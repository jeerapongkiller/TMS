<?php
require("../../../inc/connection.php");

$agent = $_POST['bo_agent'];
$query_aff = "SELECT * FROM company_aff WHERE company = '$agent' AND offline = 2 ";
$query_aff .= " ORDER BY name_aff ASC";
$result_aff = mysqli_query($mysqli_p, $query_aff);
$numrow = mysqli_num_rows($result_aff);

if (!empty($_POST['bo_agent']) && $numrow > 0) { ?>
    <div class="form-group">
        <label for="bo_company_aff"> Company (Affiliated) &nbsp;
            <a href="javascript:;" title="Restore Information (Affiliated)" onclick="checkRestoreAff()"><i class="fas fa-undo"></i></a>
        </label>
        <select class="custom-select" id="bo_company_aff" name="bo_company_aff" onchange="checkValueAff()">
            <option value=""> - </option>
            <?php while ($row_aff = mysqli_fetch_array($result_aff, MYSQLI_ASSOC)) { ?>
                <option value="<?php echo $row_aff["id"]; ?>" <?php echo !empty($_POST['de_company_aff']) && $_POST['de_company_aff'] == $row_aff["id"] ? 'selected' : ''; ?>> <?php echo $row_aff["name_aff"]; ?></option>
            <?php } ?>
        </select>
        <input type="hidden" name="restore_aff" id="restore_aff" value="false">
    </div>
<?php } else { ?>
    <div class="form-group">
        <label for="bo_company_aff"> Company (Affiliated) </label>
        <select class="form-control" name="bo_company_aff" id="bo_company_aff">
            <option value=""> No data </option>
        </select>
    </div>
<?php } ?>