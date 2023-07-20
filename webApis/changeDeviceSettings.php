<?php

include("../include/classes/session.php");

error_reporting(0);
ini_set('display_errors', 0);



if (isset($_POST["deviceName"]) && isset($_POST["deviceId"]) && isset($_POST["user"])) {
    $type = "deviceName";
    $value = $_POST["deviceName"];
    if ($database->changeDeviceSettings($type, $value, $_POST["deviceId"], $_POST["user"])) {
        echo "success";
    } else {
        echo "Failed";
    }
}

if (isset($_POST["deviceType"]) && isset($_POST["deviceId"]) && isset($_POST["user"])) {
    $type = "deviceType";
    $value = $_POST["deviceType"];
    if ($database->changeDeviceSettings($type, $value, $_POST["deviceId"], $_POST["user"])) {
        echo "success";
    } else {
        echo "Failed";
    }
}

if (isset($_POST["deviceOrientation"]) && isset($_POST["deviceId"]) && isset($_POST["user"])) {
    $type = "deviceOrientation";
    $value = $_POST["deviceOrientation"];
    if ($database->changeDeviceSettings($type, $value, $_POST["deviceId"], $_POST["user"])) {
        echo "success";
    } else {
        echo "Failed";
    }
}
