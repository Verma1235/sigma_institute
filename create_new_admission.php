<?php
session_start();
include"Chek_required_permission.php";
// $target="vendor/autoload.php";
// $linkname="https://checkout.razorpay.com/v1/checkout.js";
// link($target,$linkname);
// require('vendor/autoload.php'); // Path to Razorpay PHP SDK
// use Razorpay\Api\Api;
// $api = new Api('rzp_test_A87nm1TrwNtWIO', 'sYMMkUQdtfvVFUg90kOs1zC7');

        // $amount = 10000; // Amount in INR (1000 paise = 10 INR)

        // $order = $api->order->create([
        //      'amount' => $amount,
        //      'currency' => 'INR',
        //      'receipt' => 'receipt#1'
        //         ]);

        //     echo json_encode([
        //   'order_id' => $order['id'],
        //  'amount' => $amount
        //     ]);



extract($_POST);
if( ($Status==1 || $Status==0) && isset($FullName)){



    $Chk_admission_by_id=$SignUpId;
    $sql_admission_CK="SELECT ADMISSION_ID,ADMISSION_STATUS FROM `admission_record` WHERE `SIGNUP_ID`='$Chk_admission_by_id';";
    $res=mysqli_query($conn,$sql_admission_CK);

    $count =mysqli_num_rows($res);
    $sql_ck="SELECT * FROM `studenttable`   WHERE (`ID`='$Chk_admission_by_id' and `POST`='STUDENT');";

    $ck_query=mysqli_query($conn,$sql_ck);

    if(mysqli_num_rows($ck_query)==0)
    {
        echo 401;
    }else{
    if( $_FILES['Identityproof']['name'] ==''){
        echo 3;
    }else if($count==0){
    // $subject=$_POST["SUBJECT"];
    // $Class=$_POST["CLASS"];
    // $Dis=$_POST["DESCRIPTION"];
    // $ch_no=$_POST["CHAPTER_NO"];
    // $chapter_name=$_POST["CHAPTER_NAME"];
    $filname=$_FILES['Identityproof']['name'];
    $extension= pathinfo($filname,PATHINFO_EXTENSION);
    $valid_extension=array("pdf","png","jpeg","jpg","mp3","mp4");
    $status=1;
    if(in_array($extension,$valid_extension)){
    $new_id_proof="FILE_ID_proof_".rand().".".$extension;
    $path="adhar/".$new_id_proof;
    $uploaded= move_uploaded_file($_FILES['Identityproof']['tmp_name'],$path);
    $date_get=date("y-m-d");
    if($uploaded){
        $USER_id=$SignUpId;
        $addmissionId="ALPHA_ADM_ID".$USER_id;
        $File_Id="FILE_".rand(1,500000)."_".$extension;
        $sql_upload="INSERT INTO `admission_record`(`FULLNAME`, `SIGNUP_ID`, `ADMISSION_ID`, `FATHER_NAME`, `DOB`, `GENDER`, `PHONE`, `ADHAR_NO`, `STATE`, `DISTRICT`, `ADDRESS`, `ID_PROOF_FILE`, `ADMISSION_STATUS`,`DOA`, `STATUS`) VALUES ('$FullName','$USER_id','$addmissionId','$FatherName','$DOB','$gender','$PhoneNo','$AdharNumber','$State','$District','$FullAddress','$new_id_proof',0,'$date_get','0')";
        $query=mysqli_query($conn,$sql_upload);
        if($query){
 
      echo 0;


        }else{
            echo 6;
        }
        }
        else{
            echo 1;
        
        }
        
        }else{
            echo 2;
        
        
        }
        
        }else{
            echo 400;
        }

    }

    










}else{
    echo 5;
}
?>
