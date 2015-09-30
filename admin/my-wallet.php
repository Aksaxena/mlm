<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/classes/User.php");
$adminObj=new Admin();
$userObj = new User();
$adminObj->validateAdmin();
$commonObj->cleanInput();
if($_SESSION['SESS_UID']){
	
	$result = $userObj->getUser($_GET['uid']);	
	
	$id = 'SM100'.$result->uid;
	$UserChild = $userObj->getUserChild($id);
	$Users = $userObj->getUserRPValue($UserChild);
	//$userObj->UpdateUserRPWallet($Users);

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
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="lib/css/jquery.datepick.css"> 
<script type="text/javascript" src="lib/js/jquery.plugin.js"></script> 
<script type="text/javascript" src="lib/js/jquery.datepick.js"></script>
</head>
<body  onload="javascript:document.frm.old_password.focus()" >
  
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
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;Commission Manager </td>
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
			  <input type="hidden" name="cid" value="<?php if(isset($Comm->id)) echo $Comm->id;?>">
			  			<?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    <?php echo ucfirst($result->username);?>'s Dashboard</td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Username:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><?php echo ucfirst($result->username);?></td>
				</tr>				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">Right Position:&nbsp;</td>
					<td height="24" align="left"><?php echo $Users['rightUser'];?> User(s)</td>
				</tr>
				<tr class="oddrow">
					<td height="35" align="right"  class="bldTxt">Right Position RP Value:&nbsp;</td>
					<td height="24" align="left"><?php echo $Users['rightRPVal'];?></td>
				</tr>
				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">Left Position:&nbsp;</td>
					<td height="24" align="left"><?php echo $Users['leftUser'];?> User(s)</td>
				</tr>
				<tr class="oddrow">
					<td height="35" align="right"  class="bldTxt">Left Position RP Value:&nbsp;</td>
					<td height="24" align="left"><?php echo $Users['leftRPVal'];?></td>
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
