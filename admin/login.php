<?php
ob_start();
session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
$adminObj=new Admin();
$commonObj->clearCache();


if(isset($_POST["frmSubmit"]) && $_POST["frmSubmit"] == "yes") {
$username = $commonObj->praseData($_POST["username"]);
$password = sha1($commonObj->praseData($_POST["password"]));
	$adminObj->login($username,$password);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo ucfirst(SITE_ADMIN_TITLE);?></title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" /><script src="lib/js/jquery.js" language="javascript"></script>
<script src="lib/js/common.js" language="javascript"></script>
<script>
function validateFrm(obj) {
var errArr =  new Array();
	errArr[errArr.length] ="<strong>Error: Following is missing:</strong>" ;
	if(obj.username.value=="") {
		errArr[errArr.length] = "Please enter username";
	}
	if(obj.password.value=="") {
		errArr[errArr.length] = "Please enter password";
	}

	if(errArr.length>1) {
		raiseError(errArr);
		return false;
	}
}
</script>
</head>

<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><?php include("header.inc.php")?></td>
  </tr>
  <tr>
    <td height="465">
<?php echo $commonObj->showError();echo $commonObj->showMessage();?>

      <table width="363" height="214" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="login_bg" valign="top"><form name="form1" id="form1" method="post" action="" onsubmit="return validateFrm(this)">
          <table width="328" border="0" align="center" cellpadding="10" cellspacing="0">
            <tr>
              <td><table width="328" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="56" colspan="3" class="txt3">&nbsp;</td>
                    </tr>
                  <tr>
                    <td width="70" class="blackbold">Username</td>
                    <td width="20" align="left" class="blackbold">:</td>
                    <td><input name="username" type="text" class="input" id="username" /></td>
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
              <td>
			  <table width="328" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="100" class="blackbold">&nbsp;</td>
                  <td align="right" class="pad-right33"><input name="frmSubmit" type="hidden" id="frmSubmit" value="yes" />
                    <input name="Submit" type="image" src="images/btn_login.png" value="Submit" /></td>
                </tr>
              </table>
			  </td>
            </tr>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
   <td align="left" valign="top"><?php include("footer.inc.php");?></td>
   </tr>
</table>
</body>
</html>
