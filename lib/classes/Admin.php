<?php
class Admin extends DB
{
	var $commonObjAdmin;
	
	function Admin() {
	$this->commonObjAdmin = new Common();	
	parent:: __construct(DB_NAME,DB_HOST,DB_USERNAME,DB_PASSWORD);
	}
	function validateAdmin(){
		global $obj;
		$query = "SELECT COUNT(*) as cs FROM ".TBL_PREFIX."_admin where username='".$_SESSION["USERNAME"]."' and password='".$_SESSION["SHA1PASSWORD"]."'";
		$adminRs = $this->query($query);
		$adminObj = $this->fetchNextObject($adminRs);
		if(!$adminObj->cs) {
			$this->commonObjAdmin->pushError("Invalid admin login");
			$this->commonObjAdmin->wtRedirect("login.php");
		}
	}
   function validateAdminLogin(){
   
		if(($_SESSION['USERNAME'] == null )&&($_SESSION['SHA1PASSWORD'] == null )) {
		
			$this->commonObjAdmin->wtRedirect("index.php"); 
		} 
	}
	
	function login($username,$password){
		$query = "SELECT * FROM ".TBL_PREFIX."_admin where username='".$username."' and password='".$password."'";
		$adminRs =$this->query($query,-1);
		if($this->numRows($adminRs)==0) {
			$this->commonObjAdmin->pushError('Invalid admin login');
			$this->commonObjAdmin->wtRedirect("login.php");
		} else {		
			$adminObj = $this->fetchNextObject($adminRs);
			$_SESSION["USERNAME"] = $adminObj->username;
			$_SESSION["SESS_UID"] = $adminObj->id;
			$_SESSION["SHA1PASSWORD"] = $adminObj->password;
			$this->commonObjAdmin->wtRedirect("index.php");
		}
	}
	function logout(){
		$_SESSION["USERNAME"] = null;
		$_SESSION["SESS_UID"] = null;
		$_SESSION["SHA1PASSWORD"] = null;
		$this->commonObjAdmin->pushMessage("Logout successful");
		//session_destroy();
		$this->commonObjAdmin->wtRedirect("index.php");
	
	}
	function InsertCommission($params){
		if(!empty($params['cid'])){
			$this->query("UPDATE ".TBL_PREFIX."_commission_setting SET tds='".$this->commonObjAdmin->praseData($params['tds'])."',admin_charge='".$this->commonObjAdmin->praseData($params['admin_charge'])."',recharge='".$this->commonObjAdmin->praseData($params['recharge'])."',direct_income='".$this->commonObjAdmin->praseData($params['direct_income'])."',indirect_income='".$this->commonObjAdmin->praseData($params['indirect_income'])."',franchies='".$this->commonObjAdmin->praseData($params['franchises_value'])."',point_value='".$this->commonObjAdmin->praseData($params['point_value'])."',capping='".$this->commonObjAdmin->praseData($params['capping_income'])."' WHERE id = ".$params['cid']);
			$this->commonObjAdmin->pushMessage("Commission value updated successful.");
		}else{
			$this->query("INSERT INTO ".TBL_PREFIX."_commission_setting SET tds='".$this->commonObjAdmin->praseData($params['tds'])."',admin_charge='".$this->commonObjAdmin->praseData($params['admin_charge'])."',recharge='".$this->commonObjAdmin->praseData($params['recharge'])."',direct_income='".$this->commonObjAdmin->praseData($params['direct_income'])."',franchies='".$this->commonObjAdmin->praseData($params['franchises_value'])."',point_value='".$this->commonObjAdmin->praseData($params['point_value'])."',capping=".$this->commonObjAdmin->praseData($params['capping_income']));
			$this->commonObjAdmin->pushMessage("Commission value saved successfully.");
		}
	}
	function changeEmail($new_email){
		$this->query("update ".TBL_PREFIX."_admin set email='$new_email' where id=".$_SESSION['SESS_UID']);
		$this->commonObjAdmin->pushMessage("Email address changed sucessfully.");
		$this->commonObjAdmin->wtRedirect("change-email.php"); 
	
	}
	function changePassword($old_password,$new_password){
		$adminArr=$this->query("select * from ".TBL_PREFIX."_admin where password='$old_password' and id=".$_SESSION['SESS_UID'],$debug=-1);
		$rows=$this->numRows($adminArr);
		if($rows>0){
		$this->query("update ".TBL_PREFIX."_admin set password='$new_password' where id=".$_SESSION['SESS_UID']);
		$this->commonObjAdmin->pushMessage("Password changed sucessfully.");
		
		} else {
		$this->commonObjAdmin->pushError("Old password is wrong.");
		}
	}
	
	function getCommissionConfig(){
		$adminArr = $this->query("select * from ".TBL_PREFIX."_commission_setting where id=1");
		$rows = $this->numRows($adminArr);
		if($rows>0){
			$qr=$this->fetchNextObject($adminArr);
			return $qr;
		} 
	}
	

}


?>