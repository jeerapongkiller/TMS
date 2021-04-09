<?php
require("../../../inc/connection.php");

if (!empty($_POST['bp_products']) && !empty($_POST['bp_date_travel']) && !empty($_POST['company']) && !empty($_POST['type'])) {
    $bp_products = $_POST['bp_products'];
    $bp_date_travel = $_POST['bp_date_travel'];
    $company = $_POST['company'];
    $type = $_POST['type'];
    $query_allom = "SELECT * 
                    FROM products_allotment 
                    WHERE products = '$bp_products'
                    AND date_from <= '$bp_date_travel' AND date_to >= '$bp_date_travel' ";
    $result_allom = mysqli_query($mysqli_p, $query_allom);
    $num_allom = mysqli_num_rows($result_allom);
    $row_allom = mysqli_fetch_array($result_allom, MYSQLI_ASSOC);
    
}
