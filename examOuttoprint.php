
<?php require_once('Connections/conn_web.php');
require_once "PEAR183/HTML/QuickForm.php";?>
<script type="text/javascript">
	function SaveAlert(cert_number){
		var str=document.getElementsByName("chk[]");
		var objarray=str.length;
// 		break;
		var iCnt=0;
		var iCnt_n=0;
		//判斷checkbox是否已全部勾選
		for (i=0;i<objarray;i++){
			 if(str[i].checked == true){iCnt++;
			 }else{iCnt_n++;}
		}
// 		alert("iCnt_n="+iCnt_n);
// 		if(iCnt != 16)
		if(iCnt_n > 0)
		{
			alert("請重新確認報名資料，是否已逐筆☑勾選完成!!");
// 			history.go(-1) ;
// 			history.back();
			window.event.returnValue=false;

		}else{
		if(confirm("一旦點選  【確認】 即不得再修正報名表資訊!")){
// 		alert("您已完成線上報名登錄，您的網路登錄報名流水號為："+cert_number+"。\n提醒您：請至「報名進度查詢」中列印報名表，檢附相關證件，始完成報名流程");
			}else{window.event.returnValue=false;}

		}//history.go(-1) ;
	}

	function DeleteAlert(){
// 		var str=document.getElementsByName("MM_delete");
// 		alert(str.length);
		if(confirm('確定刪除本資料?')){
		location.href='examOut1.php?action=delete';}
	}
</script>
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


$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}

mysql_select_db($database_conn_web, $conn_web);
//$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s ORDER BY SUBSTR( id, 3, 4 ) DESC , SUBSTR( id, 2, 9 ) DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"));
//update by coway 2016.8.11
// $query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s ORDER BY no DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"));
// $web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
// $row_web_examinee = mysql_fetch_assoc($web_examinee);
// $totalRows_web_member = mysql_num_rows($web_examinee);

mysql_select_db($database_conn_web, $conn_web);
//update by coway 2016.8.19
// $query_web_new = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$query_web_new = "SELECT * FROM examyear WHERE status='1' ORDER BY id DESC LIMIT 0,1";
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);
$totalRows_web_new = mysql_num_rows($web_new);

$todayyear=$row_web_new['times'].substr(($row_web_new['endday']),0,4);//第幾次+西元年
mysql_select_db($database_conn_web, $conn_web);
$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND id LIKE %s ORDER BY DATE DESC", GetSQLValueString($colname_web_member, "text"),
		GetSQLValueString("%" . $todayyear . "%", "text"));
$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
$row_web_examinee = mysql_fetch_assoc($web_examinee);
$totalRows_web_examinee = mysql_num_rows($web_examinee);

//取得報考資格_流水號 ,add by coway 2016.8.25
$cert_number= sprintf("%s-%s",$row_web_examinee['cert_no'],sprintf("%04d", $row_web_examinee['cert_id']));

//取得學歷資料 ,add by coway 2016.8.19
$degreeArray = array($row_web_examinee['Edu_level4']=>array($row_web_examinee['Other2'],$row_web_examinee['Other2_dept'],$row_web_examinee['Edu_MK4'],$row_web_examinee['Other2_college']),
		$row_web_examinee['Edu_level']=>array($row_web_examinee['Highest'],$row_web_examinee['Department'],$row_web_examinee['Edu_MK'],$row_web_examinee['High_college']),
		$row_web_examinee['Edu_level2']=>array($row_web_examinee['Sec_highest'],$row_web_examinee['Sec_dept'],$row_web_examinee['Edu_MK2'],$row_web_examinee['Sec_college']),
		$row_web_examinee['Edu_level3']=>array($row_web_examinee['Other1'],$row_web_examinee['Other1_dept'],$row_web_examinee['Edu_MK3'],$row_web_examinee['Other1_college'])

);


//取得報考資格 add by coway 2016.8.18
mysql_select_db($database_conn_web, $conn_web);
$query_web_allguideC = sprintf("SELECT * FROM allguide WHERE up_no='IDt' and no=%s " , GetSQLValueString($row_web_examinee['cert_no'], "text"));
$web_allguideC = mysql_query($query_web_allguideC, $conn_web) or die(mysql_error());
$row_web_allguideC = mysql_fetch_assoc($web_allguideC);


if($row_web_examinee["status"] == '0'){
	$up_no ='EA2';
}else $up_no ='EA';

mysql_select_db($database_conn_web, $conn_web);
$query_web_allguide = sprintf("SELECT * FROM allguide Where up_no= %s AND nm= %s AND data2= %s", GetSQLValueString($up_no, "text"),GetSQLValueString($row_web_examinee['exarea'], "text"), GetSQLValueString($row_web_examinee['exarea_note'], "text"));
$web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
$row_allguide = mysql_fetch_assoc($web_allguide);

//刪除報名表 ,add by coway 2016.8.12
if ((isset($_GET["action"])) && ($_GET["action"]=="delete")){
	$deleteSQL = sprintf("DELETE FROM examinee WHERE no=%s",
                       GetSQLValueString($row_web_examinee['no'], "text"));
// 	echo "no=".$row_web_examinee["no"]."<br>";
  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($deleteSQL, $conn_web) or die(mysql_error());

  $deleteGoTo = "index.php";
  header(sprintf("Location: %s", $deleteGoTo));

}
//examinee_check 資料撈取 add by BlueS 20180302
mysql_select_db($database_conn_web, $conn_web);
$web_examinee_pic = sprintf("SELECT * FROM `examinee_pic` where examinee_no = %s " , GetSQLValueString($row_web_examinee['no'], "text"));
$examinee_pic = mysql_query($web_examinee_pic, $conn_web) or die(mysql_error());
$row_examinee_pic = mysql_fetch_assoc($examinee_pic);

// echo "chkMK=".$_POST["chkMK"]."<br>";

if (isset($_POST["btnSentOK"]) ){
	//再次抓取人數，確認可否報名
	$check = false;
	$Ticket =substr($row_web_examinee['id'], 0,6);
	//抓取(正取)師資生的報名資料 status=0
	$query_web_search2 = sprintf("SELECT id FROM examinee WHERE id LIKE %s
			AND Qualify=1 AND status=0 AND exarea_note = %s AND apply_mk=1 ORDER BY id DESC", GetSQLValueString("%" . $Ticket . "%", "text"), GetSQLValueString($row_web_examinee['exarea_note'], "text"));
	$web_search2 = mysql_query($query_web_search2, $conn_web) or die(mysql_error());
	$row_web_search2 = mysql_fetch_assoc($web_search2);
	$totalRows_web_search2 = mysql_num_rows($web_search2);

	//抓取(備取)師資生的報名資料 status=0
	$query_web_search_last2 = sprintf("SELECT id FROM examinee WHERE id LIKE %s
			AND Qualify=0 AND status=0 AND exarea_note = %s AND apply_mk=1 ORDER BY id DESC", GetSQLValueString("%" . $Ticket . "%", "text"), GetSQLValueString($row_web_examinee['exarea_note'], "text"));
	$web_search_last2 = mysql_query($query_web_search_last2, $conn_web) or die(mysql_error());
	$row_web_search_last2 = mysql_fetch_assoc($web_search_last2);
	$totalRows_web_search_last2 = mysql_num_rows($web_search_last2);

	$query_web_allguide2 = sprintf("SELECT * FROM allguide Where up_no='EA2' AND nm= %s AND data2= %s",GetSQLValueString($_POST['exarea'][0], "text"), GetSQLValueString($_POST['exarea'][2], "text"));
	$web_allguide2 = mysql_query($query_web_allguide2, $conn_web) or die(mysql_error());
	$row_web_allguide2 = mysql_fetch_assoc($web_allguide2);

	$exam_date = $row_web_allguide2['data1'];

	//echo "報名:$totalRows_web_search2, 正取:$row_allguide[data3]<br>";
	//echo "報名:$totalRows_web_search_last2, 備取:$row_allguide[data4]<br>";
	if($totalRows_web_search2 >= (int)$row_allguide['data3']){
		if($totalRows_web_search_last2 >= (int)$row_allguide['data4']){
			?>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<script type="text/javascript">
			alert("報名人數已滿，請選擇其他場次。");
			window.history.back();
			</script>;
			<?php
		}else $check = true;
	}else $check = true;


	//echo "check:$check";

	if($check){
		$insertSQL = sprintf("UPDATE examinee SET apply_mk=%s  WHERE id=%s",
						GetSQLValueString('1', "text"),
						GetSQLValueString($row_web_examinee['id'], "text"));
		mysql_select_db($database_conn_web, $conn_web);
		$Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());
		//echo "<br>sql:$insertSQL";
		$updateGoTo = "progress.php?status=1&check=ok&cert_number=$cert_number";

		header(sprintf("Location: %s", $updateGoTo));
	}
}


$form = new HTML_QuickForm('examOut1','post','');
$init='';
$select1[$init]='請選擇-地區';
$select2[$init][$init]='請選擇-考場';
$select3[$init][$init][$init]='請選擇-日期場次';
$select3[$init]['考場'][$init]='日期場次';

//查詢各考場正/備取人數
mysql_select_db($database_conn_web, $conn_web);
//$query_web_allguide = sprintf("SELECT * FROM allguide Where up_no='EA2' AND nm= %s AND data2= %s",GetSQLValueString($row_web_examinee['exarea'], "text"), GetSQLValueString($row_web_examinee['exarea_note'], "text"));
$query_web_allguideEA = "SELECT * FROM allguide Where up_no='EA2'";
$web_allguideEA = mysql_query($query_web_allguideEA, $conn_web) or die(mysql_error());
$i=0;
while ($row_allguideEA = mysql_fetch_assoc($web_allguideEA)){
	$select1[$row_allguideEA['nm']]=substr($row_allguideEA['note'], 0, 6);
	$select2[$row_allguideEA['nm']][$init]='請選擇-考場';
	$select3[$row_allguideEA['nm']][$init][$init]='請選擇-日期場次';
	$select2[$row_allguideEA['nm']][$row_allguideEA['note']]=$row_allguideEA['note'];
	$select3[$row_allguideEA['nm']][$row_allguideEA['note']][$init]='請選擇-日期場次';
	$select3[$row_allguideEA['nm']][$row_allguideEA['note']][$row_allguideEA['data2']]=$row_allguideEA['data1'];
}

function getStatus($value){
	IF(isset($value)){
		IF ($value =="1"){
			$status_leve="已畢業";
		}elseif ($value =="0") $status_leve="就學中";
	}
	return $status_leve;
}
?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>報名表</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="報名考試" />
<meta name="keywords" content="報名考試" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />

</head>

<body  background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>

  <div id="exam" align="center">
	<form id="form3" name="form3" method="post" enctype="multipart/form-data" action="<?php echo $editFormAction; ?>" onsubmit="YY_checkform">

    <table width="540" border="0" cellspacing="0" cellpadding="0" >
        <tr>
          <td width="25" align="left"><img src="images/board03.gif" /></td>
          <td width="505" align="left" background="images/board04.gif">報名表<span class="font_black" style="float: right; color:red;">流水號：<?php echo $cert_number;?></span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="540" border="0" cellspacing="0" cellpadding="2">
        <tr>
        <td width="110" height="30" align="right" class="board_add">姓名：</td>
          <td width="180" align="left" class="board_add"><?php echo $row_web_examinee['uname'];
		   if($row_web_examinee['eng_uname']!=""){
			  list($firstname, $lastname, $lastname2) = explode(" ", $row_web_examinee['eng_uname']);
			  if($firstname !=""){
			   	$eng_name="$firstname, $lastname $lastname2";

			  }
			   echo "<br>".$eng_name;//$row_web_examinee['eng_uname'];
		  }?></td>
          <td width="140" height="130" align="center" class="board_add"  rowspan="4"><img src="images/examinee/<?php echo $row_web_examinee['pic_name']; ?>" alt="" name="pic" width="100" id="pic" /></tr>
          <tr>
          <td height="30" align="right" class="board_add">性別：</td>
          <td align="left" class="board_add"><?php if (!(strcmp($row_web_examinee['sex'],"男"))) {echo "男";}
		  if (!(strcmp($row_web_examinee['sex'],"女"))) {echo "女";}
		   ?> </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">出生年月日：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['birthday']; ?></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">身分證字號：</td>
          <td align="left" class="board_add">
          <p><?php echo $row_web_examinee['per_id']; ?>
          </td>
        </tr>
        <!-- <tr>
           <td height="30" align="right" class="board_add">身份：</td>
          <td align="left" class="board_add">
          <?php if($row_web_examinee['status'] == '0') echo "國民小學師資類科師資生";
          		if($row_web_examinee['status'] == '1') echo "現職專任教師";
          ?></td>
           <td height="30" align="right" class="board_add"></td>
        </tr>-->
        <?php if($row_web_examinee['certificate'] != ""){ ?>
        <tr>
        <td height="30" align="right" class="board_add">教師證號碼：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['certificate']; ?></td>
           <td height="30" align="right" class="board_add"></td>
        </tr>
        <?php }?>
        <tr>
          <td height="30" align="right" class="board_add">E-mail：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['email']; ?></td>
           <td height="30" align="right" class="board_add"></td>
        </tr>
        <tr>
            <td height="30" align="right" class="board_add">聯絡電話：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['phone']; ?></td>
          <td height="30" align="right" class="board_add"></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">通訊地址：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['cuszip'];  echo $row_web_examinee['cusadr']; ?></td>
          <td height="30" align="right" class="board_add"></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><?php if($row_web_examinee['status'] == '1') echo "任職學校："; else echo "就讀學校："; ?><br></td>
          <td align="left" class="board_add">
          <?php if (!(strcmp($row_web_examinee['school'],"01_國立臺灣藝術大學"))) {echo "國立臺灣藝術大學";}
		  if (!(strcmp($row_web_examinee['school'],"02_文藻外語大學"))) {echo "文藻外語大學";}
		  if (!(strcmp($row_web_examinee['school'],"03_國立臺東大學"))) {echo "國立臺東大學";}
		  if (!(strcmp($row_web_examinee['school'],"04_國立東華大學"))) {echo "國立東華大學";}
		  if (!(strcmp($row_web_examinee['school'],"05_國立臺北教育大學"))) {echo "國立臺北教育大學";}
		  if (!(strcmp($row_web_examinee['school'],"06_輔仁大學"))) {echo "輔仁大學";}
		  if (!(strcmp($row_web_examinee['school'],"07_南臺科技大學"))) {echo "南臺科技大學";}
		  if (!(strcmp($row_web_examinee['school'],"08_國立屏東教育大學"))) {echo "國立屏東教育大學";}
		  if (!(strcmp($row_web_examinee['school'],"09_靜宜大學"))) {echo "靜宜大學";}
		  if (!(strcmp($row_web_examinee['school'],"10_國立新竹教育大學"))) {echo "國立新竹教育大學";}
		  if (!(strcmp($row_web_examinee['school'],"11_國立臺南大學"))) {echo "國立臺南大學";}
		  if (!(strcmp($row_web_examinee['school'],"12_國立高雄師範大學"))) {echo "國立高雄師範大學";}
		  if (!(strcmp($row_web_examinee['school'],"13_國立臺中教育大學"))) {echo "國立臺中教育大學";}
		  if (!(strcmp($row_web_examinee['school'],"14_臺北市立大學"))) {echo "臺北市立大學";}
		  if (!(strcmp($row_web_examinee['school'],"15_國立嘉義大學"))) {echo "國立嘉義大學";}
		  if (!(strcmp($row_web_examinee['school'],"17_國立臺灣海洋大學"))) {echo "國立臺灣海洋大學";}
		  ?>
		  <?php if($row_web_examinee['status'] == '1') echo $row_web_examinee['school']; ?>
          </td>
          <td height="30" align="right" class="board_add"></td>
        </tr>
        <?php if($degreeArray[4][0] != ""){ //if($row_web_examinee['Other1'] != ""){
        		$status_leve=getStatus($row_web_examinee['Edu_MK']);
        		$status_leve2=getStatus($row_web_examinee['Edu_MK2']);

        	?>
        <tr>
          <td height="30" align="right" class="board_add">博士學歷：</td>
          <td align="left" class="board_add"><?php echo $degreeArray[4][0].'('.getStatus($degreeArray[4][2]).')'; ?><br>
			<?php echo $degreeArray[4][3]." ".$degreeArray[4][1]; ?></td>
        <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>
<!--         <tr>
        <td width="10" align="left" class="board_add"><input type="checkbox" name="chk[]" style="WIDTH: 20px; HEIGHT: 20px"></input></td>
<!--           <td height="30" align="right" class="board_add">學院與科系：</td>
          <td align="left" class="board_add"><?php //echo $row_web_examinee['High_college']." ".$row_web_examinee['Department']; ?></td>
<!--           <td height="30" align="right" class="board_add"></td>
<!--         </tr> -->
        <?php if($degreeArray[3][0] != ""){//if($row_web_examinee['Sec_highest'] != ""){ ?>
        <tr>
          <td height="30" align="right" class="board_add">碩士學歷：</td>
          <td align="left" class="board_add"><?php echo $degreeArray[3][0].'('.getStatus($degreeArray[3][2]).')'; ?><br>
			<?php echo $degreeArray[3][3]." ".$degreeArray[3][1]; ?></td>
        <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>
        <?php //if($row_web_examinee['Sec_dept'] != ""){ ?>
<!--         <tr>
                 <td width="10" align="left" class="board_add"><input type="checkbox" name="chk[]" style="WIDTH: 20px; HEIGHT: 20px"></input></td>
<!--           <td height="30" align="right" class="board_add">學院與科系：</td>
          <td align="left" class="board_add"><?php //echo $row_web_examinee['Sec_college']." ".$row_web_examinee['Sec_dept']; ?></td>
<!--         <td height="30" align="right" class="board_add"></td>
        </tr>-->  <?php// } ?>
        <?php if($degreeArray[2][0] != ""){//if($row_web_examinee['Highest'] != ""){ ?>
        <tr>
            <td height="30" align="right" class="board_add">學士學歷：</td>
          <td align="left" class="board_add"><?php echo $degreeArray[2][0].'('.getStatus($degreeArray[2][2]).')'; ?><br>
			<?php echo $degreeArray[2][3]." ".$degreeArray[2][1]; ?></td>
        <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>
        <?php if($degreeArray[1][0] != ""){//if($row_web_examinee['Other2'] != ""){ ?>
        <tr>
          <td height="30" align="right" class="board_add">大專學歷：</td>
          <td align="left" class="board_add"><?php echo $degreeArray[1][0].'('.getStatus($degreeArray[1][2]).')'; ?><br>
			<?php echo $degreeArray[1][3]." ".$degreeArray[1][1]; ?></td>
        <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>
        <?php if($row_web_examinee['Student_ID'] != ""){ ?>
        <tr>
          <td height="30" align="right" class="board_add">學號：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['Student_ID']; ?></td>
        <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>

        <?php if($row_web_examinee['Grade']!=""){ ?>
        <tr>
          <td height="30" align="right" class="board_add">年級：</td>
          <td align="left" class="board_add"><?php if (!(strcmp($row_web_examinee['Grade'],"1"))) {echo "大一";}
		  if (!(strcmp($row_web_examinee['Grade'],"2"))) {echo "大二";}
		  if (!(strcmp($row_web_examinee['Grade'],"3"))) {echo "大三";}
		  if (!(strcmp($row_web_examinee['Grade'],"4"))) {echo "大四";}
		  if (!(strcmp($row_web_examinee['Grade'],"5"))) {echo "大五以上";}
		  if (!(strcmp($row_web_examinee['Grade'],"6"))) {echo "研究所";}
		  if (!(strcmp($row_web_examinee['Grade'],"7"))) {echo "研究所";}		   ?></td>
          <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>
        <?php if($row_web_examinee['cert_no']!=""){ ?><!-- add by coway 2016.8.9 -->
        <tr>
          <td height="30" align="right" class="board_add">報考資格：</td>
          <td align="left" class="board_add" colspan="2"><?php echo $row_web_allguideC['nm'];
		  ?></td>
          <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>
        <tr>
          <td height="30" align="right" class="board_add">報名科目：</td>
          <td align="left" class="board_add"><?php $str=split("," , $row_web_examinee['category']);
			foreach ($str as $val){
			if (!(strcmp($val,"1"))) {echo "國語領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"2"))) {echo "數學領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"3"))) {echo "社會領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"4"))) {echo "自然領域";}} ?></td>
		<td height="30" align="right" class="board_add"></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><?php
//           		$event="required onchange=\"ShowMsg(this,'$todayyear')\"";
//           		// Create the Element
// 				$sel =& $form->addElement('hierselect', 'exarea', '',$event);
				?>
          	評量考區：</td>
          <td align="left" class="board_add">
          <?php echo $row_allguide['note']." ， ".$row_allguide['data1'];?>

          <label>
          <!--<span id="spryselect1">
	           <select name="exam_school">
	          		<option>請選擇</option>
	          		<option value="01_國立臺北教育大學">國立臺北教育大學考場</option>
	          		<option value="02_臺北市立大學" >臺北市立大學考場</option>
	          		<option value="03_國立新竹教育大學" >國立新竹教育大學考場</option>
	          		<option value="04_國立臺中教育大學">國立臺中教育大學考場</option>
	          		<option value="05_國立嘉義大學" >國立嘉義大學考場</option>
	          		<option value="06_國立臺南大學" >國立臺南大學考場</option>
	          		<option value="07_國立屏東大學" >國立屏東大學考場</option>
	          		<option value="08_國立臺東大學" >國立臺東大學考場</option>
	          		<option value="09_國立東華大學" >國立東華大學考場</option>
	          </select>
          <span class="selectRequiredMsg">請選擇考場名稱</span></span> -->
          </label></td>
           <td height="30" align="right" class="board_add"></td>
        </tr>
      <?php if($row_web_examinee['contact'] != ""){ ?>
        <tr>
          <td height="30" align="right" class="board_add">緊急聯絡人：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['contact']; ?></td>
          <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>
        <?php if($row_web_examinee['contact_ph']!=""){ ?>
        <tr>
        <td height="30" align="right" class="board_add">緊急聯絡人電話：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['contact_ph']; ?></td>
          <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>

				<!-- 顯示上傳照片 BlueS 20180307  -->
				<?php
				if(null !== $row_examinee_pic[pic1_name]){?>
					<tr>
	        <td width="20" height="30" align="right" class="board_add">身分證正面：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_examinee_pic['pic1_name']; ?>" alt="" name="pic" width="200" id="pic" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_examinee_pic[pic2_name]){?>
					<tr>
	          <td width="20" height="30" align="right" class="board_add">身分證反面：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_examinee_pic['pic2_name']; ?>" alt="" name="pic" width="200" id="pic" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_examinee_pic[pic3_name]){?>
					<tr>
	          <td width="20" height="30" align="right" class="board_add">最高學歷學位證書：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_examinee_pic['pic3_name']; ?>" alt="" name="pic" width="200" id="pic" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_examinee_pic[pic4_name]){?>
					<tr>
	         <td width="20" height="30" align="right" class="board_add">國民小學教師證書：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_examinee_pic['pic4_name']; ?>" alt="" name="pic" width="200" id="pic" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_examinee_pic[pic5_name]){?>
					<tr>
	         <td width="20" height="30" align="right" class="board_add">在職證明書：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_examinee_pic['pic5_name']; ?>" alt="" name="pic" width="200" id="pic" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_examinee_pic[special_pic_name1]){?>
					<tr>
	         <td width="20" height="30" align="right" class="board_add">特殊考場服務<br>申請表：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_examinee_pic['special_pic_name1']; ?>" alt="" name="pic" width="200" id="pic" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_examinee_pic[special_pic_name2]){?>
					<tr>
          <td width="20" height="30" align="right" class="board_add">應考服務診斷<br>證明書：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_examinee_pic['special_pic_name2']; ?>" alt="" name="pic" width="200" id="pic" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_examinee_pic[special_pic_name3]){?>
					<tr>
	          <td width="20" height="30" align="right" class="board_add">應考切結書：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_examinee_pic['special_pic_name3']; ?>" alt="" name="pic" width="200" id="pic" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_examinee_pic[rename_pic_name]){?>
					<tr>
						<td width="20" height="30" align="right" class="board_add">戶口名簿：</td>
						<td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_examinee_pic['rename_pic_name']; ?>" alt="" name="pic" width="200" id="pic" /></td>
					<td height="30" align="right" class="board_add"></td>
					</tr>
				<?php }
?>
				<!--  -->

        <tr>
          <td height="40" colspan="3" align="center"><label>
            <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
          </label></td>

        </tr>
      </table>
    </form>

  </div>
  <div id="main4"></div>

<?php //include("footer.php"); ?>
</div>
</body>
</html>
