<?php require_once('Connections/conn_web.php'); ?>
<?php
$area = $_GET["area"];
$area_note = $_GET["note"];
$todayyear = $_GET["todayyear"];

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

mysql_select_db($database_conn_web, $conn_web);
$query_web_lot = sprintf("SELECT IFNULL(num,0) num, nm as exarea, data2 as exarea_note,
		data3, data4, (data3-IFNULL(num,0)) lot1 FROM allguide a2 left join
		( SELECT count(*) num, exarea, exarea_note FROM examinee WHERE id LIKE %s
		AND apply_mk=1 AND Qualify=1 AND status=0 group by exarea, exarea_note) as a1 on
		(a1.exarea = a2.nm and a1.exarea_note = a2.data2)
		WHERE a2.up_no = %s and nm = %s and data2 = %s", GetSQLValueString("%" .$todayyear . "%", "text"), GetSQLValueString('EA2', "text"), GetSQLValueString($area, "text"), GetSQLValueString($area_note, "text"));
$web_examinee_lot = mysql_query($query_web_lot, $conn_web) or die(mysql_error());
$row_web_examinee_lot = mysql_fetch_assoc($web_examinee_lot);

mysql_select_db($database_conn_web, $conn_web);
$query_web_lot2 = sprintf("SELECT IFNULL(num2,0) num2, nm as exarea, data2 as exarea_note,
		data3, data4, (data4-IFNULL(num2,0)) lot2 FROM allguide a2 left join
		(SELECT count(*) num2, exarea as exarea2, exarea_note as exarea_note2 FROM examinee WHERE id LIKE %s
		AND apply_mk=1 AND Qualify=0 AND status=0 group by exarea, exarea_note) as a3 on
		(a3.exarea2 = a2.nm and a3.exarea_note2 = a2.data2) 
		WHERE a2.up_no = %s and nm = %s and data2 = %s", GetSQLValueString("%" .$todayyear . "%", "text"), GetSQLValueString('EA2', "text"), GetSQLValueString($area, "text"), GetSQLValueString($area_note, "text"));
$web_examinee_lot2 = mysql_query($query_web_lot2, $conn_web) or die(mysql_error());
$row_web_examinee_lot2 = mysql_fetch_assoc($web_examinee_lot2);

echo "正取尚餘  $row_web_examinee_lot[lot1] 人 ；備取尚餘  $row_web_examinee_lot2[lot2] 人";
