<?php
require("../../../inc/connection.php");

if (!empty($_POST['bp_pickup'])) {
    $query_drop = "SELECT * FROM place WHERE id != '" . $_POST['bp_pickup'] . "' ";
    $query_drop .= " ORDER BY name ASC";
    $result_drop = mysqli_query($mysqli_p, $query_drop);
?>
    <label for="bp_dropoff"> Dropoff </label>
    <select class="custom-select" id="bp_dropoff" name="bp_dropoff">
        <option value=""> Please select a Dropoff .. </option>
        <?php while ($row_drop = mysqli_fetch_array($result_drop, MYSQLI_ASSOC)) { ?>
            <option value="<?php echo $row_drop["id"]; ?>" <?php if ($_POST['bp_dropoff'] == $row_drop["id"]) {
                                                                echo "selected";
                                                            } ?>>
                <?php echo $row_drop["name"]; ?></option>
        <?php } ?>
    </select>
<?php }
