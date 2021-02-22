<?php
require("../../../inc/connection.php");

#----- General Information -----#
$id = !empty($_POST["id"]) ? $_POST["id"] : '';
$page_title = !empty($_POST["page_title"]) ? $_POST["page_title"] : '';
$offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
$name = !empty($_POST["name"]) ? $_POST["name"] : '';
$name_invoice = !empty($_POST["name_invoice"]) ? $_POST["name_invoice"] : '';
$address = !empty($_POST["address"]) ? $_POST["address"] : '';
$phone = !empty($_POST["phone"]) ? $_POST["phone"] : '';
$fax = !empty($_POST["fax"]) ? $_POST["fax"] : '';
$email = !empty($_POST["email"]) ? $_POST["email"] : '';
$website = !empty($_POST["website"]) ? $_POST["website"] : '';
$contact_person = !empty($_POST["contact_person"]) ? $_POST["contact_person"] : '';
$contact_position = !empty($_POST["contact_position"]) ? $_POST["contact_position"] : '';
$contact_phone = !empty($_POST["contact_phone"]) ? $_POST["contact_phone"] : '';
$contact_email = !empty($_POST["contact_email"]) ? $_POST["contact_email"] : '';
$return = 'false'; // Return URL
#----- General Information -----#

if (!empty($_POST['name'])) {
    if (empty($id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO company (name, name_invoice, address, phone, fax, email, website, contact_person, contact_position, contact_phone, contact_email, photo, offline, trash_deleted, date_create, date_edit)";
        $query .= "VALUES ('', '', '', '', '', '', '', '', '', '', '', '', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);
    }
    if (!empty($id)) {
        # ---- Upload Photo ---- #
        $uploaddir = "../../../inc/photo/company/";
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

        $query = "UPDATE company SET";

        $query .= " offline = ?,";
        $bind_types .= "i";
        array_push($params, $offline);

        $query .= " name = ?,";
        $bind_types .= "s";
        array_push($params, $name);

        $query .= " name_invoice = ?,";
        $bind_types .= "s";
        array_push($params, $name_invoice);

        $query .= " address = ?,";
        $bind_types .= "s";
        array_push($params, $address);

        $query .= " phone = ?,";
        $bind_types .= "s";
        array_push($params, $phone);

        $query .= " fax = ?,";
        $bind_types .= "s";
        array_push($params, $fax);

        $query .= " email = ?,";
        $bind_types .= "s";
        array_push($params, $email);

        $query .= " website = ?,";
        $bind_types .= "s";
        array_push($params, $website);

        $query .= " contact_person = ?,";
        $bind_types .= "s";
        array_push($params, $contact_person);

        $query .= " contact_position = ?,";
        $bind_types .= "s";
        array_push($params, $contact_position);

        $query .= " contact_phone = ?,";
        $bind_types .= "s";
        array_push($params, $contact_phone);

        $query .= " contact_email = ?,";
        $bind_types .= "s";
        array_push($params, $contact_email);

        $query .= "photo = ?,";
        $bind_types .= "s";
        array_push($params, $photo);

        $query .= ($page_title == "Add New Company") ? ' date_create = now(),' : '';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);

        mysqli_close($mysqli_p);

        $return = ($page_title == "Add New Company") ?  "&id=" . $id : 'true';
        echo $return;
    }
} else {
    echo $return;
}
