<?php session_start();
require_once("lib/config.inc.php");
require_once("lib/classes/User.php");
require_once("lib/functions.inc.php");
require_once("lib/pagingClass.php");
$userObj = new User();
$commonObj->cleanInput();
$userObj->validateUserLogin();
if($_SESSION['UID']){
	//$id = 'SM100'.;
	$result = $userObj->getUser($_SESSION['UID']);	
	$myWallet = $userObj->getUserWallet($_GET);
	$pagingObj = new PagingClass2($obj->NumRows($userObj->getUserWallet($_GET)),10);	
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
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="admin/images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;<?php echo ucfirst($result->username);?>'s Wallet </td>
                      
					  
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
				    Total Commission<?php echo sort_column('commission_value');?></td>
					<td height="30" width="20" class="boxheadbg">&nbsp;&nbsp;
				    Direct Income<?php echo sort_column('direct_income');?></td>
                     <td height="30" width="15%" class="boxheadbg">&nbsp;&nbsp;
				    Indirect Income<?php echo sort_column('indirect_income');?></td>
                    <td height="30" width="15%" class="boxheadbg">&nbsp;&nbsp;
				    Inactive User</td>
					<td height="30" width="25%" class="boxheadbg">&nbsp;&nbsp;
				    Commission Generate Date<?php echo sort_column('commissin_generate_date');?></td>					
				</tr>
					<?php 
					$ClassName = 'oddrow';
					if($obj->NumRows($myWallet) > 0){
					$i=1;
					while($line = $obj->fetchNextObject($myWallet)){
					if($ClassName == 'oddrow')
					$ClassName = 'evenrow';
					else 
					$ClassName = 'oddrow';
					?>
	
				<tr class="<?php echo $ClassName; ?>">
                	<td height="30" width="5%" align="center"><?php echo $i; ?> </td>
                    <td height="30" width="20%"><?php echo number_format($line->commission_value,2); ?></td>
					<td height="30" width="20%"><?php echo number_format($line->direct_income,2); ?></td>
                     <td height="30" width="15%"><?php echo number_format($line->indirect_income,2); ?></td>
                    <td height="30" width="15%" align="center"><?php echo 'SM100'.$line->inactive_user_id; ?></td>
					<td height="30" width="25%" align="center"><?php echo date('d-m-Y',strtotime($line->commissin_generate_date)); ?></td>
					
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
