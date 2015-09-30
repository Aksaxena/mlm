<?php session_start();
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/classes/User.php");
require_once("../lib/functions.inc.php");
require_once("../lib/pagingClass.php");
$UserObj = new User();
$adminObj=new Admin();
$adminObj->validateAdmin();
$UserList = $UserObj->fetchAll($_GET);

$pagingObj = new PagingClass2($obj->NumRows($UserObj->fetchAllUsers()),10);
// user want to change status as Active or Inactive
if((isset($_GET['uid']) && $_GET['uid'] != null) && (isset($_GET['q']) && $_GET['q'] == 'trash')){
	$UserObj->statusRemove(intval($_GET['uid']));
}

// when user want to remove and transfer in trash
if((isset($_POST['uid']) && $_POST['uid'] != null) && (isset($_POST['action']) && $_POST['action'] != null)){
	$result = $UserObj->modifyStatus($_POST);
	echo $result;
	die;
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
		   <form action="" method="get" enctype="multipart/form-data" name="frm" onsubmit="return validateFrm(this);">
			  <input type="hidden" name="submitForm" value="yes">
				
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="title">
                    <tr>
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;User Manager </td>
                      <td width="27%" align="left" style="padding-right:20px; "> 
					  <input type="text" id="searchQry" value="<?php if(isset($_GET['searchQry'])) echo $_GET['searchQry'];?>" name="searchQry" placeholder="Search Here" />&nbsp;&nbsp;&nbsp;<button class="uk-button" type="submit"  style="cursor:pointer;">Search</button> 
				      </td>
					  <td width="27%" align="right" style="padding-right:20px; "> 
					  <button class="uk-button" type="button" onclick="document.location='add_user.php'" style="cursor:pointer;">Add</button> 
				      </td>
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
					<td height="30" width="5%" class="boxheadbg_title">&nbsp;&nbsp;
				    S.No </td>
                    <td height="30" width="20%" class="boxheadbg_title">&nbsp;&nbsp;
				    User Name<?php echo sort_column('username');?></td>
					<td height="30" width="8%" class="boxheadbg_title">&nbsp;&nbsp;
				    User Id<?php echo sort_column('uid');?></td>
                     <td height="30" width="10%" class="boxheadbg_title">&nbsp;&nbsp;
				    Parent Id<?php echo sort_column('parent_id');?></td>
                    <td height="30" width="10%" class="boxheadbg_title">&nbsp;&nbsp;
				    Position<?php echo sort_column('position');?></td>
					<td height="30" width="10%" class="boxheadbg_title">&nbsp;&nbsp;
				    Sponsor Id<?php echo sort_column('sponsor_id');?></td>
					<td height="30" width="10%" class="boxheadbg_title">&nbsp;&nbsp;
				    Created<?php echo sort_column('created');?></td>
					<td height="30" width="10%" class="boxheadbg_title">&nbsp;&nbsp;
				    Status<?php echo sort_column('status');?></td>
					<td height="30" width="25%" class="boxheadbg_title">&nbsp;&nbsp;
				    Action</td>
				</tr>
					<?php 
					$ClassName = 'oddrow';
					if($obj->NumRows($UserList) > 0){
					$i=1;
					while($line = $obj->fetchNextObject($UserList)){
					if($ClassName == 'oddrow')
					$ClassName = 'evenrow';
					else 
					$ClassName = 'oddrow';
					?>
				<tr class="<?php echo $ClassName; ?>">
                	<td height="30" width="5%" align="center"><?php echo $i; ?> </td>
                    <td height="30" width="20%"><?php echo ucfirst($line->username); ?></td>
					<td height="30" width="8%"><?php echo 'SM100'.$line->uid; ?></td>
                     <td height="30" width="10%"><?php if(isset($line->parent_id))echo $line->parent_id; else echo 'N/A'; ?></td>
                    <td height="30" width="10%" align="center"><?php if($line->position == 1) echo 'Right'; else echo 'Left'; ?></td>
					<td height="30" width="10%" align="center"><?php if(!empty($line->sponsor_id)) echo $line->sponsor_id; else echo 'N/A'; ?></td>
					<td height="30" width="10%" align="center"><?php echo date('d-m-Y',strtotime($line->created)); ?></td>
					<td height="30" width="10%" align="center">
					<?php 
					if($line->status == 1 && $line->user_pin != '') {
						 echo '<a href="javascript:void(0)" style="color:green;" class="Statustoggle" type="inactive" rel="'.$line->uid.'">Active</a>';
					}else {
					 	echo '<a href="javascript:void(0)" class="Statustoggle" style="color:red;" type="active" rel="'.$line->uid.'">Inactive</a>';
					 }
					 ?>
					</td>
					
					<td height="30" width="25%" align="center">
					<a href="add_user.php?uid=<?php echo $line->uid;?>"><i class="uk-icon-pencil-square-o uk-icon-small"></i></a> | <a href="user.php?q=trash&uid=<?php echo $line->uid;?>" onclick="if(confirm('Are you sure remove it?')) { return true;} else { return false; }"><i class="uk-icon-trash-o uk-icon-small"></i></a> | <a href="javascript:void(0);" title="<?php $statusPos =  $UserObj->getTreePosition('SM100'.$line->uid); echo $statusPos['String']?>"><i class="uk-icon-info uk-icon-small"></i></a> | <a href="assign-pin.php?uid=<?php echo $line->uid;?>" title="Assign pin"><i class="uk-icon-paperclip uk-icon-small"></i></a> | <a href="user-assign-pin-list.php?uid=<?php echo $line->uid;?>" title="View pin"><i class="uk-icon-level-down uk-icon-small"></i></a> | <a href="my-wallet.php?uid=<?php echo $line->uid;?>" title="View Wallet"><i class="uk-icon-money uk-icon-small"></i></a> 	 	
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
<?php include("footer.inc.php");?>
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
