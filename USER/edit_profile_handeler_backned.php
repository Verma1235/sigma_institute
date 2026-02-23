<?php
session_start();
include("../Chek_required_permission.php");

if($Status==1 || $Status==0)
{
extract($_POST);
if(isset($_FILES['file']['name']))
{
    $filname=$_FILES['file']['name'];
    $extension= pathinfo($filname,PATHINFO_EXTENSION);
    $valid_extension=array("png","jpeg","jpg");
    if(in_array($extension,$valid_extension)){
        $new_name="p_".$ID."_".rand(000000,999999).".".$extension;
        $path="../img/".$new_name;
        $uploaded= move_uploaded_file($_FILES['file']['tmp_name'],$path);
        if($uploaded)
        {
            $sql="UPDATE `studenttable` SET `NAME`='$name',`PHONE`='$phone',`IMG_P`='$new_name' WHERE `ID`='$ID';";
            $res_qury=mysqli_query($conn,$sql);
            if($res_qury)
            {
                echo $new_name;
                $_SESSION['IMG_P']=$new_name;
                $_SESSION['NAME']=$name;
            }
            else
            {
                echo 402;
            }
        }
    }else
    {
        echo 1;
    }      
}else
{
    $sql="UPDATE `studenttable` SET `NAME`='$name',`PHONE`='$phone' WHERE `ID`='$ID';";
    $res_qury=mysqli_query($conn,$sql);
    if($res_qury)
    {
        echo 1;
        $_SESSION['NAME']=$name;
    }
    else
    {
        echo 402;
    }
}



}
else{
    echo 420;
}



?>