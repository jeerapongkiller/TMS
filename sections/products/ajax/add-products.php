<?php
require("../../../inc/connection.php");

// echo 'id - ' . $_POST["id"] . '</br>';
// echo 'page_title - ' . $_POST["page_title"] . '</br>';
// echo 'offline - ' . $_POST["offline"] . '</br>';
// echo 'check_cut - ' . $_POST["check_cut"] . '</br>';
// echo 'company - ' . $_POST["company"] . '</br>';
// echo 'type - ' . $_POST["type"] . '</br>';
// echo 'name - ' . $_POST["name"] . '</br>';
// echo 'cut_open - ' . $_POST["cut_open"] . '</br>';
// echo 'cut_off - ' . $_POST["cut_off"] . '</br>';
// exit();

#----- General Information -----#
$id = !empty($_POST["id"]) ? $_POST["id"] : '';
$page_title = !empty($_POST["page_title"]) ? $_POST["page_title"] : '';
$company = !empty($_POST["company"]) ? $_POST["company"] : '';
$offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
$check_cut = !empty($_POST["check_cut"]) ? $_POST["check_cut"] : '';
$type = !empty($_POST["type"]) ? $_POST["type"] : '';
$name = !empty($_POST["name"]) ? $_POST["name"] : '';
$cut_open = !empty($_POST["cut_open"]) ? $_POST["cut_open"] : '';
$cut_off = !empty($_POST["cut_off"]) ? $_POST["cut_off"] : '';
if ($check_cut == '') {
    $cut_open = '00:00';
    $cut_off = '0';
}
$return = 'false'; // Return URL
#----- General Information -----#

if (!empty($_POST['company']) && !empty($_POST['type']) && !empty($_POST['name'])) {
    if (empty($id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO products (company, products_type, name, cut_open, cut_off, offline, trash_deleted, date_create, date_edit)";
        $query .= "VALUES ('0', '0', '', '00:00', '0', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);
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

        $query .= " cut_open = ?,";
        $bind_types .= "s";
        array_push($params, $cut_open);

        $query .= " cut_off = ?,";
        $bind_types .= "i";
        array_push($params, $cut_off);

        $query .= ($page_title == "Add New Products") ? ' date_create = now(),' : '';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);
        mysqli_close($mysqli_p);

        echo './?mode=products/detail-products&type='.$type.'&id='.$id;
        exit;
    }
}
echo $return;
mysqli_close($mysqli_p);
