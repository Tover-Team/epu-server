<?php
$api->setMessage("D");
$user_info = file_get_contents('http://toversystems.codns.com/teps/api/user/user.php');
$user_info = json_decode($user_info, true);
$api->setEntity(array("user_info" => $user_info));
?>