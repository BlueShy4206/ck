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
$_accepted_FILE_extensions_ = "xls,xlsx";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
include 'Excel/PHPExcel.php';
  $file='frist/'.$newFilename;
  
try {
        $objPHPExcel = PHPExcel_IOFactory::load($file);
    } catch(Exception $e) {
        die('Error loading file "'.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage());
    }
    
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

   foreach($sheetData as $key => $col)
    {
        $arr="";
		
        foreach ($col as $colkey => $colvalue) {
			 $arr=$arr."{$colvalue},^";
            			
	    }
				
		$score=explode(",^",$arr);		
		if($key != 1){		
        mysql_select_db($database_conn_web, $conn_web);
        $query_web_member = sprintf("SELECT id FROM forfirst WHERE id LIKE %s ORDER BY id DESC LIMIT 0,1", GetSQLValueString($score[1], "text"));
        $web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
        $row_web_member = mysql_fetch_assoc($web_member);
        $totalRows_web_member = mysql_num_rows($web_member);
        		   
		if($totalRows_web_member == 0){
       
       
       //變數$password取得新的隨機密碼
       $password8=getRandNewPassword();
	
	    
	   $insertSQL = sprintf("INSERT INTO forfirst (id, password, seepass, name, school, Student_ID, Department, Grade, sex) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($score[1], "text"),
                       GetSQLValueString(md5($password8), "text"),
					   GetSQLValueString($password8, "text"),
					   GetSQLValueString($score[2], "text"),
					   GetSQLValueString($score[4], "text"),
                       GetSQLValueString($score[6], "text"),
					   GetSQLValueString($score[7], "text"),
					   GetSQLValueString($score[5], "text"),
					   GetSQLValueString($score[3], "text"));
       
       mysql_select_db($database_conn_web, $conn_web);
       $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());
	   
	   $memerr=$memerr.$score[1]."、";  //有新增的帳號
	   $_SESSION[memid]=$memerr;
	   $mempass=$mempass.$password8."、"; //有新增的密碼
	   $_SESSION[mempass]=$mempass;
        }else{
			
		$updateSQL = sprintf("UPDATE forfirst SET name=%s, school=%s, Student_ID=%s, Department=%s, Grade=%s, sex=%s, chinese=%s, math=%s, social=%s, physical=%s WHERE id=%s",
                       GetSQLValueString($score[2], "text"),
                       GetSQLValueString($score[4], "text"),
					   GetSQLValueString($score[6], "text"),
					   GetSQLValueString($score[7], "text"),
					   GetSQLValueString($score[5], "text"),
                       GetSQLValueString($score[3], "text"),
					   GetSQLValueString($score[8], "text"),
					   GetSQLValueString($score[9], "text"),
					   GetSQLValueString($score[10], "text"),
					   GetSQLValueString($score[11], "text"),
					   GetSQLValueString($score[1], "text"));
        
        mysql_select_db($database_conn_web, $conn_web);
        $Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());		         
		   }
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
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">第一次批次匯入</span></td>
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
        <td width="98" height="20" align="left" class="board_add">請匯入 新增 或 更新 的</td>
        <td width="442" align="left" class="board_add"><span class="font_red">Excel</span> 檔</td>
      </tr>
      <tr>
        <td height="20" align="right" class="board_add">資 料 檔 案：</td>
        <td align="left" class="board_add"><p class="table_lineheight">
          <label>
            <input type="file" name="file_name" id="file_name" />
          </label>
          <br />
        <span class="font_red">**接受格式：</span><span class="font_red">xls、xlsx，</span><span class="font_red">大小目前限制30MB!!</span></p></td>
      </tr>
            
      <tr>
        <td height="20" align="right" class="board_add">範 例 檔 案：</td>
        <td align="left" class="board_add"><a href="frist/exexcel_frist.xls">Excel範例檔</a>
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
        $password_len = 8;//指定隨機密碼字串字數
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