<?php
require("../../../inc/connection.php");

#----- General Information -----#
$id = !empty($_POST["id"]) ? $_POST["id"] : '';
$page_title = !empty($_POST["page_title"]) ? $_POST["page_title"] : '';
$offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
$username = !empty($_POST["username"]) ? $_POST["username"] : '';
$password = !empty($_POST["password"]) ? $_POST["password"] : '';
$firstname = !empty($_POST["firstname"]) ? $_POST["firstname"] : '';
$lastname = !empty($_POST["lastname"]) ? $_POST["lastname"] : '';
$company = !empty($_POST["company"]) ? $_POST["company"] : '';
$permission = !empty($_POST["permission"]) ? $_POST["permission"] : '';
$usernamesame = !empty($_POST["usernamesame"]) ? $_POST["usernamesame"] : 'false';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
#----- General Information -----#

$return = 'false';
// $return_url = !empty($id) ? '&id=' . $id : '';
// $message_alert = "error";

if (!empty($_POST['username']) && $usernamesame != 'false') {
    if (empty($id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO users (permission, company, username, password, firstname, lastname, photo, offline, trash_deleted, date_create, date_edit)";
        $query .= "VALUES ('0', '0', '', '', '', '', '', '2', '2', now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);
    }
    if (!empty($id)) {
        # ---- Upload Photo ---- #
        $uploaddir = "../../../inc/photo/users/";
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

        $query = "UPDATE users SET";

        $query .= " offline = ?,";
        $bind_types .= "i";
        array_push($params, $offline);

        $query .= " company = ?,";
        $bind_types .= "i";
        array_push($params, $company);

        $query .= " permission = ?,";
        $bind_types .= "i";
        array_push($params, $permission);

        $query .= " username = ?,";
        $bind_types .= "s";
        array_push($params, $username);

        if(!empty($password)) {
            $query .= " password = ?,";
            $bind_types .= "s";
            array_push($params, $hashed_password);
        }

        $query .= " firstname = ?,";
        $bind_types .= "s";
        array_push($params, $firstname);

        $query .= " lastname = ?,";
        $bind_types .= "s";
        array_push($params, $lastname);

        $query .= "photo = ?,";
        $bind_types .= "s";
        array_push($params, $photo);

        $query .= ($page_title == "Add New User") ? ' date_create = now(),' : '';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);

        mysqli_close($mysqli_p);

        $return = ($page_title == "Add New User") ?  "&id=" . $id : 'true';
        // $message_alert = "success";
        // echo $return_url."&message=" . $message_alert;
        echo $return;
    }
} else {
    echo $return;
    // echo $return_url."&message=" . $message_alert;
}

