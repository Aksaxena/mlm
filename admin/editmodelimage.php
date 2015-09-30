<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/classes/Content.php");
require_once("../lib/simpleimage.php");
$adminObj=new Admin();
$ContentObj = new Content();
$ImageObj = new SimpleImage();
$adminObj->validateAdmin();
	if($_POST['submitForm'] == 'Yes'){
	  $ModelName = $_FILES['model_master_image']['name'];
	   $Id = intval($_POST['InnerId']);	
	   $ModelId = intval($_POST['ModelInnerId']);
	  	if($ModelName != ''){				
			 if($_FILES['model_master_image']['error'] == 0){
			 $ModelMasterImage = time('his').$_FILES['model_master_image']['name'];
			 $model_desc = mysql_real_escape_string($_POST['model_desc']);
			 $path = "../uploaded_images/$ModelMasterImage";
			 $thumbpath = "../uploaded_images/thumb/$ModelMasterImage";
			 move_uploaded_file($_FILES['model_master_image']['tmp_name'],$path);
			 $ImageObj->load($path);
			 $ImageObj->resize(300,300);
			 $ImageObj->save($thumbpath);		 
			 $obj->query("UPDATE tbl_model_pics set model_image_name	='$ModelMasterImage',model_desc = '$model_desc' WHERE id='$Id' AND model_id='$ModelId'");
			 }
			
		} else {
		$model_desc = mysql_real_escape_string($_POST['model_desc']);
		$obj->query("UPDATE tbl_model_pics set model_desc = '$model_desc' WHERE id='$Id' AND model_id='$ModelId'");
		}
		$commonObj->pushMessage("Gallery image has been updated successfully.");
		$commonObj->wtRedirect("gallery.php?mid=$ModelId");
	  }
	
	if(isset($_GET['ModelInnerId']) && isset($_GET['Id'])){
	$Id = intval($_GET['Id']);	
	$ModelId = intval($_GET['ModelInnerId']);
	$InnerModel = $ContentObj->GetModelInnerDetail($Id,$ModelId);
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
<script src="lib/js/jquery.js" language="javascript"></script>
<script src="fancybox/jquery.fancybox-1.3.4.pack.js" language="javascript"></script>
<script src="lib/js/common.js" language="javascript"></script>
<script>
function validateFrm(obj){
var msg = "<font color='red'>=>Following is missing.</font><br>";
var str = '';
	
	if(obj.model_master_image.value != ''){
	var img = document.getElementById('model_master_image').value;
	var extsn = img.split('.');
	
	if(extsn[1] =='jpg' || extsn[1] =='png' || extsn[1] =='jpeg' || extsn[1] =='gif'){
	} else {
	str += "=>Please upload (jpg,png,gif) extension image file";
	}
	}
	
	
	if(obj.model_desc.value == ''){
	str += '=>Please enter model description.';
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
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;Gallery Manager </td>
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
	<input type="hidden" name="InnerId" value="<?php echo $_GET['Id']; ?>">
    <input type="hidden" name="ModelInnerId" value="<?php echo $_GET['ModelInnerId']; ?>">
			  
				
							<?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    Edit Gallery
					</td>
				</tr>

				<tr align="right" class="evenrow">
					<td height="32" colspan="2" class="txt pad-right10"><span class="warning">*</span> - Required Fields</td>
				</tr>
                  <?php if(is_file("../uploaded_images/thumb/".stripslashes($InnerModel->model_image_name))){?>
                  <td width="35%" height="35" align="right"  class="bldTxt">&nbsp;</td>
                  <td width="35%" height="35" align="left"  class="bldTxt">
                <img src="../uploaded_images/thumb/<?php echo stripslashes($InnerModel->model_image_name); ?>" border="0" />
                </td>
                <?php } ?>
								
				<tr class="evenrow">
					<td height="34" align="right" class="bldTxt">Model Image:&nbsp;</td>
					<td height="34" align="left">
                    <input type="file" name="model_master_image" id="model_master_image" />
					<span class="warning">*</span></td>
				</tr>
                
                <tr class="oddrow">
					<td height="34" align="right" class="bldTxt">Model Description:&nbsp;</td>
					<td height="34">
                    <textarea id="model_desc" name="model_desc" cols="40" rows="6">
                    <?php echo stripslashes($InnerModel->model_desc); ?>
                    </textarea><span class="warning">*</span>
					</td>
				</tr>
                
				<tr class="evenrow">
				  <td height="34" align="right" class="bldTxt">&nbsp;</td>
				  <td height="34" align="left"><input type="submit" value="Submit" class="button" /></td>
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
