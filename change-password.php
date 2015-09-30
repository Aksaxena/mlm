<?php session_start();
require_once("lib/config.inc.php");
require_once("lib/classes/User.php");
require_once("lib/encryption.inc.php");
$encryptObj = new Encryption();
$UserObj = new User();
$UserObj->validateUserLogin();
$commonObj->cleanInput();

if(isset($_POST['submitForm']) && $_POST['submitForm']=="yes"){
$old_password = $encryptObj->encode($_POST['old_password']);
$new_password = $encryptObj->encode($_POST['new_password']);
	$UserObj->changePassword($old_password,$new_password);
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
<script>
function validateFrm(obj) {
var errArr =  new Array();
	var msg = "<font color='red'>=>Following is missing.</font><br>";
	var str = '';
	 if(obj.old_password.value=='')
		{
		str += "=>Please enter old password.<br>";
		}
		if(obj.new_password.value=='')
		{
		str += "=>Please enter new password.<br>";
		}
		if(obj.confirm_password.value=='')
		{
		str += "=>Please enter confirm password.<br>";
		}
		if((obj.new_password.value)!=(obj.confirm_password.value))
		{
		str += "=>New and confirm password must be same.<br>";
		}
		if(str) {
		$.fancybox(msg+str);
		return false;
	}
}
</script>
</head>
<body  onload="javascript:document.frm.old_password.focus()" >
  
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
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td height="400" align="center" valign="top">
	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
	<tr>
             <td height="21" align="left" class="txt">
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="title">
                    <tr>
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="admin/images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;Password Update </td>
                      <td width="27%" align="right" style="padding-right:20px; ">&nbsp; 
					   
				      </td>
                    </tr>
              </table>
			</td>
        </tr>
		 <tr>
            <td height="530"  align="center" valign="top" class="top5">
              <form action="change-password.php" method="post" enctype="multipart/form-data" name="frm" onsubmit="return validateFrm(this);">
			  <input type="hidden" name="submitForm" value="yes">
			  <input type="hidden" name="id" class="txtfld" value="<?php echo $result->id;?>">
				
							<?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    Change Password</td>
				</tr>

				<tr align="right" class="evenrow">
					<td height="32" colspan="2" class="txt pad-right10"><span class="warning">*</span> - Required Fields</td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Username:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><?php echo ucfirst($_SESSION["UNAME"]);?></td>
				</tr>				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">Old Password:&nbsp;</td>
					<td height="24" align="left"><input type="password" name="old_password" size="45" class="input" /> 
					<span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
					<td height="35" align="right"  class="bldTxt">New Password:&nbsp;</td>
					<td height="24" align="left"><input type="password" name="new_password" size="45" class="input" /> 
					<span class="warning">*</span></td>
				</tr>				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">Confirm Password:&nbsp;</td>
					<td height="24" align="left"><input type="password" name="confirm_password" size="45" class="input" /> 
					<span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
				  <td height="35" align="right" class="bldTxt">&nbsp;</td>
				  <td height="24" align="left"><input type="submit" value="Submit" class="button" /></td>
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
