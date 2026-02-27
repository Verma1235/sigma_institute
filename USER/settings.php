<?php
session_start();
include("../Chek_required_permission.php");
if (isset($_SESSION['ADMIN'])) {

    $sql_setting = "SELECT * FROM `sigmasettings` WHERE SETTING_ID = 1";

    $result = mysqli_query($conn, $sql_setting);
    $row = mysqli_fetch_array($result);
    mysqli_close($conn);
    $live = "";
    $maintanance = "";
    switch ($row["MODE"]) {
        case "1":
            $live = "selected";
            break;
        case "2":
            $maintanance = "selected";
            break;
        default:

    }

    $private = "";
    $public = "";
    switch ($row["ACCOUNT_ACCESS"]) {
        case "1":
            $private = "selected";
            break;
        case "2":
            $public = "selected";
            break;
        default:

    }
    $pdf = "";
    $drive = "";
    switch ($row["FILES_LOCATION"]) {
        case "pdf":
            $pdf = "selected";
            break;
        case "drive":
            $drive = "selected";
            break;
        default:

    }
    $login_yes = "";
    $login_no = "";
    switch ($row["LOGIN_ALLOW"]) {
        case "2":
            $login_yes = "selected";
            break;
        case "1":
            $login_no = "selected";
            break;
        default:

    }
    $signup_yes = "";
    $signup_no = "";
    switch ($row["SIGNUP_ALLOW"]) {
        case "2":
            $signup_yes = "selected";
            break;
        case "1":
            $signup_no = "selected";
            break;
        default:

    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>System Settings</title>
        <script src="jquery.js"></script>
        <style>
            /* Plain CSS Replacement for Tailwind */
            /* body { font-family: sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px; } */
            .containersetting {
                max-width: 800px;
                margin: 40px auto;
            }

            .card {
                background: white;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .card-header {
                background: linear-gradient(to right, rgb(17, 206, 235), rgb(64, 241, 117));
                color: white;
                padding: 20px;
            }

            .card-header h2 {
                margin: 0;
                font-size: 1.25rem;
            }

            form {
                padding: 24px;
            }

            .grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            @media (max-width: 600px) {
                .grid {
                    grid-template-columns: 1fr;
                }
            }

            .form-group {
                margin-bottom: 15px;
            }

            label {
                display: block;
                font-size: 0.875rem;
                font-weight: 600;
                color: #374151;
                margin-bottom: 5px;
            }

            input,
            select {
                width: 100%;
                padding: 8px;
                border: 1px solid #d1d5db;
                border-radius: 6px;
                box-sizing: border-box;
                background: #fff;
            }

            .btn-container {
                border-top: 1px solid #eee;
                padding-top: 20px;
                text-align: right;
            }

            #saveBtn {
                background: #4f46e5;
                color: white;
                border: none;
                padding: 10px 25px;
                border-radius: 6px;
                font-weight: bold;
                cursor: pointer;
                transition: 0.2s;
            }

            #saveBtn:hover {
                background: #4338ca;
            }

            #saveBtn:disabled {
                background: #9ca3af;
                cursor: not-allowed;
            }

            #response-msg {
                padding: 15px;
                border-radius: 6px;
                margin-bottom: 20px;
                display: none;
                font-size: 14px;
                font-weight: bold;
            }

            .success {
                background-color: #d1fae5;
                color: #065f46;
                border: 1px solid #6ee7b7;
            }

            .error {
                background-color: #fee2e2;
                color: #991b1b;
                border: 1px solid #fca5a5;
            }
        </style>
    </head>

    <body>

        <div class="containersetting">
            <div id="response-msg"></div>

            <div class="card ">
                <div class="card-header">
                    <h2>System Configuration</h2>
                </div>

                <form id="settingsForm">
                    <div class="grid">
                        <div class="form-group">
                            <label>System Mode</label>
                            <select name="MODE" id="MODE">
                                <option value="1" <?php echo $live; ?>>Live</option>
                                <option value="2" <?php echo $maintanance; ?>>Maintenance</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Account Access</label>
                            <select name="ACCOUNT_ACCESS" id="ACCOUNT_ACCESS">
                                <option value="2" <?php echo $public; ?>>Public</option>
                                <option value="1" <?php echo $private; ?>>Private</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Allow Login</label>
                            <select name="LOGIN_ALLOW" id="LOGIN_ALLOW">
                                <option value="2" <?php echo $login_yes; ?>>YES</option>
                                <option value="1" <?php echo $login_no; ?>>NO</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Allow Signup</label>
                            <select name="SIGNUP_ALLOW" id="SIGNUP_ALLOW">
                                <option value="2" <?php echo $signup_yes; ?>>YES</option>
                                <option value="1" <?php echo $signup_no; ?>>NO</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Admin ID</label>
                            <input type="text" name="ADMIN_ID" id="ADMIN_ID" value=<?php echo $_SESSION['ID']; ?> disabled>
                        </div>

                        <div class="form-group">
                            <label>Files Location</label>
                            <!-- <input type="text" name="FILES_LOCATION" id="FILES_LOCATION" value="pdf"> -->
                            <select name="FILES_LOCATION" id="FILES_LOCATION">
                                <option value="pdf" <?php echo $pdf; ?>>SERVER</option>
                                <option value="drive" <?php echo $drive; ?>>CLOUD STORAGE</option>
                            </select>
                        </div>
                    </div>

                    <div class="btn-container">
                        <button type="submit" id="saveBtn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $('#settingsForm').on('submit', function (e) {
                    e.preventDefault();
                    // var formData = {
                    //     var MODE = $("#MODE").val(),
                    //     var ACCOUNT_ACCESS = $("#ACCOUNT_ACCESS").val(),
                    //     var LOGIN_ALLOW = $("#LOGIN_ALLOW").val(),
                    //     var SIGNUP_ALLOW = $("#SIGNUP_ALLOW").val(),
                    //     var ADMIN_ID = $("#ADMIN_ID").val(),
                    //     var FILES_LOCATION = $("#FILES_LOCATION").val()

                    // };
                    var formData = $(this).serialize();

                    const btn = $('#saveBtn');
                    const msgBox = $('#response-msg');

                    btn.prop('disabled', true).text('Saving...');

                    $.ajax({
                        url: 'USER/update_setting_backend.php',
                        type: 'POST',
                        // contentType: "application/json",
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                            msgBox.removeClass('success error').hide();

                            if (response.status === 'success') {
                                msgBox.addClass('success').text(response.message).fadeIn();
                                message(response.message, "green");
                            } else {
                                msgBox.addClass('error').text(response.message).fadeIn();
                                message(response.message, "red");
                            }

                            btn.prop('disabled', false).text('Save Changes');
                            setTimeout(() => msgBox.fadeOut(), 3000);
                        },
                        error: function (error) {

                            alert("Server error. Please try again.");
                            console.log(error);
                            btn.prop('disabled', false).text('Save Changes');
                        }
                    });
                });
            });
        </script>

    </body>

    </html>
<?php } ?>