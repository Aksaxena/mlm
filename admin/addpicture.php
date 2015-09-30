<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/simpleimage.php");
$adminObj=new Admin();
$adminObj->validateAdmin();
$commonObj->cleanInput();
$image= new SimpleImage();

if($_POST['submitForm']=="yes"){
	if($_FILES['picture']['size'] > 0 && $_FILES['picture']['error']==0){
	echo $img=time(his).$_FILES['picture']['name'];
	move_uploaded_file($_FILES['picture']['tmp_name'],"../img/".$img);
	copy("../img/".$img,"../img/thumb/".$img);
	$image->load($img);
	$image->resize(120,120);
	$image->save($img);
	unlink("../img/".$img);
	}
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
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen">
<script src="fancybox/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js" language="javascript"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js" language="javascript"></script>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<script language="javascript" type="text/javascript">
function validateFrm(obj) {
var msg ="<strong>Following is missing.<br></strong>";
var str="";
	if(obj.picture.value==''){
	str += "Please upload picture.<br>";
	}
	else if(obj.picture.value != ''){
	ext=document.getElementById('picture').value.split('.');
	if(ext[1]!='jpg' && ext[1]!='png' && ext[1]!='gif')
	{
	str += "wrong file format.<br>";
	}
	}
	if(str){
	$.fancybox(msg+str);
	return false;
	}
}
</script>

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
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;Admin Manager </td>
                      <td width="27%" align="right" style="padding-right:20px; ">&nbsp; 
					   
				      </td>
                    </tr>
              </table>
			</td>
        </tr>
		 <tr>
            <td height="530"  align="center" valign="top" class="top5">
              <form action="" method="post" enctype="multipart/form-data" name="frm" onsubmit="return validateFrm(this);">
			  <input type="hidden" name="submitForm" value="yes">
			 
			  
				
							<?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    Change Email </td>
				</tr>

				<tr align="right" class="evenrow">
					<td height="32" colspan="2" class="txt pad-right10"><span class="warning">*</span> - Required Fields</td>
				</tr>				
				<tr class="evenrow">
					<td width="35%" height="34" align="right" class="bldTxt">Picture:&nbsp;</td>
					<td width="65%" height="34" align="left"><input type="file" name="picture" id="picture"  class="input"  value="<?php echo stripslashes ($result->email);?>"/> 
					<span class="warning">*</span></td>
				</tr>
				<tr class="oddrow">
				  <td height="34" align="right" class="bldTxt">&nbsp;</td>
				  <td height="34" align="left"><input type="submit" value="Upload" class="button" /></td>
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
