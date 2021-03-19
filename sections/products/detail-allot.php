<?php
if (!empty($_GET["id"])) {
    $query = "SELECT * FROM products_allotment WHERE id > '0' AND id = ? AND products = ? ";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'ii', $_GET["id"], $_GET['products']);
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    if ($numrow > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $page_title = stripslashes(get_value('products', 'id', 'name', $_GET['products'], $mysqli_p));
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=products/list'\" >";
    }
} else {
    $page_title = "Add New Allotment";
}
# check value
$id = !empty($row["id"]) ? $row["id"] : '0';
$offline = !empty($row["offline"]) ? $row["offline"] : '2';
$company = $_SESSION["admin"]["company"];
$type = !empty($_GET['products']) ? get_value('products', 'id', 'products_type', $_GET['products'], $mysqli_p) : '';
$products = !empty($_GET['products']) ? $_GET['products'] : '';
$date_from = !empty($row["date_from"]) ? $row["date_from"] : $today;
$date_to = !empty($row["date_to"]) ? $row["date_to"] : $today;
$pax = !empty($row["pax"]) ? $row["pax"] : '0';
?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> Allotment </h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?mode=products/detail-products&type=<?php echo $type; ?>&id=<?php echo $products; ?>"> <?php echo $page_title; ?> </a>
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
                                    <input type="hidden" id="txt_date" name="txt_date" value="" required>
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
                                                <label for="date_from"> Date From </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='calendar'></i></span>
                                                    </div>
                                                    <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo $date_from; ?>" placeholder="" onchange="checkDate()" />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="date_to"> Date To </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='calendar'></i></span>
                                                    </div>
                                                    <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo $date_to; ?>" placeholder="" onchange="checkDate()" />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <label for="pax"> Pax </label>
                                            <div class="input-group">
                                                <input type="number" id="pax" name="pax" class="touchspin" value="<?php echo $pax; ?>" />
                                            </div>
                                        </div> <!-- div -->
                                    </div>

                                    <hr>

                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12 mt-1">
                                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light" onclick="submitFormAllot()"><i class="fas fa-search"></i>&nbsp;&nbsp;Submit</button>
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
    </div>
</div>

<script>
    // Check Date
    function checkDate() {
        jQuery.ajax({
            url: "sections/products/ajax/checkdate.php",
            data: {
                id: $("#id").val(),
                products: $("#products").val(),
                date_from: $("#date_from").val(),
                date_to: $("#date_to").val()
            },
            type: "POST",
            success: function(response) {
                // $("#div-company").html(response);
                if (response == "true") {
                    document.getElementById("txt_date").value = true;
                } else {
                    document.getElementById("txt_date").value = "";

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

    // Submit form Allotment
    function submitFormAllot() {
        var id = document.getElementById('id');
        var page_title = document.getElementById('page_title');
        var check_offline = document.getElementById('offline');
        if (check_offline.checked) {
            var offline = $('#offline').val();
        } else {
            var offline = '';
        }
        var products = document.getElementById('products');
        var type = document.getElementById('type');
        var pax = document.getElementById('pax');
        var date_from = document.getElementById('date_from');
        var date_to = document.getElementById('date_to');
        var txt_date = document.getElementById('txt_date')
        if(txt_date.value == '') {
            Swal.fire('Error!', 'Error. Please try again', 'error');
            return false
        }
        $.ajax({
            url: "sections/products/ajax/add-allot.php",
            data: {
                id: id.value,
                page_title: page_title.value,
                offline: offline,
                products: products.value,
                type: type.value,
                pax: pax.value,
                date_from: date_from.value,
                date_to: date_to.value
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