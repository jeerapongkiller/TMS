<?php
require("../../../inc/connection.php");

#----- General Information -----#
$booking = !empty($_POST["booking"]) ? $_POST["booking"] : '';
$pm_id = !empty($_POST["pm_id"]) ? $_POST["pm_id"] : '';
$pm_offline = !empty($_POST["pm_offline"]) ? $_POST["pm_offline"] : '2';
$pm_date_payment = !empty($_POST["pm_date_payment"]) ? $_POST["pm_date_payment"] : '';
$pm_receip_no = !empty($_POST["pm_receipt"]) ? $_POST["pm_receipt"] : '';
$pm_receipt = !empty($_POST["pm_receipt"]) ? $_POST["pm_receipt"] : '';
$pm_type = !empty($_POST["pm_type"]) ? $_POST["pm_type"] : '';
$pm_products = !empty($_POST["pm_products"]) ? $_POST["pm_products"] : '';
$pm_all = $pm_products == 'all' ? '1' : '2';
$pm_price = !empty($_POST["pm_price"]) ? preg_replace('(,)', '', $_POST["pm_price"]) : '';
$pm_working = !empty($_POST["pm_working"]) ? $_POST["pm_working"] : '';
$return = 'false';
$check_add = 'false';
#----- General Information -----#

// echo $_FILES['pm_photo']['tmp_name'];
// echo '<br/>';
// echo $_FILES['pm_photo']['name'];
// echo '<br/>';

if (!empty($_POST['booking']) && !empty($_POST['pm_products']) && !empty($_POST['pm_price'])) {
    if (empty($pm_id)) {
        # ---- Insert to database ---- #
        $query = "INSERT INTO booking_payment(booking, booking_products, products_all, payment_type, bank, bank_no, bank_name, payment_date, receip_no, payment_price, receiver_name, photo, offline, trash_deleted, date_create, date_edit)";
        $query .= " VALUES (0, 0, 2, 0, 0, '', '', '', '', 0, '', '', 2, 2, now(), now())";
        $result = mysqli_query($mysqli_p, $query);
        $pm_id = mysqli_insert_id($mysqli_p);
        $check_add = 'true';
    }
    if (!empty($pm_id)) {
        # ---- Upload Photo ---- #
        $uploaddir = "../../../inc/photo/payment/";
        $photo_time = time();
        $photo = !empty($_FILES['pm_photo']['tmp_name']) ? $_FILES['pm_photo']['tmp_name'] : '';
        $photo_name = !empty($_FILES['pm_photo']['name']) ? $_FILES['pm_photo']['name'] : '';
        $tmp_photo = !empty($_POST['pm_tmp_photo']) ? $_POST['pm_tmp_photo'] : '';
        $del_photo = !empty($_POST['pm_del_photo']) ? $_POST['pm_del_photo'] : '';
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

        $query = "UPDATE booking_payment SET";

        $query .= " offline = ?,";
        $bind_types .= "i";
        array_push($params, $pm_offline);

        $query .= " booking = ?,";
        $bind_types .= "i";
        array_push($params, $booking);

        $query .= " booking_products = ?,";
        $bind_types .= "i";
        array_push($params, $pm_products);

        $query .= " products_all = ?,";
        $bind_types .= "i";
        array_push($params, $pm_all);

        $query .= " payment_type = ?,";
        $bind_types .= "i";
        array_push($params, $pm_type);

        $query .= " payment_date = ?,";
        $bind_types .= "s";
        array_push($params, $pm_date_payment); 

        $query .= " receip_no = ?,";
        $bind_types .= "s";
        array_push($params, $pm_receip_no);

        $query .= " payment_price = ?,";
        $bind_types .= "i";
        array_push($params, $pm_price); 

        $query .= " receiver_name = ?,";
        $bind_types .= "s";
        array_push($params, $pm_working);

        $query .= "photo = ?,";
        $bind_types .= "s";
        array_push($params, $photo);

        $query .= ($check_add == "true") ? ' date_create = now(),' : '';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$pm_id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);

        mysqli_close($mysqli_p);

        //  $return = ($check_add == "true") ?  "&id=" . $pm_id : 'true';
        $return = 'true';
        echo $return;
    }
} else {
    echo $return;
}
