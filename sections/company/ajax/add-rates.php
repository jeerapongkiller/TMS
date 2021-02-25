<?php
require("../../../inc/connection.php");
#----- General Information -----#
$id = !empty($_POST["id"]) ? $_POST["id"] : '';
$type_rates = !empty($_POST["type_rates"]) ? $_POST["type_rates"] : '';
$rates_adult = !empty($_POST["rates_adult"]) ?  preg_replace('(,)', '', $_POST["rates_adult"]) : '0';
$rates_children = !empty($_POST["rates_children"]) ?  preg_replace('(,)', '', $_POST["rates_children"]) : '0';
$rates_infant = !empty($_POST["rates_infant"]) ?  preg_replace('(,)', '', $_POST["rates_infant"]) : '0';
$rates_group = !empty($_POST["rates_group"]) ?  preg_replace('(,)', '', $_POST["rates_group"]) : '0';
$pax = !empty($_POST["pax"]) ?  preg_replace('(,)', '', $_POST["pax"]) : '0';
$return = 'false'; // Return URL
#----- General Information -----#
if (!empty($_POST['id']) && !empty($_POST['type_rates'])) {
    if (!empty($id)) {
        # ---- Update to database ---- #
        $bind_types = "";
        $params = array();

        $query = "UPDATE products_rates SET";

        // $query .= " offline = ?,";
        // $bind_types .= "i";
        // array_push($params, $offline);

        // $query .= " products_periods = ?,";
        // $bind_types .= "i";
        // array_push($params, $periods);

        // $query .= " type_rates = ?,";
        // $bind_types .= "i";
        // array_push($params, $type_rates);

        $query .= " rate_adult = ?,";
        $bind_types .= "i";
        array_push($params, $rates_adult);

        $query .= " rate_children = ?,";
        $bind_types .= "i";
        array_push($params, $rates_children);

        $query .= " rate_infant = ?,";
        $bind_types .= "i";
        array_push($params, $rates_infant);

        $query .= " rate_group = ?,";
        $bind_types .= "i";
        array_push($params, $rates_group);

        $query .= " pax = ?,";
        $bind_types .= "i";
        array_push($params, $pax);

        // $query .=  'date_create = now(),';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);
    }
}
