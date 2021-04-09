<?php
if (!empty($_GET["id"])) {
    $query = "SELECT * FROM company_aff WHERE id > '0' AND id = ?";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'i', $_GET["id"]);
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    if ($numrow > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $page_title = stripslashes($row["name_aff"]);
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=company/list'\" >";
    }
} else {
    $page_title = "Add New Company (Affiliated)";
}
# check value
$id = !empty($row["id"]) ? $row["id"] : '0';
$company = !empty($_GET["company"]) ? $_GET["company"] : '';
$company_name = !empty($_GET["company"]) ? get_value('company', 'id', 'name', $_GET["company"], $mysqli_p) : '';
$offline = !empty($row["offline"]) ? $row["offline"] : '2';
$name_aff = !empty($row["name_aff"]) ? $row["name_aff"] : '';
$receipt_name = !empty($row["receipt_name"]) ? $row["receipt_name"] : '';
$receipt_tax = !empty($row["receipt_taxid"]) ? $row["receipt_taxid"] : '';
$receipt_address = !empty($row["receipt_address"]) ? $row["receipt_address"] : '';
$receipt_detail = !empty($row["receipt_detail"]) ? $row["receipt_detail"] : '';
# photo
$photo = !empty($row["photo"]) ? $row["photo"] : '';
$pathphoto = !empty($photo) ? 'inc/photo/company_aff/' . $photo : 'inc/photo/no-image.jpg';
?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> Company Affiliated </h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?mode=company/detail&id=<?php echo $company; ?>"> <?php echo $company_name; ?> </a>
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

        <!-- Form company start -->
        <div class="content-body">
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="javascript:;" method="POST" id="frmcompany" name="frmcompany" class="needs-validation" enctype="multipart/form-data" novalidate>
                                    <!-- Hidden input -->
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" id="page_title" name="page_title" value="<?php echo $page_title; ?>">
                                    <input type="hidden" id="company" name="company" value="<?php echo $company; ?>">
                                    <!-- company photo -->
                                    <div class="media mb-2">
                                        <img src="<?php echo $pathphoto; ?>" alt="company" class="photo company-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                                        <div class="media-body mt-50">
                                            <h4> <?php echo $page_title; ?> </h4>
                                            <div class="col-12 d-flex mt-1 px-0">
                                                <label class="btn btn-primary mr-75 mb-0" for="photo">
                                                    <span class="d-none d-sm-block">Change</span>
                                                    <input class="form-control" type="file" id="photo" name="photo" value="<?php echo $photo; ?>" hidden value="" accept="image/png, image/jpeg, image/jpg" />
                                                    <input type="hidden" name="tmp_photo" id="tmp_photo" value="<?php echo $photo; ?>">
                                                    <input type="hidden" name="del_photo" id="del_photo" value="">
                                                    <span class="d-block d-sm-none">
                                                        <i class="mr-0" data-feather="edit"></i>
                                                    </span>
                                                </label>
                                                <button class="btn btn-outline-secondary d-none d-sm-block" id="remove_photo" type="button">Remove</button>
                                                <button class="btn btn-outline-secondary d-block d-sm-none">
                                                    <i class="mr-0" data-feather="trash-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- company information -->
                                    <div class="form-row mt-3">
                                        <div class="col-12">
                                            <h4 class="mb-1">
                                                <i data-feather="home" class="font-medium-4 mr-25"></i>
                                                <span class="align-middle">Company Information</span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="offline" class="mb-1">Status</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="offline" name="offline" <?php if ($offline != 2 || !isset($offline)) {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> value="1" />
                                                    <label class="custom-control-label" for="offline"> Offline </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name_aff"> Name (Affiliated) </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="home"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="name_aff" name="name_aff" value="<?php echo $name_aff; ?>" placeholder="" required />
                                                    <div class="invalid-feedback">Please enter a Name (Affiliated).</div>
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="receipt_name"> Receipt Name </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="receipt_name" name="receipt_name" value="<?php echo $receipt_name; ?>" placeholder="" required />
                                                    <div class="invalid-feedback">Please enter a Receipt Name.</div>
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="receipt_tax"> Receipt Tax </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="receipt_tax" name="receipt_tax" value="<?php echo $receipt_tax; ?>" placeholder="" />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="receipt_address"> Receipt Address </label>
                                                <textarea class="form-control" name="receipt_address" id="receipt_address" cols="30" rows="2"><?php echo $receipt_address; ?></textarea>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="receipt_detail"> Receipt Detail </label>
                                                <textarea class="form-control" name="receipt_detail" id="receipt_detail" cols="30" rows="2"><?php echo $receipt_detail; ?></textarea>
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

                                <div id="div-company"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Form company end -->
    </div>
</div>

<script>
    // Check Validity
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        submitFormAff();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Submit form company affiliated
    function submitFormAff() {
        var id = $('#id').val();
        var company = $('#company').val();
        var page_title = $('#page_title').val();
        var check_offline = document.getElementById('offline');
        if (check_offline.checked) {
            var offline = $('#offline').val();
        } else {
            var offline = '';
        }
        var name_aff = $('#name_aff').val();
        var receipt_name = $('#receipt_name').val();
        var receipt_tax = $('#receipt_tax').val();
        var receipt_address = $('#receipt_address').val();
        var receipt_detail = $('#receipt_detail').val();
        var tmp_photo = $('#tmp_photo').val();
        var del_photo = $('#del_photo').val();

        var fd = new FormData();
        var photo = $('#photo')[0].files[0];
        fd.append('id', id);
        fd.append('company', company);
        fd.append('page_title', page_title);
        fd.append('offline', offline);
        fd.append('name_aff', name_aff);
        fd.append('receipt_name', receipt_name);
        fd.append('receipt_tax', receipt_tax);
        fd.append('receipt_address', receipt_address);
        fd.append('receipt_detail', receipt_detail);

        fd.append('tmp_photo', tmp_photo);
        fd.append('del_photo', del_photo);
        fd.append('photo', photo);

        $.ajax({
            type: "POST",
            url: "sections/company/ajax/add-aff.php",
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: fd,
            success: function(response) {
                // $("#div-company").html(response);
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