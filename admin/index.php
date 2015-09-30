<?php
session_start();
require_once("../lib/config.inc.php");
if(isset($_SESSION["USERNAME"])) {
	$commonObj->wtRedirect("admin-home.php");
} else {
	$commonObj->wtRedirect("login.php");
}
?>