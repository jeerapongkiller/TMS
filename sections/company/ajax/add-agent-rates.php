<?php
require("../../../inc/connection.php");

// foreach ($_POST['agent'] as $agent => $value) {
//     echo $value;
// }

#----- General Information -----#
$id = !empty($_POST["id"]) ? $_POST["id"] : '';
$offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
$periods = !empty($_POST["periods"]) ? $_POST["periods"] : '';
$type_rates_agent = !empty($_POST["type_rates_agent"]) ? $_POST["type_rates_agent"] : '3';
$agent_rates_adult = !empty($_POST["agent_rates_adult"]) ? preg_replace('(,)', '', $_POST["agent_rates_adult"]) : '';
$agent_rates_children = !empty($_POST["agent_rates_children"]) ? preg_replace('(,)', '', $_POST["agent_rates_children"]) : '';
$agent_rates_infant = !empty($_POST["agent_rates_infant"]) ? preg_replace('(,)', '', $_POST["agent_rates_infant"]) : '';
$agent_rates_group = !empty($_POST["agent_rates_group"]) ? preg_replace('(,)', '', $_POST["agent_rates_group"]) : '';
$agent_pax = !empty($_POST["agent_pax"]) ? preg_replace('(,)', '', $_POST["agent_pax"]) : '';
$return = 'false'; // Return URL
#----- General Information -----#

if (!empty($_POST["periods"]) && !empty($_POST["agent_rates_adult"])) {
    if (empty($id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO products_rates (products_periods, type_rates, rate_adult, rate_children, rate_infant, rate_group, pax, offline, trash_deleted, date_create, date_edit)";
        $query .= "VALUES ('0', '0',  '0', '0', '0', '0', '0', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);
    }
    if (!empty($id)) {
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
        array_push($params, $type_rates_agent);

        $query .= " rate_adult = ?,";
        $bind_types .= "i";
        array_push($params, $agent_rates_adult);

        $query .= " rate_children = ?,";
        $bind_types .= "i";
        array_push($params, $agent_rates_children);

        $query .= " rate_infant = ?,";
        $bind_types .= "i";
        array_push($params, $agent_rates_infant);

        $query .= " rate_group = ?,";
        $bind_types .= "i";
        array_push($params, $agent_rates_group);

        $query .= " pax = ?,";
        $bind_types .= "i";
        array_push($params, $agent_pax);

        $query .=  'date_create = now(),';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);
    }
    if (!empty($_POST['agent'])) {
        foreach ($_POST['agent'] as $agent => $value) {
            # ---- Insert to database ---- #
            $query = "INSERT INTO rates_agent (products_periods, products_rates, combine_agent, trash_deleted, date_create, date_edit)";
            $query .= "VALUES ('$periods', '$id', '$value', '2', now(), now())";
            $result = mysqli_query($mysqli_p, $query);
        }
    }
}
