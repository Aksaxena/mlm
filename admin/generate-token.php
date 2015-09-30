<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/classes/Package.php");
$PackageObj = new Package();
$adminObj=new Admin();
$adminObj->validateAdmin();

if((isset($_POST['pid']) && $_POST['pid'] != null) && (isset($_POST['Nocode']) && $_POST['Nocode'] != null)){
$seed = str_split('abcdefghijklmnopqrstuvwxyz'
                     .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                     .'0123456789');
$tokens = '';
	for($i = 1; $i <= intval($_POST['Nocode']); $i++){
	shuffle($seed); // probably optional since array_is randomized; this may be redundant
    $rand = '';					 
		foreach (array_rand($seed, 8) as $k) $rand .= $seed[$k];     		
			$PackageObj->GenerateToken(intval($_POST['pid']),$rand);
			$tokens .= $rand.', ';
	}	
	$arr =  array('status'=>'success','token'=>$tokens);
	echo json_encode($arr);
}
?>
