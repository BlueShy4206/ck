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

if(isset($_POST["mailSentBtn"])){
	//print_r($_POST["username"]);
	$chkno = $_POST["examList"];
	$chkemail = $_POST["email"];
	$chkname = $_POST["username"];
	$sumSuccess=0;

	foreach($chkno as $index=>$recno){
	//依array foreach call
		
		mysql_select_db($database_conn_web, $conn_web);
		$query_web_member = sprintf("SELECT * FROM examinee WHERE  email is not null and no=%s", GetSQLValueString($recno, "text"));//allow='Y' and
		$web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
		$row_web_member = mysql_fetch_assoc($web_member);
		
		$webmaster_email = $_POST["sendmail"];
		$webmaster_name = "TCPTC系統管理員";

		$email=$row_web_member['email'];// 收件者信箱
		$name=$row_web_member['username'];// 收件者的名稱or暱稱
		$subject=$_POST["subject"];// 信件標題
		$body=$_POST["mailBody"];//信件內容(html版，就是可以有html標籤的如粗體、斜體之類)
		$filename=$_POST["attachment"];
		$sysTime = date("Y-m-d H:i:s");
		$insertSQL = sprintf("INSERT INTO tosendmail (FromEmail, FromName, RecEmail, RecUsername, subject, body, AddAttachment, status, addTime)
							VALUES (%s, %s, %s, %s, %s, %s, %s, '0', %s)",
				GetSQLValueString($webmaster_email, "text"),
				GetSQLValueString($webmaster_name, "text"),
				GetSQLValueString($email, "text"),
				GetSQLValueString($name, "text"),
				GetSQLValueString($subject, "text"),
				GetSQLValueString($body, "text"),
				GetSQLValueString($filename, "text"),
				GetSQLValueString($sysTime, "text"));
		mysql_select_db($database_conn_web, $conn_web);
		$Result2 = mysql_query($insertSQL, $conn_web) or die(mysql_error());

		if($Result2){
			$sumSuccess++;
		}
	}
	echo "成功筆數：".$sumSuccess;
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://120.108.208.34/EasyMVC/Home/mailList");
// 	header("Location: http://localhost/lab2/EasyMVC/Home/mailList");
}