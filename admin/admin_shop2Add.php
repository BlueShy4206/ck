<?
session_start(); //啟動session功能
header("Cache-control:private");//解決session 引起的回上一頁表單被清空
require_once('../imgResize.php');//引用外部縮圖函數頁面 
?>
<?php
//	---------------------------------------------
//	Pure PHP Upload version 1.1
//	-------------------------------------------
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_SIZE",300000);
define("DESTINATION_FOLDER", "../images/shop/");
define("no_error", "admin_shop2.php");
define("yes_error", "admin_shop2Add.php");
$_accepted_extensions_ = "jpg,gif,png";
if(strlen($_accepted_extensions_) > 0){
	$_accepted_extensions_ = @explode(",",$_accepted_extensions_);
} else {
	$_accepted_extensions_ = array();
}
/*	modify */
if(!empty($HTTP_POST_FILES['p_pic'])){ //如果你的上傳檔案欄位不是取p_pic，請將你的欄位名稱取代所有p_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['p_pic']['tmp_name']) && $HTTP_POST_FILES['p_pic']['error'] == 0){
		$_file_ = $HTTP_POST_FILES['p_pic'];
		$errStr = "";
		$_name_ = $_file_['name'];
		$_type_ = $_file_['type'];
		$_tmp_name_ = $_file_['tmp_name'];
		$_size_ = $_file_['size'];
        header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_SIZE && MAX_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$_ext_ = strtolower($_ext_[count($_ext_)-1]);
		if(!in_array($_ext_, $_accepted_extensions_) && count($_accepted_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_FOLDER) && is_writeable(DESTINATION_FOLDER)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			if(@copy($_tmp_name_,DESTINATION_FOLDER . "/" . date("YmdHis.").$_ext_)){ //修改自動重新命名
				$newPicname=date("YmdHis.").$_ext_;//變數$newname取得新檔案名，供寫入資料庫
                /*php製作縮圖及預覽圖*/
                    //製作縮圖
                    $src  = "../images/shop/".$newPicname;        //圖檔來源位置
                    $newSrc = $src;                               //設定縮圖儲存位置及檔名
                    $whLimit = "400";                             //縮圖寬高限制尺寸
                    imgResize($src,$newSrc,$whLimit);          //利用自訂函數製作縮圖
                    //製作預覽圖
                    $src  = "../images/shop/".$newPicname;        //圖檔來源位置
                    $newSrc = "../images/shop/thum/".$newPicname; //設定預覽圖儲存位置及檔名
                    $whLimit = "57";                             //預覽圖寬高限制尺寸
                    imgResize($src,$newSrc,$whLimit);          //利用自訂函數製作預覽圖
                /*php製作縮圖及預覽圖結束*/
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
  $insertSQL = sprintf("INSERT INTO shop2 (shop_id, p_name, p_price, p_open, p_pic, p_content, p_date) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['shop_id'], "int"),
                       GetSQLValueString($_POST['p_name'], "text"),
                       GetSQLValueString($_POST['p_price'], "text"),
                       GetSQLValueString($_POST['p_open'], "text"),
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($_POST['p_content'], "text"),
                       GetSQLValueString($_POST['p_date'], "date"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());

  $insertGoTo = "admin_shop2.php?shop_id=" . $_GET['shop_id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理後台</title>
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="國民小學教師學科知能評量" />
<meta name="keywords" content="國民小學教師學科知能評量" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="../web.css" rel="stylesheet" type="text/css" />
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div align="center">
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
    <table width="760" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="25" align="left"><img src="../images/board11.gif" /></td>
        <td width="725" align="left" background="../images/board04.gif">&nbsp; <span class="font_black">新增商品資料</span></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <table width="760" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="80" height="20" align="left" class="board_add">商 品 名 稱：</td>
        <td width="669" align="left" class="board_add"><label>
          <input name="p_name" type="text" id="p_name" size="40" />
        </label></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">商 品 價 格：</td>
        <td align="left" class="board_add"><label>
          <input name="p_price" type="text" id="p_price" size="15" />
        </label></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">商 品 開 放：</td>
        <td align="left" class="board_add"><label>
          <input name="p_open" type="radio" id="radio" value="Y" checked="checked" />
        開放
        <input type="radio" name="p_open" id="radio2" value="N" />
        不開放</label></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">商 品 圖 片：</td>
        <td align="left" class="board_add"><span class="table_lineheight">
        <label>
          <input type="file" name="p_pic" id="p_pic" />
        </label><br /><span class="font_red">**限制檔案格式為：JPG、GIF、PNG，檔案尺寸不能超過300KB</span></span></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">上 傳 日&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 期：</td>
        <td align="left" class="board_add"><label>
          <input name="p_date" type="text" id="p_date" value="<? echo date('Y-m-d')?>" />
        </label></td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="board_add">商 品 介 紹：<br />
          <br />
          <label>
            <textarea name="p_content" id="p_content" cols="80" rows="5" class="ckeditor"></textarea>
          </label>          <br /></td>
      </tr>
    </table>
    <label>
      <br />
      <input type="submit" name="button" id="button" value="新增商品" />
    </label>
    <label>
      <input type="reset" name="button2" id="button2" value="重設" />
    </label>
    <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
    <input name="shop_id" type="hidden" id="shop_id" value="<?php echo $_GET['shop_id']; ?>" />
    <br />
    <br />
    <input type="hidden" name="MM_insert" value="form1" />
    </form>
  </div>
  <div id="main4"></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>