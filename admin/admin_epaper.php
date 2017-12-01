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

$maxRows_web_epaper = 10;
$pageNum_web_epaper = 0;
if (isset($_GET['pageNum_web_epaper'])) {
  $pageNum_web_epaper = $_GET['pageNum_web_epaper'];
}
$startRow_web_epaper = $pageNum_web_epaper * $maxRows_web_epaper;

mysql_select_db($database_conn_web, $conn_web);
$query_web_epaper = "SELECT * FROM epaper ORDER BY epaper_id DESC";
$query_limit_web_epaper = sprintf("%s LIMIT %d, %d", $query_web_epaper, $startRow_web_epaper, $maxRows_web_epaper);
$web_epaper = mysql_query($query_limit_web_epaper, $conn_web) or die(mysql_error());
$row_web_epaper = mysql_fetch_assoc($web_epaper);

if (isset($_GET['totalRows_web_epaper'])) {
  $totalRows_web_epaper = $_GET['totalRows_web_epaper'];
} else {
  $all_web_epaper = mysql_query($query_web_epaper);
  $totalRows_web_epaper = mysql_num_rows($all_web_epaper);
}
$totalPages_web_epaper = ceil($totalRows_web_epaper/$maxRows_web_epaper)-1;

mysql_select_db($database_conn_web, $conn_web);
$query_web_orderPaper = "SELECT orderPaper FROM member WHERE orderPaper = 'Y'";
$web_orderPaper = mysql_query($query_web_orderPaper, $conn_web) or die(mysql_error());
$row_web_orderPaper = mysql_fetch_assoc($web_orderPaper);
$totalRows_web_orderPaper = mysql_num_rows($web_orderPaper);

$queryString_web_epaper = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_web_epaper") == false && 
        stristr($param, "totalRows_web_epaper") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_web_epaper = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_web_epaper = sprintf("&totalRows_web_epaper=%d%s", $totalRows_web_epaper, $queryString_web_epaper);
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
    <table width="555" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="25" align="left"><img src="../images/board09.gif" /></td>
        <td width="90" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">電子報管理區</span></td>
        <td width="160" align="left" valign="bottom" background="../images/board04.gif"><a href="admin_epaperAdd.php"><img src="../images/icon_add.gif" width="47" height="19" border="0" /></a>
          <a href="admin_epaperMember.php"><img src="../images/icon_mepaperOrder.gif" border="0"></a>
        </td>
        <td width="270" align="left" valign="middle" background="../images/board04.gif" class="font_black">總訂閱人數：<?php echo $totalRows_web_orderPaper ?></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <?php if ($totalRows_web_epaper > 0) { // Show if recordset not empty ?>
      <table width="555" border="0" cellspacing="0" cellpadding="0">
        <tr class="font_black">
          <td align="center" class="board_add3"><span class="font_black">編號</span></td>
          <td height="30" align="center" class="board_add3"><span class="font_black">發送狀態</span></td>
          <td align="left" class="board_add3"><span class="font_black">&nbsp; 電子報標題</span></td>
          <td width="270" align="center" class="board_add3"><span class="font_black">編輯</span></td>
        </tr>
        <?php do { ?>
          <tr>
            <td width="48" align="center" class="board_add3"><?php echo $row_web_epaper['epaper_id']; ?></td>
            <td width="57" height="30" align="center" class="board_add3"><?php /*START_PHP_SIRFCIT*/ if ($row_web_epaper['epaper_send']=="Y"){ ?>
                <img src="../images/icon_epapery.gif" />
                <?php } /*END_PHP_SIRFCIT*/ ?>
              <?php /*START_PHP_SIRFCIT*/ if ($row_web_epaper['epaper_send']=="N"){ ?>
                <img src="../images/icon_epapern.gif" />
            <?php } /*END_PHP_SIRFCIT*/ ?></td>
            <td width="180" align="left" class="board_add3"><?php echo $row_web_epaper['epaper_title']; ?></td>
            <td align="center" class="board_add3">[ <a href="admin_epaperView.php?epaper_id=<?php echo $row_web_epaper['epaper_id']; ?>">預覽</a> ] [ <a href="admin_epaperSend1.php?epaper_id=<?php echo $row_web_epaper['epaper_id']; ?>">指定寄發</a> ] [ <a href="admin_epaperSend2.php?epaper_id=<?php echo $row_web_epaper['epaper_id']; ?>" onclick="tfm_confirmLink('如果訂閱會員眾多，需要較長時間等待，確定寄發?');return document.MM_returnValue">發行電子報</a> ]&nbsp;&nbsp;[ <a href="admin_epaperUpdate.php?epaper_id=<?php echo $row_web_epaper['epaper_id']; ?>">編輯</a> ] [ <a href="admin_epaperDel.php?epaper_id=<?php echo $row_web_epaper['epaper_id']; ?>&amp;delSure=1" onclick="tfm_confirmLink('確定刪除本資料?');return document.MM_returnValue">刪除</a> ]</td>
          </tr>
          <?php } while ($row_web_epaper = mysql_fetch_assoc($web_epaper)); ?>
      </table>
      <table width="555" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="bottom">&nbsp;
            <table border="0">
              <tr>
                <td><?php if ($pageNum_web_epaper > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_web_epaper=%d%s", $currentPage, 0, $queryString_web_epaper); ?>">第一頁</a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_web_epaper > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_web_epaper=%d%s", $currentPage, max(0, $pageNum_web_epaper - 1), $queryString_web_epaper); ?>">上一頁</a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_web_epaper < $totalPages_web_epaper) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_web_epaper=%d%s", $currentPage, min($totalPages_web_epaper, $pageNum_web_epaper + 1), $queryString_web_epaper); ?>">下一頁</a>
                    <?php } // Show if not last page ?></td>
                <td><?php if ($pageNum_web_epaper < $totalPages_web_epaper) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_web_epaper=%d%s", $currentPage, $totalPages_web_epaper, $queryString_web_epaper); ?>">最後一頁</a>
                    <?php } // Show if not last page ?></td>
              </tr>
            </table></td>
          <td align="right" valign="bottom">&nbsp;
            記錄 <?php echo ($startRow_web_epaper + 1) ?> 到 <?php echo min($startRow_web_epaper + $maxRows_web_epaper, $totalRows_web_epaper) ?> 共 <?php echo $totalRows_web_epaper ?></td>
        </tr>
      </table>
      <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_web_epaper == 0) { // Show if recordset empty ?>
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
mysql_free_result($web_epaper);

mysql_free_result($web_orderPaper);
?>
