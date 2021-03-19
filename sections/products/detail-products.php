<?php
if (!empty($_GET["id"])) {
    $query = "SELECT * FROM products WHERE id > '0' AND id = ?";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'i', $_GET["id"]);
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    if ($numrow > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $page_title = stripslashes($row["name"]);
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=products/list'\" >";
    }
} else {
    $page_title = "Add New Products";
}
# check value
$id = !empty($row["id"]) ? $row["id"] : '0';
$offline = !empty($row["offline"]) ? $row["offline"] : '2';
$company = $_SESSION["admin"]["company"];
$type = !empty($_GET['type']) ? $_GET['type'] : '';
$name = !empty($row["name"]) ? $row["name"] : '';
$cut_open = !empty($row['cut_open']) ? $row['cut_open'] : '00:00';
$cut_off = !empty($row['cut_off']) ? $row['cut_off'] : '0';
?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> Products </h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?mode=products/list&type=<?php echo $type; ?>"> <?php echo $page_title; ?> </a>
                                </li>
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
                                    <input type="hidden" id="company" name="company" value="<?php echo $company; ?>">
                                    <input type="hidden" id="type" name="type" value="<?php echo $type; ?>">

                                    <!-- Products -->
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
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" placeholder="" required />
                                                <div class="invalid-feedback" id="name_feedback">Please enter a name.</div>
                                            </div>
                                        </div> <!-- div -->
                                    </div>

                                    <!-- Products Cut Off -->
                                    <div class="form-row mt-1">
                                        <div class="col-12">
                                            <h4 class="mb-1">
                                                <i data-feather="clock" class="font-medium-4 mr-25"></i>
                                                <span class="align-middle"> Cut Off </span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="check_cut" name="check_cut" value="1" <?php if ($cut_off != 0) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> onclick="checkCut();" />
                                                    <label class="custom-control-label" for="check_cut"> Cut Off </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="cut_open"> Sales opening time </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='clock'></i></span>
                                                    </div>
                                                    <input type="text" id="cut_open" name="cut_open" class="form-control flatpickr-time text-left" placeholder="" value="<?php echo $cut_open; ?>" />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <label for="cut_off"> Close the sale (Hours) </label>
                                            <div class="input-group">
                                                <input type="number" id="cut_off" name="cut_off" class="touchspin" value="<?php echo $cut_off; ?>" />
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
            <!-- Form company end -->
        </div>
        <!-- Form company end -->

        <!-- Allotment table start -->
        <?php if (!empty($id) && $offline != '1') { ?>
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0"> Allotment (Pax) </h2>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <div class="dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1">
                            <div class="dt-buttons btn-group flex-wrap">
                                <a href="./?mode=products/detail-allot&products=<?php echo $id; ?>" class="btn add-new btn-primary"><span><i class="fas fa-plus"></i>&nbsp;&nbsp;Add Allotment</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table head options start -->
            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive" id="div-allot">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Status</th>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                        <th>Pax</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $companyURL = '';
                                    $query_allot = "SELECT * FROM products_allotment WHERE products = '$id'  ";
                                    $result_allot = mysqli_query($mysqli_p, $query_allot);
                                    while ($row_allot = mysqli_fetch_array($result_allot, MYSQLI_ASSOC)) {
                                        $status_class = $row_allot["offline"] == 1 ? 'badge-light-danger' : 'badge-light-success';
                                        $status_txt = $row_allot["offline"] == 1 ? 'Offline' : 'Online';
                                    ?>
                                        <tr>
                                            <td> <span class="badge badge-pill <?php echo $status_class; ?>"> <?php echo $status_txt; ?> </span> </td>
                                            <td> <?php echo date("d F Y", strtotime($row_allot["date_from"])); ?> </td>
                                            <td> <?php echo date("d F Y", strtotime($row_allot["date_to"])); ?> </td>
                                            <td> <?php echo $row_allot["pax"]; ?> </td>
                                            <td>
                                                <a href="./?mode=products/detail-allot&products=<?php echo $id; ?>&id=<?php echo $row_allot['id']; ?>" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                                <?php if ($row_allot["trash_deleted"] == 1) { ?>
                                                    <?php if ($_SESSION["admin"]["permission"] == 1) { ?>
                                                        <a href="javascript:;" class="item-undo" onclick="restoreAllot(<?php echo $row_allot['id']; ?>)"> <i class="fas fa-undo"></i> </a>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <a href="javascript:;" class="item-trash" onclick="deleteAllot(<?php echo $row_allot['id']; ?>)"> <i class="far fa-trash-alt"></i> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table head options end -->
        <?php } ?>
        <!-- Allotment table end -->

        <div id="div-company"></div>

    </div>
</div>

<script>
    
    // Delete Rates
    function deleteAllot(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: "Do you need delete this information?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No!'
        }).then((result) => {
            if (result.value) {
                jQuery.ajax({
                    url: "sections/products/ajax/delete-allot.php",
                    data: {
                        id: id
                    },
                    type: "POST",
                    success: function(response) {
                        Swal.fire({
                            title: "Completed!",
                            text: "Delete this information Completed",
                            icon: "success"
                        }).then(function() {
                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                        });
                    },
                    error: function() {
                        Swal.fire('Delete this information failed!', 'Please try again', 'error')
                    }
                });
            }
        })
        return true;
    }

    // Restore products
    function restoreAllot(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: "Do you need restore this information?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No!'
        }).then((result) => {
            if (result.value) {
                jQuery.ajax({
                    url: "sections/products/ajax/restore-allot.php",
                    data: {
                        id: id
                    },
                    type: "POST",
                    success: function(response) {
                        Swal.fire({
                            title: "Completed!",
                            text: "Restore this information Completed",
                            icon: "success"
                        }).then(function() {
                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                        });
                    },
                    error: function() {
                        Swal.fire('Restore this information failed!', 'Please try again', 'error')
                    }
                });
            }
        })
        return true;
    }
    
    //Check Cut
    function checkCut() {
        var check_cut = document.getElementById('check_cut')
        var cut_open = document.getElementById('cut_open')
        var cut_off = document.getElementById('cut_off')
        if (check_cut.checked) {
            cut_open.disabled = false;
            cut_off.disabled = false;
        } else {
            cut_open.disabled = true;
            cut_off.disabled = true;
        }
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
                    var check_cut = document.getElementById('check_cut')
                    var cut_open = document.getElementById('cut_open')
                    var cut_off = document.getElementById('cut_off')
                    if (check_cut.checked) {
                        if (cut_off.value == '0') {
                            Swal.fire('Error!', 'Please enter Close the sale (Hours)', 'error')
                            return false
                        }
                    }
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        submitFormProducts();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Submit form company
    function submitFormProducts() {
        var id = document.getElementById('id');
        var page_title = document.getElementById('page_title');
        var check_offline = document.getElementById('offline');
        if (check_offline.checked) {
            var offline = $('#offline').val();
        } else {
            var offline = '';
        }
        var check = document.getElementById('check_cut');
        if (check.checked) {
            var check_cut = document.getElementById('check_cut');
        } else {
            var check_cut = '';
        }
        var company = document.getElementById('company');
        var type = document.getElementById('type');
        var name = document.getElementById('name');
        var cut_open = document.getElementById('cut_open');
        var cut_off = document.getElementById('cut_off');
        $.ajax({
            url: "sections/products/ajax/add-products.php",
            data: {
                id: id.value,
                page_title: page_title.value,
                offline: offline,
                check_cut: check_cut.value,
                company: company.value,
                type: type.value,
                name: name.value,
                cut_open: cut_open.value,
                cut_off: cut_off.value
            },
            type: "POST",
            success: function(response) {
                // $("#div-company").html(response);
                if (response == "false") {
                    Swal.fire({
                        title: "error!",
                        text: "Error. Please try again!",
                        icon: "error"
                    }).then(function() {
                        location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                    });
                } else {
                    Swal.fire({
                        title: "Complete!",
                        icon: "success"
                    }).then(function() {
                        location.href = response;
                    });
                }
            },
            error: function() {
                Swal.fire('Error!', 'Error. Please try again', 'error')
            }
        });
    }
</script>