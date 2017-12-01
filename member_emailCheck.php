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

$colname_web_chkEmail = "-1";
if (isset($_GET['email'])) {
  $colname_web_chkEmail = $_GET['email'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_chkEmail = sprintf("SELECT email FROM member WHERE email = %s", GetSQLValueString($colname_web_chkEmail, "text"));
$web_chkEmail = mysql_query($query_web_chkEmail, $conn_web) or die(mysql_error());
$row_web_chkEmail = mysql_fetch_assoc($web_chkEmail);
$totalRows_web_chkEmail = mysql_num_rows($web_chkEmail);
echo $totalRows_web_chkEmail; //輸出查詢到的資料總筆數
mysql_free_result($web_chkEmail);
?>
