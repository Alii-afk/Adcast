<?php
include("include/classes/session.php");

$user = $_GET['user'];
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
$infinite = $_GET['infinite'];
$startTime = $_GET['startTime'];
$endTime = $_GET['endTime'];
$everyday = $_GET['everyday'];
$customday = $_GET['customday'];

if ($infinite != "") {
    $result = $database->checkByDates($startDate, $endDate, $user);
}

$result = $database->check();
