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
// exit();
#----- General Information -----#
if (!empty($_POST['type_rates'])) {
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

        // $query .=  'date_create = now(),';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);

        $return = 'true'; 
        echo $return;
    }
}
