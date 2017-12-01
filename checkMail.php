
<?php require_once('Connections/conn_web.php'); ?>

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
    <table width="540" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20">

        </td>
      </tr>
    </table>
<table width="540" border="0" cellspacing="0" cellpadding="0">
 
</table>
  <table width="540" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2" bgcolor="#FFFFFF">
      <?php
		$uid=$_GET['uid'];
		$chkno=$_GET['chkno'];
		
		//查詢用戶的基本資料
		mysql_select_db($database_conn_web, $conn_web);
		$query_member_status = sprintf("SELECT * FROM member WHERE id='%s' AND check_no='%s' AND status='0'", $uid, $chkno);
		$web_member_status = mysql_query($query_member_status, $conn_web) or die(mysql_error());
		$row_web_member = mysql_fetch_assoc($web_member_status);
		$totalRows_member_s = mysql_num_rows($web_member_status);
		if($totalRows_member_s >=1){
			//更新驗証註記
			$updateSQL = sprintf("UPDATE member SET status='%s'  WHERE id=%s ", '1', $uid);
			mysql_select_db($database_conn_web, $conn_web);
			$Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());
			
			if($Result1){
				echo 'E-Mail 驗証成功';
			}else echo 'E-Mail 驗証失敗';
			 
		}else{ 
			$query_status = sprintf("SELECT * FROM member WHERE id='%s' AND status='1'", $uid);
			$web_status = mysql_query($query_status, $conn_web) or die(mysql_error());
			$row_member_s = mysql_fetch_assoc($web_status);
			$totalRows_s = mysql_num_rows($web_status);
			if($totalRows_s >=1) echo '已重覆驗証，請確認。';
			else echo '手動驗証碼不符合，請確認。';
		}
      ?>
      </td>
      </tr>
  </table>
 
  
  </div>
  <div id="main4"></div>
<?php include("footer.php"); ?>
</div>
</div>
</body>
</html>
<?php

mysql_free_result($web_member_status);

?>
