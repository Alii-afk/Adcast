<?php
include("include/classes/session.php");
$result = $database->findUser($session->username);
$username = $session->username;
$userid = $result['id'];
$name = $result['name'];
$profilePicture = $result['profilePicture'];
$accountStatus = $result['accountStatus'];


$result = $database->findNoOfDevices($userid);
$noOfDevices = $result['noOfDevices'];

if ($accountStatus == "basic" && $noOfDevices == 2) {
    header('Location:index.php');
} else {
}

$jumostp = rand(100000, 999999);
$jumo1 = $jumostp;
$_SESSION['CSRF_Code'] =    $jumo1;
$jumo = md5($_SESSION['CSRF_Code'] . '8j5j&*&K5jrffgF9wAJDIH' . 'JKHds998954(*)(*dfkjll');
if ($session->logged_in) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="https://fonts.cdnfonts.com/css/switzer" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="styles/style.css">
    </head>

    <body style="background-color: #117BC8;">
        <?php include("headers/header.php"); ?>
        <div class=" container-fluid d-flex justify-content-around">

            <div class="addDeviceContainer col-sm-12 col-md-7 col-lg-7 d-flex justify-content-around">
                <form class=" justify-content-around" method="POST" action="process.php">
                    <?php if ($session->logged_in) { ?>
                        <a href="index.php" class="backButton pb-3">
                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.83976 13.5348L18.9645 3.41005C19.1288 3.24581 19.3448 3.16259 19.5608 3.16259C19.7768 3.16259 19.9928 3.24468 20.1571 3.41005C20.4867 3.73967 20.4867 4.27407 20.1571 4.60369L10.6285 14.1322L20.1571 23.6607C20.4867 23.9903 20.4867 24.5247 20.1571 24.8543C19.8275 25.184 19.2931 25.184 18.9634 24.8543L8.83866 14.7296C8.51017 14.3988 8.51014 13.8645 8.83976 13.5348Z" fill="#051017" />
                            </svg> BACK</a>
                    <?php } ?>
                    <label for="formName" class="headLabel">ADD NEW DEVICE</label>
                    <div class="addDeviceFormContainer col-md-8 col-sm-6 m-auto">
                        <input type="text" class="formInput" placeholder="Device name" name="deviceName"><br>
                        <select class="formInput" name="deviceType" id="deviceTypeId">
                            <option value="" selected>Device type</option>
                            <option value="androidTv">Android Tv</option>
                            <option value="appleTv">Apple Tv</option>
                        </select><br>
                        <div class="deviceBox">
                            <p class="deviceText">Device orientation</p>
                            <div class="horizontalButton" id="horizontalButton" onclick="changeHorizontal()">Horizontal</div>
                            <div href="" class="verticalButton" id="verticalButton" onclick="changeVertical()">Vertical</div>
                        </div>
                        <input type="hidden" value="" name="deviceOrientation" id="deviceOrientation">
                        <input type="hidden" name="CSRF_Code" value="<?php echo $jumo ?>">
                        <input type="submit" class="saveAndFinishButton" value="SAVE & FINISH" name="addDevice">
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script>
        function changeHorizontal() {
            document.getElementById("deviceOrientation").value = "horizontal";
            document.getElementById("horizontalButton").style.border = "2px solid #000000";
            document.getElementById("verticalButton").style.border = "1px solid #000000";
            console.log("run");
        }

        function changeVertical() {
            document.getElementById("deviceOrientation").value = "vertical";
            document.getElementById("horizontalButton").style.border = "1px solid #000000";
            document.getElementById("verticalButton").style.border = "2px solid #000000";
        }
    </script>

    </html>
<?php } else {
    header('Location:login.php');
} ?>