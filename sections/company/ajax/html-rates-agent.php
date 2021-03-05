<?php
require("../../../inc/connection.php");
// echo $_POST['periods'] . ' + ' . $_POST['type'];

$combine_agent_arr = array();
$query_rates = "SELECT products_rates.*, rates_agent.id as rgID, rates_agent.products_periods as rgPP, rates_agent.products_rates as rgPR, rates_agent.combine_agent as rgCG
                FROM products_rates 
                LEFT JOIN rates_agent
                ON products_rates.id = rates_agent.products_rates
                WHERE products_rates.products_periods = '" . $_POST['periods'] . "' AND products_rates.type_rates = 3 ";
$result_rates = mysqli_query($mysqli_p, $query_rates);
while($row_rates = mysqli_fetch_array($result_rates, MYSQLI_ASSOC)){
    array_push($combine_agent_arr, $row_rates['rgCG']);
}
?>

<div class="form-row">
    <input type="hidden" class="form-control" id="type_rates_agent" name="type_rates_agent" value="3" placeholder="" />
    <div class="col-xl-3 col-md-6 col-12">
        <div class="form-group">
            <label for="agent_rates_adult"> <b> Adult </b> </label>
            <input type="text" class="form-control" id="agent_rates_adult" name="agent_rates_adult" value="" placeholder="" oninput="priceformat(`agent_rates_adult`);" />
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
        <div class="form-group">
            <label for="agent_rates_children"> <b> Children </b> </label>
            <input type="text" class="form-control" id="agent_rates_children" name="agent_rates_children" value="" placeholder="" oninput="priceformat(`agent_rates_children`);" />
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
        <div class="form-group">
            <label for="agent_rates_infant"> <b> Infant </b> </label>
            <input type="text" class="form-control" id="agent_rates_infant" name="agent_rates_infant" value="" placeholder="" oninput="priceformat(`agent_rates_infant`);" />
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12">
        <div class="form-group">
            <label for="agent_rates_group"> <b> Group </b> </label>
            <input type="text" class="form-control" id="agent_rates_group" name="agent_rates_group" value="" placeholder="" oninput="priceformat(`agent_rates_group`);" />
        </div>
    </div>
    <div class="col-xl-3 col-md-12 col-12">
        <div class="form-group">
            <label for="agent_pax"> <b> Pax </b> </label>
            <input type="text" class="form-control" id="agent_pax" name="agent_pax" value="" placeholder="" oninput="priceformat(`agent_pax`);" />
        </div>
    </div>
</div>
<div class="form-row">
    <?php
    $query_agent = "SELECT combine_agent.*, company.id as comID, company.name as comName 
                                FROM combine_agent 
                                LEFT JOIN company
                                ON combine_agent.agent = company.id
                                WHERE combine_agent.supplier = '" . $_POST['supplier'] . "' AND combine_agent.offline = 2 ";
    $result_agent = mysqli_query($mysqli_p, $query_agent);
    while ($row_agent = mysqli_fetch_array($result_agent, MYSQLI_ASSOC)) {
    ?> <div class="col-xl-2 col-md-4 col-6">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="agent<?php echo $row_agent['id']; ?>" name="agent[]" value="<?php echo $row_agent['id']; ?>" 
                        <?php echo in_array($row_agent['id'], $combine_agent_arr) ? 'disabled' : '' ; ?> required />
                        <label class="custom-control-label" for="agent<?php echo $row_agent['id']; ?>"> <?php echo $row_agent['comName']; ?> </label>
                    </div>
                </div>
            </div>
    <?php } ?>
</div>