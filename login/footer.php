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

?>
<?
if(!isset($_SESSION['view'])){ //先檢查Session變數view是否存在，如果不存在就新增變數並寫入瀏覽人次記錄
	$_SESSION['view'] = 1;  		   //新增Session變數view，值為1
	$view_time=date("Y-m-d H:i:s");    //變數$viewtime瀏覽時間
	$view_ip=$_SERVER['REMOTE_ADDR'];  //變數$viewip記錄瀏覽者的IP
	//指定新增資料至viewcount資料表的SQL指令
	$insertView="INSERT INTO viewcount (view_time,view_ip) VALUES ('$view_time', '$view_ip')";
	mysql_query($insertView);//執行SQL指令動作
}
?>
<link href="../web.css" rel="stylesheet" type="text/css" />
<div id="footer">
  <p>&nbsp;<br />
  指導單位：<img src="../images/356_003ab01d.png" alt="教育部" width="16" height="16" />教育部<br /> 
  執行單位：  教師專業能力測驗中心     <br />
  地址：臺中市西區民生路140號 TEL：(04)2218-3522<br />
  
  </p>
</div>

