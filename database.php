<?php

$host = getenv("DB_HOST") ?: "gateway01.ap-southeast-1.prod.aws.tidbcloud.com";
$user = getenv("DB_USERNAME") ?: "sigma";
$pass = getenv("DB_PASSWORD") ?: "YOUR_PASSWORD";
$db   = getenv("DB_DATABASE") ?: "YOUR_DATABASE";
$port = getenv("DB_PORT") ?: 4000;

$conn = mysqli_init();

/* Enable SSL (required by TiDB Cloud) */
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

mysqli_real_connect(
    $conn,
    $host,
    $user,
    $pass,
    $db,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// echo "Connected successfully";

?>