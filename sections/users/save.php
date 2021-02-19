<div class="app-content content ">
    <div class="content-body">
        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <?php
                        echo $_FILES['photo']['name'];
                        exit;
                        #----- General Information -----#
                        $id = !empty($_POST["id"]) ? $_POST["id"] : '';
                        $offline = !empty($_POST["offline"]) ? $_POST["offline"] : '2';
                        $username = !empty($_POST["username"]) ? $_POST["username"] : '';
                        $password = !empty($_POST["password"]) ? $_POST["password"] : '';
                        $firstname = !empty($_POST["firstname"]) ? $_POST["firstname"] : '';
                        $lastname = !empty($_POST["lastname"]) ? $_POST["lastname"] : '';
                        #----- General Information -----#

                        $return_url = !empty($id) ? '&id=' . $id : '';
                        $message_alert = "error";

                        if (!empty($username)) {
                            if (empty($id)) {
                                # ---- Insert to database ---- #
                                $query = "INSERT INTO users (permission, username, password, firstname, lastname, offline, trash_deleted, date_create, date_edit)";
                                $query .= "VALUES ('3', '', '', '', '', '2', '2', now(), now())";
                                $result = mysqli_query($mysqli_p, $query);
                                $id = mysqli_insert_id($mysqli_p);
                            }
                            if (!empty($id)) {
                                # ---- Upload Photo ---- #
                                $uploaddir = "inc/photo/users/";
                                $photo_time = time();
                                $photo = !empty($_FILES['photo']['tmp_name']) ? $_FILES['photo']['tmp_name'] : '';
                                $photo_name = !empty($_FILES['photo']['name']) ? $_FILES['photo']['name'] : '';
                                $tmp_photo = !empty($_POST['tmp_photo']) ? $_POST['tmp_photo'] : '';
                                $del_photo = !empty($_POST['del_photo']) ? $_POST['del_photo'] : '';

                                if (!empty($del_photo)) {
                                    unlink($uploaddir . $tmp_photo);
                                    $photo = "";
                                } else {
                                    $photo = !empty($photo[$i]) ? img_upload($photo[$i], $photo_name[$i], $tmp_photo[$i], $uploaddir, $photo_time, $paramiter) : $tmp_photo[$i];
                                }

                                # ---- Update to database ---- #
                                $bind_types = "";
                                $params = array();

                                $query = "UPDATE products SET";

                                $query .= " offline = ?,";
                                $bind_types .= "i";
                                array_push($params, $offline);

                                $query .= " category = ?,";
                                $bind_types .= "s";
                                array_push($params, $category);

                                $query .= " name = ?,";
                                $bind_types .= "s";
                                array_push($params, $name);

                                foreach ($photo as $i => $item) {
                                    if ($item != "false") {
                                        $photo_field = "photo" . $i;
                                        $query .= " " . $photo_field . " = ?,";
                                        $bind_types .= "s";
                                        array_push($params, $item);
                                    }
                                }

                                $query .= " percent = ?,";
                                $bind_types .= "s";
                                array_push($params, $percent);

                                $query .= ($page_title == "เพิ่มข้อมูล") ? ' date_create = now(),' : '';

                                $query .= " date_edit = now()";
                                $query .= " WHERE id = '$id'";
                                $procedural_statement = mysqli_prepare($mysqli_p, $query);
                                if ($bind_types != "") {
                                    mysqli_stmt_bind_param($procedural_statement, $bind_types, ...$params);
                                }
                                mysqli_stmt_execute($procedural_statement);
                                $result = mysqli_stmt_get_result($procedural_statement);

                                mysqli_close($mysqli_p);

                                $return_url = "&id=" . $id;
                                $message_alert = "success";
                                echo "<meta http-equiv=\"refresh\" content=\"0; url='./?mode=products/detail" . $return_url . "&message=" . $message_alert . "'\" >";
                            }
                        } else {
                            echo "<meta http-equiv=\"refresh\" content=\"0; url='./?mode=supplier/detail" . $return_url . "&message=" . $message_alert . "'\" >";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>