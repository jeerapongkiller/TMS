<?php
require("../../../inc/connection.php");

if (!empty($_POST["username"])) {
    $bind_types = "";
    $params = array();

    $query = "SELECT * FROM users WHERE id > '0'";
    if (!empty($_POST["username"])) {
        $query .= " AND username = ?";
        $bind_types .= "s";
        array_push($params, $_POST["username"]);
    }
    if (!empty($_POST["id"])) {
        $query .= " AND id != ?";
        $bind_types .= "i";
        array_push($params, $_POST["id"]);
    }
    $query .= " LIMIT 1";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);
    if ($bind_types != "") {
        mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
    }
    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    echo ($numrow > 0) ?  'duplicate' : 'true';
} else {
    echo "false";
}
