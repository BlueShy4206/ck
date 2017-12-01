<?php
#	BuildNav for Dreamweaver MX v0.2
#              10-02-2002
#	Alessandro Crugnola [TMM]
#	sephiroth: alessandro@sephiroth.it
#	http://www.sephiroth.it
#	
#	Function for navigation build ::
function buildNavigation($pageNum_Recordset1,$totalPages_Recordset1,$prev_Recordset1,$next_Recordset1,$separator=" | ",$max_links=10, $show_page=true)
{
                GLOBAL $maxRows_web_orders,$totalRows_web_orders;
	$pagesArray = ""; $firstArray = ""; $lastArray = "";
	if($max_links<2)$max_links=2;
	if($pageNum_Recordset1<=$totalPages_Recordset1 && $pageNum_Recordset1>=0)
	{
		if ($pageNum_Recordset1 > ceil($max_links/2))
		{
			$fgp = $pageNum_Recordset1 - ceil($max_links/2) > 0 ? $pageNum_Recordset1 - ceil($max_links/2) : 1;
			$egp = $pageNum_Recordset1 + ceil($max_links/2);
			if ($egp >= $totalPages_Recordset1)
			{
				$egp = $totalPages_Recordset1+1;
				$fgp = $totalPages_Recordset1 - ($max_links-1) > 0 ? $totalPages_Recordset1  - ($max_links-1) : 1;
			}
		}
		else {
			$fgp = 0;
			$egp = $totalPages_Recordset1 >= $max_links ? $max_links : $totalPages_Recordset1+1;
		}
		if($totalPages_Recordset1 >= 1) {
			#	------------------------
			#	Searching for $_GET vars
			#	------------------------
			$_get_vars = '';			
			if(!empty($_GET) || !empty($HTTP_GET_VARS)){
				$_GET = empty($_GET) ? $HTTP_GET_VARS : $_GET;
				foreach ($_GET as $_get_name => $_get_value) {
					if ($_get_name != "pageNum_web_orders") {
						$_get_vars .= "&$_get_name=$_get_value";
					}
				}
			}
			$successivo = $pageNum_Recordset1+1;
			$precedente = $pageNum_Recordset1-1;
			$firstArray = ($pageNum_Recordset1 > 0) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_web_orders=$precedente$_get_vars\">$prev_Recordset1</a>" :  "$prev_Recordset1";
			# ----------------------
			# page numbers
			# ----------------------
			for($a = $fgp+1; $a <= $egp; $a++){
				$theNext = $a-1;
				if($show_page)
				{
					$textLink = $a;
				} else {
					$min_l = (($a-1)*$maxRows_web_orders) + 1;
					$max_l = ($a*$maxRows_web_orders >= $totalRows_web_orders) ? $totalRows_web_orders : ($a*$maxRows_web_orders);
					$textLink = "$min_l - $max_l";
				}
				$_ss_k = floor($theNext/26);
				if ($theNext != $pageNum_Recordset1)
				{
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_web_orders=$theNext$_get_vars\">";
					$pagesArray .= "$textLink</a>" . ($theNext < $egp-1 ? $separator : "");
				} else {
					$pagesArray .= "$textLink"  . ($theNext < $egp-1 ? $separator : "");
				}
			}
			$theNext = $pageNum_Recordset1+1;
			$offset_end = $totalPages_Recordset1;
			$lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_web_orders=$successivo$_get_vars\">$next_Recordset1</a>" : "$next_Recordset1";
		}
	}
	return array($firstArray,$pagesArray,$lastArray);
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

$maxRows_web_orders = 10;
$pageNum_web_orders = 0;
if (isset($_GET['pageNum_web_orders'])) {
  $pageNum_web_orders = $_GET['pageNum_web_orders'];
}
$startRow_web_orders = $pageNum_web_orders * $maxRows_web_orders;

mysql_select_db($database_conn_web, $conn_web);
$query_web_orders = "SELECT * FROM orders ORDER BY order_id DESC";
$query_limit_web_orders = sprintf("%s LIMIT %d, %d", $query_web_orders, $startRow_web_orders, $maxRows_web_orders);
$web_orders = mysql_query($query_limit_web_orders, $conn_web) or die(mysql_error());
$row_web_orders = mysql_fetch_assoc($web_orders);

if (isset($_GET['totalRows_web_orders'])) {
  $totalRows_web_orders = $_GET['totalRows_web_orders'];
} else {
  $all_web_orders = mysql_query($query_web_orders);
  $totalRows_web_orders = mysql_num_rows($all_web_orders);
}
$totalPages_web_orders = ceil($totalRows_web_orders/$maxRows_web_orders)-1;
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
    <td width="25" align="left"><img src="../images/board13.gif" /></td>
    <td width="78" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">訂 單 管 理 區</span></td>
    <td width="442" align="left" valign="middle" background="../images/board04.gif">&nbsp;</td>
    <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
  </tr>
</table>
  <?php if ($totalRows_web_orders > 0) { // Show if recordset not empty ?>
    <table width="555" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="70" align="center" class="board_add3"><span class="font_black">訂單編號</span></td>
        <td width="245" height="30" align="left" class="board_add3"><span class="font_black">會員姓名(帳號)-訂購日期<span class="font_red">&nbsp;&nbsp;&nbsp;&nbsp;</span></span></td>
        <td width="70" align="center" class="board_add3"><span class="font_black">付款方式</span><span class="font_red">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
        <td width="70" align="center" class="board_add3"><span class="font_black">付款狀態</span><span class="font_red"></span></td>
        <td width="50" align="center" class="board_add3"><span class="font_black">檢視</span></td>
        <td width="50" align="center" class="board_add3">刪除</td>
      </tr>
      <?php do { ?>
        <tr>
          <td align="center" class="board_add3"><?php echo $row_web_orders['order_id']; ?></td>
          <td height="30" align="left" class="board_add3"><?php echo $row_web_orders['order_name1']; ?>(<?php echo $row_web_orders['order_username']; ?>)-<?php echo $row_web_orders['order_date']; ?></td>
          <td align="center" class="board_add3"><?php echo $row_web_orders['order_paytype']; ?></td>
          <td align="center" class="board_add3"><?php echo $row_web_orders['order_payok']; ?></td>
          <td align="center" class="board_add3"><a href="admin_ordersDetial.php?order_id=<?php echo $row_web_orders['order_id']; ?>&amp;order_sid=<?php echo $row_web_orders['order_sid']; ?>&amp;order_group=<?php echo $row_web_orders['order_group']; ?>">檢視</a></td>
          <td align="center" class="board_add3"><a href="admin_ordersDel.php?order_id=<?php echo $row_web_orders['order_id']; ?>&amp;delSure=1" onclick="tfm_confirmLink('確定刪除本資料?');return document.MM_returnValue">刪除</a></td>
        </tr>
        <?php } while ($row_web_orders = mysql_fetch_assoc($web_orders)); ?>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="bottom"><?php 
# variable declaration
$prev_web_orders = "« 上一頁";
$next_web_orders = "下一頁 »";
$separator = " | ";
$max_links = 10;
$pages_navigation_web_orders = buildNavigation($pageNum_web_orders,$totalPages_web_orders,$prev_web_orders,$next_web_orders,$separator,$max_links,true); 

print $pages_navigation_web_orders[0]; 
?>
          <?php print $pages_navigation_web_orders[1]; ?> <?php print $pages_navigation_web_orders[2]; ?></td>
        <td align="right" valign="bottom">&nbsp;
          記錄 <?php echo ($startRow_web_orders + 1) ?> 到 <?php echo min($startRow_web_orders + $maxRows_web_orders, $totalRows_web_orders) ?> 共 <?php echo $totalRows_web_orders ?></td>
      </tr>
    </table>
    <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_web_orders == 0) { // Show if recordset empty ?>
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
mysql_free_result($web_orders);
?>
