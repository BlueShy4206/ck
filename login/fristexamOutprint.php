<?php require_once('../Connections/conn_web.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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


$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}

$member=$_SESSION['IDNAME'];

mysql_select_db($database_conn_web, $conn_web);
$query_web_member = sprintf("SELECT * FROM forfirst WHERE id = %s  ORDER BY id DESC LIMIT 0,1", GetSQLValueString($member, "text"));
$web_examinee = mysql_query($query_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_examinee);
$totalRows_web_member = mysql_num_rows($web_examinee);

$_SESSION['IDNAME']="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>成績查詢</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="成績查詢" />
<meta name="keywords" content="成績查詢" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="../web.css" rel="stylesheet" type="text/css" />

</head>

<body >

<div id="main111" background= "#FFFFFF">
  
 <?
 if($totalRows_web_member != 0){

  ?>
  
  <div id="exam" align="center">
     <table width="600" border="0" cellspacing="0" cellpadding="0" >
        <tr>
        <td width="10" align="right"><img src="../images/board005.gif" width="10" height="28" /></td>
          <td width="580" align="center"  background="../images/board04.gif" style="font-size:20px;"><font face="DFKai-sb">成績查詢</font></td>
          <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="600" border="0" cellspacing="0" cellpadding="2" >
        <tr>
          <td width="150" height="30" align="right" class="board_add" style="font-size:18px;"><p>准考證號碼：</p>
          <p>姓名：</p>
         </td>
          <td width="300" align="left" class="board_add" style="font-size:18px;">
          <p><?php echo $row_web_member['id']; ?></p>
          <p><?php echo $row_web_member['name']; ?></p>
         
          </td>
          
           <td width="150" height="130" align="left" class="board_add"></tr>
        
         <tr>
          <td width="150" height="10" align="right" class="board_add" style="font-size:18px;"></td>
          <td width="300" align="left" class="board_add" style="font-size:18px;">
          </td>
           <td width="150" height="10" align="left" class="board_add"></tr>
                  
       <tr>
       <td width="150" height="10" align="right" class="board_add" style="font-size:18px;">科目</td>
          <td width="300" align="center" class="board_add" style="font-size:18px;">成績</td>
          <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">備註</tr>
          <?php if($row_web_member['chinese'] != 0){  ?>
          
          <tr>
          <td width="150" height="10" align="right" class="board_add" style="font-size:18px;">國文</td>
          <td width="300" align="center" class="board_add" style="font-size:18px;"><?php echo $row_web_member['chinese']; ?>       
          </td>
          <?php if($row_web_member['chinese']>603){?>          
           <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">精熟</td> <?php }elseif($row_web_member['chinese']<=603 && $row_web_member['chinese']>413) {?>
           <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">基礎</td> <?php }elseif($row_web_member['chinese']<=413){ ?>
           <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">待加強</td> <?php } ?>
           </tr>
           <?php } ?>
           <?php if($row_web_member['math'] != 0){  ?>
          
          <tr>
          <td width="150" height="10" align="right" class="board_add" style="font-size:18px;">數學</td>
          <td width="300" align="center" class="board_add" style="font-size:18px;"><?php echo $row_web_member['math']; ?>       
          </td>          
           <?php if($row_web_member['math']>608){?>          
           <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">精熟</td> <?php }elseif($row_web_member['math']<=608 && $row_web_member['math']>420) {?>
           <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">基礎</td> <?php }elseif($row_web_member['math']<=420){ ?>
           <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">待加強</td> <?php } ?>
           </tr>
           <?php } ?>
           <?php if($row_web_member['social'] != 0){  ?>
          
          <tr>
          <td width="150" height="10" align="right" class="board_add" style="font-size:18px;">社會</td>
          <td width="300" align="center" class="board_add" style="font-size:18px;"><?php echo $row_web_member['social']; ?>       
          </td>          
           <?php if($row_web_member['social']>606){?>          
           <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">精熟</td> <?php }elseif($row_web_member['social']<=606 && $row_web_member['social']>440) {?>
           <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">基礎</td> <?php }elseif($row_web_member['social']<=440){ ?>
           <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">待加強</td> <?php } ?>
           </tr>
           <?php } ?>
           <?php if($row_web_member['physical'] != 0){  ?>
          
          <tr>
          <td width="150" height="10" align="right" class="board_add" style="font-size:18px;">自然</td>
          <td width="300" align="center" class="board_add" style="font-size:18px;"><?php echo $row_web_member['physical']; ?>       
          </td>          
          <?php if($row_web_member['physical']>587){?>          
           <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">精熟</td> <?php }elseif($row_web_member['physical']<=587 && $row_web_member['physical']>417) {?>
           <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">基礎</td> <?php }elseif($row_web_member['physical']<=417){ ?>
           <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">待加強</td> <?php } ?>
           </tr>
           <?php } ?>
           
           <tr>
              
          <td height="40" colspan="3" align="center">
          <p>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </p>
            </td>
          
        </tr>
                    <tr>
              
                    
        </tr>

          
          
          <tr>
              
          <td height="40" colspan="3" align="center">
		  </td>
          
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="memberadd" />
    </form>
    
  </div>
 </div>
<?PHP }else{?>
  <table width="555" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td height="80" align="center" class="font_red2">請輸入正確的帳號密碼</td>
      </tr>
      <tr>
      <td height="80" align="center"><a href="index.php">[返回首頁]</a></td>
      </tr>
  </table>
<?PHP }?>
</body>
</html>
<?php 
mysql_free_result($web_examinee);
?>