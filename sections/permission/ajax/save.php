<?php
require("../../../inc/connection.php");

#----- General Information -----#
$id = !empty($_POST["id"]) ? $_POST["id"] : '';
$page_title = !empty($_POST["page_title"]) ? $_POST["page_title"] : '';
$offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
$name = !empty($_POST["name"]) ? $_POST["name"] : '';
$namesame = !empty($_POST["namesame"]) ? $_POST["namesame"] : 'false';
$return = 'false';
#----- General Information -----#

if (!empty($_POST['name']) && $namesame != 'false') {
    if (empty($id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO permission (name, offline, trash_deleted, date_create, date_edit)";
        $query .= "VALUES ('', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);
    }
    if (!empty($id)) {
        # ---- Update to database ---- #
        $bind_types = "";
        $params = array();

        $query = "UPDATE permission SET";

        $query .= " offline = ?,";
        $bind_types .= "i";
        array_push($params, $offline);

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= ($page_title == "Add New Permission") ? ' date_create = now(),' : '';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);

        mysqli_close($mysqli_p);

        $return = ($page_title == "Add New Permission") ?  "&id=" . $id : 'true';
        echo $return;
    }
} else {
    echo $return;
}
