<?php require_once('login_check.php'); ?>
<?php require_once('Connections/conn_web.php'); ?>
<?php

//**************************


//****************************


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
$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}

if(isset($_GET['status'])){
	$exam_type = $_GET['status'];
}

mysql_select_db($database_conn_web, $conn_web);
$query_web_banner1 = "SELECT * FROM banner WHERE banner_type = '1' ORDER BY banner_id desc limit 1";//rand()
$web_banner1 = mysql_query($query_web_banner1, $conn_web) or die(mysql_error());
$row_web_banner1 = mysql_fetch_assoc($web_banner1);
$totalRows_web_banner1 = mysql_num_rows($web_banner1);

mysql_select_db($database_conn_web, $conn_web);
$query_web_banner2 = "SELECT * FROM banner WHERE banner_type = '2' OR banner_type = '3' order by rand() limit 1  ";
$web_banner2 = mysql_query($query_web_banner2, $conn_web) or die(mysql_error());
$row_web_banner2 = mysql_fetch_assoc($web_banner2);
$totalRows_web_banner2 = mysql_num_rows($web_banner2);
//add by coway 2016.9.20
mysql_select_db($database_conn_web, $conn_web);
$query_web_new = "SELECT * FROM examyear WHERE status='{$exam_type}' ORDER BY id DESC LIMIT 0,1";
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);
$totalRows_web_new = mysql_num_rows($web_new);

mysql_select_db($database_conn_web, $conn_web);
//update by coway 2016.8.19
// $query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND status = %s ORDER BY SUBSTR( id, 3, 4 ) DESC , SUBSTR( id, 2, 9 ) DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"), GetSQLValueString($exam_type, "text"));
//update by coway 2016.9.24  (增加已確認報名表方可列印報名表，apply_mk='1')
//add by coway 2016.10.14  (增加本梯次報名方可列印報名表，examyear_id)
$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND status = %s AND apply_mk='1' AND examyear_id=%s ORDER BY no DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"), GetSQLValueString($exam_type, "text"), GetSQLValueString($row_web_new['id'], "text"));
$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
$row_web_examinee = mysql_fetch_assoc($web_examinee);
$totalRows_web_member = mysql_num_rows($web_examinee);


mysql_select_db($database_conn_web, $conn_web);
$query_web_allguide = sprintf("SELECT * FROM allguide WHERE up_no='MH'");
$web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
$row_web_allguide = mysql_fetch_assoc($web_allguide);

$MailHost = $row_web_allguide['note'];

if($row_web_examinee["status"] == '0'){
	$up_no ='EA2';
}else $up_no ='EA';

mysql_select_db($database_conn_web, $conn_web);
//$query_allguide_EA = sprintf("SELECT * FROM allguide Where up_no='EA2' AND nm= %s AND data2= %s",GetSQLValueString($row_web_examinee['exarea'], "text"), GetSQLValueString($row_web_examinee['exarea_note'], "text"));
$query_allguide_EA = sprintf("SELECT * FROM allguide Where up_no= %s AND nm= %s AND data2= %s", GetSQLValueString($up_no, "text"),GetSQLValueString($row_web_examinee['exarea'], "text"), GetSQLValueString($row_web_examinee['exarea_note'], "text"));
$web_allguide_EA = mysql_query($query_allguide_EA, $conn_web) or die(mysql_error());
$row_allguide_EA = mysql_fetch_assoc($web_allguide_EA);

mysql_select_db($database_conn_web, $conn_web);
$query_web_member = sprintf("SELECT * FROM member  WHERE username = %s", GetSQLValueString($colname_web_member, "text"));
$web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_member);

mysql_select_db($database_conn_web, $conn_web);
$apply_user = sprintf("SELECT apply_mk FROM `examinee`  WHERE id=%s", GetSQLValueString($row_web_examinee['id'], "text"));
$web_apply = mysql_query($apply_user, $conn_web) or die(mysql_error());
$rowee = mysql_fetch_assoc($web_apply);
$rowee = $rowee['apply_mk'];

if($_GET['check']=='ok'){
	if($rowee==1){
		echo '<script type="text/javascript">alert("您已完成線上報名登錄，您的網路登錄報名流水號為：'.$_GET['cert_number'].'。");location.href = "progress.php?status=1";</script>';
	}else{
		echo '<script type="text/javascript">alert("報名尚未完成！\n請再次勾選確認報名表資料!!");location.href = "examOut1.php";</script>';


// 		header(sprintf("Location: %s", $returncheck));$returncheck="examOut1.php";
	}
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
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
<!--[if IE 6]><script src="ie6png.js" type="text/javascript"></script><![endif]-->
 <script type="text/javascript">
	function CheckMailVal(){
		//console.log(MailHost+'/EasyMVC/Home/queryList/'+id);
		alert("因E-mail未認證通知，請至信箱收信並進行E-mail認證");
		//window.location = '';
		window.location = 'progress.php';// echo "$MailHost/EasyMVC/Home/queryList/$row_web_member[id]";
	}
 </script>
</head>
<body  background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <?php include("leftzone.php")?>
  </div>
  <div id="main3" style="height:600px;">
    <table width="545" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20">
          <marquee onMouseOver="this.stop()" onMouseOut="this.start()" bgcolor="#efefef" border="0" align="middle" scrollamount="2"  scrolldelay="90" behavior="scroll"  width="100%" height="20" style="color: #000000; font-size: 12">
            <a href="<?php echo $row_web_banner1['banner_url']; ?>"><img src="images/hot.gif" width="28" height="7" border="0" /><?php echo $row_web_banner1['banner_title']; ?></a>
          </marquee>
        </td>
      </tr>
    </table>
<table width="545" border="0" cellspacing="0" cellpadding="0">

</table>
    <img src="images/progress.png" width="540" height="48" /><br />


<?php if($totalRows_web_member == 0){ //判斷本次是否有報名 ?>
  <table width="540" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2" bgcolor="#FFFFFF">您尚未報名本次測驗</td>
      </tr>
  </table>
  <?php }else{ ?>
 <table width="540" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFFF">
        <tr>
          <td width="100" height="30" align="right" class="board_add4">線上報名登錄：</td>
          <td align="left" class="board_add4" > 已完成</td>
          <td width="140" height="130" align="center"  rowspan="4" style="border-style:solid; border-color:#999999; border-width:1px;"><img src="images/examinee/<?php echo $row_web_examinee['pic_name']; ?>" alt="" name="pic" width="100" id="pic" /></tr>
         <!-- <tr>
          <td height="30" align="right" class="board_add4"></td>

          <td align="left" class="board_add4"><font color="#FF0000">請確認右方大頭照是否已正確上傳。</font> </td>

           </tr>-->
           <tr>
          <td height="30" align="right" class="board_add4">報名科目：</td>
          <td align="left" class="board_add4"><?php $str=split("," , $row_web_examinee['category']);
			foreach ($str as $val){
			if (!(strcmp($val,"1"))) {echo "國語領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"2"))) {echo "數學領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"3"))) {echo "社會領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"4"))) {echo "自然領域";}} ?></td>
          </tr>
          <tr>
          <td height="30" align="right" class="board_add4">評量考區：</td>
          <td align="left" class="board_add4">
          <?php echo $row_allguide_EA['note']." ， ".$row_allguide_EA['data1'];?>
          <?php /*if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {echo "臺北(國立臺灣大學)";}
		  if (!(strcmp($row_web_examinee['exarea'],"Central"))) {echo "臺中(國立臺中教育大學)";}
		  if (!(strcmp($row_web_examinee['exarea'],"Southern"))) {echo "高雄(高雄市私立三信家事商業職業學校)";}
		  if (!(strcmp($row_web_examinee['exarea'],"Eastern"))) {echo "花蓮(國立花蓮高級商業職業學校)";} */
		   ?>
          </td>
          </tr>
        <tr>
          <td height="30" align="right" class="board_add4">檢視報名表：</td>
          <td align="left" class="board_add4">
          <?php
          	if($row_web_examinee['status'] == 1){
          		$report_url='examOuttoprint.php';
          	}else $report_url='examOuttoprint_ts.php';

          	if($row_web_member['status']== 0){
          		$report_url = "$MailHost/EasyMVC/Home/queryList/$row_web_member[id]";
          	}
          ?>
          <a href="<?php echo $report_url;?>">
          	<img src="images/progress_look.png"  onclick="<?php if($row_web_member['status'] == 0) echo "CheckMailVal()";?>" /></a></td>
           <td height="30" align="right" class="board_add4"></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add4">資料審查：</td>
          <td align="left" class="board_add4">

           <?php

           if(strtotime($row_web_new['endday']) < strtotime(date('Y-m-d')) && strtotime(date('Y-m-d')) ){//add by coway 2016.9.20?>
          <?php
          if($row_web_examinee['allow']=="Y"){
					echo "<font color='#FF0000'>通過</font>";
        }elseif($row_web_examinee['allow']!="Y" && $row_web_examinee['allow']!="0"){
					echo "<font color='#FF0000'>不通過</font>";
// 				  }else {
// 				  	echo "<font color='#FF0000'>審核中</font>"; //maker by coway 2017.9.5,"審核中"不顯示
				  } ?>
           <?php }?></td>
           <td height="30" align="right" class="board_add4"></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add4">資料審查說明：</td>
          <td align="left" class="board_add4"><?php echo $row_web_examinee['allow_note']?></td>
           <td height="30" align="right" class="board_add4"></td>
        </tr>
        <!-- 20180305 BlueS 補件上傳處 -->
        <?php
        if($row_web_examinee['allow'] != 0 && $exam_type == '0'){ ?>
          <form id="form3" name="form3" method="post" enctype="multipart/form-data" action="<?php echo $editFormAction; ?>" >
        <tr>
          <td height="30" ></td>
          <td height="30" align="center" style="font-size: 21px; color: #F00;">補件資料上傳</td>
          <td height="30" ><?php //echo $row_web_examinee['allow'];?></td>
        </tr>
        <?php
        echo $row_web_examinee['allow'];
        $tmp1=strpos($row_web_examinee['allow'], '1');
        echo $tmp1;
          if( false !== $tmp1 ){
            ?>

        <tr>
          <td height="30" align="right" class="board_add4">國民身分證正面：</td>
          <td align="left" class="board_add4">
            <div id="optionDiv2-1" style="display:inline-block;">
             <span id="sprytextfield14">
               <input type="file" name="news_pic4" id="news_pic4" />
             </span><br/>
            </div>
          </td>
           <td height="30" align="right" class="board_add4"></td>
        </tr>
      <?php }
      $tmp2=strpos($row_web_examinee['allow'], '2');
        if(false !== $tmp2){
        ?>
        <tr>
          <td height="30" align="right" class="board_add4">國民身分證反面：</td>
          <td align="left" class="board_add4">
            <div id="optionDiv2-1" style="display:inline-block;">
             <span id="sprytextfield14">
               <input type="file" name="news_pic4" id="news_pic4" />
             </span><br/>
            </div>
          </td>
           <td height="30" align="right" class="board_add4"></td>
        </tr>
      <?php }
        $tmp3=strpos($row_web_examinee['allow'], '3');
        if(false !== $tmp3){
        ?>
        <tr>
          <td height="30" align="right" class="board_add4">修畢師資職前<br>教育證明書：</td>
          <td align="left" class="board_add4">
            <div id="optionDiv2-1" style="display:inline-block;">
             <span id="sprytextfield14">
               <input type="file" name="news_pic4" id="news_pic4" />
             </span><br/>
            </div>
          </td>
           <td height="30" align="right" class="board_add4"></td>
        </tr>
      <?php }
        $tmp4=strpos($row_web_examinee['allow'], '4');
        if(false !== $tmp4){
        ?>
        <tr>
          <td height="30" align="right" class="board_add4">實習學生證：</td>
          <td align="left" class="board_add4">
            <div id="optionDiv2-1" style="display:inline-block;">
             <span id="sprytextfield14">
               <input type="file" name="news_pic4" id="news_pic4" />
             </span><br/>
            </div>
          </td>
           <td height="30" align="right" class="board_add4"></td>
        </tr>
      <?php }
        $tmp5=strpos($row_web_examinee['allow'], '5');
        if(false !== $tmp5){
        ?>
        <tr>
          <td height="30" align="right" class="board_add4">學生證正面：</td>
          <td align="left" class="board_add4">
            <div id="optionDiv2-1" style="display:inline-block;">
             <span id="sprytextfield14">
               <input type="file" name="news_pic4" id="news_pic4" />
             </span><br/>
            </div></td>
           <td height="30" align="right" class="board_add4"></td>
        </tr>
      <?php }
    }else if ($row_web_examinee['allow'] != 0 && $exam_type == '1'){ ?>
    <tr>
      <td height="30" ></td>
      <td height="30" align="center" style="font-size: 21px; color: #F00;">補件資料上傳</td>
      <td height="30" ><?php //echo $row_web_examinee['allow'];?></td>
    </tr>
    <?php

    $tmp1=strpos($row_web_examinee['allow'], '1');
      if( $tmp1 !== false){
        ?>
    <tr>
      <td height="30" align="right" class="board_add4" style="width: 110px;">國民身分證正面：</td>
      <td align="left" class="board_add4">
        <div id="optionDiv2-1" style="display:inline-block;">
         <span id="sprytextfield14">
           <input type="file" name="news_pic4" id="news_pic4" />
         </span><br/>
        </div>
      </td>
       <td height="30" align="right" class="board_add4"></td>
    </tr>
  <?php }
  $tmp2=strpos($row_web_examinee['allow'], '2');
    if($tmp2 != flase){
    ?>
    <tr>
      <td height="30" align="right" class="board_add4">國民身分證反面：</td>
      <td align="left" class="board_add4">
        <div id="optionDiv2-1" style="display:inline-block;">
         <span id="sprytextfield14">
           <input type="file" name="news_pic4" id="news_pic4" />
         </span><br/>
        </div>
      </td>
       <td height="30" align="right" class="board_add4"></td>
    </tr>
  <?php }
    $tmp3=strpos($row_web_examinee['allow'], '3');
    if($tmp3 !== flase){
    ?>
    <tr>
      <td height="30" align="right" class="board_add4">最高學歷學位證書：</td>
      <td align="left" class="board_add4">
        <div id="optionDiv2-1" style="display:inline-block;">
         <span id="sprytextfield14">
           <input type="file" name="news_pic4" id="news_pic4" />
         </span><br/>
        </div>
      </td>
       <td height="30" align="right" class="board_add4"></td>
    </tr>
  <?php }
    $tmp4=strpos($row_web_examinee['allow'], '4');
    if($tmp4 !== flase){
    ?>
    <tr>
      <td height="30" align="right" class="board_add4">國民小學教師證書：</td>
      <td align="left" class="board_add4">
        <div id="optionDiv2-1" style="display:inline-block;">
         <span id="sprytextfield14">
           <input type="file" name="news_pic4" id="news_pic4" />
         </span><br/>
        </div>
      </td>
       <td height="30" align="right" class="board_add4"></td>
    </tr>
  <?php }
    $tmp5=strpos($row_web_examinee['allow'], '5');
    if($tmp5 !== flase){
    ?>
    <tr>
      <td height="30" align="right" class="board_add4">在職證明書：</td>
      <td align="left" class="board_add4">
        <div id="optionDiv2-1" style="display:inline-block;">
         <span id="sprytextfield14">
           <input type="file" name="news_pic4" id="news_pic4" />
         </span><br/>
        </div></td>
       <td height="30" align="right" class="board_add4"></td>
    </tr>
  <?php }
  }
  ?>
      </table>
      <?php

        if($row_web_examinee['allow'] != 0 && $exam_type == '0'){ ?>
      <div align="center">
      <input  type="submit" name="button" id="button" value="確認上傳檔案" onclick="SaveAlert()" />
    </div>
  <?php }
}?>
  </div>
  <div id="main4"></div>
<?php include("footer.php"); ?>
</div>
</body>
</html>
<?php
mysql_free_result($web_banner1);
mysql_free_result($web_banner2);

?>
