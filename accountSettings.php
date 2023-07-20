<?php
include("include/classes/session.php");
$result = $database->findUser($session->username);
$username = $session->username;
$userid = $result['id'];
$name = $result['name'];
$email = $result['email'];
$profilePicture = $result['profilePicture'];

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
                <div class="mb-5">
                    <a href="index.php" class="backButton mt-5">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.83976 13.5348L18.9645 3.41005C19.1288 3.24581 19.3448 3.16259 19.5608 3.16259C19.7768 3.16259 19.9928 3.24468 20.1571 3.41005C20.4867 3.73967 20.4867 4.27407 20.1571 4.60369L10.6285 14.1322L20.1571 23.6607C20.4867 23.9903 20.4867 24.5247 20.1571 24.8543C19.8275 25.184 19.2931 25.184 18.9634 24.8543L8.83866 14.7296C8.51017 14.3988 8.51014 13.8645 8.83976 13.5348Z" fill="#051017" />
                        </svg> BACK</a>
                </div>
                <?php if ($profilePicture == "") {
                    echo '
                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="32" cy="32" r="32" fill="#117BC8"/>
                    </svg>
                    ';
                } else {
                    echo '<img id="imageId" src="images/profiles/' . $profilePicture . '" alt="" class="profileImage">';
                } ?>
                <p class="myDevice mb-4 mt-5 mr-auto d-inline align-middle ml-2" id="pname">
                    <?php echo $name; ?>
                </p>
                <a href="" class="btn adddevicebtn float-right mt-4 ">Upgrade to PRO</a>
                <hr style="border: 1px solid #051017; color: #051017; margin-top: 0.6rem">
            </div>

            <div class="col-md-12 pt-3 mb-5">
                <button class="settingButtons" data-toggle="modal" data-target="#nameModel">Change your name</button>
                <button class="settingButtons" data-toggle="modal" data-target="#emailModel">Change your email</button>
                <button class="settingButtons" data-toggle="modal" data-target="#passwordModel">Change your password</button>
                <button class="settingButtons" data-toggle="modal" data-target="#profilePictureModel">Change your profile picture</button>
                <form class="cmxform" id="signupForm" method="POST" action="webApis/deleteAccount.php">
                    <input type="hidden" class="form-text" id="username" name="username" value="<?php echo $username; ?>">
                    <input type="hidden" class="form-text" id="username" name="userid" value="<?php echo $userid; ?>">
                    <input type="submit" class="settingButtons" onClick="return confirm('Are you sure you want to delete this Account?')" name="deleteAccount" value="Delete this account">
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
                                    <label for="" class="headLabel2" id="profileName">Change your Name</label>
                                    <input type="text" class="formInput mt-2" name="profileName" id="profileNameInput" placeholder="<?php echo $name; ?>" required>
                                </div>
                            </div>
                            <div class="form-row " style="display: flex; justify-content: space-between; width:90%; padding-left:10px;">
                                <div class="form-group  col-md-12 mb-2" style="padding-left:10px;">
                                    <input class="deviceSettingModalBtn " onclick="changeName('<?php echo $username; ?>')" name="profileNameSubmit" type="submit" id="submit" value="Submit">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Name Model  End -->

            <!-- Email Model  Start -->
            <div class="modal fade" id="emailModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <label for="" class="headLabel2" id="profileEmail">Change your email</label>
                                    <input type="text" class="formInput mt-2" name="email" id="profileEmailInput" placeholder="<?php echo $username; ?>" required>
                                </div>
                            </div>
                            <div class="form-row " style="display: flex; justify-content: space-between; width:90%; padding-left:10px;">
                                <div class="form-group  col-md-12 mb-2" style="padding-left:10px;">
                                    <input class="deviceSettingModalBtn " onclick="changeEmail('<?php echo $username; ?>')" name="profileEmailSubmit" type="submit" id="submit" value="Submit">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Email Model  End -->

            <!-- Password Model  Start -->
            <div class="modal fade" id="passwordModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <label for="" class="headLabel2" id="profilePassword">Change your password</label>
                                    <input type="password" class="formInput " name="password" id="profilePasswordInput" required>
                                </div>
                                <div class="form-group  col-md-12 mb-2" style="padding-left:10px;">
                                    <label for="" class="headLabel2" id="profileConfirmPassword">Confirm Password:</label>
                                    <input type="password" class="formInput " name="confirmPassword" id="profileConfirmPasswordInput" required>
                                </div>
                            </div>
                            <div class="form-row " style="display: flex; justify-content: space-between; width:90%; padding-left:10px;">
                                <div class="form-group  col-md-12 mb-2" style="padding-left:10px;">
                                    <input class="deviceSettingModalBtn " onclick="checkPassword('<?php echo $username; ?>')" name="profilePasswordSubmit" type="submit" id="submit" value="Submit">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Password Model  End -->

            <!-- Picture Model  Start -->
            <div class="modal fade" id="profilePictureModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <label for="item" class="headLabel2" id="profilePicture">Change your picture:</label>
                                    <div class="rCol">
                                        <div id="prv" style="height:auto; width:auto; float:left; margin-bottom: 28px; "></div>
                                    </div>
                                    <div class="rCol" style="clear:both;">
                                        <input type="file" class="formInput formInput2 p-2" id="file" name='file' onChange=" return submitForm('<?php echo $username; ?>');">
                                        <input type="hidden" id="filecount" value='0'>
                                        <!-- <input type="text" class="form-control" name="profilePicture" id="profilePictureInput" onChange=" return submitForm();" required> -->
                                    </div>
                                </div>
                                <div class="form-row " style="display: flex; justify-content: space-between; width:90%; padding-left:10px;">
                                    <div class="form-group  col-md-12 mb-2" style="padding-left:10px;">
                                        <input class="deviceSettingModalBtn" onclick="changePicture('<?php echo $username; ?>')" name="profilePictureSubmit" type="submit" id="submit" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Picture Model  End -->

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


    <script type="text/javascript">
        function changeName(username) {
            var Name = $("input[name=profileName]").val();
            if (Name != "") {
                var requestName = $.ajax({
                    url: "webApis/changeProfileSettings.php",
                    type: "POST",
                    data: {
                        name: Name,
                        user: username
                    }
                });

                requestName.done(function(data) {
                    console.log("Response : Success");
                    document.getElementById("pname").innerHTML = Name;
                    document.getElementById("profileNameInput").value = "";
                    document.getElementById("profileNameInput").placeholder = Name;

                    $('#nameModel').modal('hide');
                });

                requestName.fail(function(jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus);
                });
            }
        }

        function changeEmail(username) {
            var Email = $("input[name=email]").val();
            if (Email != "") {
                var requestEmail = $.ajax({
                    url: "webApis/changeProfileSettings.php",
                    type: "POST",
                    data: {
                        email: Email,
                        user: username
                    }
                });

                requestEmail.done(function(data) {
                    console.log("Response : Success");
                    window.location.href = "login.php";
                });

                requestEmail.fail(function(jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus);
                });
            }
        }


        function changePicture(username) {
            var Email = $("input[name=email]").val();
            if (Email != "") {
                var requestEmail = $.ajax({
                    url: "webApis/changeProfileSettings.php",
                    type: "POST",
                    data: {
                        email: Email,
                        user: username
                    }
                });

                requestEmail.done(function(data) {
                    console.log("Response : Success");
                    window.location.href = "login.php";
                });

                requestEmail.fail(function(jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus);
                });
            }
        }

        function checkPassword(username) {
            var password1 = $("input[name=password]").val();
            var password2 = $("input[name=confirmPassword]").val();
            // If Not same return False.    
            if (password1 != password2) {
                alert("\nPassword did not match: Please try again...")
                return false;
            } else {
                changePassword(username, password1);
            }

        }

        function changePassword(username, Password) {
            if (Password != "") {
                var requestPassword = $.ajax({
                    url: "webApis/changeProfileSettings.php",
                    type: "POST",
                    data: {
                        password: Password,
                        user: username
                    }
                });

                requestPassword.done(function(data) {
                    console.log("Response : Success");
                    window.location.href = "login.php";
                });

                requestPassword.fail(function(jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus);
                });
            }
        }

        function submitForm(username) {

            var fcnt = $('#filecount').val();
            var fname = $('#filename').val();
            var imgclean = $('#file');
            if (fcnt <= 1) {
                data = new FormData();
                data.append('file', $('#file')[0].files[0]);
                data.append('user', username);
                var imgname = $('input[type=file]').val();
                var size = $('#file')[0].files[0].size;

                var ext = imgname.substr((imgname.lastIndexOf('.') + 1));
                if (ext == 'jpg' || ext == 'jpeg' || ext == 'png' || ext == 'gif' || ext == 'PNG' || ext == 'JPG' || ext == 'JPEG') {
                    if (size <= 1000000) {
                        $.ajax({
                            url: "WebApis/upload.php",
                            type: "POST",
                            data: data,
                            enctype: 'multipart/form-data',
                            processData: false, // tell jQuery not to process the data
                            contentType: false // tell jQuery not to set contentType
                        }).done(function(data) {
                            if (data == 'Failed') {
                                alert('Database Error');
                            }
                            if (data != 'FILE_SIZE_ERROR' || data != 'FILE_TYPE_ERROR') {
                                fcnt = parseInt(fcnt) + 1;
                                $('#filecount').val(fcnt);
                                var img = '<div class="dialog" id ="img_' + fcnt + '" ><img src="images/profiles/' + data + '" height= "180px" width=250px"><a href="#" id="rmv_' + fcnt + '" onclick="return removeit(' + fcnt + ')" class="close-classic"></a></div><input type="hidden" id="name_' + fcnt + '" value="' + data + '">';
                                $('#prv').html(img);
                                document.getElementById("headerImageId").src = "images/profiles/" + data;
                                document.getElementById("imageId").src = "images/profiles/" + data;
                                if (fname !== '') {
                                    fname = fname + ',' + data;
                                } else {
                                    fname = data;
                                }
                                $('#filename').val(fname);
                                imgclean.replaceWith(imgclean = imgclean.clone(true));
                                $('#profilePictureModel').modal('hide');
                            } else {
                                imgclean.replaceWith(imgclean = imgclean.clone(true));
                                alert('SIZE AND TYPE ISSUE');
                            }

                        });
                        return false;
                    } //end size
                    else {
                        imgclean.replaceWith(imgclean = imgclean.clone(true)); //Its for reset the value of file type
                        alert('Sorry File size exceeding from 1 Mb');
                    }
                } //end FILETYPE
                else {
                    imgclean.replaceWith(imgclean = imgclean.clone(true));
                    alert('Sorry Only you can uplaod JPEG|JPG|PNG|GIF file type ');
                }
            } //end filecount
            else {
                imgclean.replaceWith(imgclean = imgclean.clone(true));
                alert('You Can not Upload more than 6 Photos');
            }
        }
    </script>

    </html>
<?php } else {
    header('Location:login.php');
} ?>