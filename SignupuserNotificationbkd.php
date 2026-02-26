<?php
session_start();
include"Chek_required_permission.php";
date_default_timezone_set("Indian/Mahe");

if(isset($_POST["ADMIN"]) && (isset($_SESSION['ADMIN']) || $_SESSION['COADMIN'] ))
{
    $sql ="SELECT * FROM `studenttable` WHERE (`ACTIVE`=0 or `ACTIVE`=2) and `DELETE_AC`=0;";
    $res=mysqli_query($conn,$sql);

    if($res)
    {
        if(mysqli_num_rows($res)>0){
            $HTML='';
            $flag=0;
 
          while($data=mysqli_fetch_assoc($res))
          {
            $flag++; 
            $sta="";
            $clr="red";

            if($data['ACTIVE']==0)
            {
                $sta="InActive";
                $clr="gray";
            }else{
                $sta="Blocked";
            }
            $req="Today";
            // if($req==$data['DOA'][-2].$data['DOA'][-1]){
            //     $req="Today";
            // }else if($req==($data['DOA'][-2]*10 + $data['DOA'][-1] -1))
            // {
            //     $req ="Yestruday";
            // }
             $HTML .=' <tr>
            <th scope="row">'.$flag.'</th>
            <td>'.$data['ID'].'</td>
            <!-- <td>12</td> -->
            <td>'.$data['NAME'].'</td>'.'<td><small>'.$data['DOA'][-2].$data['DOA'][-1].'/'.$data['DOA'][-5].$data['DOA'][-4].'/'.$data['DOA'][0].$data['DOA'][1].$data['DOA'][2].$data['DOA'][3].'</small></td>'.'
           
            <!-- <td>verma@123gmail.com</td> -->
             <td class="edit_delete_td"><button class="btn form-control btn-warning read" data-id='.$data['ID'].'>'.$req.'</button></td>

            <--<td><!--<small
                    style="min-width: 200px;max-height:70px;overflow: scroll;display: block;text-align:center;"><mark>'.$data['ID'].'</mark></small>-->

                    <button class="btn btn-success view-query" data-query="'.$data['EMAIL'].'" data-bs-toggle="modal" data-bs-target="#query-cont"> view </button>
            </td>
             <td><button class="btn block_stu_rec" data-id1="'.$data['ID'].'" style="background:'.$clr.';color:white">'.$sta.'</button></td></tr>';
        

           }
           echo $HTML;

          }else{
        echo "Data not found";
          }
    }

}
?>