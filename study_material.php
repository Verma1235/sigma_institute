<?php
session_start();
if (isset($_SESSION['FILES_LOCATION']) && $_SESSION['FILES_LOCATION'] == 'drive') {
    include "Chek_required_permission.php";
    // require_once "DriveHandler.php"; // Load the Class we built
    ?>
    <?php
    // include "Chek_required_permission.php";
    if (isset($_SESSION['LOGIN_ID'])) {
        ?>
        <center>
            <h3 class="font-h mt-3">Study Material (Cloud data)</h3>
        </center>

        <div class="container mt-2 p-2 mb-2">
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <div class="right-element d-flex">
                    <select class="form-control" style="width: fit-content; margin-right: 5px;" id="searchby_TYPE">
                        <option value="CHAPTER_NAME">Pdf Name</option>
                        <option value="PDF_ID">PDF ID</option>
                        <option value="CHAPTER_NO">Chapter</option>
                        <option value="DESCRIPTION">About</option>
                        <option value="SUBJECT">Subject</option>
                    </select>
                    <div class="search-con">
                        <input type="search" class="form-control" placeholder="Search Drive..." id="search_input">
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="PDF_CONTAINER"></div>
        <div class="modal fade" id="Edit_pdf_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 font-h">Edit/View Pdf</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid shadow-sm p-2">
                            <form class="font-h" id="Submit_form">
                                <div class="form-group mb-2">
                                    <label>Pdf ID</label>
                                    <input type="text" name="pdf_id" class="form-control" id="PDF_ID_EDIT" readonly>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Chapter Name</label>
                                    <input type="text" name="chapter_name" class="form-control" id="CHAPTER_NAME" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Chapter No</label>
                                    <input type="text" name="ch_no" class="form-control" id="CHAPTER_NO" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Subject</label>
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
                                <div class="form-group mb-2">
                                    <label>Class</label>
                                    <select class="form-control" name="Class" id="CLASS_MODAL">
                                        <option value="0">All</option>
                                        <?php for ($i = 6; $i <= 12; $i++)
                                            echo "<option value='$i'>$i</option>"; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Description</label>
                                    <textarea name="Dis" class="form-control" id="DESCRIPTION_MODAL" rows="2"></textarea>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Current File</label>
                                    <input type="text" name="pre_file" class="form-control" id="PDF_FILE_NAME" readonly>
                                </div>
                                <!-- <div class="form-group mb-3">
                                    <label>Change file:</label>
                                    <input type="file" name="file" id="FILE_UPLOADED" class="form-control">
                                </div> -->

                                <div class="progress mb-2" style="height: 20px;">
                                    <div class="progress-bar progress-bar-striped bg-success" id="ProgressBar"
                                        style="width: 0%">0%</div>
                                </div>

                                <div id="alert_box" class="badge w-100 p-2 mb-2" style="display:none;"></div>

                                <button type="submit" class="btn btn-danger w-100" id="STUDY_MATERIAL_UPLOAD">Save
                                    Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                var FILE_Container = $("#PDF_CONTAINER");
                var searchTimer;

                // 1. Unified Fetch Logic
                window.study_material = function (input_data, search_type) {
                    $.ajax({
                        url: "access_file_backend.php",
                        type: "POST",
                        data: {
                            ID: "FILE",
                            SEARCH_DATA: input_data,
                            SEARCH_TYPE: search_type
                        },
                        success: function (data) {
                            FILE_Container.html(data);
                        }
                    });
                }

                // 2. SEARCH FUNCTION (Debounced)
                $("#search_input").on("keyup", function () {
                    var val = $(this).val();
                    var type = $("#searchby_TYPE").val();

                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(function () {
                        study_material(val, type);
                    }, 500);
                });

                // 3. Delete Logic
                $('#PDF_CONTAINER').on('click', '.pdf_delete_btn', function () {
                    if (!confirm("Are you sure you want to delete this from Drive?")) return;
                    var file_id = $(this).data("idf1");
                    var drive_file_id = $(this).data("file"); // Drive File ID
                    var card = $(this).closest(".col-sm-6");

                    $.ajax({
                        url: "Upload_study_material_backend.php",
                        type: "POST",
                        data: { FILE_ID: file_id, ACTION: 'DELETE1', FILE: drive_file_id },
                        success: function (data) {
                            if (data == 0) {
                                card.fadeOut(300);
                            } else {
                                alert("Error: " + data);
                            }
                        }
                    });
                });

                // 4. View Logic (Handles Drive vs Local via Data Attributes)
                $("#PDF_CONTAINER").on("click", ".pdf_view_btn", function (e) {
                    var loc = $(this).data("location");
                    var file = $(this).data("file_val");

                    if (loc === 'drive') {
                        e.preventDefault();
                        // If it's drive, we use your view_file.php proxy
                        window.open("view_file.php?id=" + file, "_blank");
                    }
                    // Else, the default <a> tag href handles local files
                });

                // Initial Load
                study_material("", "CHAPTER_NAME");

            });

            $(document).ready(function () {
                // Using delegated events because the cards are loaded via AJAX
                $("#PDF_CONTAINER").on("click", ".pdf_edit_btn", function () {
                    var pdf_id = $(this).data("file_id"); // Matches data-file_id in backend

                    // Reset modal state
                    $("#Submit_form")[0].reset();
                    $("#ProgressBar").width('0%').text('0%');

                    $.ajax({
                        url: "Upload_study_material_backend.php", // This should be your unified backend
                        type: "POST",
                        data: { PDF_ID: pdf_id, ACTION: "EDIT" },
                        dataType: "JSON",
                        success: function (res) {
                            if (res && res[0]) {
                                var d = res[0];
                                // Fill Modal Fields
                                $("#PDF_ID_EDIT").val(d.PDF_ID);
                                $("#CHAPTER_NAME").val(d.CHAPTER_NAME);
                                $("#CHAPTER_NO").val(d.CHAPTER_NO);
                                $("#CLASS").val(d.CLASS);
                                $("#SUBJECT").val(d.SUBJECT);
                                $("#DESCRIPTION").val(d.DESCRIPTION);
                                $("#PDF_FILE").val(d.FILE); // This shows either Drive ID or Local Path

                                // Show the modal manually if it doesn't open
                                // $('#Edit_pdf_modal').modal('show');
                            } else {
                                alert("Error: Could not fetch data for this file.");
                            }
                        },
                        error: function () {
                            alert("Server error while fetching edit data.");
                        }
                    });
                });
                // Update Form Submit
                $("#Submit_form").on("submit", function (e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    $.ajax({
                        xhr: function () {
                            const xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", (evt) => {
                                if (evt.lengthComputable) {
                                    let pct = Math.round((evt.loaded / evt.total) * 100);
                                    $("#ProgressBar").width(pct + '%').text(pct + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        url: "edit_study_material_update.php",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: () => {
                            $("#STUDY_MATERIAL_UPLOAD").prop('disabled', true);
                            show_status("Uploading... please wait", "orange");
                        },
                        success: function (data) {
                            $("#STUDY_MATERIAL_UPLOAD").prop('disabled', false);
                            if (data == 0) {
                                show_status("Update Successful!", "green");
                                load_study_material();
                            } else {
                                show_status("Error: " + data, "red");
                            }
                        }
                    });
                });

            });
        </script>
        <?php
    } else {
        include("study_material_old.php");
    }
?>
<?php } else {
    include("study_material_old.php");
}
?>