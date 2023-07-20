<?php
//Start Validation
// $validation1 = $_GET["validation1"];
// $validation2 = $_GET["validation2"];
// $project_codeid = $_GET["project_codeid"];
// if (($validation1 == "aCJr06D3m51L") && ($validation2 == "EDnkQwe2Ne3N") && ($project_codeid == "1002")) {
    //Mid Validation

    $username = $_POST['username'];
    $password = $_POST['password'];
    //Android Token
    // $tokenid = $_POST['tokenid'];

    $password = md5($password);
    $response = array();

    // include db connect class
    include 'DatabaseConfig.php';

    $con = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);


    // Securities Second Phase...

    $username = str_replace("'", "&acute;", $username);
    $username = str_replace('"', "&quot;", $username);
    $username = str_replace("=", "&equiv;", $username);
    $username = str_replace(" or ", " &oacute;r ", $username);
    $username = str_replace(" and ", " &acirc;nd ", $username);
    $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags($username)));
    $username = mysqli_real_escape_string($con, $username);

    $password = str_replace("'", "&acute;", $password);
    $password = str_replace('"', "&quot;", $password);
    $password = str_replace("=", "&equiv;", $password);
    $password = str_replace(" or ", " &oacute;r ", $password);
    $password = str_replace(" and ", " &acirc;nd ", $password);
    $password = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags($password)));
    $password = mysqli_real_escape_string($con, $password);



    $tokenid = str_replace(" or ", " &oacute;r ", $tokenid);
    $tokenid = str_replace(" and ", " &acirc;nd ", $tokenid);
    $tokenid = mysqli_real_escape_string($con, $tokenid);

    // Securites Second Phase Ends...

    $sql = "SELECT * FROM users where username = '$username' AND password = '$password'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_num_rows($res);
    
    
    if ($row > 0) {
        $response["user"] = array();
        while ($row = mysqli_fetch_array($res)) {

            $UserInfo["id"] = $row["id"];
            $UserInfo["name"] = $row["name"];
            $UserInfo["username"] = $row["username"];
            $UserInfo["password"] = $row["password"];
            $UserInfo["userid"] = $row["userid"];
            $UserInfo["userlevel"] = $row["userlevel"];
            $UserInfo["email"] = $row["email"];
            $UserInfo["timestamp"] = $row["timestamp"];
            $UserInfo["parent_directory"] = $row["parent_directory"];
            $UserInfo["profileImage"] = $row["profileImage"];

            // push single product into final response array
            array_push($response["user"], $UserInfo);
        }
        // success

        // $Sql_Query = "Update users SET tokenid='$tokenid' where username = '$username'";
        // mysqli_query($con, $Sql_Query);

        // $Sql_Querye = "Update users SET tokenid='' where username != '$username' and tokenid='$tokenid'";
        // mysqli_query($con, $Sql_Querye);

        $response["success"] = 0;
        $response["message"] = "Successfully";
        // echoing JSON response
        echo json_encode($response);
    } else {
        $response["success"] = 1;
        $response["message"] = "user not found!";
        // echoing JSON response
        echo json_encode($response);
    }

    // Resume Validation
// }
//End Validation
