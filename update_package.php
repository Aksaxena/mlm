<?php session_start();
require_once("lib/config.inc.php");
require_once("lib/classes/User.php");
require_once("lib/classes/Package.php");
$userObj = new User();
$commonObj->cleanInput();
$userObj->validateUserLogin();

if(isset($_GET['pid'])){
	$PackageObj = new Package();
	$packageList = $PackageObj->getPackage(intval($_GET['pid']));
}
if($_SESSION['UID']){
	//$id = 'SM100'.;
	$result = $userObj->getUser($_SESSION['UID']);	
}
if(isset($_POST['submitForm']) && $_POST['submitForm'] == 'Yes'){
	$userObj->ChangeUserPin($_POST);
	//echo '<pre>';
	//print_r($_POST);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ucfirst(SITE_TITLE);?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<!-- Add jQuery library -->
	<script type="text/javascript" src="admin/fancybox/lib/jquery-1.10.1.min.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="admin/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="admin/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />

<script src="lib/js/common.js" language="javascript"></script>
<script>
function validateFrm(obj){ 
var msg = "<font color='red'>=>Following is missing.</font><br>";
var str = '';
	if(obj.user_pin.value == ''){
	str += "=>Please enter user pin.<br>";
	}
	
	if(str){
		$.fancybox(msg+str);
		return false;
	}
}
</script>
</head>
<body>
  
 <?php include("header.php")?>
				  
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="180" valign="top" class="rightBorder menuBackground">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" width="180"><?php include("left-menu.inc.php");?></td>
        </tr>
        <tr>
          <td width="23">&nbsp;</td>
        </tr>
      </table>
    <br />
    <br /></td>
    <td width="1"><img src="admin/images/spacer.gif" width="1" height="1" /></td>
    <td width="1"><img src="admin/images/spacer.gif" width="1" height="1" /></td>
    <td height="400" align="center" valign="top">
	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
	<tr>
             <td height="21" align="left" class="txt">
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="title">
                    <tr>
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="admin/images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;Packages </td>
                      <td width="27%" align="right" style="padding-right:20px; ">&nbsp; 
					   
				      </td>
                    </tr>
              </table>
			</td>
        </tr>
		 <tr>
            <td height="530"  align="center" valign="top" class="top5">
              <form action="" method="post" enctype="multipart/form-data" name="frm" onsubmit="return validateFrm(this);">
			  <input type="hidden" name="submitForm" value="Yes">
			  <input type="hidden" name="pid" value="<?php if(isset($_GET['pid'])) echo $_GET['pid']; ?>">
			  <input type="hidden" name="current_user_pin" value="<?php echo $result->user_pin; ?>">
			
			  <?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    <?php echo ucfirst($packageList->package_name);?></td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Package Name:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input type="text" readonly="readonly" id="package_name" name="package_name" class="input"  value="<?php echo $packageList->package_name;?>"  /></td>
				</tr>				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">Capping:&nbsp;</td>
					<td height="24" align="left"><input type="text" id="package_capping" readonly="readonly" name="package_capping" class="input" placeholder="Enter user pin" value="<?php echo $packageList->package_capping;?>"  /></td>
				</tr>
				<tr class="oddrow">
					<td height="35" align="right"  class="bldTxt">Point:&nbsp;</td>
					<td height="24" align="left"><input type="text" id="package_point" readonly="readonly" name="package_point" class="input" placeholder="Enter user pin" value="<?php echo $packageList->package_point;?>"  /></td>
				</tr>
				<tr class="evenrow">
					<td height="35" align="right"  class="bldTxt">R.P:&nbsp;</td>
					<td height="24" align="left"><input type="text" id="package_rp" readonly="readonly" name="package_rp" class="input" placeholder="Enter user pin" value="<?php echo $packageList->package_rp;?>"  /></td>
				</tr>
				<tr class="oddrow">
					<td height="35" align="right"v  class="bldTxt">User Pin:&nbsp;</td>
					<td height="24" align="left"><input type="text" id="user_pin" name="user_pin" class="input" placeholder="Enter user pin" /><span class="warning">*</span></td>
				</tr>
				<tr class="evenrow">
					<td height="35" align="right"  class="bldTxt">&nbsp;</td>
					<td height="24" align="left"><button class="uk-button">Commit</button></td>
				</tr>				
				</table>
	</td>
  </tr>
</table>

			  </form>
		   </td>
       </tr>
     </table>
	</td>
  </tr>
</table>
<?php include("footer.php");?>
</body>
</html>
