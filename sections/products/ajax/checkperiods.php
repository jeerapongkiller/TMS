<?php
require("../../../inc/connection.php");

if (!empty($_POST["products"]) && $_POST["products"] > 0 && !empty($_POST["periods_from"]) && !empty($_POST["periods_to"])) {
    $bind_types = "";
    $params = array();
    $query = "SELECT * 
                        FROM products_periods 
                        WHERE id > '0' 
                            AND products = ? 
            ";
    $query .= " AND (periods_from <= '" . $_POST["periods_to"] . "') AND (periods_to >= '" . $_POST["periods_from"] . "')";
    $query .= $_POST["id"] > 0 ? " AND id != '" . $_POST["id"] . "'" : '';
    $query .= " ORDER BY products ASC, periods_from ASC";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    mysqli_stmt_bind_param($procedural_statement, 'i', $_POST["products"]);
    mysqli_stmt_execute($procedural_statement);
    $result_cate = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result_cate);
    echo $numrow > 0 ? "false" : "true";
} else {
    echo "false";
}	
