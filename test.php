<?php
session_start();
$login_id=$_SESSION['LOGIN_STATUS'];
$actual=$_SESSION['LOGIN_STATUS_ACTUALL'];
$data="<script>alert(' Login local status id -{$login_id}');alert(' Login actual status id -{$actual}'); window.location.href='index.php';</script>";
echo  $data;
?>