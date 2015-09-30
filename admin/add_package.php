<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/classes/Package.php");
$PackageObj = new Package();
$adminObj=new Admin();
$adminObj->validateAdmin();
$commonObj->cleanInput();
if(isset($_POST['submitForm']) && $_POST['submitForm'] == 'Yes'){
	if(!empty($_POST['pid']) && $_POST['pid'] != null){
	  $PackageObj->updatePackage($_POST);
	} else {
	$PackageObj->AddPackage($_POST);
	}
}
if(isset($_GET['pid'])){
$line = $PackageObj->getPackage(intval($_GET['pid']));
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

<script src="lib/js/common.js" language="javascript"></script>
<!--
<script language="javascript" type="text/javascript" src="../lib/tinyfck-0.16/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,flash,searchreplace,print,paste,directionality,fullscreen,noneditable,contextmenu",
		theme_advanced_buttons1_add_before : "save,newdocument,separator",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor,liststyle",
		theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "hr[class|width|size|noshade]",
		file_browser_callback : "fileBrowserCallBack",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
		apply_source_formatting : true
	});

	function fileBrowserCallBack(field_name, url, type, win) {
		var connector = "../../filemanager/browser.html?Connector=connectors/php/connector.php";
		var enableAutoTypeSelection = true;

		var cType;
		tinyfck_field = field_name;
		tinyfck = win;

		switch (type) {
			case "image":
				cType = "Image";
				break;
			case "flash":
				cType = "Flash";
				break;
			case "file":
				cType = "File";
				break;
		}

		if (enableAutoTypeSelection && cType) {
			connector += "&Type=" + cType;
		}

		window.open(connector, "tinyfck", "modal,width=600,height=400");
	}
	
</script>-->
<script>
function validateFrm(obj){ 
var msg = "<font color='red'>=>Following is missing.</font><br>";
var str = '';

	if(obj.package_name.value == ''){
	str += "=>Please enter package name.<br>";
	}
	
	if(obj.package_point.value == ''){
	str += "=>Please enter package point.<br>";
	}
	if(obj.package_capping.value == ''){
	str += "=>Please enter package capping.<br>";
	}
	if(obj.package_rp.value == ''){
	str += "=>Please enter package r.p.<br>";
	}
	
	if(str){
	$.fancybox(msg+str);
	return false;
	}
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
                     <a href="package.php">Package Manager</a> >><?php if(isset($_GET['pid'])) echo "Edit Package"; else echo"Add Package"; ?> </td>
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
			  <input type="hidden" name="pid" value="<?php if(isset($_GET['pid'])) echo $_GET['pid']; ?>">
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    <?php if(isset($_GET['pid'])) echo "Edit Package"; else echo"Add Package"; ?> </td>
				</tr>

				<tr align="right" class="evenrow">
					<td height="32" colspan="2" class="txt pad-right10"><span class="warning">*</span> - Required Fields</td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Package Name:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input placeholder="Enter package name" type="text" name="package_name" id="package_name" value="<?php if(isset($line->package_name)) echo $line->package_name; ?>" class="input" /><span class="warning">*</span></td>
				</tr>
				<tr class="evenrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Package Point:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input type="text" name="package_point" placeholder="Enter package title" id="package_point" value="<?php if(isset($line->package_point)) echo $line->package_point; ?>" class="input" /><span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Package Capping:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input type="text" name="package_capping" id="package_capping" placeholder="Enter package capping value" value="<?php if(isset($line->package_capping)) echo $line->package_capping; ?>" class="input" /><span class="warning">*</span></td>
				</tr>
				<tr class="evenrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Package R.P:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input type="text" name="package_rp" id="package_rp" value="<?php if(isset($line->package_rp)) echo $line->package_rp; ?>" class="input" placeholder="Enter package r.p" /><span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt">
					<?php 
					if(isset($_GET['pid'])){?>
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
