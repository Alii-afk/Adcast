<?php

include("../include/classes/session.php");
error_reporting(0);
ini_set('display_errors', 0);

$username = $session->username;
$retval = $session->updateAdDevice($_POST['adId'], $_POST['name'], $_POST['deviceId'], $_POST['startDate'], $_POST['endDate'], $_POST['infinite'], $_POST['startTime'], $_POST['endTime'], $_POST['everyday'], $_POST['customday'], $username, $_POST['Monday'], $_POST['Tuesday'], $_POST['Wednesday'], $_POST['Thursday'], $_POST['Friday'], $_POST['Saturday'], $_POST['Sunday']);
if ($retval == "failed") {
    echo json_encode(array('status' => 'failed'));
} else if ($retval == "formError") {
    echo json_encode(array('status' => 'failed'));
} else {
    echo json_encode(array('status' => 'ok', 'url' => $retval));
}
