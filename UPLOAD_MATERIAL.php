<?php
session_start();
if(isset($_SESSION['ADMIN']) ||  isset($_SESSION['COADMIN']) ||  isset($_SESSION['TEACHER']))
{
?>

<head>
  <style>
    h1 {
      font-size: 20px;
      margin-top: 24px;
      margin-bottom: 24px;
    }

    img {
      height: 60px;
    }
  </style>
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
  <center>
    <h3 class='font-h'>Upload Study Material</h3>
  </center>
  <div class="container shadow-lg p-2 ">
    <form class="font-h" id="Submit_form">
      <div class="form-group">
        <label for="CHAPTER_NAME">Chapter Name</label>
        <input type="text" name="chapter_name" class="form-control" id="CHAPTER_NAME"
          placeholder="Enter chapter or Unit name" required="required">
      </div>
      <div class="form-group">
        <label for="CHAPTER_NO">Chapter</label>
        <input type="number" name="ch_no" class="form-control" id="CHAPTER_NO"
          placeholder=" Enter chapter or Unit name" required="required">
      </div>
      <div class="form-group">
        <label required="required">Subject </label>
        <select class="form-control" name="subject" id="SUBJECT">
          <option value="PHYSICS">Physics</option>
          <option value="CHEMISTRY">Chemistry</option>
          <option value="BIOLOGY">Biology</option>
          <option value="SCIENCE">Science</option>
          <option value="ENGLISH">English</option>
          <option value="MATHEMATICS">Mathematics</option>
          <option value="COMPUTER SCIENCE">Computer Science</option>
          <option value="SOCIAL SCIENCE">Social science</option>
          <option value="HINDI">Hindi</option>
          <option value="OTHER">Other</option>

        </select>
      </div>
      <div class="form-group">
        <label for="exampleFormControlSelect1">Class: </label>
        <select class="form-control" name="Class" id="CLASS" required="required">
          <option value="0">All</option>
          <!-- <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option> -->
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
        </select>
      </div>
      <div class="form-group mt-3">
        <label class="mr-2">Description</label>
        <textarea type="text" class="form-control" name="Dis" placeholder="write description about topic.."
          id="DESCRIPTION"></textarea>
      </div>
      <hr>

      <div class="form-group mt-3">
        <label class="mr-2">Upload file:</label>
        <input type="file" name="file" id="FILE_UPLOADED" class="form-control">
      </div>
      <div class="progress" role="progressbar" aria-label="Success striped example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
    <div class="progress-bar progress-bar-striped bg-success" style="width: 0%" id="ProgressBar"></div>
  </div>
<div class="badge text-bg-success text-wrap m-2" style="width: 15rem;" id="success_upload">
  ! File successfully uploaded !
</div>
<div class="badge text-bg-danger text-wrap m-2" style="width: 15rem;" id="unsuccess_upload">
  ! File not uploaded ! Sorry
</div>
<div class="badge text-bg-warning text-wrap m-2" style="width: 15rem;" id="process_upload">
    Process in pending please Wait !! file Uploading....
</div>

      
      <hr>
      <button type="submit" name="button" class="btn btn-success form-control" id="STUDY_MATERIAL_UPLOAD">Upload</button>
    </form>
  </div>
</div>
<?php }else{
  echo "<script>window.location.href='index.php';</script>";
}?>
<script>
  $(document).ready(() => {
    $("#success_upload").hide();
    $("#unsuccess_upload").hide();
    $("#process_upload").hide();
    $("#Submit_form").on("submit", function(e) {
      // alert("click work")
      e.preventDefault();
      // var this_selector=$(this);
      var formData = new FormData($('#Submit_form')[0]);
      var C_name = $("#CHAPTER_NAME");
      var C_Descr = $("#DESCRIPTION");
      var Class = $("#CLASS");
        var File=$('#FILE_UPLOADED');
      var Subject = $("#SUBJECT");
      var c_no = $("#CHAPTER_NO");

      if (C_name.val() != "" && C_Descr.val() != "" && c_no.val() != "" && File.val()!="" && File.val()!=null && c_no.val()>0) {
        // alert("value chek work");
      
       
        
        // alert("file get work");
        $.ajax({
          xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        
                        $("#ProgressBar").width(percentComplete + '%');
                        $("#ProgressBar").html(parseInt(percentComplete)+'%');
                        $("#process_upload").show(200);
                        $("#process_upload").html("Uploading..");
                        $("#success_upload").hide();
                        $("#unsuccess_upload").hide();
                        $("#STUDY_MATERIAL_UPLOAD").hide(200);
                         $("#process_upload").html("Uploading.....");
                          $("#process_upload").html("Uploading........");
                          if(parseInt(percentComplete)>99){
                            $("#process_upload").html("!! Process in pending please Wait !! file recombine !!");
                          }
                       
                    }
                }, false);
                return xhr;
            },
          url: "Upload_study_material_backend.php",
          type: "POST",
          data:formData, 
          beforeSend: function(){
                $("#ProgressBar").width('0%');
                $("#success_upload").hide();
               $("#unsuccess_upload").hide();
                $("#process_upload").hide();
                $("#STUDY_MATERIAL_UPLOAD").show(200);
                // $('#uploadStatus').html('<img src="images/loading.gif"/>');
            },
          contentType: false,
          processData: false,
          success: function (data) {
            // alert("return work "+data);
            $("#STUDY_MATERIAL_UPLOAD").show(200);
            if (data == 0) {
              $("#process_upload").hide();
              message("!! file uploaded successfully !!", "green");
              $("#success_upload").show(300);
              $("#unsuccess_upload").hide();
              $("#process_upload").hide();
              $("#Submit_form")[0].reset();
              $("#process_upload").html("!Process Completed !");
              // $("#ProgressBar").width(0 + '%');
            } else if(data==3) {
              message("! Please select a file !", "red");
              $("#success_upload").hide();
            $("#unsuccess_upload").hide();
              $("#process_upload").hide();
            }else if(data==1){
              message("File not Uploaded !! Server issue ! Sorry","red");
              $("#unsuccess_upload").show(300);
              $("#unsuccess_upload").html(" ! file not Uploaded ! Unsuccessfull");
              $("#success_upload").hide();
              $("#process_upload").hide();
              $("#process_upload").html("!Process Completed !");
            }
            else if(data==2){
              message("Valid format ('pdf','png','jpg','jpeg')(Please select valid format file.) !","red");
            }else if(data==4){
              message("Access Denied","red");
              $("#success_upload").hide();
              $("#unsuccess_upload").show(200);
             $("#unsuccess_upload").html("Access denied by Admin to upload files.");
            $("#process_upload").hide();
            $("#process_upload").html("!Process Completed !");
          
            }else{
              message("server Issue !! Please leave this plateform Temporary !","red");
              $("#unsuccess_upload").show(200);
              $("#unsuccess_upload").html(" !! Server Error !! Sorry ");
              $("#success_upload").hide();
              $("#process_upload").hide();
              $("#process_upload").html("!Process Completed !");
            }

          }
        });


        // CHAPTER_NAME: C_name.val(), CLASS: Class.val(), CHAPTER_NO: c_no.val(), DESCRIPTION: C_Descr.val(), SUBJECT: Subject.val() }



      } else {
        // alert("chek else part");
        if(c_no.val()<=0){
          message("Incorrect Chapter number!","red");
        }else{
        message("Please Enter sufficient information ! So, All filed are Required ", "red");
        }
      }




    })

  });

</script>
