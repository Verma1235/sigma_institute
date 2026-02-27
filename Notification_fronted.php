<?php
session_start();
// Redirect immediately if not logged in to save server resources
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit();
}
?>

<head>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="jquery.js"></script>
</head>

<div class="col-md-8" style="max-width:800px;margin:auto;">
    <br>
    
    <?php if(isset($_SESSION['ADMIN'])): ?>
        <center><h3 class='font-h'>Notification</h3></center>

        <div class="container" id="TABLE_user">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col" colspan="3">Query</th>
                        <th scope="col">Read</th>
                    </tr>
                </thead>
                <tbody id="student_data_cont">
                    </tbody>
            </table>
            
            <hr>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Signup Date</th>
                        <th scope="col">Request</th>
                        <th scope="col">Details</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody id="student_data_cont2">
                    </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="query-cont" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background: linear-gradient(rgb(9, 199, 220),rgb(108, 205, 140));">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Message/Query</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <pre id="query_modal_con" style="overflow-x:hidden; text-align:justify; white-space:pre-wrap; color: rgb(8, 3, 74);" class="font-h"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Cache selectors to improve performance
    const $notifTable = $("#student_data_cont");
    const $signupTable = $("#student_data_cont2");
    const $modalContent = $("#query_modal_con");

    // 1. Optimized Notification Loader
    window.load_Notification = function () {
        $.post("Notification_backend.php", function(data) {
            $notifTable.html(data);
        });
    };

    // 2. Optimized Signup Loader
    window.loadDataOfSignUpUsers = function() {
        $.ajax({
            url: "SignupuserNotificationbkd.php",
            type: "POST",
            data: { ADMIN: "ADMIN" },
            success: function(data) { $signupTable.html(data); },
            error: function(err) { console.error("Signup Load Error", err); }
        });
    };

    // Initial Load & Interval (using function reference, not string)
    load_Notification();
    loadDataOfSignUpUsers();
    setInterval(load_Notification, 10000); 

    // 3. Mark as Read (Event Delegation)
    $notifTable.on("click", ".read", function() {
        const nId = $(this).data("id");
        $.post("Notification_backend.php", { N_ID: nId }, function(data) {
            if(data == 0) load_Notification();
        });
    });

    // 4. Unified View Query (Handles both tables)
    $(document).on("click", ".view-query", function() {
        const queryText = $(this).data("query");
        $modalContent.html(queryText);
        // If using Bootstrap JS, you might need to trigger the modal manually 
        // if it doesn't have data-bs-toggle attributes
    });

    // 5. Block/Unblock Record
    $signupTable.on("click", '.block_stu_rec', function () {
        const id = $(this).data("id1");
        $.post("deleterecord.php", { ID: id, ACTION: 'STATUS' }, function(data) {
            if (data == 0) {
                if(typeof message === "function") message("Status Changed", "green");
                loadDataOfSignUpUsers();
            } else {
                const errorMsg = (data == 402) ? "Permissions denied." : data;
                if(typeof message === "function") message(errorMsg, "red");
            }
        });
    });
});
</script>