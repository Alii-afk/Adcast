<?php

include("constants.php");

class MySQLDB
{
   var $connection;
   var $num_active_users;
   var $num_active_guests;
   var $num_members;

   function __construct()
   {
      $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
      $this->num_members = -1;
      if (TRACK_VISITORS) {
         $this->calcNumActiveUsers();
         $this->calcNumActiveGuests();
      }
   }

   function confirmUserPass($username, $password)
   {
      $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $username))));
      $password = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $password))));

      $q = "SELECT password FROM users WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      if (!$result || (mysqli_num_rows($result) < 1)) {
         return 1;
      }

      $dbarray = mysqli_fetch_array($result);
      $dbarray['password'] = stripslashes($dbarray['password']);
      $password = stripslashes($password);

      if ($password == $dbarray['password']) {
         return 0;
      } else {
         return 2;
      }
   }

   function confirmUserID($username, $userid)
   {
      $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $username))));
      $userid = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $userid))));

      $q = "SELECT userid FROM " . TBL_USERS . " WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      if (!$result || (mysqli_num_rows($result) < 1)) {
         return 1;
      }

      $dbarray = mysqli_fetch_array($result);
      $dbarray['userid'] = stripslashes($dbarray['userid']);
      $userid = stripslashes($userid);

      if ($userid == $dbarray['userid']) {
         return 0;
      } else {
         return 2;
      }
   }

   function usernameTaken($username)
   {
      $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $username))));
      $q = "SELECT username FROM " . TBL_USERS . " WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      return (mysqli_num_rows($result) > 0);
   }

   function usernameBanned($username)
   {
      $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $username))));
      $q = "SELECT username FROM " . TBL_BANNED_USERS . " WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      return (mysqli_num_rows($result) > 0);
   }


   // ----- Custom Functions -----


   function findUser($username)
   {
      $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $username))));
      $q = "SELECT * FROM users where username='$username'";
      $result = mysqli_query($this->connection, $q);

      if (!$result || (mysqli_num_rows($result) < 1)) {
         return NULL;
      }

      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }

   function deleteDevice($deviceId, $userid)
   {
      $deviceId = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $deviceId))));
      $userid = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $userid))));

      $y = "DELETE FROM `adstimedetail` WHERE `user` = '$userid' AND `deviceId` = '$deviceId'";
      mysqli_query($this->connection, $y);

      $x = "DELETE FROM `adsdetail` WHERE `user` = '$userid' AND `deviceId` = '$deviceId'";
      mysqli_query($this->connection, $x);

      $z = "DELETE FROM `devices` WHERE `user` = '$userid' AND `id` = '$deviceId'";
      return mysqli_query($this->connection, $z);
   }

   function deleteAd($adId, $deviceId, $userid)
   {
      global $session;

      $adId = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $adId))));
      $deviceId = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $deviceId))));
      $userid = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $userid))));

      $username_confirm = $session->username;
      $res = $this->findUser($username_confirm);
      $userid_confirm = $res['id'];

      if ($userid_confirm == $userid) {
         $y = "DELETE FROM `adstimedetail` WHERE `user` = '$userid' AND `deviceId` = '$deviceId' AND `adId` = '$adId'";
         mysqli_query($this->connection, $y);

         $x = "DELETE FROM `adsdetail` WHERE `user` = '$userid' AND `deviceId` = '$deviceId' AND `id` = '$adId'";
         return mysqli_query($this->connection, $x);
      }
   }


   function deleteAccount($username, $userid)
   {
      global $session;

      $username_confirm = $session->username;
      $res = $this->findUser($username_confirm);
      $userid_confirm = $res['id'];

      $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $username))));
      $userid = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $userid))));

      if ($username_confirm == $username && $userid == $userid_confirm) {
         $y = "DELETE FROM `adstimedetail` WHERE `user` = '$userid'";
         mysqli_query($this->connection, $y);

         $x = "DELETE FROM `adsdetail` WHERE `user` = '$userid' ";
         mysqli_query($this->connection, $x);

         $z = "DELETE FROM `devices` WHERE `user` = '$userid'";
         mysqli_query($this->connection, $z);

         $p = "DELETE FROM `profile` WHERE `user` = '$userid'";
         mysqli_query($this->connection, $p);

         $q = "DELETE FROM `users` WHERE `id` = '$userid' AND `username` = '$username'";
         return mysqli_query($this->connection, $q);
      }

      return Null;
   }

   function changeDeviceSettings($type, $value, $deviceId, $userid)
   {
      $deviceId = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $deviceId))));
      $userid = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $userid))));
      $type = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $type))));
      $value = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $value))));

      $z = "UPDATE `devices` SET $type = '$value' WHERE `user` = '$userid' AND `id` = '$deviceId' ";
      return mysqli_query($this->connection, $z);
   }

   function changeProfileSettings($type, $value, $username)
   {
      $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $username))));
      $type = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $type))));
      $value = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $value))));

      $z = "UPDATE `users` SET $type = '$value' WHERE `username` = '$username'";
      return mysqli_query($this->connection, $z);
   }

   function findProfile($id)
   {
      $id = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $id))));
      $q = "SELECT * FROM profile where user = '$id'";
      $result = mysqli_query($this->connection, $q);

      if (!$result || (mysqli_num_rows($result) < 1)) {
         return NULL;
      }

      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }

   function findDevice($userid)
   {
      $userid = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $userid))));
      $q = "SELECT * FROM devices where user = '$userid'";
      $result = mysqli_query($this->connection, $q);

      if (!$result || (mysqli_num_rows($result) < 1)) {
         return NULL;
      }

      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }

   function findDeviceById($userid, $id)
   {
      $userid = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $userid))));
      $q = "SELECT * FROM devices where user = '$userid' and id= '$id'";
      $result = mysqli_query($this->connection, $q);

      if (!$result || (mysqli_num_rows($result) < 1)) {
         return NULL;
      }

      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }



   function addNewUser($name, $email, $password, $privacy)
   {
      $name = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $name))));
      $email = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $email))));
      $password = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $password))));
      $privacy = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $privacy))));

      $time = time();

      $q = "INSERT INTO `users`(`id`, `name`, `username`, `password`, `userid`, `userlevel`, `email`, `timestamp`, `parent_directory`, `privacy`, `profilePicture`, `accountStatus`) 
                        VALUES ('','$name','$email','$password','','2','$email','$time','0','$privacy','','basic')";
      return mysqli_query($this->connection, $q);
   }

   function registerProfile($businessName, $businessIndustry, $businessType, $workingHours, $timezone, $username)
   {
      $businessName = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $businessName))));
      $businessIndustry = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $businessIndustry))));
      $businessType = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $businessType))));
      $workingHours = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $workingHours))));
      $timezone = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $timezone))));
      $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $username))));

      $q = "INSERT INTO `profile` (`id`, `user`, `businessName`, `businessIndustry`, `businessType`, `workingHours`, `timezone`) 
         VALUES ('', '$username', '$businessName', '$businessIndustry', '$businessType', '$workingHours', '$timezone')";
      return mysqli_query($this->connection, $q);
   }

   function registerDevice($deviceName, $deviceType, $deviceOrientation, $id)
   {
      $deviceName = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $deviceName))));
      $deviceType = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $deviceType))));
      $deviceOrientation = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $deviceOrientation))));
      $id = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $id))));

      $q = "INSERT INTO `devices`(`id`, `user`, `deviceName`, `deviceType`, `deviceOrientation`, `status`) VALUES ('','$id','$deviceName','$deviceType','$deviceOrientation', 'Offline')";
      return mysqli_query($this->connection, $q);
   }

   function findNoOfDevices($id)
   {
      $q = "SELECT count(id) as noOfDevices FROM `devices` WHERE user = '$id'";
      $result = mysqli_query($this->connection, $q);

      if (!$result || (mysqli_num_rows($result) < 1)) {
         return NULL;
      }

      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }

   function findadDetail($id)
   {
      $q = "SELECT * FROM `adstimedetail` WHERE `adId` = '$id' LIMIT 1";
      $result = mysqli_query($this->connection, $q);

      if (!$result || (mysqli_num_rows($result) < 1)) {
         return NULL;
      }

      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }

   function findadbasicDetail($id)
   {
      $q = "SELECT * FROM `adsdetail` WHERE `id` = '$id' LIMIT 1";
      $result = mysqli_query($this->connection, $q);

      if (!$result || (mysqli_num_rows($result) < 1)) {
         return NULL;
      }

      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }

   function updateUserField($username, $field, $value)
   {
      $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $username))));
      $field = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $field))));
      $value = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $value))));
      $q = "UPDATE " . TBL_USERS . " SET " . $field . " = '$value' WHERE username = '$username'";
      return mysqli_query($this->connection, $q);
   }


   function uploadAdDevice($adFile, $name, $deviceId, $status, $startDate, $endDate, $flag, $startTime, $endTime, $id, $everyday, $customday, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $filesize)
   {
      $startDate = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $startDate))));
      $endDate = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $endDate))));
      $flag = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $flag))));
      $startTime = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $startTime))));
      $endTime = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $endTime))));
      $monday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $monday))));
      $tuesday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $tuesday))));
      $wednesday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $wednesday))));
      $thursday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $thursday))));
      $friday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $friday))));
      $saturday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $saturday))));
      $sunday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $sunday))));
      $everyday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $everyday))));
      $customday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $customday))));
      $name = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $name))));
      $adFile = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $adFile))));

      if ($customday == "") {
         $flag2 = 0;
      } else {
         $flag2 = 1;
      }

      if ($flag == 0) {
         $rangArray = [];
         $startDateTimestamp = [];
         $startDate1 = strtotime($startDate);
         $endDate1 = strtotime($endDate);
         $counter = 0;
         // Match Check Indefinetly For All Days Start
         $b = "SELECT * FROM `adstimedetail` WHERE 
                                             (`deviceId` = '$deviceId') 
                                             AND (`user` = '$id') 
                                             AND (`date`<= '$endDate') 
                                             AND (`flag` = '1') 
                                             AND (`flag2` = '0') 
                                             AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))";
         $resultb = mysqli_query($this->connection, $b);
         if (!$resultb || (mysqli_num_rows($resultb) < 1)) {
         } else {
            $counter++;
            return "failed";
         }
         // Match Check Indefinetly For All Days End

         for ($currentDate = $startDate1; $currentDate <= $endDate1; $currentDate += (86400)) {
            $day = date('l', $currentDate);
            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
            $startDateTimestamp[] = $currentDate;

            // Match Check Indefinetly For Custom Days Start
            $a = "SELECT * FROM `adstimedetail` WHERE 
                                    (`deviceId` = '$deviceId') 
                                    AND (`user` = '$id') 
                                    AND (`flag` = '1') 
                                    AND (`flag2` = '1') 
                                    AND (`date` <= '$date')
                                    AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))
                                    AND (`monday` = '$day' || `tuesday` = '$day' || `wednesday` = '$day' || `thursday` = '$day' || `friday` = '$day' || `saturday` = '$day' || `sunday` = '$day')";
            $resulta = mysqli_query($this->connection, $a);
            if (!$resulta || (mysqli_num_rows($resulta) < 1)) {
            } else {
               $counter++;
               return "failed";
            }
            // Match Check Indefinetly For Custom Days End

            $b = "SELECT * FROM `adstimedetail` WHERE 
                                    (`deviceId` = '$deviceId') 
                                    AND (`user` = '$id') 
                                    AND (`date` = '$date') 
                                    AND (`flag` = '0') 
                                    AND (`flag2` = '0') 
                                    AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))";
            $resultb = mysqli_query($this->connection, $b);
            if (!$resultb || (mysqli_num_rows($resultb) < 1)) {
            } else {
               $counter++;
               return "failed";
            }
         }

         //Data Insertion Part After All Checks Start
         if ($counter == 0) {
            $x = 0;
            $timestamp = time();
            $q = "INSERT INTO `adsdetail`(`id`, `deviceId`, `name`, `user`, `timestamp`, `startDate`, `endDate`, `status`, `downloadStatus`, `size`, `flag`, `flag2`, `path`, `startTime`, `endTime`) 
                                  VALUES ('','$deviceId','$name','$id', '$timestamp', '$startDate', '$endDate', '$status', 'Pending Download', '$filesize', '$flag', '$flag2', '$adFile', '$startTime', '$endTime' )";
            mysqli_query($this->connection, $q);

            $t = "SELECT * FROM `adsdetail` WHERE `deviceId` = '$deviceId' AND `name` = '$name' AND `user` = '$id' AND `timestamp` = '$timestamp'";
            $resultt = mysqli_query($this->connection, $t);
            $dbarrayt = mysqli_fetch_array($resultt);
            $adId = $dbarrayt['id'];

            $short_url = "http://adcast.industrialemployeeprogress.com/playAdd.php?c=" . $adId;
            $q1 = "UPDATE `adsdetail` SET `short_url`='$short_url' WHERE `id` = '$adId'";
            mysqli_query($this->connection, $q1);

            $x = 0;
            foreach ($rangArray as $value) {
               $day = "";
               $dateTimestamp = $startDateTimestamp[$x];
               $day = date('l', $dateTimestamp);
               if ($flag2 == 1) {
                  if ($day == $monday || $day == $tuesday || $day == $wednesday || $day == $thursday || $day == $friday || $day == $saturday || $day == $sunday) {
                     $r = "INSERT INTO `adstimedetail`(`id`, `adId`, `deviceId`, `user`, `name`, `date`, `dateTimestamp`, `flag`, `startTime`, `endTime`, `day`, `flag2`) 
                     VALUES ('', '$adId', '$deviceId', '$id', '$name', '$value', '$dateTimestamp', '$flag', '$startTime', '$endTime', '$day', '$flag2')";
                     mysqli_query($this->connection, $r);
                  }
               } else {
                  $r = "INSERT INTO `adstimedetail`(`id`, `adId`, `deviceId`, `user`, `name`, `date`, `dateTimestamp`, `flag`, `startTime`, `endTime`, `day`, `flag2`) 
                  VALUES ('', '$adId', '$deviceId', '$id', '$name', '$value', '$dateTimestamp', '$flag', '$startTime', '$endTime', '$day', '$flag2')";
                  mysqli_query($this->connection, $r);
               }

               $x++;
            }
            return $short_url;
         }
         //Data Insertion Part After All Checks End


      } else if ($flag == 1) {
         $counter = 0;
         if ($flag2 == 0) {

            $c = "SELECT * FROM `adstimedetail` WHERE 
                                                (`deviceId` = '$deviceId') 
                                                AND (`user` = '$id') 
                                                AND (`flag` = '1') 
                                                AND (`flag2` = '0') 
                                                AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))";
            $resultc = mysqli_query($this->connection, $c);
            if (!$resultc || (mysqli_num_rows($resultc) < 1)) {
            } else {
               $counter++;
               return "failed";
            }

            $d = "SELECT * FROM `adstimedetail` WHERE 
                                                (`deviceId` = '$deviceId') 
                                                AND (`user` = '$id') 
                                                AND (`flag` = '1') 
                                                AND (`flag2` = '1') 
                                                AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))";
            $resultd = mysqli_query($this->connection, $d);
            if (!$resultd || (mysqli_num_rows($resultd) < 1)) {
            } else {
               $counter++;
               return "failed";
            }

            $e = "SELECT * FROM `adstimedetail` WHERE 
                                                (`deviceId` = '$deviceId') 
                                                AND (`user` = '$id') 
                                                AND (`date` >= '$startDate')
                                                AND (`flag` = '0') 
                                                AND (`flag2` = '0') 
                                                AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))";
            $resulte = mysqli_query($this->connection, $e);
            if (!$resulte || (mysqli_num_rows($resulte) < 1)) {
            } else {
               $counter++;
               return "failed";
            }

            if ($counter == 0) {
               $x = 0;
               $timestamp = time();
               $q = "INSERT INTO `adsdetail`(`id`, `deviceId`, `name`, `user`, `timestamp`, `startDate`, `endDate`, `status`, `downloadStatus`, `size`, `flag`, `flag2`, `path` , `startTime`, `endTime`) 
                                  VALUES ('','$deviceId','$name','$id', '$timestamp', '$startDate', '$endDate', '$status', 'Pending Download', '$filesize', '$flag', '$flag2', '$adFile', '$startTime', '$endTime' )";
               mysqli_query($this->connection, $q);

               $t = "SELECT * FROM `adsdetail` WHERE `deviceId` = '$deviceId' AND `name` = '$name' AND `user` = '$id' AND `timestamp` = '$timestamp'";
               $result = mysqli_query($this->connection, $t);
               $dbarray = mysqli_fetch_array($result);
               $adId = $dbarray['id'];

               $short_url = "http://adcast.industrialemployeeprogress.com/playAdd.php?c=" . $adId;
               $q1 = "UPDATE `adsdetail` SET `short_url`='$short_url' WHERE `id` = '$adId'";
               mysqli_query($this->connection, $q1);

               $dateTimestamp = strtotime($startDate);
               $r = "INSERT INTO `adstimedetail`(`id`, `adId`, `deviceId`, `user`, `name`, `date`, `dateTimestamp`, `flag`, `startTime`, `endTime`, `day`, `flag2`)
                                          VALUES ('', '$adId', '$deviceId', '$id', '$name', '$startDate', '$dateTimestamp', '$flag', '$startTime', '$endTime', '','$flag2')";
               mysqli_query($this->connection, $r);

               return $short_url;
            }
         } else if ($flag2 == 1) {
            $f = "SELECT * FROM `adstimedetail` WHERE 
                                                (`deviceId` = '$deviceId') 
                                                AND (`user` = '$id') 
                                                AND (`flag` = '1') 
                                                AND (`flag2` = '0') 
                                                AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))";
            $resultf = mysqli_query($this->connection, $f);
            if (!$resultf || (mysqli_num_rows($resultf) < 1)) {
            } else {
               $counter++;
               return "failed";
            }
            $day2 = date('l', $startDate);
            $g = "SELECT * FROM `adstimedetail` WHERE 
                                                (`deviceId` = '$deviceId') 
                                                AND (`user` = '$id') 
                                                AND (`flag` = '1') 
                                                AND (`flag2` = '1') 
                                                AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))
                                                AND (`monday` = '$monday' || `tuesday` = '$tuesday' || `wednesday` = '$wednesday' || `thursday` = '$thursday' || `friday` = '$friday' || `saturday` = '$saturday' || `sunday` = '$sunday')";
            $resultg = mysqli_query($this->connection, $g);
            if (!$resultg || (mysqli_num_rows($resultg) < 1)) {
            } else {
               $counter++;
               return "failed";
            }

            $h = "SELECT * FROM `adstimedetail` WHERE 
                                                (`deviceId` = '$deviceId') 
                                                AND (`user` = '$id') 
                                                AND (`date` >= '$startDate')
                                                AND (`flag` = '0') 
                                                AND (`flag2` = '0') 
                                                AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))
                                                AND (`day` = '$monday' || `day` = '$tuesday' || `day` = '$wednesday' || `day` = '$thursday' || `day` = '$friday' || `day` = '$saturday' || `day` = '$sunday')";
            $resulth = mysqli_query($this->connection, $h);
            if (!$resulth || (mysqli_num_rows($resulth) < 1)) {
            } else {
               $counter++;
               return "failed";
            }

            if ($counter == 0) {
               $x = 0;
               $timestamp = time();
               $q = "INSERT INTO `adsdetail`(`id`, `deviceId`, `name`, `user`, `timestamp`, `startDate`, `endDate`, `status`, `downloadStatus`, `size`, `flag`, `flag2`, `path`, `startTime`, `endTime`) 
                                  VALUES ('','$deviceId','$name','$id', '$timestamp', '$startDate', '$endDate', '$status', 'Pending Download', '$filesize', '$flag', '$flag2', '$adFile', '$startTime', '$endTime')";
               mysqli_query($this->connection, $q);

               $t = "SELECT * FROM `adsdetail` WHERE `deviceId` = '$deviceId' AND `name` = '$name' AND `user` = '$id' AND `timestamp` = '$timestamp'";
               $result = mysqli_query($this->connection, $t);
               $dbarray = mysqli_fetch_array($result);
               $adId = $dbarray['id'];

               $short_url = "http://adcast.industrialemployeeprogress.com/playAdd.php?c=" . $adId;
               $q1 = "UPDATE `adsdetail` SET `short_url`='$short_url' WHERE `id` = '$adId'";
               mysqli_query($this->connection, $q1);

               $dateTimestamp = strtotime($startDate);
               $r = "INSERT INTO `adstimedetail`(`id`, `adId`, `deviceId`, `user`, `name`, `date`, `dateTimestamp`, `flag`, `startTime`, `endTime`, `day`, `flag2`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`)
                                          VALUES ('', '$adId', '$deviceId', '$id', '$name', '$startDate', '$dateTimestamp', '$flag', '$startTime', '$endTime', '','$flag2', '$monday', '$tuesday', '$wednesday', '$thursday', '$friday', '$saturday', '$sunday')";

               mysqli_query($this->connection, $r);

               return $short_url;
            }
         }
      }
   }


   function updateAdDevice($adId, $name, $deviceId, $startDate, $endDate, $flag, $startTime, $endTime, $id, $everyday, $customday, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday)
   {
      $adId = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $adId))));
      $startDate = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $startDate))));
      $endDate = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $endDate))));
      $flag = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $flag))));
      $startTime = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $startTime))));
      $endTime = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $endTime))));
      $monday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $monday))));
      $tuesday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $tuesday))));
      $wednesday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $wednesday))));
      $thursday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $thursday))));
      $friday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $friday))));
      $saturday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $saturday))));
      $sunday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $sunday))));
      $everyday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $everyday))));
      $customday = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $customday))));
      $name = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $name))));

      if ($customday == "") {
         $flag2 = 0;
      } else {
         $flag2 = 1;
      }

      if ($flag == 0) {
         $rangArray = [];
         $startDateTimestamp = [];
         $startDate1 = strtotime($startDate);
         $endDate1 = strtotime($endDate);
         $counter = 0;
         // Match Check Indefinetly For All Days Start
         $b = "SELECT * FROM `adstimedetail` WHERE 
                                             (`deviceId` = '$deviceId') 
                                             AND (`user` = '$id') 
                                             AND (`date`<= '$endDate') 
                                             AND (`flag` = '1') 
                                             AND (`flag2` = '0') 
                                             AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`)) 
                                             AND `adId` != '$adId'";
         $resultb = mysqli_query($this->connection, $b);
         if (!$resultb || (mysqli_num_rows($resultb) < 1)) {
         } else {
            $counter++;
            return "failed";
         }
         // Match Check Indefinetly For All Days End

         for ($currentDate = $startDate1; $currentDate <= $endDate1; $currentDate += (86400)) {
            $day = date('l', $currentDate);
            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
            $startDateTimestamp[] = $currentDate;

            // Match Check Indefinetly For Custom Days Start
            $a = "SELECT * FROM `adstimedetail` WHERE 
                                    (`deviceId` = '$deviceId') 
                                    AND (`user` = '$id') 
                                    AND (`flag` = '1') 
                                    AND (`flag2` = '1') 
                                    AND (`date` <= '$date')
                                    AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))
                                    AND (`monday` = '$day' || `tuesday` = '$day' || `wednesday` = '$day' || `thursday` = '$day' || `friday` = '$day' || `saturday` = '$day' || `sunday` = '$day')
                                    AND `adId` != '$adId'";
            $resulta = mysqli_query($this->connection, $a);
            if (!$resulta || (mysqli_num_rows($resulta) < 1)) {
            } else {
               $counter++;
               return "failed";
            }
            // Match Check Indefinetly For Custom Days End

            $b = "SELECT * FROM `adstimedetail` WHERE 
                                    (`deviceId` = '$deviceId') 
                                    AND (`user` = '$id') 
                                    AND (`date` = '$date') 
                                    AND (`flag` = '0') 
                                    AND (`flag2` = '0') 
                                    AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))
                                    AND `adId` != '$adId'";
            $resultb = mysqli_query($this->connection, $b);
            if (!$resultb || (mysqli_num_rows($resultb) < 1)) {
            } else {
               $counter++;
               return "failed";
            }
         }

         //Data Insertion Part After All Checks Start
         if ($counter == 0) {
            $x = 0;
            $timestamp = time();
            $q = "UPDATE `adsdetail` SET `timestamp`= '$timestamp' , `startDate` = '$startDate' , `endDate` = '$endDate' , `flag` = '$flag' , `flag2` = '$flag2' , `startTime` = '$startTime', `endTime` = '$endTime' WHERE `id` = '$adId'";
            mysqli_query($this->connection, $q);

            $q1 = "DELETE FROM `adstimedetail` WHERE `adId` = '$adId'";
            mysqli_query($this->connection, $q1);

            $x = 0;
            foreach ($rangArray as $value) {
               $day = "";
               $dateTimestamp = $startDateTimestamp[$x];
               $day = date('l', $dateTimestamp);
               if ($flag2 == 1) {
                  if ($day == $monday || $day == $tuesday || $day == $wednesday || $day == $thursday || $day == $friday || $day == $saturday || $day == $sunday) {
                     $r = "INSERT INTO `adstimedetail`(`id`, `adId`, `deviceId`, `user`, `name`, `date`, `dateTimestamp`, `flag`, `startTime`, `endTime`, `day`, `flag2`) 
                     VALUES ('', '$adId', '$deviceId', '$id', '$name', '$value', '$dateTimestamp', '$flag', '$startTime', '$endTime', '$day', '$flag2')";
                     mysqli_query($this->connection, $r);
                  }
               } else {
                  $r = "INSERT INTO `adstimedetail`(`id`, `adId`, `deviceId`, `user`, `name`, `date`, `dateTimestamp`, `flag`, `startTime`, `endTime`, `day`, `flag2`) 
                  VALUES ('', '$adId', '$deviceId', '$id', '$name', '$value', '$dateTimestamp', '$flag', '$startTime', '$endTime', '$day', '$flag2')";
                  mysqli_query($this->connection, $r);
               }

               $x++;
            }
            return "Success";
         }
         //Data Insertion Part After All Checks End


      } else if ($flag == 1) {
         $counter = 0;
         if ($flag2 == 0) {

            $c = "SELECT * FROM `adstimedetail` WHERE 
                                                (`deviceId` = '$deviceId') 
                                                AND (`user` = '$id') 
                                                AND (`flag` = '1') 
                                                AND (`flag2` = '0') 
                                                AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))
                                                AND `adId` != '$adId'";
            $resultc = mysqli_query($this->connection, $c);
            if (!$resultc || (mysqli_num_rows($resultc) < 1)) {
            } else {
               $counter++;
               return "failed";
            }

            $d = "SELECT * FROM `adstimedetail` WHERE 
                                                (`deviceId` = '$deviceId') 
                                                AND (`user` = '$id') 
                                                AND (`flag` = '1') 
                                                AND (`flag2` = '1') 
                                                AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))
                                                AND `adId` != '$adId'";
            $resultd = mysqli_query($this->connection, $d);
            if (!$resultd || (mysqli_num_rows($resultd) < 1)) {
            } else {
               $counter++;
               return "failed";
            }

            $e = "SELECT * FROM `adstimedetail` WHERE 
                                                (`deviceId` = '$deviceId') 
                                                AND (`user` = '$id') 
                                                AND (`date` >= '$startDate')
                                                AND (`flag` = '0') 
                                                AND (`flag2` = '0') 
                                                AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))
                                                AND `adId` != '$adId'";
            $resulte = mysqli_query($this->connection, $e);
            if (!$resulte || (mysqli_num_rows($resulte) < 1)) {
            } else {
               $counter++;
               return "failed";
            }

            if ($counter == 0) {
               $x = 0;
               $timestamp = time();

               $q = "UPDATE `adsdetail` SET `timestamp`= '$timestamp' , `startDate` = '$startDate' , `endDate` = '$endDate' , `flag` = '$flag' , `flag2` = '$flag2' , `startTime` = '$startTime', `endTime` = '$endTime' WHERE `id` = '$adId'";
               mysqli_query($this->connection, $q);

               $q1 = "DELETE FROM `adstimedetail` WHERE `adId` = '$adId'";
               mysqli_query($this->connection, $q1);

               $dateTimestamp = strtotime($startDate);
               $r = "INSERT INTO `adstimedetail`(`id`, `adId`, `deviceId`, `user`, `name`, `date`, `dateTimestamp`, `flag`, `startTime`, `endTime`, `day`, `flag2`)
                                          VALUES ('', '$adId', '$deviceId', '$id', '$name', '$startDate', '$dateTimestamp', '$flag', '$startTime', '$endTime', '','$flag2')";
               mysqli_query($this->connection, $r);

               return "Success";
            }
         } else if ($flag2 == 1) {
            $f = "SELECT * FROM `adstimedetail` WHERE 
                                                (`deviceId` = '$deviceId') 
                                                AND (`user` = '$id') 
                                                AND (`flag` = '1') 
                                                AND (`flag2` = '0') 
                                                AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))
                                                AND `adId` != '$adId'";
            $resultf = mysqli_query($this->connection, $f);
            if (!$resultf || (mysqli_num_rows($resultf) < 1)) {
            } else {
               $counter++;
               return "failed";
            }
            $day2 = date('l', $startDate);
            $g = "SELECT * FROM `adstimedetail` WHERE 
                                                (`deviceId` = '$deviceId') 
                                                AND (`user` = '$id') 
                                                AND (`flag` = '1') 
                                                AND (`flag2` = '1') 
                                                AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))
                                                AND (`monday` = '$monday' || `tuesday` = '$tuesday' || `wednesday` = '$wednesday' || `thursday` = '$thursday' || `friday` = '$friday' || `saturday` = '$saturday' || `sunday` = '$sunday')
                                                AND `adId` != '$adId'";
            $resultg = mysqli_query($this->connection, $g);
            if (!$resultg || (mysqli_num_rows($resultg) < 1)) {
            } else {
               $counter++;
               return "failed";
            }

            $h = "SELECT * FROM `adstimedetail` WHERE 
                                                (`deviceId` = '$deviceId') 
                                                AND (`user` = '$id') 
                                                AND (`date` >= '$startDate')
                                                AND (`flag` = '0') 
                                                AND (`flag2` = '0') 
                                                AND ((`startTime` <= '$startTime' AND '$startTime' <= `endTime`) OR (`startTime` <= '$endTime' AND '$endTime' <= `endTime`))
                                                AND (`day` = '$monday' || `day` = '$tuesday' || `day` = '$wednesday' || `day` = '$thursday' || `day` = '$friday' || `day` = '$saturday' || `day` = '$sunday')
                                                AND `adId` != '$adId'";
            $resulth = mysqli_query($this->connection, $h);
            if (!$resulth || (mysqli_num_rows($resulth) < 1)) {
            } else {
               $counter++;
               return "failed";
            }

            if ($counter == 0) {
               $x = 0;
               $timestamp = time();
               $q = "UPDATE `adsdetail` SET `timestamp`= '$timestamp' , `startDate` = '$startDate' , `endDate` = '$endDate' , `flag` = '$flag' , `flag2` = '$flag2', `startTime` = '$startTime', `endTime` = '$endTime' WHERE `id` = '$adId'";
               mysqli_query($this->connection, $q);

               $q1 = "DELETE FROM `adstimedetail` WHERE `adId` = '$adId'";
               mysqli_query($this->connection, $q1);

               $dateTimestamp = strtotime($startDate);
               $r = "INSERT INTO `adstimedetail`(`id`, `adId`, `deviceId`, `user`, `name`, `date`, `dateTimestamp`, `flag`, `startTime`, `endTime`, `day`, `flag2`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`)
                                          VALUES ('', '$adId', '$deviceId', '$id', '$name', '$startDate', '$dateTimestamp', '$flag', '$startTime', '$endTime', '','$flag2', '$monday', '$tuesday', '$wednesday', '$thursday', '$friday', '$saturday', '$sunday')";

               mysqli_query($this->connection, $r);

               return "Success";
            }
         }
      }
      return "failed";
   }


   function groupdata($type, $val1, $val2, $val3, $CSRF_Code)
   {
      $type = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $type))));
      $CSRF_Code = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $CSRF_Code))));

      $jumo2 = md5($_SESSION['CSRF_Code'] . '8j5j&*&K5jrffgF9wAJDIH' . 'JKHds998954(*)(*dfkjll');

      if ($CSRF_Code == $jumo2) {
         // in CKRF

         if ($type == "stp_fieldset") {
            $q = "SELECT username FROM users order by username ASC";
         }

         if ($type == "show_devices") {
            $q = "SELECT * FROM devices where user = '$val1' order by id ASC";
         }

         if ($type == "show_ads") {
            $q = "SELECT * FROM adsdetail where user = '$val1' AND deviceId = '$val2' order by id ASC";
         }
         if ($type == "show_ads1") {
            $q = "SELECT * FROM adsdetail where user = '$val1' AND deviceId = '$val2' order by id ASC";
         }
         if ($type == "show_ads2") {
            $q = "SELECT * FROM adsdetail where user = '$val1' AND deviceId = '$val2' order by id ASC";
         }
         if ($type == "show_ads3") {
            $q = "SELECT * FROM adsdetail where user = '$val1' AND deviceId = '$val2' order by id ASC";
         }


         // End in CKRF
      }



      // Out of CKRF
      if ($type == "stp_fieldset_more") {
         $q = "SELECT username FROM users order by username ASC";
      }



      //start query process



      $result = mysqli_query($this->connection, $q);
      $num_rows = mysqli_num_rows($result);
      if (!$result || ($num_rows < 0)) {
         echo "";
         return;
      }
      if ($num_rows == 0) {
         echo "";
         return;
      }


      for ($i = 0; $i < $num_rows; $i++) {

         mysqli_data_seek($result, $i);
         $row = mysqli_fetch_row($result);

         //END query process


         if ($CSRF_Code == $jumo2) {
            //In CKRF
            if ($type == "stp_fieldset") {
               echo $row[0];
            }

            if ($type == "show_devices") {
               echo '<div class="row mb-2">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-9 ">
                           <a href="deviceView.php?id=' . $row[0] . '" class="device">
                              <svg width="57" height="38" viewBox="0 0 57 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M32.583 8.83301H23.4163C20.8891 8.83301 18.833 10.8891 18.833 13.4163V18.9163C18.833 21.4436 20.8891 23.4997 23.4163 23.4997H27.083V25.333H24.333C23.827 25.333 23.4163 25.7428 23.4163 26.2497C23.4163 26.7566 23.827 27.1663 24.333 27.1663H31.6663C32.1723 27.1663 32.583 26.7566 32.583 26.2497C32.583 25.7428 32.1723 25.333 31.6663 25.333H28.9163V23.4997H32.583C35.1103 23.4997 37.1663 21.4436 37.1663 18.9163V13.4163C37.1663 10.8891 35.1103 8.83301 32.583 8.83301ZM35.333 18.9163C35.333 20.4325 34.0992 21.6663 32.583 21.6663H23.4163C21.9002 21.6663 20.6663 20.4325 20.6663 18.9163V13.4163C20.6663 11.9002 21.9002 10.6663 23.4163 10.6663H32.583C34.0992 10.6663 35.333 11.9002 35.333 13.4163V18.9163Z" fill="#051017"/>
                              <rect x="0.93" y="0.93" width="54.5755" height="35.2686" rx="4.2307" stroke="#051017" stroke-width="1.86"/>
                              </svg>
                              <span class=" ml-2 dsubtext">' . $row[2] . '</span>
                           </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-3  mr-auto cont"><span class="dsubtext">' . $row[5] . '</span></div>
                        <div class="col-lg-2 col-md-3 col-sm-6 col-12 text-right connect3t">
                           <a href="deviceSettings.php?id=' . $row[0] . '" class="deviceSettingbtn">Device settings</a>
                        </div>
                     </div>';
            }

            if ($type == "show_ads") {
               $text = "'Are you sure you want to delete this Ad?'";
               $startDay = date('d',  strtotime($row[5]));
               $startmonth = date('m',   strtotime($row[5]));
               $startDate =  $startDay . '.' . $startmonth . '.';
               $flag = $row['10'];
               if ($flag == 1) {
                  $endDate = "Indefinitely";
               } else {
                  $endDay = date('d',  strtotime($row[6]));
                  $endMonth = date('m',  strtotime($row[6]));
                  $endDate =  $endDay . '.' . $endMonth . '.';
               }
               $data = $this->findadDetail($row[0]);
               $startTime = $data['startTime'];
               $endTime = $data['endTime'];
               $d_monday  = $data['monday'];
               $d_tuesday  = $data['tuesday'];
               $d_wednesday  = $data['wednesday'];
               $d_thursday  = $data['thursday'];
               $d_friday  = $data['friday'];
               $d_saturday  = $data['saturday'];
               $d_sunday  = $data['sunday'];

               
               $time = $row[14] . ' to ' . $row[15];
               $current_date = date('Y-m-d');
               $sdate = "'sdate" . $row[0] . "'";
               $SDateValue = "'SDateValue" . $row[0] . "'";
               $edate = "'edate" . $row[0] . "'";
               $EDateValue = "'EDateValue" . $row[0] . "'";
               $stime = "'stime" . $row[0] . "'";
               $STimeValue = "'STimeValue" . $row[0] . "'";
               $etime = "'etime" . $row[0] . "'";
               $ETimeValue = "'ETimeValue" . $row[0] . "'";
               $customday = "'customday" . $row[0] . "'";
               $customdaysname = "'customdaysname" . $row[0] . "'";
               
               $Monday = "'Monday" . $row[0] . "'";
               $Tuesday = "'Tuesday" . $row[0] . "'";
               $Wednesday = "'Wednesday" . $row[0] . "'";
               $Thursday = "'Thursday" . $row[0] . "'";
               $Friday = "'Friday" . $row[0] . "'";
               $Saturday = "'Saturday" . $row[0] . "'";
               $Sunday = "'Sunday" . $row[0] . "'";
               $Mondays = "'Mondays" . $row[0] . "'";
               $Tuesdays = "'Tuesdays" . $row[0] . "'";
               $Wednesdays = "'Wednesdays" . $row[0] . "'";
               $Thursdays = "'Thursdays" . $row[0] . "'";
               $Fridays = "'Fridays" . $row[0] . "'";
               $Saturdays = "'Saturdays" . $row[0] . "'";
               $Sundays = "'Sundays" . $row[0] . "'";
               $Mondayss = "'Monday'";
               $Tuesdayss = "'Tuesday'";
               $Wednesdayss = "'Wednesday'";
               $Thursdayss = "'Thursday'";
               $Fridayss = "'Friday'";
               $Saturdayss = "'Saturday'";
               $Sundayss = "'Sunday'";
               $infinite = "'infinite" . $row[0] . "'";


               echo '<div class="row mb-2 largeScreen">
                        <div class="col-md-3">
                        <svg width="57" height="38" viewBox="0 0 57 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="57" height="38" fill="#E5E5E5"/>
                        <rect width="1440" height="1024" transform="translate(-226 -325)" fill="white"/>
                        <rect x="0.93" y="0.93" width="54.5755" height="35.2686" rx="4.2307" stroke="#051017" stroke-width="1.86"/>
                        <g filter="url(#filter0_d_4_526)">
                        <path d="M38.6664 20.3445C39.2855 19.9517 39.2855 19.0484 38.6664 18.6557L23.5357 9.05617C22.8699 8.63377 22 9.11209 22 9.90056V29.0996C22 29.8881 22.8699 30.3664 23.5357 29.944L38.6664 20.3445Z" fill="#117BC8"/>
                        </g>
                        <defs>
                        <filter id="filter0_d_4_526" x="2" y="-7.10059" width="57.1309" height="61.2021" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                        <feOffset dy="4"/>
                        <feGaussianBlur stdDeviation="10"/>
                        <feComposite in2="hardAlpha" operator="out"/>
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.08 0"/>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_4_526"/>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_4_526" result="shape"/>
                        </filter>
                        </defs>
                        </svg>
                        <a href="../playAdd.php?c=' . $row[0] . '" class=" ml-2 dsubtext" target="_blank" style="color: #051017;">' . $row[2] . '</a>
                        </div>
                        <div class="col-md-2"><span class="dsubtext">' . $val3 . '</span></div>
                        <div class="col-md-2"><span class="dsubtext">' . $row[8] . '</span></div>
                        <div class="col-md-3"><span class="dsubtext">From ' . $startDate . ' till ' . $endDate . '
                              - ' . $time . ' </span><br>
                              <button class="deviceSettingbtn" data-toggle="modal" data-target="#timeModal' . $row[0] . '" style="color: #117BC8">Change</button></div>
                        <div class="col-md-2 text-right">
                           <form class="cmxform" id="signupForm" method="POST" action="webApis/deleteAd.php">
                              <input type="hidden" class="form-text" id="id" name="adId" value="' . $row[0] . '">
                              <input type="hidden" class="form-text" id="id" name="deviceId" value="' . $val2 . '">
                              <input type="hidden" class="form-text" id="userid" name="userid" value="' . $val1 . '">
                              <input type="submit" class="deleteVideobtn" onClick="return confirm(' . $text . ')" value="Delete">
                           </form>
                        </div>
                     </div>
                     
                     <!-- Type Model  Start -->
                     <div class="modal fade" id="timeModal' . $row[0] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                              <div class="modal-content changeDiv p-4" style="border-radius: 20px;">
                                 <form action="" id="signupForm2' . $row[0] . '" method="POST" enctype="multipart/form-data">
                                    <div class="row" style="margin: 0px;">
                                       <div class="" id="formDiv">
                                          <p class="chooselabel" style="margin-top: 20px;"> Choose date</p>
                                          <div style="display: flex;">
                                             <div style="position:relative; display: flex; align-items: center;">
                                                <input type="date" id="sdate' . $row[0] . '" class="val" name="startDate' . $row[0] . '" value ="' . $row[5] . '" onchange="sdchange(' . $sdate . ', ' . $SDateValue . ')" style=" width:105px; border: none; opacity: 0; z-index: 1;">
                                                <label class="DateLabel" style="margin-top: 10px; position:absolute; margin: 0px; ">Start date</label>
                                                <span class="date-icon open-datetimepicker" style="position:absolute; z-index: 0; margin-left: 83px;"><svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                         <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4223 2.43702C12.8751 1.98423 12.8751 1.25012 12.4223 0.797329C11.9695 0.344542 11.2354 0.344542 10.7826 0.797329L6.6488 4.93117L2.49116 0.773528C2.03837 0.320741 1.30426 0.320741 0.851473 0.773528C0.398686 1.22631 0.398685 1.96043 0.851473 2.41321L5.60267 7.16441C5.65395 7.25688 5.71883 7.34383 5.79733 7.42233C6.18765 7.81265 6.78704 7.8665 7.23505 7.58386C7.32137 7.53412 7.40266 7.47234 7.47647 7.39853C7.51507 7.35993 7.55038 7.31929 7.58239 7.27695L12.4223 2.43702Z" fill="#051017" />
                                                      </svg>
                                                </span>
                                             </div>
                                             <div style="position:relative; display: flex; align-items: center; margin-left: 20px;">
                                                <input type="date" id="edate' . $row[0] . '" name="endDate' . $row[0] . '" id="enddateinput' . $row[0] . '" value ="' . $row[6] . '" onchange="edchange(' . $edate . ', ' . $EDateValue . ')" style="width:95px; border: none; opacity: 0; z-index: 1;">
                                                <label class="DateLabel" style=" position:absolute;  margin: 0px; ">End date</label>
                                                <span class="date-icon open-datetimepicker" style="position:absolute; z-index: 0; margin-left: 78px;"><svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                         <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4223 2.43702C12.8751 1.98423 12.8751 1.25012 12.4223 0.797329C11.9695 0.344542 11.2354 0.344542 10.7826 0.797329L6.6488 4.93117L2.49116 0.773528C2.03837 0.320741 1.30426 0.320741 0.851473 0.773528C0.398686 1.22631 0.398685 1.96043 0.851473 2.41321L5.60267 7.16441C5.65395 7.25688 5.71883 7.34383 5.79733 7.42233C6.18765 7.81265 6.78704 7.8665 7.23505 7.58386C7.32137 7.53412 7.40266 7.47234 7.47647 7.39853C7.51507 7.35993 7.55038 7.31929 7.58239 7.27695L12.4223 2.43702Z" fill="#051017" />
                                                      </svg>
                                                </span>
                                             </div>
                                          </div>
                                          <div style="display: flex;">
                                             <label id="SDateValue' . $row[0] . '" class="DateLabel" style="display: inline-block; width: 105px;"></label>
                                             ';
                                            if($row[10] == 1)
                                            {
                                            echo ' <label id="EDateValue' . $row[0] . '" class="DateLabel" style="display: inline-block; width: 105px; margin-left:17px; textDecoration: line-through;"></label>';
   
                                            }
                                            else
                                            {
                                            echo ' <label id="EDateValue' . $row[0] . '" class="DateLabel" style="display: inline-block; width: 105px; margin-left:17px;"></label>';
                                            }
                                            echo '
                                          </div>
                                          <div class="form-group pl-5">
                                            ';
                                            if($row[10] == 1)
                                            {
                                            echo ' <input type="checkbox" id="infinite' . $row[0] . '" name="infinite' . $row[0] . '" value="infinite" onclick="showdatefunc(' . $infinite . ', ' . $EDateValue . ')" checked>';
   
                                            }
                                            else
                                            {
                                            echo ' <input type="checkbox" id="infinite' . $row[0] . '" name="infinite' . $row[0] . '" value="infinite" onclick="showdatefunc(' . $infinite . ', ' . $EDateValue . ')">';
                                            }
                                            echo '<label for="infinite" class="checkdata"> Indefinitely</label>
                                          </div>
                                       </div>
                                       <div class="timeDiv" id="formDiv">
                                          <p class="chooselabel" style="margin-top: 20px;"> Choose time</p>
                                          <div style="display: flex;">
                                             <div style="position:relative; display: flex; align-items: center;">
                                                <input type="time" id="stime' . $row[0] . '" style="border: none; opacity: 0; z-index: 1;" onchange="schange(' . $stime . ',' . $STimeValue . ')" value="'.$startTime.'" name="startTime' . $row[0] . '">
                                                <label class="DateLabel" style="margin-top: 10px; position:absolute; margin: 0px; ">Start Time</label>
                                                <span class="date-icon open-datetimepicker" style="position:absolute; z-index: 0; margin-left: 85px;"><svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                         <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4223 2.43702C12.8751 1.98423 12.8751 1.25012 12.4223 0.797329C11.9695 0.344542 11.2354 0.344542 10.7826 0.797329L6.6488 4.93117L2.49116 0.773528C2.03837 0.320741 1.30426 0.320741 0.851473 0.773528C0.398686 1.22631 0.398685 1.96043 0.851473 2.41321L5.60267 7.16441C5.65395 7.25688 5.71883 7.34383 5.79733 7.42233C6.18765 7.81265 6.78704 7.8665 7.23505 7.58386C7.32137 7.53412 7.40266 7.47234 7.47647 7.39853C7.51507 7.35993 7.55038 7.31929 7.58239 7.27695L12.4223 2.43702Z" fill="#051017" />
                                                      </svg>
                                                </span>
                                             </div>
                                             <div style="position:relative; display: flex; align-items: center; margin-left: 20px;">
                                                <input type="time" id="etime' . $row[0] . '" style="border: none; opacity: 0; width:100px; z-index: 1;" name="endTime' . $row[0] . '" value="'.$endTime.'" onchange="echange(' . $etime . ', ' . $ETimeValue . ')">
                                                <label id="EndTimeLabel' . $row[0] . '" class="DateLabel" style=" position:absolute; margin: 0px;">End Time</label>
                                                <span id="EndTimeIcon' . $row[0] . '" class="date-icon" style="position:absolute; z-index: 0; margin-left: 80px;"><svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                         <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4223 2.43702C12.8751 1.98423 12.8751 1.25012 12.4223 0.797329C11.9695 0.344542 11.2354 0.344542 10.7826 0.797329L6.6488 4.93117L2.49116 0.773528C2.03837 0.320741 1.30426 0.320741 0.851473 0.773528C0.398686 1.22631 0.398685 1.96043 0.851473 2.41321L5.60267 7.16441C5.65395 7.25688 5.71883 7.34383 5.79733 7.42233C6.18765 7.81265 6.78704 7.8665 7.23505 7.58386C7.32137 7.53412 7.40266 7.47234 7.47647 7.39853C7.51507 7.35993 7.55038 7.31929 7.58239 7.27695L12.4223 2.43702Z" fill="#051017" />
                                                      </svg>
                                                </span><br>
                                             </div>
                                          </div>
                                          <div>
                                             <label id="STimeValue' . $row[0] . '" class="DateLabel" style="display: inline-block; width: 105px;"></label>
                                             <label id="ETimeValue' . $row[0] . '" class="DateLabel" style="display: inline-block; width: 105px; margin-left:17px;"></label>
                                          </div>
                                          <div class="form-group">
                                             ';
                                            if($row[11] == 0)
                                            {
                                            echo ' <input type="checkbox" id="everyday' . $row[0] . '' . $row[0] . '" name="everyday' . $row[0] . '" value="everyday" checked>';
   
                                            }
                                            else
                                            {
                                            echo '<input type="checkbox" id="everyday' . $row[0] . '' . $row[0] . '" name="everyday' . $row[0] . '" value="everyday" >';
                                            }
                                            echo '<label for="everyday" class="checkdata"> Everyday</label>
                                          </div>
                                          <div class="form-group">
                                             ';
                                            if($row[11] == 1)
                                            {
                                            echo ' <input type="checkbox" id="customday' . $row[0] . '" name="customday' . $row[0] . '" onclick="showfunc(' . $customday . ' , ' . $customdaysname . ')" value="customday" checked>';
   
                                            }
                                            else
                                            {
                                            echo '<input type="checkbox" id="customday' . $row[0] . '" name="customday' . $row[0] . '" onclick="showfunc(' . $customday . ' , ' . $customdaysname . ')" value="customday">';
                                            }
                                            echo '
                                             <label for="customday" class="checkdata"> Custom days</label>
                                          </div>
                                           ';
                                            if($row[11] == 1)
                                            {
                                            echo '<div class="mb-5" id="customdaysname' . $row[0] . '" >
                                            ';
                                            
                                            if ($d_monday != "") { echo '<span style="color : #B5B5B5" id="Mondays' . $row[0] . '" class="days Monday" onclick="change(' . $Mondayss . ', ' . $Monday . ', ' . $Mondays . ');">MON</span>'; }
                                            else { echo '<span id="Mondays' . $row[0] . '" class="days Monday" onclick="change(' . $Mondayss . ', ' . $Monday . ', ' . $Mondays . ');">MON</span>'; }
                                            
                                            if ($d_tuesday != "") { echo '<span style="color : #B5B5B5" id="Tuesdays' . $row[0] . '" class="days Tuesday" onclick="change(' . $Tuesdayss . ', ' . $Tuesday . ', ' . $Tuesdays . ');">TUE</span>'; }
                                            else { echo '<span id="Tuesdays' . $row[0] . '" class="days Tuesday" onclick="change(' . $Tuesdayss . ', ' . $Tuesday . ', ' . $Tuesdays . ');">TUE</span>'; }
                                            
                                            if ($d_wednesday != "") { echo '<span style="color : #B5B5B5" id="Wednesdays' . $row[0] . '" class="days Wednesday" onclick="change(' . $Wednesdayss . ', ' . $Wednesday . ', ' . $Wednesdays . ');">WED</span>'; }
                                            else { echo '<span id="Wednesdays' . $row[0] . '" class="days Wednesday" onclick="change(' . $Wednesdayss . ', ' . $Wednesday . ', ' . $Wednesdays . ');">WED</span>'; }
                                            
                                            if ($d_thursday != "") { echo '<span style="color : #B5B5B5" id="Thursdays' . $row[0] . '" class="days Thursday" onclick="change(' . $Thursdayss . ', ' . $Thursday . ', ' . $Thursdays . ');">THU</span>'; }
                                            else { echo '<span id="Thursdays' . $row[0] . '" class="days Thursday" onclick="change(' . $Thursdayss . ', ' . $Thursday . ', ' . $Thursdays . ');">THU</span>'; }
                                            
                                            if ($d_friday != "") { echo '<span style="color : #B5B5B5" id="Fridays' . $row[0] . '" class="days Friday" onclick="change(' . $Fridayss . ',' . $Friday . ', ' . $Fridays . ');">FRI</span>'; }
                                            else { echo '<span id="Fridays' . $row[0] . '" class="days Friday" onclick="change(' . $Fridayss . ',' . $Friday . ', ' . $Fridays . ');">FRI</span>'; }
                                            
                                            if ($d_saturday != "") { echo '<span style="color : #B5B5B5" id="Saturdays' . $row[0] . '" class="days Saturday" onclick="change(' . $Saturdayss . ', ' . $Saturday . ', ' . $Saturdays . ');">SAT</span>'; }
                                            else { echo '<span id="Saturdays' . $row[0] . '" class="days Saturday" onclick="change(' . $Saturdayss . ', ' . $Saturday . ', ' . $Saturdays . ');">SAT</span>'; }
                                            
                                            if ($d_sunday != "") { echo '<span style="color : #B5B5B5" id="Sundays' . $row[0] . '" class="days Sunday" onclick="change(' . $Sundayss . ', ' . $Sunday . ', ' . $Sundays . ');">SUN</span>'; }
                                            else { echo '<span id="Sundays' . $row[0] . '" class="days Sunday" onclick="change(' . $Sundayss . ', ' . $Sunday . ', ' . $Sundays . ');">SUN</span>'; }
                                            
                                            echo '
                                                  </div>';
                                            }
                                            else
                                            {
                                            echo '<div class="mb-5" id="customdaysname' . $row[0] . '" style="display: none;">
                                                     <span id="Mondays' . $row[0] . '" class="days Monday" onclick="change(' . $Mondayss . ', ' . $Monday . ', ' . $Mondays . ');">MON</span>
                                                     <span id="Tuesdays' . $row[0] . '" class="days Tuesday" onclick="change(' . $Tuesdayss . ', ' . $Tuesday . ', ' . $Tuesdays . ');">TUE</span>
                                                     <span id="Wednesdays' . $row[0] . '" class="days Wednesday" onclick="change(' . $Wednesdayss . ', ' . $Wednesday . ', ' . $Wednesdays . ');">WED</span>
                                                     <span id="Thursdays' . $row[0] . '" class="days Thursday" onclick="change(' . $Thursdayss . ', ' . $Thursday . ', ' . $Thursdays . ');">THU</span>
                                                     <span id="Fridays' . $row[0] . '" class="days Friday" onclick="change(' . $Fridayss . ',' . $Friday . ', ' . $Fridays . ');">FRI</span>
                                                     <span id="Saturdays' . $row[0] . '" class="days Saturday" onclick="change(' . $Saturdayss . ', ' . $Saturday . ', ' . $Saturdays . ');">SAT</span>
                                                     <span id="Sundays' . $row[0] . '" class="days Sunday" onclick="change(' . $Sundayss . ', ' . $Sunday . ', ' . $Sundays . ');">SUN</span>
                                                  </div>';
                                            }
                                            echo '
                                       </div>
                                    </div>
                                    <div class="row mt-4 d-flex justify-content-around" style="margin: 0px;">
                                       <div class="">
                                          <button class="cancelbtn" data-dismiss="modal" aria-label="Close">CANCLE</button>
                                          <input type="submit" id="updateAd' . $row[0] . '" class="savebtn" value="SAVE" name="updateAd' . $row[0] . '" style="margin-top: 30px;">
                                       </div>
                                    </div>
                                    <div class="row mt -2 mb-2 d-flex justify-content-around">
                                       <input type="hidden" name="adId' . $row[0] . '" value="' . $row[0] . '">
                                       <input type="hidden" name="modal' . $row[0] . '" value="#timeModal' . $row[0] . '">
                                       <input type="hidden" id="Monday' . $row[0] . '" name="Monday' . $row[0] . '" value="">
                                       <input type="hidden" id="Tuesday' . $row[0] . '" name="Tuesday' . $row[0] . '" value="">
                                       <input type="hidden" id="Wednesday' . $row[0] . '" name="Wednesday' . $row[0] . '" value="">
                                       <input type="hidden" id="Thursday' . $row[0] . '" name="Thursday' . $row[0] . '" value="">
                                       <input type="hidden" id="Friday' . $row[0] . '" name="Friday' . $row[0] . '" value="">
                                       <input type="hidden" id="Saturday' . $row[0] . '" name="Saturday' . $row[0] . '" value="">
                                       <input type="hidden" id="Sunday' . $row[0] . '" name="Sunday' . $row[0] . '" value="">
                                       <input type="hidden" name="user' . $row[0] . '" value="' . $row[3] . '">
                                       <input type="hidden" name="name' . $row[0] . '" value="' . $row[2] . '">
                                       <input type="hidden" name="deviceId' . $row[0] . '" value="' .  $row[1] . '">
                                    </div>
                                 </form>
                              </div>
                        </div>
                     </div>
                     <!-- Type Model  End -->
                    <script>
                    
                        // ----- Set Start Date Change Model ----- 
                        var sdate = document.getElementById("sdate' . $row[0] . '").value;
                        var day = sdate.substring(8, 10);
                        var month = sdate.substring(5, 7);
                        var year = sdate.substring(0, 4);
                        var format = day + "." + month + "." + year;
                        document.getElementById("SDateValue' . $row[0] . '").innerHTML = format;
                        
                        // ----- Set End Date Change Model ----- 
                        var edate = document.getElementById("edate' . $row[0] . '").value;
                        var day2 = edate.substring(8, 10);
                        var month2 = edate.substring(5, 7);
                        var year2 = edate.substring(0, 4);
                        var format2 = day2 + "." + month2 + "." + year2;
                        document.getElementById("EDateValue' . $row[0] . '").innerHTML = format2;
        
                        
                        // ----- Set Start Time Change Model ----- 
                        var stime = document.getElementById("stime' . $row[0] . '").value;
                        time = stime.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [stime];
                        if (time.length > 1) { // If time format correct
                            time = time.slice(1); // Remove full string match value
                            time[5] = +time[0] < 12 ? "AM" : "PM"; // Set AM/PM
                            time[0] = +time[0] % 12 || 12; // Adjust hours
                        }
                        var str = time.toString().replaceAll(",", " ");
                        document.getElementById("STimeValue' . $row[0] . '").innerHTML = str;
                        
                        //----- Set End Time Change Model ----------
                        var etime = document.getElementById("etime' . $row[0] . '").value;
                        time2 = etime.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [etime];
                        if (time2.length > 1) { // If time2 format correct
                            time2 = time2.slice(1); // Remove full string match value
                            time2[5] = +time2[0] < 12 ? "AM" : "PM"; // Set AM/PM
                            time2[0] = +time2[0] % 12 || 12; // Adjust hours
                        }
                        var strs = time2.toString().replaceAll(",", " ");
                        document.getElementById("ETimeValue' . $row[0] . '").innerHTML = strs;
                        
                    </script>
                    <script>
                        $(document).ready(function() {
                            $("#signupForm2' . $row[0] . '").submit(function(event) {
                    
                                if ($("input[name=infinite' . $row[0] . ']:checked").val()) {
                                    var infinite1 = $("input[name=infinite' . $row[0] . ']").val()
                                } else {
                                    var infinite1 = "";
                                }
                                if ($("input[name=everyday' . $row[0] . ']:checked").val()) {
                                    var everyday1 = $("input[name=everyday' . $row[0] . ']").val()
                                } else {
                                    var everyday1 = "";
                                }
                                if ($("input[name=customday' . $row[0] . ']:checked").val()) {
                                    var customday1 = $("input[name=customday' . $row[0] . ']").val()
                                } else {
                                    var customday1 = "";
                                }
                    
                                console.log($("input[name=infinite' . $row[0] . ']:checked").val());
                                var formData = {
                                    adId: $("input[name=adId' . $row[0] . ']").val(),
                                    name: $("input[name=name' . $row[0] . ']").val(),
                                    deviceId: $("input[name=deviceId' . $row[0] . ']").val(),
                                    startDate: $("input[name=startDate' . $row[0] . ']").val(),
                                    endDate: $("input[name=endDate' . $row[0] . ']").val(),
                                    infinite: infinite1,
                                    startTime: $("input[name=startTime' . $row[0] . ']").val(),
                                    endTime: $("input[name=endTime' . $row[0] . ']").val(),
                                    everyday: everyday1,
                                    customday: customday1,
                                    username: $("input[name=user' . $row[0] . ']").val(),
                                    Monday: $("input[name=Monday' . $row[0] . ']").val(),
                                    Tuesday: $("input[name=Tuesday' . $row[0] . ']").val(),
                                    Wednesday: $("input[name=Wednesday' . $row[0] . ']").val(),
                                    Thursday: $("input[name=Thursday' . $row[0] . ']").val(),
                                    Friday: $("input[name=Friday' . $row[0] . ']").val(),
                                    Saturday: $("input[name=Saturday' . $row[0] . ']").val(),
                                    Sunday: $("input[name=Sunday' . $row[0] . ']").val()
                                };
                                modal = $("input[name=modal' . $row[0] . ']").val();
                                console.log(formData);
                                $.ajax({
                                    type: "POST",
                                    url: "webApis/updateVideoData.php",
                                    data: formData,
                                    dataType: "json",
                                    encode: true,
                                }).done(function(data) {
                                    if (data["status"] == "ok") {
                                        console.log(data["status"]);
                                        console.log(data["url"]);
                                        $(modal).modal("hide");
                                    } else if (data["status"] == "failed") {
                                        console.log(data["status"]);
                                        alert("Your Ad Timing Or Days is overlapping Existing Ad Settings On This Device. Please Try To Add Unique Time/Date");
                                    }
                                });
                    
                                event.preventDefault();
                            });
                        });
                    </script>
                ';
                

               //  <p class="chooselabel">Name this AD:</p>
               //                            <input type="text" placeholder="' . $row[2] . '" class="adname" name="name">
            }


            if ($type == "show_ads1") {
               $text = "'Are you sure you want to delete this Ad?'";
               echo '<div class="row mb-2">
                        <div class="col-md-9 col-9" style="padding: 0px;">
                        <svg width="57" height="38" viewBox="0 0 57 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <rect width="57" height="38" fill="#E5E5E5"/>
                           <rect width="1440" height="1024" transform="translate(-226 -325)" fill="white"/>
                           <rect x="0.93" y="0.93" width="54.5755" height="35.2686" rx="4.2307" stroke="#051017" stroke-width="1.86"/>
                           <g filter="url(#filter0_d_4_526)">
                           <path d="M38.6664 20.3445C39.2855 19.9517 39.2855 19.0484 38.6664 18.6557L23.5357 9.05617C22.8699 8.63377 22 9.11209 22 9.90056V29.0996C22 29.8881 22.8699 30.3664 23.5357 29.944L38.6664 20.3445Z" fill="#117BC8"/>
                           </g>
                           <defs>
                           <filter id="filter0_d_4_526" x="2" y="-7.10059" width="57.1309" height="61.2021" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                           <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                           <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                           <feOffset dy="4"/>
                           <feGaussianBlur stdDeviation="10"/>
                           <feComposite in2="hardAlpha" operator="out"/>
                           <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.08 0"/>
                           <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_4_526"/>
                           <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_4_526" result="shape"/>
                           </filter>
                           </defs>
                        </svg>
                        <a href="../playAdd.php?c=' . $row[0] . '" class=" ml-2 dsubtext" target="_blank" style="color: #051017;">' . $row[2] . '</a>
                        </div>
                        <div class="col-md-3 col-3 text-right" style="padding: 0px;">
                           <form class="cmxform" id="signupForm" method="POST" action="../webApis/deleteAd.php">
                              <input type="hidden" class="form-text" id="id" name="adId" value="' . $row[0] . '">
                              <input type="hidden" class="form-text" id="id" name="deviceId" value="' . $val2 . '">
                              <input type="hidden" class="form-text" id="userid" name="userid" value="' . $val1 . '">
                              <input type="submit" class="deleteVideobtn" onClick="return confirm(' . $text . ')" value="Delete">
                           </form>
                        </div>
                     </div>';
            }

            if ($type == "show_ads2") {
               echo '<div class="row mb-2">
                        <div class="col-md-9 col-9" style="padding: 0px;"><span class="dsubtext">' . $row[8] . '</span></div>
                        <div class="col-md-3 col-3 text-right" style="padding: 0px;"><span class="dsubtext">' . $val3 . '</span></div>
                     </div>';
            }

            if ($type == "show_ads3") {
               $startDay = date('d',  strtotime($row[5]));
               $startmonth = date('m',   strtotime($row[5]));
               $startDate =  $startDay . '.' . $startmonth . '.';
               $flag = $row['10'];
               if ($flag == 1) {
                  $endDate = "Indefinitely";
               } else {
                  $endDay = date('d',  strtotime($row[6]));
                  $endMonth = date('m',  strtotime($row[6]));
                  $endDate =  $endDay . '.' . $endMonth . '.';
               }
               $data = $this->findadDetail($row[0]);
               $startTime = $data['startTime'];
               $endTime = $data['endTime'];
               $time = $row[14] . ' to ' . $row[15];
               echo '<div class="row mb-2" >
                        <div class="col-md-3" style="padding: 0px;">
                           <span class="dsubtext">From ' . $startDate . ' till ' . $endDate . ' - ' . $time . ' </span>
                              <br><button class="deviceSettingbtn" data-toggle="modal" data-target="#timeModal' . $row[0] . '" style="color: #117BC8">Change</button>
                        </div>
                     </div>';
            }

            //END In CKRF
         }

         //Out of CKRF
         if ($type == "stp_fieldset_getnamereg") {
            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
         }


         // END Out of CKRF
      }
   }





   ///////END Custom Functions


   function getUserInfo($username)
   {
      $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $username))));
      $q = "SELECT * FROM " . TBL_USERS . " WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);

      if (!$result || (mysqli_num_rows($result) < 1)) {
         return NULL;
      }

      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }

   function getUserOnly($username)
   {
      $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $username))));
      $q = "SELECT username FROM " . TBL_USERS . " WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);

      if (!$result || (mysqli_num_rows($result) < 1)) {
         return NULL;
      }

      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }


   function getNumMembers()
   {
      if ($this->num_members < 0) {
         $q = "SELECT * FROM " . TBL_USERS;
         $result = mysqli_query($this->connection, $q);
         $this->num_members = mysqli_num_rows($result);
      }
      return $this->num_members;
   }


   function calcNumActiveUsers()
   {

      $q = "SELECT * FROM " . TBL_ACTIVE_USERS;
      $result = mysqli_query($this->connection, $q);
      $this->num_active_users = mysqli_num_rows($result);
   }

   function calcNumActiveGuests()
   {

      $q = "SELECT * FROM " . TBL_ACTIVE_GUESTS;
      $result = mysqli_query($this->connection, $q);
      $this->num_active_guests = mysqli_num_rows($result);
   }

   function addActiveUser($username, $time)
   {
      $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $username))));
      $time = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $time))));
      $q = "UPDATE " . TBL_USERS . " SET timestamp = '$time' WHERE username = '$username'";
      mysqli_query($this->connection, $q);

      if (!TRACK_VISITORS) return;
      $q = "REPLACE INTO " . TBL_ACTIVE_USERS . " VALUES ('$username', '$time')";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveUsers();
   }


   function addActiveGuest($ip, $time)
   {
      $ip = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $ip))));
      $time = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $time))));
      if (!TRACK_VISITORS) return;
      $q = "REPLACE INTO " . TBL_ACTIVE_GUESTS . " VALUES ('$ip', '$time')";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveGuests();
   }


   function removeActiveUser($username)
   {
      $username = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $username))));
      if (!TRACK_VISITORS) return;
      $q = "DELETE FROM " . TBL_ACTIVE_USERS . " WHERE username = '$username'";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveUsers();
   }


   function removeActiveGuest($ip)
   {
      $ip = str_replace('&lt;', "~", str_replace('<', "~&gt;", strip_tags(mysqli_real_escape_string($this->connection, $ip))));
      if (!TRACK_VISITORS) return;
      $q = "DELETE FROM " . TBL_ACTIVE_GUESTS . " WHERE ip = '$ip'";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveGuests();
   }


   function removeInactiveUsers()
   {
      if (!TRACK_VISITORS) return;
      $timeout = time() - USER_TIMEOUT * 60;
      $q = "DELETE FROM " . TBL_ACTIVE_USERS . " WHERE timestamp < $timeout";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveUsers();
   }


   function removeInactiveGuests()
   {
      if (!TRACK_VISITORS) return;
      $timeout = time() - GUEST_TIMEOUT * 60;
      $q = "DELETE FROM " . TBL_ACTIVE_GUESTS . " WHERE timestamp < $timeout";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveGuests();
   }


   function query($query)
   {
      return mysqli_query($this->connection, $query);
   }
};


$database = new MySQLDB;
