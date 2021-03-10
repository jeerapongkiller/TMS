<?php
require("../../../inc/connection.php");

#----- General Information -----#
$id = !empty($_POST["id"]) ? $_POST["id"] : '';
$company = !empty($_POST["company"]) ? $_POST["company"] : '';
$offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
$type = !empty($_POST["type"]) ? $_POST["type"] : '';
$name = !empty($_POST["name"]) ? $_POST["name"] : '';
$return = 'false'; // Return URL
#----- General Information -----#

if (!empty($_POST['company']) && !empty($_POST['type']) && !empty($_POST['name'])) {
    if (empty($id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO products (company, products_type, name, offline, trash_deleted, date_create, date_edit)";
        $query .= "VALUES ('0', '0', '', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);
        $page_title = "add";
    }
    if (!empty($id)) {
        # ---- Update to database ---- #
        $bind_types = "";
        $params = array();

        $query = "UPDATE products SET";

        $query .= " offline = ?,";
        $bind_types .= "i";
        array_push($params, $offline);

        $query .= " company = ?,";
        $bind_types .= "i";
        array_push($params, $company);

        $query .= " products_type = ?,";
        $bind_types .= "i";
        array_push($params, $type);

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

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

        echo $id;
    }
}