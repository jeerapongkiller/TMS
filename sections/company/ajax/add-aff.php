<?php
require("../../../inc/connection.php");
#----- General Information -----#
$id = !empty($_POST["id"]) ? $_POST["id"] : '';
$company = !empty($_POST["company"]) ? $_POST["company"] : '';
$page_title = !empty($_POST["page_title"]) ? $_POST["page_title"] : '';
$offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
$name_aff = !empty($_POST["name_aff"]) ? $_POST["name_aff"] : '';
$receipt_name = !empty($_POST["receipt_name"]) ? $_POST["receipt_name"] : '';
$receipt_taxid = !empty($_POST["receipt_tax"]) ? $_POST["receipt_tax"] : '';
$receipt_address = !empty($_POST["receipt_address"]) ? $_POST["receipt_address"] : '';
$receipt_detail = !empty($_POST["receipt_detail"]) ? $_POST["receipt_detail"] : '';
$return = 'false'; // Return URL
// echo 'id - ' . $id . '</br>';
// echo 'company - ' . $company . '</br>';
// echo 'page_title - ' . $page_title . '</br>';
// echo 'offline - ' . $offline . '</br>';
// echo 'name_aff - ' . $name_aff . '</br>';
// echo 'receipt_name - ' . $receipt_name . '</br>';
// echo 'receipt_tax - ' . $receipt_tax . '</br>';
// echo 'receipt_address - ' . $receipt_address . '</br>';
// echo 'receipt_detail - ' . $receipt_detail . '</br>';
#----- General Information -----#

if (!empty($_POST["company"]) && !empty($_POST["name_aff"])) {
    if (empty($id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO company_aff (company, name_aff, receipt_name, receipt_address, receipt_taxid, receipt_detail, photo, offline, trash_deleted, date_create, date_edit)";
        $query .= "VALUES ('0', '', '', '', '', '', '', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);
    }
    if (!empty($id)) {
        # ---- Upload Photo ---- #
        $uploaddir = "../../../inc/photo/company_aff/";
        $photo_time = time();
        $photo = !empty($_FILES['photo']['tmp_name']) ? $_FILES['photo']['tmp_name'] : '';
        $photo_name = !empty($_FILES['photo']['name']) ? $_FILES['photo']['name'] : '';
        $tmp_photo = !empty($_POST['tmp_photo']) ? $_POST['tmp_photo'] : '';
        $del_photo = !empty($_POST['del_photo']) ? $_POST['del_photo'] : '';
        $paramiter = '1';

        if (!empty($del_photo)) {
            unlink($uploaddir . $tmp_photo);
            $photo = "";
        } else {
            $photo = !empty($photo) ? img_upload($photo, $photo_name, $tmp_photo, $uploaddir, $photo_time, $paramiter) : $tmp_photo;
        }

        # ---- Update to database ---- #
        $bind_types = "";
        $params = array();

        $query = "UPDATE company_aff SET";

        $query .= " offline = ?,";
        $bind_types .= "i";
        array_push($params, $offline);

        $query .= " company = ?,";
        $bind_types .= "i";
        array_push($params, $company);

        $query .= " name_aff = ?,";
        $bind_types .= "s";
        array_push($params, $name_aff);

        $query .= " receipt_name = ?,";
        $bind_types .= "s";
        array_push($params, $receipt_name);

        $query .= " receipt_address = ?,";
        $bind_types .= "s";
        array_push($params, $receipt_address);

        $query .= " receipt_taxid = ?,";
        $bind_types .= "s";
        array_push($params, $receipt_taxid);

        $query .= " receipt_detail = ?,";
        $bind_types .= "s";
        array_push($params, $receipt_detail);

        $query .= "photo = ?,";
        $bind_types .= "s";
        array_push($params, $photo);

        $query .= ($page_title == "Add New Company (Affiliated)") ? ' date_create = now(),' : '';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);

        mysqli_close($mysqli_p);

        $return = ($page_title == "Add New Company (Affiliated)") ?  "&id=" . $id : 'true';
        echo $return;
    }
} else {
    echo $return;
}
