<?php

//Start Validation
// $validation1 = $_GET["validation1"];
// $validation2 = $_GET["validation2"];
// $project_codeid = $_GET["project_codeid"];
// if(($validation1 == "aCJr06D3m51L") && ($validation2 == "EDnkQwe2Ne3N") && ($project_codeid == "1001")){
//Mid Validation


$userId = $_POST['userId'];


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



// Securites Second Phase Ends...




    $sql = "SELECT * FROM devices where user = '$userId' order by id DESC";

    $res = mysqli_query($con,$sql);
  	$row = mysqli_num_rows($res);
  	if ($row > 0) {
        $response["screens"] = array();
        while ($row = mysqli_fetch_array($res)){

         
          $Info["id"] = $row["id"];
          $Info["user"] = $row["user"];
          $Info["deviceName"] = $row["deviceName"];
          $Info["deviceType"] = $row["deviceType"];
          $Info["deviceOrientation"] = $row["deviceOrientation"];
          $Info["status"] = $row["status"];



          // push single product into final response array
          array_push($response["screens"], $Info);
        }
        // success
        $response["success"] = 0;
        $response["message"] = "Screens fetch Successfully";
        // echoing JSON response
        echo json_encode($response);

  	}else{
      $response["success"] = $userId;
      $response["message"] = "Screens not found!";
      // echoing JSON response
        echo json_encode($response);
  	}



// Resume Validation
//}
//End Validation
?>
