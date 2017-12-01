<?php require_once('../Connections/conn_web.php'); ?>
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

$colname_web_paper = "-1";
if (isset($_POST['epaper_id'])) {
  $colname_web_paper = $_POST['epaper_id'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_paper = sprintf("SELECT * FROM epaper WHERE epaper_id = %s", GetSQLValueString($colname_web_paper, "int"));
$web_paper = mysql_query($query_web_paper, $conn_web) or die(mysql_error());
$row_web_paper = mysql_fetch_assoc($web_paper);
$totalRows_web_paper = mysql_num_rows($web_paper);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理後台</title>
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="國民小學教師學科知能評量" />
<meta name="keywords" content="國民小學教師學科知能評量" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="../web.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="admin_main2">
    <table width="555" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="25" align="left"><img src="../images/board09.gif" /></td>
        <td width="90" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">電子報發送</span></td>
        <td width="430" align="left" background="../images/board04.gif">&nbsp;</td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="0">
      <tr class="font_black">
        <td width="300" align="center" class="board_add3"><span class="font_black">指定寄發Email</span></td>
        <td width="255" height="30" align="center" class="board_add3"><span class="font_black">發送狀態</span></td>
      </tr>
      <tr>
        <td height="30" align="center" class="board_add3"><?php echo $_POST['email']; ?>
<?
//寄發電子報給指定mail
  mb_internal_encoding('UTF-8');//指定發信使用UTF-8編碼，防止信件標題亂碼
  $servicemail="test@test.com";//指定網站管理員服務信箱，請修改為自己的有效mail
  $webname="HAPPY購物網站";//寫入網站名稱
  $email=$_POST['email'];//上一頁傳來的email
  //由web_paper資料集取得電子報標題，作為信件標題，如果資料集名稱不同，請自行修改
  $subject=$row_web_paper['epaper_title'];
  $subject=mb_encode_mimeheader($subject, 'UTF-8');//指定標題將雙位元文字編碼為單位元字串，避免亂碼
  //由web_paper資料集取得電子報內容，作為信件內容，如果資料集名稱不同，請自行修改
  $body=$row_web_paper['epaper_content'];
  //郵件檔頭設定
  $headers = "MIME-Version: 1.0\r\n";//指定MIME(多用途網際網路郵件延伸標準)版本
  $headers .= "Content-type: text/html; charset=utf-8\r\n";//指定郵件類型為HTML格式
  $headers .= "From:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail."> \r\n";//指定寄件者資訊
  $headers .= "Reply-To:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail.">\r\n";//指定信件回覆位置
  $headers .= "Return-Path:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail.">\r\n";//被退信時送回位置
  //使用mail函數寄發信件
  mail ($email,$subject,$body,$headers);
//寄發電子報給指定mail結束
?>
        </td>
        <td height="30" align="center" class="board_add3">完成寄發電子報!!</td>
      </tr>
    </table><br /><br />
          <script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<input name="Submit" type="button" onclick="MM_goToURL('parent','admin_epaper.php');return document.MM_returnValue" value="回電子報管理區" />
  </div>
  <div id="admin_main3">
       <? include("right_zone.php");?>
  </div>
  <div id="main4"></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>
<?php
mysql_free_result($web_paper);
?>
