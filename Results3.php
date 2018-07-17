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
//add status search, by coway 2017.1.5
// $query_examyear = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$query_examyear = sprintf("SELECT * FROM examyear where status=%s ORDER BY id DESC LIMIT 0,1",GetSQLValueString($_GET['status'],"text"));
$web_examyear = mysql_query($query_examyear, $conn_web) or die(mysql_error());
$row_examyear = mysql_fetch_assoc($web_examyear);

mysql_select_db($database_conn_web, $conn_web);
//add status search,add examinee/examyear_id, by coway 2017.1.5
// $query_web_news = sprintf("SELECT ex.username, ex.birthday, ex.status, s.* FROM examinee ex, score s WHERE ex.id_number=s.score_id and ex.username = %s ORDER BY id ASC", GetSQLValueString($colname_web_member, "text"));
$query_web_news = sprintf("SELECT ex.username, ex.birthday, ex.status, ex.examyear_id, s.* FROM examinee ex, score s WHERE ex.id_number=s.score_id and ex.username = %s and ex.status=%s ORDER BY id ASC", GetSQLValueString($colname_web_member, "text"),GetSQLValueString($_GET['status'],"text"));
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
$showPrint_mk = false;

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

<!--<link rel="stylesheet" type="text/css" href="js/themes/easyui.css" />
<link rel="stylesheet" type="text/css" href="js/themes/icon.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.easyui.min.js"></script>
<script type="text/javascript" src="js/easyui-lang-zh_TW.js"></script>
引入easyui-->
<!--已在leftzone引入easyui-->

<script type="text/javascript">

function resultOnload() {
	//MM_preloadImages('images/index_button2.png','images/aboutCK_button2.png','images/download_button2.png','images/Q&A_button2.png');
	$('#dlg_score').dialog('close');
}

</script>
</head>

<body onload="resultOnload()" background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <?php include("leftzone.php")?>
  </div>
  <?php
  $queryScore_mk = false;
  if ($row_examyear['scoreTimeCK'] <= date("Y-m-d H:i:s")){
  	$queryScore_mk = true;
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
	<table width="540" border="0" cellspacing="0" cellpadding="0">

	</table>
    <img src="images/Results.png" width="540" height="48" /><br />
    <table width="540" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
    <tr>
          <td width="20" height="25" align="right" class="underline1"></td>
          <td width="80" align="center" class="underline1">考試時間</td>
          <td width="80" align="center" class="underline1">准考證號碼</td>
          <td width="50" align="center" class="underline1">國語</td>
          <td width="50" align="center" class="underline1">數學</td>
          <td width="50" align="center" class="underline1">社會</td>
          <td width="50" align="center" class="underline1">自然</td>
          <td width="90" align="center" class="underline1">列印成績單</td>
          <td width="90" align="center" class="underline1">申請證明書</td>
        </tr>

      <?php do { ?>
        <tr>
          <td width="20" height="25" align="right" class="underline1">‧</td>
          <td width="100" class="underline1" align="center">
          <?php echo $row_web_news['score_time']; ?> </td>
          <td width="100" class="underline1" align="center">
          <?php echo $row_web_news['score_id']; ?> </td>

          <td width="50" align="center" class="underline1">
          <?php if($row_web_news['score_cpoint'] == 0){
          if($row_web_news['score_cpoint'] == null) echo " "; else echo '不計分';
        }
          else{
          	echo $row_web_news['score_cpoint']."<br>($row_web_news[c_level])";
          	if($row_web_news['c_level'] == '精熟') $showPrint_mk=true;
          } ?> </td>

          <td width="50" align="center" class="underline1">
          <?php
          if($row_web_news['score_mpoint'] == 0){
          	if($row_web_news['score_mpoint'] == null) echo " "; else echo '不計分';
          }else{
          	echo $row_web_news['score_mpoint']."<br>($row_web_news[m_level])";
          	if($row_web_news['m_level'] == '精熟') $showPrint_mk=true;
          } ?> </td>

          <td width="50" align="center" class="underline1">
          <?php if($row_web_news['score_spoint'] == 0){
          if($row_web_news['score_spoint'] == null) echo " "; else echo '不計分';}
          else{
          	echo $row_web_news['score_spoint']."<br>($row_web_news[s_level])";
          	if($row_web_news['s_level'] == '精熟') $showPrint_mk=true;
          } ?> </td>

          <td width="50" align="center" class="underline1">
          <?php if($row_web_news['score_ppoint'] == 0){
            if($row_web_news['score_ppoint'] == null) echo " "; else echo '不計分';
          }
          else{
          	echo $row_web_news['score_ppoint']."<br>($row_web_news[p_level])";
          	if($row_web_news['p_level'] == '精熟') $showPrint_mk=true;
          } ?> </td>
          <td align="center" class="underline1">
          <?php if($row_web_news['score_id'] !=""){ ?>
          	<img class="img-40" src="images/icon_print.png" onclick="$('#dlg_score').dialog('open')" />
          	  <div id="dlg_score" class="easyui-dialog" title="選擇成績單列印科目" style="width:400px;height:200px;padding:10px"
						data-options="
							buttons: [{
								text:'Print',
								iconCls:'icon-ok',
								method:'get',
								handler:function(){
									$('#login-form').submit();
								}
							},{
								text:'Cancel',
								handler:function(){
									$('#dlg_score').dialog('close');
								}
							}]
						">
				<form id="login-form" method="get" action="resultsPDF.php">
					請先選擇評量科目：<select name="type">
					　<?php if($row_web_news['score_cpoint'] != null){echo '<option value="c">國語</option>';}?>
					　<?php if ($row_web_news['score_mpoint'] != null){echo '<option value="m">數學</option>';}?>
					　<?php if($row_web_news['score_spoint'] != null){echo '<option value="s">社會</option>';}?>
					　<?php if($row_web_news['score_ppoint'] != null){echo '<option value="p">自然</option>';}?>
					</select>
					<input type="hidden" name="id" value="<?php echo $row_web_news['score_id']; ?>">
					<input type="hidden" name="status" value="<?php echo $_GET['status']; ?>">
					<input type="hidden" name="examyear_id" value="<?php echo $row_web_news['examyear_id']; ?>">
				</form>
          	  </div>


          <?php }?>
          </td>
          <td align="center" class="underline1">
          <?php if($showPrint_mk) {
          	if($row_web_news["status"] == '1') $onclick_fun = 'ShowLink3()';
          	else $onclick_fun = 'ShowLink2()';
          	?>
          	<img class="img-40" src="images/icon_mail.png" onclick="<?php echo $onclick_fun;?>" />
          <?php }?></td>
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

     <?php if ($totalRows_web_news == 0) { // Show if recordset empty ?>
    <table width="540" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2" bgcolor="#FFFFFF">目前資料庫中沒有任何資料!</td>
      </tr>
    </table>
    <?php } // Show if recordset empty ?>

  </div>
	<?PHP }else{?><table width="540" border="0" cellspacing="0" cellpadding="0" align="center">
      	<p align="center" class="font_red2">目前尚未開放成績查詢</p>
      	<p align="center"><a href="index.php">[返回首頁]</a></p>
	<?PHP }?>


  <div id="main4"></div>
<div style="border:5px #FFCC66 solid;border-radius:10px;width:50%;background-color:#FFFFCC;padding:10px;margin:10px;">
    <table width="100%" style="border:2px #ffdd70 solid;padding:5px;" cellpadding='5';>
    	<tr align="center" bgcolor="#ffe89d"><td>科目</td><td>待加強</td><td>基礎</td><td>精熟</td></tr>
    	<tr align="center" bgcolor="#FFFFFF"><td>國語</td><td>0-412</td><td>413-553</td><td>554以上</td></tr>
    	<tr align="center"><td>數學</td><td>0-420</td><td>421-579</td><td>580以上</td></tr>
    	<tr align="center" bgcolor="#FFFFFF"><td>社會</td><td>0-446</td><td>447-589</td><td>590以上</td></tr>
    	<tr align="center"><td>自然</td><td>0-415</td><td>416-573</td><td>574以上</td></tr>
    </table>
    </div>
<?php include("footer.php"); ?>
</div>
</body>
</html>
<?php
mysql_free_result($web_news);

mysql_free_result($web_banner1);

mysql_free_result($web_banner2);

?>
