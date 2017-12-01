<?php

require_once('Connections/conn_web.php');

//echo "<pre>";
//print_r($_POST);

$psw = md5($_POST['password']);
//$birthday=$_POST['year']."-".$_POST['month']."-".$_POST['day'];
$eng_uname=$_POST['Firstname']." ".$_POST['Lastname'];

$rs = $dbh->prepare('INSERT INTO member (username, password, uname, eng_uname, uid, sex, birthday, email, orderPaper, phone, Area, cityarea, cuszip, cusadr, level, date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ');
$result = $rs->execute(array($_POST['username'], $psw, $_POST['uname'], $eng_uname /*$_POST['eng_uname']*/, ucfirst($_POST['id']), $_POST['sex'], $_POST['birthday'], $_POST['email'], $_POST['orderPaper'], $_POST['phone'], $_POST['Area'], $_POST['cityarea'], $_POST['cuszip'], $_POST['cusadr'],  "member", $_POST['date']));

if($result){
	mysql_select_db($database_conn_web, $conn_web);
	$query_web_member = sprintf("SELECT * FROM member WHERE uid='%s' AND email='%s' AND status='0'", $_POST['id'], $_POST['email']);
	$web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
	$row_web_member = mysql_fetch_assoc($web_member);
}

mysql_select_db($database_conn_web, $conn_web);
$query_web_allguide = sprintf("SELECT * FROM allguide WHERE up_no='MH'");
$web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
$row_web_allguide = mysql_fetch_assoc($web_allguide);

$MailHost = $row_web_allguide['note'];
//會員加入成功
//header("Location:memberAddSuccess.php" );
header("Location:$MailHost/EasyMVC/Home/queryList/$row_web_member[id]");

?>