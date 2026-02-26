<?php
session_start();
if (isset($_SESSION['FILES_LOCATION']) && $_SESSION['FILES_LOCATION'] == 'drive') {
    include "Chek_required_permission.php";
    require_once __DIR__ . '/vendor/autoload.php'; // Google API client

    // Database connection
// include "db_connection.php"; // Make sure $conn exists and is properly initialized

    if (!isset($_SESSION['LOGIN_ID'])) {
        echo "Access Denied: User not logged in.";
        exit;
    }

    /* ================= GOOGLE AUTH (Render ENV Compatible) ================= */

    // Read JSON from Render ENV
    $credentialsJson = getenv("GOOGLE_SERVICE_ACCOUNT_JSON");

    if (!$credentialsJson) {
        die("Google credentials missing in environment variables");
    }

    // Create temporary credentials file inside container
    $tempGoogleFile = sys_get_temp_dir() . '/google_service_account.json';

    // Write JSON into temp file (only once per request)
    if (!file_exists($tempGoogleFile)) {
        file_put_contents($tempGoogleFile, $credentialsJson);
    }

    // Define constant as FILE PATH (not JSON)
    define('SERVICE_ACCOUNT_KEY_FILE', $tempGoogleFile);

    // Google Drive folder ID
    define('GOOGLE_DRIVE_UPLOAD_FOLDER_ID', '1AcLwAM3K4hM4OcxrtWsMY8dBrykvcz87');

    /* ======================================================================= */

    // Initialize Google Client and Drive Service
    $client = new Google_Client();
    try {
        $client->setAuthConfig(SERVICE_ACCOUNT_KEY_FILE);
        $client->addScope(Google_Service_Drive::DRIVE); // Full Drive access. Consider DRIVE_FILE for more restricted.
        $driveService = new Google_Service_Drive($client);
    } catch (Exception $e) {
        error_log("Google Client/Drive Service Initialization Error: " . $e->getMessage());
        echo "Error initializing Google Drive service.";
        exit;
    }

    // Helper: upload to Drive
    function uploadToDrive($fileTmp, $fileName, $driveService)
    {
        global $conn; // Access the database connection for escaping (if needed for debugging logs)

        // Determine MIME type
        $mimeType = mime_content_type($fileTmp);
        if ($mimeType === false) {
            $mimeType = 'application/octet-stream'; // Fallback
        }

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $fileName,
            'parents' => [GOOGLE_DRIVE_UPLOAD_FOLDER_ID] // Use the defined folder ID
        ]);

        $content = file_get_contents($fileTmp);
        if ($content === false) {
            error_log("Failed to read file content for upload: " . $fileTmp);
            return false;
        }

        try {
            $driveFile = $driveService->files->create($fileMetadata, [
                'data' => $content,
                'mimeType' => $mimeType,
                'uploadType' => 'multipart',
                'fields' => 'id,name'
            ]);
            return $driveFile->id ?? false;
        } catch (Google\Service\Exception $e) {
            error_log("Google Drive API Upload Error: " . $e->getMessage() . " Code: " . $e->getCode());
            return false;
        } catch (Exception $e) {
            error_log("General Upload Error: " . $e->getMessage());
            return false;
        }
    }

    // Helper: delete from Drive
    function deleteFromDrive($fileId, $driveService)
    {
        if (empty($fileId)) {
            error_log("Attempted to delete empty Google Drive File ID.");
            return false;
        }
        try {
            $driveService->files->delete($fileId);
            return true;
        } catch (Google\Service\Exception $e) {
            // Log if the file doesn't exist, it might be a normal flow if the file was already gone.
            // Google returns 404 for non-existent files on delete.
            if ($e->getCode() == 404) {
                error_log("Google Drive file with ID '{$fileId}' not found during delete operation (might be already deleted).");
                return true; // Consider it successful if the file is already gone.
            }
            error_log("Google Drive API Delete Error for ID '{$fileId}': " . $e->getMessage() . " Code: " . $e->getCode());
            return false;
        } catch (Exception $e) {
            error_log("General Delete Error for ID '{$fileId}': " . $e->getMessage());
            return false;
        }
    }

    // Extract POST data
// IMPORTANT: Avoid using extract($_POST) directly in production code due to security risks (variable collisions).
// Access $_POST elements explicitly.
    $action = $_POST['ACTION'] ?? ''; // Default to empty string if not set

    if ($action === 'EDIT' && isset($_POST['PDF_ID'])) {
        $pdf_id = mysqli_real_escape_string($conn, $_POST['PDF_ID']);
        $sql = "SELECT * FROM study_material WHERE PDF_ID='$pdf_id'";
        $res = mysqli_query($conn, $sql);
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            echo json_encode([$row]);
        } else {
            echo json_encode([]); // Return empty array if not found
            error_log("EDIT action: PDF_ID '{$pdf_id}' not found in database.");
        }
        exit;
    }

    if ($action === 'DELETE1' && isset($_POST['FILE_ID']) && isset($_POST['FILE'])) {
        $file_id = mysqli_real_escape_string($conn, $_POST['FILE_ID']);
        $drive_file_id = mysqli_real_escape_string($conn, $_POST['FILE']); // This is the Google Drive File ID

        $check = deleteFromDrive($drive_file_id, $driveService);
        if ($check) {
            $delete_sql = "DELETE FROM study_material WHERE PDF_ID='$file_id'";
            if (mysqli_query($conn, $delete_sql)) {
                echo 0; // success
            } else {
                error_log("DB error deleting record for PDF_ID '{$file_id}': " . mysqli_error($conn));
                echo 1; // DB error
            }
        } else {
            echo 1; // Google Drive delete error
        }
        exit;
    }

    // Handle file upload/update
// This block handles both new file uploads (when $_FILES['file'] is set) and updates (when $_POST['pdf_id'] is set).
    if (isset($_POST['pdf_id']) || (isset($_FILES['file']) && $_FILES['file']['name'] != '')) {
        // Sanitize and validate all incoming POST data
        $pdf_id = mysqli_real_escape_string($conn, $_POST['pdf_id'] ?? ("FILE_" . rand(100000, 999999))); // Generate new ID if not provided
        $chapter_name = mysqli_real_escape_string($conn, $_POST['chapter_name'] ?? '');
        $ch_no = mysqli_real_escape_string($conn, $_POST['ch_no'] ?? '');
        $Class = mysqli_real_escape_string($conn, $_POST['Class'] ?? '');
        $Dis = mysqli_real_escape_string($conn, $_POST['Dis'] ?? '');
        $Subject = mysqli_real_escape_string($conn, $_POST['subject'] ?? '');
        $existing_drive_file_id = mysqli_real_escape_string($conn, $_POST['pre_file'] ?? ''); // This is the existing Google Drive File ID

        // Validate fields for insert/update
        if (empty($chapter_name) || empty($ch_no) || empty($Class) || empty($Subject)) { // Dis is optional, removed from here
            echo "All required fields (chapter name, chapter no, class, subject) must be provided.";
            exit;
        }

        $drive_file_id_to_store_in_db = $existing_drive_file_id; // Default to existing if no new file uploaded

        // If a new file is uploaded
        if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
            $tmpFile = $_FILES['file']['tmp_name'];
            $originalName = $_FILES['file']['name'];
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
            $valid_ext = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'mp4', 'mov', 'avi', 'wmv', 'flv', 'webm', 'jpg', 'jpeg', 'png', 'gif']; // Expanded valid extensions, add as needed
            if (!in_array(strtolower($ext), $valid_ext)) {
                echo "2: Invalid file format. Allowed formats: " . implode(', ', $valid_ext); // invalid format
                exit;
            }

            // Upload to Drive
            $new_drive_file_id = uploadToDrive($tmpFile, $originalName, $driveService);
            if (!$new_drive_file_id) {
                echo "1: Failed to upload file to Google Drive.";
                exit;
            }
            $drive_file_id_to_store_in_db = $new_drive_file_id; // Update to new file ID

            // Delete old file from Drive if a new one was uploaded and an old one existed
            if (!empty($existing_drive_file_id)) {
                if (!deleteFromDrive($existing_drive_file_id, $driveService)) {
                    // Log but don't necessarily exit, as the new file is already uploaded.
                    error_log("Warning: Failed to delete old Google Drive file ID '{$existing_drive_file_id}' during update.");
                }
            }
        }

        // Determine if it's an INSERT or UPDATE
        // Check if PDF_ID already exists in the database
        $check_sql = "SELECT PDF_ID FROM study_material WHERE PDF_ID='$pdf_id'";
        $check_res = mysqli_query($conn, $check_sql);

        if ($check_res && mysqli_num_rows($check_res) > 0) {

            $sql_statement = "UPDATE study_material SET
            CHAPTER_NAME='$chapter_name',
            CHAPTER_NO='$ch_no',
            CLASS='$Class',
            DESCRIPTION='$Dis',
            SUBJECT='$Subject',
            FILE='$drive_file_id_to_store_in_db',
            UPLOADED_BY_ID='" . mysqli_real_escape_string($conn, $_SESSION['ID']) . "',
            UPL_BY='" . mysqli_real_escape_string($conn, $_SESSION['POST']) . "'" // No comma needed here if it's the last SET clause
                . " WHERE PDF_ID='$pdf_id' AND FILES_LOCATION='drive' ;";




        } else {
            // It's an INSERT operation
            $sql_statement = "INSERT INTO `study_material`
            (`PDF_ID`,`UPLOADED_BY_ID`,`UPL_BY`,`CLASS`,`CHAPTER_NO`,`CHAPTER_NAME`,`FILE`,`STATUS`,`DESCRIPTION`,`SUBJECT`,`FILES_LOCATION`)
            VALUES
            ('$pdf_id','" . mysqli_real_escape_string($conn, $_SESSION['ID']) . "','" . mysqli_real_escape_string($conn, $_SESSION['POST']) . "','$Class','$ch_no','$chapter_name','$drive_file_id_to_store_in_db','1','$Dis','$Subject','drive')";
        }


        if (mysqli_query($conn, $sql_statement)) {
            echo 0; // success
        } else {
            error_log("DB error during file record save: " . mysqli_error($conn) . " Query: " . $sql_statement);
            echo "1: Database error saving file record."; // DB error
        }

        exit;
    }

    // Fallback for requests that don't match any specific action
    echo "Invalid request or action.";
} else {
    include("study_material_old.php");
}
?>