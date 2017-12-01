<? if (!isset($_SESSION)) {
session_start();
}?>
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

$maxRows_web_news = 16;
$pageNum_web_news = 0;
if (isset($_GET['pageNum_web_news'])) {
  $pageNum_web_news = $_GET['pageNum_web_news'];
}
$startRow_web_news = $pageNum_web_news * $maxRows_web_news;
mysql_select_db($database_conn_web, $conn_web);
$query_web_news = "SELECT file_id, file_title, file_name, file_date, position FROM file ORDER BY position ASC,file_id DESC";
$query_limit_web_news = sprintf("%s LIMIT %d, %d", $query_web_news, $startRow_web_news, $maxRows_web_news);
$web_news = mysql_query($query_limit_web_news, $conn_web) or die(mysql_error());
$row_web_news = mysql_fetch_assoc($web_news);
//add by coway 2016.8.31
 //echo "user_id=".$_SESSION['MM_UserId'];
 if(!empty($_SESSION['MM_UserId'])){ 
mysql_select_db($database_conn_web, $conn_web);
// $query_web_schoolFile = sprintf("SELECT a1.username,a.* FROM file a,member a1 WHERE (INSTR(a.sMember_str,',') OR (length(a.sMember_str)>0)) AND INSTR(a.sMember_str,%s)>0 AND a1.id =%s AND a1.username=%s ORDER BY position " ,$_SESSION['MM_UserId'],$_SESSION['MM_UserId'],GetSQLValueString($_SESSION['MM_Username'], "text"));
// // $query_limit_web_news = sprintf("%s LIMIT %d, %d", $query_web_news, $startRow_web_news, $maxRows_web_news);
// $web_schoolFile = mysql_query($query_web_schoolFile, $conn_web) or die(mysql_error());
// $row_web_schoolFile = mysql_fetch_assoc($web_schoolFile);

//取得幾個梯次, add by coway 2017.8.28
$query_web_schoolSemes = sprintf("select distinct substring(aa.file_title,1,LOCATE('_', aa.file_title)-7) semes from (SELECT a1.username,a.* FROM file a,member a1 WHERE (INSTR(a.sMember_str,',') OR (length(a.sMember_str)>0)) AND INSTR(a.sMember_str,%s)>0 AND a1.id =%s AND a1.username=%s ORDER BY position ) aa order by substring(aa.file_title,1,LOCATE('_', aa.file_title)-7) desc " ,$_SESSION['MM_UserId'],$_SESSION['MM_UserId'],GetSQLValueString($_SESSION['MM_Username'], "text"));
// $query_limit_web_news = sprintf("%s LIMIT %d, %d", $query_web_news, $startRow_web_news, $maxRows_web_news);
$web_schoolSemes = mysql_query($query_web_schoolSemes, $conn_web) or die(mysql_error());
$row_web_schoolSemes = mysql_fetch_assoc($web_schoolSemes);
//--2---
$query_web_schoolSemes2 = sprintf("select distinct substring(aa.file_title,1,LOCATE('_', aa.file_title)-7) semes from (SELECT a1.username,a.* FROM file a,member a1 WHERE (INSTR(a.sMember_str,',') OR (length(a.sMember_str)>0)) AND INSTR(a.sMember_str,%s)>0 AND a1.id =%s AND a1.username=%s ORDER BY position ) aa order by substring(aa.file_title,1,LOCATE('_', aa.file_title)-7) desc " ,$_SESSION['MM_UserId'],$_SESSION['MM_UserId'],GetSQLValueString($_SESSION['MM_Username'], "text"));
// $query_limit_web_news = sprintf("%s LIMIT %d, %d", $query_web_news, $startRow_web_news, $maxRows_web_news);
$web_schoolSemes2 = mysql_query($query_web_schoolSemes2, $conn_web) or die(mysql_error());
$row_web_schoolSemes2 = mysql_fetch_assoc($web_schoolSemes2);
 	
 }
//  echo "cnt=".strlen(mysql_result($web_schoolSemes2, 0))."<br>";
//  echo "semes=".$web_schoolSemes2["semes"]."<br>";
//  echo "sqstr=".$query_web_schoolSemes2."<br>";
//  print_r($row_web_schoolSemes);

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
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
	 crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
	 crossorigin="anonymous">

<body  onload="MM_preloadImages('images/index_button2.png','images/aboutCK_button2.png','images/download_button2.png','images/Q&A_button2.png')" background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <?php include("leftzone.php")?>
  </div>
  <div id="main3" >
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
    <img src="images/schoolQry_CK.png" width="540" height="48" /><br />
    
  
  <? $ii=0;
  	
	do{ ?>
	<div id="nav" style="background-color:#FFFFFF;" class="col-md-4 col-sm-4 col-xs-4" > 
	<? if(strlen(mysql_result($web_schoolSemes2, 0)) > 0){?>
    <p> <a href="#content<? echo $ii+1?>"  onClick="changeLinkColor(this)" class="btn btn-success" style="padding:6px 9px;background-image: linear-gradient(to bottom,#98F55E ,#097C0F 80%);"><? echo $row_web_schoolSemes["semes"];?></a></p>
<? }else{ ?>
<a href="#content<? echo $ii+1?>" onClick="changeLinkColor(this)"><? echo $row_web_schoolSemes["semes"];?></a>
<? }?>
<!--     <a href="#content2">Show content 2</a> -->
<!--     <a href="#content3">Show content 3</a> -->
    <? 
//     if(!empty($_SESSION['MM_UserId'])){
//     	mysql_select_db($database_conn_web, $conn_web);
//     	$query_web_schoolFile = sprintf("SELECT a1.username,a.* FROM file a,member a1 WHERE (INSTR(a.sMember_str,',') OR (length(a.sMember_str)>0)) AND INSTR(a.sMember_str,%s)>0 AND a1.id =%s AND a1.username=%s and a.file_title like %s ORDER BY position " ,$_SESSION['MM_UserId'],$_SESSION['MM_UserId'],GetSQLValueString($_SESSION['MM_Username'], "text"),GetSQLValueString($row_web_schoolSemes["semes"]."%", "text"));
//     	// $query_limit_web_news = sprintf("%s LIMIT %d, %d", $query_web_news, $startRow_web_news, $maxRows_web_news);
//     	$web_schoolFile = mysql_query($query_web_schoolFile, $conn_web) or die(mysql_error());
//     	$row_web_schoolFile = mysql_fetch_assoc($web_schoolFile);
//     	}
//     	echo "sqstr=".$query_web_schoolFile;
     	?>
</div>
<?php 

 $ii++;
  		}while($row_web_schoolSemes = mysql_fetch_assoc($web_schoolSemes));
  		?>

<?
$j=0;  
do{
    if(!empty($_SESSION['MM_UserId'])){
    	mysql_select_db($database_conn_web, $conn_web);
    	$query_web_schoolFile = sprintf("SELECT a1.username,a.* FROM file a,member a1 WHERE (INSTR(a.sMember_str,',') OR (length(a.sMember_str)>0)) AND INSTR(a.sMember_str,%s)>0 AND a1.id =%s AND a1.username=%s and a.file_title like %s ORDER BY position " ,$_SESSION['MM_UserId'],$_SESSION['MM_UserId'],GetSQLValueString($_SESSION['MM_Username'], "text"),GetSQLValueString($row_web_schoolSemes2["semes"]."%", "text"));
    	// $query_limit_web_news = sprintf("%s LIMIT %d, %d", $query_web_news, $startRow_web_news, $maxRows_web_news);
    	$web_schoolFile = mysql_query($query_web_schoolFile, $conn_web) or die(mysql_error());
    	$row_web_schoolFile = mysql_fetch_assoc($web_schoolFile);
    	}
  	if($j+1 >1){ $displayCss="style='display:none'"; }else{ $displayCss="";}	
    	?>
  <div id="content<? echo $j+1?>" class="toggle" <?echo $displayCss?>>
   
  <table width="540" border="0" cellspacing="0" cellpadding="0">  
  <?php 
		if(!empty($_SESSION['MM_UserId']))
		{
		//判斷member/id 是否包含在file/sMember_str ,add by coway 2016.9.2
  		$sbool=false;
  		$memStr = explode(",", $row_web_schoolFile['sMember_str']);
  		$i=0;
  		while (count($memStr)>$i){
  			if($memStr[$i] == $_SESSION['MM_UserId'])
  			{
  				$sbool = true;
  			}
  			$i++;
  		}  		
  	if($sbool==true)
  	{
?>
  		<tr><td class="font_title3" bgcolor="#FFFFFF"><font size="4px"><br>．國民小學師資類科培育學校</font><br></td></tr>
  	<?php do { ?>
  
  	<tr>
      <td height="50" align="left" class="font_red2" bgcolor="#FFFFFF">
      <a href="file/<?php echo $row_web_schoolFile['file_name']; ?>"><font color="purple"><?php echo $row_web_schoolFile['file_title']; ?></font></a></td>
    </tr>    
        <?php } while ($row_web_schoolFile = mysql_fetch_assoc($web_schoolFile)); 
  	}else{ ?> <td height="50" align="center" class="font_red2" bgcolor="#FFFFFF">貴單位 目前沒有資料!</td><?php }
  	
  	}else{?><td height="50" align="center" class="font_red2" bgcolor="#FFFFFF">僅限國民小學師資類科培育學校師培單位，<br>以及自然領域加註專長認証單位方可查詢。</td><?php }?>
	</table></div>
  <?
  		$j++;
  		}while($row_web_schoolSemes2 = mysql_fetch_assoc($web_schoolSemes2));  	?>

<!--  show the stuff1 -->
<script language="javascript" type="text/javascript">
$("#nav a").click(function(e){
    e.preventDefault();
    $(".toggle").hide();
    var toShow = $(this).attr('href');
    $(toShow).show();
//     $(this).css('color', 'blue');
});

</script>
<script type="text/javascript">
   var currentLink = null;
   function changeLinkColor(link){
	   if(currentLink!=null){
	   currentLink.style.color = link.style.color; //You may put any color you want
	   }
	   link.style.color ="yellow";
	   currentLink = link;
    }

   function MM_preloadImages() { //v3.0
	   var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
	     var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
	     if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
	 }
</script> 
  
  </div>
  <div id="main4"></div>
  <?php include("footer.php"); ?>
</div>
</div>
</body>
<style>
  		a:link, a:active, a:visited{
  		    color: #efefef;
  		}
</style>
</html>


<?php
mysql_free_result($web_news);

mysql_free_result($web_banner1);

mysql_free_result($web_banner2);

?>
