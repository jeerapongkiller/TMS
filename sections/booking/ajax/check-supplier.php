<?php
require("../../../inc/connection.php");

if (!empty($_POST['bp_supplier']) && !empty($_POST['company']) && !empty($_POST['bp_date_travel']) && empty($_POST['id'])) {
    $combine_agent = $_POST['bp_supplier'];
    $bp_rates_agent = $_POST['bp_rates_agent'];
    $company = $_POST['company'];
    $bp_date_travel = $_POST['bp_date_travel'];
    $check_option = 0;
    // Agent Rates
    if ($_POST['bp_supplier'] != 'company') {
        $query_products = "SELECT RAG.*, 
                            CAG.id as cagId, CAG.supplier as cagSupplier, CAG.agent as cagAgent, CAG.offline as cagOffline,
                            PR.id as prId, PR.products_periods as prPP, PR.offline as prOffline, 
                            PP.id as ppId, PP.products as ppProducts, PP.periods_from as pp_from, PP.periods_to as pp_to, PP.offline as ppOffline,
                            PRO.id as proId, PRO.name as proName, PRO.cut_open as proCutOpen, PRO.cut_off as proCutOff, PRO.offline as proOffline
                            FROM rates_agent RAG
                            LEFT JOIN combine_agent CAG
                                ON RAG.combine_agent = CAG.id
                            LEFT JOIN products_rates PR
                                ON RAG.products_rates = PR.id
                            LEFT JOIN products_periods PP
                                ON PR.products_periods = PP.id
                            LEFT JOIN products PRO
                                ON PP.products = PRO.id
                            WHERE CAG.id = '$combine_agent' AND PP.periods_from <= '$bp_date_travel' AND PP.periods_to >= '$bp_date_travel'
                            AND CAG.offline = '2' AND PR.offline = '2' AND PP.offline = '2' AND PRO.offline = '2' ";
        $result_products = mysqli_query($mysqli_p, $query_products);
        // echo $query_products;
?>
        <label for="bp_products"> Products </label>
        <select class="custom-select" id="bp_products" name="bp_products" onchange="checkPeriod()" required>
            <?php
            while ($row_products = mysqli_fetch_array($result_products, MYSQLI_ASSOC)) {
                // Check Cut Off
                if (!empty($row_products['proCutOpen']) && !empty($row_products['proCutOff'])) {
                    $now = $today . ' ' . $time_hm;
                    $date_cut = date('Y-m-d H:i', strtotime($bp_date_travel . ' ' . $row_products['proCutOpen'] . '-' . $row_products['proCutOff'] . ' hour'));
                    $cut_off = (strtotime($now) <= strtotime($date_cut)) ? 'true' : 'false';
                    // $date_cut = date('Y-m-d H:i', strtotime($today . ' ' . $row_products['proCutOpen'] . '-' . $row_products['proCutOff'] . ' hour'));
                    // $date_cut = strtotime($date_cut);
                    // $date_travel = strtotime($bp_date_travel.' '.$time_hm);
                    // $cut_off = $today == $bp_date_travel ? $date_cut - $date_travel : $date_travel - $date_cut ;
                    if ($cut_off == 'true') {
                        $check_option++;
                        echo '<option value=" ' . $row_products['prId'] . ' " data-ragent=" ' . $row_products['id'] . ' " >' . $row_products['proName'] . '</option>';
                    }
                } else {
                    $check_option++;
                    echo '<option value=" ' . $row_products['prId'] . ' " data-ragent=" ' . $row_products['id'] . ' " >' . $row_products['proName'] . '</option>';
                }
            }
            if ($check_option == 0) {
                echo "<option value=''> No Data </option>";
            }
            ?>
        </select>
    <?php
        // Company Rates
    } else {
        $query_products = "SELECT PR.*, 
                            PP.id as ppId, PP.products as ppProducts, PP.periods_from as pp_from, PP.periods_to as pp_to, PP.offline as ppOffline,
                            PRO.id as proId, PRO.name as proName, PRO.cut_open as proCutOpen, PRO.cut_off as proCutOff, PRO.offline as proOffline
                            FROM products_rates PR
                            LEFT JOIN products_periods PP
                                ON PR.products_periods = PP.id
                            LEFT JOIN products PRO
                                ON PP.products = PRO.id
                            WHERE PRO.company = '$company' AND PR.type_rates = '2'
                            AND PP.periods_from <= '$bp_date_travel' AND PP.periods_to >= '$bp_date_travel'
                            AND PR.offline = '2' AND PP.offline = '2' AND PRO.offline = '2' ";
        $result_products = mysqli_query($mysqli_p, $query_products);
    ?>
        <label for="bp_products"> Products </label>
        <select class="custom-select" id="bp_products" name="bp_products" onchange="checkPeriod()" required>
            <?php
            while ($row_products = mysqli_fetch_array($result_products, MYSQLI_ASSOC)) {
                // Check Cut Off
                if (!empty($row_products['proCutOpen']) && !empty($row_products['proCutOff'])) {
                    $now = $today . ' ' . $time_hm;
                    $date_cut = date('Y-m-d H:i', strtotime($bp_date_travel . ' ' . $row_products['proCutOpen'] . '-' . $row_products['proCutOff'] . ' hour'));
                    $cut_off = (strtotime($now) <= strtotime($date_cut)) ? 'true' : 'false';
                    if ($cut_off == 'true') {
                        $check_option++;
                        echo '<option value=" ' . $row_products['id'] . ' " >' . $row_products['proName'] . '</option>';
                    }
                } else {
                    $check_option++;
                    echo '<option value=" ' . $row_products['id'] . ' " >' . $row_products['proName'] . '</option>';
                }
            }
            if ($check_option == 0) {
                echo "<option value=''> No Data </option>";
            } ?>
        </select>
    <?php
    }
} else {
    if (!empty($_POST['id'])) {
        $bp_products_rates = !empty($_POST['bp_products_rates']) ? $_POST['bp_products_rates'] : '0' ;
        $default_products = !empty($_POST['default_products']) ? $_POST['default_products'] : '0' ;
         ?>
        <label for="bp_products"> Products </label>
        <input type="text" class="form-control" id="text_products" name="text_products" value="<?php echo get_value('products', 'id', 'name', $default_products, $mysqli_p); ?>" readonly>
        <input type="hidden" class="form-control" id="bp_products" name="bp_products" value="<?php echo $bp_products_rates; ?>">
    <?php } else { ?>
        <label for="bp_products"> Products </label>
        <select class="custom-select" id="bp_products" name="bp_products" required>
            <option value="">No Data</option>
        </select>
<?php }
} ?>