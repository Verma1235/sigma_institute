<?php
session_start();
include"../Chek_required_permission.php";
?>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="jquery.js"> </script>
    <style type="text/stylesheet">
        .user_profile_img{
            margin: 3px;
            border-radius: 50%;
            overflow: hidden;
            background: red;
        }

        </style>
</head>
<div class="col-md-8" style="max-width:100%;margin:auto;">
    <!-- <a target="_blank" href="https://getform.io?ref=codepenHTML">
          <img src='https://i.imgur.com/O1cKLCn.png'>
        </a> -->
    <br>
    <!-- <a target="_blank" href="https://getform.io?ref=codepenHTML" class="mt-3 d-flex">Getform.io |  Get your free endpoint now</a> -->
    <!-- <h3 class='font-h'> My Profile </h3> -->
    <?php
        if(isset($_SESSION['NAME'])){
       ?>
    <div class="container shadow user_profile p-2">
        <div class="container p-2 ">
            <div class=" d-flex " style="display: flex;justify-content:  flex-start;flex-wrap: wrap;">
                <div class="col user_profile_img font-h pic_container" data-bs-toggle='modal' data-bs-target='#pic_dev' style='text-align:center;font-size:15px; ' data-ownimg="<?php if(isset($_SESSION['IMG_P'])){ echo $_SESSION['IMG_P'];}else{echo 'profile1.jpg';} ?>"><img width="100px"
                        height="100px"
                        src="img\<?php if(isset($_SESSION['IMG_P'])){ echo $_SESSION['IMG_P'];}else{echo 'profile1.jpg';};?>"
                        class="shadow" alt="No any image uploaded"
                        style="border-radius: 50%;filter:drop-shadow(2px 3px 5px rgb(10, 14, 223));padding:3px;object-fit:cover;" />
                </div>
                <div class="col mt-1" style="display: flex;justify-content: flex-start;">
                    <?php
                        if(isset($_SESSION['NAME'])){
                       ?>
                    <div class="sub_col " style="">

                        <div class="btn btn-warning m-2 shadow-lg" data-bs-toggle="modal"
                            data-bs-target="#edit_by_user_modal"><i class="bi bi-pencil"></i> Edit</div>
                        <div class="btn btn-dark m-2 shadow-lg pic_container"  data-bs-toggle='modal' data-bs-target='#pic_dev'  data-ownimg="<?php if(isset($_SESSION['IMG_P'])){ echo $_SESSION['IMG_P'];}else{echo 'profile1.jpg';} ?>"><i class="bi bi-eye"></i> view</div>
                        <!-- <div class="font-h">Alok Soni</div>
                            <div class="font-h">Post: Coadminhggftyftyf</div> -->

                    </div>
                    <?php } ?>

                    <!-- <div class="btn btn-secondary " style="min-width:50px;overflow: scroll;height: 40px;"></div> -->
                </div>

            </div>
            <hr>
            <div class="" style="display: block;flex-wrap: wrap;"
                style="width: 320px; background: rgb(220, 170, 170);overflow: hidden;">
                <div class="font-h " style="width: 100%;display: flex;"><i class="bi bi-person-circle "></i> &ensp;
                    Name:
                    <i id="name_view">
                        <?php echo $_SESSION['NAME'];?>
                    </i>
                </div>
                <div class="font-h " style="width: 100%;display: flex;"><i class="bi bi-postcard"></i> &ensp; Post:
                    <?php echo $_SESSION['POST'];?>
                </div>
                <div class="font-h "
                    style="width: 100%;display: flex;overflow: hidden;justify-content: flex-start;flex-wrap: nowrap;"><i
                        class="bi bi-envelope-at"></i>&ensp;<b style="min-width: 200px;">
                        <?php echo $_SESSION['Email'];?>
                    </b></div>
                <div class="font-h " style="width: 100%;display: flex;"><i class="bi bi-postcard"></i> &ensp;User Id:
                    <?php echo $_SESSION['ID'];?>
                </div>
                <?php 
                    $STATUS="In Active";
                    $bg="orange";

                    if($_SESSION['ACTIVE_NO']==0){
                        $STATUS="In Active";

                    }else if($_SESSION['ACTIVE_NO']==1){
                        $STATUS="Active";
                        $bg="rgb(0, 255, 0)";
                    }else{
                        $STATUS="Blocked";
                        $bg="red";
                    }

                    ?>
                <div class="font-h " style="width: 100%;display: flex;"><i class="bi bi-shield-check"></i>&ensp;Status:
                    <b
                        style="background:<?php echo $bg;?>;padding:2px 10px;border-radius: 5px;color: rgb(68, 4, 4);margin:0px 5px;">
                        <?php echo  $STATUS;?>
                    </b>
                </div>
            </div>
            <hr>

        </div>
        <div class="container mt-2">

        </div>

    </div>

</div>

<?php } 
        
      else{?>

<img width="100%" height="auto"
    src="img/sigmabanner.png" alt="Image not found ...." style="border-radius:10px;box-shadow:0px 0px 10px 2px white;">


<?php } ?>
<br>
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Launch static backdrop modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="edit_by_user_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"> Update Profile </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="profile-info">
                    <form id="Profile_form">
                        <div class="info-item">
                            <label for="section" class="font-h">Set a profile photo:</label>
                            <input type="file" name="p_img" id="p_img" class="form-control"
                                placeholder="Change your email... ">
                        </div>
                        <div class="progress m-3" role="progressbar" aria-label="Success striped example" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-striped bg-success" style="width: 0%"
                                id="ProgressBar"></div>
                        </div>
                        <div class="info-item">
                            <label for="name" class="font-h">Name:</label>
                            <input id="name" type="name" name="Name" class="form-control"
                                value="<?php echo $_SESSION['NAME'];?>" placeholder="Change your name...">
                        </div>
                        <div class="info-item">
                            <label for="id_updat" class="font-h">USER ID:</label>
                            <input id="id_updat" type="text" name="ID" class="form-control"
                                value="<?php echo $_SESSION['ID'];?>" placeholder="Change your name..." readonly>
                        </div>

                        <div class="info-item">
                            <label for="number" class="font-h">Phone:</label>
                            <input id="number" name="phone" type="tel" class="form-control"
                                value="<?php if(isset($_SESSION['PHONE'])){echo $_SESSION['PHONE'];}else{}?>"
                                placeholder="Enter phone no....">

                        </div>
                        <div class="info-item">
                            <label for="section" class="font-h">Email:</label>
                            <input id="email" type="email" name="email" class="form-control"
                                value="<?php echo $_SESSION['Email'];?>" placeholder="Change your email... " readonly
                                disabled>
                        </div>
                        <div class="info-item">
                            <div style="height: 300px; width: 300px;margin: 5px;border-radius: 8px;"
                                id="uploaded_profile">

                            </div>
                        </div>
                        <button type="button" class="btn btn-success" id="update_profile_btn">Update
                            change</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" type="submit" class="btn btn-success">Update change</button> -->
            </div>

        </div>
    </div>
</div>
<hr>
<div class="modal fade" id="pic_dev" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Profile Picture</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="pic_modal_con">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<?php 
$sql_students="SELECT * FROM `studenttable` WHERE `POST`='STUDENT' and `DELETE_AC`='0';";
$sql_files="SELECT * FROM `study_material`";
$sql_teacher="SELECT * FROM `studenttable` WHERE ((`POST`='TEACHER' or `POST`='ADMIN' or `POST`='COADMIN') and (`DELETE_AC`='0'));";

$res1=mysqli_num_rows(mysqli_query($conn,$sql_students));
$res2=mysqli_num_rows(mysqli_query($conn,$sql_files));
$res3=mysqli_num_rows(mysqli_query($conn,$sql_teacher));
?>


<div class="container " style="display:flex; justify-content: space-evenly;flex-wrap: wrap;align-items: center;">
    <div class="card m-2 shadow" style="width: 15rem;background:linear-gradient(to right,rgb(17, 206, 235),rgb(64, 241, 117));">
      <div class="card-body">
      <center><h1 class="card-title font-h mt-2 mb-2" style="height: 50%; width: 70%;"><i class="bi bi-person-fill-lock fs-1" style="color:green;filter:drop-shadow(1px 2px 1px black)"></i></h1></center>
        <center><h1 class="card-title font-h mt-2 mb-2" style="height: 50%; width: 70%;"><?php echo $res1; ?></h1></center>
        <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
        <center><h3 href="#" class="font-h"> Total Students </h3></center>
      </div>
    </div>
    
    <div class="card m-2 shadow" style="width: 15rem;background:linear-gradient(to right,rgb(235, 228, 17),rgb(64, 241, 117));">
        <div class="card-body">
        <center><h1 class="card-title font-h mt-2 mb-2" style="height: 50%; width: 70%;"><i class="bi bi-joystick fs-1" style="color:white;filter:drop-shadow(1px 2px 1px black);font-size:20px"></i></h1></center>
          <center><h1 class="card-title font-h mt-2 mb-2" style="height: 50%; width: 70%;"><?php echo $res3; ?></h1></center>
          <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
         <center><h3 href="#" class="font-h"> Total Teachers </h3></center>  
        </div>
      </div>

      <div class="card m-2 shadow" style="width: 15rem;background:linear-gradient(to right,rgb(17, 206, 235),rgb(241, 64, 229));">
        <div class="card-body">
        <center><h1 class="card-title font-h mt-2 mb-2" style="height: 50%; width: 70%;"><i class="bi bi-person-fill-lock fs-1" style="color:pink;filter:drop-shadow(1px 2px 1px black)"></i></h1></center>
          <center><h1 class="card-title font-h mt-2 mb-2" style="height: 50%; width: 70%;"><?php echo $res1+$res3; ?></h1></center>
          <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
          <center><h3 href="#" class="font-h"> Total Users </h3></center>  
        </div>
      </div>

      <div class="card m-2 shadow" style="width: 15rem;background:linear-gradient(to right,rgb(17, 235, 206),rgb(241, 64, 182));">
        <div class="card-body">
        <center><h1 class="card-title font-h mt-2 mb-2" style="height: 50%; width: 70%;"><i class="bi bi-file-earmark-text-fill fs-1" style="color:orange;filter:drop-shadow(1px 2px 1px black)"></i></h1></center>
          <center><h1 class="card-title font-h mt-2 mb-2" style="height: 50%; width: 70%;" id="NO_PDF_FILES"><?php echo $res2; ?></h1></center>
          <!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
          <center><h3 href="#" class="font-h"> Total files</h3></center> 
        </div>
      </div>
  </div>
<div class="container-fluid" style="max-width:800px" id="contact"></div>
<br>
<hr>

<script>
    $(document).ready(function () {


        $('#contact').load('tailwind/index.html');
        $("#uploaded_profile").css("height", "0px");


        $("#update_profile_btn").on("click", function () {

            var profile_img = $("#p_img")[0].files[0];
            var formData = new FormData();
            formData.append('name', $("#name").val());
            formData.append('phone', $("#number").val());
            formData.append('ID', $("#id_updat").val());
            if (profile_img) {

                formData.append('file', profile_img);

                $.ajax({
                    url: "USER/edit_profile_handeler_backned.php",
                    xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                   xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        
                        $("#ProgressBar").width(percentComplete + '%');
                        $("#ProgressBar").html(parseInt(percentComplete)+'%');
                        // $("#process_upload").show(200);
                        // $("#process_upload").html("Uploading..");
                        // $("#success_upload").hide();
                        // $("#unsuccess_upload").hide();
                        // $("#STUDY_MATERIAL_UPLOAD").hide(200);
                        //  $("#process_upload").html("Uploading.....");
                        //   $("#process_upload").html("Uploading........");
                          if(parseInt(percentComplete)>99){
                            message("!! Process in pending please Wait !! profile picture recombine !!","orange");
                          }
                       
                    }
                }, false);
                return xhr;
            },
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        // alert(data);
                        if (data == 1) {
                            message("Only png, jpg and jpeg files are allowed !!", "red");
                        } else {
                            $("#name_view").html($("#name").val());
                            $("#uploaded_profile").css("height", "100px");
                            var html = '  <img src="' + 'img/' + data + '" style="height: 100%;width: 100%;object-fit:contain;"/>';
                            var p_img = '<img width="100px" height="100px" src = "img/' + data + '" class="shadow" style = "border-radius: 50%;filter:drop-shadow(2px 3px 5px rgb(10, 14, 223));padding:3px;object-fit:cover;"/> ';
                            $(".user_profile_img").html(p_img);
                            $("#uploaded_profile").html(html);
                            $("#update_profile_btn").show(200);
                            message("Uploaded successfully","green");
                            $("#p_img").val("");

                        }
                    },
                    error: function (err) {
                        message("Somthing went wrong!" + err, "red");

                    }
                });
            }
            else {

                $.ajax({
                    url: "USER/edit_profile_handeler_backned.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        // alert(data);
                        if (data == 1) {
                            $("#name_view").html($("#name").val());
                            message("Updated successfully !");
                            $("#update_profile_btn").hide(200);
                            $("#update_profile_btn").show(200);
                        } else {
                            message("Somthing went wrong !", "red");
                        }
                    },
                    error: function (err) {
                        message("Somthing went wrong!" + err, "red");

                    }
                });
            }



        });


        $(".pic_container").on("click",function(){
            var pic=$(this).data("ownimg");
            
            $("#pic_modal_con").html("<img src='img/"+pic+"' width='100%'/>");
        });


    });
</script>