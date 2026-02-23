<?php
include("../database.php");

if(isset($_POST["PHONE"])){
    $phone=$_POST['PHONE'];
    $name=$_POST['NAME'];
    $message=$_POST['MESSAGE'];
    $SQL='INSERT INTO `contact_table`(`Name`, `Phone`, `Message`,`Read_s`,`ID`) VALUES ("'.$name.'","'.$phone.'","'.$message.'","0",NULL)';
    $query=mysqli_query($conn,$SQL);
    if($query){
        echo 1;
    }else{
        echo 2;
    }

}else{
    echo "Not Allowed Unauthorized user !";
}



?>