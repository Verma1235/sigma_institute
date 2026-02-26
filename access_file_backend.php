<?php
session_start();
include"Chek_required_permission.php";
$HTML="";
$F_Id="";
if(isset($_POST['ID']) &&  ($Status==1) && isset($_POST['SEARCH_DATA'])){
    $sData=$_POST['SEARCH_DATA'];
    $sType=$_POST['SEARCH_TYPE'];
    if($_POST['SEARCH_DATA']!="" && ($sType=='DESCRIPTION' || $sType=='CHAPTER_NAME'))
    {
        $sData1=$sData.'%';
        $sData2='%'.$sData;
        $sData3='%'.$sData.'%';
        $sql="SELECT * FROM `study_material` WHERE ((`$sType` LIKE '$sData1') || (`$sType` LIKE '$sData2') || (`$sType` LIKE '$sData3'));";
    }else if($_POST['SEARCH_DATA']!=""){
        $sData1=$sData.'%';
        // $sData2='%'.$sData;
        // $sData3='%'.$sData.'%';
        $sql="SELECT * FROM `study_material` WHERE (`$sType` LIKE '$sData1');";
    }else{
    $sql="SELECT * FROM `study_material`;";
    }
    $query=mysqli_query($conn,$sql);
    if($query){
        if(mysqli_num_rows($query)>0){
            
          
            while($row=mysqli_fetch_assoc($query))
            {
                $F_Id=$row['PDF_ID'];
                $file=$row['FILE'];
                $uploadedby="";
                $uploaded_id=$row['UPLOADED_BY_ID'];
                
                if(isset($_SESSION['TEACHER']) || isset($_SESSION['ADMIN']) ||  isset($_SESSION['COADMIN']))
                {
                    if($_SESSION['ID']==$uploaded_id)
                    {
                        $uploadedby="Myself";
                    }
                    else{
                        $uploadedby=$row['UPL_BY'];
                    }
                }
                
                $HTML.="  <!-- A card of pdf view edit delete or download  -->
             <div class='col-sm-6 mb-3 mb-sm-0'>
             <div class='card'>
                <div class='card-body card-local '>
                    <h4 class='card-title font-h'><i class='bi bi-caret-right'><small>{$row['CHAPTER_NAME']}</small></i> </h4>
                    <small class='card-title font-h' style='color:brown'><i class='bi bi-caret-right-fill'>Chapter:
                        {$row['CHAPTER_NO']}</i> </small> &emsp; <small class='card-title font-h' style='color:brown'>
                           <i class='bi bi-caret-right-fill'>Class: {$row['CLASS']}</i></small><br>
                            <small class='card-title font-h' style='color:blue'>
                           <i class='bi bi-caret-right-fill'>Subject: {$row['SUBJECT']}</i></small>
                    <p class='card-text font-h ' style='color: rgb(22, 4, 107);font-size:15px;'><i
                            class='bi bi-caret-right-fill'>About: {$row['DESCRIPTION']}</i>
                            <br><i class='bi bi-caret-right-fill'>pdf ID: {$row['PDF_ID']}</i>";
                            if(isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN']) || isset($_SESSION['TEACHER'])){ 
                                if($_SESSION['ACTIVE']==0 || $_SESSION['ACTIVE']==1){
        
                           $HTML .="&emsp; <i class='bi bi-caret-right-fill'>uploaded by: <b style='color:green;font-weight:bolder;'>{$uploadedby}</b></i>  ";
                
                                }}
                                $HTML .=" <div class='d-flex sub-card-pdf' style='flex-wrap: wrap;'>";
                           if(isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN']) || isset($_SESSION['TEACHER'])){ 
                            if($_SESSION['ACTIVE']==0 || $_SESSION['ACTIVE']==1){
                     $HTML .="  <button data-file_id='{$row['PDF_ID']}' data-bs-toggle='modal' data-bs-target='#Edit_pdf_modal' href='#' class='btn btn-warning m-1 pdf_edit_btn'
                            style='display: flex; justify-content: flex-start; align-items: center; width: fit-content;'>
                            <i class='bi bi-pencil fs-5 ' style='color:rgb(207, 34, 34);margin-right:5px;'></i>
                            Edit</button>
                         <button data-idF1='{$F_Id}' data-file='{$file}' class='btn btn-danger m-1 pdf_delete_btn'
                            style='display: flex; justify-content: flex-start; align-items: center; width: fit-content;'>
                            <i class='bi bi-trash fs-5' style='color:rgb(232, 212, 212);margin-right:5px;'></i>
                            Delete</button>";
                          } }

                           $HTML.="   <a href='pdf/{$row['FILE']}' target='_blank' class='btn btn-success m-1 shadow pdf_view_btn'
                            style='display: flex; justify-content: flex-start; align-items: center; width: fit-content;'>
                            <i class='bi bi-filetype-pdf fs-5' style='color:rgb(215, 181, 27);margin-right:5px;'></i>
                            View</a>
                          <button href='' style='color:white' data-file='{$file}'  class='btn btn-dark m-1 pdf_download_btn'
                            style='display: flex; justify-content: flex-start; align-items: center; width: fit-content;'>
                            <i class='bi bi-filetype-pdf fs-5' style='color:rgb(215, 181, 27);margin-right:5px;'></i>
                            Download </button> 
                    </div>
                    <div class='progress ' role='progressbar' aria-label='Default striped example' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100' style='background:  linear-gradient(to right,rgb(17, 206, 235),rgb(64, 241, 117));'>
                        <div class='progress-bar progress-bar-striped download_progress' style='width: 0%' >0%</div>
                      </div>
                </div>
              </div>
              </div>
             <!-- A card of pdf view edit delete or download  -->";



            }
        

            echo $HTML;


        }else{
            echo "<center><h4 class='font-h m-3' style='color:red;'> No file Found </h4> </center>";
        }
    }else{
        echo "sql error";
    }



}
else{
    if(isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN']) ){
        echo " <center><h4 class='font-h' style='color:red;'>!! ACCESS DENIED !! </h4> </center>";
    }else if(isset($_SESSION['TEACHER'])){
       $account_active= $_SESSION['ACTIVE'];
       $data_s="active";
       if($account_active==0)
       {
        $data_s="Inactive";
       }else if($account_active==2)
       {
        $data_s="blocked";
       }
        echo " <center><h4 class='font-h' style='color:red;'>!! ACCESS DENIED !! because your account is {$data_s} </h4> </center>";

    }
    else{
    echo " <center><h4 class='font-h'>!! After the Approval by the Teacher you can access All Pdf and file !! </h4> </center>";
    }
}
?>