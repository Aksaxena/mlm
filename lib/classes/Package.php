<?php 
class Package extends DB
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
	
	function fetchAll(){
	$q=$this->query("select * from ".TBL_PREFIX."_packages where package_status != 2");
	return $q;
	}
	
	function assignPinToUser($params){
		$q = $this->query("SELECT * from ".TBL_PREFIX."_tokens WHERE pid = ".intval($params['package'])." AND status=1");		
		$rows = $this->numRows($q);
		if( $rows >= $params['no_of_pin']){
			$qr = $this->query("SELECT * from ".TBL_PREFIX."_tokens WHERE pid = ".intval($params['package'])." AND status=1 LIMIT 0,".intval($params['no_of_pin']));
			while($line = $this->fetchNextObject($qr)){
				$this->query("UPDATE ".TBL_PREFIX."_tokens SET assign_to_user =".intval($params['uid']).",status = 2 WHERE token = '".$line->token."'");
			}
			$this->commonObjContent->pushMessage("Pin assign to user successfully.");
			$this->commonObjContent->wtRedirect("user-assign-pin-list.php?uid=".intval($params['uid']));
		}else{
			$this->commonObjContent->pushError($params['no_of_pin']." pin(s) are not available in selected packages.");
		}
	}
	function fetchAllToken($id){
		$q=$this->query("select * from ".TBL_PREFIX."_tokens where pid = ".intval($id));
		return $q;
	}	
	function fetchToken($params){
	$sortby = 'ASC';
	$col = 'pid';
	$searchQ = '';
	if (isset($params['searchQry'])) {  
  		$searchQ = " AND token LIKE '%".$params['searchQry']."%'";
		
	}
	if (isset($params['sort'])) {  
  		$sortby = $params['sort'];
	}
	if (isset($params['sort'])) {  
  		$col = $params['column'];
	}
  	$start=0;
	$limit=10;

	if(isset($params['page']))
	{
	$id = $params['page'];
	$start=($id-1)*$limit;
	}

	$q=$this->query("select * from ".TBL_PREFIX."_tokens where pid = ".intval($params['package'])." $searchQ ORDER BY $col $sortby LIMIT $start, $limit");
	return $q;
	}
	function modifyStatus($params){
	if($this->commonObjContent->praseData($_POST['action']) == 'active'){
		$val = 1;
	}else{
		$val = 0;
	}
		$query = "update ".TBL_PREFIX."_packages set package_status =".$val.",package_updated = NOW() where pid=".intval($_POST['pid']);
		$q = $this->query($query);
		if($q){
			return('success');
		}else{
			return('fail');
		}
	}
		
}
?>