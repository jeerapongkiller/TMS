<?php
require("../../../inc/connection.php");

#----- General Information -----#
$id = !empty($_POST["id"]) ? $_POST["id"] : '';
$offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
$supplier = !empty($_POST["supplier"]) ? $_POST["supplier"] : '';
$agent = !empty($_POST["agent"]) ? $_POST["agent"] : '';
$return = 'false'; // Return URL
#----- General Information -----#

if (!empty($_POST['supplier']) && !empty($_POST['agent'])) {
    if (empty($id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO agent (supplier, agent, offline, trash_deleted, date_create, date_edit)";
        $query .= "VALUES ('0', '0', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);
        $page_title = "add";
    }
    if (!empty($id)) {
        # ---- Update to database ---- #
        $bind_types = "";
        $params = array();

        $query = "UPDATE agent SET";

        $query .= " offline = ?,";
        $bind_types .= "i";
        array_push($params, $offline);

        $query .= " supplier = ?,";
        $bind_types .= "i";
        array_push($params, $supplier);

        $query .= " agent = ?,";
        $bind_types .= "i";
        array_push($params, $agent);

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
