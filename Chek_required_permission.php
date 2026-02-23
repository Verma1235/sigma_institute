<?php
include"database.php";
$Status=2;
$id_ad="";
// $_SESSION['DBMS_ADM_STATUS']="incomplete";
$_SESSION['ADMISSION_STATUS']=0;
if(isset($_SESSION['ADMIN'])){
    $Status=$_SESSION['ADMIN'];
    $id_ad=$_SESSION['ID'];
    $sql_activated_chk="SELECT ACTIVE,LOGIN_STATUS,LOGIN_ID,POST,DELETE_AC FROM `studenttable` WHERE `ID`='$id_ad';";

    $chked_query=mysqli_query($conn,$sql_activated_chk);
    if( $chked_query){
        if(mysqli_num_rows($chked_query)>0 ){
        $row_get=mysqli_fetch_assoc($chked_query);
        $Status=$row_get['ACTIVE'];
        $_SESSION['ACTIVE']=$Status;
        $_SESSION['ACTIVE_NO']=$row_get['ACTIVE'];
    
        // ########################## Login chek ##################
        if($row_get['DELETE_AC']==1){
            echo "<script>alert('! Your Account has been deleted by the Admin !'); window.location.href = 'logout.php'; </script>";
        }

     if( $row_get['LOGIN_ID']!=$_SESSION['LOGIN_ID']){
                echo "<script>alert('! Your Account  is login into an another device !'); window.location.href = 'logout.php'; </script>";
            }
            if($row_get["POST"]!="ADMIN"){
                echo "<script>alert('! Your POST has been changed by Admin ! Relogin now !'); window.location.href = 'logout.php'; </script>";
            }
  
        // ########################## Login chek ##################
    
        }else{
            echo "<script>window.location.href = 'logout.php'; </script>";
        }
    }else{
        echo "error in active status cheking 1";
    }
  
}else if(isset($_SESSION['COADMIN'])){
     $Status=$_SESSION['COADMIN'];
     $id_ad=$_SESSION['ID'];
     $sql_activated_chk="SELECT ACTIVE,LOGIN_STATUS,LOGIN_ID,POST,DELETE_AC FROM `studenttable` WHERE `ID`='$id_ad';";
 
     $chked_query=mysqli_query($conn,$sql_activated_chk);
     if( $chked_query){
        if(mysqli_num_rows($chked_query)>0){
            $row_get=mysqli_fetch_assoc($chked_query);
            $Status=$row_get['ACTIVE'];
            $_SESSION['ACTIVE']=$Status;
            $_SESSION['ACTIVE_NO']=$row_get['ACTIVE'];

        // ########################## Login chek ##################
        if($row_get['DELETE_AC']==1){
            echo "<script>alert('! Your Account has been deleted by the Admin !'); window.location.href = 'logout.php'; </script>";
        }

        if( $row_get['LOGIN_ID']!=$_SESSION['LOGIN_ID']){
            echo "<script>alert('! Your Account  is login into an another device !'); window.location.href = 'logout.php'; </script>";
        }
        if($row_get["POST"]!="COADMIN"){
            echo "<script>alert('! Your POST has been changed by Admin! Relogin now !'); window.location.href = 'logout.php'; </script>";
        }

    // ########################## Login chek ##################

                }else{
                    echo "<script>window.location.href = 'logout.php'; </script>";
                }
     }else{
         echo "error in active status cheking 2";
     }
   

}else if(isset($_SESSION['TEACHER'])){
    $Status=$_SESSION['TEACHER'];
    $id_ad=$_SESSION['ID'];
    $sql_activated_chk="SELECT ACTIVE,LOGIN_STATUS,LOGIN_ID,POST,DELETE_AC FROM `studenttable` WHERE `ID`='$id_ad';";

    $chked_query=mysqli_query($conn,$sql_activated_chk);
    if( $chked_query){
       if(mysqli_num_rows($chked_query)>0){
           $row_get=mysqli_fetch_assoc($chked_query);
           $Status=$row_get['ACTIVE'];
           $_SESSION['ACTIVE']=$Status;
           $_SESSION['ACTIVE_NO']=$row_get['ACTIVE'];

       // ########################## Login chek ##################
       if($row_get['DELETE_AC']==1){
        echo "<script>alert('! Your Account has been deleted by the Admin !'); window.location.href = 'logout.php'; </script>";
    }

       if( $row_get['LOGIN_ID']!=$_SESSION['LOGIN_ID']){
           echo "<script>alert('! Your Account  is login into an another device !'); window.location.href = 'logout.php'; </script>";
       }
       if($row_get["POST"]!="TEACHER"){
           echo "<script>alert('! Your POST has been changed by Admin! Relogin now !'); window.location.href = 'logout.php'; </script>";
       }

   // ########################## Login chek ##################

               }else{
                   echo "<script>window.location.href = 'logout.php'; </script>";
               }
    }else{
        echo "error in active status cheking 2";
    }
  

}
else if(isset($_SESSION['ID'])){
      
    $id_ad=$_SESSION['ID'];
    $sql_activated_chk="SELECT ACTIVE,LOGIN_STATUS,LOGIN_ID,POST,DELETE_AC FROM `studenttable` WHERE `ID`='$id_ad';";

    $chked_query=mysqli_query($conn,$sql_activated_chk);
    if( $chked_query){
       if(mysqli_num_rows($chked_query)>0){
           $row_get=mysqli_fetch_assoc($chked_query);
           $Status=$row_get['ACTIVE'];
           $_SESSION['ACTIVE_NO']=$row_get['ACTIVE'];

       // ########################## Login chek ##################
       if($row_get['DELETE_AC']==1){
        echo "<script>alert('! Your Account has been deleted by the Admin !'); window.location.href = 'logout.php'; </script>";
    }

       if( $row_get['LOGIN_ID']!=$_SESSION['LOGIN_ID']){
           echo "<script>alert('! Your Account  is login into an another device !'); window.location.href = 'logout.php'; </script>";
       }
       if($row_get["POST"]!=$_SESSION['POST']){
           echo "<script>alert('! Your POST has been changed by Admin! Relogin now !'); window.location.href = 'logout.php'; </script>";
       }

   // ########################## Login chek ##################

               }else{
                   echo "<script>window.location.href = 'logout.php'; </script>";
               }
    }else{
        echo "error in active status cheking 2";
    }



}else{
    $Status=2;
}


if(isset($_SESSION['ID']) && (!isset($_SESSION['ADMIN']) &&  !isset($_SESSION['COADMIN']) && !isset($_SESSION['TEACHER']))){

    $Chk_admission_by_id=$_SESSION['ID'];
    $sql_admission="SELECT ADMISSION_ID,ADMISSION_STATUS FROM `admission_record` WHERE `SIGNUP_ID`='$Chk_admission_by_id';";
    $res=mysqli_query($conn,$sql_admission);
    if($res){
        if(mysqli_num_rows($res)>0){
            $data=mysqli_fetch_assoc($res);
            $_SESSION['ADMISSION_STATUS']=1;
            $_SESSION['DBMS_ADM_STATUS']=$data['ADMISSION_STATUS'];

        }
    }
    
}else{
    $_SESSION['ADMISSION_STATUS']=0;
}



?>