<?php
session_start();
include"Chek_required_permission.php";
if(isset($_SESSION['ADMISSION_STATUS'])){
if(($Status==1 || $Status==0)){
  if($_SESSION['ADMISSION_STATUS']==0){
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admission form</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <style type="text/css">
    /* *{
        margin:0px;
        padding:0px;
        } */
    #admission_box {
      height: auto;
      position: relative;
      width: auto;
      display: block;
      align-items: center;
      justify-content: center;
      box-sizing: border-box;
    }

    #admission_form {
      width: 100%;
      height: auto;
      color: white;
      display: flex;
      align-items: center;
      justify-content: space-evenly;
      position: relative;
      box-sizing: border-box;
    }

    fieldset {
      min-height: 100px;
      padding: 20px;
      border: 2px solid white;
      margin: 2px;
      filter: drop-shadow(-2px 1.5px 1.5px black);
      border-radius: 4px;
      background: linear-gradient(to right bottom, #199696, #5b9292);

    }

    #container_admission {

      display: flex;
      flex-wrap: wrap;
      justify-content: space-evenly;


    }

    fieldset div {
      margin: 5px 2px;
    }

    #head {
      font-size: 20px;
      font-family: sans-serif;
      font-weight: bolder;
      margin: 5px;
      color: yellow;
      filter: drop-shadow(-2px 1.5px 1.5px black);

    }

    .filed {
      font-size: 20px;
      font-weight: 500;
      filter: drop-shadow(-2px 1.5px 1.5px black);
      font-family: "Josefin Sans", sans-serif;
      font-optical-sizing: auto;
      font-weight: 700;
      font-style: normal;
    }

    /* .input_filed {
        width:260px;
        height:30px;
        margin:2px 5px;
        font-size:19px;
        padding:5px;
        color:lightseagreen;
        filter:drop-shadow(1px 1px 2px purple);
        border-radius:3px;
        border:none;
        }
        .input_filed::placeholder{
        font-weight:lighter;
        color:lightseagreen;
        }
        textarea::placeholder,textarea {
        font-weight:lighter;
        color:lightseagreen;
        font-size:14px;
        } */
    .btn_sub_cl {
      height: 35px;
      margin: 5px 10px;
      font-size: 18px;
      padding: 2px 15px;
      font-weight: bolder;
      border: none;
      background: blue;
      color: white;
      border-radius: 5px;
    }

    /* #admission_off {
        position:fixed;
        right:10px;
        top:-20px;
        font-size:55px;
        color:red;
        filter:drop-shadow(1px 1px 2px purple);
        
        } */
  </style>
</head>

<body>
  <div class="container">
    <center>
      <h3 class="font-h">Admission Form</h3>
    </center>
  </div>

  <div id="admission_box">
    <div class="container" style="max-width: 800Px;">


      <form class="font-h mb-3" id="form_submition">
        <div class="mb-3">
          <label class="form-label">Full Name</label>
          

            <?php if(isset($_SESSION['NAME']) ){ 
            if(isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN']) || isset($_SESSION['TEACHER'])){
              ?>
                <input type="text" class="form-control" placeholder="Enter student's Name" name="FullName" id="FullName"
                required>
           <?php }else{
            ?>
            
            <input type="text" class="form-control" value="<?php echo $_SESSION['NAME']?>" placeholder="Enter student's Name" name="FullName" id="FullName"
            required readonly>
          <?php } }?>
         
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Registered Account Id</label>
          <?php if(isset($_SESSION['ID']) ){ 
            if(isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN']) || isset($_SESSION['TEACHER'])){
              ?>
                <input type="text" class="form-control" id="SignUpId"  name="SignUpId" 
                value="" placeholder="Registered Id Ex. SIGMA012345" required pattern="([SIGMA]*[0-9]){4,}">
           <?php }else{
            ?>
            
          <input type="text" class="form-control" id="SignUpId"  name="SignUpId" readonly
            value="<?php echo $_SESSION['ID'];?>" placeholder="Registered Id">
          <?php } }?>
        </div>
        <div class="mb-3">
          <label class="form-label">Father Name</label>
          <input type="text" class="form-control" placeholder="Enter student's Father name.." name="FatherName"
            id="FatherName" required>

        </div>
        <div class="mb-3">
          <label class="form-label">Date of Birth</label>
          <input type="date" class="form-control" placeholder="DOB" id="DOB" name="DOB" required>

        </div>
        <div class="mb-3">
          <label class="form-label">Gender:</label>
         
          <input class="" type="radio" name="gender" value="Male"  id="gender" required> Male
          <input class="" type="radio" name="gender"  value="Female" id="gender" required> Female
        </div>
        <div class="mb-3">
          <label class="form-label">Phone no</label>
          <input type="tel" class="form-control" placeholder="Enter 10 digits Phone number.." id="PhoneNo"
            name="PhoneNo" pattern="[0-9]{10,10}" required>

        </div>
        <div class="mb-3">
          <label class="form-label">Student's Adhar Number</label>
          <input type="tel" class="form-control" placeholder="Enter 12-digits Adhar number.." id="AdharNumber"
            name="AdharNumber" pattern="[0-9]{12,12}" required>

        </div>
        <div class="mb-3">
          <label class="form-label">State</label>
          <select class="form-control" id="State" name="State">
            <option value="JHARKHAND">Jharkhand</option>
          </select>

        </div>
        <div class="mb-3">
          <label class="form-label">District</label>
          <select class="form-control" name="District" name="District">
            <option value="CHATRA">Chatra</option>
            <option value="HAZARIBAGH">Hazaribagh</option>
          </select>

        </div>
        <div class="mb-3">
          <label class="form-label">Parmanent Address</label>
          <textarea class="form-control" placeholder="Enter full Address" name="FullAddress"
            id="FullAddress"></textarea>

        </div>
        <div class="mb-3">
          <label class="form-label">Upload Identity Proof</label>
          <input type="file" class="form-control" required id="Identityproof" name="Identityproof">

        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" required id="Termcondition" name="Termcondition">
          <label class="form-check-label" for="exampleCheck1">I accept all <mark>Term</mark> and <mark>condition </mark>
            and also Verified All details</label>
        </div>
        <button type="submit" class="btn btn-success font-h drop-shadow mb-3" name="Pay" id="Pay">Submit now
          </button>
            <div class="progress mt-2" role="progressbar" aria-label="Success striped example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar progress-bar-striped bg-success" style="width: 0%" id="ProgressBar"></div>
            </div>
           <center> <div class="badge text-bg-success text-wrap m-2" style="width: 15rem;" id="success_upload">
              ! File successfully uploaded !
            </div>
            <div class="badge text-bg-danger text-wrap m-2" style="width: 15rem;" id="unsuccess_upload">
              ! File not uploaded ! Sorry
            </div>
            <div class="badge text-bg-warning text-wrap m-2" style="width: 15rem;" id="process_upload">
                Process in pending please Wait !! file Uploading....
            </div></center>
      </form>
      <div class="container">
          
          <button id="pay-button mb-3" class="btn btn-success font-h paynow">Pay Admiision fee<i
            class="bi bi-currency-rupee"></i>500</button>
  
  
        </div>
         <?php }else if(isset($_SESSION['DBMS_ADM_STATUS'])){ 
          $admi_status="";
          if($_SESSION['DBMS_ADM_STATUS']==0){
            $admi_status="Pending";
          }else{
            $admi_status="Completed";
          }
          if($_SESSION['DBMS_ADM_STATUS']==0){
          ?>
            <div class="container">
          
          <button id="pay-button" class="btn btn-success font-h m-3 paynow">Pay Addmission fee<i
          class="bi bi-currency-rupee"></i>500</button>


      </div>
      <div class="container">
        <center>
          <h3 class="font-h p-2" style='background:orange;color:white'>!! Admission  <?php  echo $admi_status; ?></h3>
        </center>
      </div>
      
     

      <?php } else{ ?>
              <div class="container">
          <center>
            <h3 class="font-h p-2" style='background:green;color:white'>!! Admission  <?php  echo $admi_status ?></h3>
          </center>
        </div>
   
   <?php } } else{ ?>

      
  
  <div class="container">
    <center>
      <h3 class="font-h p-2" style='background:green;color:white'>!! Admission  <?php  echo $admi_status; ?></h3>
    </center>
  </div>
        

        <?php } ?>
       
        <?php }else{ ?>


<center>
  <h4 class="font-h" style="color:red;"> !! Access Denied ! you have been blocked !! </h4>
</center>


<?php } }  ?>
    
    </div>
    <script>
      // $(document).ready(function () {

      //   var amount = 500;
      //   var registerd_Id = $("#SignUpId");
      //   const paymentStart = function (a, Id) {

      //     alert("payment started " + a +" Id" + Id.val());


          



      //   };
      //   $("#form_submition").on("submit", (e) => {
      //     e.preventDefault();

      //   paymentStart(amount,registerd_Id);

      //   });



      // });

    </script>
         <head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        </head>
  
    

    <script>
        $(document).ready(function() {

           $("#pay-button").show();
          $("#success_upload").hide();
         $("#unsuccess_upload").hide();
         $("#process_upload").hide();


             $('#form_submition').on("submit",function(e) {
                e.preventDefault();
                var formData = new FormData($('#form_submition')[0]);
                 $.ajax({
                     xhr: function() {
                          var xhr = new window.XMLHttpRequest();
                          xhr.upload.addEventListener("progress", function(evt) {
                              if (evt.lengthComputable) {
                                  var percentComplete = ((evt.loaded / evt.total) * 100);
                                  
                                  $("#ProgressBar").width(percentComplete + '%');
                                  $("#ProgressBar").html(parseInt(percentComplete)+'%');
                                  $("#process_upload").show(200);
                                  $("#success_upload").hide();
                                  $("#unsuccess_upload").hide();
                                  $("#Pay").hide(200);
                                
                              }
                          }, false);
                          return xhr;
                      },
                    url: 'create_new_admission.php',
                    method: 'POST',
                    data:formData,
                    contentType:false,
                    processData:false,
                    success: function(response) {

                      if(response==0){
                        message("!! Addmision data submited successfully !!","green");
                        $("#success_upload").show(300);
                         $("#unsuccess_upload").hide();
                         $("#process_upload").hide();
                         $("#process_upload").html(" ! Process complete !");
                         $("#Pay").show(200);
                        $("#form_submition")[0].reset();

                      }else if(response==5){
                        message("!! Somthing went wrong !!","red");
                        $("#Pay").show(200);
                      
                      }else if(response==3){
                        message("ID proof Uploaded Issue occured","red");
                        $("#Pay").show(200);
                      }else if(response==2){
                        message("file not supportable! only acceptable file type are 'png','pdf','jpg','jpeg' !","red");
                        $("#Pay").show(200);
                      }else if(response==1){
                        message("File not uploaded !! server issue","red");
                        $("#Pay").show(200);
                      }else if(response==6){

                        message("! file uploaded, but data not submitted due to high traffic","red");
                        // $("#Pay").show(200);
                        $("#Pay").show(200);

                      }
                      else if(401)
                      {
                        message("Registration Id is unvalid !! No such students found through this id !! Please enter valid Id !","red");
                        $("#Pay").show(200);
                      }else if(400) {
                        // message("! server issue !","red");
                        // $("#unsuccess_upload").show(200);
                        // $("#unsuccess_upload").html("due to server issue data ! processing has been stoped!");
                        // $("#process_upload").hide();
                        // $("#process_upload").html("! process incompleted !");
                        // $("#Pay").show(200);
                        // alert(response);
                        message("! Admission has been already done !","linear-gradient(to right,rgb(17, 206, 235),rgb(64, 241, 117))");
                        $("#Pay").show(200);

                      }
             
                    }
                  });


                });
        
        
        
              });
              $(".paynow").on("click",function(){
                
                window.location.href="process_payment.php";
                // $.ajax({
                //   url:"process_payment.php",
                //   type:"POST",
                //   success:function(res){
                //     console.log("payment request");
                //     window.location.href=res.payment_url;
                //   },
                //   error:function(xhr, status,error){
                //     console.error("error in payment request",error);
                //   }
                // });
      
                                         });

        


            


    </script>
</body>
</html>




</body>

</html>

