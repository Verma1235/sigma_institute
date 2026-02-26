<?php
session_start();
if(isset($_SESSION['ID']))
{


?>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="jquery.js"> </script>
</head>
<div class="col-md-8" style="max-width:800px;margin:auto;">
    <!-- <a target="_blank" href="https://getform.io?ref=codepenHTML">
          <img src='https://i.imgur.com/O1cKLCn.png'>
        </a> -->
    <br>
    <!-- <a target="_blank" href="https://getform.io?ref=codepenHTML" class="mt-3 d-flex">Getform.io |  Get your free endpoint now</a> -->
  <?php
if(isset($_SESSION['ADMIN']))
{


  ?>
    <center>
        <h3 class='font-h'> Notification </h3>
    </center>

    <div class="container" id="TABLE_user">
        <table class="table table-striped table-hover">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <!-- <th scope="col">Class</th> -->
                        <th scope="col">Phone</th>
                        <!-- <th scope="col">Email</th> -->

                        <th scope="col" colspan="3">Query</th>
                        <th scope="col">Read</th>

                    </tr>
                </thead>
                <tbody style="overflow: scroll;width: calc(100% - 100px);" id="student_data_cont">
                    <!-- <tr>
                        <th scope="row">1</th>
                        <td>Dinesh verma</td>
                      
                        <td>4578968545</td>
                

                        <td colspan="3"><small
                                style="min-width: 200px;max-height:70px;overflow: scroll;display: block;">I request
                                to you for activation my account. I request to you for activation my account. I request
                                to you for activation my account.</small>
                        </td>
                        <td class="edit_delete_td"><button class="btn form-control btn-warning">UnRead</button> </td>
                    </tr> -->

                </tbody>
            </table>
            
            <hr>
            <?php
              }
                ?>


            <table class="table table-striped table-hover">
            
                
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <!-- <th scope="col">Class</th> -->
                      
                        <!-- <th scope="col">Email</th> -->

                        <th scope="col" >Name</th>
                        <th scope="col">Signup Date</th>
                        <th scope="col">Request</th>
                     
                        <th scope="col">Details</th>
                        <th scope="col">Status</th>
                     

                    </tr>
                </thead>
                <tbody style="overflow: scroll;width: calc(100% - 100px);" id="student_data_cont2">
                    <!-- <tr>
                        <th scope="row">1</th>
                        <td>Dinesh verma</td>
                      
                        <td>4578968545</td>
                

                        <td colspan="3"><small
                                style="min-width: 200px;max-height:70px;overflow: scroll;display: block;">I request
                                to you for activation my account. I request to you for activation my account. I request
                                to you for activation my account.</small>
                        </td>
                        <td class="edit_delete_td"><button class="btn form-control btn-warning">UnRead</button> </td>
                    </tr> -->

                </tbody>
            </table>

       





    </div>

    <div class="container">

    </div>
    <!-- modal con -->
<div class="modal fade" id="query-cont" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content" style="background: linear-gradient(rgb(9, 199, 220),rgb(108, 205, 140));">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Message/Query</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <pre style="overflow-x:hidden;text-align:justify;text-wrap: wrap; background:linear-gradient(rgb(9, 199, 220),rgb(108, 205, 140)) ;color: rgb(8, 3, 74);" class="font-h">
      <div class="modal-body" id="query_modal_con">
        
      </div>
     </pre>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<!-- modal con -->

    <script>
        $(document).ready(function () {
            var Table_user_tr = $("#student_data_cont");
            var Table_user_tr2 = $("#student_data_cont2");
       window.load_Notification = function () {
                $.ajax({
                    url: "Notification_backend.php",
                    type: "POST",
                    
                    success: function (data) {
                       var count=0;
                    //    alert(data);
                      Table_user_tr.html(data);
                    //    Table_user_tr.append(data);
                    }
                });

            };
            load_Notification();

          setInterval("load_Notification()",5000); 
        

            $("#student_data_cont").on("click",".read",function(){
                var N_id=$(this).data("id");
                // alert(N_id);
                $.ajax({
                    url:"Notification_backend.php",
                    type:"POST",
                    data:{N_ID:N_id},
                    success:function(data)
                    {
                        if(data==0)
                    {
                        load_Notification();
                    }
                
                    }

                });



            });


           

            $("#student_data_cont").on("click",".view-query",function(){
                var child=$(this).data("query");
                // alert(child);

                $("#query_modal_con").html(child);


            });

            $("#student_data_cont2").on("click",".view-query",function(){
                var child=$(this).data("query");
                // alert(child);

                $("#query_modal_con").html(child);


            });


            window.loadDataOfSignUpUsers=function()
            {
                $.ajax({
                    url:"SignupuserNotificationbkd.php",
                    type:"POST",
                    data:{ADMIN:"ADMIN"},
                    success:function(data){
                        // alert(data+" succes");
                        Table_user_tr2.html(data);
                    },
                    error:function(err){
                        alert(err+" error");
                    }




                });
            };
            loadDataOfSignUpUsers();
            Table_user_tr2.on("click", '.block_stu_rec', function () {
            var id = $(this).data("id1");
            var child = $(this);
          
           
                $.ajax({
                    url: "deleterecord.php", // combine status change with delete file 
                    type: "POST",
                    data: { ID: id, ACTION: 'STATUS' },
                    success: function (data) {
                        if (data == 0) {

                            message("Status Change successfully", "green");
                            loadDataOfSignUpUsers();
                            // load_data(Class.val(),page,Rec_Show.val());
                        }else if(data==1){
                            message("Error occours in server !!","red");
                        }else if(data==402){
                            message("Blocked student can't be unblock by the teacher!! only Admin or Coadmin can unblock his/her. ","red");
                        } else{
                            message(data,"red");
                            
                        }
                    }
                });
            

        });

        });
    </script>

    <?php
}
else {
    echo "<script>window.location.href='index.php';</script>";
}

    ?>