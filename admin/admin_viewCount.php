<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>

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

$maxRows_web_viewCount = 15;
$pageNum_web_viewCount = 0;
if (isset($_GET['pageNum_web_viewCount'])) {
  $pageNum_web_viewCount = $_GET['pageNum_web_viewCount'];
}
$startRow_web_viewCount = $pageNum_web_viewCount * $maxRows_web_viewCount;

mysql_select_db($database_conn_web, $conn_web);
$query_web_viewCount = "SELECT * FROM viewcount ORDER BY view_id DESC";
$query_limit_web_viewCount = sprintf("%s LIMIT %d, %d", $query_web_viewCount, $startRow_web_viewCount, $maxRows_web_viewCount);
$web_viewCount = mysql_query($query_limit_web_viewCount, $conn_web) or die(mysql_error());
$row_web_viewCount = mysql_fetch_assoc($web_viewCount);

if (isset($_GET['totalRows_web_viewCount'])) {
  $totalRows_web_viewCount = $_GET['totalRows_web_viewCount'];
} else {
  $all_web_viewCount = mysql_query($query_web_viewCount);
  $totalRows_web_viewCount = mysql_num_rows($all_web_viewCount);
}
$totalPages_web_viewCount = ceil($totalRows_web_viewCount/$maxRows_web_viewCount)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理後台</title>
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="國民小學教師學科知能評量" />
<meta name="keywords" content="國民小學教師學科知能評量" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="../web.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="admin_main2">
    <table width="555" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="25" align="left"><img src="../images/board03.gif" /></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">瀏覽時間 &nbsp;</span></td>
        <td width="416" align="right" background="../images/board04.gif" class="font_black">IP位置</td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="0">
      <?php do { ?>
        <tr>
          <td width="26" align="center" class="board_add">&nbsp;</td>
          <td width="340" height="30" align="left" class="board_add"><?php echo $row_web_viewCount['view_time']; ?></td>
          <td width="176" align="right" class="board_add"><?php echo $row_web_viewCount['view_ip']; ?></td>
          <td width="13" align="center" class="board_add">&nbsp;</td>
        </tr>
        <?php } while ($row_web_viewCount = mysql_fetch_assoc($web_viewCount)); ?>
    </table>
  </div>
  <div id="admin_main3">
       <? include("right_zone.php");?>
  </div>
  <div id="main4"></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>
<?php
mysql_free_result($web_viewCount);
?>
