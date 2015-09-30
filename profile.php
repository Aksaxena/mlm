<?php session_start();
require_once("lib/config.inc.php");
require_once("lib/classes/User.php");
require_once("lib/encryption.inc.php");
require_once("lib/simpleimage.php");
$encryptObj = new Encryption();
$UserObj = new User();
$image= new SimpleImage();
$UserObj->validateUserLogin();
$commonObj->cleanInput();

if(isset($_POST['submitForm']) && $_POST['submitForm']=="yes"){
$result = $UserObj->getUser($_SESSION['UID']);	
$img = $result->profile_image;
if($_FILES['profile_image']['size'] > 0 && $_FILES['profile_image']['error']==0){
	$dirPath = 'images/users/'.$_SESSION['UID'].'/';	
	$img=time('his').$_FILES['profile_image']['name'];	
	if (!is_dir($dirPath)) {
    	mkdir($dirPath,0777);		
	}
	move_uploaded_file($_FILES['profile_image']['tmp_name'],$dirPath.$img);	
	}
	$UserObj->UpdateUserProfile($_POST,$img);
}
if($_SESSION['UID']){
	$result = $UserObj->getUser($_SESSION['UID']);	
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
	 if(obj.username.value=='')
		{
		str += "=>Please enter user name.<br>";
		}
		if(obj.address.value=='')
		{
		str += "=>Please enter address.<br>";
		}
		if(obj.mobile.value=='')
		{
		str += "=>Please enter mobile.<br>";
		}
		
		if(obj.profile_image.value != ''){
		ext=$('#profile_image').val().split('.');
			if(ext[1]!='jpg' && ext[1]!='png' && ext[1]!='gif')
			{
				str += "wrong file format.<br>";
			}
		}
		if(obj.pancard.value=='')
		{
		str += "=>Please enter pancard.<br>";
		}
		if(str) {
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
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td width="1"><img src="images/spacer.gif" width="1" height="1" /></td>
    <td height="400" align="center" valign="top">
	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
	<tr>
             <td height="21" align="left" class="txt">
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="title">
                    <tr>
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="admin/images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;Profile Management </td>
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
			  <?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    <?php echo ucfirst($result->username);?>'s Profile</td>
				</tr>

				<tr align="right" class="evenrow">
					<td height="32" colspan="2" class="txt pad-right10"><span class="warning">*</span> - Required Fields</td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">User Pin:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><?php echo 'SM100'.$result->uid;?></td>
				</tr>				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">User Name:&nbsp;</td>
					<td height="24" align="left"><input type="text"  name="username" value="<?php echo $result->username; ?>" id="username" size="45" class="input" /> 
					<span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
					<td height="35" align="right"  class="bldTxt">Email:&nbsp;</td>
					<td height="24" align="left"><?php echo $result->email; ?></td>
				</tr>				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">Address:&nbsp;</td>
					<td height="24" align="left"><textarea cols="27" id="address" name="address"><?php echo $result->address; ?></textarea>
					<span class="warning">*</span></td>
				</tr>
				
				<tr class="oddrow">
					<td height="35" align="right"  class="bldTxt">City:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php echo $result->city;?>"  id="city" name="city"  size="45" class="input" /> 
					</td>
				</tr>
				
				<tr class="evenrow">
					<td height="35" align="right"  class="bldTxt">State:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php echo $result->state;?>"  id="state" name="state"  size="45" class="input" /> 
					</td>
				</tr>
				
				<tr class="oddrow">
					<td height="35" align="right"  class="bldTxt">Country:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php echo $result->country;?>"  id="country" name="country"  size="45" class="input" /> 
					</td>
				</tr>
				
				<tr class="evenrow">
					<td height="35" align="right"  class="bldTxt">Mobile:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php echo $result->mobile;?>"  id="mobile" name="mobile"  size="45" class="input" /> 
					<span class="warning">*</span></td>
				</tr>				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">DOB:&nbsp;</td>
					<td height="24" align="left"><?php echo $result->date_of_birth;?></td>
				</tr>
				<tr class="oddrow">
					<td height="35" align="right"  class="bldTxt">Profile Image:&nbsp;</td>
					<td height="24" align="left"><input type="file" id="profile_image" name="profile_image" />
					<div>Support (jpeg,jpg,png,gif file format.)
					</td>
				</tr>				
				
				<tr class="evenrow">
					<td height="35" align="right"  class="bldTxt">Pancard:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php echo $result->pancard;?>"  id="pancard" name="pancard"  size="45" class="input" /> 
					<span class="warning">*</span></td>
				</tr>
				
				<tr class="oddrow">
					<td height="35" align="right"  class="bldTxt">Bank Name:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php echo $result->bank_name;?>"  id="bank_name" name="bank_name"  size="45" class="input" /> 
					</td>
				</tr>
				<tr class="evenrow">
					<td height="35" align="right"  class="bldTxt">Branch Code:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php echo $result->branch_code;?>"  id="branch_code" name="branch_code"  size="45" class="input" /> 
					</td>
				</tr>
				
				<tr class="oddrow">
					<td height="35" align="right"  class="bldTxt">A/c Holder Name:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php echo $result->acct_holder_name;?>"  id="acct_holder_name" name="acct_holder_name"  size="45" class="input" /> 
					</td>
				</tr>
				<tr class="evenrow">
					<td height="35" align="right"  class="bldTxt">A/c Number:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php echo $result->acct_number;?>"  id="acct_number" name="acct_number"  size="45" class="input" /> 
					</td>
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
</table><br /><br /><br />
<?php include("footer.php");?>
</body>
</html>
