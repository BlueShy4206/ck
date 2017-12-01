<?php require_once('../Connections/conn_web.php'); ?>
<? $order_total='0';?>
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

$colname_web_orders = "-1";
if (isset($_GET['order_id'])) {
  $colname_web_orders = $_GET['order_id'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_orders = sprintf("SELECT * FROM orders WHERE order_id = %s", GetSQLValueString($colname_web_orders, "int"));
$web_orders = mysql_query($query_web_orders, $conn_web) or die(mysql_error());
$row_web_orders = mysql_fetch_assoc($web_orders);
$totalRows_web_orders = mysql_num_rows($web_orders);

$colname_web_orderList = "-1";
if (isset($_GET['order_sid'])) {
  $colname_web_orderList = $_GET['order_sid'];
}
$colname2_web_orderList = "-1";
if (isset($_GET['order_group'])) {
  $colname2_web_orderList = $_GET['order_group'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_orderList = sprintf("SELECT * FROM orderlist WHERE order_sid = %s AND order_group = %s ORDER BY odlist_id ASC", GetSQLValueString($colname_web_orderList, "text"),GetSQLValueString($colname2_web_orderList, "text"));
$web_orderList = mysql_query($query_web_orderList, $conn_web) or die(mysql_error());
$row_web_orderList = mysql_fetch_assoc($web_orderList);
$totalRows_web_orderList = mysql_num_rows($web_orderList);
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
<script src="../ie6png.js" type="text/javascript"></script>
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="admin_main2">
    <table width="555" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="25" align="left"><img src="../images/board13.gif" /></td>
        <td width="78" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">訂 單 編&nbsp; 號</span></td>
        <td width="442" align="left" valign="middle" background="../images/board04.gif"><?php echo $row_web_orders['order_id']; ?></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td align="right" class="board_add"><span class="font_black">訂 購 者 資 料：</span></td>
        <td align="left" class="board_add"><?php echo $row_web_orders['order_name1']; ?>-<?php echo $row_web_orders['order_username']; ?></td>
      </tr>
      <tr>
        <td width="93" align="right" class="board_add"><span class="font_black">收 件 者 姓 名：</span></td>
        <td width="442" align="left" class="board_add"><?php echo $row_web_orders['order_name2']; ?></td>
      </tr>
      <tr>
        <td align="right" class="board_add"><span class="font_black">聯 絡 電 話：</span></td>
        <td align="left" class="board_add"><?php echo $row_web_orders['order_phone']; ?></td>
      </tr>
      <tr>
        <td align="right" class="board_add"><span class="font_black">收 件 者 地 址：</span></td>
        <td align="left" class="board_add"><?php echo $row_web_orders['order_cusadr']; ?></td>
      </tr>
      <tr>
        <td align="right" class="board_add"><span class="font_black">付 款 方 式：</span></td>
        <td align="left" class="board_add"><?php echo $row_web_orders['order_paytype']; ?></td>
      </tr>
      <tr>
        <td align="right" class="board_add"><span class="font_black">完 成 付 款：</span></td>
        <td align="left" class="board_add"><?php echo $row_web_orders['order_payok']; ?></td>
      </tr>
      <tr>
        <td align="right" class="board_add"><span class="font_black">匯款帳號末5碼：</span></td>
        <td align="left" class="board_add"><?php echo $row_web_orders['order_paynumber']; ?></td>
      </tr>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="25" align="left"><img src="../images/board12.gif" /></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">訂購清單&nbsp; &nbsp;</span></td>
        <td width="416" align="left" valign="bottom" background="../images/board04.gif">&nbsp;</td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="5">
      <tr class="font_black">
        <td width="100" align="center" class="board_add3"><span class="font_black">商品圖</span></td>
        <td width="255" align="left" class="board_add3"><span class="font_black">訂購商品名稱</span></td>
        <td width="100" align="center" valign="middle" class="board_add3"><span class="font_black">單價</span></td>
        <td width="100" align="center" class="board_add3"><span class="font_black">訂購數量</span></td>
      </tr>
      <?php do { ?>
        <tr>
          <td align="center" class="board_add3"><img src="../images/shop/thum/<?php echo $row_web_orderList['p_pic']; ?>" width="57" /></td>
          <td height="30" align="left" class="board_add3"><span class="font_black">&nbsp;<?php echo $row_web_orderList['p_name']; ?></span></td>
          <td align="center" valign="middle" class="board_add3"><span class="font_black">&nbsp;<?php echo $row_web_orderList['p_price']; ?></span><? $order_total=$order_total+$row_web_orderList['p_price']*$row_web_orderList['odlist_qty']?></td>
          <td align="center" class="board_add3"><?php echo $row_web_orderList['odlist_qty']; ?></td>
        </tr>
        <?php } while ($row_web_orderList = mysql_fetch_assoc($web_orderList)); ?>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td height="20" align="right" class="board_add3"><span class="font_black">小 計：<? echo $order_total?></span></td>
      </tr>
      <tr>
        <td height="20" align="right" class="board_add3"><span class="font_black">運 費：100</span></td>
      </tr>
      <tr>
        <td height="20" align="right" class="board_add3"><span class="font_red">總 計：<? echo $order_total+100?></span></td>
      </tr>
    </table>
    <p><input type="button" name="submit" value="回上一頁" onClick="window.history.back()";></p>
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
mysql_free_result($web_orders);

mysql_free_result($web_orderList);
?>
