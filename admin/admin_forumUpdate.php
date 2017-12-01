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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "repost1")) {
  $updateSQL = sprintf("UPDATE forum SET forum_title=%s, forum_top=%s, forum_content=%s WHERE forum_id=%s",
                       GetSQLValueString($_POST['forum_title'], "text"),
                       GetSQLValueString($_POST['forum_top'], "text"),
                       GetSQLValueString($_POST['forum_content'], "text"),
                       GetSQLValueString($_POST['forum_id'], "int"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());

  $updateGoTo = "admin_forum.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "repost2")) {
  $updateSQL = sprintf("UPDATE forum_re SET re_title=%s, re_content=%s WHERE re_id=%s",
                       GetSQLValueString($_POST['re_title'], "text"),
                       GetSQLValueString($_POST['re_content'], "text"),
                       GetSQLValueString($_POST['re_id'], "int"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());

  $updateGoTo = "admin_forum.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_web_forum = "-1";
if (isset($_GET['forum_id'])) {
  $colname_web_forum = $_GET['forum_id'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_forum = sprintf("SELECT * FROM forum WHERE forum_id = %s", GetSQLValueString($colname_web_forum, "int"));
$web_forum = mysql_query($query_web_forum, $conn_web) or die(mysql_error());
$row_web_forum = mysql_fetch_assoc($web_forum);
$totalRows_web_forum = mysql_num_rows($web_forum);

$colname_web_forumRe = "-1";
if (isset($_GET['forum_id'])) {
  $colname_web_forumRe = $_GET['forum_id'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_forumRe = sprintf("SELECT * FROM forum_re WHERE forum_id = %s ORDER BY re_id ASC", GetSQLValueString($colname_web_forumRe, "text"));
$web_forumRe = mysql_query($query_web_forumRe, $conn_web) or die(mysql_error());
$row_web_forumRe = mysql_fetch_assoc($web_forumRe);
$totalRows_web_forumRe = mysql_num_rows($web_forumRe);
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
<script type="text/javascript">
<!--
function tfm_confirmLink(message) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
}
//-->
</script>
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="admin_main2">
    <table width="555" border="0" cellspacing="0" cellpadding="0" background="../images/forum01.gif">
      <tr>
        <td height="34" colspan="2" align="left"><img src="../images/forum02.gif" width="158" height="34" /></td>
      </tr>
      <tr>
        <td width="411" height="36" align="left" class="font_title2">&nbsp;標題：<?php echo $row_web_forum['forum_title']; ?></td>
        <td width="144" align="right" class="underline2"><span class="font_black"><?php echo $row_web_forum['forum_date']; ?>&nbsp;</span></td>
      </tr>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="0" class="board_add2">
      <form id="repost1" name="repost1" method="POST" action="<?php echo $editFormAction; ?>">
        <tr>
          <td width="115" rowspan="2" align="center" valign="top"><br />
            <div id="board_pic"><img src="../images/face/<?php echo $row_web_forum['forum_img']; ?>" width="80" height="80" /></div>
            <div id="board_namefont">&nbsp;<?php echo $row_web_forum['forum_username']; ?></div>
            [ <a href="admin_forumDel.php?delSure=1&amp;forum_id=<?php echo $row_web_forum['forum_id']; ?>" onclick="tfm_confirmLink('確定刪除本討論主題及所屬回覆留言?');return document.MM_returnValue">刪除本資料</a> ] 
            </td>
        </tr>
        <tr>
          <td colspan="2" valign="top" align="left"><br />
            <img src="../images/icon_forum_top.gif" width="38" height="16" hspace="10" /><span class="font_black">文章設定置頂：
                        <label>
                          <input <?php if (!(strcmp($row_web_forum['forum_top'],"Y"))) {echo "checked=\"checked\"";} ?> type="radio" name="forum_top" id="radio" value="Y" />
                        是
                        <input <?php if (!(strcmp($row_web_forum['forum_top'],"N"))) {echo "checked=\"checked\"";} ?> type="radio" name="forum_top" id="radio2" value="N" />
            否</label>
            </span>
            <table width="430" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="11" valign="top" background="../images/board02.gif"><img src="../images/board01.gif" width="11" height="40" /></td>
                <td width="429" align="left" valign="top" class="board_line1"><div class="board_post"><span class="font_black">標題：</span> 
                  <label>
                    <input name="forum_title" type="text" id="forum_title" value="<?php echo $row_web_forum['forum_title']; ?>" size="45" />
                  </label>
                  <br />
                
                    <label>
                      <textarea name="forum_content" id="forum_content" cols="45" rows="5"><?php echo $row_web_forum['forum_content']; ?></textarea>
                    </label>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="78%" valign="middle" class="font_black">IP位置：<?php echo $row_web_forum['forum_ip']; ?></td>
                      <td width="22%" align="right" valign="middle">&nbsp;</td>
                    </tr>
                  </table>
                </div>
                <div class="board_repost">
                <label>
                  <input type="submit" name="button" id="button" value="送出修改" />
                </label>
                <input name="forum_id" type="hidden" id="forum_id" value="<?php echo $row_web_forum['forum_id']; ?>" />
                </div>
                </td>
              </tr>
            </table></td>
        </tr>
        <input type="hidden" name="MM_update" value="repost1" />
      </form>
    </table>
    <?php do { ?>
      <?php if ($totalRows_web_forumRe > 0) { // Show if recordset not empty ?>
  <table width="555" border="0" cellspacing="0" cellpadding="0" class="board_add2">
    <form id="repost2" name="repost2" method="POST" action="<?php echo $editFormAction; ?>">
      <tr>
        <td width="115" rowspan="2" align="center" valign="top"><br />
          <div id="board_pic"><img src="../images/face/<?php echo $row_web_forumRe['re_img']; ?>" width="80" height="80" /></div>
          <div id="board_namefont"><?php echo $row_web_forumRe['re_username']; ?>&nbsp;</div>
          [ <a href="admin_forumDel2.php?delSure=1&amp;forum_id=<?php echo $row_web_forumRe['forum_id']; ?>&amp;re_id=<?php echo $row_web_forumRe['re_id']; ?>" onclick="tfm_confirmLink('確定刪除本回覆留言?');return document.MM_returnValue">刪除本資料</a> ] 
          </td>
        <td width="260" align="left" class="font_black">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_web_forumRe['re_title']; ?></td>
        <td width="180" height="20" align="right" class="font_black">發表時間：<?php echo $row_web_forumRe['re_date']; ?>&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top"><table width="430" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="11" valign="top" background="../images/board02.gif"><img src="../images/board01.gif" width="11" height="40" /></td>
            <td width="429" align="left" valign="top" class="board_line1"><?php /*START_PHP_SIRFCIT*/ if ($row_web_forumRe['re_quote']!=""){ ?>
                <div class="board_repost2"> <span class="font_black">引用</span><span class="font_red"><?php echo $row_web_forumRe['re_quoteUser']; ?></span><span class="font_black"> 於</span><span class="font_red"><?php echo $row_web_forumRe['re_quoteDate']; ?></span><span class="font_black"> 發表</span>
                  <div class="board_repost3"><?php echo $row_web_forumRe['re_quote']; ?></div>
                </div>
                <?php } /*END_PHP_SIRFCIT*/ ?>
              <div class="board_post">
                <span class="font_black">標題：</span> 
                <label>
                  <input name="re_title" type="text" id="re_title" value="<?php echo $row_web_forumRe['re_title']; ?>" size="45" />
                  </label>
                <br />
                <label>
                  <textarea name="re_content" id="re_content" cols="45" rows="5"><?php echo $row_web_forumRe['re_content']; ?></textarea>
                  </label>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="78%" valign="middle" class="font_black">IP位置：<?php echo $row_web_forumRe['re_ip']; ?></td>
                    <td width="22%" align="right" valign="middle"></td>
                    </tr>
                  </table>
              </div>
              <div class="board_repost">
                <label>
                  <input type="submit" name="button" id="button" value="送出修改" />
                  </label>
                <input name="re_id" type="hidden" id="re_id" value="<?php echo $row_web_forumRe['re_id']; ?>" />
              </div>
            </td>
          </tr>
        </table></td>
      </tr>
      <input type="hidden" name="MM_update" value="repost2" />
    </form>
  </table>
  <?php } // Show if recordset not empty ?>
      <?php } while ($row_web_forumRe = mysql_fetch_assoc($web_forumRe)); ?>
<br />
    <div align="center"><input type="button" name="submit" value="回上一頁" onClick="window.history.back()";>
    <script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<input name="Submit" type="button" onclick="MM_goToURL('parent','admin_forum.php');return document.MM_returnValue" value="回討論區管理主頁面" />
    </div>
    <br />
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
mysql_free_result($web_forum);

mysql_free_result($web_forumRe);
?>
