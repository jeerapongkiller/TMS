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
    $bo_company = $_SESSION["admin"]["company"];
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
    $bo_full_new = $bo_title . setNumberLength($bo_company, 4) . $bo_year_th . $bo_month . setNumberLength($bo_no_new, 5);
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
                                    <i data-feather="info"></i><span class="d-none d-sm-block"> Information </span>
                                </a>
                            </li>
                            <?php if (!empty($_GET["id"])) { ?>
                                <input type="hidden" id="id" name="id" value="<?php echo $_GET["id"]; ?>">

                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center" id="payment-tab" data-toggle="tab" href="#payment" aria-controls="payment" role="tab" aria-selected="false">
                                        <i data-feather='dollar-sign'></i><span class="d-none d-sm-block"> Payment </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center" id="products-tab" data-toggle="tab" href="#products" aria-controls="products" role="tab" aria-selected="false">
                                        <i data-feather="box"></i><span class="d-none d-sm-block"> Products </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center" id="history-tab" data-toggle="tab" href="#history" aria-controls="history" role="tab" aria-selected="false">
                                        <i data-feather='repeat'></i><span class="d-none d-sm-block"> History </span>
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

                            <!-- Payment Tab starts -->
                            <div class="tab-pane" id="payment" aria-labelledby="payment-tab" role="tabpanel">
                                <div class="card-header row">
                                    <div class="content-header-left col-md-6 col-12">
                                        <h5 class="card-title">
                                            <a href="javascript:;" class="btn btn-primary" data-toggle="modal" data-target="#add-payment"><span><i class="fas fa-plus"></i>&nbsp; Add Payment </span></a>
                                        </h5>
                                    </div>
                                    <div class="content-header-right text-md-right col-md-6 col-12">
                                        <h5 class="card-title">
                                            <a href="javascript:;" class="btn btn-primary"><span><i class="fas fa-print"></i>&nbsp; Print Payment </span></a>
                                        </h5>
                                    </div>
                                </div>
                                <table class="table" id="datatables-payment">
                                    <thead>
                                        <tr>
                                            <th> Status </th>
                                            <th> Receipt No. </th>
                                            <th> Products (Date Tarvel) </th>
                                            <th> Payment Date </th>
                                            <th> Price </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query_bpm = "SELECT BPM.*,
                                                BK.id as bkID,
                                                BP.id as bpID, BP.products as bpProducts, BP.travel_date as bpTravel_date,
                                                PD.id as pdID, PD.name as pdName
                                                FROM booking_payment BPM
                                                LEFT JOIN booking_products BP
                                                    ON BPM.booking_products = BP.id
                                                LEFT JOIN booking BK
                                                    ON BPM.booking = BK.id
                                                LEFT JOIN products PD
                                                    ON BP.products = PD.id
                                                WHERE BPM.booking = '$id'
                                        ";
                                        $query_bpm .= " ORDER BY BPM.payment_date ASC";
                                        $result_bpm = mysqli_query($mysqli_p, $query_bpm);
                                        while ($row_bpm = mysqli_fetch_array($result_bpm, MYSQLI_ASSOC)) {
                                            $status_class_bpm = $row_bpm["offline"] == 1 ? 'badge-light-danger' : 'badge-light-success';
                                            $status_txt_bpm = $row_bpm["offline"] == 1 ? 'Offline' : 'Online';
                                        ?>
                                            <tr>
                                                <td> <span class="badge badge-pill <?php echo $status_class_bpm; ?>"> <?php echo $status_txt_bpm; ?> </span> </td>
                                                <td> <?php echo $row_bpm["receip_no"]; ?> </td>
                                                <td> <?php echo $row_bpm["products_all"] == 2 ? $row_bpm["pdName"] . ' (' . date("d F Y", strtotime($row_bpm["bpTravel_date"])) . ')' : 'All Products'; ?> </td>
                                                <td> <?php echo date("d F Y", strtotime($row_bpm["payment_date"])); ?> </td>
                                                <td> <?php echo number_format($row_bpm["payment_price"]); ?> </td>
                                                <td> <a href="javascript:;" data-toggle="modal" data-target="#edit-payment<?php echo $row_bpm["id"]; ?>"> <i class="far fa-edit"></i> </a> </td>
                                            </tr>

                                            <!-- Modal Edit start -->
                                            <div class="modal fade text-left" id="edit-payment<?php echo $row_bpm["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel160"> Add Payment </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="javascript:;" method="POST" id="frmpayment" name="frmpayment" enctype="multipart/form-data">
                                                                <div class="form-row text-md-left">
                                                                    <div class="col-md-3 col-12">
                                                                        <div class="form-group">
                                                                            <label for="pm_offline<?php echo $row_bpm["id"]; ?>" class="mb-1"> Status </label>
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input" id="pm_offline<?php echo $row_bpm["id"]; ?>" name="pm_offline<?php echo $row_bpm["id"]; ?>" value="1" <?php echo ($row_bpm["offline"] != 2) ? 'checked' : ''; ?> />
                                                                                <label class="custom-control-label" for="pm_offline<?php echo $row_bpm["id"]; ?>"> Offline </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-row text-md-left">
                                                                    <div class="col-md-6 col-12 text-center">
                                                                        <div class="form-group">
                                                                            <label for="pm_voucher<?php echo $row_bpm["id"]; ?>" class="mb-1"> Voucher No. </label><br />
                                                                            <span style="font-size:20px; font-weight:bold; color:#059DDE" id="pm_voucher<?php echo $row_bpm["id"]; ?>"> <?php echo $bo_full; ?> </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-12 text-center">
                                                                        <div class="form-group">
                                                                            <label for="pm_date_payment<?php echo $row_bpm["id"]; ?>" class="mb-1"> Date Payment </label><br />
                                                                            <span class="font-size-20"><?php echo date("d F Y", strtotime($row_bpm["payment_date"])); ?></span>
                                                                            <input type="hidden" class="form-control" id="pm_date_payment<?php echo $row_bpm["id"]; ?>" name="pm_date_payment<?php echo $row_bpm["id"]; ?>" value="<?php echo $row_bpm["payment_date"]; ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-12">
                                                                        <div class="form-group">
                                                                            <label for="pm_receipt<?php echo $row_bpm["id"]; ?>"> Receipt No. </label>
                                                                            <input type="text" class="form-control" id="pm_receipt<?php echo $row_bpm["id"]; ?>" name="pm_receipt<?php echo $row_bpm["id"]; ?>" value="<?php echo $row_bpm["receip_no"]; ?>" required />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-12">
                                                                        <div class="form-group">
                                                                            <label for="pm_type<?php echo $row_bpm["id"]; ?>"> Payment Type </label>
                                                                            <?php
                                                                            $query_pt = "SELECT * FROM payment_type WHERE id > 0 ";
                                                                            $query_pt .= " ORDER BY name ASC";
                                                                            $result_pt = mysqli_query($mysqli_p, $query_pt);
                                                                            ?>
                                                                            <select class="custom-select" id="pm_type<?php echo $row_bpm["id"]; ?>" name="pm_type<?php echo $row_bpm["id"]; ?>">
                                                                                <option value=""> Please select payment type </option>
                                                                                <?php while ($row_pt = mysqli_fetch_array($result_pt, MYSQLI_ASSOC)) { ?>
                                                                                    <option value="<?php echo $row_pt["id"]; ?>" <?php echo ($row_pt["id"] == $row_bpm["payment_type"]) ? 'selected' : ''; ?>><?php echo $row_pt["name"]; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-12">
                                                                        <div class="form-group">
                                                                            <?php
                                                                            $query_bppt = "SELECT BP.*, 
                                                                                PD.id as pdID, PD.name as pdName
                                                                                FROM booking_products BP
                                                                                LEFT JOIN products PD
                                                                                    ON BP.products = PD.id
                                                                                WHERE BP.id > 0 AND BP.booking = '$id' ";
                                                                            $query_bppt .= " ORDER BY PD.name ASC";
                                                                            $result_bppt = mysqli_query($mysqli_p, $query_bppt); ?>
                                                                            <label for="pm_products<?php echo $row_bpm["id"]; ?>"> Products </label>
                                                                            <select class="custom-select" id="pm_products<?php echo $row_bpm["id"]; ?>" name="pm_products<?php echo $row_bpm["id"]; ?>">
                                                                                <option value=""> Please select products </option>
                                                                                <option value="all" <?php echo ($row_bpm["booking_products"] == 0 && $row_bpm["products_all"] == 1) ? 'selected' : ''; ?>>
                                                                                    All products
                                                                                </option>
                                                                                <?php while ($row_bppt = mysqli_fetch_array($result_bppt, MYSQLI_ASSOC)) { ?>
                                                                                    <option value="<?php echo $row_bppt['id'] ?>" <?php echo ($row_bppt["id"] == $row_bpm["booking_products"]) ? 'selected' : ''; ?>>
                                                                                        <?php echo $row_bppt['pdName'] . ' (' . date("d F Y", strtotime($row_bppt['travel_date'])) . ')'; ?>
                                                                                    </option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-12">
                                                                        <div class="form-group">
                                                                            <label for="pm_price<?php echo $row_bpm["id"]; ?>"> Payment Price </label>
                                                                            <input type="text" class="form-control" id="pm_price<?php echo $row_bpm["id"]; ?>" name="pm_price<?php echo $row_bpm["id"]; ?>" value="<?php echo $row_bpm["payment_price"]; ?>" oninput="priceformat('<?php echo 'pm_price' . $row_bpm['id']; ?>');" required />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-12">
                                                                        <div class="form-group">
                                                                            <label for="pm_working<?php echo $row_bpm["id"]; ?>"> Working By </label>
                                                                            <input type="text" class="form-control" id="pm_working<?php echo $row_bpm["id"]; ?>" name="pm_working<?php echo $row_bpm["id"]; ?>" value="<?php echo $row_bpm["receiver_name"]; ?>" required />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-12">
                                                                        <label for="pm_photo<?php echo $row_bpm["id"]; ?>"> Photo </label>
                                                                        <?php
                                                                        $img_tmp = !empty($row_bpm["photo"]) ? $row_bpm["photo"] : '';
                                                                        $pathpicture = !empty($img_tmp) ? 'inc/photo/payment/' . $img_tmp : '';
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <input type="file" id="pm_photo<?php echo $row_bpm["id"]; ?>" name="pm_photo<?php echo $row_bpm["id"]; ?>" class="dropify" data-default-file="<?php echo $pathpicture; ?>" data-show-remove="false" data-max-file-size="2M" data-allowed-file-extensions="jpg png" />
                                                                        </div>
                                                                        <?php if ($img_tmp != "") { ?>
                                                                            <div class="custom-control custom-control-danger custom-checkbox mb-1">
                                                                                <input type="checkbox" class="custom-control-input" id="pm_del_photo<?php echo $row_bpm["id"]; ?>" name="pm_del_photo<?php echo $row_bpm["id"]; ?>" value="1" />
                                                                                <label class="custom-control-label" for="pm_del_photo<?php echo $row_bpm["id"]; ?>"><span style="font-weight:bold; color:#FF0000"> Delete Photo </span></label>
                                                                                <input type="hidden" class="form-control" id="pm_tmp_photo<?php echo $row_bpm["id"]; ?>" name="pm_tmp_photo<?php echo $row_bpm["id"]; ?>" value="<?php echo $img_tmp; ?>">
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div> <!-- div -->
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="add_payment('<?php echo $row_bpm['id']; ?>')"> Submit </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Edit end -->

                                        <?php } ?>
                                    </tbody>
                                </table>

                                <!-- Modal Insert start -->
                                <div class="modal fade text-left" id="add-payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myModalLabel160"> Add Payment </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="javascript:;" method="POST" id="frmpayment" name="frmpayment" enctype="multipart/form-data">
                                                    <div class="form-row text-md-left">
                                                        <div class="col-md-3 col-12">
                                                            <div class="form-group">
                                                                <label for="pm_offline" class="mb-1"> Status </label>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="pm_offline" name="pm_offline" value="1" />
                                                                    <label class="custom-control-label" for="pm_offline"> Offline </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row text-md-left">
                                                        <div class="col-md-6 col-12 text-center">
                                                            <div class="form-group">
                                                                <label for="pm_voucher" class="mb-1"> Voucher No. </label><br />
                                                                <span style="font-size:20px; font-weight:bold; color:#059DDE" id="pm_voucher"> <?php echo $bo_full; ?> </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 text-center">
                                                            <div class="form-group">
                                                                <label for="pm_date_payment" class="mb-1"> Date Payment </label><br />
                                                                <span class="font-size-20"><?php echo date("d F Y", strtotime($today)); ?></span>
                                                                <input type="hidden" class="form-control" id="pm_date_payment" name="pm_date_payment" value="<?php echo $today; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group">
                                                                <label for="pm_receipt"> Receipt No. </label>
                                                                <input type="text" class="form-control" id="pm_receipt" name="pm_receipt" value="" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group">
                                                                <label for="pm_type"> Payment Type </label>
                                                                <?php
                                                                $query_pt = "SELECT * FROM payment_type WHERE id > 0 ";
                                                                $query_pt .= " ORDER BY name ASC";
                                                                $result_pt = mysqli_query($mysqli_p, $query_pt);
                                                                if (!empty($pm_id) && $pm_id > 0) {
                                                                    $row_pt = mysqli_fetch_array($result_pt, MYSQLI_ASSOC);
                                                                    echo "<br /><span style=\"font-size:16px\">" . $row_pt['name'] . "</span>";
                                                                    echo "<br /><input type=\"hidden\" id=\"pm_type\" name=\"pm_type\" value=\"" . $row_pt . "\">";
                                                                } else {
                                                                ?>
                                                                    <select class="custom-select" id="pm_type" name="pm_type" onchange="checkCompanyAff(this)">
                                                                        <option value=""> Please select payment type </option>
                                                                        <?php while ($row_pt = mysqli_fetch_array($result_pt, MYSQLI_ASSOC)) {
                                                                        ?>
                                                                            <option value="<?php echo $row_pt["id"]; ?>"><?php echo $row_pt["name"]; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group">
                                                                <?php
                                                                $query_bppt = "SELECT BP.*, 
                                                                                PD.id as pdID, PD.name as pdName
                                                                                FROM booking_products BP
                                                                                LEFT JOIN products PD
                                                                                    ON BP.products = PD.id
                                                                                WHERE BP.id > 0 AND BP.booking = '$id' ";
                                                                $query_bppt .= " ORDER BY PD.name ASC";
                                                                $result_bppt = mysqli_query($mysqli_p, $query_bppt); ?>
                                                                <label for="pm_products"> Products </label>
                                                                <select class="custom-select" id="pm_products" name="pm_products">
                                                                    <option value=""> Please select products </option>
                                                                    <option value="all"> All products </option>
                                                                    <?php while ($row_bppt = mysqli_fetch_array($result_bppt, MYSQLI_ASSOC)) { ?>
                                                                        <option value="<?php echo $row_bppt['id'] ?>"><?php echo $row_bppt['pdName'] . ' (' . date("d F Y", strtotime($row_bppt['travel_date'])) . ')'; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group">
                                                                <label for="pm_price"> Payment Price </label>
                                                                <input type="text" class="form-control" id="pm_price" name="pm_price" value="" oninput="priceformat('pm_price');" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group">
                                                                <label for="pm_working"> Working By </label>
                                                                <input type="text" class="form-control" id="pm_working" name="pm_working" value="" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <label for="pm_photo"> Photo </label>
                                                            <div class="form-group">
                                                                <input type="file" id="pm_photo" name="pm_photo" class="dropify" data-default-file="" data-show-remove="false" data-max-file-size="2M" data-allowed-file-extensions="jpg png" />
                                                            </div>
                                                            <?php
                                                            $img_tmp = !empty($row["photo"]) ? $row["photo"] : '';
                                                            $pathpicture = !empty($img_tmp) ? '../inc/photo/payment/' . $img_tmp : '';
                                                            if ($img_tmp != "") {
                                                            ?>
                                                                <div class="custom-control custom-control-danger custom-checkbox mb-1">
                                                                    <input type="checkbox" class="custom-control-input" id="pm_del_photo" name="pm_del_photo" value="1" />
                                                                    <label class="custom-control-label" for="pm_del_photo"><span style="font-weight:bold; color:#FF0000"> Delete Photo </span></label>
                                                                    <input type="hidden" class="form-control" id="pm_tmp_photo" name="pm_tmp_photo" value="<?php echo $img_tmp; ?>">
                                                                </div>
                                                            <?php } ?>
                                                        </div> <!-- div -->
                                                    </div>

                                                    <!-- <div class="form-row">
                                                        <?php
                                                        for ($i = 1; $i <= 1; $i++) {
                                                            $img_tmp = !empty($row["photo" . $i]) ? $row["photo" . $i] : '';
                                                            $pathpicture = !empty($img_tmp) ? '../inc/photo/supplier/' . $img_tmp : '';
                                                        ?>
                                                            <div class="col-md-3 mb-3">
                                                                <label for="photo<?php echo $i; ?>"> Photo </label>
                                                                <?php if ($img_tmp != "") { ?>
                                                                    <label class="m-l-15">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="del_photo<?php echo $i; ?>" name="del_photo<?php echo $i; ?>" value="1">
                                                                            <label class="custom-control-label" for="del_photo<?php echo $i; ?>">ลบภาพ</label>
                                                                            <input type="hidden" class="form-control" id="tmp_photo<?php echo $i; ?>" name="tmp_photo<?php echo $i; ?>" value="<?php echo $img_tmp; ?>">
                                                                        </div>
                                                                    </label>
                                                                <?php } ?>
                                                                <div class="input-group">
                                                                    <input type="file" id="photo<?php echo $i; ?>" name="photo<?php echo $i; ?>" class="dropify" data-default-file="<?php echo $pathpicture; ?>" data-show-remove="false" data-max-file-size="2M" data-allowed-file-extensions="jpg png" />
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <input type="hidden" class="form-control" id="photo_count" name="photo_count" value="<?php echo $i - 1; ?>">
                                                    </div> -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="add_payment('0')"> Submit </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Insert end -->

                            </div>
                            <!-- Payment Tab ends -->

                            <!-- Products Tab starts -->
                            <div class="tab-pane" id="products" aria-labelledby="products-tab" role="tabpanel">
                                <!-- Card Product start -->
                                <?php
                                $query_pt = "SELECT * FROM products_type WHERE id > 0";
                                $query_pt .= " ORDER BY id ASC";
                                $result_pt = mysqli_query($mysqli_p, $query_pt);
                                while ($row_pt = mysqli_fetch_array($result_pt, MYSQLI_ASSOC)) {
                                ?>
                                    <div class="card collapse-icon plan-card">
                                        <div class="card-body p-0 pl-2 pr-2 pb-1">
                                            <!-- Card Name start -->
                                            <div class="collapse-margin" id="accordionExample">
                                                <div class="card">
                                                    <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#coll-<?php echo $row_pt["name"]; ?>" aria-expanded="false" aria-controls="collapse">
                                                        <span class="lead collapse-title">
                                                            <h4><?php echo $row_pt["name"]; ?></h4>
                                                        </span>
                                                    </div>
                                                    <div id="coll-<?php echo $row_pt["name"]; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <p class="card-title">
                                                                <!-- <a href="./?mode=booking/products-detail&type=<?php echo $row_pt['id']; ?>&booking=<?php echo $id; ?>" data-toggle="tooltip" data-placement="top" title="Add Products"><i data-feather='plus'></i></a> -->
                                                                <a href="./?mode=booking/products-detail&type=<?php echo $row_pt['id']; ?>&booking=<?php echo $id; ?>" class="btn add-new btn-primary"><span><i class="fas fa-plus"></i>&nbsp;&nbsp; <?php echo 'Add ' . $row_pt["name"]; ?> </span></a>
                                                            </p>
                                                            <div class="table-responsive" id="div-products">
                                                                <table class="table" id="datatables-booking-<?php echo $row_pt["name"]; ?>">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Status</th>
                                                                            <th>Name</th>
                                                                            <th>Date Travel</th>
                                                                            <th>ADL</th>
                                                                            <th>CHD</th>
                                                                            <th>INF</th>
                                                                            <th>Pick Up</th>
                                                                            <th>Drop Off</th>
                                                                            <th>Price</th>
                                                                            <th>Status (Email)</th>
                                                                            <th>Status (Confirm)</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $query_bp = "SELECT BP.*,
                                                                                    PT.id as ptID, PT.name as ptName,
                                                                                    PD.id as pdID, PD.name as pdName
                                                                                    FROM booking_products BP
                                                                                    LEFT JOIN products_type PT
                                                                                        ON BP.products_type = PT.id
                                                                                    LEFT JOIN products PD
                                                                                        ON BP.products = PD.id
                                                                                    WHERE BP.booking = '$id' AND PT.id = '" . $row_pt["id"] . "'
                                                                                    ";
                                                                        $query_bp .= " ORDER BY BP.travel_date ASC";
                                                                        $result_bp = mysqli_query($mysqli_p, $query_bp);
                                                                        while ($row_bp = mysqli_fetch_array($result_bp, MYSQLI_ASSOC)) {
                                                                            $status_class = $row_bp["offline"] == 1 ? 'badge-light-danger' : 'badge-light-success';
                                                                            $status_txt = $row_bp["offline"] == 1 ? 'Offline' : 'Online';
                                                                        ?>
                                                                            <tr>
                                                                                <td> <span class="badge badge-pill <?php echo $status_class; ?>"> <?php echo $status_txt; ?> </span> </td>
                                                                                <td> <?php echo $row_bp["pdName"]; ?> </td>
                                                                                <td> <?php echo date("d F Y", strtotime($row_bp["travel_date"])); ?> </td>
                                                                                <td> <?php echo $row_bp["adults"]; ?> </td>
                                                                                <td> <?php echo $row_bp["children"]; ?> </td>
                                                                                <td> <?php echo $row_bp["infant"]; ?> </td>
                                                                                <td> <?php echo !empty($row_bp["pickup"]) ? get_value('place', 'id', 'name', $row_bp["pickup"], $mysqli_p) : '-'; ?> </td>
                                                                                <td> <?php echo !empty($row_bp["dropoff"]) ? get_value('place', 'id', 'name', $row_bp["dropoff"], $mysqli_p) : '-'; ?> </td>
                                                                                <td> <?php echo number_format($row_bp["price_latest"]); ?> </td>
                                                                                <td>
                                                                                    <div class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" id="check_confirm<?php echo $row_bp["id"]; ?>" name="check_confirm<?php echo $row_bp["id"]; ?>" value="1" />
                                                                                        <label class="custom-control-label" for="check_confirm<?php echo $row_bp["id"]; ?>"> </label>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="custom-control custom-checkbox">
                                                                                        <input type="checkbox" class="custom-control-input" id="check_email<?php echo $row_bp["id"]; ?>" name="check_email<?php echo $row_bp["id"]; ?>" value="1" />
                                                                                        <label class="custom-control-label" for="check_email<?php echo $row_bp["id"]; ?>"> </label>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="<?php echo './?mode=booking/products-detail&type=' . $row_bp['ptID'] . '&booking=' . $id . '&id=' . $row_bp["id"] ?>" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                                                                    <?php if ($row_bp["trash_deleted"] == 1) { ?>
                                                                                        <?php if ($_SESSION["admin"]["permission"] == 1) { ?>
                                                                                            <a href="javascript:;" class="item-undo" onclick="restoreRates(<?php echo $row_bp['id']; ?>)"> <i class="fas fa-undo"></i> </a>
                                                                                        <?php } ?>
                                                                                    <?php } else { ?>
                                                                                        <a href="javascript:;" class="item-trash" onclick="deleteRates(<?php echo $row_bp['id']; ?>)"> <i class="far fa-trash-alt"></i> </a>
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
                                            </div>
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
                                        <?php
                                        $query_bh = "SELECT BH.*,
                                                    HT.id as htID, HT.name as htName,
                                                    BK.id as bkID,
                                                    BP.id as bpID, BP.products as bpProducts,
                                                    PD.id as pdID, PD.name as pdName,
                                                    US.id as usID, US.permission as uspermiss,
                                                    PM.id as pmID, PM.name as pmName
                                                    FROM booking_history BH
                                                    LEFT JOIN history_type HT
                                                        ON BH.history_type = HT.id
                                                    LEFT JOIN booking BK
                                                        ON BH.booking = BK.id
                                                    LEFT JOIN booking_products BP
                                                        ON BH.booking_products = BP.id
                                                    LEFT JOIN products PD
                                                        ON BP.products = PD.id
                                                    LEFT JOIN users US
                                                        ON BH.users = US.id
                                                    LEFT JOIN permission PM
                                                        ON US.permission = PM.id
                                                    WHERE BH.booking = '$id'
                                                    ";
                                        $query_bh .= " ORDER BY BH.date_create ASC";
                                        $result_bh = mysqli_query($mysqli_p, $query_bh);
                                        while ($row_bh = mysqli_fetch_array($result_bh, MYSQLI_ASSOC)) {
                                        ?>
                                            <tr>
                                                <td> <?php echo $row_bh["htName"]; ?> </td>
                                                <td> <?php echo $row_bh["pdName"]; ?> </td>
                                                <td> <?php echo $row_bh["pmName"]; ?> </td>
                                                <td> <?php echo $row_bh["ip_address"]; ?> </td>
                                                <td> <?php echo date("d F Y H:i", strtotime($row_bh["date_create"])); ?> </td>
                                                <td>
                                                    <a href="javascript:;" class="item-trash" data-toggle="modal" data-target="<?php echo '#history' . $row_bh["id"]; ?>">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <!-- Modal -->
                                            <div class="modal fade text-left modal-primary" id="<?php echo 'history' . $row_bh["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel160"> <?php echo $row_bh["pdName"]; ?> </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo nl2br($row_bh["description_field"]); ?>
                                                            <?php echo 'Listed by : ' . $row_bh["pmName"]; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- History Tab ends -->
                        </div>
                    </div>
                </div>
            </section>
            <div id="div-booking"></div>
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
            document.getElementById(inputfield).value = 0;
        } else {
            document.getElementById(inputfield).value = n;
        }
    }

    // Add Payment
    function add_payment(valid) {
        var booking = $('#id').val();
        var pm_id = valid;
        if (pm_id > 0) {
            var check_offline = document.getElementById('pm_offline' + pm_id);
            var pm_date_payment = $('#pm_date_payment' + pm_id).val();
            var pm_receipt = $('#pm_receipt' + pm_id).val();
            var pm_type = $('#pm_type' + pm_id).val();
            var pm_products = $('#pm_products' + pm_id).val();
            var pm_price = $('#pm_price' + pm_id).val();
            var pm_working = $('#pm_working' + pm_id).val();
            var pm_photo = $('#pm_photo' + pm_id)[0].files[0];
            var pm_tmp_photo = $('#pm_tmp_photo' + pm_id).val();
            var check_del_photo = document.getElementById('pm_del_photo' + pm_id);
            if(check_del_photo != null){
                if (check_del_photo.checked) {
                var pm_del_photo = $('#pm_del_photo' + pm_id).val();
                } else {
                    var pm_del_photo = '';
                }
            } else {
                var pm_del_photo = '';
                var pm_tmp_photo = '';
            }
        } else {
            var check_offline = document.getElementById('pm_offline');
            var pm_date_payment = $('#pm_date_payment').val();
            var pm_receipt = $('#pm_receipt').val();
            var pm_type = $('#pm_type').val();
            var pm_products = $('#pm_products').val();
            var pm_price = $('#pm_price').val();
            var pm_working = $('#pm_working').val();
            var pm_photo = $('#pm_photo')[0].files[0];
            var pm_del_photo = '';
            var pm_tmp_photo = '';
        }
        if (check_offline.checked) {
            var pm_offline = 1;
        } else {
            var pm_offline = 2;
        }
        var fd = new FormData();
        fd.append('booking', booking);
        fd.append('pm_id', pm_id);
        fd.append('pm_offline', pm_offline);
        fd.append('pm_date_payment', pm_date_payment);
        fd.append('pm_receipt', pm_receipt);
        fd.append('pm_type', pm_type);
        fd.append('pm_products', pm_products);
        fd.append('pm_price', pm_price);
        fd.append('pm_working', pm_working);
        fd.append('pm_tmp_photo', pm_tmp_photo);
        fd.append('pm_del_photo', pm_del_photo);
        fd.append('pm_photo', pm_photo);

        $.ajax({
            type: "POST",
            url: "sections/booking/ajax/save-payment.php",
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: fd,
            success: function(response) {
                // $("#div-booking").html(response);
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
                        location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                    })
                }
            },
            error: function() {
                Swal.fire('Error!', 'Error. Please try again', 'error')
            }
        });
    }

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
                // $("#div-booking").html(response)
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
                    }).then(function() {
                        if(response == 'true') {
                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                        } else {
                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>" + response;
                        }
                    })
                }
            },
            error: function() {}
        });
    }
</script>