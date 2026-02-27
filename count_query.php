<?php
session_start();
include("Chek_required_permission.php");
if (isset($_SESSION['ADMIN']) || $_SESSION['COADMIN']) {
    $sql = "SELECT `Read_s` FROM `contact_table` WHERE `Read_s`='0';";
    $res = mysqli_query($conn, $sql);
    $sql2 = "SELECT * FROM `studenttable` WHERE (`ACTIVE`=0 or`ACTIVE`=2) and `DELEte_AC`=0;";
    $res2 = mysqli_query($conn, $sql2);
    if ($res && $res2) {
        $num = mysqli_num_rows($res);
        $num2 = mysqli_num_rows($res2);
        if (isset($_SESSION['ADMIN'])) {
            echo ($num + $num2);
        } else {
            echo $num2;
        }
    } else {

    }

} else {
    echo 0;
}



?>