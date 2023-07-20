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

$result = $database->findDevice($userid);
if ($result) {
} else {
    header("location: addDevice.php");
}

$result = $database->findProfile($userid);
if ($result) {
} else {
    header("location: addProfile.php?SetUpProfile");
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

    <body style="background-color: #FFFFFF;">
        <?php include("headers/secondHeader.php"); ?>
        <div class="container mt-5">
            <div class="col-md-12">
                <p class="myDevice mb-4">My Devices</p>
                <div class="row divTag">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 connect"><span class="dtext">Name</span></div>
                    <div class="col-lg-3 col-md-2 col-sm-6 col-6 mr-auto connect connect2"><span class="dtext">Connection</span></div>
                    <div class="col-md-3 text-right deviceDiv">
                        <?php if ($accountStatus == "basic" && $noOfDevices == 2) {
                        } else {
                            echo '<a href="addDevice.php" class="btn adddevicebtn ">Add new device</a>';
                        } ?>
                    </div>
                </div>
                <hr style="border: 1px solid #051017; color: #051017; margin-top: 0.6rem">
            </div>
            <div class="col-md-12 pt-3 ">
                <?php $database->groupdata('show_devices', $userid, '', '', $jumo); ?>
            </div>
            <div class="col-md-12 mt-4 deviceDiv2">
                <?php if ($accountStatus == "basic" && $noOfDevices == 2) {
                } else {
                    echo '<a href="addDevice.php" class="btn adddevicebtn">Add new device</a>';
                } ?>
            </div>
        </div>
        <div class="container" style="margin-top: 130px;">
            <div class="col-md-12">
                <p class="myDevice mb-4 mr-auto d-inline">Account status</p>
                <button class="btn adddevicebtn float-right mt-2 adddevicedisplay " data-toggle="modal" data-target="#packageModel">Upgrade to PRO</button>
                <hr style="border: 1px solid #051017; color: #051017; margin-top: 0.4rem">
            </div>
            <div class="col-md-12 pt-3 mb-5">
                <?php
                if ($accountStatus == "basic") {
                    echo '<p class="accountText">You are on free version</p>
                    <p class="accountText">' . $noOfDevices . '/2 devices registered </p>
                    <p class="accountText">Storage 50% full (100/200MB available)</p>';
                } else {
                    echo '<p class="accountText">You are on Pro version</p>
                    <p class="accountText">' . $noOfDevices . ' devices registered </p>
                    <p class="accountText">Storage 50% full (100/200MB available)</p>';
                } ?>

                <div class="progDiv">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <button class="btn adddevicebtn adddevicedisplay2 mt-3" data-toggle="modal" data-target="#packageModel">Upgrade to PRO</button>

            </div>
        </div>

        <!-- Package Model  Start -->
        <div class="modal fade" id="packageModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content packageModelClass">
                    <div class="modal-body">
                        <button type="button" class="close closeModalButton" style="padding-top: 7px; padding-right: 15px; padding-bottom: 7px; padding-left: 15px;" data-dismiss="modal" aria-label="Close">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.58382 24.1547C0.709046 25.0294 0.709046 26.4477 1.58382 27.3225L3.16774 28.9064C4.04251 29.7812 5.4608 29.7812 6.33558 28.9064L15.245 19.997L24.1549 28.9068C25.0296 29.7816 26.4479 29.7816 27.3227 28.9068L28.9066 27.3229C29.7814 26.4481 29.7814 25.0298 28.9066 24.1551L19.9968 15.2452L28.9064 6.33557C29.7812 5.4608 29.7812 4.04251 28.9064 3.16773L27.3225 1.58381C26.4477 0.70904 25.0294 0.709041 24.1547 1.58382L15.245 10.4935L6.33577 1.58422C5.461 0.709447 4.04271 0.709447 3.16793 1.58422L1.58402 3.16814C0.709241 4.04292 0.709241 5.4612 1.58402 6.33598L10.4933 15.2452L1.58382 24.1547Z" fill="white" />
                            </svg>
                        </button>
                        <div class="pkgDiv text-center">
                            <p class="pkgtext">Thank you for registering on AdCast+ <br> your account is</p>
                            <h2 class="pkgHeading">FREE FOREVER</h2>
                            <p class="pkgtext">but keep in mind your limitations</p>
                            <ul class="text-left d-inline-block pkgtext pkgtext2">
                                <li>200MB of storage</li>
                                <li>2 devices</li>
                                <li>our banner</li>
                            </ul>
                            <p class="pkgtext">Upgrade to PRO and get:</p>
                            <ul class="text-left d-inline-block pkgtext">
                                <li>up to 4GB of storage</li>
                                <li>up to 20 devices</li>
                                <li>remove our banner</li>
                            </ul><br>
                            <a href="" class="btn addPackagebtn">Upgrade to PRO</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Package Model  End -->

    </body>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </html>
<?php } else {
    header('Location:login.php');
} ?>