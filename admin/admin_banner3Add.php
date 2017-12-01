<?php require_once('../imgResize.php'); ?>
<?php
//	---------------------------------------------
//	Pure PHP Upload version 1.1
//	-------------------------------------------
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_SIZE",300000);
define("DESTINATION_FOLDER", "../images/panner/");
define("no_error", "admin_banner.php");
define("yes_error", "admin_banner3Add.php");
$_accepted_extensions_ = "jpg,gif,png";
if(strlen($_accepted_extensions_) > 0){
	$_accepted_extensions_ = @explode(",",$_accepted_extensions_);
} else {
	$_accepted_extensions_ = array();
}
/*	modify */
if(!empty($HTTP_POST_FILES['banner_pic'])){ //如果你的上傳檔案欄位不是取banner_pic，請將你的欄位名稱取代所有banner_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['banner_pic']['tmp_name']) && $HTTP_POST_FILES['banner_pic']['error'] == 0){
		$_file_ = $HTTP_POST_FILES['banner_pic'];
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
                  $src  = "../images/panner/".$newPicname; //自訂變數$src，指定圖檔來源位置以及檔名
                  $newSrc = $src;                          //自訂變數$newSrc，設定後續縮圖儲存位置及檔名
                  $whLimit = "555";                        //自訂變數$whLimit，設訂縮圖寬高限制尺寸
                  imgResize($src,$newSrc,$whLimit);        //將上面3個自訂變數帶入自訂函數imgResize()開始製作縮圖
                  //製作預覽圖
                  $src  = "../images/panner/".$newPicname; //自訂變數$src，指定圖檔來源位置以及檔名
                  $newSrc = "../images/panner/thum/".$newPicname; //自訂變數$newSrc，設定後續縮圖儲存位置及檔名
                  $whLimit = "200";                        //自訂變數$whLimit，設訂縮圖寬高限制尺寸
                  imgResize($src,$newSrc,$whLimit);        //將上面3個自訂變數帶入自訂函數imgResize()開始製作縮圖
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
  $insertSQL = sprintf("INSERT INTO banner (banner_type, banner_pic, banner_url) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['banner_type'], "text"),
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($_POST['banner_url'], "text"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());

  $insertGoTo = "admin_banner.php";
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
<meta name="description" content="Dreamweaver+PHP資料庫網站製作" />
<meta name="keywords" content="Dreamweaver+PHP資料庫網站製作" />
<meta name="author" content="joj設計、joj網頁設計、joj Design、joj Web Design、呂昶億、杜慎甄" />
<link href="../web.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div align="center">
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
    <table width="760" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="25" align="left"><img src="../images/board10.gif" /></td>
        <td width="725" align="left" background="../images/board04.gif">&nbsp; <span class="font_black">新增<img src="../images/icon_pic.gif" width="16" height="16" />廣告</span></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <table width="760" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td height="20" align="left" class="board_add">廣 告 網 址：</td>
        <td align="left" class="board_add"><label>
          <input name="banner_url" type="text" id="banner_url" size="60" />
        </label><span class="font_red">**請輸入圖文廣告連結前往網址!!</span></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">廣 告 圖 片：</td>
        <td align="left" class="board_add"><span class="table_lineheight">
        <label>
          <input type="file" name="banner_pic" id="banner_pic" />
          </label><span class="font_red"><br />
          **限制檔案格式為：JPG、GIF、PNG，檔案尺寸不能超過300KB，如需背景透明圖檔，請使用PNG圖檔
          </span></span></td>
      </tr>
    </table>
    <label>
      <br />
      <input type="submit" name="button" id="button" value="新增廣告" />
    </label>
    <label>
      <input type="reset" name="button2" id="button2" value="重設" />
    </label>
    <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
    <input name="banner_type" type="hidden" id="banner_type" value="3" />
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