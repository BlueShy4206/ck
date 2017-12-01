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
  $updateSQL = sprintf("UPDATE news SET news_download=%s WHERE news_id=%s",
                       GetSQLValueString($_POST['news_download'], "text"),
                       GetSQLValueString($_POST['news_id'], "int"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());

  $updateGoTo = "admin_newsUpdate.php?news_id=" . $row_web_news['news_id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  @unlink('../images/news/'.$_POST["fileDel"]);//刪除之前上傳檔案
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
  <div id="admin_main2">
      <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
        <p>&nbsp;</p>
        <p><span class="font_red2" >您確定要刪除 [<?php echo $row_web_news['news_title']; ?>] 資料的供下載檔案??</span></p>
        <p><br />
          檔案名稱：
        <?php echo $row_web_news['news_download']; ?></p>
          <label>
            <br />
            <input type="submit" name="button" id="button" value="刪除檔案" /><input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
          </label>
          <input name="news_id" type="hidden" id="news_id" value="<?php echo $row_web_news['news_id']; ?>" />
          <input type="hidden" name="news_download" id="news_download" />
        </p>
        <input name="fileDel" type="hidden" id="fileDel" value="<?php echo $row_web_news['news_download']; ?>" />
<p>&nbsp;</p>
<input type="hidden" name="MM_update" value="form1" />
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
mysql_free_result($web_news);
?>
