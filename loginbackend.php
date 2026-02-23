<?php
session_start();
if(isset($_SESSION['ID']) && isset($_POST['LEMAIL']))
{
echo("<script>
 var data =confirm('!! You need to first logout than login into an another account !! Do you want to logout');
if(data==true){
window.location.href='logout.php';
}
</script>");
}else{
include"database.php";
if($conn){
if(isset($_POST['LEMAIL']) && isset($_POST['LPASS'])){

$email=$_POST['LEMAIL'];
$password=$_POST['LPASS'];
$pass_hash=password_hash($password,PASSWORD_DEFAULT);
$sql="SELECT * FROM `studenttable` WHERE `EMAIL`='$email';";

$result=mysqli_query($conn,$sql);
if($result){
    if(mysqli_num_rows($result)>0){
    $data=mysqli_fetch_assoc($result);

if($data['DELETE_AC']==0){
if(password_verify($password,$data['PASSWORD'])){
    $_SESSION['ID']=$data['ID'];
    $ID=$data['ID'];
    $_SESSION['ACTIVE_NO']=$data['ACTIVE'];
    $_SESSION['IMG_P']= $data['IMG_P'];
    $_SESSION['PHONE']=$data['PHONE'];

 

    // LOGIM LOGIC 
    $GEN_LOGIN_ID=$ID."_LOGIN_".rand(10,1000);



    $LOGIN_CHANGE=1 + $data['LOGIN_STATUS']; 
    if($data['LOGIN_STATUS']>=0){  
        $_SESSION['LOGIN_STATUS'] =$LOGIN_CHANGE +1; 
        $_SESSION['LOGIN_STATUS_ACTUALL']= $LOGIN_CHANGE;
        $_SESSION['LOGIN_ID']=$GEN_LOGIN_ID;
    }
    $sql_login="UPDATE  `studenttable` SET `LOGIN_STATUS`={$LOGIN_CHANGE},`LOGIN_ID`='{$GEN_LOGIN_ID}' WHERE  `ID`='{$ID}';";  // =2
    mysqli_query($conn,$sql_login);

    // LOGIM LOGIC 
  
    $_SESSION['NAME']=$data['NAME'];
    $_SESSION['Email']=$data['EMAIL'];

    if($data['POST']!=""){
        $_SESSION['POST']=$data['POST'];
        if($data['POST']=="ADMIN"){
            // 
            $_SESSION['ADMIN']=$data['ACTIVE'];
        }else if ($data['POST']=="COADMIN") {
            $_SESSION['COADMIN']=$data['ACTIVE'];
        }else if($data['POST']=='TEACHER')
        {
            $_SESSION['TEACHER']=$data['ACTIVE'];
        }

    }else{
        $_SESSION['POST']="";
    }
 
   

    echo 0;
}else{
    echo "wrong password";
}

    }else{
        echo 420;
    }

    }else{
        echo 1;
    }
}else{
    echo 2;
}

}else if( isset($_POST['SIGNEMAIL']) && isset($_POST['SIGNPASS']) &&  isset($_POST['SIGNNAME'])){
$name =$_POST['SIGNNAME'];
$pass =$_POST['SIGNPASS'];
$email=$_POST['SIGNEMAIL'];




$pass_hash=password_hash($pass,PASSWORD_DEFAULT);



// function id_generate(){
//     $ID="SIGMA".rand(1,50000);
// }
$new_id="SIGMA".rand(1,50000);
// $Post="STUDENT";
$sql_id_chk="SELECT * FROM `studenttable` WHERE `ID`='$new_id';";
$res_id=mysqli_query($conn,$sql_id_chk);
if(mysqli_num_rows($res_id)==0){
    $date =date("y-m-d");

$sql="INSERT INTO `studenttable` (`NAME`,`EMAIL`,`PASSWORD`,`ID`,`POST`,`DOA`)  VALUES('$name','$email','$pass_hash','$new_id','STUDENT','$date');";

$result=mysqli_query($conn,$sql);
if($result){
    echo 0;
}
else{
    echo 1;
}

}else{
    echo "!! Use Another email id !! this email is already in use !!!";
}

}else{
    echo("<script>window.location.href='index.php';</script>");
}

}else{
    echo "!! Server Down !!";
}

}

?>