<?php
require("../../../inc/connection.php");

if (!empty($_POST['products']) && !empty($_POST['bp_date_travel']) && !empty($_POST['pax_mix'])) {
    $products = $_POST['products'];
    $bp_date_travel = $_POST['bp_date_travel'];
    $company = $_POST['company'];
    $type = $_POST['type'];
    $pax_mix = $_POST['pax_mix'];
    $pax_products = 0;
    $query_allom = "SELECT * 
                    FROM products_allotment 
                    WHERE id > 0
                     ";
    $query_allom .= " AND products = '$products' AND date_from <= '$bp_date_travel' AND date_to >= '$bp_date_travel' ";
    $result_allom = mysqli_query($mysqli_p, $query_allom);
    $num_allom = mysqli_num_rows($result_allom);
    if ($num_allom > 0) {
        $row_allom = mysqli_fetch_array($result_allom, MYSQLI_ASSOC);
        $pax = $row_allom['pax'];
        $query_bp = "SELECT * 
                    FROM booking_products 
                    WHERE id > 0 ";
        $query_bp .= !empty($_POST['id']) ? " AND id != " . $_POST['id'] . " " : '';
        $query_bp .= " AND products = '$products' AND travel_date = '$bp_date_travel'";
        $result_bp = mysqli_query($mysqli_p, $query_bp);
        // $num_bp = mysqli_num_rows($result_bp);
        while ($row_bp = mysqli_fetch_array($result_bp, MYSQLI_ASSOC)) {
            $pax_products = $row_bp['adults'] + $row_bp['children'] + $row_bp['infant'];
        }
        $pax_products = $pax_products + $pax_mix;
        echo ($pax_products <= $pax) ? 'true' : 'false';
    } else {
        echo 'true';
    }
}
