<?php
session_start();
require_once "DriveHandler.php";
include "database.php"; // Ensure $conn is available


if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Fetch info. Using PDF_ID is safer.
    $res = mysqli_query($conn, "SELECT FILE, FILES_LOCATION, CHAPTER_NAME FROM study_material WHERE PDF_ID='$id' LIMIT 1");
    $data = mysqli_fetch_assoc($res);

    if ($data) {
        $file_val = $data['FILE']; // This will be the Google Drive ID
        $location = $data['FILES_LOCATION'];
        $name = $data['CHAPTER_NAME'] . ".pdf";

        if ($location === 'drive') {
            try {
                $drive = new DriveHandler();
                $content = $drive->download($file_val);
                
                // Set headers to show in browser
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="' . $name . '"');
                header('Cache-Control: private, max-age=0, must-revalidate');
                header('Pragma: public');
                
                echo $content;
                exit;
            } catch (Exception $e) { 
                die("Drive Error: " . $e->getMessage()); 
            }
        } else {
            // Local fallback
            $local_path = "pdf/" . $file_val;
            if (file_exists($local_path)) {
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="' . $name . '"');
                readfile($local_path);
                exit;
            } else {
                die("File not found on server.");
            }
        }
    } else {
        die("Record not found in database.");
    }
}
?>