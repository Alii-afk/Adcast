<?php
include("include/classes/session.php");

if (isset($_GET['c'])) {
    $link = $_GET['c'];
}

$result = $database->findadbasicDetail($link);
$path = $result['path'];
$id = $result['id'];
$deviceId = $result['deviceId'];
$name = $result['name'];
$user = $result['user'];
$timestamp = $result['timestamp'];
$startDate = $result['startDate'];
$endDate = $result['endDate'];
$status = $result['status'];
$downloadStatus = $result['downloadStatus'];
$size = $result['size'];
$flag = $result['flag'];
$flag2 = $result['flag2'];
$path = $result['path'];
$short_url = $result['short_url'];


$result1 = $database->findadDetail($id);
$adId = $result1['adId'];
$deviceId1 = $result1['deviceId'];
$user1 = $result1['user'];
$name1 = $result1['name'];
$date = $result1['date'];
$dateTimestamp = $result1['dateTimestamp'];
$flag1 = $result1['flag'];
$startTime = $result1['startTime'];
$endTime = $result1['endTime'];
$day = $result1['day'];
$flag21 = $result1['flag2'];
$monday = $result1['monday'];
$tuesday = $result1['tuesday'];
$wednesday = $result1['wednesday'];
$thursday = $result1['thursday'];
$friday = $result1['friday'];
$saturday = $result1['saturday'];
$sunday = $result1['sunday'];


$result2 = $database->findProfile($user1);
$timezone = $result2['timezone'];
date_default_timezone_set($timezone);

$t = date('H:i');
$t = strtotime($t);
$startTime = strtotime($startTime);
$endTime = strtotime($endTime);
$date = date('Y-m-d');

error_reporting(0);
ini_set('display_errors', 0);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="height:100vh">
    <?php if ($startDate <= $date) {
        // if Not Indefinetly
        if ($flag == 0) {
            if ($endDate >= $date) {
                if ($startTime <= $t && $t < $endTime) { ?>
                    <video width="100%" height="100%" controls autoplay>
                        <source src="videos/<?php echo $path; ?> " type="video/mp4">
                    </video>
                <?php } else {
                    echo "Your Video Is not scheduled For Today Date And Current Time";
                }
            } else {
                echo "Your Video Is not scheduled For Today Date And Current Time";
            }
        } else {
            if ($startTime <= $t && $t < $endTime) { ?>
                <video width="100%" height="100%" controls autoplay>
                    <source src="videos/<?php echo $path; ?> " type="video/mp4">
                </video>
    <?php } else {
                echo "Your Video Is not scheduled For Today Date And Current Time";
            }
        }
    } else {
        echo "Your Video Is not scheduled For Today Date And Current Time";
    } ?>

</body>

</html>