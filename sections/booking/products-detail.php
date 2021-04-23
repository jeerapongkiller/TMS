<?php
if (!empty($_GET["id"])) {
    $query = "SELECT * FROM booking_products WHERE id > '0' AND id = ?";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'i', $_GET["id"]);
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    if ($numrow > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $page_title = stripslashes($row["name"]);
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=booking/list'\" >";
    }
} else {
    $page_title = "Add New Products";
}
# check value
$id = !empty($row["id"]) ? $row["id"] : '0';
$company = $_SESSION["admin"]["company"];
$type = !empty($_GET["type"]) ? $_GET["type"] : '';
$booking = !empty($_GET["booking"]) ? $_GET["booking"] : '';
$booking_no = !empty($_GET["booking"]) ? get_value('booking', 'id', 'booking_no', $booking, $mysqli_p) : '';
$bo_full = !empty($booking_no) ? get_value('booking_no', 'id', 'bo_full', $booking_no, $mysqli_p) : '';
$offline = !empty($row["offline"]) ? $row["offline"] : '2';
$bp_supplier = !empty($row["supplier"]) ? $row["supplier"] : '0';
$bp_pickup = !empty($row["pickup"]) ? $row["pickup"] : '0';
$bp_dropoff = !empty($row["dropoff"]) ? $row["dropoff"] : '0';
$add_trans = !empty($row["transfer"]) ? $row["transfer"] : '2';
?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Booking Products</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?mode=booking/detail&id=<?php echo $booking; ?>"> <?php echo $bo_full; ?> </a>
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
                                    <input type="hidden" id="company" name="company" value="<?php echo $company; ?>">
                                    <input type="hidden" id="type" name="type" value="<?php echo $type; ?>">
                                    <input type="hidden" id="bp_dropoff_check" name="bp_dropoff_check" value="<?php echo $bp_dropoff; ?>">
                                    <?php
                                    // $now_date = '2021-04-23';
                                    // $now_time = '10:40';
                                    // $now = $now_date.' '.$now_time;
                                    // $cut_hour = '11:30';
                                    // $cut_no = '48';
                                    // $travel_date = '2021-04-25';
                                    // $cut_t = date('Y-m-d H:i', strtotime($travel_date . ' ' . $cut_hour . '-' . $cut_no . ' hour'));
                                    // echo (strtotime($now) <= strtotime($cut_t)) ? 'true' : 'flase' ;
                                    // echo '</br>';
                                    // echo 'Book start - ' . $cut_t;
                                    // echo '</br>';
                                    // echo 'Now - ' . $now;
                                    ?>

                                    <!-- booking products edit -->
                                    <div class="form-row mt-1">
                                        <div class="col-12">
                                            <h4 class="mb-1">
                                                <i data-feather="book-open" class="font-medium-4 mr-25"></i>
                                                <span class="align-middle"> Products </span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-2 col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="offline" class="mb-1"> Status </label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="offline" name="offline" <?php if ($offline != 2 || !isset($offline)) {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> value="1" />
                                                    <label class="custom-control-label" for="offline"> Offline </label>
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <label for="bp_supplier"> Supplier </label>
                                            <?php
                                            $query_agent = "SELECT combine_agent.*, company.id as comID, company.name as comName 
                                                            FROM combine_agent 
                                                            LEFT JOIN company
                                                            ON combine_agent.supplier = company.id
                                                            WHERE combine_agent.agent = '$company' AND combine_agent.offline = 2 ";
                                            $query_agent .= " ORDER BY comName ASC";
                                            $result_agent = mysqli_query($mysqli_p, $query_agent);
                                            ?>
                                            <select class="custom-select" id="bp_supplier" name="bp_supplier" onchange="checkSupplier()">
                                                <option value="">Please select supplier</option>
                                                <option value="<?php echo $company; ?>"><?php echo get_value('company', 'id', 'name', $company, $mysqli_p) ?></option>
                                                <?php while ($row_agent = mysqli_fetch_array($result_agent, MYSQLI_ASSOC)) {
                                                ?>
                                                    <option value="<?php echo $row_agent["id"]; ?>" <?php if ($bp_supplier == $row_agent["id"]) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                        <?php echo $row_agent["comName"] . '-' . $row_agent["id"]; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback" id="agent_feedback">Please select a Agent..</div>
                                        </div> <!-- </div> -->
                                        <div class="col-xl-3 col-md-6 col-12" id="div-products">
                                            <label for="bp_products"> Products </label>
                                            <select class="custom-select" id="bp_products" name="bp_products">
                                                <option value=""></option>
                                            </select>
                                            <div class="invalid-feedback" id="agent_feedback">Please select a Agent..</div>
                                        </div> <!-- </div> -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="bp_date_travel"> Date Travel </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='calendar'></i></span>
                                                    </div>
                                                    <input type="date" class="form-control" id="bp_date_travel" name="bp_date_travel" value="<?php echo $today; ?>" placeholder="" onchange="checkSupplier()" />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12 text-center">
                                            <label for=""> Period </label></br>
                                            <span style="font-size:16px; font-weight:bold; color:#059DDE" id="span_period"> No relevant period </span>
                                        </div> <!-- </div> -->
                                        <div class="col-xl-2 col-md-3 col-6">
                                            <label for="bp_adults"> Adults </label>
                                            <select class="custom-select" id="bp_adults" name="bp_adults" onchange="checkPrice();">
                                                <?php list_number($bp_adults, '1', '500'); ?>
                                            </select>
                                            <div class="invalid-feedback" id="agent_feedback">Please select a Agent..</div>
                                        </div> <!-- </div> -->
                                        <div class="col-xl-2 col-md-3 col-6">
                                            <label for="bp_children"> Children </label>
                                            <select class="custom-select" id="bp_children" name="bp_children" onchange="checkPrice();">
                                                <?php list_number($bp_children, '0', '501'); ?>
                                            </select>
                                            <div class="invalid-feedback" id="agent_feedback">Please select a Agent..</div>
                                        </div> <!-- </div> -->
                                        <div class="col-xl-2 col-md-3 col-6">
                                            <label for="bp_infant"> Infant </label>
                                            <select class="custom-select" id="bp_infant" name="bp_infant" onchange="checkPrice();">
                                                <?php list_number($bp_infant, '0', '501'); ?>
                                            </select>
                                            <div class="invalid-feedback" id="agent_feedback">Please select a Agent..</div>
                                        </div> <!-- </div> -->
                                    </div>

                                    <!-- booking transfer edit -->
                                    <div class="form-row mt-2">
                                        <div class="col-12">
                                            <h4 class="mb-1">
                                                <i data-feather="truck" class="font-medium-4 mr-25"></i>
                                                <span class="align-middle"> Transfer </span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-2 col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="add_trans" class="mb-1"> Transfer </label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="add_trans" name="add_trans" <?php if ($add_trans != 2 || !isset($add_trans)) {
                                                                                                                                            echo "checked";
                                                                                                                                        } ?> value="1" onclick="checkPrice();" />
                                                    <label class="custom-control-label" for="add_trans"> Add </label>
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <label for="bp_pickup"> Pickup </label>
                                            <?php
                                            $query_pic = "SELECT * FROM place WHERE id > 0 ";
                                            $query_pic .= " ORDER BY name ASC";
                                            $result_pic = mysqli_query($mysqli_p, $query_pic);
                                            ?>
                                            <select class="custom-select" id="bp_pickup" name="bp_pickup" onchange="checkPlace();">
                                                <option value=""> Please select a Pickup .. </option>
                                                <?php while ($row_pic = mysqli_fetch_array($result_pic, MYSQLI_ASSOC)) { ?>
                                                    <option value="<?php echo $row_pic["id"]; ?>" <?php if ($bp_pickup == $row_pic["id"]) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                        <?php echo $row_pic["name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> <!-- </div> -->
                                        <div class="col-xl-3 col-md-6 col-12" id="div-dropoff">
                                            <label for="bp_dropoff"> Dropoff </label>
                                            <select class="custom-select" id="bp_dropoff" name="bp_dropoff">
                                                <option value=""> Please select a Dropoff .. </option>
                                            </select>
                                        </div> <!-- </div> -->
                                    </div>

                                    <!-- booking Prices edit -->
                                    <div class="form-row mt-2">
                                        <div class="col-12">
                                            <h4 class="mb-1">
                                                <i data-feather="dollar-sign" class="font-medium-4 mr-25"></i>
                                                <span class="align-middle"> Prices </span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <!-- Type Hidden Rates -->
                                        <input type="text" name="rate_adult" id="rate_adult" value="">
                                        <input type="text" name="rate_children" id="rate_children" value="">
                                        <input type="text" name="rate_infant" id="rate_infant" value="">
                                        <input type="text" name="rate_group" id="rate_group" value="">
                                        <input type="text" name="products_pax" id="products_pax" value="">
                                        <input type="text" name="rate_transfer" id="rate_transfer" value="">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <label for="bp_default"> Starting Price </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i data-feather='dollar-sign'></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="bp_default" name="bp_default" value="" placeholder="" readonly />
                                            </div>
                                        </div> <!-- </div> -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <label for="bp_latest"> Revised Price </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i data-feather='dollar-sign'></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="bp_latest" name="bp_latest" value="" placeholder="" oninput="priceformat('bp_latest');" />
                                            </div>
                                        </div> <!-- </div> -->
                                    </div>

                                    <div id="div-booking"></div>

                                    <hr>

                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12 mt-1">
                                            <button type="button" class="btn btn-primary mr-1 waves-effect waves-float waves-light" onclick="submitFormProducts();"><i class="fas fa-search"></i>&nbsp;&nbsp;Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Form permission end -->
        </div>
    </div>
</div>
<script>
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

    // Check Pickup and Dropoff
    function checkPlace() {
        var bp_pickup = document.getElementById('bp_pickup');
        var bp_dropoff = document.getElementById('bp_dropoff_check');
        jQuery.ajax({
            url: "sections/booking/ajax/check-place.php",
            data: {
                bp_pickup: bp_pickup.value,
                bp_dropoff: bp_dropoff.value
            },
            type: "POST",
            success: function(response) {
                $("#div-dropoff").html(response)
                checkPeriod()
            },
            error: function() {}
        });
    }

    // Check Supplier Or Agent, Date Traval, Cut Off, Offline
    function checkSupplier() {
        var bp_supplier = document.getElementById('bp_supplier')
        var bp_date_travel = document.getElementById('bp_date_travel')
        var company = document.getElementById('company')
        jQuery.ajax({
            url: "sections/booking/ajax/check-supplier.php",
            data: {
                bp_supplier: bp_supplier.value,
                bp_date_travel: bp_date_travel.value,
                company: company.value
            },
            type: "POST",
            success: function(response) {
                $("#div-products").html(response)
                checkPeriod()
            },
            error: function() {}
        });
    }

    // Check Allotment
    function checkAllotment() {
        var bp_date_travel = document.getElementById('bp_date_travel')
        var bp_products = document.getElementById('bp_products')
        var company = document.getElementById('company')
        var type = document.getElementById('type')
        jQuery.ajax({
            url: "sections/booking/ajax/check-allotment.php",
            data: {
                bp_products: bp_products.value,
                bp_date_travel: bp_date_travel.value,
                company: company.value,
                type: type.value
            },
            type: "POST",
            success: function(response) {
                $("#div-booking").html(response)
            },
            error: function() {}
        });
    }

    function checkPeriod() {
        var bp_date_travel = document.getElementById('bp_date_travel')
        var bp_products = document.getElementById('bp_products')
        var company = document.getElementById('company')
        var type = document.getElementById('type')
        var span_period = document.getElementById('span_period')
        var rate_adult = document.getElementById('rate_adult')
        var rate_children = document.getElementById('rate_children')
        var rate_infant = document.getElementById('rate_infant')
        var rate_group = document.getElementById('rate_group')
        var products_pax = document.getElementById('products_pax')
        var rate_transfer = document.getElementById('rate_transfer')
        jQuery.ajax({
            url: "sections/booking/ajax/check-period.php",
            data: {
                bp_products: bp_products.value,
                bp_date_travel: bp_date_travel.value,
                company: company.value,
                type: type.value
            },
            type: "POST",
            dataType: 'json',
            success: function(response) {
                // console.log(response['0'].name_aff);
                span_period.innerHTML = response['0'].products_period
                rate_adult.value = response['0'].products_adult
                rate_children.value = response['0'].products_children
                rate_infant.value = response['0'].products_infant
                rate_group.value = response['0'].products_group
                products_pax.value = response['0'].products_pax
                rate_transfer.value = response['0'].products_transfer
                checkPrice();
            },
            error: function() {}
        });
    }

    // Calculate Price
    function checkPrice() {
        var type = document.getElementById('type').value;
        var bp_default = document.getElementById('bp_default');
        var bp_latest = document.getElementById('bp_latest');
        var add_trans = document.getElementById('add_trans');
        var check_trans = add_trans.checked ? 'true' : 'false';
        var bp_adults = parseFloat(document.getElementById('bp_adults').value);
        var bp_children = parseFloat(document.getElementById('bp_children').value);
        var bp_infant = parseFloat(document.getElementById('bp_infant').value);
        var rate_adult = parseFloat(document.getElementById('rate_adult').value);
        var rate_children = parseFloat(document.getElementById('rate_children').value);
        var rate_infant = parseFloat(document.getElementById('rate_infant').value);
        var rate_group = parseFloat(document.getElementById('rate_group').value);
        var products_pax = Number(document.getElementById('products_pax').value);
        var rate_transfer = parseFloat(document.getElementById('rate_transfer').value);
        var price_sum = '';
        var pax_mix = bp_adults + bp_children;
        if (type == 1 || type == 2) {
            if (products_pax > 0) {
                if (pax_mix > products_pax) {
                    var pax_profuse = pax_mix - products_pax;
                    if (check_trans == 'true') {
                        price_sum = ((rate_adult * pax_profuse) + (rate_transfer * pax_mix)) + rate_group;
                    } else {
                        price_sum = (rate_adult * pax_profuse) + rate_group;
                    }
                } else {
                    if (check_trans == 'true') {
                        price_sum = (rate_transfer * pax_mix) + rate_group;
                    } else {
                        price_sum = rate_group;
                    }
                }
            } else {
                var price_adults = rate_adult * bp_adults;
                var price_children = rate_children * bp_children;
                if (check_trans == 'true') {
                    price_sum = (price_adults + price_children) + (rate_transfer * pax_mix);
                } else {
                    price_sum = price_adults + price_children;
                }
            }
        }
        bp_default.value = price_sum;
        bp_latest.value = price_sum;
        priceformat('bp_default');
        priceformat('bp_latest');
    }

    // Add products
    function submitFormProducts() {
        var id = document.getElementById('id');
        var page_title = document.getElementById('page_title');
        var company = document.getElementById('company');
        var type = document.getElementById('type');
        var offline = document.getElementById('offline');
        var check_offline = offline.checked ? '1' : '2';
        var bp_supplier = document.getElementById('bp_supplier');
        var bp_products = document.getElementById('bp_products');
        var bp_date_travel = document.getElementById('bp_date_travel');
        var bp_adults = document.getElementById('bp_adults');
        var bp_children = document.getElementById('bp_children');
        var bp_infant = document.getElementById('bp_infant');
        var add_trans = document.getElementById('add_trans');
        var check_trans = add_trans.checked ? 'true' : 'false';
        var bp_pickup = document.getElementById('bp_pickup');
        var bp_dropoff = document.getElementById('bp_dropoff');
        var rate_adult = document.getElementById('rate_adult');
        var rate_children = document.getElementById('rate_children');
        var rate_infant = document.getElementById('rate_infant');
        var rate_group = document.getElementById('rate_group');
        var products_pax = document.getElementById('products_pax');
        var rate_transfer = document.getElementById('rate_transfer');
        var bp_default = document.getElementById('bp_default');
        var bp_latest = document.getElementById('bp_latest');
        jQuery.ajax({
            url: "sections/booking/ajax/add-products.php",
            data: {
                id: id.value,
                page_title: page_title.value,
                company: company.value,
                type: type.value,
                offline: check_offline.value,
                bp_supplier: bp_supplier.value,
                bp_products: bp_products.value,
                bp_date_travel: bp_date_travel.value,
                bp_adults: bp_adults.value,
                bp_children: bp_children.value,
                bp_infant: bp_infant.value,
                add_trans: check_trans.value,
                bp_pickup: bp_pickup.value,
                bp_dropoff: bp_dropoff.value,
                rate_adult: rate_adult.value,
                rate_children: rate_children.value,
                rate_infant: rate_infant.value,
                rate_group: rate_group.value,
                products_pax: products_pax.value,
                rate_transfer: rate_transfer.value,
                bp_default: bp_default.value,
                bp_latest: bp_latest.value
            },
            type: "POST",
            success: function(response) {
                // console.log(response['0'].name_aff);
                $("#div-booking").html(response)
            },
            error: function() {}
        });
    }
</script>