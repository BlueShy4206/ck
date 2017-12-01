<?php
require_once('../Connections/conn_web.php');
header("Cache-control:private");//解決session 引起的回上一頁表單被清空
header("Content-Type:text/html; charset=utf-8");
?>
<?php
//	---------------------------------------------
//	Pure PHP PIC Upload version 1.1
//	-------------------------------------------
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_PIC_SIZE",3000000);
define("DESTINATION_PIC_FOLDER", "../images/news/");
define("no_error", "admin_news.php");
define("yes_error", "admin_newsAdd.php");
$_accepted_PIC_extensions_ = "jpg,gif,png";
if(strlen($_accepted_PIC_extensions_) > 0){
	$_accepted_PIC_extensions_ = @explode(",",$_accepted_PIC_extensions_);
} else {
	$_accepted_PIC_extensions_ = array();
}
/*	modify */
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
			if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER . "/" . date("YmdHis.").$_ext_)){ //修改自動重新命名
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

//	---------------------------------------------
//	Pure PHP FILE Upload version 1.1
//	-------------------------------------------
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_FILE_SIZE",51200000);
define("DESTINATION_FILE_FOLDER", "../images/news/");
//define("no_error", "admin_news.php");
//define("yes_error", "admin_newsAdd.php");
$_accepted_FILE_extensions_ = "pdf,rar,doc,docx,ppt,pptx,xlsx,xls";
if(strlen($_accepted_FILE_extensions_) > 0){
	$_accepted_FILE_extensions_ = @explode(",",$_accepted_FILE_extensions_);
} else {
	$_accepted_FILE_extensions_ = array();
}
/*	modify */
if(!empty($HTTP_POST_FILES['news_download'])){
	if(is_uploaded_file($HTTP_POST_FILES['news_download']['tmp_name']) && $HTTP_POST_FILES['news_download']['error'] == 0){
		$_file_ = $HTTP_POST_FILES['news_download'];
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
		

$news_download_title=$_file_['name'];


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
  $insertSQL = sprintf("INSERT INTO news (news_title, news_type, news_date, news_movie, news_pic_title, news_pic, news_content, news_download_title, news_download, news_top) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['news_title'], "text"),
                       GetSQLValueString($_POST['news_type'], "text"),
                       GetSQLValueString($_POST['news_date'], "date"),
                       GetSQLValueString($_POST['news_movie'], "text"),
                       GetSQLValueString($news_pic_title, "text"),					   
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($_POST['news_content'], "text"),
                       GetSQLValueString($news_download_title, "text"),						
                       GetSQLValueString($newFilename, "text"),
                       GetSQLValueString($_POST['news_top'], "int"));				   

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());

  $insertGoTo = "admin_news.php";
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理後台</title>


<link href="../web.css" rel="stylesheet" type="text/css" />
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
</head>

<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<body>
<?php include("header.php"); ?>
  <div align="center">
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
    <table width="760" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="148" align="left">
<div><span class="font_red">管理員</span>您好
 </div>      
        </td>
        <td width="544" align="left" background="../images/board04.gif">&nbsp;</td>
        
        <td width="68" align="right">&nbsp;</td>
      </tr>
    </table>
    <table width="760" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="98" height="20" align="left" class="board_add">標&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 題：</td>
        <td width="642" align="left" class="board_add"><label>
          <input name="news_title" type="text" id="news_title" size="40" />
        </label></td>
      </tr>

      <tr>
        <td width="98" height="20" align="left" class="board_add">置&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 頂：</td>
        <td width="642" align="left" class="board_add"><p>是
          <input type="radio" name="news_top" value=1 id="news_top_yes" /> 
          	否     
          <input type="radio" name="news_top" value=0 id="news_top_no" checked/>
          </p>
          </td>
          
      </tr>      
      
      <tr>
        <td height="20" align="left" class="board_add">類&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 別：</td>
        <td align="left" class="board_add"><label>
          <select name="news_type" id="news_type">
            <option value="news">新聞</option>
            <option value="action">活動</option>
	    <option value="publish">公告</option>
            <option value="news2">新聞稿</option>
          </select>
        </label></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">日&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 期：</td>
        <td align="left" class="board_add"><label>
          <input name="news_date" type="text" id="news_date" class="Wdate" onFocus="WdatePicker()"  value="<? echo date('Y-m-d')?>" />
              
        </label></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">影&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 片：</td>
        <td align="left" class="board_add"><span class="table_lineheight">
        <label>
          <input name="news_movie" type="text" id="news_movie" size="90" />
        </label>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="4%"><img src="../images/icon_youtube.gif" width="25" height="25" /></td>
    <td width="96%"><span class="font_red">**如需影片，請選擇上傳至Youtube的影片後，將「嵌入」欄位語法貼入本欄位。</span></td>
  </tr>
</table></span></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">資 料 圖 片：</td>
        <td align="left" class="board_add"><span class="table_lineheight">
          <label>
            <input type="file" name="news_pic" id="news_pic" />
          </label>
          <br />
        <span class="font_red">**限制檔案格式為：JPG、GIF、PNG，檔案尺寸不能超過3MB</span></span></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">資 料 檔 案：</td>
        <td align="left" class="board_add"><span class="table_lineheight">
          <label>
            <input type="file" name="news_download" id="news_download" />
          </label>
          <br />
        <span class="font_red">**大小請勿超過50MB!!</span></span></td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="board_add">公 告 內 容：<br />
          <br />
          <label>
            <textarea name="news_content" cols="80" class="ckeditor" id="news_content"></textarea>
          </label>          
          <br /></td>
      </tr>
    </table>
    <label>
      <br />
      <input type="submit" name="button" id="button" value="新增公告" />&nbsp;&nbsp;
    </label>
    <label>
      <input type="reset" name="button2" id="button2" value="重新填寫" />&nbsp;&nbsp;
    </label>


    <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>&nbsp;&nbsp;
               <input type="button" class="style1" onclick="location='logout.php'" value="登出" />
    <br />
    <input type="hidden" name="MM_insert" value="form1" />
    </form>
  </div>

</body>
</html>
