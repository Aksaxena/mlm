<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/classes/Common.php");
$CommonObj = new Common();
$num = count($_POST['modelInnerImage']);
if(isset($_POST['submitForm'])){
$ActionName = $_POST['actionname'];
if($num > 0){
$ids = implode(',',$_POST['modelInnerImage']);
$ids = explode(',',$ids);


	if($ActionName == 'Active'){
		foreach($ids as $modelId){
		$obj->query("UPDATE tbl_model_pics SET status=1 WHERE id='$modelId'");
		}
	}
	if($ActionName == 'Inactive'){
	foreach($ids as $modelId){
		$obj->query("UPDATE tbl_model_pics SET status=0 WHERE id='$modelId'");
		}
	}
	$CommonObj->pushMessage("Selected items has been ".$ActionName." successfully.");
	$CommonObj->wtRedirect("Gallery.php?mid=".$_POST['modelId']);
 } else {
 	$CommonObj->pushMessage("Please select items.");
	$CommonObj->wtRedirect("Gallery.php?mid=".$_POST['modelId']);
 }
}
?>