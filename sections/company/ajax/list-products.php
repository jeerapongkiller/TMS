<?php
require("../../../inc/connection.php");

if (!empty($_POST['type']) && !empty($_POST['company'])) {
    $type = $_POST['type'];
    $company = $_POST['company'];
    switch ($type) {
        case '1':
            $T_name = 'Tours';
            $T_icon = 'fas fa-map';
            $color = 'info';
            break;
        case '2':
            $T_name = 'Activity';
            $T_icon = 'fas fa-life-ring';
            $color = 'success';
            break;
        case '3':
            $T_name = 'Transfer';
            $T_icon = 'fas fa-car';
            $color = 'warning';
            break;
        case '4':
            $T_name = 'Hotel';
            $T_icon = 'fas fa-hotel';
            $color = 'secondary';
            break;
        case '5':
            $T_name = 'Ticket';
            $T_icon = 'fas fa-ticket-alt';
            $color = 'danger';
            break;
    }
?>
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0"> <?php echo $T_name; ?> </h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <i class="<?php echo $T_icon; ?> font-size-20"></i>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrumb-right">
                <div class="dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1">
                    <div class="dt-buttons btn-group flex-wrap">
                        <a href="javascript:;" class="btn add-new btn-<?php echo $color; ?>" onclick="addProducts(<?php echo $type; ?>)"><span><i class="fas fa-plus"></i>&nbsp;&nbsp; <?php echo 'Add ' . $T_name; ?> </span></a>
                        <input type="hidden" name="type" id="type" value="<?php echo $type; ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accordion with margin start -->
    <section id="accordion-with-margin">
        <div class="row">
            <div class="col-sm-12">
                <?php
                // Procedural mysqli
                $bind_types = "";
                $params = array();

                $query = "SELECT * FROM products WHERE id > '0'";
                // if ($_SESSION["admin"]["permission"] != 1) {
                //     $query .= " AND trash_deleted != '1'";
                // }
                if (!empty($type)) {
                    # products_type
                    $query .= " AND products_type = ?";
                    $bind_types .= "i";
                    array_push($params, $type);
                }
                if (!empty($company)) {
                    # supplier
                    $query .= " AND company = ?";
                    $bind_types .= "i";
                    array_push($params, $company);
                }
                $query .= " ORDER BY name DESC";
                $procedural_statement = mysqli_prepare($mysqli_p, $query);

                // Check error query
                if ($procedural_statement == false) {
                    die("<pre>" . mysqli_error($mysqli_p) . PHP_EOL . $query . "</pre>");
                }

                if ($bind_types != "") {
                    mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
                }

                mysqli_stmt_execute($procedural_statement);
                $result = mysqli_stmt_get_result($procedural_statement);
                $numrow = mysqli_num_rows($result);
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                ?>
                    <div class="card collapse-icon plan-card border-<?php echo $color; ?> products-<?php echo $color; ?>">
                        <!-- Name starts-->
                        <div class="card-header row">
                            <div class="content-header-left col-md-9 col-12">
                                <h5 class="card-title"> <?php echo $row['name']; ?> </h5>
                            </div>
                            <div class="content-header-right text-md-right col-md-3 col-12">
                                <h5 class="card-title">
                                    <a href="./?mode=company/detail-periods&company=<?php echo $_POST['company']; ?>&products=<?php echo $row['id']; ?>" class="btn btn-outline-<?php echo $color; ?>"><span><i class="fas fa-plus"></i>&nbsp; Add Periods </span></a>
                                </h5>
                            </div>
                        </div>
                        <?php
                        // Procedural mysqli
                        $bind_types = "";
                        $params = array();
                        $first = 0;
                        $numrow_realtime = 1;

                        $query_rates = "SELECT PR.*, PP.id as ppID, PP.products as ppProducts, PP.periods_from as ppPeriods_from, PP.periods_to as ppPeriods_to, PP.offline as ppOffline
                                        FROM products_rates PR
                                        LEFT JOIN products_periods PP
                                        ON PR.products_periods = PP.id
                                        WHERE PR.id > '0'";
                        if (!empty($row['id'])) {
                            # supplier
                            $query_rates .= " AND products = ?";
                            $bind_types .= "i";
                            array_push($params, $row['id']);
                        }
                        $query_rates .= " ORDER BY date_create DESC";
                        $procedural_statement_rates = mysqli_prepare($mysqli_p, $query_rates);

                        // Check error query
                        if ($procedural_statement_rates == false) {
                            die("<pre>" . mysqli_error($mysqli_p) . PHP_EOL . $query_rates . "</pre>");
                        }

                        if ($bind_types != "") {
                            mysqli_stmt_bind_param($procedural_statement_rates, $bind_types, ...$params);
                        }

                        mysqli_stmt_execute($procedural_statement_rates);
                        $result_rates = mysqli_stmt_get_result($procedural_statement_rates);
                        $numrow_rates = mysqli_num_rows($result_rates);
                        while ($row_rates = mysqli_fetch_array($result_rates, MYSQLI_ASSOC)) {
                            $status_class_periods = $row_rates["ppOffline"] == 1 ? 'badge-light-danger' : 'badge-light-success';
                            $status_txt_periods = $row_rates["ppOffline"] == 1 ? 'Offline' : 'Online';
                            $type_rates =  get_value('type_rates', 'id', 'name', $row_rates["type_rates"], $mysqli_p);
                            $status_class_rates = $row_rates["offline"] == 1 ? 'badge-light-danger' : 'badge-light-success';
                            $status_txt_rates = $row_rates["offline"] == 1 ? 'Offline' : 'Online';
                            #---- Head ----#
                            if ($first != $row_rates["ppID"]) {
                                #---- Foot ----#
                                echo $numrow_realtime != 1 ? '</tbody></table></div></div></div></div></div></div>' : '';
                                $first = $row_rates["ppID"];
                        ?>
                                <div class="card-body products-<?php echo $color; ?> p-0 pl-2 pr-2 pb-1">
                                    <div class="collapse-margin" id="accordionExample">
                                        <div class="card border-<?php echo $color; ?>">
                                            <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#collapse<?php echo $row_rates['ppID']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $row_rates['ppID']; ?>">
                                                <span class="lead collapse-title">
                                                    <?php echo date("d F Y", strtotime($row_rates["ppPeriods_from"])) . ' - ' . date("d F Y", strtotime($row_rates["ppPeriods_to"])); ?>
                                                    <span class="badge badge-pill <?php echo $status_class_periods; ?>"> <?php echo $status_txt_periods; ?> </span>
                                                </span>
                                            </div>
                                            <div id="collapse<?php echo $row_rates['ppID']; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <a href="javascript:;" class="btn btn-outline-<?php echo $color; ?>" onclick="addRatesAgent(<?php echo $row_rates['ppID']; ?>)"><span><i class="fas fa-plus"></i>&nbsp; Add Rates Agent </span></a>
                                                    </h5>
                                                    <div class="table-responsive" id="div-products">
                                                        <table class="table">
                                                            <thead class="<?php echo 'thead-' . $color; ?>">
                                                                <tr>
                                                                    <th>Status</th>
                                                                    <th>Type Rates</th>
                                                                    <th>Adult</th>
                                                                    <th>Children</th>
                                                                    <th>Infant</th>
                                                                    <th>Group</th>
                                                                    <th>Pax</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php } ?>
                                                            <tr>
                                                                <td> <span class="badge badge-pill <?php echo $status_class_rates; ?>"> <?php echo $status_txt_rates; ?> </span> </td>
                                                                <td> 
                                                                    <?php echo $type_rates; ?>
                                                                    <input type="hidden" name="type_rates<?php echo $row_rates['id']; ?>" id="type_rates<?php echo $row_rates['id']; ?>" value="<?php echo $row_rates["type_rates"]; ?>" />
                                                                </td>
                                                                <td> 
                                                                    <?php echo number_format($row_rates["rate_adult"]); ?>
                                                                    <input type="hidden" name="rate_adult<?php echo $row_rates['id']; ?>" id="rate_adult<?php echo $row_rates['id']; ?>" value="<?php echo $row_rates['rate_adult']; ?>" />
                                                                </td>
                                                                <td> 
                                                                    <?php echo number_format($row_rates["rate_children"]); ?>
                                                                    <input type="hidden" name="rate_children<?php echo $row_rates['id']; ?>" id="rate_children<?php echo $row_rates['id']; ?>" value="<?php echo $row_rates['rate_children']; ?>" />
                                                                </td>
                                                                <td>
                                                                    <?php echo number_format($row_rates["rate_infant"]); ?>
                                                                    <input type="hidden" name="rate_infant<?php echo $row_rates['id']; ?>" id="rate_infant<?php echo $row_rates['id']; ?>" value="<?php echo $row_rates['rate_infant']; ?>" />
                                                                </td>
                                                                <td>
                                                                    <?php echo number_format($row_rates["rate_group"]); ?>
                                                                    <input type="hidden" name="rate_group<?php echo $row_rates['id']; ?>" id="rate_group<?php echo $row_rates['id']; ?>" value="<?php echo $row_rates['rate_group']; ?>" />    
                                                                </td>
                                                                <td>
                                                                    <?php echo number_format($row_rates["pax"]); ?>
                                                                    <input type="hidden" name="pax_rates<?php echo $row_rates['id']; ?>" id="pax_rates<?php echo $row_rates['id']; ?>" value="<?php echo $row_rates['pax']; ?>" />
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:;" class="pr-1 item-edit" onclick="addRates(<?php echo $row_rates['id']; ?>, <?php echo $type; ?>)"> <i class="far fa-edit"></i> </a>
                                                                    <?php if ($row_rates["trash_deleted"] == 1) { ?>
                                                                        <?php if ($_SESSION["admin"]["permission"] == 1) { ?>
                                                                            <a href="javascript:;" class="item-undo" onclick="restoreList(<?php echo $row_rates['id']; ?>)"> <i class="fas fa-undo"></i> </a>
                                                                        <?php } ?>
                                                                    <?php } else { ?>
                                                                        <a href="javascript:;" class="item-trash" onclick="deleteList(<?php echo $row_rates['id']; ?>)"> <i class="far fa-trash-alt"></i> </a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>

                                                        <?php $numrow_realtime++;
                                                    }
                                                    #---- Foot ----#
                                                    echo $numrow_realtime != 1 ? '</tbody></table></div></div></div></div></div></div>' : '';
                                                        ?>
                                                    </div>
                                                <?php } ?>
                                                </div>
                                            </div>
    </section>
    <!-- Accordion with margin end -->
<?php } ?>