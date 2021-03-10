<?php
$company = $_SESSION["admin"]["company"];
$type = $_GET['type'];
switch ($type) {
    case '1':
        $T_name = 'Tours';
        $T_icon = 'fas fa-map';
        break;
    case '2':
        $T_name = 'Activity';
        $T_icon = 'fas fa-life-ring';
        break;
    case '3':
        $T_name = 'Transfer';
        $T_icon = 'fas fa-car';
        break;
    case '4':
        $T_name = 'Hotel';
        $T_icon = 'fas fa-hotel';
        break;
    case '5':
        $T_name = 'Ticket';
        $T_icon = 'fas fa-ticket-alt';
        break;
}
?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
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
                            <a href="javascript:;" class="btn add-new btn-primary" onclick="addProducts()"><span><i class="fas fa-plus"></i>&nbsp;&nbsp; <?php echo 'Add ' . $T_name; ?> </span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="company" name="company" value="<?php echo $company; ?>">
        <input type="hidden" id="type" name="type" value="<?php echo $type; ?>">

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
                        $status_class = $row["offline"] == 1 ? 'badge-light-danger' : 'badge-light-success';
                        $status_txt = $row["offline"] == 1 ? 'Offline' : 'Online';
                    ?>
                        <div class="card collapse-icon plan-card">
                            <!-- Name starts-->
                            <div class="card-header row">
                                <div class="content-header-left col-md-9 col-12">
                                    <div>
                                        <span class="card-title"> <?php echo $row['name']; ?> </span>
                                        <span class="badge badge-pill <?php echo $status_class; ?>"> <?php echo $status_txt; ?> </span>
                                    </div>
                                </div>
                                <div class="content-header-right text-md-right col-md-3 col-12">
                                    <h5 class="card-title">
                                        <a href="./?mode=products/detail-periods&type=<?php echo $type; ?>&products=<?php echo $row['id']; ?>" class="btn btn-outline-primary"><span><i class="fas fa-plus"></i>&nbsp; Add Periods </span></a>
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
                                $query_rates .= " AND PP.products = ?";
                                $bind_types .= "i";
                                array_push($params, $row['id']);
                            }
                            $query_rates .= " ORDER BY PP.id DESC , PR.date_create DESC ";
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
                                    <div class="card-body p-0 pl-2 pr-2 pb-1">
                                        <div class="collapse-margin" id="accordionExample">
                                            <div class="card">
                                                <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#collapse<?php echo $row_rates['ppID']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $row_rates['ppID']; ?>">
                                                    <span class="lead collapse-title">
                                                        <?php echo date("d F Y", strtotime($row_rates["ppPeriods_from"])) . ' - ' . date("d F Y", strtotime($row_rates["ppPeriods_to"])); ?>
                                                        <span class="badge badge-pill <?php echo $status_class_periods; ?>"> <?php echo $status_txt_periods; ?> </span>
                                                    </span>
                                                </div>
                                                <div id="collapse<?php echo $row_rates['ppID']; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <h5 class="card-title">
                                                            <a href="./?mode=products/detail-rates&company=<?php echo $_POST['company']; ?>&periods=<?php echo $row_rates['ppID']; ?>" class="btn btn-outline-primary"><span><i class="fas fa-plus"></i>&nbsp; Add Rates Agent </span></a>
                                                        </h5>
                                                        <div class="table-responsive" id="div-products">
                                                            <table class="table">
                                                                <thead class="thead-primary">
                                                                    <tr>
                                                                        <th>Status</th>
                                                                        <th>Type Rates</th>
                                                                        <th>Adult</th>
                                                                        <th>Children</th>
                                                                        <th>Infant</th>
                                                                        <th>Group</th>
                                                                        <th>Pax</th>
                                                                        <th>Transfer</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php } ?>
                                                                <tr>
                                                                    <td> <span class="badge badge-pill <?php echo $status_class_rates; ?>"> <?php echo $status_txt_rates; ?> </span> </td>
                                                                    <td>
                                                                        <?php echo $type_rates; ?></td>
                                                                    <td>
                                                                        <?php echo number_format($row_rates["rate_adult"]); ?></td>
                                                                    <td>
                                                                        <?php echo number_format($row_rates["rate_children"]); ?></td>
                                                                    <td>
                                                                        <?php echo number_format($row_rates["rate_infant"]); ?></td>
                                                                    <td>
                                                                        <?php echo number_format($row_rates["rate_group"]); ?></td>
                                                                    <td>
                                                                        <?php echo number_format($row_rates["pax"]); ?></td>
                                                                    <td>
                                                                        <?php echo number_format($row_rates["rate_transfer"]); ?></td>
                                                                    <td>
                                                                        <!-- <a href="javascript:;" class="pr-1 item-edit" onclick="addRates(<?php echo $row_rates['id']; ?>, <?php echo $type; ?>)"> <i class="far fa-edit"></i> </a> -->
                                                                        <a href="./?mode=products/detail-rates&company=<?php echo $_POST['company']; ?>&periods=<?php echo $row_rates['ppID']; ?>&id=<?php echo $row_rates['id']; ?>" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
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
                                                <div id="div-agent"></div>
        </section>
    </div>
</div>

<script>
    // Add Products
    function addProducts() {
        var company = document.getElementById('company')
        var type = document.getElementById('type')
        Swal.fire({
            title: 'Add Products',
            input: 'text',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ml-1',
                input: 'form-control'
            },
            buttonsStyling: false,
            selectAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Close',
        }).then((result) => {
            if (result.value) {
                jQuery.ajax({
                    url: "sections/products/ajax/add-products.php",
                    data: {
                        company: company.value,
                        type: type.value,
                        name: result.value
                    },
                    type: "POST",
                    success: function(response) {
                        Swal.fire({
                            title: "Successfuly!",
                            icon: "success"
                        }).then(function() {
                            // $("#div-agent").html(response);
                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                        });
                    },
                    error: function() {
                        Swal.fire('บันทึกข้อมูลไม่สำเร็จ!', 'กรุณาลองใหม่อีกครั้ง', 'error')
                    }
                });
            }
        })
    }
</script>