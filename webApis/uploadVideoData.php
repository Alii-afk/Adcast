<?php

include("../include/classes/session.php");
error_reporting(0);
ini_set('display_errors', 0);

define('UPLOAD_PATH', '../videos/');
$filetmpname = $_POST['adFile'];

$username = $session->username;
$retval = $session->uploadAdDevice($_POST['adFile'], $_POST['name'], $_POST['deviceId'], $_POST['status'], $_POST['startDate'], $_POST['endDate'], $_POST['infinite'], $_POST['startTime'], $_POST['endTime'], $_POST['everyday'], $_POST['customday'], $username, $_POST['CSRF_Code'], $_POST['Monday'], $_POST['Tuesday'], $_POST['Wednesday'], $_POST['Thursday'], $_POST['Friday'], $_POST['Saturday'], $_POST['Sunday'], $_POST['filesize']);
if ($retval == "failed") {
    echo json_encode(array('status' => 'failed'));
} else if ($retval == "formError") {
    echo json_encode(array('status' => 'failed'));
} else {
    echo json_encode(array('status' => 'ok', 'url' => $retval));
}
