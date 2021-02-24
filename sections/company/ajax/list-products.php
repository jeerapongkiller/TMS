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
                                    <a href="./?mode=company/detail-periods" class="btn btn-outline-<?php echo $color; ?>"><span><i class="fas fa-plus"></i>&nbsp; Add Periods </span></a>
                                    <!-- <button type="button" class="btn btn-outline-<?php echo $color; ?>" data-toggle="modal" data-target="#addperiods" onclick="fromPeriods(<?php echo $row['id']; ?>, <?php echo $type; ?>)"> <i class="fas fa-plus"></i>&nbsp; Add Periods </button> -->
                                </h5>
                            </div>
                        </div>
                        <?php
                        // Procedural mysqli
                        $bind_types = "";
                        $params = array();

                        $query_periods = "SELECT * FROM products_periods WHERE id > '0'";
                        // if ($_SESSION["admin"]["permission"] != 1) {
                        //     $query .= " AND trash_deleted != '1'";
                        // }
                        if (!empty($row['id'])) {
                            # supplier
                            $query_periods .= " AND products = ?";
                            $bind_types .= "i";
                            array_push($params, $row['id']);
                        }
                        $query_periods .= " ORDER BY date_create DESC";
                        $procedural_statement_periods = mysqli_prepare($mysqli_p, $query_periods);

                        // Check error query
                        if ($procedural_statement_periods == false) {
                            die("<pre>" . mysqli_error($mysqli_p) . PHP_EOL . $query_periods . "</pre>");
                        }

                        if ($bind_types != "") {
                            mysqli_stmt_bind_param($procedural_statement_periods, $bind_types, ...$params);
                        }

                        mysqli_stmt_execute($procedural_statement_periods);
                        $result_periods = mysqli_stmt_get_result($procedural_statement_periods);
                        $numrow_periods = mysqli_num_rows($result_periods);
                        while ($row_periods = mysqli_fetch_array($result_periods, MYSQLI_ASSOC)) {
                            $status_class_periods = $row_periods["offline"] == 1 ? 'badge-light-danger' : 'badge-light-success';
                            $status_txt_periods = $row_periods["offline"] == 1 ? 'Offline' : 'Online';
                        ?>
                            <div class="card-body products-<?php echo $color; ?> p-0 pl-2 pr-2 pb-1">
                                <div class="collapse-margin" id="accordionExample">
                                    <div class="card border-<?php echo $color; ?>">
                                        <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#collapse<?php echo $row_periods['id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $row_periods['id']; ?>">
                                            <span class="lead collapse-title">
                                                <?php echo date("d F Y", strtotime($row_periods["periods_from"])) . ' - ' . date("d F Y", strtotime($row_periods["periods_to"])); ?>
                                                <span class="badge badge-pill <?php echo $status_class_periods; ?>"> <?php echo $status_txt_periods; ?> </span>
                                            </span>
                                        </div>
                                        <div id="collapse<?php echo $row_periods['id']; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <a href="javascript:;" class="btn btn-outline-<?php echo $color; ?>" onclick="addPeriods(<?php echo $row['id']; ?>, <?php echo $type; ?>)"><span><i class="fas fa-plus"></i>&nbsp; Add Rates Agent </span></a>
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
                                                            <tr>
                                                                <td>test</td>
                                                                <td>test</td>
                                                                <td>test</td>
                                                                <td>test</td>
                                                                <td>test</td>
                                                                <td>test</td>
                                                                <td>test</td>
                                                                <td>test</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Accordion with margin end -->
<?php } ?>