<?php 
//引入資料庫連線設定檔
require_once('Connections/conn_web.php');
/* 依據取得的URL參數forum_id，更新forum資料表中forum_view文章瀏覽次數欄位計數的SQL語法*/
$updateSQL = "UPDATE forum SET forum_view=forum_view+1 WHERE forum_id = ".$_GET["forum_id"];
/*執行更新動作*/
mysql_select_db($database_conn_web, $conn_web);
$Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());
//網頁重新導向forum_detial.php頁面，並傳遞要讀取的文章ID參數forum_id
header("Location:forum_detial.php?forum_id=".$_GET["forum_id"]);
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