<?php
require("../../../inc/connection.php");
#----- General Information -----#
$periods = !empty($_POST["periods"]) ? $_POST["periods"] : '';
$rate = !empty($_POST["rate"]) ? $_POST["rate"] : '';
$offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
$products = !empty($_POST["products"]) ? $_POST["products"] : '';
$company = !empty($_POST["company"]) ? $_POST["company"] : '';
$type = !empty($_POST["type"]) ? $_POST["type"] : '';
$periods_from = !empty($_POST["periods_from"]) ? $_POST["periods_from"] : $today;
$periods_to = !empty($_POST["periods_to"]) ? $_POST["periods_to"] : $today;
$adult_cost = !empty($_POST["adult_cost"]) ?  preg_replace('(,)', '', $_POST["adult_cost"]) : '0';
$adult_sale = !empty($_POST["adult_sale"]) ?  preg_replace('(,)', '', $_POST["adult_sale"]) : '0';
$children_cost = !empty($_POST["children_cost"]) ?  preg_replace('(,)', '', $_POST["children_cost"]) : '0';
$children_sale = !empty($_POST["children_sale"]) ?  preg_replace('(,)', '', $_POST["children_sale"]) : '0';
$infant_cost = !empty($_POST["infant_cost"]) ?  preg_replace('(,)', '', $_POST["infant_cost"]) : '0';
$infant_sale = !empty($_POST["infant_sale"]) ?  preg_replace('(,)', '', $_POST["infant_sale"]) : '0';
$group_cost = !empty($_POST["group_cost"]) ?  preg_replace('(,)', '', $_POST["group_cost"]) : '0';
$group_sale = !empty($_POST["group_sale"]) ?  preg_replace('(,)', '', $_POST["group_sale"]) : '0';
$pax = !empty($_POST["pax"]) ?  preg_replace('(,)', '', $_POST["pax"]) : '0';
$transfer_cost = !empty($_POST["transfer_cost"]) ?  preg_replace('(,)', '', $_POST["transfer_cost"]) : '0';
$transfer_sale = !empty($_POST["transfer_sale"]) ?  preg_replace('(,)', '', $_POST["transfer_sale"]) : '0';
$return = 'false'; // Return URL
#----- General Information -----#
if (!empty($_POST['company']) && !empty($_POST['products']) && !empty($_POST['periods_from']) && !empty($_POST['periods_to'])) {
    # ---- Add Periods ---- #
    if (empty($periods)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO products_periods (products, periods_from, periods_to, offline, trash_deleted, date_create, date_edit)";
        $query .= "VALUES ('0', '', '', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $periods = mysqli_insert_id($mysqli_p);
        $page_title = "add";
    }
    if (!empty($periods)) {
        # ---- Update to database ---- #
        $bind_types = "";
        $params = array();

        $query = "UPDATE products_periods SET";

        $query .= " offline = ?,";
        $bind_types .= "i";
        array_push($params, $offline);

        $query .= " products = ?,";
        $bind_types .= "i";
        array_push($params, $products);

        $query .= " periods_from = ?,";
        $bind_types .= "s";
        array_push($params, $periods_from);

        $query .= " periods_to = ?,";
        $bind_types .= "s";
        array_push($params, $periods_to);

        $query .= ($page_title == "add") ? ' date_create = now(),' : '';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$periods'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);
    }

    # ---- Add Rates ---- #
    for ($i = 0; $i < 2; $i++) {
        #----- General Information -----#
        $rate = '';
        $type_rates = $i == '0' ? '1' : '2';
        $rate_adult = $i == '0' ?  $adult_cost : $adult_sale;
        $rate_children = $i == '0' ?  $children_cost : $children_sale;
        $rate_infant = $i == '0' ?  $infant_cost : $infant_sale;
        $rate_group = $i == '0' ?  $group_cost : $group_sale;
        $rate_transfer = $i == '0' ?  $transfer_cost : $transfer_sale;
        #----- General Information -----#
        if (empty($rate)) {
            # ---- Insert to database ---- #
            $query = "INSERT INTO products_rates (products_periods, type_rates, rate_adult, rate_children, rate_infant, rate_group, pax, offline, trash_deleted, date_create, date_edit)";
            $query .= "VALUES ('0', '0',  '0', '0', '0', '0', '0', '2', '2', now(), now())";
            $result = mysqli_query($mysqli_p, $query);
            $rate = mysqli_insert_id($mysqli_p);
        }
        if (!empty($rate)) {
            # ---- Update to database ---- #
            $bind_types = "";
            $params = array();

            $query = "UPDATE products_rates SET";

            $query .= " offline = ?,";
            $bind_types .= "i";
            array_push($params, $offline);

            $query .= " products_periods = ?,";
            $bind_types .= "i";
            array_push($params, $periods);

            $query .= " type_rates = ?,";
            $bind_types .= "i";
            array_push($params, $type_rates);

            $query .= " rate_adult = ?,";
            $bind_types .= "i";
            array_push($params, $rate_adult);

            $query .= " rate_children = ?,";
            $bind_types .= "i";
            array_push($params, $rate_children);

            $query .= " rate_infant = ?,";
            $bind_types .= "i";
            array_push($params, $rate_infant);

            $query .= " rate_group = ?,";
            $bind_types .= "i";
            array_push($params, $rate_group);

            $query .= " pax = ?,";
            $bind_types .= "i";
            array_push($params, $pax);

            $query .= " rate_transfer = ?,";
            $bind_types .= "i";
            array_push($params, $rate_transfer);

            $query .=  'date_create = now(),';

            $query .= " date_edit = now()";
            $query .= " WHERE id = '$rate'";
            $procedural_statement = mysqli_prepare($mysqli_p, $query);
            if ($bind_types != "") {
                mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
            }
            mysqli_stmt_execute($procedural_statement);
            $result = mysqli_stmt_get_result($procedural_statement);
        }
    }
    mysqli_close($mysqli_p);
    echo $rate;
    exit;
}
echo $return;
exit;
