<?php require_once('login_check.php'); ?>
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

$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}

mysql_select_db($database_conn_web, $conn_web);
$query_examyear = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$web_examyear = mysql_query($query_examyear, $conn_web) or die(mysql_error());
$row_examyear = mysql_fetch_assoc($web_examyear);

mysql_select_db($database_conn_web, $conn_web); //`id` `name` `school` `Student_ID` `Department` `Grade`
$query_web_news = sprintf("SELECT id, name, school, Student_ID, Department, Grade, chinese_level, chinese, math_level, math, social_level, social, physical_level, physical FROM forfirst WHERE id = %s ORDER BY id ASC", GetSQLValueString($colname_web_member, "text"));
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
<title>國民小學教師學科知能評量</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="國民小學教師學科知能評量" />
<meta name="keywords" content="國民小學教師學科知能評量" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<script type="text/javascript">

</script>
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
  <?php
  $queryScore_mk = false;
  if ($row_examyear['scoreTime'] <= date("Y-m-d H:i:s")){
  	$queryScore_mk = false;//改
  }
  //判斷成績是否開放查詢
  if ($queryScore_mk){
  ?>
  <div id="main3">
    <table width="540" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20">
          <marquee onMouseOver="this.stop()" onMouseOut="this.start()" bgcolor="#efefef" border="0" align="middle" scrollamount="2"  scrolldelay="90" behavior="scroll"  width="100%" height="20" style="color: #000000; font-size: 12">
            <a href="<?php echo $row_web_banner1['banner_url']; ?>"><img src="images/hot.gif" width="28" height="7" border="0" /><?php echo $row_web_banner1['banner_title']; ?></a>
          </marquee>
        </td>
      </tr>
    </table>
    <!--<img src="images/Results.png" width="540" height="48" /><br />-->
	<img src="images/score_person1.png" width="540" height="48" /><br />
	 <table width="540" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
    <tr>
          <td width="20" height="25" align="right" class="underline1"></td>
          <!--<td width="100" align="center" class="underline1">考試時間</td>-->
          <td width="79" align="center" class="underline1">准考證</td>
		  <td width="79" align="center" class="underline1">名字</td>
		  <td width="79" align="center" class="underline1">學校</td>
          <td width="79" align="center" class="underline1">學校學號</td>
		  <td width="79" align="center" class="underline1">系別</td>
          <td width="79" align="center" class="underline1">年級</td>
        </tr>


        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
		  <!--id, name, school, Student_ID, Department, Grade-->
          <td width="79" align="center" class="underline1"> <?php echo $row_web_news['id']; ?> </td>
          <td width="79" align="center" class="underline1"> <?php echo $row_web_news['name']; ?> </td>
          <td width="79" align="center" class="underline1"> <?php echo $row_web_news['school']; ?> </td>
          <td width="79" align="center" class="underline1"> <?php echo $row_web_news['Student_ID']; ?> </td>
		  <td width="79" align="center" class="underline1"> <?php echo $row_web_news['Department']; ?> </td>
          <td width="79" align="center" class="underline1"> <?php echo $row_web_news['Grade']; ?> </td>
        </tr>

    </table>

	<br />
	<img src="images/Results.png" width="540" height="48" />

    <table width="540" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
    <tr>
          <td width="20" height="25" align="right" class="underline1"></td>
          <td width="79" align="center" class="underline1">國語領域</td>
		  <td width="79" align="center" class="underline1">社會領域</td>
		  <td width="79" align="center" class="underline1">數學領域</td>
		  <td width="79" align="center" class="underline1">自然領域</td>
        </tr>

      <?php do { ?>
        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
		 <!--chinese_level, chinese, math_level, math, social_level, social, physical_level, physical-->
          <td width="79" align="center" class="underline1">
          <?php if($row_web_news['chinese'] == ""){echo "";}
          	else{
          		echo '<a href="resultsOutprint.php?type=c">'.' <img class="img-20" src="images/icon_print.png" />'.'</a>';}
          	IF($row_web_news['chinese_level']=='精熟' || $row_web_news['chinese_level']=='基礎'){
          		echo ' <img class="img-20" src="images/icon_mail.png" onclick="ShowLink()" />';
          	}
          		?> </td>
          <!-- <td width="79" align="center" class="underline1"> <?php if($row_web_news['chinese'] == 0){echo " ";}else{echo $row_web_news['chinese'];} ?> </td> -->

		  <td width="79" align="center" class="underline1">
		  <?php if($row_web_news['social'] == ""){echo "";}
		  else{
		  	echo '<a href="resultsOutprint.php?type=s">'.' <img class="img-20" src="images/icon_print.png" />'.'</a>';}
			IF($row_web_news['social_level']=='精熟' || $row_web_news['social_level']=='基礎'){
          		echo ' <img class="img-20" src="images/icon_mail.png" onclick="ShowLink()" />';
          	}
		  	?> </td>
          <!-- <td width="79" align="center" class="underline1"> <?php if($row_web_news['social'] == 0){echo " ";}else{echo $row_web_news['social'];} ?> </td> -->
          <td width="79" align="center" class="underline1">
          <?php if($row_web_news['math'] == ""){echo " ";}
          else{
          	echo '<a href="resultsOutprint.php?type=m">'.' <img class="img-20" src="images/icon_print.png" />'.'</a>';}
          	IF($row_web_news['math_level']=='精熟' || $row_web_news['math_level']=='基礎'){
          		echo ' <img class="img-20" src="images/icon_mail.png" onclick="ShowLink()" />';
          	}
          	?> </td>
          <!-- <td width="79" align="center" class="underline1"> <?php if($row_web_news['math'] == 0){echo " ";}else{echo $row_web_news['math'];} ?> </td> -->
          <td width="79" align="center" class="underline1">
          <?php if($row_web_news['physical'] == ""){echo " ";}
          else{
          	echo '<a href="resultsOutprint.php?type=p">'.' <img class="img-20" src="images/icon_print.png" />'.'</a>';}
          	IF($row_web_news['physical_level']=='精熟' || $row_web_news['physical_level']=='基礎'){
          		echo ' <img class="img-20" src="images/icon_mail.png" onclick="ShowLink()" />';
          	}
          	?> </td>
          <!-- <td width="79" align="center" class="underline1"> <?php if($row_web_news['physical'] == 0){echo " ";}else{echo $row_web_news['physical'];} ?> </td> -->
        </tr>
        <?php } while ($row_web_news = mysql_fetch_assoc($web_news)); ?>

    </table>

     <table width="540" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
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
      <table>
        <tr><td width="20" height="30" align="right" >‧</td>
        <td>
        <img class="img-20" src="images/icon_print.png" />：列印成績單</td>
        </tr>
        <tr><td width="20" height="30" align="right" >‧</td>
        <td><img class="img-20" src="images/icon_mail.png" />：證明書申請</td>
        </tr>
       </table>
     <?php if ($totalRows_web_news == 0) { // Show if recordset empty ?>
  <table width="540" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2" bgcolor="#FFFFFF">目前資料庫中沒有任何資料!</td>
    </tr>
  </table>
  <?php } // Show if recordset empty ?>

  </div>
	<?PHP }else{?><table width="540" border="0" cellspacing="0" cellpadding="0" align="center">
      	<p align="center" class="font_red2">目前尚未開放成績查詢<br></p>
      	<p align="center"><a href="index.php">[返回首頁]</a></p>
	<?PHP }?>
  <div id="main4"></div>

<?php include("footer.php"); ?>
</div>
</body>
</html>
<?php
mysql_free_result($web_news);

mysql_free_result($web_banner1);

mysql_free_result($web_banner2);

?>
