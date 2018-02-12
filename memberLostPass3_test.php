<?php
phpinfo();
//include("PHPMailer_52/class.phpmailer.php");  // 匯入PHPMailer library
include('PHPMailer_52/PHPMailerAutoload.php');


$mail= new PHPMailer();          //建立新物件

$mail->IsSMTP();                 //設定使用SMTP方式寄信
$mail->SMTPDebug  = 2;
$mail->SMTPAuth = true;          //設定SMTP需要驗證
$mail->SMTPSecure = "ssl";       // Gmail的SMTP主機需要使用SSL連線
$mail->Host = 'smtp.gmail.com';  //Gamil的SMTP主機
$mail->Port = 465;               //Gamil的SMTP主機的SMTP埠位為465埠。
$mail->CharSet = "utf-8";         //設定郵件編碼，預設UTF-8

$mail->Username = "ckassessment@gmail.com";  //Gmail帳號
$mail->Password = "tryckckck";  //Gmail密碼 

$mail->From = 'lty.billy@gmail.com'; //設定寄件者信箱
$mail->FromName = 'First Last';           //設定寄件者姓名
$mail->addAddress('lty.billy@gmail.com');

//$mail->SetFrom('lty.billy@gmail.com');

$mail->Subject = "PHPMailer Test Subject via mail(), advanced";    //設定郵件標題
$mail->Body = "Mail content";  //設定郵件內容
//$mail->IsHTML(true);                     //設定郵件內容為HTML
//$mail->AddAttachment("filename"); // 設定附件檔檔名
$mail->AddAddress("lty.billy@gmail.com"); //設定收件者郵件及名稱

if(!$mail->Send()) {
    echo "寄信失敗: " . $mail->ErrorInfo;
}
else {
    echo "寄信成功!";
}
?>
