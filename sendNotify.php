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

mysql_select_db($database_conn_web, $conn_web);
//$query_web_member = sprintf("SELECT * FROM examinee WHERE id like %s AND exarea='Eastern' AND exarea_note='1' AND id_number is not null", GetSQLValueString('%B2016%', "text"));
//$query_web_member = sprintf("SELECT * FROM examinee WHERE allow='Y' and email is not null and exarea in ('Northern')");

// $query_web_member = sprintf("SELECT * FROM `member` where username in (SELECT username FROM `examinee` where examyear_id=35 and allow='Y' and exarea_date in ('106年6月18日(日)','106年6月21日(三)'))");
$query_web_member = sprintf("SELECT * FROM `member` WHERE EForm_MK = 0 AND id >100 AND level='member' and status=1 and username not in (SELECT RecUsername FROM `tosendmail` where subject='106年第二梯次國民小學師資類科師資生學科知能評量簡章公告通知') order by id desc limit 0,50 ");
$web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
//$row_web_member = mysql_fetch_assoc($web_member);
echo 'start....';
while ($row_web_member = mysql_fetch_assoc($web_member))
{
	$webmaster_email = "ckassessment@gmail.com";
	$webmaster_name = "TCPTC系統管理員";
	
	$email=$row_web_member['email'];// 收件者信箱
	$name=$row_web_member['username'];// 收件者的名稱or暱稱
        $subject="106年第二梯次國民小學師資類科師資生學科知能評量簡章公告通知";// 信件標題
        $pattern="@";
	if(preg_match("/\@/i",$email)){
	/*$body="親愛的會員，您好！
	由於您在 「教師專業能力測驗中心(https://tl-assessment.ntcu.edu.tw/index.php)」的會員密碼強度不足建議變更，
	為了保護會員個人資料，本中心會員即日起，登入密碼必須改為英文和數字併用的8字元的密碼
	為確保您的網路交易安全，建議您不定期變更「會員密碼」，謝謝！ 

	教師專業能力測驗中心 敬上";*/

	$body="106年第二梯次國民小學師資類科師資生學科知能評量簡章公告通知<br/>
			

			詳如右方連結:https://tl-assessment.ntcu.edu.tw/news_detial.php?news_id=4017<br/>
			any problem，you can touch us，thank you!!";
	/*if($row_web_member['exarea']=='Southern'){
		$filename='/home/sysop/file/20151015101913.doc';
	}elseif ($row_web_member['exarea']=='Northern'){
		$filename='/home/sysop/file/20151015101906.doc';
	}*/
	//信件內容(html版，就是可以有html標籤的如粗體、斜體之類)
	//$filename='/home/sysop/file/20160621083848.pdf';
	$sysTime = date("Y-m-d H:i:s");//new DateTime('NOW');
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
}}
	echo'end!';
