<?php
include"database.php";

if(isset($_POST['ID'])){

    $id=$_POST['ID'];
    $sql="SELECT * FROM `studenttable` WHERE ID='$id' ;";
    $data=mysqli_query($conn,$sql);

    if($data){
        $output=mysqli_fetch_all($data,MYSQLI_ASSOC);
     
        // echo "<pre>";
        echo json_encode($output);
        // print_r($output);
        // echo "</pre>";
    }
}else{
    echo 2;
}


?>