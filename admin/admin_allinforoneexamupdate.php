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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
  $updateSQL = sprintf("UPDATE forfirst SET name=%s, school=%s, sex=%s, Student_ID=%s, Department=%s, Grade=%s WHERE id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['school'] , "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['Student_ID'], "text"),
                       GetSQLValueString($_POST['Department'], "date"),
                       GetSQLValueString($_POST['Grade'], "text"),
                       GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());

  $updateGoTo = "admin_allinforoneexammember.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_web_member = "-1";
if (isset($_GET['id'])) {
  $colname_web_member = $_GET['id'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_member = sprintf("SELECT * FROM forfirst WHERE id = %s", GetSQLValueString($colname_web_member, "text"));
$web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_member);
$totalRows_web_member = mysql_num_rows($web_member);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理後台</title>
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="國民小學教師學科知能評量" />
<meta name="keywords" content="國民小學教師學科知能評量" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="../web.css" rel="stylesheet" type="text/css" />
<script language=javascript src="../address.js"></script><!--引入郵遞區號.js檔案-->
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="admin_main2">
  <form id="form3" name="form3" method="POST" action="<?php echo $editFormAction; ?>">
      <table width="540" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
        <tr>
          <td width="25" align="left"><img src="../images/board03.gif" /></td>
          <td width="505" align="left" background="../images/board04.gif">&nbsp; <span class="font_black">親愛的管理員，您正在編輯會員[<?php echo $row_web_member['username']; ?></span><span class="font_red">&nbsp; &nbsp;</span><span class="font_black">]的資料</span></td>
          <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="540" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td height="30" align="right" class="board_add">帳號：</td>
          <td align="left" class="board_add"><label>
            <?php echo $row_web_member['id']; ?>
          </label></td>
        </tr>
        <tr>
          <td width="82" height="30" align="right" class="board_add">姓名：</td>
          <td width="458" align="left" class="board_add"><label>
            <input name="name" type="text" id="name" value="<?php echo $row_web_member['name']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">密碼：</td>
          <td align="left" class="board_add"><?php echo $row_web_member['seepass']; ?></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">學校：</td>
          <td align="left" class="board_add"><label>
            <input name="school" type="text" id="school" value="<?php echo $row_web_member['school']; ?>" size="35" />
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">性別：</td>
          <td align="left" class="board_add"><label>
           <input name="sex" type="text" id="sex" value="<?php echo $row_web_member['sex']; ?>" size="10" /></label>
         </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">學號：</td>
          <td align="left" class="board_add"><label>
            <input name="Student_ID" type="text" id="Student_ID" value="<?php echo $row_web_member['Student_ID']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">系所：</td>
          <td align="left" class="board_add"><label>
            <input name="Department" type="text" id="Department" value="<?php echo $row_web_member['Department']; ?>" />
          </label></td>
        </tr>
        
        <tr>
          <td height="30" align="right" class="board_add">年級：</td>
          <td align="left" class="board_add">
            <input name="Grade" type="text" id="Grade" value="<?php echo $row_web_member['Grade']; ?>" size="10" />
          </td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="center"><label>
            <input type="submit" name="button" id="button" value="更新資料" />
            <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
            <input name="id" type="hidden" id="id" value="<?php echo $row_web_member['id']; ?>" />
          </label></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form3" />
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
mysql_free_result($web_member);
?>
