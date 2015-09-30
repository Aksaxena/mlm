<?php session_start();
/*$seed = str_split('abcdefghijklmnopqrstuvwxyz'
                     .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                     .'0123456789!@#$%^&*()'); // and any other characters
    shuffle($seed); // probably optional since array_is randomized; this may be redundant
    $rand = '';
    foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];
 
    echo $rand;
	*/
require_once("../lib/config.inc.php");
require_once("../lib/classes/Admin.php");
require_once("../lib/classes/Package.php");
$PackageObj = new Package();
$adminObj=new Admin();
$adminObj->validateAdmin();
$PackageList = $PackageObj->fetchAll();
if((isset($_GET['pid']) && $_GET['pid'] != null) && (isset($_GET['q']) && $_GET['q'] == 'trash')){
$PackageObj->statusRemove(intval($_GET['pid']));
}
if((isset($_POST['pid']) && $_POST['pid'] != null) && (isset($_POST['action']) && $_POST['action'] != null)){
$result = $PackageObj->modifyStatus($_POST);
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
	<?php echo $commonObj->showError(); echo $commonObj->showMessage();	?>
	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
	<tr>
           <td height="21" align="left" class="txt">
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" class="title">
                    <tr>
                     <td width="73%" height="30" valign="middle" class="txt2 pad-left12"><img src="images/admin.png" width="32" height="32" align="absmiddle" />&nbsp;Package Manager </td>
                      <td width="27%" align="right" style="padding-right:20px; ">
 
					  <button class="uk-button" type="button" onclick="document.location='add_package.php'" style="cursor:pointer;">Add</button> 
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
					<td height="30" width="10%" class="boxheadbg_title">&nbsp;&nbsp;
				    S.No </td>
                    <td height="30" width="20%" class="boxheadbg_title">&nbsp;&nbsp;
				    Package Name</td>
                     <td height="30" width="10%" class="boxheadbg_title">&nbsp;&nbsp;
				    Package Point</td>
                    <td height="30" width="10%" class="boxheadbg_title">&nbsp;&nbsp;
				    Capping</td>
					<td height="30" width="10%" class="boxheadbg_title">&nbsp;&nbsp;
				    R.P</td>
					<td height="30" width="10%" class="boxheadbg_title">&nbsp;&nbsp;
				    Status</td>
					<td height="30" width="30%" class="boxheadbg_title">&nbsp;&nbsp;
				    Action</td>
				</tr>
				<?php 
				$ClassName = 'oddrow';
				if($obj->NumRows($PackageList) > 0){
				$i=1;
				while($line = $obj->fetchNextObject($PackageList)){
				if($ClassName == 'oddrow')
				$ClassName = 'evenrow';
				else 
				$ClassName = 'oddrow';
				?>
				<tr class="<?php echo $ClassName; ?>">
                	<td height="30" width="10%" align="center"><?php echo $i; ?> </td>
                    <td height="30" width="20%"><?php echo ucfirst($line->package_name); ?></td>
                     <td height="30" width="10%"><?php echo $line->package_point; ?> point</td>
                    <td height="30" width="10%" align="center"><i class="uk-icon-rupee"></i> <?php echo $line->package_capping; ?></td>
					<td height="30" width="10%" align="center"><?php echo $line->package_rp; ?></td>
					<td height="30" width="10%" align="center">
					<?php 
					if($line->package_status) {
						 echo '<a href="javascript:void(0)" style="color:green;" class="Statustoggle" type="inactive" rel="'.$line->pid.'">Active</a>';
					}else {
					 	echo '<a href="javascript:void(0)" class="Statustoggle" style="color:red;" type="active" rel="'.$line->pid.'">Inactive</a>';
					 }
					 ?>
					</td>
					<td height="30" width="30%" align="center"><a href="add_package.php?pid=<?php echo $line->pid;?>"><i class="uk-icon-pencil-square-o uk-icon-small"></i></a> | <a href="package.php?q=trash&pid=<?php echo $line->pid;?>" onclick="if(confirm('Are you sure remove it?')) { return true;} else { return false; }"><i class="uk-icon-trash-o uk-icon-small"></i></a> | 
					<a href="generate_code.php?package=<?php echo $line->pid;?>">Generate Code</a> | <a href="code.php?package=<?php echo $line->pid;?>">View Code</a>	
					</td>
                </tr>
				<?php $i++;
					}
				}else{				
				 ?>
				 <tr class="oddrow">
                	<td height="30" width="10%" align="center" colspan="7"></td>                    
                </tr>
				 <?php 
				 } ?>
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
