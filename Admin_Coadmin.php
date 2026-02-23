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
  
//           // ########################## Login chek ##################

//           if( $row_get['LOGIN_ID']!=$_SESSION['LOGIN_ID']){
//             echo "<script>alert('! Your Account  is login into an another device !'); window.location.href = 'logout.php'; </script>";
//         }
//         if($row_get["POST"]!="COADMIN" || $row_get["POST"]!="ADMIN"){
//             echo "<script>alert('! Your POST has been changed by Admin! Relogin now !'); window.location.href = 'logout.php'; </script>";
//         }
//     // ########################## Login chek ##################

//          }else{
//                     echo "<script>window.location.href='logout.php'; </script>";
//           }
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

 
//             // ########################## Login chek ##################

//             if( $row_get['LOGIN_ID']!=$_SESSION['LOGIN_ID']){
//                 echo "<script>alert('! Your Account  is login into an another device !'); window.location.href = 'logout.php'; </script>";
//             }
//             if($row_get["POST"]!="COADMIN" || $row_get["POST"]!="ADMIN"){
//                 echo "<script>alert('! Your POST has been changed by Admin! Relogin now !'); window.location.href = 'logout.php'; </script>";
//             }
  
//         // ########################## Login chek ##################

//                 }else{
//                     echo "<script>window.location.href='logout.php'; </script>";
//                 }
//      }else{
//          echo "error in active status cheking 2";
//      }
   

// }else{
//     $Status=2;
// }


if(isset($_SESSION['ADMIN']) && $Status==1){
?>
<center>
    <h3 class="font-h">Admin And Co-Admin TAble</h3>
</center>

<head>
    <link rel="stylesheet" src="css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- <script type="text/javascript" src="js/home.js"></script> -->
    <script src="jquery.js"> </script>
</head>
<div class="container-fluid ">
    <div style="display: flex; justify-content: space-between;align-items: center;width: 100%;">


        <div class="right-element">
            <select class="form-control" style="width: fit-content;margin-right: 5px;" id="searchbyNEPID">
                <option value="NAME">Name</option>
                <option value="PHONE">Phone </option>
                <option value="EMAIL">Email</option>
                <option value="ID">ID</option>

            </select>

            <div class="search-con"><input type="search" class="form-control header-input-search"
                    placeholder="search data" id="search_student_input"></div>
            <div class="search-btn2"><button class="form-control header-btn-search-table del_stu_record"><i
                        class="bi bi-search"></i></button>
            </div>
        </div>
        <h5 id="filter" style="margin-right: 3px;" ><button class="btn btn-success form-control header-btn-search-table" style="background:green;border-radius:10px"><i class="bi bi-arrow-clockwise"></i></button></h5>
        <!-- <div class="left-element font-h ">
            <h5 id="filter" style="margin-right: 3px;">Class </h5>
            <select class="form-control" style="width: fit-content; margin-left: 5px;" id="class">
                <option value="0">All</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>

            </select>
        </div> -->
    </div>
    <table class="table table-striped table-hover">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">POST</th>
                    <th scope="col">ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">Edit/Delete</th>
                </tr>
            </thead>
            <tbody style="overflow: scroll;width: calc(100% - 100px);" id="student_data_cont">
                <tr>
                    <th scope="row">1</th>
                    <td>Dinesh verma</td>
                    <td>ADMIN</td>
                    <td>SIGMA@001</td>
                    <td>verma@123gmail.com</td>
                    <td></button> <button
                    class="btn form-control btn-success del_stu_record">Active</button></td>
                    <td class="edit_delete_td"><button class="btn form-control btn-warning">Edit</button> <button
                            class="btn form-control btn-danger del_stu_record">Delete</button></td>
                </tr>

            </tbody>
            <script type="text/javascript">


            </script>
        </table>
    </table>
    <script>

        var container = $("#student_data_cont");
        var searcBy_NPEID = $("#searchbyNEPID");
        var search_btn = $(".header-btn-search-table");
        var input_search = $("#search_student_input");
        // alert(input_search.val())

        // var Class = $("#class");
        // var delete1 = 0;
        $("#student_data_cont").on("click", '.del_stu_record', function () {
            var id = $(this).data("id2");
            var child = $(this);
            var con = confirm("Do you want to delete student record of ID=" + id);
            if (con == true) {
                $.ajax({
                    url: "deleterecord.php",
                    type: "POST",
                    data: { ID: id, ACTION: 'DELETE1' },
                    success: function (data) {
                        if (data == 0) {

                            message("Record deleted", "green");
                            child.parents(".tr_stu").hide(300);
                        }else{
                            message(data,"red");
                        }
                    }
                });
            }

        });

        $("#student_data_cont").on("click", '.change_admin_status', function () {
            var id = $(this).data("id");
            var child = $(this);
            
          
           
                $.ajax({
                    url: "deleterecord.php", // combine status change with delete file 
                    type: "POST",
                    data: { ID: id, ACTION: 'STATUS' },
                    success: function (data) {
                        if (data == 0) {

                            message("Status Change successfully", "green");
                            load_admion_data();
                        }else if(data==1){
                            message("Error occours in server !!","red");
                        }else{
                            message(data,"red");
                            
                        }
                    }
                });
            

        });





        // $("#student_data_cont").on("click", '.edit_stu_rec', function () {
        //     var id = $(this).data("id1");
        //     alert(id);
        // });



        $("#student_data_cont").on("click", '.edit_stu_rec', function () {
            var id = $(this).data("id1");
            // alert("work 1 "+id);
            $.ajax({
                url:"fetch_data_for_edit.php",
                type:"POST",
                data:{ID:id},
                dataType:"JSON",
                success:function(data){
          
                    $.each(data,function(key,value1){
                        console.log(value1);
                        $("#EDITNAME").val(value1.NAME);
                        $("#EDITEMAIL").val(value1.EMAIL);
                        $("#EDITID").val(value1.ID);
                        $("#EDITPOST").val(value1.POST);
                        $("#EDITPOST").val(value1.POST); 
                        $("#temp_post_holder").val(value1.POST);    // POST SELECT 
                        $("#EDITADDRESS").val(value1.ADDRESS);
                        $("#EDITADHAR").val(value1.ADHAR);
                        $("#EDITCLASS").val(value1.CLASS);
                        $("#EDITDISTRICT").val(value1.DISTRICT);
                        $("#EDITDOA").val(value1.DOA);
                        $("#EDITDOB").val(value1.DOB);
                        $("#EDITFATHER").val(value1.FATHER);
                        $("#EDITPHONE").val(value1.PHONE);
                        $("#EDITVILLAGE").val(value1.VILLAGE);
                        $("#EDITACTIVE").val(value1.ACTIVE);
                        $("#EDITGENDER").val(value1.GENDER);
                        $("#EDITPARENTCONTACT").val(value1.PARENTCONTACT);
                        // $("#").val(value1.);
                        // $("#").val(value1.);
                    });
              
                }


            });
        });











        // data load according to condition by class 

       window.load_admion_data= function() {
            $.ajax({
                url: "Adminbackend.php",
                type: "post",
                data: { ADMIN: "ADMIN",COADMIN: "COADMIN" },
                success: function (data) {

                    container.html(data);

                }
            });

        }
        load_admion_data();
        // loading data initialy
        // Class.on("change", () => {
        //     load_data(Class.val());
        // });
        // load_data(0);
        // calling classd

        // searching
        input_search.on("keyup", () => {

            if (input_search.val() != "") {
                var TYPE = "NAME";
                if (searcBy_NPEID.val() == "NAME") {
                    TYPE = "NAME";
                } else if (searcBy_NPEID.val() == "ID") {
                    TYPE = "ID";
                }
                else if (searcBy_NPEID.val() == "PHONE") {
                    TYPE = "PHONE";
                } else if (searcBy_NPEID.val() == "EMAIL") {
                    TYPE = "EMAIL";
                }
                // alert(TYPE);
                $.ajax({
                    url: "Adminbackend.php",
                    type: "POST",
                    data: { SEARCH_TYPE: TYPE, SEARCH_DATA: input_search.val(),ADMIN2:"ADMIN" },
                    success: function (data) {

                        container.html(data);

                    }

                });
            }
            else {
                load_admion_data();
            }
        });

        // search byclick
        search_btn.on("click", () => {


            if (input_search.val() != "") {
                var TYPE = "NAME";
                if (searcBy_NPEID.val() == "NAME") {
                    TYPE = "NAME";
                } else if (searcBy_NPEID.val() == "ID") {
                    TYPE = "ID";
                }
                else if (searcBy_NPEID.val() == "PHONE") {
                    TYPE = "PHONE";
                } else if (searcBy_NPEID.val() == "EMAIL") {
                    TYPE = "EMAIL";
                }
                // alert(TYPE);
                $.ajax({
                    url: "Adminbackend.php",
                    type: "POST",
                    data: { SEARCH_TYPE: TYPE, SEARCH_DATA: input_search.val() },
                    success: function (data) {

                        container.html(data);

                    }

                });
            }
            else {
                load_admion_data();
            }

        });








    </script>
</div>
<?php }else{ ?>


    <center><h4 class="font-h" style="color:red;"> !! Access Denied ! you unable to manage Admin And CoAdmin data !! </h4></center>


    <?php } ?>