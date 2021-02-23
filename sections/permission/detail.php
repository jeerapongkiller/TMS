<?php
if (!empty($_GET["id"])) {
    if ($_GET["id"] == '1') {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=permission/list'\" >";
    }

    $query = "SELECT * FROM permission WHERE id > '0' AND id = ?";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'i', $_GET["id"]);
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    if ($numrow > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $page_title = stripslashes($row["name"]);
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=permission/list'\" >";
    }
} else {
    $page_title = "Add New Permission";
}
# check value
$id = !empty($row["id"]) ? $row["id"] : '0';
$offline = !empty($row["offline"]) ? $row["offline"] : '2';
$name = !empty($row["name"]) ? $row["name"] : '';
$namesame = !empty($row["id"]) ? 'true' : 'false';
?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Permission</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?mode=permission/list"> Home </a>
                                </li>
                                <li class="breadcrumb-item active"> <?php echo $page_title; ?>
                                </li>
                                <!-- <li class="breadcrumb-item active">Home
                                </li> -->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right">

                </div>
            </div>
        </div>

        <!-- Form permission start -->
        <div class="content-body">
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <!-- <div class="card-header">
                                <h4 class="card-title">Search</h4>
                            </div> -->
                            <div class="card-body">
                                <form action="javascript:;" method="POST" id="frmpermission" name="frmpermission" class="needs-validation" enctype="multipart/form-data" novalidate>
                                    <!-- Hidden input -->
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" id="page_title" name="page_title" value="<?php echo $page_title; ?>">
                                    <input type="hidden" id="namesame" name="namesame" value="<?php echo $namesame; ?>">
                                    <!-- permission edit -->
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="offline" class="mb-1">Status</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="offline" name="offline" <?php if ($offline != 2 || !isset($offline)) {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> value="1" <?php echo !empty($row["trash_deleted"]) && ($row["trash_deleted"] == '1') ? 'disabled' : ''; ?> />
                                                    <label class="custom-control-label" for="offline"> Offline </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='pocket'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" onkeyup="checkName();" placeholder="" required />
                                                    <div class="invalid-feedback" id="name_feedback">Please enter a name.</div>
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                    </div>

                                    <hr>

                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12 mt-1">
                                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light"><i class="fas fa-search"></i>&nbsp;&nbsp;Submit</button>
                                        </div>
                                    </div>
                                </form>

                                <script>
                                    // Check name
                                    function checkName() {
                                        var name = document.getElementById('name');
                                        name.value = name.value.replace(/[^A-Za-z0-9]+/, '');
                                        var namesame = document.getElementById('namesame');

                                        jQuery.ajax({
                                            url: "sections/permission/ajax/namesame.php",
                                            data: {
                                                name: $("#name").val(),
                                                id: $("#id").val()
                                            },
                                            type: "POST",
                                            success: function(response) {
                                                // alert(response);

                                                if (response == "duplicate") {
                                                    namesame.value = false;
                                                    // document.getElementById("name_feedback").classList.add('invalid-feedback');
                                                    $("#name_feedback").html("Please enter a new name. because name duplicate");

                                                    Swal.fire({
                                                        // position: 'top-end',
                                                        type: 'error',
                                                        // title: '',
                                                        text: 'Please enter a new name. because name duplicate',
                                                        showConfirmButton: false,
                                                        timer: 3000
                                                    });
                                                } else if (response == "true") {
                                                    namesame.value = true;
                                                    $("#name_feedback").html("Please enter name.");
                                                } else {
                                                    namesame.value = false;
                                                    $("#name_feedback").html("Please enter name again.");
                                                }
                                            },
                                            error: function() {}
                                        });
                                    }

                                    // Example starter JavaScript for disabling form submissions if there are invalid fields
                                    (function() {
                                        'use strict';
                                        window.addEventListener('load', function() {
                                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                            var forms = document.getElementsByClassName('needs-validation');
                                            // Loop over them and prevent submission
                                            var validation = Array.prototype.filter.call(forms, function(form) {
                                                form.addEventListener('submit', function(event) {
                                                    var name = document.getElementById('name').value;
                                                    var namesame = document.getElementById('namesame').value;

                                                    if (namesame == "false") {
                                                        namesame = false;
                                                    } else {
                                                        namesame = true;
                                                    }

                                                    if (form.checkValidity() === false || namesame === false) {
                                                        // $("#name").next("div.invalid-feedback").text("Please enter a new name because the name is a duplicate or name has not been specified.");
                                                        if (namesame === false) {
                                                            // name.value = "";
                                                            // alert(name);
                                                            document.getElementById('name').value = "";
                                                        }
                                                        event.preventDefault();
                                                        event.stopPropagation();
                                                    } else {
                                                        submitFormUser();
                                                    }
                                                    form.classList.add('was-validated');
                                                }, false);
                                            });
                                        }, false);
                                    })();

                                    // Submit form permission
                                    function submitFormUser() {
                                        var id = $('#id').val();
                                        var page_title = $('#page_title').val();
                                        var check_offline = document.getElementById('offline');
                                        if (check_offline.checked) {
                                            var offline = $('#offline').val();
                                        } else {
                                            var offline = '';
                                        }
                                        var name = $('#name').val();
                                        var namesame = $('#namesame').val();

                                        var fd = new FormData();
                                        fd.append('id', id);
                                        fd.append('page_title', page_title);
                                        fd.append('offline', offline);
                                        fd.append('name', name);
                                        fd.append('namesame', namesame);

                                        $.ajax({
                                            type: "POST",
                                            url: "sections/permission/ajax/save.php",
                                            dataType: 'text', // what to expect back from the PHP script, if anything
                                            cache: false,
                                            contentType: false,
                                            processData: false,
                                            data: fd,
                                            success: function(response) {
                                                // $("#div-permission").html(response);
                                                if (response == 'false') {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error. Please try again!',
                                                        showConfirmButton: false,
                                                        timer: 3000
                                                    });
                                                } else {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Complete!',
                                                        showConfirmButton: false,
                                                        timer: 3600
                                                    }).then((result) => {
                                                        if (response == 'true') {
                                                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                                                        } else {
                                                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>" + response;
                                                        }
                                                    })
                                                }
                                            },
                                            error: function() {
                                                Swal.fire('Error!', 'Error. Please try again', 'error')
                                            }
                                        });
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Form permission end -->
        </div>
    </div>
</div>