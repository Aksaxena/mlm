<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/classes/Content.php");
$ContentObj = new Content();
$adminObj=new Admin();
$adminObj->validateAdmin();
$ModelDetail = $ContentObj->GetModelDetail(intval($_GET['mid']));
$InnerModelImage = $ContentObj->GetInnerDetail(intval($_GET['mid']));
$NumInnerModel = $obj->NumRows($InnerModelImage);
$CoverImageDetail = $ContentObj->GetCoverDetail(intval($_GET['mid']));
?>
<!DOCTYPE html PUBLIC "-//W3C//Dtd XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/Dtd/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ucfirst(SITE_ADMIN_TITLE);?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<script src="lib/js/jquery.js" language="javascript"></script>
<script src="lib/js/common.js" language="javascript"></script>
<script>
function DelInnerModel(id,model_id){
	if(confirm('Would you like to remove this?')){
window.location = "takeaction.php?RemoveInnerModel=Yes&Id="+id+"&ModelInnerId="+model_id;
	}
}
function EditInnerModel(id,model_id){
window.location = "editmodelimage.php?EditModelImage=Yes&Id="+id+"&ModelInnerId="+model_id;
}
function ApplyCoverPhoto(id,modelid,innerimagename){
if(confirm('Would you like to change cover photo?')){
window.location = "takeaction.php?UpdateCoverPhoto=Yes&Id="+id+"&modelId="+modelid+"&CoverPhotoName="+innerimagename;
}
}
function Action(act,obj){
document.getElementById('actionname').value = act;
document.getElementById('frm').action = 'submitfrm.php';
document.getElementById('frm').submit();
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
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;Gallery Manager</td>
                      <td width="27%" align="right" style="padding-right:20px; ">&nbsp; 
<input type="button" class="button" value="Add Gallery" onclick="document.location='add_model.php?Model_Id=<?php echo $_GET['mid']; ?>'" style="cursor:pointer;" />
				      </td>
                    </tr>
              </table>
			</td>
        </tr>
		 <tr>
            <td height="530"  align="center" valign="top" class="top5">
              <form action="" method="post" enctype="multipart/form-data" name="frm" id="frm" onsubmit="return validateFrm(this);">
			  <input type="hidden" name="submitForm" value="Yes">
              <input type="hidden" name="modelId" value="<?php echo $_GET['mid']; ?>">
							<?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" colspan="2" class="boxheadbg">&nbsp;&nbsp;
				    <?php echo ucfirst($ModelDetail->model_name); ?>  Gallery </td>
				</tr>
				</table>
                <div id="modelbox">                
				<div id="ModelImage"><img src="../uploaded_images/thumb/<?php echo stripslashes($CoverImageDetail->cover_image_name); ?>" border="0" /></div>
                <div style="margin-left:10px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px; color:green; font-weight:bold;">Active Cover Photo</div>
                </div>
                <?php
				if($NumInnerModel > 0){
				while($line = $obj->fetchNextObject($InnerModelImage)){
				?>
                <div id="modelbox">
				<div id="ModelImage"><img src="../uploaded_images/thumb/<?php echo stripslashes($line->model_image_name); ?>" border="0" /></div>
                
                <div id="Attributes">
                <div style="float:left; cursor:pointer;margin-left:10px;"><input type="button" value="Make cover photo" class="button" style="cursor:pointer;" onclick="ApplyCoverPhoto(<?php echo $line->id; ?>,<?php echo $line->model_id; ?>,'<?php echo $line->model_image_name; ?>');" /></div>
               
 
 
  <div style="float:left; cursor:pointer; margin-left:5px;">
<input type="button" value="Delete" class="button" style="cursor:pointer;" onclick="DelInnerModel(<?php echo $line->id; ?>,<?php echo $line->model_id; ?>);" />
</div>

<div style="float:left; cursor:pointer; margin-left:10px; margin-top:5px;">
<input type="button" value="Edit" class="button" style="cursor:pointer;" onclick="EditInnerModel(<?php echo $line->id; ?>,<?php echo $line->model_id; ?>);" />
</div>
 
<?php if($line->status == 1){?>
<div style="float:left; margin-left:5px; margin-top:5px; font-weight:bold; border:1px solid; background-color:white; color:green;  padding:3px;">
<div style="margin:1px;">Active</div>
</div>
<?php } else {?>
<div style="float:left; font-weight:bold; border:1px solid; background-color:white; color:red; margin-left:5px;">
<div style="margin:1px;">Inactive</div>
</div>

<?php } ?>

    <div style="float:left; margin-left:5px;">
    <input type="checkbox" name="modelInnerImage[]" class="button" value="<?php echo $line->id; ?>" />
    </div>

                </div>
                
                </div>
                
                <?php } }else { ?>
                <div style="color:#990000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px;">Sorry ! No any gallery image.</div>
                <?php } ?>
                
                
	</td>
  </tr>
</table>
<div style="width:98%;" align="right">
<input type="hidden" id="actionname" name="actionname" />
<div style="margin-right:15px;float:right;"><input type="button" onclick="Action('Inactive',this);" class="button" style="cursor:pointer;" value="Inactive" /></div>
</div>

<div style="margin-right:15px; float:right;">
<input type="button" style="cursor:pointer;" class="button" value="Active" onclick="Action('Active',this);" /></div>

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
