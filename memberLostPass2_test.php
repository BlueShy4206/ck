<?php

//phpinfo();
require_once('PHPMailer_old/class.phpmailer.php');
require_once('PHPMailer_old/class.smtp.php');

$mail = new PHPMailer(); 
$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
$mail -> From = "ckassessment@gmail.com";
$mail->FromName = "ck系統管理員";
$mail->Host       = "smtp.gmail.com";
$mail->SMTPSecure = "ssl";
$mail->Port       = 465; 
$mail->SMTPAuth = true;
$mail->Username   = "ckassessment@gmail.com";  // GMAIL username
$mail->Password   = "ntcub507";  // GMAIpassword
$to = "lioujay@hotmail.com";
$mail->AddAddress($to);
$mail->AddReplyTo("lioujay@hotmail.com");
$mail->WordWrap   = 80;
$mail->IsHTML(true);
$mail->Subject  = "First PHPMailer Message";
$mail->Body = 'test';
echo 'teresa.';
if($mail->Send()) {echo "Send mail successfully";}
else {echo "Send mail fail<br>" . $mail->ErrorInfo;} 
?>
