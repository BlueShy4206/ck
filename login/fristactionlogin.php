<?php
require_once('../Connections/conn_web.php'); 

if (!isset($_SESSION)) {
  session_start();
}
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
$email = $_POST['email'];
$password = $_POST['password'];
$refer = $_POST['refer'];
$_SESSION['ROWS']=1;

if ($email == '' || $password == '')
{
    // No login information
    header('Location: index.php?refer='. urlencode($_POST['refer']));
}
else
{
	
	 
	  mysql_select_db($database_conn_web, $conn_web);
     $query_web_member = sprintf("SELECT * FROM forfirst WHERE id = %s AND password = %s", 
	 GetSQLValueString($email, "text"),
	 GetSQLValueString(md5($password), "text"));
     $web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
     $row_web_member = mysql_fetch_assoc($web_member);
     $totalRows_web_member = mysql_num_rows($web_member);
	 
	 if($totalRows_web_member == 0){           
       mysql_free_result($web_member);
       header('Location: index.php?err=error');
       
    }
    else
    {   
	    $_SESSION['IDNAME']=$email;
       
		$refer = 'fristexamOutprint.php';
        mysql_free_result($web_member);
		header('Location: '. $refer);
    }
}
?>

