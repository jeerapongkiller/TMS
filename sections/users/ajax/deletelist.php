<?php
    require("../../../inc/connection.php");

    if(!empty($_POST["id"])){
        $query = "UPDATE users SET trash_deleted = ?, offline = ? WHERE id = ?";
        $procedural_statement = mysqli_prepare($mysqli_p, $query);
        mysqli_stmt_bind_param($procedural_statement, 'iii', $trash_deleted, $offline, $_POST["id"]);
        $trash_deleted = 1;
        $offline = 1;
        mysqli_stmt_execute($procedural_statement);
        $result = mysqli_stmt_get_result($procedural_statement);

        mysqli_close($mysqli_p);
    }
?>