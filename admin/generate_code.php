<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/classes/Package.php");
$PackageObj = new Package();
$adminObj=new Admin();
$adminObj->validateAdmin();
$commonObj->cleanInput();
if(isset($_GET['package'])){
$line = $PackageObj->getPackage(intval($_GET['package']));
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
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<!-- Add jQuery library -->
	<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script src="lib/js/common.js" language="javascript"></script>
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
                     <a href="package.php"><?php echo ucfirst($line->package_name); ?></a> >> Geretate Code</td>
                      <td width="27%" align="right" style="padding-right:20px; ">&nbsp; 
					   
				      </td>
                    </tr>
              </table>
			</td>
        </tr>
		 <tr>
            <td height="530"  align="center" valign="top" class="top5">
              <table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    Generate Code </td>
				</tr>

				<tr align="right" class="evenrow">
					<td height="32" colspan="2" class="txt pad-right10"><span class="warning">*</span> - Required Fields</td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Package Name:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input placeholder="Enter package name" type="text" name="package_name" id="package_name" value="<?php if(isset($line->package_name)) echo $line->package_name; ?>" readonly="readonly" class="input" /></td>
				</tr>
				<tr class="evenrow">
					<td width="35%" height="35" align="right"  class="bldTxt">Number of Code:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input type="text" name="no_code" placeholder="Enter how much code" id="no_code" value="" class="input" /><span class="warning">*</span></td>
				</tr>
				<tr class="oddrow" style="display:none;" id="codeArea">
					<td width="35%" height="35" align="right"  class="bldTxt">Available code:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt">
					<textarea id="generated_code" cols="27" name="generated_code" readonly="readonly"></textarea>
					</td>
				</tr>
				<tr class="oddrow">
					<td width="35%" height="35" align="right"  class="bldTxt">&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt">
					<img src="../images/ajax-loader.gif" id="ajaxLoader" style="display:none;" />
					<button class="uk-button generateCode" rel="<?php if(isset($_GET['package'])) echo $_GET['package']; ?>">Submit</button>					
					</td>
				</tr>
				</table>
	</td>
  </tr>
</table>
		   </td>
       </tr>
     </table>
	</td>
  </tr>
</table>
<?php include("footer.inc.php");?>
<script>
$('.generateCode').click(function(){ 
var msg = "<font color='red'>=>Following is missing.</font><br>";
	var str = '';
	if($('#no_code').val() == ''){
	str += "=>Please enter amount of code.<br>";
	}
	else if($.isNumeric($('#no_code').val()) == false){
        str += "=>Please enter numeric value.";        
    }
	if(str){
	$.fancybox(msg+str);
	return false;
	}

	var obj = $(this);
	var Nocode = $('#no_code').val();	
	var id = $(this).attr('rel');
	
	var data = 'pid='+id+'&Nocode='+Nocode;
	$.ajax({
		  url: 'generate-token.php',
		  type: 'POST',
		  data: data,
		  success: function(response) {
			result = $.parseJSON(response);console.log(result);
				if(result.status == 'success'){ 
					$('#ajaxLoader').hide();
					$('#codeArea').show();
					$('#generated_code').val(result.token);
					obj.hide();
					setTimeout(function(){ window.location = 'code.php?package='+id; }, 1500);
				}
		  },  
		  beforeSend: function( xhr ) {
			obj.hide()
			$('#ajaxLoader').show();
		  }
		});
});
</script>
</body>
</html>
