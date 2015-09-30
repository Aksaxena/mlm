<link rel="stylesheet" href="admin/lib/css/jquery-ui.css">
<!-- Add jQuery library -->
	<script type="text/javascript" src="admin/fancybox/lib/jquery-1.10.1.min.js"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="admin/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="admin/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />

<script src="admin/lib/js/common.js" language="javascript"></script>
<script src="admin/lib/js/jquery-ui.js"></script>

<link rel="stylesheet" type="text/css" href="admin/lib/css/jquery.datepick.css"> 
<script type="text/javascript" src="admin/lib/js/jquery.plugin.js"></script> 
<script type="text/javascript" src="admin/lib/js/jquery.datepick.js"></script>

<script>
  $(function() {
    $( document ).tooltip();
  });
  </script>

  <div class="header-section">
    <div class="logo-section"><a href="index.php"><h1>MLM Project</h1></a></div>
  <div class="top-menu">
    <ul>
	<?php 
		if(!isset($_SESSION['UID'])){		
	?>
    <li><a href="login.php" id="various2">Login</a></li>
	<?php 
		}
	?>
	<?php 
		if(isset($_SESSION['UID'])){
	?>
    <li title="Welcome <?php echo ucfirst($_SESSION['UNAME']); ?>"><a href="dashboard.php" id="various2" >My Account</a></li>
	<?php 
		}else {
	?>
	<li><a href="register.php" id="various3">Register</a></li>
	<?php 
		}
	?>
    
    <li><a href="javascript:void(0);" onclick="alert('Comming Soon.....')" id="various4">About</a></li>
    <li><a href="javascript:void(0);" onclick="alert('Comming Soon.....')" id="various5">Contact</a></li>    
    </ul>
    </div>
  </div>