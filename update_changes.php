<?php
session_start();
include"Chek_required_permission.php";

// include"database.php";


// $Status=2;
// $id_ad="";
// if(isset($_SESSION['ADMIN'])){
//     $Status=$_SESSION['ADMIN'];
//     $id_ad=$_SESSION['ID'];
//     $sql_activated_chk="SELECT ACTIVE,LOGIN_STATUS,LOGIN_ID,POST FROM `studenttable` WHERE `ID`='$id_ad';";

//     $chked_query=mysqli_query($conn,$sql_activated_chk);
//     if( $chked_query){
//         if(mysqli_num_rows($chked_query)>0){
//             $row_get=mysqli_fetch_assoc($chked_query);
//             $Status=$row_get['ACTIVE'];
//         // ########################## Login chek ##################

//         if( $row_get['LOGIN_ID']!=$_SESSION['LOGIN_ID']){
//             echo "<script>alert('! Your Account  is login into an another device !'); window.location.href = 'logout.php'; </script>";
//         }
//         if($row_get["POST"]!="COADMIN" || $row_get["POST"]!="ADMIN"){
//             echo "<script>alert('! Your POST has been changed by Admin! Relogin now !'); window.location.href = 'logout.php'; </script>";
//         }

//     // ########################## Login chek ##################

//                 }
//             else{
//                     echo "<script>window.location.href='logout.php'; </script>";
//          }
//     }else{
//         echo "error in active status cheking 1";
//     }
  
// }else if(isset($_SESSION['COADMIN'])){
//      $Status=$_SESSION['COADMIN'];
//      $id_ad=$_SESSION['ID'];
//      $sql_activated_chk="SELECT ACTIVE,LOGIN_STATUS,LOGIN_ID,POST FROM `studenttable` WHERE `ID`='$id_ad';";
 
//      $chked_query=mysqli_query($conn,$sql_activated_chk);
//      if( $chked_query){
//         if(mysqli_num_rows($chked_query)>0){
//             $row_get=mysqli_fetch_assoc($chked_query);
//             $Status=$row_get['ACTIVE'];

//         // ########################## Login chek ##################

//         if( $row_get['LOGIN_ID']!=$_SESSION['LOGIN_ID']){
//             echo "<script>alert('! Your Account  is login into an another device !'); window.location.href = 'logout.php'; </script>";
//         }
//         if($row_get["POST"]!="COADMIN" || $row_get["POST"]!="ADMIN"){
//             echo "<script>alert('! Your POST has been changed by Admin! Relogin now !'); window.location.href = 'logout.php'; </script>";
//         }

//     // ########################## Login chek ##################

//                 }else{
//                     echo "<script>window.location.href='logout.php'; </script>";
//                 }
//      }else{
//          echo "error in active status cheking 2";
//      }
   

// }else{
//     $Status=2;
// }

if($Status==1 && (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN']) || isset($_SESSION['TEACHER']))){
if(isset($_POST['ID'])){
 
  $sql="";
  $name=$_POST['NAME'];
  $email=$_POST['EMAIL'];
  $post=$_POST['POST'];
  $address=$_POST['ADDRESS'];
  $adhar=$_POST['ADHAR'];
  $class=$_POST['CLASS'];
  $district=$_POST['DISTRICT'];
  $father=$_POST['FATHER'];
  $phone=$_POST['PHONE'];
  $village=$_POST['VILLAGE'];
  $active=$_POST['ACTIVE'];
  $gender=$_POST['GENDER'];
  $parentcontact=$_POST['PARENTCONTACT'];
  $dob=$_POST['DOB'];
  $doa=$_POST['DOA'];
  $id=$_POST['ID'];
    if($_POST['DOA']!="" && $_POST['DOB']!=""){

        // echo "both data ".$_POST['DOA']." ".$_POST['DOB'];
            $sql="UPDATE `studenttable` SET `NAME`='$name',`EMAIL`='$email',`POST`='$post',`ADDRESS`='$address',`ADHAR`='$adhar',`CLASS`='$class',`DISTRICT`='$district',`FATHER`='$father',`PHONE`='$phone',`VILLAGE`='$village',`ACTIVE`='$active',`GENDER`='$gender',`PARENTCONTACT`='$parentcontact',`DOA`='$doa',`DOB`='$dob'  WHERE `ID`='$id';";

    }else if($_POST['DOA']!=""){

        // echo "only doa ".$_POST['DOA'];
            $sql="UPDATE `studenttable` SET `NAME`='$name',`EMAIL`='$email',`POST`='$post',`ADDRESS`='$address',`ADHAR`='$adhar',`CLASS`='$class',`DISTRICT`='$district',`FATHER`='$father',`PHONE`='$phone',`VILLAGE`='$village',`ACTIVE`='$active',`GENDER`='$gender',`PARENTCONTACT`='$parentcontact',`DOA`='$doa'  WHERE `ID`='$id';";

    }else if($_POST['DOB']!=""){
        // echo "only dob".$_POST['DOB'];
                $sql="UPDATE `studenttable` SET `NAME`='$name',`EMAIL`='$email',`POST`='$post',`ADDRESS`='$address',`ADHAR`='$adhar',`CLASS`='$class',`DISTRICT`='$district',`FATHER`='$father',`PHONE`='$phone',`VILLAGE`='$village',`ACTIVE`='$active',`GENDER`='$gender',`PARENTCONTACT`='$parentcontact',`DOB`='$dob' WHERE `ID`='$id';";

    }else{
        // echo "not known";
        $sql="UPDATE `studenttable` SET `NAME`='$name',`EMAIL`='$email',`POST`='$post',`ADDRESS`='$address',`ADHAR`='$adhar',`CLASS`='$class',`DISTRICT`='$district',`FATHER`='$father',`PHONE`='$phone',`VILLAGE`='$village',`ACTIVE`='$active',`GENDER`='$gender',`PARENTCONTACT`='$parentcontact' WHERE `ID`='$id';";
    }
    
    $result=mysqli_query($conn,$sql);
    if($result){
        echo 0;
    }else{
        echo 1;
    }


}else{
    echo 2;
}
}else{
    echo " Access Denied by admin to  change in data !! ";
}
?>