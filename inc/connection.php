<?php
ob_start();
session_start();

date_default_timezone_set("Asia/Bangkok");
# -------------------- #

# DB Connect --------- #
if (strpos($_SERVER['DOCUMENT_ROOT'], ":")) {
	$host = "localhost";
	$username = "root";
	$password = "password";
	$database = "system_tms";

	$url_explode = explode("/", $_SERVER['REQUEST_URI']);
	$URL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . "/" . $url_explode[1] . "/" . $url_explode[2];
	$URL_INDEX = "http://localhost/tms";
	$URL_IMG = "..";
} else {
	$host = "localhost";
	$username = "wisdomto_online";
	$password = "gQ3Byqq=){}P";
	$database = "wisdomto_online";

	$URL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	$URL_INDEX = "https://www.wisdomtoken.co";
	$URL_IMG = "https://www.wisdomtoken.co";
}

$mysqli_p = mysqli_connect($host, $username, $password, $database);
if (!$mysqli_p) {
	die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($mysqli_p, "utf8");
# -------------------- #

# Set Default -------- #
$default_name = "TMS"; # Set company name
$confirm_code = "#ADMINTMS";
$today = date("Y-m-d");
$times = date("H:i:s");
$time_hm = date("H:i");
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; # Set full URL
# -------------------- #

# Set Function ------- #
function get_value($table, $field_id, $field_name, $val, $mysqli_p)
{
	$sqlgv = "SELECT $field_id, $field_name FROM $table WHERE $field_id = '$val'";
	$resultgv = mysqli_query($mysqli_p, $sqlgv);
	$numrowgv = mysqli_num_rows($resultgv);

	if (!empty($numrowgv)) {
		$rows = mysqli_fetch_array($resultgv);
		$value = $rows[1];
		// $value = preg_replace("~'~","",$value);
	} else {
		$value = "";
	}

	return $value;
}

function img_upload($photo, $photo_name, $tmp_photo, $uploaddir, $photo_time, $paramiter)
{
	if (empty($photo)) {
		$photo = $tmp_photo;
	} else {
		$ext = explode(".", $photo_name);
		$ext_n = count($ext) - 1;
		$ext_filetype = strtolower($ext[$ext_n]);
		$final_filename = $photo_time . $paramiter . "." . $ext_filetype;
		$newfile = $uploaddir . $final_filename;
		if (move_uploaded_file($photo, $newfile)) {
			$photo = $final_filename;
			!empty($tmp_photo) ? unlink($uploaddir . $tmp_photo) : '';
		} else {
			$photo = "false";
		}
	}

	return $photo;
}

function list_number($select, $start, $loop)
{
	$select = $select * 1;
	$i = 0;
	while ($i != $loop) {
		$selected = ($start == $select) ? ' selected' : '';
		echo "<option value=\"$start\"" . $selected . ">$start</option>";
		$start++;
		$i++;
	}
}

function DateDiff($strDate1, $strDate2)
{
	return (strtotime($strDate2) - strtotime($strDate1)) / (60 * 60 * 24);  // 1 day = 60*60*24
}

function setNumberLength($num, $length)
{
	$sumstr = strlen($num);
	$zero = str_repeat("0", $length - $sumstr);
	$result = $zero . $num;

	return $result;
}

function monthThai($month)
{
	switch ($month) {
		case "January":
			$value = "มกราคม";
			break;
		case "February":
			$value = "กุมภาพันธ์";
			break;
		case "March":
			$value = "มีนาคม";
			break;
		case "April":
			$value = "เมษายน";
			break;
		case "May":
			$value = "พฤษภาคม";
			break;
		case "June":
			$value = "มิถุนายน";
			break;
		case "July":
			$value = "กรกฎาคม";
			break;
		case "August":
			$value = "สิงหาคม";
			break;
		case "September":
			$value = "กันยายน";
			break;
		case "October":
			$value = "ตุลาคม";
			break;
		case "November":
			$value = "พฤศจิกายน";
			break;
		case "December":
			$value = "ธันวาคม";
			break;
	}

	return $value;
}

function send_notify_message($line_api, $access_token, $message_data)
{
	$headers = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer ' . $access_token);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $line_api);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $message_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	// Check Error
	if (curl_error($ch)) {
		$return_array = array('status' => '000: send fail', 'message' => curl_error($ch));
	} else {
		$return_array = json_decode($result, true);
	}
	curl_close($ch);
	return $return_array;
}
# -------------------- #
