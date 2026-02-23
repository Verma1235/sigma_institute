<?php
session_start();
include"Chek_required_permission.php";

extract($_POST);
if(isset($chapter_name) &&   $Status==1){

if( $_FILES['file']['name'] ==''){
    echo 3;
}else{
// $subject=$_POST["SUBJECT"];
// $Class=$_POST["CLASS"];
// $Dis=$_POST["DESCRIPTION"];
// $ch_no=$_POST["CHAPTER_NO"];
// $chapter_name=$_POST["CHAPTER_NAME"];
$filname=$_FILES['file']['name'];
$extension= pathinfo($filname,PATHINFO_EXTENSION);
$valid_extension=array("pdf","png","jpeg","jpg","mp4");
$status=1;
if(in_array($extension,$valid_extension)){
$new_name="FILE_".$ch_no.rand().".".$extension;
$path="pdf/".$new_name;
$uploaded= move_uploaded_file($_FILES['file']['tmp_name'],$path);
$id=$_SESSION['ID'];
$POST=$_SESSION['POST'];
if($uploaded){
$File_Id="FILE_".rand(1,500000)."_".$extension;
$sql_upload="INSERT INTO `study_material`(`PDF_ID`,`UPLOADED_BY_ID`,`UPL_BY`, `CLASS`, `CHAPTER_NO`, `CHAPTER_NAME`, `FILE`, `STATUS`, `DESCRIPTION`,`SUBJECT`) VALUES ('$File_Id','$id','$POST','$Class','$ch_no','$chapter_name','$new_name','$status','$Dis','$subject');";
$query=mysqli_query($conn,$sql_upload);
if($query){
    echo 0;
}
}
else{
    echo 1;

}

}else{
    echo 2;


}

}

}else if(isset($_POST['FILE_ID'])  &&   $Status==1 ){
    $id=$_POST['FILE_ID'];
    if($_POST['ACTION']=="DELETE1"){
        $sql1="SELECT * FROM `study_material` WHERE `PDF_ID`='$id';";
        $res=mysqli_query($conn,$sql1);
        $data=mysqli_fetch_assoc($res);
        $uploaded_id=$data['UPLOADED_BY_ID'];
        if(($uploaded_id==$_SESSION['ID']) || (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN']))){
    $sql="DELETE FROM `study_material` WHERE `PDF_ID`='$id';";
    $unlink=true;
    try{
        unlink("pdf/".$_POST['FILE']);
    }catch(Exception $e){
        echo $e;
        $unlink=false;
    }
    if($unlink==true)
    {
    $respons=mysqli_query($conn,$sql);
    if($respons){
        echo 0;
    }
    else{
        echo 1;
    }
  }else{
    echo "pdf file not found to delete";
    }
    }else{
        echo "This File is not deleted by you. Only self-uploaded files can be deleted!!";
    }


  }else{
    echo "Not deleted";
 }
}else if(isset($_POST['PDF_ID']) && isset($_POST['ACTION']) && $Status==1)
{
    $id_pdf=$_POST['PDF_ID'];
    
    $sql_edit="SELECT * FROM `study_material` WHERE `PDF_ID`='$id_pdf'; ";
    $res2=mysqli_query($conn,$sql_edit);
    if(mysqli_num_rows($res2)>0)
    {
        $data2=mysqli_fetch_all($res2,MYSQLI_ASSOC);
        // $data_pdf=array(
        //     'PDF_ID' => $data2['PDF_ID'],
        //     'CLASS'=>$data2['CLASS'],
        //     'CHAPTER_NO'=>$data2['CHAPTER_NO'],
        //     'SUBJECT'=>$data2['SUBJECT'],
        //     'FILE'=>$data2['FILE'],
        //     'STATUS'=>$data2['STATUS'],
        //     'DESCRIPTION'=>$data2['DESCRIPTION'],
        //     'CHAPTER_NAME'=>$data2['CHAPTER_NAME']
        // );
        $json_data =json_encode($data2);
        echo $json_data;

    }else
    {
        echo "no record found";
    }

} if($Status!=1){
    echo 4;
   
}else{
  
}