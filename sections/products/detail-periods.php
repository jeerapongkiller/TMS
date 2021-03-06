<?php
if (empty($_GET["products"])) {
    echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=products/list'\" >";
}
if (!empty($_GET["id"])) {
    $query = "SELECT * FROM products_periods WHERE id > '0' AND id = ?";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'i', $_GET["id"]);
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    if ($numrow > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $page_title = stripslashes($row["periods_from"] . " " . $row["periods_to"]);
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=products/list'\" >";
    }
} else {
    $page_title = "Add New Periods";
}
# check value
$id = !empty($row["id"]) ? $row["id"] : '0';
$offline = !empty($row["offline"]) ? $row["offline"] : '2';
$company = $_SESSION["admin"]["company"];
$products = !empty($_GET["products"]) ? $_GET["products"] : '';
$type = !empty($_GET["type"]) ? $_GET["type"] : '';
$periods_from = !empty($row["periods_from"]) ? $row["periods_from"] : $today;
$periods_to = !empty($row["periods_to"]) ? $row["periods_to"] : $today;
?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Periods</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?mode=products/list&type=<?php echo $type; ?>"> <?php echo get_value('products', 'id', 'name', $_GET["products"], $mysqli_p); ?> </a>
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
                                    <input type="hidden" id="products" name="products" value="<?php echo $products; ?>">
                                    <input type="hidden" id="type" name="type" value="<?php echo $type; ?>">
                                    <input type="hidden" id="txt_periods" name="txt_periods" value="" required>

                                    <!-- company edit -->
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
                                                <label for="periods_from">Periods Date (From)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='calendar'></i></span>
                                                    </div>
                                                    <input type="date" class="form-control" id="periods_from" name="periods_from" value="<?php echo $periods_from; ?>" placeholder="" onchange="checkPeriods()" />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="periods_to">Periods Date (To)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='calendar'></i></span>
                                                    </div>
                                                    <input type="date" class="form-control" id="periods_to" name="periods_to" value="<?php echo $periods_to; ?>" placeholder="" onchange="checkPeriods()" />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                    </div>

                                    <?php if (empty($_GET["id"])) { ?>

                                        <div class="form-row">
                                            <div class="col-xl-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="adult_cost">Adult (Cost)</label>
                                                    <input type="text" class="form-control" id="adult_cost" name="adult_cost" value="" placeholder="" oninput="priceformat('adult_cost');" />
                                                </div>
                                            </div> <!-- div -->
                                            <div class="col-xl-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="adult_sale">Adult (Sale)</label>
                                                    <input type="text" class="form-control" id="adult_sale" name="adult_sale" value="" placeholder="" oninput="priceformat('adult_sale');" />
                                                </div>
                                            </div> <!-- div -->
                                            <div class="col-xl-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="children_cost">Children (Cost)</label>
                                                    <input type="text" class="form-control" id="children_cost" name="children_cost" value="" placeholder="" oninput="priceformat('children_cost');" />
                                                </div>
                                            </div> <!-- div -->
                                            <div class="col-xl-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="children_sale">Children (Sale)</label>
                                                    <input type="text" class="form-control" id="children_sale" name="children_sale" value="" placeholder="" oninput="priceformat('children_sale');" />
                                                </div>
                                            </div> <!-- div -->
                                            <div class="col-xl-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="infant_cost">Infant (Cost)</label>
                                                    <input type="text" class="form-control" id="infant_cost" name="infant_cost" value="" placeholder="" oninput="priceformat('infant_cost');" />
                                                </div>
                                            </div> <!-- div -->
                                            <div class="col-xl-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="infant_sale">Infant (Sale)</label>
                                                    <input type="text" class="form-control" id="infant_sale" name="infant_sale" value="" placeholder="" oninput="priceformat('infant_sale');" />
                                                </div>
                                            </div> <!-- div -->
                                            <div class="col-xl-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="group_cost">Group (Cost)</label>
                                                    <input type="text" class="form-control" id="group_cost" name="group_cost" value="" placeholder="" oninput="priceformat('group_cost');" />
                                                </div>
                                            </div> <!-- div -->
                                            <div class="col-xl-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="group_sale">Group (Sale)</label>
                                                    <input type="text" class="form-control" id="group_sale" name="group_sale" value="" placeholder="" oninput="priceformat('group_sale');" />
                                                </div>
                                            </div> <!-- div -->
                                            <div class="col-xl-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="per_pax">Pax</label>
                                                    <input type="text" class="form-control" id="per_pax" name="per_pax" value="" placeholder="" oninput="priceformat('per_pax');" />
                                                </div>
                                            </div> <!-- div -->
                                            <div class="col-xl-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="transfer_cost">Transfer (Cost)</label>
                                                    <input type="text" class="form-control" id="transfer_cost" name="transfer_cost" value="" placeholder="" oninput="priceformat('transfer_cost');" />
                                                </div>
                                            </div> <!-- div -->
                                            <div class="col-xl-3 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="transfer_sale">Transfer (Sale)</label>
                                                    <input type="text" class="form-control" id="transfer_sale" name="transfer_sale" value="" placeholder="" oninput="priceformat('transfer_sale');" />
                                                </div>
                                            </div> <!-- div -->
                                        </div>

                                    <?php } ?>

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
    </div>
</div>

<script>
    // Check Periods
    function checkPeriods() {
        jQuery.ajax({
            url: "sections/products/ajax/checkperiods.php",
            data: {
                id: $("#id").val(),
                products: $("#products").val(),
                periods_from: $("#periods_from").val(),
                periods_to: $("#periods_to").val()
            },
            type: "POST",
            success: function(response) {
                // $("#div-company").html(response);
                if (response == "true") {
                    document.getElementById("txt_periods").value = true;
                } else {
                    document.getElementById("txt_periods").value = "";

                    Swal.fire({
                        icon: 'error',
                        text: 'Please select time zone agian!',
                        showConfirmButton: false,
                        timer: 2000
                    });
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
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        checkFormPeriods();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Fun Price Format
    function priceformat(inputfield) {
        var i = 0,
            num = 0;
        var j = document.getElementById(inputfield).value;
        while (i < j.length) {
            if (j[i] != ',') {
                num += j[i];
            }
            i++;
        }
        var d = new Number(parseInt(num));
        var n = d.toLocaleString();
        if (n == 0) {
            document.getElementById(inputfield).value = '';
        } else {
            document.getElementById(inputfield).value = n;
        }
    }

    // Check Form
    function checkFormPeriods() {
        var periods_from = $('#periods_from').val();
        var periods_to = $('#periods_to').val();
        var txt_periods = $('#txt_periods').val();
        if (periods_from == '') {
            Swal.fire('Error!', 'Error. Please try again', 'error');
            return false
        }
        if (periods_to == '') {
            Swal.fire('Error!', 'Error. Please try again', 'error');
            return false
        }
        if (txt_periods == '') {
            Swal.fire('Error!', 'Error. Please try again', 'error');
            return false
        }
        submitFormPeriods();
    }

    // Submit form company
    function submitFormPeriods() {
        var id = $('#id').val();
        var page_title = $('#page_title').val();
        var check_offline = document.getElementById('offline');
        if (check_offline.checked) {
            var offline = $('#offline').val();
        } else {
            var offline = '';
        }
        var company = $('#company').val();
        var products = $('#products').val();
        var type = $('#type').val();
        var periods_from = $('#periods_from').val();
        var periods_to = $('#periods_to').val();
        var adult_cost = $('#adult_cost').val();
        var adult_sale = $('#adult_sale').val();
        var children_cost = $('#children_cost').val();
        var children_sale = $('#children_sale').val();
        var infant_cost = $('#infant_cost').val();
        var infant_sale = $('#infant_sale').val();
        var group_cost = $('#group_cost').val();
        var group_sale = $('#group_sale').val();
        var per_pax = $('#per_pax').val();
        var transfer_cost = $('#transfer_cost').val();
        var transfer_sale = $('#transfer_sale').val();

        var fd = new FormData();
        fd.append('id', id);
        fd.append('page_title', page_title);
        fd.append('offline', offline);
        fd.append('company', company);
        fd.append('products', products);
        fd.append('type', type);
        fd.append('periods_from', periods_from);
        fd.append('periods_to', periods_to);
        fd.append('adult_cost', adult_cost);
        fd.append('adult_sale', adult_sale);
        fd.append('children_cost', children_cost);
        fd.append('children_sale', children_sale);
        fd.append('infant_cost', infant_cost);
        fd.append('infant_sale', infant_sale);
        fd.append('group_cost', group_cost);
        fd.append('group_sale', group_sale);
        fd.append('per_pax', per_pax);
        fd.append('transfer_cost', transfer_cost);
        fd.append('transfer_sale', transfer_sale);
        $.ajax({
            type: "POST",
            url: "sections/products/ajax/add-periodsAndcost.php",
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
                        location.href = "./?mode=products/list&type=" + type;
                    })
                }
            },
            error: function() {
                Swal.fire('Error!', 'Error. Please try again', 'error')
            }
        });
    }
</script>