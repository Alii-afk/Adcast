<?php

include("database.php");
include("mailer.php");
include("form.php");

class Session
{
   var $username;
   var $userid;
   var $userlevel;
   var $time;
   var $logged_in;
   var $userinfo = array();
   var $url;
   var $referrer;

   function __construct()
   {
      $this->time = time();
      $this->startSession();
   }


   function startSession()
   {
      global $database;
      session_start();


      $this->logged_in = $this->checkLogin();


      if (!$this->logged_in) {
         $this->username = $_SESSION['username'] = GUEST_NAME;
         $this->userlevel = GUEST_LEVEL;
         $database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
      } else {
         $database->addActiveUser($this->username, $this->time);
      }


      $database->removeInactiveUsers();
      $database->removeInactiveGuests();


      if (isset($_SESSION['url'])) {
         $this->referrer = $_SESSION['url'];
      } else {
         $this->referrer = "/";
      }


      $this->url = $_SESSION['url'] = $_SERVER['PHP_SELF'];
   }


   function checkLogin()
   {
      global $database;
      if (isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])) {
         $this->username = $_SESSION['username'] = $_COOKIE['cookname'];
         $this->userid   = $_SESSION['userid']   = $_COOKIE['cookid'];
      }


      if (
         isset($_SESSION['username']) && isset($_SESSION['userid']) &&
         $_SESSION['username'] != GUEST_NAME
      ) {

         if ($database->confirmUserID($_SESSION['username'], $_SESSION['userid']) != 0) {

            unset($_SESSION['username']);
            unset($_SESSION['userid']);
            return false;
         }


         $this->userinfo  = $database->getUserInfo($_SESSION['username']);
         $this->username  = $this->userinfo['username'];
         $this->userid    = $this->userinfo['userid'];
         $this->userlevel = $this->userinfo['userlevel'];
         return true;
      } else {
         return false;
      }
   }

   function userLogin($email, $password, $CSRF_Code)
   {
      global $database, $form;

      $jumo2 = md5($_SESSION['CSRF_Code'] . '8j5j&*&K5jrffgF9wAJDIH' . 'JKHds998954(*)(*dfkjll');

      $field = "CSRF_Code";
      if ($CSRF_Code != $jumo2) {
         $form->setError($field, "Network error. please try again.");
      }
      
      $field = "email";
      if (!$email) {
         $form->setError($field, "Email not entered");
      }

      $field = "password";
      if (!$password) {
         $form->setError($field, "Password not entered");
      }
      if ($form->num_errors > 0) {
         return 1;
      }

      $email = stripslashes($email);
      $result = $database->confirmUserPass($email, md5($password));

      if ($result == 1) {
         $field = "email";
         $form->setError($field, "Email not found");
         return 1;
      } else if ($result == 2) {
         $field = "password";
         $form->setError($field, "Invalid password");
         return 1;
      }

      if ($form->num_errors > 0) {
         return 1;
      }

      $this->userinfo  = $database->getUserInfo($email);
      $this->username  = $_SESSION['username'] = $this->userinfo['username'];
      $this->userid    = $_SESSION['userid']   = $this->generateRandID();
      $this->userlevel = $this->userinfo['userlevel'];

      $database->updateUserField($this->username, "userid", $this->userid);
      $database->addActiveUser($this->username, $this->time);
      $database->removeActiveGuest($_SERVER['REMOTE_ADDR']);

      setcookie("cookname", $this->username, time() + COOKIE_EXPIRE, COOKIE_PATH);
      setcookie("cookid",   $this->userid,   time() + COOKIE_EXPIRE, COOKIE_PATH);


      return 0;
   }


   function logout()
   {
      global $database;
      if (isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])) {
         setcookie("cookname", "", time() - COOKIE_EXPIRE, COOKIE_PATH);
         setcookie("cookid",   "", time() - COOKIE_EXPIRE, COOKIE_PATH);
      }


      unset($_SESSION['username']);
      unset($_SESSION['userid']);


      $this->logged_in = false;


      $database->removeActiveUser($this->username);
      $database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);


      $this->username  = GUEST_NAME;
      $this->userlevel = GUEST_LEVEL;
   }

   ////////// Start Custom Functions

   function register($name, $email, $password, $confirmPassword, $privacy)
   {
      global $database, $form, $mailer;

      $jumo2 = md5($_SESSION['CSRF_Code'] . '8j5j&*&K5jrffgF9wAJDIH' . 'JKHds998954(*)(*dfkjll');

      $field = "name";
      if (!$name) {
         $form->setError($field, "Name Not Entered");
      }

      $field = "password";
      if (!$password) {
         $form->setError($field, "Password Not Entered");
      }
      
      $field = "password";
      if ($password != $confirmPassword) {
         $form->setError($field, "Confirm Password Mismatch");
      }
      
      $field = "password";
      if ($privacy == null) {
         $form->setError($field, "Please Take A Note On Privacy Policy.");
      }

      $field = "email";
      if (!$email || strlen($email = trim($email)) == 0) {
         $form->setError($field, "Email Not Entered");
      } else {

         $regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
            . "@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
            . "\.([a-z]{2,}){1}$/";
         if (!preg_match($regex, $email)) {
            $form->setError($field, "Invalid Email ");
         }
         $email = stripslashes($email);
      }
      
      $result = $database->findUser($email);
      $email_2 = $result['username'];
      $field = "email";
      if($email_2 != null)
      {
        if ($email == $email_2) {
          $form->setError($field, "Account Already Exist On This Email"); 
      }  
      }
      
      if ($form->num_errors > 0) {
         return 1;
      } else {
         if ($database->addNewUser($name, $email, md5($password), $privacy)) {

            return 0;
         } else {
            return 2;
         }
      }
   }

   function registerProfile($businessName, $businessIndustry, $businessType, $workingHours, $timezone, $username, $CSRF_Code)
   {

      global $database, $form, $mailer;

      $jumo2 = md5($_SESSION['CSRF_Code'] . '8j5j&*&K5jrffgF9wAJDIH' . 'JKHds998954(*)(*dfkjll');

      $field = "CSRF_Code";
      if ($CSRF_Code != $jumo2) {
         $form->setError($field, "<br>Network error. please try again." . $CSRF_Code . "<br>" . $jumo2);
      }

      $username_check = $this->username;

      $field = "username";
      if (!$username) {
         $form->setError($field, "User Not Found");
      }

      $field = "username";
      if ($username_check != $username) {
         $form->setError($field, "User Authentication Mismatch");
      }

      $result_2 = $database->findUser($username);
      $id = $result_2['id'];

      $field = "businessName";
      if (!$businessName) {
         $form->setError($field, "Add Your Buisness Name Please.");
      }

      $field = "businessIndustry";
      if (!$businessIndustry) {
         $form->setError($field, "Buisness Industry Type Not Selected");
      }
      $field = "businessType";
      if (!$businessType) {
         $form->setError($field, "Buisness Type Not Selected");
      }
      $field = "workingHours";
      if (!$workingHours) {
         $form->setError($field, "Working Hours Not Selected");
      }
      $field = "timezone";
      if (!$timezone) {
         $form->setError($field, "Select Your Time Zone Please.");
      }

      if ($form->num_errors > 0) {
         return 1;
      } else {
         if ($database->registerProfile($businessName, $businessIndustry, $businessType, $workingHours, $timezone, $id)) {
            return 0;
         } else {
            return 2;
         }
      }
   }

   function registerDevice($deviceName, $deviceType, $deviceOrientation, $username, $CSRF_Code)
   {

      global $database, $form, $mailer;

      $jumo2 = md5($_SESSION['CSRF_Code'] . '8j5j&*&K5jrffgF9wAJDIH' . 'JKHds998954(*)(*dfkjll');

      $field = "CSRF_Code";
      if ($CSRF_Code != $jumo2) {
         $form->setError($field, "<br>Network error. please try again." . $CSRF_Code . "<br>" . $jumo2);
      }

      $username_check = $this->username;

      $field = "username";
      if (!$username) {
         $form->setError($field, "* username Name not entered");
      }

      $result_2 = $database->findUser($username);
      $id = $result_2['id'];

      $field = "username";
      if ($username_check != $username) {
         $form->setError($field, "* username mismatch");
      }

      $field = "deviceName";
      if (!$deviceName) {
         $form->setError($field, "* device Name not entered");
      }

      $field = "deviceType";
      if (!$deviceType) {
         $form->setError($field, "* device Type not entered");
      }

      $field = "deviceOrientation";
      if (!$deviceOrientation) {
         $form->setError($field, "* device Orientation not entered");
      }

      if ($form->num_errors > 0) {
         return 1;
      } else {
         if ($database->registerDevice($deviceName, $deviceType, $deviceOrientation, $id)) {
            return 0;
         } else {
            return 2;
         }
      }
   }

   function uploadAdDevice($adFile, $name, $deviceId, $status,  $startDate, $endDate, $infinite, $startTime, $endTime, $everyday, $customday, $username, $CSRF_Code, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $filesize)
   {

      global $database, $form, $mailer;

      $jumo2 = md5($_SESSION['CSRF_Code'] . '8j5j&*&K5jrffgF9wAJDIH' . 'JKHds998954(*)(*dfkjll');

      $field = "CSRF_Code";
      if ($CSRF_Code != $jumo2) {
         $form->setError($field, "<br>Network error. please try again." . $CSRF_Code . "<br>" . $jumo2);
      }

      $username_check = $this->username;

      $field = "username";
      if (!$username) {
         $form->setError($field, "* username Name not entered");
      }

      $field = "username";
      if ($username_check != $username) {
         $form->setError($field, "* username mismatch");
      }

      $result_2 = $database->findUser($username);
      $id = $result_2['id'];

      $field = "startDate";
      if (!$startDate) {
         $form->setError($field, "* start Date not entered");
      }

      if ($infinite == "") {
         $field = "endDate";
         if (!$endDate) {
            $form->setError($field, "* end Date not entered");
         }

         $field = "endDate";
         if ($endDate < $startDate) {
            $form->setError($field, "* End Date Less Than Start Date");
         }
      }

      if ($customday != "") {
         $field = "customday";
         if (($monday == "") && ($tuesday == "") && ($wednesday == "") && ($thursday == "") && ($friday == "") && ($saturday == "") && ($sunday == "")) {
            $form->setError($field, "* Must Select 1 Day");
         }
      }
      if ($everyday != "") {
         $customday = "";
         $monday = "";
         $tuesday = "";
         $wednesday = "";
         $thursday = "";
         $friday = "";
         $saturday = "";
         $sunday = "";
      }
      // $field = "everyday";
      // $form->setError($field, "* device Id not entered" . $everyday);

      $field = "deviceId";
      if (!$deviceId) {
         $form->setError($field, "* device Id not entered" . $deviceId);
      }

      $field = "startTime";
      if (!$startTime) {
         $form->setError($field, "* start Time not entered");
      }

      $field = "endTime";
      if (!$endTime) {
         $form->setError($field, "* end Time not entered");
      }

      $field = "endTime";
      if ($startTime > $endTime) {
         $form->setError($field, "* End Time Less Than Start Time");
      }

      if ($form->num_errors > 0) {
         return "formError";
      } else {

         if ($infinite == "infinite") {
            $flag = 1;
         } else {
            $flag = 0;
         }

         $result = $database->uploadAdDevice($adFile, $name, $deviceId, $status, $startDate, $endDate, $flag, $startTime, $endTime, $id, $everyday, $customday, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $filesize);
         if ($result == "failed") {
            return "failed";
         } else {
            return $result;
         }
      }
   }


   function updateAdDevice($adId, $name,  $deviceId,  $startDate, $endDate, $infinite, $startTime, $endTime, $everyday, $customday, $username, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday)
   {

      global $database, $form, $mailer;

      $jumo2 = md5($_SESSION['CSRF_Code'] . '8j5j&*&K5jrffgF9wAJDIH' . 'JKHds998954(*)(*dfkjll');

      $username_check = $this->username;

      $field = "username";
      if (!$username) {
         $form->setError($field, "* username Name not entered");
      }

      $field = "username";
      if ($username_check != $username) {
         $form->setError($field, "* username mismatch");
      }

      $result_2 = $database->findUser($username);
      $id = $result_2['id'];

      $field = "startDate";
      if (!$startDate) {
         $form->setError($field, "* start Date not entered");
      }

      if ($infinite == "") {
         $field = "endDate";
         if (!$endDate) {
            $form->setError($field, "* end Date not entered");
         }

         $field = "endDate";
         if ($endDate < $startDate) {
            $form->setError($field, "* End Date Less Than Start Date");
         }
      }

      if ($customday != "") {
         $field = "customday";
         if (($monday == "") && ($tuesday == "") && ($wednesday == "") && ($thursday == "") && ($friday == "") && ($saturday == "") && ($sunday == "")) {
            $form->setError($field, "* Must Select 1 Day");
         }
      }
      if ($everyday != "") {
         $customday = "";
         $monday = "";
         $tuesday = "";
         $wednesday = "";
         $thursday = "";
         $friday = "";
         $saturday = "";
         $sunday = "";
      }
      // $field = "everyday";
      // $form->setError($field, "* device Id not entered" . $everyday);

      $field = "deviceId";
      if (!$deviceId) {
         $form->setError($field, "* device Id not entered" . $deviceId);
      }

      $field = "startTime";
      if (!$startTime) {
         $form->setError($field, "* start Time not entered");
      }

      $field = "endTime";
      if (!$endTime) {
         $form->setError($field, "* end Time not entered");
      }

      $field = "endTime";
      if ($startTime > $endTime) {
         $form->setError($field, "* End Time Less Than Start Time");
      }

      if ($form->num_errors > 0) {
         return "formError";
      } else {

         if ($infinite == "infinite") {
            $flag = 1;
         } else {
            $flag = 0;
         }

         $result = $database->updateAdDevice($adId, $name,  $deviceId, $startDate, $endDate, $flag, $startTime, $endTime, $id, $everyday, $customday, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);
         return $result;
      }
   }



   function editAccount($subcurpass, $subnewpass, $subemail)
   {
      global $database, $form;

      $jumo2 = md5($_SESSION['CSRF_Code'] . '8j5j&*&K5jrffgF9wAJDIH' . 'JKHds998954(*)(*dfkjll');

      if ($subnewpass) {

         $field = "curpass";
         if (!$subcurpass) {
            $form->setError($field, "* Current Password not entered");
         } else {

            $subcurpass = stripslashes($subcurpass);
            if (
               strlen($subcurpass) < 4 ||
               !preg_match("/^([0-9a-z])+$/", ($subcurpass = trim($subcurpass)))
            ) {
               $form->setError($field, "* Current Password incorrect");
            }

            if ($database->confirmUserPass($this->username, md5($subcurpass)) != 0) {
               $form->setError($field, "* Current Password incorrect");
            }
         }


         $field = "newpass";

         $subpass = stripslashes($subnewpass);
         if (strlen($subnewpass) < 4) {
            $form->setError($field, "* New Password too short");
         } else if (!preg_match("/^([0-9a-z])+$/", ($subnewpass = trim($subnewpass)))) {
            $form->setError($field, "* New Password not alphanumeric");
         }
      } else if ($subcurpass) {

         $field = "newpass";
         $form->setError($field, "* New Password not entered");
      }


      $field = "email";
      if ($subemail && strlen($subemail = trim($subemail)) > 0) {

         $regex = "/^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
            . "@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
            . "\.([a-z]{2,}){1}$/";
         if (!preg_match($regex, $subemail)) {
            $form->setError($field, "* Email invalid");
         }
         $subemail = stripslashes($subemail);
      }


      if ($form->num_errors > 0) {
         return false;
      }


      if ($subcurpass && $subnewpass) {
         $database->updateUserField($this->username, "password", md5($subnewpass));
      }


      if ($subemail) {
         $database->updateUserField($this->username, "email", $subemail);
      }


      return true;
   }











   ////////////////////////// END Custom Functions

   function isAdmin()
   {
      return ($this->userlevel == ADMIN_LEVEL ||
         $this->username  == ADMIN_NAME);
   }

   function isMaster()
   {
      return ($this->userlevel == MASTER_LEVEL);
   }

   function isAgent()
   {
      return ($this->userlevel == AGENT_LEVEL);
   }

   function isMember()
   {
      return ($this->userlevel == AGENT_MEMBER_LEVEL);
   }



   function generateRandID()
   {
      return md5($this->generateRandStr(16));
   }


   function generateRandStr($length)
   {
      $randstr = "";
      for ($i = 0; $i < $length; $i++) {
         $randnum = mt_rand(0, 61);
         if ($randnum < 10) {
            $randstr .= chr($randnum + 48);
         } else if ($randnum < 36) {
            $randstr .= chr($randnum + 55);
         } else {
            $randstr .= chr($randnum + 61);
         }
      }
      return $randstr;
   }
};



$session = new Session;


$form = new Form;
