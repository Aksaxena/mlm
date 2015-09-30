<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/classes/User.php");
require_once("../lib/encryption.inc.php");

$UserObj = new User();
$adminObj=new Admin();
$encryptObj = new Encryption();
$adminObj->validateAdmin();
$commonObj->cleanInput();
if(isset($_POST['submitForm']) && $_POST['submitForm'] == 'Yes'){
	if(!empty($_POST['uid']) && $_POST['uid'] != null){
		$PASS = $encryptObj->encode($_POST['password']);
	  	$UserObj->updateUser($_POST,$PASS);
	} else {
		$PASS = $encryptObj->encode($_POST['password']);
		$UserObj->AddUser($_POST,$PASS);
	}
}
if(isset($_GET['uid'])){
$line = $UserObj->getUser(intval($_GET['uid']));
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
<link href="fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<!-- Add jQuery library -->
	<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />

<script src="lib/js/common.js" language="javascript"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="lib/css/jquery.datepick.css"> 
<script type="text/javascript" src="lib/js/jquery.plugin.js"></script> 
<script type="text/javascript" src="lib/js/jquery.datepick.js"></script>

<script>
$(function() {
    $( "#date_of_birth" ).datepick();
  });
function validateFrm(obj){ 
var msg = "<font color='red'>=>Following is missing.</font><br>";
var str = '';

	if(obj.sponsor_id.value == ''){
	str += "=>Please enter sponsor id.<br>";
	}
	
	if(obj.position.value == 0){
	str += "=>Please select position.<br>";
	}
	if(obj.parent_id.value == ''){
	str += "=>Please enter parent id.<br>";
	}	
	if(obj.username.value == ''){
	str += "=>Please enter user name.<br>";
	}
	if(obj.email.value == ''){
	str += "=>Please enter email<br>";
	}
	else if( !validateEmail(obj.email.value)) { str += "=>Please enter valid email.<br>"; }
	if(obj.password.value == ''){
	str += "=>Please enter password<br>";
	}
	if(obj.address.value == ''){
	str += "=>Please enter address<br>";
	}
	if(obj.mobile.value == ''){
	str += "=>Please enter mobile<br>";
	}
	if(obj.date_of_birth.value == ''){
	str += "=>Please enter date of birth<br>";
	}
	if(obj.termCondition.checked == false){
	str += "=>Please accept term and condition.<br>";
	}
	if(str){
	$.fancybox(msg+str);
	return false;
	}
}
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}
</script>
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
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;
                     <a href="user.php">User Manager</a> >><?php if(isset($_GET['uid'])) echo "Edit User"; else echo"Add User"; ?> </td>
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
			  <input type="hidden" name="uid" value="<?php if(isset($_GET['uid'])) echo $_GET['uid']; ?>">
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    <?php if(isset($_GET['uid'])) echo "Edit User"; else echo"Add User"; ?> </td>
				</tr>

				<tr align="right" class="evenrow">
					<td height="32" colspan="2" class="txt pad-right10"><span class="warning">*</span> - Required Fields</td>
				</tr>
				<tr class="evenrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Sponsor Id:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input placeholder="Enter sponsor id" type="text" name="sponsor_id" id="sponsor_id" value="<?php if(isset($line->sponsor_id)) echo $line->sponsor_id; ?>" class="input" /><span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Position:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt">
					<select class="uk-form-stacked" id="position" name="position">
					<option value="0">Select Position</option>
					<option value="1" <?php if(isset($line->position) && $line->position == 1) echo 'selected'; ?>>Right Position</option>
					<option value="2" <?php if(isset($line->position) && $line->position == 2) echo 'selected'; ?>>Left Position</option>
					</select><span class="warning">*</span></td>
				</tr>
				<tr class="evenrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Parent Id:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input type="text" name="parent_id" id="parent_id" placeholder="Enter parent id" value="<?php if(isset($line->parent_id)) echo $line->parent_id; ?>" class="input" /><span class="warning">*</span></td>
				</tr>
								
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Name:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input type="text" name="username" id="username" placeholder="Enter name" value="<?php if(isset($line->username)) echo $line->username; ?>" class="input" /><span class="warning">*</span></td>
				</tr>
				<tr class="evenrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Email:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input type="text" name="email" id="email" value="<?php if(isset($line->email)) echo $line->email; ?>" class="input" placeholder="Enter email" /><span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Password:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input type="password" name="password" id="password" value="<?php if(isset($line->password)) echo $encryptObj->decode($line->password); ?>" class="input" placeholder="Enter password" /><span class="warning">*</span></td>
				</tr>
				<tr class="evenrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Address:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><textarea id="address" placeholder="Enter address." name="address" cols="27"><?php if(isset($line->address)) echo $line->address; ?></textarea><span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Mobile:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input type="text" name="mobile" id="mobile" value="<?php if(isset($line->mobile)) echo $line->mobile; ?>" class="input" placeholder="Enter mobile" /><span class="warning">*</span></td>
				</tr>
				<tr class="evenrow">
					<td width="35%" height="35" align="right"  class="bldTxt">DOB:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input type="text" name="date_of_birth" id="date_of_birth" value="<?php if(isset($line->date_of_birth)) echo $line->date_of_birth; ?>" class="input" placeholder="Enter date of birth" /><span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">User Pin:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input type="text" <?php //if(isset($_GET['uid'])) echo 'readonly'; ?> name="user_pin" id="user_pin" placeholder="Enter pin" value="<?php if(isset($line->user_pin)) echo $line->user_pin; ?>" class="input" /><span class="warning">*</span></td>
				</tr>

				<?php
				if(empty($_GET['uid'])){?>
				<tr class="evenrow">
					<td width="35%" height="35" align="right"  class="bldTxt">&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><textarea id="termcondition" cols="27">Term & condition :-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lorum Ipsum Lorum Ipsum Lorum Ipsum Lorum Ipsum Lorum Ipsum </textarea></td>
				</tr>
				<tr class="evenrow">
					<td width="35%" height="35" align="right"  class="bldTxt">&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt">
					<input type="checkbox" id="termCondition" />&nbsp; I Agree With Terms And Condition
					</td>
				</tr>
				<?php } ?>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt">
					<?php 
					if(isset($_GET['uid'])){?>
					<button class="uk-button">Update</button>					
					<?php 
					} else { 
					?>
					<button class="uk-button">Submit</button>					
					<?php 
					}
					?>
					</td>
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
