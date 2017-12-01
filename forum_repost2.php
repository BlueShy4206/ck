<?php require_once('Connections/conn_web.php'); ?>
<?php
//自訂變數$re_quote記錄表單傳送過來的re_quote欄位資料
$re_quote=$_POST["re_quote"];
//如果未驗證到re_quoteY欄位勾選
if(empty($_POST["re_quoteY"])){
	$re_quote=''; //自訂變數$re_quote就設為空值
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formPost")) {
  $updateSQL = sprintf("UPDATE forum SET forum_lastman=%s, forum_lastdate=%s WHERE forum_id=%s",
                       GetSQLValueString($_POST['re_username'], "text"),
                       GetSQLValueString($_POST['re_date'], "int"),
                       GetSQLValueString($_POST['forum_id'], "int"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formPost")) {
  $insertSQL = sprintf("INSERT INTO forum_re (forum_id, re_title, re_img, re_content, re_quoteUser, re_quote, re_quoteDate, re_date, re_username, re_ip) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['forum_id'], "text"),
                       GetSQLValueString($_POST['re_title'], "text"),
                       GetSQLValueString($_POST['re_img'], "text"),
                       GetSQLValueString($_POST['re_content'], "text"),
                       GetSQLValueString($_POST['re_quoteUser'], "text"),
                       GetSQLValueString($re_quote, "text"),
                       GetSQLValueString($_POST['re_quoteDate'], "int"),
                       GetSQLValueString($_POST['re_date'], "int"),
                       GetSQLValueString($_POST['re_username'], "text"),
                       GetSQLValueString($_POST['re_ip'], "text"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());

  $insertGoTo = "forum_detial.php?forum_id=".$_POST["forum_id"];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  /* 依據取得的表單forum_id，更新forum資料forum_replies回覆文章欄位，作數值+1的SQL語法*/
  $updateSQL = "UPDATE forum SET forum_replies=forum_replies+1 WHERE forum_id = ".$_POST['forum_id'];
  /*執行更新動作*/
  mysql_select_db($database_conn_web, $conn_web);
  $Result = mysql_query($updateSQL, $conn_web) or die(mysql_error());
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_web_forumRe = "-1";
if (isset($_GET['re_id'])) {
  $colname_web_forumRe = $_GET['re_id'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_forumRe = sprintf("SELECT * FROM forum_re WHERE re_id = %s", GetSQLValueString($colname_web_forumRe, "int"));
$web_forumRe = mysql_query($query_web_forumRe, $conn_web) or die(mysql_error());
$row_web_forumRe = mysql_fetch_assoc($web_forumRe);
$totalRows_web_forumRe = mysql_num_rows($web_forumRe);
?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>國民小學教師學科知能評量</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="國民小學教師學科知能評量" />
<meta name="keywords" content="國民小學教師學科知能評量" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />
</head>

<body onload="MM_preloadImages('images/btn_shop1_2.gif','images/btn_shop2_2.gif','images/btn_shop3_2.gif','images/btn_shop4_2.gif','images/btn_shop5_2.gif','images/btn_shop6_2.gif')">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <? include("leftzone.php")?>
  </div>
  <div id="main3">
  <? if(isset($_SESSION["MM_Username"])){//如果驗證到會員登入的Session變數MM_Username，顯示本區塊?>
  <form id="formPost" name="formPost" method="POST" action="<?php echo $editFormAction; ?>">
    <table width="555" border="0" cellspacing="0" cellpadding="0" background="images/forum01.gif">
      <tr>
        <td height="34" colspan="4" align="left"><img src="images/forum04.gif" width="158" height="34" /></td>
        <td width="393" align="right" class="font_red">您的IP位置：<? echo $_SERVER["REMOTE_ADDR"];?> </td>
      </tr>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td colspan="2" class="board_add"><span class="font_black">原文作者：</span><?php echo $row_web_forumRe['re_username']; ?><br />          
          <label>
            <textarea name="re_quote" id="re_quote" cols="65" rows="5"><?php echo $row_web_forumRe['re_content']; ?></textarea>
          </label>
          <br />
          <span class="font_black">引用原文：</span><label>
  <input name="re_quoteY" type="checkbox" id="re_quoteY" value="Y" />
  <span class="font_black">**如果不需引用原文，不必勾選!!</span>
  <input name="re_quoteUser" type="hidden" id="re_quoteUser" value="<?php echo $row_web_forumRe['re_username']; ?>" />
  <input name="re_quoteDate" type="hidden" id="re_quoteDate" value="<?php echo $row_web_forumRe['re_date']; ?>" />
</label></td>
      </tr>
      <tr>
        <td width="82" height="30" class="board_add">回覆標題：</td>
        <td width="468" align="left" class="board_add"><label>
          <input name="re_title" type="text" id="re_title" value="Re:<?php echo $row_web_forumRe['re_title']; ?>" size="60" />
          </label><span class="font_red">* </span></td>
      </tr>
      <tr>
        <td height="30" class="board_add">表&nbsp; 情：</td>
        <td align="left" class="board_add"><table width="480" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><div id="board_pic"><img src="images/face/fface1.gif" width="80" height="80" /></div></td>
            <td align="center"><div id="board_pic"><img src="images/face/fface2.gif" width="80" height="80" /></div></td>
            <td align="center"><div id="board_pic"><img src="images/face/fface3.gif" width="80" height="80" /></div></td>
            <td align="center"><div id="board_pic"><img src="images/face/fface4.gif" width="80" height="80" /></div></td>
          </tr>
          <tr>
            <td align="center"><label>
              <input name="re_img" type="radio" id="radio" value="fface1.gif" checked="checked" />
            </label></td>
            <td align="center"><label>
              <input type="radio" name="re_img" id="radio" value="fface2.gif" />
            </label></td>
            <td align="center"><label>
              <input type="radio" name="re_img" id="radio" value="fface3.gif" />
            </label></td>
            <td align="center"><label>
              <input type="radio" name="re_img" id="radio" value="fface4.gif" />
            </label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2" class="board_add"><label> 回覆內容：<span class="font_red">*</span><br />
            <textarea name="re_content" id="re_content" cols="65" rows="10"></textarea>
            <br />
            <br />
        </label></td>
      </tr>
      <tr>
        <td height="40" colspan="2" align="center"><label>
          <input type="submit" name="button2" id="button2" value="送出回覆文章" />
          <input type="button" name="submit" value="回上一頁" onClick="window.history.back()";>
          <input name="forum_id" type="hidden" id="forum_id" value="<?php echo $row_web_forumRe['forum_id']; ?>" />
          <input name="re_date" type="hidden" id="re_date" value="<? echo time();?>" />
          <input name="re_username" type="hidden" id="re_username" value="<? echo $_SESSION["MM_Username"]?>" />
          <input name="re_ip" type="hidden" id="re_ip" value="<? echo $_SERVER["REMOTE_ADDR"];?>" />
        </label></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="formPost" />
    <input type="hidden" name="MM_update" value="formPost" />
  </form>
  <? }else{  //否則顯示另一個區塊?>
    <table width="555" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="80" align="center" class="font_red2">回覆文章前請先登入會員，謝謝。</td>
      </tr>
    </table>
  <? }?>
  </div>
  <div id="main4"></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>
<?php
mysql_free_result($web_forumRe);
?>
