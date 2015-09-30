<?php 
class Content extends DB
{
	var $commonObjContent;
	function __construct(){
		$this->commonObjContent=new Common();
		parent:: __construct(DB_NAME,DB_HOST,DB_USERNAME,DB_PASSWORD);
		
	}
	function updateContent($id,$title,$content)
	{
	$this->query("update ".TBL_PREFIX."_content set title='$title',description='$content' where id=$id");
	$this->commonObjContent->pushMessage("Content updated successfully.");
	$this->commonObjContent->wtRedirect("content_list.php");
	}
	function InsertContent($title,$content){
	$this->query("INSERT INTO ".TBL_PREFIX."_content set title='$title',description='$content',status=1,add_date=CURDATE()");
	$this->commonObjContent->pushMessage("Content added successfully.");
	$this->commonObjContent->wtRedirect("content_list.php");
	}
	
	function GetAllContent(){
	$q=$this->query("select * from tbl_content where 1=1 order by id desc");
	return $q;
	}
	function getContent($id){
		$q=$this->query("select * from tbl_content where id=$id");
		$qr=$this->fetchNextObject($q);
		return $qr;
	}
	
	function AllModels(){
	$q=$this->query("select * from tbl_model_cover_photo where 1=1");
	return $q;
	}
	function GetModelInnerDetail($id,$mid){
	$q=$this->query("select * from tbl_model_pics where model_id='$mid' AND id='$id'");
	return $this->fetchNextObject($q);;
	}
	function GetModelInnerImage($mid){
	$q=$this->query("select * from tbl_model_pics where model_id='$mid' AND status=1");
	return $q;
	}
	function GetModelDetail($id){
	$q=$this->query("SELECT * FROM tbl_model where id='$id'");
	$qr = $this->fetchNextObject($q);
	return $qr;
	}
	function GetModelCover($id){
	$q=$this->query("SELECT * FROM tbl_model_cover_photo where model_id='$id'");
	$qr = $this->fetchNextObject($q);
	return $qr;
	}
	 function GetInnerDetail($mid){
	 $q=$this->query("SELECT * FROM tbl_model_pics where model_id='$mid'");
	 return $q;
	 }
	function DeleteModel($ModelId){		
	$q = $this->query("SELECT tbl_model.*,tbl_model_pics.* FROM tbl_model LEFT JOIN tbl_model_pics ON tbl_model.id = tbl_model_pics.model_id where tbl_model.id = '$ModelId'");
		/*while($line = $this->fetchNextObject($q)){ 
		unlink("../uploaded_images/".stripslashes($line->model_image_name));
		unlink("../uploaded_images/".stripslashes($line->model_master_image));
		unlink("../uploaded_images/thumb/".stripslashes($line->model_master_image));
		}*/
		$this->query("DELETE FROM tbl_model WHERE id='$ModelId'");
		$this->query("DELETE FROM tbl_model_cover_photo WHERE model_id='$ModelId'");
		$this->query("DELETE FROM tbl_model_pics WHERE model_id='$ModelId'");
		
		$this->commonObjContent->pushMessage("Model has been removed successfully.");
		$this->commonObjContent->wtRedirect("models.php");
		}
		function DeleteInnerModel($Id,$ModelId){

		$q = $this->query("DELETE FROM tbl_model_pics WHERE id='$Id'");
		$this->commonObjContent->pushMessage("Model Image has been removed successfully.");
		$this->commonObjContent->wtRedirect("Gallery.php?mid=$ModelId");
		}
		
		function GetCoverDetail($mid){
		$q=$this->query("SELECT * FROM tbl_model_cover_photo where model_id='$mid'");
		$qr = $this->fetchNextObject($q);
	 	return $qr;
		}
		function UpdateCoverPhoto($modelid,$InnerImageName){
		$q=$this->query("UPDATE tbl_model_cover_photo SET cover_image_name='$InnerImageName' WHERE model_id='$modelid'");
		$this->commonObjContent->pushMessage("Cover photo has been changed successfully.");
		$this->commonObjContent->wtRedirect("Gallery.php?mid=$modelid");
		}	
}
?>