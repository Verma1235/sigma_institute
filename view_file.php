<?php
session_start();
require_once "DriveHandler.php";
include "database.php"; // Ensure $conn is available

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Fetch location and file path from DB
    $res = mysqli_query($conn, "SELECT FILE, FILES_LOCATION FROM study_material WHERE PDF_ID='$id' OR FILE='$id' LIMIT 1");
    $data = mysqli_fetch_assoc($res);

    if ($data) {
        $file_val = $data['FILE'];
        $location = $data['FILES_LOCATION'];

        if ($location === 'drive') {
            // Fetch from Google Drive
            try {
                $drive = new DriveHandler();
                $content = $drive->download($file_val);
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="material.pdf"');
                echo $content;
            } catch (Exception $e) { die("Drive Error: " . $e->getMessage()); }
        } else {
            // Serve from local folder
            $local_path = "pdf/" . $file_val;
            if (file_exists($local_path)) {
                header('Content-Type: application/pdf');
                readfile($local_path);
            } else {
                die("Local file not found.");
            }
        }
    }
}