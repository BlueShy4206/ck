<?
header("Cache-control:private");//解決session 引起的回上一頁表單被清空
?>
<?php
require_once('Connections/conn_web.php');
require_once "examAdd_function.php";
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
//	---------------------------------------------
//	Pure PHP PIC Upload version 1.1
//	-------------------------------------------
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}

define("DESTINATION_PIC_FOLDER_ID", "images/examinee/id_check");
define("MAX_PIC_SIZE",5000000);
define("DESTINATION_PIC_FOLDER", "images/examinee");
define("no_error", "examAdd2.php");
define("yes_error", "examAdd2.php");
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
		$headpic_name=upload_pic('hpic',$_file_);
        @$news_pic_title=$headpic_name[0];
        @$newPicname=$headpic_name[1];
	}
}

//各種check START
//1********************  BlueS 20180302 將身分證等資料傳至網頁
if(!empty($HTTP_POST_FILES['news_pic1'])){
    if(is_uploaded_file($HTTP_POST_FILES['news_pic1']['tmp_name']) && $HTTP_POST_FILES['news_pic1']['error'] == 0){

    	$_file_ = $HTTP_POST_FILES['news_pic1'];
    	$news_pic1=upload_pic('1',$_file_);
    	//updata
    	$insertSQL_check = sprintf("UPDATE examinee_pic SET pic1_title = %s, `pic1_name` = %s
    											WHERE examinee_no = %s",
                                                GetSQLValueString($news_pic1[0], "text"),
                     							GetSQLValueString($news_pic1[1], "text"),
     				 					   GetSQLValueString($_POST['no'], "text")
     	);
     	// echo "$insertSQL_check<br>";
     	// die();
     	mysql_select_db($database_conn_web, $conn_web);
     		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("ERROR"));
      	$nums=mysql_affected_rows();
    		if($nums==0){
    		echo "<script>javascript:alert(".$picname_t[1]."上傳失敗);</script>";
    	}
    }
}

//2*******************
if(!empty($HTTP_POST_FILES['news_pic2'])){
	if(is_uploaded_file($HTTP_POST_FILES['news_pic2']['tmp_name']) && $HTTP_POST_FILES['news_pic2']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['news_pic2'];
		$news_pic2=upload_pic('2',$_file_);
		//updata
		$insertSQL_check = sprintf("UPDATE examinee_pic SET pic2_title = %s, `pic2_name` = %s
												WHERE examinee_no = %s",
                                                GetSQLValueString($news_pic2[0], "text"),
                     							GetSQLValueString($news_pic2[1], "text"),
	 				 					   GetSQLValueString($_POST['no'], "text")
	 	);
	 	// echo "$insertSQL_check<br>";
	 	// die();
	 	mysql_select_db($database_conn_web, $conn_web);
	 		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
	  	$nums=mysql_affected_rows();
			if($nums==0){
			echo "<script>javascript:alert(".$picname_t[2]."上傳失敗);</script>";
		}
	}
}
//3********************
if(!empty($HTTP_POST_FILES['news_pic3'])){
	if(is_uploaded_file($HTTP_POST_FILES['news_pic3']['tmp_name']) && $HTTP_POST_FILES['news_pic3']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['news_pic3'];
		$news_pic3=upload_pic('3',$_file_);
		//updata
		$insertSQL_check = sprintf("UPDATE examinee_pic SET pic3_title = %s, `pic3_name` = %s
												WHERE examinee_no = %s",
                                                GetSQLValueString($news_pic3[0], "text"),
                     							GetSQLValueString($news_pic3[1], "text"),
	 				 					   GetSQLValueString($_POST['no'], "text")
	 	);
	 	// echo "$insertSQL_check<br>";
	 	// die();
	 	mysql_select_db($database_conn_web, $conn_web);
	 		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
	  	$nums=mysql_affected_rows();
			if($nums==0){
			echo "<script>javascript:alert(".$picname_t[3]."上傳失敗);</script>";
		}
	}
}
//4********************
if(!empty($HTTP_POST_FILES['news_pic4'])){
	if(is_uploaded_file($HTTP_POST_FILES['news_pic4']['tmp_name']) && $HTTP_POST_FILES['news_pic4']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['news_pic4'];
		$news_pic4=upload_pic('4',$_file_);
		//updata
		$insertSQL_check = sprintf("UPDATE examinee_pic SET pic4_title = %s, `pic4_name` = %s
												WHERE examinee_no = %s",
                                        GetSQLValueString($news_pic4[0], "text"),
             							GetSQLValueString($news_pic4[1], "text"),
	 				 					GetSQLValueString($_POST['no'], "text")
	 	);
	 	// echo "$insertSQL_check<br>";
	 	// die();
	 	mysql_select_db($database_conn_web, $conn_web);
	 		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
	  	$nums=mysql_affected_rows();
			if($nums==0){
			echo "<script>javascript:alert(".$picname_t['4n']."上傳失敗);</script>";
		}
	}
}

//5********************

if(!empty($HTTP_POST_FILES['news_pic5'])){
	if(is_uploaded_file($HTTP_POST_FILES['news_pic5']['tmp_name']) && $HTTP_POST_FILES['news_pic5']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['news_pic5'];
		$news_pic5=upload_pic('5',$_file_);
	//updata
	$insertSQL_check = sprintf("UPDATE examinee_pic SET pic5_title = %s, `pic5_name` = %s
											WHERE examinee_no = %s",
  									GetSQLValueString($news_pic5[0], "text"),
 									GetSQLValueString($news_pic5[1], "text"),
 				 					GetSQLValueString($_POST['no'], "text")
 	);
 	// echo "$insertSQL_check<br>";
 	// die();
 	mysql_select_db($database_conn_web, $conn_web);
 		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
  	$nums=mysql_affected_rows();
		if($nums==0){
			echo "<script>javascript:alert(".$picname_t[5]."上傳失敗);</script>";
		}
	}
}

if(!empty($HTTP_POST_FILES['news_pic6'])){
	if(is_uploaded_file($HTTP_POST_FILES['news_pic6']['tmp_name']) && $HTTP_POST_FILES['news_pic6']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['news_pic6'];
		$news_pic6=upload_pic('6',$_file_);
	//updata
	$insertSQL_check = sprintf("UPDATE examinee_pic SET pic6_title = %s, `pic6_name` = %s
											WHERE examinee_no = %s",
  									 GetSQLValueString($news_pic6[0], "text"),
 										 GetSQLValueString($news_pic6[1], "text"),
 				 					   GetSQLValueString($_POST['no'], "text")
 	);
 	// echo "$insertSQL_check<br>";
 	// die();
 	mysql_select_db($database_conn_web, $conn_web);
 		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
  	$nums=mysql_affected_rows();
		if($nums==0){
			echo "<script>javascript:alert(".$picname_t[6]."上傳失敗);</script>";
		}
	}
}
if(!empty($HTTP_POST_FILES['news_pic7'])){
	if(is_uploaded_file($HTTP_POST_FILES['news_pic7']['tmp_name']) && $HTTP_POST_FILES['news_pic7']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['news_pic7'];
		$news_pic6=upload_pic('7',$_file_);
	//updata
	$insertSQL_check = sprintf("UPDATE examinee_pic SET pic7_title = %s, `pic7_name` = %s
											WHERE examinee_no = %s",
  									GetSQLValueString($news_pic7[0], "text"),
 									GetSQLValueString($news_pic7[1], "text"),
 				 					GetSQLValueString($_POST['no'], "text")
 	);
 	// echo "$insertSQL_check<br>";
 	// die();
 	mysql_select_db($database_conn_web, $conn_web);
 		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
  	$nums=mysql_affected_rows();
		if($nums==0){
			echo "<script>javascript:alert(".$picname_t[7]."上傳失敗);</script>";
		}
	}
}
//特殊考生1********************

if(!empty($HTTP_POST_FILES['special_pic1'])){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['special_pic1']['tmp_name']) && $HTTP_POST_FILES['special_pic1']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['special_pic1'];
		$special_pic1=upload_pic('sp1',$_file_);

	//updata
	$insertSQL_check = sprintf("UPDATE examinee_pic SET special_pic_title1 = %s, `special_pic_name1` = %s
											WHERE examinee_no = %s",
										 GetSQLValueString($special_pic1[0], "text"),
										 GetSQLValueString($special_pic1[1], "text"),
										 GetSQLValueString($_POST['no'], "text")
	);
	// echo "$insertSQL_check<br>";
	// die();
	mysql_select_db($database_conn_web, $conn_web);
		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error(""));
		$nums=mysql_affected_rows();
		if($nums==0){
		echo "<script>javascript:alert(".$picname_t[sp1]."上傳失敗);</script>";
	}
	// echo "title1=$newPicname5<br>"; $news_pic_title5
	}
}
//特殊考生2********************

if(!empty($HTTP_POST_FILES['special_pic2'])){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['special_pic2']['tmp_name']) && $HTTP_POST_FILES['special_pic2']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['special_pic2'];
		$special_pic2=upload_pic('sp2',$_file_);

	//updata
	$insertSQL_check = sprintf("UPDATE examinee_pic SET special_pic_title2 = %s, `special_pic_name2` = %s
											WHERE examinee_no = %s",
										 GetSQLValueString($special_pic2[0], "text"),
										 GetSQLValueString($special_pic2[1], "text"),
										 GetSQLValueString($_POST['no'], "text")
	);
	// echo "$insertSQL_check<br>";
	// die();
	mysql_select_db($database_conn_web, $conn_web);
		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error(""));
		$nums=mysql_affected_rows();
		if($nums==0){
		echo "<script>javascript:alert(".$picname_t[sp2]."上傳失敗);</script>";
	}
	// echo "title1=$newPicname5<br>"; $news_pic_title5
	}
}
//特殊考生3********************

if(!empty($HTTP_POST_FILES['special_pic3'])){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['special_pic3']['tmp_name']) && $HTTP_POST_FILES['special_pic3']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['special_pic3'];
		$special_pic3=upload_pic('sp3',$_file_);

	//updata
	$insertSQL_check = sprintf("UPDATE examinee_pic SET special_pic_title3 = %s, `special_pic_name3` = %s
											WHERE examinee_no = %s",
										 GetSQLValueString($special_pic3[0], "text"),
										 GetSQLValueString($special_pic3[1], "text"),
										 GetSQLValueString($_POST['no'], "text")
	);
	// echo "$insertSQL_check<br>";
	// die();
	mysql_select_db($database_conn_web, $conn_web);
		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error(""));
		$nums=mysql_affected_rows();
		if($nums==0){
		echo "<script>javascript:alert(".$picname_t[sp3]."上傳失敗);</script>";
	}
	// echo "title1=$newPicname5<br>"; $news_pic_title5
	}
}
//改名********************

if(!empty($HTTP_POST_FILES['rename_pic'])){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['rename_pic']['tmp_name']) && $HTTP_POST_FILES['rename_pic']['error'] == 0){


		$_file_ = $HTTP_POST_FILES['rename_pic'];
		$rename_pic=upload_pic('rename',$_file_);

	$insertSQL_check = sprintf("UPDATE examinee_pic SET rename_pic_title = %s, `rename_pic_name` = %s
											WHERE examinee_no = %s",
										 GetSQLValueString($rename_pic[0], "text"),
										 GetSQLValueString($rename_pic[1], "text"),
										 GetSQLValueString($_POST['no'], "text")
	);
	// echo "$insertSQL_check<br>";
	// die();
	mysql_select_db($database_conn_web, $conn_web);
		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
		$nums=mysql_affected_rows();
		if($nums==0){
		echo "<script>javascript:alert(".$picname_t[rename]."上傳失敗);</script>";
	}
}

	// echo "title1=$newPicname5<br>"; $news_pic_title5
}

// die();
//各種check END

?>


<?php


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {

  $allSubjects=$_POST['Subjects'];
  $allSubjects= implode(',' , $allSubjects);

 $insertSQL = sprintf("UPDATE examinee SET birthday=%s, sex=%s, email=%s, phone=%s, local_call=%s, Area=%s, cityarea=%s, cuszip=%s, cusadr=%s, per_id=%s,
 		category=%s, exarea=%s, school=%s, Grade=%s, Student_ID=%s, Department=%s, contact=%s, contact_ph=%s, pic_title=%s, pic_name=%s, date=%s , certificate=%s
 		WHERE id=%s AND no=%s",
                       GetSQLValueString($_POST['birthday'], "text"),
					   // GetSQLValueString($_POST['username'], "text"),
                       // GetSQLValueString($_POST['uname'], "text"),
//  					   GetSQLValueString($_POST['eng_uname'], "text"),//update by coway 2016.8.12
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone1']."-".$_POST['phone2'], "text"),
                       GetSQLValueString($_POST['local_call'], "text"),
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
					   GetSQLValueString($_POST['Department'], "text"),
 					   GetSQLValueString($_POST['contact'], "text"),
 					   GetSQLValueString($_POST['contact_ph'], "text"),
					   GetSQLValueString($news_pic_title, "text"),
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($_POST['date'], "date"),
					   GetSQLValueString($_POST['certificate'], "text"),
					   GetSQLValueString($_POST['id'], "text"),
 					   GetSQLValueString($_POST['no'], "text"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());

  $updateGoTo = "examOut.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn_web, $conn_web);
//update by coway 2016.8.12
// $query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s ORDER BY SUBSTR( id, 3, 4 ) DESC , SUBSTR( id, 2, 9 ) DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"));
$query_web_examinee = sprintf("SELECT * FROM examinee,examinee_pic WHERE examinee.username = %s AND examinee.no = examinee_pic.examinee_no ORDER BY examinee.no DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"));
$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
$row_web_examinee = mysql_fetch_assoc($web_examinee);
$totalRows_web_member = mysql_num_rows($web_examinee);

//取得報考資格 add by coway 2016.8.18
mysql_select_db($database_conn_web, $conn_web);
$query_web_allguideC = sprintf("SELECT * FROM allguide WHERE up_no='ID' and no=%s " , GetSQLValueString($row_web_examinee['cert_no'], "text"));
$web_allguideC = mysql_query($query_web_allguideC, $conn_web) or die(mysql_error());
$row_web_allguideC = mysql_fetch_assoc($web_allguideC);

if($row_web_examinee["status"] == '0'){
	$up_no ='EA2';
}else $up_no ='EA';

mysql_select_db($database_conn_web, $conn_web);
$query_web_allguide = sprintf("SELECT * FROM allguide Where up_no= %s AND nm= %s AND data2= %s", GetSQLValueString($up_no, "text"),GetSQLValueString($row_web_examinee['exarea'], "text"), GetSQLValueString($row_web_examinee['exarea_note'], "text"));
$web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
$row_allguide = mysql_fetch_assoc($web_allguide);


$phone_num= array();
  $phone_check=isPhone($row_web_examinee['phone']);
  if($phone_check[0]){
	  if($phone_check[1]=='1'){
		   array_push($phone_num,substr($row_web_examinee['phone'],0,4),substr($row_web_examinee['phone'],5,3).substr($row_web_examinee['phone'],9,3));
	  }else{
		   array_push($phone_num,substr($row_web_examinee['phone'],0,4),substr($row_web_examinee['phone'],-6));
	  }
  }
?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改資料</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="修改報名資料" />
<meta name="keywords" content="修改報名資料" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />

<script language=javascript src="address.js"></script><!--引入郵遞區號.js檔案-->
<link rel="stylesheet" href="./css/dhtmlgoodies_calendar.css" />
<script src="./js/dhtmlgoodies_calendar.js"></script>
<script src="Scripts/sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="Scripts/sweetalert2/dist/sweetalert2.min.css">
<script type="text/javascript">

//電話自動換下一格
function setBlur(obj,target2)
{
var target =document.getElementById(target2);
 if( obj.value.length ==obj.getAttribute('maxlength'))
     {
         target.focus();
     }
 return;
}


    function SaveAlert(){
		// 判斷是否上傳照片 BlueS 20180308
		var check =0;
		// var phone11 = phone1.value;
		// var phone2 = phone2.value;
		if(phone1.value=="" || phone2.value==""){
			swal("電話填寫不完整。");
			window.event.returnValue=false;
		}
        if(eng_uname.value=="" ){
			swal("英文姓名未填。");
			window.event.returnValue=false;
		}
        if(email.value=="" ){
			swal("E-mail未填。");
			window.event.returnValue=false;
		}else{
            emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
            var check_mail=email.value;
            if(check_mail.search(emailRule)== -1){
                swal("填入無效E-mail");
                window.event.returnValue=false;
            }
        }
        if(birthday.value=="" ){
			swal("生日未填。");
			window.event.returnValue=false;
		}
        if(cusadr.value=="" ){
			swal("地址未填。");
			window.event.returnValue=false;
		}
        if(contact.value=="" ){
			swal("緊急聯絡人未填。");
			window.event.returnValue=false;
		}
        if(contact_ph.value=="" ){
			swal("緊急聯絡人電話未填。");
			window.event.returnValue=false;
		}
        if(Department.value=="" ){
			swal("就讀科系未填。");
			window.event.returnValue=false;
		}

	}

</script>

</head>

<body  background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="exam" align="center">
    <form id="form3" name="form3" method="POST" enctype="multipart/form-data" action="<?php echo $editFormAction; ?>" >
      <table width="540" border="0" cellspacing="0" cellpadding="0" >
        <tr>
          <td width="25" align="left"><img src="images/board03.gif" /></td>
          <td width="505" align="left" background="images/board04.gif">&nbsp; <span class="font_black">親愛的考生[</span><span class="font_red">&nbsp;<?php echo $row_web_examinee['username']; ?> &nbsp;</span><span class="font_black">]請確認下方您填寫的報名資料~~</span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="540" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="105" height="30" align="right" class="board_add">姓名：</td>
          <td width="458" align="left" class="board_add"><label><?php echo $row_web_examinee['uname']; ?>
            <!-- <input name="uname" type="text" id="uname" value="<?php echo $row_web_examinee['uname']; ?>" /> -->
          </label><span class="font_red">* </span></td>
        </tr>
        <tr>
          <td width="82" height="30" align="right" class="board_add">英文姓名：</td>
          <td width="458" align="left" class="board_add"><label>
          <?php
	          list($firstname, $lastname, $lastname2) = explode(" ", $row_web_examinee['eng_uname']);
		          if($firstname !=""){
		          	$eng_name="$firstname, $lastname $lastname2";
		          }
	          //echo $eng_name;  ?>
            <input name="eng_uname" type="text" id="eng_uname" value="<?php echo $eng_name;//$row_web_examinee['eng_uname']; ?>" readonly="readonly"/>
          </label><span class="font_red">* </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">E-mail：</td>
          <td align="left" class="board_add"><label>
            <input name="email" type="text" id="email" value="<?php echo $row_web_examinee['email']; ?>" size="35" />
          </label><span class="font_red">* </span><br />
		<span class="font_black">請勿使用會檔信的yahoo、pchome信箱，以免收不到信。</span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">性別：</td>
          <td align="left" class="board_add"><label>
            <input <?php if (!(strcmp($row_web_examinee['sex'],"男"))) {echo "checked=\"checked\"";} ?> name="sex" type="radio" id="radio" value="男" checked="checked" />
          男
          <input <?php if (!(strcmp($row_web_examinee['sex'],"女"))) {echo "checked=\"checked\"";} ?> type="radio" name="sex" id="radio2" value="女" />
          女&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</label>

          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">出生年月日：</td>
          <td align="left" class="board_add"><label>
            <input name="birthday" type="text" id="birthday" value="<?php echo $row_web_examinee['birthday']; ?>" />
            <input type="button" value="Cal" onclick="displayCalendar(birthday,'yyyy-mm-dd',this)">
          格式為：YYYY-MM-DD</label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">聯絡電話：</td>
          <td align="left" class="board_add"><label>手機-
            <input onkeyup="value=value.replace(/[^\d]/g,'');setBlur(this,'phone2');" name="phone1" type="text" id="phone1" style="width: 40px;" maxlength="4"  value="<?php echo $phone_num[0] ?>" />-
            <input onkeyup="value=value.replace(/[^\d]/g,'')" name="phone2" type="text" id="phone2" style="width: 77px;" maxlength="6" value="<?php echo $phone_num[1] ?>" /><span class="font_red">*</span>
        </label><br>
          <label>市話-
            <input  name="local_call" type="text" id="local_call" style="width: 127px;"  value="<?php echo $row_web_examinee['local_call'] ?>" />
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">身分證字號：</td>
          <td align="left" class="board_add"><label>
            <?php echo $row_web_examinee['per_id']; ?><input name="per_id" type="hidden" id="per_id" value="<?php echo $row_web_examinee['per_id']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">郵遞區號：</td>
          <td align="left" class="board_add">
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
          <td height="30" align="right" class="board_add">詳細地址：</td>
          <td align="left" class="board_add"><span class="bs">
            <input name="cusadr" type="text" id="cusadr" value="<?php echo $row_web_examinee['cusadr']; ?>" size="60" />
          </span></td>
        </tr>
        <tr>
          <td height="30" align="right" colspan="2" class="board_add">=========================================================================================</td>
        </tr>
        <!-- <tr>
          <td height="30" align="right" class="board_add">教師證號碼：</td>
          <td align="left" class="board_add">
           <label>
            <input name="certificate" type="text" id="certificate" value="<?php echo $row_web_examinee['certificate']; ?>" />
          </label>
            </td>
        </tr> -->
        <tr>
          <td height="30" align="right" class="board_add">報考資格：</td>
          <td align="left" class="board_add">
          <?php echo $row_web_allguideC['nm'];?>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">報名領域：</td>
          <td align="left" class="board_add">
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
          <td height="30" align="right" class="board_add">評量考區：</td>
          <td align="left" class="board_add">
          <?php echo $row_allguide['note']." ， ".$row_allguide['data1'];?>
           <?php //if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {echo "北部";} ?>
           <?php //if (!(strcmp($row_web_examinee['exarea'],"Central"))) {echo "中部";} ?>
           <?php //if (!(strcmp($row_web_examinee['exarea'],"Southern"))) {echo "南部";} ?>
           <?php //if (!(strcmp($row_web_examinee['exarea'],"Eastern"))) {echo "東部";} ?>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">就讀學校：</td>
          <td align="left" class="board_add">
          <select name="school">
				<option value="01_國立臺灣藝術大學" <?php if (!(strcmp($row_web_examinee['school'],"01_國立臺灣藝術大學"))) {echo "selected=\"selected\"";} ?>>國立臺灣藝術大學</option>
                <option value="02_文藻外語大學"  <?php if (!(strcmp($row_web_examinee['school'],"02_文藻外語大學"))) {echo "selected=\"selected\"";} ?>>文藻外語大學</option>
                <option value="03_國立臺東大學"  <?php if (!(strcmp($row_web_examinee['school'],"03_國立臺東大學"))) {echo "selected=\"selected\"";} ?> >國立臺東大學</option>
                <option value="04_國立東華大學" <?php if (!(strcmp($row_web_examinee['school'],"04_國立東華大學"))) {echo "selected=\"selected\"";} ?> >國立東華大學</option>
                <option value="05_國立臺北教育大學" <?php if (!(strcmp($row_web_examinee['school'],"05_國立臺北教育大學"))) {echo "selected=\"selected\"";} ?> >國立臺北教育大學</option>
                <option value="06_輔仁大學" <?php if (!(strcmp($row_web_examinee['school'],"06_輔仁大學"))) {echo "selected=\"selected\"";} ?> >輔仁大學</option>
                <option value="07_南臺科技大學" <?php if (!(strcmp($row_web_examinee['school'],"07_南臺科技大學"))) {echo "selected=\"selected\"";} ?> >南臺科技大學</option>
                <option value="08_國立屏東大學" <?php if (!(strcmp($row_web_examinee['school'],"08_國立屏東大學"))) {echo "selected=\"selected\"";} ?> >國立屏東大學</option>
                <option value="09_靜宜大學" <?php if (!(strcmp($row_web_examinee['school'],"09_靜宜大學"))) {echo "selected=\"selected\"";} ?> >靜宜大學</option>
                <option value="10_國立清華大學" <?php if (!(strcmp($row_web_examinee['school'],"10_國立清華大學"))) {echo "selected=\"selected\"";} ?> >國立清華大學</option>
                <option value="11_國立臺南大學" <?php if (!(strcmp($row_web_examinee['school'],"11_國立臺南大學"))) {echo "selected=\"selected\"";} ?> >國立臺南大學</option>
                <option value="12_國立高雄師範大學" <?php if (!(strcmp($row_web_examinee['school'],"12_國立高雄師範大學"))) {echo "selected=\"selected\"";} ?> >國立高雄師範大學</option>
                <option value="13_國立臺中教育大學" <?php if (!(strcmp($row_web_examinee['school'],"13_國立臺中教育大學"))) {echo "selected=\"selected\"";} ?> >國立臺中教育大學</option>
                <option value="14_臺北市立大學" <?php if (!(strcmp($row_web_examinee['school'],"14_臺北市立大學"))) {echo "selected=\"selected\"";} ?> >臺北市立大學</option>
                <option value="15_國立嘉義大學" <?php if (!(strcmp($row_web_examinee['school'],"15_國立嘉義大學"))) {echo "selected=\"selected\"";} ?> >國立嘉義大學</option>
                <option value="17_國立臺灣海洋大學" <?php if (!(strcmp($row_web_examinee['school'],"17_國立臺灣海洋大學"))) {echo "selected=\"selected\"";} ?> >國立臺灣海洋大學</option>

           </select>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">年級：</td>
          <td align="left" class="board_add">
          <label>
            <input <?php if (!(strcmp($row_web_examinee['Grade'],"1"))) {echo "checked=\"checked\"";} ?> name="Grade" type="radio" id="radio1" value="1" checked="checked" />
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
          <input <?php if (!(strcmp($row_web_examinee['Grade'],"7"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio7" value="7" />
          已畢業
          </label>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">學號：</td>
          <td align="left" class="board_add"><label>
            <input type="text" name="Student_ID" id="Student_ID" value="<?php echo $row_web_examinee['Student_ID']; ?>" />(已畢業者請填畢業時之學號)
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">就讀科系：</td>
          <td align="left" class="board_add"><label>
            <input type="text" name="Department" id="Department" value="<?php echo $row_web_examinee['Department']; ?>" />(已畢業者請填最高學歷之就讀科系)
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">緊急聯絡人：</td>
          <td align="left" class="board_add" colspan="2">
          <label><input name="contact" type="text" id="contact" value="<?php echo $row_web_examinee['contact']; ?>" /></label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">緊急聯絡人<br />電話：</td>
          <td align="left" class="board_add" colspan="2">
          <label><input name="contact_ph" type="text" id="contact_ph" value="<?php echo $row_web_examinee['contact_ph']; ?>" /></label></td>
        </tr>
        <tr>
        <td height="30" align="right" class="board_add">大頭照圖片：</td>
         <td align="left" class="board_add"><span class="table_lineheight">
          <?php /*START_PHP_SIRFCIT*/ if ($row_web_examinee['pic_name']!=""){ ?>
          <a href="editpic.php?id=<?php echo $row_web_examinee['pic_name']; ?>"><img src="images/examinee/<?php echo $row_web_examinee['pic_name']; ?>" alt="" name="pic" width="70" id="pic" /></a>
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
			 <!-- 各種check圖檔 BlueS 20180313 -->
			 <!-- 1 START -->
			 <td height="30" align="right" class="board_add"><?PHP echo $picname_t[1]; ?>：</td>
			 <td align="left" class="board_add"><span class="table_lineheight">
				 <?php /*START_PHP_SIRFCIT*/ if ($row_web_examinee['pic1_name']!=""){ ?>
				 <a href="editpic.php?id=<?php echo $row_web_examinee['pic1_name']; ?>"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic1_name']; ?>" alt="" name="pic" width="70" id="pic" /></a>
				 <?php } /*END_PHP_SIRFCIT*/ ?>
				 <input name="oldPic1" type="hidden" id="oldPic1" value="<?php echo $row_web_examinee['pic1_name']; ?>" />
				 <input name="oldPictitle" type="hidden" id="oldPic1" value="<?php echo $row_web_examinee['pic1_title']; ?>" />
				 <?php echo $row_web_examinee['pic1_title']; ?><br />
				 <label>
					 <input type="file" name="news_pic1" id="news_pic1" />
				 </label>
				 <br />
				 <span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
			</td>
			<!-- 2 START -->
		</tr>
		<tr>
			<td height="30" align="right" class="board_add"><?PHP echo $picname_t[2]; ?>：</td>
			 <td align="left" class="board_add"><span class="table_lineheight">
				<?php /*START_PHP_SIRFCIT*/ if ($row_web_examinee['pic2_name']!=""){ ?>
				<a href="editpic.php?id=<?php echo $row_web_examinee['pic2_name']; ?>"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic2_name']; ?>" alt="" name="pic" width="70" id="pic" /></a>
				<?php } /*END_PHP_SIRFCIT*/ ?>
				<input name="oldPic2" type="hidden" id="oldPic2" value="<?php echo $row_web_examinee['pic2_name']; ?>" />
				<input name="oldPictitle" type="hidden" id="oldPic2" value="<?php echo $row_web_examinee['pic2_title']; ?>" />
				<?php echo $row_web_examinee['pic2_title']; ?><br />
				<label>
					<input type="file" name="news_pic2" id="news_pic2" />
				</label>
				<br />
				<span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
		 </td>
		 <!-- 3 START-->
	 </tr>
	 <?php  if ($row_web_examinee['pic3_name']!=""){ ?>
	 <tr>
		 <td height="30" align="right" class="board_add" style="width: 160px;"><?PHP echo $picname_t[3]; ?>：</td>
			<td align="left" class="board_add"><span class="table_lineheight">

			 <a href="editpic.php?id=<?php echo $row_web_examinee['pic3_name']; ?>"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic3_name']; ?>" alt="" name="pic" width="70" id="pic" /></a>

			 <input name="oldPic3" type="hidden" id="oldPic3" value="<?php echo $row_web_examinee['pic3_name']; ?>" />
			 <input name="oldPictitle" type="hidden" id="oldPic3" value="<?php echo $row_web_examinee['pic3_title']; ?>" />
			 <?php echo $row_web_examinee['pic3_title']; ?><br />
			 <label>
				 <input type="file" name="news_pic3" id="news_pic3" />
			 </label>
			 <br />
			 <span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
		</td>
	</tr>
	<?php }?>
	<!-- 4 START -->
	<?php /*START_PHP_SIRFCIT*/ if ($row_web_examinee['pic4_name']!=""){ ?>
	<tr>
		<td height="30" align="right" class="board_add"><?PHP echo $picname_t[4]; ?>：</td>
		 <td align="left" class="board_add"><span class="table_lineheight">

			<a href="editpic.php?id=<?php echo $row_web_examinee['pic4_name']; ?>"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic4_name']; ?>" alt="" name="pic" width="70" id="pic" /></a>

			<input name="oldPic4" type="hidden" id="oldPic4" value="<?php echo $row_web_examinee['pic4_name']; ?>" />
			<input name="oldPictitle" type="hidden" id="oldPic4" value="<?php echo $row_web_examinee['pic4_title']; ?>" />
			<?php echo $row_web_examinee['pic4_title']; ?><br />
			<label>
				<input type="file" name="news_pic4" id="news_pic4" />
			</label>
			<br />
			<span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
	 </td>
	 </tr>
	 <?php } /*END_PHP_SIRFCIT*/ ?>
	 <!-- 5 START -->
<?php /*START_PHP_SIRFCIT*/ if ($row_web_examinee['pic5_name']!=""){ ?>
	 <tr>
	 	<td height="30" align="right" class="board_add"><?PHP echo $picname_t[5]; ?>：</td>
	 	 <td align="left" class="board_add"><span class="table_lineheight">

	 		<a href="editpic.php?id=<?php echo $row_web_examinee['pic5_name']; ?>"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic5_name']; ?>" alt="" name="pic" width="70" id="pic" /></a>

	 		<input name="oldPic5" type="hidden" id="oldPic5" value="<?php echo $row_web_examinee['pic5_name']; ?>" />
	 		<input name="oldPictitle" type="hidden" id="oldPic5" value="<?php echo $row_web_examinee['pic5_title']; ?>" />
	 		<?php echo $row_web_examinee['pic5_title']; ?><br />
	 		<label>
	 			<input type="file" name="news_pic5" id="news_pic5" />
	 		</label>
	 		<br />
	 		<span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
	  </td>
  </tr>
	<?php } ?>
    <?php if ($row_web_examinee['pic6_name']!=""){ ?>
    	 <tr>
    	 	<td height="30" align="right" class="board_add"><?PHP echo $picname_t[6]; ?>：</td>
    	 	 <td align="left" class="board_add"><span class="table_lineheight">

    	 		<a href="editpic.php?id=<?php echo $row_web_examinee['pic6_name']; ?>"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic6_name']; ?>" alt="" name="pic" width="70" id="pic" /></a>

    	 		<input name="oldPic6" type="hidden" id="oldPic6" value="<?php echo $row_web_examinee['pic6_name']; ?>" />
    	 		<input name="oldPictitle" type="hidden" id="oldPic6" value="<?php echo $row_web_examinee['pic6_title']; ?>" />
    	 		<?php echo $row_web_examinee['pic6_title']; ?><br />
    	 		<label>
    	 			<input type="file" name="news_pic6" id="news_pic6" />
    	 		</label>
    	 		<br />
    	 		<span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
    	  </td>
      </tr>
    	<?php } ?>
        <?php if ($row_web_examinee['pic7_name']!=""){ ?>
        	 <tr>
        	 	<td height="30" align="right" class="board_add"><?PHP echo $picname_t[5]; ?>：</td>
        	 	 <td align="left" class="board_add"><span class="table_lineheight">

        	 		<a href="editpic.php?id=<?php echo $row_web_examinee['pic7_name']; ?>"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic7_name']; ?>" alt="" name="pic" width="70" id="pic" /></a>

        	 		<input name="oldPic5" type="hidden" id="oldPic7" value="<?php echo $row_web_examinee['pic7_name']; ?>" />
        	 		<input name="oldPictitle" type="hidden" id="oldPic7" value="<?php echo $row_web_examinee['pic7_title']; ?>" />
        	 		<?php echo $row_web_examinee['pic7_title']; ?><br />
        	 		<label>
        	 			<input type="file" name="news_pic7" id="news_pic7" />
        	 		</label>
        	 		<br />
        	 		<span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
        	  </td>
          </tr>
        	<?php } /*END_PHP_SIRFCIT*/ ?>

	<!-- special1 START -->
<?php /*START_PHP_SIRFCIT*/ if ($row_web_examinee['special_pic_name1']!=""){ ?>
	<tr>
	 <td height="30" align="right" class="board_add"><?PHP echo $picname_t[sp1]; ?>：</td>
		<td align="left" class="board_add"><span class="table_lineheight">

		 <a href="editpic.php?id=<?php echo $row_web_examinee['special_pic_name1']; ?>"><img src="images/examinee/id_check/<?php echo $row_web_examinee['special_pic_name1']; ?>" alt="" name="pic" width="70" id="pic" /></a>

		 <input name="oldPic_s1" type="hidden" id="oldPic_s1" value="<?php echo $row_web_examinee['special_pic_name1']; ?>" />
		 <input name="oldPictitle" type="hidden" id="oldPic_s1" value="<?php echo $row_web_examinee['special_pic_title1']; ?>" />
		 <?php echo $row_web_examinee['special_pic_title1']; ?><br />
		 <label>
			 <input type="file" name="special_pic1" id="special_pic1" />
		 </label>
		 <br />
		 <span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
	 </td>
 </tr>
 <?php } /*END_PHP_SIRFCIT*/ ?>
 <!-- special2 START -->
<?php /*START_PHP_SIRFCIT*/ if ($row_web_examinee['special_pic_name2']!=""){ ?>
 <tr>
	<td height="30" align="right" class="board_add"><?PHP echo $picname_t[sp2]; ?>：</td>
	 <td align="left" class="board_add"><span class="table_lineheight">

		<a href="editpic.php?id=<?php echo $row_web_examinee['special_pic_name2']; ?>"><img src="images/examinee/id_check/<?php echo $row_web_examinee['special_pic_name2']; ?>" alt="" name="pic" width="70" id="pic" /></a>

		<input name="oldPic_s2" type="hidden" id="oldPic_s2" value="<?php echo $row_web_examinee['special_pic_name2']; ?>" />
		<input name="oldPictitle" type="hidden" id="oldPic_s2" value="<?php echo $row_web_examinee['special_pic_title2']; ?>" />
		<?php echo $row_web_examinee['special_pic_title2']; ?><br />
		<label>
			<input type="file" name="special_pic2" id="special_pic2" />
		</label>
		<br />
		<span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
	</td>
</tr>
<?php } /*END_PHP_SIRFCIT*/ ?>
<!-- special3 START -->
<?php /*START_PHP_SIRFCIT*/ if ($row_web_examinee['special_pic_name3']!=""){ ?>
<tr>
 <td height="30" align="right" class="board_add"><?PHP echo $picname_t[sp3]; ?>：</td>
	<td align="left" class="board_add"><span class="table_lineheight">

	 <a href="editpic.php?id=<?php echo $row_web_examinee['special_pic_name3']; ?>"><img src="images/examinee/id_check/<?php echo $row_web_examinee['special_pic_name3']; ?>" alt="" name="pic" width="70" id="pic" /></a>

	 <input name="oldPic_s3" type="hidden" id="oldPic_s3" value="<?php echo $row_web_examinee['special_pic_name3']; ?>" />
	 <input name="oldPictitle" type="hidden" id="oldPic_s3" value="<?php echo $row_web_examinee['special_pic_title3']; ?>" />
	 <?php echo $row_web_examinee['special_pic_title3']; ?><br />
	 <label>
		 <input type="file" name="special_pic3" id="special_pic3" />
	 </label>
	 <br />
	 <span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
 </td>
</tr>
<?php } /*END_PHP_SIRFCIT*/ ?>
<!-- rename START -->
<?php /*START_PHP_SIRFCIT*/ if ($row_web_examinee['rename_pic_name']!=""){ ?>
<tr>
 <td height="30" align="right" class="board_add"><?PHP echo $picname_t[rename]; ?>：</td>
	<td align="left" class="board_add"><span class="table_lineheight">

	 <a href="editpic.php?id=<?php echo $row_web_examinee['rename_pic_name']; ?>"><img src="images/examinee/id_check/<?php echo $row_web_examinee['rename_pic_name']; ?>" alt="" name="pic" width="70" id="pic" /></a>

	 <input name="oldPic_re" type="hidden" id="oldPic_re" value="<?php echo $row_web_examinee['rename_pic_name']; ?>" />
	 <input name="oldPictitle" type="hidden" id="oldPic_re" value="<?php echo $row_web_examinee['rename_pic_title']; ?>" />
	 <?php echo $row_web_examinee['rename_pic_title']; ?><br />
	 <label>
		 <input type="file" name="rename_pic" id="rename_pic" />
	 </label>
	 <br />
	 <span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
 </td>
</tr>
<?php } /*END_PHP_SIRFCIT*/ ?>
        <tr>
          <td height="40" colspan="2" align="center"><label>
            <?php if($row_web_examinee['allow'] == '0'){?><input type="submit" name="button" id="button" value="完成修改" onclick="SaveAlert()" />  <?php }?>
            <input name="id" type="hidden" id="id" value="<?php echo $row_web_examinee['id']; ?>" />
            <input name="no" type="hidden" id="no" value="<?php echo $row_web_examinee['no']; ?>" />
            <input name="username" type="hidden" id="username" value="<?php echo $row_web_examinee['username']; ?>" />
            <input name="exarea" type="hidden" id="username" value="<?php echo $row_web_examinee['exarea']; ?>" />
            <input name="date" type="hidden" id="date" value="<? echo date("Y-m-d H:i:s");?>" />
          </label>
          <!-- <input type="button" name="submit" value="回上一頁" onClick=window.history.back();> -->
          </td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form3" />
    </form>
  </div>
  <div id="main4"></div>
<?php include("footer.php"); ?>
</div>
</body>
</html>
<?php
mysql_free_result($web_examinee);
?>
