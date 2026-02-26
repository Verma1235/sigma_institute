<?php
session_start();
include("Chek_required_permission.php");
if(isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN'])){
?>
<center>
    <h3 class="font-h">Deleted Account</h3>
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
                <!-- <option value="SUBJECT">Subject</option> -->

            </select>

            <div class="search-con"><input type="search" class="form-control header-input-search"
                    placeholder="search data" id="search_student_input"></div>
            <div class="search-btn2"><button class="form-control header-btn-search-table del_stu_record"><i
                        class="bi bi-search"></i></button>
            </div>
        </div>

        <div class="left-element font-h ">
            <!-- <h5 id="filter" style="margin-right: 3px;">Class </h5> -->
            <select class="form-control" style="width: fit-content; margin-left: 5px;display:none" id="class">
                <option value="0">All</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>

            </select>
        </div>
    </div>
    <table class="table table-striped table-hover">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <!-- <th scope="col">Subject</th> -->
                    <th scope="col">ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th> 
                    <th scope="col">Bakup Account</th>
                    <th scope="col">Account</th>
                </tr>
            </thead>
            <tbody style="overflow: scroll;width: calc(100% - 100px);" id="student_data_cont">
                <tr>
                    <th scope="row">1</th>
                    <td>Dinesh verma</td>
                    <td>12</td>
                    <td>SIGMA@001</td>
                    <td>verma@123gmail.com</td>
                    <td>9693490785</td>
                    <td class="edit_delete_td"><button class="btn form-control btn-warning">Edit</button> <button
                            class="btn form-control btn-danger del_stu_record">Delete</button></td>
                </tr>

            </tbody>
            <script type="text/javascript">


            </script>
        </table>
    </table>
    <div style="display: flex; justify-content: space-between;align-items: center;width: 100%;">


        <div class="right-element">
            <nav aria-label="Page navigation example">
                <ul class="pagination font-h" id="pagination" style="color:blue">
                    <!-- <li class="page-item"><a class="page-link" href="#">Total Page:</a></li> -->
                    <?php  
        $sql_count_rec="SELECT ID FROM `studenttable` WHERE `POST`='STUDENT' OR `POST`='';";
        $rec_num=mysqli_query($conn,$sql_count_rec);
        if($rec_num)
        {
             $total_rec=mysqli_num_rows($rec_num);

             if(isset($_SESSION['STD_LIST_LIM']))
             {
                $limit=$_SESSION['STD_LIST_LIM'];
             }else{
                $limit=6;
             }
            
             $total_page=ceil($total_rec / $limit);
           
                echo '<li class="page-item" ><button class="page-link "  data-page="'.$total_page.'" >Total <b style="color:red">'.$total_page.' page </b> <small></small></button></li>';
             
             echo '</ul>';
        
     ?>


            </nav>
            <div class="left-element font-h ">
                <h5 id="filter" style="margin-right: 3px;color:black"><select class="form-control"
                        style="width: fit-content; margin-left: 5px;" id="page_num">
                        <?php   
        for($i = 1;$i<=$total_page;$i++)
        {
            echo '<option value="'.$i.'">'.$i.'</option>';
        }
       

      }  ?>


                    </select>
            </div>



        </div>
<!-- 
        <div class="left-element font-h ">
            <h5 id="filter" style="margin-right: 3px;">List:</h5>
            <select class="form-control" style="width: fit-content; margin-left: 5px;" id="rec_show">
                <option value="6">6</option>
                <option value="3">3</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="150">150</option>


            </select>
        </div> -->
    </div>
    <script>
        $(document).ready(function () {


            var container = $("#student_data_cont");
            var searcBy_NPEID = $("#searchbyNEPID");
            var search_btn = $(".header-btn-search-table");
            var input_search = $("#search_student_input");
            var Rec_Show = $("#rec_show");
            var page = 1;

            // alert(input_search.val())

            var Class = $("#class");
            var delete1 = 0;
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
                            } else {
                                message(data, "red", ".page_num", () => {
                                    var page = $(this).data("page");


                                });
                            }
                        }
                    });
                }

            });





            $("#student_data_cont").on("click", '.edit_stu_rec', function () {
                var id = $(this).data("id1");
                // alert("work");
                $.ajax({
                    url: "fetch_data_for_edit.php",
                    type: "POST",
                    data: { ID: id },
                    dataType: "JSON",
                    success: function (data) {



                        $.each(data, function (key, value1) {
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
                            $("#EDITACTIVE_COADMIN").val(value1.ACTIVE);

                            $("#EDITGENDER").val(value1.GENDER);
                            $("#EDITPARENTCONTACT").val(value1.PARENTCONTACT);
                        //     if(value1.POST!="TEACHER")
                        //    {
                        //     id.parents(".tr_stu").hide(300);
                        //   }
                        });

                    }




                });
            });


            //  load Teacher data 

            window.load_deleted_data = function () {
                $.ajax({
                    url: "Adminbackend.php",
                    type: "post",
                    data: { DELETED_ACCOUNT: "ACTIVE" },
                    success: function (data) {

                        container.html(data);
                    

                    }
                });

            }
            
            load_deleted_data();
            
        $("#student_data_cont").on("click", '.restore_stu_rec', function () {
            var id = $(this).data("id1");
            var child = $(this);
          
           
                $.ajax({
                    url: "deleterecord.php", // combine status change with delete file 
                    type: "POST",
                    data: { ID: id, ACTION: 'RESTORE_AC' },
                    success: function (data) {
                        if (data == 0) {

                            message("Account successfully backuped !!", "green");
                            // load_deleted_data().delay(500);
                            child.parents(".tr_stu").hide(300);
                        }else if(data==1){
                            message("Error occours in server !!","red");
                        }else{
                            message(data,"red");
                            
                        }
                    }
                });
            

        });



        $("#student_data_cont").on("click", '.delete_permanet_stu_rec', function () {
            var id = $(this).data("id1");
            var child = $(this);
          
            var fix=confirm("Do you want to delete permanentaly");

            if(fix==true)
        {
           
                $.ajax({
                    url: "Adminbackend.php", // combine status change with delete file 
                    type: "POST",
                    data: { ID: id, AC_DELETE_PER: 'AC_DELETE_PER' },
                    success: function (data) {
                        // alert(data);
                        if (data == 0) {

                            message("Account Deleted successfully !!", "green");
                            // load_deleted_data().delay(500);
                            child.parents(".tr_stu").hide(300);
                        }else if(data==1){
                            message("Error occours in removing data!!","red");
                        }else{
                            message(data,"red");
                            
                        }
                    }
                });
            }
            

        });
            // PAGINATION


            // $("#page_num").on("change",()=>{

            //                 page=$("#page_num").val();
            //                 // alert($("#page_num").val());
            //             load_data(Class.val(),page,Rec_Show.val());



            //         });

            //         $("#rec_show").on("change",()=>{
            //             load_data(Class.val(),page,Rec_Show.val());
            //         });
            // data load according to condition by class 

            // function load_data(class_value,page1,limit) {
            //     $.ajax({
            // //         url: "backend_data_of_student_table.php",
            // //         type: "POST",
            // //         data: { CLASS: class_value,PAGE:page1,LIMIT:limit },
            // //         success: function (data) {

            // //             container.html(data);
            // //        var data_pagination=  $("#pagination").html();
            // //        $("#pagination").html(data_pagination);

            // //         }
            // //     });

            // // }

            // // loading data initialy
            // Class.on("change", () => {
            //     load_data(Class.val(),page,Rec_Show.val());
            // });
            // load_data(0,page,Rec_Show.val());
            // // calling classd

            // // searching
            // input_search.on("input", () => {

            //     if (input_search.val() != "") {
            //         var TYPE = "NAME";
            //         if (searcBy_NPEID.val() == "NAME") {
            //             TYPE = "NAME";
            //         } else if (searcBy_NPEID.val() == "ID") {
            //             TYPE = "ID";
            //         }
            //         else if (searcBy_NPEID.val() == "PHONE") {
            //             TYPE = "PHONE";
            //         } else if (searcBy_NPEID.val() == "EMAIL") {
            //             TYPE = "EMAIL";
            //         }
            //         // alert(TYPE);
            //         $.ajax({
            //             url: "backend_data_of_student_table.php",
            //             type: "POST",
            //             data: { SEARCH_TYPE: TYPE, SEARCH_DATA: input_search.val() ,CLASS_SEARCH:Class.val() },
            //             success: function (data) {

            //                 container.html(data);

            //             }

            //         });
            //     }
            //     else {
            //         load_data(Class.val(),page,Rec_Show.val());
            //         var data_pagination=  $("#pagination").html();
            //         $("#pagination").html(data_pagination);
            //     }
            // });

            // // search byclick
            // search_btn.on("click", () => {


            //     if (input_search.val() != "") {
            //         var TYPE = "NAME";
            //         if (searcBy_NPEID.val() == "NAME") {
            //             TYPE = "NAME";
            //         } else if (searcBy_NPEID.val() == "ID") {
            //             TYPE = "ID";
            //         }
            //         else if (searcBy_NPEID.val() == "PHONE") {
            //             TYPE = "PHONE";
            //         } else if (searcBy_NPEID.val() == "EMAIL") {
            //             TYPE = "EMAIL";
            //         }
            //         // alert(TYPE);
            //         $.ajax({
            //             url: "backend_data_of_student_table.php",
            //             type: "POST",
            //             data: { SEARCH_TYPE: TYPE, SEARCH_DATA: input_search.val() },
            //             success: function (data) {

            //                 container.html(data);

            //             }

            //         });
            //     }
            //     else {
            //         load_data(Class.val(),page,Rec_Show.val()); 

            //     }

        });





    </script>
</div>

<?php
}else if(isset($_SESSION['NAME'])){
?>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" src="css/style.css">
    <style type="text/stylesheet">



.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.profile-header {
    text-align: center;
    margin-bottom: 20px;
}

.profile-info {
    margin-bottom: 20px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #ddd;
}

.info-item label {
    font-weight: bold;
}

.info-item span {
    color: #555;
}

.actions {
    text-align: center;
    margin-bottom: 20px;
}

.edit-button {
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.edit-button:hover {
    background-color: #0056b3;
}

.notification-panel {
    border-top: 1px solid #ddd;
    padding-top: 10px;
}

.notification-panel h2 {
    margin-top: 0;
}

.notification-panel ul {
    list-style-type: none;
    padding: 0;
}

.notification-panel ul li {
    padding: 8px;
    border-bottom: 1px solid #ddd;
}

.notification-panel ul li:last-child {
    border-bottom: none;
}

</style>
</head>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="profile-header font-h">
            <h2>User Profile</h2>
        </div>

        <div class="profile-info">
            <div class="info-item">
                <label for="name">Name:</label>
                <span id="name">
                    <?php echo $_SESSION['NAME'];?>
                </span>
            </div>
            <div class="info-item">
                <label for="number">Phone:</label>
                <span id="number">
                    <?php if(isset($_SESSION['PHONE'])){echo $_SESSION['PHONE'];}else{echo '+91xxxxxxxxxx';}?>
                </span>
            </div>
            <div class="info-item">
                <label for="section">Email:</label>
                <span id="section">
                    <?php  echo $_SESSION['Email']?>
                </span>
            </div>
            <div class="info-item">
                <label for="account-type">Account Type:</label>
                <span id="account-type">BASIC</span>
            </div>
        </div>

        <div class="actions">
            <button class=" btn form-control btn-warning shadow font-h" style="width: 100px;">Edit <i
                    class="bi bi-pencil"></i></button>
        </div>

        <div class="notification-panel font-h">
            <h3>Notifications</h3>
            <ul>
                <li>New message from admin</li>
                <li>Account verification successful</li>
                <li>Upcoming maintenance scheduled</li>

            </ul>
        </div>
    </div>
</body>

</html>






<?php
}else{?>

<img width="100%" height="auto"
    src="https://media.licdn.com/dms/image/D4D12AQEvlwvk_5jSBw/article-cover_image-shrink_600_2000/0/1714975705046?e=2147483647&v=beta&t=SSIjJpE29SKs3_amDcg2HY3bYhUaR145LScDJaJ5enk">


<?php } ?>