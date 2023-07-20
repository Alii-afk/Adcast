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
$dId = $result_2['id'];
$deviceName = $result_2['deviceName'];
$deviceType = $result_2['deviceType'];
$deviceOrientation = $result_2['deviceOrientation'];
$status = $result_2['status'];


$jumostp = rand(100000, 999999);
$jumo1 = $jumostp;
$_SESSION['CSRF_Code'] =    $jumo1;
$jumo = md5($_SESSION['CSRF_Code'] . '8j5j&*&K5jrffgF9wAJDIH' . 'JKHds998954(*)(*dfkjll');
if ($session->logged_in) {

    if (isset($_GET['id']) && $dId != "") {
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
                    <a href="index.php" class="backButton">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.83976 13.5348L18.9645 3.41005C19.1288 3.24581 19.3448 3.16259 19.5608 3.16259C19.7768 3.16259 19.9928 3.24468 20.1571 3.41005C20.4867 3.73967 20.4867 4.27407 20.1571 4.60369L10.6285 14.1322L20.1571 23.6607C20.4867 23.9903 20.4867 24.5247 20.1571 24.8543C19.8275 25.184 19.2931 25.184 18.9634 24.8543L8.83866 14.7296C8.51017 14.3988 8.51014 13.8645 8.83976 13.5348Z" fill="#051017" />
                        </svg> BACK</a>
                    <p class="myDevice settingHeading mt-5" id="dname"><?php echo $deviceName; ?></p>

                    <hr style="border: 1px solid #051017; color: #051017; margin-top: 0.6rem">
                </div>
                <div class="col-md-12 pt-3 mb-5">
                    <button class="settingButtons" data-toggle="modal" data-target="#nameModel">Change device name</button>
                    <button class="settingButtons" data-toggle="modal" data-target="#typeModel">Change device type</button>
                    <button class="settingButtons" data-toggle="modal" data-target="#orientationModel">Change device orientation</button>
                    <form class="cmxform" id="signupForm" method="POST" action="webApis/deleteDevice.php">
                        <input type="hidden" class="form-text" id="id" name="deviceId" value="<?php echo $id; ?>">
                        <input type="hidden" class="form-text" id="username" name="userid" value="<?php echo $userid; ?>">
                        <input type="submit" class="settingButtons" onClick="return confirm('Are you sure you want to delete this Device?')" name="deleteDevice" value="Delete this device">
                    </form>
                </div>

                <!-- Name Model  Start -->
                <div class="modal fade" id="nameModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content settingsModelClass">
                            <div class="modal-body">
                                <button type="button" class="close closeModalButton" style="padding-top: 7px; padding-right: 15px; padding-bottom: 7px; padding-left: 15px;" data-dismiss="modal" aria-label="Close">
                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.58382 24.1547C0.709046 25.0294 0.709046 26.4477 1.58382 27.3225L3.16774 28.9064C4.04251 29.7812 5.4608 29.7812 6.33558 28.9064L15.245 19.997L24.1549 28.9068C25.0296 29.7816 26.4479 29.7816 27.3227 28.9068L28.9066 27.3229C29.7814 26.4481 29.7814 25.0298 28.9066 24.1551L19.9968 15.2452L28.9064 6.33557C29.7812 5.4608 29.7812 4.04251 28.9064 3.16773L27.3225 1.58381C26.4477 0.70904 25.0294 0.709041 24.1547 1.58382L15.245 10.4935L6.33577 1.58422C5.461 0.709447 4.04271 0.709447 3.16793 1.58422L1.58402 3.16814C0.709241 4.04292 0.709241 5.4612 1.58402 6.33598L10.4933 15.2452L1.58382 24.1547Z" fill="white" />
                                    </svg>
                                </button>
                                <div class="form-row" style="display: flex; justify-content: space-between; width:90%; padding-left:10px;">
                                    <div class="form-group  col-md-12 mb-2" style="padding-left:10px;">
                                        <label for="" class="headLabel2" id="deviceName">Change Device Name</label>
                                        <input type="text" class="formInput mt-2" name="deviceName" id="deviceNameInput" placeholder="<?php echo $deviceName; ?>" required>
                                    </div>
                                </div>
                                <div class="form-row " style="display: flex; justify-content: space-between; width:90%; padding-left:10px;">
                                    <div class="form-group  col-md-12 mb-2" style="padding-left:10px;">
                                        <input class=" deviceSettingModalBtn" onclick="changeName('<?php echo $userid; ?>', '<?php echo $id; ?>' )" name="deviceNameSubmit" type="submit" id="submit" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Name Model  End -->

                <!-- Type Model  Start -->
                <div class="modal fade" id="typeModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content settingsModelClass">
                            <div class="modal-body">
                                <button type="button" class="close closeModalButton" style="padding-top: 7px; padding-right: 15px; padding-bottom: 7px; padding-left: 15px;" data-dismiss="modal" aria-label="Close">
                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.58382 24.1547C0.709046 25.0294 0.709046 26.4477 1.58382 27.3225L3.16774 28.9064C4.04251 29.7812 5.4608 29.7812 6.33558 28.9064L15.245 19.997L24.1549 28.9068C25.0296 29.7816 26.4479 29.7816 27.3227 28.9068L28.9066 27.3229C29.7814 26.4481 29.7814 25.0298 28.9066 24.1551L19.9968 15.2452L28.9064 6.33557C29.7812 5.4608 29.7812 4.04251 28.9064 3.16773L27.3225 1.58381C26.4477 0.70904 25.0294 0.709041 24.1547 1.58382L15.245 10.4935L6.33577 1.58422C5.461 0.709447 4.04271 0.709447 3.16793 1.58422L1.58402 3.16814C0.709241 4.04292 0.709241 5.4612 1.58402 6.33598L10.4933 15.2452L1.58382 24.1547Z" fill="white" />
                                    </svg>
                                </button>
                                <div class="form-row" style="display: flex; justify-content: space-between; width:90%; padding-left:10px;">
                                    <div class="form-group  col-md-12 mb-2" style="padding-left:10px;">
                                        <label for="" class="headLabel2" id="deviceText1">Change Device Type: <?php echo $deviceType; ?></label>
                                        <select class="formInput mt-2" name="deviceType" id="deviceTypeId" onchange="myFunction(event)">
                                            <option value="" selected>Device type</option>
                                            <option value="androidTv">Android Tv</option>
                                            <option value="appleTv">Apple Tv</option>
                                        </select>
                                    </div>
                                </div>
                                <div class=" form-row " style=" display: flex; justify-content: space-between; width:90%; padding-left:10px;">
                                    <div class="form-group  col-md-12 mb-2" style="padding-left:10px;">
                                        <input type="hidden" class="form-control" name="deviceType" id="deviceTypeInput" placeholder="">
                                        <input class=" deviceSettingModalBtn " onclick="changeType('<?php echo $userid; ?>', '<?php echo $id; ?>' )" name="deviceTypeSubmit" type="submit" id="submit" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Type Model  End -->

                <!-- Orientation Model  Start -->
                <div class="modal fade" id="orientationModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content settingsModelClass">
                            <div class="modal-body">
                                <button type="button" class="close closeModalButton" style="padding-top: 7px; padding-right: 15px; padding-bottom: 7px; padding-left: 15px;" data-dismiss="modal" aria-label="Close">
                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.58382 24.1547C0.709046 25.0294 0.709046 26.4477 1.58382 27.3225L3.16774 28.9064C4.04251 29.7812 5.4608 29.7812 6.33558 28.9064L15.245 19.997L24.1549 28.9068C25.0296 29.7816 26.4479 29.7816 27.3227 28.9068L28.9066 27.3229C29.7814 26.4481 29.7814 25.0298 28.9066 24.1551L19.9968 15.2452L28.9064 6.33557C29.7812 5.4608 29.7812 4.04251 28.9064 3.16773L27.3225 1.58381C26.4477 0.70904 25.0294 0.709041 24.1547 1.58382L15.245 10.4935L6.33577 1.58422C5.461 0.709447 4.04271 0.709447 3.16793 1.58422L1.58402 3.16814C0.709241 4.04292 0.709241 5.4612 1.58402 6.33598L10.4933 15.2452L1.58382 24.1547Z" fill="white" />
                                    </svg>
                                </button>
                                <div class="form-row" id="name" style="display: flex; justify-content: space-between; width:90%; padding-left:10px;">
                                    <div class="form-group  col-md-12 mb-2" style="padding-left:10px;">
                                        <label for="" class="headLabel2">Change Device Orientation</label>
                                        <div class="deviceBox mt-2">
                                            <p class="deviceText">Device orientation</p>
                                            <div class="horizontalButton" id="horizontalButton" onclick="changeHorizontal()">Horizontal</div>
                                            <div href="" class="verticalButton" style="text-align: center;" id="verticalButton" onclick="changeVertical()">Vertical</div>
                                        </div>
                                        <input type="hidden" class="form-control" name="deviceOrientation" id="deviceOrientationInput">
                                    </div>
                                </div>
                                <div class="form-row " style="display: flex; justify-content: space-between; width:90%; padding-left:10px;">
                                    <div class="form-group  col-md-12 mb-2" style="padding-left:10px;">
                                        <input class="deviceSettingModalBtn " onclick="changeOrientation('<?php echo $userid; ?>', '<?php echo $id; ?>' )" name="deviceOrientationSubmit" type="submit" id="submit" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Orientation Model  End -->
            </div>

        </body>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

        <!-- jQuery library -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script> -->
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <!-- Popper JS -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function changeHorizontal() {
                document.getElementById("deviceOrientationInput").value = "horizontal";
                document.getElementById("horizontalButton").style.border = "2px solid #000000";
                document.getElementById("verticalButton").style.border = "1px solid #000000";
            }

            function changeVertical() {
                document.getElementById("deviceOrientationInput").value = "vertical";
                document.getElementById("horizontalButton").style.border = "1px solid #000000";
                document.getElementById("verticalButton").style.border = "2px solid #000000";
            }

            function myFunction(e) {
                document.getElementById("deviceTypeInput").value = e.target.value
            }
        </script>

        <script type="text/javascript">
            function changeName(username, id) {
                var Name = $("input[name=deviceName]").val();
                if (Name != "") {

                    var requestName = $.ajax({
                        url: "webApis/changeDeviceSettings.php",
                        type: "POST",
                        data: {
                            deviceName: Name,
                            user: username,
                            deviceId: id
                        }
                    });

                    requestName.done(function(data) {
                        console.log("Response : Success");
                        document.getElementById("dname").innerHTML = Name;
                        document.getElementById("deviceNameInput").value = "";
                        document.getElementById("deviceNameInput").placeholder = Name;

                        $('#nameModel').modal('hide');
                    });

                    requestName.fail(function(jqXHR, textStatus) {
                        console.log("Request failed: " + textStatus);
                    });
                }
            }

            function changeType(username, id) {
                var Type = $("input[name=deviceType]").val();
                if (Type != "") {

                    var requestType = $.ajax({
                        url: "webApis/changeDeviceSettings.php",
                        type: "POST",
                        data: {
                            deviceType: Type,
                            user: username,
                            deviceId: id
                        }
                    });

                    requestType.done(function(data) {
                        console.log("Response : Success");
                        document.getElementById("deviceText1").innerHTML = "Change Device Type: " + Type;
                        document.getElementById("deviceTypeInput").placeholder = Type;

                        $('#typeModel').modal('hide');
                    });

                    requestType.fail(function(jqXHR, textStatus) {
                        console.log("Request failed: " + textStatus);
                    });
                }
            }

            function changeOrientation(username, id) {
                var Orientation = $("input[name=deviceOrientation]").val();
                if (Orientation != "") {
                    var requestOrientation = $.ajax({
                        url: "webApis/changeDeviceSettings.php",
                        type: "POST",
                        data: {
                            deviceOrientation: Orientation,
                            user: username,
                            deviceId: id
                        }
                    });

                    requestOrientation.done(function(data) {
                        console.log("Response : Success");
                        // document.getElementById("deviceTypeInput").value = "";
                        // document.getElementById("deviceTypeInput").placeholder = Type;

                        $('#orientationModel').modal('hide');
                    });

                    requestOrientation.fail(function(jqXHR, textStatus) {
                        console.log("Request failed: " + textStatus);
                    });
                }
            }
        </script>

        </html>
<?php

    } else {
        header('Location:index.php');
    }
} else {
    header('Location:login.php');
} ?>