<?php
require("../../../inc/connection.php");
#----- General Information -----#
$id = !empty($_POST["id"]) ? $_POST["id"] : '';
$page_title = !empty($_POST["page_title"]) ? $_POST["page_title"] : '';
$offline = !empty($_POST["offline"]) ? $_POST["offline"] : '';
$company = !empty($_POST["company"]) ? $_POST["company"] : '';
$periods = !empty($_POST["periods"]) ? $_POST["periods"] : '';
$type_rates = !empty($_POST["type_rates"]) ? $_POST["type_rates"] : '';
$type_products = !empty($_POST["type_products"]) ? $_POST["type_products"] : '';
$rate_adult = !empty($_POST["adult"]) ?  preg_replace('(,)', '', $_POST["adult"]) : '0';
$rate_children = !empty($_POST["children"]) ?  preg_replace('(,)', '', $_POST["children"]) : '0';
$rate_infant = !empty($_POST["infant"]) ?  preg_replace('(,)', '', $_POST["infant"]) : '0';
$rate_transfer = !empty($_POST["transfer"]) ?  preg_replace('(,)', '', $_POST["transfer"]) : '0';
$rate_group = !empty($_POST["group"]) ?  preg_replace('(,)', '', $_POST["group"]) : '0';
$pax = !empty($_POST["pax"]) ?  preg_replace('(,)', '', $_POST["pax"]) : '0';
$return = 'false'; // Return URL
// echo 'id - '.$id.'</br>';
// echo 'page_title - '.$page_title.'</br>';
// echo 'company - '.$company.'</br>';
// echo 'periods - '.$periods.'</br>';
// echo 'type_rates - '.$type_rates.'</br>';
// echo 'type_products - '.$type_products.'</br>';
// echo 'adult - '.$rate_adult.'</br>';
// echo 'children - '.$rate_children.'</br>';
// echo 'infant - '.$rate_infant.'</br>';
// echo 'transfer - '.$rate_transfer.'</br>';
// echo 'group - '.$rate_group.'</br>';
// echo 'pax - '.$pax.'</br>';
// foreach ($_POST['agent'] as $agent => $value) {
//     echo $value;
// }
// foreach ($_POST['default_agent'] as $default_agent => $value) {
//     echo $value;
// }
// foreach ($_POST['agent'] as $agent => $value) {
//     if(empty(in_array($value, $_POST['default_agent']))){
//         echo 'insert!!! - '.$value.'</br>';
//     }
// }
// foreach ($_POST['default_agent'] as $default_agent => $value) {
//     if(empty(in_array($value, $_POST['agent']))){
//         echo 'delete!!! - '.$value.'</br>';
//     }
// }
exit();
#----- General Information -----#
if (!empty($_POST['type_rates'])) {
    if (empty($id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO products_rates (products_periods, type_rates, rate_adult, rate_children, rate_infant, rate_group, pax, rate_transfer, offline, trash_deleted, date_create, date_edit)";
        $query .= "VALUES ('0', '0', '0', '0', '0', '0', '0', '0', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);
    }

    if (!empty($id)) {
        # ---- Update to database ---- #
        $bind_types = "";
        $params = array();

        $query = "UPDATE products_rates SET";

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

        if ($type_rates == '3') {
            $query .= " products_periods = ?,";
            $bind_types .= "i";
            array_push($params, $periods);

            $query .= " 	type_rates = ?,";
            $bind_types .= "i";
            array_push($params, $type_rates);

            $query .=  'date_create = now(),';
        }

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);

        if (!empty($_POST['agent'])) {
            foreach ($_POST['agent'] as $agent => $value) {
                if (empty(in_array($value, $_POST['default_agent']))) {
                    # ---- Insert to database ---- #
                    $query = "INSERT INTO rates_agent (products_periods, products_rates, combine_agent, trash_deleted, date_create, date_edit)";
                    $query .= "VALUES ('$periods', '$id', '$value', '2', now(), now())";
                    $result = mysqli_query($mysqli_p, $query);
                }
            }
            $query = "SELECT products_rates.*, rates_agent.id as rgID, rates_agent.products_periods as rgPP, rates_agent.products_rates as rgPR, rates_agent.combine_agent as rgCG
                    FROM products_rates 
                    LEFT JOIN rates_agent
                    ON products_rates.id = rates_agent.products_rates
                    WHERE products_rates.products_periods = ' $periods ' AND products_rates.type_rates = 3 ";
            $result_rates = mysqli_query($mysqli_p, $query);
            while ($row_rates = mysqli_fetch_array($result_rates, MYSQLI_ASSOC)) {
                if (empty(in_array($row_rates['rgCG'], $_POST['agent']))) {
                    # ---- Insert to database ---- #
                    $query = "DELETE FROM rates_agent WHERE id = ?";
                    $procedural_statement = mysqli_prepare($mysqli_p, $query);
                    mysqli_stmt_bind_param($procedural_statement, 'i', $row_rates['rgID']);
                    mysqli_stmt_execute($procedural_statement);
                    $result = mysqli_stmt_get_result($procedural_statement);
                }
            }
        }
        echo $id;
    }
}
