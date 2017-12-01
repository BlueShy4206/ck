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

foreach ($_GET['text'] as $position => $item) : 
 
  $sql[] = "UPDATE `file` SET `position` = $position WHERE `id` = $item"; 

  $updateSQL = sprintf("UPDATE file SET position=%s WHERE file_id=%s",
                       GetSQLValueString($position, "int"),                       
                       GetSQLValueString($item, "int"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());
endforeach; 
 //$updateGoTo = "admin_file.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));



?>
<?php 
/* This is where you would inject your sql into the database 
but we're just going to format it and send it back 
*/
//.sortable('serialize');會將要排序的物件取得id值，並解析為陣列資料。
//變數陣列名為listItem 而id值底線後面的數字變成值，索引為數字索引
foreach ($_GET['text'] as $position => $item) : 
  $sql[] = "UPDATE `table` SET `position` = $position WHERE `id` = $item"; 
endforeach; 
print_r ($sql); 
?>