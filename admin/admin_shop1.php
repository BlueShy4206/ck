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

mysql_select_db($database_conn_web, $conn_web);
$query_web_shop1 = "SELECT * FROM shop1 ORDER BY shop_id ASC";
$web_shop1 = mysql_query($query_web_shop1, $conn_web) or die(mysql_error());
$row_web_shop1 = mysql_fetch_assoc($web_shop1);
$totalRows_web_shop1 = mysql_num_rows($web_shop1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理後台</title>
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="Dreamweaver+PHP資料庫網站製作" />
<meta name="keywords" content="Dreamweaver+PHP資料庫網站製作" />
<meta name="author" content="joj設計、joj網頁設計、joj Design、joj Web Design、呂昶億、杜慎甄" />
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
        <td width="25" align="left"><img src="../images/board11.gif" /></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">商品分類管理區&nbsp; &nbsp;</span></td>
        <td width="416" align="left" background="../images/board04.gif"><a href="admin_shop1Add.php"><img src="../images/icon_shop1Add.gif" width="120" height="19" border="0" /></a></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <?php if ($totalRows_web_shop1 > 0) { // Show if recordset not empty ?>
      <table width="555" border="0" cellspacing="0" cellpadding="0">
        <?php do { ?>
          <tr>
            <td width="25" align="center" class="board_add3"><?php echo $row_web_shop1['shop_id']; ?></td>
            <td width="270" height="30" align="left" class="board_add3">&nbsp; &nbsp; <?php echo $row_web_shop1['shop_name']; ?></td>
            <td width="260" align="center" class="board_add3"> [ <a href="admin_shop2.php?shop_id=<?php echo $row_web_shop1['shop_id']; ?>">管理本分類相關商品</a> ] [ <a href="admin_shop1Update.php?shop_id=<?php echo $row_web_shop1['shop_id']; ?>">編輯</a> ]&nbsp; [ <a href="admin_shop1Del.php?delSure=1&amp;shop_id=<?php echo $row_web_shop1['shop_id']; ?>" onclick="tfm_confirmLink('確定刪除本商品分類?');return document.MM_returnValue">刪除</a> ]</td>
          </tr>
          <?php } while ($row_web_shop1 = mysql_fetch_assoc($web_shop1)); ?>
      </table>
      <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_web_shop1 == 0) { // Show if recordset empty ?>
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
mysql_free_result($web_shop1);
?>
