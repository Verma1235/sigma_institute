<?php
session_start();
include "Chek_required_permission.php";
$new_file = "";
$file_unlink = "";
extract($_POST);

if (isset($chapter_name) && $Status == 1) {
    // $new_file="";
    $status = 1;
    $file_unlink_status = 1;
    if ($_FILES['file']['name'] == '') {
        $new_file = $pre_file;
        $file_unlink_status = 1;

    } else if ($_FILES['file']['name'] != '') {
        $file_unlink = "pdf/" . $pre_file;

        // change and dbms

        $filname = $_FILES['file']['name'];
        $extension = pathinfo($filname, PATHINFO_EXTENSION);
        $valid_extension = array("pdf", "png", "jpeg", "jpg");

        if (in_array($extension, $valid_extension)) {
            $new_name = "FILE_C" . $ch_no . rand() . "." . $extension;
            $path = "pdf/" . $new_name;
            $uploaded = move_uploaded_file($_FILES['file']['tmp_name'], $path);

            if ($uploaded) {
                unlink($file_unlink);
                $new_file = $new_name;
                $file_unlink_status = 2;
                if ($file_unlink_status == 2) {
                    $sql_upload = "UPDATE `study_material` SET `CLASS`='$Class', `CHAPTER_NO`='$ch_no', `CHAPTER_NAME`='$chapter_name', `FILE`='$new_file', `STATUS`='$status', `DESCRIPTION`='$Dis',`SUBJECT`='$subject' WHERE `PDF_ID`='$pdf_id';";
                    $query = mysqli_query($conn, $sql_upload);
                    if ($query) {
                        echo 0;
                    }
                }

            } else {
                echo 1;

            }

        } else {
            echo 2;

        }




        // change and dbms

    }

    if ($file_unlink_status == 1) {
        $sql_upload = "UPDATE `study_material` SET `CLASS`='$Class', `CHAPTER_NO`='$ch_no', `CHAPTER_NAME`='$chapter_name', `FILE`='$new_file', `STATUS`='$status', `DESCRIPTION`='$Dis',`SUBJECT`='$subject' WHERE `PDF_ID`='$pdf_id';";
        $query = mysqli_query($conn, $sql_upload);
        if ($query) {
            echo 0;
        }
    }



} else {
    echo 4;
}






?>