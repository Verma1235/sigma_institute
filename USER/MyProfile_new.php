<?php
session_start();
include"../Chek_required_permission.php";

/* --- GOOGLE DRIVE IMAGE HANDLER --- */
// Logic to determine the image source
$user_img = 'profile1.jpg'; // Default
if (isset($_SESSION['IMG_P']) && !empty($_SESSION['IMG_P'])) {
    $user_img = $_SESSION['IMG_P'];
}

// Check if the image is a Google Drive ID or a local file
// Typically, local files have extensions (like .jpg), Drive IDs are long alphanumeric strings
$is_drive_image = (strlen($user_img) > 20 && strpos($user_img, '.') === false);
$image_src = $is_drive_image ? "download_profile_pic.php?id=" . $user_img : "img/" . $user_img;
?>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        .user_profile_img {
            margin: 3px;
            border-radius: 50%;
            overflow: hidden;
        }
    </style>
</head>

<div class="col-md-8" style="max-width:100%;margin:auto;">
    <br>
    <?php if(isset($_SESSION['NAME'])){ ?>
    <div class="container shadow user_profile p-2">
        <div class="container p-2 ">
            <div class=" d-flex " style="display: flex;justify-content: flex-start;flex-wrap: wrap;">
                
                <div class="col user_profile_img font-h pic_container" 
                     data-bs-toggle='modal' 
                     data-bs-target='#pic_dev' 
                     style='text-align:center;font-size:15px;' 
                     data-ownimg="<?php echo $image_src; ?>">
                    
                    <img width="100px" height="100px"
                        src="<?php echo $image_src; ?>"
                        class="shadow" alt="Profile Image"
                        style="border-radius: 50%; filter:drop-shadow(2px 3px 5px rgb(10, 14, 223)); padding:3px; object-fit:cover;" />
                </div>

                <div class="col mt-1" style="display: flex;justify-content: flex-start;">
                    <div class="sub_col">
                        <div class="btn btn-warning m-2 shadow-lg" data-bs-toggle="modal"
                            data-bs-target="#edit_by_user_modal"><i class="bi bi-pencil"></i> Edit</div>
                        <div class="btn btn-dark m-2 shadow-lg pic_container" 
                             data-bs-toggle='modal' 
                             data-bs-target='#pic_dev' 
                             data-ownimg="<?php echo $image_src; ?>"><i class="bi bi-eye"></i> View</div>
                    </div>
                </div>
            </div>
            <hr>
            
            <div class="font-h"><i class="bi bi-person-circle"></i> &ensp; Name: <i><?php echo $_SESSION['NAME'];?></i></div>
            <div class="font-h"><i class="bi bi-postcard"></i> &ensp; Post: <?php echo $_SESSION['POST'];?></div>
            <div class="font-h"><i class="bi bi-envelope-at"></i>&ensp;<b><?php echo $_SESSION['Email'];?></b></div>
            <div class="font-h"><i class="bi bi-postcard"></i> &ensp;User Id: <?php echo $_SESSION['ID'];?></div>
            
            <?php 
                $STATUS="In Active"; $bg="orange";
                if($_SESSION['ACTIVE_NO']==1){ $STATUS="Active"; $bg="rgb(0, 255, 0)"; }
                else if($_SESSION['ACTIVE_NO']==2){ $STATUS="Blocked"; $bg="red"; }
            ?>
            <div class="font-h"><i class="bi bi-shield-check"></i>&ensp;Status: 
                <b style="background:<?php echo $bg;?>;padding:2px 10px;border-radius: 5px;"><?php echo $STATUS;?></b>
            </div>
        </div>
    </div>
    <?php } else { ?>
        <img width="100%" src="img/sigmabanner.png" style="border-radius:10px;box-shadow:0px 0px 10px 2px white;">
    <?php } ?>
</div>

<div class="modal fade" id="pic_dev" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body" id="pic_modal_con">
          </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function () {
        // Handle viewing the profile picture in modal
        $(".pic_container").on("click", function(){
            var imgSrc = $(this).data("ownimg");
            $("#pic_modal_con").html("<img src='"+imgSrc+"' width='100%'/>");
        });

        // Update Profile AJAX
        $("#update_profile_btn").on("click", function () {
            var formData = new FormData($("#Profile_form")[0]);
            
            $.ajax({
                url: "USER/edit_profile_handeler_backned.php", // This backend should handle Drive Upload
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (newFileId) {
                    if (newFileId != 1) {
                        message("Profile Updated Successfully", "green");
                        location.reload(); // Refresh to show new Drive image
                    } else {
                        message("Update failed", "red");
                    }
                }
            });
        });
    });
</script>