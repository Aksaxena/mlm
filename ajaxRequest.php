<?php session_start();
require_once("lib/config.inc.php");
require_once("lib/classes/User.php");
require_once("lib/encryption.inc.php");
$userObj = new User();

if(isset($_POST["search_keyword"])) {
$user_pin = $commonObj->praseData($_POST["search_keyword"]);
$user = $userObj->getUserByPin($user_pin);
if($user){
	echo ucfirst($user->username);
	}	
}
?>
