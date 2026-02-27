<?php
session_start();
if (isset($_SESSION['FILES_LOCATION']) && $_SESSION['FILES_LOCATION'] == 'drive') {
    include "Chek_required_permission.php";
    require_once "DriveHandler.php"; // Load the Class we built

    if (!isset($_SESSION['LOGIN_ID'])) {
        echo "Access Denied: User not logged in.";
        exit;
    }

    // Initialize the Drive Handler Class
    try {
        $drive = new DriveHandler();
    } catch (Exception $e) {
        error_log("Drive Init Error: " . $e->getMessage());
        echo "Error initializing Google Drive service.";
        exit;
    }

    $action = $_POST['ACTION'] ?? '';

    // --- CASE 1: FETCH DATA FOR EDIT ---
    if ($action === 'EDIT' && isset($_POST['PDF_ID'])) {
        $pdf_id = mysqli_real_escape_string($conn, $_POST['PDF_ID']);
        $sql = "SELECT * FROM study_material WHERE PDF_ID='$pdf_id'";
        $res = mysqli_query($conn, $sql);
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            echo json_encode([$row]);
        } else {
            echo json_encode([]);
        }
        exit;
    }

    // --- CASE 2: DELETE FILE ---
    if ($action === 'DELETE1' && isset($_POST['FILE_ID']) && isset($_POST['FILE'])) {
        $file_id = mysqli_real_escape_string($conn, $_POST['FILE_ID']);
        $drive_file_id = $_POST['FILE']; // Google Drive File ID

        try {
            $drive->deleteFile($drive_file_id); // Using class method
            $delete_sql = "DELETE FROM study_material WHERE PDF_ID='$file_id'";
            if (mysqli_query($conn, $delete_sql)) {
                echo 0; // success
            } else {
                echo 1; // DB error
            }
        } catch (Exception $e) {
            error_log("Delete Error: " . $e->getMessage());
            echo 1; // Drive error
        }
        exit;
    }

    // --- CASE 3: UPLOAD OR UPDATE ---
    if (isset($_POST['pdf_id']) || (isset($_FILES['file']) && $_FILES['file']['name'] != '')) {
        
        $pdf_id = mysqli_real_escape_string($conn, $_POST['pdf_id'] ?? ("FILE_" . rand(100000, 999999)));
        $chapter_name = mysqli_real_escape_string($conn, $_POST['chapter_name'] ?? '');
        $ch_no = mysqli_real_escape_string($conn, $_POST['ch_no'] ?? '');
        $Class = mysqli_real_escape_string($conn, $_POST['Class'] ?? '');
        $Dis = mysqli_real_escape_string($conn, $_POST['Dis'] ?? '');
        $Subject = mysqli_real_escape_string($conn, $_POST['subject'] ?? '');
        $existing_drive_file_id = $_POST['pre_file'] ?? '';

        if (empty($chapter_name) || empty($ch_no) || empty($Class) || empty($Subject)) {
            echo "All required fields must be provided.";
            exit;
        }

        $drive_file_id_to_store_in_db = $existing_drive_file_id;

        // If a NEW file is being uploaded
        if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
            $tmpFile = $_FILES['file']['tmp_name'];
            $originalName = $_FILES['file']['name'];
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            
            $valid_ext = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'mp4', 'jpg', 'jpeg', 'png'];
            if (!in_array($ext, $valid_ext)) {
                echo "2: Invalid file format.";
                exit;
            }

            try {
                $mimeType = mime_content_type($tmpFile) ?: 'application/octet-stream';
                
                // Use Class to Upload
                $newDriveFile = $drive->uploadFile($tmpFile, $originalName, $mimeType);
                $drive_file_id_to_store_in_db = $newDriveFile->id;

                // Delete old file from Drive if updating
                if (!empty($existing_drive_file_id)) {
                    try {
                        $drive->deleteFile($existing_drive_file_id);
                    } catch (Exception $e) {
                        error_log("Old file cleanup failed: " . $e->getMessage());
                    }
                }
            } catch (Exception $e) {
                error_log("Upload Error: " . $e->getMessage());
                echo "1: Failed to upload to Google Drive.";
                exit;
            }
        }

        // --- Database Sync (Insert or Update) ---
        $check_sql = "SELECT PDF_ID FROM study_material WHERE PDF_ID='$pdf_id'";
        $check_res = mysqli_query($conn, $check_sql);

        if ($check_res && mysqli_num_rows($check_res) > 0) {
            // UPDATE
            $sql_statement = "UPDATE study_material SET 
                CHAPTER_NAME='$chapter_name', 
                CHAPTER_NO='$ch_no', 
                CLASS='$Class', 
                DESCRIPTION='$Dis', 
                SUBJECT='$Subject', 
                FILE='$drive_file_id_to_store_in_db',
                UPLOADED_BY_ID='" . mysqli_real_escape_string($conn, $_SESSION['ID']) . "',
                UPL_BY='" . mysqli_real_escape_string($conn, $_SESSION['POST']) . "'
                WHERE PDF_ID='$pdf_id' AND FILES_LOCATION='drive'";
        } else {
            // INSERT
            $sql_statement = "INSERT INTO `study_material` 
                (`PDF_ID`,`UPLOADED_BY_ID`,`UPL_BY`,`CLASS`,`CHAPTER_NO`,`CHAPTER_NAME`,`FILE`,`STATUS`,`DESCRIPTION`,`SUBJECT`,`FILES_LOCATION`) 
                VALUES 
                ('$pdf_id','" . mysqli_real_escape_string($conn, $_SESSION['ID']) . "','" . mysqli_real_escape_string($conn, $_SESSION['POST']) . "','$Class','$ch_no','$chapter_name','$drive_file_id_to_store_in_db','1','$Dis','$Subject','drive')";
        }

        if (mysqli_query($conn, $sql_statement)) {
            echo 0; // success
        } else {
            echo "1: Database error.";
        }
        exit;
    }

    echo "Invalid request or action.";
} else {
    include("study_material_old.php");
}
?>