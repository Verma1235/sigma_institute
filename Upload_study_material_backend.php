<?php
session_start();
if (isset($_SESSION['FILES_LOCATION']) && $_SESSION['FILES_LOCATION'] == 'drive') {
    include "Chek_required_permission.php";
    require_once "DriveHandler.php"; // Include the class we created above

    try {
        $drive = new DriveHandler();
    } catch (Exception $e) {
        die("Drive Connection Error: " . $e->getMessage());
    }

    // Sanitize inputs
    $action = $_POST['ACTION'] ?? '';
    $pdf_id = isset($_POST['pdf_id']) ? mysqli_real_escape_string($conn, $_POST['pdf_id']) : '';

    // --- CASE 1: FETCH FOR EDIT (JSON) ---
    if ($action === 'EDIT' && !empty($_POST['PDF_ID'])) {
        $fetch_id = mysqli_real_escape_string($conn, $_POST['PDF_ID']);
        $res = mysqli_query($conn, "SELECT * FROM study_material WHERE PDF_ID='$fetch_id'");
        if ($res && mysqli_num_rows($res) > 0) {
            echo json_encode([mysqli_fetch_assoc($res)]);
        } else {
            echo "error";
        }
        exit;
    }

    // --- CASE 2: DELETE FILE ---
    if ($action === 'DELETE1' && isset($_POST['FILE_ID'])) {
        $id = mysqli_real_escape_string($conn, $_POST['FILE_ID']);
        $sql1 = "SELECT * FROM `study_material` WHERE `PDF_ID`='$id';";
        $res = mysqli_query($conn, $sql1);
        $data = mysqli_fetch_assoc($res);

        if ($data && $Status == 1) {
            $uploaded_id = $data['UPLOADED_BY_ID'];
            $cloudFileId = $data['FILE'];

            if (($uploaded_id == $_SESSION['ID']) || isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN'])) {
                // Delete from Google Drive via Class
                $drive->deleteFile($cloudFileId);

                // Delete from Database
                $sql = "DELETE FROM `study_material` WHERE `PDF_ID`='$id';";
                echo mysqli_query($conn, $sql) ? 0 : 1;
            } else {
                echo "Unauthorized Access";
            }
        }
        exit;
    }

    // --- CASE 3: SAVE OR UPDATE ---
    if (isset($_POST['chapter_name']) && $Status == 1) {
        $chapter_name = mysqli_real_escape_string($conn, $_POST['chapter_name']);
        $ch_no = mysqli_real_escape_string($conn, $_POST['ch_no']);
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $class = mysqli_real_escape_string($conn, $_POST['Class']);
        $desc = mysqli_real_escape_string($conn, $_POST['discription'] ?? $_POST['Dis'] ?? '');
        $existing_drive_id = $_POST['pre_file'] ?? ''; // Google File ID from hidden input

        $file_id_to_store = $existing_drive_id;
        $new_upload = (isset($_FILES['file']) && $_FILES['file']['name'] != '');

        try {
            if ($new_upload) {
                $fileTmp = $_FILES['file']['tmp_name'];
                $fileName = $_FILES['file']['name'];
                $mimeType = mime_content_type($fileTmp);

                if (!empty($existing_drive_id)) {
                    // UPDATE: Replace existing file on Drive
                    $updatedDriveFile = $drive->updateFile($existing_drive_id, $fileTmp, $mimeType);
                    $file_id_to_store = $updatedDriveFile->id;
                } else {
                    // NEW: Upload fresh file to Drive
                    $newDriveFile = $drive->uploadFile($fileTmp, $fileName, $mimeType);
                    $file_id_to_store = $newDriveFile->id;
                }
            }

            // Logic to determine if we Update or Insert in Database
            $check = mysqli_query($conn, "SELECT 1 FROM study_material WHERE PDF_ID='$pdf_id'");

            if (mysqli_num_rows($check) > 0) {
                // SQL UPDATE
                $sql = "UPDATE `study_material` SET 
                    `CLASS`='$class', `CHAPTER_NO`='$ch_no', `CHAPTER_NAME`='$chapter_name', 
                    `FILE`='$file_id_to_store', `DESCRIPTION`='$desc', `SUBJECT`='$subject' 
                    WHERE `PDF_ID`='$pdf_id'";
            } else {
                // SQL INSERT
                $db_pdf_id = "FILE_" . rand(1000, 999999);
                $user_id = $_SESSION['ID'];
                $user_post = $_SESSION['POST'];
                $sql = "INSERT INTO `study_material` 
                    (`PDF_ID`,`UPLOADED_BY_ID`,`UPL_BY`,`CLASS`,`CHAPTER_NO`,`CHAPTER_NAME`,`FILE`,`STATUS`,`DESCRIPTION`,`SUBJECT`,`FILES_LOCATION`) 
                    VALUES 
                    ('$db_pdf_id','$user_id','$user_post','$class','$ch_no','$chapter_name','$file_id_to_store','1','$desc','$subject','drive')";
            }

            echo mysqli_query($conn, $sql) ? 0 : 1;

        } catch (Exception $e) {
            error_log("Drive Operation Failed: " . $e->getMessage());
            echo "Drive Error";
        }
        exit;
    }
    // ... Case 3 (Edit) remains exactly the same as your previous code
} else {
    include("Upload_study_material_backend_old.php");
}
?>