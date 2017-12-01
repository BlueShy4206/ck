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
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
 
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js'></script>
 
<script type="text/javascript">
$(document).ready(function() { //表格拖曳功能
  $("#sort").sortable({
    opacity: 0.6,
    //拖曳時透明
    cursor: 'move',
    //游標設定
    axis:'y',
    //只能垂直拖曳
    update : function () { 
       var order = $('#sort').sortable('serialize'); 
      $("#info").load("process-sortable.php?"+order); 
	  
    } 
  });
});
</script>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_web_news = 20;
$pageNum_web_news = 0;
if (isset($_GET['pageNum_web_news'])) {
  $pageNum_web_news = $_GET['pageNum_web_news'];
}
$startRow_web_news = $pageNum_web_news * $maxRows_web_news;

mysql_select_db($database_conn_web, $conn_web);
$query_web_news = "SELECT * FROM file ORDER BY position ASC,file_id DESC";
$query_limit_web_news = sprintf("%s LIMIT %d, %d", $query_web_news, $startRow_web_news, $maxRows_web_news);
$web_news = mysql_query($query_limit_web_news, $conn_web) or die(mysql_error());
$row_web_news = mysql_fetch_assoc($web_news);

if (isset($_GET['totalRows_web_news'])) {
  $totalRows_web_news = $_GET['totalRows_web_news'];
} else {
  $all_web_news = mysql_query($query_web_news);
  $totalRows_web_news = mysql_num_rows($all_web_news);
}
$totalPages_web_news = ceil($totalRows_web_news/$maxRows_web_news)-1;

$queryString_web_news = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_web_news") == false && 
        stristr($param, "totalRows_web_news") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_web_news = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_web_news = sprintf("&totalRows_web_news=%d%s", $totalRows_web_news, $queryString_web_news);
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
<script type="text/javascript">
<!--
function tfm_confirmLink(message) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
}
//-->
</script>
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="admin_main2">
    <table width="555" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="25" align="left"><img src="../images/board15.gif"/></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">檔案管理區&nbsp; &nbsp;</span></td>
        <td width="416" align="left" background="../images/board04.gif"><a href="admin_file_add.php"><img src="../images/icon_add.gif" width="47" height="19" border="0" /></a></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <?php if ($totalRows_web_news > 0) { // Show if recordset not empty ?>
      <table width="555" border="0" cellspacing="0" cellpadding="0">
      <tbody class="sort" id="sort">
        <?php 
		
		do { ?>
          <tr id="text_<?php echo $row_web_news['file_id']; //設定表格每行的id?>">
            <td width="20" align="center" class="board_add">&nbsp;</td>
            <td width="50" height="30" align="center" class="board_add"><?php echo $row_web_news['file_id']; ?></td>
            <td width="385" align="left" class="board_add">&nbsp; <?php echo $row_web_news['file_title']; ?>&nbsp; ...<?php echo $row_web_news['file_date']; ?></td>
            <td width="100" align="center" class="board_add">[ <a href="admin_fileUpdate.php?file_id=<?php echo $row_web_news['file_id']; ?>">編輯</a> ]&nbsp; [ <a href="admin_fileDel.php?file_id=<?php echo $row_web_news['file_id']; ?>&amp;file_name=<?php echo $row_web_news['file_name']; ?>&amp;delSure=1" onClick="tfm_confirmLink('確定刪除本資料?');return document.MM_returnValue">刪除</a> ]</td>
          </tr>
          <?php } while ($row_web_news = mysql_fetch_assoc($web_news)); ?>
          </tbody>
      </table>
      <div id="info"></div>
    <form action="process-sortable.php" method="post" name="sortables">  
<input type="hidden" name="test-log" id="test-log">
</form> 
   
      <table width="555" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="bottom">&nbsp;
            <table border="0">
              <tr>
                <td><?php if ($pageNum_web_news > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_web_news=%d%s", $currentPage, 0, $queryString_web_news); ?>">第一頁</a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_web_news > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_web_news=%d%s", $currentPage, max(0, $pageNum_web_news - 1), $queryString_web_news); ?>">上一頁</a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_web_news < $totalPages_web_news) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_web_news=%d%s", $currentPage, min($totalPages_web_news, $pageNum_web_news + 1), $queryString_web_news); ?>">下一頁</a>
                    <?php } // Show if not last page ?></td>
                <td><?php if ($pageNum_web_news < $totalPages_web_news) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_web_news=%d%s", $currentPage, $totalPages_web_news, $queryString_web_news); ?>">最後一頁</a>
                    <?php } // Show if not last page ?></td>
              </tr>
            </table></td>
          <td align="right" valign="bottom">&nbsp;
            記錄 <?php echo ($startRow_web_news + 1) ?> 到 <?php echo min($startRow_web_news + $maxRows_web_news, $totalRows_web_news) ?> 共 <?php echo $totalRows_web_news ?></td>
        </tr>
      </table>
      <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_web_news == 0) { // Show if recordset empty ?>
  <table width="555" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2">目前資料庫中沒有任何資料!</td>
      </tr>
  </table>
  <?php } // Show if recordset empty ?>
  
 

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
mysql_free_result($web_news);
?>

