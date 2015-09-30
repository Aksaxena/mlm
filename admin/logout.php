<?php
session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
$adminObj=new Admin();
$adminObj->logout();
?>