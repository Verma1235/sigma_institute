<?php
session_start();
include("Chek_required_permission.php");

if((isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN'])) && $Status==1 && isset($_POST['LOAD']))
{
    $DATA_ADM="";
    $sql5="SELECT * FROM `admission_record`;";
    $result=mysqli_query($conn,$sql5);
    if($result)
    {
        if(mysqli_num_rows($result)>0){
        $count_Row=0;
        while($data=mysqli_fetch_assoc($result))
        {   $count_Row +=1;
            $name =$data['FULLNAME'];
            $Signupid=$data['SIGNUP_ID'];

            $AdmID=$data['ADMISSION_ID'];
            $Phone=$data['PHONE'];
            $Status_adm=$data['STATUS'];
            $Amount=$data['AMOUNT'];
            $approval="Approved";
            $DOA=$data['DOA'];
            $apr_clr='greenyellow';
            $PayMent=$data['PAYMENT'];

            $sql_profile="SELECT * FROM `studenttable` WHERE `ID`='$Signupid';";
            $query=mysqli_query($conn,$sql_profile);
            $pic_path="img/"."profile.png";
            $pic="profile.png";
            if($query){
                $data=mysqli_fetch_assoc($query);
                if(isset($data['IMG_P'])){
                    $pic_path='img/'.$data['IMG_P'];
                    $pic=$data['IMG_P'];
                }
               
            }
           


            if($Status_adm==0)
            {
                $approval="Approved";
                $apr_clr='greenyellow';
            }else
            {
                $approval="UnApproved";
                $apr_clr='orange';
            }
            $Pay_clr='#212529';
            if($PayMent==0)
            {
                $Pay_status="Due";
                $Pay_clr='#212529';
            }else
            {
                $Pay_status='Paid';
                $Pay_clr='#65dcf2';
            }
            $DATA_ADM .="
              <tr>
                    <th scope='row'>{$count_Row}</th>
                    <td data-img='{$pic_path}'data-bs-toggle='modal' data-bs-target='#pic_dev' class='pic_container'> <div style='height:50px; width:50px; border-radius:50%;background:lime;display:flex;align-item:center;'  ><img src='{$pic_path}' width='100%' style='border-radius:50%;object-fit:cover;' '/></div></td>
                    <td>{$name}</td>
                    
                    <td>{$Signupid}</td>
                    <td>{$Phone}</td>
                    <td><button class='form-control btn btn-warning font-h shadow'  data-admid='{$AdmID}' >Edit</button></td>
                    <td><button class='form-control btn btn-dark  font-h shadow' style='background: {$Pay_clr};'><small>{$Pay_status}</small></button></td>
                    <td><button class='form-control btn btn-primary font-h shadow status_btn' data-admid='{$AdmID}'>{$DOA}</button></td>
                    <td><button class='form-control btn btn-danger font-h shadow del_btn' data-admid='{$AdmID}' >Delete</button></td>
                    <td><button class='form-control btn  font-h shadow apv_btn' style='background: {$apr_clr};' data-admid='{$AdmID}'>{$approval}</button></td>
                    
                 
                </tr>
                            
            ";

        }

        echo $DATA_ADM;
      }
     else
     {
        echo "<tr><th colspan='10' class='font-h'> ! No Admission Details found ! </th></td>";
     }

    }

}else if(isset($_POST['DELETE_REC']) && (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN'])) && $Status==1 ){


}
else if(isset($_POST['EDIT_REC']) && (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN'])) && $Status==1 ){


}else if(isset($_POST['SEARCH']) && (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN'])) && $Status==1 ){


}else
{
    echo "<tr><th colspan='10' class='font-h' style='color:red;'> <center>! Access Denied ! </center> </th></td>";
}

?>