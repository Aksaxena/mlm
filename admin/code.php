<?php 
session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/functions.inc.php");
require_once("../lib/pagingClass.php");
require_once("../lib/classes/Package.php");
require_once("../lib/classes/User.php");
$PackageObj = new Package();
$userObj = new User();
$adminObj=new Admin();
$adminObj->validateAdmin();

if( isset($_GET['package']) && $_GET['package'] != null){
$line = $PackageObj->getPackage(intval($_GET['package']));
$tokens 	= $PackageObj->fetchToken($_GET);
$AllTokens = $PackageObj->fetchAllToken(intval($_GET['package'])); 
$pagingObj = new PagingClass2($obj->NumRows($AllTokens),10);
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
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<link rel="stylesheet" href="uikit/css/uikit.min.css" />
<link rel="stylesheet" href="lib/css/jquery-ui.css">
<script src="lib/js/jquery.js" language="javascript"></script>
<script src="lib/js/common.js" language="javascript"></script>
<script src="lib/js/jquery-ui.js"></script>
<script>
  $(function() {
    $( document ).tooltip();
  });
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
	<?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
	<tr>
           <td height="21" align="left" class="txt">
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="title">
                    <tr>
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;<?php echo ucfirst($line->package_name);?> >> User Code </td>
                      <td width="27%" align="right" style="padding-right:20px; ">
 <form action="" method="get" enctype="multipart/form-data" name="frm" onsubmit="return validateFrm(this);">
			  <input type="hidden" name="submitForm" value="yes">
				<input type="hidden" name="package" value="<?php if(isset($_GET['package'])) echo $_GET['package'];?>">
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="title">
                    <tr>
                      <td width="27%" align="left" style="padding-right:20px; "> 
					  <input type="text" id="searchQry" value="<?php if(isset($_GET['searchQry'])) echo $_GET['searchQry'];?>" name="searchQry" placeholder="Search Here" />&nbsp;&nbsp;&nbsp;<button class="uk-button" type="submit"  style="cursor:pointer;">Search</button> 
				      </td>
					                      </tr>
              </table>
			  </form>
					  
				      </td>
                    </tr>
              </table>
			</td>
        </tr>
		 <tr>
            <td height="530"  align="center" valign="top" class="top5">
              <form action="" method="post" enctype="multipart/form-data" name="frm" onsubmit="return validateFrm(this);">
			  <input type="hidden" name="submitForm" value="yes">
				<table width="98%"  align="center" border="0" cellspacing="0" cellpadding="0" class="greyBorder">
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
				<tr align="left"> 
					<td height="30" width="20%" class="boxheadbg_title">&nbsp;&nbsp;
				    S.No</td>
                     <td height="30" width="20%" class="boxheadbg_title">&nbsp;&nbsp;
				    Code</td>
					<td height="30" width="20%" class="boxheadbg_title">&nbsp;&nbsp;
				    Avaibility<?php echo sort_column('status');?></td>                    
					<td height="30" width="20%" class="boxheadbg_title">&nbsp;&nbsp;
				    Sponsor Id</td>                    
					<td height="30" width="20%" class="boxheadbg_title">&nbsp;&nbsp;
				    User Name</td>                    
				</tr>
				<?php 
				$ClassName = 'oddrow';
				if($obj->NumRows($tokens) > 0){
				$i=1;
				while($token = $obj->fetchNextObject($tokens)){					
				if($ClassName == 'oddrow')
				$ClassName = 'evenrow';
				else 
				$ClassName = 'oddrow';
				$user = $userObj->getUserByPin($token->token);
				
				?>
				<tr class="<?php echo $ClassName; ?>">                	
                    <td height="30" width="20%"><?php echo $i; ?></td>
                     <td height="30" width="20%"><?php echo $token->token;?></td>
					 <td height="30" width="20%">
					 	<?php 
							if($token->status == 1){
								echo '<span style="color:green;padding:5px;" title="Available">Available</span>';								
							}else if($token->status == 2){
								echo '<span style="color:red;padding:5px;" title="Assigned to user">Assigned</span>';
							}
							else{
								echo '<span style="color:red;padding:5px;" title="Not Available">Used</span>';
							}
						?>
					 </td>
					 <td height="30" width="20%"><?php if(isset($user->sponsor_id)) echo $user->sponsor_id;  else echo 'N/A';?></td>
					 <td height="30" width="260%"><?php if(isset($user->username)) echo $user->username; else echo 'N/A';?></td>
					 	<?php $i++; }
						 } else {?>
						<td colspan="3">No code available.</td>
						<?php
						}
						?>
                </tr>
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

			  </form>
		   </td>
       </tr>
     </table>
	</td>
  </tr>
</table>
<?php include("footer.inc.php");?>
<script>
$('.Statustoggle').click(function(){ 
	var obj = $(this);
	var action = $(this).attr('type');
	
	var id = $(this).attr('rel');
	var data = 'pid='+id+'&action='+action;
	$.post('package.php',data,function(response){
		if(response == 'success'){ 
			window.location.reload(true);
		}
	});
});
</script>
</body>
</html>
