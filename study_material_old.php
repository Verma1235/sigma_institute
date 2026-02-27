<?php
// session_start();
include "Chek_required_permission.php";
if (isset($_SESSION['LOGIN_ID'])) {
    ?>

    <head>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@300;400;500;600;700;800;900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
            rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <link href="css/font-awesome.min.css" rel="stylesheet" />
        <link href="css/responsive.css" rel="stylesheet" />
        <link href="css/style.css" rel="stylesheet" />
    </head>

    <center>
        <h3 class="font-h mt-3">Study Material</h3>
    </center>

    <div class="container mt-2 p-2 mb-2">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <div class="right-element d-flex">
                <select class="form-control" style="width: fit-content; margin-right: 5px;" id="searchbyNEPID_FILE">
                    <option value="CHAPTER_NAME">Pdf Name</option>
                    <option value="PDF_ID">PDF ID</option>
                    <option value="CHAPTER_NO">Chapter</option>
                    <option value="DESCRIPTION">About</option>
                    <option value="SUBJECT">Subject</option>
                </select>
                <div class="search-con">
                    <input type="search" class="form-control header-input-search" placeholder="search data"
                        id="search_pdf_input">
                </div>
                <div class="search-btn2">
                    <button class="form-control header-btn-search-table" id="REFRESH_FILE"><i
                            class="bi bi-arrow-clockwise"></i></button>
                </div>
            </div>
            <div class="left-element font-h d-flex align-items-center">
                <h5 id="filter" class="mb-0">Class</h5>
                <select class="form-control ms-2" style="width: fit-content;" id="class_filter">
                    <option value="0">All</option>
                    <?php for ($i = 6; $i <= 12; $i++)
                        echo "<option value='$i'>$i</option>"; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="p-0" style="margin: auto; max-width: 1000px;">
        <div class="row" id="PDF_CONTAINER">
        </div>
    </div>

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
                            <div class="form-group mb-3">
                                <label>Change file:</label>
                                <input type="file" name="file" id="FILE_UPLOADED" class="form-control">
                            </div>

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
            const FILE_Container = $("#PDF_CONTAINER");
            const SEARCH_BY = $("#searchbyNEPID_FILE");
            const input_search = $("#search_pdf_input");
            const class_filter = $("#class_filter");
            let searchTimer;

            // --- Core Functions ---

            function load_study_material(input_data = "", search_type = "CHAPTER_NAME") {
                $.ajax({
                    url: "access_file_backend.php",
                    type: "POST",
                    data: {
                        ID: "FILE",
                        SEARCH_DATA: input_data,
                        SEARCH_TYPE: search_type,
                        CLASS: class_filter.val()
                    },
                    success: function (data) {
                        FILE_Container.html(data);
                    }
                });
            }

            function get_search_type() {
                return SEARCH_BY.val() || "CHAPTER_NAME";
            }

            function show_status(msg, color) {
                $("#alert_box").text(msg).css("background-color", color).fadeIn(200);
            }

            // --- Event Handlers ---

            // Debounced Search (Fixes the continuous calling issue)
            input_search.on("keyup", function () {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    load_study_material($(this).val(), get_search_type());
                }, 500);
            });

            // Refresh and Filter
            $("#REFRESH_FILE, #class_filter").on("click change", function () {
                load_study_material(input_search.val(), get_search_type());
            });

            // Delete Logic (Fixed infinite refresh)
            FILE_Container.on('click', '.pdf_delete_btn', function () {
                if (!confirm("Are you sure you want to delete this?")) return;

                const btn = $(this);
                $.ajax({
                    url: "Upload_study_material_backend.php",
                    type: "POST",
                    data: {
                        FILE_ID: btn.data("idf1"),
                        ACTION: 'DELETE1',
                        FILE: btn.data("file")
                    },
                    success: function (data) {
                        if (data == 0) {
                            btn.closest(".card-local").fadeOut(300);
                            setTimeout(() => load_study_material(), 1000); // Only refreshes ONCE
                        } else {
                            alert("Error: " + data);
                        }
                    }
                });
            });

            // Download Logic
            FILE_Container.on("click", ".pdf_download_btn", function () {
                const btn = $(this);
                const fileName = btn.data("file");
                const path = 'pdf/' + fileName;
                const pBar = btn.closest(".sub-card-pdf").siblings('.progress').find(".download_progress");

                const xhr = new XMLHttpRequest();
                xhr.open('GET', path, true);
                xhr.responseType = 'blob';
                xhr.onprogress = (e) => {
                    if (e.lengthComputable) {
                        let pct = Math.round((e.loaded / e.total) * 100);
                        pBar.width(pct + '%').text(pct + '%');
                    }
                };
                xhr.onload = () => {
                    if (xhr.status === 200) {
                        const link = document.createElement('a');
                        link.href = window.URL.createObjectURL(xhr.response);
                        link.download = fileName;
                        link.click();
                    }
                };
                xhr.send();
            });

            // Edit Modal Populate
            FILE_Container.on("click", ".pdf_edit_btn", function () {
                const pdf_id = $(this).data("file_id");
                $("#FILE_UPLOADED").val("");
                $("#ProgressBar").width('0%').text('0%');
                $("#alert_box").hide();

                $.ajax({
                    url: "Upload_study_material_backend_old.php",
                    type: "POST",
                    data: { PDF_ID: pdf_id, ACTION: "EDIT" },
                    dataType: "JSON",
                    success: function (res) {
                        const d = res[0];
                        $("#PDF_ID_EDIT").val(d.PDF_ID);
                        $("#CHAPTER_NAME").val(d.CHAPTER_NAME);
                        $("#CLASS_MODAL").val(d.CLASS);
                        $("#DESCRIPTION_MODAL").val(d.DESCRIPTION);
                        $("#PDF_FILE_NAME").val(d.FILE);
                        $("#SUBJECT").val(d.SUBJECT);
                        $("#CHAPTER_NO").val(d.CHAPTER_NO);
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

            // Initial Load
            load_study_material();
        });
    </script>

<?php } else { ?>
    <div class="container text-center mt-5">
        <h4 class='font-h text-danger'>Please Login to access study materials.</h4>
        <img class="img-fluid mt-3"
            src="https://media.licdn.com/dms/image/D4D12AQEvlwvk_5jSBw/article-cover_image-shrink_600_2000/0/1714975705046?e=2147483647&v=beta&t=SSIjJpE29SKs3_amDcg2HY3bYhUaR145LScDJaJ5enk">
    </div>
<?php } ?>