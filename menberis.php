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
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(function(){
	
	// 先取得 #main3 及其各種高度
	// 判斷是否停用 $submit
	var $terms = $('#main3'),
		_height = $terms.height(), 
		_scrollHeight =  $terms.prop('scrollHeight'), 
		_maxScrollHeight = _scrollHeight - _height - 20;
		_least = 0, // 距離底部多少就可以, 0 表示得完全到底部
		$submit = $('#btnOK').attr('disabled', _maxScrollHeight > _least);
		$submit2 = $('#btnDeny').attr('disabled',_maxScrollHeight > _least)
 
	// 當 #main3 中捲軸捲動時
	$('#main3').scroll(function(){
		var $this = $(this);
		// 如果高度已經達到指定的高度就啟用 $submit
		if(_maxScrollHeight - $this.scrollTop() <= _least){
			$submit.attr('disabled', false);
			$submit2.attr('disabled', false);
		}
	});


});

</script>
</head>

<body onload="MM_preloadImages('images/index_button2.png','images/aboutCK_button2.png','images/download_button2.png','images/Q&A_button2.png')" background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  
  <div id="main2">
      <?php include("leftzone.php")?>
  </div>
  <div id="main1">
      <table width="545" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20">
          <marquee onMouseOver="this.stop()" onMouseOut="this.start()" bgcolor="#efefef" border="0" align="middle" scrollamount="2"  scrolldelay="90" behavior="scroll"  width="100%" height="20" style="color: #000000; font-size: 12">
            <a href="<?php echo $row_web_banner1['banner_url']; ?>"><img src="images/hot.gif" width="28" height="7" border="0" /><?php echo $row_web_banner1['banner_title']; ?></a>
          </marquee>
        </td>
      </tr>
    </table>
    <br/>
  </div>
  <div id="main3" >
	  <table width="540" border="0" cellspacing="0" cellpadding="0">
	    <tr>
	     <!-- <td height="80" align="center" class="font_red2" bgcolor="#FFFFFF">目前中沒有任何資料可以提供</td> -->
	     <iframe name="terms" id="terms" src="menberisto.php" width="520" height="1400" frameborder="0" scrolling="no"></iframe>
	    </tr>
	      
	  </table>
  </div>
  <div id="main4">
	  <table width="540" border="0" cellspacing="0" cellpadding="0">
		  <tr>
	          <td height="40" colspan="3" align="center"><label>
	            <input type="button" name="btnOK" id="btnOK" value="我同意" onclick="location.href='memberAdd.php'" />  
	           </label>
	          <label>
	            <input type="button" name="btnDeny" id="btnDeny" value="我不同意" onclick="location.href='index.php'" />
	            
	          </label></td>
	       </tr>
	  </table>

  </div>

<?php include("footer.php"); ?>
</div>
</body>
</html>
<?php

mysql_free_result($web_banner1);

mysql_free_result($web_banner2);

?>
