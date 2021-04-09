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
                            <!-- <a href="javascript:;" class="btn add-new btn-primary" onclick="addProducts()"><span><i class="fas fa-plus"></i>&nbsp;&nbsp; <?php echo 'Add ' . $T_name; ?> </span></a> -->
                            <a href="./?mode=products/detail-products&type=<?php echo $type; ?>" class="btn add-new btn-primary"><span><i class="fas fa-plus"></i>&nbsp;&nbsp; <?php echo 'Add ' . $T_name; ?> </span></a>
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
                    $query .= " ORDER BY date_create DESC";
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

                        <input type="hidden" id="pro_name<?php echo $row['id']; ?>" name="pro_name[]" value="<?php echo $row['name']; ?>">
                        <input type="hidden" id="pro_offline<?php echo $row['id']; ?>" name="pro_offline[]" value="<?php echo $row['offline']; ?>">

                        <div class="card collapse-icon plan-card">
                            <!-- Name starts-->
                            <div class="card-header row mb-1">
                                <div class="content-header-left col-md-9 col-12">
                                    <div>
                                        <span class="card-title"> <?php echo $row['name']; ?> </span>
                                        <span class="badge badge-pill <?php echo $status_class; ?>"> <?php echo $status_txt; ?> </span>
                                        <a href="./?mode=products/detail-products&type=<?php echo $type; ?>&id=<?php echo $row['id']; ?>"><i data-feather='edit'></i></a>
                                        <?php if ($row["trash_deleted"] == 1) { ?>
                                            <?php if ($_SESSION["admin"]["permission"] == 1) { ?>
                                                <a href="#restore" class="item-undo" onclick="restoreList(<?php echo $row['id']; ?>)"> <i data-feather='rotate-ccw'></i> </a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <a href="#trash" onclick="deleteProducts(<?php echo $row['id']; ?>);"><i data-feather='trash'></i></a>
                                        <?php } ?>
                                        <a href="#copy" onclick="copyProducts(<?php echo $row['id']; ?>);"><i data-feather='copy'></i></a>
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
                            $query_rates = "SELECT PR.*, PP.id as ppID, PP.products as ppProducts, PP.periods_from as ppPeriods_from, PP.periods_to as ppPeriods_to, 
                                            PP.offline as ppOffline, PP.trash_deleted as ppTrash_deleted
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
                                                        <p class="card-title">
                                                            <!-- <a href="./?mode=products/detail-rates&type=<?php echo $type; ?>&periods=<?php echo $row_rates['ppID']; ?>" class="btn btn-outline-primary"><span><i class="fas fa-plus"></i>&nbsp; Add Rates Agent </span></a> -->
                                                            <!-- <a href="#edit" data-toggle="tooltip" data-placement="top" title="Edit periods"><i data-feather='edit'></i></a> -->
                                                            <?php if ($row_rates["ppTrash_deleted"] == 1) { ?>
                                                                <?php if ($_SESSION["admin"]["permission"] == 1) { ?>
                                                                    <a href="#restore" data-toggle="tooltip" data-placement="top" title="Restore periods" onclick="restorePeriods(<?php echo $row_rates['ppID']; ?>);"><i data-feather='rotate-ccw'></i></a>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <a href="#trash" data-toggle="tooltip" data-placement="top" title="Delete periods" onclick="deletePeriods(<?php echo $row_rates['ppID']; ?>);"><i data-feather='trash'></i></a>
                                                            <?php } ?>
                                                            <a href="./?mode=products/detail-rates&type=<?php echo $type; ?>&periods=<?php echo $row_rates['ppID']; ?>" data-toggle="tooltip" data-placement="top" title="Add Rates Agent"><i data-feather='plus'></i></a>
                                                        </p>
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
                                                                        <a href="./?mode=products/detail-rates&type=<?php echo $type; ?>&periods=<?php echo $row_rates['ppID']; ?>&id=<?php echo $row_rates['id']; ?>" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                                                        <?php if ($row_rates["trash_deleted"] == 1) { ?>
                                                                            <?php if ($_SESSION["admin"]["permission"] == 1) { ?>
                                                                                <a href="javascript:;" class="item-undo" onclick="restoreRates(<?php echo $row_rates['id']; ?>)"> <i class="fas fa-undo"></i> </a>
                                                                            <?php } ?>
                                                                        <?php } else { ?>
                                                                            <a href="javascript:;" class="item-trash" onclick="deleteRates(<?php echo $row_rates['id']; ?>)"> <i class="far fa-trash-alt"></i> </a>
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
    // Copy Products
    function copyProducts(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Are your sure?',
            text: "Do you want to copy this information?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {
                jQuery.ajax({
                    url: "sections/products/ajax/copy-products.php",
                    data: {
                        id: id
                    },
                    type: "POST",
                    success: function(response) {
                        // $("#div-agent").html(response);
                        if (response == "success") {
                            Swal.fire({
                                title: "Complete!",
                                text: "Copying data is complete!",
                                icon: "success"
                            }).then(function() {
                                location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                            });
                        } else {
                            Swal.fire({
                                title: "Copying data failed!",
                                text: "Please try again",
                                icon: "error"
                            }).then(function() {
                                location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                            });
                        }
                    },
                    error: function() {
                        Swal.fire('Copying data failed!', 'Please try again', 'error')
                    }
                });
            }
        })
        return true;
    }

    // Delete products
    function deleteProducts(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: "Do you need delete this information?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No!'
        }).then((result) => {
            if (result.value) {
                jQuery.ajax({
                    url: "sections/products/ajax/deletelist.php",
                    data: {
                        id: id
                    },
                    type: "POST",
                    success: function(response) {
                        Swal.fire({
                            title: "Completed!",
                            text: "Delete this information Completed",
                            icon: "success"
                        }).then(function() {
                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                        });
                    },
                    error: function() {
                        Swal.fire('Delete this information failed!', 'Please try again', 'error')
                    }
                });
            }
        })
        return true;
    }

    // Delete Periods
    function deletePeriods(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: "Do you need delete this information?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No!'
        }).then((result) => {
            if (result.value) {
                jQuery.ajax({
                    url: "sections/products/ajax/delete-periods.php",
                    data: {
                        id: id
                    },
                    type: "POST",
                    success: function(response) {
                        Swal.fire({
                            title: "Completed!",
                            text: "Delete this information Completed",
                            icon: "success"
                        }).then(function() {
                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                        });
                    },
                    error: function() {
                        Swal.fire('Delete this information failed!', 'Please try again', 'error')
                    }
                });
            }
        })
        return true;
    }

    // Delete Rates
    function deleteRates(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: "Do you need delete this information?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No!'
        }).then((result) => {
            if (result.value) {
                jQuery.ajax({
                    url: "sections/products/ajax/delete-rates.php",
                    data: {
                        id: id
                    },
                    type: "POST",
                    success: function(response) {
                        Swal.fire({
                            title: "Completed!",
                            text: "Delete this information Completed",
                            icon: "success"
                        }).then(function() {
                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                        });
                    },
                    error: function() {
                        Swal.fire('Delete this information failed!', 'Please try again', 'error')
                    }
                });
            }
        })
        return true;
    }

    // Restore products
    function restoreList(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: "Do you need restore this information?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No!'
        }).then((result) => {
            if (result.value) {
                jQuery.ajax({
                    url: "sections/products/ajax/restorelist.php",
                    data: {
                        id: id
                    },
                    type: "POST",
                    success: function(response) {
                        Swal.fire({
                            title: "Completed!",
                            text: "Restore this information Completed",
                            icon: "success"
                        }).then(function() {
                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                        });
                    },
                    error: function() {
                        Swal.fire('Restore this information failed!', 'Please try again', 'error')
                    }
                });
            }
        })
        return true;
    }

    // Restore Periods
    function restorePeriods(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: "Do you need restore this information?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No!'
        }).then((result) => {
            if (result.value) {
                jQuery.ajax({
                    url: "sections/products/ajax/restore-periods.php",
                    data: {
                        id: id
                    },
                    type: "POST",
                    success: function(response) {
                        Swal.fire({
                            title: "Completed!",
                            text: "Restore this information Completed",
                            icon: "success"
                        }).then(function() {
                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                        });
                    },
                    error: function() {
                        Swal.fire('Restore this information failed!', 'Please try again', 'error')
                    }
                });
            }
        })
        return true;
    }

    // Restore Rates
    function restoreRates(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: "Do you need restore this information?",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No!'
        }).then((result) => {
            if (result.value) {
                jQuery.ajax({
                    url: "sections/products/ajax/restore-rates.php",
                    data: {
                        id: id
                    },
                    type: "POST",
                    success: function(response) {
                        Swal.fire({
                            title: "Completed!",
                            text: "Restore this information Completed",
                            icon: "success"
                        }).then(function() {
                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                        });
                    },
                    error: function() {
                        Swal.fire('Restore this information failed!', 'Please try again', 'error')
                    }
                });
            }
        })
        return true;
    }
</script>