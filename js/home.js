
$(document).ready(function () {
    $("#login").hide();
    $("#signup").hide();
    $("#information_box").hide();

    $("#login-form-close-btn").on("click", () => {
        $("#login").hide();
        $("#signup").hide();

    });

    $("#sign-form-close-btn").on("click", () => {
        $("#signup").hide();
        $("#login").hide();

    });

    $(".login-btn").on("click", () => {
        $("#login").show();
        $("#signup").hide();
    });

    $(".signup-btn").on("click", () => {
        $("#login").hide();
        $("#signup").show();
    });

    window.signup = function () {
        $(".signup-btn").on("click", () => {
            $("#login").hide();
            $("#signup").show();
        });
    }

    var turn = true;
    $(".menu-container").on("click", () => {

        if (turn == true) {
            $(".sidebar-container").css('transform', "translateX(0px)");
            turn = false;
        } else {
            $(".sidebar-container").css('transform', "translateX(300px)");
            turn = true;
        }
    });
    $(".main-screen").on("click", () => {

        if (turn == false) {
            $(".sidebar-container").css('transform', "translateX(300px)");
            turn = false;
        }
    });

    $(".admission-form-apply").on("click", () => {
        $("#Dynamic-screen").load("Admissionform.php");

    });
    $(".studentTable").on("click", () => {
        $("#Dynamic-screen").load("studentTable.php");

    });
    $(".Admin_coAdmin_file").on("click", () => {
        $("#Dynamic-screen").load("Admin_Coadmin.php");
        // $("#Dynamic-screen").load("USER/MyProfile.php");
    });
    // $("#Dynamic-screen").load("studentTable.php");
    $("#Dynamic-screen").load("USER/MyProfile.php");
    $(".logout-btn").on("click", () => {
        window.location.href = "logout.php";

    });

    $(".Study_material").on("click", () => {
        $("#Dynamic-screen").load("study_material.php");


    });

    $(".upload_material").on("click", () => {
        $("#Dynamic-screen").load("UPLOAD_MATERIAL.php");


    });

    $(".myprofile").on("click", () => {
        $("#Dynamic-screen").load("USER/MyProfile.php");


    });

    $(".addmission_req").on("click", () => {
        $("#Dynamic-screen").load("admission_request_fronted.php");


    });

    $(".admin_settings").on("click", () => {
        $("#Dynamic-screen").load("USER/settings.php");
        // alert("working")


    });
    // $(".notification-pannel").on("click", () => {
    //     alert()
    //     $("#Dynamic-screen").load("Notification_fronted.php");


    // });
    // $("#Dynamic-screen").load("studymaterial_fronted_show.php");

    // $("#information_box").delay(1000).hide(500);
    // $("#information_box").delay(2000).show(500);
    $(".manageTeacher").on("click", () => {
        $("#Dynamic-screen").load("manage_teacher.php");

    });

    $(".deleted_account").on("click", () => {
        $("#Dynamic-screen").load("Deleted_account.php");

    });

    $(".video_rec_lec").on("click", () => {
        $("#Dynamic-screen").load("recorded_files.php");

    });

    window.message = function (data, bg_color) {
        $("#info_cont").html(data);
        $("#information_box").css("background", bg_color);
        $("#information_box").delay(100).show(500);
        $("#information_box").delay(3000).hide(500);

    }

    $(".del_stu_record").on("click", () => {
        var id = $(this).data("id");
        alert(id);
    });


    function delete_rec(id) {
        alert(id);
    }




});