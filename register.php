<?php session_start();
require_once("lib/config.inc.php");
require_once("lib/classes/User.php");
require_once("lib/encryption.inc.php");
$encryptObj = new Encryption();
$UserObj = new User();
if(isset($_POST['submitForm']) && $_POST['submitForm'] == 'Yes'){
		$PASS = $encryptObj->encode($_POST['password']);
		$UserObj->AddUser($_POST,$PASS,'front');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome To <?php echo SITE_TITLE;?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<style>
input[type="text"],input[type="Password"],select,textarea {
	padding: 9px;
	width: 90%;
	font-size: 1.1em;	
	border: 2px solid#EAEEF1;
	color: #666666;
	background:#EAEEF1;
	font-family: 'Open Sans', sans-serif;
	font-weight:600;
	margin-left: 5px;
	outline:none;
	-webkit-transition: all 0.3s ease-out;
	-moz-transition: all 0.3s ease-out;
	-ms-transition: all 0.3s ease-out;
	-o-transition: all 0.3s ease-out;
	transition: all 0.3s ease-out;
}
input[type="text"]:hover,input[type="Password"]:hover,select:hover,textarea:hover,#active{
	background:#fff;
	border:2px solid #609EC3;
	outline:none;
}
</style>
</head>

<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><?php include("header.php")?></td>
  </tr>
  <tr>
    <td height="500">
<?php echo $commonObj->showError();echo $commonObj->showMessage();?>

      <table width="363" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="login_bg" valign="top">
		<form action="" method="post" enctype="multipart/form-data" name="frm" onsubmit="return validateFrm(this);">
			  <input type="hidden" name="submitForm" value="Yes">
          <table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
            <tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="56" colspan="3" class="txt3"><h3>User Registration</h3></td>
                    </tr>
                  <tr>
                    <td width="70" class="blackbold">Sponsor Id</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td>
					<input placeholder="Enter sponsor id" class="keyupArea" type="text" name="sponsor_id" id="sponsor_id" value="<?php if(isset($line->sponsor_id)) echo $line->sponsor_id; ?>" class="input" /><span class="warning">*</span>
					<div id="sponsorUser"></div>
					</td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">Position</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td>
						<select class="uk-form-stacked" id="position" name="position">
					<option value="0">Select Position</option>
					<option value="1" <?php if(isset($line->position) && $line->position == 1) echo 'selected'; ?>>Right Position</option>
					<option value="2" <?php if(isset($line->position) && $line->position == 0) echo 'selected'; ?>>Left Position</option>
					</select><span class="warning">*</span>
					</td>
                  </tr>
				  
              </table></td>
            </tr>
			
			<tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">Parent Id</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td><input type="text" name="parent_id" class="fffkeyupArea" id="parent_id" placeholder="Enter parent id" value="<?php if(isset($line->parent_id)) echo $line->parent_id; ?>" class="input" /><span class="warning">*</span> <div id="parentUser"></div>
					</td>
                  </tr>
				  
              </table></td>
            </tr>
			<tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">Name</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td><input type="text" name="username" id="username" placeholder="Enter name" value="<?php if(isset($line->username)) echo $line->username; ?>" class="input" /><span class="warning">*</span>
					</td>
                  </tr>
				  
              </table></td>
            </tr>
			<tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">Email</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td><input type="text" name="email" id="email" value="<?php if(isset($line->email)) echo $line->email; ?>" class="input" placeholder="Enter email" /><span class="warning">*</span>
					</td>
                  </tr>
				  
              </table></td>
            </tr>
			<tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">Password</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td><input type="password" name="password" id="password" value="<?php if(isset($line->password)) echo $encryptObj->decode($line->password); ?>" class="input" placeholder="Enter password" /><span class="warning">*</span>
					</td>
                  </tr>
				  
              </table></td>
            </tr>
			<tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">Address</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td><textarea id="address" placeholder="Enter address." name="address" cols="25"><?php if(isset($line->address)) echo $line->address; ?></textarea><span class="warning">*</span>
					</td>
                  </tr>
				  
              </table></td>
            </tr>
			<tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">Mobile</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td><input type="text" name="mobile" id="mobile" value="<?php if(isset($line->mobile)) echo $line->mobile; ?>" class="input" placeholder="Enter mobile" /><span class="warning">*</span>
					</td>
                  </tr>
				  
              </table></td>
            </tr>
			<tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">DOB</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td><input type="text" name="date_of_birth" id="date_of_birth" value="<?php if(isset($line->date_of_birth)) echo $line->date_of_birth; ?>" class="input" placeholder="Enter date of birth" /><span class="warning">*</span>
					</td>
                  </tr>
				  
              </table></td>
            </tr>
			<tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">User Pin</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td><input type="text" name="user_pin" id="user_pin" placeholder="Enter pin" value="<?php if(isset($line->user_pin)) echo $line->user_pin; ?>" class="input" /><span class="warning">*</span>
					</td>
                  </tr>
				  
              </table></td>
            </tr>
			<tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">&nbsp;</td>
                    <td width="20" align="left" class="blackbold">&nbsp;</td>
                    <td><textarea id="termcondition" cols="25">Term & condition :-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lorum Ipsum Lorum Ipsum Lorum Ipsum Lorum Ipsum Lorum Ipsum </textarea>
					</td>
                  </tr>
				  
              </table></td>
            </tr>
			
			<tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">&nbsp;</td>
                    <td width="20" align="left" class="blackbold">&nbsp;</td>
                    <td><input type="checkbox" id="termCondition" />&nbsp; I Agree With Terms And Condition
					</td>
                  </tr>
				  
              </table></td>
            </tr>
			
			<tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">&nbsp;</td>
                    <td width="20" align="left" class="blackbold">&nbsp;</td>
                    <td><button class="uk-button">Submit</button>
					</td>
                  </tr>
				  
              </table></td>
            </tr>
			
			<tr>
              <td><table width="500" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">&nbsp;</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td>
					</td>
                  </tr>
				  
              </table></td>
            </tr>
			
            
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
   <td align="left" valign="top"><?php include("footer.php");?></td>
   </tr>
</table>
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
	/*if(obj.user_pin.value == ''){
	str += "=>Please enter user pin.<br>";
	}*/
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

</body>
</html>