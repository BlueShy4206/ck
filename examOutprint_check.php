<?php require_once('Connections/conn_web.php');
require_once "PEAR183/HTML/QuickForm.php";
require_once "examAdd_function.php";

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
$datetime= date("Y/m/d H:i:s");

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}

if ($_SESSION['user_level']== '0'){
    $TestingRegulations=$TestingRegulations_s;
}
if ($_SESSION['user_level']== '1'){
    $TestingRegulations=$TestingRegulations_t;
}

// mysql_select_db($database_conn_web, $conn_web);
//$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s ORDER BY SUBSTR( id, 3, 4 ) DESC , SUBSTR( id, 2, 9 ) DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"));
//update by coway 2016.8.11
// $query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s ORDER BY no DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"));
// $web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
// $row_web_examinee = mysql_fetch_assoc($web_examinee);
// $totalRows_web_member = mysql_num_rows($web_examinee);

mysql_select_db($database_conn_web, $conn_web);
$query_web_new = "SELECT * FROM examyear Where status = '1' ORDER BY id DESC LIMIT 0,1";
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);
$totalRows_web_new = mysql_num_rows($web_new);

$todayyear = $row_web_new['times'];
$todayyear .= date("Y");
mysql_select_db($database_conn_web, $conn_web);
//update by coway 2016.8.18
// $query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND id LIKE %s ORDER BY SUBSTR( id, 3, 4 ) DESC , SUBSTR( id, 2, 9 ) DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"),GetSQLValueString("%" . $todayyear . "%", "text"));
$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND id LIKE %s ORDER BY no DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"),GetSQLValueString("%" . $todayyear . "%", "text"));
$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
$row_web_examinee = mysql_fetch_assoc($web_examinee);
//$row_web_examinee user相關資料
$totalRows_web_member = mysql_num_rows($web_examinee);
if($row_web_examinee["read_examout"] != '0'){
     header(sprintf("Location: %s", "examOutprint.php"));//換頁
}


// echo $datetime;
// print_r($row_web_examinee);
if (isset($_POST["btnSentOK"]) ){
	$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND id LIKE %s ORDER BY no DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"),GetSQLValueString("%" . $todayyear . "%", "text"));
	$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
	$row_web_examinee = mysql_fetch_assoc($web_examinee);

	if($row_web_examinee["read_examout"] == '0'){
	     //UPdate的地方
		 $insertSQL = sprintf("UPDATE examinee SET read_examout=%s  WHERE id=%s",
						 GetSQLValueString($datetime, "text"),
						 GetSQLValueString($row_web_examinee['id'], "text"));
		 mysql_select_db($database_conn_web, $conn_web);
		 $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());
		 //echo "<br>sql:$insertSQL";
		 if(mysql_affected_rows() > 0) {
			 $updateGoTo = "examOutprint.php";
			 header(sprintf("Location: %s", $updateGoTo));
		 }
	}
}




?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>試場規則</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="報名考試" />
<meta name="keywords" content="報名考試" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="Scripts/sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="Scripts/sweetalert2/dist/sweetalert2.min.css">
<script type="text/javascript">
	function SaveAlert(cert_number){

		var str=document.getElementsByName("chk[]");
		var objarray=str.length;
	// 		alert("123="+objarray);
	// 		break;
		var iCnt=0;
		//判斷checkbox是否已全部勾選
		for (i=0;i<objarray;i++){
			 if(str[i].checked == true){iCnt++;}
		}
		// alert("iCnt="+iCnt+'====='+objarray);
		if( iCnt != objarray)
		{
	// 			alert("Ticket="+$Ticket);
			alert("請閱讀並同意勾選試場規則，是否已逐筆☑勾選完成!!");
				window.event.returnValue=false;
	// 			window.location.reload();
	// 			if(confirm('確定刪除本資料?')){
	// 			location.href='examAdd.php?action=no';}
	// 			break;
	// 			location.href='examAdd.php';
		}else{
		if(confirm("請問您是否已確實看完且同意試場規則")){

			}else{
				window.event.returnValue=false;
			}
		}//history.go(-1) ;
		// return false;
	}
</script>
</head>

<body  background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="exam" align="center">
	<form id="form3" name="form3" method="post" enctype="multipart/form-data" action="<?php echo $editFormAction; ?>" onsubmit="YY_checkform">

    <table width="580" border="0" cellspacing="0" cellpadding="0" >
        <tr>
          <td width="25" align="left"><img src="images/board03.gif" /></td>
          <td width="505" align="left" background="images/board04.gif">試場規則<span class="font_black"></span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="580" border="0" cellspacing="0" cellpadding="2">
        <div align="center" style="width:580px; color:red; font-size:15px" class="board_add"><b>請閱讀並同意後勾選試場規則!!</b></div>
        <?PHP foreach($TestingRegulations as $value){?>
            <tr>
    			<td width="50" align="left" class="board_add"><input type="checkbox" name="chk[]" style="WIDTH: 20px; HEIGHT: 20px"></input></td>
    			<td align="left" class="board_add" style="padding-top: 6px;padding-bottom: 6px;padding-left: 6px;padding-right: 6px;font-size: 15px;">
    				<?PHP echo $value;?>
    			</td>
    		</tr>
            <?php
        }?>



				<!--  -->


        <tr>
          <td height="40" colspan="3" align="center"><label>
          <?php if($row_web_examinee['allow'] == '0'){
          		if($row_web_examinee["status"] == '0'){
          			$update_url = 'examupdate.php';
          		}else $update_url = 'examupdate1.php';
          	?>
           <input type="button" value="修正資料" onclick="location.href='<?php echo $update_url;?>'" />  <?php } ?>
          <!--  <input type="button" name="Submit" value="列印本頁" onclick="javascript:window.print()">  -->
          </label>
     	<!--     <label>
          <input type="button" value="列印報名表" onclick="location.href='examOuttoprint.php'" />
          <input type="button" value="確認報名，送出" onclick="location.href='index.php'" />
          </label>-->
          <label>
            <input type="submit" name="btnSentOK" value="確認報名，送出" onclick="SaveAlert('<?php echo $cert_number?>');" />
          </label></td>

        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="memberadd" />
    </form>

  </div>
  <div id="main4"></div>

<?php include("footer.php"); ?>
</div>
</body>
</html>
