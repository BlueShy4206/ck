<?php
session_start();
if(isset($_POST["captcha"])) {
	if(($_SESSION['captcha_code'] == $_POST['captcha']) && (!empty($_SESSION['captcha_code'])) ) {
		//Passed!
		$captcha_msg="Thank you";
	}else{
		// Not passed 8-(
		$captcha_msg="invalid code";
		if(isset($_POST["MM_insert"])){
	  		unset($_POST["MM_insert"]);
		}
		if(isset($_POST["MM_update"])){
			unset($_POST["MM_update"]);
		}
	}
}
class CaptchaImage {
	var $font = "verdana.ttf";
	function hex_to_dec($hexcolor){
	//convert hex hex values to decimal ones
	$dec_color=array('r'=>hexdec(substr($hexcolor,0,2)),'g'=>hexdec(substr($hexcolor,2,2)),'b'=>hexdec(substr($hexcolor,4,2)));
	return $dec_color;
	}
	function generateCode($characters) {
		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = '23456789bcdfghjkmnpqrstvwxyz'; 
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}
	function CaptchaImage($width='120',$height='30',$characters='6',$hex_bg_color='FFFFFF',$hex_text_color="FF0000",$hex_noise_color="CC0000", $img_file='captcha.jpg') {
		$rgb_bg_color=$this->hex_to_dec($hex_bg_color);
		$rgb_text_color=$this->hex_to_dec($hex_text_color);
		$rgb_noise_color=$this->hex_to_dec($hex_noise_color);
		$code = $this->generateCode($characters);
		/* font size will be 60% of the image height */
		$font_size = $height * 0.60;
		$image = @imagecreate($width, $height) or die('Cannot Initialize new GD image stream');
		/* set the colours */
		$background_color = imagecolorallocate($image, $rgb_bg_color['r'], $rgb_bg_color['g'],$rgb_bg_color['b']);
		$text_color = imagecolorallocate($image, $rgb_text_color['r'], $rgb_text_color['g'],$rgb_text_color['b']);
		$noise_color = imagecolorallocate($image, $rgb_noise_color['r'], $rgb_noise_color['g'],$rgb_noise_color['b']);
		/* generate random dots in background */
		for( $i=0; $i<($width*$height)/3; $i++ ) {
			imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
		}
		/* generate random lines in background */
		for( $i=0; $i<($width*$height)/150; $i++ ) {
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
		}
		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $code);
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $code);
		/* save the image */
		imagejpeg($image,$img_file);
		imagedestroy($image);
		echo "<img src=\"$img_file?".time()."\" width=\"$width\" height=\"$height\" alt=\"security code\" id=\"captchaImg\">";
		$_SESSION['captcha_code'] = $code;
	}

}
?>
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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="memberAdd.php";
  $loginUsername = $_POST['username'];
  $loginEmail = $_POST['email'];
  $LoginRS__query = sprintf("SELECT username FROM member WHERE username=%s OR email=%s", GetSQLValueString($loginUsername, "text"),GetSQLValueString($loginEmail, "text"));
  mysql_select_db($database_conn_web, $conn_web);
  $LoginRS=mysql_query($LoginRS__query, $conn_web) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$birthday=$_POST["year"]."-".$_POST["month"]."-".$_POST["day"];
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "memberadd")) {
  $insertSQL = sprintf("INSERT INTO member (birthday,username, password, uname, sex, email, orderPaper, phone, Area, cityarea, cuszip, cusadr, `date`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($birthday, "text"),
					   GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString(md5($_POST['password']), "text"),
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString(isset($_POST['orderPaper']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['Area'], "text"),
                       GetSQLValueString($_POST['cityarea'], "text"),
                       GetSQLValueString($_POST['cuszip'], "text"),
                       GetSQLValueString($_POST['cusadr'], "text"),
                       GetSQLValueString($_POST['date'], "date"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());

  $insertGoTo = "memberAddSuccess.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
//加入會員成功後，寄發會員信
  mb_internal_encoding('UTF-8');//指定發信使用UTF-8編碼，防止信件標題亂碼
  $servicemail="test@test.com";//指定網站管理員服務信箱，請修改為自己的有效mail
  $webname="HAPPY購物網站";//寫入網站名稱
  $email=$_POST['email'];//上一頁傳來的會員email
  $subject=$_POST['name']."您好，歡迎您加入".$webname;//信件標題
  $subject=mb_encode_mimeheader($subject, 'UTF-8');//指定標題將雙位元文字編碼為單位元字串，避免亂碼
  //指定信件內容
  $body="親愛的會員".$_POST['uname']."您好，歡迎您加入HAPPY購物網站成為會員，以下是您的會員資料:<br />
         您的帳號是".$_POST['username']."<br />您的密碼是".$_POST['password']."<br />
         請妥善保存您的資料，如有任何問題歡迎與我們聯絡，謝謝!!any problem，you can touch us，thank you!!";
  //郵件檔頭設定
  $headers = "MIME-Version: 1.0\r\n";//指定MIME(多用途網際網路郵件延伸標準)版本
  $headers .= "Content-type: text/html; charset=utf-8\r\n";//指定郵件類型為HTML格式
  $headers .= "From:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail."> \r\n";//指定寄件者資訊
  $headers .= "Reply-To:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail.">\r\n";//指定信件回覆位置
  $headers .= "Return-Path:".mb_encode_mimeheader($webname, 'UTF-8')."<".$servicemail.">\r\n";//被退信時送回位置
  //使用mail函數寄發信件
  mail ($email,$subject,$body,$headers);
//加入會員成功後，寄發會員信結束
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dreamweaver+PHP資料庫網站製作</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="Dreamweaver+PHP資料庫網站製作" />
<meta name="keywords" content="Dreamweaver+PHP資料庫網站製作" />
<meta name="author" content="joj設計、joj網頁設計、joj Design、joj Web Design、呂昶億、杜慎甄" />
<link href="web.css" rel="stylesheet" type="text/css" />
<script language=javascript src="address.js"></script><!--引入郵遞區號.js檔案-->
<script type="text/javascript">
<!--
function YY_checkform() { //v4.66
//copyright (c)1998,2002 Yaromat.com
  var args = YY_checkform.arguments; var myDot=true; var myV=''; var myErr='';var addErr=false;var myReq;
  for (var i=1; i<args.length;i=i+4){
    if (args[i+1].charAt(0)=='#'){myReq=true; args[i+1]=args[i+1].substring(1);}else{myReq=false}
    var myObj = MM_findObj(args[i].replace(/\[\d+\]/ig,""));
    myV=myObj.value;
    if (myObj.type=='text'||myObj.type=='password'||myObj.type=='hidden'){
      if (myReq&&myObj.value.length==0){addErr=true}
      if ((myV.length>0)&&(args[i+2]==1)){ //fromto
        var myMa=args[i+1].split('_');if(isNaN(myV)||myV<myMa[0]/1||myV > myMa[1]/1){addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==2)){
          var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-z]{2,4}$");if(!rx.test(myV))addErr=true;
      } else if ((myV.length>0)&&(args[i+2]==3)){ // date
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);
        if(myAt){
          var myD=(myAt[myMa[1]])?myAt[myMa[1]]:1; var myM=myAt[myMa[2]]-1; var myY=myAt[myMa[3]];
          var myDate=new Date(myY,myM,myD);
          if(myDate.getFullYear()!=myY||myDate.getDate()!=myD||myDate.getMonth()!=myM){addErr=true};
        }else{addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==4)){ // time
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);if(!myAt){addErr=true}
      } else if (myV.length>0&&args[i+2]==5){ // check this 2
            var myObj1 = MM_findObj(args[i+1].replace(/\[\d+\]/ig,""));
            if(myObj1.length)myObj1=myObj1[args[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!myObj1.checked){addErr=true}
      } else if (myV.length>0&&args[i+2]==6){ // the same
            var myObj1 = MM_findObj(args[i+1]);
            if(myV!=myObj1.value){addErr=true}
      }
    } else
    if (!myObj.type&&myObj.length>0&&myObj[0].type=='radio'){
          var myTest = args[i].match(/(.*)\[(\d+)\].*/i);
          var myObj1=(myObj.length>1)?myObj[myTest[2]]:myObj;
      if (args[i+2]==1&&myObj1&&myObj1.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
      if (args[i+2]==2){
        var myDot=false;
        for(var j=0;j<myObj.length;j++){myDot=myDot||myObj[j].checked}
        if(!myDot){myErr+='* ' +args[i+3]+'\n'}
      }
    } else if (myObj.type=='checkbox'){
      if(args[i+2]==1&&myObj.checked==false){addErr=true}
      if(args[i+2]==2&&myObj.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
    } else if (myObj.type=='select-one'||myObj.type=='select-multiple'){
      if(args[i+2]==1&&myObj.selectedIndex/1==0){addErr=true}
    }else if (myObj.type=='textarea'){
      if(myV.length<args[i+1]){addErr=true}
    }
    if (addErr){myErr+='* '+args[i+3]+'\n'; addErr=false}
  }
  if (myErr!=''){alert('The required information is incomplete or contains errors:\t\t\t\t\t\n\n'+myErr)}
  document.MM_returnValue = (myErr=='');
}
//-->
</script>
<script src="SpryAssets/SpryData.js" type="text/javascript"></script>
<script language="javascript">
<!--
function chkUserID(idObj){ 
	if(idObj.value.length < 4){
		/*帳號欄位輸入不得少於4個字元，否則顯示提示訊息*/
		document.getElementById("idErrMsg").innerHTML = "<img src='images/icon-cross.gif' /><font color='red'> 帳號輸入請勿少於4個字元</font>";
	}else{
		/*確認無誤，採用GET方式傳遞帳號欄位輸入內容至member_idCheck.php頁面，進行帳號查詢，並傳回結果*/
		Spry.Utils.loadURL("GET","member_idCheck.php?username=" + idObj.value,false,uidchkRes);
	}
}
function uidchkRes(idreq){ /*下面依據查詢結果，顯示對應訊息*/
	var IDresult = idreq.xhRequest.responseText;
	if(IDresult!=0){
		document.getElementById("idErrMsg").innerHTML = "<img src='images/icon-cross.gif' /><font color='red'> 此帳號已被使用!!</font>";
	}else{
		document.getElementById("idErrMsg").innerHTML = "<img src='images/icon-tick.gif' /><font color='green'> 此帳號可註冊使用!</font>";
	}
}
function chkUserMail(mailObj){
	if(mailObj.value.length < 4){
		/*email欄位輸入不得少於4個字元，否則顯示提示訊息*/
		document.getElementById("emailErrMsg").innerHTML = "<img src='images/icon-cross.gif' /><font color='red'> email輸入請勿少於4個字元</font>";
	}else{
		/*確認無誤，採用GET方式傳遞email欄位輸入內容至member_emailCheck.php頁面，進行email查詢，並傳回結果*/
		Spry.Utils.loadURL("GET","member_emailCheck.php?email=" + mailObj.value,false,umailchkRes);
	}
}
function umailchkRes(mailreq){  /*下面依據查詢結果，顯示對應訊息*/
	var IDresult = mailreq.xhRequest.responseText;
	if(IDresult!=0){
		document.getElementById("emailErrMsg").innerHTML = "<img src='images/icon-cross.gif' /><font color='red'> 此email已被使用!!</font>";
	}else{
		document.getElementById("emailErrMsg").innerHTML = "<img src='images/icon-tick.gif' /><font color='green'> 此email可註冊使用!</font>";
	}
}			
-->
</script>
</head>

<body onload="MM_preloadImages('images/btn_shop1_2.gif','images/btn_shop2_2.gif','images/btn_shop3_2.gif','images/btn_shop4_2.gif','images/btn_shop5_2.gif','images/btn_shop6_2.gif')">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <? include("leftzone.php")?>
  </div>
  <div id="main3" align="center">
    <? if(empty($_SESSION["MM_Username"])){//如果未驗證到會員登入的Session變數MM_Username，顯示本區塊?>
    <form action="<?php echo $editFormAction; ?>" method="POST" name="memberadd" id="memberadd" onsubmit="YY_checkform('memberadd','uname','#q','0','請檢查姓名欄位','username','#q','0','請檢查帳號欄位','email','#S','2','請檢查email欄位','phone','#q','0','請檢查電話欄位','captcha','#recaptcha','6','請檢查圖形驗證碼欄位','password','#repassword','6','請檢查密碼欄位','repassword','#password','6','請檢查確認密碼欄位，或輸入值與密碼欄位不同');return document.MM_returnValue">
      <? if($_GET["requsername"]!=""){?>
      <table width="540" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" bgcolor="#FF0000" class="font_white">帳號或電子郵件已經註冊過了!!</td>
        </tr>
      </table>
      <? }?>
      <table width="540" border="0" cellspacing="0" cellpadding="0" background="images/back11_2.gif">
        <tr>
          <td width="25" align="left"><img src="images/board03.gif" /></td>
          <td width="505" align="left" background="images/board04.gif">&nbsp; <span class="font_black">歡迎您填妥資料，加入成為網站會員~~</span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="540" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="82" height="30" align="right" class="board_add">姓名：</td>
          <td width="458" align="left" class="board_add"><label>
            <input type="text" name="uname" id="uname" />
          </label><span class="font_red">* </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">帳號：</td>
          <td align="left" class="board_add"><label>
            <input type="text" name="username" id="username" onblur="chkUserID(this)" />
          </label><span class="font_red">* </span><span id="idErrMsg"> </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">密碼：</td>
          <td align="left" class="board_add"><label>
            <input name="password" type="password" id="password" size="15" />
          </label><span class="font_red">* </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">確認密碼：</td>
          <td align="left" class="board_add"><label>
            <input name="repassword" type="password" id="repassword" size="15" />
          </label><span class="font_red">* </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">E-mail：</td>
          <td align="left" class="board_add"><label>
            <input name="email" type="text" id="email" size="35" onblur="chkUserMail(this)" />
          </label><span class="font_red">*</span><span id="emailErrMsg"> </span><br />
          <span class="font_black">請勿使用會檔信的yahoo、pchome信箱，以免收不到註冊信及訂閱之會員電子報。</span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">性別：</td>
          <td align="left" class="board_add"><label>
            <input name="sex" type="radio" id="radio" value="男" checked="checked" />
          男
          <input type="radio" name="sex" id="radio2" value="女" />
          女&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</label>
          <label>
            <input name="orderPaper" type="checkbox" id="orderPaper" value="Y" checked="checked" />
         </label> 訂閱電子報
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">生日：</td>
          <td align="left" class="board_add">
          <select name="year" id="year">
             <option>年</option>
               <script language="javascript" type="text/javascript">
                   var watch=new Date();
                   var thisYear=watch.getFullYear();
				   for(y=1900;y<=thisYear;y++){
                       document.write("<option value='"+y+"'>"+y+"</option>")
	                  }
	           </script>
          </select>
          
          <select name="month" id="month">
            <option>月</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(m=01;m<=12;m++){
                       document.write("<option value='"+m+"'>"+m+"</option>")
	                  }
	           </script>
           </select>
 
           <select name="day" id="day">
            <option>日</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(d=01;d<=31;d++){
                       document.write("<option value='"+d+"'>"+d+"</option>")
	                  }
	           </script>
          </select>
          </td>
        </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">電話：</td>
          <td align="left" class="board_add"><label>
            <input type="text" name="phone" id="phone" />
          </label><span class="font_red">* </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">郵遞區號：</td>
          <td align="left" class="board_add">
                          <select onChange="citychange(this.form)" name="Area">
                              <option value="基隆市">基隆市</option>
                              <option value="臺北市" selected="selected">臺北市</option>
                              <option value="新北市">新北市</option>
                              <option value="桃園縣">桃園縣</option>
                              <option value="新竹市">新竹市</option>
                              <option value="新竹縣">新竹縣</option>
                              <option value="苗栗縣">苗栗縣</option>
                              <option value="臺中市">臺中市</option>
                              <option value="彰化縣">彰化縣</option>
                              <option value="南投縣">南投縣</option>
                              <option value="雲林縣">雲林縣</option>
                              <option value="嘉義市">嘉義市</option>
                              <option value="嘉義縣">嘉義縣</option>
                              <option value="臺南市">臺南市</option>
                              <option value="高雄市">高雄市</option>
                              <option value="屏東縣">屏東縣</option>
                              <option value="臺東縣">臺東縣</option>
                              <option value="花蓮縣">花蓮縣</option>
                              <option value="宜蘭縣">宜蘭縣</option>
                              <option value="澎湖縣">澎湖縣</option>
                              <option value="金門縣">金門縣</option>
                              <option value="連江縣">連江縣</option>
                            </select>
                              <select onChange="areachange(this.form)" name="cityarea">
                                <option value="中正區" selected="selected">中正區</option>
                                <option value="大同區">大同區</option>
                                <option value="中山區">中山區</option>
                                <option value="松山區">松山區</option>
                                <option value="大安區">大安區</option>
                                <option value="萬華區">萬華區</option>
                                <option value="信義區">信義區</option>
                                <option value="士林區">士林區</option>
                                <option value="北投區">北投區</option>
                                <option value="內湖區">內湖區</option>
                                <option value="南港區">南港區</option>
                                <option value="文山區">文山區</option>
                              </select>
                           <input type="hidden" value="100" name="Mcode" />
                           <input name="cuszip" value="100" size="5" maxlength="5" readonly="readOnly" />
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">詳細地址：</td>
          <td align="left" class="board_add"><span class="bs">
            <input name="cusadr" type="text" id="cusadr" value="" size="60" />
          </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">驗證碼：</td>
          <td align="left" class="board_add">
          <label>
            <input name="captcha" type="text" id="captcha" size="10" />
            <?php $captcha = new CaptchaImage(150,50,5,'99FF00','000000','FFFFFF');?>
          </label>
          &nbsp;
          <input name="recaptcha" type="hidden" id="recaptcha" value="<? echo $_SESSION['captcha_code']?>" /></td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="center"><label>
            <input type="submit" name="button" id="button" value="送出資料" />
            <input type="reset" name="button2" id="button2" value="重設" />
            <input name="date" type="hidden" id="date" value="<? echo date("Y-m-d H:i:s");?>" />
          </label></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="memberadd" />
    </form>
    <? }else{//否則顯示另依個區塊內容?>
    <div align="center"><img src="images/memberAdderr.gif"></div>
    <? }?>
  </div>
  <div id="main4"></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>