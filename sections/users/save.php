<?php
require("../../inc/connection.php");

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    #----- General Information -----#
    $id = !empty($_POST["id"]) ? $_POST["id"] : '';
    $offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
    $username = !empty($_POST["username"]) ? $_POST["username"] : '';
    $password = !empty($_POST["password"]) ? $_POST["password"] : '';
    $firstname = !empty($_POST["firstname"]) ? $_POST["firstname"] : '';
    $lastname = !empty($_POST["lastname"]) ? $_POST["lastname"] : '';
    #----- General Information -----#

    $return_url = !empty($id) ? '&id=' . $id : '';
    $message_alert = "error";

    if (empty($id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO users (permission, username, password, firstname, lastname, photo, offline, trash_deleted, date_create, date_edit)";
        $query .= "VALUES ('2', '', '', '', '', '', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);
    }
    if (!empty($id)) {
        # ---- Upload Photo ---- #
        $uploaddir = "inc/photo/users/";
        $photo_time = time();
        $photo = !empty($_FILES['photo']['tmp_name']) ? $_FILES['photo']['tmp_name'] : '';
        $photo_name = !empty($_FILES['photo']['name']) ? $_FILES['photo']['name'] : '';
        $tmp_photo = !empty($_POST['tmp_photo']) ? $_POST['tmp_photo'] : '';
        $del_photo = !empty($_POST['del_photo']) ? $_POST['del_photo'] : '';

        if (!empty($del_photo)) {
            unlink($uploaddir . $tmp_photo);
            $photo = "";
        } else {
            $photo = !empty($photo) ? img_upload($photo, $photo_name, $tmp_photo, $uploaddir, $photo_time, $paramiter) : $tmp_photo;
        }

        # ---- Update to database ---- #
        $bind_types = "";
        $params = array();

        $query = "UPDATE users SET";

        $query .= " offline = ?,";
        $bind_types .= "i";
        array_push($params, $offline);

        $query .= " username = ?,";
        $bind_types .= "s";
        array_push($params, $username);

        $query .= " password = ?,";
        $bind_types .= "s";
        array_push($params, $password);

        $query .= " firstname = ?,";
        $bind_types .= "s";
        array_push($params, $firstname);

        $query .= " lastname = ?,";
        $bind_types .= "s";
        array_push($params, $lastname);

        if(!empty($photo)) {
            $photo_field = "photo";
            $query .= " " . $photo_field . " = ?,";
            $bind_types .= "s";
            array_push($params, $photo);
        }

        $query .= ($page_title == "เพิ่มข้อมูล") ? ' date_create = now(),' : '';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);

        mysqli_close($mysqli_p);
    }
}
