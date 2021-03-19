<?php
require("../../../inc/connection.php");

#----- General Information -----#
$id = !empty($_POST["id"]) ? $_POST["id"] : '';
$page_title = !empty($_POST["page_title"]) ? $_POST["page_title"] : '';
$products = !empty($_POST["products"]) ? $_POST["products"] : '';
$offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
$type = !empty($_POST["type"]) ? $_POST["type"] : '';
$pax = !empty($_POST["pax"]) ? $_POST["pax"] : '';
$date_from = !empty($_POST["date_from"]) ? $_POST["date_from"] : '';
$date_to = !empty($_POST["date_to"]) ? $_POST["date_to"] : '';
$return = 'false'; // Return URL
#----- General Information -----#

if (!empty($_POST['products']) && !empty($_POST['date_from']) && !empty($_POST['date_to']) && !empty($_POST['pax'])) {
    if (empty($id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO products_allotment (products, pax, date_from, date_to, offline, trash_deleted, date_create, date_edit)";
        $query .= "VALUES ('0', '0', '', '', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);
    }
    if (!empty($id)) {
        # ---- Update to database ---- #
        $bind_types = "";
        $params = array();

        $query = "UPDATE products_allotment SET";

        $query .= " offline = ?,";
        $bind_types .= "i";
        array_push($params, $offline);

        $query .= " products = ?,";
        $bind_types .= "i";
        array_push($params, $products);

        $query .= " pax = ?,";
        $bind_types .= "i";
        array_push($params, $pax);

        $query .= " date_from = ?,";
        $bind_types .= "s";
        array_push($params, $date_from);

        $query .= " date_to = ?,";
        $bind_types .= "s";
        array_push($params, $date_to);

        $query .= ($page_title == "Add New Allotment") ? ' date_create = now(),' : '';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);
        mysqli_close($mysqli_p);

        echo './?mode=products/detail-allot&products='.$products.'&id='.$id;
        exit;
    }
}
echo $return;
mysqli_close($mysqli_p);
