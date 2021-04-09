<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> Booking </h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <!-- <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Datatable</a>
                                </li> -->
                                <li class="breadcrumb-item active">Home
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right">
                    <div class="dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1">
                        <div class="dt-buttons btn-group flex-wrap">
                            <a href="./?mode=booking/detail" class="btn add-new btn-primary"><span><i class="fas fa-plus"></i>&nbsp;&nbsp;Add Booking</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        # check value from search
        $search_status_val = !empty($_POST["search_status"]) ? $_POST["search_status"] : '0';
        $search_booking_val = !empty($_POST["search_booking"]) ? $_POST["search_booking"] : '';
        $search_fname_val = !empty($_POST["search_fname"]) ? $_POST["search_fname"] : '';
        $search_lname_val = !empty($_POST["search_lname"]) ? $_POST["search_lname"] : '';
        $search_phone_val = !empty($_POST["search_phone"]) ? $_POST["search_phone"] : '';
        $search_from_booking_val = !empty($_POST["search_from_booking"]) ? $_POST["search_from_booking"] : '';
        $search_to_booking_val = !empty($_POST["search_to_booking"]) ? $_POST["search_to_booking"] : '';
        $search_from_travel_val = !empty($_POST["search_from_travel"]) ? $_POST["search_from_travel"] : '';
        $search_to_travel_val = !empty($_POST["search_to_travel"]) ? $_POST["search_to_travel"] : '';
        $search_agent_val = !empty($_POST["search_agent"]) ? $_POST["search_agent"] : '0';
        $search_status_email_val = !empty($_POST["search_status_email"]) ? $_POST["search_status_email"] : '0';
        $search_status_confirm_val = !empty($_POST["search_status_confirm"]) ? $_POST["search_status_confirm"] : '0';
        ?>

        <!-- Section search start -->
        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Search</h4>
                        </div>
                        <div class="card-body">
                            <form action="./?mode=<?php echo $_GET["mode"]; ?>" enctype="multipart/form-data" method="POST" id="frmsearch" name="frmsearch" class="needs-validation">
                                <div class="form-row">
                                    <div class="col-xl-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="search_booking">Booking No.</label>
                                            <input type="text" class="form-control" id="search_booking" name="search_booking" placeholder="" value="<?php echo $search_booking_val; ?>" />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="search_fname">Frist Name</label>
                                            <input type="text" class="form-control" id="search_fname" name="search_fname" placeholder="" value="<?php echo $search_fname_val; ?>" />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="search_lname">Last Name</label>
                                            <input type="text" class="form-control" id="search_lname" name="search_lname" placeholder="" value="<?php echo $search_lname_val; ?>" />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="search_phone">Phone</label>
                                            <input type="text" class="form-control" id="search_phone" name="search_phone" placeholder="" value="<?php echo $search_phone_val; ?>" />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="search_from_booking">Date Booking (From)</label>
                                            <input type="date" class="form-control" id="search_from_booking" name="search_from_booking" placeholder="" value="<?php echo $search_from_booking_val; ?>" />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="search_to_booking">Date Booking (To)</label>
                                            <input type="date" class="form-control" id="search_to_booking" name="search_to_booking" placeholder="" value="<?php echo $search_to_booking_val; ?>" />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="search_from_travel">Date Travel (From)</label>
                                            <input type="date" class="form-control" id="search_from_travel" name="search_from_travel" placeholder="" value="<?php echo $search_from_travel_val; ?>" />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="search_to_travel">Date Travel (To)</label>
                                            <input type="date" class="form-control" id="search_to_travel" name="search_to_travel" placeholder="" value="<?php echo $search_to_travel_val; ?>" />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="search_agent">Agent</label>
                                            <select class="form-control" id="search_agent" name="search_agent">
                                                <option value="">-</option>
                                                <?php
                                                $query_agent = "SELECT combine_agent.*, company.id as comID, company.name as comName 
                                                                FROM combine_agent 
                                                                LEFT JOIN company
                                                                    ON combine_agent.agent = company.id
                                                                WHERE combine_agent.supplier = '" . $_SESSION["admin"]["company"] . "' AND combine_agent.offline = 2 ";
                                                $query_agent .= " ORDER BY id ASC";
                                                $result_agent = mysqli_query($mysqli_p, $query_agent);
                                                while ($row_agent = mysqli_fetch_array($result_agent, MYSQLI_ASSOC)) {
                                                ?>
                                                    <option value="<?php echo $row_agent["id"]; ?>" <?php if ($search_agent_val == $row_agent["id"]) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                        <?php echo $row_agent["comName"]; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="search_status">Status</label>
                                            <select class="form-control" id="search_status" name="search_status">
                                                <!-- required -->
                                                <option value="0" <?php if ($search_status_val == 0) {
                                                                        echo "selected";
                                                                    } ?>>All</option>
                                                <option value="2" <?php if ($search_status_val == 2) {
                                                                        echo "selected";
                                                                    } ?>>Online</option>
                                                <option value="1" <?php if ($search_status_val == 1) {
                                                                        echo "selected";
                                                                    } ?>>Offline</option>
                                            </select>
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="search_status_email">Status (Email)</label>
                                            <select class="form-control" id="search_status_email" name="search_status_email">
                                                <!-- required -->
                                                <option value="0" <?php if ($search_status_email_val == 0) {
                                                                        echo "selected";
                                                                    } ?>>All</option>
                                                <option value="1" <?php if ($search_status_email_val == 1) {
                                                                        echo "selected";
                                                                    } ?>>Sent</option>
                                                <option value="2" <?php if ($search_status_email_val == 2) {
                                                                        echo "selected";
                                                                    } ?>>Don't send</option>
                                                <option value="3" <?php if ($search_status_email_val == 3) {
                                                                        echo "selected";
                                                                    } ?>>Resend</option>
                                                <option value="4" <?php if ($search_status_email_val == 4) {
                                                                        echo "selected";
                                                                    } ?>>Cancel</option>
                                            </select>
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="search_status_confirm">Status (Confirm)</label>
                                            <select class="form-control" id="search_status_confirm" name="search_status_confirm">
                                                <!-- required -->
                                                <option value="0" <?php if ($search_status_email_val == 0) {
                                                                        echo "selected";
                                                                    } ?>>All</option>
                                                <option value="1" <?php if ($search_status_email_val == 1) {
                                                                        echo "selected";
                                                                    } ?>>Confirm</option>
                                                <option value="2" <?php if ($search_status_email_val == 2) {
                                                                        echo "selected";
                                                                    } ?>>Don't confirm</option>
                                                <option value="3" <?php if ($search_status_email_val == 3) {
                                                                        echo "selected";
                                                                    } ?>>Cancel</option>
                                            </select>
                                        </div>
                                    </div> <!-- div -->
                                </div>
                                <div class="form-row">
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light"><i class="fas fa-search"></i>&nbsp;&nbsp;Submit</button>
                                        <button type="button" class="btn btn-outline-primary waves-effect" onclick="window.location.href='./?mode=booking/list'"><i class="fas fa-redo-alt"></i>&nbsp;&nbsp;Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section search end -->

        <!-- booking table start -->
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <table class="table" id="datatables-booking">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Booking No.</th>
                                        <th>Date Booking</th>
                                        <th>Agent</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Date Travel</th>
                                        <th>Balance Booking</th>
                                        <th>Status (Email)</th>
                                        <th>Status (Confirm)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Procedural mysqli
                                    $bind_types = "";
                                    $params = array();

                                    $query = "SELECT booking.*, booking_no.id as no_id, booking_no.bo_full as bo_full, booking_no.bo_no as bo_no,
                                            combine_agent.id as cgid, combine_agent.supplier as cgspp, combine_agent.agent as cgagen, 
                                            company.id as comid, company.name as comname
                                            FROM booking
                                            LEFT JOIN booking_no
                                                ON booking.booking_no = booking_no.id
                                            LEFT JOIN combine_agent
                                                ON booking.agent = combine_agent.id
                                            LEFT JOIN company
                                                ON combine_agent.agent = company.id
                                            WHERE booking.id > '0' AND booking.company = '" . $_SESSION["admin"]["company"] . "' ";
                                    if (!empty($search_status_val)) {
                                        # search status
                                        $query .= " AND booking.offline = ?";
                                        $bind_types .= "i";
                                        array_push($params, $search_status_val);
                                    }
                                    if (!empty($search_agent_val)) {
                                        # search status
                                        $query .= " AND booking.agent = ?";
                                        $bind_types .= "i";
                                        array_push($params, $search_agent_val);
                                    }
                                    if (!empty($search_fname_val)) {
                                        # search firstname
                                        $param = "%{$search_fname_val}%";
                                        $query .= " AND booking.customer_firstname LIKE ?";
                                        $bind_types .= "s";
                                        array_push($params, $param);
                                    }
                                    if (!empty($search_lname_val)) {
                                        # search firstname
                                        $param = "%{$search_lname_val}%";
                                        $query .= " AND booking.customer_lastname LIKE ?";
                                        $bind_types .= "s";
                                        array_push($params, $param);
                                    }
                                    if (!empty($search_phone_val)) {
                                        # search status
                                        $query .= " AND booking.customer_mobile = ?";
                                        $bind_types .= "i";
                                        array_push($params, $search_phone_val);
                                    }
                                    if (!empty($search_phone_val)) {
                                        # search status
                                        $query .= " AND booking.customer_mobile = ?";
                                        $bind_types .= "i";
                                        array_push($params, $search_phone_val);
                                    }
                                    if (!empty($search_from_booking_val) && !empty($search_to_booking_val)) {
                                        # search status
                                        $query .= " AND booking.booking_date BETWEEN ? AND ?";
                                        $bind_types .= "ss";
                                        array_push($params, $search_from_booking_val, $search_to_booking_val);
                                    }


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
                                        <tr>
                                            <th> <span class="badge badge-pill <?php echo $status_class; ?>"> <?php echo $status_txt; ?> </span> </th>
                                            <th> <?php echo $row["bo_full"]; ?> </th>
                                            <th> <?php echo date("d F Y", strtotime($row["booking_date"])); ?> </th>
                                            <th> <?php echo !empty($row["comname"]) ? $row["comname"] : '-'; ?> </th>
                                            <th> <?php echo !empty($row["customer_firstname"]) ? $row["customer_firstname"] . ' ' . $row["customer_lastname"] : '-'; ?> </th>
                                            <th> <?php echo $row["customer_mobile"]; ?> </th>
                                            <th> <?php echo '-'; ?> </th>
                                            <th> <?php echo '%'; ?> </th>
                                            <th> <span class="badge badge-pill <?php echo $status_class; ?>"> <?php echo $status_txt; ?> </span> </th>
                                            <th> <span class="badge badge-pill <?php echo $status_class; ?>"> <?php echo $status_txt; ?> </span> </th>
                                            <th>
                                                <a href="./?mode=booking/detail&id=<?php echo $row["id"]; ?>" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                                <?php if ($row["trash_deleted"] == 1) { ?>
                                                    <?php if ($_SESSION["admin"]["permission"] == 1) { ?>
                                                        <a href="javascript:;" class="item-undo" onclick="restoreList(<?php echo $row['id']; ?>)"> <i class="fas fa-undo"></i> </a>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <a href="javascript:;" class="item-trash" onclick="deleteList(<?php echo $row['id']; ?>)"> <i class="far fa-trash-alt"></i> </a>
                                                <?php } ?>
                                            </th>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Booking table end -->
        </div>
    </div>
</div>