<?php
session_start();
include"Chek_required_permission.php";


if($Status==1 || $Status==0){

// $class=6;
if(isset($_POST['CLASS'])){
    $page=1;
    if(isset($_POST['PAGE']))
    {
        $page=$_POST['PAGE'];
    }
    $limit=$_POST['LIMIT'];
    $_SESSION['STD_LIST_LIM']=$limit;
    $class=$_POST['CLASS'];
    $offset=($page - 1) * $limit;

    // echo $class;
    // $class=0;
    if($class==0){
        $sql="SELECT * FROM `studenttable` Where ((`POST`='STUDENT' OR `POST`='') and `DELETE_AC`='0')  LIMIT {$offset},{$limit} ;";

    }else{

        $sql="SELECT * FROM `studenttable` WHERE (`CLASS`=$class and ((`POST`='STUDENT' OR `POST`='') and `DELETE_AC`='0')) LIMIT {$offset},{$limit};";
    }

$result=mysqli_query($conn,$sql);

if($result){
if(mysqli_num_rows($result)>0){
    $Html="";
    $count=0;
    while($data=mysqli_fetch_assoc($result)){
        if( $data['POST']=='STUDENT' || $data['POST']==''){
            $class=$data['CLASS'];
            if($data['CLASS']==0)
            {
                $class="Not specified";
            }
            $pic_path="img/".$data['IMG_P'];

        $count +=1;
            if(!isset($_SESSION['TEACHER'])){
     $Html .="   <tr class='tr_stu'>
                    <th scope='row'>$count</th>
                <td data-img='{$pic_path}'data-bs-toggle='modal' data-bs-target='#pic_dev' class='pic_container'> <div style='height:50px; width:50px; border-radius:50%;background:lime;display:flex;align-item:center;'  ><img src='{$pic_path}' width='100%' style='border-radius:50%;object-fit:cover;' '/></div></td>

                    <td>{$data['NAME']}</td>
                    <td>{$class}</td>
                    <td>{$data['ID']}</td>
                    <td>{$data['EMAIL']}</td>
                    
                    <td class='edit_delete_td'><button class='btn form-control btn-warning edit_stu_rec' data-id1='{$data['ID']}' data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button> <button
                     class='btn form-control btn-danger del_stu_record' data-id2='{$data['ID']}'  >Delete</button></td>
                </tr>";
            }else{
                $block_data=$data['ACTIVE'];
               
                if($block_data==0)
                {
                    $dis="InActive";
                    $color="orange";
                }else if($block_data==2){
                    $dis="Blocked";
                    $color="red";
                }else{
                    $dis="Active";
                    $color="lime";
                }

                $Html .=" <tr class='tr_stu'>
                <th scope='row'>$count</th>
                <td data-img='{$pic_path}'data-bs-toggle='modal' data-bs-target='#pic_dev' class='pic_container'> <div style='height:50px; width:50px; border-radius:50%;background:lime;display:flex;align-item:center;'  ><img src='{$pic_path}' width='100%' style='border-radius:50%;object-fit:cover;' '/></div></td>

                <td>{$data['NAME']}</td>
                <td>{$class}</td>
                <td>{$data['ID']}</td>
                <td>{$data['EMAIL']}</td>
                
                  <td class='edit_delete_td'><button class='btn form-control btn-warning block_stu_rec' style='background:{$color};min-width:100px' data-id1='{$data['ID']}' >{$dis}</button> 
                </tr>";
            }
        }       


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
else if(isset($_POST['SEARCH_TYPE']) && isset($_POST['SEARCH_DATA'])){

$type=$_POST['SEARCH_TYPE'];
$data="";
if($_POST['SEARCH_DATA'] != "{\}"){
    $data=$_POST['SEARCH_DATA'];
}


// $class=$_POST['CLASS_SEARCH'];
if($type=="NAME"){
    $data1=$data."%";
     $data2="%".$data."%";
      $data3="%".$data;
      $sql="SELECT * FROM `studenttable` WHERE ((( `NAME` like '$data1') or  (`NAME` like '$data2')  or (`NAME` like '$data3')) and `DELETE_AC`='0');";
}else{
    $data1=$data."%";
    $sql="SELECT * FROM `studenttable` WHERE  ((`$type` like '$data1') and `DELETE_AC`='0');";
}

$result=mysqli_query($conn,$sql);
if($result){
    if(mysqli_num_rows($result)>0){
        $Html="";
        $count=0;
        while($data=mysqli_fetch_assoc($result)){
            if($data['POST']!="ADMIN" && $data['POST']=='STUDENT' ){
                $class=$data['CLASS'];
                if($data['CLASS']==0)
                {
                    $class="Not specified";
                }

                $pic_path="img/".$data['IMG_P'];
    

            $count +=1;
            if(!isset($_SESSION['TEACHER'])){
            $Html .="   <tr class='tr_stu'>
            <th scope='row'>$count</th>
        <td data-img='{$pic_path}'data-bs-toggle='modal' data-bs-target='#pic_dev' class='pic_container'> <div style='height:50px; width:50px; border-radius:50%;background:lime;display:flex;align-item:center;'  ><img src='{$pic_path}' width='100%' style='border-radius:50%;object-fit:cover;' '/></div></td>
            <td>{$data['NAME']}</td>
            <td>{$class}</td>
            <td>{$data['ID']}</td>
            <td>{$data['EMAIL']}</td>
            
            <td class='edit_delete_td'><button class='btn form-control btn-warning edit_stu_rec' data-id1='{$data['ID']}' data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button> <button
                    class='btn form-control btn-danger del_stu_record' data-id2='{$data['ID']}'  >Delete</button></td>
        </tr>";
            }else{
                $block_data=$data['ACTIVE'];
                $dis="Active";
                $color="lime";
                if($block_data==0)
                {
                    $dis="InActive";
                    $color="orange";
                }else if($block_data==2){
                    $dis="Blocked";
                    $color="red";
                }
                $Html .=" <tr class='tr_stu'>
                <th scope='row'>$count</th>
                <td data-img='{$pic_path}'data-bs-toggle='modal' data-bs-target='#pic_dev' class='pic_container'> <div style='height:50px; width:50px; border-radius:50%;background:lime;display:flex;align-item:center;'  ><img src='{$pic_path}' width='100%' style='border-radius:50%;object-fit:cover;' '/></div></td>
                <td>{$data['NAME']}</td>
                <td>{$class}</td>
                <td>{$data['ID']}</td>
                <td>{$data['EMAIL']}</td>
                
                <td class='edit_delete_td'><button class='btn form-control btn-warning block_stu_rec' style='background:{$color}' data-id1='{$data['ID']}' >{$dis}</button> 
            </tr>";
            }
    
        }

        }
        echo $Html;
    }
    else{
        echo "<tr><td class='font-h' colspan='3'> No data found</td> </tr>";
    }
    
    }else{
        echo "Error 2";
    }

}

}else{
  echo "<tr><center><td class='font-h' colspan='5' style='color:red'> <li>You have been blocked by Admin.</li> <br><li>So you unable to access and manage  data </li> </td> <center></tr>";
}


// INSERT INTO `studenttable` (`NAME`, `ID`, `EMAIL`, `PHONE`, `CLASS`) VALUES ('Dinesh verma', 'SIGMA001', 'vermadinesh@250gmail.com', '9693431253', '6');
?>