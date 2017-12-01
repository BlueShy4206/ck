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

$colname_web_member = "-1";
if (isset($_POST['email'])) {
  $colname_web_member = $_POST['email'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_member = sprintf("SELECT * FROM member WHERE email = %s", GetSQLValueString($colname_web_member, "text"));
$web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_member);
$totalRows_web_member = mysql_num_rows($web_member);

require_once('PHPMailer_old/class.phpmailer.php');
$mail = new PHPMailer();
$webmaster_email = "ckassessment@gmail.com";
$webmaster_name = "TCPTC系統管理員";

$mail->IsSMTP();
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = $mailUsername;
$mail->Password = $mailPassword;
$mail->FromName = $webmaster_name;

?>
<? session_start();?>
<?
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
          <td align="left" valign="top" class="font_black">您的新密碼: <?php $password=getRandNewPassword(); echo $password; ?><br />
            	請使用新密碼登入網站，謝謝。<br />

<?PHP
		$mail->CharSet = "utf8";
		$email=$_POST['email'];// 收件者信箱
		$name=$row_web_member['username'];// 收件者的名稱or暱稱
		$mail->From = $webmaster_email;
		
		$mail->AddAddress($email,$name);
		$mail->AddReplyTo($webmaster_email,"Squall.f");
		
		$mail->WordWrap = 50;
		//每50行斷一次行
		
		//$mail->AddAttachment("/XXX.rar");
		// 附加檔案可以用這種語法(記得把上一行的//去掉)
		
		$mail->IsHTML(true); // send as HTML
		
		$subject="國民小學教師學科知能評量--忘記密碼通知";// 信件標題
		$mail->Subject = $subject; 
		
		//變數$password取得新的隨機密碼
		//$password=getRandNewPassword();
		$body="親愛的會員您好，以下是您的新會員密碼，請妥善保存您的資料，謝謝:<br />
			您的帳號是 $name , 新密碼是".$password."<br />
		         如有任何問題歡迎與我們聯絡，謝謝!!<br />
				 any problem，you can touch us，thank you!!";
		$mail->Body = $body;
		//信件內容(html版，就是可以有html標籤的如粗體、斜體之類)
		$mail->AltBody = $body; 
		$sysTime = date("Y-m-d h:i:s");//new DateTime('NOW');
		$insertSQL = sprintf("INSERT INTO tosendmail (FromEmail, FromName, RecEmail, RecUsername, subject, body, status, addTime) 
				VALUES (%s, %s, %s, %s, %s, %s, '0', %s)",
				GetSQLValueString($webmaster_email, "text"),
				GetSQLValueString($webmaster_name, "text"),
				GetSQLValueString($email, "text"),
				GetSQLValueString($name, "text"),
				GetSQLValueString($subject, "text"),
				GetSQLValueString($body, "text"),
				GetSQLValueString($sysTime, "text"));
		mysql_select_db($database_conn_web, $conn_web);
		$Result2 = mysql_query($insertSQL, $conn_web) or die(mysql_error());
				
		//更新資料庫的會員密碼資料
		$updateSQL = sprintf("UPDATE member SET password=%s WHERE email=%s",
		                       GetSQLValueString(md5($password), "text"),
		                       GetSQLValueString($_POST['email'], "text"));
		mysql_select_db($database_conn_web, $conn_web);
		$Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());
	}
//信件內容(純文字版)
/*
if(!$mail->Send()){
echo "寄信發生錯誤：" . $mail->ErrorInfo;
//如果有錯誤會印出原因
}
else{ 
echo "寄信成功";
}*/


?>

<br />
        <input name="Submit" type="button" onclick="MM_goToURL('parent','index.php');return document.MM_returnValue" value="回首頁" /></td>
        </tr>
      </table>
    <br />
    <?php if ($totalRows_web_member == 0 && isset($_POST['button'])) { // Show if recordset empty ?>
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
	<?php include("footer.php"); ?>  
</div>
</div>
</body>
</html>
<?php
mysql_free_result($web_member);
?>
