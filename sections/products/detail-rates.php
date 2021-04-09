<?php
if (empty($_GET["periods"])) {
    echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=products/list'\" >";
}
if (!empty($_GET["id"])) {
    $query = "SELECT products_rates.*, products_periods.id as PPID, products_periods.products as PPp, products_periods.periods_from as PPpf, products_periods.periods_to as PPpt,
            products.id as PID, products.products_type as Ppt, products.name as pName
            FROM products_rates 
            LEFT JOIN products_periods 
            ON products_rates.products_periods = products_periods.id
            LEFT JOIN products 
            ON products_periods.products = products.id
            WHERE products_rates.id > '0' AND products_rates.id = ?";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'i', $_GET["id"]);
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    if ($numrow > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $page_title = $row["pName"] . ' (' . $row["PPpf"] . ' - ' . $row["PPpt"] . ')';
    } else {
        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=products/list'\" >";
    }
} else {
    $agent_periods_from = get_value('products_periods', 'id', 'periods_from', $_GET["periods"], $mysqli_p);
    $agent_periods_to = get_value('products_periods', 'id', 'periods_to', $_GET["periods"], $mysqli_p);
    $agent_products = get_value('products_periods', 'id', 'products', $_GET["periods"], $mysqli_p);
    $products_name = get_value('products', 'id', 'name', $agent_products, $mysqli_p);
    $page_title = $products_name . ' (' . $agent_periods_from . ' - ' . $agent_periods_to . ')';
}
# check value
$main = array();
$id = !empty($row["id"]) ? $row["id"] : '0';
$offline = !empty($row["offline"]) ? $row["offline"] : '2';
$company = $_SESSION["admin"]["company"];
$periods = !empty($_GET["periods"]) ? $_GET["periods"] : '';
$type_products = !empty($_GET["type"]) ? $_GET["type"] : '';
$type_rates = !empty($row["type_rates"]) ? $row["type_rates"] : '3';
$periods_from = !empty($row["PPpf"]) ? $row["PPpf"] : $agent_periods_from;
$periods_to = !empty($row["PPpt"]) ? $row["PPpt"] : $agent_periods_to;
$rate_adult = !empty($row["rate_adult"]) ? number_format($row["rate_adult"]) : '0';
$rate_children = !empty($row["rate_children"]) ? number_format($row["rate_children"]) : '0';
$rate_infant = !empty($row["rate_infant"]) ? number_format($row["rate_infant"]) : '0';
$rate_group = !empty($row["rate_group"]) ? number_format($row["rate_group"]) : '0';
$rate_pax = !empty($row["pax"]) ? $row["pax"] : '0';
$rate_transfer = !empty($row["rate_transfer"]) ? number_format($row["rate_transfer"]) : '0';
?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> Rates </h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./?mode=products/list&type=<?php echo $type_products; ?>"> <?php echo $page_title; ?> </a>
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
                                <form action="javascript:;" method="POST" id="frmsearch" name="frmsearch" class="needs-validation" enctype="multipart/form-data" novalidate>
                                    <!-- Hidden input -->
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" id="page_title" name="page_title" value="<?php echo $page_title; ?>">
                                    <input type="hidden" id="company" name="company" value="<?php echo $company; ?>">
                                    <input type="hidden" id="periods" name="periods" value="<?php echo $periods; ?>">
                                    <input type="hidden" id="type_products" name="type_products" value="<?php echo $type_products; ?>">
                                    <input type="hidden" id="type_rates" name="type_rates" value="<?php echo $type_rates; ?>">
                                    <?php
                                    // Check Agents
                                    $query = "SELECT products_rates.*, rates_agent.id as rgID, rates_agent.products_periods as rgPP, rates_agent.products_rates as rgPR, rates_agent.combine_agent as rgCG
                                        FROM products_rates 
                                        LEFT JOIN rates_agent
                                        ON products_rates.id = rates_agent.products_rates
                                        WHERE products_rates.products_periods = '" . $_GET["periods"] . "' AND products_rates.type_rates = 3 ";
                                    $result_rates = mysqli_query($mysqli_p, $query);
                                    while ($row_rates = mysqli_fetch_array($result_rates, MYSQLI_ASSOC)) {
                                        $combine_items = array("products_rates" => $row_rates['rgPR'], "combine_agent" => $row_rates['rgCG']);
                                        array_push($main, $combine_items);
                                    } ?>
                                    <!-- company edit -->
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="offline" class="mb-1">Status</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="offline" name="offline" <?php if ($offline != 2 || !isset($offline)) {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> value="1" <?php echo !empty($row["trash_deleted"]) && ($row["trash_deleted"] == '1') ? 'disabled' : ''; ?> />
                                                    <label class="custom-control-label" for="offline"> Offline </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="periods_from">Periods Date (From)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='calendar'></i></span>
                                                    </div>
                                                    <input type="date" class="form-control" id="periods_from" name="periods_from" value="<?php echo $periods_from; ?>" placeholder="" disabled />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="periods_to">Periods Date (To)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i data-feather='calendar'></i></span>
                                                    </div>
                                                    <input type="date" class="form-control" id="periods_to" name="periods_to" value="<?php echo $periods_to; ?>" placeholder="" disabled />
                                                </div>
                                            </div>
                                        </div> <!-- div -->
                                    </div>

                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="adult">Adult </label>
                                                <input type="text" class="form-control" id="adult" name="adult" value="<?php echo $rate_adult; ?>" placeholder="" oninput="priceformat('adult');" required />
                                                <div class="invalid-feedback">Please enter a Adult.</div>
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="children">Children </label>
                                                <input type="text" class="form-control" id="children" name="children" value="<?php echo $rate_children; ?>" placeholder="" oninput="priceformat('children');" />
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="infant">Infant </label>
                                                <input type="text" class="form-control" id="infant" name="infant" value="<?php echo $rate_infant; ?>" placeholder="" oninput="priceformat('infant');" />
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="group">Group </label>
                                                <input type="text" class="form-control" id="group" name="group" value="<?php echo $rate_group; ?>" placeholder="" oninput="priceformat('group');" />
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="rate_pax">Pax</label>
                                                <input type="text" class="form-control" id="rate_pax" name="rate_pax" value="<?php echo $rate_pax; ?>" placeholder="" oninput="priceformat('rate_pax');" />
                                            </div>
                                        </div> <!-- div -->
                                        <div class="col-xl-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="transfer">Transfer</label>
                                                <input type="text" class="form-control" id="transfer" name="transfer" value="<?php echo $rate_transfer; ?>" placeholder="" oninput="priceformat('transfer');" />
                                            </div>
                                        </div> <!-- div -->
                                    </div>
                                    <?php if ($type_rates == '3') { ?>
                                        <div class="form-row mt-1 mb-1">
                                            <div class="col-12">
                                                <h4 class="mb-1">
                                                    <i data-feather="home" class="font-medium-4 mr-25"></i>
                                                    <span class="align-middle"> Agent </span>
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <?php
                                            $query_agent = "SELECT combine_agent.*, company.id as comID, company.name as comName 
                                                        FROM combine_agent 
                                                        LEFT JOIN company
                                                        ON combine_agent.agent = company.id
                                                        WHERE combine_agent.supplier = '$company' AND combine_agent.offline = 2 ";
                                            if (!empty($main)) {
                                                $combine_agent_check = array();
                                                $num_cg = count($main);
                                                for ($i = 0; $i < $num_cg; $i++) {
                                                    if ($main[$i]["products_rates"] != $id) {
                                                        $query_agent .= " AND combine_agent.id != '" . $main[$i]["combine_agent"] . "' ";
                                                    } else {
                                                        array_push($combine_agent_check, $main[$i]["combine_agent"]);
                                                    }
                                                }
                                            }
                                            $result_agent = mysqli_query($mysqli_p, $query_agent);
                                            while ($row_agent = mysqli_fetch_array($result_agent, MYSQLI_ASSOC)) {
                                                // $checked_agent = in_array($row_agent['id'], $combine_agent_check) ? 'checked'  : ''
                                                if (!empty($combine_agent_check) && (in_array($row_agent['id'], $combine_agent_check))) {
                                                    $checked_agent = 'checked';
                                            ?> <input type="hidden" id="default_agent<?php echo $row_agent['id']; ?>" name="default_agent[]" value="<?php echo $row_agent['id']; ?>"> <?php
                                                                                                                                                                                            } else {
                                                                                                                                                                                                $checked_agent = '';
                                                                                                                                                                                            }
                                                                                                                                                                                                ?> <div class="col-xl-2 col-md-4 col-6">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="agent<?php echo $row_agent['id']; ?>" name="agent[]" value="<?php echo $row_agent['id']; ?>" <?php echo $checked_agent; ?> />
                                                            <label class="custom-control-label" for="agent<?php echo $row_agent['id']; ?>"> <?php echo $row_agent['comName']; ?> </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                    <hr>

                                    <div class="form-row">
                                        <div class="col-xl-3 col-md-6 col-12 mt-1">
                                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-float waves-light" id="btusubmit"><i class="fas fa-search"></i>&nbsp;&nbsp;Submit</button>
                                        </div>
                                    </div>
                                </form>

                                <div id="div-company"></div>

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
                                                        checkFormPeriods();
                                                    }
                                                    form.classList.add('was-validated');
                                                }, false);
                                            });
                                        }, false);
                                    })();

                                    //Check Agent
                                    function checkAgent() {
                                        var id = document.getElementById('id').value
                                        var btusubmit = document.getElementById('btusubmit')
                                        var agent = document.getElementsByName('agent[]')
                                        var a = 0
                                        for (var i = 0; i < agent.length; i++) {
                                            if (agent[i].checked) {
                                                a++
                                            }
                                        }
                                        if (a == agent.length && id == 0) {
                                            btusubmit.disabled = true;
                                            Swal.fire('warning!', 'There are no agent to choose from', 'warning');
                                            return false;
                                        }
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

                                    // checkFormPeriods
                                    function checkFormPeriods() {
                                        var group = document.getElementById('group')
                                        var pax = document.getElementById('rate_pax')
                                        if (group.value != '') {
                                            if (pax.value == '') {
                                                Swal.fire('Error!', 'Error. Please Enter a Pax', 'error');
                                                return false;
                                            }
                                        }
                                        submitFormPeriods();
                                    }

                                    // Submit form company
                                    function submitFormPeriods() {
                                        var id = $('#id').val();
                                        var page_title = $('#page_title').val();
                                        var check_offline = document.getElementById('offline');
                                        if (check_offline.checked) {
                                            var offline = $('#offline').val();
                                        } else {
                                            var offline = '2';
                                        }
                                        var company = $('#company').val();
                                        var periods = $('#periods').val();
                                        var type_products = $('#type_products').val();
                                        var type_rates = $('#type_rates').val();
                                        var adult = $('#adult').val();
                                        var children = $('#children').val();
                                        var infant = $('#infant').val();
                                        var group = $('#group').val();
                                        var pax = $('#rate_pax').val();
                                        var transfer = $('#transfer').val();
                                        var agent_arr = []
                                        var default_agent_arr = []
                                        if (type_rates == '3') {
                                            var agent = document.getElementsByName('agent[]')
                                            for (var i = 0; i < agent.length; i++) {
                                                if (agent[i].checked) {
                                                    agent_arr.push(agent[i].value);
                                                }
                                            }
                                            var default_agent = document.getElementsByName('default_agent[]')
                                            for (var i = 0; i < default_agent.length; i++) {
                                                default_agent_arr.push(default_agent[i].value);
                                            }
                                            if (agent_arr == '') {
                                                Swal.fire('Error!', 'Plase select agent!', 'error');
                                                return false;
                                            }
                                        }
                                        jQuery.ajax({
                                            url: "sections/products/ajax/add-rates.php",
                                            data: {
                                                id: id,
                                                page_title: page_title,
                                                offline: offline,
                                                company: company,
                                                periods: periods,
                                                type_products: type_products,
                                                type_rates: type_rates,
                                                adult: adult,
                                                children: children,
                                                infant: infant,
                                                group: group,
                                                pax: pax,
                                                transfer: transfer,
                                                agent: agent_arr,
                                                default_agent: default_agent_arr
                                            },
                                            type: "POST",
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
                                                        location.href = "./?mode=products/detail-rates&type=" + type_products + "&periods=" + periods + "&id=" + response;
                                                    })
                                                }
                                            },
                                            error: function() {
                                                Swal.fire('Error!', 'Error. Please try again', 'error')
                                            }
                                        });
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Form company end -->
        </div>
    </div>
</div>