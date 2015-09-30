<?php session_start();
require_once("lib/config.inc.php");
require_once("lib/classes/User.php");
require_once("lib/classes/Package.php");
$userObj = new User();
$packageObj = new Package();
$commonObj->cleanInput();
$userObj->validateUserLogin();
$packages = $packageObj->fetchAll();
if(isset($_POST['submitForm']) && $_POST['submitForm'] == "yes"){
$old_password=sha1(mysql_real_escape_string($_POST['old_password']));
$new_password=sha1(mysql_real_escape_string($_POST['new_password']));
	$adminObj->changePassword($old_password,$new_password);
}

if($_SESSION['UID']){
	//$id = 'SM100'.;
	$result = $userObj->getUser($_SESSION['UID']);	
	$PositionLevel = $userObj->getTreePosition($result->user_pin);
	$packageDetails = $userObj->getUserPackage($result->user_pin);	
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
<!-- Add jQuery library -->
	<script type="text/javascript" src="admin/fancybox/lib/jquery-1.10.1.min.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="admin/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="admin/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
    <td width="1"><img src="admin/images/spacer.gif" width="1" height="1" /></td>
    <td width="1"><img src="admin/images/spacer.gif" width="1" height="1" /></td>
    <td height="400" align="center" valign="top">
	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
	<tr>
             <td height="21" align="left" class="txt">
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="title">
                    <tr>
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="admin/images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;Package Management </td>
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
			  <?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    Active Package</td>
				</tr>
				<tr align="right" class="evenrow">
					<td height="32" colspan="2" class="txt pad-right10"><a href="javascript:void(0);" id="PackageArea">Update Package</a></td>
				</tr>
				
				<tr align="right" class="evenrow" style="display:none;" id="packageDisplayArea">
					<td height="32" colspan="2" class="txt pad-right10">
						<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
							<tr align="left"> 
								<td height="30" colspan="5" class="boxheadbg">&nbsp;&nbsp;Available Packages</td>
							</tr>
							<tr align="left"> 
								<td height="30" ><strong>Package Name</strong></td>
								<td height="30"><strong>Capping</strong></td>
								<td height="30"><strong>Point</strong></td>
								<td height="30"><strong>R.P</strong></td>
								<td height="30"><strong>Action</strong></td>
							</tr>
							<?php
							$Row = 'evenrow';
							while($line = $obj->fetchNextObject($packages)){
								if($Row == 'oddrow')
								$Row = 'evenrow';
								else 
								$Row = 'oddrow';
							if(!empty($packageDetails)){
							if($packageDetails->pid != $line->pid){								
							?>
							<tr class="<?php echo $Row; ?>"> 
								<td height="30"><?php echo ucfirst($line->package_name);?></td>
								<td height="30"><?php echo $line->package_capping;?></td>
								<td height="30"><?php echo $line->package_point;?></td>
								<td height="30"><?php echo $line->package_rp;?></td>
								<td height="30"><a href="update_package.php?pid=<?php echo $line->pid;?>" onclick="if(confirm('Are you sure want to change package.')) { return true;} else { return false; }">Assign</a></td>
							</tr>
							<?php }
								}else{?>
								<tr class="<?php echo $Row; ?>"> 
								<td height="30"><?php echo ucfirst($line->package_name);?></td>
								<td height="30"><?php echo $line->package_capping;?></td>
								<td height="30"><?php echo $line->package_point;?></td>
								<td height="30"><?php echo $line->package_rp;?></td>
								<td height="30"><a href="update_package.php?pid=<?php echo $line->pid;?>" onclick="if(confirm('Are you sure want to change package.')) { return true;} else { return false; }">Assign</a></td>
							</tr>
								<?php }
								}
							?>
							<tr align="left"> 
								<td height="30" colspan="5" class="boxheadbg"></td>
							</tr>		
						</table>
					</td>
				</tr>
				<?php 
				if(!empty($packageDetails)){?>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Package Name:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><?php echo ucfirst($packageDetails->package_name);?></td>
				</tr>				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">Capping:&nbsp;</td>
					<td height="24" align="left"><?php echo $packageDetails->package_capping;?> </td>
				</tr>
				<tr class="oddrow">
					<td height="35" align="right"  class="bldTxt">Point:&nbsp;</td>
					<td height="24" align="left"><?php echo $packageDetails->package_point;?></td>
				</tr>
				<tr class="evenrow">
					<td height="35" align="right"  class="bldTxt">R.P Value :&nbsp;</td>
					<td height="24" align="left"><?php echo $packageDetails->package_rp;?></td>
				</tr>
				<?php
				}else{?>
				<tr class="evenrow">
					<td height="35" align="left" colspan="4"  class="bldTxt">No Package assign yet.</td>
					
				</tr>
				<?php
				}?>				
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
<script>
	$('#PackageArea').click(function(){ 
		$('#packageDisplayArea').slideToggle();
	});
</script>
</body>
</html>
