<?php
define('UPLOAD_PATH', '../videos/');
$video = time() . '.mp4';
$filetmpname = $_FILES['file']['tmp_name'];
move_uploaded_file($filetmpname, UPLOAD_PATH . $_POST['video']);
// echo $video;
echo $_POST['video'];
