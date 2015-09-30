<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Content.php");
$ContentObj = new Content();
$CoverDetail = $ContentObj->GetCoverDetail(intval($_GET['modelId']));
	if($_GET['RemoveModel'] == 'Yes')
	{
	$ContentObj->DeleteModel(intval($_GET['ModelId']));
	}
	if($_GET['RemoveInnerModel'] == 'Yes')
	{
	$ContentObj->DeleteInnerModel($_GET['Id'],$_GET['ModelInnerId']);
	}
	if($_GET['UpdateCoverPhoto'] == 'Yes'){
	$obj->query("UPDATE tbl_model_pics SET model_image_name='$CoverDetail->cover_image_name' WHERE id=".$_GET['Id']." AND model_id=".$_GET['modelId']);
	
	$ContentObj->UpdateCoverPhoto(intval($_GET['modelId']),$_GET['CoverPhotoName']);
	}
?>