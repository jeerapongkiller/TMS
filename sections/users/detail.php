<?php
if (!empty($_GET["id"])) {
    if ($_GET["id"] == '1') {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=users/list'\" >";
    }

    $query = "SELECT * FROM users WHERE id > '0' AND id = ?";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'i', $_GET["id"]);
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    if ($numrow > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $page_title = stripslashes($row["firstname"] . " " . $row["lastname"]);
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=users/list'\" >";
    }
} else {
    $page_title = "Add New User";
}
# check value
$id = !empty($row["id"]) ? $row["id"] : '0';
$offline = !empty($row["offline"]) ? $row["offline"] : '2';
$username = !empty($row["username"]) ? $row["username"] : '';
$password = !empty($row["password"]) ? $row["password"] : '';
$firstname = !empty($row["firstname"]) ? $row["firstname"] : '';
$lastname = !empty($row["lastname"]) ? $row["lastname"] : '';
$usernamesame = !empty($row["id"]) ? 'true' : 'false';
# photo
$photo = !empty($row["photo"]) ? $row["photo"] : '';
$pathphoto = !empty($photo) ? 'inc/photo/users/'.$photo : 'inc/photo/no-image.jpg' ;
?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">User</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?mode=users/list"> Home </a>
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

        <!-- Form users start -->
        <div class="content-body">
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <!-- <div class="card-header">
                                <h4 class="card-title">Search</h4>
                            </div> -->
                            <div class="card-body">
                                <form action="./?mode=users/save" method="POST" id="frmsearch" name="frmsearch" class="needs-validation" enctype="multipart/form-data" novalidate>
                                    <!-- Hidden input -->
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" id="page_title" name="page_title" value="<?php echo $page_title; ?>">
                                    <input type="hidden" id="usernamesame" name="usernamesame" value="<?php echo $usernamesame; ?>">
                                    <!-- Users photo -->
                                    <div class="media mb-2">
                                        <img src="<?php echo $pathphoto; ?>" alt="users" class="user-photo users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                                        <div class="media-body mt-50">
                                            <h4> <?php echo $page_title; ?> </h4>
                                            <div class="col-12 d-flex mt-1 px-0">
                                                <label class="btn btn-primary mr-75 mb-0" for="photo">
                                                    <span class="d-none d-sm-block">Change</span>
                                                    <input class="form-control" type="file" id="photo" name="photo" value="<?php echo $photo; ?>" hidden accept="image/png, image/jpeg, image/jpg" />
                                                    <input type="hidden" name="del_photo" id="del_photo" value="">
                                                    <span class="d-block d-sm-none">
                                                        <i class="mr-0" data-feather="edit"></i>
                                                    </span>
                                                </label>
                                                <button class="btn btn-outline-secondary d-none d-sm-block" id="remove_photo_user" type="button">Remove</button>
                                                <button class="btn btn-outline-secondary d-block d-sm-none">
                                                    <i class="mr-0" data-feather="trash-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Users edit -->
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
                                                <label for="username">Username</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" onkeyup="checkUsername();" placeholder="" required />
                                                    <div class="invalid-feedback" id="username_feedback">Please enter a username.</div>
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="lock"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="password" name="password" placeholder="" onkeyup="checkPassword();" required />
                                                    <div class="invalid-feedback">Please enter a password.</div>
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="firstname">First Name</label>
                                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstname; ?>" placeholder="" required />
                                                <div class="invalid-feedback">Please enter a firstname.</div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="lastname">Last Name</label>
                                                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname; ?>" placeholder="" required />
                                                <div class="invalid-feedback">Please enter a lastname.</div>
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
                                    // Check Username
                                    function checkUsername() {
                                        var username = document.getElementById('username');
                                        username.value = username.value.replace(/[^A-Za-z0-9]+/, '');
                                        var usernamesame = document.getElementById('usernamesame');

                                        jQuery.ajax({
                                            url: "inc/ajax/backend/users/usernamesame.php",
                                            data: {
                                                username: $("#username").val(),
                                                id: $("#id").val()
                                            },
                                            type: "POST",
                                            success: function(response) {
                                                // alert(response);

                                                if (response == "duplicate") {
                                                    usernamesame.value = false;
                                                    // document.getElementById("username_feedback").classList.add('invalid-feedback');
                                                    $("#username_feedback").html("Please enter a new username. because username duplicate");

                                                    Swal.fire({
                                                        // position: 'top-end',
                                                        type: 'error',
                                                        // title: '',
                                                        text: 'Please enter a new username. because username duplicate',
                                                        showConfirmButton: false,
                                                        timer: 3000
                                                    });
                                                } else if (response == "true") {
                                                    usernamesame.value = true;
                                                    $("#username_feedback").html("Please enter username.");
                                                } else {
                                                    usernamesame.value = false;
                                                    $("#username_feedback").html("Please enter username again.");
                                                }
                                            },
                                            error: function() {}
                                        });
                                    }

                                    // Check Password
                                    function checkPassword() {
                                        var password = document.getElementById('password');
                                        password.value = password.value.replace(/[^A-Za-z0-9#]+/, '');
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
                                                    }
                                                    form.classList.add('was-validated');
                                                }, false);
                                            });
                                        }, false);
                                    })();
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Form users end -->
        </div>
    </div>
</div>