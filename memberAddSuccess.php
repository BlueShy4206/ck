<? session_start();?>
<?php require_once('Connections/conn_web.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>會員加入成功</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="會員加入成功" />
<meta name="keywords" content="會員加入成功" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />
</head>

<body>
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
    <table width="328" border="0" align="center" cellpadding="0" cellspacing="0" background="images/memberAddSuccess.gif">
      <tr>
        <td width="22" height="55">&nbsp;</td>
        <td width="306">&nbsp;</td>
      </tr>
      <tr>
        <td height="93">&nbsp;</td>
        <td align="left" valign="top"><p class="font_black">感謝您的加入會員！<br />
        請於右方會員專區，使用您的帳號、<br />
        密碼進行登入。</p></td>
      </tr>
    </table>
  </div>
  <div id="main4"></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>