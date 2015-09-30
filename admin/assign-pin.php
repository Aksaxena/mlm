<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/classes/User.php");
require_once("../lib/classes/Package.php");
$adminObj = new Admin();
$userObj = new User();
$packageObj = new Package();
$adminObj->validateAdmin();
$commonObj->cleanInput();

if(isset($_POST['submitForm']) && $_POST['submitForm']=="yes"){
	$packageObj->assignPinToUser($_POST);
}

if(isset($_GET['uid'])){	
	$result = $userObj->getUser(intval($_GET['uid']));
	$packages = $packageObj->fetchAll();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ucfirst(SITE_ADMIN_TITLE);?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<!-- Add jQuery library -->
	<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script src="lib/js/common.js" language="javascript"></script>

<script src="lib/js/common.js" language="javascript"></script>
<script>
function validateFrm(obj){ 
var msg = "<font color='red'>=>Following is missing.</font><br>";
var str = '';

	if(obj.package.value == '0'){
	str += "=>Please select package.<br>";
	}
	
	if(obj.no_of_pin.value == ''){
	str += "=>Please enter no. of pin.<br>";
	}
	else if(jQuery.isNumeric(obj.no_of_pin.value) == false){
        str += "=>Please enter numeric value.";        
    }
	if(str){
	$.fancybox(msg+str);
	return false;
	}
}

</script></head>
<body>
  
 <?php include("header.inc.php")?>
				  
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
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;Assign Pin </td>
                      <td width="27%" align="right" style="padding-right:20px; ">&nbsp; 
					   
				      </td>
                    </tr>
              </table>
			</td>
        </tr>
		 <tr>
            <td height="530"  align="center" valign="top" class="top5">
              <form method="post" enctype="multipart/form-data" name="frm" onsubmit="return validateFrm(this);">
			  <input type="hidden" name="submitForm" value="yes">
			  <input type="hidden" name="uid" class="txtfld" value="<?php echo $result->uid;?>">
				
							<?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    Assign pin to <?php echo ucfirst($result->username); ?></td>
				</tr>

				<tr align="right" class="evenrow">
					<td height="32" colspan="2" class="txt pad-right10"><span class="warning">*</span> - Required Fields</td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Username:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><?php echo $result->username;?></td>
				</tr>				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">Package:&nbsp;</td>
					<td height="24" align="left">
					<select name="package" id="package">
						<option value="0">Select Package</option>
						<?php
						while($line = $obj->fetchNextObject($packages)){?>
						<option value="<?php echo $line->pid; ?>"><?php echo ucfirst($line->package_name); ?></option>
						<?php } ?>
					</select>
					<span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
					<td height="35" align="right"  class="bldTxt">No. Of Pin:&nbsp;</td>
					<td height="24" align="left"><input type="text" name="no_of_pin" id="no_of_pin" size="45" class="input" /> 
					<span class="warning">*</span></td>
				</tr>				
				
				<tr class="evenrow">
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
<?php include("footer.inc.php");?>
</body>
</html>
