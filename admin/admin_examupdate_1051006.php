<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>

<?
header("Cache-control:private");//解決session 引起的回上一頁表單被清空
?>
<?php
//	---------------------------------------------
//	Pure PHP PIC Upload version 1.1
//	-------------------------------------------
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_PIC_SIZE",3000000);
define("DESTINATION_PIC_FOLDER", "../images/examinee");
define("no_error", "../examAdd2.php");
define("yes_error", "../examAdd2.php");
$_accepted_PIC_extensions_ = "jpg,gif,png";
if(strlen($_accepted_PIC_extensions_) > 0){
	$_accepted_PIC_extensions_ = @explode(",",$_accepted_PIC_extensions_);
} else {
	$_accepted_PIC_extensions_ = array();
}
/*	modify */
@$news_pic_title=$_POST["oldPictitle"];
@$newPicname=$_POST["oldPic"]; //變數$news_pic_title先儲存之前舊圖片檔名，如果沒有更新圖片，news_pic圖片欄位就繼續存入舊圖檔名
if(!empty($HTTP_POST_FILES['news_pic'])){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['news_pic']['tmp_name']) && $HTTP_POST_FILES['news_pic']['error'] == 0){
		$_file_ = $HTTP_POST_FILES['news_pic'];
		$errStr = "";
		$_name_ = $_file_['name'];
		$_type_ = $_file_['type'];
		$_tmp_name_ = $_file_['tmp_name'];
		$_size_ = $_file_['size'];
		header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_PIC_SIZE && MAX_PIC_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$_ext_ = strtolower($_ext_[count($_ext_)-1]);
		
		$news_pic_title=$_file_['name'];		
		list($usec, $sec) = explode(" ", microtime());//$usec:毫秒, $sec:秒
		$datetime = date("YmdHisx.",$sec);
		$datetime = str_replace('x', substr($usec,2,3), $datetime);
		
		if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_PIC_FOLDER) && is_writeable(DESTINATION_PIC_FOLDER)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			$newPicname=$datetime.$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱
			if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER . "/" . $newPicname)){//修改檔案名稱
				@unlink('../images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它
				header("Location: " . no_error);
			} else {
				echo "<script>history.back()</script>";//回上一頁
				exit;                                  //停止後續程式碼的繼續執行
				//header("Location: " . yes_error);
			}
		} else {
			echo "<script>history.back()</script>";//回上一頁
		    exit;	                               //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}
	}
}
?>

<?php require_once('../Connections/conn_web.php');
require_once('../PHPMailer/class.phpmailer.php');
mb_internal_encoding('UTF-8'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
  $allSubjects=$_POST['Subjects'];
  $allSubjects= implode(',' , $allSubjects);		
  $maxlevel=0;
  $degreeArray = array('1'=>array($_POST['Other2'],$_POST['Other2_dept'],$_POST['eduRec1']),
  		'2'=>array($_POST['Highest'],$_POST['Department'],$_POST['eduRec2']),
  		'3'=>array($_POST['Sec_highest'],$_POST['Sec_dept'],$_POST['eduRec3']),
  		'4'=>array($_POST['Other1'],$_POST['Other1_dept'],$_POST['eduRec4']));
  IF($_POST['Other2']!=""){ //學歷(1:專科,2:學士,3:碩士,4:博士)
  	$maxlevel=1;
  }
  IF($_POST['Highest']!=""){
  	$maxlevel=2;
  }
  IF($_POST['Sec_highest']!=""){
  	$maxlevel=3;
  }
  IF($_POST['Other1']!=""){
  	$maxlevel=4;
  }	
 $insertSQL = sprintf("UPDATE examinee SET birthday=%s, username=%s, uname=%s, eng_uname=%s, sex=%s, email=%s, phone=%s, Area=%s, cityarea=%s, cuszip=%s, cusadr=%s, per_id=%s,  
 				category=%s, exarea=%s, school=%s, Grade=%s, Student_ID=%s, Highest=%s, Department=%s, Edu_level=%s, Edu_MK=%s, pic_title=%s, pic_name=%s, date=%s, allow=%s, certificate=%s, 
 				Sec_highest=%s, Sec_dept=%s, Edu_level2=%s, Edu_MK2=%s, Other1=%s, Other1_dept=%s, Edu_level3=%s, Edu_MK3=%s, Other2=%s, Other2_dept=%s, Edu_level4=%s, Edu_MK4=%s 
 				WHERE id=%s AND no=%s",
                       GetSQLValueString($_POST['birthday'], "text"),
					   GetSQLValueString($_POST['username'], "text"),					   
                       GetSQLValueString($_POST['uname'], "text"),
					   GetSQLValueString($_POST['eng_uname'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['email'], "text"),                      
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['Area'], "text"),
                       GetSQLValueString($_POST['cityarea'], "text"),
                       GetSQLValueString($_POST['cuszip'], "text"),
                       GetSQLValueString($_POST['cusadr'], "text"),
					   GetSQLValueString($_POST['per_id'], "text"),
					   GetSQLValueString($allSubjects, "text"),
					   GetSQLValueString($_POST['exarea'], "text"),
					   GetSQLValueString($_POST['school'], "text"),
					   GetSQLValueString($_POST['Grade'], "text"),
					   GetSQLValueString($_POST['Student_ID'], "text"),
 					   GetSQLValueString($degreeArray[$maxlevel][0], "text"),
					   GetSQLValueString($degreeArray[$maxlevel][1], "text"),
					   GetSQLValueString($maxlevel, "text"),
					   GetSQLValueString($degreeArray[$maxlevel][2], "text"),
					   GetSQLValueString($news_pic_title, "text"),					   
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($_POST['date'], "date"),
					   GetSQLValueString($_POST['allow'], "text"),
					   GetSQLValueString($_POST['certificate'], "text"),
			 		   GetSQLValueString($degreeArray[$maxlevel-1][0], "text"),
			 		   GetSQLValueString($degreeArray[$maxlevel-1][1], "text"),
			 		   GetSQLValueString($maxlevel-1, "text"),
			 		   GetSQLValueString($degreeArray[$maxlevel-1][2], "text"),
			 		   GetSQLValueString($degreeArray[$maxlevel-2][0], "text"),
			 		   GetSQLValueString($degreeArray[$maxlevel-2][1], "text"),
			 		   GetSQLValueString($maxlevel-2, "text"),
			 		   GetSQLValueString($degreeArray[$maxlevel-2][2], "text"),
			 		   GetSQLValueString($degreeArray[$maxlevel-3][0], "text"),
			 		   GetSQLValueString($degreeArray[$maxlevel-3][1], "text"),
			 		   GetSQLValueString($maxlevel-3, "text"),
			 		   GetSQLValueString($degreeArray[$maxlevel-3][2], "text"),
 		
					   GetSQLValueString($_POST['id'], "text"),
 					   GetSQLValueString($_POST['no'], "text"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());

  $updateGoTo = "admin_exammember.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
	
	  if($_POST['allow'] == 'N'){
		  $mail = new PHPMailer();
	      $mail->IsSMTP();
	      $mail->SMTPAuth = true; // turn on SMTP authentication
	      $mail->Username = "ckassessment@gmail.com";
	      $mail->Password = "assessmentck";
	      $mail->FromName = "ck系統管理員";
	      $webmaster_email = "ckassessment@gmail.com"; 
		  
		  $mail->CharSet = "utf8";
	      $email=$_POST['email'];// 收件者信箱
	      $name=$_POST['username'];// 收件者的名稱or暱稱
	      $mail->From = $webmaster_email;
	      $mail->AddAddress($email,$name);
	      $mail->AddReplyTo($webmaster_email,"Squall.f");
	      $mail->WordWrap = 50;//每50行斷一次行
	      //$mail->AddAttachment("/XXX.rar");
	      // 附加檔案可以用這種語法(記得把上一行的//去掉)
	
	      $mail->IsHTML(true); // send as HTML
	      $subject="國民小學教師學科知能評量通知";
	      $mail->Subject = $subject; // 信件標題
	
	      $body="親愛的考生您好，由於您上傳的大頭照未符合規定，請重新上傳正確的大頭照，以免影響考試權益，謝謝；<br />
	         <br />
	         如有任何問題歡迎與我們聯絡，謝謝!!<br />
			 any problem，you can touch us，thank you!!";
	      $mail->Body = $body;//信件內容(html版，就是可以有html標籤的如粗體、斜體之類)
	      $mail->AltBody = $body; //信件內容(純文字版)
	
	      //if(!$mail->Send()){
	      // echo "寄信發生錯誤：" . $mail->ErrorInfo;//如果有錯誤會印出原因
	      //  }
	      // else{ 
	      // echo "寄信成功";
	      //     }	  
  	}
	
	
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_web_member = "-1";
if (isset($_GET['no'])) {
  $colname_web_member = $_GET['no'];
}
// echo $colname_web_member;
mysql_select_db($database_conn_web, $conn_web);
$query_web_examinee = sprintf("SELECT * FROM examinee WHERE no = %s ", GetSQLValueString($colname_web_member, "text"));
$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
$row_web_examinee = mysql_fetch_assoc($web_examinee);
$totalRows_web_member = mysql_num_rows($web_examinee);

$degreeArray = array($row_web_examinee['Edu_level4']=>array($row_web_examinee['Other2'],$row_web_examinee['Other2_dept'],$row_web_examinee['Edu_MK4']),
		$row_web_examinee['Edu_level']=>array($row_web_examinee['Highest'],$row_web_examinee['Department'],$row_web_examinee['Edu_MK']),
		$row_web_examinee['Edu_level2']=>array($row_web_examinee['Sec_highest'],$row_web_examinee['Sec_dept'],$row_web_examinee['Edu_MK2']),
		$row_web_examinee['Edu_level3']=>array($row_web_examinee['Other1'],$row_web_examinee['Other1_dept'],$row_web_examinee['Edu_MK3']));


?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台管理</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="報名考試" />
<meta name="keywords" content="報名考試" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />
<script language=javascript src="../address.js"></script><!--引入郵遞區號.js檔案-->
</head>

<body  background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  
  <div id="exam" align="center">
    <form id="form3" name="form3" method="POST" enctype="multipart/form-data" action="<?php echo $editFormAction; ?>" onsubmit="YY_checkform('form3','uname','#q','0','請檢查姓名欄位','email','#S','2','請檢查email欄位','phone','#q','0','請檢查電話欄位','captcha','birthday','#q','0','請檢查生日欄位','per_id','#q','0','請檢查身分證字號欄位','cusadr','#q','0','請檢查地址欄位','Student_ID','#q','0','請檢查學號欄位','Department','#q','0','請檢查就讀科系欄位');return document.MM_returnValue">
      <table width="540" border="0" cellspacing="0" cellpadding="0" >
        <tr>
          <td width="25" align="left"><img src="../images/board03.gif" /></td>
          <td width="505" align="left" background="../images/board04.gif">&nbsp; <span class="font_black">親愛的考生[</span><span class="font_red">&nbsp;<?php echo $row_web_examinee['username']; ?> &nbsp;</span><span class="font_black">]請確認下方您填寫的報名資料~~</span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="540" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="82" height="30" align="right" class="board_add">姓名：</td>
          <td width="458" align="left" class="board_add" colspan="2"><label>
            <input name="uname" type="text" id="uname" value="<?php echo $row_web_examinee['uname']; ?>" />
          </label><span class="font_red">* </span><?php echo $row_web_examinee['no'];?></td>
        </tr>
         <tr>
          <td width="82" height="30" align="right" class="board_add">英文姓名：</td>
          <td width="458" align="left" class="board_add" colspan="2"><label>
            <input name="eng_uname" type="text" id="eng_uname" value="<?php echo $row_web_examinee['eng_uname']; ?>" />
          </label><span class="font_red">* </span></td>
        </tr>       
        <tr>
          <td height="30" align="right" class="board_add">E-mail：</td>
          <td align="left" class="board_add" colspan="2"><label>
            <input name="email" type="text" id="email" value="<?php echo $row_web_examinee['email']; ?>" size="35" />
          </label><span class="font_red">* </span><br /></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">性別：</td>
          <td align="left" class="board_add" colspan="2"><label>
            <input <?php if (!(strcmp($row_web_examinee['sex'],"男"))) {echo "checked=\"checked\"";} ?> name="sex" type="radio" id="radio" value="男" checked="checked" />
          男
          <input <?php if (!(strcmp($row_web_examinee['sex'],"女"))) {echo "checked=\"checked\"";} ?> type="radio" name="sex" id="radio2" value="女" />
          女 &nbsp; &nbsp;</label>
          
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">出生年月日：</td>
          <td align="left" class="board_add" colspan="2"><label>
            <input name="birthday" type="text" id="birthday" value="<?php echo $row_web_examinee['birthday']; ?>" />
          格式為：YYYY-MM-DD</label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">聯絡電話：</td>
          <td align="left" class="board_add" colspan="2"><label>
            <input name="phone" type="text" id="phone" value="<?php echo $row_web_examinee['phone']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">身分證字號：</td>
          <td align="left" class="board_add" colspan="2"><label>
            <?php echo $row_web_examinee['per_id']; ?><input name="per_id" type="hidden" id="per_id" value="<?php echo $row_web_examinee['per_id']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">郵遞區號：</td>
          <td align="left" class="board_add" colspan="2">
                          <select onchange="citychange(this.form)" name="Area">
                            <option value="基隆市" <?php if (!(strcmp("基隆市", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>基隆市</option>
                            <option value="臺北市" selected="selected" <?php if (!(strcmp("臺北市", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>臺北市</option>
                            <option value="新北市" <?php if (!(strcmp("新北市", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>新北市</option>
                            <option value="桃園縣" <?php if (!(strcmp("桃園縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>桃園縣</option>
                            <option value="新竹市" <?php if (!(strcmp("新竹市", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>新竹市</option>
                            <option value="新竹縣" <?php if (!(strcmp("新竹縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>新竹縣</option>
                            <option value="苗栗縣" <?php if (!(strcmp("苗栗縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>苗栗縣</option>
                            <option value="臺中市" <?php if (!(strcmp("臺中市", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>臺中市</option>
                            <option value="彰化縣" <?php if (!(strcmp("彰化縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>彰化縣</option>
                            <option value="南投縣" <?php if (!(strcmp("南投縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>南投縣</option>
                            <option value="雲林縣" <?php if (!(strcmp("雲林縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>雲林縣</option>
                            <option value="嘉義市" <?php if (!(strcmp("嘉義市", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>嘉義市</option>
                            <option value="嘉義縣" <?php if (!(strcmp("嘉義縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>嘉義縣</option>
                            <option value="臺南市" <?php if (!(strcmp("臺南市", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>臺南市</option>
                            <option value="高雄市" <?php if (!(strcmp("高雄市", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>高雄市</option>
                            <option value="屏東縣" <?php if (!(strcmp("屏東縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>屏東縣</option>
                            <option value="臺東縣" <?php if (!(strcmp("臺東縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>臺東縣</option>
                            <option value="花蓮縣" <?php if (!(strcmp("花蓮縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>花蓮縣</option>
                            <option value="宜蘭縣" <?php if (!(strcmp("宜蘭縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>宜蘭縣</option>
                            <option value="澎湖縣" <?php if (!(strcmp("澎湖縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>澎湖縣</option>
                            <option value="金門縣" <?php if (!(strcmp("金門縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>金門縣</option>
                            <option value="連江縣" <?php if (!(strcmp("連江縣", $row_web_examinee['Area']))) {echo "selected=\"selected\"";} ?>>連江縣</option>
                          </select>
                          <select onchange="areachange(this.form)" name="cityarea">
                                <option value="<?php echo $row_web_examinee['cityarea']; ?>" selected="selected"><?php echo $row_web_examinee['cityarea']; ?></option>
                          </select>
                          <input type="hidden" value="100" name="Mcode" />
                          <input name="cuszip" value="<?php echo $row_web_examinee['cuszip']; ?>" size="5" maxlength="5" readonly="readOnly" />
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">完整地址：</td>
          <td align="left" class="board_add" colspan="2"><span class="bs">
            <input name="cusadr" type="text" id="cusadr" value="<?php echo $row_web_examinee['cusadr']; ?>" size="60" />
          </span></td>
        </tr>
        <tr>
          <td height="30" align="right" colspan="3" class="board_add">=========================================================================================</td>          
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">教師證號碼：</td>
          <td align="left" class="board_add" colspan="2">
           <label>
            <input name="certificate" type="text" id="certificate" value="<?php echo $row_web_examinee['certificate']; ?>" />
          </label>
            </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">報名科目：</td>
          <td align="left" class="board_add" colspan="2">
          <label>
            <input <?php $str=split("," , $row_web_examinee['category']);
foreach ($str as $val){
if (!(strcmp($val,"1"))) {echo "checked=\"checked\"";}} ?> name="Subjects[]" type="checkbox" id="Subjects[]" value="1"  />
          國語
          <input <?php $str=split("," , $row_web_examinee['category']);
foreach ($str as $val){
if (!(strcmp($val,"2"))) {echo "checked=\"checked\"";} }?> type="checkbox" name="Subjects[]" id="Subjects[]" value="2" />
          數學
          <input <?php $str=split("," , $row_web_examinee['category']);
foreach ($str as $val){
if (!(strcmp($val,"3"))) {echo "checked=\"checked\"";}} ?> type="checkbox" name="Subjects[]" id="Subjects[]" value="3" />
          社會
          <input <?php $str=split("," , $row_web_examinee['category']);
foreach ($str as $val){
if (!(strcmp($val,"4"))) {echo "checked=\"checked\"";}} ?> type="checkbox" name="Subjects[]" id="Subjects[]" value="4" />
          自然         
          </label>
          (可複選)</td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">測驗考區：</td>
          <td align="left" class="board_add" colspan="2">
          <label>
            <input <?php if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {echo "checked=\"checked\"";} ?> name="exarea" type="radio" id="radio" value="Northern" checked="checked" />
          北部 
          <input <?php if (!(strcmp($row_web_examinee['exarea'],"Central"))) {echo "checked=\"checked\"";} ?> type="radio" name="exarea" id="radio2" value="Central" />
          中部
          <input <?php if (!(strcmp($row_web_examinee['exarea'],"Southern"))) {echo "checked=\"checked\"";} ?> type="radio" name="exarea" id="radio3" value="Southern" />
          南部  
          <input <?php if (!(strcmp($row_web_examinee['exarea'],"Eastern"))) {echo "checked=\"checked\"";} ?> type="radio" name="exarea" id="radio4" value="Eastern" />
          東部</label>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">任職學校：</td>
          <td align="left" class="board_add" colspan="2">
           <input name="school" type="text" id="school" value="<?php echo $row_web_examinee['school']; ?>" />
          </td>
        </tr>
        <tr>
          <td height="30" align="center" class="board_add">學歷</td>
          <td align="center" class="board_add">學校名稱</td>
          <td align="center" class="board_add">就讀科系</td>
        </tr>
        <tr>
          <td align="center" class="board_add"><label id="Edu_level" for="1">專科</label></td>
          <td height="30" align="right" class="board_add">
          	(<input name="eduRec1" type="radio" id="radio" value="0" <?php if($degreeArray[1][2]=="0") echo "checked=\"checked\""; ?> />在學中
			<input name="eduRec1" type="radio" id="radio" value="1" <?php if($degreeArray[1][2]=="1") echo "checked=\"checked\""; ?>/>畢業)
          	<label><input type="text" name="Other2" id="Other2"  value="<?php echo $degreeArray[1][0]; ?>" /></label>
          </td>
          <td align="left" class="board_add">       
          <input type="text" name="Other2_dept" id="Other2_dept"  value="<?php echo $degreeArray[1][1]; ?>"/>
          </td>
        </tr>
        <tr>
          <td align="center" class="board_add"><label id="Edu_level" for="2">學士</label></td>
          <td height="30" align="right" class="board_add">
          	(<input name="eduRec2" type="radio" id="radio" value="0"  <?php if($degreeArray[2][2]=="0") echo "checked=\"checked\""; ?>/>在學中
			<input name="eduRec2" type="radio" id="radio" value="1" <?php if($degreeArray[2][2]=="1") echo "checked=\"checked\""; ?>/>畢業)
          	<label><input type="text" name="Highest" id="Highest"  value="<?php echo $degreeArray[2][0]; ?>" /></label>
          </td>
          <td align="left" class="board_add">   
          <input type="text" name="Department" id="Department"  value="<?php echo $degreeArray[2][1]; ?>"/>
          </td>
        </tr>
        <tr>
          <td  align="center" class="board_add"><label id="Edu_level" for="3">碩士</label></td>
          <td height="30" align="right" class="board_add">
			(<input name="eduRec3" type="radio" id="radio" value="0" <?php if($degreeArray[3][2]=="0") echo "checked=\"checked\""; ?>/>在學中
			<input name="eduRec3" type="radio" id="radio" value="1"  <?php if($degreeArray[3][2]=="1") echo "checked=\"checked\""; ?>/>畢業)
          	<label><input type="text" name="Sec_highest" id="Sec_highest"  value="<?php echo $degreeArray[3][0]; ?>" /></label>
          </td>
          <td align="left" class="board_add">        
          <input type="text" name="Sec_dept" id="Sec_dept"  value="<?php echo $degreeArray[3][1]; ?>"/>
          </td>
        </tr>
        <tr>
          <td  align="center" class="board_add"> <label id="Edu_level" for="4">博士</label></td>
          <td height="30" align="right" class="board_add">
          	(<input name="eduRec4" type="radio" id="radio" value="0" <?php if($degreeArray[4][2]=="0") echo "checked=\"checked\""; ?> />在學中
			<input name="eduRec4" type="radio" id="radio" value="1" <?php if($degreeArray[4][2]=="1") echo "checked=\"checked\""; ?>/>畢業)
          <label><input type="text" name="Other1" id="Other1"  value="<?php echo $degreeArray[4][0]; ?>" /></label>
          </td>
          <td align="left" class="board_add">        
          <input type="text" name="Other1_dept" id="Other1_dept"  value="<?php echo $degreeArray[4][1]; ?>"/>
          </td>
        </tr>

        <tr>
          <td height="30" align="right" class="board_add">年級：</td>
          <td align="left" class="board_add">
          <label>
            <input <?php if (!(strcmp($row_web_examinee['Grade'],"1"))) {echo "checked=\"checked\"";} ?> name="Grade" type="radio" id="radio1" value="1"  />
          大一
          <input <?php if (!(strcmp($row_web_examinee['Grade'],"2"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio2" value="2" />
          大二
          <input <?php if (!(strcmp($row_web_examinee['Grade'],"3"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio3" value="3" />
          大三
          <input <?php if (!(strcmp($row_web_examinee['Grade'],"4"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio4" value="4" />
          大四
          <input <?php if (!(strcmp($row_web_examinee['Grade'],"5"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio5" value="5" />
          大五(含)以上
          <input <?php if (!(strcmp($row_web_examinee['Grade'],"6"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio6" value="6" />
          研究所
          </label>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">學號：</td>
          <td align="left" class="board_add" colspan="2"><label>
            <input type="text" name="Student_ID" id="Student_ID" value="<?php echo $row_web_examinee['Student_ID']; ?>" />
          </label></td>
        </tr>
        <tr>
        <td height="30" align="right" class="board_add">大頭照圖片：</td>
         <td align="left" class="board_add" colspan="2"><span class="table_lineheight">
          <?php /*START_PHP_SIRFCIT*/ if ($row_web_examinee['pic_name']!=""){ ?>
          <a href="editpic.php?id=<?php echo $row_web_examinee['pic_name']; ?>"><img src="../images/examinee/<?php echo $row_web_examinee['pic_name']; ?>" alt="" name="pic" width="70" id="pic" /></a>
          <?php } /*END_PHP_SIRFCIT*/ ?>
          <input name="oldPic" type="hidden" id="oldPic" value="<?php echo $row_web_examinee['pic_name']; ?>" />
          <input name="oldPictitle" type="hidden" id="oldPic" value="<?php echo $row_web_examinee['pic_title']; ?>" />          
          <?php echo $row_web_examinee['pic_title']; ?><br />
          <label>
            <input type="file" name="news_pic" id="news_pic" />
          </label>
          <br />
          <span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
       </td>
        
      </tr>
        <tr>
          <td height="30" align="right" class="board_add">是否審核<br>通過：</td>
          <td align="left" class="board_add" colspan="2"><label>
            <input <?php if (!(strcmp($row_web_examinee['allow'],"Y"))) {echo "checked=\"checked\"";} ?> name="allow" type="radio" id="radio" value="Y"  />
          通過
          <input <?php if (!(strcmp($row_web_examinee['allow'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="allow" id="radio2" value="N"/>
          不通過
          <input <?php if (!(strcmp($row_web_examinee['allow'],"0"))) {echo "checked=\"checked\"";} ?> type="radio" name="allow" id="radio3" value="0"/>
          審核中&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</label>
          
          </td>
        <tr>
          <td height="40" colspan="2" align="center"><label>
            <input type="submit" name="button" id="button" value="確認編輯" />
            <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
            <input name="id" type="hidden" id="id" value="<?php echo $row_web_examinee['id']; ?>" />
            <input name="no" type="hidden" id="no" value="<?php echo $row_web_examinee['no']; ?>" />
            <input name="username" type="hidden" id="username" value="<?php echo $row_web_examinee['username']; ?>" />
            <input name="date" type="hidden" id="date" value="<? echo date("Y-m-d H:i:s");?>" />
          </label></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form3" />
    </form>
  </div>
  <div id="main4"></div>
  <?php include("footer.php"); ?>
</div>

</div>
</body>
</html>
<?php
mysql_free_result($web_examinee);
?>
