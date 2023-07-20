<?php

include("../include/classes/session.php");
error_reporting(0);
ini_set('display_errors', 0);
$filetype = array('jpeg', 'jpg', 'png', 'gif', 'PNG', 'JPEG', 'JPG');
foreach ($_FILES as $key) {

    $name = time() . $key['name'];

    $path = $base_url_images . $name;
    $file_ext =  pathinfo($name, PATHINFO_EXTENSION);
    if (in_array(strtolower($file_ext), $filetype)) {
        if ($key['name'] < 1000000) {
            $type = "profilePicture";
            $value = $name;
            $res = $database->findUser($_REQUEST["user"]);
            $profilePucture = $res['profilePicture'];

            if ($database->changeProfileSettings($type, $value, $_REQUEST["user"])) {
                $path_old = $base_url_images . $profilePucture;
                @unlink($path_old);
                @move_uploaded_file($key['tmp_name'], $path);
                echo $name;
            } else {
                echo "Failed";
            }
        } else {
            echo "FILE_SIZE_ERROR";
        }
    } else {
        echo "FILE_TYPE_ERROR";
    }
}
