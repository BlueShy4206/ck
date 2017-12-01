<?php require_once('Connections/conn_web.php'); ?>

<?php mb_internal_encoding('UTF-8'); ?>
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

$colname_web_member = "-1";
if (isset($_POST['email'])) {
  $colname_web_member = $_POST['email'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_member = sprintf("SELECT * FROM member WHERE email = %s", GetSQLValueString($colname_web_member, "text"));
$web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_member);
$totalRows_web_member = mysql_num_rows($web_member);

require_once('PHPMailer/class.phpmailer.php');
//require_once('PHPMailer_old/class.smtp.php');

//require_once('PHPMailer/PHPMailerAutoload.php');
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = $mailUsername;
$mail->Password = $mailPassword;
$mail->FromName = "ck系統管理員";
$webmaster_email = "ckassessment@gmail.com"; 
$mail->SMTPDebug = 4;

?>
<?php session_start();?>
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
        <script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body onload="MM_preloadImages('images/btn_shop1_2.gif','images/btn_shop2_2.gif','images/btn_shop3_2.gif','images/btn_shop4_2.gif','images/btn_shop5_2.gif','images/btn_shop6_2.gif')"  background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <?php include("leftzone.php")?>
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
          <td align="left" valign="top" class="font_black">您的新密碼已經寄出到您的信箱，請收信<br />
            後使用新帳號、密碼登入網站，謝謝。<br />
<?php
  //自訂取得隨機密碼函數
  function getRandNewPassword()
  {
    $password_len = 6;//指定隨機密碼字串字數
    $password = '';
	//指定隨機密碼字串內容
    $word = 'abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
    $len = strlen($word);
    for ($i = 0; $i < $password_len; $i++) {
        $password .= $word[rand() % $len];
    }
    return $password;
  }
  //變數$password取得新的隨機密碼
  $password=getRandNewPassword();
?>
<?PHP
$mail->CharSet = "utf8";
$email=$_POST['email'];
// 收件者信箱
$name=$row_web_member['username'];
// 收件者的名稱or暱稱
$mail->From = $webmaster_email;


$mail->AddAddress($email,$name);
$mail->AddReplyTo($webmaster_email,"Squall.f");


$mail->WordWrap = 50;
//每50行斷一次行

//$mail->AddAttachment("/XXX.rar");
// 附加檔案可以用這種語法(記得把上一行的//去掉)

$mail->IsHTML(true); // send as HTML

$subject="國民小學教師學科知能評量通知";
$mail->Subject = $subject; 
// 信件標題

$body="親愛的會員您好，以下是您的新會員密碼，請妥善保存您的資料，謝謝:<br />
         您的新密碼是".$password."<br />
         如有任何問題歡迎與我們聯絡，謝謝!!<br />
		 any problem，you can touch us，thank you!!";
$mail->Body = $body;
//信件內容(html版，就是可以有html標籤的如粗體、斜體之類)
$mail->AltBody = $body; 
//信件內容(純文字版)

if(!$mail->Send()){
echo "寄信發生錯誤：" . $mail->ErrorInfo;
//如果有錯誤會印出原因
}
else{ 
echo "寄信成功";
}


?>

<?php
/*
  //將新密碼發信給使用者
  mb_internal_encoding('UTF-8');//指定發信使用UTF-8編碼，防止信件標題亂碼
  $servicemail="shisutemukanrishaofck@gmail.com";//指定網站管理員服務信箱，請修改為自己的有效mail
  $webname="國民小學教師學科知能評量";//寫入網站名稱
  $email=$_POST['email'];//上一頁中會員輸入的信箱
  $subject=$webname."補發會員密碼";//信件標題
  $subject=mb_encode_mimeheader($subject, 'UTF-8');//指定標題將雙位元文字編碼為單位元字串，避免亂碼
  //指定信件內容
  $body="親愛的會員您好，以下是您的新會員密碼，請妥善保存您的資料，謝謝:<br />
         您的新密碼是".$password."<br />
         如有任何問題歡迎與我們聯絡，謝謝!!any problem，you can touch us，thank you!!";
  //郵件檔頭設定
  $headers = "MIME-Version: 1.0\r\n";//指定MIME(多用途網際網路郵件延伸標準)版本
  $headers .= "Content-type: text/html; charset=utf-8\r\n";//指定郵件類型為HTML格式
  $headers .= "From:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail."> \r\n";//指定寄件者資訊
  $headers .= "Reply-To:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail.">\r\n";//指定信件回覆位置
  $headers .= "Return-Path:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail.">\r\n";//被退信時送回位置
  //使用mail函數寄發信件
  mail ($email,$subject,$body,$headers);
  //將新密碼發信給使用者結束 */
?>
<?php
  //更新資料庫的會員密碼資料
  $updateSQL = sprintf("UPDATE member SET password=%s WHERE email=%s",
                       GetSQLValueString(md5($password), "text"),
                       GetSQLValueString($_POST['email'], "text"));
  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());
?>
<br />
            <input name="Submit" type="button" onclick="MM_goToURL('parent','index.php');return document.MM_returnValue" value="回首頁" /></td>
        </tr>
      </table>
      <?php } // Show if recordset not empty ?>
    <br />
    <?php if ($totalRows_web_member == 0) { // Show if recordset empty ?>
  <table width="364" border="0" align="center" cellpadding="0" cellspacing="0" background="images/memberSendPass3.gif">
    <tr>
      <td width="22" height="55">&nbsp;</td>
      <td width="306">&nbsp;</td>
      </tr>
    <tr>
      <td height="129">&nbsp;</td>
      <td align="left" valign="top" class="font_black">對不起!!資料庫中沒有您的會員E-mail，請<br />
        回上一頁重新輸入，或是加入會員。<br />
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
</div>
<?php include("footer.php"); ?>
</div>
</body>
</html>
<?php
mysql_free_result($web_member);
?>
