<?php
include("../include/classes/session.php");

error_reporting(0);
ini_set('display_errors', 0);

if ($database->deleteDevice($_POST['deviceId'], $_POST['userid'])) {
    header("Location: ../index.php?DeviceRemoved");
} else {
    header("Location: ../deviceSettings.php?Error");
}
