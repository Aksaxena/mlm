<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
$adminObj=new Admin();
$adminObj->validateAdmin();
$commonObj->cleanInput();


if(isset($_POST['submitForm']) && $_POST['submitForm'] == "yes"){
$new_email=mysql_real_escape_string($_POST['email_address']);
$adminObj->changeEmail($new_email);
}
if($_SESSION['SESS_UID']){
$sql=$adminObj->query("select * from ".TBL_PREFIX."_admin where id=".$_SESSION['SESS_UID']);
$result=$adminObj->fetchNExtObject($sql);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//Dtd XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/Dtd/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ucfirst(SITE_ADMIN_TITLE);?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" /><script>
function validateFrm(obj) {
var errArr =  new Array();
	errArr[errArr.length] = "<strong>Error following is missing!</strong>";
	
	if(obj.email_address.value=="") {
		errArr[errArr.length] = "Please enter Email Address";
	}
	else if(!validEmailAddress(obj.email_address.value))
	{
	errArr[errArr.length] = "Please enter valid Email Address";
	}
	if(errArr.length>1) {
		raiseError(errArr);
		return false;
	}
}
function validEmailAddress(email_address)
{
		invalidChars = " /:,;~"
		if (email_address == "") 
		{
			return (false);
		}
		for (i=0; i<invalidChars.length; i++) 
		{
			badChar = invalidChars.charAt(i)
			if (email_address.indexOf(badChar,0) != -1) 
			{
				return (false);
			}
		}
		atPos = email_address.indexOf("@",1)
		if (atPos == -1) 
		{
			return (false);
		}
		if (email_address.indexOf("@",atPos+1) != -1) 
		{
			return (false);
		}
		periodPos = email_address.indexOf(".",atPos)
		if (periodPos == -1) 
		{
			return (false);
		}
		if (periodPos+3 > email_address.length)	
		{
			return (false);
		}
			
		return (true);
}
</script>
<script src="lib/js/jquery.js" language="javascript"></script>
<script src="lib/js/common.js" language="javascript"></script>
<?php include("header.inc.php")?>
				  
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"valign="top" width="180" class="menuBackground">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" width="180"  ><?php include("left-menu.inc.php");?></td>
        </tr>
      </table>
	</td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td height="400" align="center" valign="top">
	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
	<tr>
           <td height="21" align="left" class="txt">
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="title">
                    <tr>
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;Admin Manager </td>
                      <td width="27%" align="right" style="padding-right:20px; ">&nbsp; 
					   
				      </td>
                    </tr>
              </table>
			</td>
        </tr>
		 <tr>
            <td height="530"  align="center" valign="top" class="top5">
              <form action="" method="post" enctype="multipart/form-data" name="frm" onsubmit="return validateFrm(this);">
			  <input type="hidden" name="submitForm" value="yes">
			  <input type="hidden" name="submitForm" value="yes">
			  
				
							<?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    Change Email </td>
				</tr>

				<tr align="right" class="evenrow">
					<td height="32" colspan="2" class="txt pad-right10"><span class="warning">*</span> - Required Fields</td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Username:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><?php echo $result->username;?></td>
				</tr>				
				<tr class="evenrow">
					<td height="34" align="right" class="bldTxt">Email Address:&nbsp;</td>
					<td height="34" align="left"><input type="text" name="email_address" size="45" class="input"  value="<?php echo stripslashes ($result->email);?>"/> 
					<span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
				  <td height="34" align="right" class="bldTxt">&nbsp;</td>
				  <td height="34" align="left"><input type="submit" value="Submit" class="button" /></td>
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
<?php include("footer.inc.php");?>
</body>
</html>
