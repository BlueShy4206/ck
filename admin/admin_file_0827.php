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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_web_news = 10;
$pageNum_web_news = 0;
if (isset($_GET['pageNum_web_news'])) {
  $pageNum_web_news = $_GET['pageNum_web_news'];
}
$startRow_web_news = $pageNum_web_news * $maxRows_web_news;

mysql_select_db($database_conn_web, $conn_web);
$query_web_news = "SELECT * FROM file ORDER BY file_id DESC";
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
<meta name="description" content="師資生學科知能標準化評量" />
<meta name="keywords" content="師資生學科知能標準化評量" />
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
    <table width="555" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="25" align="left"><img src="../images/board07.gif" /></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">檔案管理區&nbsp; &nbsp;</span></td>
        <td width="416" align="left" background="../images/board04.gif"><a href="admin_file_add.php"><img src="../images/icon_add.gif" width="47" height="19" border="0" /></a></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <?php if ($totalRows_web_news > 0) { // Show if recordset not empty ?>
      <table width="555" border="0" cellspacing="0" cellpadding="0">
        <?php do { ?>
          <tr>
            <td width="20" align="center" class="board_add">&nbsp;</td>
            <td width="50" height="30" align="center" class="board_add"><?php echo $row_web_news['file_id']; ?></td>
            <td width="385" align="left" class="board_add">&nbsp; <?php echo $row_web_news['file_title']; ?>&nbsp; ...<?php echo $row_web_news['file_date']; ?></td>
            <td width="100" align="center" class="board_add">[ <a href="admin_fileUpdate.php?file_id=<?php echo $row_web_news['file_id']; ?>">編輯</a> ]&nbsp; [ <a href="admin_fileDel.php?file_id=<?php echo $row_web_news['file_id']; ?>&amp;news_pic=<?php echo $row_web_news['news_pic']; ?>&amp;delSure=1" onclick="tfm_confirmLink('確定刪除本資料?');return document.MM_returnValue">刪除</a> ]</td>
          </tr>
          <?php } while ($row_web_news = mysql_fetch_assoc($web_news)); ?>
      </table>
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
