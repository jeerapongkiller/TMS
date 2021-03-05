<?php
if (empty($_GET["company"]) || empty($_GET["periods"])) {
    echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=company/list'\" >";
}
if (!empty($_GET["id"])) {
    $query = "SELECT products_rates.*, products_periods.id as PPID, products_periods.products as PPp, products_periods.periods_from as PPpf, products_periods.periods_to as PPpt,
            products.id as PID, products.products_type as Ppt, products.name as pName
            FROM products_rates 
            LEFT JOIN products_periods 
            ON products_rates.products_periods = products_periods.id
            LEFT JOIN products 
            ON products_periods.products = products.id
            WHERE products_rates.id > '0' AND products_rates.id = ?";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'i', $_GET["id"]);
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    if ($numrow > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $page_title = $row["pName"] . ' (' . $row["PPpf"] . ' - ' . $row["PPpt"] . ')';
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=company/list'\" >";
    }
} else {
    $page_title = "Add New Rates";
}
# check value
$id = !empty($row["id"]) ? $row["id"] : '0';
$offline = !empty($row["offline"]) ? $row["offline"] : '2';
$company = !empty($_GET["company"]) ? $_GET["company"] : '';
$periods = !empty($_GET["periods"]) ? $_GET["periods"] : '';
$type_products = !empty($row["Ppt"]) ? $row["Ppt"] : '';
$type_rates = !empty($row["type_rates"]) ? $row["type_rates"] : '';
$periods_from = !empty($row["PPpf"]) ? $row["PPpf"] : '';
$periods_to = !empty($row["PPpt"]) ? $row["PPpt"] : '';
$rate_adult = !empty($row["rate_adult"]) ? number_format($row["rate_adult"]) : '0';
$rate_children = !empty($row["rate_children"]) ? number_format($row["rate_children"]) : '0';
$rate_infant = !empty($row["rate_infant"]) ? number_format($row["rate_infant"]) : '0';
$rate_group = !empty($row["rate_group"]) ? number_format($row["rate_group"]) : '0';
$pax = !empty($row["pax"]) ? $row["pax"] : '0';
$rate_transfer = !empty($row["rate_transfer"]) ? number_format($row["rate_transfer"]) : '0';
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
                                <li class="breadcrumb-item"><a href="./?mode=company/detail&id=<?php echo $_GET["company"]; ?>"> <?php echo $page_title; ?> </a>
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
                                    <input type="hidden" id="periods" name="periods" value="<?php echo $periods; ?>">
                                    <input type="hidden" id="type_products" name="type_products" value="<?php echo $type_products; ?>">
                                    <input type="hidden" id="type_rates" name="type_rates" value="<?php echo $type_rates; ?>">
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
                                                    <input type="date" class="form-control" id="periods_from" name="periods_from" value="<?php echo $periods_from; ?>" placeholder="" <?php echo $id > 0 ? 'disabled' : 'readonly'; ?> />
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
                                                    <input type="date" class="form-control" id="periods_to" name="periods_to" value="<?php echo $periods_to; ?>" placeholder="" <?php echo $id > 0 ? 'disabled' : 'readonly'; ?> />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                    </div>

                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="adult">Adult </label>
                                                <input type="text" class="form-control" id="adult" name="adult" value="<?php echo $rate_adult; ?>" placeholder="" oninput="priceformat('adult');" required />
                                                <div class="invalid-feedback">Please enter a Adult.</div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="children">Children </label>
                                                <input type="text" class="form-control" id="children" name="children" value="<?php echo $rate_children; ?>" placeholder="" oninput="priceformat('children');" />
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="infant">Infant </label>
                                                <input type="text" class="form-control" id="infant" name="infant" value="<?php echo $rate_infant; ?>" placeholder="" oninput="priceformat('infant');" />
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="group">Group </label>
                                                <input type="text" class="form-control" id="group" name="group" value="<?php echo $rate_group; ?>" placeholder="" oninput="priceformat('group');" />
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="pax">Pax</label>
                                                <input type="text" class="form-control" id="pax" name="pax" value="<?php echo $pax; ?>" placeholder="" oninput="priceformat('pax');" />
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="transfer">Transfer</label>
                                                <input type="text" class="form-control" id="transfer" name="transfer" value="<?php echo $rate_transfer; ?>" placeholder="" oninput="priceformat('transfer');" />
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

                                    function checkFormPeriods() {
                                        var group = document.getElementById('group')
                                        var pax = document.getElementById('pax')
                                        if (group.value != '') {
                                            if (pax.value == '') {
                                                Swal.fire('Error!', 'Error. Please Enter a Pax', 'error');
                                                return false;
                                            }
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
                                        var periods = $('#periods').val();
                                        var type_products = $('#type_products').val();
                                        var type_rates = $('#type_rates').val();
                                        var adult = $('#adult').val();
                                        var children = $('#children').val();
                                        var infant = $('#infant').val();
                                        var group = $('#group').val();
                                        var pax = $('#pax').val();
                                        var transfer = $('#transfer').val();

                                        var fd = new FormData();
                                        fd.append('id', id);
                                        fd.append('page_title', page_title);
                                        fd.append('offline', offline);
                                        fd.append('company', company);
                                        fd.append('periods', periods);
                                        fd.append('type_products', type_products);
                                        fd.append('type_rates', type_rates);
                                        fd.append('adult', adult);
                                        fd.append('children', children);
                                        fd.append('infant', infant);
                                        fd.append('group', group);
                                        fd.append('pax', pax);
                                        fd.append('transfer', transfer);
                                        $.ajax({
                                            type: "POST",
                                            url: "sections/company/ajax/add-rates.php",
                                            dataType: 'text', // what to expect back from the PHP script, if anything
                                            cache: false,
                                            contentType: false,
                                            processData: false,
                                            data: fd,
                                            success: function(response) {
                                                $("#div-company").html(response);
                                                // if (response == 'false') {
                                                //     Swal.fire({
                                                //         icon: 'error',
                                                //         title: 'Error. Please try again!',
                                                //         showConfirmButton: false,
                                                //         timer: 3000
                                                //     });
                                                // } else {
                                                //     Swal.fire({
                                                //         icon: 'success',
                                                //         title: 'Complete!',
                                                //         showConfirmButton: false,
                                                //         timer: 3600
                                                //     }).then((result) => {
                                                //         location.href = "./?mode=company/detail&id=" + company;
                                                //     })
                                                // }
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