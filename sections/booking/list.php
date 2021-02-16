<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Booking</h2>
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

                </div>
            </div>
        </div>

        <!-- Basic Inputs start -->
        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Search</h4>
                        </div>
                        <div class="card-body">
                            <form action="#" class="needs-validation" novalidate>
                                <div class="form-row">
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="Name">Name</label>
                                            <input type="text" class="form-control" id="Name" placeholder="Enter Name" required />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="Email">Email</label>
                                            <input type="text" class="form-control" id="Email" placeholder="Enter email" required />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="Date">Date</label>
                                            <input type="text" id="" class="form-control pickadate" placeholder="18 June, 2020" />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="basicInput">Salary</label>
                                            <input type="text" class="form-control" id="Salary" placeholder="Enter salary" required />
                                        </div>
                                    </div> <!-- div -->
                                    <div class="col-xl-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="basicInput">Status</label>
                                            <select class="form-control" id="Status" required >
                                                <option>IT</option>
                                                <option>Blade Runner</option>
                                                <option>Thor Ragnarok</option>
                                            </select>
                                        </div>
                                    </div> <!-- div -->
                                </div>
                                <div class="form-row">
                                    <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light">Submit</button>
                                    <button type="reset" class="btn btn-outline-primary waves-effect">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Basic Inputs end -->

        <div class="content-body">
            <!-- Basic table -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <table class="table" id="datatables-basic">
                                <thead>
                                    <tr>
                                        <th class="dt-checkboxes-cell dt-checkboxes-select-all sorting_disabled" rowspan="1" colspan="1" style="width: 18px;" data-col="1" aria-label>
                                            <div class="custom-control custom-checkbox"> <input class="custom-control-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="custom-control-label" for="checkboxSelectAll"></label></div>
                                        </th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Date</th>
                                        <th>Salary</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="dt-checkboxes-cell">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input dt-checkboxes" type="checkbox" value="" id="checkbox1" />
                                                <label class="custom-control-label" for="checkbox1"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar bg-light-success mr-1"> <span class="avatar-content"> T1 </span> </div>
                                                <div class="d-flex flex-column"><span class="emp_name text-truncate font-weight-bold"> Test 1 </span>
                                                    <small class="emp_post text-truncate text-muted">Remark Test 1 </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>email_1@gmail.com</td>
                                        <td>01/02/2020</td>
                                        <td>฿1,000</td>
                                        <td>
                                            <span class="badge badge-pill badge-light-primary"> Current </span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                            <a href="javascript:;" class="item-trash"> <i class="far fa-trash-alt"></i> </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input dt-checkboxes" type="checkbox" value="" id="checkbox2" />
                                                <label class="custom-control-label" for="checkbox2"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar bg-light-danger mr-1"> <span class="avatar-content"> T2 </span> </div>
                                                <div class="d-flex flex-column"><span class="emp_name text-truncate font-weight-bold"> Test 2 </span>
                                                    <small class="emp_post text-truncate text-muted">Remark Test 2 </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>email_2@gmail.com</td>
                                        <td>02/02/2020</td>
                                        <td>฿2,000</td>
                                        <td>
                                            <span class="badge badge-pill badge-light-success"> Professional </span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                            <a href="javascript:;" class="item-trash"> <i class="far fa-trash-alt"></i> </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input dt-checkboxes" type="checkbox" value="" id="checkbox3" />
                                                <label class="custom-control-label" for="checkbox3"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar bg-light-warning mr-1"> <span class="avatar-content"> T3 </span> </div>
                                                <div class="d-flex flex-column"><span class="emp_name text-truncate font-weight-bold"> Test 3 </span>
                                                    <small class="emp_post text-truncate text-muted">Remark Test 3 </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>email_3@gmail.com</td>
                                        <td>03/02/2020</td>
                                        <td>฿3,000</td>
                                        <td>
                                            <span class="badge badge-pill badge-light-danger"> Rejected </span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                            <a href="javascript:;" class="item-trash"> <i class="far fa-trash-alt"></i> </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input dt-checkboxes" type="checkbox" value="" id="checkbox4" />
                                                <label class="custom-control-label" for="checkbox4"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar bg-light-info mr-1"> <span class="avatar-content"> T4 </span> </div>
                                                <div class="d-flex flex-column"><span class="emp_name text-truncate font-weight-bold"> Test 4 </span>
                                                    <small class="emp_post text-truncate text-muted">Remark Test 4 </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>email_4@gmail.com</td>
                                        <td>04/02/2020</td>
                                        <td>฿4,000</td>
                                        <td>
                                            <span class="badge badge-pill badge-light-warning"> Resigned </span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                            <a href="javascript:;" class="item-trash"> <i class="far fa-trash-alt"></i> </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input dt-checkboxes" type="checkbox" value="" id="checkbox5" />
                                                <label class="custom-control-label" for="checkbox5"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar bg-light-dark mr-1"> <span class="avatar-content"> T5 </span> </div>
                                                <div class="d-flex flex-column"><span class="emp_name text-truncate font-weight-bold"> Test 5 </span>
                                                    <small class="emp_post text-truncate text-muted">Remark Test 5 </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>email_5@gmail.com</td>
                                        <td>05/02/2020</td>
                                        <td>฿5,000</td>
                                        <td>
                                            <span class="badge badge-pill badge-light-info"> Applied </span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                            <a href="javascript:;" class="item-trash"> <i class="far fa-trash-alt"></i> </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input dt-checkboxes" type="checkbox" value="" id="checkbox6" />
                                                <label class="custom-control-label" for="checkbox6"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar bg-light-primary mr-1"> <span class="avatar-content"> T6 </span> </div>
                                                <div class="d-flex flex-column"><span class="emp_name text-truncate font-weight-bold"> Test 6 </span>
                                                    <small class="emp_post text-truncate text-muted">Remark Test 6 </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>email_6@gmail.com</td>
                                        <td>06/02/2020</td>
                                        <td>฿6,000</td>
                                        <td>
                                            <span class="badge badge-pill badge-light-info"> Applied </span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                            <a href="javascript:;" class="item-trash"> <i class="far fa-trash-alt"></i> </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input dt-checkboxes" type="checkbox" value="" id="checkbox7" />
                                                <label class="custom-control-label" for="checkbox7"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar bg-light-secondary mr-1"> <span class="avatar-content"> T7 </span> </div>
                                                <div class="d-flex flex-column"><span class="emp_name text-truncate font-weight-bold"> Test 7 </span>
                                                    <small class="emp_post text-truncate text-muted">Remark Test 7 </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>email_7@gmail.com</td>
                                        <td>07/02/2020</td>
                                        <td>฿7,000</td>
                                        <td>
                                            <span class="badge badge-pill badge-light-info"> Applied </span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                            <a href="javascript:;" class="item-trash"> <i class="far fa-trash-alt"></i> </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input dt-checkboxes" type="checkbox" value="" id="checkbox8" />
                                                <label class="custom-control-label" for="checkbox8"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar bg-light-success mr-1"> <span class="avatar-content"> T8 </span> </div>
                                                <div class="d-flex flex-column"><span class="emp_name text-truncate font-weight-bold"> Test 8 </span>
                                                    <small class="emp_post text-truncate text-muted">Remark Test 8 </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>email_8@gmail.com</td>
                                        <td>08/02/2020</td>
                                        <td>฿8,000</td>
                                        <td>
                                            <span class="badge badge-pill badge-light-info"> Applied </span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                            <a href="javascript:;" class="item-trash"> <i class="far fa-trash-alt"></i> </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input dt-checkboxes" type="checkbox" value="" id="checkbox9" />
                                                <label class="custom-control-label" for="checkbox9"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-left align-items-center">
                                                <div class="avatar bg-light-danger mr-1"> <span class="avatar-content"> T9 </span> </div>
                                                <div class="d-flex flex-column"><span class="emp_name text-truncate font-weight-bold"> Test 9 </span>
                                                    <small class="emp_post text-truncate text-muted">Remark Test 9 </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>email_9@gmail.com</td>
                                        <td>09/02/2020</td>
                                        <td>฿9,000</td>
                                        <td>
                                            <span class="badge badge-pill badge-light-primary"> Applied </span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="pr-1 item-edit"> <i class="far fa-edit"></i> </a>
                                            <a href="javascript:;" class="item-trash"> <i class="far fa-trash-alt"></i> </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ Basic table -->

        </div>
    </div>
</div>