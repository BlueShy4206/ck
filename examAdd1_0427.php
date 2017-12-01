<?
require_once "PEAR183/HTML/QuickForm.php";
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
define("no_error", "examOut1.php");
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
		header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_PIC_SIZE && MAX_PIC_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$attach = $_POST['username'];//$_ext_[0];
		$_ext_ = strtolower($_ext_[count($_ext_)-1]);
		$news_pic_title=$_file_['name'];	
		$pic_type = $_file_['type'];
		
		//取原圖的大小進行比例處理
		switch ($pic_type){
			case "image/jpeg":
				$src2 = imagecreatefromjpeg($_FILES['news_pic']['tmp_name']);
				break;
			case "image/png":
				$src2 = imagecreatefrompng($_FILES['news_pic']['tmp_name']);
				break;
			case "image/gif":
				$src2 = imagecreatefromgif($_FILES['news_pic']['tmp_name']);
				break;
		}
		$src_w2 = imagesx($src2);
		$src_h2 = imagesy($src2);
		if($src_w2 > 100){
			$thumb_w2 = intval($src_h2 / $src_w2 * 100);
			$thumb_h2 = intval($src_h2 / $src_w2 * 130);
		}else{
			$thumb_h2 = intval($src_w2 / $src_h2 * 130);
			$thumb_w2 = intval($src_w2 / $src_h2 * 100);
		}
		
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
			//進行縮圖
			$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
			imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
			switch ($pic_type){
				case "image/jpeg":
					$resultOK= imagejpeg($thumb2, "images/smallPic/".$newPicname);
					break;
				case "image/png":
					$resultOK= imagepng($thumb2, "images/smallPic/".$newPicname);
					break;
				case "image/gif":
					$resultOK= imagegif($thumb2, "images/smallPic/".$newPicname);
					break;
			}
			
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
// echo "college1=".$_POST['edu1'][0]."<br>";
// echo "dept1.=".$_POST['edu1'][1]."<br>";
// 	echo "college2=".$_POST['edu2'][0]."<br>";
// 	echo "dept2.=".$_POST['edu2'][1]."<br>";
// 	echo "college3=".$_POST['edu3'][0]."<br>";
// 	echo "dept3.=".$_POST['edu3'][1]."<br>";
// 	echo "college4=".$_POST['edu4'][0]."<br>";
// 	echo "dept4.=".$_POST['edu4'][1]."<br>";
// 	die();

	$Ticket=substr(($_POST['exarea']),0,1).$_POST['times'].substr(($_POST['endday']),0,4);
	mysql_select_db($database_conn_web, $conn_web);
	$query_web_search = sprintf("SELECT id FROM examinee WHERE id LIKE %s AND Qualify=1 ORDER BY id DESC", GetSQLValueString("%" . $Ticket . "%", "text"));
	$web_search = mysql_query($query_web_search, $conn_web) or die(mysql_error());
	$row_web_search = mysql_fetch_assoc($web_search);
	$totalRows_web_search = mysql_num_rows($web_search);
	
	$query_web_search_last = sprintf("SELECT id FROM examinee WHERE id LIKE %s AND Qualify=0 ORDER BY id DESC", GetSQLValueString("%" . $Ticket . "%", "text"));
	$web_search_last = mysql_query($query_web_search_last, $conn_web) or die(mysql_error());
	$row_web_search_last = mysql_fetch_assoc($web_search_last);
	$totalRows_web_search_last = mysql_num_rows($web_search_last);

	$query_web_allguide2 = sprintf("SELECT * FROM allguide Where up_no='EA' AND nm= %s",GetSQLValueString($_POST['exarea'], "text"));
	$web_allguide2 = mysql_query($query_web_allguide2, $conn_web) or die(mysql_error());
	$row_web_allguide2 = mysql_fetch_assoc($web_allguide2);
	//新增寫入考試日期 examinee/exarea_date, add by coway 2017.3.22
	$exam_date = $row_web_allguide2['data1'];
	
	if($totalRows_web_search == 0){
		$number=1;
		$Ticket=$Ticket.sprintf("%04d", $number);
	}else{

		if($totalRows_web_search_last == 0){
			$number=substr(($row_web_search['id']),6,4);
		}else{
			$number=substr(($row_web_search_last['id']),6,4);
		}
		$number=$number+1;
		$Ticket=$Ticket.sprintf("%04d", $number);
	}
	//add判斷身份一和二才為必填(任職學校), by coway 2016.10.20
// 	if ((isset($_POST["id"])) && ($_POST["id"] != 3) && (empty($_POST["school"]))){
// // 		echo "請輸入任職學校";
// 		echo '<script> var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {minChars:4, validateOn:["blur", "change"]});</script>';
// 		echo '<script>alert("請輸入任職學校!");</script>';
// // 		echo '<script language=Javascript>window.location.href="examAdd1.php"</script>';
// 		//echo 'die()1';		
// // 		break;
// // 		die();
// 		$updateGoTo = "examAdd1.php?certificate=".$_REQUEST['certificate']."&Other2=".$_REQUEST['Other2']."&Other2_college=".$_REQUEST['Other2_college']."&Other2_dept=".$_REQUEST['Other2_dept'];
// 		$updateGoTo .= "&Highest=".$_REQUEST['Highest']."&High_college=".$_REQUEST['High_college']."&Department=".$_REQUEST['Department'];
// 		$updateGoTo .= "&Sec_highest=".$_REQUEST['Sec_highest']."&Sec_college=".$_REQUEST['Sec_college']."&Sec_dept=".$_REQUEST['Sec_dept'];
// 		$updateGoTo .= "&Other1=".$_REQUEST['Other1']."&Other1_college=".$_REQUEST['Other1_college']."&Other1_dept=".$_REQUEST['Other1_dept'];
// 		$updateGoTo .= "&contact=".$_REQUEST['contact']."&contact_ph=".$_REQUEST['contact_ph'];
// 		if (isset($_SERVER['QUERY_STRING'])) {
// 			$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
// 			$updateGoTo .= $_SERVER['QUERY_STRING'];
// 		}
// 		echo '<script language=Javascript>window.location.href="'.$updateGoTo.'"</script>';
// 		die();
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript">

	
// 					var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {minChars:4, validateOn:["blur", "change"]});

// 					alert('請輸入任職學校');
// 	 				window.go(-2);
// 	 				alert('123');
// 	 				break;
// 	alert($_POST["id"]);
// 	window.location ="examAdd1.php";
// 	this.stop;
// 	break;
// 	for (var i=0; i<form.id.length; i++)
// 	{
// 		if (form.id[i].checked)
// 		{
// 			var idVal = form.id[i].value;
// 			alert(idVal);
// 			if(idVal != 3){	
// 				// 		    	  school.removeAttr("disabled");	
// // 				var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {minChars:4, validateOn:["blur", "change"]});
// 				window.go(-2);
// 				alert('123');
// 				break;
// 			}
				
// 		}
// 	}
	</script>
	
	<?php 
// 	die();
// 	}
	
	if(substr(($_POST['exarea']),0,1) == $row_web_allguide2['no']){
		if($totalRows_web_search >= (int)$row_web_allguide2['data3']){ 
			if($totalRows_web_search_last >= (int)$row_web_allguide2['data4']){
		?>
			    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			    <script type="text/javascript">
				alert("報名人數已滿，請選擇其他場次。");
				window.history.back();
				</script>;
		<?php	
				die();
			}else{
				$qualify=0;
			}
		}else $qualify=1;
	
	}else{
	?>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <script type="text/javascript">
		alert("報名場次有誤，請重新報名。");
		window.history.back();
		</script>;	
	<?php	

	}
	echo "Highest=".$_POST['Highest']."<br>";
	echo "Department=".$_POST['Department']."<br>";
	echo "eduRec2=".$_POST['eduRec2']."<br>";
	echo "High_college=".$_POST['High_college']."<br>";
// 	echo "ins_High_college=".$_POST['Other1_college']."<br>";
	echo "other_dept1=".$_POST['Other2_dept']."<br>";
// 	echo "college1=".$_POST['edu1'][0]."<br>";
// 	echo "dept1.=".$_POST['edu1'][1]."<br>";
	echo "college2=".$_POST['edu2'][0]."<br>";
	echo "dept2.=".$_POST['edu2'][1]."<br>";
	echo "college3=".$_POST['edu3'][0]."<br>";
	echo "dept3.=".$_POST['edu3'][1]."<br>";
	echo "college4=".$_POST['edu4'][0]."<br>";
	echo "dept4.=".$_POST['edu4'][1]."<br>";
// 	die();
	//若其他學院/系所有填寫則以此為主,add by coway 2017.4.11
	$_POST['Other2_college'] = (trim($_POST['Other2_college_other']) != "") ? $_POST['Other2_college_other'] : $_POST['Other2_college'];
	$_POST['Other2_dept'] = (trim($_POST['Other2_dept_other']) != "") ? $_POST['Other2_dept_other'] : $_POST['Other2_dept'];
	$_POST['High_college'] = (trim($_POST['High_college_other']) != "") ? $_POST['High_college_other'] : $_POST['High_college'];
	$_POST['Department'] = (trim($_POST['Department_other']) != "") ? $_POST['Department_other'] : $_POST['Department'];
	$_POST['Sec_college'] = (trim($_POST['Sec_college_other']) != "") ? $_POST['Sec_college_other'] : $_POST['Sec_college'];
	$_POST['Sec_dept'] = (trim($_POST['Sec_dept_other']) != "") ? $_POST['Sec_dept_other'] : $_POST['Sec_dept'];
	$_POST['Other1_college'] = (trim($_POST['Other1_college_other']) != "") ? $_POST['Other1_college_other'] : $_POST['Other1_college'];
	$_POST['Other1_dept'] = (trim($_POST['Other1_dept_other']) != "") ? $_POST['Other1_dept_other'] : $_POST['Other1_dept'];
	$maxlevel=0;
	$degreeArray = array('1'=>array($_POST['Other2'],$_POST['Other2_dept'],$_POST['eduRec1'],$_POST['Other2_college']),
			'2'=>array($_POST['Highest'],$_POST['Department'],$_POST['eduRec2'],$_POST['High_college']),
			'3'=>array($_POST['Sec_highest'],$_POST['Sec_dept'],$_POST['eduRec3'],$_POST['Sec_college']),
			'4'=>array($_POST['Other1'],$_POST['Other1_dept'],$_POST['eduRec4'],$_POST['Other1_college'])
			
	);
	IF($_POST['Other2']!=""){//專科
		$maxlevel=1;
	}
	IF($_POST['Highest']!=""){//學士
		$maxlevel=2;
	}
	IF($_POST['Sec_highest']!=""){//碩士
		$maxlevel=3;
	}
	IF($_POST['Other1']!=""){//博士
		$maxlevel=4;
	}

	echo "maxlevel=".$maxlevel."<br>";
	echo "Department=".$degreeArray[2][1]."<br>";
	echo "Department3=".$degreeArray[3][1]."<br>";
	echo "Department4=".$degreeArray[4][1]."<br>";
// 	die();

	//取得報考資格流水號
	$query_web_cert = sprintf("SELECT IFNULL(max(cert_id),0)+1 AS cert_id FROM `examinee` WHERE examyear_id=%s AND cert_no=%s ",GetSQLValueString($_POST['examyear_id'], "text"), GetSQLValueString($_POST['id'], "text"));
	$web_cert = mysql_query($query_web_cert, $conn_web) or die(mysql_error());
	$row_web_cert = mysql_fetch_assoc($web_cert);
// 		echo "cert_no=".$_POST['id']."<br>";
// 		echo "examyear_id=".$_POST['examyear_id']."<br>";
// 		echo "cert_id=".$row_web_cert['cert_id']."<br>";
// 	die();

	
	$insertSQL = sprintf("INSERT INTO examinee (birthday, username, uname, eng_uname ,sex, 
 		email, phone, Area, cityarea, cuszip, cusadr, certificate, per_id, category, 
 		exarea, exarea_date, school, Highest, Department, Edu_level, Edu_MK, contact, contact_ph,
 		pic_title, pic_name, `date`, id, Sec_highest, Sec_dept, Edu_level2, Edu_MK2,
 		Other1, Other1_dept, Edu_level3, Edu_MK3, Other2, Other2_dept, Edu_level4, Edu_MK4, Qualify, status, cert_no,
		High_college,Sec_college,Other1_college,Other2_college, cert_id,examyear_id) 
 		VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
 		%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
			%s,%s,%s,%s,%s,%s)",
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
					   GetSQLValueString("4", "text"),//category
					   GetSQLValueString($_POST['exarea'], "text"),//exarea
					   GetSQLValueString($exam_date, "text"),//exarea_date,add by coway 2017.3.22
					   GetSQLValueString($_POST['school'], "text"),//school
					   GetSQLValueString($degreeArray[$maxlevel][0], "text"),//Highest
					   GetSQLValueString($degreeArray[$maxlevel][1], "text"),//Department
 					   GetSQLValueString($maxlevel, "text"),
 					   GetSQLValueString($degreeArray[$maxlevel][2], "text"),
					   GetSQLValueString($_POST['contact'], "text"),//contact
					   GetSQLValueString($_POST['contact_ph'], "text"),//contact_ph
					   GetSQLValueString($news_pic_title, "text"),					   
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($_POST['date'], "date"),					   
                       GetSQLValueString($Ticket, "text"),//id
 					   GetSQLValueString($degreeArray[$maxlevel-1][0], "text"),//Sec_highest
					   GetSQLValueString($degreeArray[$maxlevel-1][1], "text"),//Sec_dept
 					   GetSQLValueString($maxlevel-1, "text"),
 					   GetSQLValueString($degreeArray[$maxlevel-1][2], "text"),
			 		   GetSQLValueString($degreeArray[$maxlevel-2][0], "text"),//Other1
			 		   GetSQLValueString($degreeArray[$maxlevel-2][1], "text"),//Other1_dept
			 		   GetSQLValueString($maxlevel-2, "text"),
			 	       GetSQLValueString($degreeArray[$maxlevel-2][2], "text"),
			 		   GetSQLValueString($degreeArray[$maxlevel-3][0], "text"),//Other2
			 		   GetSQLValueString($degreeArray[$maxlevel-3][1], "text"),//Other2_dept
			 		   GetSQLValueString($maxlevel-3, "text"),
			 		   GetSQLValueString($degreeArray[$maxlevel-3][2], "text"),
					   GetSQLValueString($qualify, "text"),//Qualify
					   GetSQLValueString('1', "text"),//status
					   GetSQLValueString($_POST['id'], "text"),//cert_no, add by coway 2016.8.9
					   GetSQLValueString($degreeArray[$maxlevel][3], "text"),//High_college, add by coway 2016.8.18
					   GetSQLValueString($degreeArray[$maxlevel-1][3], "text"),//Sec_college, add by coway 2016.8.18
					   GetSQLValueString($degreeArray[$maxlevel-2][3], "text"),//Other1_college, add by coway 2016.8.18
					   GetSQLValueString($degreeArray[$maxlevel-3][3], "text"),//Other2_college, add by coway 2016.8.18
					   GetSQLValueString($row_web_cert['cert_id'], "text"),//cert_id, add by coway 2016.8.25
					   GetSQLValueString($_POST['examyear_id'], "text")//examyear_id, add by coway 2016.8.25
			);

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

  $insertGoTo = "examOut1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  exit();//
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
$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND status=1 AND id LIKE %s ORDER BY DATE DESC", GetSQLValueString($colname_web_member, "text"),
GetSQLValueString("%" . $todayyear . "%", "text"));
$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
$row_web_examinee = mysql_fetch_assoc($web_examinee);
$totalRows_web_examinee = mysql_num_rows($web_examinee);

mysql_select_db($database_conn_web, $conn_web);
$query_web_examinee2 = sprintf("SELECT * FROM examinee WHERE username = %s AND status=1  ORDER BY DATE DESC", GetSQLValueString($colname_web_member, "text"));
$web_examinee2 = mysql_query($query_web_examinee2, $conn_web) or die(mysql_error());
$row_web_examinee2 = mysql_fetch_assoc($web_examinee2);
$totalRows_web_examinee2 = mysql_num_rows($web_examinee2);

mysql_select_db($database_conn_web, $conn_web);
$query_web_examineeN = sprintf("SELECT * FROM examinee WHERE id LIKE %s AND status=1 AND apply_mk=1 AND Qualify=1 ORDER BY id DESC", GetSQLValueString("%" ."N". $todayyear . "%", "text"));
$web_examineeN = mysql_query($query_web_examineeN, $conn_web) or die(mysql_error());
$row_web_examineeN = mysql_fetch_assoc($web_examineeN);
$totalRows_web_examineeN = mysql_num_rows($web_examineeN);

mysql_select_db($database_conn_web, $conn_web);
$query_web_examineeC = sprintf("SELECT * FROM examinee WHERE id LIKE %s AND status=1 AND apply_mk=1 AND Qualify=1 ORDER BY id DESC", GetSQLValueString("%" ."C". $todayyear . "%", "text"));
$web_examineeC = mysql_query($query_web_examineeC, $conn_web) or die(mysql_error());
$row_web_examineeC = mysql_fetch_assoc($web_examineeC);
$totalRows_web_examineeC = mysql_num_rows($web_examineeC);

mysql_select_db($database_conn_web, $conn_web);
$query_web_examineeS = sprintf("SELECT * FROM examinee WHERE id LIKE %s AND status=1 AND apply_mk=1 AND Qualify=1 ORDER BY id DESC", GetSQLValueString("%" ."S". $todayyear . "%", "text"));
$web_examineeS = mysql_query($query_web_examineeS, $conn_web) or die(mysql_error());
$row_web_examineeS = mysql_fetch_assoc($web_examineeS);
$totalRows_web_examineeS = mysql_num_rows($web_examineeS);

mysql_select_db($database_conn_web, $conn_web);
$query_web_examineeE = sprintf("SELECT * FROM examinee WHERE id LIKE %s AND status=1 AND apply_mk=1 AND Qualify=1 ORDER BY id DESC", GetSQLValueString("%" ."E". $todayyear . "%", "text"));
$web_examineeE = mysql_query($query_web_examineeE, $conn_web) or die(mysql_error());
$row_web_examineeE = mysql_fetch_assoc($web_examineeE);
$totalRows_web_examineeE = mysql_num_rows($web_examineeE);

$oln=$totalRows_web_examineeN;//substr($row_web_examineeN['id'],6,4);
$olc=$totalRows_web_examineeC;//substr($row_web_examineeC['id'],6,4);
$ols=$totalRows_web_examineeS;//substr($row_web_examineeS['id'],6,4);
$ole=$totalRows_web_examineeE;//substr($row_web_examineeE['id'],6,4);

//取得報考資格 add by coway 2016.8.8
mysql_select_db($database_conn_web, $conn_web);
$query_web_allguide = "SELECT * FROM allguide WHERE up_no='IDt'  ";
$web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
// $row_web_allguide = mysql_fetch_assoc($web_allguide);
// $totalRows_web_allguide = mysql_num_rows($web_allguide);
$allguide_lot = array();
$alli=0;
while ($row_web_allguide = mysql_fetch_assoc($web_allguide)){
	$allguide_lot[$alli] = $row_web_allguide;
	$alli++;
}

//查詢備取資料
mysql_select_db($database_conn_web, $conn_web);
$query_examineeN_last = sprintf("SELECT * FROM examinee WHERE id LIKE %s AND apply_mk=1 AND Qualify=0 ORDER BY id DESC", GetSQLValueString("%" ."N". $todayyear . "%", "text"));
$web_examineeN_last = mysql_query($query_examineeN_last, $conn_web) or die(mysql_error());
$row_examineeN_last = mysql_fetch_assoc($web_examineeN_last);
$totalRows_examineeN_last = mysql_num_rows($web_examineeN_last);

mysql_select_db($database_conn_web, $conn_web);
$query_examineeC_last = sprintf("SELECT * FROM examinee WHERE id LIKE %s AND apply_mk=1 AND Qualify=0 ORDER BY id DESC", GetSQLValueString("%" ."C". $todayyear . "%", "text"));
$web_examineeC_last = mysql_query($query_examineeC_last, $conn_web) or die(mysql_error());
$row_examineeC_last = mysql_fetch_assoc($web_examineeC_last);
$totalRows_examineeC_last = mysql_num_rows($web_examineeC_last);

mysql_select_db($database_conn_web, $conn_web);
$query_examineeS_last = sprintf("SELECT * FROM examinee WHERE id LIKE %s AND apply_mk=1 AND Qualify=0 ORDER BY id DESC", GetSQLValueString("%" ."S". $todayyear . "%", "text"));
$web_examineeS_last = mysql_query($query_examineeS_last, $conn_web) or die(mysql_error());
$row_examineeS_last = mysql_fetch_assoc($web_examineeS_last);
$totalRows_examineeS_last = mysql_num_rows($web_examineeS_last);

mysql_select_db($database_conn_web, $conn_web);
$query_examineeE_last = sprintf("SELECT * FROM examinee WHERE id LIKE %s AND apply_mk=1 AND Qualify=0 ORDER BY id DESC", GetSQLValueString("%" ."E". $todayyear . "%", "text"));
$web_examineeE_last = mysql_query($query_examineeE_last, $conn_web) or die(mysql_error());
$row_examineeE_last = mysql_fetch_assoc($web_examineeE_last);
$totalRows_examineeE_last = mysql_num_rows($web_examineeE_last);

$overn=$totalRows_examineeN_last;
$overc=$totalRows_examineeC_last;
$overs=$totalRows_examineeS_last;
$overe=$totalRows_examineeE_last;

$form1 = new HTML_QuickForm('examAdd1','post','');
$form2 = new HTML_QuickForm('examAdd2','post','');
$form3 = new HTML_QuickForm('examAdd3','post','');
$form4 = new HTML_QuickForm('examAdd4','post','');
$init='';
$select1[$init]='請 選 擇-學 院';
$select2[$init][$init]='請 選 擇-系 所';
$select3[$init]='請 選 擇-學 院';
$select4[$init][$init]='請 選 擇-系 所';

//查詢各考場正/備取人數
mysql_select_db($database_conn_web, $conn_web);
//$query_web_allguide = sprintf("SELECT * FROM allguide Where up_no='EA2' AND nm= %s AND data2= %s",GetSQLValueString($row_web_examinee['exarea'], "text"), GetSQLValueString($row_web_examinee['exarea_note'], "text"));

//取得學院系所資料
// $query_web_allguide = sprintf("SELECT * FROM `allguide` where up_no='Edu' order by no,CAST(CONVERT(data1 USING big5) AS BINARY)",GetSQLValueString('%', "text"));
$query_web_allguide = sprintf("SELECT * FROM allguide where up_no='Edu' and data1 not in ('其他學系') UNION SELECT * FROM allguide where up_no='Edu' and data1 ='其他學系'",GetSQLValueString('%', "text"));
$web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
$i=0;
while ($row_allguide = mysql_fetch_assoc($web_allguide)){
	$select1[$row_allguide['nm']]=$row_allguide['nm'];
	$select2[$row_allguide['nm']][$init]='請選擇-系所';
	$select2[$row_allguide['nm']][$row_allguide['data1']]=$row_allguide['data1'];
	$select3[$row_allguide['nm']]=$row_allguide['nm'];
	$select4[$row_allguide['nm']][$init]='請選擇-系所';
	$select4[$row_allguide['nm']][$row_allguide['data1']]=$row_allguide['data1'];
// 	$select3[$row_allguide['nm']][$init][$init]='請選擇-日期場次';
// 	$select3[$row_allguide['nm']][$row_allguide['note']][$init]='請選擇-日期場次';
// 	$select3[$row_allguide['nm']][$row_allguide['note']][$row_allguide['data2']]=$row_allguide['data1'];
}
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
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery.js"></script>
	<script src="js/jquery.validate.js"></script>
<script language="javascript" src="address.js"></script><!--引入郵遞區號.js檔案、驗證.js檔-->
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>

	<style type="text/css">
        /************jQuery.Validate樣式********************/
    label.error
        {
            background: url(../../ck910/ck/images/icon-cross.gif) no-repeat 0px 0px;
            color: Red;
            padding-left: 20px;
        }
        input.error
        {
            border: dashed 1px red;
        }
        /************jQuery.Validate樣式********************/
    </style>
  
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
// 	$().ready(function() {
// 		// validate the comment form when it is submitted
// 		$("#commentForm").validate();

// 		// validate signup form on keyup and submit
// 		$("#form3").validate({
// 			rules: {
// 				email: "required",
// 				phone: "required",
				
// 				Student_ID: {
// 					required: true,
// 					minlength: 4
// 				},
// 				Department: {
// 					required: true,
// 					minlength: 4
				//},<?php //add判斷身份一和二才為必填(任職學校), by coway 2016.10.20
// 						if (($_GET['id'] =='') ? ($row_web_examinee2['cert_no']) : ($_GET['id']) != '3'){
// 							?>

// 								school: {
// 										required: true,
// 										minlength: 4,
// 										},	
							<?php //} ?>
// 				agree: "required"
// 			},
// 			//錯誤訊息
// 			messages: {
// 				Student_ID: {
// 					required: "請檢查學號欄位",
// 					minlength: "學號輸入請勿少於4個字元"
// 				},
// 				Department: {
// 					required: "請檢查科系欄位",
// 					minlength: "科系輸入請勿少於4個字元"
// 				},
// 				email:"請檢查email欄位",
					
// 				phone: "請檢查電話欄位",
// 				//
// 				school: {
// 					required: "請檢查學校欄位",
// 					minlength: "請檢查學校欄位",
// 				},	
				
// 			}
// 		});	
// 	});

	function ShowAlert(){
		alert("本梯次暫不開放代理代課教師報名");		
	}

	function SaveAlert(){
		alert("提醒您，報名尚未完成。");
		
	}

	function popIdMsg(){
		var winvar;	
			window.open('popIdMsg.php','msg','resizable=no,top=220,left=900,height=200,width=400,scrollbars=no,menubar=no,location=no,status=no,titlebar=no,toolbar=no');
// 			checkSchool();		
		var idValue = getSchoolVal();
			location.href='examAdd1.php?id='+idValue
	}

	function getSchoolVal(){

		var form1 = document.getElementById("form3")
		var id2Val=null;
		for (var i=0; i<form1.id.length; i++)
		{
			if (form1.id[i].checked)
				{
				id2Val = form1.id[i].value;
				}
			}
		return id2Val;
	}


	//刪除報名表 ,add by coway 2016.8.22
	function DeleteAlert(){
// 		var str=document.getElementsByName("MM_delete");
// 		alert(str.length);
		if(confirm('確定刪除報名表資料?')){
		location.href='examAdd1.php?action=delete';}
	}

	function areachange2(form) {
		var form1 = document.getElementById("form3");
// 		 var test_value= document.form.elements["edu2[1]"].value;
// 		var form = document.getElementById("form3");
// 		i = form.edu2.selectedIndex;
// 		edu = form.edu2[0].value;
// 		test_value = document.form.i.value();
// 		form.Other2_dept.value="123";
// 		alert(test_value);
		
// 		var form1 = document.getElementById("form3")
		var High_college_str=$(".input-normal[name^='edu2[0]'").val();
		var Department_str=$(".input-normal[name^='edu2[1]'").val();
		form1.High_college.value=High_college_str;
		form1.Department.value=Department_str;
// 		alert (form1.High_college.value);
		if(form1.High_college.value =="其他")
		{
// 			 document.getElementById("divHigh").style.display = 'inline';
// 			 document.getElementById("sprytextfield12").style.display = 'inline';

// 			 var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "none", {minChars:2, validateOn:["blur", "change"]});
// 			 var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "none", {isRequired:true});
// 			 sprytextfield12="";
			 
// 			 result_style.display = 'inline';
// 			$(".divHigh").show();
		}else{

// 			var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12");  
// 			if(!sprytextfield12){  
// 				sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12");  
// 	        }  


	// if there is a validaiton in sprytextfield destory it, and clear the variable  
// 	        if(sprytextfield12 && sprytextfield12.destroy){  
// 	        	sprytextfield12.resetClasses();  
// 	        	sprytextfield12.destroy();  
// 	        	sprytextfield12 = null;  
// 	        }
				
// 			var $MySpans = $("#divHigh span");
// 			$MySpans.removeClass();
// 			 document.getElementById("sprytextfield12").style.display = 'none';
// 			document.getElementById('form3').reset();
// 			var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "none", {isRequired:false});
// 			var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3", "none", {isRequired:false});
// 			var sprytextfield12 = new Spry.Widget.ValidationTextField("High_college_other", "none", {isRequired:false});
			

			form1.High_college_other.value="";
			form1.Department_other.value="";
// 			 alert("test");
// 			 var sprytextfield12=null;
// 			 if(sprytextfield12 != null){
// // 			 sprytextfield12 = null;
// 			 }
// 		document.getElementById('sprytextfield12').reset();
// 		var sprytextfield = document.getElementById("sprytextfield12");
// 		sprytextfield.reset();
// 		sprytextfield.destroy();

// 			 document.getElementById("divHigh").style.display = 'none'; 
// var sprytextfield12 = null;
// 			 if(sprytextfield12){
// 				 sprytextfield12.reset();
// 				 sprytextfield12.destroy();
// 			    }
		}
// 		for (var i=0; i<form1.edu2.length ; i++)
// 		{
// 			if (form1.edu2[i].checked)
// 				{
// 				id2Val = form1.edu2[i].value;
// 				}
// 			}
// 		alert(High_college);

		
		
// 		i = form.cityarea.selectedIndex;
// 		form.Mcode.value = cityareacode[cityarea_account[form.Area.selectedIndex]+i+1];
// 		form.cuszip.value = cityareacode[cityarea_account[form.Area.selectedIndex]+i+1];
// 		form.cusadr.value = form.Area.options[form.Area.selectedIndex].value+form.cityarea.options[form.cityarea.selectedIndex].value;
	}

	function areachange3(form) {
		var form1 = document.getElementById("form3");
		var Sec_college_str=$(".input-normal[name^='edu3[0]'").val();
		var Sec_dept_str=$(".input-normal[name^='edu3[1]'").val();
		form1.Sec_college.value=Sec_college_str;
		form1.Sec_dept.value=Sec_dept_str;
		if(form1.Sec_college.value =="其他")
		{
// 			 document.getElementById("divSec").style.display = 'inline';
		}else{

			form1.Sec_college_other.value="";
			form1.Sec_dept_other.value="";
// 			 document.getElementById("divSec").style.display = 'none';
		}
// 		alert(id2Val);
// alert(form1.Sec_college.value);
	}
	function areachange4(form) {
		var form1 = document.getElementById("form3");
		var Other1_college_str=$(".input-normal[name^='edu4[0]'").val();
		var Other1_dept_str=$(".input-normal[name^='edu4[1]'").val();
		form1.Other1_college.value=Other1_college_str;
		form1.Other1_dept.value=Other1_dept_str;
		if(form1.Other1_college.value =="其他")
		{
// 			 document.getElementById("divOther1").style.display = 'inline';
		}else{

			form1.Other1_college_other.value="";
			form1.Other1_dept_other.value="";
// 			 document.getElementById("divOther1").style.display = 'none';
		}

// 		alert(Other1_dept_str);
	}
	
	</script>


</head>

<body background="images/background.jpg">
<div id="wrapper">
<?php include("header.php");
//序列化數組
$a = array('a' => 'Apple' ,'b' => 'banana' , 'c' => 'Coconut');
$s = serialize($a);
// $s = json_encode($a);
// echo $s;
//輸出結果：{"a":"Apple","b":"banana","c":"Coconut"}


// echo '<br /><br />';


//反序列化
$o = unserialize($s);
// $o = json_decode($s);
// print_r($o);
// print_r($o[a]);

 ?>
<div id="main">
  <div id="main1">
  </div>

  <div id="exam" align="center">
  <?
  $row_web_new['startday']=$row_web_new['startday']." 08:30:00";
  $row_web_new['endday']=$row_web_new['endday']." 15:30:00";
  ?>
  <? if(strtotime($row_web_new['startday']) <= strtotime(date('Y-m-d H:i:s')) && strtotime(date('Y-m-d H:i:s')) <= strtotime($row_web_new['endday']) && $row_web_new['status'] == '1'){?>
  <? if(($row_web_examinee['username'] != $row_web_member['username']) or  strtotime(substr(($row_web_examinee['date']),0,19)) < (strtotime($row_web_new['startday']))){?>
  
    <form id="form3" name="form3" method="post" enctype="multipart/form-data" action="<?php echo $editFormAction; ?>" >
      <table width="620" border="0" cellspacing="0" cellpadding="0" >
        <tr>
          <td width="15" align="left"><img src="images/board03.gif" /></td>
          <td width="565" align="left" background="images/board04.gif">&nbsp; <span class="font_black">親愛的考生[</span><span class="font_red">&nbsp;<?php echo $row_web_member['username']; ?> &nbsp;</span><span class="font_black">]請在下方確實填寫您的報名資料，每個欄位皆為必填!</span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="540" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="82" height="30" align="right" class="board_add">姓名：</td>
          <td width="458" align="left" class="board_add" colspan="3"><label>
			<?php echo $row_web_member['uname']; ?>          
            <input name="uname" type="hidden" id="uname" value="<?php echo $row_web_member['uname']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td width="82" height="30" align="right" class="board_add">英文姓名：</td>
          <td width="458" align="left" class="board_add" colspan="3"><label>
          <?php 
	          list($firstname, $lastname, $lastname2) = explode(" ", $row_web_member['eng_uname']);
	          if($firstname !=""){
	          	$eng_name="$firstname, $lastname $lastname2";
	          }
// 	          echo $eng_name; //$row_web_member['eng_uname']; 
          ?>
            <input name="eng_uname"  id="eng_uname" value="<?php echo $row_web_member['eng_uname']; ?>" /><!-- type="hidden"調整可以修改英文名字,update by coway 2017.4.28 -->
          </label>(例如：李大同，英文名:Li Da Tong)</td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">E-mail：</td>
          <td align="left" class="board_add" colspan="3"><label>
          <span id="sprytextfield0">          
            <input name="email" type="text" id="email" value="<?php echo $row_web_member['email']; ?>" size="35" />
   			<span class="textfieldRequiredMsg">請輸入mail</span><span class="textfieldMinCharsMsg">請輸入mail</span></span>             
          </label>
          <br />
			<span class="font_black">請勿使用會檔信的yahoo、pchome信箱，以免收不到信。</span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">性別：</td>
          <td align="left" class="board_add" colspan="3"><label>
          <input <?php if (!(strcmp($row_web_member['sex'],"男"))) {echo "checked=\"checked\"";} ?> name="sex" type="radio" id="radio" value="男" checked="checked" />
          男
          <input <?php if (!(strcmp($row_web_member['sex'],"女"))) {echo "checked=\"checked\"";} ?> type="radio" name="sex" id="radio2" value="女" />
          女</label>
          
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">生日：</td>
          <td align="left" class="board_add" colspan="3"><label>
          <span id="sprytextfield4">
            <input name="birthday" type="text" id="birthday" value="<?php echo $row_web_member['birthday']; ?>" />
          格式為：YYYY-MM-DD
   			<span class="textfieldRequiredMsg">請輸入生日</span><span class="textfieldMinCharsMsg">請輸入生日</span></span>        
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">電話：</td>
          <td align="left" class="board_add" colspan="3"><label>
          <span id="sprytextfield5">
            <input name="phone" type="text" id="phone" value="<?php echo $row_web_member['phone']; ?>" />
   			<span class="textfieldRequiredMsg">請輸入電話</span><span class="textfieldMinCharsMsg">請輸入電話</span></span>            
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">身分證字號：</td>
          <td align="left" class="board_add" colspan="32"><label>
            <?php echo $row_web_member['uid']; ?><input name="per_id" type="hidden" id="per_id" value="<?php echo $row_web_member['uid']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">郵遞區號：</td>
          <td align="left" class="board_add" colspan="3">
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
          <td align="left" class="board_add" colspan="3"><span class="bs">
            <span id="sprytextfield3">
            <label for="cusadr"></label>
            <input type="text" name="cusadr" id="cusadr" value="<?php echo $row_web_member['cusadr']; ?>" size="60" />
            <span class="textfieldRequiredMsg">請輸入地址</span><span class="textfieldMinCharsMsg">請輸入地址</span></span></span></td>
        </tr>
        <tr>
          <td height="30" align="right" colspan="4" class="board_add">=================================================================================================</td>   
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">錄取順序一.<br>錄取順序二.<br>錄取順序三.</td><!-- 報考資格：<br> -->
           <td align="left" class="board_add" colspan="4">
          <!-- <label> -->本評量報考資格分為三類，其錄取順序如下：<br><?php //echo "id=".$_GET['id']."<br>"; //echo ($row_web_examinee2['cert_no']).(($_GET['id'] == '') ? ($row_web_examinee2['cert_no']) : ($_GET['id']))//($row_web_examinee2['cert_no'])?>
          	<input <?php if (!(strcmp((($_GET['id'] =='') ? ($row_web_examinee2['cert_no']) : ($_GET['id'])),"1"))) {echo "checked=\"checked\"";} ?> name="id" type="radio" id="radio1" value="1" onclick="popIdMsg();" />
          	<?php echo $allguide_lot[0]['nm']."<br>"?>
          	<input <?php if (!(strcmp((($_GET['id'] =='') ? ($row_web_examinee2['cert_no']) : ($_GET['id'])),"2"))) {echo "checked=\"checked\"";} ?> type="radio" name="id" id="radio2" value="2" onclick="popIdMsg();" />
          	<?php echo $allguide_lot[1]['nm']."<br>"?>
          	<input <?php if (!(strcmp((($_GET['id'] =='') ? ($row_web_examinee2['cert_no']) : ($_GET['id'])),"3"))) {echo "checked=\"checked\"";} ?> type="radio" name="id" id="radio3" value="3" onclick="popIdMsg();" />
          	<?php echo $allguide_lot[2]['nm']?>
          <!-- </label> -->
          </td>
         </tr>
        <tr>
          <td height="30" align="right" class="board_add">教師證號碼：</td>
          <td align="left" class="board_add" colspan="3">
           <label>
           	<span id="sprytextfield6">          
            <input name="certificate" type="text" id="certificate" value="<?php echo ($row_web_examinee2['certificate']==null)? ($_REQUEST['certificate']): $row_web_examinee2['certificate']; ?>" /><!-- onclick="ShowAlert()" -->
   			<span class="textfieldRequiredMsg">請輸入教師證號碼</span><span class="textfieldMinCharsMsg">請輸入教師證號碼</span></span>            
          </label>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">報名科目：</td>
          <td align="left" class="board_add" colspan="3">
         
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
          <td height="30" align="right" class="board_add">評量考區：</td>
          <td align="left" class="board_add" colspan="3">
          <label>
            <input name="exarea" type="radio" id="radio" value="Northern" checked="checked" />
          	臺北(國立臺灣大學)，106年6月18日(星期日) 
          	<!-- 尚餘名額：<?php //echo (300-$oln); ?>人
	          <?php //if((300-$oln) <= 0){
	          	//$over = 90-$overn;
	          	//echo "<font color='#FF0000'>(已額滿)</font> 備取尚餘名額：$over 人";
          		//} ?> --> <br /></label>
          <label>
          <input type="radio" name="exarea" id="radio2" value="Central" />
          	臺中(國立臺中教育大學)，106年6月21日(星期三) 
          	<!-- 尚餘名額：<?php //echo (250-$olc); ?>人
          		<?php //if((250-$olc) <= 0){
          			//$over = 75-$overc;
          			//echo "<font color='#FF0000'>(已額滿)</font> 備取尚餘名額：$over 人";
          		//} ?>  --><br /></label>
          <label>
          <input type="radio" name="exarea" id="radio3" value="Southern" />
          	高雄(私立三信家事商業職業學校)，106年6月18日(星期日)
          	<!-- 尚餘名額：<?php //echo (160-$ols); ?>人 
          		<?php //if((160-$ols) <= 0){
          			//$over = 48-$overs;
          			//echo "<font color='#FF0000'>(已額滿)</font> 備取尚餘名額：$over 人";
          		//} ?>  --><br/></label>
          <label>
          <input type="radio" name="exarea" id="radio4" value="Eastern" />
          	花蓮(國立花蓮高級商業職業學校)，106年6月21日(星期三) 
          	<!-- 尚餘名額：<?php //echo (40-$ole); ?>人
          		<?php //if((40-$ole) <= 0){
          			//$over = 12-$overe;
          			//echo "<font color='#FF0000'>(已額滿)</font> 備取尚餘名額：$over 人";
          		//} ?>  --></label>
          </td>
        </tr>
        <tr id="tr_school" >
          <td height="30" align="right" class="board_add">任職學校：</td>
          <td align="left" class="board_add" colspan="3">
          <label>
           <!-- <span id="sprytextfield7" >  -->
            <input name="school" type="text" id="school" value="<?php echo $row_web_examinee2['school']; ?>" />
    			<!-- <span class="textfieldRequiredMsg">請輸入(縣市)學校名稱</span><span class="textfieldMinCharsMsg">請輸入(縣市)學校名稱</span></span> -->
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
          <td align="center" class="board_add"></td><!-- 學院 -->
          <td align="center" class="board_add">就讀科系<font color="red" ><br>須與畢業証書或學生証上<br>科系名稱一致(勿縮寫)</font></td>
        </tr>
                  <?php 
//           		$event="required onchange=\"ShowMsg(this,'$todayyear')\"";
//           		$event="required onchange=\"ShowMsg(this,'$todayyear')\"";
          		$events=' class="input-normal" height="30" width="200" onchange="areachange2(this.form)" ';/* style="width: 220px;" */
//           		$events='class="input-normal" height="30" width="200"';
          		// Create the Element
// 				$sel1 =& $form1->addElement('hierselect', 'edu2', '',$events);
// 				$sel1 =& $form1->addElement('hierselect', 'edu3', '',$events);
// 				$sel1 =& $form1->addElement('hierselect', 'edu4', '',$events);
// 				$sel2 =& $form1->addElement('hierselect', 'edu2', '',$events);
// 				$sel3 =& $form33->addElement('hierselect', 'edu3', '',$events);
// 				$sel4 =& $form4->addElement('hierselect', 'edu4', '',$events);
// 				$sel =& $form->addElement('hierselect', 'school', '就讀學校：', $optionEvent);  //關聯式選單
// 				$sel->setOptions(array($select1, $select2));
				?>
        <tr>
          <td align="center" class="board_add"><label id="Edu_level" for="1">專科</label></td>
          <td height="30" align="left" class="board_add">
          	(<input name="eduRec1" type="radio" id="radio" value="0" checked="checked" />在學中
			<input name="eduRec1" type="radio" id="radio" value="1" />畢業)
          <label>
            <span>
            <input type="text" name="Other2" id="Other2"  value="<?php echo ($row_web_examinee2['Other2']==null)?($_REQUEST['Other2']):($row_web_examinee2['Other2']); ?>" />
          <span class="textfieldRequiredMsg"><br>請輸入學校</span><span class="textfieldMinCharsMsg">請輸學校</span></span></label>
          </td>
          <!--td align="left" class="board_add" width="200" colspan="2" rowspan="4"-->
          
          <span> 
          <?php 
				// And add the selection options
// 				$sel1->setOptions(array($select1, $select2));
// 				?>
				<?php 
// 				$sel2->setOptions(array($select1, $select2));
// 				?>
				<?php 
// 				$sel3->setOptions(array($select1, $select2));
// 				?>
				<?php 
// 				$sel4->setOptions(array($select1, $select2));
// 				$form1->display();
				?>       
          <!--input type="text" name="Other2_college" id="Other2_college" value="<?php echo ($row_web_examinee2['Other2_college']==null)?($_REQUEST['Other2_college']):($row_web_examinee2['Other2_college']); ?>"/>
          <span class="textfieldRequiredMsg">請輸入學院</span><span class="textfieldMinCharsMsg">請輸入學院</span></span>
          </td-->
          <td align="center" class="board_add" width="30" colspan="2">
          
          <span>  
          <br>           
          <input type="text" name="Other2_dept" id="Other2_dept"  value="<?php echo ($row_web_examinee2['Other2_dept']==null)?($_REQUEST['Other2_dept']):($row_web_examinee2['Other2_dept']); ?>"/>
          <span class="textfieldRequiredMsg">請輸入科系</span><span class="textfieldMinCharsMsg">請輸入科系</span></span>
          </td>
        </tr>

        <tr>
          <td align="center" class="board_add"><label id="Edu_level" for="2">學士</label></td>
          <td height="30" align="left" class="board_add">
          	(<input name="eduRec2" type="radio" id="radio" value="0" checked="checked" />在學中
			<input name="eduRec2" type="radio" id="radio" value="1" />畢業)
          <label>
            <span id="sprytextfield1">
            <input type="text" name="Highest" id="Highest"  value="<?php echo ($row_web_examinee2['Highest']==null)?($_REQUEST['Highest']):($row_web_examinee2['Highest']); ?>" />
          <span class="textfieldRequiredMsg"><br>請輸入學校</span><span class="textfieldMinCharsMsg">請輸學校</span></span></label>
          </td>
          <?php 
				$sel1 =& $form2->addElement('hierselect', 'edu2', '',$events);?>
          <td align="left" class="board_add" colspan="2">
          
          <span id="spryselect3"><!-- sprytextfield11 -->            
          <?php 
				// And add the selection options
				$sel1->setOptions(array($select1, $select2));
// 				$form2->addElement('text','other','家長帳號1：');
// 				$sel1 =& $form1->addElement('hierselect', 'edu3', '科系',$events);
// 				$sel1->setOptions(array($select1, $select2));
// 				$sel1 =& $form1->addElement('hierselect', 'edu4', '科系',$events);
// 				$sel1->setOptions(array($select1, $select2));
				$form2->display();
				?> 
          	<span class="selectRequiredMsg">請選擇學院科系</span></span>
				 <input name="High_college" type="hidden" ></input> 
				 <!-- <span id="sprytextfield2"> -->
				 <input name="Department"  type="hidden" ></input>  
				 <!-- <span class="textfieldRequiredMsg">請輸入科系</span><span class="textfieldMinCharsMsg">請輸入科系</span>  -->
				 <div id="divHigh" > <!-- style="display:none" -->
				 <!--span id="sprytextfield12" > style="display:none" -->
				 <input type="text" name="High_college_other" id="High_college_other" style="width: 60px;" ></input>
				 <span class="textfieldRequiredMsg">請輸入學院系所</span>學院／<input type="text" name="Department_other" id="Department_other" style="width: 100px;" ></input>系所<!-- </span> -->
				 </div>       
          <!--input type="text" name="High_college" id="High_college" value="<?php //echo ($row_web_examinee2['High_college']==null)?($_REQUEST['High_college']):($row_web_examinee2['High_college']); ?>"/>
          <span class="textfieldRequiredMsg">請輸入學院</span><span class="textfieldMinCharsMsg">請輸入學院</span></span>
          </td>
          <td align="left" class="board_add">
          
          <span id="sprytextfield2">         
          <br>    
          <input type="text" name="Department" id="Department"  value="<?php //echo ($row_web_examinee2['Department']==null)?($_REQUEST['Department']):($row_web_examinee2['Department']); ?>"/>
          <span class="textfieldRequiredMsg">請輸入科系</span><span class="textfieldMinCharsMsg">請輸入科系</span--></span>
          <script>
			
          </script>
          </td>
        </tr>
        <tr>
          <td  align="center" class="board_add"><label id="Edu_level" for="3">碩士</label></td>
          <td height="30" align="left" class="board_add">
			(<input name="eduRec3" type="radio" id="radio" value="0" checked="checked" />在學中
			<input name="eduRec3" type="radio" id="radio" value="1" />畢業)
          <label>
            <span>
            <input type="text" name="Sec_highest" id="Sec_highest"  value="<?php echo ($row_web_examinee2['Sec_highest']==null)?($_REQUEST['Sec_highest']):($row_web_examinee2['Sec_highest']); ?>" />
          <span class="textfieldRequiredMsg"><br>請輸入學校</span><span class="textfieldMinCharsMsg">請輸學校</span></span></label>
          </td>
          <td align="left" class="board_add" colspan="2">
          
          <span>           
          <?php 
          		$events=' class="input-normal" height="30" width="200" onchange="areachange3(this.form)"';
				// And add the selection options
				$sel2 =& $form1->addElement('hierselect', 'edu3', '',$events);
				$sel2->setOptions(array($select3, $select4));
				$form1->display();
				?>            
				 <input name="Sec_college" id="Sec_college" type="hidden" ></input> 
				 <input name="Sec_dept" id="Sec_dept" type="hidden" ></input>  
				 <div id="divSec">  
				 <span id="sprytextfield13">
				 <input type="text" name="Sec_college_other" id="Sec_college_other" style="width: 60px;" ></input>學院／<input type="text" name="Sec_dept_other" id="Sec_dept_other"  style="width: 100px;"></input>系所
				 <span class="textfieldRequiredMsg">請輸入學院系所</span><span class="textfieldMinCharsMsg">請輸入學院系所</span></span>
				 </div>
          <!--input type="text" name="Sec_college" id="Sec_college"  value="<?php echo ($row_web_examinee2['Sec_college']==null)?($_REQUEST['Sec_college']):($row_web_examinee2['Sec_college']); ?>"/>
          <span class="textfieldRequiredMsg">請輸入學院</span><span class="textfieldMinCharsMsg">請輸入學院</span></span>
          </td>
          <td align="left" class="board_add">
          
          <span>          
          <br>   
          <input type="text" name="Sec_dept" id="Sec_dept"  value="<?php echo ($row_web_examinee2['Sec_dept']==null)?($_REQUEST['Sec_dept']):($row_web_examinee2['Sec_dept']); ?>"/>
          <span class="textfieldRequiredMsg">請輸入科系</span><span class="textfieldMinCharsMsg">請輸入科系</span--></span>
          </td>
        </tr>
        <tr>
          <td  align="center" class="board_add"> <label id="Edu_level" for="4">博士</label></td>
          <td height="30" align="left" class="board_add">
          	(<input name="eduRec4" type="radio" id="radio" value="0" checked="checked" />在學中
			<input name="eduRec4" type="radio" id="radio" value="1" />畢業)
          <label>
            <span>
            <input type="text" name="Other1" id="Other1"  value="<?php echo ($row_web_examinee2['Other1']==null)?($_REQUEST['Other1']):($row_web_examinee2['Other1']); ?>" />
          <span class="textfieldRequiredMsg"><br>請輸入學校</span><span class="textfieldMinCharsMsg">請輸學校</span></span></label>
          </td>
          <td align="left" class="board_add" colspan="2">
          
          <span>           
          <?php 
          		$events=' class="input-normal" height="30" width="200" onchange="areachange4(this.form)"';
				// And add the selection options
				$sel3 =& $form3->addElement('hierselect', 'edu4', '',$events);
				$sel3->setOptions(array($select1, $select2));
				$form3->display();
				?>              
				 <input name="Other1_college" type="hidden" ></input> 
				 <input name="Other1_dept" type="hidden" ></input> 
				 <div id="divOther1"> 
				 <span id="sprytextfield14">
				 <input type="text" name="Other1_college_other" id="Other1_college_other" style="width: 60px;" ></input>學院／<input type="text" name="Other1_dept_other" id="Other1_dept_other"  style="width: 100px;"></input>系所
				 <span class="textfieldRequiredMsg">請輸入學院系所</span><span class="textfieldMinCharsMsg">請輸入學院系所</span></span>
				 </div>
          <!--input type="text" name="Other1_college" id="Other1_college"  value="<?php echo ($row_web_examinee2['Other1_college']==null)?($_REQUEST['Other1_college']):($row_web_examinee2['Other1_college']); ?>"/>
          <span class="textfieldRequiredMsg">請輸入學院</span><span class="textfieldMinCharsMsg">請輸入學院</span></span>
          </td>
          <td align="left" class="board_add">
          
          <span>   
          <br>          
          <input type="text" name="Other1_dept" id="Other1_dept"  value="<?php echo ($row_web_examinee2['Other1_dept']==null)?($_REQUEST['Other1_dept']):($row_web_examinee2['Other1_dept']); ?>"/>
          <span class="textfieldRequiredMsg">請輸入科系</span><span class="textfieldMinCharsMsg">請輸入科系</span--></span>
          </td>
        </tr>
        
        <tr>
          <td height="30" align="right" class="board_add">緊急聯絡人：</td>
          <td align="left" class="board_add" colspan="3">
          <label>
           <span id="sprytextfield8">            
            <input name="contact" type="text" id="contact" value="<?php echo ($row_web_examinee2['contact']==null)?($_REQUEST['contact']):($row_web_examinee2['contact']); ?>" />
			<span class="textfieldRequiredMsg">請輸入聯絡人</span><span class="textfieldMinCharsMsg">請輸聯絡人</span></span>            
          </label>
         
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">緊急聯絡人<br />電話：</td>
          <td align="left" class="board_add" colspan="3">
          <label>
           <span id="sprytextfield9">          
            <input name="contact_ph" type="text" id="contact_ph" value="<?php echo ($row_web_examinee2['contact_ph']==null)?($_REQUEST['contact_ph']):($row_web_examinee2['contact_ph']); ?>" />
			<span class="textfieldRequiredMsg">請輸入聯絡電話</span><span class="textfieldMinCharsMsg">請輸聯絡電話</span></span>            
          </label>
         
          </td>
        </tr>
        <tr>
        <td height="30" align="right" class="board_add">大頭照圖片：</td>
        <td align="left" class="board_add" colspan="3"><span class="table_lineheight">
          <?php /*START_PHP_SIRFCIT*/ //if ($row_web_examinee2['pic_name']!=""){ //marker by coway 2016.10.14?>
          <img src="images/examinee/<?php //echo $row_web_examinee2['pic_name']; ?>" alt="" name="pic" width="70" id="pic" />
          <?php //} /*END_PHP_SIRFCIT*/ ?>
          <input name="oldPic" type="hidden" id="oldPic" value="<?php echo $row_web_examinee2['pic_name']; ?>" />
          <input name="oldPictitle" type="hidden" id="oldPic" value="<?php echo $row_web_examinee2['pic_title']; ?>" />          
          <?php //echo $row_web_examinee2['pic_title']; ?><br />
          <label>
          <span id="sprytextfield10"> 
            <input type="file" name="news_pic" id="news_pic" />
			<span class="textfieldRequiredMsg">請選擇照片</span><span class="textfieldMinCharsMsg">請選擇照片</span></span>               
          </label>
          <br />
          <span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
       </td>
        
        <tr>
          <td height="40" colspan="3" align="center"><label>
            <input type="submit" name="button" id="button" value="報名資料儲存" onclick="SaveAlert()"/>  </label>
            <label>
            <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
            <input name="username" type="hidden" id="username" value="<?php echo $row_web_member['username']; ?>" />
            <input name="date" type="hidden" id="date" value="<?php echo date("Y-m-d H:i:s");?>" />
            <input name="times" type="hidden" id="times" value="<?php echo $row_web_new['times']; ?>" />
            <input name="endday" type="hidden" id="endday" value="<?php echo $row_web_new['endday']; ?>" />
            <input name="examyear_id" type="hidden" id="examyear_id" value="<?php echo $row_web_new['id']; ?>" />
            
          </label></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form3" />
    </form>
     <?php
  		}elseif($row_web_examinee['username'] == $row_web_member['username'] && $row_web_examinee['apply_mk']=='1' && ($_GET["action"]!="delete")){
	  ?>
<table width="555" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2">您已經完成報名了，請點選 <a href="progress.php?status=1"><img src="images/progress_check_t.png"  /></a> 查看審核情況。</td>
      </tr>
      <tr> <td align="center" style="color: blue; font-weight: bold; font-size: 16px;">若您需取消本梯次報名，請點選 <input type="button" name="btnSentDel" value="刪除報名>>" onclick="DeleteAlert();"/> 取消報名資格。 </td></tr>
</table>      
<!-- <script>
   alert("您已經完成報名了，請點選[報名進度查詢]查看審核情況。"); 
 document.location.href=".";
 </script>
--> 	 
<?php	 
  }elseif(($_GET["action"]!="delete")){//否則顯示另依個區塊內容?>
  	<table width="555" border="0" cellspacing="0" cellpadding="0">
  	<tr>
  	<td height="80" align="center" class="font_red2">您已經填寫報名資料，請點選<a href="examOut1.php"><img src="images/sign_t.png"  /></a>送出報名資料。</td>
  	</tr>
  	</table>
<?php     	
	//header("Location: examOut1.php");
	//exit();
  }?>
    
<?PHP }else{?><table width="555" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2">目前尚未開放報名!</td>
      </tr>
  </table><?PHP }?>
  <?php  
  //刪除報名表 ,add by coway 2016.8.17
	
if ((isset($_GET["action"])) && ($_GET["action"]=="delete")){
	$ResultDel="";
	$deleteSQL = sprintf("DELETE FROM examinee WHERE no=%s",
			GetSQLValueString($row_web_examinee['no'], "text"));
	//echo "no=".$row_web_examinee["no"]."<br>";
	mysql_select_db($database_conn_web, $conn_web);
		$ResultDel = mysql_query($deleteSQL, $conn_web) or die(mysql_error());
		if($ResultDel)
		{			
// 			echo "result=".$ResultDel;
		$deleteGoTo = "examAdd1.php";
		header(sprintf("Location: %s", $deleteGoTo));
	?>
			<table width="570" border="0" cellspacing="0" cellpadding="0">
  			<tr>
  				<td height="80" align="center" class="font_red2">您已取消本梯次報名資格，欲重新報名者，請點選<a href="examAdd1.php"><img src="images/sign.png"  /></a> 重新報名。</td>
  			</tr>
  			</table>
	<?php 
	include("footer.php");
	exit();
		}
}
?>  
    
  </div>
  <div id="main4"></div>


<?php include("footer.php"); ?>
</div>
<script type="text/javascript">
var sprytextfield0 = new Spry.Widget.ValidationTextField("sprytextfield0", "none", {minChars:5, validateOn:["blur", "change"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:4, validateOn:["blur", "change"]});
// var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:2, validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {minChars:6, validateOn:["blur", "change"]});
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "none", {minChars:2, validateOn:["blur", "change"]});//add by coway 2016.8.17

var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
/*******dios add**********/
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {minChars:8, validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {minChars:9, validateOn:["blur", "change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {minChars:5, validateOn:["blur", "change"]});
// var form1 = document.getElementById("form3")
// if(form1.High_college.value =="其他")
// {
// 	var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "none", {isRequired:true});
// 	alert("test");
// var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "none", {minChars:2, validateOn:["blur", "change"]});
// var sprytextfield13 = new Spry.Widget.ValidationTextField("sprytextfield13", "none", {minChars:2, validateOn:["blur", "change"]});
// var sprytextfield14 = new Spry.Widget.ValidationTextField("sprytextfield14", "none", {minChars:2, validateOn:["blur", "change"]});
// }else{

// 	var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "none", {isRequired:false});
// 	alert(form1.High_college.value);	
// }

function checkSchool(){
var form = document.getElementById("form3")
var field7 = document.getElementById("sprytextfield7")
var school = document.getElementById("school2")
// var sprytextfield7_obj = new Object();
// var sprytextfield7_val=null;
for (var i=0; i<form.id.length; i++)
		{				
		   if (form.id[i].checked)				
		   {				
		      var idVal = form.id[i].value;
// 		      alert('idVal='+idVal);	
		      if(idVal != 3){

// 		    	  school.removeAttr("disabled");

// 		    	  sprytextfield7_obj = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {minChars:4, validateOn:["blur", "change"]});
// 		    	  alert(sprytextfield7);
		    	  var result_style = document.getElementById('tr_school').style;
		    	  result_style.display = 'table-row';
// 		    	  sprytextfield7_obj=null;
// 					delete sprytextfield7_obj;
		      }else{
// 		    	  result_style = document.getElementById('tr_school').style;
// 		    	  sprytextfield7_obj = new Object();
// 		    	  $('.textfieldRequiredState').attr('disabled', 'disabled');
// 		    	  $('#sprytextfield7').removeChild(field7.lastChild);
// 		    	  field7.attr("disabled", "disabled");
// 		    	  field7.removeChild(field7.lastChild); 
// 		    	  field7.removeChild(field7.lastChild);   
// 		    	  sprytextfield7_obj=null;
// 					delete sprytextfield7_obj;
// 					result_class=null;
// 					delete field7.css;
// 			    	  sprytextfield7_obj = new Spry.Widget.ValidationTextField("sprytextfield7");
// 					delete sprytextfield7_obj.id;
// 					sprytextfield7_obj.remove();
// 					field7.outerHTML='';
// 					sprytextfield7_obj = new Spry.Widget.ValidationTextField("sprytextfield7");
		    	  var result_style = document.getElementById('tr_school').style;
		    	  result_style.display = 'none';
// 		    	  alert(sprytextfield7_obj);
		      }	
		      break;		
			
		   }				
		}
}				
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
