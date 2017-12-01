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

$maxRows_web_member = 10;
$pageNum_web_member = 0;
if (isset($_GET['pageNum_web_member'])) {
  $pageNum_web_member = $_GET['pageNum_web_member'];
}
$startRow_web_member = $pageNum_web_member * $maxRows_web_member;

mysql_select_db($database_conn_web, $conn_web);
$query_web_member = "SELECT * FROM member WHERE orderPaper = 'Y' ORDER BY id ASC";
$query_limit_web_member = sprintf("%s LIMIT %d, %d", $query_web_member, $startRow_web_member, $maxRows_web_member);
$web_member = mysql_query($query_limit_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_member);

if (isset($_GET['totalRows_web_member'])) {
  $totalRows_web_member = $_GET['totalRows_web_member'];
} else {
  $all_web_member = mysql_query($query_web_member);
  $totalRows_web_member = mysql_num_rows($all_web_member);
}
$totalPages_web_member = ceil($totalRows_web_member/$maxRows_web_member)-1;

$queryString_web_member = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_web_member") == false && 
        stristr($param, "totalRows_web_member") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_web_member = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_web_member = sprintf("&totalRows_web_member=%d%s", $totalRows_web_member, $queryString_web_member);
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
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">電子報訂閱會員&nbsp; &nbsp;</span></td>
        <td width="416" align="left" background="../images/board04.gif">&nbsp;</td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="0">
      <?php do { ?>
        <tr>
          <td width="20" align="center" class="board_add"><?php echo $row_web_member['id']; ?></td>
          <td width="435" height="30" align="left" class="board_add">&nbsp; &nbsp;[<?php echo $row_web_member['username']; ?> ] <?php echo $row_web_member['uname']; ?>&nbsp; &nbsp; - &nbsp;<?php echo $row_web_member['level']; ?> &nbsp;
            <?php /*START_PHP_SIRFCIT*/ if ($row_web_member['orderPaper']=="Y"){ ?>
              <img src="../images/icon_epaperOrder.gif">
          <?php } /*END_PHP_SIRFCIT*/ ?></td>
          <td width="100" align="center" class="board_add">[ <a href="admin_memberUpdate.php?id=<?php echo $row_web_member['id']; ?>" target="_blank">編輯</a> ]&nbsp; [ <a href="admin_memberDel.php?id=<?php echo $row_web_member['id']; ?>&amp;delSure=1" onclick="tfm_confirmLink('確定刪除本資料?');return document.MM_returnValue">刪除</a> ]</td>
        </tr>
        <?php } while ($row_web_member = mysql_fetch_assoc($web_member)); ?>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="bottom">&nbsp;
          <table border="0">
            <tr>
              <td><?php if ($pageNum_web_member > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_web_member=%d%s", $currentPage, 0, $queryString_web_member); ?>">第一頁</a>
                  <?php } // Show if not first page ?></td>
              <td><?php if ($pageNum_web_member > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_web_member=%d%s", $currentPage, max(0, $pageNum_web_member - 1), $queryString_web_member); ?>">上一頁</a>
                  <?php } // Show if not first page ?></td>
              <td><?php if ($pageNum_web_member < $totalPages_web_member) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_web_member=%d%s", $currentPage, min($totalPages_web_member, $pageNum_web_member + 1), $queryString_web_member); ?>">下一頁</a>
                  <?php } // Show if not last page ?></td>
              <td><?php if ($pageNum_web_member < $totalPages_web_member) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_web_member=%d%s", $currentPage, $totalPages_web_member, $queryString_web_member); ?>">最後一頁</a>
                  <?php } // Show if not last page ?></td>
            </tr>
        </table></td>
        <td align="right" valign="bottom">&nbsp;
記錄 <?php echo ($startRow_web_member + 1) ?> 到 <?php echo min($startRow_web_member + $maxRows_web_member, $totalRows_web_member) ?> 共 <?php echo $totalRows_web_member ?></td>
      </tr>
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
mysql_free_result($web_member);
?>
