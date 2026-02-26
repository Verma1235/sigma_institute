<?php
include"database.php";
// $class=6;
  // echo $class;
    // $class=0;
    // if($class==0){
    //     $sql="SELECT * FROM `studenttable` ;";

    // }else{ }

if(isset($_POST['ADMIN'])){


$ADMIN=$_POST['ADMIN'];
 $sql="SELECT * FROM `studenttable` WHERE (`POST`='ADMIN' or `POST`='COADMIN'); ";
    

$result=mysqli_query($conn,$sql);

if($result){
if(mysqli_num_rows($result)>0){
    $Html="";
    $count=0;
    while($data=mysqli_fetch_assoc($result)){
    
        $count +=1;

     $Html .="   <tr class='tr_stu'>
                    <th scope='row'>$count</th>
                    <td>{$data['NAME']}</td>
                    <td>{$data['POST']}</td>
                    <td>{$data['ID']}</td>
                    <td>{$data['EMAIL']}</td>
                    <td>";
                    if($data['ACTIVE']==1){

                        $Html.="<button
                    class='btn form-control btn-success change_admin_status' data-id='{$data['ID']}' >Active</button>";
                    }else{
                        $Html.="<button
                        class='btn form-control btn-secondary change_admin_status' data-id='{$data['ID']}'>Disable</button>";
                    }
                    
                    $Html.="</td>
                    <td class='edit_delete_td'><button class='btn form-control btn-warning edit_stu_rec' data-id1='{$data['ID']}' data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button> <button
                            class='btn form-control btn-danger del_stu_record' data-id2='{$data['ID']}'  >Delete</button></td>
                </tr>";
             


    }
    echo $Html;
}
else{
    echo "<tr><td class='font-h' colspan='5'> No data found</td> </tr>";
}

}else{
    echo "error";
}


}
else if(isset($_POST['SEARCH_TYPE']) && isset($_POST['SEARCH_DATA']) && isset($_POST['ADMIN2'])){

$type=$_POST['SEARCH_TYPE'];
$data=$_POST['SEARCH_DATA'];
if($type=="NAME"){
    $data1=$data."%";
     $data2="%".$data."%";
     

      $data3="%".$data;
      $sql="SELECT * FROM `studenttable` WHERE (( `NAME` like '$data1') or ( (`NAME` like '$data2')  or (`NAME` like '$data3'))) and (`POST`='ADMIN' OR `POST`='COADMIN');";
}else{
    $data1=$data."%";
    // ""."%";
    $sql="SELECT * FROM `studenttable` WHERE  (`$type` like '$data1') AND (`POST`='ADMIN' OR `POST`='COADMIN');";
}

$result=mysqli_query($conn,$sql);
if($result){
    if(mysqli_num_rows($result)>0){
        $Html="";
        $count=0;
        while($data=mysqli_fetch_assoc($result)){
            $count +=1;
            $Html .="   <tr class='tr_stu'>
            <th scope='row'>$count</th>
            <td>{$data['NAME']}</td>
            <td>{$data['POST']}</td>
            <td>{$data['ID']}</td>
            <td>{$data['EMAIL']}</td>
            <td>";
            if($data['ACTIVE']==1){

                $Html.="<button
            class='btn form-control btn-success change_admin_status' data-id='{$data['ID']}'>Active</button>";
            }else{
                $Html.="<button
                class='btn form-control btn-secondary change_admin_status' data-id='{$data['ID']}'>Disable</button>";
            }
            
            $Html.="</td>
            <td class='edit_delete_td'><button class='btn form-control btn-warning edit_stu_rec' data-id1='{$data['ID']}' data-bs-toggle='modal' data-bs-target='#editModal' >Edit</button> <button
                    class='btn form-control btn-danger del_stu_record' data-id2='{$data['ID']}'  >Delete</button></td>
        </tr>";
    
    
        }
        echo $Html;
    }
    else{
        echo "<tr><td class='font-h' colspan='5'> No data found</td> </tr>";
    }
    
    }else{
        echo "Error 2";
    }



}else if(isset($_POST['TEACHER']) && !isset($_POST['SEARCH_TYPE_T']))
{


    // $ADMIN=$_POST['ADMIN'];
    $sql="SELECT * FROM `studenttable` WHERE `POST`='TEACHER'; ";
   $result=mysqli_query($conn,$sql);
   
   if($result){
   if(mysqli_num_rows($result)>0){
       $Html="";
       $count=0;
       while($data=mysqli_fetch_assoc($result)){
       
           $count +=1;
   
        $Html .="   <tr class='tr_stu'>
                       <th scope='row'>$count</th>
                       <td>{$data['NAME']}</td>
                       <td>{$data['POST']}</td>
                       <td>{$data['ID']}</td>
                       <td>{$data['EMAIL']}</td>
                       <td>";
                       if($data['ACTIVE']==1){
   
                           $Html.="<button
                       class='btn form-control btn-success change_admin_status' data-id='{$data['ID']}' >Active</button>";
                       }else{
                           $Html.="<button
                           class='btn form-control btn-secondary change_admin_status' data-id='{$data['ID']}'>Disable</button>";
                       }
                       
                       $Html.="</td>
                       <td class='edit_delete_td'><button class='btn form-control btn-warning edit_stu_rec' data-id1='{$data['ID']}' data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button> <button
                               class='btn form-control btn-danger del_stu_record' data-id2='{$data['ID']}'  >Delete</button></td>
                   </tr>";
                
   
   
       }
       echo $Html;
   }
   else{
       echo "<tr><td class='font-h' colspan='5'> No data found</td> </tr>";
   }
   
   }else{
       echo "error";
   }
   



}else  if(isset($_POST['DELETED_ACCOUNT']))
{
    // $ADMIN=$_POST['ADMIN'];
    $sql="SELECT * FROM `studenttable` WHERE `DELETE_AC`='1'; ";
   $result=mysqli_query($conn,$sql);
   
   if($result){
   if(mysqli_num_rows($result)>0){
       $Html="";
       $count=0;
       while($data=mysqli_fetch_assoc($result)){
       
           $count +=1;
   
           $Html .=" <tr class='tr_stu'>
           <th scope='row'>$count</th>
           <td>{$data['NAME']}</td>
           <td>{$data['ID']}</td>
           <td>{$data['EMAIL']}</td>
           <td>{$data['PHONE']}</td>
          <td><button class='btn form-control btn-warning restore_stu_rec' style='background:linear-gradient(to right, rgb(17, 206, 235), rgb(64, 241, 117))' data-id1='{$data['ID']}' >Restore</button> </td>
           <td><button class='btn form-control btn-warning delete_permanet_stu_rec' style='background:linear-gradient(to right, rgb(255,121,4), pink)' data-id1='{$data['ID']}' >Deleted</button> 
              </tr>";
       }
       echo $Html;
   }
   else{
       echo "<tr><td class='font-h' colspan='5'> No data found</td> </tr>";
   }
   
   }else{
       echo "error";
   }
}else  if(isset($_POST['AC_DELETE_PER']))
{
    // $ADMIN=$_POST['ADMIN'];
    $id=$_POST['ID'];
    $sql="SELECT * FROM `studenttable` WHERE `ID`='$id';";
   $result=mysqli_query($conn,$sql);

   $data=mysqli_fetch_assoc($result);
//    ALPHA_ADM_IDSIGMA8297
//    $id_proof='ID_PROOF_FILE';
    if($data['IMG_P']!='profile.png')
    {
        $img="img/".$data['IMG_P'];
        unlink($img);
    }
    if($result){
    $sql0="SELECT * FROM `admission_record` WHERE `SIGNUP_ID`='$id';";
    $res0=mysqli_query($conn,$sql0);
    if(mysqli_num_rows($res0)>0)
    {
        $data0=mysqli_fetch_assoc($res0);
        $id_proof="adhar/".$data0['ID_PROOF_FILE'];
        unlink($id_proof);
    }
   $sql2="DELETE FROM `studenttable` WHERE `ID`='$id';";
   $sql3="DELETE FROM `admission_record` WHERE `SIGNUP_ID`='$id';";

   $res2=mysqli_query($conn,$sql2);
   $res3=mysqli_query($conn,$sql3);

   if($res2 && $res3)
   {
    // echo "Data deleted permanentaly";
    echo 0;
   }else 
   {
    // echo "Somthing went wrong !!";
    echo 1;
   }

}else{
    echo "error hear";
}


}else if(isset($_POST['SEARCH_TYPE_T']) && isset($_POST['SEARCH_DATA_T']))
{
$Search=$_POST['SEARCH_TYPE_T'];
$inp_val=$_POST['SEARCH_DATA_T'];

$SRCH1="%".$inp_val;
$SRCH2=$inp_val."%";
$SRCH3="%".$inp_val."%";

$sql="SELECT * FROM `studenttable` WHERE ((`POST`='TEACHER') AND ((`$Search` like '$SRCH1') OR (`$Search` like '$SRCH2') OR (`$Search` like '$SRCH3')));";
$result=mysqli_query($conn,$sql);

if($result){
    echo "rgrh";
    if(mysqli_num_rows($result)>0){
        $Html="";
        $count=0;
        
        while($data=mysqli_fetch_assoc($result)){
        
            $count +=1;
    
         $Html .="   <tr class='tr_stu'>
                        <th scope='row'>$count</th>
                        <td>{$data['NAME']}</td>
                        <td>{$data['POST']}</td>
                        <td>{$data['ID']}</td>
                        <td>{$data['EMAIL']}</td>
                        <td>";
                        if($data['ACTIVE']==1){
    
                            $Html.="<button
                        class='btn form-control btn-success change_admin_status' data-id='{$data['ID']}' >Active</button>";
                        }else{
                            $Html.="<button
                            class='btn form-control btn-secondary change_admin_status' data-id='{$data['ID']}'>Disable</button>";
                        }
                        
                        $Html.="</td>
                        <td class='edit_delete_td'><button class='btn form-control btn-warning edit_stu_rec' data-id1='{$data['ID']}' data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button> <button
                                class='btn form-control btn-danger del_stu_record' data-id2='{$data['ID']}'  >Delete</button></td>
                    </tr>";
                 
    
    
        }
        echo $Html;
    }
    else{
        echo "<tr><td class='font-h' colspan='5'> No data found</td> </tr>";
    }
    
    }else{
        echo "error";
    }


}

// INSERT INTO `studenttable` (`NAME`, `ID`, `EMAIL`, `PHONE`, `CLASS`) VALUES ('Dinesh verma', 'SIGMA001', 'vermadinesh@250gmail.com', '9693431253', '6');
?>