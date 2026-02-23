<?php 
session_start();
include"Chek_required_permission.php";
if(isset($_SESSION['LOGIN_ID'])){
?>

<head>
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

    <!--owl slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- font awesome style -->
    <link href="css/font-awesome.min.css" rel="stylesheet" />

    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <script src="jquery.js"> </script>
    <link href="css/style.css" rel="stylesheet" />
    <style type="text/stylesheet">


    </style>
    <!-- <script type="text/javascript" src="js/home.js"></script> -->

</head>
<center>
    <h3 class="font-h">Study Material</h3>
</center>
<div class="container mt-2  p-2 mb-2">
    <div style="display: flex; justify-content: space-between;align-items: center;width: 100%;">


        <div class="right-element">
            <select class="form-control" style="width: fit-content;margin-right: 5px;" id="searchbyNEPID_FILE">
                <option value="CHAPTER_NAME">Pdf Name</option>
                <option value="PDF_ID">PDF ID</option>
                <option value="CHAPTER_NO">Chapter</option>
                <option value="DESCRIPTION">About</option>
                <option value="SUBJECT">Subject</option>

            </select>

            <div class="search-con"><input type="search" class="form-control header-input-search"
                    placeholder="search data" id="search_pdf_input"></div>
            <div class="search-btn2"><button class="form-control header-btn-search-table del_stu_record"><i
                        class="bi bi-search"></i></button>
            </div>
        </div>
        <div class="left-element font-h ">
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
        </div>

    </div>
</div>
<div class=" p-0 " style="margin: auto; max-width: 1000px;">
    <div class="row" id="PDF_CONTAINER">


        <!-- A card of pdf view edit delete or download  -->
        <!-- <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-body card-local">
                    <div class="card-title font-h"><i class="bi bi-caret-right-fill"></i>Current And Electricity </div>
                    <small class="card-title font-h" style="color:brown"><i class="bi bi-caret-right-fill"></i>Chapter:
                        3 </small> <small class="card-title font-h" style="color:brown">||<i
                            class="bi bi-caret-right-fill"></i> Class: 12</small>
                    <p class="card-text font-h " style="color: rgb(22, 4, 107);"><i
                            class="bi bi-caret-right-fill"></i>Topic: With supporting text below as a natural lead-in to
                    <div class="d-flex " style="flex-wrap: wrap;"> <a href="#" class="btn btn-warning m-1 "
                            style="display: flex; justify-content: flex-start; align-items: center; width: fit-content;">
                            <i class="bi bi-pencil fs-5 " style="color:rgb(207, 34, 34);margin-right:5px;"></i>
                            Edit</a>
                        <a href="#" class="btn btn-danger m-1 "
                            style="display: flex; justify-content: flex-start; align-items: center; width: fit-content;">
                            <i class="bi bi-trash fs-5" style="color:rgb(232, 212, 212);margin-right:5px;"></i>
                            Delete</a>
                        <a href="#" class="btn btn-success m-1 shadow"
                            style="display: flex; justify-content: flex-start; align-items: center; width: fit-content;">
                            <i class="bi bi-filetype-pdf fs-5" style="color:rgb(215, 181, 27);margin-right:5px;"></i>
                            View</a>
                        <a href="#" class="btn btn-dark m-1 "
                            style="display: flex; justify-content: flex-start; align-items: center; width: fit-content;">
                            <i class="bi bi-filetype-pdf fs-5" style="color:rgb(215, 181, 27);margin-right:5px;"></i>
                            Download </a>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- A card of pdf view edit delete or download  -->

    </div>
    <!-- Button trigger modal -->
    <!-- <button type="button" class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#Edit_pdf_modal'>
        Launch demo modal
    </button> -->

    <!-- Modal -->
    <div class="modal fade" id="Edit_pdf_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 font-h" id="exampleModalLabel">Edit/View Pdf</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- modal edit body start -->

                    <!-- <a target="_blank" href="https://getform.io?ref=codepenHTML">
                                <img src='https://i.imgur.com/O1cKLCn.png'>
                              </a> -->

                    <!-- <a target="_blank" href="https://getform.io?ref=codepenHTML" class="mt-3 d-flex">Getform.io |  Get your free endpoint now</a> -->

                    <div class="container-fluid shadow-lg p-2 ">
                        <form class="font-h" id="Submit_form">
                            <div class="form-group">
                                <label for="CHAPTER_NO">Pdf ID</label>
                                <input type="text" name="pdf_id" class="form-control" id="PDF_ID_EDIT"
                                    placeholder="uploaded pdf file" required="required" readonly>
                            </div>
                            <div class="form-group">
                                <label for="CHAPTER_NAME">Chapter Name</label>
                                <input type="text" name="chapter_name" class="form-control" id="CHAPTER_NAME"
                                    placeholder="Enter chapter or Unit name" required="required">
                            </div>
                            <div class="form-group">
                                <label for="CHAPTER_NO">Chapter</label>
                                <input type="text" name="ch_no" class="form-control" id="CHAPTER_NO"
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
                                <textarea type="text" class="form-control" name="Dis"
                                    placeholder="write description about topic.." id="DESCRIPTION"></textarea>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="CHAPTER_NO">Pdf File</label>
                                <input type="text" name="pre_file" class="form-control" id="PDF_FILE"
                                    placeholder="uploaded pdf file" required="required" readonly>
                            </div>

                            <div class="form-group mt-3">
                                <label class="mr-2">Change file:</label>
                                <input type="file" name="file" id="FILE_UPLOADED" class="form-control">
                            </div>
                            <div class="progress" role="progressbar" aria-label="Success striped example"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-striped bg-success" style="width: 0%"
                                    id="ProgressBar"></div>
                            </div>
                            <div class="badge text-bg-success text-wrap m-2" style="width: 15rem;" id="success_upload">
                                ! Data updated successfully ! !
                            </div>
                            <div class="badge text-bg-danger text-wrap m-2" style="width: 15rem;" id="unsuccess_upload">
                                ! data not updated ! Sorry
                            </div>
                            <div class="badge text-bg-warning text-wrap m-2" style="width: 15rem;" id="process_upload">
                                Process in pending please Wait !! file Uploading....
                            </div>
                            <hr>
                            <button type="submit" name="button" class="btn btn-danger form-control"
                                id="STUDY_MATERIAL_UPLOAD">Save Change</button>
                        </form>
                    </div>



                    <!-- modal body end -->



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-warning font-h">Save Change</button> -->
                </div>
            </div>
        </div>
    </div>

    <?php ?>
    <script>
        $(document).ready(function () {

            var FILE_Container = $("#PDF_CONTAINER");
            var SEARCH_BY = $("#searchbyNEPID_FILE");
            var input_search=$("#search_pdf_input");

            window.study_material = function (input_data,search_type) {
                // LOAD_BY,FILED_NAME
                // LOAD_BY="ID";

                // if(FILED_NAME=="CLASS"){
                //     FILED_NAME=1;
                // }else if(FILED_NAME=="NAME"){

                // }else if(FILED_NAME=="ID"){

                // }else if(FILED_NAME=="CHAPTER_NO"){

                // }else if(FILED_NAME=="NAME"){

                // }
                $.ajax({
                    url: "access_file_backend.php",
                    type: "POST",
                    data: { ID: "FILE",SEARCH_DATA:input_data,SEARCH_TYPE:search_type},
                    success: function (data) {
                        FILE_Container.html(data);

                    }
                })


            }

            search_by=function(SEARCH_BY)
            {
                if (SEARCH_BY.val() != "") {
                var TYPE = "CHAPTER_NAME";
                if (SEARCH_BY.val() == "NAME") {
                    TYPE = "CHAPTER_NAME";
                } else if (SEARCH_BY.val() == "PDF_ID") {
                    TYPE = "PDF_ID";
                }
                else if (SEARCH_BY.val() == "SUBJECT") {
                    TYPE = "SUBJECT";
                } else if (SEARCH_BY.val() == "DESCRIPTION") {
                    TYPE = "DESCRIPTION";
                }
                return TYPE;
               }
            }
            // alert(search_by(SEARCH_BY));
            // SEARCH_BY.on("change",()=>{
            //     alert(search_by(SEARCH_BY));
            // })

            study_material("",search_by(SEARCH_BY));

            $("#REFRESH_FILE").on("click", () => {
                study_material("",search_by(SEARCH_BY));
            });

            // searching code
            input_search.on("keyup",()=>{
               
                // alert(input_search.val());

                study_material(input_search.val(),search_by(SEARCH_BY));

            });



            // searching code



            $('#PDF_CONTAINER').on('click', '.pdf_delete_btn', function () {
                var file_id = $(this).data("idf1");
                var file = $(this).data("file");
                var child = $(this);
                //    alert(file);
                $.ajax({
                    url: "Upload_study_material_backend.php",
                    type: "POST",
                    data: { FILE_ID: file_id, ACTION: 'DELETE1', FILE: file },
                    success: function (data) {
                        if (data == 0) {

                            message("FILE deleted Successfully ", "green");
                            child.parents(".card-local").hide(300);
                            setInterval(() => {
                                study_material("",search_by(SEARCH_BY));

                            }, 1000);
                        } else if (data == 1) {
                            message("Error occoured", "red");
                        } else if (data == 2) {
                            message("! You have been blocked !.", "red");

                        } else if (data == 4) {
                            message("Access denied to delete any files.", "red");
                        } else {
                            message(data, "red");
                        }
                    }
                });

            });

            $("#PDF_CONTAINER").on("click", ".pdf_download_btn", function () {
                var Download_btn = $(this);
                var file = 'pdf/' + Download_btn.data("file");
                // alert(file);
                // Download_btn.parents('.span') .width(percentComplete + '%');
                //     $('.download_progress').width(5 + '%')
                //    var progress_bar=$('.download_progress');

                var k = Download_btn.parents(".sub-card-pdf");

                statusbar = k.siblings('.progress');
                p = statusbar.find(".download_progress");

                // p.width(100 + '%');
                // alert(p.html());
                var xhr = new XMLHttpRequest();
                xhr.open('GET', file, true);
                xhr.responseType = 'blob';

                xhr.onprogress = function (e) {
                    if (e.lengthComputable) {
                        var percentComplete = Math.round((e.loaded / e.total) * 100);
                        // progress_bar.width(percentComplete + '%');
                        // progress_bar.html(percentComplete + '%');
                        p.width(percentComplete + '%');
                        p.html(percentComplete + '%');
                    }
                };
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(xhr.response);
                        link.download = Download_btn.data("file");
                        link.click();
                    }
                };

                xhr.send();

            });
            $("#PDF_CONTAINER").on("load", ".download_progress", () => {

                var progress = $(this);
                progress.hide();

            });
            var C_name = $("#CHAPTER_NAME");
            var C_Descr = $("#DESCRIPTION");
            var Class = $("#CLASS");
            var File = $('#PDF_FILE');
            var Subject = $("#SUBJECT");
            var c_no = $("#CHAPTER_NO");

            $("#success_upload").hide();
            $("#unsuccess_upload").hide();
            $("#process_upload").hide();

            $("#PDF_CONTAINER").on("click", ".pdf_edit_btn", function () {
                var pdf_selector = $(this);
                var pdf_id = pdf_selector.data("file_id");
                $("#FILE_UPLOADED").val("");


                $.ajax({
                    url: "Upload_study_material_backend.php",
                    type: "POST",
                    data: { PDF_ID: pdf_id, ACTION: "EDIT" },
                    dataType: "JSON",
                    success: function (res_data) {
                        console.log(res_data);
                        console.log(res_data[0].FILE);

                        C_name.val(res_data[0].CHAPTER_NAME);
                        Class.val(res_data[0].CLASS);
                        C_Descr.val(res_data[0].DESCRIPTION);
                        File.val(res_data[0].FILE);
                        Subject.val(res_data[0].SUBJECT);
                        c_no.val(res_data[0].CHAPTER_NO);
                        $("#PDF_ID_EDIT").val(res_data[0].PDF_ID);
                        $("#ProgressBar").width('0%');
                        $("#success_upload").hide();
                        $("#unsuccess_upload").hide();
                        $("#process_upload").hide();
                        $("#STUDY_MATERIAL_UPLOAD").show(200);
                        // alert(res_data[0].CHAPTER_NAME);
                    },
                    error: function (err) {
                        message("error", "red");
                    }
                });

            });

            $("#Submit_form").on("submit", (e) => {
                e.preventDefault();
                var formData = new FormData($('#Submit_form')[0]);

                if (C_name.val() != "" && C_Descr.val() != "" && c_no.val() != "" && File.val() != "" && c_no.val() > 0) {
                    // ajax start
                    $.ajax({
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = ((evt.loaded / evt.total) * 100);

                                    $("#ProgressBar").width(percentComplete + '%');
                                    $("#ProgressBar").html(parseInt(percentComplete) + '%');
                                    $("#process_upload").show(200);
                                    $("#process_upload").html("Uploading..");
                                    $("#success_upload").hide();
                                    $("#unsuccess_upload").hide();
                                    $("#STUDY_MATERIAL_UPLOAD").hide(200);
                                    $("#process_upload").html("Uploading.....");
                                    $("#process_upload").html("Uploading........");
                                    if (parseInt(percentComplete) > 99) {
                                        $("#process_upload").html("!! Process in pending please Wait !! file recombine !!");
                                    }

                                }
                            }, false);
                            return xhr;
                        },
                        url: "edit_study_material_update.php",
                        type: "POST",
                        data: formData,
                        beforeSend: function () {
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
                                message("!! file Changed successfully !!", "green");
                                $("#success_upload").show(300);
                                $("#unsuccess_upload").hide();
                                $("#process_upload").hide();
                                // $("#Submit_form")[0].reset();
                                $("#process_upload").html("!Process Completed !");
                                $("#FILE_UPLOADED").val("");
                                study_material("",search_by(SEARCH_BY));
                                // $("#ProgressBar").width(0 + '%');
                            } else if (data == 3) {
                                message("! Please select a file !", "red");
                                $("#success_upload").hide();
                                $("#unsuccess_upload").hide();
                                $("#process_upload").hide();
                            } else if (data == 1) {
                                message("File not Uploaded !! Server issue ! Sorry", "red");
                                $("#unsuccess_upload").show(300);
                                $("#unsuccess_upload").html(" ! file not Uploaded ! Unsuccessfull");
                                $("#success_upload").hide();
                                $("#process_upload").hide();
                                $("#process_upload").html("!Process Completed !");
                            }
                            else if (data == 2) {
                                message("Valid format ('pdf','png','jpg','jpeg')(Please select valid format file.) !", "red");
                            } else if (data == 4) {
                                message("Access Denied", "red");
                                $("#success_upload").hide();
                                $("#unsuccess_upload").show(200);
                                $("#unsuccess_upload").html("Access denied by Admin to upload files.");
                                $("#process_upload").hide();
                                $("#process_upload").html("!Process Completed !");

                            } else {
                                message("server Issue !! Please leave this plateform Temporary ! " + data, "red");
                                $("#unsuccess_upload").show(200);
                                $("#unsuccess_upload").html(" !! Server Error !! Sorry ");
                                $("#success_upload").hide();
                                $("#process_upload").hide();
                                $("#process_upload").html("!Process Completed !");
                                alert(data);
                            }

                        }
                    });


                    // ajax end
                } else {
                    message("All field are required", "red");
                }


            });


        });



    </script>

    <?php }else{          echo "<br> <center><h4 class='font-h' style='color:red;'> Login Now, then you can access All the study material. </h4> </center>";?>


    <img width="100%" height="auto"
        src="https://media.licdn.com/dms/image/D4D12AQEvlwvk_5jSBw/article-cover_image-shrink_600_2000/0/1714975705046?e=2147483647&v=beta&t=SSIjJpE29SKs3_amDcg2HY3bYhUaR145LScDJaJ5enk">

    <?php

    }
    
    ?>