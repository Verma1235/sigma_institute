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