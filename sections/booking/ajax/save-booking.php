<?php
require("../../../inc/connection.php");

// echo 'id - ' . $_POST["id"] . '</br>';
// echo 'company - ' . $_POST["company"] . '</br>';
// echo 'page_title - ' . $_POST["page_title"] . '</br>';
// echo 'offline - ' . $_POST["offline"] . '</br>';
// echo 'type_val - ' . $_POST["type_val"] . '</br>';
// echo 'full_no - ' . $_POST["full_no"] . '</br>';
// echo 'booking_date - ' . $_POST["booking_date"] . '</br>';
// echo 'agent - ' . $_POST["agent"] . '</br>';
// echo 'agent_voucher - ' . $_POST["agent_voucher"] . '</br>';
// echo 'sale_name - ' . $_POST["sale_name"] . '</br>';
// echo 'customer_firstname - ' . $_POST["customer_firstname"] . '</br>';
// echo 'customer_lastname - ' . $_POST["customer_lastname"] . '</br>';
// echo 'customer_mobile - ' . $_POST["customer_mobile"] . '</br>';
// echo 'customer_email - ' . $_POST["customer_email"] . '</br>';
// echo 'full_receipt - ' . $_POST["full_receipt"] . '</br>';
// echo 'company_aff - ' . $_POST["company_aff"] . '</br>';
// echo 'receipt_name - ' . $_POST["receipt_name"] . '</br>';
// echo 'receipt_taxid - ' . $_POST["receipt_taxid"] . '</br>';
// echo 'receipt_address - ' . $_POST["receipt_address"] . '</br>';
// echo 'receipt_detail - ' . $_POST["receipt_detail"] . '</br>';

// echo 'bo_title - ' . $bo_title . '</br>';
// echo 'bo_date - ' . $today . '</br>';
// echo 'bo_year - ' . $bo_year . '</br>';
// echo 'bo_year_th - ' . $bo_year_th . '</br>';
// echo 'bo_month - ' . $bo_month . '</br>';
// echo 'bo_no - ' . $_POST["bo_no"] . '</br>';
// echo 'bo_full - ' . $_POST["bo_full"] . '</br>';
// exit();

#----- General Information -----#
$id = !empty($_POST["id"]) ? $_POST["id"] : '';
$company = !empty($_POST["company"]) ? $_POST["company"] : '';
$page_title = !empty($_POST["page_title"]) ? $_POST["page_title"] : '';
$offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
$type_val = !empty($_POST["type_val"]) ? $_POST["type_val"] : '';
$bo_full = !empty($_POST["bo_full"]) ? $_POST["bo_full"] : '';
$booking_date = !empty($_POST["booking_date"]) ? $_POST["booking_date"] : '';
$agent = !empty($_POST["agent"]) ? $_POST["agent"] : '';
$agent_voucher = !empty($_POST["agent_voucher"]) ? $_POST["agent_voucher"] : '';
$sale_name = !empty($_POST["sale_name"]) ? $_POST["sale_name"] : '';
$customer_firstname = !empty($_POST["customer_firstname"]) ? $_POST["customer_firstname"] : '';
$customer_lastname = !empty($_POST["customer_lastname"]) ? $_POST["customer_lastname"] : '';
$customer_mobile = !empty($_POST["customer_mobile"]) ? $_POST["customer_mobile"] : '';
$customer_email = !empty($_POST["customer_email"]) ? $_POST["customer_email"] : '';
$full_receipt = !empty($_POST["full_receipt"]) ? $_POST["full_receipt"] : '2';
$company_aff = !empty($_POST["company_aff"]) ? $_POST["company_aff"] : '';
$receipt_name = !empty($_POST["receipt_name"]) ? $_POST["receipt_name"] : '';
$receipt_taxid = !empty($_POST["receipt_taxid"]) ? $_POST["receipt_taxid"] : '';
$receipt_address = !empty($_POST["receipt_address"]) ? $_POST["receipt_address"] : '';
$receipt_detail = !empty($_POST["receipt_detail"]) ? $_POST["receipt_detail"] : '';
# Check Booking No.
$bo_title = "BO";
$today_str = explode("-", $today);
$bo_year = $today_str[0];
$bo_year_th_full = $today_str[0] + 543;
$bo_year_th = substr($bo_year_th_full, -2);
$bo_month = $today_str[1];
$bo_date = $today;
$bo_no = $_POST['bo_no'];
$bo_full = $_POST['bo_full'];
$return = 'false'; // Return URL
#----- General Information -----#

if (!empty($_POST["type_val"]) && !empty($_POST["bo_full"])) {
    if (empty($id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO booking (company, booking_no, booking_date, agent, agent_voucher, company_aff, sale_name, customer_firstname, customer_lastname, customer_mobile, customer_email, full_receipt, receipt_name, receipt_address, receipt_taxid, receipt_detail, offline, trash_deleted, date_create, date_edit)";
        $query .= " VALUES ('0', '0', '', '0', '', '0', '', '', '', '', '', '2', '', '', '', '', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);

        $query_no = "INSERT INTO booking_no (company, bo_title, bo_date, bo_year, bo_year_thai, bo_month, bo_no, bo_full, date_create)";
        $query_no .= " VALUES ('$company', '$bo_title', '$bo_date', '$bo_year', '$bo_year_th', '$bo_month', '$bo_no', '$bo_full', now())";
        $result_no = mysqli_query($mysqli_p, $query_no);
        $id_no = mysqli_insert_id($mysqli_p);
    }
    if (!empty($id)) {
        # ---- Update to database ---- #
        $bind_types = "";
        $params = array();

        $query = "UPDATE booking SET";

        $query .= " offline = ?,";
        $bind_types .= "i";
        array_push($params, $offline);

        $query .= " company = ?,";
        $bind_types .= "i";
        array_push($params, $company);

        if (empty($_POST["id"])) {
            $query .= " booking_no = ?,";
            $bind_types .= "i";
            array_push($params, $id_no);

            $query .= " booking_date = ?,";
            $bind_types .= "s";
            array_push($params, $booking_date);
        }

        if ($type_val == '1') {
            $query .= " agent = ?,";
            $bind_types .= "i";
            array_push($params, $agent);

            $query .= " agent_voucher = ?,";
            $bind_types .= "s";
            array_push($params, $agent_voucher);

            $query .= " company_aff = ?,";
            $bind_types .= "i";
            array_push($params, $company_aff);
        }

        $query .= " sale_name = ?,";
        $bind_types .= "s";
        array_push($params, $sale_name);

        $query .= " receipt_address = ?,";
        $bind_types .= "s";
        array_push($params, $receipt_address);

        $query .= " customer_firstname = ?,";
        $bind_types .= "s";
        array_push($params, $customer_firstname);

        $query .= " customer_lastname = ?,";
        $bind_types .= "s";
        array_push($params, $customer_lastname);

        $query .= " customer_mobile = ?,";
        $bind_types .= "s";
        array_push($params, $customer_mobile);

        if ($type_val == '2') {
            $query .= " customer_email = ?,";
            $bind_types .= "s";
            array_push($params, $customer_email);
        }

        $query .= " full_receipt = ?,";
        $bind_types .= "i";
        array_push($params, $full_receipt);

        $query .= " receipt_name = ?,";
        $bind_types .= "s";
        array_push($params, $receipt_name);

        $query .= " receipt_address = ?,";
        $bind_types .= "s";
        array_push($params, $receipt_address);

        $query .= " receipt_taxid = ?,";
        $bind_types .= "s";
        array_push($params, $receipt_taxid);

        $query .= " receipt_detail = ?,";
        $bind_types .= "s";
        array_push($params, $receipt_detail);

        $query .= ($page_title == "Add New Booking") ? ' date_create = now(),' : '';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);

        mysqli_close($mysqli_p);

        $return = ($page_title == "Add New Company") ?  "&id=" . $id : 'true';
        echo $return;
    }
} else {
    echo $return;
}
