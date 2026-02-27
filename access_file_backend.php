<?php
session_start();
include "Chek_required_permission.php"; 

$HTML = "";

if (isset($_POST['ID']) && ($Status == 1) && isset($_POST['SEARCH_DATA'])) {
    
    $sData = mysqli_real_escape_string($conn, $_POST['SEARCH_DATA']);
    $sType = mysqli_real_escape_string($conn, $_POST['SEARCH_TYPE']);
    
    // Fix: Match the session variable to your database storage strings
    $FILES_LOCATION = $_SESSION['FILES_LOCATION'] ?? 'local';

    // 1. Build SQL Query - Removed "ORDER BY id" to fix your crash
    if ($sData != "") {
        if ($sType == 'DESCRIPTION' || $sType == 'CHAPTER_NAME') {
            $sql = "SELECT * FROM `study_material` 
                    WHERE (`$sType` LIKE '%$sData%') 
                    AND `FILES_LOCATION`='$FILES_LOCATION';";
        } else {
            $sql = "SELECT * FROM `study_material` 
                    WHERE `$sType` LIKE '$sData%' 
                    AND `FILES_LOCATION`='$FILES_LOCATION';";
        }
    } else {
        $sql = "SELECT * FROM `study_material` WHERE `FILES_LOCATION`='$FILES_LOCATION';";
    }

    $query = mysqli_query($conn, $sql);

    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $F_Id = $row['PDF_ID'];
                $file_val = $row['FILE'];
                $location = $row['FILES_LOCATION'];
                
                $uploadedby = ($row['UPLOADED_BY_ID'] == $_SESSION['ID']) ? "Myself" : $row['UPL_BY'];

                // 2. Determine View/Download Links
                if ($location === 'drive') {
                    $view_path = "view_file.php?id=$F_Id";
                    $download_path = "view_file.php?id=$F_Id&download=1";
                } else {
                    $view_path = "pdf/$file_val";
                    $download_path = "pdf/$file_val"; 
                }
              $class=  $row['CLASS']==0?'All':$row['CLASS'];

                $HTML .= "
                <div class='col-sm-6 mb-4'>
                    <div class='card shadow-sm h-100'>
                        <div class='card-body card-local'>
                            <h5 class='card-title font-h ' style='color:purple'>
                                <i class='bi bi-file-earmark-pdf-fill me-2'></i>{$row['CHAPTER_NAME']}
                            </h5>
                            <div class='mb-2'>
                                <span class='badge bg-light text-dark border'>Ch: {$row['CHAPTER_NO']}</span>
                                <span class='badge bg-light text-dark border'>Class: {$class}</span>
                                <span class='badge bg-info text-white'>{$row['SUBJECT']}</span>
                            </div>
                            <p class='card-text small text-muted mb-3'>
                                <strong>About:</strong> {$row['DESCRIPTION']}<br>
                                <strong>ID:</strong> <code class='text-danger'>$F_Id</code>
                            </p>
                            <div class='d-flex flex-wrap gap-2 mb-3'>";

                if (isset($_SESSION['ADMIN']) || isset($_SESSION['COADMIN']) || isset($_SESSION['TEACHER'])) {
                    if ($_SESSION['ACTIVE'] == 1 || $_SESSION['ACTIVE'] == 0) {
                        $HTML .= "
                        <button data-file_id='$F_Id' data-bs-toggle='modal' data-bs-target='#Edit_pdf_modal' class='btn btn-warning btn-sm pdf_edit_btn'>
                            <i class='bi bi-pencil-square'></i> Edit
                        </button>
                        <button data-idF1='$F_Id' data-file='$file_val' class='btn btn-danger btn-sm pdf_delete_btn'>
                            <i class='bi bi-trash3'></i> Delete
                        </button>";
                    }
                }

                $HTML .= "
                        <a href='$view_path' target='_blank' class='btn btn-success btn-sm shadow-sm'>
                            <i class='bi bi-eye'></i> View
                        </a>
                        <a href='$download_path' download class='btn btn-dark btn-sm shadow-sm'>
                            <i class='bi bi-download'></i> Download
                        </a>
                    </div>
                            <div class='progress' style='height: 1px;'>
                                <div class='progress-bar progress-bar-striped progress-bar-animated download_progress' style='width: 0%'></div>
                            </div>
                        </div>
                    </div>
                </div>";
            }
            echo $HTML;
        } else {
            echo "<div class='col-12 text-center mt-5'><h4 class='text-danger font-h'>No files found in $FILES_LOCATION storage.</h4></div>";
        }
    } else {
        echo "SQL Error: " . mysqli_error($conn);
    }
}
?>