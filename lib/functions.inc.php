<?php
function cleanInput() {
	if (get_magic_quotes_gpc()){  
	 $_GET = array_map('stripslashes', $_GET);  
	 $_POST = array_map('stripslashes', $_POST);  
	 $_COOKIE = array_map('stripslashes', $_COOKIE);  
	}
}
function clearCache() {
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
}
function wtRedirect($url) {
	header("location:".$url);
	exit();
}
function pushError($errMsg) {
	$_SESSION["sess_err_msg"] = $errMsg;
}
function showError() {
	if(trim($_SESSION["sess_err_msg"])) {
	$table = '<table align="center" id="errorbox">
  <tr><td  class="errorBox" id="errorboxcontent">'.$_SESSION["sess_err_msg"].'</td>
  </tr></table>';
  $_SESSION["sess_err_msg"] = "";
  } else {
	$table = '<table align="center" id="errorbox" style="display:none">
  <tr><td  class="errorBox" id="errorboxcontent">&nbsp;</td>
  </tr></table>';
  }
  return $table;
}
function validate_user()
{
	if($_SESSION['sess_uid']=='')
	{
		wtRedirect(SITE_URL."login.php?back=$_SERVER[REQUEST_URI]");
	}
}
function validateAdmin() {
	global $obj;
	$query = "SELECT COUNT(*) as cs FROM ".TBL_PREFIX."_admin where username='".$_SESSION["USERNAME"]."' and password='".$_SESSION["SHA1PASSWORD"]."'";
	$adminRs = $obj->query($query);
	$adminObj = $obj->fetchNextObject($adminRs);
	if(!$adminObj->cs) {
		pushError("Invalid admin login");
		wtRedirect("login.php");
	}
}
function praseData($str) {
	return mysql_real_escape_string($str);
}
function pr($arr) {
	global $mode;
	if($mode=="local") {
		print_r($arr);
	}
}
function getQueryString($excludeArr) {
	$queryStr = "";
	foreach($_GET as $ind=>$val) {
		if(!in_array($ind,$excludeArr)) {
		$queryStr .= $ind."=".$val."&";
		}
	}
	return substr($queryStr,0,-1);
}
function sort_column($column) {
	$getString = getQueryString(array("sort","column"));
	return "<a href='?".$getString."&sort=desc&column=".$column."'><img src='images/arrow_up.gif' border='0'></a> <a href='?".$getString."&sort=asc&column=".$column."''><img src='images/arrow_down.gif' border='0'></a>";
}
function sendPhpMail($email_to,$emailto_name,$email_subject,$email_body,$email_from,$reply_to,$html=true)
{
	require_once "class.phpmailer.php";
	global $SITE_NAME;
	$mail = new PHPMailer();
	$mail->From     = $email_from;
	$mail->FromName = $SITE_NAME;
	$mail->AddAddress($email_to,$emailto_name); 
	$mail->AddReplyTo($reply_to,$SITE_NAME);
	$mail->WordWrap = 50;                              // set word wrap
	$mail->IsHTML($html);                               // send as HTML
	$mail->Subject  =  $email_subject;
	$mail->Body     =  $email_body;
	$mail->Send();	
	return true;
}
function validateUser() {
	if(!trim($_SESSION['sess_uid'])) {
		pushError("Invalid username/passwrod");
		wtRedirect("login.php?back=".$_SERVER['HTTP_REFERER']);
	}
}
function builUrl($url) {
	return str_replace(" ","-",str_replace("-","_",$url));
}
function builReverseUrl($url) {
	return str_replace("_","-",str_replace("-"," ",$url));
}
function alphaID($in, $to_num = false, $pad_up = false, $passKey = null)
{	
if(is_numeric($in)) {
	$in += 12345678;
}
    $index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    if ($passKey !== null) {
        // Although this function's purpose is to just make the
        // ID short - and not so much secure,
        // with this patch by Simon Franz (http://blog.snaky.org/)
        // you can optionally supply a password to make it harder
        // to calculate the corresponding numeric ID
        
        for ($n = 0; $n<strlen($index); $n++) {
            $i[] = substr( $index,$n ,1);
        }
 
        $passhash = hash('sha256',$passKey);
        $passhash = (strlen($passhash) < strlen($index))
            ? hash('sha512',$passKey)
            : $passhash;
 
        for ($n=0; $n < strlen($index); $n++) {
            $p[] =  substr($passhash, $n ,1);
        }
        
        array_multisort($p,  SORT_DESC, $i);
        $index = implode($i);
    }
 
    $base  = strlen($index);
 
    if ($to_num) {
        // Digital number  <<--  alphabet letter code
        $in  = strrev($in);
        $out = 0;
        $len = strlen($in) - 1;
        for ($t = 0; $t <= $len; $t++) {
            $bcpow = bcpow($base, $len - $t);
            $out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
        }
 
        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $out -= pow($base, $pad_up);
            }
        }
        $out = sprintf('%F', $out);
        $out = substr($out, 0, strpos($out, '.'));
		$out = 	$out-12345678;
    } else { 
        // Digital number  -->>  alphabet letter code
        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $in += pow($base, $pad_up);
            }
        }
 
        $out = "";
        for ($t = floor(log($in, $base)); $t >= 0; $t--) {
            $bcp = bcpow($base, $t);
            $a   = floor($in / $bcp) % $base;
            $out = $out . substr($index, $a, 1);
            $in  = $in - ($a * $bcp);
        }
        $out = strrev($out); // reverse
    }
 
    return $out;
}

function wdateformat($date) {
	return date("dS M Y",strtotime($date));
}

function getRatingStars( $number ) {
    // Convert any entered number into a float
    // Because the rating can be a decimal e.g. 4.5
    $number = number_format ( $number, 1 );

    // Get the integer part of the number
    $intpart = floor ( $number );

    // Get the fraction part
    $fraction = $number - $intpart;

    // Rating is out of 5
    // Get how many stars should be left blank
    $unrated = 5 - ceil ( $number );

    // Populate the full-rated stars
    if ( $intpart <= 5 ) {
        for ( $i=0; $i<$intpart; $i++ )
	    echo '<img src="images/rating_full.png" />';
    }
    
    // Populate the half-rated star, if any
//    if ( $fraction == 0.5 ) {
    if ( $fraction) {
        echo '<img src="images/rating_half.png" />';
    }
    
    // Populate the unrated stars, if any
    if ( $unrated > 0 ) {
        for ( $j=0; $j<$unrated; $j++ )
	    echo '<img src="images/rating_none.png" />';
    }
	
  
}


?>