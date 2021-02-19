<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Login Page - Vuexy - Bootstrap HTML admin template</title>
    <link rel="apple-touch-icon" href="assets/images/ico/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/ico/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css">
    <!-- BEGIN: Sweetalert2 CSS-->
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/extensions/sweetalert2.min.css">

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="assets/css/pages/page-auth.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-v1 px-2">
                    <div class="auth-inner py-2">
                        <!-- Login v1 -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="brand-logo">
                                    <img src="assets/images/logo/logo.svg" width="50">
                                    <h4 class="brand-text text-primary ml-1">SHAMBHALA<small class="d-block">TRAVEL</small></h4>
                                </a>

                                <h4 class="card-title text-center mb-1">Welcome to Vuexy! 👋</h4>
                                <p class="card-text text-center mb-2">Please sign-in to your account and start the adventure</p>

                                <form class="auth-login-form mt-2" id="frmlogin" name="frmlogin" action="./index.php" method="POST" novalidate>
                                    <input class="form-control" type="hidden" id="mode" name="mode" value="authentication/checklogin">
                                    <div class="form-group">
                                        <label for="lg_username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="lg_username" name="lg_username" placeholder="Username" aria-describedby="lg_username" tabindex="1" autofocus required />
                                    </div>

                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label for="lg_password">Password</label>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" class="form-control form-control-merge" id="lg_password" name="lg_password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="lg_password" required />
                                            <div class="input-group-append">
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="lg_code" class="form-label">Code</label>
                                        <input type="text" class="form-control" id="lg_code" name="lg_code" placeholder="Code" aria-describedby="login_code" tabindex="1" required />
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block" tabindex="4">Sign in</button>

                                    <div class="my-2">
                                        <hr>
                                    </div>

                                    <div class="auth-footer-btn d-flex justify-content-center">
                                        <div class="col-sm-12 text-center">
                                            © <?php echo (date("Y") > "2020") ? '2020 - ' : ''; ?><?php echo date("Y"); ?> Develop by <a href="https://phuketsolution.com" target="_blank">Phuket Solution</a>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <!-- /Login v1 -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN Sweetalert2 JS -->
    <script src="assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="assets/vendors/js/extensions/polyfill.min.js"></script>
    <!-- END Sweetalert2 JS -->

    <!-- BEGIN: Theme JS-->
    <script src="assets/js/core/app-menu.js"></script>
    <script src="assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="assets/js/scripts/pages/page-auth-login.js"></script>
    <!-- END: Page JS-->

    <?php
    echo $_GET['message'];
    if (!empty($_GET['message'])) {
        switch ($_GET['message']) {
            case "error-login":
                $message_type = "error";
                $message_title = "Please login again!";
                break;
            case "error":
                $message_type = "error";
                $message_title = "ลองใหม่อีกครั้ง!";
                break;
            case "success":
                $message_type = "success";
                $message_title = "เสร็จสิ้น!";
                break;
        }
    ?>
        <script type="text/javascript">
            Swal.fire({
                icon: '<?php echo $message_type; ?>',
                text: '<?php echo $message_title; ?>',
                showConfirmButton: false,
                timer: 1800
            });
        </script>
    <?php
    } /* if(!empty($_GET['message'])){ */
    ?>

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
<!-- END: Body-->

</html>