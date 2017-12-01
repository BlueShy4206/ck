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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_web_shop2 = 12;
$pageNum_web_shop2 = 0;
if (isset($_GET['pageNum_web_shop2'])) {
  $pageNum_web_shop2 = $_GET['pageNum_web_shop2'];
}
$startRow_web_shop2 = $pageNum_web_shop2 * $maxRows_web_shop2;

$colname_web_shop2 = "-1";
if (isset($_GET['shop_id'])) {
  $colname_web_shop2 = $_GET['shop_id'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_shop2 = sprintf("SELECT shop1.shop_id,shop1.shop_name,shop2.p_id, shop2.p_name,shop2.p_price, shop2.p_open, shop2.p_pic FROM shop1 Left Join shop2 ON shop1.shop_id = shop2.shop_id WHERE shop2.shop_id = %s AND shop2.p_open = 'Y' ORDER BY shop2.p_id DESC", GetSQLValueString($colname_web_shop2, "int"));
$query_limit_web_shop2 = sprintf("%s LIMIT %d, %d", $query_web_shop2, $startRow_web_shop2, $maxRows_web_shop2);
$web_shop2 = mysql_query($query_limit_web_shop2, $conn_web) or die(mysql_error());
$row_web_shop2 = mysql_fetch_assoc($web_shop2);

if (isset($_GET['totalRows_web_shop2'])) {
  $totalRows_web_shop2 = $_GET['totalRows_web_shop2'];
} else {
  $all_web_shop2 = mysql_query($query_web_shop2);
  $totalRows_web_shop2 = mysql_num_rows($all_web_shop2);
}
$totalPages_web_shop2 = ceil($totalRows_web_shop2/$maxRows_web_shop2)-1;

$queryString_web_shop2 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_web_shop2") == false && 
        stristr($param, "totalRows_web_shop2") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_web_shop2 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_web_shop2 = sprintf("&totalRows_web_shop2=%d%s", $totalRows_web_shop2, $queryString_web_shop2);
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
<link href="web.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]><script src="ie6png.js" type="text/javascript"></script><![endif]-->
</head>

<body onload="MM_preloadImages('images/btn_shop1_2.gif','images/btn_shop2_2.gif','images/btn_shop3_2.gif','images/btn_shop4_2.gif','images/btn_shop5_2.gif','images/btn_shop6_2.gif')" background="images/background.jpg">
<div id="wrapper">
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
      <td height="25" valign="middle" class="underline3"> &nbsp;<a href="index.php">首頁</a> &gt; <?php echo $row_web_shop2['shop_name']; ?></td>
    </tr>
  </table>
  <?php if ($totalRows_web_shop2 > 0) { // Show if recordset not empty ?>
    <table >
      <tr>
        <?php
$web_shop2_endRow = 0;
$web_shop2_columns = 4; // number of columns
$web_shop2_hloopRow1 = 0; // first row flag
do {
    if($web_shop2_endRow == 0  && $web_shop2_hloopRow1++ != 0) echo "<tr>";
   ?>
        <td><table width="134" border="0" cellspacing="0" cellpadding="0" background="images/shop3.gif">
          <tr>
            <td width="134" height="79" align="center" valign="bottom"><a href="products_detial.php?p_id=<?php echo $row_web_shop2['p_id']; ?>"><img src="images/shop/thum/<?php echo $row_web_shop2['p_pic']; ?>" width="55" height="57" border="0" /></a></td>
          </tr>
          <tr>
            <td height="17" align="center" class="font1"><?php echo $row_web_shop2['p_name']; ?><br />
              <span class="font_red">NT：<?php echo $row_web_shop2['p_price']; ?></span></td>
          </tr>
          <tr>
            <td height="19" align="center"><a href="shopcart_add.php?p_name=<?php echo urlencode($row_web_shop2['p_name']); ?>&amp;p_price=<?php echo $row_web_shop2['p_price']; ?>&amp;p_pic=<?php echo $row_web_shop2['p_pic']; ?>"><img src="images/car_add.gif" width="75" height="16" border="0" /></a></td>
          </tr>
        </table></td>
        <?php  $web_shop2_endRow++;
if($web_shop2_endRow >= $web_shop2_columns) {
  ?>
      </tr>
      <?php
 $web_shop2_endRow = 0;
  }
} while ($row_web_shop2 = mysql_fetch_assoc($web_shop2));
if($web_shop2_endRow != 0) {
while ($web_shop2_endRow < $web_shop2_columns) {
    echo("<td>&nbsp;</td>");
    $web_shop2_endRow++;
}
echo("</tr>");
}?>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="bottom">&nbsp;
          <table border="0">
            <tr>
              <td><?php if ($pageNum_web_shop2 > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_web_shop2=%d%s", $currentPage, 0, $queryString_web_shop2); ?>">第一頁</a>
                  <?php } // Show if not first page ?></td>
              <td><?php if ($pageNum_web_shop2 > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_web_shop2=%d%s", $currentPage, max(0, $pageNum_web_shop2 - 1), $queryString_web_shop2); ?>">上一頁</a>
                  <?php } // Show if not first page ?></td>
              <td><?php if ($pageNum_web_shop2 < $totalPages_web_shop2) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_web_shop2=%d%s", $currentPage, min($totalPages_web_shop2, $pageNum_web_shop2 + 1), $queryString_web_shop2); ?>">下一頁</a>
                  <?php } // Show if not last page ?></td>
              <td><?php if ($pageNum_web_shop2 < $totalPages_web_shop2) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_web_shop2=%d%s", $currentPage, $totalPages_web_shop2, $queryString_web_shop2); ?>">最後一頁</a>
                  <?php } // Show if not last page ?></td>
            </tr>
          </table></td>
        <td align="right" valign="bottom">&nbsp;
          記錄 <?php echo ($startRow_web_shop2 + 1) ?> 到 <?php echo min($startRow_web_shop2 + $maxRows_web_shop2, $totalRows_web_shop2) ?> 共 <?php echo $totalRows_web_shop2 ?></td>
      </tr>
    </table>
    <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_web_shop2 == 0) { // Show if recordset empty ?>
  <table width="555" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2">目前資料庫中沒有任何資料!</td>
      </tr>
  </table>
  <?php } // Show if recordset empty ?>
  </div>
  <div id="main4"></div>
</div>
<?php include("footer.php"); ?>
</div>
</body>
</html>
<?php
mysql_free_result($web_shop2);
?>
