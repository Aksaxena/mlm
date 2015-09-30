<?php session_start();
require_once("lib/config.inc.php");
require_once("lib/classes/User.php");
$userObj = new User();
$userObj->logout();
?>