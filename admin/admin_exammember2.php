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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_web_member = 10;
$pageNum_web_member = 0;
if (isset($_GET['pageNum_web_member'])) {
  $pageNum_web_member = $_GET['pageNum_web_member'];
}

mysql_select_db($database_conn_web, $conn_web);
$query_web_new = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);
$totalRows_web_new = mysql_num_rows($web_new);
$Ticket=$row_web_new['times'].substr(($row_web_new['endday']),0,4);



$startRow_web_member = $pageNum_web_member * $maxRows_web_member;

mysql_select_db($database_conn_web, $conn_web);
$query_web_member = sprintf("SELECT * FROM examinee WHERE id LIKE %s AND allow LIKE %s ORDER BY id ASC", GetSQLValueString("%" . $Ticket . "%", "text"), GetSQLValueString("%" . N . "%", "text"));
$query_limit_web_member = sprintf("%s LIMIT %d, %d", $query_web_member, $startRow_web_member, $maxRows_web_member);
$web_member = mysql_query($query_limit_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_member);

if (isset($_GET['totalRows_web_member'])) {
  $totalRows_web_member = $_GET['totalRows_web_member'];
} else {
  $all_web_member = mysql_query($query_web_member);
  $totalRows_web_member = mysql_num_rows($all_web_member);
}
$totalPages_web_member = ceil($totalRows_web_member/$maxRows_web_member)-1;

$queryString_web_member = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_web_member") == false && 
        stristr($param, "totalRows_web_member") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_web_member = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_web_member = sprintf("&totalRows_web_member=%d%s", $totalRows_web_member, $queryString_web_member);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理後台</title>
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="" />
<meta name="keywords" content="" />
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

</br>
<div align="center">
 
  <div id="admin_main8">
    <table width="555" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="25" align="left"><img src="../images/board08.gif" /></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">考試會員管理區&nbsp; &nbsp;</span></td>
        <td width="416" align="left" background="../images/board04.gif">&nbsp;</td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="0">
      <?php do { ?>
        <tr>
          <td width="20" align="center" class="board_add"><?php echo $row_web_member['id']; ?></td>
          <td width="435" height="30" align="left" class="board_add">&nbsp; &nbsp;[<?php echo $row_web_member['username']; ?> ] <?php echo $row_web_member['uname']; ?>&nbsp; &nbsp; - &nbsp;<img src="../images/examinee/<?php echo $row_web_member['pic_name']; ?>" alt="" name="pic" width="50" id="pic" /> &nbsp;
           <?php  if ($row_web_member['allow']=="N"){ ?>
              <img src="../images/crosses.jpg" width="20">
          <?php }  ?>
           </td>
          <td width="100" align="center" class="board_add">[ <a href="admin_examupdate.php?id=<?php echo $row_web_member['id']; ?>">編輯</a> ]&nbsp; [ <a href="admin_exammemberDel.php?id=<?php echo $row_web_member['id']; ?>&amp;delSure=1" onclick="tfm_confirmLink('確定刪除本資料?');return document.MM_returnValue">刪除</a> ]</td>
        </tr>
        <?php } while ($row_web_member = mysql_fetch_assoc($web_member)); ?>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="bottom">&nbsp;
          <table border="0">
            <tr>
              <td><?php if ($pageNum_web_member > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_web_member=%d%s", $currentPage, 0, $queryString_web_member); ?>">第一頁</a>
                  <?php } // Show if not first page ?></td>
              <td><?php if ($pageNum_web_member > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_web_member=%d%s", $currentPage, max(0, $pageNum_web_member - 1), $queryString_web_member); ?>">上一頁</a>
                  <?php } // Show if not first page ?></td>
              <td><?php if ($pageNum_web_member < $totalPages_web_member) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_web_member=%d%s", $currentPage, min($totalPages_web_member, $pageNum_web_member + 1), $queryString_web_member); ?>">下一頁</a>
                  <?php } // Show if not last page ?></td>
              <td><?php if ($pageNum_web_member < $totalPages_web_member) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_web_member=%d%s", $currentPage, $totalPages_web_member, $queryString_web_member); ?>">最後一頁</a>
                  <?php } // Show if not last page ?></td>
            </tr>
        </table></td>
        <td align="right" valign="bottom">&nbsp;
記錄 <?php echo ($startRow_web_member + 1) ?> 到 <?php echo min($startRow_web_member + $maxRows_web_member, $totalRows_web_member) ?> 共 <?php echo $totalRows_web_member ?></td>
      </tr>
    </table>
  </div>
  
</div>

</body>
</html>
<?php
mysql_free_result($web_member);
?>
<SCRIPT>
//定義左聯圖片的所在位置及其鏈接目標的地址
var leftsrc = "../images/arrow-to-left.jpg";
var leftlink = "admin_exammember.php";
//定義右聯圖片的所在位置及其鏈接目標的地址
var rightsrc =  "../images/arrow-to-right.jpg";
var rightlink = "admin_exammember.php";
//定義「關閉」按鈕圖片的所在位置
//var closesrc ="img/close.gif";

///////////////////////////
////  以下代碼無需改動  ////
//////////////////////////

lastScrollY=0;

function heartBeat(){ 
var diffY;
if (document.documentElement && document.documentElement.scrollTop)
diffY = document.documentElement.scrollTop;
else if (document.body)
diffY = document.body.scrollTop
else
{/*Netscape stuff*/}
//alert(diffY);
percent=.1*(diffY-lastScrollY); 
if(percent>0)percent=Math.ceil(percent); 
else percent=Math.floor(percent); 
document.getElementById("lovexin12").style.top=parseInt(document.getElementById
("lovexin12").style.top)+percent+"px";
document.getElementById("lovexin14").style.top=parseInt(document.getElementById("lovexin14").style.top)+percent+"px";
lastScrollY=lastScrollY+percent; 
//alert(lastScrollY);
} 

suspendcode12="<div id=\"lovexin12\" style='left:2px;position:absolute;top:200px; cursor:pointer;'><div onclick=javascript:location=\"" + leftlink + "\"><img src=\"" + leftsrc +"\" height=\"30px\" width=\"30px\"/></div><div/></div></div>"
//"onclick=\"document.getElementById('lovexin12').style.display = 'none'; document.getElementById('lovexin12').style.display = 'none';\" style='text-align:center;'><img src=\"" + closesrc +"\" /></div></div>"
suspendcode14="<div id=\"lovexin14\" style='right:2px;position:absolute;top:200px; cursor:pointer;'><div onclick=javascript:location=\"" + rightlink + "\"><img src=\"" + rightsrc +"\" height=\"30px\" width=\"30px\"/></div>"
//"<div onclick=\"document.getElementById('lovexin12').style.display = 'none'; document.getElementById('lovexin14').style.display = 'none';\" style='text-align:center;'><img src=\"" + closesrc +"\" /></div></div>"

document.write(suspendcode12); 
document.write(suspendcode14); 

window.setInterval("heartBeat()",1);
</SCRIPT>