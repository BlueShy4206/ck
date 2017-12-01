<?php require_once('Connections/conn_web.php'); ?>
<?php 
$colname_web_member = "-1";
if (isset($_GET['email'])) {
	$colname_web_member = $_GET['email'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_member = sprintf("SELECT * FROM member WHERE email = '%s'",  $colname_web_member);
$web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_member);
$totalRows_web_member = mysql_num_rows($web_member);
?>
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

</head>

<body onload="MM_preloadImages('images/btn_shop1_2.gif','images/btn_shop2_2.gif','images/btn_shop3_2.gif','images/btn_shop4_2.gif','images/btn_shop5_2.gif','images/btn_shop6_2.gif')"  background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <? include("leftzone.php")?>
  </div>
  <div id="main3">
	<br />
    <br />
    <br />
<?php if ($totalRows_web_member > 0) { // Show if recordset not empty ?>
      <table width="364" border="0" align="center" cellpadding="0" cellspacing="0" background="images/memberSendPass2.gif">
        <tr>
          <td width="22" height="55">&nbsp;</td>
          <td width="306">&nbsp;</td>
        </tr>
        <tr>
          <td height="129">&nbsp;</td>
          <td align="left" valign="top" class="font_black">您的新密碼已寄出至您的郵箱，<br />
            	請使用新密碼登入網站，謝謝。<br/>  	
			<br/>
        <input name="Submit" type="button" onclick="MM_goToURL('parent','index.php');return document.MM_returnValue" value="回首頁" /></td>
        </tr>
      </table>
      <?php }?>
    <br />
    <?php if ($totalRows_web_member == 0) { // Show if recordset empty ?>
  <table width="364" border="0" align="center" cellpadding="0" cellspacing="0" background="images/memberSendPass3.gif">
    <tr>
      <td width="22" height="55">&nbsp;</td>
      <td width="306">&nbsp;</td>
      </tr>
    <tr>
      <td height="129">&nbsp;</td>
      <td align="left" valign="top" class="font_black">對不起!!資料庫中沒有您的會員E-mail，<br />
       		 請回上一頁重新輸入，或是加入會員。<br />
        <br />
        <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
        <input name="Submit" type="button" onclick="MM_goToURL('parent','memberAdd.php');return document.MM_returnValue" value="加入會員" />
        <input name="Submit" type="button" onclick="MM_goToURL('parent','index.php');return document.MM_returnValue" value="回首頁" />
        
        </td>
      </tr>
  </table>
  <?php } // Show if recordset empty ?>
<p>&nbsp;</p>
  </div>
  <div id="main4"></div>
	<?php include("footer.php"); ?>  
</div>
</div>
</body>
</html>
<?php
mysql_free_result($web_member);
?>
            	