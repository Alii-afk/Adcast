<?php
include("../include/classes/session.php");

error_reporting(0);
ini_set('display_errors', 0);

if ($database->deleteAccount($_POST['username'], $_POST['userid'])) {
    header("Location: " . $base_url);
} else {
    header("Location: ../accountSettings.php");
}
