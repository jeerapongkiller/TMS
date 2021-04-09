<?php
require("../../../inc/connection.php");

if (!empty($_POST['id'])) {
    $query = "SELECT * FROM products WHERE id > '0' ";
    $query .= " AND id = ?";
    $query .= " LIMIT 1";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'i', $_POST["id"]);
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    if ($numrow > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $pro_no = $row["id"];
        $pro_company = $row["company"];
        $pro_type = $row["products_type"];
        $pro_offile = 1;
        $pro_name = stripslashes($row["name"]);
        $pro_name_copy = $pro_name . " - (Copy)";

        if (!empty($row["id"])) {
            $products_copy = "";
            if (empty($products_copy)) {
                $query_copy = "INSERT INTO products () VALUES ()";
                $result_copy = mysqli_query($mysqli_p, $query_copy);
                $products_copy = mysqli_insert_id($mysqli_p);

                if (!empty($products_copy)) {
                    $bind_types = "";
                    $params = array();

                    $query_copy = "UPDATE products SET";

                    $query_copy .= " company = ?,";
                    $bind_types .= "s";
                    array_push($params, $pro_company);

                    $query_copy .= " products_type = ?,";
                    $bind_types .= "s";
                    array_push($params, $pro_type);

                    $query_copy .= " name = ?,";
                    $bind_types .= "s";
                    array_push($params, $pro_name_copy);

                    $query_copy .= " cut_open = ?,";
                    $bind_types .= "s";
                    array_push($params, $row["cut_open"]);

                    $query_copy .= " cut_off = ?,";
                    $bind_types .= "i";
                    array_push($params, $row["cut_off"]);

                    $query_copy .= " offline = ?,";
                    $bind_types .= "i";
                    array_push($params, $pro_offile);

                    $query_copy .=  'date_create = now(),';

                    $query_copy .= " date_edit = now()";
                    $query_copy .= " WHERE id = '$products_copy'";
                    $procedural_statement_copy = mysqli_prepare($mysqli_p, $query_copy);
                    if ($bind_types != "") {
                        mysqli_stmt_bind_param($procedural_statement_copy, $bind_types, ...$params);
                    }
                    mysqli_stmt_execute($procedural_statement_copy);
                    $result_copy = mysqli_stmt_get_result($procedural_statement_copy);

                    /* ============================================================== */
                    /* Loop : products_periods */
                    /* ============================================================== */
                    $query_periods = "SELECT * FROM products_periods WHERE id > '0'";
                    $query_periods .= " AND products = ?";
                    $procedural_statement_periods = mysqli_prepare($mysqli_p, $query_periods);
                    mysqli_stmt_bind_param($procedural_statement_periods, 'i', $pro_no);
                    mysqli_stmt_execute($procedural_statement_periods);
                    $result_periods = mysqli_stmt_get_result($procedural_statement_periods);
                    $numrow_periods = mysqli_num_rows($result_periods);
                    if ($numrow_periods > 0) {
                        while ($rowperiods = mysqli_fetch_array($result_periods, MYSQLI_ASSOC)) {

                            $periods_id = "";
                            $periods_no = $rowperiods['id'];
                            $per_offile = 2;

                            if (empty($periods_id)) {
                                $query_insert = "INSERT INTO products_periods () VALUES ()";
                                $result_insert = mysqli_query($mysqli_p, $query_insert);
                                $periods_id = mysqli_insert_id($mysqli_p);

                                if (!empty($periods_id)) {
                                    $bind_types = "";
                                    $params = array();

                                    $query_update = "UPDATE products_periods SET";

                                    $query_update .= " offline = ?,";
                                    $bind_types .= "i";
                                    array_push($params, $per_offile);

                                    $query_update .= " products = ?,";
                                    $bind_types .= "i";
                                    array_push($params, $products_copy);

                                    $query_update .= " periods_from = ?,";
                                    $bind_types .= "s";
                                    array_push($params, $rowperiods['periods_from']);

                                    $query_update .= " periods_to = ?,";
                                    $bind_types .= "s";
                                    array_push($params, $rowperiods['periods_to']);

                                    $query_update .= ' date_create = now(),';

                                    $query_update .= " date_edit = now()";
                                    $query_update .= " WHERE id = '$periods_id'";
                                    $procedural_statement_update = mysqli_prepare($mysqli_p, $query_update);
                                    if ($bind_types != "") {
                                        mysqli_stmt_bind_param($procedural_statement_update, $bind_types, ...$params);
                                    }
                                    mysqli_stmt_execute($procedural_statement_update);
                                    $result_update = mysqli_stmt_get_result($procedural_statement_update);
                                }
                            }

                            $query_rates = "SELECT * FROM products_rates WHERE id > '0'";
                            $query_rates .= " AND products_periods = ?";
                            $query_rates .= " AND type_rates IN (1, 2)";
                            $procedural_statement_rates = mysqli_prepare($mysqli_p, $query_rates);
                            mysqli_stmt_bind_param($procedural_statement_rates, 'i', $periods_no);
                            mysqli_stmt_execute($procedural_statement_rates);
                            $result_rates = mysqli_stmt_get_result($procedural_statement_rates);
                            $numrow_rates = mysqli_num_rows($result_rates);
                            if ($numrow_rates > 0) {
                                while ($rowrates = mysqli_fetch_array($result_rates, MYSQLI_ASSOC)) {

                                    $rates_id = "";

                                    if (empty($rates_id)) {
                                        $query_rates = "INSERT INTO products_rates () VALUES ()";
                                        $result_pro_rates = mysqli_query($mysqli_p, $query_rates);
                                        $rates_id = mysqli_insert_id($mysqli_p);
                                    }

                                    if (!empty($rates_id)) {
                                        $bind_types = "";
                                        $params = array();

                                        $query_rate = "UPDATE products_rates SET";

                                        $query_rate .= " products_periods = ?,";
                                        $bind_types .= "i";
                                        array_push($params, $periods_id);

                                        $query_rate .= " type_rates = ?,";
                                        $bind_types .= "i";
                                        array_push($params, $rowrates['type_rates']);

                                        $query_rate .= " rate_adult = ?,";
                                        $bind_types .= "i";
                                        array_push($params, $rowrates['rate_adult']);

                                        $query_rate .= " rate_children = ?,";
                                        $bind_types .= "i";
                                        array_push($params, $rowrates['rate_children']);

                                        $query_rate .= " rate_infant = ?,";
                                        $bind_types .= "i";
                                        array_push($params, $rowrates['rate_infant']);

                                        $query_rate .= " rate_group = ?,";
                                        $bind_types .= "i";
                                        array_push($params, $rowrates['rate_group']);

                                        $query_rate .= " pax = ?,";
                                        $bind_types .= "i";
                                        array_push($params, $rowrates['pax']);

                                        $query_rate .= " rate_transfer = ?,";
                                        $bind_types .= "i";
                                        array_push($params, $rowrates['rate_transfer']);

                                        $query_rate .= ' date_create = now(),';

                                        $query_rate .= " date_edit = now()";
                                        $query_rate .= " WHERE id = '$rates_id'";
                                        $procedural_statement_rate = mysqli_prepare($mysqli_p, $query_rate);
                                        if ($bind_types != "") {
                                            mysqli_stmt_bind_param($procedural_statement_rate, $bind_types, ...$params);
                                        }
                                        mysqli_stmt_execute($procedural_statement_rate);
                                        $result_rate = mysqli_stmt_get_result($procedural_statement_rate);
                                    }
                                }
                            } #--- $numrow_rates > 0 ---#
                        }   #--- while ($rowperiods) ---#
                    } else {

                        echo "error";
                        exit();
                    } #--- $numrow_periods ---#

                    echo "success";
                    exit();
                } #--- !empty($products_copy) ---#
            } else {

                echo "error";
                exit();
            } #--- empty($products_copy) ---#
        } else {

            echo "error";
            exit();
        } #---- !empty($row["id"]) ---#
    } else {

        echo "error";
        exit();
    } #--- $numrow ---#
}
mysqli_close($mysqli_p);
