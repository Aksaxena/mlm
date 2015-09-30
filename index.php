<?php session_start();
require_once("lib/config.inc.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome To <?php echo SITE_TITLE;?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/favicon.gif" type="image/gif" />
<script>
		!window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');
</script>
<script type="text/javascript" src="admin/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="admin/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="admin/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<link rel="stylesheet" href="style.css" />
<script type="text/javascript" src="script/popup.js"></script>
</head>

<body>
<div class="wrapper">
<!--Start Header Section-->
<?php include("header.php"); ?>
<!--End Header Section-->

<!--Start Content Section-->
<div class="content-area">
  <a href="javascript:void(0);" id="various8"><img src="images/cover-img2.jpg" alt="" width="322" height="369" class="img2" border="0" /></a>
  <a href="javascript:void(0);" id="various9"><img src="images/cover-img3.jpg" alt="" width="314" height="427" class="img3" border="0" /></a>
  <a href="javascript:void(0);" id="various10"><img src="images/cover-img4.jpg" alt="" width="389" height="557" class="img4" border="0" /></a>
  <a href="javascript:void(0);" id="various11"><img src="images/cover-img5.jpg" alt="" width="497" height="329" class="img5" border="0" /></a>
  <a href="javascript:void(0);" id="various12"><img src="images/cover-img9.jpg" alt="" width="500" height="332" class="img6" border="0" /></a>
  <a href="javascript:void(0);" id="various13"><img src="images/cover-img6.jpg" alt="" width="505" height="344" class="img7" border="0" /></a>
  <a href="javascript:void(0);" id="various14"><img src="images/cover-img8.jpg" alt="" width="393" height="420" class="img8" border="0" /></a>
  <a href="javascript:void(0);" id="various15"><img src="images/cover-img7.jpg" alt="" width="500" height="375" class="img9" border="0" /></a>
 
</div>
<!--End Content Section-->
</div>
<!--Start Footer Section-->
<?php include("footer.php"); ?>
<!--End Footer Section-->
</body>
</html>