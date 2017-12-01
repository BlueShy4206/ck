<?php
//	---------------------------------------------
//	Pure PHP Upload version 1.1
//	-------------------------------------------
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_SIZE",300000);
define("DESTINATION_FOLDER", "../images/news/");
define("no_error", "admin_newsUpdate.php");
define("yes_error", "admin_newsPicAdd.php");
$_accepted_extensions_ = "jpg,gif,png";
if(strlen($_accepted_extensions_) > 0){
	$_accepted_extensions_ = @explode(",",$_accepted_extensions_);
} else {
	$_accepted_extensions_ = array();
}
/*	modify */
if(!empty($HTTP_POST_FILES['newspic_pic'])){//如果你的上傳檔案欄位不是取名為newspic_pic，請將你的欄位名稱取代所有newspic_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['newspic_pic']['tmp_name']) && $HTTP_POST_FILES['newspic_pic']['error'] == 0){
		$_file_ = $HTTP_POST_FILES['newspic_pic'];
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
  $insertSQL = sprintf("INSERT INTO newspic (news_id, newspic_pic, newspic_title) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['news_id'], "int"),
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($_POST['newspic_title'], "text"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());

  $insertGoTo = "admin_newsUpdate.php?news_id=" . $row_web_newspic['news_id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_web_newspic = "-1";
if (isset($_GET['news_id'])) {
  $colname_web_newspic = $_GET['news_id'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_newspic = sprintf("SELECT news_id, news_title FROM news WHERE news_id = %s", GetSQLValueString($colname_web_newspic, "int"));
$web_newspic = mysql_query($query_web_newspic, $conn_web) or die(mysql_error());
$row_web_newspic = mysql_fetch_assoc($web_newspic);
$totalRows_web_newspic = mysql_num_rows($web_newspic);
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
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="admin_main2">
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      您正在為 [<span class="font_red"><?php echo $row_web_newspic['news_title']; ?> </span>] 資料，新增資料圖片<br />
      <br />
      <table width="370" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="70" height="35" align="left" valign="middle" class="board_add">&nbsp; 圖片標題：</td>
          <td width="300" align="left" class="board_add"><label>
            <input type="text" name="newspic_title" id="newspic_title" />
          </label></td>
        </tr>
        <tr>
          <td width="70" align="left" valign="top" class="board_add">&nbsp; 上傳圖片：</td>
          <td align="left" class="board_add">
        <label>
        <input type="file" name="newspic_pic" id="newspic_pic" />
        </label><span class="font_red"><br />
        **格式為.jpg、.gif、.png，檔案大小請勿超過300KB!!</span>
          </td>
        </tr>
      </table>
        <label>
          <br />
          <input type="submit" name="button" id="button" value="新增圖片" />
      </label>
      <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
      <input name="news_id" type="hidden" id="news_id" value="<?php echo $row_web_newspic['news_id']; ?>" />
      <input type="hidden" name="MM_insert" value="form1" />
      </p>
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
mysql_free_result($web_newspic);
?>
