<?php
include "database.php";

$Status = 2;
$id_ad = "";
$_SESSION['ADMISSION_STATUS'] = 0;

// Function to logout with alert
function forceLogout($message)
{
    echo "<script>alert('{$message}'); window.location.href='logout.php';</script>";
    exit;
}

function chechsettings($conn)
{
    $sqlSettings = "SELECT * FROM `sigmasettings` WHERE `SETTING_ID`=1 ;";
    $res = mysqli_query($conn, $sqlSettings);
    $settings = mysqli_fetch_assoc($res);
    $_SESSION['FILES_LOCATION'] = $settings['FILES_LOCATION'];
}
chechsettings($conn);
// Function to fetch user data safely
function getUserData($conn, $id)
{
    $stmt = $conn->prepare("SELECT ACTIVE, LOGIN_STATUS, LOGIN_ID, POST, DELETE_AC FROM studenttable WHERE ID = ?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        die("Error checking user status: " . $stmt->error);
    }
    $result = $stmt->get_result();
    return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
}

// Determine user type
$userRoles = ['ADMIN', 'COADMIN', 'TEACHER'];
$roleFound = false;

foreach ($userRoles as $role) {
    if (isset($_SESSION[$role])) {
        $Status = $_SESSION[$role];
        $id_ad = $_SESSION['ID'] ?? null;
        $roleExpected = $role;
        $roleFound = true;
        break;
    }
}

// If no role, but ID exists (normal user)
if (!$roleFound && isset($_SESSION['ID'])) {
    $id_ad = $_SESSION['ID'];
    $roleExpected = $_SESSION['POST'] ?? null; // Use stored POST
}

// Fetch user data if ID exists
if ($id_ad) {
    $userData = getUserData($conn, $id_ad);

    if (!$userData) {
        // No user found, force logout
        echo "<script>window.location.href='logout.php';</script>";
        exit;
    }

    // Set session ACTIVE values
    $Status = $userData['ACTIVE'];
    $_SESSION['ACTIVE'] = $Status;
    $_SESSION['ACTIVE_NO'] = $userData['ACTIVE'];

    // Account deleted check
    if ($userData['DELETE_AC'] == 1) {
        forceLogout("Your account has been deleted by the Admin!");
    }

    // Concurrent login check
    if ($userData['LOGIN_ID'] != ($_SESSION['LOGIN_ID'] ?? null)) {
        forceLogout("Your account is logged in on another device!");
    }

    // POST consistency check
    if ($userData['POST'] != $roleExpected) {
        forceLogout("Your POST has been changed by Admin! Please relogin.");
    }
}

// Admission status check for normal users
if (isset($_SESSION['ID']) && !$roleFound) {
    $Chk_admission_by_id = $_SESSION['ID'];
    $stmt = $conn->prepare("SELECT ADMISSION_ID, ADMISSION_STATUS FROM admission_record WHERE SIGNUP_ID = ?");
    $stmt->bind_param("i", $Chk_admission_by_id);

    if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res && $res->num_rows > 0) {
            $data = $res->fetch_assoc();
            $_SESSION['ADMISSION_STATUS'] = 1;
            $_SESSION['DBMS_ADM_STATUS'] = $data['ADMISSION_STATUS'];
        }
    } else {
        error_log("Error checking admission status: " . $stmt->error);
    }
} else {
    $_SESSION['ADMISSION_STATUS'] = 0;
}

?>