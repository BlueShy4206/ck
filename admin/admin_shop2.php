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
                GLOBAL $maxRows_web_shop2,$totalRows_web_shop2;
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
					if ($_get_name != "pageNum_web_shop2") {
						$_get_vars .= "&$_get_name=$_get_value";
					}
				}
			}
			$successivo = $pageNum_Recordset1+1;
			$precedente = $pageNum_Recordset1-1;
			$firstArray = ($pageNum_Recordset1 > 0) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_web_shop2=$precedente$_get_vars\">$prev_Recordset1</a>" :  "$prev_Recordset1";
			# ----------------------
			# page numbers
			# ----------------------
			for($a = $fgp+1; $a <= $egp; $a++){
				$theNext = $a-1;
				if($show_page)
				{
					$textLink = $a;
				} else {
					$min_l = (($a-1)*$maxRows_web_shop2) + 1;
					$max_l = ($a*$maxRows_web_shop2 >= $totalRows_web_shop2) ? $totalRows_web_shop2 : ($a*$maxRows_web_shop2);
					$textLink = "$min_l - $max_l";
				}
				$_ss_k = floor($theNext/26);
				if ($theNext != $pageNum_Recordset1)
				{
					$pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_web_shop2=$theNext$_get_vars\">";
					$pagesArray .= "$textLink</a>" . ($theNext < $egp-1 ? $separator : "");
				} else {
					$pagesArray .= "$textLink"  . ($theNext < $egp-1 ? $separator : "");
				}
			}
			$theNext = $pageNum_Recordset1+1;
			$offset_end = $totalPages_Recordset1;
			$lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_web_shop2=$successivo$_get_vars\">$next_Recordset1</a>" : "$next_Recordset1";
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

$maxRows_web_shop2 = 10;
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
$query_web_shop2 = sprintf("SELECT shop1.shop_id,shop1.shop_name,shop2.p_id, shop2.p_name, shop2.p_open, shop2.p_pic FROM shop1 Left Join shop2 ON shop1.shop_id = shop2.shop_id WHERE shop2.shop_id = %s ORDER BY shop2.p_id DESC", GetSQLValueString($colname_web_shop2, "int"));
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
<script src="../ie6png.js" type="text/javascript"></script>
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
        <td width="404" align="left" valign="middle" background="../images/board04.gif"><span class="font_black">&nbsp; [<span class="font_red"> &nbsp;<?php echo $row_web_shop2['shop_name']; ?> &nbsp; </span>] 分類商品管理區&nbsp; &nbsp;</span></td>
        <td width="116" align="right" background="../images/board04.gif"><a href="admin_shop2Add.php?shop_id=<?php echo $_GET['shop_id']; ?>"><img src="../images/icon_shop2Add.gif" width="89" height="19" border="0" /></a></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <?php if ($totalRows_web_shop2 > 0) { // Show if recordset not empty ?>
      <table width="555" border="0" cellspacing="0" cellpadding="0">
        <?php do { ?>
          <tr>
            <td width="25" align="center" class="board_add3"><?php echo $row_web_shop2['p_id']; ?></td>
            <td width="430" height="30" align="left" class="board_add3">&nbsp; &nbsp; <img src="../images/shop/thum/<?php echo $row_web_shop2['p_pic']; ?>" alt="" name="pic" width="57" id="pic" />&nbsp; <?php echo $row_web_shop2['p_name']; ?>
              <?php /*START_PHP_SIRFCIT*/ if ($row_web_shop2['p_open']=="Y"){ ?>
                <img src="../images/open.gif" />
                <?php } /*END_PHP_SIRFCIT*/ ?>
              &nbsp;
              <?php /*START_PHP_SIRFCIT*/ if ($row_web_shop2['p_open']=="N"){ ?>
                <img src="../images/open_no.gif" width="50" height="19" />
                <?php } /*END_PHP_SIRFCIT*/ ?></td>
            <td width="100" align="center" class="board_add3">[ <a href="admin_shop2Update.php?p_id=<?php echo $row_web_shop2['p_id']; ?>">編輯</a> ]&nbsp; [ <a href="admin_shop2Del.php?delSure=1&amp;p_id=<?php echo $row_web_shop2['p_id']; ?>&amp;shop_id=<?php echo $row_web_shop2['shop_id']; ?>&amp;p_pic=<?php echo $row_web_shop2['p_pic']; ?>" onclick="tfm_confirmLink('確定刪除本商品?');return document.MM_returnValue">刪除</a> ]</td>
          </tr>
          <?php } while ($row_web_shop2 = mysql_fetch_assoc($web_shop2)); ?>
      </table>
      <table width="555" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="bottom"><?php 
# variable declaration
$prev_web_shop2 = "« 上一頁";
$next_web_shop2 = "下一頁 »";
$separator = " | ";
$max_links = 10;
$pages_navigation_web_shop2 = buildNavigation($pageNum_web_shop2,$totalPages_web_shop2,$prev_web_shop2,$next_web_shop2,$separator,$max_links,true); 

print $pages_navigation_web_shop2[0]; 
?>
          <?php print $pages_navigation_web_shop2[1]; ?> <?php print $pages_navigation_web_shop2[2]; ?></td>
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
<p><script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<input name="Submit" type="button" onclick="MM_goToURL('parent','admin_shop1.php');return document.MM_returnValue" value="回商品管理區" />
</p>
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
mysql_free_result($web_shop2);
?>
