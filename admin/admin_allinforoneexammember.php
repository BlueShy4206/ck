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
$startRow_web_member = $pageNum_web_member * $maxRows_web_member;

//$colname_web_search = "-1";
if (isset($_GET['keyword'])) {
  $colname_web_search =htmlspecialchars(strip_tags($_GET['keyword']), ENT_QUOTES) ;
}

if($colname_web_search != ""){
mysql_select_db($database_conn_web, $conn_web);
$query_web_member = sprintf("SELECT * FROM forfirst WHERE (id LIKE %s or name LIKE %s) ORDER BY id ASC", GetSQLValueString($colname_web_search, "text"), GetSQLValueString("%".$colname_web_search."%", "text"));
$query_limit_web_member = sprintf("%s LIMIT %d, %d", $query_web_member, $startRow_web_member, $maxRows_web_member);
$web_member = mysql_query($query_limit_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_member);
}else{
mysql_select_db($database_conn_web, $conn_web);
$query_web_member = "SELECT * FROM forfirst ORDER BY id ASC";
$query_limit_web_member = sprintf("%s LIMIT %d, %d", $query_web_member, $startRow_web_member, $maxRows_web_member);
$web_member = mysql_query($query_limit_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_member);
}

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
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="admin_main2">
  <?php if($row_web_member == 0){ ?>
   <table width="555" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="25" align="left"><img src="../images/board08.gif" /></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">考試會員管理區&nbsp; &nbsp;</span></td>
        <td width="416" align="left" background="../images/board04.gif"><form id="Search" name="Search" method="get" action="admin_allinforoneexammember.php">
      <label>
          <input name="keyword" type="text" class="inputstyle2" id="keyword" />
        <input type="submit" name="button" id="button" value="搜尋" />
        </label>
       </form></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
  <table width="555" border="0" cellspacing="0" cellpadding="0">
       查無資料
    </table>
  <?php }else{ ?>
    <table width="555" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="25" align="left"><img src="../images/board08.gif" /></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">考試會員管理區&nbsp; &nbsp;</span></td>
        <td width="416" align="left" background="../images/board04.gif">    <form id="Search" name="Search" method="get" action="admin_allinforoneexammember.php">
      <label>
         <input name="keyword" type="text" class="inputstyle2" id="keyword" />
        <input type="submit" name="button" id="button" value="搜尋" />
      </label>
    </form></td>
      <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <table width="555" border="0" cellspacing="0" cellpadding="0">
      <?php do { ?>
        <tr>
          <td width="20" align="center" class="board_add"><?php echo $row_web_member['id']; ?></td>
          <td width="435" height="30" align="left" class="board_add">&nbsp; &nbsp;[<?php echo $row_web_member['name']; ?> ] <?php echo $row_web_member['school']; ?> - <?php echo $row_web_member['seepass']; ?>
           </td>
          <td width="100" align="center" class="board_add">[ <a href="admin_allinforoneexamupdate.php?id=<?php echo $row_web_member['id']; ?>">編輯</a> ] [ <a href="admin_allinforoneexammemberDel.php?id=<?php echo $row_web_member['id']; ?>&amp;delSure=1" onclick="tfm_confirmLink('確定刪除本資料?');return document.MM_returnValue">刪除</a> ]</td>
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
     <?php } ?>
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
