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
<? $i=1;?>
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

mysql_select_db($database_conn_web, $conn_web);
$query_web_banner = "SELECT * FROM banner ORDER BY banner_type ASC";
$web_banner = mysql_query($query_web_banner, $conn_web) or die(mysql_error());
$row_web_banner = mysql_fetch_assoc($web_banner);
$totalRows_web_banner = mysql_num_rows($web_banner);
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
<script src="../Scripts/swfobject_modified.js" type="text/javascript"></script>
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
    <table width="555" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="25" align="left"><img src="../images/board10.gif" /></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">圖文廣告管理區&nbsp; &nbsp;</span></td>
        <td width="416" align="left" valign="bottom" background="../images/board04.gif">
        <a href="admin_banner1Add.php"><img src="../images/icon_addfont.gif" title="增加跑馬燈文字廣告" border="0" /></a>
       <a href="admin_banner2Add.php"><img src="../images/icon_addswf.gif" title="增加SWF動畫廣告" border="0" /></a>
        <a href="admin_banner3Add.php"><img src="../images/icon_addpic.gif" title="增加圖像廣告" border="0" /></a> 
        </td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <?php if ($totalRows_web_banner > 0) { // Show if recordset not empty ?>
      <table width="555" border="0" cellspacing="0" cellpadding="0">
        <?php do { ?>
          <tr>
            <td width="20" align="center" class="board_add3">&nbsp;</td>
            <td width="50" height="30" align="center" class="board_add3"><?php /*START_PHP_SIRFCIT*/ if ($row_web_banner['banner_type']=="1"){ ?>
                <img src="../images/icon_font.gif" />
                <?php } /*END_PHP_SIRFCIT*/ ?>
              <?php /*START_PHP_SIRFCIT*/ if ($row_web_banner['banner_type']=="2"){ ?>
                <img src="../images/icon_swf.gif" />
                <?php } /*END_PHP_SIRFCIT*/ ?>
              <?php /*START_PHP_SIRFCIT*/ if ($row_web_banner['banner_type']=="3"){ ?>
                <img src="../images/icon_pic.gif" />
                <?php } /*END_PHP_SIRFCIT*/ ?></td>
            <td width="385" align="left" valign="middle" class="board_add3"><?php echo $row_web_banner['banner_title']; ?> <?php echo $row_web_banner['banner_url']; ?><br />
              <?php /*START_PHP_SIRFCIT*/ if ($row_web_banner['banner_type']=="2"){ ?>
              <object id="FlashID<? echo $i++?>" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="200" height="55">
                <param name="movie" value="../images/panner/<?php echo $row_web_banner['banner_pic']; ?>" />
                <param name="quality" value="high" />
                <param name="wmode" value="opaque" />
                <param name="swfversion" value="6.0.65.0" />
                <!-- 此 param 標籤會提示使用 Flash Player 6.0 r65 和更新版本的使用者下載最新版本的 Flash Player。如果您不想讓使用者看到這項提示，請將其刪除。 -->
                <param name="expressinstall" value="../Scripts/expressInstall.swf" />
                <!-- 下一個物件標籤僅供非 IE 瀏覽器使用。因此，請使用 IECC 將其自 IE 隱藏。 -->
                <!--[if !IE]>-->
          <object type="application/x-shockwave-flash" data="../images/panner/<?php echo $row_web_banner['banner_pic']; ?>" width="50" height="50">
            <!--<![endif]-->
                <param name="quality" value="high" />
                <param name="wmode" value="opaque" />
                <param name="swfversion" value="6.0.65.0" />
                <param name="expressinstall" value="../Scripts/expressInstall.swf" />
                <!-- 瀏覽器會為使用 Flash Player 6.0 和更早版本的使用者顯示下列替代內容。 -->
                <div>
                  <h4>這個頁面上的內容需要較新版本的 Adobe Flash Player。</h4>
                  <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="取得 Adobe Flash Player" width="200" height="55" /></a></p>
                </div>
                <!--[if !IE]>-->
            </object><?php } /*END_PHP_SIRFCIT*/ ?>
            <!--<![endif]-->
              </object>
              <br />
              <?php /*START_PHP_SIRFCIT*/ if ($row_web_banner['banner_type']=="3"){ ?>
                <img src="../images/panner/thum/<?php echo $row_web_banner['banner_pic']; ?>" width="200" height="55" />
                <?php } /*END_PHP_SIRFCIT*/ ?>
              <br /></td>
            <td width="100" align="center" class="board_add3">[ <a href="admin_banner<?php echo $row_web_banner['banner_type']; ?>Update.php?banner_id=<?php echo $row_web_banner['banner_id']; ?>">編輯</a> ]&nbsp; [ <a href="admin_banner<?php echo $row_web_banner['banner_type']; ?>Del.php?banner_id=<?php echo $row_web_banner['banner_id']; ?>&amp;banner_pic=<?php echo $row_web_banner['banner_pic']; ?>&amp;delSure=1" onclick="tfm_confirmLink('確定刪除本資料?');return document.MM_returnValue">刪除</a> ]</td>
          </tr>
          <?php } while ($row_web_banner = mysql_fetch_assoc($web_banner)); ?>
      </table>
      <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_web_banner == 0) { // Show if recordset empty ?>
  <table width="555" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2">目前資料庫中沒有任何資料!</td>
      </tr>
  </table>
  <?php } // Show if recordset empty ?>
  </div>
  <div id="admin_main3">
       <? include("right_zone.php");?>
  </div>
  <div id="main4"></div>
</div>
<?php include("footer.php"); ?>
<script type="text/javascript">
<!--
swfobject.registerObject("FlashID<? echo $i++?>");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($web_banner);
?>
