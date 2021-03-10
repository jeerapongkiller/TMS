<?php
if (!empty($_POST['lg_username']) && !empty($_POST['lg_password']) && !empty($_POST['lg_code']) && ($_POST['lg_code'] == $confirm_code)) {

    // Procedural mysqli
    $query = "SELECT * FROM users WHERE username = ? AND offline = '2'";
    $procedural_statement = mysqli_prepare($mysqli_p, $query);

    // Check error query
    if ($procedural_statement == false) {
        die("<pre>" . mysqli_error($mysqli_p) . PHP_EOL . $query . "</pre>");
    }

    mysqli_stmt_bind_param($procedural_statement, 's', $lg_username);

    $lg_username = $_POST["lg_username"];

    mysqli_stmt_execute($procedural_statement);
    $result = mysqli_stmt_get_result($procedural_statement);
    $numrow = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($numrow > 0) {
        $hashed_password = $row["password"];
        if (password_verify($_POST['lg_password'], $hashed_password)) {
            $_SESSION["admin"]["id"] = $row["id"];
            $_SESSION["admin"]["firstname"] = $row["firstname"];
            $_SESSION["admin"]["lastname"] = $row["lastname"];
            $_SESSION["admin"]["name"] = $row["firstname"] . " " . $row["lastname"];
            $_SESSION["admin"]["permission"] = $row["permission"];
            $_SESSION["admin"]["permission_name"] = get_value('permission', 'id', 'name', $row["permission"], $mysqli_p);
            $_SESSION["admin"]["photo"] = $row["photo"];
            $_SESSION["admin"]["company"] = '4';
            $_SESSION["admin"]["timestamp"] = time();

            mysqli_stmt_execute($procedural_statement);
            mysqli_stmt_close($procedural_statement);
            mysqli_close($mysqli_p);

            echo "<meta http-equiv=\"refresh\" content=\"0; url = './?mode=booking/list'\" >";
        } else {
            mysqli_close($mysqli_p);

            echo "<meta http-equiv=\"refresh\" content=\"0; url = './?message=error-login'\" >"; # go to login page with error message
        }
    } else {
        mysqli_close($mysqli_p);

        echo "<meta http-equiv=\"refresh\" content=\"0; url = './?message=error-login'\" >"; # go to login page with error message
    }
} else {
    mysqli_close($mysqli_p);

    echo "<meta http-equiv=\"refresh\" content=\"0; url = './?message=error-login'\" >"; # go to login page with error message
}
