<?php
require_once "include/classes/session.php";
$base_url = "http://adcast.industrialemployeeprogress.com/";

$status = "'0'";
$error = "";

if (isset($_GET['SuccessfullyRegistered'])) {
    $status = "'1'";
    $error = "Account Registered! Please Login";
}
if (isset($_GET['FormError'])) {
    $status = "'2'";

    $nameError = $form->error("name");
    $emailError = $form->error("email");
    $passwordError = $form->error("password");

    if ($nameError != "") {
        $error = $nameError;
    } else if ($emailError != "") {
        $error = $emailError;
    } else if ($passwordError != "") {
        $error = $passwordError;
    }
}
if (isset($_GET['DBError'])) {
    $status = "'3'";
    $error = "Database Error";
}

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

<body style="background-color: #117BC8;" onload="launch_toast(<?php echo $status; ?>)">
    <?php include("headers/header.php"); ?>
    <div class="row d-flex container-fluid justify-content-around">
        <div class="registerContainer col-sm-10 col-md-7 col-lg-4 d-flex justify-content-around">
            <form class="row justify-content-around" method="POST" action="process.php">
                <label for="formName" class="headLabel">REGISTER NEW ACCOUNT</label>
                <div class="registerFormContainer col-md-8 col-sm-6">
                    <input type="text" class="formInput" placeholder="Name" name="name" value="<?php echo $form->value("name"); ?>" required>
                    <input type="email" class="formInput" placeholder="Email" name="email" value="<?php echo $form->value("email"); ?>" required>
                    <input type="password" class="formInput" placeholder="Password" name="password" required>
                    <input type="password" class="formInput" placeholder="Confirm Password" name="confirmPassword" required><br>
                    <input type="checkbox" class="privacyCheckbox" name="privacy" value="checked" required><span class="checkboxtext">I have taken note of the <a href="#" class="privacy noHover">privacy policy.</a></span>
                    <br><input type="submit" class="registerButton formButton" value="REGISTER" name="register">
                    <a href="login.php" class="registerLink noHover">Already have an account?<br><u class="noHover">Log in here.</u></a>
                </div>
            </form>
        </div>
    </div>
    <div id="toast">
        <div id="desc">A notification message..</div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
    function launch_toast(value) {
        var x = document.getElementById("toast");

        <?php if ($error != "") { ?>
            if (value == 1) {

                var y = document.getElementById("desc");
                y.innerHTML = '<?php echo $error; ?>';
            }
            if (value == 2) {
                var y = document.getElementById("desc");
                y.innerHTML = '<?php echo $error; ?>';
                x.style.backgroundColor = "#F94025";
            }
            if (value == 3) {
                var y = document.getElementById("desc");
                y.innerHTML = '<?php echo $error; ?>';
                x.style.backgroundColor = "#F94025";
            }
            if (value != 0) {
                x.className = "show";
                setTimeout(function() {
                    x.className = x.className.replace("show", "");
                }, 3000);
            }

        <?php } ?>

    }
</script>

</html>