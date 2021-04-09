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
                                                <option value="<?php echo $company; ?>" <?php if ($bp_supplier == 0) {
                                                                                            echo "selected";
                                                                                        } ?>><?php echo get_value('company', 'id', 'name', $company, $mysqli_p) ?></option>
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
                                            <label for=""> Date </label>
                                        </div> <!-- </div> -->
                                    </div>

                                    <!-- booking transfer edit -->
                                    <div class="form-row mt-1">
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
                                            <label for="bp_pickup"> Pickup </label>
                                            <select class="custom-select" id="bp_pickup" name="bp_pickup">
                                                <option value=""></option>
                                            </select>
                                        </div> <!-- </div> -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <label for="bp_dropoff"> Dropoff </label>
                                            <select class="custom-select" id="bp_dropoff" name="bp_dropoff">
                                                <option value=""></option>
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
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <label for="bp_default"> Starting Price </label>
                                            <select class="custom-select" id="bp_default" name="bp_default">
                                                <option value=""></option>
                                            </select>
                                        </div> <!-- </div> -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <label for="bp_latest"> Revised Price </label>
                                            <select class="custom-select" id="bp_latest" name="bp_latest">
                                                <option value=""></option>
                                            </select>
                                        </div> <!-- </div> -->
                                    </div>

                                    <div id="div-booking"></div>

                                    <hr>

                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12 mt-1">
                                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light"><i class="fas fa-search"></i>&nbsp;&nbsp;Submit</button>
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
                checkAllotment()
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
</script>