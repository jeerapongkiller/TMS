<?php
require("../../../inc/connection.php");
#----- General Information -----#
$id = !empty($_POST["id"]) ? $_POST["id"] : '';
$offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
$products = !empty($_POST["products"]) ? $_POST["products"] : '';
$type = !empty($_POST["type"]) ? $_POST["type"] : '';
$periods_from = !empty($_POST["periods_from"]) ? $_POST["periods_from"] : '';
$periods_to = !empty($_POST["periods_to"]) ? $_POST["periods_to"] : '';
$return = 'false'; // Return URL
#----- General Information -----#
if(!empty($_POST['products']) && !empty($_POST['type'])) {
    if (empty($id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO products_periods (products, periods_from, periods_to, offline, trash_deleted, date_create, date_edit)";
        $query .= "VALUES ('0', '', '', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);
        $page_title = "add";
    }
    if (!empty($id)) {
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
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);
        mysqli_close($mysqli_p);

        $return = "true";
        echo $return;
    }
}
