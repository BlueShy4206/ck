<? session_start();?>
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
    <table width="328" border="0" align="center" cellpadding="0" cellspacing="0" background="images/memberLogout.gif">
      <tr>
        <td width="22" height="55">&nbsp;</td>
        <td width="306">&nbsp;</td>
      </tr>
      <tr>
        <td height="93">&nbsp;</td>
        <td align="left" valign="top"><p class="font_black">您已經登出網站，可以放心離開 !!<br />
          <script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script><input name="Submit" type="button" onclick="MM_goToURL('parent','index.php');return document.MM_returnValue" value="回首頁" />
        </p></td>
      </tr>
    </table>
  </div>
  <div id="main4"></div>

<?php include("footer.php"); ?>
</body>
</html>
