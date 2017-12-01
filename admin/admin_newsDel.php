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

if ((isset($_GET['news_id'])) && ($_GET['news_id'] != "") && (isset($_GET['delSure']))) {
  $deleteSQL = sprintf("DELETE FROM news WHERE news_id=%s",
                       GetSQLValueString($_GET['news_id'], "int"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($deleteSQL, $conn_web) or die(mysql_error());

  $deleteGoTo = "admin_news.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  
   //如果news_download變數定義不是空的，就刪除檔
  if($_GET["news_download"]!=''){
  @unlink('../images/news/'.$_GET["news_download"]);
  }
  header(sprintf("Location: %s", $deleteGoTo));
  //如果news_pic變數定義不是空的，就刪除圖檔
  if($_GET["news_pic"]!=''){
  @unlink('../images/news/'.$_GET["news_pic"]);
  }
  header(sprintf("Location: %s", $deleteGoTo));
 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
</body>
</html>