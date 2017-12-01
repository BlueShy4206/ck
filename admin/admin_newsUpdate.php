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
//	---------------------------------------------
//	Pure PHP Upload version 1.1
//	-------------------------------------------
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_PIC_SIZE",3000000);
define("DESTINATION_PIC_FOLDER", "../images/news/");
define("no_error", "admin_news.php");
define("yes_error", "admin_newsUpdate.php");
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
				@unlink('../photo/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它
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


if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_FILE_SIZE",51200000);
define("DESTINATION_FILE_FOLDER", "../images/news/");
//define("no_error", "admin_news.php");
//define("yes_error", "admin_newsAdd.php");
$_accepted_FILE_extensions_ = "rar,doc,docx,pdf,ppt,pptx,xlsx,xls";
if(strlen($_accepted_FILE_extensions_) > 0){
	$_accepted_FILE_extensions_ = @explode(",",$_accepted_FILE_extensions_);
} else {
	$_accepted_FILE_extensions_ = array();
}
/*	modify */
@$news_download_title=$_POST["old_news_download_title"];
@$newFilename=$_POST["old_news_download"]; //變數$newPicname先儲存之前舊圖片檔名，如果沒有更新圖片，news_pic圖片欄位就繼續存入舊圖檔
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
				@unlink('../file/'.$_POST["old_news_download"]);//依據傳過來的舊圖檔名，指定路徑刪				
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
  $updateSQL = sprintf("UPDATE news SET news_title=%s, news_type=%s, news_date=%s, news_movie=%s, news_pic_title=%s, news_pic=%s, news_download_title=%s, news_download=%s, news_content=%s, news_count=%s,news_top=%s WHERE news_id=%s",
                       GetSQLValueString($_POST['news_title'], "text"),
                       GetSQLValueString($_POST['news_type'], "text"),
                       GetSQLValueString($_POST['news_date'], "date"),
                       GetSQLValueString($_POST['news_movie'], "text"),					                       GetSQLValueString($news_pic_title, "text"),	
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($news_download_title, "text"),	
                       GetSQLValueString($newFilename, "text"),	   					   
                       GetSQLValueString($_POST['news_content'], "text"),
                       GetSQLValueString($_POST['news_count'], "int"),
                       GetSQLValueString($_POST['news_top'], "int"),					   
                       GetSQLValueString($_POST['news_id'], "int"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());

  $updateGoTo = "admin_news.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_web_news = "-1";
if (isset($_GET['news_id'])) {
  $colname_web_news = $_GET['news_id'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_news = sprintf("SELECT * FROM news WHERE news_id = %s", GetSQLValueString($colname_web_news, "int"));
$web_news = mysql_query($query_web_news, $conn_web) or die(mysql_error());
$row_web_news = mysql_fetch_assoc($web_news);
$totalRows_web_news = mysql_num_rows($web_news);

$colname_web_newspic = "-1";
if (isset($_GET['news_id'])) {
  $colname_web_newspic = $_GET['news_id'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_newspic = sprintf("SELECT * FROM newspic WHERE news_id = %s ORDER BY newspic_id ASC", GetSQLValueString($colname_web_newspic, "int"));
$web_newspic = mysql_query($query_web_newspic, $conn_web) or die(mysql_error());
$row_web_newspic = mysql_fetch_assoc($web_newspic);
$totalRows_web_newspic = mysql_num_rows($web_newspic);
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
  <div align="center">
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
    <table width="760" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="134" align="left">您好</td>
        <td width="616" align="left">&nbsp;</td>
        <td width="10" align="right">&nbsp;</td>
      </tr>
    </table>
    <table width="769" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="130" height="20" align="left" class="board_add">標 題：</td>
        <td colspan="2" align="left" class="board_add"><label>
          <input name="news_title" type="text" id="news_title" value="<?php echo $row_web_news['news_title']; ?>" size="40" />
        </label></td>
      </tr>

      <tr>
        <td width="130" height="20" align="left" class="board_add">置 頂：</td>
       
<?php       
	   if($row_web_news['news_top']==0)
	   { 
	   echo "<td align=left class=board_add><p>是<input type=radio name=news_top value=1 id=news_top_yes />否<input type=radio name=news_top value=0 id=news_top_no checked/></p></td>";
    }
	else if($row_web_news['news_top']==1)
	{
	   echo "<td align=left class=board_add><p>是<input type=radio name=news_top value=1 id=news_top_yes checked/>否<input type=radio name=news_top value=0 id=news_top_no /></p></td>";
      }
	  ?>                
      </tr>  
      
      <tr>
        <td height="20" align="left" class="board_add">類 別：</td>
        <td colspan="2" align="left" class="board_add"><select name="news_type" id="news_type">
          <option value="news" <?php if (!(strcmp("news", $row_web_news['news_type']))) {echo "selected=\"selected\"";} ?>>新聞</option>
          <option value="action" <?php if (!(strcmp("action", $row_web_news['news_type']))) {echo "selected=\"selected\"";} ?>>活動</option>
          <option value="publish" <?php if (!(strcmp("publish", $row_web_news['news_type']))) {echo "selected=\"selected\"";} ?>>公告</option>
            <option value="news2" <?php if (!(strcmp("news2", $row_web_news['news_type']))) {echo "selected=\"selected\"";} ?>>新聞稿</option>
        </select></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">瀏 覽 次 數：</td>
        <td colspan="2" align="left" class="board_add"><label>
          <input name="news_count" type="text" id="news_count" value="<?php echo $row_web_news['news_count']; ?>" />
        </label></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">日 期：</td>
        <td colspan="2" align="left" class="board_add"><label>
          <input name="news_date" type="text" id="news_date" value="<?php echo $row_web_news['news_date']; ?>" class="Wdate" onFocus="WdatePicker()"/>
          
        </label></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">影 片：</td>
        <td colspan="2" align="left" class="board_add"><span class="table_lineheight">
        <label>
          <input name="news_movie" type="text" id="news_movie" value="<?php echo htmlspecialchars($row_web_news['news_movie']); ?>" size="90" />
        </label>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="4%"><img src="../images/icon_youtube.gif" width="25" height="25" /></td>
    <td width="96%"><span class="font_red">**如需影片，請選擇上傳至Youtube的影片後，將「嵌入」欄位語法貼入本欄位。</span></td>
  </tr>
</table>
         </span></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">更 新 圖 片：</td>
        <td width="456" align="left" class="board_add"><span class="table_lineheight">
          <?php /*START_PHP_SIRFCIT*/ if ($row_web_news['news_pic']!=""){ ?>
          <img src="../images/news/<?php echo $row_web_news['news_pic']; ?>" alt="" name="pic" width="70" id="pic" />
          <?php } /*END_PHP_SIRFCIT*/ ?>
          <input name="oldPic" type="hidden" id="oldPic" value="<?php echo $row_web_news['news_pic']; ?>" />
          <input name="oldPictitle" type="hidden" id="oldPic" value="<?php echo $row_web_news['news_pic_title']; ?>" />          
          <?php echo $row_web_news['news_pic_title']; ?><br />
          <label>
            <input type="file" name="news_pic" id="news_pic" />
          </label>
          <br />
          <span class="font_red">**接受檔案格式為：JPG、GIF、PNG，**檔案大小不能超過3MB</span></span></td>
        <td width="164" align="left" class="board_add">[ <a href="admin_newsPicDel.php?news_id=<?php echo $row_web_news['news_id'];?>&amp;news_pic=<?php echo $row_web_news['news_pic'];  ?>&amp;news_pic_title=<?php echo $row_web_news['news_pic_title'];  ?>">刪除</a> ]</td>
        </tr>
      <tr>
        <td height="20" align="left" class="board_add">更 新 檔案：</td>
        <td align="left" class="board_add"><span class="table_lineheight">原始檔案：<a href="../images/news/<?php echo $row_web_news['news_download']; ?>"><?php echo $row_web_news['news_download_title']; ?></a><br />
          <input name="old_news_download" type="hidden" id="oldPic" value="<?php echo $row_web_news['news_download']; ?>" />
          <input name="old_news_download_title" type="hidden" id="oldPic" value="<?php echo $row_web_news['news_download_title']; ?>" />           
        <label>
          <input type="file" name="news_download" id="news_download" />
          </label><br />
          <span class="font_red">**接受檔案格式為：rar,doc,docx,pdf,ppt,pptx,xlsx,xls，**檔案大小請勿超過50MB!!</span></span></td>
        <td align="left" class="board_add">[ <a href="admin_newsDownloadDel.php?&amp;news_id=<?php echo $row_web_news['news_id'];?>&amp;news_download=<?php echo $row_web_news['news_download'];?>&amp;news_download_title=<?php echo $row_web_news['news_download_title'];?>">刪除</a> ]</td>
      </tr>
      <tr>
        <td colspan="3" align="left" class="board_add">資 料 內 容：<br />
          <br />
          <label>
            <textarea name="news_content" id="news_content" cols="80" rows="5" class="ckeditor"><?php echo $row_web_news['news_content']; ?></textarea>
          </label>          <br /></td>
      </tr>
    </table>
     <table width="760" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="644" height="25" align="left"><img src="../images/icon_pic.gif" width="16" height="16" /> [ <a href="admin_newsPicAdd.php?news_id=<?php echo $row_web_news['news_id']; ?>">新增更多本資料相關圖片</a> ]</td>
        <td width="96" align="left">&nbsp;</td>
      </tr>
      <?php do { ?>
        <?php if ($totalRows_web_newspic > 0) { // Show if recordset not empty ?>
  <tr>
    <td height="20" align="left" class="board_add"><img src="../images/news/<?php echo $row_web_newspic['newspic_pic']; ?>" alt="" name="pic2" width="100" id="pic2" /><?php echo $row_web_newspic['newspic_title']; ?></td>
    <td align="center" class="board_add">[ <a href="admin_newsPicDel.php?newspic_id=<?php echo $row_web_newspic['newspic_id']; ?>&amp;newspic_pic=<?php echo $row_web_newspic['newspic_pic']; ?>&amp;news_id=<?php echo $row_web_newspic['news_id']; ?>">刪除</a> ]</td>
  </tr>
  <?php } // Show if recordset not empty ?>
        <?php } while ($row_web_newspic = mysql_fetch_assoc($web_newspic)); ?>
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
<input name="Submit" type="button" onclick="MM_goToURL('parent','admin_news.php');return document.MM_returnValue" value="回公告列表" />

      <input name="news_id" type="hidden" id="news_id" value="<?php echo $row_web_news['news_id']; ?>" />
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
