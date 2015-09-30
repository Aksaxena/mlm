<?php 
class Member extends DB
{
	var $commonObjContent;
	function __construct(){
		$this->commonObjContent=new Common();
		parent:: __construct(DB_NAME,DB_HOST,DB_USERNAME,DB_PASSWORD);
		
	}
	function updatePackage($params)
	{
	
	$this->query("update ".TBL_PREFIX."_packages set package_name='".$this->commonObjContent->praseData($params['package_name'])."',package_point='".$this->commonObjContent->praseData($params['package_point'])."',package_capping='".$this->commonObjContent->praseData($params['package_capping'])."',package_rp='".$this->commonObjContent->praseData($params['package_rp'])."',package_updated=NOW() where pid = '".intval($params['pid'])."'");
	$this->commonObjContent->pushMessage("Package updated successfully.");
	$this->commonObjContent->wtRedirect("package.php");
	}
	function AddPackage($params){
	$this->query("INSERT INTO ".TBL_PREFIX."_packages set package_name='".$this->commonObjContent->praseData($params['package_name'])."',package_point='".$this->commonObjContent->praseData($params['package_point'])."',package_capping='".$this->commonObjContent->praseData($params['package_capping'])."',package_rp='".$this->commonObjContent->praseData($params['package_rp'])."'");
	$this->commonObjContent->pushMessage("Package added successfully.");
	$this->commonObjContent->wtRedirect("package.php");
	}
	
	function GenerateToken($id,$token){
		$this->query("INSERT INTO ".TBL_PREFIX."_tokens set pid='".$this->commonObjContent->praseData($id)."',token='".$this->commonObjContent->praseData($token)."'");	
	}
	function statusRemove($id){
	$q=$this->query("update ".TBL_PREFIX."_packages set package_status = 2, package_updated = NOW()  where pid=$id");
	$this->commonObjContent->pushMessage("Package has been removed successfully.");
	$this->commonObjContent->wtRedirect("package.php");	
	}
	function getPackage($id){
		$q=$this->query("select * from ".TBL_PREFIX."_packages where pid=$id");
		$qr=$this->fetchNextObject($q);
		return $qr;
	}
	
	function fetchMemberCode(){
		$q = $this->query("SELECT code from ".TBL_PREFIX."_members where 1=1");
		$Arr = array();
		while($line = $this->fetchNextObject($q)){
			$Arr[] = $line->code; 
		}
		return $Arr;
	}
	
	function fetchToken($id){
	$q=$this->query("select * from ".TBL_PREFIX."_tokens where pid = ".intval($id));
	return $q;
	}
	
	
}
?>