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
$timezone = "-12:00";
$result1 = $database->findProfile($userid);
$timezone = $result1['timezone'];
date_default_timezone_set($timezone);

$time = date("H:i");

$current_date = date('Y-m-d');

$deviceId = $_GET['id'];
if (isset($_GET['id'])) {
    $deviceId = $_GET['id'];
} else {
    $deviceId = "";
}

if ($deviceId != "") {
    $result_2 = $database->findDeviceById($userid, $deviceId);
    $deviceName = $result_2['deviceName'];
    $deviceType = $result_2['deviceType'];
    $deviceOrientation = $result_2['deviceOrientation'];
    $status = $result_2['status'];
}

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

    <style>
        ::placeholder {
            font-family: 'Switzer', sans-serif;
            font-style: normal;
            font-weight: 500;
            font-size: 16px;
            line-height: 21px;
        }
    </style>
</head>

<body style="background-color: #FFFFFF;">
    <?php include("headers/secondHeader.php"); ?>
    <div class="container mt-5 mb-5">
        <div class="col-md-12">
            <a href="deviceView.php?id=<?php echo $deviceId; ?>" class="backButton">
                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.83976 13.5348L18.9645 3.41005C19.1288 3.24581 19.3448 3.16259 19.5608 3.16259C19.7768 3.16259 19.9928 3.24468 20.1571 3.41005C20.4867 3.73967 20.4867 4.27407 20.1571 4.60369L10.6285 14.1322L20.1571 23.6607C20.4867 23.9903 20.4867 24.5247 20.1571 24.8543C19.8275 25.184 19.2931 25.184 18.9634 24.8543L8.83866 14.7296C8.51017 14.3988 8.51014 13.8645 8.83976 13.5348Z" fill="#051017" />
                </svg> BACK</a>
            <p class="myDevice mb-4 mt-5">Upload new AD on <?php echo $deviceName; ?></p>
        </div>
        <div class="col-md-12 pt-3">
            <div class="row mb-2">
                <form action="" method="POST" enctype="multipart/form-data" style="display: flex;">
                    <div class="row d-flex">
                        <div class="col-lg-8 col-md-12 col-sm-12 col-12 " style="text-align: center;">
                            <div id="drop-area">
                                <div class="dropAreaInner">
                                    <svg width="29" height="28" viewBox="0 0 29 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.5359 8.73561C10.1987 8.39838 10.1987 7.85163 10.5359 7.5144L13.9888 4.06152C14.326 3.72429 14.8728 3.72429 15.21 4.06152L18.6629 7.5144C19.0001 7.85163 19.0001 8.39838 18.6629 8.73561C18.4948 8.90365 18.2738 8.98879 18.0528 8.98879C17.8319 8.98879 17.6109 8.9048 17.4429 8.73561L15.4632 6.75599V12.7294C15.4632 13.2059 15.0765 13.5926 14.6 13.5926C14.1235 13.5926 13.7367 13.2059 13.7367 12.7294V6.75712L11.7571 8.73674C11.4187 9.07282 10.8731 9.07284 10.5359 8.73561ZM20.3536 11.8662C19.8771 11.8662 19.4904 12.2529 19.4904 12.7294C19.4904 13.2059 19.8771 13.5926 20.3536 13.5926C22.4162 13.5926 24.0943 15.2707 24.0943 17.3333V18.4842C24.0943 20.5467 22.4162 22.2248 20.3536 22.2248H8.84402C6.7815 22.2248 5.1034 20.5467 5.1034 18.4842V17.3333C5.1034 15.2707 6.7815 13.5926 8.84402 13.5926C9.32052 13.5926 9.70724 13.2059 9.70724 12.7294C9.70724 12.2529 9.32052 11.8662 8.84402 11.8662C5.82965 11.8662 3.37695 14.3189 3.37695 17.3333V18.4842C3.37695 21.4986 5.82965 23.9513 8.84402 23.9513H20.3536C23.368 23.9513 25.8207 21.4986 25.8207 18.4842V17.3333C25.8207 14.3189 23.368 11.8662 20.3536 11.8662ZM21.5046 17.3333C21.5046 16.6979 20.989 16.1823 20.3536 16.1823C19.7183 16.1823 19.2027 16.6979 19.2027 17.3333C19.2027 17.9686 19.7183 18.4842 20.3536 18.4842C20.989 18.4842 21.5046 17.9686 21.5046 17.3333Z" fill="#051017" />
                                    </svg>
                                </div>
                                <p id="dragText">Drag & drop content here!</p>
                                <div style="position: relative;">
                                    <p id="dropText" class="text-center" style="position: absolute; z-index: -1; width:100% ">Upload content here!</p>
                                    <input style="opacity: 0; " type="file" id="fileElem" accept="video/*" multiple onchange="handleFiles(this.files)">
                                </div>

                                <p id="supportText">Files supported: mp4.<br>File can be 200MB max.</p>

                                <progress id="progress-bar" max=100 value=0 style="display: none; width:80%; margin:auto;"></progress>
                                <p id="percentageText" style="display: none;">0%</p><br>
                            </div>
                            <input type="submit" id="upldAd" class="uploadButton formButton large" value="Upload new AD" name="uploadAd" style="margin-top: 30px;">
                            <a href="index.php" id="bckDash" class="dashboardButton formButton large" style=" display: none; margin-top: 30px;">BACK TO DASHBOARD</a>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12 col-12 ml-5" id="formDiv">
                            <div class="onSmall">
                                <p class="chooselabel"> Choose date</p>
                                <div style="display: flex;">
                                    <div style="position:relative; display: flex; align-items: center;">
                                        <input type="date" id="sdate" class="val" name="startDate" min="<?php echo $current_date; ?>" onchange="sdchange()" style=" width:105px; border: none; opacity: 0;">
                                        <label class="DateLabel" style="margin-top: 10px; position:absolute; margin: 0px; ">Start date</label>
                                        <span class="date-icon open-datetimepicker" style="position:absolute; z-index: -1; margin-left: 83px;"><svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4223 2.43702C12.8751 1.98423 12.8751 1.25012 12.4223 0.797329C11.9695 0.344542 11.2354 0.344542 10.7826 0.797329L6.6488 4.93117L2.49116 0.773528C2.03837 0.320741 1.30426 0.320741 0.851473 0.773528C0.398686 1.22631 0.398685 1.96043 0.851473 2.41321L5.60267 7.16441C5.65395 7.25688 5.71883 7.34383 5.79733 7.42233C6.18765 7.81265 6.78704 7.8665 7.23505 7.58386C7.32137 7.53412 7.40266 7.47234 7.47647 7.39853C7.51507 7.35993 7.55038 7.31929 7.58239 7.27695L12.4223 2.43702Z" fill="#051017" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div style="position:relative; display: flex; align-items: center; margin-left: 10px;">
                                        <input type="date" id="edate" name="endDate" min="<?php echo $current_date; ?>" onchange="edchange()" style="width:95px; border: none; opacity: 0;">
                                        <label class="DateLabel" style=" position:absolute;  margin: 0px; ">End date</label>
                                        <span class="date-icon open-datetimepicker" style="position:absolute; z-index: -1; margin-left: 78px;"><svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4223 2.43702C12.8751 1.98423 12.8751 1.25012 12.4223 0.797329C11.9695 0.344542 11.2354 0.344542 10.7826 0.797329L6.6488 4.93117L2.49116 0.773528C2.03837 0.320741 1.30426 0.320741 0.851473 0.773528C0.398686 1.22631 0.398685 1.96043 0.851473 2.41321L5.60267 7.16441C5.65395 7.25688 5.71883 7.34383 5.79733 7.42233C6.18765 7.81265 6.78704 7.8665 7.23505 7.58386C7.32137 7.53412 7.40266 7.47234 7.47647 7.39853C7.51507 7.35993 7.55038 7.31929 7.58239 7.27695L12.4223 2.43702Z" fill="#051017" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label id="SDateValue" class="DateLabel" style="display: inline-block; width: 105px;"></label>
                                    <label id="EDateValue" class="DateLabel" style="display: inline-block; width: 105px; margin-left:17px;"></label>
                                </div>
                                <div class="form-group pl-5">
                                    <input type="checkbox" id="infinite" name="infinite" value="infinite" onclick="showdatefunc()">
                                    <label for="infinite" class="checkdata">Indefinitely</label>
                                </div>
                                <p class="chooselabel" style="margin-top: 20px;"> Choose time</p>
                                <div style="display: flex;">
                                    <div style="position:relative; display: flex; align-items: center;">
                                        <input type="time" id="stime" style="border: none; opacity: 0;" onchange="schange()" value="<?php echo $time; ?>" name="startTime">
                                        <label class="DateLabel" style="margin-top: 10px; position:absolute; margin: 0px; ">Start Time</label>
                                        <span class="date-icon open-datetimepicker" style="position:absolute; z-index: -1; margin-left: 85px;"><svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4223 2.43702C12.8751 1.98423 12.8751 1.25012 12.4223 0.797329C11.9695 0.344542 11.2354 0.344542 10.7826 0.797329L6.6488 4.93117L2.49116 0.773528C2.03837 0.320741 1.30426 0.320741 0.851473 0.773528C0.398686 1.22631 0.398685 1.96043 0.851473 2.41321L5.60267 7.16441C5.65395 7.25688 5.71883 7.34383 5.79733 7.42233C6.18765 7.81265 6.78704 7.8665 7.23505 7.58386C7.32137 7.53412 7.40266 7.47234 7.47647 7.39853C7.51507 7.35993 7.55038 7.31929 7.58239 7.27695L12.4223 2.43702Z" fill="#051017" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div style="position:relative; display: flex; align-items: center; margin-left: 13px;">
                                        <input type="time" id="etime" style="border: none; opacity: 0; width:100px;" name="endTime" onchange="echange()">
                                        <label id="EndTimeLabel" class="DateLabel" style=" position:absolute; margin: 0px;">End Time</label>
                                        <span id="EndTimeIcon" class="date-icon" style="position:absolute; z-index: -1; margin-left: 80px;"><svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4223 2.43702C12.8751 1.98423 12.8751 1.25012 12.4223 0.797329C11.9695 0.344542 11.2354 0.344542 10.7826 0.797329L6.6488 4.93117L2.49116 0.773528C2.03837 0.320741 1.30426 0.320741 0.851473 0.773528C0.398686 1.22631 0.398685 1.96043 0.851473 2.41321L5.60267 7.16441C5.65395 7.25688 5.71883 7.34383 5.79733 7.42233C6.18765 7.81265 6.78704 7.8665 7.23505 7.58386C7.32137 7.53412 7.40266 7.47234 7.47647 7.39853C7.51507 7.35993 7.55038 7.31929 7.58239 7.27695L12.4223 2.43702Z" fill="#051017" />
                                            </svg>
                                        </span><br>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <label id="STimeValue" class="DateLabel" style="display: inline-block; width: 105px;"></label>
                                    <label id="ETimeValue" class="DateLabel" style="display: inline-block; width: 105px; margin-left: 22px;"></label>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" id="everyday" name="everyday" value="everyday">
                                    <label for="everyday" class="checkdata">Everyday</label>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="customday" name="customday" onclick="showfunc()" value="customday">
                                    <label for="customday" class="checkdata">Custom days</label>
                                </div>
                                <div class="mb-5" id="customdaysname" style="display: none;">
                                    <span class="days Monday" onclick="change('Monday');">MON</span>
                                    <span class="days Tuesday" onclick="change('Tuesday');">TUE</span>
                                    <span class="days Wednesday" onclick="change('Wednesday');">WED</span>
                                    <span class="days Thursday" onclick="change('Thursday');">THU</span>
                                    <span class="days Friday" onclick="change('Friday');">FRI</span>
                                    <span class="days Saturday" onclick="change('Saturday');">SAT</span>
                                    <span class="days Sunday" onclick="change('Sunday');">SUN</span>
                                </div>
                                <p class="chooselabel">Name this AD:</p>
                                <input type="text" placeholder="Eg. My AD 1" style="border: none; border-bottom: 1px solid #000000;" name="name">

                                <input type="submit" id="upldAd1" class=" smallFormButton small" value="Upload new AD" name="uploadAd" style="margin-top: 30px; display:block; margin-left:auto; margin-right:auto;">
                                <a href="index.php" id="bckDash1" class="smallDashboardButton small" style=" display: none; margin-top: 30px;">BACK TO DASHBOARD</a>
                            </div>

                        </div>
                        
                            <input type="hidden" id="adFile" name="adFile" value="">
                            <input type="hidden" id="filesize" name="filesize" value="">
                            <input type="hidden" id="Monday" name="Monday" value="">
                            <input type="hidden" id="Tuesday" name="Tuesday" value="">
                            <input type="hidden" id="Wednesday" name="Wednesday" value="">
                            <input type="hidden" id="Thursday" name="Thursday" value="">
                            <input type="hidden" id="Friday" name="Friday" value="">
                            <input type="hidden" id="Saturday" name="Saturday" value="">
                            <input type="hidden" id="Sunday" name="Sunday" value="">
                            <input type="hidden" name="user" value="<?php echo $username; ?>">
                            <input type="hidden" name="deviceId" value="<?php echo $deviceId; ?>">
                            <input type="hidden" name="status" value="<?php echo $status; ?>">
                            <input type="hidden" name="CSRF_Code" value="<?php echo $jumo; ?>">
                       
                    </div>




                </form>
                <div class="col-md-4  ml-5" id="linkDiv" style="display:none">
                    <label for="" class="chooselabel">How to view my AD?</label>
                    <div class="mt-2 mb-2">
                        <span class="linktext">You have two options:</span>
                    </div>
                    <table>
                        <tr>
                            <td class="linktext" style=" vertical-align:top">1.</td>
                            <td class="linktext">Download our AdCast+ android app on your smartphone, tablet, or Android TV. Log in with you account and your add will start casting there.</td>
                        </tr>
                    </table>
                    <div class="mt-3 mb-3">
                        <a href="#" class="appLinkButton ml-3">DOWNLOAD ADCAST+ APP</a><br>
                    </div>
                    <table>
                        <tr>
                            <td class="linktext" style=" vertical-align:top">2.</td>
                            <td class="linktext">Generate a browser link that will automatically cast your AD. You can open that link on your smart TV, or any device with an internet browser.</td>
                        </tr>
                    </table>
                    <div class="mt-3 mb-3">
                        <button class="appLinkButton ml-3" data-toggle="modal" data-target="#urlModel">GENERATE BROWSER LINK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Url Model  Start -->
    <div class="modal fade" id="urlModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modalcont modal-content">
                <div class="modal-body">
                    <button type="button" class="closebtn" data-dismiss="modal" aria-label="Close">
                        <svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.656086 23.2269C-0.218689 24.1017 -0.218689 25.52 0.656086 26.3948L2.24001 27.9787C3.11478 28.8535 4.53307 28.8535 5.40784 27.9787L14.3173 19.0692L23.2271 27.9791C24.1019 28.8539 25.5202 28.8539 26.395 27.9791L27.9789 26.3952C28.8537 25.5204 28.8537 24.1021 27.9789 23.2273L19.069 14.3175L27.9787 5.40784C28.8535 4.53306 28.8535 3.11477 27.9787 2.24L26.3948 0.65608C25.52 -0.218694 24.1017 -0.218693 23.2269 0.656081L14.3173 9.56573L5.40804 0.656487C4.53326 -0.218287 3.11497 -0.218287 2.2402 0.656487L0.656281 2.24041C-0.218493 3.11518 -0.218493 4.53347 0.656281 5.40824L9.56553 14.3175L0.656086 23.2269Z" fill="white" />
                        </svg>

                    </button>
                    <div class="form-row mb-4" style="display: flex; justify-content: space-around; width:90%; padding-left:10px; margin-top: 76px;">
                        <div class="form-group mb-2" style=" padding: 11px; background: #FFFFFF; border-radius: 10px;">
                            <p id="urlLink" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; "></p>
                            <button class="btnCopyText11" onclick="myFunction()">Copy text</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Url Model  End -->
    </div>
    </div>

</body>
<script>
    function myFunction(elementID) {
        let element = document.getElementById("urlLink"); //select the element
        let elementText = element.textContent; //get the text content from the element
        copyText(elementText); //use the copyText function below
    }

    //If you only want to put some Text in the Clipboard just use this function
    // and pass the string to copied as the argument.
    function copyText(text) {
        navigator.clipboard.writeText(text);
    }
</script>

<script>
    $(document).ready(function() {
        $("form").submit(function(event) {
            var formData = {
                fileElem: $("input[name=adFile]").val(),
                adFile: $("input[name=adFile]").val(),
                name: $("input[name=name]").val(),
                deviceId: $("input[name=deviceId]").val(),
                status: $("input[name=status]").val(),
                startDate: $("input[name=startDate]").val(),
                endDate: $("input[name=endDate]").val(),
                infinite: $("input[name=infinite]:checked").val(),
                startTime: $("input[name=startTime]").val(),
                endTime: $("input[name=endTime]").val(),
                everyday: $("input[name=everyday]:checked").val(),
                customday: $("input[name=customday]:checked").val(),
                username: $("input[name=user]").val(),
                CSRF_Code: $("input[name=CSRF_Code]").val(),
                Monday: $("input[name=Monday]").val(),
                Tuesday: $("input[name=Tuesday]").val(),
                Wednesday: $("input[name=Wednesday]").val(),
                Thursday: $("input[name=Thursday]").val(),
                Friday: $("input[name=Friday]").val(),
                Saturday: $("input[name=Saturday]").val(),
                Sunday: $("input[name=Sunday]").val(),
                filesize: $("input[name=filesize]").val()
            };
            console.log(formData);
            $.ajax({
                type: "POST",
                url: "webApis/uploadVideoData.php",
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function(data) {
                if (data['status'] == "ok") {
                    document.getElementById("formDiv").style.display = "none";
                    document.getElementById("linkDiv").style.display = "block";
                    document.getElementById("upldAd").style.display = "none";
                    document.getElementById("upldAd1").style.display = "none";
                    document.getElementById("bckDash").style.display = "inline-block";
                    document.getElementById("bckDash1").style.display = "inline-block";
                    document.getElementById("urlLink").innerHTML = data['url'];
                } else {
                    alert("Your Ad Timing Or Days is overlapping Existing Ad Settings On This Device. Please Try To Add Unique Time/Date");
                }
            });

            event.preventDefault();
        });
    });
</script>
<script>
    function change($arg) {
        $value = document.getElementById($arg).value;
        if ($value == "") {
            document.getElementById($arg).value = $arg;
            document.getElementsByClassName($arg)[0].style.color = "#051017";
        } else {
            document.getElementById($arg).value = "";
            document.getElementsByClassName($arg)[0].style.color = "#B5B5B5";
        }
    }

    function showfunc() {
        var checkBox = document.getElementById("customday");
        var text = document.getElementById("customdaysname");
        if (checkBox.checked == true) {
            text.style.display = "block";
        } else {
            text.style.display = "none";
        }
    }

    function showdatefunc() {
        var checkBox = document.getElementById("infinite");
        var EndDateLabel = document.getElementById("EDateValue");
        var EndDateIcon = document.getElementById("EndDateIcon");

        if (checkBox.checked == true) {
            EndDateLabel.style.textDecoration = "line-through";
            // EndDateIcon.style.display = "none";
        } else {
            EndDateLabel.style.textDecoration = "none";
        }
    }
</script>

<script>
    function sdchange() {
        var stime = document.getElementById("sdate").value;
        let day = stime.substring(8, 10);
        let month = stime.substring(5, 7);
        let year = stime.substring(0, 4);
        let format4 = day + "." + month + "." + year;
        document.getElementById("SDateValue").innerHTML = format4;
    }

    function edchange() {
        var stime = document.getElementById("edate").value;
        let day = stime.substring(8, 10);
        let month = stime.substring(5, 7);
        let year = stime.substring(0, 4);
        let format4 = day + "." + month + "." + year;
        document.getElementById("EDateValue").innerHTML = format4;
    }

    function schange() {
        var stime = document.getElementById("stime").value;
        time = stime.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [stime];

        if (time.length > 1) { // If time format correct
            time = time.slice(1); // Remove full string match value
            time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
        }

        var str = time.toString().replaceAll(",", " ");
        document.getElementById("STimeValue").innerHTML = str;
    }

    function echange() {
        var etime = document.getElementById("etime").value;
        time = etime.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [etime];

        if (time.length > 1) { // If time format correct
            time = time.slice(1); // Remove full string match value
            time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
        }

        var strs = time.toString().replaceAll(",", " ");

        document.getElementById("ETimeValue").innerHTML = strs;
    }

    $('.open-datetimepicker').click(function(event) {
        event.preventDefault();
        $('#date').focus();
    });
    var value = Math.floor(Math.random() * (100000000000 - 1 + 1)) + 1;
    var index = "<?php echo $userid; ?>" + "<?php echo $deviceId; ?>";
    var videovalue = index + "_" + value + ".mp4";

    let dropArea = document.getElementById("drop-area");

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false)
        document.body.addEventListener(eventName, preventDefaults, false)
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false)
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false)
    })

    dropArea.addEventListener('drop', handleDrop, false)

    function preventDefaults(e) {
        e.preventDefault()
        e.stopPropagation()
    }

    function highlight(e) {
        dropArea.classList.add('highlight')
    }

    function unhighlight(e) {
        dropArea.classList.remove('active')
    }

    function handleDrop(e) {
        var dt = e.dataTransfer
        var files = dt.files
        console.log(files);

        if (files.length > 1) {
            alert("You can select only 1 video");
        } else {
            handleFiles(files)
        }
    }

    let uploadProgress = []
    let progressBar = document.getElementById('progress-bar')

    function initializeProgress(numFiles) {
        progressBar.value = 0
        uploadProgress = []
        document.getElementById("drop-area").style.border = "none";
        document.getElementById("progress-bar").style.display = "block";
        document.getElementById("percentageText").style.display = "block";
        document.getElementById("supportText").style.display = "none";

        for (let i = numFiles; i > 0; i--) {
            uploadProgress.push(0)
        }
    }

    function updateProgress(fileNumber, percent) {
        uploadProgress[fileNumber] = percent
        let total = uploadProgress.reduce((tot, curr) => tot + curr, 0) / uploadProgress.length
        document.getElementById("percentageText").innerHTML = total + "%";
        console.debug('update', fileNumber, percent, total)
        progressBar.value = total
    }

    function handleFiles(files) {

       if ($("#fileElem")[0].files.length > 1) {
            $("#fileElem").value = "";
            alert("You can select only 1 video");
            var $el = $('#fileElem');
            $el.wrap('<form>').closest(
                'form').get(0).reset();
            $el.unwrap();
        } else {
            var fileSize = files[0].size
            fileSize /= 1000000
            exactSize = (Math.round(fileSize * 100) / 100)

            if (exactSize > 200) {
                $("#fileElem").value = "";
                alert("You can only Upload file Of Size Max 200Mb");
                var $el = $('#fileElem');
                $el.wrap('<form>').closest(
                    'form').get(0).reset();
                $el.unwrap();
            } else {
                document.getElementById("dragText").innerHTML = "Your AD is uploading";
                document.getElementById("dropText").innerHTML = "Your AD is uploading";
                files = [...files]
                initializeProgress(files.length)
                files.forEach(uploadFile)
            }


        }
    }

    function uploadFile(file, i) {
        var url = 'webApis/uploadvideo.php';
        var xhr = new XMLHttpRequest()
        var formData = new FormData()

        var fileSize = file.size
        fileSize /= 1000000
        exactSize = (Math.round(fileSize * 100) / 100)

        xhr.open('POST', url, true)
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')

        // Update progress (can be used to show progress indicator)
        xhr.upload.addEventListener("progress", function(e) {
            updateProgress(i, (e.loaded * 100.0 / e.total) || 100)
        })

        xhr.addEventListener('readystatechange', function(e) {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("dragText").innerHTML = "Your AD is UP. Upload successful!";
                document.getElementById("dropText").innerHTML = "Your AD is UP. Upload successful!";
                updateProgress(i, 100) // <- Add this
                // console.log(videovalue);
                document.getElementById("percentageText").innerHTML = "100% (" + exactSize + "/" + exactSize + "MB) uploaded";
                document.getElementById("adFile").value = xhr.responseText;
                document.getElementById("filesize").value = exactSize;
                document.getElementById("drop-area").style.height = "auto";
                // alert(xhr.responseText);

            } else if (xhr.readyState == 4 && xhr.status != 200) {
                // Error. Inform the user
            }
        })

        formData.append('upload_preset', 'ujpu6gyk')
        formData.append('file', file)
        formData.append('video', videovalue)
        xhr.send(formData)
    }
</script>


<!-- jQuery library -->
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script> -->
<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</html>