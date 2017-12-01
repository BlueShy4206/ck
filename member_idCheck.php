<?php require_once('Connections/conn_web.php'); ?>
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

$colname_web_chkUsername = "-1";
if (isset($_GET['username'])) {
  $colname_web_chkUsername = $_GET['username'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_chkUsername = sprintf("SELECT username FROM member WHERE username = %s", GetSQLValueString($colname_web_chkUsername, "text"));
$web_chkUsername = mysql_query($query_web_chkUsername, $conn_web) or die(mysql_error());
$row_web_chkUsername = mysql_fetch_assoc($web_chkUsername);
$totalRows_web_chkUsername = mysql_num_rows($web_chkUsername);
echo $totalRows_web_chkUsername; //輸出查詢到的資料總筆數
mysql_free_result($web_chkUsername);
?>
