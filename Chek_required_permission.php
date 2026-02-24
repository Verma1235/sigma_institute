<?php
// session_start();
include "database.php";

$Status = 2;
$id_ad = "";
$_SESSION['ADMISSION_STATUS'] = 0;

/* ================= COMMON FUNCTIONS ================= */

function logoutMsg($msg = "")
{
    if ($msg != "") {
        echo "<script>alert('$msg');</script>";
    }
    echo "<script>window.location.href='logout.php';</script>";
    exit;
}
// check setings
function chechsettings($conn)
{
    $sqlSettings = "SELECT * FROM `sigmasettings` WHERE `SETTING_ID`=1 ;";
    $res = mysqli_query($conn, $sqlSettings);
    $settings = mysqli_fetch_assoc($res);
    $_SESSION['FILES_LOCATION'] = $settings['FILES_LOCATION'];
    if ($settings['ACCOUNT_ACCESS'] == '1' && isset($_SESSION['LOGIN_ID']) && $_SESSION['POST'] !="ADMIN") {
        logoutMsg($msg = "INSTITUTE MANAGEMENT TEAMS || FORCEFULLY LOGOUT ALL THE ACCOUNTS !!");
    }
}
chechsettings($conn);
function fetchUser($conn, $id)
{
    // STRING binding (important fix)
    $stmt = $conn->prepare("SELECT ACTIVE,LOGIN_STATUS,LOGIN_ID,POST,DELETE_AC FROM studenttable WHERE ID=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if (!$res || $res->num_rows == 0) {
        logoutMsg();
    }

    return $res->fetch_assoc();
}

function checkSecurity($row, $expectedPost = null)
{
    // account deleted
    if ($row['DELETE_AC'] == 1) {
        logoutMsg('! Your Account has been deleted by the Admin !');
    }

    // another device login
    if (isset($_SESSION['LOGIN_ID']) && $row['LOGIN_ID'] != $_SESSION['LOGIN_ID']) {
        logoutMsg('! Your Account is login into an another device !');
    }

    // post changed
    if ($expectedPost !== null && $row['POST'] != $expectedPost) {
        logoutMsg('! Your POST has been changed by Admin! Relogin now !');
    }
}

/* ================= ROLE CHECK ================= */

if (isset($_SESSION['ADMIN'])) {
    $id_ad = $_SESSION['ID'];
    $row = fetchUser($conn, $id_ad);

    $Status = $row['ACTIVE'];
    $_SESSION['ACTIVE'] = $Status;
    $_SESSION['ACTIVE_NO'] = $Status;

    checkSecurity($row, 'ADMIN');
} else if (isset($_SESSION['COADMIN'])) {
    $id_ad = $_SESSION['ID'];
    $row = fetchUser($conn, $id_ad);

    $Status = $row['ACTIVE'];
    $_SESSION['ACTIVE'] = $Status;
    $_SESSION['ACTIVE_NO'] = $Status;

    checkSecurity($row, 'COADMIN');
} else if (isset($_SESSION['TEACHER'])) {
    $id_ad = $_SESSION['ID'];
    $row = fetchUser($conn, $id_ad);

    $Status = $row['ACTIVE'];
    $_SESSION['ACTIVE'] = $Status;
    $_SESSION['ACTIVE_NO'] = $Status;

    checkSecurity($row, 'TEACHER');
} else if (isset($_SESSION['ID'])) {
    $id_ad = $_SESSION['ID'];
    $row = fetchUser($conn, $id_ad);

    $Status = $row['ACTIVE'];
    $_SESSION['ACTIVE_NO'] = $Status;

    checkSecurity($row, $_SESSION['POST'] ?? null);
}

/* ================= ADMISSION CHECK ================= */

if (isset($_SESSION['ID']) && !isset($_SESSION['ADMIN']) && !isset($_SESSION['COADMIN']) && !isset($_SESSION['TEACHER'])) {
    $stmt = $conn->prepare("SELECT ADMISSION_ID,ADMISSION_STATUS FROM admission_record WHERE SIGNUP_ID=?");
    $stmt->bind_param("s", $_SESSION['ID']);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows > 0) {
        $data = $res->fetch_assoc();
        $_SESSION['ADMISSION_STATUS'] = 1;
        $_SESSION['DBMS_ADM_STATUS'] = $data['ADMISSION_STATUS'];
    } else {
        $_SESSION['ADMISSION_STATUS'] = 0;
    }
} else {
    $_SESSION['ADMISSION_STATUS'] = 0;
}
?>