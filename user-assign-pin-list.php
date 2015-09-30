<?php session_start();
require_once("lib/config.inc.php");
require_once("lib/classes/User.php");
require_once("lib/functions.inc.php");
require_once("lib/pagingClass.php");
require_once("lib/classes/Package.php");
$packageObj = new Package();
$UserObj = new User();
if($_SESSION['UID']){
	$result = $UserObj->getUser(intval($_SESSION['UID']));
	$TokenList = $UserObj->AssignedUsersPin($_GET,'front');
	$pagingObj = new PagingClass2($obj->NumRows($UserObj->fetchAllAssignedUsersPin(intval($_SESSION['UID']))),10);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//Dtd XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/Dtd/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ucfirst(SITE_TITLE);?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<link rel="stylesheet" href="admin/uikit/css/uikit.min.css" />
<link rel="stylesheet" href="admin/lib/css/jquery-ui.css">


<script src="admin/lib/js/jquery-ui.js"></script>
<script>
  $(function() {
    $( document ).tooltip();
  });
  </script>
<?php include("header.php")?>
				  
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
	<?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
	<tr>
           <td height="21" align="left" class="txt">
		   <form action="" method="get" enctype="multipart/form-data" name="frm" onsubmit="return validateFrm(this);">
			  <input type="hidden" name="submitForm" value="yes">
				
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="title">
                    <tr>
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="admin/images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;<?php echo ucfirst($result->username);?>'s Assigned Pin </td>
                      
					  
                    </tr>
              </table>
			  </form>
			</td>
        </tr>
		 <tr>
            <td height="530"  align="center" valign="top" class="top5">
              <table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
				
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" width="5%" class="boxheadbg">&nbsp;&nbsp;
				    S.No </td>
                    <td height="30" width="20%" class="boxheadbg">&nbsp;&nbsp;
				    Token<?php echo sort_column('token');?></td>
					<td height="30" width="8%" class="boxheadbg">&nbsp;&nbsp;
				    Package Name<?php echo sort_column('pid');?></td>
					<td height="30" width="8%" class="boxheadbg">&nbsp;&nbsp;
				    Availability<?php echo sort_column('status');?></td>
                     
				</tr>
					<?php 
					$ClassName = 'oddrow';
					if($obj->NumRows($TokenList) > 0){
					$i=1;
					while($line = $obj->fetchNextObject($TokenList)){
					if($ClassName == 'oddrow')
					$ClassName = 'evenrow';
					else 
					$ClassName = 'oddrow';
					?>
				<tr class="<?php echo $ClassName; ?>">
                	<td height="30" width="5%" align="center"><?php echo $i; ?> </td>
                    <td height="30" width="20%"><?php echo $line->token; ?></td>
					<td height="30" width="20%"><?php $packageDetail = $packageObj->getPackage($line->pid); echo $packageDetail->package_name;  ?></td>
					<td height="30" width="8%">
						<?php 
					if($line->status == 2) {
						 echo '<a href="javascript:void(0)" style="color:green;" >Available</a>';
					}else {
					 	echo '<a href="javascript:void(0)"  style="color:red;">Used</a>';
					 }
					 ?>
					</td>                     
                </tr>
				<?php $i++;
					}
				}else{				
				 ?>
				 <tr class="evenrow" align="left">
                	<td colspan="9" height="30">Record Not Found.</td>                    
                </tr>
				 <?php 
				 } ?>
				 <?php 
				$page = 1;
				if(isset($_GET['page'])){
				$page = intval($_GET['page']);
				}
				echo $pagingObj->DisplayPaging($page); ?>
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
<?php include("footer.php");?>
<script>
$('.Statustoggle').click(function(){ 
	var obj = $(this);
	var action = $(this).attr('type');
	
	var id = $(this).attr('rel');
	var data = 'uid='+id+'&action='+action;
	$.post('user.php',data,function(response){
		if(response == 'success'){ 
			window.location.reload(true);
		}
	});
});
</script>
</body>
</html>
