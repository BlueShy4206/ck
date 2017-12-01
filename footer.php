<?php require_once('Connections/conn_web.php'); ?>
<?
$thisYear=date("Y");//自訂變數$thisYear儲存年度資料，供資料集查詢用
$thisMonth=date("Y-m");//自訂變數$thisMouth儲存月份資料，供資料集查詢用
$today=date("Y-m-d");//自訂變數$today儲存今天日期，供資料集查詢用
?>
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

mysql_select_db($database_conn_web, $conn_web);
$query_web_viewTotal = "SELECT * FROM viewcount";
$web_viewTotal = mysql_query($query_web_viewTotal, $conn_web) or die(mysql_error());
$row_web_viewTotal = mysql_fetch_assoc($web_viewTotal);
$totalRows_web_viewTotal = mysql_num_rows($web_viewTotal);

mysql_select_db($database_conn_web, $conn_web);
$query_web_thisYear = "SELECT * FROM viewcount WHERE view_time LIKE '%$thisYear%'";
$web_thisYear = mysql_query($query_web_thisYear, $conn_web) or die(mysql_error());
$row_web_thisYear = mysql_fetch_assoc($web_thisYear);
$totalRows_web_thisYear = mysql_num_rows($web_thisYear);

mysql_select_db($database_conn_web, $conn_web);
$query_web_thisMonth = "SELECT * FROM viewcount WHERE view_time LIKE '%$thisMonth%'";
$web_thisMonth = mysql_query($query_web_thisMonth, $conn_web) or die(mysql_error());
$row_web_thisMonth = mysql_fetch_assoc($web_thisMonth);
$totalRows_web_thisMonth = mysql_num_rows($web_thisMonth);

mysql_select_db($database_conn_web, $conn_web);
$query_web_today = "SELECT * FROM viewcount WHERE view_time LIKE '%$today%'";
$web_today = mysql_query($query_web_today, $conn_web) or die(mysql_error());
$row_web_today = mysql_fetch_assoc($web_today);
$totalRows_web_today = mysql_num_rows($web_today);
?>
<?
if(!isset($_SESSION['view'])){ //先檢查Session變數view是否存在，如果不存在就新增變數並寫入瀏覽人次記錄
	$_SESSION['view'] = 1;  		   //新增Session變數view，值為1
	$view_time=date("Y-m-d H:i:s");    //變數$viewtime瀏覽時間
	$view_ip=$_SERVER['REMOTE_ADDR'];  //變數$viewip記錄瀏覽者的IP
	//指定新增資料至viewcount資料表的SQL指令
	$insertView="INSERT INTO viewcount (view_time,view_ip) VALUES ('$view_time', '$view_ip')";
	mysql_query($insertView);//執行SQL指令動作
}
?>
<link href="web.css" rel="stylesheet" type="text/css" />
<style type="text/css">

</style>

<br><br><br>
<div id="footer" style="background-image:url(images/footer.png);width:770px;height:170px;" >
  <p style="font-size:12px">&nbsp;<br />
  指導單位：<img src="images/356_003ab01d.png" alt="教育部" width="16" height="16" /> 教育部<br /> 
  執行單位：國立臺中教育大學  教師專業能力測驗中心   ( https://tl-assessment.ntcu.edu.tw) <br />
  地址：臺中市西區民生路140號 TEL：(04)2218-3651 &nbsp;&nbsp;&nbsp; E-Mail：ckassessment@gmail.com <a href="mailto:ckassessment@gmail.com"><img src="images/mailto.png" width="15" height="10" alt="mail" /></a><br />
    您是第<span class="font_red"><?php echo $totalRows_web_viewTotal ?></span> 位訪客，今年：<span class="font_red"><?php echo $totalRows_web_thisYear ?></span> 人，本月：<span class="font_red"><?php echo $totalRows_web_thisMonth ?></span> 人，本日：<span class="font_red"><?php echo $totalRows_web_today ?></span> 人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;目前線上人數：
  <?
$time=gettimeofday();
$tmp=file("time.txt");
if ($tmp[0]==""){
  $fopen0=fopen("time.txt","w+");
  fputs($fopen0,$time[sec]);
  fclose($fopen0);
  $fopen1=fopen("ip.txt","w+");
  fputs($fopen1,"");
  fclose($fopen1);
}
$tmp1=file("time.txt");
$equal=($time[sec]-$tmp1[0]);
if ($equal>60){
  $fopen0=fopen("time.txt","w+");
  fputs($fopen0,"");
  fclose($fopen0); 
}
$fopen=fopen("ip.txt","a+");
$ip=$_SERVER["REMOTE_ADDR"];
$flag=1;
$tmp2=file("ip.txt");
$con=count($tmp2);
for ($i=0;$i<$con;$i++)
{
  if ($ip."\n"==$tmp2[$i])
  {
    $flag=0;
    break;
  }
}
if ($flag==1)
{
  $ipstring=$ip."\n";
  fputs($fopen,$ipstring);
}
fclose($fopen);
$tmp3=file("ip.txt");
$value=count($tmp3);
echo "<span class='font_red'>".$value."</span>";
?>
    人
    
  <br />
  </p>
</div>

<?php
mysql_free_result($web_viewTotal);

mysql_free_result($web_thisYear);

mysql_free_result($web_thisMonth);

mysql_free_result($web_today);
?>
