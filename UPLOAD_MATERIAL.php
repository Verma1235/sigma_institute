<?php
session_start();
if (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN']) || isset($_SESSION['TEACHER'])) {
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2ecc71;
            --primary-hover: #27ae60;
            --bg-color: #f4f7f6;
            --text-main: #2d3436;
            --card-bg: #ffffff;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
        }

        .containersetting {
            max-width: 600px;
            margin: 40px auto !important;
        }

        .upload-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h3 {
            font-weight: 600;
            color: #1a1a1a;
            margin: 0;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #636e72;
        }

        .form-control {
            width: 100%;
            padding: 5px 10px;
            border-radius: 8px;
            border: 1px solid #dfe6e9;
            transition: all 0.3s ease;
            box-sizing: border-box;
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .btn-success {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            width: 100%;
            font-size: 1rem;
            margin-top: 1rem;
        }

        .btn-success:hover {
            background-color: var(--primary-hover);
        }

        /* Modern Progress Bar */
        .progress {
            height: 8px;
            background-color: #eee;
            border-radius: 10px;
            overflow: hidden;
            margin: 20px 0;
            display: none; /* Controlled by JS via parent */
        }

        .progress-bar {
            height: 100%;
            background-color: var(--primary-color);
            transition: width 0.4s ease;
        }

        /* Status Messages */
        .status-msg {
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-top: 10px;
            text-align: center;
            display: none;
        }

        #success_upload { background: #dff9fb; color: #0984e3; border: 1px solid #74b9ff; width: 100% !important; }
        #unsuccess_upload { background: #ffeaa7; color: #d63031; border: 1px solid #fab1a0; width: 100% !important; }
        #process_upload { background: #f1f2f6; color: #2f3542; border: 1px solid #dfe6e9; width: 100% !important; }

        hr {
            border: 0;
            border-top: 1px solid #eee;
            margin: 1.5rem 0;
        }
    </style>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="jquery.js"> </script>
</head>

<body>
    <div class="containersetting">
        <div class="upload-card">
            <div class="form-header">
                <h3 class='font-h'>Upload Study Material</h3>
            </div>

            <form id="Submit_form">
                <div class="form-group">
                    <label for="CHAPTER_NAME">Chapter Name</label>
                    <input type="text" name="chapter_name" class="form-control" id="CHAPTER_NAME"
                        placeholder="e.g. Introduction to Quantum Physics" required="required">
                </div>

                <div style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label for="CHAPTER_NO">Chapter Number</label>
                        <input type="number" name="ch_no" class="form-control" id="CHAPTER_NO" placeholder="e.g. 1"
                            required="required">
                    </div>

                    <div class="form-group" style="flex: 2;">
                        <label for="CLASS">Class</label>
                        <select class="form-control" name="Class" id="CLASS" required="required">
                            <option value="0">All Classes</option>
                            <option value="6">Class 6</option>
                            <option value="7">Class 7</option>
                            <option value="8">Class 8</option>
                            <option value="9">Class 9</option>
                            <option value="10">Class 10</option>
                            <option value="11">Class 11</option>
                            <option value="12">Class 12</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="SUBJECT">Subject</label>
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
                    <label for="DESCRIPTION">Description</label>
                    <textarea class="form-control" name="discription" placeholder="Briefly describe the content..."
                        id="DESCRIPTION"></textarea>
                </div>

                <hr>

                <div class="form-group">
                    <label for="FILE_UPLOADED">Select File (PDF, JPG, PNG)</label>
                    <input type="file" name="file" id="FILE_UPLOADED" class="form-control">
                </div>

                <div class="progress" id="ProgressContainer">
                    <div class="progress-bar" role="progressbar" id="ProgressBar" style="width: 0%"></div>
                </div>

                <div class="status-msg" id="success_upload">
                    <strong>✓ Success!</strong> File successfully uploaded.
                </div>
                <div class="status-msg" id="unsuccess_upload">
                    <strong>✕ Error!</strong> File not uploaded.
                </div>
                <div class="status-msg" id="process_upload">
                    Uploading... please wait.
                </div>

                <button type="submit" name="button" class="btn-success" id="STUDY_MATERIAL_UPLOAD">
                    Upload Material
                </button>
            </form>
        </div>
    </div>
</body>

<?php } else {
    echo "<script>window.location.href='index.php';</script>";
} ?>

<script>
    $(document).ready(() => {
        $("#success_upload").hide();
        $("#unsuccess_upload").hide();
        $("#process_upload").hide();
        
        $("#Submit_form").on("submit", function (e) {
            e.preventDefault();
            var formData = new FormData($('#Submit_form')[0]);
            var C_name = $("#CHAPTER_NAME");
            var C_Descr = $("#DESCRIPTION");
            var Class = $("#CLASS");
            var File = $('#FILE_UPLOADED');
            var Subject = $("#SUBJECT");
            var c_no = $("#CHAPTER_NO");

            if (C_name.val() != "" && C_Descr.val() != "" && c_no.val() != "" && File.val() != "" && File.val() != null && c_no.val() > 0) {
                
                $.ajax({
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                $("#ProgressContainer").show(); // Show progress bar container
                                var percentComplete = ((evt.loaded / evt.total) * 100);
                                $("#ProgressBar").width(percentComplete + '%');
                                $("#process_upload").show();
                                
                                if (parseInt(percentComplete) > 99) {
                                    $("#process_upload").html("Finishing up... processing on server.");
                                } else {
                                    $("#process_upload").html("Uploading: " + parseInt(percentComplete) + "%");
                                }
                            }
                        }, false);
                        return xhr;
                    },
                    url: "Upload_study_material_backend.php",
                    type: "POST",
                    data: formData,
                    beforeSend: function () {
                        $("#ProgressBar").width('0%');
                        $("#success_upload").hide();
                        $("#unsuccess_upload").hide();
                        $("#process_upload").show();
                        $("#STUDY_MATERIAL_UPLOAD").attr("disabled", true).css("opacity", "0.7");
                    },
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $("#STUDY_MATERIAL_UPLOAD").attr("disabled", false).css("opacity", "1");
                        $("#ProgressContainer").hide();
                        
                        if (data == 0) {
                            $("#process_upload").hide();
                            $("#success_upload").show(300);
                            $("#unsuccess_upload").hide();
                            $("#Submit_form")[0].reset();
                        } else if (data == 3) {
                            $("#unsuccess_upload").show().html("Please select a file!");
                            $("#process_upload").hide();
                        } else if (data == 1) {
                            $("#unsuccess_upload").show().html("Server issue: File not uploaded.");
                            $("#process_upload").hide();
                        } else if (data == 2) {
                            $("#unsuccess_upload").show().html("Invalid format! Use PDF, PNG, or JPG.");
                            $("#process_upload").hide();
                        } else if (data == 4) {
                            $("#unsuccess_upload").show().html("Access Denied by Admin.");
                            $("#process_upload").hide();
                        } else {
                            alert(data);
                        }
                    }
                });
            } else {
                if (c_no.val() <= 0) {
                    alert("Incorrect Chapter number!");
                } else {
                    alert("Please fill all required fields.");
                }
            }
        })
    });
</script>