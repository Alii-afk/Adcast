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

$id = $_GET['id'];

$result_2 = $database->findDeviceById($userid, $id);
$deviceName = $result_2['deviceName'];
$deviceType = $result_2['deviceType'];
$deviceOrientation = $result_2['deviceOrientation'];
$status = $result_2['status'];

$jumostp = rand(100000, 999999);
$jumo1 = $jumostp;
$_SESSION['CSRF_Code'] =    $jumo1;
$jumo = md5($_SESSION['CSRF_Code'] . '8j5j&*&K5jrffgF9wAJDIH' . 'JKHds998954(*)(*dfkjll');

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

</head>

<body style="background-color: #FFFFFF;">
    <?php include("headers/secondHeader.php"); ?>
    <div class="container mt-5">
        <div class="col-md-12">
            <a href="index.php" class="backButton">
                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.83976 13.5348L18.9645 3.41005C19.1288 3.24581 19.3448 3.16259 19.5608 3.16259C19.7768 3.16259 19.9928 3.24468 20.1571 3.41005C20.4867 3.73967 20.4867 4.27407 20.1571 4.60369L10.6285 14.1322L20.1571 23.6607C20.4867 23.9903 20.4867 24.5247 20.1571 24.8543C19.8275 25.184 19.2931 25.184 18.9634 24.8543L8.83866 14.7296C8.51017 14.3988 8.51014 13.8645 8.83976 13.5348Z" fill="#051017" />
                </svg> BACK</a>
            <p class="myDevice mb-4 mt-5">Ads on TV <?php echo $deviceName; ?></p>
            <div class="">
                <div class="row largeScreen">
                    <div class="col-md-3"><span class="dtext">Name</span></div>
                    <div class="col-md-2"><span class="dtext">Connection</span></div>
                    <div class="col-md-2"><span class="dtext">Status</span></div>
                    <div class="col-md-3"><span class="dtext">Date & Time</span></div>
                    <div class="col-md-2 text-right">
                        <a href="uploadNewAd.php?id=<?php echo $id; ?>" class="btn adddevicebtn">Upload new AD</a>
                    </div>
                </div>
                <hr class="largeScreen" style="border: 1px solid #051017; color: #051017; margin-top: 0.6rem">
                <div class="col-md-12 pt-3">
                    <?php $database->groupdata('show_ads', $userid, $id, $status, $jumo); ?>
                </div>
            </div>
            <div class="smallScreen">
                <div class="row">
                    <div class="col-md-3"><span class="dtext">Name</span></div>
                </div>
                <hr style="border: 1px solid #051017; color: #051017; margin-top: 0.6rem">
                <div class="col-md-12 pt-3">
                    <?php $database->groupdata('show_ads1', $userid, $id, $status, $jumo); ?>
                </div>
                <div class="row">
                    <div class="col-md-6 col-6"><span class="dtext">Status</span></div>
                    <div class="col-md-6 col-6 text-right"><span class="dtext">Connection</span></div>
                </div>
                <hr style="border: 1px solid #051017; color: #051017; margin-top: 0.6rem">
                <div class="col-md-12 pt-3">
                    <?php $database->groupdata('show_ads2', $userid, $id, $status, $jumo); ?>
                </div>
                <div class="row">
                    <div class="col-md-12"><span class="dtext">Date & Time</span></div>
                </div>
                <hr style="border: 1px solid #051017; color: #051017; margin-top: 0.6rem">
                <div class="col-md-12 pt-3">
                    <?php $database->groupdata('show_ads3', $userid, $id, $status, $jumo); ?>
                </div>
                <div class="col-md-12 mt-3" style="padding:0px;">
                    <a href="uploadNewAd.php?id=<?php echo $id; ?>" class="btn adddevicebtn">Upload new AD</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container largeScreen" style="margin-top: 130px;">
        <div class="col-md-12">
            <p class="myDevice mb-4 mr-auto d-inline">Storage on this device</p>
            <button class="btn adddevicebtn  float-right mt-3 storagetext" data-toggle="modal" data-target="#packageModel">Upgrade to PRO</button>
            <p class="float-right storagetext mt-3 mr-2 accountText">Need more storage?</p>
            <hr style="border: 1px solid #051017; color: #051017; margin-top: 0.4rem">
        </div>
        <div class="col-md-12 pt-3">
            <p class="accountText">Storage 50% full (100/200MB avalable)</p>
            <div style="width: 300px; height: 10px; margin-top: 9px;">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

        </div>
    </div>

    <div class="container smallScreen" style="margin-top: 130px;">
        <div class="col-md-12">
            <p class="myDevice mb-4 mr-auto d-inline">Storage on this device</p>
            <hr style="border: 1px solid #051017; color: #051017; margin-top: 0.4rem">
        </div>
        <div class="col-md-12 pt-3">
            <p class="accountText">Storage 50% full (100/200MB avalable)</p>
            <div style="width: 300px; height: 10px; margin-top: 9px;">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 pt-3 d-flex justify-content-between">
            <p class=" mt-3 mr-2 accountText">Need more storage?</p>
            <button class="btn adddevicebtn mt-3" data-toggle="modal" data-target="#packageModel">Upgrade to PRO</button>
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

    <!-- Modal -->
    <!-- <div class="modal fade" id="changemodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div> -->
</body>

<script>
    function change($arg1, $arg, $arg2) {
        $value = document.getElementById($arg).value;
        if ($value == "") {
            document.getElementById($arg).value = $arg1;
            document.getElementById($arg2).style.color = "#051017";
        } else {
            document.getElementById($arg).value = "";
            document.getElementById($arg2).style.color = "#B5B5B5";
        }
    }

    function showfunc(customday, customdaysname) {
        var checkBox = document.getElementById(customday);
        var text = document.getElementById(customdaysname);
        if (checkBox.checked == true) {
            text.style.display = "block";
        } else {
            text.style.display = "none";
        }
    }

    function sdchange(sdate, SDateValue) {
        var stime = document.getElementById(sdate).value;
        let day = stime.substring(8, 10);
        let month = stime.substring(5, 7);
        let year = stime.substring(0, 4);
        let format4 = day + "." + month + "." + year;
        document.getElementById(SDateValue).innerHTML = format4;
    }

    function edchange(edate, EDateValue) {
        var stime = document.getElementById(edate).value;
        let day = stime.substring(8, 10);
        let month = stime.substring(5, 7);
        let year = stime.substring(0, 4);
        let format4 = day + "." + month + "." + year;
        document.getElementById(EDateValue).innerHTML = format4;
    }

    function schange(stime, STimeValue) {
        var stime = document.getElementById(stime).value;
        time = stime.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [stime];

        if (time.length > 1) { // If time format correct
            time = time.slice(1); // Remove full string match value
            time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
        }

        var str = time.toString().replaceAll(",", " ");
        document.getElementById(STimeValue).innerHTML = str;
    }

    function echange(etime, ETimeValue) {
        var etime = document.getElementById(etime).value;
        time = etime.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [etime];

        if (time.length > 1) { // If time format correct
            time = time.slice(1); // Remove full string match value
            time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
        }

        var strs = time.toString().replaceAll(",", " ");

        document.getElementById(ETimeValue).innerHTML = strs;
    }

    function showdatefunc(infinite, EDateValue) {
        var checkBox = document.getElementById(infinite);
        var EndDateLabel = document.getElementById(EDateValue);
        if (checkBox.checked == true) {
            EndDateLabel.style.textDecoration = "line-through";
        } else {
            EndDateLabel.style.textDecoration = "none";
        }
    }
</script>



<!-- jQuery library -->
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</html>