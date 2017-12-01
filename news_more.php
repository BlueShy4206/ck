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

$maxRows_web_news = 10;
$pageNum_web_news = 0;
if (isset($_GET['pageNum_web_news'])) {
  $pageNum_web_news = $_GET['pageNum_web_news'];
}
$startRow_web_news = $pageNum_web_news * $maxRows_web_news;

mysql_select_db($database_conn_web, $conn_web);
$query_web_news = "SELECT news_id, news_title, news_type, news_date, news_top FROM news ORDER BY news_top DESC, news_id DESC";
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

mysql_select_db($database_conn_web, $conn_web);
$query_web_banner1 = "SELECT * FROM banner WHERE banner_type = '1' ORDER BY rand() limit 1";
$web_banner1 = mysql_query($query_web_banner1, $conn_web) or die(mysql_error());
$row_web_banner1 = mysql_fetch_assoc($web_banner1);
$totalRows_web_banner1 = mysql_num_rows($web_banner1);

mysql_select_db($database_conn_web, $conn_web);
$query_web_banner2 = "SELECT * FROM banner WHERE banner_type = '2' OR banner_type = '3' order by rand() limit 1  ";
$web_banner2 = mysql_query($query_web_banner2, $conn_web) or die(mysql_error());
$row_web_banner2 = mysql_fetch_assoc($web_banner2);
$totalRows_web_banner2 = mysql_num_rows($web_banner2);

$maxRows_web_shop = 8;
$pageNum_web_shop = 0;
if (isset($_GET['pageNum_web_shop'])) {
  $pageNum_web_shop = $_GET['pageNum_web_shop'];
}
$startRow_web_shop = $pageNum_web_shop * $maxRows_web_shop;

mysql_select_db($database_conn_web, $conn_web);
$query_web_shop = "SELECT * FROM shop2 WHERE p_open = 'Y' ORDER BY p_id DESC";
$query_limit_web_shop = sprintf("%s LIMIT %d, %d", $query_web_shop, $startRow_web_shop, $maxRows_web_shop);
$web_shop = mysql_query($query_limit_web_shop, $conn_web) or die(mysql_error());
$row_web_shop = mysql_fetch_assoc($web_shop);

if (isset($_GET['totalRows_web_shop'])) {
  $totalRows_web_shop = $_GET['totalRows_web_shop'];
} else {
  $all_web_shop = mysql_query($query_web_shop);
  $totalRows_web_shop = mysql_num_rows($all_web_shop);
}
$totalPages_web_shop = ceil($totalRows_web_shop/$maxRows_web_shop)-1;
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
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
</head>

<body onload="MM_preloadImages('images/btn_shop1_2.gif','images/btn_shop2_2.gif','images/btn_shop3_2.gif','images/btn_shop4_2.gif','images/btn_shop5_2.gif','images/btn_shop6_2.gif')">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <?php include("leftzone.php")?>
  </div>
  <div id="main3">
    <table width="555" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20">
          <marquee onMouseOver="this.stop()" onMouseOut="this.start()" bgcolor="#FFFFFF" border="0" align="middle" scrollamount="2"  scrolldelay="90" behavior="scroll"  width="100%" height="20" style="color: #000000; font-size: 12">
            <a href="<?php echo $row_web_banner1['banner_url']; ?>"><img src="images/hot.gif" width="28" height="7" border="0" /><?php echo $row_web_banner1['banner_title']; ?></a>
          </marquee>
        </td>
      </tr>
    </table>
<table width="555" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="154"><?php /*START_PHP_SIRFCIT*/ if ($row_web_banner2['banner_type']=="3"){ ?>
          <a href="<?php echo $row_web_banner2['banner_url']; ?>"><img src="images/panner/<?php echo $row_web_banner2['banner_pic']; ?>" width="555" height="154" border="0"></a>
        <?php } /*END_PHP_SIRFCIT*/ ?>
      <?php /*START_PHP_SIRFCIT*/ if ($row_web_banner2['banner_type']=="2"){ ?>
        <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="555" height="154">
          <param name="movie" value="images/panner/<?php echo $row_web_banner2['banner_pic']; ?>" />
          <param name="quality" value="high" />
          <param name="wmode" value="opaque" />
          <param name="swfversion" value="6.0.65.0" />
          <!-- 此 param 標籤會提示使用 Flash Player 6.0 r65 和更新版本的使用者下載最新版本的 Flash Player。如果您不想讓使用者看到這項提示，請將其刪除。 -->
          <param name="expressinstall" value="Scripts/expressInstall.swf" />
          <!-- 下一個物件標籤僅供非 IE 瀏覽器使用。因此，請使用 IECC 將其自 IE 隱藏。 -->
          <!--[if !IE]>-->
          <object type="application/x-shockwave-flash" data="images/panner/<?php echo $row_web_banner2['banner_pic']; ?>" width="555" height="154">
            <!--<![endif]-->
            <param name="quality" value="high" />
            <param name="wmode" value="opaque" />
            <param name="swfversion" value="6.0.65.0" />
            <param name="expressinstall" value="Scripts/expressInstall.swf" />
            <!-- 瀏覽器會為使用 Flash Player 6.0 和更早版本的使用者顯示下列替代內容。 -->
            <div>
              <h4>這個頁面上的內容需要較新版本的 Adobe Flash Player。</h4>
              <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="取得 Adobe Flash Player" /></a></p>
              </div>
            <!--[if !IE]>-->
            </object>
          <!--<![endif]-->
        </object>
        <?php } /*END_PHP_SIRFCIT*/ ?>
</td>
  </tr>
</table>
    <img src="images/adv2.gif" width="505" height="31" /><img src="images/adv3.gif" width="50" height="31" border="0" /><br />
    
    
    <table width="550" border="0" cellspacing="0" cellpadding="0">
      <?php do { ?>
        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
          <td width="33" class="underline1">
            <?php /*START_PHP_SIRFCIT*/ if ($row_web_news['news_type']=="news"){ ?>
              <img src="images/icon_news.gif" />
              <?php } /*END_PHP_SIRFCIT*/ ?>
            <?php /*START_PHP_SIRFCIT*/ if ($row_web_news['news_type']=="action"){ ?>
              <img src="images/icon_action.gif" />
          <?php } /*END_PHP_SIRFCIT*/ ?></td>
          <td width="292" align="left" class="underline1"> &nbsp; <a href="news_detial.php?news_id=<?php echo $row_web_news['news_id']; ?>"><?php echo $row_web_news['news_title']; ?></a>&nbsp; &nbsp; <?php /*START_PHP_SIRFCIT*/ if ($row_web_news['news_date'] > date("Y-m-d",strtotime("-7 day"))){ ?>
              <img src="images/icon_new.gif" width="23" height="9" />
              <?php } /*END_PHP_SIRFCIT*/ ?>
              
                <?php 
		  //若為置頂公告則增添TOP圖示
		  /*START_PHP_SIRFCIT*/ if ($row_web_news['news_top']==1){ ?>
              <img src="images/icon_top.gif" width="23" height="9" />
              <?php } /*END_PHP_SIRFCIT*/ ?>  </td>
          <td width="100" align="right" class="underline1"><?php echo $row_web_news['news_date']; ?></td>
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
  </div>
   
  <div id="main4"></div>


<?php include("footer.php"); ?>
<script type="text/javascript">
<!--
swfobject.registerObject("FlashID");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($web_news);

mysql_free_result($web_banner1);

mysql_free_result($web_banner2);

mysql_free_result($web_shop);
?>
