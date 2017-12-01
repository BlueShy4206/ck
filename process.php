<?php
 
require_once('Connections/conn_web.php');

$username = $_POST['username'];
$email = $_POST['email'];
$id = $_POST['id'];

//如果傳來的帳號在資料庫裡找不到，則回傳true
if (!empty($username)) {
	$rs = $dbh->prepare('SELECT username FROM member WHERE username = ? ');
	$rs->execute(array($username));
	$result = $rs->fetch(PDO::FETCH_ASSOC);

	if ( !empty($result) ) {
		echo 'false' ;
	} else {
		echo 'true' ;
	} 
} else if (!empty($email)) { //如果傳來的email在資料庫裡找不到，則回傳true
	$rs = $dbh->prepare('SELECT email FROM member WHERE email = ? ');
	$rs->execute(array($email));
	$result = $rs->fetch(PDO::FETCH_ASSOC);

	if ( !empty($result)  ) {
		echo 'false' ;
	} else {
		echo 'true' ;
	} 
} else if (!empty($id)) { //如果傳來的身分證字號在資料庫裡找不到，則回傳true
	$rs = $dbh->prepare('SELECT uid FROM member WHERE uid = ? ');
	$rs->execute(array($id));
	$result = $rs->fetch(PDO::FETCH_ASSOC);

	if ( !empty($result)  ) {
		echo 'false' ;
	} else {
		echo 'true' ;
	}
} else if(strtoupper($_GET['captcha']) == $_SESSION['randcode']) { //比對驗證碼是否輸入正確
	echo 'true';
} else {
	echo 'false';
}
?>