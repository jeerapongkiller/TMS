<?php
require("../../../inc/connection.php");

if (!empty($_POST['bo_com_aff'])) {
    $data_aff = array();
    $id = $_POST['id'];
    $affiliated = $_POST['bo_com_aff'];
    $de_affiliated = $_POST['de_company_aff'];
    $restore_aff = $_POST['restore_aff'];
    if (!empty($id) && !empty($de_affiliated) && ($affiliated == $de_affiliated) && $restore_aff == 'false') {
        $query_aff = "SELECT * FROM booking WHERE id = '$id' AND offline = 2 ";
        $result_aff = mysqli_query($mysqli_p, $query_aff);
        $row_aff = mysqli_fetch_array($result_aff, MYSQLI_ASSOC);
    } else {
        $query_aff = "SELECT * FROM company_aff WHERE id = '$affiliated' AND offline = 2 ";
        $result_aff = mysqli_query($mysqli_p, $query_aff);
        $numrow = mysqli_num_rows($result_aff);
        $row_aff = mysqli_fetch_array($result_aff, MYSQLI_ASSOC);
    }
    $data_aff[] = array(
        'receipt_name' => $row_aff['receipt_name'],
        'receipt_taxid' => $row_aff['receipt_taxid'],
        'receipt_address' => $row_aff['receipt_address'],
        'receipt_detail' => $row_aff['receipt_detail']
    );
    echo json_encode($data_aff);
}
