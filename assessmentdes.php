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

$maxRows_web_news = 12;
$pageNum_web_news = 0;
if (isset($_GET['pageNum_web_news'])) {
  $pageNum_web_news = $_GET['pageNum_web_news'];
}
$startRow_web_news = $pageNum_web_news * $maxRows_web_news;

mysql_select_db($database_conn_web, $conn_web);
$query_web_news = "SELECT file_id, file_title, file_name, file_date, position FROM file WHERE public_mk=1 ORDER BY position ASC,file_id DESC";
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
</head>

<body onload="MM_preloadImages('images/index_button2.png','images/aboutCK_button2.png','images/download_button2.png','images/Q&A_button2.png')" background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
<?php include("leftzone.php")?>
  </div>
  <div id="main3">
    <table width="520" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20">
          <marquee onMouseOver="this.stop()" onMouseOut="this.start()" bgcolor="#efefef" border="0" align="middle" scrollamount="2"  scrolldelay="90" behavior="scroll"  width="100%" height="20" style="color: #000000; font-size: 12">
            <a href="<?php echo $row_web_banner1['banner_url']; ?>"><img src="images/hot.gif" width="28" height="7" border="0" /><?php echo $row_web_banner1['banner_title']; ?></a>
          </marquee>
        </td>
      </tr>
    </table>
<table width="520" border="0" cellspacing="0" cellpadding="0">

</table>
    <img src="images/assessmentdes.png" width="520" height="30" /><br />
    <table width="520" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">

        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
          <td width="30" class="underline1">
           </td>
          <td width="300" align="left" class="underline1"> &nbsp; <a href="file/20160328080351.pdf">數學領域學科知能評量_評量架構.pdf</a>&nbsp; &nbsp; </td>
        </tr>
        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
          <td width="30" class="underline1">
           </td>
          <td width="300" align="left" class="underline1"> &nbsp; <a href="file/20160328080356.pdf">數學領域學科知能評量_範例試題.pdf</a>&nbsp; &nbsp; </td>
        </tr>
        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
          <td width="30" class="underline1">
           </td>
          <td width="300" align="left" class="underline1"> &nbsp; <a href="file/20160328080340.pdf">國語領域學科知能評量_評量架構.pdf</a>&nbsp; &nbsp; </td>
        </tr>
        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
          <td width="30" class="underline1">
           </td>
          <td width="300" align="left" class="underline1"> &nbsp; <a href="file/20160328080345.pdf">國語領域學科知能評量_範例試題.pdf</a>&nbsp; &nbsp; </td>
        </tr>
        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
          <td width="30" class="underline1">
           </td>
          <td width="300" align="left" class="underline1"> &nbsp; <a href="file/20150630165520.pdf">自然領域學科知能評量_範例試題.pdf</a>&nbsp; &nbsp; </td>
        </tr>
        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
          <td width="30" class="underline1">
           </td>
          <td width="300" align="left" class="underline1"> &nbsp; <a href="file/20150625055424.pdf">自然領域學科知能評量_評量架構.pdf</a>&nbsp; &nbsp; </td>
        </tr>
        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
          <td width="30" class="underline1">
           </td>
          <td width="300" align="left" class="underline1"> &nbsp; <a href="file/20160328075815.pdf">社會領域學科知能評量_評量架構.pdf</a>&nbsp; &nbsp; </td>
        </tr>
        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
          <td width="30" class="underline1">
           </td>
          <td width="300" align="left" class="underline1"> &nbsp; <a href="file/20160328080332.pdf">社會領域學科知能評量_範例試題.pdf</a>&nbsp; &nbsp; </td>
        </tr>
        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
          <td width="30" class="underline1">
           </td>
          <td width="300" align="left" class="underline1"> &nbsp; <a href="news_detial.php?news_id=4023">學科知能評量_電腦化適性測驗操作範例</a>&nbsp; &nbsp; </td>
        </tr>

    </table>

     <table width="520" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
        <tr>
          <td align="left" valign="bottom">&nbsp;
            <table border="0">
            </table>
        </td>
         </tr>
      </table>

     <?php if ($totalRows_web_news == 0) { // Show if recordset empty ?>
  <table width="520" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2" bgcolor="#FFFFFF">目前資料庫中沒有任何資料可以提供下載!</td>
      </tr>
  </table>
  <?php } // Show if recordset empty ?>

  </div>
  <div id="main4"></div>
  <?php include("footer.php"); ?>
</div>
</div>
</body>

</html>
<?php
mysql_free_result($web_news);

mysql_free_result($web_banner1);

mysql_free_result($web_banner2);

?>
