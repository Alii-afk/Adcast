<?php

include("include/classes/session.php");

class Process
{

   function __construct()
   {
      global $session;

      if (isset($_POST['login'])) {
         $this->userLogin();
      } else if (isset($_POST['register'])) {
         $this->procRegister();
      } else if (isset($_POST['registerProfile'])) {
         $this->registerProfile();
      } else if (isset($_POST['addDevice'])) {
         $this->registerDevice();
      } else if (isset($_POST['uploadAd'])) {
         $this->uploadAdDevice();
      } else if (isset($_POST['subedit'])) {
         $this->procEditAccount();
      } else if ($session->logged_in) {
         $this->procLogout();
      } else {
         header("Location: login.php");
      }
   }

   function userLogin()
   {
      global $session, $form;
      $retval = $session->userLogin($_POST['email'], $_POST['password'], $_POST['CSRF_Code']);

      if ($retval == 0) {
         header("Location: index.php?SuccessfullyLoggedIn");
      } else if ($retval == 1) {
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: login.php?FormError");
      } else {
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: login.php?DbError");
      }
   }

   function procLogout()
   {
      global $session;
      $retval = $session->logout();
      header("Location: login.php");
   }


   function procRegister()
   {
      global $session, $form;

      $retval = $session->register($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirmPassword'], $_POST['privacy']);
      if ($retval == 0) {
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = true;
         header("Location: login.php?SuccessfullyRegistered");
      } else if ($retval == 1) {
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: register.php?FormError");
      } else if ($retval == 2) {
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = false;
         header("Location: register.php?DBError");
      }
   }

   function registerProfile()
   {
      global $session, $form, $database;
      $username = $session->username;
      $re = $database->findUser($username);
      $id = $re['id'];
      $retval = $session->registerProfile($_POST['businessName'], $_POST['businessIndustry'], $_POST['businessType'], $_POST['workingHours'], $_POST['timezone'], $username, $_POST['CSRF_Code']);

      $result = $database->findDevice($id);
      if ($result) {
         $url = "index.php";
      } else {
         $url = "addDevice.php";
      }

      if ($retval == 0) {
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = true;
         header("Location: " . $url . "?ProfileAdded");
      } else if ($retval == 1) {
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: addProfile.php?FormError");
      } else if ($retval == 2) {
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = false;
         header("Location: addProfile.php?DBError");
      }
   }


   function uploadAdDevice()
   {

      global $session, $form;
      $username = $session->username;
      define('UPLOAD_PATH', 'videos/');
      $time = time();
      $rand = rand();
      $filechecking = basename(strtolower($_FILES['adFile']['name']));
      $ext = substr($filechecking, strrpos($filechecking, '.') + 1);
      if ($ext != "") {
         if ($ext == "mp4") {
            $filetmpname = $_FILES['adFile']['tmp_name'];
            $video = $time . $rand . $_POST['deviceId'] . '.mp4';
         }
      }
      $video = $_POST['adFile'];
      $retval = $session->uploadAdDevice($video, $_POST['deviceName'], $_POST['deviceId'], $_POST['status'], $_POST['startDate'], $_POST['endDate'], $_POST['infinite'], $_POST['startTime'], $_POST['endTime'], $_POST['everyday'], $_POST['customday'], $username, $_POST['CSRF_Code'], $_POST['Monday'], $_POST['Tuesday'], $_POST['Wednesday'], $_POST['Thursday'], $_POST['Friday'], $_POST['Saturday'], $_POST['Sunday']);
      if ($retval == 10) {
         move_uploaded_file($filetmpname, UPLOAD_PATH . $video);
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = true;
         header("Location: deviceView.php?id=" . $_POST['deviceId'] . "&&Success");
      } else if ($retval == 1) {
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: uploadNewAd.php?id=" . $_POST['deviceId'] . "&&FormError" . " /n/" . $_POST['name'] . " /di/" . $_POST['deviceId'] . " //" . $_POST['status'] . " /sd/" . $_POST['startDate'] . " /ed/" . $_POST['endDate'] . " //" . $_POST['infinite'] . " /st/" . $_POST['startTime'] . " /et/" . $_POST['endTime'] . " /d/" . $_POST['everyday'] . " /cd/" . $_POST['customday'] . " /usr/" . $username . " /csr/" . $_POST['CSRF_Code']);
      } else if ($retval == 12) {
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = false;
         header("Location: uploadNewAd.php?id=" . $_POST['deviceId'] . "&&DBError");
      }
   }

   function registerDevice()
   {
      global $session, $form;
      $username = $session->username;
      $retval = $session->registerDevice($_POST['deviceName'], $_POST['deviceType'], $_POST['deviceOrientation'], $username, $_POST['CSRF_Code']);
      if ($retval == 0) {
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = true;
         header("Location: index.php?DeviceAdded");
      } else if ($retval == 1) {
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: addDevice.php?FormError");
      } else if ($retval == 2) {
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = false;
         header("Location: addDevice.php?DBError");
      }
   }



   function procEditAccount()
   {
      global $session, $form;

      $retval = $session->editAccount($_POST['curpass'], $_POST['newpass'], $_POST['email']);


      if ($retval) {
         $_SESSION['useredit'] = true;
         header("Location: " . $session->referrer);
      } else {
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         header("Location: " . $session->referrer);
      }
   }
};


$process = new Process;
