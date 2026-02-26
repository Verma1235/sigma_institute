<?php



$host = getenv("DB_HOST") ?: "localhost";
$user = getenv("DB_USER") ?: "root";
$pass = getenv("DB_PASS") ?: "";
$db = getenv("DB_NAME") ?: "sigma";
$port = getenv("DB_PORT") ?: 3306;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// if($conn){
//     echo "Connected";
// }
// else{
//     echo"Error".mysqli_connect_error();
// }

?>