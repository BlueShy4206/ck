<?php require_once('Connections/conn_web.php'); ?>
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

$colname_web_shop2 = "-1";
if (isset($_GET['p_id'])) {
  $colname_web_shop2 = $_GET['p_id'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_shop2 = sprintf("SELECT shop1.shop_id, shop1.shop_name, shop2.p_id, shop2.p_name, shop2.p_price, shop2.p_open, shop2.p_pic, shop2.p_content FROM shop1 left join shop2 on shop1.shop_id=shop2.shop_id WHERE shop2.p_id = %s", GetSQLValueString($colname_web_shop2, "int"));
$web_shop2 = mysql_query($query_web_shop2, $conn_web) or die(mysql_error());
$row_web_shop2 = mysql_fetch_assoc($web_shop2);
$totalRows_web_shop2 = mysql_num_rows($web_shop2);
?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dreamweaver+PHP資料庫網站製作</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="Dreamweaver+PHP資料庫網站製作" />
<meta name="keywords" content="Dreamweaver+PHP資料庫網站製作" />
<meta name="author" content="joj設計、joj網頁設計、joj Design、joj Web Design、呂昶億、杜慎甄" />
<link href="web.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]><script src="ie6png.js" type="text/javascript"></script><![endif]-->
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <? include("leftzone.php")?>
  </div>
  <div id="main3">
  <table width="555" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="23" valign="middle" class="underline3"><img src="images/icon_cube.gif" width="23" height="21" /></td>
      <td height="25" valign="middle" class="underline3"> &nbsp;<a href="index.php">首頁</a> &gt; <a href="products.php?shop_id=<?php echo $row_web_shop2['shop_id']; ?>"><?php echo $row_web_shop2['shop_name']; ?></a>  &gt; <?php echo $row_web_shop2['p_name']; ?></td>
    </tr>
  </table>
  <table width="555" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="300" align="center" valign="top"><img src="images/shop/<?php echo $row_web_shop2['p_pic']; ?>" width="300" /></td>
      <td width="255" align="center" valign="top"><p><span class='font_title3'><?php echo $row_web_shop2['p_name']; ?>&nbsp;</span></p>
        <p>NT：<?php echo $row_web_shop2['p_price']; ?></p>
        <p><a href="shopcart_add.php?p_name=<?php echo urlencode($row_web_shop2['p_name']); ?>&amp;p_price=<?php echo $row_web_shop2['p_price']; ?>&amp;p_pic=<?php echo $row_web_shop2['p_pic']; ?>"><img src="images/car_add.gif" width="75" height="16" border="0" /></a></p></td>
    </tr>
  </table>
  <table width="555" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="left" valign="top"><?php echo $row_web_shop2['p_content']; ?><br />        <br /></td>
    </tr>
  </table>
  </div>
  <div id="main4"></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>
<?php
mysql_free_result($web_shop2);
?>
