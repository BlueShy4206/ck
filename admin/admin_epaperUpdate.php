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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE epaper SET epaper_title=%s, epaper_content=%s, epaper_date=%s, epaper_send=%s WHERE epaper_id=%s",
                       GetSQLValueString($_POST['epaper_title'], "text"),
                       GetSQLValueString($_POST['epaper_content'], "text"),
                       GetSQLValueString($_POST['epaper_date'], "date"),
                       GetSQLValueString($_POST['epaper_send'], "text"),
                       GetSQLValueString($_POST['epaper_id'], "int"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());

  $updateGoTo = "admin_epaper.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_web_paper = "-1";
if (isset($_GET['epaper_id'])) {
  $colname_web_paper = $_GET['epaper_id'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_paper = sprintf("SELECT * FROM epaper WHERE epaper_id = %s", GetSQLValueString($colname_web_paper, "int"));
$web_paper = mysql_query($query_web_paper, $conn_web) or die(mysql_error());
$row_web_paper = mysql_fetch_assoc($web_paper);
$totalRows_web_paper = mysql_num_rows($web_paper);
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
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div align="center">
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
    <table width="760" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="25" align="left"><img src="../images/board09.gif" /></td>
        <td width="725" align="left" background="../images/board04.gif">&nbsp; <span class="font_black">編輯電子報</span></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <table width="760" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td width="101" height="20" align="left" class="board_add">標&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 題：</td>
        <td width="639" align="left" class="board_add"><label>
          <input name="epaper_title" type="text" id="epaper_title" value="<?php echo $row_web_paper['epaper_title']; ?>" size="40" />
        </label></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">修 改 發 送 狀 態：</td>
        <td align="left" class="board_add"><label>
          <input <?php if (!(strcmp($row_web_paper['epaper_send'],"Y"))) {echo "checked=\"checked\"";} ?> type="radio" name="epaper_send" id="radio" value="Y" />
        已發送
        <input <?php if (!(strcmp($row_web_paper['epaper_send'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="epaper_send" id="radio2" value="N" />
        未發送
        </label></td>
      </tr>
      <tr>
        <td height="20" align="left" class="board_add">日&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 期：</td>
        <td align="left" class="board_add"><label>
          <input name="epaper_date" type="text" id="epaper_date" value="<?php echo $row_web_paper['epaper_date']; ?>" />
          </label></td>
      </tr>
      <tr>
        <td colspan="2" align="left" class="board_add">電 子 報 內 容：<br />
          <br />
          <label>
            <textarea name="epaper_content" id="epaper_content" cols="80" rows="5" class="ckeditor"><?php echo $row_web_paper['epaper_content']; ?></textarea>
          </label>          <br /></td>
      </tr>
    </table>
    <label>
      <br />
      <input type="submit" name="button" id="button" value="更新電子報" />
    </label>
    <label>
      <input type="reset" name="button2" id="button2" value="重設" />
    </label>
    <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
    <input name="epaper_id" type="hidden" id="epaper_id" value="<?php echo $row_web_paper['epaper_id']; ?>" />
    <br />
    <br />
    <input type="hidden" name="MM_update" value="form1" />
    </form>
  </div>
  <div id="main4"></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>
<?php
mysql_free_result($web_paper);
?>
