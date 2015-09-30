<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
$adminObj=new Admin();
$adminObj->validateAdmin();
$commonObj->cleanInput();

if(isset($_POST['submitForm']) && $_POST['submitForm']=="yes"){
	$adminObj->InsertCommission($_POST);
}

if($_SESSION['SESS_UID']){
	$sql=$adminObj->query("select * from ".TBL_PREFIX."_admin where id=".$_SESSION['SESS_UID']);
	$result  = $adminObj->fetchNExtObject($sql);
	$CommSql = $adminObj->query("select * from ".TBL_PREFIX."_commission_setting where 1 = 1");
	$Comm    = $adminObj->fetchNExtObject($CommSql);
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
<script>
$(function() {
    $( "#date_of_birth" ).datepick();
  });
function validateFrm(obj){ 
var msg = "<font color='red'>=>Following is missing.</font><br>";
var str = '';

	if(obj.tds.value == ''){
	str += "=>Please enter tds value.<br>";
	}
	else if(jQuery.isNumeric(obj.tds.value) == false){
        str += "=>Tds value is not numeric.<br>";        
    }
	if(obj.admin_charge.value == ''){
	str += "=>Please enter admin charge.<br>";
	}
	else if(jQuery.isNumeric(obj.admin_charge.value) == false){
        str += "=>Admin charge is not numeric.<br>";        
    }
	if(obj.recharge.value == ''){
	str += "=>Please enter recharge value.<br>";
	}
	else if(jQuery.isNumeric(obj.recharge.value) == false){
        str += "=>Recharge value is not numeric.<br>";        
    }
	
	if(obj.point_value.value == ''){
	str += "=>Please enter point value.<br>";
	}
	else if(jQuery.isNumeric(obj.point_value.value) == false){
        str += "=>Point value is not numeric.<br>";        
    }

	if(obj.franchises_value.value == ''){
	str += "=>Please enter franchises value.<br>";
	}
	else if(jQuery.isNumeric(obj.franchises_value.value) == false){
        str += "=>Franchises value is not numeric.<br>";        
    }
	if(obj.direct_income.value == ''){
	str += "=>Please enter direct income.<br>";
	}
	else if(jQuery.isNumeric(obj.direct_income.value) == false){
        str += "=>Direct income value is not numeric.<br>";        
    }
	if(obj.indirect_income.value == ''){
	str += "=>Please enter indirect income.<br>";
	}
	else if(jQuery.isNumeric(obj.indirect_income.value) == false){
        str += "=>Indirect income value is not numeric.<br>";        
    }
	if(obj.capping_income.value == ''){
	str += "=>Please enter capping value.<br>";
	}
	else if(jQuery.isNumeric(obj.capping_income.value) == false){
        str += "=>Capping value is not numeric.<br>";        
    }
	if(str){
	$.fancybox(msg+str);
	return false;
	}
}
</script>
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
				    Commission Setting</td>
				</tr>

				<tr align="right" class="evenrow">
					<td height="32" colspan="2" class="txt pad-right10"><span class="warning">*</span> - Required Fields</td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">TDS:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input value="<?php if(isset($Comm->tds)) echo $Comm->tds;?>" type="text" placeholder="Enter value in percentge." name="tds" id="tds" size="45" class="input" /><span class="warning">*</span></td>
				</tr>				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">Admin Charge:&nbsp;</td>
					<td height="24" align="left"><input type="text" name="admin_charge" value="<?php if(isset($Comm->admin_charge)) echo $Comm->admin_charge;?>" placeholder="Enter value in percentge." id="admin_charge" size="45" class="input" /> 
					<span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
					<td height="35" align="right"  class="bldTxt">Recharge:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php if(isset($Comm->recharge)) echo $Comm->recharge;?>" name="recharge" placeholder="Enter value in percentge." id="recharge" size="45" class="input" /> 
					<span class="warning">*</span></td>
				</tr>				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">Point Value:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php if(isset($Comm->point_value)) echo $Comm->point_value;?>" name="point_value" placeholder="Enter point value." id="point_value" size="45" class="input" /> 
					<span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
					<td height="35" align="right" class="bldTxt">Franchises:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php if(isset($Comm->franchies)) echo $Comm->franchies;?>" name="franchises_value" placeholder="Enter value in percentge." id="franchises_value" size="45" class="input" /> 
					<span class="warning">*</span></td>
				</tr>				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">Direct Income:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php if(isset($Comm->direct_income)) echo $Comm->direct_income;?>" placeholder="Enter value in percentge." name="direct_income" id="direct_income" size="45" class="input" /> 
					<span class="warning">*</span></td>
				</tr>
				
				<tr class="oddrow">
					<td height="35" align="right" class="bldTxt">Indirect Income:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php if(isset($Comm->indirect_income)) echo $Comm->indirect_income;?>" placeholder="Enter value in percentge." name="indirect_income" id="indirect_income" size="45" class="input" /> 
					<span class="warning">*</span></td>
				</tr>
				
				<tr class="evenrow">
					<td height="35" align="right" class="bldTxt">Capping:&nbsp;</td>
					<td height="24" align="left"><input type="text" value="<?php if(isset($Comm->capping)) echo $Comm->capping;?>" placeholder="Enter capping value in rupees." name="capping_income" id="capping_income" size="45" class="input" /> 
					<span class="warning">*</span></td>
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
</table>
<?php include("footer.inc.php");?>
</body>
</html>
