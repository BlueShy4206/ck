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
//	Pure PHP FILE Upload version 1.1
//	-------------------------------------------
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_FILE_SIZE",51200000);
define("DESTINATION_FILE_FOLDER", "frist/");
define("no_error", "admin_scoreok.php");
define("yes_error", "admin_scoreok.php");
$_accepted_FILE_extensions_ = "xls";
if(strlen($_accepted_FILE_extensions_) > 0){
	$_accepted_FILE_extensions_ = @explode(",",$_accepted_FILE_extensions_);
} else {
	$_accepted_FILE_extensions_ = array();
}
/*	modify */
if(!empty($HTTP_POST_FILES['file_name'])){
	if(is_uploaded_file($HTTP_POST_FILES['file_name']['tmp_name']) && $HTTP_POST_FILES['file_name']['error'] == 0){
		$_file_ = $HTTP_POST_FILES['file_name'];
		$errStr = "";
		$_name_ = $_file_['name'];
		$_type_ = $_file_['type'];
		$_tmp_name_ = $_file_['tmp_name'];
		$_size_ = $_file_['size'];
        header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_FILE_SIZE && MAX_FILE_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$_ext_ = strtolower($_ext_[count($_ext_)-1]);
		

$file_name_title=$_file_['name'];


		if(!in_array($_ext_, $_accepted_FILE_extensions_) && count($_accepted_FILE_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_FILE_FOLDER) && is_writeable(DESTINATION_FILE_FOLDER)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			if(@copy($_tmp_name_,DESTINATION_FILE_FOLDER . "/" . date("YmdHis.").$_ext_)){ //修改自動重新命名
				$newFilename=date("YmdHis.").$_ext_;//變數$newname取得新檔案名，供寫入資料庫
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
<?php require_once('../Connections/conn_web.php'); ?>
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
require_once 'Excel/reader.php';

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('UTF-8');
$data->read('frist/'.$newFilename);
error_reporting(E_ALL ^ E_NOTICE);


for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
	for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
		 $score[$j]=$data->sheets[0]['cells'][$i][$j];
	}
	
	 //$Ticket="15S".$_POST['times'].substr(($score[4]),0,1);
     //mysql_select_db($database_conn_web, $conn_web);
     //$query_web_search = sprintf("SELECT id FROM forfirst WHERE id LIKE %s ORDER BY id DESC LIMIT 0,1", GetSQLValueString("%" . $Ticket . "%", "text"));
     //$web_search = mysql_query($query_web_search, $conn_web) or die(mysql_error());
     //$row_web_search = mysql_fetch_assoc($web_search);
     //$totalRows_web_search = mysql_num_rows($web_search);
     //if($totalRows_web_search == 0){
     //$number=1;
     //$Ticket=$Ticket.sprintf("%05d", $number);
      //}else{
     //$number=substr(($row_web_search['id']),5,5);
     //$number=$number+1;
     //$Ticket=$Ticket.sprintf("%05d", $number);
     //}
 mysql_select_db($database_conn_web, $conn_web);
     $query_web_member = sprintf("SELECT id FROM forfirst WHERE id LIKE %s ORDER BY id DESC LIMIT 0,1", GetSQLValueString($score[2], "text"));
     $web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
     $row_web_member = mysql_fetch_assoc($web_member);
     $totalRows_web_member = mysql_num_rows($web_member);

if($totalRows_web_member == 0){


  //變數$password取得新的隨機密碼
  $password=getRandNewPassword();
	
	$insertSQL = sprintf("INSERT INTO forfirst (id, password, seepass, name, school, Student_ID, Department, Grade, sex) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($score[2], "text"),
                       GetSQLValueString(md5($password), "text"),
					   GetSQLValueString($password, "text"),
					   GetSQLValueString(mb_convert_encoding($score[3],"utf-8","big5"), "text"),
					   GetSQLValueString(mb_convert_encoding($score[5],"utf-8","big5"), "text"),
                       GetSQLValueString(mb_convert_encoding($score[7],"utf-8","big5"), "text"),
					   GetSQLValueString(mb_convert_encoding($score[8],"utf-8","big5"), "text"),
					   GetSQLValueString(mb_convert_encoding($score[6],"utf-8","big5"), "text"),
					   GetSQLValueString(mb_convert_encoding($score[4],"utf-8","big5"), "text"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());
     }else{
		 $insertSQL = sprintf("UPDATE forfirst SET name=%s, school=%s, Student_ID=%s, Department=%s, Grade=%s, sex=%s, chinese=%s, math=%s, social=%s, physical=%s WHERE id=%s",
                       GetSQLValueString(mb_convert_encoding($score[3],"utf-8","big5"), "text"),
                       GetSQLValueString(mb_convert_encoding($score[5],"utf-8","big5"), "text"),
					   GetSQLValueString(mb_convert_encoding($score[7],"utf-8","big5"), "text"),
					   GetSQLValueString(mb_convert_encoding($score[8],"utf-8","big5"), "text"),
					   GetSQLValueString(mb_convert_encoding($score[6],"utf-8","big5"), "text"),
                       GetSQLValueString(mb_convert_encoding($score[4],"utf-8","big5"), "text"),
					   GetSQLValueString($score[9], "text"),
					   GetSQLValueString($score[10], "text"),
					   GetSQLValueString($score[11], "text"),
					   GetSQLValueString($score[12], "text"),
					   GetSQLValueString($score[2], "text"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());		 
		 
	}
  
  
	
	}


  $insertGoTo = "admin_scoreok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn_web, $conn_web);
$query_web_new = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);
$totalRows_web_new = mysql_num_rows($web_new);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理後台</title>



<link href="../web.css" rel="stylesheet" type="text/css" />
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
</head>

<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<body>
<?php include("header.php"); ?>
<div id="main">
<div id="main1"></div>
  <div id="admin_main2">
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
    <table width="540" border="0" cellspacing="0" cellpadding="0" >
     <tr>
        <td width="25" align="left"><img src="../images/board17.gif"/></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">批次匯入</span></td>
        <td width="416" align="left" background="../images/board04.gif"></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    
      <tr>
        <td width="25" align="left"></td>
        <td width="140" align="left">
<div><span class="font_red">管理員</span>您好
 </div>      
        </td>
        <td width="416" align="left" >&nbsp;</td>
               
      </tr>
    </table>
    <table width="550" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="98" height="20" align="left" class="board_add">請 匯 入 Excel 檔</td>
        <td width="442" align="left" class="board_add">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" align="right" class="board_add">資 料 檔 案：</td>
        <td align="left" class="board_add"><p class="table_lineheight">
          <label>
            <input type="file" name="file_name" id="file_name" />
          </label>
          <br />
        <span class="font_red">**接受格式：</span><span class="font_red">xls，</span><span class="font_red">大小目前限制30MB!!</span></p></td>
      </tr>
      <tr>
        <td width="140" height="20" align="right" class="board_add">本次考試為：</td>
        
        <td width="405" align="left" class="board_add"><input name="year" type="text" id="year" value="<?PHP echo substr(($row_web_new['endday']),0,4) ?>" size="8"/>年度第  
          <select name="times">
                              <option value="A" selected="selected">1</option>
                              <option value="B" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"B"))) {echo "selected=\"selected\"";}} ?>>2</option>
                              <option value="C" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"C"))) {echo "selected=\"selected\"";}} ?>>3</option>
                              <option value="D" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"D"))) {echo "selected=\"selected\"";}} ?>>4</option>
                              <option value="E" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"E"))) {echo "selected=\"selected\"";}} ?>>5</option>
                              <option value="F" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"F"))) {echo "selected=\"selected\"";}} ?>>6</option>
                              <option value="G" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"G"))) {echo "selected=\"selected\"";}} ?>>7</option>
                              <option value="H" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"H"))) {echo "selected=\"selected\"";}} ?>>8</option>
                              <option value="I" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"I"))) {echo "selected=\"selected\"";}} ?>>9</option>
                              <option value="J" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"J"))) {echo "selected=\"selected\"";}} ?>>10</option>
                              <option value="K" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"K"))) {echo "selected=\"selected\"";}} ?>>11</option>
                              <option value="L" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"L"))) {echo "selected=\"selected\"";}} ?>>12</option>
                              <option value="M" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"M"))) {echo "selected=\"selected\"";}} ?>>13</option>
                              <option value="N" <?php if(substr(($row_web_new['endday']),0,4)== date("Y"))if (!(strcmp($row_web_new['times'],"N"))) {echo "selected=\"selected\"";} ?>>14</option>
                              <option value="O" <?php if(substr(($row_web_new['endday']),0,4)== date("Y"))if (!(strcmp($row_web_new['times'],"O"))) {echo "selected=\"selected\"";} ?>>15</option>
                              <option value="P" <?php if(substr(($row_web_new['endday']),0,4)== date("Y"))if (!(strcmp($row_web_new['times'],"P"))) {echo "selected=\"selected\"";} ?>>16</option>
                              
                            </select> 
           次</td>
      </tr>
      
      <tr>
        <td height="20" align="right" class="board_add">範 例 檔 案：</td>
        <td align="left" class="board_add"><a href="allin/exexcel.xls">Excel範例檔</a>
       </td>
      </tr>
    </table>
    <label>
      <br />
      <input type="submit" name="button" id="button" value="新增檔案" />&nbsp;&nbsp;
    </label>
    <label>
      <input type="reset" name="button2" id="button2" value="重新填寫" />&nbsp;&nbsp;
    </label>


    <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
               <input type="button" class="style1" onclick="location='logout.php'" value="登出" />
    <br />
     <input name="date" type="hidden" id="date" value="<? echo date("Y-m-d H:i:s");?>" />
    <input type="hidden" name="MM_insert" value="form1" />
    </form>
  </div>
   <div id="admin_main3">
       <? include("right_zone.php");?>
  </div>
  <div id="main4"></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>

<?php 
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