<?php

include("../include/classes/session.php");

error_reporting(0);
ini_set('display_errors', 0);



if (isset($_POST["name"]) && isset($_POST["user"])) {
    $type = "name";
    $value = $_POST["name"];
    if ($database->changeProfileSettings($type, $value, $_POST["user"])) {
        echo "Success";
    } else {
        echo "Failed";
    }
}

if (isset($_POST["email"]) && isset($_POST["user"])) {
    $type = "email";
    $value = $_POST["email"];
    if ($database->changeProfileSettings($type, $value, $_POST["user"])) {
        $type = "username";
        if ($database->changeProfileSettings($type, $value, $_POST["user"])) {
            header("Location: " . $base_url);
        }
    } else {
        echo "Failed";
    }
}

if (isset($_POST["password"]) && isset($_POST["user"])) {
    $type = "password";
    $value = $_POST["password"];
    if ($database->changeProfileSettings($type, md5($value), $_POST["user"])) {
        header('Location: ' . $base_url);
    } else {
        echo "Failed";
    }
}


// 
