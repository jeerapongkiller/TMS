<?php
require("../../../inc/connection.php");

if (!empty($_POST['booking']) && !empty($_POST['company']) && !empty($_POST['type']) && !empty($_POST['bp_supplier']) && !empty($_POST['bp_products']) && !empty($_POST['bp_date_travel'])) {
    #----- General Information -----#
    $data_return = array();
    $id = !empty($_POST["id"]) ? $_POST["id"] : '0';
    $booking = !empty($_POST["booking"]) ? $_POST["booking"] : '0';
    $page_title = !empty($_POST["page_title"]) ? $_POST["page_title"] : '';
    $company = !empty($_POST["company"]) ? $_POST["company"] : '0';
    $ptype = !empty($_POST["type"]) ? $_POST["type"] : '0';
    $offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
    $products = !empty($_POST["products"]) ? $_POST["products"] : '0';
    $products_periods = !empty($_POST["products_period"]) ? $_POST["products_period"] : '0';
    $bp_supplier = !empty($_POST["bp_supplier"]) && $_POST["bp_supplier"] != 'company' ? $_POST["bp_supplier"] : '0';
    $rates_agent = !empty($_POST["rate_agent"]) ? $_POST["rate_agent"] : '0';
    $bp_products = !empty($_POST["bp_products"]) ? $_POST["bp_products"] : '0';
    $bp_travel_date = !empty($_POST["bp_date_travel"]) ? $_POST["bp_date_travel"] : '';
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
    function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    if (empty($id)) {
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
                        AND PP.periods_from <= '$bp_travel_date' AND PP.periods_to >= '$bp_travel_date'
                        AND PR.offline = '2' AND PP.offline = '2' AND PRO.offline = '2' ";
        $result_rates = mysqli_query($mysqli_p, $query_rates);
        $num_rates = mysqli_num_rows($result_rates);
        if ($num_rates > 0) {
            $row_rates = mysqli_fetch_array($result_rates, MYSQLI_ASSOC);
            #----- Check Cut-off -----#
            if (!empty($row_rates['proCutOpen']) && !empty($row_rates['proCutOff'])) {
                $now = $today . ' ' . $time_hm;
                $date_cut = date('Y-m-d H:i', strtotime($bp_travel_date . ' ' . $row_rates['proCutOpen'] . '-' . $row_rates['proCutOff'] . ' hour'));
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
        $ip = get_client_ip();
        $description_field = "";

        $bp_adults_text = ($bp_adults > 0) ? $bp_adults : '-';
        $bp_children_text = ($bp_children > 0) ? $bp_children : '-';
        $bp_infant_text = ($bp_infant > 0) ? $bp_infant : '-';
        $add_trans_text = ($add_trans != 2) ? 'Yes!' : 'No!';
        $bp_pickup_text = !empty($bp_pickup) ? get_value("place", "id", "name", $bp_pickup, $mysqli_p) : 'N/A';
        $bp_dropoff_text = ($bp_dropoff > 0) ? get_value("place", "id", "name", $bp_dropoff, $mysqli_p) : 'N/A';
        $bp_latest_text = ($bp_latest > 0) ? $bp_latest : 0;

        # ---- Crate to history booking ---- #
        if ($return_edit == 'true') {

            if ($ptype != 4) {
                $description_field .= "Date Travel : " . date("d F Y", strtotime($bp_travel_date)) . "\n";
            } else {
                $description_field .= "Date Check-in : " . date("d F Y", strtotime($bp_checkin_date)) . "\n";
                $description_field .= "Date Check-out : " . date("d F Y", strtotime($bp_checkout_date)) . "\n";
            }

            $description_field .= "Adults : " . $bp_adults_text . " \n";
            $description_field .= "Children : " . $bp_children_text . " \n";
            $description_field .= "Infant : " . $bp_infant_text . " \n";
            // $description_field .= "FOC : " . $bp_foc_text . " คน\n";
            if ($ptype != 3 && $ptype != 4) {
                $description_field .= "Add Transfer : " . $add_trans_text . "\n";
            }
            $description_field .= "Pickup : " . $bp_pickup_text . "\n";
            $description_field .= "Dropoff : " . $bp_dropoff_text . "\n";
            // $description_field .= "โซน : " . $bp_zones_text . "\n";
            // $description_field .= "ห้องพัก : " . $bp_roomno_text . "\n";
            // if ($ptype == 3) {
            //     $description_field .= "จำนวนคัน : " . $bp_no_cars_text . " คัน\n";
            //     $description_field .= "จำนวนชั่วโมง : " . $bp_no_hours_text . " ชั่วโมง\n";
            //     $description_field .= "เวลารับ : " . $bp_pickup_time_text . "\n";
            //     $description_field .= "เวลาส่ง : " . $bp_dropoff_time_text . "\n";
            // }
            // if ($ptype == 4) {
            //     $description_field .= "จำนวนห้อง : " . $bp_no_rooms_text . " ห้อง\n";
            //     $description_field .= "จำนวนเตียงเสริม : " . $bp_extra_beds_text . " เตียง\n";
            //     $description_field .= "จำนวนแชร์เตียง : " . $bp_share_bed_text . " เตียง\n";
            // }
            // if ($ptype != 3 && $ptype != 4) {
            //     $description_field .= "ชาวต่างชาติ : " . $bp_foreigner_text . "\n";
            //     $description_field .= "จำนวนชาวต่างชาติ : " . $bp_foreigner_no_text . " คน\n";
            //     $description_field .= "ราคาเพิ่มเติมสำหรับชาวต่างชาติ : " . number_format($bp_foreigner_price_text) . " บาท\n";
            // }
            $description_field .= "Price Latest : " . number_format($bp_latest_text) . " THB\n";
            // $description_field .= "หมายเหตุ : \n" . $bp_notes_text . "\n";
        } else {
            $query_booking_prod = "SELECT * FROM booking_products WHERE id > '0'";
            $query_booking_prod .= " AND id = ?";
            $query_booking_prod .= " LIMIT 1";
            $procedural_statement = mysqli_prepare($mysqli_p, $query_booking_prod);
            mysqli_stmt_bind_param($procedural_statement, 'i', $id);
            mysqli_stmt_execute($procedural_statement);
            $result_prod = mysqli_stmt_get_result($procedural_statement);
            $row_booking_prod = mysqli_fetch_array($result_prod, MYSQLI_ASSOC);

            if ($ptype != 4) {
                $description_field .= ($bp_travel_date != $row_booking_prod["travel_date"]) ? "Date Travel : " . date("d F Y", strtotime($bp_travel_date)) . "\n" : "";
            } else {
                $description_field .= ($bp_checkin_date != $row_booking_prod["bp_checkin_date"]) ? "Date Check-in : " . date("d F Y", strtotime($bp_checkin_date)) . "\n" : "";
                $description_field .= ($bp_checkout_date != $row_booking_prod["bp_checkout_date"]) ? "Date Check-out : " . date("d F Y", strtotime($bp_checkout_date)) . "\n" : "";
            }

            $description_field .= ($bp_adults_text != $row_booking_prod["adults"]) ? "Adults : " . $bp_adults_text . " \n" : "";
            $description_field .= ($bp_children_text != $row_booking_prod["children"]) ? "Children : " . $bp_children_text . " \n" : "";
            $description_field .= ($bp_infant_text != $row_booking_prod["infant"]) ? "Infant : " . $bp_infant_text . " \n" : "";
            // $description_field .= ($bp_foc_text != $row_booking_prod["foc"]) ? "FOC : " . $bp_foc_text . " คน\n" : "";
            if ($ptype != 3 && $ptype != 4) {
                $description_field .= ($add_trans != $row_booking_prod["transfer"]) ? "Add Transfer : " . $add_trans_text . "\n" : "";
            }
            $description_field .= ($bp_pickup != $row_booking_prod["pickup"]) ? "Pickup : " . $bp_pickup_text . "\n" : "";
            $description_field .= ($bp_dropoff != $row_booking_prod["dropoff"]) ? "Dropoff : " . $bp_dropoff_text . "\n" : "";
            // $description_field .= ($bp_zones != $row_booking_prod["zones"]) ? "โซน : " . $bp_zones_text . "\n" : "";
            // $description_field .= ($bp_roomno != $row_booking_prod["roomno"]) ? "ห้องพัก : " . $bp_roomno_text . "\n" : "";
            // if ($ptype == 3) {
            //     $description_field .= ($bp_no_cars_text != $row_booking_prod["no_cars"]) ? "จำนวนคัน : " . $bp_no_cars_text . " คัน\n" : "";
            //     $description_field .= ($bp_no_hours_text != $row_booking_prod["no_hours"]) ? "จำนวนชั่วโมง : " . $bp_no_hours_text . " ชั่วโมง\n" : "";
            //     $description_field .= ($bp_pickup_time != $row_booking_prod["pickup_time"]) ? "เวลารับ : " . $bp_pickup_time_text . "\n" : "";
            //     $description_field .= ($bp_dropoff_time != $row_booking_prod["dropoff_time"]) ? "เวลาส่ง : " . $bp_dropoff_time_text . "\n" : "";
            // }
            // if ($ptype == 4) {
            //     $description_field .= ($bp_no_rooms_text != $row_booking_prod["no_rooms"]) ? "จำนวนห้อง : " . $bp_no_rooms_text . " ห้อง\n" : "";
            //     $description_field .= ($bp_extra_beds_text != $row_booking_prod["extra_beds"]) ? "จำนวนเตียงเสริม : " . $bp_extra_beds_text . " เตียง\n" : "";
            //     $description_field .= ($bp_share_bed_text != $row_booking_prod["share_bed"]) ? "จำนวนแชร์เตียง : " . $bp_share_bed_text . " เตียง\n" : "";
            // }
            // if ($ptype != 3 && $ptype != 4) {
            //     $description_field .= ($bp_foreigner != $row_booking_prod["foreigner"]) ? "ชาวต่างชาติ : " . $bp_foreigner_text . "\n" : "";
            //     $description_field .= ($bp_foreigner_no != $row_booking_prod["foreigner_no"]) ? "จำนวนชาวต่างชาติ : " . $bp_foreigner_no_text . " คน\n" : "";
            //     $description_field .= ($bp_foreigner_price != $row_booking_prod["foreigner_price"]) ? "ราคาเพิ่มเติมสำหรับชาวต่างชาติ : " . number_format($bp_foreigner_price_text) . " บาท\n" : "";
            // }
            $description_field .= ($bp_latest != $row_booking_prod["price_latest"]) ? "Price Latest : " . number_format($bp_latest_text) . " THB\n" : "";
            // $description_field .= "หมายเหตุ : \n" . $bp_notes_text . "\n";
        }

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
        array_push($params, $ptype);

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
        array_push($params, $bp_travel_date);

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

        # --- booking_history
        if (!empty($id) && !empty($booking) && $description_field != "") {
            # ---- Insert to booking_history ---- #
            $query_history = "INSERT INTO booking_history (booking, history_type, booking_products, description_field, users, ip_address, date_create)";
            $query_history .= "VALUES (0, 0, 0, '', 0, '', now())";
            $result = mysqli_query($mysqli_p, $query_history);
            $history_id = mysqli_insert_id($mysqli_p);

            $bind_types = "";
            $params = array();

            $query_history = "UPDATE booking_history SET";

            $query_history .= " booking = ?,";
            $bind_types .= "i";
            array_push($params, $booking);

            if ($return_edit == 'true') {
                $query_history .= " history_type = ?,";
                $bind_types .= "i";
                array_push($params, '1');
            } else {
                $query_history .= " history_type = ?,";
                $bind_types .= "i";
                array_push($params, '2');
            }

            $query_history .= " booking_products = ?,";
            $bind_types .= "i";
            array_push($params, $id);

            $query_history .= " description_field = ?,";
            $bind_types .= "s";
            array_push($params, $description_field);

            $query_history .= " users = ?,";
            $bind_types .= "i";
            array_push($params, $_SESSION["admin"]["id"]);

            $query_history .= " ip_address = ?,";
            $bind_types .= "s";
            array_push($params, $ip);

            $query_history .= " date_create = now()";
            $query_history .= " WHERE id = '$history_id'";
            $procedural_statement = mysqli_prepare($mysqli_p, $query_history);
            if ($bind_types != "") {
                mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
            }
            mysqli_stmt_execute($procedural_statement);
            $result = mysqli_stmt_get_result($procedural_statement);
        }

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
