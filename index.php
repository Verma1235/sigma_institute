<?php
session_start();
include("database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- <script src="https://checkout.razorpay.com/v1/checkout.js"></script> -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sigma Learning</title>
  <link rel="icon" href="img\sigma_icon.jpg" type="image/x-icon" />
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@300;400;500;600;700;800;900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
    rel="stylesheet">
  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
  <script src="js\bootstrap-5.3.3-dist\js\bootstrap.bundle.min.js"></script>

  <!-- icon -->
  <link rel="stylesheet" href="css\bootstrap-icons-1.11.3\font\bootstrap-icons.min.css">

  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="js\bootstrap-5.3.3-dist\css\bootstrap.min.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <style type="text/stylesheet">



  </style>
  <script src="jquery.js"> </script>
  <script type="text/javascript" src="js/home.js"></script>
  <!-- <script type="text/javascript">
    $(document).ready(function () {

      $("#Dynamic-screen").load("study_material.php");
      
    });
  </script> -->

</head>

<body>

  <div class="container-fluid shadow header ">
    <div class="container sub-header1">
      <div class="left-element">

        <div class="logo-container font-h"><img src="img/sigma.png" width="100%" height="45px"
            style="filter:drop-shadow(2px 2px 1px rgb(244, 240, 240));"></div>
      </div>
      <div class="right-element">
        <div class="search-cont">
          <!-- <input type="search" class="form-control header-input-searh" style="box-shadow: none;"
            placeholder="search content...."> -->
        </div>
        <?php if (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN'])) {
          $sql = "SELECT `Read_s` FROM `contact_table` WHERE `Read_s`='0';";
          $res = mysqli_query($conn, $sql);
          $num = mysqli_num_rows($res);
          if ($num > 99) {
            $num = "99+";
          }


          ?>
          <div class="btn  notification-pannel "><i class="bi bi-bell-fill fs-3 shadow p-2 " style='color:lime'><sup
                style='color:yellow' class='font-h'><small id="count_query"><?php echo $num; ?></small></sup></i>
          </div>
        <?php } ?>

        <div class="menu-container"><i class="bi bi-list i"></i></div>
      </div>
    </div>
    <div class="container sub-header2">
      <div class="option-container font-h">
        <div class="option-item"><a href="index.php">Home</a> </div>
        <?php
        if (isset($_SESSION['NAME'])) {
          ?>
          <div class="option-item logout-btn">logout</div>
          <!-- <div class="option-item signup-btn">Apply Admission</div> -->

          <?php
        } else {
          ?>
          <div class="option-item login-btn">Login</div>
          <div class="option-item signup-btn">SignUp</div>
          <?php
        }
        ?>

        <div class="option-item">Contact</div>
        <div class="option-item">Help</div>
        <div class="option-item">Services</div>


      </div>

    </div>

  </div>
  <div class="container-fluid main-screen ">
    <div class="container-fluid form-container  mt-5">

      <div class="sub-form-cont shadow" id="login">
        <center>
          <h2 class="font-h" style="color:green"><i class="bi bi-person-lock i" style="color:green"></i> login</h2>
        </center>
        <span class="close_form" id="login-form-close-btn">&times;</span>
        <form class="font-h">

          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" id="LOGINEMAIL" placeholder="Enter email.."
              aria-describedby="emailHelp" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">

          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" id="LOGINPASSWORD" placeholder="Enter Correct Password"
              value="">
          </div>
          <div class="mb-3 form-check">

            <label class="signup-btn" for="exampleCheck1" style="color:blue;cursor: pointer;"><i
                class="bi bi-check-circle-fill" style="color: green;"></i> Create a new Account</label>
          </div>
          <button type="submit" class="btn btn-success shadow font-h" id="LOGINBTN">Login</button>
        </form>
        <script type="text/javascript">
          $(document).ready(() => {

            var LoginEmail = $("#LOGINEMAIL");
            var LoginPassword = $("#LOGINPASSWORD");
            var LoginBtn = $("#LOGINBTN");

            LoginBtn.on("click", (e) => {

              e.preventDefault();


              if (LoginPassword.val() != "" || LoginEmail.val() != "") {
                function IsEmail(email) {
                  const regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                  if (!regex.test(email)) {
                    return false;
                  }
                  else {
                    return true;
                  }
                }

                if (IsEmail(LoginEmail.val())) {
                  $.ajax({
                    url: "loginbackend.php",
                    type: "POST",
                    data: { LEMAIL: LoginEmail.val(), LPASS: LoginPassword.val() },
                    success: function (data) {

                      if (data == 1) {

                        message("!Email or password is incorrect!", "red");

                        LoginEmail.val("");
                        LoginPassword.val("");
                      } else if (data == 0) {

                        message("login successfully !!", "green");


                        $(document).ready(() => {
                          function redirect() {
                            window.location.href = 'index.php';
                          }
                          redirect().delay(5000);
                        });


                      } else if (data == 420) {
                        message("Your account has been deleted !!,if you want to backup of your account ! you should send a request through contact form,which is given below ! mention (Email,phone and id) and name !!", "red");
                      } else if(data==201){
                        message("TEMPORARY LOGIN DENIED BY INSTITUTE MANAGEMENT TEAM !!", "red");

                      } else {
                        message(" Wrong Email or Password !" + data, "red");

                        LoginEmail.val("");
                        LoginPassword.val("");
                      }
                    }

                  });
                } else {
                  message("Please enter valid Email Id", "red");
                  LoginEmail.val("");
                }

              } else {


                message("All fields are required !!", "orange");

              }
            });



          });

        </script>

      </div>
      <!-- Sign up form -->
      <div class="sub-form-cont shadow" id="signup">
        <center>
          <h2 class="font-h" style="color:green"><i class="bi bi-person-lock i" style="color:green"></i> Sign up</h2>
        </center>
        <span class="close_form" id="sign-form-close-btn">&times;</span>
        <form class="font-h">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" id="SIGNNAME" placeholder="Enter name..">

          </div>
          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" placeholder="Enter Email..." id="SIGNEMAIL"
              aria-describedby="emailHelp" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">

          </div>
          <div class="mb-3">
            <label f class="form-label">Set Password</label>
            <input type="password" id="SIGNSETPASS" class="form-control" placeholder="Set Password...">
          </div>
          <div class="mb-3">
            <label f class="form-label">Conform Password</label>
            <input type="password" id="SIGNCONFPASS" class="form-control" placeholder="Reenter Password...">
          </div>
          <div class="mb-3 form-check">

            <label class="login-btn" for="exampleCheck1" style="color:blue;cursor: pointer;"><i
                class="bi bi-check-circle-fill" style="color: green;"></i> Already have an Account </label>
          </div>
          <button type="submit" class="btn btn-success font-h" id="SIGNUPBTN">Sign up</button>
        </form>
      </div>
      <script type="text/javascript">
        $(document).ready(() => {
          var sign_name = $("#SIGNNAME");
          var sign_email = $("#SIGNEMAIL");
          var sign_pass = $("#SIGNSETPASS");
          var sign_confpass = $("#SIGNCONFPASS");

          var sign_btn = $("#SIGNUPBTN");

          sign_btn.on("click", (e) => {
            e.preventDefault();
            if (sign_name.val() != "" && sign_email.val() != "" && sign_pass.val() != "") {
              function IsEmail(email) {
                const regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!regex.test(email)) {
                  return false;
                }
                else {
                  return true;
                }
              }

              if (IsEmail(sign_email.val())) {

                if (sign_pass.val() == sign_confpass.val()) {


                  // sign_up ajax combine with login .php

                  $.ajax({
                    url: "loginbackend.php",
                    type: "POST",
                    data: { SIGNEMAIL: sign_email.val(), SIGNPASS: sign_pass.val(), SIGNNAME: sign_name.val() },
                    success: function (data) {

                      if (data == 1) {
                        message("server Down !! signup unsucessful ", "orange")
                      } else if (data == 0) {

                        message("Signup successfully !!", "green");


                        $(document).ready(() => {
                          function redirect() {
                            window.location.href = 'index.php';
                          }
                          redirect().delay(5000);
                        });


                      } else {
                        message("!! Use Another email id !! this email is already in use !!!", "orange");
                        // message("server Issue !! Please leave this plateform Temporary !","red");
                        // alert(data);
                        LoginEmail.val("");
                        LoginPassword.val("");
                      }
                    }

                  });






                } else {
                  message("password not match ! Reenter your password !", "red");
                }

              } else {
                message("Please enter valid Email Id", "red");
              }


            } else {
              message("All fields are required !! ", "orange");
              // alert(sign_email.val()+ sign_name.val()+sign_pass.val()+sign_confpass.val())
            }

          });

        });



      </script>





    </div>


    <div class="sidebar-container">
      <div class="container">
        <div class=" font-h">
          <div class="side-option-item"><a href="index.php">Home</a> </div>
          <?php
          if (isset($_SESSION['NAME'])) {
            ?>
            <div class="side-option-item logout-btn">Logout</div>
            <!-- <div class="option-item signup-btn">Apply Admission</div> -->

            <?php
          } else {
            ?>
            <div class="side-option-item login-btn">Login</div>

            <?php
          } ?>
          <div class="side-option-item signup-btn">Sign up</div>
          <div class="side-option-item">Contact</div>
          <!-- <div class="side-option-item">Help</div> -->

          <?php if (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN']) || isset($_SESSION['TEACHER'])) { ?>
            <div class="side-option-item">Send A new Post</div>
            <div class="side-option-item upload_material">Upload Study material</div>
            <div class="side-option-item Study_material">Manage Study Material</div>
            <div class="side-option-item studentTable">Student Table</div>
            <div class="side-option-item  myprofile">My Profile</div>

            <div class="side-option-item  video_rec_lec">Manage videos</div>
            <div class="side-option-item admission-form-apply"> Admission section</div>
            <?php if (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN'])) { ?>

              <div class="side-option-item addmission_req">Admission Request</div>
              <div class="side-option-item studentTable">Student Table</div>
              <div class="side-option-item deleted_account">Deleted Account</div>
              <div class="side-option-item manageTeacher">managment teacher</div>
            <?php } ?>
            <?php if (isset($_SESSION['ADMIN'])) { ?>
              <div class="side-option-item Admin_coAdmin_file">Manage CoAdmin data</div>
              <div class="side-option-item admin_settings">Settings</div>

            <?php } ?>
          <?php } else if (isset($_SESSION['ID'])) {
            ?>
              <div class="side-option-item  myprofile">My Profile</div>

              <div class="side-option-item admission-form-apply">Admission section</div>
              <div class="side-option-item Study_material">Study material</div>
              <div class="side-option-item">setting</div>
          <?php } ?>
          <!-- <div class="side-option-item"></div>
        <div class="side-option-item"></div> -->


        </div>

      </div>

    </div>

    <!-- MAin content start -->

  </div>
  <br><br>
  <div class="container  mt-5 p-3">
    <div class="userdata">
      <!-- <div class="profile font-h"><i class="bi bi-person-circle i"></i>
        <h3 style="display: inline-block;">U<u>ser Profil</u>e</h3>
      </div> -->
      <?php
      if (isset($_SESSION['NAME'])) {
        ?>
        <div style="display: flex;justify-content:flex-start;align-items: center;flex-wrap: wrap;">
          <div class="user_name font-h"><i class="bi bi-person-circle "></i> Name:
            <?php echo $_SESSION['NAME']; ?>
          </div> &emsp;
          <div class="user_name font-h"><i class="bi bi-envelope-at"></i> Email:
            <?php echo $_SESSION['Email']; ?>
          </div>&emsp;
          <!-- <div class="user_name font-h">Phone: +91______________ </div>  -->
          <div class="user_name font-h"><i class="bi bi-signpost-2"></i>Post:
            <?php echo $_SESSION['POST']; ?>
          </div>
          <?php
      } else {
        ?>
          <div style="display: flex;justify-content: space-around;align-items: center;flex-wrap: wrap;">
            <div class="user_name font-h"><i class="bi bi-person-circle "></i> Name: New Guest </div>
            <div class="user_name font-h"><i class="bi bi-envelope-at"></i> Email: newguest_xyz_@gmail.com </div>
            <!-- <div class="user_name font-h">Phone: +91______________ </div>  -->
            <div class="user_name font-h"><i class="bi bi-signpost-2"></i>Post: visiter

            </div>

            <?php
      }
      ?>

        </div>
      </div>
    </div>

    <div class="container-fluid shadow main_view" style="max-width:98%">

      <div class="sub_main_cont2 font-h">
        <ul>
          <?php if (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN']) || isset($_SESSION['TEACHER'])) { ?>
            <li class="list-item signup-btn"><i class="bi bi-caret-right-fill i-color"></i> New Signup</li>
            <li class="list-item admission-form-apply"><i class="bi bi-caret-right-fill i-color"></i> Admission section
            </li>
            <li class="list-item"><i class="bi bi-caret-right-fill i-color"></i> Send A new post</li>
            <li class="list-item upload_material"><i class="bi bi-caret-right-fill i-color"></i> Upload File </li>
            <li class="list-item Study_material"><i class="bi bi-caret-right-fill i-color "></i> Manage files</li>
            <li class="list-item myprofile"><i class="bi bi-caret-right-fill i-color"></i> My profile</li>
            <li class="list-item studentTable"><i class="bi bi-caret-right-fill i-color"></i> Student Table</li>
            <li class="list-item video_rec_lec"><i class="bi bi-caret-right-fill i-color "></i>Video Lectures
            </li>
            <?php if (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN'])) { ?>
              <li class="list-item"><i class="bi bi-caret-right-fill i-color"></i> User Signup data</li>
              <li class="list-item addmission_req"><i class="bi bi-caret-right-fill i-color"></i> Admission Request </li>
              <li class="list-item studentTable"><i class="bi bi-caret-right-fill i-color"></i> Student Table</li>

              <li class="list-item deleted_account"><i class="bi bi-caret-right-fill i-color"></i> Deleted Account </li>

              <li class="list-item manageTeacher"><i class="bi bi-caret-right-fill i-color"></i> Manage Teachers</li>
            <?php } ?>

            <?php if (isset($_SESSION['ADMIN'])) { ?>

              <li class="list-item Admin_coAdmin_file"><i class="bi bi-caret-right-fill i-color"></i> Manage CoAdmin
              </li>
              <li class="list-item admin_settings"><i class="bi bi-caret-right-fill i-color"></i> Settings
              </li>

            <?php } ?>



          <?php } else if (isset($_SESSION['ID'])) { ?>
              <li class="list-item admission-form-apply"><i class="bi bi-caret-right-fill i-color"></i> Admission section
              </li>
              <li class="list-item myprofile"><i class="bi bi-caret-right-fill i-color"></i> My Profile</li>
              <li class="list-item Study_material"><i class="bi bi-caret-right-fill i-color "></i>Study
                materials</li>


          <?php } else { ?>
              <li class="list-item "><i class="bi bi-caret-right-fill i-color"></i> About us</li>
              <li class="list-item "><i class="bi bi-caret-right-fill i-color"></i> Help </li>



          <?php } ?>

        </ul>
      </div>
      <div class="sub_main_cont1" id="Dynamic-screen">


      </div>
    </div>


    <div id="information_box">

      <div class="container font-h" id="info_cont"></div>

    </div>




    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle='modal' data-bs-target='#editModal'>
  Launch demo modal
</button> -->

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5 font-h" id="exampleModalLabel"> Edit Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="font-h">
              <div class="mb-3">
                <label class="form-label">Name</label>
                <?php if (isset($_SESSION['ADMIN'])) { ?>

                  <input type="text" class="form-control" id="EDITNAME" placeholder="Enter name..">
                <?php } else { ?>
                  <input type="text" class="form-control" id="EDITNAME" placeholder="Enter name.." readonly>
                <?php } ?>

              </div>
              <div class="mb-3">
                <label class="form-label">Email address</label>
                <?php if (isset($_SESSION['ADMIN'])) { ?>
                  <input type="email" class="form-control" placeholder="Enter Email..." id="EDITEMAIL"
                    aria-describedby="emailHelp">
                <?php } else { ?>
                  <input type="email" class="form-control" placeholder="Enter Email..." id="EDITEMAIL" readonly
                    aria-describedby="emailHelp">
                <?php } ?>


              </div>
              <div class="mb-3">
                <label class="form-label">ID</label>
                <input type="text" class="form-control" id="EDITID" placeholder="ID can not be changed" readonly>

              </div>
              <div class="mb-3">
                <label class="form-label">Post</label>
                <!-- <input type="text" class="form-control" id="EDITPOST" placeholder="" readonly> -->
                <!-- <select class="form-control font-h" id="EDITPOST">
                  <option value="STUDENT">Student</option>
                  <option value="ADMIN">Admin</option>
                  <option value="COADMIN">Co-Admin</option>
                  <option value="EMPLOYEE">Employee</option>
                  <option value="GUEST">Guest</option>
                </select> -->

                <?php if (isset($_SESSION['ADMIN'])) { ?>
                  <select name="" id="EDITPOST" class="form-control">
                    <span id="temp_post_holder" value="">
                      <option value="STUDENT">Student</option>
                      <option value="ADMIN">Admin</option>
                      <option value="COADMIN">Co-Admin</option>
                      <option value="TEACHER">Teacher</option>
                      <option value="GUEST">Guest</option>
                  </select>
                <?php } else { ?>
                  <select name="" id="EDITPOST" class="form-control" disabled>
                    <option value="STUDENT">Student</option>
                    <option value="ADMIN">Admin</option>
                    <option value="COADMIN">Co-Admin</option>
                    <option value="TEACHER">Teacher</option>
                    <option value="GUEST">Guest</option>
                  </select>
                  <!-- <select name="" id="EDITPOST" class="form-control" hidden>
                    <option value="1">Active</option>
                    <option value="0">not active</option>
                    <option value="2">Blocked</option>
                  </select> -->

                <?php } ?>

              </div>
              <div class="mb-3">
                <label class="form-label">Adhar no.</label>
                <input type="tel" class="form-control" id="EDITADHAR" placeholder="">

              </div>
              <div class="mb-3">
                <label class="form-label">class</label>
                <!-- <input type="text" class="form-control" id="EDITCLASS" placeholder="" readonly> -->
                <select class="form-control font-h" id="EDITCLASS">
                  <option value="0">not selected</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">District</label>
                <input type="text" class="form-control" id="EDITDISTRICT" placeholder="">

              </div>
              <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="text" class="form-control" id="EDITDOB" readonly placeholder="">
                <input type="date" class="form-control" id="EDIT_NEW_DOB" placeholder="">

              </div>
              <div class="mb-3">
                <label class="form-label">Date of Admission/joining</label>
                <input type="text" readonly class="form-control" id="EDITDOA" placeholder="">
                <input type="date" class="form-control" id="EDIT_NEW_DOA" placeholder="">

              </div>
              <div class="mb-3">
                <label class="form-label">Father Name</label>
                <input type="text" class="form-control" id="EDITFATHER" placeholder="">

              </div>
              <div class="mb-3">
                <label class="form-label">Phone no.</label>
                <input type="tel" class="form-control" id="EDITPHONE" placeholder="">

              </div>
              <div class="mb-3">
                <label class="form-label">Village/city</label>
                <input type="text" class="form-control" id="EDITVILLAGE" placeholder="">

              </div>
              <div class="mb-3">
                <label class="form-label">Account </label>

                <?php if (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN'])) { ?>
                  <select name="" id="EDITACTIVE" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">not active</option>
                    <option value="2">Blocked</option>
                  </select>
                <?php } else { ?>
                  <select name="" id="EDITACTIVE_COADMIN" class="form-control" disabled>
                    <option value="1">Active</option>
                    <option value="0">not active</option>
                    <option value="2">Blocked</option>
                  </select>
                  <select name="" id="EDITACTIVE" class="form-control" hidden>
                    <option value="1">Active</option>
                    <option value="0">not active</option>
                    <option value="2">Blocked</option>
                  </select>

                <?php } ?>
              </div>
              <div class="mb-3">
                <label class="form-label">Gender</label>
                <!-- <input type="text" class="form-control" id="EDITGENDER" placeholder="not specified" readonly> -->
                <select id="EDITGENDER" class="form-control">
                  <option value="">not specified</option>
                  <option value="MALE">Male</option>
                  <option value="FEMALE">Female</option>
                </select>

              </div>
              <div class="mb-3">
                <label class="form-label">Parent's Contact</label>
                <input type="text" class="form-control" id="EDITPARENTCONTACT" placeholder="">

              </div>
              <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea type="text" class="form-control" id="EDITADDRESS" placeholder="Address ....">
                </textarea>

              </div>
              <!-- <div class="mb-3">
               <label class="form-label"></label>
                <input type="text" class="form-control" id="" placeholder="">

              </div> -->


              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id="UPDATE_CHANGE_BTN">Update now</button>
              </div>
          </div>
          </form>

        </div>
      </div>




</body>
<!-- jQery -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<!-- popper js -->
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
  integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script> -->
<!-- bootstrap js -->
<script type="text/javascript" src="js/bootstrap.js"></script>
<!-- owl slider -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
</script>
<!-- custom js -->
<script type="text/javascript" src="js/custom.js"></script>
<!-- Google Map -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
</script> -->
<!-- End Google Map -->
<script type="text/javascript">
  $(document).ready(function () {
    // function load_admion_data2() {
    //         $.ajax({
    //             url: "Adminbackend.php",
    //             type: "post",
    //             data: { ADMIN: "ADMIN",COADMIN: "COADMIN" },
    //             success: function (data) {

    //                 $("#student_data_cont").html(data);

    //             }
    //         });

    //     }

    $("#UPDATE_CHANGE_BTN").on("click", (e) => {
      e.preventDefault();
      // alert($("#EDIT_NEW_DOA").val());
      // alert($("#EDIT_NEW_DOB").val());
      // alert($("#EDITADDRESS").val());
      $.ajax({
        url: "update_changes.php",
        type: "POST",
        data: { NAME: $("#EDITNAME").val(), EMAIL: $("#EDITEMAIL").val(), ID: $("#EDITID").val(), POST: $("#EDITPOST").val(), ADDRESS: $("#EDITADDRESS").val(), ADHAR: $("#EDITADHAR").val(), CLASS: $("#EDITCLASS").val(), DISTRICT: $("#EDITDISTRICT").val(), DOA: $("#EDIT_NEW_DOA").val(), DOB: $("#EDIT_NEW_DOB").val(), FATHER: $("#EDITFATHER").val(), PHONE: $("#EDITPHONE").val(), VILLAGE: $("#EDITVILLAGE").val(), ACTIVE: $("#EDITACTIVE").val(), GENDER: $("#EDITGENDER").val(), PARENTCONTACT: $("#EDITPARENTCONTACT").val() },
        success: function (data) {
          if (data == 0) {
            message(" data updated susscessfully ", "green");
            if ($("#EDITPOST").val() != $("#temp_post_holder").val()) {
              load_teacher_data();
              load_admion_data();

            }

            if ($("#EDITPOST").val() == "ADMIN" && $("#EDITPOST").val() == "COADMIN") {
              $("#Dynamic-screen").load("Admin_Coadmin.php");
            }
          } else if (data == 1) {
            message("! SERVER DOWN ! details unchanged oops!", "red");
          } else {
            message("server Issue !! Please leave this plateform Temporary !", "red");
          }
          // alert(data);
          // $("#Dynamic-screen").html(data);
        }
      })

    });



  });

</script>
<script type="text/javascript">
  $(document).ready(function () {

    //   $("#Dynamic-screen").load("study_material.php");
    $(".notification-pannel").on("click", () => {

      $("#Dynamic-screen").load("Notification_fronted.php");


    });

    count = function () {
      $.ajax({
        url: "count_query.php",
        type: "GET",
        success: function (data) {
          $("#count_query").html(data);
          if (data > 99) {
            $("#count_query").html("99+");
          }
        }
      });
    }
    // count();
    setInterval("count()", 3000);



  });


</script>

</html>