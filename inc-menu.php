    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="html/ltr/vertical-menu-template/index.html"><span class="brand-logo">
                            <img src="assets/images/logo/logo.svg" height="24"></span>
                        <h5 class="brand-text text-center">SHAMBHALA<small class="d-block">TRAVEL</small></h5>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

                <li class=" navigation-header"><span data-i18n="all booking">Booking</span><i data-feather="more-horizontal"></i>
                </li>
                <li class="nav-item <?php echo (strstr($_GET["mode"], "booking/")) ? 'active' : ''; ?> ">
                    <a class="d-flex align-items-center" href="./?mode=booking/list"><i data-feather='book-open'></i><span class="menu-title text-truncate" data-i18n="Booking">Booking</span></a>
                </li>

                <li class="navigation-header"><span data-i18n="user">User & Permission</span><i data-feather="more-horizontal"></i>
                </li>
                <li class="nav-item <?php echo (strstr($_GET["mode"], "users/")) ? 'active' : ''; ?> ">
                    <a class="d-flex align-items-center" href="./?mode=users/list"><i data-feather='user'></i><span class="menu-title text-truncate" data-i18n="Users">User</span></a>
                </li>
                <li class="nav-item <?php echo (strstr($_GET["mode"], "permission/")) ? 'active' : ''; ?> ">
                    <a class="d-flex align-items-center" href="./?mode=permission/list"><i data-feather='pocket'></i><span class="menu-title text-truncate" data-i18n="permission">Permission</span></a>
                </li>

                <li class="navigation-header"><span data-i18n="user">Company & Agent</span><i data-feather="more-horizontal"></i>
                <li class="nav-item <?php echo (strstr($_GET["mode"], "company/")) ? 'active' : ''; ?> ">
                    <a class="d-flex align-items-center" href="./?mode=company/list"><i data-feather='home'></i><span class="menu-title text-truncate" data-i18n="Company">Company</span></a>
                </li>

                <li class="navigation-header"><span data-i18n="products">Products</span><i data-feather="more-horizontal"></i>
                <li class=" nav-item"><a class="d-flex align-items-center" href="javascript:;"><i data-feather='package'></i><span class="menu-title text-truncate" data-i18n="Products">Products</span></a>
                    <ul class="menu-content">
                        <?php
                        $menu_ptype = "SELECT * FROM products_type WHERE id > '0'";
                        $menu_ptype .= " ORDER BY id ASC";
                        $result_ptype = mysqli_query($mysqli_p, $menu_ptype);
                        while ($row_ptype = mysqli_fetch_array($result_ptype, MYSQLI_ASSOC)) {
                            switch ($row_ptype['id']) {
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
                            $menu_products = "SELECT * FROM products WHERE id > '0' AND products_type = '" . $row_ptype["id"] . "' AND company = '" . $_SESSION["admin"]["company"] . "' ";
                            // mysqli_stmt_bind_param($procedural_statement, 'ii', $row_ptype["id"], $id);
                            $result_products = mysqli_query($mysqli_p, $menu_products);
                            $num_products = mysqli_num_rows($result_products);
                        ?>
                            <li class="nav-item <?php echo (strstr($_GET["mode"], "products/") && $_GET["type"] == $row_ptype['id']) ? 'active' : ''; ?> ">
                                <a class="d-flex align-items-center" href="./?mode=products/list&type=<?php echo $row_ptype['id']; ?>">
                                    <i class="<?php echo $T_icon; ?>"></i><span class="menu-title text-truncate" data-i18n="<?php echo $T_name; ?>"> <?php echo $T_name; ?> </span><span class="badge badge-light-warning badge-pill ml-auto mr-1"> <?php echo $num_products; ?> </span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>