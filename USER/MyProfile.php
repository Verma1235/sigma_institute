<?php
session_start();
include "../Chek_required_permission.php";
?>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="jquery.js"> </script>
    <style>
        /* Professional UI Variables */
        :root {
            --accent-color: #4e73df;
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --glass-white: rgba(255, 255, 255, 0.9);
        }

        .profile-wrapper-full {
            width: 100%;
            padding: 10px;
        }

        .profile-card-custom {
            background: var(--glass-white);
            border-radius: 12px;
            border: 1px solid #e3e6f0;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            overflow: hidden;
            width: 100%;
        }

        .profile-header-bg {
              background: linear-gradient(to right, rgb(17, 206, 235), rgb(64, 241, 117));
            height: 80px;
            width: 100%;
        }

        .user-main-info {
            margin-top: -40px;
            padding: 0 20px 20px 20px;
            text-align: center;
        }

        .img-profile-circle {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            cursor: pointer;
            transition: transform 0.2s;
        }

        .img-profile-circle:hover {
            transform: scale(1.05);
        }

        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            padding: 20px;
            background: #f8f9fc;
            border-top: 1px solid #e3e6f0;
        }

        .data-item {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .data-item i {
            width: 25px;
            color: var(--accent-color);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            width: 100%;
            margin-top: 20px;
        }

        .stat-box {
            padding: 20px;
            border-radius: 10px;
            color: white;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Status Badge Logic */
        .badge-active { background: #1cc88a; color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; }
        .badge-inactive { background: #f6c23e; color: #333; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; }
        .badge-blocked { background: #e74a3b; color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; }
    </style>
</head>

<div class="profile-wrapper-full">
    <?php if(isset($_SESSION['NAME'])){ ?>
        
        <div class="profile-card-custom">
            <div class="profile-header-bg"></div>
            <div class="user-main-info">
                <div class="pic_container" data-bs-toggle='modal' data-bs-target='#pic_dev' 
                     data-ownimg="<?php echo isset($_SESSION['IMG_P']) ? $_SESSION['IMG_P'] : 'profile1.jpg'; ?>">
                    <img src="img/<?php echo isset($_SESSION['IMG_P']) ? $_SESSION['IMG_P'] : 'profile1.jpg'; ?>" class="img-profile-circle shadow">
                </div>
                
                <h4 class="mt-2 mb-0 font-h"><?php echo $_SESSION['NAME'];?></h4>
                <p class="text-muted small mb-3"><?php echo $_SESSION['POST'];?></p>
                
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-sm btn-outline-primary px-3" data-bs-toggle="modal" data-bs-target="#edit_by_user_modal">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-dark px-3 pic_container" data-bs-toggle='modal' data-bs-target='#pic_dev' 
                            data-ownimg="<?php echo isset($_SESSION['IMG_P']) ? $_SESSION['IMG_P'] : 'profile1.jpg'; ?>">
                        <i class="bi bi-fullscreen"></i> View
                    </button>
                </div>
            </div>

            <div class="data-grid">
                <div class="data-item"><i class="bi bi-person"></i> <b>ID:</b> &nbsp; <?php echo $_SESSION['ID'];?></div>
                <div class="data-item text-truncate"><i class="bi bi-envelope"></i> <b>Email:</b> &nbsp; <?php echo $_SESSION['Email'];?></div>
                
                <?php 
                    $status_class = "badge-inactive"; $status_text = "In Active";
                    if($_SESSION['ACTIVE_NO']==1) { $status_class = "badge-active"; $status_text = "Active"; }
                    else if($_SESSION['ACTIVE_NO']>1) { $status_class = "badge-blocked"; $status_text = "Blocked"; }
                ?>
                <div class="data-item">
                    <i class="bi bi-shield-check"></i> <b>Status:</b> &nbsp; 
                    <span class="<?php echo $status_class; ?>"><?php echo $status_text; ?></span>
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

        <div class="stats-grid">
            <div class="stat-box" style="background: linear-gradient(45deg, #4e73df, #224abe);">
                <i class="bi bi-people fs-3"></i>
                <h3 class="mb-0 mt-1"><?php echo $res1; ?></h3>
                <div class="small">Students</div>
            </div>
            <div class="stat-box" style="background: linear-gradient(45deg, #1cc88a, #13855c);">
                <i class="bi bi-person-badge fs-3"></i>
                <h3 class="mb-0 mt-1"><?php echo $res3; ?></h3>
                <div class="small">Teachers</div>
            </div>
            <div class="stat-box" style="background: linear-gradient(45deg, #36b9cc, #258391);">
                <i class="bi bi-person-check fs-3"></i>
                <h3 class="mb-0 mt-1"><?php echo $res1+$res3; ?></h3>
                <div class="small">Total Users</div>
            </div>
            <div class="stat-box" style="background: linear-gradient(45deg, #f6c23e, #dda20a);">
                <i class="bi bi-file-earmark-text fs-3"></i>
                <h3 class="mb-0 mt-1" id="NO_PDF_FILES"><?php echo $res2; ?></h3>
                <div class="small">Resources</div>
            </div>
        </div>

    <?php } else { ?>
        <div class="w-100 text-center">
            <img src="img/sigmabanner.png" class="img-fluid rounded shadow" alt="Welcome">
        </div>
    <?php } ?>

    <div id="contact" class="mt-4 w-100"></div>
</div>

<div class="modal fade" id="edit_by_user_modal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow border-0">
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title font-h">Edit Profile Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="Profile_form">
                    <div class="mb-3">
                        <label class="form-label small font-h">Profile Photo</label>
                        <input type="file" name="p_img" id="p_img" class="form-control">
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar progress-bar-striped bg-success" id="ProgressBar" style="width: 0%"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small font-h">Name</label>
                        <input id="name" type="text" name="Name" class="form-control" value="<?php echo $_SESSION['NAME'];?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small font-h">Phone</label>
                        <input id="number" name="phone" type="tel" class="form-control" value="<?php echo isset($_SESSION['PHONE']) ? $_SESSION['PHONE'] : '';?>">
                    </div>
                    <input type="hidden" id="id_updat" value="<?php echo $_SESSION['ID'];?>">
                    
                    <div id="uploaded_profile" class="text-center mb-3"></div>
                    <button type="button" class="btn btn-primary w-100" id="update_profile_btn">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pic_dev" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center" id="pic_modal_con"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Load external component
        $('#contact').load('tailwind/index.html');

        // Logic for Profile Update (Untouched functionality)
        $("#update_profile_btn").on("click", function () {
            var profile_img = $("#p_img")[0].files[0];
            var formData = new FormData();
            formData.append('name', $("#name").val());
            formData.append('phone', $("#number").val());
            formData.append('ID', $("#id_updat").val());

            var ajaxParams = {
                url: "USER/edit_profile_handeler_backned.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data == 1 && profile_img) {
                        if(typeof message === 'function') message("Only png, jpg and jpeg allowed!", "red");
                    } else if (data == 1 && !profile_img) {
                        $("#name_view").html($("#name").val());
                        if(typeof message === 'function') message("Updated successfully!");
                    } else {
                        // Image upload success
                        $(".img-profile-circle").attr("src", "img/" + data);
                        $("#name_view").html($("#name").val());
                        if(typeof message === 'function') message("Profile Synchronized", "green");
                        $("#p_img").val("");
                    }
                }
            };

            if (profile_img) {
                formData.append('file', profile_img);
                ajaxParams.xhr = function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percent = (evt.loaded / evt.total) * 100;
                            $("#ProgressBar").width(percent + '%').html(Math.round(percent)+'%');
                        }
                    }, false);
                    return xhr;
                };
            }
            $.ajax(ajaxParams);
        });

        // Image Preview Trigger
        $(document).on("click", ".pic_container", function(){
            var pic = $(this).data("ownimg");
            $("#pic_modal_con").html("<img src='img/"+pic+"' class='img-fluid rounded shadow-lg' style='max-height:85vh;'>");
        });
    });
</script>