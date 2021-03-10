<?php
require "inc/connection.php";

if (!empty($_GET["mode"]) && !empty($_SESSION["admin"]["id"])) {
?>
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
        <title>Shambhala Travel</title>
        <link rel="apple-touch-icon" href="assets/images/ico/favicon.png">
        <link rel="shortcut icon" type="image/x-icon" href="assets/images/ico/favicon.png">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

        <!-- BEGIN: Vendor CSS-->
        <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css">
        <link rel="stylesheet" type="text/css" href="assets/vendors/css/extensions/toastr.min.css">
        <!-- BEGIN: Data Table CSS-->
        <link rel="stylesheet" type="text/css" href="assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css">
        <!-- BEGIN: Fontawesome icon CSS-->
        <link rel="stylesheet" type="text/css" href="assets/dist/fontawesome/css/all.css">
        <!-- BEGIN: Pickers Date CSS-->
        <link rel="stylesheet" type="text/css" href="assets/vendors/css/pickers/pickadate/pickadate.css">
        <link rel="stylesheet" type="text/css" href="assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
        <!-- BEGIN: Sweetalert2 CSS-->
        <link rel="stylesheet" type="text/css" href="assets/vendors/css/extensions/sweetalert2.min.css">
        <!-- BEGIN: Select CSS-->
        <link rel="stylesheet" type="text/css" href="assets/vendors/css/forms/select/select2.min.css">

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
        <link rel="stylesheet" type="text/css" href="assets/css/plugins/forms/pickers/form-flat-pickr.css">
        <link rel="stylesheet" type="text/css" href="assets/css/plugins/forms/pickers/form-pickadate.css">
        <link rel="stylesheet" type="text/css" href="assets/css/pages/dashboard-ecommerce.css">
        <link rel="stylesheet" type="text/css" href="assets/css/plugins/charts/chart-apex.css">
        <link rel="stylesheet" type="text/css" href="assets/css/plugins/extensions/ext-component-toastr.css">
        <!-- BEGIN: Custom CSS-->
        <!-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"> -->
        <!-- END: Custom CSS-->

    </head>
    <!-- END: Head-->

    <!-- BEGIN: Body-->

    <body class="vertical-layout vertical-menu-modern  navbar-floating footer-static menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="">

        <!-- ============================================================== -->
        <!-- BEGIN: Header-->
        <?php include 'inc-header.php'; ?>
        <!-- END: Header-->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- BEGIN: Main Menu-->
        <?php include 'inc-menu.php'; ?>
        <!-- END: Main Menu-->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- BEGIN: Content-->
        <?php include "sections/" . $_GET["mode"] . ".php"; ?>
        <!-- END: Content-->
        <!-- ============================================================== -->

        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <!-- BEGIN: Footer-->
        <?php include 'inc-footer.php'; ?>
        <!-- END: Footer-->

        <!-- ============================================================== -->
        <!-- BEGIN: Script -->

        <!-- BEGIN: Vendor JS -->
        <script src="assets/vendors/js/vendors.min.js"></script>
        <!-- END Vendor JS -->

        <!-- BEGIN Data Table JS -->
        <script src="assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
        <script src="assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
        <script src="assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
        <script src="assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
        <!-- END Data Table JS -->

        <!-- BEGIN Pickers JS -->
        <script src="assets/vendors/js/pickers/pickadate/picker.js"></script>
        <script src="assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
        <script src="assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
        <!-- END Pickers JS -->

        <!-- BEGIN Sweetalert2 JS -->
        <script src="assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
        <script src="assets/vendors/js/extensions/polyfill.min.js"></script>
        <!-- END Sweetalert2 JS -->

        <!-- BEGIN Select JS -->
        <script src="assets/vendors/js/forms/select/select2.full.min.js"></script>
        <!-- END Select JS -->

        <!-- BEGIN: Menu Theme JS -->
        <script src="assets/js/core/app-menu.js"></script>
        <script src="assets/js/core/app.js"></script>
        <!-- END: Menu Theme JS -->

        <!-- BEGIN: Page Vendor JS-->
        <script src="assets/vendors/js/extensions/toastr.min.js"></script>
        <!-- END: Page Vendor JS-->

        <!-- Script Ready -->
        <script>
            $(document).ready(function() {
                var str_mode = "<?php echo $_GET["mode"] ?>";
                if (str_mode.indexOf("company/detail-rates") >= 0) {
                    checkAgent();
                }
            });
        </script>

        <!-- Script Data Table -->
        <script>
            /** DataTables Basic **/
            $(function() {
                'use strict';
                $('#datatables-basic').DataTable({
                    "searching": false,
                    order: [
                        [1, 'asc']
                    ], //desc , asc
                    dom: '<<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    displayLength: 7,
                    lengthMenu: [7, 10, 25, 50, 75, 100],
                    columnDefs: [{
                        targets: [6],
                        orderable: false
                    }],
                    language: {
                        paginate: {
                            // remove previous & next text from pagination
                            previous: '&nbsp;',
                            next: '&nbsp;'
                        }
                    }
                });
            });

            /** DataTables Users **/
            $(function() {
                'use strict';
                $('#datatables-users').DataTable({
                    "searching": false,
                    order: [
                        [3, 'asc']
                    ], //desc , asc
                    dom: '<<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    displayLength: 7,
                    lengthMenu: [7, 10, 25, 50, 75, 100],
                    columnDefs: [{
                        targets: [4],
                        orderable: false
                    }],
                    language: {
                        paginate: {
                            // remove previous & next text from pagination
                            previous: '&nbsp;',
                            next: '&nbsp;'
                        }
                    }
                });
            });

            /** DataTables Company **/
            $(function() {
                'use strict';
                $('#datatables-company').DataTable({
                    "searching": false,
                    order: [
                        [1, 'asc']
                    ], //desc , asc
                    dom: '<<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    displayLength: 7,
                    lengthMenu: [7, 10, 25, 50, 75, 100],
                    columnDefs: [{
                        targets: [3, 4, 5],
                        orderable: false
                    }],
                    language: {
                        paginate: {
                            // remove previous & next text from pagination
                            previous: '&nbsp;',
                            next: '&nbsp;'
                        }
                    }
                });
            });

            /** DataTables Permission **/
            $(function() {
                'use strict';
                $('#datatables-permission').DataTable({
                    "searching": false,
                    order: [
                        [1, 'asc']
                    ], //desc , asc
                    dom: '<<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    displayLength: 7,
                    lengthMenu: [7, 10, 25, 50, 75, 100],
                    columnDefs: [{
                        targets: [2],
                        orderable: false
                    }],
                    language: {
                        paginate: {
                            // remove previous & next text from pagination
                            previous: '&nbsp;',
                            next: '&nbsp;'
                        }
                    }
                });
            });
        </script>

        <!-- Script Flatpickr -->
        <script>
            /** Flatpickr **/
            $(function() {
                'use strict';

                /** Booking Search **/
                $('#date-to').flatpickr({
                    // enableTime: true,
                    // dateFormat: "Y-m-d H:i",
                    dateFormat: 'Y-m-d',
                    minDate: $('#date-from').val()
                });
                $('#date-from').flatpickr({
                    dateFormat: 'Y-m-d'
                });
                $('#date-from').on('change', function() {
                    $('#date-to').flatpickr({
                        minDate: this.value
                    });
                    document.getElementById('date-to').value = $('#date-from').val();
                });

                /** Periods date products **/
                $('#periods_to').flatpickr({
                    // enableTime: true,
                    // dateFormat: "Y-m-d H:i",
                    dateFormat: 'Y-m-d',
                    minDate: $('#periods_from').val()
                });
                $('#periods_from').flatpickr({
                    dateFormat: 'Y-m-d'
                });
                $('#periods_from').on('change', function() {
                    $('#periods_to').flatpickr({
                        minDate: this.value
                    });
                    document.getElementById('periods_to').value = $('#periods_from').val();
                });

                /** Booking Search **/
                $('#date-range').flatpickr({
                    // enableTime: true,
                    // dateFormat: "Y-m-d H:i",
                    // dateFormat: 'Y-m-d',
                    // minDate: $('#date-from').val()
                    mode: 'range'
                });
            });
        </script>

        <!-- Script Sweetalert2 -->
        <script>
            function reset() {
                Swal.fire({
                    title: 'Good job!',
                    text: 'You clicked the button!',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            }

            function submit() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Your file has been deleted.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            }
        </script>

        <!-- Script Check Image -->
        <script>
            $(function() {
                'use strict';
                // Check limit file
                // Change user profile picture
                var changePhoto = $('#photo'),
                    viewPhoro = $('.photo'),
                    removePhoto = $('#remove_photo'),
                    noImage = $('#no_image');
                $(changePhoto).on('change', function(e) {
                    if (this.files[0].size > 2000000) {
                        Swal.fire({
                            type: 'error',
                            text: 'limit file size 2 MB',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        this.value = "";
                    } else {
                        var reader = new FileReader(),
                            files = e.target.files;
                        reader.onload = function() {
                            if (viewPhoro.length) {
                                viewPhoro.attr('src', reader.result);
                            }
                        };
                        reader.readAsDataURL(files[0]);
                    }
                })
                $(removePhoto).on('click', function() {
                    document.getElementById('del_photo').value = '1';
                    document.getElementById('photo').value = '';
                    viewPhoro.attr('src', 'inc/photo/no-image.jpg');
                })
            });
        </script>

        <!-- Script Select2 -->
        <script>
            (function(window, document, $) {
                'use strict';
                var select = $('.select2');
                select.each(function() {
                    var $this = $(this);
                    $this.wrap('<div class="position-relative"></div>');
                    $this.select2({
                        // the following code is used to disable x-scrollbar when click in select input and
                        // take 100% width in responsive also
                        dropdownAutoWidth: true,
                        width: '100%',
                        dropdownParent: $this.parent()
                    });
                });

            })(window, document, jQuery);
        </script>

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
        <!-- END: Script -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Start error message -->
        <?php
        if (!empty($_GET["message"])) {
            switch ($_GET["message"]) {
                case "error-login":
                    $message_type = "error";
                    $message_title = "Username or Password is not valid.";
                    break;
                case "error-same":
                    $message_type = "error";
                    $message_title = "สินค้าที่เลือกซ้ำกับสินค้าในการจองนี้ กรุณาเลือกใหม่อีกครั้ง!";
                    break;
                case "error":
                    $message_type = "error";
                    $message_title = "ทำใหม่อีกครั้ง!";
                    break;
                case "success":
                    $message_type = "success";
                    $message_title = "ทำรายการสำเร็จแล้ว";
                    break;
            }
        ?>
            <script type="text/javascript">
                Swal.fire({
                    icon: '<?php echo $message_type; ?>',
                    text: '<?php echo $message_title; ?>',
                    showConfirmButton: false,
                    timer: 3600
                });
            </script>
        <?php
        }
        ?>
        <!-- Start error message -->
        <!-- ============================================================== -->

    </body>
    <!-- END: Body-->

    </html>
<?php
} else {
    if (!empty($_POST["mode"]) && $_POST["mode"] == "authentication/checklogin") {
        include "sections/authentication/checklogin.php"; # go to check login page
    } else {
        // session_destroy();
        unset($_SESSION["admin"]);
        mysqli_close($mysqli_p);
        include "sections/authentication/login.php"; # go to login page
    }
}
?>