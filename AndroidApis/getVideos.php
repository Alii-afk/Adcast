<?php

//Start Validation
// $validation1 = $_GET["validation1"];
// $validation2 = $_GET["validation2"];
// $project_codeid = $_GET["project_codeid"];
// if(($validation1 == "aCJr06D3m51L") && ($validation2 == "EDnkQwe2Ne3N") && ($project_codeid == "1001")){
//Mid Validation


$userId = $_POST['userId'];
$deviceId = $_POST['deviceId'];

$response = array();

    // include db connect class
include 'DatabaseConfig.php';

$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);


// Securities Second Phase...

$userId = str_replace("'","&acute;",$userId);
$userId = str_replace('"',"&quot;",$userId);
$userId = str_replace("=","&equiv;",$userId);
$userId = str_replace(" or "," &oacute;r ",$userId);
$userId = str_replace(" and "," &acirc;nd ",$userId);
$userId = str_replace('&lt;',"~",str_replace('<',"~&gt;",strip_tags($userId)));
$userId = mysqli_real_escape_string($con, $userId);

$deviceId = str_replace("'","&acute;",$deviceId);
$deviceId = str_replace('"',"&quot;",$deviceId);
$deviceId = str_replace("=","&equiv;",$deviceId);
$deviceId = str_replace(" or "," &oacute;r ",$deviceId);
$deviceId = str_replace(" and "," &acirc;nd ",$deviceId);
$deviceId = str_replace('&lt;',"~",str_replace('<',"~&gt;",strip_tags($deviceId)));
$deviceId = mysqli_real_escape_string($con, $deviceId);



// Securites Second Phase Ends...




    $sql = "SELECT * FROM `adsdetail` WHERE `deviceId` = '$deviceId' AND `user` = '$userId' order by id DESC";

    $res = mysqli_query($con,$sql);
  	$row = mysqli_num_rows($res);
  	if ($row > 0) {
        $response["Videos"] = array();
        while ($row = mysqli_fetch_array($res)){

            $Info["id"] = $row["id"];
            $Info["deviceId"] = $row["deviceId"];
            $Info["name"] = $row["name"];
            $Info["user"] = $row["user"];
            $Info["timestamp"] = $row["timestamp"];
            $Info["startDate"] = $row["startDate"];
            $Info["endDate"] = $row["endDate"];
            $Info["status"] = $row["status"];
            $Info["downloadStatus"] = $row["downloadStatus"];
            $Info["size"] = $row["size"];
            $Info["flag"] = $row["flag"];
            $Info["flag2"] = $row["flag2"];
            $Info["path"] = $row["path"];


          // push single product into final response array
          array_push($response["Videos"], $Info);
        }
        // success
        $response["success"] = 0;
        $response["message"] = "Videos fetch Successfully";
        // echoing JSON response
        echo json_encode($response);

  	}else{
      $response["success"] = $userId;
      $response["message"] = "Videos not found!";
      // echoing JSON response
        echo json_encode($response);
  	}



// Resume Validation
//}
//End Validation
?>
