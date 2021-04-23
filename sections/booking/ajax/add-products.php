<?php
require("../../../inc/connection.php");

if (!empty($_POST['company']) && !empty($_POST['type']) && !empty($_POST['bp_supplier']) && !empty($_POST['bp_products']) && !empty($_POST['bp_date_travel'])) {
    #----- General Information -----#
    $id = !empty($_POST["id"]) ? $_POST["id"] : '0';
    $page_title = !empty($_POST["page_title"]) ? $_POST["page_title"] : '';
    $company = !empty($_POST["company"]) ? $_POST["company"] : '0';
    $type = !empty($_POST["type"]) ? $_POST["type"] : '0';
    $offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
    $bp_supplier = !empty($_POST["bp_supplier"]) ? $_POST["bp_supplier"] : '0';
    $bp_products = !empty($_POST["bp_products"]) ? $_POST["bp_products"] : '0';
    $bp_date_travel = !empty($_POST["bp_date_travel"]) ? $_POST["bp_date_travel"] : '';
    $bp_adults = !empty($_POST["bp_adults"]) ? $_POST["bp_adults"] : '0';
    $bp_children = !empty($_POST["bp_children"]) ? $_POST["bp_children"] : '0';
    $bp_infant = !empty($_POST["bp_infant"]) ? $_POST["bp_infant"] : '0';
    $add_trans = !empty($_POST["add_trans"]) ? $_POST["add_trans"] : '2';
    $bp_pickup = !empty($_POST["bp_pickup"]) ? $_POST["bp_pickup"] : '0';
    $bp_dropoff = !empty($_POST["bp_dropoff"]) ? $_POST["bp_dropoff"] : '0';
    $rate_adult = !empty($_POST["rate_adult"]) ? $_POST["rate_adult"] : '0';
    $rate_children = !empty($_POST["rate_children"]) ? $_POST["rate_children"] : '0';
    $rate_infant = !empty($_POST["rate_infant"]) ? $_POST["rate_infant"] : '0';
    $rate_group = !empty($_POST["rate_group"]) ? $_POST["rate_group"] : '0';
    $products_pax = !empty($_POST["products_pax"]) ? $_POST["products_pax"] : '0';
    $rate_transfer = !empty($_POST["rate_transfer"]) ? $_POST["rate_transfer"] : '0';
    $bp_default = !empty($_POST["bp_default"]) ? preg_replace('(,)', '', $_POST["bp_default"]) : '0';
    $bp_latest = !empty($_POST["bp_latest"]) ? preg_replace('(,)', '', $_POST["bp_latest"]) : '0';
    $return = 'false'; // Return URL
    #----- Check Products & Cut-off -----#
    $query_rates = "SELECT PR.*, 
                        PP.id as ppId, PP.products as ppProducts, PP.periods_from as pp_from, PP.periods_to as pp_to, PP.offline as ppOffline,
                        PRO.id as proId, PRO.name as proName, PRO.cut_open as proCutOpen, PRO.cut_off as proCutOff, PRO.offline as proOffline
                        FROM products_rates PR
                        LEFT JOIN products_periods PP
                            ON PR.products_periods = PP.id
                        LEFT JOIN products PRO
                            ON PP.products = PRO.id
                        WHERE PR.id = '$bp_products'
                        AND PR.offline = '2' AND PP.offline = '2' AND PRO.offline = '2' ";
    $result_rates = mysqli_query($mysqli_p, $query_rates);
    $row_rates = mysqli_fetch_array($result_rates, MYSQLI_ASSOC);
    #----- Check Cut-off -----#
    if (!empty($row_rates['proCutOpen']) && !empty($row_rates['proCutOff'])) {
        $now = $today . ' ' . $time_hm;
        $date_cut = date('Y-m-d H:i', strtotime($bp_date_travel . ' ' . $row_rates['proCutOpen'] . '-' . $row_rates['proCutOff'] . ' hour'));
        $cut_off = (strtotime($now) <= strtotime($date_cut)) ? 'true' : 'false';
        if($cut_off == 'false') { echo $return; exit(); }
    }
}
