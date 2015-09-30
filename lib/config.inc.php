<?php
ini_set('max_execution_time', 0); 
$mode = "local";

if($mode == "local") {
	define('DB_HOST',"localhost");
	define('DB_USERNAME',"root");
	define('DB_PASSWORD',"");
	define('DB_NAME',"securema_mlm_web_db");
	define('TBL_PREFIX',"tbl");
	define('SITE_TITLE',"MLM PROJECT");
	define('SITE_ADMIN_TITLE',"MLM PROJECT - Admin Panel");
	define('SITE_URL',"http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/');
	define('SITE_URL_DISPLAY',"http://localhost/mlmproject/");
	define('SITE_URL_ADMIN',"http://localhost/mlmproject/admin/");
} if($mode == "production") {
	define('DB_HOST',"localhost");
	define('DB_USERNAME',"securema_mlmuser");
	define('DB_PASSWORD',"mlm@9577");
	define('DB_NAME',"securema_mlm_web_db");
	define('TBL_PREFIX',"tbl");
	define('SITE_TITLE',"MLM PROJECT");
	define('SITE_ADMIN_TITLE',"MLM PROJECT - Admin Panel");
	define('SITE_URL',"http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/');
	define('SITE_URL_DISPLAY',"http://localhost/mlmproject/");
	define('SITE_URL_ADMIN',"http://localhost/mlmproject/admin/");
}
require_once("classes/Common.php");
require_once("encryption.inc.php");
$encryObj = new Encryption();
$commonObj = new Common();
require_once("db.class.php");
$obj = new DB(DB_NAME, DB_HOST, DB_USERNAME, DB_PASSWORD);
//require_once("custom_functions.inc.php");
?>