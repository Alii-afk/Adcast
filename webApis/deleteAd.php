<?php
include("../include/classes/session.php");

error_reporting(0);
ini_set('display_errors', 0);

if ($database->deleteAd($_POST['adId'], $_POST['deviceId'], $_POST['userid'])) {
    header("Location: ../deviceView.php?id=" . $_POST['deviceId'] . "&&AdRemoved");
} else {
    header("Location: ../deviceView.php?id=" . $_POST['deviceId'] . "&&Error");
}
