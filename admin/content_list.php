<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/classes/Content.php");
$adminObj=new Admin();
$adminObj->validateAdmin();
$ContentObj = new Content();
$contentList = $ContentObj->GetAllContent();

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
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;Content Manager </td>
                      <td width="27%" align="right" style="padding-right:20px; "><input type="button" value="Add Content" class="button" onclick="document.location='add_content.php'" style="cursor:pointer;" /> 
					   
				      </td>
                    </tr>
              </table>
			</td>
        </tr>
		 <tr>
            <td height="530"  align="center" valign="top" class="top5">
              <form action="" method="post" enctype="multipart/form-data" name="frm" onsubmit="return validateFrm(this);">
			  <input type="hidden" name="submitForm" value="yes">
			  <input type="hidden" name="submitForm" value="yes">
			  
				
							<?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" width="10%" class="boxheadbg_title">&nbsp;&nbsp;
				    S.No </td>
                    <td height="30" width="20%" class="boxheadbg_title">&nbsp;&nbsp;
				    Title</td>
                     <td height="30" width="50%" class="boxheadbg_title">&nbsp;&nbsp;
				    Content</td>
                    <td height="30" width="20%" class="boxheadbg_title">&nbsp;&nbsp;
				    Action</td>
				</tr>
				<?php 
				$ClassName = 'oddrow';
				$i =1;
				while($line = $obj->fetchNextObject($contentList)){
				if($ClassName == 'oddrow')
				$ClassName = 'evenrow';
				else 
				$ClassName = 'oddrow';
				?>
				<tr class="<?php echo $ClassName; ?>">
                	<td height="30" width="10%" align="center"><?php echo $i; ?> </td>
                    <td height="30" width="20%"><?php echo ucfirst($line->title); ?></td>
                     <td height="30" width="50%"><?php echo stripslashes(substr($line->description,0,200)); ?></td>
                    <td height="30" width="20%" align="center"><a href="add_content.php?c_id=<?php echo $line->id; ?>">Edit</a></td>
                </tr>
				<?php $i++;} ?>
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
