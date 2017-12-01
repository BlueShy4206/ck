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
define("DESTINATION_PIC_FOLDER", "images/examinee");
define("no_error", "examOut.php");
define("yes_error", "examAdd1.php");
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
		echo "name:$_name_, type:$_type_, tmpName:$_tmp_name_<br>";
		header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_PIC_SIZE && MAX_PIC_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$attach = $_POST['username'];
		$_ext_ = strtolower($_ext_[count($_ext_)-1]);
		echo "newPic:".$newPicname=date("YmdHis")."_$attach.".$_ext_;
		$news_pic_title=$_file_['name'];		
		
		if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_PIC_FOLDER) && is_writeable(DESTINATION_PIC_FOLDER)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			$newPicname=date("YmdHis")."_$attach.".$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱
			if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER . "/" . $newPicname)){//修改檔案名稱
				@unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它
				//header("Location: " . no_error);
			} else {
				echo "<script>javascript:alert(\"發生錯誤1!\");</script>";//跳出錯誤訊息
				echo "<script>history.back()</script>";//回上一頁
				exit;                                  //停止後續程式碼的繼續執行
				//header("Location: " . yes_error);
			}
		} else {
			echo "<script>javascript:alert(\"發生錯誤2!\");</script>";//跳出錯誤訊息
			echo "<script>history.back()</script>";//回上一頁
		    exit;	                               //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
 // $allSubjects=$_POST['Subjects'];
 // $allSubjects= implode(',' , $allSubjects);	

	$Ticket=substr(($_POST['exarea']),0,1).$_POST['times'].substr(($_POST['endday']),0,4);
	mysql_select_db($database_conn_web, $conn_web);
	$query_web_search = sprintf("SELECT id FROM examinee WHERE id LIKE %s ORDER BY id DESC LIMIT 0,1", GetSQLValueString("%" . $Ticket . "%", "text"));
	$web_search = mysql_query($query_web_search, $conn_web) or die(mysql_error());
	$row_web_search = mysql_fetch_assoc($web_search);
	$totalRows_web_search = mysql_num_rows($web_search);
	if($totalRows_web_search == 0){
		$number=1;
		$Ticket=$Ticket.sprintf("%04d", $number);
	}else{
		$number=substr(($row_web_search['id']),6,4);
		$number=$number+1;
		$Ticket=$Ticket.sprintf("%04d", $number);

	}

if(substr(($_POST['exarea']),0,1)=="E" || substr(($_POST['exarea']),0,1)=="S"){
	if($number > 100){ 
	?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
	alert("報名人數已滿，請選擇其他場次。");
	window.history.back();
	</script>;
		
	<?php	
	die();
	}
	
	}else{
		if($number > 150){ 
	?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
	alert("報名人數已滿，請選擇其他場次。");
	window.history.back();
	</script>;
		
	<?php	
	die();
	}
		
	}
	$maxlevel=0;
	$degreeArray = array('1'=>array($_POST['Other2'],$_POST['Other2_dept'],$_POST['eduRec1']),
			'2'=>array($_POST['Highest'],$_POST['Department'],$_POST['eduRec2']),
			'3'=>array($_POST['Sec_highest'],$_POST['Sec_dept'],$_POST['eduRec3']),
			'4'=>array($_POST['Other1'],$_POST['Other1_dept'],$_POST['eduRec4']));
	IF($_POST['Other2']!=""){
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
	
	//echo $degreeArray[$maxlevel][0].",".$degreeArray[$maxlevel][1].",".$degreeArray[$maxlevel][2];
	
	$insertSQL = sprintf("INSERT INTO examinee (birthday, username, uname, eng_uname ,sex, 
 		email, phone, Area, cityarea, cuszip, cusadr, certificate, per_id, category, 
 		exarea, school, Highest, Department, Edu_level, Edu_MK, contact, contact_ph,
 		pic_title, pic_name, `date`, id, Sec_highest, Sec_dept, Edu_level2, Edu_MK2,
 		Other1, Other1_dept, Edu_level3, Edu_MK3, Other2, Other2_dept, Edu_level4, Edu_MK4) 
 		VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
 		%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
					   GetSQLValueString($_POST['certificate'], "text"),
					   GetSQLValueString($_POST['per_id'], "text"),
					   GetSQLValueString("4", "text"),
					   GetSQLValueString($_POST['exarea'], "text"),
					   GetSQLValueString($_POST['school'], "text"),
					   GetSQLValueString($degreeArray[$maxlevel][0], "text"),
					   GetSQLValueString($degreeArray[$maxlevel][1], "text"),
 					   GetSQLValueString($maxlevel, "text"),
 					   GetSQLValueString($degreeArray[$maxlevel][2], "text"),
					   GetSQLValueString($_POST['contact'], "text"),
					   GetSQLValueString($_POST['contact_ph'], "text"),
					   GetSQLValueString($news_pic_title, "text"),					   
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($_POST['date'], "date"),					   
                       GetSQLValueString($Ticket, "text"),
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
			 		   GetSQLValueString($degreeArray[$maxlevel-3][2], "text"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());
   
   require_once('PHPMailer/class.phpmailer.php');
   $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->SMTPAuth = true; // turn on SMTP authentication
	  $mail->Username = $mailUsername;
      $mail->Password = $mailPassword;
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
      
	  
      $body="親愛的".$_POST['uname']."您好： <br />感謝您報名本次測驗，請再次確認您所填寫的個人資料是否正確，上傳的大頭照是否符合規定，以免影響應考權益，謝謝。<br />
	  如有任何問題歡迎與我們聯絡。";
      $mail->Body = $body;//信件內容(html版，就是可以有html標籤的如粗體、斜體之類)
      $mail->AltBody = $body; //信件內容(純文字版)
/*
      if(!$mail->Send()){
       echo "寄信發生錯誤：" . $mail->ErrorInfo;//如果有錯誤會印出原因
        }
       else{ 
       echo "寄信成功";
           }	   
*/

  $insertGoTo = "examOut.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}

mysql_select_db($database_conn_web, $conn_web);
$query_web_new = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);
$totalRows_web_new = mysql_num_rows($web_new);

mysql_select_db($database_conn_web, $conn_web);
$query_web_member = sprintf("SELECT * FROM member WHERE username = %s", GetSQLValueString($colname_web_member, "text"));
$web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_member);
$totalRows_web_member = mysql_num_rows($web_member);

$todayyear=$row_web_new['times'].substr(($row_web_new['endday']),0,4);
mysql_select_db($database_conn_web, $conn_web);
$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND id LIKE %s ORDER BY DATE DESC", GetSQLValueString($colname_web_member, "text"),
GetSQLValueString("%" . $todayyear . "%", "text"));
$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
$row_web_examinee = mysql_fetch_assoc($web_examinee);
$totalRows_web_examinee = mysql_num_rows($web_examinee);

mysql_select_db($database_conn_web, $conn_web);
$query_web_examinee2 = sprintf("SELECT * FROM examinee WHERE username = %s ORDER BY DATE DESC", GetSQLValueString($colname_web_member, "text"));
$web_examinee2 = mysql_query($query_web_examinee2, $conn_web) or die(mysql_error());
$row_web_examinee2 = mysql_fetch_assoc($web_examinee2);
$totalRows_web_examinee2 = mysql_num_rows($web_examinee2);

mysql_select_db($database_conn_web, $conn_web);
$query_web_examineeN = sprintf("SELECT * FROM examinee WHERE id LIKE %s AND apply_mk=1 AND Qualify=1 ORDER BY id DESC", GetSQLValueString("%" ."N". $todayyear . "%", "text"));
$web_examineeN = mysql_query($query_web_examineeN, $conn_web) or die(mysql_error());
$row_web_examineeN = mysql_fetch_assoc($web_examineeN);
$totalRows_web_examineeN = mysql_num_rows($web_examineeN);

mysql_select_db($database_conn_web, $conn_web);
$query_web_examineeC = sprintf("SELECT * FROM examinee WHERE id LIKE %s AND apply_mk=1 AND Qualify=1 ORDER BY id DESC", GetSQLValueString("%" ."C". $todayyear . "%", "text"));
$web_examineeC = mysql_query($query_web_examineeC, $conn_web) or die(mysql_error());
$row_web_examineeC = mysql_fetch_assoc($web_examineeC);
$totalRows_web_examineeC = mysql_num_rows($web_examineeC);

mysql_select_db($database_conn_web, $conn_web);
$query_web_examineeS = sprintf("SELECT * FROM examinee WHERE id LIKE %s AND apply_mk=1 AND Qualify=1 ORDER BY id DESC", GetSQLValueString("%" ."S". $todayyear . "%", "text"));
$web_examineeS = mysql_query($query_web_examineeS, $conn_web) or die(mysql_error());
$row_web_examineeS = mysql_fetch_assoc($web_examineeS);
$totalRows_web_examineeS = mysql_num_rows($web_examineeS);

mysql_select_db($database_conn_web, $conn_web);
$query_web_examineeE = sprintf("SELECT * FROM examinee WHERE id LIKE %s AND apply_mk=1 AND Qualify=1 ORDER BY id DESC", GetSQLValueString("%" ."E". $todayyear . "%", "text"));
$web_examineeE = mysql_query($query_web_examineeE, $conn_web) or die(mysql_error());
$row_web_examineeE = mysql_fetch_assoc($web_examineeE);
$totalRows_web_examineeE = mysql_num_rows($web_examineeE);

$oln=$totalRows_web_examineeN;//substr($row_web_examineeN['id'],6,4);
$olc=$totalRows_web_examineeC;//substr($row_web_examineeC['id'],6,4);
$ols=$totalRows_web_examineeS;//substr($row_web_examineeS['id'],6,4);
$ole=$totalRows_web_examineeE;//substr($row_web_examineeE['id'],6,4);

?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>報名考試</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="報名考試" />
<meta name="keywords" content="報名考試" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script language=javascript src="address.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<!--引入郵遞區號.js檔案、驗證.js檔-->
  
<script>
	$.validator.setDefaults({
		submitHandler: function() {
			//alert("submitted!");
			//$('#signupForm').submit(function(){
			$(this).ajaxSubmit({
				type:"post",
				url:"examAdd1.php",
				beforeSubmit:showRequest,
				success:showResponse
			});
			return false; //此處必須返回false，阻止常規的form提交
		//});
		}
	});
	
	
	//驗證
	$().ready(function() {
		// validate the comment form when it is submitted
		$("#commentForm").validate();

		// validate signup form on keyup and submit
		$("#form3").validate({
			rules: {
				email: "required",
				phone: "required",
				
				Student_ID: {
					required: true,
					minlength: 4
				},
				Department: {
					required: true,
					minlength: 4
				},
				agree: "required"
			},
			//錯誤訊息
			messages: {
				Student_ID: {
					required: "請檢查學號欄位",
					minlength: "學號輸入請勿少於4個字元"
				},
				Department: {
					required: "請檢查科系欄位",
					minlength: "科系輸入請勿少於4個字元"
				},
				email:"請檢查email欄位",
					
				phone: "請檢查電話欄位",
				
			}
		});	
	});

	function ShowAlert(){
		alert("本年度暫不開放代理代課教師報名");
		
	}
	
	</script>


</head>

<body background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1">
  </div>

  <div id="exam" align="center">
  <? if(strtotime($row_web_new['startday']) <= strtotime(date('Y-m-d')) && strtotime(date('Y-m-d')) <= strtotime($row_web_new['endday'])){?>
  <? if(($row_web_examinee['username'] != $row_web_member['username']) or  strtotime(substr(($row_web_examinee['date']),0,10)) < (strtotime($row_web_new['startday']))){?>
  
    <form id="form3" name="form3" method="post" enctype="multipart/form-data" action="<?php echo $editFormAction; ?>" >
      <table width="540" border="0" cellspacing="0" cellpadding="0" >
        <tr>
          <td width="25" align="left"><img src="images/board03.gif" /></td>
          <td width="505" align="left" background="images/board04.gif">&nbsp; <span class="font_black">親愛的考生[</span><span class="font_red">&nbsp;<?php echo $row_web_member['username']; ?> &nbsp;</span><span class="font_black">]請在下方確實填寫您的報名資料，每個欄位皆為必填!</span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="540" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="82" height="30" align="right" class="board_add">姓名：</td>
          <td width="458" align="left" class="board_add" colspan="2"><label>
<?php echo $row_web_member['uname']; ?>          
            <input name="uname" type="hidden" id="uname" value="<?php echo $row_web_member['uname']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td width="82" height="30" align="right" class="board_add">英文姓名：</td>
          <td width="458" align="left" class="board_add" colspan="2"><label>
          <?php echo $row_web_member['eng_uname']; ?>
            <input name="eng_uname" type="hidden" id="eng_uname" value="<?php echo $row_web_member['eng_uname']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">E-mail：</td>
          <td align="left" class="board_add" colspan="2"><label>
          <span id="sprytextfield0">          
            <input name="email" type="text" id="email" value="<?php echo $row_web_member['email']; ?>" size="35" />
   			<span class="textfieldRequiredMsg">請輸入mail</span><span class="textfieldMinCharsMsg">請輸入mail</span></span>             
          </label>
          <br />
			<span class="font_black">請勿使用會檔信的yahoo、pchome信箱，以免收不到信。</span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">性別：</td>
          <td align="left" class="board_add" colspan="2"><label>
          <input <?php if (!(strcmp($row_web_member['sex'],"男"))) {echo "checked=\"checked\"";} ?> name="sex" type="radio" id="radio" value="男" checked="checked" />
          男
          <input <?php if (!(strcmp($row_web_member['sex'],"女"))) {echo "checked=\"checked\"";} ?> type="radio" name="sex" id="radio2" value="女" />
          女</label>
          
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">生日：</td>
          <td align="left" class="board_add" colspan="2"><label>
          <span id="sprytextfield4">
            <input name="birthday" type="text" id="birthday" value="<?php echo $row_web_member['birthday']; ?>" />
          格式為：YYYY-MM-DD
   			<span class="textfieldRequiredMsg">請輸入生日</span><span class="textfieldMinCharsMsg">請輸入生日</span></span>        
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">電話：</td>
          <td align="left" class="board_add" colspan="2"><label>
          <span id="sprytextfield5">
            <input name="phone" type="text" id="phone" value="<?php echo $row_web_member['phone']; ?>" />
   <span class="textfieldRequiredMsg">請輸入電話</span><span class="textfieldMinCharsMsg">請輸入電話</span></span>            
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">身分證字號：</td>
          <td align="left" class="board_add" colspan="2"><label>
            <?php echo $row_web_member['uid']; ?><input name="per_id" type="hidden" id="per_id" value="<?php echo $row_web_member['uid']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">郵遞區號：</td>
          <td align="left" class="board_add" colspan="2">
                          <select name="Area" onChange="citychange(this.form)">
                            <option value="基隆市" <?php if (!(strcmp("基隆市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>基隆市</option>
                            <option value="臺北市"  <?php if (!(strcmp("臺北市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>臺北市</option>
                            <option value="新北市" <?php if (!(strcmp("新北市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>新北市</option>
                            <option value="桃園縣" <?php if (!(strcmp("桃園縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>桃園縣</option>
                            <option value="新竹市" <?php if (!(strcmp("新竹市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>新竹市</option>
                            <option value="新竹縣" <?php if (!(strcmp("新竹縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>新竹縣</option>
                            <option value="苗栗縣" <?php if (!(strcmp("苗栗縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>苗栗縣</option>
                            <option value="臺中市" <?php if (!(strcmp("臺中市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>臺中市</option>
                            <option value="彰化縣" <?php if (!(strcmp("彰化縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>彰化縣</option>
                            <option value="南投縣" <?php if (!(strcmp("南投縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>南投縣</option>
                            <option value="雲林縣" <?php if (!(strcmp("雲林縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>雲林縣</option>
                            <option value="嘉義市" <?php if (!(strcmp("嘉義市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>嘉義市</option>
                            <option value="嘉義縣" <?php if (!(strcmp("嘉義縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>嘉義縣</option>
                            <option value="臺南市" <?php if (!(strcmp("臺南市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>臺南市</option>
                            <option value="高雄市" <?php if (!(strcmp("高雄市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>高雄市</option>
                            <option value="屏東縣" <?php if (!(strcmp("屏東縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>屏東縣</option>
                            <option value="臺東縣" <?php if (!(strcmp("臺東縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>臺東縣</option>
                            <option value="花蓮縣" <?php if (!(strcmp("花蓮縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>花蓮縣</option>
                            <option value="宜蘭縣" <?php if (!(strcmp("宜蘭縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>宜蘭縣</option>
                            <option value="澎湖縣" <?php if (!(strcmp("澎湖縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>澎湖縣</option>
                            <option value="金門縣" <?php if (!(strcmp("金門縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>金門縣</option>
                            <option value="連江縣" <?php if (!(strcmp("連江縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>連江縣</option>
                          </select>
                          <select onChange="areachange(this.form)" name="cityarea">
                            <option value="<?php echo $row_web_member['cityarea']; ?>" selected="selected"><?php echo $row_web_member['cityarea']; ?></option>
                          </select>
                          <input type="hidden" value="100" name="Mcode" />
                          <input name="cuszip" value="<?php echo $row_web_member['cuszip']; ?>" size="5" maxlength="5" readonly />
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">詳細地址：</td>
          <td align="left" class="board_add" colspan="2"><span class="bs">
            <span id="sprytextfield3">
            <label for="cusadr"></label>
            <input type="text" name="cusadr" id="cusadr" value="<?php echo $row_web_member['cusadr']; ?>" size="60" />
            <span class="textfieldRequiredMsg">請輸入地址</span><span class="textfieldMinCharsMsg">請輸入地址</span></span></span></td>
        </tr>
        <tr>
          <td height="30" align="right" colspan="3" class="board_add">=========================================================================================</td>   
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">教師證號碼：</td>
          <td align="left" class="board_add" colspan="2">
           <label>
           <span id="sprytextfield6">          
            <input name="certificate" type="text" id="certificate" onclick="ShowAlert()" value="<?php echo $row_web_examinee2['certificate']; ?>" />
   <span class="textfieldRequiredMsg">請輸入教師證號碼</span><span class="textfieldMinCharsMsg">請輸入教師證號碼</span></span>            
          </label>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">報名科目：</td>
          <td align="left" class="board_add" colspan="2">
         
         <!--   <input name="Subjects[]" type="checkbox" id="Subjects[]" value="1"  />
           <label>國語 </label>
          <input type="checkbox" name="Subjects[]" id="Subjects[]" value="2" />
         <label> 數學 </label>
          <input type="checkbox" name="Subjects[]" id="Subjects[]" value="3" />
          <label>社會 </label>  -->
          <!--<input type="checkbox" name="Subjects" id="Subjects" value="4" checked="checked"/> -->
          <label>自然領域
          </label>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">測驗考場：</td>
          <td align="left" class="board_add" colspan="2">
          <label>
            <input name="exarea" type="radio" id="radio" value="Northern" checked="checked" />
          臺北(國立臺灣大學) 尚餘名額：<?php echo (150-$oln); ?>人<?php if((150-$oln)==0){echo "<font color='#FF0000'>(已額滿)</font>";} ?> <br /></label>
          <label>
          <input type="radio" name="exarea" id="radio2" value="Central" />
          臺中(國立臺中教育大學) 尚餘名額：<?php echo (150-$olc); ?>人<?php if((150-$olc)==0){echo "<font color='#FF0000'>(已額滿)</font>";} ?> <br /></label>
          <label>
          <input type="radio" name="exarea" id="radio3" value="Southern" />
          高雄(高雄市私立三信家事商業職業學校) 尚餘名額：<?php echo (100-$ols); ?>人 <?php if((100-$ols)==0){echo "<font color='#FF0000'>(已額滿)</font>";} ?> <br/></label>
          <label>
          <input type="radio" name="exarea" id="radio4" value="Eastern" />
          花蓮(國立花蓮高級商業職業學校) 尚餘名額：<?php echo (100-$ole); ?>人<?php if((100-$ole)==0){echo "<font color='#FF0000'>(已額滿)</font>";} ?> </label>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">任職學校：</td>
          <td align="left" class="board_add" colspan="2">
          <label>
           <span id="sprytextfield7">           
            <input name="school" type="text" id="school" value="<?php echo $row_web_examinee2['school']; ?>" />
   			<span class="textfieldRequiredMsg">請輸入(縣市)學校名稱</span><span class="textfieldMinCharsMsg">請輸入(縣市)學校名稱</span></span>              
          </label>
         
          </td>
        </tr>
    <!--    <tr>
          <td height="30" align="right" class="board_add">年級：</td>
          <td align="left" class="board_add">
          <label>
           <input <?php //if (!(strcmp($row_web_examinee2['Grade'],"1"))) {echo "checked=\"checked\"";} ?> name="Grade" type="radio" id="radio1" value="1" checked="checked" />
          大一
          <input <?php //if (!(strcmp($row_web_examinee2['Grade'],"2"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio2" value="2" />
          大二
          <input <?php //if (!(strcmp($row_web_examinee2['Grade'],"3"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio3" value="3" />
          大三
          <input <?php //if (!(strcmp($row_web_examinee2['Grade'],"4"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio4" value="4" />
          大四
          <input <?php //if (!(strcmp($row_web_examinee2['Grade'],"5"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio5" value="5" />
          大五(含)以上
          <input <?php //if (!(strcmp($row_web_examinee2['Grade'],"6"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio6" value="6" />
          研究所
          </label>
          </td>
        </tr>  -->

        <tr>
          <td height="30" align="center" class="board_add">學歷</td>
          <td align="center" class="board_add">學校名稱</td>
          <td align="center" class="board_add">就讀科系</td>
        </tr>
        <tr>
          <td align="center" class="board_add"><label id="Edu_level" for="1">專科</label></td>
          <td height="30" align="right" class="board_add">
          	(<input name="eduRec1" type="radio" id="radio" value="0" checked="checked" />在學中
			<input name="eduRec1" type="radio" id="radio" value="1" />畢業)
          <label>
            <span>
            <input type="text" name="Other2" id="Other2"  value="<?php echo $row_web_examinee2['Other2']; ?>" />
          <span class="textfieldRequiredMsg">請輸入學校</span><span class="textfieldMinCharsMsg">請輸學校</span></span></label>
          </td>
          <td align="left" class="board_add">
          
          <span>          
          <input type="text" name="Other2_dept" id="Other2_dept"  value="<?php echo $row_web_examinee2['Other2_dept']; ?>"/>
          <span class="textfieldRequiredMsg">請輸入科系</span><span class="textfieldMinCharsMsg">請輸入科系</span></span>
          </td>
        </tr>

        <tr>
          <td align="center" class="board_add"><label id="Edu_level" for="2">學士</label></td>
          <td height="30" align="right" class="board_add">
          	(<input name="eduRec2" type="radio" id="radio" value="0" checked="checked" />在學中
			<input name="eduRec2" type="radio" id="radio" value="1" />畢業)
          <label>
            <span id="sprytextfield1">
            <input type="text" name="Highest" id="Highest"  value="<?php echo $row_web_examinee2['Highest']; ?>" />
          <span class="textfieldRequiredMsg">請輸入學校</span><span class="textfieldMinCharsMsg">請輸學校</span></span></label>
          </td>
          <td align="left" class="board_add">
          
          <span id="sprytextfield2">          
          <input type="text" name="Department" id="Department"  value="<?php echo $row_web_examinee2['Department']; ?>"/>
          <span class="textfieldRequiredMsg">請輸入科系</span><span class="textfieldMinCharsMsg">請輸入科系</span></span>
          </td>
        </tr>
        <tr>
          <td  align="center" class="board_add"><label id="Edu_level" for="3">碩士</label></td>
          <td height="30" align="right" class="board_add">
			(<input name="eduRec3" type="radio" id="radio" value="0" checked="checked" />在學中
			<input name="eduRec3" type="radio" id="radio" value="1" />畢業)
          <label>
            <span>
            <input type="text" name="Sec_highest" id="Sec_highest"  value="<?php echo $row_web_examinee2['Sec_highest']; ?>" />
          <span class="textfieldRequiredMsg">請輸入學校</span><span class="textfieldMinCharsMsg">請輸學校</span></span></label>
          </td>
          <td align="left" class="board_add">
          
          <span>          
          <input type="text" name="Sec_dept" id="Sec_dept"  value="<?php echo $row_web_examinee2['Sec_dept']; ?>"/>
          <span class="textfieldRequiredMsg">請輸入科系</span><span class="textfieldMinCharsMsg">請輸入科系</span></span>
          </td>
        </tr>
        <tr>
          <td  align="center" class="board_add"> <label id="Edu_level" for="4">博士</label></td>
          <td height="30" align="right" class="board_add">
          	(<input name="eduRec4" type="radio" id="radio" value="0" checked="checked" />在學中
			<input name="eduRec4" type="radio" id="radio" value="1" />畢業)
          <label>
            <span>
            <input type="text" name="Other1" id="Other1"  value="<?php echo $row_web_examinee2['Other1']; ?>" />
          <span class="textfieldRequiredMsg">請輸入學校</span><span class="textfieldMinCharsMsg">請輸學校</span></span></label>
          </td>
          <td align="left" class="board_add">
          
          <span>          
          <input type="text" name="Other1_dept" id="Other1_dept"  value="<?php echo $row_web_examinee2['Other1_dept']; ?>"/>
          <span class="textfieldRequiredMsg">請輸入科系</span><span class="textfieldMinCharsMsg">請輸入科系</span></span>
          </td>
        </tr>
        
        <tr>
          <td height="30" align="right" class="board_add">緊急聯絡人：</td>
          <td align="left" class="board_add" colspan="2">
          <label>
           <span id="sprytextfield8">            
            <input name="contact" type="text" id="contact" value="<?php echo $row_web_examinee2['contact']; ?>" />
<span class="textfieldRequiredMsg">請輸入聯絡人</span><span class="textfieldMinCharsMsg">請輸聯絡人</span></span>            
          </label>
         
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">緊急聯絡人<br />電話：</td>
          <td align="left" class="board_add" colspan="2">
          <label>
           <span id="sprytextfield9">          
            <input name="contact_ph" type="text" id="contact_ph" value="<?php echo $row_web_examinee2['contact_ph']; ?>" />
<span class="textfieldRequiredMsg">請輸入聯絡電話</span><span class="textfieldMinCharsMsg">請輸聯絡電話</span></span>            
          </label>
         
          </td>
        </tr>
        <tr>
        <td height="30" align="right" class="board_add">大頭照圖片：</td>
        <td align="left" class="board_add" colspan="2"><span class="table_lineheight">
          <?php /*START_PHP_SIRFCIT*/ if ($row_web_examinee2['pic_name']!=""){ ?>
          <img src="images/examinee/<?php echo $row_web_examinee2['pic_name']; ?>" alt="" name="pic" width="70" id="pic" />
          <?php } /*END_PHP_SIRFCIT*/ ?>
          <input name="oldPic" type="hidden" id="oldPic" value="<?php echo $row_web_examinee2['pic_name']; ?>" />
          <input name="oldPictitle" type="hidden" id="oldPic" value="<?php echo $row_web_examinee2['pic_title']; ?>" />          
          <?php echo $row_web_examinee2['pic_title']; ?><br />
          <label>
                     <span id="sprytextfield10"> 
            <input type="file" name="news_pic" id="news_pic" />
<span class="textfieldRequiredMsg">請選擇照片</span><span class="textfieldMinCharsMsg">請選擇照片</span></span>               
          </label>
          <br />
          <span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
       </td>
        
        <tr>
          <td height="40" colspan="2" align="center"><label>
            <input type="submit" name="button" id="button" value="報名資料儲存" />  </label>
            <label>
            <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
            <input name="username" type="hidden" id="username" value="<?php echo $row_web_member['username']; ?>" />
            <input name="date" type="hidden" id="date" value="<?php echo date("Y-m-d H:i:s");?>" />
            <input name="times" type="hidden" id="times" value="<?php echo $row_web_new['times']; ?>" />
            <input name="endday" type="hidden" id="endday" value="<?php echo $row_web_new['endday']; ?>" />
            
          </label></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form3" />
    </form>
     <?php
	 
  }elseif($row_web_examinee['username'] == $row_web_member['username'] && $row_web_examinee['apply_mk']=='1'){
	  ?>
<table width="555" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2">您已經完成報名了，請點選 <a href="progress.php"><img src="images/progress_check.png"  /></a> 查看審核情況。</td>
      </tr>
</table>      
<!-- <script>
   alert("您已經完成報名了，請點選[報名進度查詢]查看審核情況。"); 
 document.location.href=".";
 </script>
--> 	 
<?php	 
  }else{//否則顯示另依個區塊內容?>
  	<table width="555" border="0" cellspacing="0" cellpadding="0">
  	<tr>
  	<td height="80" align="center" class="font_red2">您已經填寫報名資料，請點選<a href="examOut.php"><img src="images/sign.png"  /></a>送出報名資料。</td>
  	</tr>
  	</table>
<?php     	
	//header("Location: examOut.php");
	//exit();
  }?>
    
<?PHP }else{?><table width="555" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2">目前尚未開放報名!</td>
      </tr>
  </table><?PHP }?>
    
  </div>
  <div id="main4"></div>


<?php include("footer.php"); ?>
</div>
<script type="text/javascript">
var sprytextfield0 = new Spry.Widget.ValidationTextField("sprytextfield0", "none", {minChars:5, validateOn:["blur", "change"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:4, validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:2, validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {minChars:6, validateOn:["blur", "change"]});
/*******dios add**********/
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {minChars:8, validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {minChars:9, validateOn:["blur", "change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {minChars:5, validateOn:["blur", "change"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {minChars:4, validateOn:["blur", "change"]});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "none", {minChars:2, validateOn:["blur", "change"]});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "none", {minChars:9, validateOn:["blur", "change"]});
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "none", {minChars:3, validateOn:["blur", "change"]});
</script>
</body>
</html>
<?php
mysql_free_result($web_member);
//mysql_free_result($web_search);
mysql_free_result($web_examinee);
mysql_free_result($web_new);
mysql_free_result($web_examineeE);
mysql_free_result($web_examineeC);
mysql_free_result($web_examineeN);
mysql_free_result($web_examineeS);
?>
