<?php
session_start();
include"Chek_required_permission.php";





if(isset($_POST['N_ID']))
{
    $id_N=$_POST['N_ID'];
    $sql4=" UPDATE `contact_table` SET `Read_s`='1' WHERE `ID`='$id_N';";
    $result=mysqli_query($conn,$sql4);
    if($result)
    {
        echo 0;
    }else{
        echo "error";
    }





}else if($Status==1 &&  (isset($_SESSION['ADMIN']) || isset($_SESSION['ADMIN'])))
{

    $sql5="SELECT * FROM `contact_table` WHERE `Read_s`='0';";
    $result=mysqli_query($conn,$sql5);

    if($result)
    {
      $HTML=" No data found";
      if(mysqli_num_rows($result)>0){

        $HTML="";
    //    echo json_encode($data_array);
    $flag=0;
       while( $data= mysqli_fetch_assoc($result))
       {    $flag +=1;
            $HTML .=' <tr>
                        <th scope="row">'.$flag.'</th>
                        <td>'.$data['Name'].'</td>
                        <!-- <td>12</td> -->
                        <td>'.$data['Phone'].'</td>
                        <!-- <td>verma@123gmail.com</td> -->

                        <td colspan="3"><!--<small
                                style="min-width: 200px;max-height:70px;overflow: scroll;display: block;text-align:center;"><mark>'.$data['Message'].'</mark></small>-->
                                <button class="btn btn-success view-query" data-query="'.$data['Message'].'" data-bs-toggle="modal" data-bs-target="#query-cont"> View </button>
                        </td>
                        <td class="edit_delete_td"><button class="btn form-control btn-warning read" data-id='.$data['ID'].'>Read</button> </td>
                    </tr>';
       }
    }
       echo $HTML;
    }else{
        echo "error";
    }

}



?>