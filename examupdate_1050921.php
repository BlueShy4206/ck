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
		
		if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_PIC_FOLDER) && is_writeable(DESTINATION_PIC_FOLDER)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			$newPicname=date("YmdHis.").$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱
			if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER . "/" . $newPicname)){//修改檔案名稱
				@unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它
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
  $allSubjects=$_POST['Subjects'];
  $allSubjects= implode(',' , $allSubjects);		
	
 $insertSQL = sprintf("UPDATE examinee SET birthday=%s, username=%s, uname=%s, sex=%s, email=%s, phone=%s, Area=%s, cityarea=%s, cuszip=%s, cusadr=%s, per_id=%s,  
 		category=%s, exarea=%s, school=%s, Grade=%s, Student_ID=%s, Department=%s, contact=%s, contact_ph=%s, pic_title=%s, pic_name=%s, date=%s , certificate=%s 
 		WHERE id=%s AND no=%s",
                       GetSQLValueString($_POST['birthday'], "text"),
					   GetSQLValueString($_POST['username'], "text"),					   
                       GetSQLValueString($_POST['uname'], "text"),
//  					   GetSQLValueString($_POST['eng_uname'], "text"),//update by coway 2016.8.12
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
$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s ORDER BY no DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"));
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

<script language=javascript src="address.js"></script><!--引入郵遞區號.js檔案-->
<link rel="stylesheet" href="./css/dhtmlgoodies_calendar.css" />
<script src="./js/dhtmlgoodies_calendar.js"></script>
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
          <td width="25" align="left"><img src="images/board03.gif" /></td>
          <td width="505" align="left" background="images/board04.gif">&nbsp; <span class="font_black">親愛的考生[</span><span class="font_red">&nbsp;<?php echo $row_web_examinee['username']; ?> &nbsp;</span><span class="font_black">]請確認下方您填寫的報名資料~~</span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="540" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="82" height="30" align="right" class="board_add">姓名：</td>
          <td width="458" align="left" class="board_add"><label>
            <input name="uname" type="text" id="uname" value="<?php echo $row_web_examinee['uname']; ?>" />
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
          <td align="left" class="board_add"><label>
            <input name="phone" type="text" id="phone" value="<?php echo $row_web_examinee['phone']; ?>" />
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
          <td height="30" align="right" class="board_add">報名科目：</td>
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
                <option value="10_國立新竹教育大學" <?php if (!(strcmp($row_web_examinee['school'],"10_國立新竹教育大學"))) {echo "selected=\"selected\"";} ?> >國立新竹教育大學</option>
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
          <td height="40" colspan="2" align="center"><label>
            <?php if($row_web_examinee['allow'] == '0'){?><input type="submit" name="button" id="button" value="完成修改" />  <?php }?>
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
