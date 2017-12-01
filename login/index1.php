<?php require_once('../Connections/conn_web.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>國民小學教師學科知能評量</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="國民小學教師學科知能評量" />
<meta name="keywords" content="國民小學教師學科知能評量" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="../web.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]><script src="ie6png.js" type="text/javascript"></script><![endif]-->
<script src="../Scripts/swfobject_modified.js" type="text/javascript"></script>
</head>
<body onload="MM_preloadImages('../images/index_button2.png','../images/aboutCK_button2.png','../images/download_button2.png','../images/Q&A_button2.png')" background="../images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main3" style="width: 760px;">
  
    <form action="fristactionlogin.php" method="POST" align="center">
<?php if($_GET['err'] == 'error'){ ?>
     <tr><td align="center"> <font color="red" >准考證號碼或密碼錯誤</font></td></tr>
  <?php } ?><?php if($_GET['refer'] == 'NULL'){ ?>
     <tr><td align="center"> <font color="red" >准考證號碼和密碼不能為空</font></td></tr>
  <?php } ?><br />
  准考證號碼:<br />
<input type="text" name="email">
<br />
密碼:<br />
<input type="password" name="password">
<br />
<input type="submit" name="submit" value="Login">
<input type="hidden" name="refer" value="<?php echo (isset($_GET['refer'])) ? $_GET['refer'] : 'NULL'; ?>">
</form>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>



  </div>
  <div id="main4" style="width: 760px;" align="center"></div>
  </div>
   
 


<?php include("footer.php"); ?>
</div>
</div>
</body>
</html>

