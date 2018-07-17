<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

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
    echo "$MM_referrer====";
    die();
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理後台</title>



<link href="../web.css" rel="stylesheet" type="text/css" />
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
</head>

<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<body>
<?php include("header.php"); ?>
<div id="main">
<div id="main1"></div>
  <div id="admin_main2">
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
    <table width="540" border="0" cellspacing="0" cellpadding="0" >
     <tr>
        <td width="25" align="left"><img src="../images/board17.gif"/></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">匯入考試成績</span></td>
        <td width="416" align="left" background="../images/board04.gif"></td>
        <td width="10" align="right" background="../images/board04.gif"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>

      <tr>
        <td width="25" align="left"></td>
        <td width="140" align="left">
<div><span class="font_red">管理員</span>您好
 </div>
        </td>
        <td width="444" align="left" >&nbsp;</td>

        <td width="68" align="right">&nbsp;</td>
      </tr>
    </table>
    <table width="550" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="98" height="20" align="left" class="board_add"></td>
        <td width="442" align="left" class="font_red2" bgcolor="#FFFFFF"> 匯 入 結 果</td>

      </tr>
      <tr>
      	<td width="550" align="center" class="font_red2" colspan="2"><?php echo "成功筆數: $_SESSION[sumSuccess], 失敗筆數: $_SESSION[sumFail], 已存在筆數: $_SESSION[sumexist]";?></td>
      </tr>
    </table>
    <?php if($_SESSION[memerr] != "" or $_SESSION[exerr] != ""){ ?>
    <table width="550" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="98" height="20" align="left" class="board_add">無法匯入會員：</td>
        <td width="442" align="left" class="font_red2" bgcolor="#FFFFFF"><?php echo $_SESSION[memerr]; ?> </td>
      </tr>

      <tr>
        <td width="98" height="20" align="left" class="board_add">無法匯入考生：</td>
        <td width="442" align="left" class="font_red2" bgcolor="#FFFFFF"><?php echo $_SESSION[exerr]; ?> </td>
      </tr>

    </table>

    <?php
	  unset($_SESSION[memerr]);
      unset($_SESSION[exerr]);

	}?>

    <?php if($_SESSION[memid] != "" or $_SESSION[mempass] != ""){
	$memid=explode("、",$_SESSION[memid]);
	$mempass=explode("、",$_SESSION[mempass]);
	//$idpass=array($memid => $mempass);
	?>
    <table width="550" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
        <td width="200" height="20" align="left" class="board_add">帳號</td>
        <td width="200" align="left" class="board_add" bgcolor="#FFFFFF">密碼 </td>
      </tr>

      <?php foreach($memid as $nameid) {
			$query_web_Recordset2 = sprintf("SELECT * FROM forfirst WHERE id LIKE %s  ORDER BY id ASC", GetSQLValueString($nameid, "text"));
			$web_Recordset2 = mysql_query($query_web_Recordset2) or die(mysql_error());
			$totalRows_web_Recordset2 = mysql_num_rows($web_Recordset2);
			$row_web_Recordset2 = mysql_fetch_array($web_Recordset2);

		  echo '<tr>
        <td width="98" height="20" align="left" class="board_add">'.$nameid.'</td>
        <td width="442" align="left" class="font_red2" bgcolor="#FFFFFF"> '.$row_web_Recordset2['seepass'].'</td>
      </tr>';

		  }?>


    </table>

    <?php
	  unset($_SESSION[memid]);
      unset($_SESSION[mempass]);
      unset($_SESSION[sumSuccess]);
      unset($_SESSION[sumFail]);
      unset($_SESSION[sumexist]);

	}?>

      <br />

    <input type="button" name="submit" value="回上一頁" onClick="location='admin.php'";>
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
