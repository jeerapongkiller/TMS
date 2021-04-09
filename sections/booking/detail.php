<?php
if (!empty($_GET["id"])) {
    $query = "SELECT booking.*, booking_no.id as no_id, booking_no.bo_full as bo_full, booking_no.bo_no as bo_no
            FROM booking
            LEFT JOIN booking_no
            ON booking.booking_no = booking_no.id
            WHERE booking.id > '0' AND booking.id = ?";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'i', $_GET["id"]);
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    if ($numrow > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $page_title = stripslashes($row["customer_firstname"]) . ' ' . stripslashes($row["customer_lastname"]);
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=booking/list'\" >";
    }
} else {
    $page_title = "Add New Booking";

    #--- GET VALUE ---#
    $bo_title = "BO";
    $today_str = explode("-", $today);
    $bo_year = $today_str[0];
    $bo_year_th_full = $today_str[0] + 543;
    $bo_year_th = substr($bo_year_th_full, -2);
    $bo_month = $today_str[1];
    $bo_no_new = 0;

    #--- CHECK TB : Booking ---#
    $query_no = "SELECT * FROM booking_no WHERE id > '0' AND company = '" . $_SESSION["admin"]["company"] . "' ";
    $query_no .= " ORDER BY bo_date DESC, bo_no DESC LIMIT 0,1";
    $procedural_statement_no = mysqli_prepare($mysqli_p, $query_no);
    mysqli_stmt_execute($procedural_statement_no);
    $result_no = mysqli_stmt_get_result($procedural_statement_no);
    $num_no = mysqli_num_rows($result_no);
    if ($num_no > 0) {
        $row_no = mysqli_fetch_array($result_no, MYSQLI_ASSOC);
        $bo_month_sql = setNumberLength($row_no["bo_month"], 2);
        if ($bo_month_sql == $bo_month) {
            if ($row_no["bo_year"] != $bo_year) {
                $bo_no_new = 1;
            } else {
                $bo_no_new = $row_no["bo_no"] + 1;
            }
        } else {
            $bo_no_new = 1;
        }
    } else {
        $bo_no_new = 1;
    }
    $bo_full_new = $bo_title . $bo_year_th . $bo_month . setNumberLength($bo_no_new, 5);
}
# check value
$id = !empty($row["id"]) ? $row["id"] : '0';
$company = $_SESSION["admin"]["company"];
$offline = !empty($row["offline"]) ? $row["offline"] : '2';
$name = !empty($row["name"]) ? $row["name"] : '';
$bo_full = !empty($row["bo_full"]) ? $row["bo_full"] : $bo_full_new;
$bo_no = !empty($row["bo_no"]) ? $row["bo_no"] : $bo_no_new;
$bo_booking_date = !empty($row["booking_date"]) ? $row["booking_date"] : $today;
$bo_booking_date_text = !empty($row["booking_date"]) ? date("d F Y", strtotime($row["booking_date"])) : date("d F Y", strtotime($today));
$bo_agent = !empty($row["agent"]) ? $row["agent"] : '0';
$bo_customertype = ($bo_agent > 0 || $id == 0) ? '1' : '2';
$bo_agent_voucher = !empty($row["agent_voucher"]) ? $row["agent_voucher"] : '';
$bo_sale_name = !empty($row["sale_name"]) ? $row["sale_name"] : '';
$bo_customer_firstname = !empty($row["customer_firstname"]) ? $row["customer_firstname"] : '';
$bo_customer_lastname = !empty($row["customer_lastname"]) ? $row["customer_lastname"] : '';
$bo_customer_mobile = !empty($row["customer_mobile"]) ? $row["customer_mobile"] : '';
$bo_customer_email = !empty($row["customer_email"]) ? $row["customer_email"] : '';
$bo_full_receipt = !empty($row["full_receipt"]) ? $row["full_receipt"] : '2';
$bo_receipt_name = !empty($row["receipt_name"]) ? $row["receipt_name"] : '';
$bo_receipt_taxid = !empty($row["receipt_taxid"]) ? $row["receipt_taxid"] : '';
$bo_receipt_address = !empty($row["receipt_address"]) ? $row["receipt_address"] : '';
$bo_receipt_detail = !empty($row["receipt_detail"]) ? $row["receipt_detail"] : '';
$bo_company_aff = !empty($row["company_aff"]) ? $row["company_aff"] : '';
?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> Booking </h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?mode=booking/list"> Home </a>
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
                    <?php // echo $query_no; 
                    ?>
                </div>
            </div>
        </div>

        <!-- Form permission start -->
        <div class="content-body">
            <!-- Booking edit start -->
            <section class="app-user-edit">
                <div class="card">
                    <div class="card-body">
                        <!-- Tab head start -->
                        <ul class="nav nav-pills justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center active" id="information-tab" data-toggle="tab" href="#information" aria-controls="information" role="tab" aria-selected="true">
                                    <i data-feather="info"></i><span class="d-none d-sm-block">Information</span>
                                </a>
                            </li>
                            <?php if (!empty($_GET["id"])) { ?>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center" id="products-tab" data-toggle="tab" href="#products" aria-controls="products" role="tab" aria-selected="false">
                                        <i data-feather="box"></i><span class="d-none d-sm-block">Products</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center" id="history-tab" data-toggle="tab" href="#history" aria-controls="history" role="tab" aria-selected="false">
                                        <i data-feather='repeat'></i><span class="d-none d-sm-block">History</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                        <!-- Tab head end -->

                        <div class="tab-content">
                            <!-- Information Tab starts -->
                            <div class="tab-pane active" id="information" aria-labelledby="information-tab" role="tabpanel">
                                <form action="javascript:;" method="POST" id="frmpermission" name="frmpermission" class="needs-validation" enctype="multipart/form-data" novalidate>
                                    <!-- Hidden input -->
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" id="page_title" name="page_title" value="<?php echo $page_title; ?>">
                                    <input type="hidden" id="company" name="company" value="<?php echo $company; ?>">
                                    <input type="hidden" id="de_company_aff" name="de_company_aff" value="<?php echo $bo_company_aff; ?>">
                                    <!-- permission edit -->
                                    <div class="form-row mt-1">
                                        <div class="col-12">
                                            <h4 class="mb-1">
                                                <i data-feather='book-open' class="font-medium-4 mr-25"></i>
                                                <span class="align-middle"> Booking Information </span>
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
                                        <div class="col-xl-2 col-md-3 col-12">
                                            <div class="form-group">
                                                <label for="offline" class="mb-1"> Walk In or Agent </label>
                                                <?php
                                                if ($id > 0) {
                                                    $customertype_name = ($bo_agent > 0) ? 'Agent' : 'Walk In';
                                                    echo "<br /><span style=\"font-size:16px; font-weight:bold; color:#0D84DE\">" . $customertype_name . "</span>";
                                                    echo "<br /><input type=\"hidden\" id=\"bo_customertype\" name=\"bo_customertype\" value=\"" . $bo_customertype . "\">";
                                                } else {
                                                ?>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="type_agent" name="bo_customertype" class="custom-control-input" <?php if ($bo_customertype == 1) {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?> value="1" onclick="checkCustomertype(this)" required />
                                                        <label class="custom-control-label" for="type_agent"> Agent </label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="type_walkin" name="bo_customertype" class="custom-control-input" <?php if ($bo_customertype == 2) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> value="2" onclick="checkCustomertype(this)" required />
                                                        <label class="custom-control-label" for="type_walkin"> Walk In </label>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-2 col-md-3 col-12 text-center">
                                            <div class="form-group">
                                                <label for="bo_full_no" class="mb-1"> Booking No. </label><br />
                                                <span class="font-size-20"><?php echo $bo_full; ?></span>
                                                <input type="hidden" class="form-control" id="bo_full_no" name="bo_full_no" placeholder="" value="<?php echo $bo_full; ?>" readonly>
                                                <input type="hidden" class="form-control" id="bo_no" name="bo_no" placeholder="" value="<?php echo $bo_no; ?>" readonly>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-2 col-md-2 col-12 text-center">
                                            <div class="form-group">
                                                <label for="offline" class="mb-1"> Date Booking </label><br />
                                                <span class="font-size-20"><?php echo $bo_booking_date_text; ?></span>
                                                <input type="hidden" class="form-control" id="bo_booking_date" name="bo_booking_date" placeholder="" value="<?php echo $bo_booking_date; ?>" readonly>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-1 col-md-2 col-12 text-center">
                                            <div class="form-group">
                                                <label for="offline" class="mb-1"> Total Booking </label><br />
                                                <span style="font-size:16px; font-weight:bold; color:#059DDE" id="price_total">0</span>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-1 col-md-2 col-12 text-center">
                                            <div class="form-group">
                                                <label for="offline" class="mb-1"> Paid Booking </label><br />
                                                <span style="font-size:16px; font-weight:bold; color:#12AC5D" id="price_paid">0</span>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-1 col-md-2 col-12 text-center">
                                            <div class="form-group">
                                                <label for="offline" class="mb-1"> Balance Booking </label><br />
                                                <span style="font-size:16px; font-weight:bold; color:#BD1A2A" id="price_balance">0</span>
                                            </div>
                                        </div> <!-- div -->
                                    </div>

                                    <div class="form-row mt-3">
                                        <div class="col-12">
                                            <h4 class="mb-1">
                                                <i data-feather='tablet' class="font-medium-4 mr-25"></i>
                                                <span class="align-middle"> Booking Contact </span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="form-row" id="div-agent">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <label for="bo_agent"> Agent </label>
                                            <?php
                                            $query_agent = "SELECT combine_agent.*, company.id as comID, company.name as comName 
                                                            FROM combine_agent 
                                                            LEFT JOIN company
                                                            ON combine_agent.agent = company.id
                                                            WHERE combine_agent.supplier = '$company' AND combine_agent.offline = 2 ";
                                            if ($id > 0) {
                                                $query_agent .= " AND combine_agent.id = '$bo_agent' ";
                                            }
                                            $query_agent .= " ORDER BY comName ASC";
                                            $result_agent = mysqli_query($mysqli_p, $query_agent);
                                            if ($id > 0) {
                                                $row_agent = mysqli_fetch_array($result_agent, MYSQLI_ASSOC);
                                                echo "<br /><span style=\"font-size:16px\">" . $row_agent['comName'] . "</span>";
                                                echo "<br /><input type=\"hidden\" id=\"bo_agent\" name=\"bo_agent\" value=\"" . $bo_agent . "\">";
                                            } else {
                                            ?>
                                                <select class="custom-select" id="bo_agent" name="bo_agent" onchange="checkCompanyAff(this)">
                                                    <option value="" <?php if ($bo_agent == 0) {
                                                                            echo "selected";
                                                                        } ?>>-</option>
                                                    <?php while ($row_agent = mysqli_fetch_array($result_agent, MYSQLI_ASSOC)) {
                                                    ?>
                                                        <option value="<?php echo $row_agent["id"]; ?>" <?php if ($bo_agent == $row_agent["id"]) {
                                                                                                            echo "selected";
                                                                                                        } ?>>
                                                            <?php echo $row_agent["comName"]; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <div class="invalid-feedback" id="agent_feedback">Please select a Agent..</div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="bo_agent_voucher"> Voucher No. (Agent) </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='package'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="bo_agent_voucher" name="bo_agent_voucher" value="<?php echo $bo_agent_voucher; ?>" placeholder="" />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="bo_sale_name"> Name Sale </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='user'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="bo_sale_name" name="bo_sale_name" value="<?php echo $bo_sale_name; ?>" placeholder="" />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">

                                            </div>
                                        </div> <!-- div -->
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="bo_customer_firstname"> Customer Frist Name </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='user'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="bo_customer_firstname" name="bo_customer_firstname" value="<?php echo $bo_customer_firstname; ?>" placeholder="" />
                                                    <div class="invalid-feedback" id="name_feedback">Please enter a Name..</div>
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="bo_customer_lastname"> Customer Last Name </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='user'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="bo_customer_lastname" name="bo_customer_lastname" value="<?php echo $bo_customer_lastname; ?>" placeholder="" />
                                                    <div class="invalid-feedback" id="agent_feedback">Please select a Last Name..</div>
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="bo_customer_mobile"> Customer Phone </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='smartphone'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="bo_customer_mobile" name="bo_customer_mobile" value="<?php echo $bo_customer_mobile; ?>" placeholder="" />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12" id="div-customer">
                                            <div class="form-group">
                                                <label for="bo_customer_email"> Customer Email </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='mail'></i></span>
                                                    </div>
                                                    <input type="email" class="form-control" id="bo_customer_email" name="bo_customer_email" value="<?php echo $bo_customer_email; ?>" placeholder="" />
                                                    <div class="invalid-feedback" id="email_feedback">Please enter a Email.</div>
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                    </div>

                                    <div class="form-row mt-3">
                                        <div class="col-12">
                                            <h4 class="mb-1">
                                                <i data-feather='file-text' class="font-medium-4 mr-25"></i>
                                                <span class="align-middle"> Booking Receipt </span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="bo_full_receipt" class="mb-1"> Receipt </label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="bo_full_receipt" name="bo_full_receipt" <?php if ($bo_full_receipt != 2 || !isset($bo_full_receipt)) {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> value="1" />
                                                    <label class="custom-control-label" for="bo_full_receipt"> Receipt Full </label>
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12" id="div-companyaff">
                                            <div class="form-group">
                                                <label for="bo_company_aff"> Company (Affiliated) </label>
                                                <select class="form-control" name="bo_company_aff" id="bo_company_aff">
                                                    <option value=""></option>
                                                </select>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="bo_receipt_name"> Receipt Name </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='user'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="bo_receipt_name" name="bo_receipt_name" value="<?php echo $bo_receipt_name; ?>" placeholder="" />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="bo_receipt_taxid"> Receipt Tax </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='smartphone'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="bo_receipt_taxid" name="bo_receipt_taxid" value="<?php echo $bo_receipt_taxid; ?>" placeholder="" />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="bo_receipt_address"> Receipt Address </label>
                                                <textarea class="form-control" id="bo_receipt_address" name="bo_receipt_address" cols="30" rows="3"> <?php echo $bo_receipt_address; ?> </textarea>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="bo_receipt_detail"> Receipt Detail </label>
                                                <textarea class="form-control" id="bo_receipt_detail" name="bo_receipt_detail" cols="30" rows="3"> <?php echo $bo_receipt_detail; ?> </textarea>
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
                            </div>
                            <!-- Information Tab ends -->

                            <!-- Products Tab starts -->
                            <div class="tab-pane" id="products" aria-labelledby="products-tab" role="tabpanel">
                                <!-- Card Product start -->
                                <?php
                                    $query_type = "SELECT * FROM products_type WHERE id > '0'";
                                    $query_type .= " ORDER BY id ASC";
                                    $result_type = mysqli_query($mysqli_p, $query_type);
                                    while ($row_type = mysqli_fetch_array($result_type, MYSQLI_ASSOC)) {
                                ?>
                                <div class="card collapse-icon plan-card">
                                    <div class="card-header pb-1">
                                        <h4 class="card-title"> <?php echo $row_type['name']; ?>
                                            <a href="./?mode=booking/detail-products&type=<?php echo $row_type['id']; ?>&booking=<?php echo $id; ?>" data-toggle="tooltip" data-placement="top" title="Add Products"><i data-feather='plus'></i></a>
                                        </h4>
                                    </div>
                                    <div class="card-body p-0 pl-2 pr-2 pb-1">
                                        <!-- Card Name start -->
                                        <div class="collapse-margin" id="accordionExample">
                                            <div class="card">
                                                <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#coll-tour" aria-expanded="false" aria-controls="collapse">
                                                    <span class="lead collapse-title">
                                                        Products 1
                                                    </span>
                                                </div>
                                                <div id="coll-tour" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <p class="card-title"> </p>
                                                        <div class="table-responsive" id="div-products">
                                                            <table class="table">
                                                                <thead class="thead-primary">
                                                                    <tr>
                                                                        <th>Status</th>
                                                                        <th>Name</th>
                                                                        <th>Date Travel</th>
                                                                        <th>Adult</th>
                                                                        <th>Children</th>
                                                                        <th>Infant</th>
                                                                        <th>FOC</th>
                                                                        <th>Pick Up</th>
                                                                        <th>Drop Off</th>
                                                                        <th>Price</th>
                                                                        <th>Status (Email)</th>
                                                                        <th>Status (Confirm)</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>test</td>
                                                                        <td>Dream Covid Pro</td>
                                                                        <td>01 March 2021</td>
                                                                        <td>2</td>
                                                                        <td>1</td>
                                                                        <td>1</td>
                                                                        <td>0</td>
                                                                        <td>Phuket</td>
                                                                        <td>Phang Nga</td>
                                                                        <td>12,000</td>
                                                                        <td>
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input" id="check_confirm" name="check_confirm" value="1" />
                                                                                <label class="custom-control-label" for="check_confirm"> </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input" id="check_email" name="check_email" value="1" />
                                                                                <label class="custom-control-label" for="check_email"> </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>0</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card Name End -->
                                    </div>
                                </div>
                                <?php } ?>
                                <!-- Card Product End -->

                            </div>
                            <!-- Products Tab ends -->

                            <!-- History Tab starts -->
                            <div class="tab-pane" id="history" aria-labelledby="history-tab" role="tabpanel">
                                <table class="table" id="datatables-history">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Products</th>
                                            <th>Working By</th>
                                            <th>IP Address</th>
                                            <th>Date / Time</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!-- History Tab ends -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- Booking ends -->
        </div>
    </div>
</div>

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
                    var id = document.getElementById('id')
                    var bo_agent = document.getElementById('bo_agent')
                    var bo_firstname = document.getElementById('bo_customer_firstname')
                    var bo_customer_email = document.getElementById('bo_customer_email')

                    if (id.value > 0) {
                        var customertype = document.getElementById('bo_customertype').value;
                    } else {
                        var customertype = $('[name="bo_customertype"]:checked').val();
                    }

                    if (customertype == 1) {
                        if (bo_agent.value == '') {
                            bo_agent.setAttribute("required", "");
                            bo_firstname.removeAttribute("required");
                        }
                    } else {
                        if (bo_firstname.value == '') {
                            bo_firstname.setAttribute("required", "");
                            bo_agent.removeAttribute("required");
                        }
                    }

                    if (bo_customer_email.value != '') {
                        bo_customer_email.setAttribute("required", "");
                    }

                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        SubmitFormBooking();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Check Customer type
    function checkCustomertype() {
        var id = document.getElementById('id')
        var div_agent = document.getElementById('div-agent')
        var div_customer = document.getElementById('div-customer')
        var div_companyaff = document.getElementById('div-companyaff')

        if (id.value > 0) {
            var customertype = document.getElementById('bo_customertype').value;
        } else {
            var customertype = $('[name="bo_customertype"]:checked').val();
        }

        if (customertype == 1) {
            div_agent.style.display = "";
            div_companyaff.style.display = "";
            div_customer.style.display = "none";
        } else {
            div_agent.style.display = "none";
            div_companyaff.style.display = "none";
            div_customer.style.display = "";
        }
    }

    // Check Restore Affiliated
    function checkRestoreAff() {
        var restore_aff = document.getElementById('restore_aff')
        if (restore_aff.value == 'false') {
            restore_aff.value = 'true'
        } else {
            restore_aff.value = 'false'
        }
        checkValueAff()
    }

    //Chceck Company Affiliated 
    function checkCompanyAff() {
        var bo_agent = document.getElementById('bo_agent')
        var de_company_aff = document.getElementById('de_company_aff')
        jQuery.ajax({
            url: "sections/booking/ajax/check-companyaff.php",
            data: {
                bo_agent: bo_agent.value,
                de_company_aff: de_company_aff.value
            },
            type: "POST",
            success: function(response) {
                $("#div-companyaff").html(response)
                checkValueAff()
            },
            error: function() {}
        });
    }

    // check Value Affiliated 
    function checkValueAff() {
        var id = document.getElementById('id')
        var de_company_aff = document.getElementById('de_company_aff')
        var bo_com_aff = document.getElementById('bo_company_aff')
        var bo_receipt_name = document.getElementById('bo_receipt_name')
        var bo_receipt_taxid = document.getElementById('bo_receipt_taxid')
        var bo_receipt_address = document.getElementById('bo_receipt_address')
        var bo_receipt_detail = document.getElementById('bo_receipt_detail')
        var restore_aff = document.getElementById('restore_aff')
        if (bo_com_aff.value != '') {
            jQuery.ajax({
                url: "sections/booking/ajax/check-valueaff.php",
                data: {
                    id: id.value,
                    bo_com_aff: bo_com_aff.value,
                    de_company_aff: de_company_aff.value,
                    restore_aff: restore_aff.value
                },
                type: "POST",
                dataType: 'json',
                success: function(response) {
                    // console.log(response['0'].name_aff);
                    bo_receipt_name.value = response['0'].receipt_name
                    bo_receipt_taxid.value = response['0'].receipt_taxid
                    bo_receipt_address.value = response['0'].receipt_address
                    bo_receipt_detail.value = response['0'].receipt_detail
                },
                error: function() {}
            });
        }
    }

    // Submit Form Booking
    function SubmitFormBooking() {
        var id = document.getElementById('id')
        var company = document.getElementById('company')
        var page_title = document.getElementById('page_title')
        var check_offline = document.getElementById('offline')
        if (check_offline.checked) {
            var offline = $('#offline').val();
        } else {
            var offline = '';
        }
        if (id.value > 0) {
            var customertype = document.getElementById('bo_customertype').value;
        } else {
            var customertype = $('[name="bo_customertype"]:checked').val();
        }
        if (customertype == 1) {
            var type_val = customertype
        } else {
            var type_val = customertype
        }
        var bo_full_no = document.getElementById('bo_full_no')
        var bo_no = document.getElementById('bo_no')
        var bo_booking_date = document.getElementById('bo_booking_date')
        var bo_agent = document.getElementById('bo_agent')
        var bo_agent_voucher = document.getElementById('bo_agent_voucher')
        var bo_sale_name = document.getElementById('bo_sale_name')
        var bo_customer_firstname = document.getElementById('bo_customer_firstname')
        var bo_customer_lastname = document.getElementById('bo_customer_lastname')
        var bo_customer_mobile = document.getElementById('bo_customer_mobile')
        var bo_customer_email = document.getElementById('bo_customer_email')
        var check_full_receipt = document.getElementById('bo_full_receipt')
        if (check_full_receipt.checked) {
            var bo_full_receipt = $('#bo_full_receipt').val();
        } else {
            var bo_full_receipt = '';
        }
        var bo_company_aff = document.getElementById('bo_company_aff')
        var bo_receipt_name = document.getElementById('bo_receipt_name')
        var bo_receipt_taxid = document.getElementById('bo_receipt_taxid')
        var bo_receipt_address = document.getElementById('bo_receipt_address')
        var bo_receipt_detail = document.getElementById('bo_receipt_detail')
        jQuery.ajax({
            url: "sections/booking/ajax/save-booking.php",
            data: {
                id: id.value,
                company: company.value,
                page_title: page_title.value,
                offline: offline,
                type_val: type_val,
                bo_full: bo_full_no.value,
                bo_no: bo_no.value,
                booking_date: bo_booking_date.value,
                agent: bo_agent.value,
                agent_voucher: bo_agent_voucher.value,
                sale_name: bo_sale_name.value,
                customer_firstname: bo_customer_firstname.value,
                customer_lastname: bo_customer_lastname.value,
                customer_mobile: bo_customer_mobile.value,
                customer_email: bo_customer_email.value,
                full_receipt: bo_full_receipt,
                company_aff: bo_company_aff.value,
                receipt_name: bo_receipt_name.value,
                receipt_taxid: bo_receipt_taxid.value,
                receipt_address: bo_receipt_address.value,
                receipt_detail: bo_receipt_detail.value
            },
            type: "POST",
            success: function(response) {
                $("#div-booking").html(response)
            },
            error: function() {}
        });
    }
</script>