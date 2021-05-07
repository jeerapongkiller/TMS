<?php
require("../../../inc/connection.php");

if (!empty($_POST['booking']) && !empty($_POST['company']) && !empty($_POST['type']) && !empty($_POST['bp_supplier']) && !empty($_POST['bp_products']) && !empty($_POST['bp_date_travel'])) {
    #----- General Information -----#
    $data_return = array();
    $id = !empty($_POST["id"]) ? $_POST["id"] : '0';
    $booking = !empty($_POST["booking"]) ? $_POST["booking"] : '0';
    $page_title = !empty($_POST["page_title"]) ? $_POST["page_title"] : '';
    $company = !empty($_POST["company"]) ? $_POST["company"] : '0';
    $type = !empty($_POST["type"]) ? $_POST["type"] : '0';
    $offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
    $products = !empty($_POST["products"]) ? $_POST["products"] : '0';
    $products_periods = !empty($_POST["products_period"]) ? $_POST["products_period"] : '0';
    $bp_supplier = !empty($_POST["bp_supplier"]) && $_POST["bp_supplier"] != 'company' ? $_POST["bp_supplier"] : '0';
    $rates_agent = !empty($_POST["rate_agent"]) ? $_POST["rate_agent"] : '0';
    $bp_products = !empty($_POST["bp_products"]) ? $_POST["bp_products"] : '0';
    $bp_date_travel = !empty($_POST["bp_date_travel"]) ? $_POST["bp_date_travel"] : '';
    $bp_adults = !empty($_POST["bp_adults"]) ? $_POST["bp_adults"] : '0';
    $bp_children = !empty($_POST["bp_children"]) ? $_POST["bp_children"] : '0';
    $bp_infant = !empty($_POST["bp_infant"]) ? $_POST["bp_infant"] : '0';
    $add_trans = !empty($_POST["add_trans"]) ? $_POST["add_trans"] : '2';
    $bp_pickup = !empty($_POST["bp_pickup"]) ? $_POST["bp_pickup"] : '0';
    $bp_dropoff = !empty($_POST["bp_dropoff"]) ? $_POST["bp_dropoff"] : '0';
    $rate_adults = !empty($_POST["rate_adult"]) ? $_POST["rate_adult"] : '0';
    $rate_children = !empty($_POST["rate_children"]) ? $_POST["rate_children"] : '0';
    $rate_infant = !empty($_POST["rate_infant"]) ? $_POST["rate_infant"] : '0';
    $rate_group = !empty($_POST["rate_group"]) ? $_POST["rate_group"] : '0';
    $products_pax = !empty($_POST["products_pax"]) ? $_POST["products_pax"] : '0';
    $rate_transfer = !empty($_POST["rate_transfer"]) ? $_POST["rate_transfer"] : '0';
    $bp_default = !empty($_POST["bp_default"]) ? preg_replace('(,)', '', $_POST["bp_default"]) : '0';
    $bp_latest = !empty($_POST["bp_latest"]) ? preg_replace('(,)', '', $_POST["bp_latest"]) : '0';
    $return = 'false';
    $return_cutoff = 'false';
    $return_edit = 'false';
    $return_url = '';
    #----- Check Products & Cut-off -----#
    if (empty($id)) {
        $query_rates = "SELECT PR.*, 
                        PP.id as ppId, PP.products as ppProducts, PP.periods_from as pp_from, PP.periods_to as pp_to, PP.offline as ppOffline,
                        PRO.id as proId, PRO.name as proName, PRO.cut_open as proCutOpen, PRO.cut_off as proCutOff, PRO.offline as proOffline
                        FROM products_rates PR
                        LEFT JOIN products_periods PP
                            ON PR.products_periods = PP.id
                        LEFT JOIN products PRO
                            ON PP.products = PRO.id
                        WHERE PR.id = '$bp_products'
                        AND PP.periods_from <= '$bp_date_travel' AND PP.periods_to >= '$bp_date_travel'
                        AND PR.offline = '2' AND PP.offline = '2' AND PRO.offline = '2' ";
        $result_rates = mysqli_query($mysqli_p, $query_rates);
        $num_rates = mysqli_num_rows($result_rates);
        if ($num_rates > 0) {
            $row_rates = mysqli_fetch_array($result_rates, MYSQLI_ASSOC);
            #----- Check Cut-off -----#
            if (!empty($row_rates['proCutOpen']) && !empty($row_rates['proCutOff'])) {
                $now = $today . ' ' . $time_hm;
                $date_cut = date('Y-m-d H:i', strtotime($bp_date_travel . ' ' . $row_rates['proCutOpen'] . '-' . $row_rates['proCutOff'] . ' hour'));
                $cut_off = (strtotime($now) <= strtotime($date_cut)) ? 'true' : 'false';
            }
            if (!empty($cut_off) && $cut_off == 'false') {
                $data_return[] = array(
                    'add_return' => $return,
                    'add_return_cutoff' => $return_cutoff,
                    'add_return_url' => $return_url
                );
                echo json_encode($data_return);
                exit();
            }
        }
        # ---- Insert to database ---- #
        $query = "INSERT INTO booking_products(company, booking, combine_agent, products_type, products, products_periods, products_rates, rates_agent, travel_date, adults, children, infant, transfer, no_cars, no_hours, 
                                    pickup, pickup_time, dropoff, dropoff_time, rate_adults, rate_children, rate_infant, rate_group, rate_transfer, pax, price_default, price_latest, offline, trash_deleted, date_create, date_edit) 
                            VALUES ('0', '0', '0', '0', '0', '0', '0', '0', '', '0', '0', '0', '0', '0', '0',
                                    '0', '', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '2', '2', now(), now()) ";
        $result = mysqli_query($mysqli_p, $query);
        $id = mysqli_insert_id($mysqli_p);
        $return_edit = 'true';
    }
    if (!empty($id)) {
        # ---- Update to database ---- #
        $bind_types = "";
        $params = array();

        $query = "UPDATE booking_products SET";

        $query .= " offline = ?,";
        $bind_types .= "i";
        array_push($params, $offline);

        $query .= " company = ?,";
        $bind_types .= "i";
        array_push($params, $company);

        $query .= " booking = ?,";
        $bind_types .= "i";
        array_push($params, $booking);

        $query .= " combine_agent = ?,";
        $bind_types .= "i";
        array_push($params, $bp_supplier);

        $query .= " products_type = ?,";
        $bind_types .= "i";
        array_push($params, $type);

        $query .= " products = ?,";
        $bind_types .= "i";
        array_push($params, $products);

        $query .= " products_periods = ?,";
        $bind_types .= "i";
        array_push($params, $products_periods);

        $query .= " products_rates = ?,";
        $bind_types .= "i";
        array_push($params, $bp_products);

        $query .= " rates_agent = ?,";
        $bind_types .= "i";
        array_push($params, $rates_agent);

        $query .= " travel_date = ?,";
        $bind_types .= "s";
        array_push($params, $bp_date_travel);

        $query .= " adults = ?,";
        $bind_types .= "i";
        array_push($params, $bp_adults);

        $query .= " children = ?,";
        $bind_types .= "i";
        array_push($params, $bp_children);

        $query .= " infant = ?,";
        $bind_types .= "i";
        array_push($params, $bp_infant);

        $query .= " transfer = ?,";
        $bind_types .= "i";
        array_push($params, $add_trans);

        // $query .= " no_cars = ?,";
        // $bind_types .= "i";
        // array_push($params, $no_cars);

        // $query .= " no_hours = ?,";
        // $bind_types .= "i";
        // array_push($params, $no_hours);

        $query .= " pickup = ?,";
        $bind_types .= "i";
        array_push($params, $bp_pickup);

        // $query .= " pickup_time = ?,";
        // $bind_types .= "i";
        // array_push($params, $pickup_time);

        $query .= " dropoff = ?,";
        $bind_types .= "i";
        array_push($params, $bp_dropoff);

        // $query .= " dropoff_time = ?,";
        // $bind_types .= "i";
        // array_push($params, $dropoff_time);

        $query .= " rate_adults = ?,";
        $bind_types .= "i";
        array_push($params, $rate_adults);

        $query .= " rate_children = ?,";
        $bind_types .= "i";
        array_push($params, $rate_children);

        $query .= " rate_infant = ?,";
        $bind_types .= "i";
        array_push($params, $rate_infant);

        $query .= " rate_group = ?,";
        $bind_types .= "i";
        array_push($params, $rate_group);

        $query .= " rate_transfer = ?,";
        $bind_types .= "i";
        array_push($params, $rate_transfer);

        $query .= " pax = ?,";
        $bind_types .= "i";
        array_push($params, $products_pax);

        $query .= " price_default = ?,";
        $bind_types .= "i";
        array_push($params, $bp_default);

        $query .= " price_latest = ?,";
        $bind_types .= "i";
        array_push($params, $bp_latest);

        $query .= ($page_title == "Add New Products") ? ' date_create = now(),' : '';

        $query .= " date_edit = now()";
        $query .= " WHERE id = '$id'";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        if ($bind_types != "") {
            mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
        }
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);
        mysqli_close($mysqli_p);

        $return_cutoff = 'true';
        $return = 'true';
        $return_url = $return_edit == 'true' ? '&id=' . $id : '';
        $data_return[] = array(
            'add_return' => $return,
            'add_return_cutoff' => $return_cutoff,
            'add_return_url' => $return_url
        );
        echo json_encode($data_return);
        exit();
    }
} else {
    $data_return[] = array(
        'add_return' => $return,
        'add_return_cutoff' => $return_cutoff,
        'add_return_url' => $return_url
    );
    echo json_encode($data_return);
    exit();
}
