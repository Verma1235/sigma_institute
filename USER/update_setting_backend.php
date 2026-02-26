<?php
session_start();
header('Content-Type: application/json');

// Database connection details
include('../Chek_required_permission.php');
if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . mysqli_connect_error()]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize data
    $mode           = mysqli_real_escape_string($conn, $_POST['MODE']);
    $account_access = mysqli_real_escape_string($conn, $_POST['ACCOUNT_ACCESS']);
    $login_allow    = mysqli_real_escape_string($conn, $_POST['LOGIN_ALLOW']);
    $signup_allow   = mysqli_real_escape_string($conn, $_POST['SIGNUP_ALLOW']);
    $admin_id       = mysqli_real_escape_string($conn, $_SESSION['ID']);
    $files_location = mysqli_real_escape_string($conn, $_POST['FILES_LOCATION']);

    // Update query (Targeting Row ID 1)
    $sql = "UPDATE sigmasettings SET 
            MODE = '$mode', 
            ACCOUNT_ACCESS = '$account_access', 
            LOGIN_ALLOW = '$login_allow', 
            SIGNUP_ALLOW = '$signup_allow', 
            ADMIN_ID = '$admin_id', 
            FILES_LOCATION = '$files_location' 
            WHERE SETTING_ID = 1";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['FILES_LOCATION'] = $files_location;
        echo json_encode(['status' => 'success', 'message' => 'Settings updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($conn)]);
    }

    mysqli_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request Method']);
}
?>