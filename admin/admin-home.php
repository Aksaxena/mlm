<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
$adminObj=new Admin();
$adminObj->validateAdmin();
$commonObj->cleanInput();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo ucfirst(SITE_ADMIN_TITLE);?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include("header.inc.php")?>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top" class="pad10"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="470" align="center" valign="middle" class="pad10"><table width="898" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><table  border="0" align="center" cellpadding="0" cellspacing="0">

				
				 <tr>
  <td align="left" valign="top" class="box_bg" id="boxbg"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="123" align="center" valign="middle"><a href="admin-dashboard.php"><img src="images/adminuser.png" border="0" /></a></td>
                      </tr>
                      <tr>
                        <td height="38" align="center" valign="middle"><a href="change-password.php" class="white_txtcaps"><strong>Admin manager</strong></a></td>
                      </tr>
                  </table></td>
                  <td width="10" align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top" class="box_bg" id="boxbg"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="123" align="center" valign="middle"><a href="logout.php"><img src="images/exit.png" border="0" /></a></td>
                      </tr>
                      <tr>
                        <td height="38" align="center" valign="middle"><a href="logout.php" class="white_txtcaps"><strong>Logout</strong></a></td>
                      </tr>
                  </table></td>
                  <td width="10" align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
				</tr>


            </table></td>
  </tr>
</table>
</td>
          </tr>
        </table></td>
      </tr>
     
    </table>
	</td>
          </tr>
		   <tr>
            <td align="left" valign="top"><?php include("footer.inc.php");?></td>
          </tr>
    </table>        
</body>
</html>
