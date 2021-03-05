<?php
if (!empty($_GET["id"])) {
    $query = "SELECT * FROM company WHERE id > '0' AND id = ?";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'i', $_GET["id"]);
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    if ($numrow > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $page_title = stripslashes($row["name"]);
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=company/list'\" >";
    }
} else {
    $page_title = "Add New Company";
}
# check value
$id = !empty($row["id"]) ? $row["id"] : '0';
$offline = !empty($row["offline"]) ? $row["offline"] : '2';
$name = !empty($row["name"]) ? $row["name"] : '';
$name_invoice = !empty($row["name_invoice"]) ? $row["name_invoice"] : '';
$address = !empty($row["address"]) ? $row["address"] : '';
$phone = !empty($row["phone"]) ? $row["phone"] : '';
$fax = !empty($row["fax"]) ? $row["fax"] : '';
$email = !empty($row["email"]) ? $row["email"] : '';
$website = !empty($row["website"]) ? $row["website"] : '';
$contact_person = !empty($row["contact_person"]) ? $row["contact_person"] : '';
$contact_position = !empty($row["contact_position"]) ? $row["contact_position"] : '';
$contact_phone = !empty($row["contact_phone"]) ? $row["contact_phone"] : '';
$contact_email = !empty($row["contact_email"]) ? $row["contact_email"] : '';
# photo
$photo = !empty($row["photo"]) ? $row["photo"] : '';
$pathphoto = !empty($photo) ? 'inc/photo/company/' . $photo : 'inc/photo/no-image.jpg';
?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Company</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?mode=company/list"> Home </a>
                                </li>
                                <li class="breadcrumb-item active"> <?php echo $page_title; ?>
                                </li>
                                <!-- <li class="breadcrumb-item active">Home
                                </li> -->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrumb-right">

                </div>
            </div>
        </div>

        <!-- Plan Card starts-->
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-6">
                <div class="card plan-card border-info">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4> <i class="fas fa-map font-size-20"></i> Tours </h4>
                        <h4> 0 </h4>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-info text-center btn-block" onclick="productView('1')"> Products </button>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-6">
                <div class="card plan-card border-success">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4> <i class="fas fa-life-ring font-size-20"></i> Acticity </h4>
                        <h4> 0 </h4>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-success text-center btn-block" onclick="productView('2')"> Products </button>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-6">
                <div class="card plan-card border-warning">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4> <i class="fas fa-car font-size-20"></i> Transfer </h4>
                        <h4> 0 </h4>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-warning text-center btn-block" onclick="productView('3')"> Products </button>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-6">
                <div class="card plan-card border-secondary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4> <i class="fas fa-hotel font-size-20"></i> Hotel </h4>
                        <h4> 0 </h4>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-secondary text-center btn-block" onclick="productView('4')"> Products </button>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-6">
                <div class="card plan-card border-danger">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4> <i class="fas fa-ticket-alt font-size-20"></i> Ticket </h4>
                        <h4> 0 </h4>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-danger text-center btn-block" onclick="productView('5')"> Products </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Plan CardEnds -->

        <!-- Div Products starts-->
        <div id="div-products"> </div>
        <!-- /Plan Products Ends -->

        <!-- Basic Modals start -->
        <div class="modal fade nodal-lg" id="addperiods" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle"> Add Periods <span id="periods_name"></span> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="periods-from">Periods Date (From)</label>
                                    <input type="date" class="form-control" id="periods-from" name="periods-from" value="" placeholder="" />
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="periods-to">Periods Date (To)</label>
                                    <input type="date" class="form-control" id="periods-to" name="periods-to" value="" placeholder="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="model-products" id="model-products" value="" />
                        <input type="hidden" name="model-type" id="model-type" value="" />
                        <button type="button" id="submit-periods" data-dismiss="modal" onclick="addPeriods()"> Submit </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Modals end -->

        <!-- Form company start -->
        <div class="content-body">
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <!-- <div class="card-header">
                                <h4 class="card-title">Search</h4>
                            </div> -->
                            <div class="card-body">
                                <form action="javascript:;" method="POST" id="frmcompany" name="frmcompany" class="needs-validation" enctype="multipart/form-data" novalidate>
                                    <!-- Hidden input -->
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" id="page_title" name="page_title" value="<?php echo $page_title; ?>">
                                    <!-- company photo -->
                                    <div class="media mb-2">
                                        <img src="<?php echo $pathphoto; ?>" alt="company" class="photo company-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                                        <div class="media-body mt-50">
                                            <h4> <?php echo $page_title; ?> </h4>
                                            <div class="col-12 d-flex mt-1 px-0">
                                                <label class="btn btn-primary mr-75 mb-0" for="photo">
                                                    <span class="d-none d-sm-block">Change</span>
                                                    <input class="form-control" type="file" id="photo" name="photo" value="<?php echo $photo; ?>" hidden value="" accept="image/png, image/jpeg, image/jpg" />
                                                    <input type="hidden" name="tmp_photo" id="tmp_photo" value="<?php echo $photo; ?>">
                                                    <input type="hidden" name="del_photo" id="del_photo" value="">
                                                    <span class="d-block d-sm-none">
                                                        <i class="mr-0" data-feather="edit"></i>
                                                    </span>
                                                </label>
                                                <button class="btn btn-outline-secondary d-none d-sm-block" id="remove_photo" type="button">Remove</button>
                                                <button class="btn btn-outline-secondary d-block d-sm-none">
                                                    <i class="mr-0" data-feather="trash-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- company information -->
                                    <div class="form-row mt-3">
                                        <div class="col-12">
                                            <h4 class="mb-1">
                                                <i data-feather="home" class="font-medium-4 mr-25"></i>
                                                <span class="align-middle">Company Information</span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="offline" class="mb-1">Status</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="offline" name="offline" <?php if ($offline != 2 || !isset($offline)) {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> value="1" <?php echo $row["trash_deleted"] == '1' ? 'disabled' : ''; ?> />
                                                    <label class="custom-control-label" for="offline"> Offline </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name"> Name </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="home"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" placeholder="" required />
                                                    <div class="invalid-feedback">Please enter a Name.</div>
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name_invoice"> Name Invoice </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="home"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="name_invoice" name="name_invoice" value="<?php echo $name_invoice; ?>" placeholder="" />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="phone"> Phone </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='smartphone'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" placeholder="" />
                                                    <!-- <div class="invalid-feedback">Please enter a phone.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="fax"> Fax </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='printer'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="fax" name="fax" value="<?php echo $fax; ?>" placeholder="" />
                                                    <!-- <div class="invalid-feedback">Please enter a fax.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="email"> Email </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='mail'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>" placeholder="" />
                                                    <!-- <div class="invalid-feedback">Please enter a fax.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="website"> Website </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='globe'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="website" name="website" value="<?php echo $website; ?>" placeholder="" />
                                                    <!-- <div class="invalid-feedback">Please enter a fax.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="address"> Address </label>
                                                <textarea class="form-control" name="address" id="address" cols="30" rows="2"><?php echo $address; ?></textarea>
                                            </div>
                                        </div> <!-- div -->
                                    </div>

                                    <!-- contact company -->
                                    <div class="form-row">
                                        <div class="col-12">
                                            <h4 class="mb-1">
                                                <i data-feather="user" class="font-medium-4 mr-25"></i>
                                                <span class="align-middle">Contact Company</span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="contact_person"> Contact Person </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="contact_person" name="contact_person" value="<?php echo $contact_person; ?>" placeholder="" />
                                                    <!-- <div class="invalid-feedback">Please enter a name.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="contact_position"> Contact Position </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='archive'></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="contact_position" name="contact_position" value="<?php echo $contact_position; ?>" placeholder="" />
                                                    <!-- <div class="invalid-feedback">Please enter a name invoice.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="contact_phone"> Contact Phone </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="smartphone"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?php echo $contact_phone; ?>" placeholder="" />
                                                    <!-- <div class="invalid-feedback">Please enter a phone.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="contact_email"> Email </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather="mail"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="contact_email" name="contact_email" value="<?php echo $contact_email; ?>" placeholder="" />
                                                    <!-- <div class="invalid-feedback">Please enter a fax.</div> -->
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                    </div>

                                    <hr>

                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12 mt-1">
                                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light"><i class="fas fa-search"></i>&nbsp;&nbsp;Submit</button>
                                        </div>
                                    </div>
                                </form>

                                <div id="div-company"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Form company end -->

        <!-- Agent table start -->
        <?php if (!empty($id) && $offline != '1') { ?>
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0"> Agent </h2>
                            <!-- <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Datatable</a>
                                    </li>
                                    <li class="breadcrumb-item active">Home
                                    </li>
                                </ol>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <div class="dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1">
                            <div class="dt-buttons btn-group flex-wrap">
                                <a href="javascript:;" class="btn add-new btn-primary" onclick="addAgent(<?php echo $id; ?>)"><span><i class="fas fa-plus"></i>&nbsp;&nbsp;Add Agent</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table head options start -->
            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive" id="div-agent">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Status</th>
                                        <th>Agent</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $companyURL = '';
                                    $query_agent = "SELECT combine_agent.*, company.id as comID, company.name as comName, company.name_invoice as comName_invoice, company.photo as comPhoto 
                                                        FROM combine_agent 
                                                        LEFT JOIN company
                                                        ON combine_agent.agent = company.id
                                                        WHERE combine_agent.supplier = '$id'  ";
                                    $result_agent = mysqli_query($mysqli_p, $query_agent);
                                    while ($row_agent = mysqli_fetch_array($result_agent, MYSQLI_ASSOC)) {
                                        $status_class = $row_agent["offline"] == 1 ? 'badge-light-danger' : 'badge-light-success';
                                        $status_txt = $row_agent["offline"] == 1 ? 'Offline' : 'Online';
                                        $pathphoto = !empty($row_agent["comPhoto"]) ? 'inc/photo/company/' . $row_agent["comPhoto"] : 'inc/photo/no-image.jpg';
                                        $companyURL .= ' AND id != ' . $row_agent["agent"];
                                    ?>
                                        <tr>
                                            <td> <span class="badge badge-pill <?php echo $status_class; ?>"> <?php echo $status_txt; ?> </span> </td>
                                            <td>
                                                <div class="d-flex justify-content-left align-items-center">
                                                    <div class="avatar pull-up my-0 mr-1">
                                                        <img src="<?php echo $pathphoto; ?>" alt="Avatar" height="30" width="30" />
                                                    </div>
                                                    <div class="d-flex flex-column"><span class="emp_name text-truncate font-weight-bold"> <?php echo $row_agent["comName"]; ?> </span>
                                                        <small class="emp_post text-truncate text-muted"> <b> invoice : </b> <?php echo $row_agent["comName_invoice"]; ?> </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($row_agent["trash_deleted"] == 1) { ?>
                                                    <?php if ($_SESSION["admin"]["permission"] == 1) { ?>
                                                        <a href="javascript:;" class="item-undo" onclick="restoreList(<?php echo $row_agent['id']; ?>)"> <i class="fas fa-undo"></i> </a>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <a href="javascript:;" class="item-trash" onclick="deleteList(<?php echo $row_agent['id']; ?>)"> <i class="far fa-trash-alt"></i> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table head options end -->
            <?php
            $query_company = "SELECT * FROM company WHERE id != '$id'  ";
            $query_company .= $companyURL;
            $query_company .= " AND offline = '2' ";
            $result_company = mysqli_query($mysqli_p, $query_company);
            while ($row_company = mysqli_fetch_array($result_company, MYSQLI_ASSOC)) {
                $data[$row_company['id']] = $row_company['name'];
            } ?>
        <?php } ?>
        <!-- Agent table end -->
    </div>
</div>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        submitFormUser();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    <?php if (!empty($id) && $offline != '1') { ?>

        function addAgent(id) {
            Swal.fire({
                title: 'Add Agent',
                input: 'select',
                inputOptions: <?php echo json_encode($data); ?>,
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
                        url: "sections/company/ajax/add_agent.php",
                        data: {
                            supplier: id,
                            agent: result.value
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
    <?php } ?>

    // Delete Agent
    function deleteList(id) {
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
                    url: "sections/company/ajax/deletelist-agent.php",
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

    // Restore Agent
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
                    url: "sections/company/ajax/restorelist-agent.php",
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

    // Submit form company
    function submitFormUser() {
        var id = $('#id').val();
        var page_title = $('#page_title').val();
        var check_offline = document.getElementById('offline');
        if (check_offline.checked) {
            var offline = $('#offline').val();
        } else {
            var offline = '';
        }
        var name = $('#name').val();
        var name_invoice = $('#name_invoice').val();
        var address = $('#address').val();
        var phone = $('#phone').val();
        var fax = $('#fax').val();
        var email = $('#email').val();
        var website = $('#website').val();
        var contact_person = $('#contact_person').val();
        var contact_position = $('#contact_position').val();
        var contact_phone = $('#contact_phone').val();
        var contact_email = $('#contact_email').val();
        var tmp_photo = $('#tmp_photo').val();
        var del_photo = $('#del_photo').val();

        var fd = new FormData();
        var photo = $('#photo')[0].files[0];
        fd.append('id', id);
        fd.append('page_title', page_title);
        fd.append('offline', offline);
        fd.append('name', name);
        fd.append('name_invoice', name_invoice);
        fd.append('address', address);
        fd.append('phone', phone);
        fd.append('fax', fax);
        fd.append('email', email);
        fd.append('website', website);
        fd.append('contact_person', contact_person);
        fd.append('contact_position', contact_position);
        fd.append('contact_phone', contact_phone);
        fd.append('contact_email', contact_email);

        fd.append('tmp_photo', tmp_photo);
        fd.append('del_photo', del_photo);
        fd.append('photo', photo);

        $.ajax({
            type: "POST",
            url: "sections/company/ajax/save.php",
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: fd,
            success: function(response) {
                // $("#div-company").html(response);
                if (response == 'false') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error. Please try again!',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Complete!',
                        showConfirmButton: false,
                        timer: 3600
                    }).then((result) => {
                        if (response == 'true') {
                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                        } else {
                            location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>" + response;
                        }
                    })
                }
            },
            error: function() {
                Swal.fire('Error!', 'Error. Please try again', 'error')
            }
        });
    }

    // List Products
    function productView(type) {
        jQuery.ajax({
            url: "sections/company/ajax/list-products.php",
            data: {
                company: $('#id').val(),
                type: type
            },
            type: "POST",
            success: function(response) {
                $("#div-products").html(response);
            },
            error: function() {
                Swal.fire('Error this information failed!', 'Please try again', 'error')
            }
        });
    }

    // Add Products
    function addProducts(type) {
        switch (type) {
            case 1:
                var T_name = 'Add Tour'
                var color = 'info'
                break;
            case 2:
                var T_name = 'Add Activity'
                var color = 'success'
                break;
            case 3:
                var T_name = 'Add Transfer'
                var color = 'warning'
                break;
            case 4:
                var T_name = 'Add Hotel'
                var color = 'secondary'
                break;
            case 5:
                var T_name = 'Add Ticket'
                var color = 'danger'
                break;
        }
        Swal.fire({
            title: T_name,
            input: 'text',
            customClass: {
                confirmButton: 'btn btn-' + color,
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
                    url: "sections/company/ajax/add-products.php",
                    data: {
                        company: $('#id').val(),
                        type: type,
                        name: result.value
                    },
                    type: "POST",
                    success: function(response) {
                        Swal.fire({
                            title: "Successfuly!",
                            icon: "success"
                        }).then(function() {
                            // $("#div-agent").html(response);
                            // location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                        });
                    },
                    error: function() {
                        Swal.fire('บันทึกข้อมูลไม่สำเร็จ!', 'กรุณาลองใหม่อีกครั้ง', 'error')
                    }
                });
            }
        })
    }

    // Fun Color
    function colorType(type) {
        switch (type) {
            case 1:
                var color = 'info'
                return 'info';
                break;
            case 2:
                var color = 'success'
                return 'success';
                break;
            case 3:
                var color = 'warning'
                return 'warning';
                break;
            case 4:
                var color = 'secondary'
                return 'secondary';
                break;
            case 5:
                var color = 'danger'
                return 'danger';
                break;
        }
    }

    // From Periods
    function fromPeriods(products, type) {
        var button = document.getElementById('submit-periods');
        var model_products = document.getElementById('model-products');
        var model_type = document.getElementById('model-type');
        button.className = 'btn btn-' + colorType(type);
        model_products.value = products;
        model_type.value = type;
    }

    // Add Periods
    function addPeriods() {
        var model_products = document.getElementById('model-products');
        var model_type = document.getElementById('model-type');
        var periods_from = document.getElementById('periods-from');
        var periods_to = document.getElementById('periods-to');
        jQuery.ajax({
            url: "sections/company/ajax/add-periods.php",
            data: {
                products: model_products.value,
                type: model_type.value,
                periods_from: periods_from.value,
                periods_to: periods_to.value
            },
            type: "POST",
            success: function(response) {
                // Swal.fire({
                //     title: "Successfuly!",
                //     icon: "success"
                // }).then(function() {
                //     // $("#div-agent").html(response);
                //     // location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                // });
            },
            error: function() {
                Swal.fire('บันทึกข้อมูลไม่สำเร็จ!', 'กรุณาลองใหม่อีกครั้ง', 'error')
            }
        });
    }

    // Add Rates
    function addRates(id, type) {
        var type_rates = document.getElementById('type_rates' + id);
        var rate_adult = document.getElementById('rate_adult' + id);
        var rate_children = document.getElementById('rate_children' + id);
        var rate_infant = document.getElementById('rate_infant' + id);
        var rate_group = document.getElementById('rate_group' + id);
        var pax = document.getElementById('pax_rates' + id);
        swal.fire({
            title: 'Edit Rates',
            width: 600,
            html: '<div class="form-row">' +
                '<input type="hidden" class="form-control" id="type_rates' + id + '" name="type_rates" value="' + type_rates.value + '" placeholder="" />' +
                '<div class="col-xl-6 col-md-6 col-12">' +
                '<div class="form-group">' +
                '<label for="rates_adult"> <b> Adult </b> </label>' +
                '<input type="text" class="form-control" id="rates_adult' + id + '" name="rates_adult" value="' + rate_adult.value + '" placeholder="" oninput="priceformat(`rates_adult' + id + '`);" />' +
                '</div>' +
                '</div>' +
                '<div class="col-xl-6 col-md-6 col-12">' +
                '<div class="form-group">' +
                '<label for="rates_children"> <b> Children </b> </label>' +
                '<input type="text" class="form-control" id="rates_children' + id + '" name="rates_children" value="' + rate_children.value + '" placeholder="" oninput="priceformat(`rates_children' + id + '`);" />' +
                '</div>' +
                '</div> ' +
                '<div class="col-xl-6 col-md-6 col-12">' +
                '<div class="form-group">' +
                '<label for="rates_infant"> <b> Infant </b> </label>' +
                '<input type="text" class="form-control" id="rates_infant' + id + '" name="rates_infant" value="' + rate_infant.value + '" placeholder="" oninput="priceformat(`rates_infant' + id + '`);" />' +
                '</div>' +
                '</div> ' +
                '<div class="col-xl-6 col-md-6 col-12">' +
                '<div class="form-group">' +
                '<label for="rates_group"> <b> Group </b> </label>' +
                '<input type="text" class="form-control" id="rates_group' + id + '" name="rates_group" value="' + rate_group.value + '" placeholder="" oninput="priceformat(`rates_group' + id + '`);" />' +
                '</div>' +
                '</div>' +
                '<div class="col-xl-12 col-md-12 col-12">' +
                '<div class="form-group">' +
                '<label for="pax"> <b> Pax </b> </label>' +
                '<input type="text" class="form-control" id="pax' + id + '" name="pax" value="' + pax.value + '" placeholder="" oninput="priceformat(`pax' + id + '`);" />' +
                '</div>' +
                '</div>' +
                '</div>',
            confirmButtonText: 'Confirm',
            // showConfirmButton: false,
            // showCancelButton: false,
            showCloseButton: true,
            preConfirm: function() {
                return new Promise((resolve, reject) => {
                    // get your inputs using their placeholder or maybe add IDs to them
                    resolve({
                        id: id,
                        type_rates: $('#type_rates' + id).val(),
                        rates_adult: $('#rates_adult' + id).val(),
                        rates_children: $('#rates_children' + id).val(),
                        rates_infant: $('#rates_infant' + id).val(),
                        rates_group: $('#rates_group' + id).val(),
                        pax: $('#pax' + id).val()
                    });
                    // maybe also reject() on some condition
                });
            }
        }).then((result) => {
            // console.log(result.value['id']);
            jQuery.ajax({
                url: "sections/company/ajax/add-rates.php",
                data: {
                    id: result.value['id'],
                    type_rates: result.value['type_rates'],
                    rates_adult: result.value['rates_adult'],
                    rates_children: result.value['rates_children'],
                    rates_infant: result.value['rates_infant'],
                    rates_group: result.value['rates_group'],
                    pax: result.value['pax']
                },
                type: "POST",
                success: function(response) {
                    Swal.fire({
                        title: "Successfuly!",
                        icon: "success"
                    }).then(function() {
                        productView(type)
                        // $("#div-agent").html(response);
                    });
                },
                error: function() {
                    Swal.fire('Error!', 'Error. Please try again', 'error')
                }
            });
        });
    }

    // Add Rates Agent
    function addRatesAgent(periods, type) {
        var supplier = document.getElementById('id')
        jQuery.ajax({
            url: "sections/company/ajax/html-rates-agent.php",
            data: {
                supplier: supplier.value,
                type: type,
                periods: periods
            },
            type: "POST",
            success: function(response) {
                swal.fire({
                    title: 'Add Rates (Agent)',
                    width: 600,
                    html: response,
                    confirmButtonText: 'Confirm',
                    showCloseButton: true,
                    preConfirm: function() {
                        return new Promise((resolve, reject) => {
                            resolve({
                                periods: periods
                            });
                        });
                    }
                }).then((result) => {
                    // console.log(result.value['agent_pax']);
                    if (result.value['periods']) {
                        var agent_arr = []
                        var agent = document.getElementsByName('agent[]')
                        for (var i = 0; i < agent.length; i++) {
                            if (agent[i].checked) {
                                agent_arr.push(agent[i].value);
                            }
                        }
                        if (agent_arr == '') {
                            Swal.fire('Error!', 'Error. Please try again', 'error');
                            return false;
                        }
                        jQuery.ajax({
                            url: "sections/company/ajax/add-agent-rates.php",
                            data: {
                                periods: result.value['periods'],
                                type_rates_agent: $('#type_rates_agent').val(),
                                agent_rates_adult: $('#agent_rates_adult').val(),
                                agent_rates_children: $('#agent_rates_children').val(),
                                agent_rates_infant: $('#agent_rates_infant').val(),
                                agent_rates_group: $('#agent_rates_group').val(),
                                agent_pax: $('#agent_pax').val(),
                                agent: agent_arr
                            },
                            type: "POST",
                            success: function(response) {
                                Swal.fire({
                                    title: "Successfuly!",
                                    icon: "success"
                                }).then(function() {
                                    // productView(type)
                                    // $("#div-agent").html(response);
                                    location.href = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                                });
                            },
                            error: function() {
                                Swal.fire('Error!', 'Error. Please try again', 'error')
                            }
                        });
                    }
                });
            }
        });
    }

    // Add rate (agent) & edit rate
    function cuRates(periods, id, type, type_rates) {
        jQuery.ajax({
            url: "sections/company/ajax/html-rates.php",
            data: {
                periods: periods,
                id: id,
                type: type,
                type_rates: type_rates
            },
            type: "POST",
            success: function(response) {
                swal.fire({
                    title: 'Edit Rates',
                    width: 600,
                    html: response,
                    confirmButtonText: 'Confirm',
                    showCloseButton: true,
                    preConfirm: function() {
                        return new Promise((resolve, reject) => {
                            resolve({
                                id: id
                            });
                        });
                    }
                }).then((result) => {
                    exit();
                    // console.log(result.value['id']);
                    jQuery.ajax({
                        url: "sections/company/ajax/add-rates.php",
                        data: {
                            id: result.value['id']
                        },
                        type: "POST",
                        success: function(response) {
                            Swal.fire({
                                title: "Successfuly!",
                                icon: "success"
                            }).then(function() {
                                productView(type)
                                // $("#div-agent").html(response);
                            });
                        },
                        error: function() {
                            Swal.fire('Error!', 'Error. Please try again', 'error')
                        }
                    });
                });
            }
        });
    }

    // Fun Price Format
    function priceformat(inputfield) {
        var i = 0,
            num = 0;
        var j = document.getElementById(inputfield).value;
        while (i < j.length) {
            if (j[i] != ',') {
                num += j[i];
            }
            i++;
        }
        var d = new Number(parseInt(num));
        var n = d.toLocaleString();
        if (n == 0) {
            document.getElementById(inputfield).value = '';
        } else {
            document.getElementById(inputfield).value = n;
        }
    }
</script>