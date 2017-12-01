<?php require_once('../Connections/conn_web.php'); ?>
<?PHP
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

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_Recordset = "SELECT * FROM examinee ORDER BY id";
$web_Recordset = mysql_query($query_web_Recordset, $conn_web) or die(mysql_error());
$row_web_Recordset = mysql_fetch_assoc($web_Recordset);
$totalRows_web_Recordset = mysql_num_rows($web_Recordset);


mysql_select_db($database_conn_web, $conn_web);
$query_web_Recordset2 = "SELECT * FROM examinee ORDER BY id";
$web_Recordset2 = mysql_query($query_web_Recordset2, $conn_web) or die(mysql_error());
$row_web_Recordset2 = mysql_fetch_assoc($web_Recordset2);
$totalRows_web_Recordset2 = mysql_num_rows($web_Recordset2);

if ($_GET['act']=='download') {
  downloadxls();
  die();
}
function downloadxls(){

$query_web_Recordset2 = "SELECT * FROM examinee ORDER BY id";
$web_Recordset2 = mysql_query($query_web_Recordset2);

$totalRows_web_Recordset2 = mysql_num_rows($web_Recordset2);
	
	
$filename="examineeoutput.xls";
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: filename=$filename");
//header("Content-type: application/octetstream");
header("Pragma: no-cache");
header("Expires: 0");


echo "<table border=1px><tr><td>本欄留空</td><td>中文姓名(必填)</td><td>密碼((若不填，由系統決定密碼))</td><td>電子郵件信箱(可留白)</td><td>性別(必填)</td><td>出生年月日(可留白)</td><td>身份證字號(可留白)</td><td>住所電話(可留白)</td><td>手機號碼</td><td>家裡住址(可留白)</td><td>年級(預設為6)</td><td>班級(預設為1)</td><td>自訂帳號</td></tr>";

for ($i = 0; $i < $totalRows_web_Recordset2; $i++)
{
$row_web_Recordset2 = mysql_fetch_array($web_Recordset2);

echo "<tr><td></td><td>".$row_web_Recordset2['uname']."</td><td>".$row_web_Recordset2['per_id']."</td><td>".$row_web_Recordset2['email']."</td><td>".$row_web_Recordset2['sex']."</td><td>".$row_web_Recordset2['birthday']."</td><td>".$row_web_Recordset2['per_id']."</td><td>".$row_web_Recordset2['phone']."</td><td>".$row_web_Recordset2['phone']."</td><td>".$row_web_Recordset2['cusadr']."</td><td>".$row_web_Recordset2['Grade']."</td><td></td><td>".$row_web_Recordset2['id']."</td></tr>";
$j=$i+1;
}
echo "</table>";

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>

<table width="100%" border="1">
  <tr><td>本欄留空</td><td>中文姓名(必填)</td><td>密碼((若不填，由系統決定密碼))</td><td>電子郵件信箱(可留白)</td><td>性別(必填)</td><td>出生年月日(可留白)</td><td>身份證字號(可留白)</td><td>住所電話(可留白)</td><td>手機號碼</td><td>家裡住址(可留白)</td><td>年級(預設為6)</td><td>班級(預設為1)</td><td>自訂帳號</td></tr>
  <?php do { ?><tr><td></td><td><?php echo $row_Recordset['uname']; ?></td><td><?php echo $row_Recordset['per_id']; ?></td><td><?php echo $row_Recordset['email']; ?></td><td><?php echo $row_Recordset['sex']; ?></td><td><?php echo $row_Recordset['birthday']; ?></td><td><?php echo $row_Recordset['per_id']; ?></td><td><?php echo $row_Recordset['phone']; ?></td><td><?php echo $row_Recordset['phone']; ?></td><td><?php echo $row_Recordset['cusadr']; ?></td><td><?php echo $row_Recordset['Grade']; ?></td><td></td><td><?php echo $row_Recordset['id']; ?></td></tr><?php } while ($row_Recordset = mysql_fetch_assoc($web_Recordset)); ?>
</table>
</body>
</html>