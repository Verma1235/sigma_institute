<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script> -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>Addmission Reequest</title>
</head>

<body>


    <div class="container-fluid">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"> Photo </th>
                    <th scope="col"> Name </th>
                    
                    <th scope="col"> User_Id </th>
                    <th scope="col"> Phone </th>
                    <th scope="col"> Details </th>
                    <th scope="col"> Payment </th>
                    <th scope="col"> DOA </th>
                    <th scope="col"> Delete</th>
                    <th scope="col"> Status </th>
                    


                </tr>
            </thead>
            <tbody id="admission_data">
                <tr>
                    <th scope="row">1</th>
                    <td>Dinesh kumar verma</td>
                    <td>Id546546</td>
                    <td>Sigma565</td>
                    <td>9693490785</td>
                    <td><button class='form-control btn btn-warning font-h shadow'>Edit</button></td>
                    <td><button class='form-control btn btn-dark font-h shadow'><small>Due</small></button></td>
                    <td><button class='form-control btn btn-primary font-h shadow'>Active</button></td>
                    <td><button class='form-control btn btn-danger font-h shadow'>Delete</button></td>
                    <td><button class='form-control btn  font-h shadow'
                            style='background: greenyellow;'>Approved</button></td>
                    <td> Cash (ofline)</td>

                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Dinesh kumar verma</td>
                    <td>Id546546</td>
                    <td>Sigma565</td>
                    <td>9693490785</td>
                    <td><button class='form-control btn btn-warning font-h shadow'>Edit</button></td>
                    <td><button class='form-control btn  font-h shadow'
                            style='background: rgb(47, 241, 255);'><small>Paid</small></button></td>
                    <td><button class='form-control btn btn-secondary font-h shadow'>Blocked</button></td>
                    <td><button class='form-control btn btn-danger font-h shadow'>Delete</button></td>
                    <td><button class='form-control btn  font-h shadow'
                            style='background: rgb(255, 47, 200);'>Unapproved</button></td>
                    <td> (Online)</td>

                </tr>

            </tbody>
        </table>
        <!-- <button class="form-control btn btn-dark " id="load_data">Load Data</button> -->
    </div>
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target='#pic_dev'>
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="pic_dev" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Profile Picture</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="pic_modal_con">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

</body>
<script>
    $(document).ready(function () {
        var Table_cont = $("#admission_data");

        // Table_cont.html("");

        window.load_data_admi = () => {
            Table_cont.html("");

            $.ajax({
                url: "admission_request_backend.php",
                type: "POST",
                data:{LOAD:"data"},
                success: function (res) {
                    Table_cont.html(res);
                }
            });
        }
        load_data_admi();
        $("#load_data").on("click", () => {
            // alert("vdyc");
            load_data_admi();
        });

        $("#admission_data").on("click",".del_btn",function(){

            var del_btn=$(this);
            alert(del_btn.data('admid'));



        });

        $("#admission_data").on("click",".pic_container",function(){


      var pic=$(this).data("img");
            $("#pic_modal_con").html("<img src='"+pic+"' width='100%'/>");
        });

    });
</script>

</html>