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

$maxRows_web_forum = 10;
$pageNum_web_forum = 0;
if (isset($_GET['pageNum_web_forum'])) {
  $pageNum_web_forum = $_GET['pageNum_web_forum'];
}
$startRow_web_forum = $pageNum_web_forum * $maxRows_web_forum;

mysql_select_db($database_conn_web, $conn_web);
$query_web_forum = "SELECT * FROM forum ORDER BY forum_top DESC,forum_lastdate DESC";
$query_limit_web_forum = sprintf("%s LIMIT %d, %d", $query_web_forum, $startRow_web_forum, $maxRows_web_forum);
$web_forum = mysql_query($query_limit_web_forum, $conn_web) or die(mysql_error());
$row_web_forum = mysql_fetch_assoc($web_forum);

if (isset($_GET['totalRows_web_forum'])) {
  $totalRows_web_forum = $_GET['totalRows_web_forum'];
} else {
  $all_web_forum = mysql_query($query_web_forum);
  $totalRows_web_forum = mysql_num_rows($all_web_forum);
}
$totalPages_web_forum = ceil($totalRows_web_forum/$maxRows_web_forum)-1;

$queryString_web_forum = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_web_forum") == false && 
        stristr($param, "totalRows_web_forum") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_web_forum = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_web_forum = sprintf("&totalRows_web_forum=%d%s", $totalRows_web_forum, $queryString_web_forum);
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
    <table width="555" border="0" cellspacing="0" cellpadding="0" background="../images/forum01.gif">
      <tr>
        <td height="34" colspan="5" align="left"><img src="../images/forum02.gif" width="158" height="34" align="left" /></td>
      </tr>
      <tr>
        <td width="234" height="36" align="left" class="font_title2">&nbsp;討論文章標題</td>
        <td width="110" align="center" class="font_title2">發表者</td>
        <td width="92" align="center" class="font_title2">回覆/瀏覽</td>
        <td width="119" align="center" class="font_title2">最後發表</td>
        <td width="119" align="center" class="font_title2">編輯</td>
      </tr>
    </table>
    <?php if ($totalRows_web_forum > 0) { // Show if recordset not empty ?>
  <table width="555" border="0" cellspacing="0" cellpadding="0">
    <?php do { ?>
      <tr class="board_add3">
        <td width="25" align="center" class="board_add3"><img src="../images/face/<?php echo $row_web_forum['forum_type']; ?>" width="19" height="19" /></td>
        <td width="167" height="30" align="left" class="board_add3"><?php /*START_PHP_SIRFCIT*/ if ($row_web_forum['forum_top']=="Y"){ ?>
            <img src="../images/icon_forum_top.gif" width="38" height="16" hspace="2" />
            <?php } /*END_PHP_SIRFCIT*/ ?>
          <?php echo $row_web_forum['forum_title']; ?>
          <?php /*START_PHP_SIRFCIT*/ if ($row_web_forum['forum_replies']>="5"){ ?>
            <img src="../images/icon_hot.gif" />
            <?php } /*END_PHP_SIRFCIT*/ ?>
<?php /*START_PHP_SIRFCIT*/ if ($row_web_forum['forum_date']>time()-86400*3){ ?>
          <img src="../images/icon_new2.gif" />
          <?php } /*END_PHP_SIRFCIT*/ ?>
      </td>
        <td width="91" align="center" class="board_add3"><span class="font_mini"><?php echo $row_web_forum['forum_username']; ?><br />
          <?php echo $row_web_forum['forum_date']; ?><br />
          </span></td>
          <td width="75" align="center" class="board_add3"><?php echo $row_web_forum['forum_replies']; ?>/ <?php echo $row_web_forum['forum_view']; ?></td>
          <td width="97" align="center" class="board_add3"><span class="font_mini"><?php echo $row_web_forum['forum_lastman']; ?><br />
            <?php echo $row_web_forum['forum_lastdate']; ?><br />
            </span></td>
          <td width="100" align="center" class="board_add3">[ <a href="admin_forumUpdate.php?forum_id=<?php echo $row_web_forum['forum_id']; ?>">編輯</a> ] [ <a href="admin_forumDel.php?delSure=1&amp;forum_id=<?php echo $row_web_forum['forum_id']; ?>" onclick="tfm_confirmLink('確定刪除本討論主題及所屬回覆留言?');return document.MM_returnValue">刪除</a> ]</td>
        </tr><?php } while ($row_web_forum = mysql_fetch_assoc($web_forum)); ?>
  </table>
      <table width="555" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="bottom">&nbsp;
            <table border="0">
              <tr>
                <td><?php if ($pageNum_web_forum > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_web_forum=%d%s", $currentPage, 0, $queryString_web_forum); ?>">第一頁</a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_web_forum > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_web_forum=%d%s", $currentPage, max(0, $pageNum_web_forum - 1), $queryString_web_forum); ?>">上一頁</a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_web_forum < $totalPages_web_forum) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_web_forum=%d%s", $currentPage, min($totalPages_web_forum, $pageNum_web_forum + 1), $queryString_web_forum); ?>">下一頁</a>
                    <?php } // Show if not last page ?></td>
                <td><?php if ($pageNum_web_forum < $totalPages_web_forum) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_web_forum=%d%s", $currentPage, $totalPages_web_forum, $queryString_web_forum); ?>">最後一頁</a>
                    <?php } // Show if not last page ?></td>
              </tr>
          </table></td>
          <td align="right" valign="bottom">&nbsp;
            記錄 <?php echo ($startRow_web_forum + 1) ?> 到 <?php echo min($startRow_web_forum + $maxRows_web_forum, $totalRows_web_forum) ?> 共 <?php echo $totalRows_web_forum ?></td>
        </tr>
      </table>
      <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_web_forum == 0) { // Show if recordset empty ?>
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
mysql_free_result($web_forum);
?>
