<?php
session_start();
include"Chek_required_permission.php";



if($Status==1){




if(isset($_POST['ID']) && isset($_POST['ACTION'])){
    $id=$_POST['ID'];
    if($_POST['ACTION']=="DELETE1" && $_SESSION['ID']!=$id){
    $sql="UPDATE  `studenttable` SET `DELETE_AC`='1' WHERE `ID`='$id';";
    $respons=mysqli_query($conn,$sql);
    if($respons){
        echo 0;
    }
    else{
        echo 1;
    }
    }else if($_POST['ACTION']=="STATUS" && $_SESSION['ID']!=$id){

    $sql="SELECT * FROM `studenttable` WHERE `ID`='$id';";
    $respons=mysqli_query($conn,$sql);

    if($respons){
        if(mysqli_num_rows($respons)>0){
    $row=mysqli_fetch_assoc($respons);
    $status=1;

    
    if($row['ACTIVE']==1){
        $status=0;
    }else if($row['ACTIVE']==2)
    {
        $status=1;
    }
    else{
        $status=1;
    }
    if(($row['ACTIVE']!=2 && isset($_SESSION['TEACHER'])) || (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN']))){

    
    $sql2="UPDATE `studenttable` SET `ACTIVE` =$status WHERE `studenttable`.`ID` = '$id';";
    $respons2=mysqli_query($conn,$sql2);
    if($respons2){
        echo 0;
    }else{
        echo 1;
    }
}else{
    echo 402;
}

 }
    }
 }else if($_POST['ACTION']=="RESTORE_AC" && $_SESSION['ID']!=$id){


    // account backup code
    $sql2="UPDATE `studenttable` SET `DELETE_AC`=0 WHERE `studenttable`.`ID` = '$id';";
    $respons2=mysqli_query($conn,$sql2);
    if($respons2){
        echo 0;
    }else{
        echo 1;
    }



    // account backup code



 }
 
 
 else if($_SESSION['ID']==$id){
    echo "You can not change/delete  your own  Account status ! You can change it by manully through editing !";
}

}

}else{
    echo " Access Denied by admin to further change in any records of students by you !! ";
}

?>