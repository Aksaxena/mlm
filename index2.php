<?php
require_once("lib/config.inc.php");
//my database connection is set in my config, otherwise, just create your own db connect
$topmcode = 'SM1002';
//my memberid are alphanumerics and all caps so I had to conver all to upper case, else, comment the above strtoupper call

//get Downline of a Member, this function is needed so that you can simply call left or right of the memberid you are looking for
		function GetDownline($member_id,$direction) 
		{ 
				$getdownlinesql = @mysql_fetch_assoc(@mysql_query('select * from `tbl_users` where parent_id="'.$member_id.'" and  position="'.$direction.'"'));
				$getdownline = 'SM100'.$getdownlinesql['uid'];
				return $getdownline; 
		}

//get the child of the member, this section will look for left or right of a member, once found, it will call GetNextDownlines() function to assign new memberid variables for left or right
    function GetChildDownline($member_id) 
    { 
				$getchilddownlinesql = @mysql_query('select * from `tbl_users` where parent_id="'.$member_id.'" ORDER BY position');
				while($childdownline = mysql_fetch_array($getchilddownlinesql)){
						$childdownlinecode = 'SM100'.$childdownline['uid'];
						$direction = $childdownline['position'];
						if($direction=='2'){
							if($childdownlinecode){
								//this is where you play with your html layout
								echo $childdownlinecode.'<br>';
								GetNextDownlines($childdownlinecode,'2');
							}
						}
						
							if($direction=='1'){
								if($childdownlinecode){
									//this is where you play with your html layout
									echo $childdownlinecode.'<br>';
									GetNextDownlines($childdownlinecode,'1');
							}
						}
				 }
    }

//recursive function to call the functions and start all over again, this is where you can get the newly assigned memberid, call the GetChildDownline() that gets the left or right, then recycle all codes
    function GetNextDownlines($member_id,$direction) 
    {
			if($direction=='2'){
					$topleft = GetDownline($member_id,'2');
						if($topleft){
								//this is where you play with your html layout
						echo $topleft.'<br>';
						}
							$getleftdownlinesql = @mysql_query('select * from `tbl_users` where parent_id="'.$topleft.'" ORDER BY position');
							while($getleftdownline = mysql_fetch_array($getleftdownlinesql)){
							$leftdownline = 'SM100'.$getleftdownline['uid'];
							$leftdirection = $getleftdownline['position'];
							
							if($leftdirection=='2'){
									if($leftdownline){
								//this is where you play with your html layout
										echo $leftdownline.'<br>';
										GetChildDownline($leftdownline);
									}
							  }
							
							if($leftdirection=='1'){
									if($leftdownline){
								//this is where you play with your html layout
									echo $leftdownline.'<br>';
									 GetChildDownline($leftdownline);
									 }
							   }
							 }
			}
			
			
			if($direction=='1'){
						$topright = GetDownline($member_id,'1');
						if($topright){
						echo $topright.'<br>';
						}
						$getrightdownlinesql = @mysql_query('select * from `tbl_users` where parent_id="'.$topright.'" ORDER BY position');
						while($getrightdownline = @mysql_fetch_array($getrightdownlinesql)){
									$rightdownline = 'SM100'.$getrightdownline['uid'];
									$rightdirection = $getrightdownline['position'];
									
									if($rightdirection=='2'){
											if($rightdownline){
								//this is where you play with your html layout
											echo $rightdownline.'<br>';
											GetChildDownline($rightdownline);
											}
									}
									
									if($rightdirection=='1'){
											if($rightdownline){
								//this is where you play with your html layout
											echo $rightdownline.'<br>';
											GetChildDownline($rightdownline);
											}
									}
						
							}
				}
}

?>
<html>
	<head>
	<title>Genealogy</title>
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<meta http-equiv=content-language content=en>
	<link href="styles.css" type=text/css rel=stylesheet>
	</head>
<body>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="noborder">
 <tr>
	<td>
<?php
echo $topmcode.'<hr>';
GetNextDownlines('SM1002','1');
echo '<hr>';
GetNextDownlines('SM1002','2');
?>

	</td>
 </tr>
</table>
</body>
</html>