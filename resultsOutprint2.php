<?php require_once('Connections/conn_web.php'); ?>


<? session_start();?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
<title>國民小學教師學科知能評量</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="國民小學教師學科知能評量列印" />
<meta name="keywords" content="國民小學教師學科知能評量列印" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<form method="GET" action="resultsPDF.php">
		請先選擇評量科目：<select name="type">
		 <option  value="0">請選擇</option>
		　<option <?php if($_GET['type']=='c') echo ("selected");?> value="c">國語</option>
		　<option <?php if($_GET['type']=='m') echo ("selected");?> value="m">數學</option>
		　<option <?php if($_GET['type']=='s') echo ("selected");?> value="s">社會</option>
		　<option <?php if($_GET['type']=='p') echo ("selected");?> value="p">自然</option>
		</select>
		<input type="hidden" name="id" value=<?php echo $_GET['id']; ?> >
		<input type="submit" value="查詢"/>
		<a href="Results2.php">回上一頁</a>
	</form>
	


</body>
</html>


