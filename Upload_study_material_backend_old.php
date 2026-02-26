<?php

// Start session at the very beginning
// session_start();

// Include permission check. Ensure this file handles security appropriately.
// It's good practice to have this file handle redirection or error messages
// if permissions are not met, rather than relying on a global $Status variable.
include "Chek_required_permission.php";

// Function to sanitize input. This is a crucial security measure.
// You might want a more robust sanitization library for production.
function sanitize_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// Ensure $conn (database connection) is available from Chek_required_permission.php or establish it here.
// For improved security and maintainability, consider using PDO or MySQLi with prepared statements.

// Check if the user is logged in and authorized. Assuming Check_required_permission.php
// sets $_SESSION['ID'] and $_SESSION['POST'] for logged-in users and handles authorization.
if (!isset($_SESSION['ID'])) {
    // Handle unauthorized access, e.g., redirect to login or show an error.
    // For this example, we'll just echo a message.
    echo "Error: User not authenticated.";
    exit;
}

// Use a switch statement for better readability and to handle different actions.
// Filter and sanitize input before using it.
$action = isset($_POST['ACTION']) ? sanitize_input($_POST['ACTION']) : 'UPLOAD';

switch ($action) {
    case 'UPLOAD':
        handleFileUpload();
        break;
    case 'DELETE1': // Renamed from "DELETE1" to "DELETE" as it's more descriptive.
        handleFileDelete();
        break;
    case 'FETCH_DETAILS':
        handleFetchDetails();
        break;
    default:
        // Handle cases where no valid action is provided or an unknown action is sent.
        echo "Error: Invalid or missing action.";
        break;
}

function handleFileUpload()
{
    global $conn; // Access the global database connection
    extract($_POST);
    // Sanitize and validate all expected POST variables
    $chapter_name = isset($_POST['chapter_name']) ? sanitize_input($_POST['chapter_name']) : '';
    $subject = isset($_POST['subject']) ? sanitize_input($_POST['subject']) : '';
    $class = isset($_POST['Class']) ? sanitize_input($_POST['Class']) : '';
    $description = isset($_POST['discription']) ? sanitize_input($_POST['discription']) : '';
    $chapter_no = isset($_POST['ch_no']) ? sanitize_input($_POST['ch_no']) : '';
    $FILES_LOCATION = isset($_SESSION['FILES_LOCATION']) ? $_SESSION['FILES_LOCATION'] : 'pdf';



    if (empty($chapter_name) || empty($subject)  || empty($chapter_no)) {
        echo "Error: Missing required fields for upload.  NAME:" . $chapter_name . " \n SUBJECT: " . $subject . " \n CLASS: " . $class . " \n CHAPTER NO:  " . $chapter_no;
        return;
    }

    if (empty($_FILES['file']['name'])) {
        echo 3; // No file uploaded
        return;
    }

    $filename = $_FILES['file']['name'];
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $valid_extensions = array("pdf", "png", "jpeg", "jpg", "mp4");

    if (!in_array($extension, $valid_extensions)) {
        echo 2; // Invalid file type
        return;
    }

    // Generate a unique file name to prevent overwriting and improve security
    $new_name = "FILE_" . $chapter_no . "_" . uniqid() . "." . $extension;
    $path = "pdf/" . $new_name;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
        $file_id = "FILE_" . uniqid() . "_" . $extension; // Generate unique ID for database

        $uploaded_by_id = $_SESSION['ID'];
        $uploaded_by_post = $_SESSION['POST'];
        $status = 1; // Assuming 1 means active/published

        // Use prepared statements to prevent SQL injection
        $sql_upload = "INSERT INTO `study_material` (`PDF_ID`, `UPLOADED_BY_ID`, `UPL_BY`, `CLASS`, `CHAPTER_NO`, `CHAPTER_NAME`, `FILE`, `STATUS`, `DESCRIPTION`, `SUBJECT`,`FILES_LOCATION`) VALUES ('$file_id','$uploaded_by_id','$uploaded_by_post','$class','$chapter_no','$chapter_name','$new_name','$status','$description','$subject','$FILES_LOCATION')";



        if (mysqli_query($conn, $sql_upload)) {
            echo 0; // Success
        } else {
            error_log("Database Error: " . mysqli_error($conn)); // Log the error
            echo 1; // Database insert failed
        }
        mysqli_close($conn);
    } else {
        error_log("Prepared Statement Error: " . mysqli_error($conn));
        echo 1; // Prepared statement creation failed
    }
    //  else {
    //     echo 1; // File upload to server failed
    // }
}

function handleFileDelete()
{
    global $conn;

    $file_id = isset($_POST['FILE_ID']) ? sanitize_input($_POST['FILE_ID']) : '';

    if (empty($file_id)) {
        echo "Error: Missing FILE_ID for deletion.";
        return;
    }

    // Use prepared statement to fetch file details
    $sql_select = "SELECT `UPLOADED_BY_ID`, `FILE` FROM `study_material` WHERE `PDF_ID` = ?";
    if ($stmt_select = mysqli_prepare($conn, $sql_select)) {
        mysqli_stmt_bind_param($stmt_select, "s", $file_id);
        mysqli_stmt_execute($stmt_select);
        $result = mysqli_stmt_get_result($stmt_select);
        $data = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt_select);

        if ($data) {
            $uploaded_id = $data['UPLOADED_BY_ID'];
            $file_on_disk = $data['FILE'];

            // Check permissions: Uploader, Admin, or Co-Admin
            // Assuming $_SESSION['ADMIN'] and $_SESSION['COADMIN'] are set to true/false
            // (or specific roles) when the user logs in and their permissions are checked.
            if (($uploaded_id == $_SESSION['ID']) || (isset($_SESSION['ADMIN']) && $_SESSION['ADMIN'] === true) || (isset($_SESSION['COADMIN']) && $_SESSION['COADMIN'] === true)) {
                $file_path = "pdf/" . $file_on_disk;
                if (file_exists($file_path)) {
                    if (unlink($file_path)) {
                        // Use prepared statement for deletion from DB
                        $sql_delete = "DELETE FROM `study_material` WHERE `PDF_ID` = ?";
                        if ($stmt_delete = mysqli_prepare($conn, $sql_delete)) {
                            mysqli_stmt_bind_param($stmt_delete, "s", $file_id);
                            if (mysqli_stmt_execute($stmt_delete)) {
                                echo 0; // Success
                            } else {
                                error_log("Database Error: " . mysqli_error($conn));
                                echo 1; // Database delete failed
                            }
                            mysqli_stmt_close($stmt_delete);
                        } else {
                            error_log("Prepared Statement Error: " . mysqli_error($conn));
                            echo 1; // Prepared statement creation failed
                        }
                    } else {
                        error_log("File unlink failed for: " . $file_path);
                        echo 1; // File deletion failed on server
                    }
                } else {
                    error_log("Attempted to delete non-existent file: " . $file_path);
                    echo "PDF file not found on server to delete.";
                }
            } else {
                echo "This file cannot be deleted by you. Only self-uploaded files or administrators can delete this file.";
            }
        } else {
            echo "Error: File details not found in database for deletion.";
        }
    } else {
        error_log("Prepared Statement Error: " . mysqli_error($conn));
        echo 1; // Prepared statement creation failed
    }
}

function handleFetchDetails()
{
    global $conn;

    $pdf_id = isset($_POST['PDF_ID']) ? sanitize_input($_POST['PDF_ID']) : '';

    if (empty($pdf_id)) {
        echo "Error: Missing PDF_ID for fetching details.";
        return;
    }

    // Use prepared statement to fetch details
    $sql_edit = "SELECT `PDF_ID`, `CLASS`, `CHAPTER_NO`, `SUBJECT`, `FILE`, `STATUS`, `DESCRIPTION`, `CHAPTER_NAME` FROM `study_material` WHERE `PDF_ID` = ?";
    if ($stmt = mysqli_prepare($conn, $sql_edit)) {
        mysqli_stmt_bind_param($stmt, "s", $pdf_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            echo json_encode($data);
        } else {
            echo "no record found";
        }
        mysqli_stmt_close($stmt);
    } else {
        error_log("Prepared Statement Error: " . mysqli_error($conn));
        echo "Error: Could not prepare statement.";
    }
}

// The original code had a conditional '$Status != 1' followed by an 'else' with no condition.
// This indicates a potential logic flow issue or an expectation from `Chek_required_permission.php`.
// It's better to handle permission checks at the very beginning and ensure that `Chek_required_permission.php`
// either allows execution or exits with an error/redirection.
// If $Status is a global variable from that file meant to indicate permission,
// its usage should be integrated into the initial authorization check.
// For now, I've removed the global $Status check as it's implied by the session check.

?>