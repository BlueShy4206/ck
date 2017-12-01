<?php

require_once('Connections/conn_web.php');

//echo "<pre>";
//print_r($_POST);

$psw = md5($_POST['password']);
//$birthday=$_POST['year']."-".$_POST['month']."-".$_POST['day'];
$eng_uname=$_POST['Firstname']." ".$_POST['Lastname'];

$rs = $dbh->prepare('INSERT INTO member (username, password, uname, eng_uname, uid, sex, birthday, email, orderPaper, phone, Area, cityarea, cuszip, cusadr, level, date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ');
$result = $rs->execute(array($_POST['username'], $psw, $_POST['uname'], $eng_uname /*$_POST['eng_uname']*/, ucfirst($_POST['id']), $_POST['sex'], $_POST['birthday'], $_POST['email'], $_POST['orderPaper'], $_POST['phone'], $_POST['Area'], $_POST['cityarea'], $_POST['cuszip'], $_POST['cusadr'],  "member", $_POST['date']));

//�s�J��Ʈw��A����즨�\�e��
header("Location:memberAddSuccess.php" );

?>