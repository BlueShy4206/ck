<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conn_web = "localhost";
$database_conn_web = "ck";
$username_conn_web = "ckuser";
$password_conn_web = "kbc78!@#$%";
$conn_web = mysql_pconnect($hostname_conn_web, $username_conn_web, $password_conn_web) or trigger_error(mysql_error(),E_USER_ERROR); 
//��Ʈw�s�u�]�w�ϥ�UTF8�s�X
mysql_query("SET NAMES UTF8");
//�����ҥ�session�\��(���ϥγs�u�]�w�ɪ�����)
session_start();
//�����P�_�O�_�ϥβ���cookie�O���b���B�K�X��(���ϥγs�u�]�w�ɪ�����)
if(isset($_POST['uCheck']) and isset($_POST['pCheck'])) {
	if(isset($_POST['remember'])) {
		//�]�w�@�W�٬�rmUsername��cookie�A�O����J���ϥΪ̱b���A�O�s����30��
		setcookie("rmUsername",$_POST['uCheck'],time()+3600*24*30);
		//�]�w�@�W�٬�rmPassword��cookie�A�O����J���ϥΪ̱K�X�A�O�s����30��
		setcookie("rmPassword",$_POST['pCheck'],time()+3600*24*30);
	}else{
		setcookie("rmUsername",'', time()); //�R���O���b����Cookie
		setcookie("rmPassword",'', time()); //�R���O���K�X��Cookie
	}
}
date_default_timezone_set("Asia/Taipei");

 $mailUsername = "ckassessment@gmail.com";
 $mailPassword = "ntcub507";


//��Ʈw�]�w
$dbtype='mysql';
$hostspec='localhost';
$dbuser=$db_user='ckuser';
$dbpass=$db_user_passwd='kbc78!@#$%';
$database=$db_dbn='ck';  //��Ʈw�W��
//grant all privileges on mftWS.* to mftadmin@localhost identified by '2wsx7ujm';

$dbhost = 'localhost';
//�����{�Ҫ���ƪ�
$auth_table='member';
//�������e��ƪ�
//$news_table='news';
//�n�J�᤹�\�����m�ɶ�(��)
define('_IDLETIME' , '36000');
$idletime = 36000;
//�n�J��cookie���s���ɶ�(��)
$expire = 36000;

// session_start();

//PDO
$config['db']['dsn']='mysql:host=localhost;dbname=ck;charset=utf8';
$config['db']['user'] = 'ckuser';
$config['db']['password'] = 'kbc78!@#$%';
$dbh = new PDO(
	$config['db']['dsn'],
	$config['db']['user'] ,
	$config['db']['password'],
	array(
		PDO::ATTR_EMULATE_PREPARES => false,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	)
);
$dbh->exec("SET NAMES utf8");
?>
