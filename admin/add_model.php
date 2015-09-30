<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/classes/Content.php");
require_once("../lib/simpleimage.php");
$adminObj=new Admin();
$ContentObj = new Content();
$ImageObj = new SimpleImage();
$adminObj->validateAdmin();
	if(isset($_POST['submitForm'])){
	 if(empty($_POST['ModelId'])){
	
		if($_FILES['model_master_image']['error'] == 0){
		 $ModelName = mysql_real_escape_string($_POST['model_name']);
		 $ModelMasterImage = time('his').$_FILES['model_master_image']['name'];
		 $path = "../uploaded_images/$ModelMasterImage";
		 $thumbPath = "../uploaded_images/thumb/$ModelMasterImage";
		 move_uploaded_file($_FILES['model_master_image']['tmp_name'],$path);
		 $ImageObj->load($path);
		 $ImageObj->resize(300,300);
		 $ImageObj->save($thumbPath);
		 $obj->query("insert into tbl_model set model_name='$ModelName',model_master_image	='$ModelMasterImage',status=1,add_date=CURDATE()");
		  $modelId = mysql_insert_id();
		 $obj->query("insert into tbl_model_cover_photo set model_id = '$modelId' , cover_image_name = '$ModelMasterImage' , status=1 , add_date=CURDATE()");
		 
		 $commonObj->pushMessage("Model has been uploaded successfully.");
		$commonObj->wtRedirect("models.php");
		}
		else {
		$commonObj->pushError("Opps!Error in file uploading try again.");
		}
	  }
	  else {	  	
		if($_FILES['model_master_image']['error'] == 0){
		 $ModelName = mysql_real_escape_string($_POST['model_name']);
		 $ModelMasterImage = time('his').$_FILES['model_master_image']['name'];
		 $model_desc = mysql_real_escape_string($_POST['model_desc']);
		 $path = "../uploaded_images/$ModelMasterImage";
		 $thumbpath = "../uploaded_images/thumb/$ModelMasterImage";
		 move_uploaded_file($_FILES['model_master_image']['tmp_name'],$path);
		 $ImageObj->load($path);
		 $ImageObj->resize(300,300);
		 $ImageObj->save($thumbpath);		 
		 $obj->query("INSERT INTO tbl_model_pics set model_id=".$_POST['ModelId'].",model_image_name	='$ModelMasterImage',model_desc = '$model_desc',status=1,add_date=CURDATE()");
		 $commonObj->pushMessage("Gallery image uploaded successfully.");
		$commonObj->wtRedirect("gallery.php?mid=".$_POST['ModelId']);
		}
		else {
		$commonObj->pushError("Opps!Error in file uploading try again.");
		}
	  }
	}
	if(isset($_GET['Model_Id'])){
	$model = $ContentObj->GetModelDetail($_GET['Model_Id']);
	$modelCover = $ContentObj->GetModelCover($_GET['Model_Id']);
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
	if(obj.model_name.value == ''){
	str += "=>Please enter model name.<br>";
	}
	if(obj.model_master_image.value == ''){
	str += "=>Please select model image.<br>";
	}
	if(obj.model_master_image.value != ''){
	var img = document.getElementById('model_master_image').value;
	var extsn = img.split('.');
	
	if(extsn[1] =='jpg' || extsn[1] =='png' || extsn[1] =='jpeg' || extsn[1] =='gif'){
	} else {
	str += "=>Please upload (jpg,png,gif) extension image file";
	}
	}
	<?php 
	if(!empty($_GET['Model_Id'])){?>
	if(obj.model_desc.value == ''){
	str += '=>Please enter model description.';
	}
	<?php } ?>
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
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;Model Manager </td>
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
			  <input type="hidden" name="ModelId" value="<?php echo $_GET['Model_Id']; ?>">
			  
				
							<?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    <?php
					if(empty($_GET['Model_Id']))
					echo "Add New Model";
					else 
					echo "Add more pics";
                    ?>
					</td>
				</tr>

				<tr align="right" class="evenrow">
					<td height="32" colspan="2" class="txt pad-right10"><span class="warning">*</span> - Required Fields</td>
				</tr>
                  <?php if(is_file("../uploaded_images/thumb/".stripslashes($modelCover->cover_image_name))){?>
                  <td width="35%" height="35" align="right"  class="bldTxt">&nbsp;</td>
                  <td width="35%" height="35" align="left"  class="bldTxt">
                <img src="../uploaded_images/thumb/<?php echo stripslashes($modelCover->cover_image_name); ?>" border="0" />
                </td>
                <?php } ?>
				<tr class="oddrow">
              
					<td width="35%" height="35" align="right"  class="bldTxt">Model Name:&nbsp;</td>
					<td width="65%" height="24" align="left" class="txt"><input type="text" name="model_name" id="model_name" class="input" value="<?php echo ucfirst($model->model_name); ?>" /><span class="warning">*</span></td>
				</tr>				
				<tr class="evenrow">
					<td height="34" align="right" class="bldTxt">Model Image:&nbsp;</td>
					<td height="34" align="left">
                    <input type="file" name="model_master_image" id="model_master_image" />
					<span class="warning">*</span></td>
				</tr>
                <?php 
				if(!empty($_GET['Model_Id'])){
				?>
                <tr class="<?php if(!empty($_GET['Model_Id']))echo "oddrow";else echo "evenrow"; ?>">
					<td height="34" align="right" class="bldTxt">Model Description:&nbsp;</td>
					<td height="34" align="left">
                    <textarea id="model_desc" name="model_desc" cols="30" rows="6"></textarea>
					<span class="warning">*</span></td>
				</tr>
                <?php } ?>
				<tr class="<?php if(!empty($_GET['Model_Id']))echo "evenrow";else echo "oddrow"; ?>">
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
