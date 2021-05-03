<?php
require("../../../inc/connection.php");

$data_products = array();

if (!empty($_POST['bp_products']) && !empty($_POST['bp_date_travel']) && !empty($_POST['company']) && !empty($_POST['type'])) {
    $bp_products = $_POST['bp_products'];
    $bp_date_travel = $_POST['bp_date_travel'];
    $company = $_POST['company'];
    $type = $_POST['type'];
    $query_period = "SELECT PR.*,
                            PP.id as ppId, PP.products as ppProducts, PP.periods_from as pp_from, PP.periods_to as pp_to, PP.offline as ppOffline,
                            PRO.id as proId, PRO.name as proName, PRO.cut_open as proCutOpen, PRO.cut_off as proCutOff, PRO.offline as proOffline
                    FROM products_rates PR
                    LEFT JOIN products_periods PP
                        ON PR.products_periods = PP.id
                    LEFT JOIN products PRO
                        ON PP.products = PRO.id 
                    WHERE PR.id = '$bp_products' ";
    $result_period = mysqli_query($mysqli_p, $query_period);
    $row_period = mysqli_fetch_array($result_period, MYSQLI_ASSOC);

    $date_period = date("d F Y", strtotime($row_period['pp_from'])) . ' - ' . date("d F Y", strtotime($row_period['pp_to']));
    $data_products[] = array(
        'products_name' => $row_period['proName'],
        'date_period' => $date_period,
        'products' => $row_period['proId'],
        'products_period' => $row_period['ppId'],
        'products_adult' => $row_period['rate_adult'],
        'products_children' => $row_period['rate_children'],
        'products_infant' => $row_period['rate_infant'],
        'products_group' => $row_period['rate_group'],
        'products_pax' => $row_period['pax'],
        'products_transfer' => $row_period['rate_transfer']
    );
} else {
    $data_products[] = array(
        'products_name' => 'No data',
        'date_period' => 'No relevant period',
        'products' => 0,
        'products_period' => 0,
        'products_adult' => 0,
        'products_children' => 0,
        'products_infant' => 0,
        'products_group' => 0,
        'products_pax' => 0,
        'products_transfer' => 0
    );
}
echo json_encode($data_products);
