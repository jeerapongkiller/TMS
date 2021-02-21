<?php
if (!empty($_GET["id"])) {
    $query = "SELECT * FROM company WHERE id > '0' AND id = ?";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'i', $_GET["id"]);
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    if ($numrow > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $page_title = stripslashes($row["name"]);
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=company/list'\" >";
    }
} else {
    $page_title = "Add New Company";
}
# check value
$id = !empty($row["id"]) ? $row["id"] : '0';
$offline = !empty($row["offline"]) ? $row["offline"] : '2';
$name = !empty($row["name"]) ? $row["name"] : '';
$name_invoice = !empty($row["name_invoice"]) ? $row["name_invoice"] : '';
$address = !empty($row["address"]) ? $row["address"] : '';
$phone = !empty($row["phone"]) ? $row["phone"] : '';
$fax = !empty($row["fax"]) ? $row["fax"] : '';
$email = !empty($row["email"]) ? $row["email"] : '';
$website = !empty($row["website"]) ? $row["website"] : '';
$contact_person = !empty($row["contact_person"]) ? $row["contact_person"] : '';
$contact_position = !empty($row["contact_position"]) ? $row["contact_position"] : '';
$contact_phone = !empty($row["contact_phone"]) ? $row["contact_phone"] : '';
$contact_email = !empty($row["contact_email"]) ? $row["contact_email"] : '';
# photo
$photo = !empty($row["photo"]) ? $row["photo"] : '';
$pathphoto = !empty($photo) ? 'inc/photo/company/' . $photo : 'inc/photo/no-image.jpg';
?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Company</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?mode=company/list"> Home </a>
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
                            <!-- <div class="card-header">
                                <h4 class="card-title">Search</h4>
                            </div> -->
                            <div class="card-body">
                                <form action="javascript:;" method="POST" id="frmsearch" name="frmsearch" class="needs-validation" enctype="multipart/form-data" novalidate>
                                    <!-- Hidden input -->
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" id="page_title" name="page_title" value="<?php echo $page_title; ?>">
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
                                                <label for="name"> Name </label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="home"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" placeholder="" required />
                                                    <!-- <div class="invalid-feedback">Please enter a name.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name_invoice"> Name Invoice </label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="home"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="name_invoice" name="name_invoice" value="<?php echo $name_invoice; ?>" placeholder="" required />
                                                    <!-- <div class="invalid-feedback">Please enter a name invoice.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="phone"> Phone </label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='smartphone'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" placeholder="" required />
                                                    <!-- <div class="invalid-feedback">Please enter a phone.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="fax"> Fax </label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='printer'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="fax" name="fax" value="<?php echo $fax; ?>" placeholder="" required />
                                                    <!-- <div class="invalid-feedback">Please enter a fax.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="email"> Email </label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='mail'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>" placeholder="" required />
                                                    <!-- <div class="invalid-feedback">Please enter a fax.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="website"> Website </label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='globe'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="website" name="website" value="<?php echo $website; ?>" placeholder="" required />
                                                    <!-- <div class="invalid-feedback">Please enter a fax.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="address"> Address </label>
                                                <textarea class="form-control" name="address" id="address" cols="30" rows="2"><?php echo $address; ?></textarea>
                                            </div>
                                        </div> <!-- div -->
                                    </div>

                                    <!-- contact company -->
                                    <div class="form-row">
                                        <div class="col-12">
                                            <h4 class="mb-1">
                                                <i data-feather="user" class="font-medium-4 mr-25"></i>
                                                <span class="align-middle">Contact Company</span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="contact_person"> Contact Person </label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="contact_person" name="contact_person" value="<?php echo $contact_person; ?>" placeholder="" required />
                                                    <!-- <div class="invalid-feedback">Please enter a name.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="contact_position"> Contact Position </label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='archive'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="contact_position" name="contact_position" value="<?php echo $contact_position; ?>" placeholder="" required />
                                                    <!-- <div class="invalid-feedback">Please enter a name invoice.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="contact_phone"> Contact Phone </label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="smartphone"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?php echo $contact_phone; ?>" placeholder="" required />
                                                    <!-- <div class="invalid-feedback">Please enter a phone.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="contact_email"> Email </label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="mail"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="contact_email" name="contact_email" value="<?php echo $contact_email; ?>" placeholder="" required />
                                                    <!-- <div class="invalid-feedback">Please enter a fax.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                    </div>

                                    <hr>

                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12 mt-1">
                                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light" onclick="submitFormUser();"><i class="fas fa-search"></i>&nbsp;&nbsp;Submit</button>
                                        </div>
                                    </div>
                                </form>

                                <div id="div-company"></div>

                                <script>
                                    // Example starter JavaScript for disabling form submissions if there are invalid fields
                                    (function() {
                                        'use strict';
                                        window.addEventListener('load', function() {
                                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                            var forms = document.getElementsByClassName('needs-validation');
                                            // Loop over them and prevent submission
                                            var validation = Array.prototype.filter.call(forms, function(form) {
                                                form.addEventListener('submit', function(event) {
                                                    var username = document.getElementById('username').value;
                                                    var usernamesame = document.getElementById('usernamesame').value;

                                                    if (usernamesame == "false") {
                                                        usernamesame = false;
                                                    } else {
                                                        usernamesame = true;
                                                    }

                                                    if (form.checkValidity() === false || usernamesame === false) {
                                                        // $("#username").next("div.invalid-feedback").text("Please enter a new username because the username is a duplicate or username has not been specified.");
                                                        if (usernamesame === false) {
                                                            // username.value = "";
                                                            // alert(username);
                                                            document.getElementById('username').value = "";
                                                        }
                                                        event.preventDefault();
                                                        event.stopPropagation();
                                                    } else {
                                                        // submitFormUser();
                                                    }
                                                    form.classList.add('was-validated');
                                                }, false);
                                            });
                                        }, false);
                                    })();

                                    // Submit form company
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
                                        var name_invoice = $('#name_invoice').val();
                                        var address = $('#address').val();
                                        var phone = $('#phone').val();
                                        var fax = $('#fax').val();
                                        var email = $('#email').val();
                                        var website = $('#website').val();
                                        var contact_person = $('#contact_person').val();
                                        var contact_position = $('#contact_position').val();
                                        var contact_phone = $('#contact_phone').val();
                                        var contact_email = $('#contact_email').val();
                                        var tmp_photo = $('#tmp_photo').val();
                                        var del_photo = $('#del_photo').val();

                                        var fd = new FormData();
                                        var photo = $('#photo')[0].files[0];
                                        fd.append('id', id);
                                        fd.append('page_title', page_title);
                                        fd.append('offline', offline);
                                        fd.append('name', name);
                                        fd.append('name_invoice', name_invoice);
                                        fd.append('address', address);
                                        fd.append('phone', phone);
                                        fd.append('fax', fax);
                                        fd.append('email', email);
                                        fd.append('website', website);
                                        fd.append('contact_person', contact_person);
                                        fd.append('contact_position', contact_position);
                                        fd.append('contact_phone', contact_phone);
                                        fd.append('contact_email', contact_email);
                                        
                                        fd.append('tmp_photo', tmp_photo);
                                        fd.append('del_photo', del_photo);
                                        fd.append('photo', photo);

                                        $.ajax({
                                            type: "POST",
                                            url: "sections/company/save.php",
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
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Form company end -->
        </div>
    </div>
</div>