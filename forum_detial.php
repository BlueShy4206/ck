<?php require_once('Connections/conn_web.php'); ?>
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
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dreamweaver+PHP資料庫網站製作</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="Dreamweaver+PHP資料庫網站製作" />
<meta name="keywords" content="Dreamweaver+PHP資料庫網站製作" />
<meta name="author" content="joj設計、joj網頁設計、joj Design、joj Web Design、呂昶億、杜慎甄" />
<link href="web.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <? include("leftzone.php")?>
  </div>
  <div id="main3">
    <table width="555" border="0" cellspacing="0" cellpadding="0" background="images/forum01.gif">
      <tr>
        <td height="34" colspan="2" align="left"><img src="images/forum02.gif" width="158" height="34" /></td>
      </tr>
      <tr>
        <td width="411" height="36" align="left" class="font_title2">&nbsp;標題：<?php echo $row_web_forum['forum_title']; ?></td>
        <td width="144" align="right" class="underline2"><span class="font_black">&nbsp;</span><?php echo date("Y-m-d H:i:s",$row_web_forum['forum_date']); ?></td>
      </tr>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="0" class="board_add2">
      <form id="repost1" name="form1" method="get" action="forum_repost1.php">
      <tr>
        <td width="115" rowspan="2" align="center" valign="top"><br />
          <div id="board_pic"><img src="images/face/<?php echo $row_web_forum['forum_img']; ?>" width="80" height="80" /></div>
          <div id="board_namefont">&nbsp;<?php echo $row_web_forum['forum_username']; ?></div></td>
      </tr>
      <tr>
        <td colspan="2" valign="top"><br />
          <table width="430" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="11" valign="top" background="images/board02.gif"><img src="images/board01.gif" width="11" height="40" /></td>
            <td width="429" align="left" valign="top" class="board_line1">
            
            <div class="board_post"> <?php echo $row_web_forum['forum_content']; ?><br />
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="45%" valign="middle" class="font_black">IP位置：<?php echo $row_web_forum['forum_ip']; ?></td>
                  <td width="55%" align="right" valign="middle">
                    <input name="forum_id" type="hidden" id="forum_id" value="<?php echo $row_web_forum['forum_id']; ?>" />
                    <label>
                      <input type="image" name="imageField3" id="imageField3" src="images/icon_re.gif" />
                    </label>
                  </td>
                </tr>
              </table>
            </div>
             </td>
          </tr>
        </table></td>
      </tr>
      </form>
    </table>
    <?php do { ?>
      <?php if ($totalRows_web_forumRe > 0) { // Show if recordset not empty ?>
  <table width="555" border="0" cellspacing="0" cellpadding="0" class="board_add2">
    <form id="repost2" name="form1" method="get" action="forum_repost2.php">
      <tr>
        <td width="115" rowspan="2" align="center" valign="top"><br />
          <div id="board_pic"><img src="images/face/<?php echo $row_web_forumRe['re_img']; ?>" width="80" height="80" /></div>
          <div id="board_namefont">&nbsp;<?php echo $row_web_forumRe['re_username']; ?></div></td>
        <td width="260" align="left" class="font_black">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row_web_forumRe['re_title']; ?></td>
        <td width="180" height="20" align="right" class="font_black">發表時間：<?php echo date("Y-m-d H:i:s",$row_web_forumRe['re_date']); ?>&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" valign="top"><table width="430" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="11" valign="top" background="images/board02.gif"><img src="images/board01.gif" width="11" height="40" /></td>
            <td width="429" align="left" valign="top" class="board_line1"><?php /*START_PHP_SIRFCIT*/ if ($row_web_forumRe['re_quote']!=""){ ?>
                <div class="board_repost2"> <span class="font_black">引用</span><span class="font_red"><?php echo $row_web_forumRe['re_quoteUser']; ?></span><span class="font_black"> 於</span><span class="font_red"><?php echo date("Y-m-d H:i:s",$row_web_forumRe['re_quoteDate']); ?></span><span class="font_black"> 發表</span>
                  <div class="board_repost3"><?php echo $row_web_forumRe['re_quote']; ?></div>
                </div>
                <?php } /*END_PHP_SIRFCIT*/ ?>
              <div class="board_post"> <?php echo $row_web_forumRe['re_content']; ?><br />
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="45%" valign="middle" class="font_black">IP位置：<?php echo $row_web_forumRe['re_ip']; ?></td>
                    <td width="55%" align="right" valign="middle">
                      <input name="re_id" type="hidden" id="re_id" value="<?php echo $row_web_forumRe['re_id']; ?>" />
                      <label>
                        <input type="image" name="imageField3" id="imageField3" src="images/icon_re.gif" />
                        </label></td>
                    </tr>
                  </table>
              </div></td>
          </tr>
        </table></td>
      </tr>
    </form>
  </table>
  <?php } // Show if recordset not empty ?>
      <?php } while ($row_web_forumRe = mysql_fetch_assoc($web_forumRe)); ?>
<br />
    <div align="center"><input type="button" name="submit" value="回上一頁" onClick="window.history.back()";><input type="button" name="Submit2" value="回討論區主頁" onclick="window.location='forum.php'"></div>
    <br />
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
