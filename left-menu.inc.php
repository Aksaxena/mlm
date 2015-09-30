<div class="user one">
<?php if(!empty($result->profile_image)){?>
<img id="circle" src="<?php echo SITE_URL;?>TimThumb.php?src=<?php echo SITE_URL.'images/users/'.$_SESSION['UID'].'/'.$result->profile_image;?>&h=160&w=160&zc=1" />
<?php
}else{?>

<img id="circle" src="<?php echo SITE_URL;?>TimThumb.php?src=<?php echo SITE_URL;?>images/user-profile-default.png&h=150&w=150&zc=3" />
<?php } ?>
</div>

<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="right">
<tr>
	<td height="50" align="left" class="menuLeft"><div class="menuBoldText"><a href="package.php" class="menuLinks">Manage Package</a></div>	
	</td>
</tr>

<tr>
	<td height="50" align="left" class="menuLeft"><div class="menuBoldText"><a href="user-assign-pin-list.php" class="menuLinks">View Pin</a></div>	
	</td>
</tr>

<tr>
	<td height="50" align="left" class="menuLeft"><div class="menuBoldText"><a href="profile.php" class="menuLinks">Manage Profile</a></div>

	
	</td>
</tr> 
<tr>
	<td height="50" align="left" class="menuLeft"><div class="menuBoldText"><a href="my-wallet.php" class="menuLinks">My Wallet</a></div></td>
</tr> 

<tr>
	<td height="50" align="left" class="menuLeft"><div class="menuBoldText"><a href="my-position-level.php" class="menuLinks">View Position</a></div></td>
</tr> 

<tr>
	<td height="50" align="left" class="menuLeft"><div class="menuBoldText"><a href="change-password.php" class="menuLinks">Change Password</a></div>
	</td>
</tr> 

<tr>
	<td height="30" align="left" class="menuLeft"><a href="logout.php" class="menuBoldText">Logout</a></td>
</tr>

<tr>
	<td><img src="admin/images/spacer.gif" width="1" height="1" /></td>
</tr>
</table>

