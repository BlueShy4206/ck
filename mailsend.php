<?php echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n"; ?>

<?php
//phpinfo();
$host = "ssl:smtp.gmail.com";      // sets GMAIL as the SMTP server
$port = 465;
$tval = 30;
//$errno;
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', $certfile);
stream_context_set_option($ctx, 'ssl', 'passphrase', $pass);

    $socket = stream_socket_client('ssl://smtp.gmail.com:465', $errno, $errstr,60, STREAM_CLIENT_CONNECT, $ctx);
    echo "socket:".$socket."<br>";

    $smtp_conn = fsockopen($host,    // the host of the server
                                 $port,    // the port to use
                                 $errno,   // error number if any
                                 $errstr,  // error message if any
                                 $tval);   // give up after ? secs
    // verify we connected properly
    if(empty($socket)) {
      echo "errno:$errno, errstr:$errstr.<b>";
      $error = array("error" => "Failed to connect to server",
                           "errno" => $errno,
                           "errstr" => $errstr);
      echo "errno:$errno, errstr:$errstr.<b>";
      if($this->do_debug >= 1) {
        $this->edebug("SMTP -> ERROR: " . $this->error["error"] . ": $errstr ($errno)" . $this->CRLF . '<br />');
      }
      return false;
    }else echo '<br> connect server success.';

if(!empty($socket)) {
      $sock_status = socket_get_status($socket);
      echo "eof:$sock_status[eof]";
      if($sock_status["eof"]) {
        // the socket is valid but we are not connected
        if($this->do_debug >= 1) {
            $this->edebug("SMTP -> NOTICE:" . $this->CRLF . "EOF caught while checking if connected");
        }
        $this->Close();
        return false;
      }
      echo "check connected.";
      return true; // everything looks good
    }


ini_set('SMTP', $host); 
ini_set('smtp_port', $port);

  $to ="yuanhsuanch@gmail.com"; //收件者
  $subject = "test"; //信件標題
  $msg = "smtp發信測試";//信件內容
  $headers = "From: ckassessment@gmail.com"; //寄件者
  
  if(mail("$to", "$subject", "$msg", "$headers")):
   echo "信件已經發送成功。";//寄信成功就會顯示的提示訊息
  else:
   echo "信件發送失敗！";//寄信失敗顯示的錯誤訊息
  endif;
?>

