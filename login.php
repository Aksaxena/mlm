<?php session_start();
require_once("lib/config.inc.php");
require_once("lib/classes/User.php");
require_once("lib/encryption.inc.php");
$userObj = new User();
$commonObj->clearCache();


if(isset($_POST["frmSubmit"]) && $_POST["frmSubmit"] == "yes") {
$encryptObj = new Encryption();
$user_pin = $commonObj->praseData($_POST["user_pin"]);
$password = $encryptObj->encode($commonObj->praseData($_POST["password"]));
$userObj->login($user_pin,$password);
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
input[type="text"],input[type="Password"] {
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
input[type="text"]:hover,input[type="Password"]:hover,#active{
	background:#fff;
	border:2px solid #609EC3;
	outline:none;
}
</style>
<script>
function validateFrm(obj){ 
var msg = "<font color='red'>=>Following is missing.</font><br>";
var str = '';
	if(obj.user_pin.value == ''){
	str += "=>Please enter user pin.<br>";
	}
	if(obj.password.value == ''){
	str += "=>Please enter password<br>";
	}
	if(str){
	$.fancybox(msg+str);
	return false;
	}
}
</script>
</head>

<body><table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><?php include("header.php")?></td>
  </tr>
  <tr>
    <td height="465">
<?php echo $commonObj->showError();echo $commonObj->showMessage();?>

      <table width="363" height="214" border="3" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="login_bg" valign="top">
		<form name="form1" id="form1" method="post" action="" onsubmit="return validateFrm(this)">		
          <table width="328" border="0" align="center" cellpadding="10" cellspacing="0">
            <tr>
              <td><table width="328" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="56" colspan="3" class="txt3"><h3>Member Login</h3></td>
                    </tr>
                  <tr>
                    <td width="70" class="blackbold">User Id</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td><input name="user_pin" type="text" class="input" id="user_pin" /></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="328" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="70" class="blackbold">Password</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td><input name="password" type="password" class="input" id="password" /></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="328" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="100" class="blackbold"><a href="forget-password.php">Forget Password</a></td>
                  <td align="right" class="pad-right33">
				  <input name="frmSubmit" type="hidden" id="frmSubmit" value="yes" />                 
				  <input class="button" type="submit" value="Login">

				  </td>
				  <td width="100" class="blackbold">&nbsp;</td>
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

</body>
</html>