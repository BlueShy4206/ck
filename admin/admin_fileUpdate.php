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

<?php require_once('../Connections/conn_web.php'); ?>

<?php
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_FILE_SIZE",51200000);
define("DESTINATION_FILE_FOLDER", "../file/");
define("no_error", "admin_file.php");
define("yes_error", "admin_file.php");
$_accepted_FILE_extensions_ = "rar,doc,docx,pdf,ppt,pptx";
if(strlen($_accepted_FILE_extensions_) > 0){
	$_accepted_FILE_extensions_ = @explode(",",$_accepted_FILE_extensions_);
} else {
	$_accepted_FILE_extensions_ = array();
}
/*	modify */
@$file_title=$_POST["old_file_title"];
@$newFilename=$_POST["old_file_name"]; //變數$newPicname先儲存之前舊圖片檔名，如果沒有更新圖片，news_pic圖片欄位就繼續存入舊圖檔
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
		

$file_title=$_file_['name'];


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
				@unlink('../file/'.$_POST["old_file_name"]);//依據傳過來的舊圖檔名，指定路徑刪				
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE file SET file_title=%s, file_name=%s, file_date=%s WHERE file_id=%s",
                       GetSQLValueString($file_title, "text"),
                       GetSQLValueString($newFilename, "text"),
                       GetSQLValueString($_POST['file_date'], "date"),
                       GetSQLValueString($_POST['file_id'], "int"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());

  $updateGoTo = "admin_file.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_web_news = "-1";
if (isset($_GET['file_id'])) {
  $colname_web_news = $_GET['file_id'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_news = sprintf("SELECT * FROM
file WHERE file_id = %s", GetSQLValueString($colname_web_news, "int"));
$web_news = mysql_query($query_web_news, $conn_web) or die(mysql_error());
$row_web_news = mysql_fetch_assoc($web_news);
$totalRows_web_news = mysql_num_rows($web_news);
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
<div id="main">
  <div id="main1"></div>
  <div align="center">
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
    <table width="760" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="134" align="left">親愛的 <span class="font_red">管理員</span>您好 </td>
        <td width="616" align="left" background="../images/board04.gif">&nbsp;</td>
        <td width="10" align="right">&nbsp;</td>
      </tr>
    </table>
    <table width="769" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="130" height="20" align="left" class="board_add">張 貼 日 期：</td>
        <td align="left" class="board_add"><label>
          <input name="file_date" type="text" id="file_date" value="<?php echo $row_web_news['file_date']; ?>" class="Wdate" onFocus="WdatePicker()"/>
          
          </label></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">更 新 檔 案：</td>
        <td align="left" class="board_add"><span class="table_lineheight">原始檔案：<a href="../file/<?php echo $row_web_news['file_name']; ?>"><?php echo $row_web_news['file_title']; ?></a><br />
          <input name="old_file_title" type="hidden" id="oldfile" value="<?php echo $row_web_news['file_title']; ?>" />
          <input name="old_file_name" type="hidden" id="oldfile2" value="<?php echo $row_web_news['file_name']; ?>" />           
          <label>
            <input type="file" name="file_name" id="file_name" />
            </label><br />
          <span class="font_red">**接受檔案格式為：rar、doc、docx、pdf、ppt、pptx，**檔案大小請勿超過50MB!!</span></span></td>
      </tr>
      </table>
    <br />
    <p>
      <label>
        <br />
        <input type="submit" name="button" id="button" value="更新內容" />
      </label>
      <script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<input name="Submit" type="button" onclick="MM_goToURL('parent','admin_file.php');return document.MM_returnValue" value="回上一頁" />

      <input name="file_id" type="hidden" id="file_id" value="<?php echo $row_web_news['file_id']; ?>" />
      <br />
      <br />
</p>
    <input type="hidden" name="MM_update" value="form1" />
    </form>
  </div>
  <div id="main4"></div>
</div>
</body>
</html>
<?php
mysql_free_result($web_news);
?>
