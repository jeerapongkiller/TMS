<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">User</h2>
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
                            <a href="./?mode=users/detail" class="btn add-new btn-primary"><span><i class="fas fa-plus"></i>&nbsp;&nbsp;Add User</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        # check value from search
        $search_firstname_val = !empty($_POST["search_firstname"]) ? $_POST["search_firstname"] : '';
        $search_lastname_val = !empty($_POST["search_lastname"]) ? $_POST["search_lastname"] : '';
        $search_username_val = !empty($_POST["search_username"]) ? $_POST["search_username"] : '';
        $search_status_val = !empty($_POST["search_status"]) ? $_POST["search_status"] : '';
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
                            <form action="./?mode=<?php echo $_GET["mode"]; ?>" enctype="multipart/form-data" method="POST" id="frmsearch" name="frmsearch" class="needs-validation" >
                                <div class="form-row">
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="search_firstname">First name</label>
                                            <input type="text" class="form-control" id="search_firstname" name="search_firstname" placeholder="" value="<?php echo $search_firstname_val; ?>" />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="search_lastname">Last name</label>
                                            <input type="text" class="form-control" id="search_lastname" name="search_lastname" placeholder="" value="<?php echo $search_lastname_val; ?>" />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="search_username">Username</label>
                                            <input type="text" class="form-control" id="search_username" name="search_username" placeholder="" value="<?php echo $search_username_val; ?>" />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="search_status">Status</label>
                                            <select class="form-control" id="search_status" name="search_status" required>
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
                                </div>
                                <div class="form-row">
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light"><i class="fas fa-search"></i>&nbsp;&nbsp;Submit</button>
                                        <button type="button" class="btn btn-outline-primary waves-effect" onclick="window.location.href='./?mode=users/list'"><i class="fas fa-redo-alt"></i>&nbsp;&nbsp;Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section search end -->

        <!-- Booking table start -->
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <table class="table" id="datatables-users">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Procedural mysqli
                                    $bind_types = "";
                                    $params = array();

                                    $query = "SELECT * FROM users WHERE id != 1";
                                    if (!empty($search_firstname_val)) {
                                        # search firstname
                                        $param = "%{$search_firstname_val}%";
                                        $query .= " AND firstname LIKE ?";
                                        $bind_types .= "s";
                                        array_push($params, $param);
                                    }
                                    if (!empty($search_lastname_val)) {
                                        # search lastname
                                        $param = "%{$search_lastname_val}%";
                                        $query .= " AND lastname LIKE ?";
                                        $bind_types .= "s";
                                        array_push($params, $param);
                                    }
                                    if (!empty($search_username_val)) {
                                        # search username
                                        $param = "%{$search_username_val}%";
                                        $query .= " AND username LIKE ?";
                                        $bind_types .= "s";
                                        array_push($params, $param);
                                    }
                                    if (!empty($search_status_val)) {
                                        # search status
                                        $query .= " AND offline = ?";
                                        $bind_types .= "i";
                                        array_push($params, $search_status_val);
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
                                        $status_txt = $row["offline"] == 1 ? 'ออฟไลน์' : 'ออนไลน์';
                                        $name = $row["firstname"] . ' ' . $row["lastname"];
                                    ?>
                                        <tr>
                                            <td> <span class="badge badge-pill <?php echo $status_class; ?>"> <?php echo $status_txt; ?> </span> </td>
                                            <td> <?php echo $row["username"]; ?> </td>
                                            <td>
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="avatar bg-light-success mr-1"> <span class="avatar-content"> T1 </span> </div>
                                                    <div class="d-flex flex-column"><span class="emp_name text-truncate font-weight-bold"> <?php echo $name; ?> </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript:;" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                                <a href="javascript:;" class="item-trash"> <i class="far fa-trash-alt"></i> </a>
                                            </td>
                                        </tr>
                                    <?php
                                    } /* while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){ */
                                    ?>
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