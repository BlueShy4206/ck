<script type="text/javascript" src="Scripts/jquery-2.1.0.min.js"></script>
<script src="Scripts/sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="Scripts/sweetalert2/dist/sweetalert2.min.css">
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> -->
<?php
ini_set("session.cookie_httponly", 1);
require_once('Connections/conn_web.php'); ?>
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

$maxRows_web_news = 4;
$pageNum_web_news = 0;
$maxRows_web_news2 = 4;
$pageNum_web_news2 = 0;
if (isset($_GET['pageNum_web_news'])) {
  $pageNum_web_news = $_GET['pageNum_web_news'];
}
$startRow_web_news = $pageNum_web_news * $maxRows_web_news;

if (isset($_GET['pageNum_web_news2'])) {
	$pageNum_web_news2 = $_GET['pageNum_web_news2'];
}
$startRow_web_news2 = $pageNum_web_news2 * $maxRows_web_news2;

mysql_select_db($database_conn_web, $conn_web);
$query_web_news = "SELECT news_id, news_title, news_type, date_format(news_date,'%Y-%m-%d') news_date, news_top FROM news WHERE news_date <= now() and news_type !='news' ORDER BY news_top DESC, news_id DESC";
$query_limit_web_news = sprintf("%s LIMIT %d, %d", $query_web_news, $startRow_web_news, $maxRows_web_news);
$web_news = mysql_query($query_limit_web_news, $conn_web) or die(mysql_error());
$row_web_news = mysql_fetch_assoc($web_news);

$query_web_news2 = "SELECT news_id, news_title, news_type, date_format(news_date,'%Y-%m-%d') news_date, news_top FROM news WHERE news_date <= now() and news_type ='news' ORDER BY news_top DESC, news_id DESC";
//$query_limit_web_news2 = sprintf("%s LIMIT %d, %d", $query_web_news2, $startRow_web_news, $maxRows_web_news);
$web_news2 = mysql_query($query_web_news2, $conn_web) or die(mysql_error());
$row_web_news2 = mysql_fetch_assoc($web_news2);

if (isset($_GET['totalRows_web_news'])) {
  $totalRows_web_news = $_GET['totalRows_web_news'];
} else {
  $all_web_news = mysql_query($query_web_news);
  $totalRows_web_news = mysql_num_rows($all_web_news);
}
$totalPages_web_news = ceil($totalRows_web_news/$maxRows_web_news)-1;

if (isset($_GET['totalRows_web_news2'])) {
	$totalRows_web_news2 = $_GET['totalRows_web_news'];
} else {
	$all_web_news2 = mysql_query($query_web_news2);
	$totalRows_web_news2 = mysql_num_rows($all_web_news2);
}
$totalPages_web_news2 = ceil($totalRows_web_news2/$maxRows_web_news2)-1;

mysql_select_db($database_conn_web, $conn_web);
$query_web_banner1 = "SELECT * FROM banner WHERE banner_type = '1' ORDER BY banner_id desc limit 1";//rand()
$web_banner1 = mysql_query($query_web_banner1, $conn_web) or die(mysql_error());
$row_web_banner1 = mysql_fetch_assoc($web_banner1);
$totalRows_web_banner1 = mysql_num_rows($web_banner1);

mysql_select_db($database_conn_web, $conn_web);
$query_web_banner2 = "SELECT * FROM banner WHERE banner_type = '2' OR banner_type = '3' order by rand() limit 1  ";
$web_banner2 = mysql_query($query_web_banner2, $conn_web) or die(mysql_error());
$row_web_banner2 = mysql_fetch_assoc($web_banner2);
$totalRows_web_banner2 = mysql_num_rows($web_banner2);

$maxRows_web_shop = 4;
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
<title>教師專業能力測驗中心</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="國民小學教師學科知能評量" />
<meta name="keywords" content="國民小學教師學科知能評量" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]><script src="ie6png.js" type="text/javascript"></script><![endif]-->
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>


</head>
<body  background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main" >
  <div id="main1"></div>
  <div id="main2">
      <?php include("leftzone.php")?>
  </div>
  <div id="main3" style="background-image:url(images/Background2.png);height:450px;">
    <table width="500" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20">
          <marquee onMouseOver="this.stop()" onMouseOut="this.start()" bgcolor="#EFEFEF" border="0" align="middle" scrollamount="2"  scrolldelay="90" behavior="scroll"  width="100%" height="20" style="color: #000000; font-size: 12">
            <a href="<?php echo $row_web_banner1['banner_url']; ?>"><img src="images/hot.gif" width="28" height="7" border="0" /><?php echo $row_web_banner1['banner_title']; ?></a>
          </marquee>
        </td>
      </tr>
    </table>


<div id="content">
    <img src="images/news.png" width="500" height="48" /><br />


    <table width="500" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
      <?php do { ?>
        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
          <td width="33" class="underline1">
            <?php /*START_PHP_SIRFCIT*/ if ($row_web_news['news_type']=="news"){ ?>
              <img src="images/icon_news.gif" />
            <?php } /*END_PHP_SIRFCIT*/ ?>
            <?php /*START_PHP_SIRFCIT*/ if ($row_web_news['news_type']=="action"){ ?>
              <img src="images/icon_action.gif" />
            <?php } /*END_PHP_SIRFCIT*/ ?>
          	<?php /*START_PHP_SIRFCIT*/ if ($row_web_news['news_type']=="publish"){ ?>
              <img src="images/icon_publish.jpg" />
            <?php } /*END_PHP_SIRFCIT*/ ?>
            <?php /*START_PHP_SIRFCIT*/ if ($row_web_news['news_type']=="news2"){ ?>
              <img src="images/icon_news2.jpg" />
            <?php } /*END_PHP_SIRFCIT*/ ?>
          </td>
          <td width="292" align="left" class="underline1"> &nbsp; <a href="news_detial.php?news_id=<?php echo $row_web_news['news_id']; ?>"><?php echo $row_web_news['news_title']; ?></a>&nbsp; &nbsp; <?php /*START_PHP_SIRFCIT*/ if ($row_web_news['news_date'] > date("Y-m-d",strtotime("-7 day"))){ ?>
              <img src="images/icon_new.gif" width="23" height="9" />
              <?php } /*END_PHP_SIRFCIT*/ ?>

                <?php
		  //若為置頂公告則增添TOP圖示
		  /*START_PHP_SIRFCIT*/ if ($row_web_news['news_top']==1){ ?>
              <img src="images/icon_top.gif" width="23" height="9" />
              <?php } /*END_PHP_SIRFCIT*/ ?></td>
          <td width="90" align="right" class="underline1"><?php echo $row_web_news['news_date']; ?></td>
        </tr>
        <?php } while ($row_web_news = mysql_fetch_assoc($web_news)); ?>
    </table>
   <table width="500" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
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
          <td align="right" valign="bottom">
         記錄  <?php echo ($startRow_web_news + 1) ?>到 <?php echo min($startRow_web_news + $maxRows_web_news, $totalRows_web_news) ?> 共 <?php echo $totalRows_web_news ?></td>
        </tr>
   </table>
   <br>相關新聞：
   <table width="500" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
      <?php do { ?>
        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
          <td width="33" class="underline1">
            <?php /*START_PHP_SIRFCIT*/ if ($row_web_news2['news_type']=="news"){ ?>
              <img src="images/icon_news.gif" />
              <?php } /*END_PHP_SIRFCIT*/ ?>
            <?php /*START_PHP_SIRFCIT*/ if ($row_web_news2['news_type']=="action"){ ?>
              <img src="images/icon_action.gif" />
            <?php } /*END_PHP_SIRFCIT*/ ?>
          	<?php /*START_PHP_SIRFCIT*/ if ($row_web_news2['news_type']=="publish"){ ?>
              	公告
            <?php } /*END_PHP_SIRFCIT*/ ?>
          </td>
          <td width="292" align="left" class="underline1"> &nbsp; <a href="news_detial.php?news_id=<?php echo $row_web_news2['news_id']; ?>"><?php echo $row_web_news2['news_title']; ?></a>&nbsp; &nbsp; <?php /*START_PHP_SIRFCIT*/ if ($row_web_news2['news_date'] > date("Y-m-d",strtotime("-7 day"))){ ?>
              <img src="images/icon_new.gif" width="23" height="9" />
              <?php } /*END_PHP_SIRFCIT*/ ?>

                <?php
		  //若為置頂公告則增添TOP圖示
		  /*START_PHP_SIRFCIT*/ if ($row_web_news2['news_top']==1){ ?>
              <img src="images/icon_top.gif" width="23" height="9" />
              <?php } /*END_PHP_SIRFCIT*/ ?></td>
          <td width="90" align="right" class="underline1"><?php echo $row_web_news2['news_date']; ?></td>
        </tr>
        <?php } while ($row_web_news2 = mysql_fetch_assoc($web_news2)); ?>
    </table>
   </div>
  </div>

  <div id="main4"></div>


<?php include("footer.php"); ?>

<script type="text/javascript">

// swal({
// 	html:"<b>7/21(六)上午7:00-7/23(一)上午8:30<br>因本校進行高壓電力檢查,網站暫停服務<br>造成不便 敬請見諒！！",
// 	title: "<b>主機房高壓電力檢查停電公告</b>",
// 	type: "warning",
// 	animation: "slide-from-top",
// });

</script>


</div>
</div>
</body>
</html>
<?php
mysql_free_result($web_news);

mysql_free_result($web_banner1);

mysql_free_result($web_banner2);

mysql_free_result($web_shop);
?>
