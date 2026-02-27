<?php
session_start();
if (isset($_SESSION['FILES_LOCATION']) && $_SESSION['FILES_LOCATION'] == 'drive') {
    include "Chek_required_permission.php"; 
    require_once "DriveHandler.php"; // Include the class we created above

    try {
        $drive = new DriveHandler();
    } catch (Exception $e) {
        die($e->getMessage());
    }

    extract($_POST);

    // --- CASE 1: UPLOAD FILE TO CLOUD ---
    if (isset($chapter_name) && $Status == 1) {

        if (!isset($_FILES['file']) || $_FILES['file']['name'] == '') {
            echo 3; exit;
        }

        try {
            $fileTmp = $_FILES['file']['tmp_name'];
            $originalName = $_FILES['file']['name'];
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            $valid_extension = array("pdf", "png", "jpeg", "jpg", "mp4");
            if (!in_array($extension, $valid_extension)) {
                echo 2; exit;
            }

            $mimeType = mime_content_type($fileTmp) ?: 'application/octet-stream';

            // Use the Class to upload
            $driveFile = $drive->uploadFile($fileTmp, $originalName, $mimeType);

            if ($driveFile && $driveFile->id) {
                $googleFileId = $driveFile->id;
                $File_Id = "FILE_" . rand(1, 500000) . "_" . $extension;
                $id_user = $_SESSION['ID'];
                $POST_user = $_SESSION['POST'];

                $safe_class = mysqli_real_escape_string($conn, $Class);
                $safe_ch_no = mysqli_real_escape_string($conn, $ch_no);
                $safe_ch_name = mysqli_real_escape_string($conn, $chapter_name);
                $safe_desc = mysqli_real_escape_string($conn, $Dis);
                $safe_sub = mysqli_real_escape_string($conn, $subject);
                $FILES_LOCATION = 'drive';

                $sql_upload = "INSERT INTO `study_material` 
                (`PDF_ID`,`UPLOADED_BY_ID`,`UPL_BY`,`CLASS`,`CHAPTER_NO`,`CHAPTER_NAME`,`FILE`,`STATUS`,`DESCRIPTION`,`SUBJECT`,`FILES_LOCATION`) 
                VALUES 
                ('$File_Id','$id_user','$POST_user','$safe_class','$safe_ch_no','$safe_ch_name','$googleFileId','1','$safe_desc','$safe_sub','$FILES_LOCATION')";

                echo mysqli_query($conn, $sql_upload) ? 0 : 1.0;
            } else {
                echo 1.1;
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
                $cloudFileId = $data['FILE']; 

                if (($uploaded_id == $_SESSION['ID']) || isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN'])) {
                    try {
                        // Use the Class to delete
                        $drive->deleteFile($cloudFileId);
                    } catch (Exception $e) {
                        error_log("Cloud delete failed: " . $e->getMessage());
                    }

                    $sql = "DELETE FROM `study_material` WHERE `PDF_ID`='$id';";
                    echo mysqli_query($conn, $sql) ? 0 : 1.4;
                } else {
                    echo "Unauthorized deletion attempt!!";
                }
            }
        }
    }
    // ... Case 3 (Edit) remains exactly the same as your previous code
} else {
    include("Upload_study_material_backend_old.php");
}
?>