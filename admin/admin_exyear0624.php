<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>

<?
header("Cache-control:private");//解決session 引起的回上一頁表單被清空
?>

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$startday=$_POST["startyear"]."-".$_POST["startmonth"]."-".$_POST["startday"];
	$endday=$_POST["endyear"]."-".$_POST["endmonth"]."-".$_POST["endday"];
	$printtime=$_POST["printyear"]."-".$_POST["printmonth"]."-".$_POST["printday"];
	$ndateday=$_POST['ndateyear']."-".$_POST['ndatemonth']."-".$_POST['ndateday'];
	$cdateday=$_POST['cdateyear']."-".$_POST['cdatemonth']."-".$_POST['cdateday'];
	$sdateday=$_POST['sdateyear']."-".$_POST['sdatemonth']."-".$_POST['sdateday'];
	$edateday=$_POST['edateyear']."-".$_POST['edatemonth']."-".$_POST['edateday'];
  $insertSQL = sprintf("INSERT INTO examyear (startday, endday, times, printtime, ndate, cdate, sdate, edate) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($startday, "text"),
                       GetSQLValueString($endday, "text"),                       GetSQLValueString($_POST['times'], "text"),
					   GetSQLValueString($printtime, "text"),
					   GetSQLValueString($ndateday, "text"),
					   GetSQLValueString($cdateday, "text"),
					   GetSQLValueString($sdateday, "text"),
					   GetSQLValueString($edateday, "text"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());

  $insertGoTo = "admin_exyear.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn_web, $conn_web);
$query_web_new = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);
$totalRows_web_new = mysql_num_rows($web_new);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理後台</title>



<link href="../web.css" rel="stylesheet" type="text/css" />
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
</head>


<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="admin_main2">
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
    <table width="540" border="0" cellspacing="0" cellpadding="0" >
     <tr>
        <td width="25" align="left"><img src="../images/board16.gif"/></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">報名開放管理</span></td>
        <td width="416" align="left" background="../images/board04.gif"></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    
      <tr>
      <td width="25" align="left"></td>
        <td width="140" align="right">
<div><span class="font_red">管理員</span>您好
 </div>      
        </td>
        <td width="444" align="left">&nbsp;</td>
        
       
      </tr>
    </table>
    <table width="540" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="140" height="20" align="right" class="board_add">現在時間：</td>
        <td width="405" align="left" class="board_add"><label>
          <? echo date('Y-m-d');?></label></td>
      </tr>
      <tr>
        <td width="140" height="20" align="right" class="board_add">最後開放報名時間：</td>
        <td width="405" align="left" class="board_add"><label>
          <? echo $row_web_new['startday'];?> 至 <? echo $row_web_new['endday'];?></label></td>
      </tr>
      <tr>
        <td width="140" height="20" align="right" class="board_add">是否已開放報名：</td>
        
        <td width="405" align="left" class="board_add"><label>
          <? if(strtotime($row_web_new['startday']) <= strtotime(date('Y-m-d')) && strtotime(date('Y-m-d')) <= strtotime($row_web_new['endday'])){echo "<span class=\"font_red\">YES</span>";}else{echo "NO";}?></label></td>
      </tr>
      <tr>
        <td width="140" height="20" align="right" class="board_add">准考證開始列印時間：</td>
        
        <td width="405" align="left" class="board_add"><label>
          <? echo $row_web_new['printtime'];?></label></td>
      </tr>
      <tr>
        <td width="140" height="20" align="right" class="board_add">考試時間：</td>
        
        <td width="405" align="left" class="board_add"><label>
           北區：<? echo $row_web_new['ndate'];?>  中區： <? echo $row_web_new['cdate'];?> 南區： <? echo $row_web_new['sdate'];?> 東區： <? echo $row_web_new['edate'];?></label></td>
      </tr>
      <tr>
        <td height="20" align="right" class="board_add">報名時間開始：</td>
        <td align="left" class="board_add"><p class="table_lineheight">
           <select name="startyear" id="startyear">
             <option>年</option>
               <script language="javascript" type="text/javascript">
                   var watch=new Date();
                   var thisYear=watch.getFullYear();
				   for(y=thisYear;y<=thisYear+1;y++){
                       document.write("<option value='"+y+"'>"+y+"</option>")
	                  }
	           </script>
          </select>
          
          <select name="startmonth" id="startmonth">
            <option>月</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(m=01;m<=12;m++){
                       document.write("<option value='"+m+"'>"+m+"</option>")
	                  }
	           </script>
           </select>
 
           <select name="startday" id="startday">
            <option>日</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(d=01;d<=31;d++){
                       document.write("<option value='"+d+"'>"+d+"</option>")
	                  }
	           </script>
          </select>
         </td>
      </tr>
      <tr>
        <td height="20" align="right" class="board_add">報名時間結束：</td>
        <td align="left" class="board_add"><p class="table_lineheight">
           <select name="endyear" id="endyear">
             <option>年</option>
               <script language="javascript" type="text/javascript">
                   var watch=new Date();
                   var thisYear=watch.getFullYear();
				   for(y=thisYear;y<=thisYear+1;y++){
                       document.write("<option value='"+y+"'>"+y+"</option>")
	                  }
	           </script>
          </select>
          
          <select name="endmonth" id="endmonth">
            <option>月</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(m=01;m<=12;m++){
                       document.write("<option value='"+m+"'>"+m+"</option>")
	                  }
	           </script>
           </select>
 
           <select name="endday" id="endday">
            <option>日</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(d=01;d<=31;d++){
                       document.write("<option value='"+d+"'>"+d+"</option>")
	                  }
	           </script>
          </select>
         </td>
      </tr>
      <td height="20" align="right" class="board_add">准考證列印時間：</td>
        <td align="left" class="board_add"><p class="table_lineheight">
           <select name="printyear" id="printyear">
             <option>年</option>
               <script language="javascript" type="text/javascript">
                   var watch=new Date();
                   var thisYear=watch.getFullYear();
				   for(y=thisYear;y<=thisYear+1;y++){
                       document.write("<option value='"+y+"'>"+y+"</option>")
	                  }
	           </script>
          </select>
          
          <select name="printmonth" id="printmonth">
            <option>月</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(m=01;m<=12;m++){
                       document.write("<option value='"+m+"'>"+m+"</option>")
	                  }
	           </script>
           </select>
 
           <select name="printday" id="printday">
            <option>日</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(d=01;d<=31;d++){
                       document.write("<option value='"+d+"'>"+d+"</option>")
	                  }
	           </script>
          </select>
         </td>
      </tr>
       <tr>
        <td height="20" align="right" class="board_add"><p>北區：</p>
          <p>考試時間 中區：</p>
          <p>南區：</p>
          <p>東區：</p></td>
        <td align="left" class="board_add"><p class="table_lineheight"><select name="ndateyear" id="ndateyear">
             <option>年</option>
               <script language="javascript" type="text/javascript">
                   var watch=new Date();
                   var thisYear=watch.getFullYear();
				   for(y=thisYear;y<=thisYear+1;y++){
                       document.write("<option value='"+y+"'>"+y+"</option>")
	                  }
	           </script>
          </select>
          
          <select name="ndatemonth" id="ndatemonth">
            <option>月</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(m=01;m<=12;m++){
                       document.write("<option value='"+m+"'>"+m+"</option>")
	                  }
	           </script>
           </select>
 
           <select name="ndateday" id="ndateday">
            <option>日</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(d=01;d<=31;d++){
                       document.write("<option value='"+d+"'>"+d+"</option>")
	                  }
	           </script>
          </select>
          <p><select name="cdateyear" id="cdateyear">
             <option>年</option>
               <script language="javascript" type="text/javascript">
                   var watch=new Date();
                   var thisYear=watch.getFullYear();
				   for(y=thisYear;y<=thisYear+1;y++){
                       document.write("<option value='"+y+"'>"+y+"</option>")
	                  }
	           </script>
          </select>
          
          <select name="cdatemonth" id="cdatemonth">
            <option>月</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(m=01;m<=12;m++){
                       document.write("<option value='"+m+"'>"+m+"</option>")
	                  }
	           </script>
           </select>
 
           <select name="cdateday" id="cdateday">
            <option>日</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(d=01;d<=31;d++){
                       document.write("<option value='"+d+"'>"+d+"</option>")
	                  }
	           </script>
          </select></p>
          <p><select name="sdateyear" id="sdateyear">
             <option>年</option>
               <script language="javascript" type="text/javascript">
                   var watch=new Date();
                   var thisYear=watch.getFullYear();
				   for(y=thisYear;y<=thisYear+1;y++){
                       document.write("<option value='"+y+"'>"+y+"</option>")
	                  }
	           </script>
          </select>
          
          <select name="sdatemonth" id="sdatemonth">
            <option>月</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(m=01;m<=12;m++){
                       document.write("<option value='"+m+"'>"+m+"</option>")
	                  }
	           </script>
           </select>
 
           <select name="sdateday" id="sdateday">
            <option>日</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(d=01;d<=31;d++){
                       document.write("<option value='"+d+"'>"+d+"</option>")
	                  }
	           </script>
          </select></p>
          <p><select name="edateyear" id="edateyear">
             <option>年</option>
               <script language="javascript" type="text/javascript">
                   var watch=new Date();
                   var thisYear=watch.getFullYear();
				   for(y=thisYear;y<=thisYear+1;y++){
                       document.write("<option value='"+y+"'>"+y+"</option>")
	                  }
	           </script>
          </select>
          
          <select name="edatemonth" id="edatemonth">
            <option>月</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(m=01;m<=12;m++){
                       document.write("<option value='"+m+"'>"+m+"</option>")
	                  }
	           </script>
           </select>
 
           <select name="edateday" id="edateday">
            <option>日</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(d=01;d<=31;d++){
                       document.write("<option value='"+d+"'>"+d+"</option>")
	                  }
	           </script>
          </select></p> 
          
         </td>
      </tr>
      <tr>
        <td width="140" height="20" align="right" class="board_add">上次為：</td>
        <td width="405" align="left" class="board_add"><label>
         本年度第 <?php 
		  if(substr(($row_web_new['endday']),0,4)== date("Y")){
		  if (!(strcmp($row_web_new['times'],"A"))) {echo "1";}
		  if (!(strcmp($row_web_new['times'],"B"))) {echo "2";}
		  if (!(strcmp($row_web_new['times'],"C"))) {echo "3";}
		  if (!(strcmp($row_web_new['times'],"D"))) {echo "4";}
		  if (!(strcmp($row_web_new['times'],"E"))) {echo "5";}
		  if (!(strcmp($row_web_new['times'],"F"))) {echo "6";}
		  if (!(strcmp($row_web_new['times'],"G"))) {echo "7";}
		  if (!(strcmp($row_web_new['times'],"H"))) {echo "8";}
		  if (!(strcmp($row_web_new['times'],"I"))) {echo "9";}
		  if (!(strcmp($row_web_new['times'],"J"))) {echo "10";}
		  if (!(strcmp($row_web_new['times'],"K"))) {echo "11";}
		  if (!(strcmp($row_web_new['times'],"L"))) {echo "12";}
		  if (!(strcmp($row_web_new['times'],"M"))) {echo "13";}
		  if (!(strcmp($row_web_new['times'],"N"))) {echo "14";}
		  if (!(strcmp($row_web_new['times'],"O"))) {echo "15";}
		  if (!(strcmp($row_web_new['times'],"P"))) {echo "16";}}else{
			echo "0";  
			  }
		   ?> 次考試</label></td>
      </tr>
      <tr>
        <td width="140" height="20" align="right" class="board_add">本次考試為：</td>
        
        <td width="405" align="left" class="board_add">本年度第  
          <select name="times">
                              <option value="A" selected="selected">1</option>
                              <option value="B" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"A"))) {echo "selected=\"selected\"";}} ?>>2</option>
                              <option value="C" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"B"))) {echo "selected=\"selected\"";}} ?>>3</option>
                              <option value="D" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"C"))) {echo "selected=\"selected\"";}} ?>>4</option>
                              <option value="E" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"D"))) {echo "selected=\"selected\"";}} ?>>5</option>
                              <option value="F" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"E"))) {echo "selected=\"selected\"";}} ?>>6</option>
                              <option value="G" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"F"))) {echo "selected=\"selected\"";}} ?>>7</option>
                              <option value="H" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"G"))) {echo "selected=\"selected\"";}} ?>>8</option>
                              <option value="I" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"H"))) {echo "selected=\"selected\"";}} ?>>9</option>
                              <option value="J" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"I"))) {echo "selected=\"selected\"";}} ?>>10</option>
                              <option value="K" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"J"))) {echo "selected=\"selected\"";}} ?>>11</option>
                              <option value="L" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"K"))) {echo "selected=\"selected\"";}} ?>>12</option>
                              <option value="M" <?php if(substr(($row_web_new['endday']),0,4)== date("Y")){if (!(strcmp($row_web_new['times'],"L"))) {echo "selected=\"selected\"";}} ?>>13</option>
                              <option value="N" <?php if(substr(($row_web_new['endday']),0,4)== date("Y"))if (!(strcmp($row_web_new['times'],"M"))) {echo "selected=\"selected\"";} ?>>14</option>
                              <option value="O" <?php if(substr(($row_web_new['endday']),0,4)== date("Y"))if (!(strcmp($row_web_new['times'],"N"))) {echo "selected=\"selected\"";} ?>>15</option>
                              <option value="P" <?php if(substr(($row_web_new['endday']),0,4)== date("Y"))if (!(strcmp($row_web_new['times'],"O"))) {echo "selected=\"selected\"";} ?>>16</option>
                              
                            </select> 
           次</td>
      </tr>
    </table>
    <label>
      <br />
      <input type="submit" name="button" id="button" value="新增" />&nbsp;&nbsp;
    </label>
  

    <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
               <input type="button" class="style1" onclick="location='logout.php'" value="登出" />
    <br />
    <input type="hidden" name="MM_insert" value="form1" />
    </form>
    </div>
 <div id="admin_main3">
       <? include("right_zone.php");?>
  </div>
  <div id="main4"></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>

<?php
mysql_free_result($web_new);
?>
