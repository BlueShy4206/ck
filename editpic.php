<?php require_once('Connections/conn_web.php'); ?>
<?PHP
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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}
$filename = $_GET['id'];
mysql_select_db($database_conn_web, $conn_web);
$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND pic_name = %s ORDER BY id DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"),GetSQLValueString($filename, "text"));
$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
$row_web_examinee = mysql_fetch_assoc($web_examinee);
$totalRows_web_examinee = mysql_num_rows($web_examinee);

?>

<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Jcrop</title>  
<script src= "js/jquery-1.6.2.min.js" ></script>  
<script src= "js/jquery.Jcrop.min.js" ></script>  
<link rel= "stylesheet"  href= "js/jquery.Jcrop.min.css"  type= "text/css"  />  
<style type= "text/css" >  
#preview{width:100px;height:100px;border:1px solid # 000 ;overflow:hidden;}  
#imghead{filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=image);}  
</style>  
<script language= "Javascript" >  
jQuery(function(){  
 jQuery( '#imghead' ).Jcrop({  
  aspectRatio:  0.8 ,  
  onSelect: updateCoords, //選中區域時執行對應的回調函數  
  onChange: updateCoords, //選擇區域變化時執行對應的回調函數  
 });  
});  
function updateCoords(c)  
{  
 jQuery( '#x' ).val(c.x); //選中區域左上角橫座標  
 jQuery( '#y' ).val(c.y); //選中區域左上角縱座標 
 //jQuery( "#x2" ).val(c.x2); //選中區域右下角橫坐標  
 //jQuery( "#y2" ).val(c.y2); //選中區域右下角縱座標  
 jQuery( '#w' ).val(c.w); //選中區域的寬度  
 jQuery( '#h' ).val(c.h); //選中區域的高度  
};  
function checkCoords()  
{  
 if (parseInt(jQuery( '#w' ).val())> 0 ) return true;  
 alert( '請選擇需要裁切的區域' );  
 return false;  
};  
</script>  
<?PHP 
$filename=$_GET['id'];
$ext = pathinfo($_GET['id'], PATHINFO_EXTENSION); 

?>


</head>
  
<body>

 <?php if ($totalRows_web_examinee > 0) { // Show if recordset not empty ?> 
 
<img id= "imghead"  border= 0  src= 'images/examinee/<?PHP echo $filename; ?>'  />  
<form action= "crop.php"  method= "post"  onsubmit= "return checkCoords();" >  
 <input type="hidden"  id= "x"  name= "x"  />  
 <input type="hidden"  id= "y"  name= "y"  />  
 <input type="hidden"  id= "w"  name= "w"  />  
 <input type="hidden"  id= "h"  name= "h"  />  
 <input type= "submit"  value= "確定" >
 <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
 <input name="filename" type="hidden" id="filename" value="<? echo $filename;?>" />
</form>

<?PHP }else{
	 header('Location: examOut.php');}?>  
</body>  
</html>  