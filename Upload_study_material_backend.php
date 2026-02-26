<?php
session_start();
if (isset($_SESSION['FILES_LOCATION']) && $_SESSION['FILES_LOCATION'] == 'drive') {
    include "Chek_required_permission.php"; // Assuming $conn and $Status are defined here
    require_once __DIR__ . '/vendor/autoload.php';

    // Constants for Cloud Storage
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

    extract($_POST);

    // --- CASE 1: UPLOAD FILE TO CLOUD ---
    if (isset($chapter_name) && $Status == 1) {

        if (!isset($_FILES['file']) || $_FILES['file']['name'] == '') {
            echo 3; // No file selected
            exit;
        }

        try {
            // Initialize Google Client
            $client = new Google_Client();
            $client->setAuthConfig(SERVICE_ACCOUNT_KEY_FILE);
            $client->addScope(Google_Service_Drive::DRIVE);
            $driveService = new Google_Service_Drive($client);

            $fileTmp = $_FILES['file']['tmp_name'];
            $originalName = $_FILES['file']['name'];
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            $valid_extension = array("pdf", "png", "jpeg", "jpg", "mp4");
            if (!in_array($extension, $valid_extension)) {
                echo 2; // Invalid format
                exit;
            }

            // Detect Mime Type
            $mimeType = mime_content_type($fileTmp) ?: 'application/octet-stream';

            // Prepare Cloud Metadata
            $fileMetadata = new Google_Service_Drive_DriveFile(array(
                'name' => $originalName,
                'parents' => array(GOOGLE_DRIVE_UPLOAD_FOLDER_ID)
            ));

            $content = file_get_contents($fileTmp);

            // Upload to Google Drive
            $driveFile = $driveService->files->create($fileMetadata, array(
                'data' => $content,
                'mimeType' => $mimeType,
                'uploadType' => 'multipart',
                'fields' => 'id'
            ));

            if ($driveFile && $driveFile->id) {
                $googleFileId = $driveFile->id; // This replaces the old $new_name
                $File_Id = "FILE_" . rand(1, 500000) . "_" . $extension;
                $id_user = $_SESSION['ID'];
                $POST_user = $_SESSION['POST'];

                // Secure the inputs
                $safe_class = mysqli_real_escape_string($conn, $Class);
                $safe_ch_no = mysqli_real_escape_string($conn, $ch_no);
                $safe_ch_name = mysqli_real_escape_string($conn, $chapter_name);
                $safe_desc = mysqli_real_escape_string($conn, $Dis);
                $safe_sub = mysqli_real_escape_string($conn, $subject);

                $sql_upload = "INSERT INTO `study_material`
                (`PDF_ID`,`UPLOADED_BY_ID`,`UPL_BY`,`CLASS`,`CHAPTER_NO`,`CHAPTER_NAME`,`FILE`,`STATUS`,`DESCRIPTION`,`SUBJECT`)
                VALUES
                ('$File_Id','$id_user','$POST_user','$safe_class','$safe_ch_no','$safe_ch_name','$googleFileId','1','$safe_desc','$safe_sub')";

                if (mysqli_query($conn, $sql_upload)) {
                    echo 0; // Success
                } else {
                    echo 1.0; // DB Error
                }
            } else {
                echo 1.1; // Cloud Upload Failed
            }

        } catch (Exception $e) {
            error_log($e->getMessage());
            echo 1.2;
        }

        // --- CASE 2: DELETE FILE ---
    } else if (isset($_POST['FILE_ID']) && $Status == 1) {
        $id = mysqli_real_escape_string($conn, $_POST['FILE_ID']);

        if ($_POST['ACTION'] == "DELETE1") {
            $sql1 = "SELECT * FROM `study_material` WHERE `PDF_ID`='$id';";
            $res = mysqli_query($conn, $sql1);
            $data = mysqli_fetch_assoc($res);

            if ($data) {
                $uploaded_id = $data['UPLOADED_BY_ID'];
                $cloudFileId = $data['FILE']; // The Google Drive ID stored in DB

                // Permission Check: Owner or Admin
                if (($uploaded_id == $_SESSION['ID']) || isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN'])) {

                    // Optional: Delete from Google Drive too
                    try {
                        $client = new Google_Client();
                        $client->setAuthConfig(SERVICE_ACCOUNT_KEY_FILE);
                        $client->addScope(Google_Service_Drive::DRIVE);
                        $driveService = new Google_Service_Drive($client);
                        $driveService->files->delete($cloudFileId);
                    } catch (Exception $e) {
                        // Log error but continue to delete from DB if file is already gone
                        error_log("Cloud delete failed: " . $e->getMessage());
                    }

                    $sql = "DELETE FROM `study_material` WHERE `PDF_ID`='$id';";
                    if (mysqli_query($conn, $sql)) {
                        echo 0;
                    } else {
                        echo 1.4;
                    }
                } else {
                    echo "This File is not deleted by you. Only self-uploaded files can be deleted!!";
                }
            }
        }

        // --- CASE 3: FETCH DATA FOR EDIT ---
    } else if (isset($_POST['PDF_ID']) && isset($_POST['ACTION']) && $Status == 1) {
        $id_pdf = mysqli_real_escape_string($conn, $_POST['PDF_ID']);
        $sql_edit = "SELECT * FROM `study_material` WHERE `PDF_ID`='$id_pdf'; ";
        $res2 = mysqli_query($conn, $sql_edit);

        if (mysqli_num_rows($res2) > 0) {
            $data2 = mysqli_fetch_all($res2, MYSQLI_ASSOC);
            echo json_encode($data2);
        } else {
            echo "no record found";
        }

    } else if ($Status != 1) {
        echo 4; // Permission Denied
    }
} else {
    include("Upload_study_material_backend_old.php");
}
?>