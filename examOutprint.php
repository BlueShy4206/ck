
<?php require_once('Connections/conn_web.php');
require_once "examAdd_function.php";?>
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

function EngNameStr($eng_name){
	list($firstname, $lastname, $lastname2) = explode(" ", $eng_name);
	$firstname = strtoupper (substr($firstname,0,1)).strtolower(substr($firstname,1));

	if(isset($lastname2)){
		$lastname=strtoupper (substr($lastname,0,1)).strtolower(substr($lastname,1));
		$lastname2=strtoupper (substr($lastname2,0,1)).strtolower(substr($lastname2,1));
	}else {

		list($lastname, $lastname2)=explode("-", $lastname);
		if(isset($lastname2)){
			$lastname=strtoupper (substr($lastname,0,1)).strtolower(substr($lastname,1));
			$lastname2=strtoupper (substr($lastname2,0,1)).strtolower(substr($lastname2,1));
		}else {
			$lastname=strtoupper (substr($lastname,0,1)).substr($lastname,1);
		}
	}
	$eng_name="$firstname,$lastname $lastname2";
	return $eng_name;
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
$totalRows_web_member = mysql_num_rows($web_examinee);
$_SESSION['user_level']=$row_web_examinee['status'];

mysql_select_db($database_conn_web, $conn_web);
$query_web_allguide = sprintf("SELECT * FROM allguide Where up_no='EA' AND nm= %s",GetSQLValueString($row_web_examinee['exarea'], "text"));
$web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
$row_allguide = mysql_fetch_assoc($web_allguide);

?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>考試通知</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="考試通知" />
<meta name="keywords" content="考試通知" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />
</head>

<body >

<div id="main111" background= "#FFFFFF">
  <div id="main111" background= "#FFFFFF"></div>

 <?

 if($colname_web_member != "-1"){

 	if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {$exdate=$row_web_new['ndate'];}
 	if (!(strcmp($row_web_examinee['exarea'],"Central"))) {$exdate=$row_web_new['cdate'];}
 	if (!(strcmp($row_web_examinee['exarea'],"Southern"))) {$exdate=$row_web_new['sdate'];}
 	if (!(strcmp($row_web_examinee['exarea'],"Eastern"))) {$exdate=$row_web_new['edate'];}
 	$times1=substr(($row_web_examinee['id']),1,1);
 	$times2=substr(($row_web_examinee['id']),2,4);

 	$exyear=date('Y');
 if($row_web_new['times']=="A"){
 	$exyear=date('Y')+1;}

 if(strtotime($row_web_new['printtime']) <= strtotime(date('Y-m-d H:i:s')) && strtotime(date('Y-m-d')) <= strtotime($exdate)
 		&& $times1 == $row_web_new['times'] && $row_web_examinee['allow'] == "YY" &&($times2 == date('Y') or $times2 == $exyear)
 		&& $row_web_new['status'] == '1'){ //判斷否符合列印准考證的資格
    if($row_web_examinee["read_examout"]==0){
        header('Location: examOutprint_check.php');
        //換頁
    }
 	$dateline=strtotime($row_web_new['ndate']);

  ?>



  <div id="exam" align="center">
  <br />
  <table width="600" border="0" cellspacing="0" cellpadding="0" >
    <td align="center">
    <br />
  <p><font size="+2" ><?php echo (date('Y',$dateline)-1911); ?>年第二梯次國民小學教師自然領域學科知能評量</font></p> <br />
  <p><font size="+3" >考試通知</font> </p><br />
  </td>
  </table>
   <!--  <table width="600" border="0" cellspacing="0" cellpadding="0" >
        <tr>
        <td width="10" align="right"><img src="images/board005.gif" width="10" height="28" /></td>
          <td width="580" align="center"  background="images/board04.gif" style="font-size:20px;"><font face="DFKai-sb">准考證</font><span class="font_black"></span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table> -->
      <table width="600" border="0" cellspacing="0" cellpadding="3" >
        <tr>
        	<td width="150" height="130" align="left" class="board_add" rowspan="3" style="background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;"><img src="images/examinee/<?php echo $row_web_examinee['pic_name']; ?>" alt="" name="pic" width="140" id="pic" /></td>
        	<td height="30" width="120" align="right" class="board_add" style="font-size:18px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;">應試號碼：</td>
        	<td width="350" align="center" class="board_add" style="font-size:20px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;"><b><?php echo $row_web_examinee['id_number']; ?> </b></td>
        </tr>
        <tr>
       		<td height="10" align="right" class="board_add" style="font-size:18px; border-style:solid; border-color:#f3f3f3; border-width:1px;">姓名：</td>
          	<td width="300" align="center" class="board_add" style="font-size:20px; border-style:solid; border-color:#f3f3f3; border-width:1px; ">
          	<b><?php echo $row_web_examinee['uname']."<br>".EngNameStr($row_web_examinee['eng_uname']); ?> </b>
          	</td>
        </tr>
        <tr>
 			<td height="10" align="right" class="board_add" style="font-size:18px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;">身分證字號：</td>
 			<td width="300" align="center" class="board_add" style="font-size:20px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px; ">
 			<b><?php echo $row_web_examinee['per_id']; ?> </b>
 			</td>
        </tr>
        <!--  -->
        <tr>
             <td width="150" height="10" align="right" class="board_add" style="font-size:18px; background-color: #f3f3f3; border-style:solid; border-color:#f3f3f3; border-width:1px;">應考領域：</td>
             <td align="left" class="board_add" style="font-size:18px; background-color: #f3f3f3; border-style:solid; border-color:#f3f3f3; border-width:1px;" colspan="2"><?php echo "自然領域";?></td>
        </tr>
        <tr>
            <td height="10" align="right" class="board_add" style="font-size:18px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;">評量日期：</td>
            <td width="300" align="center" class="board_add" style="font-size:20px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;">
                <b><?php echo $row_allguide['data1'];?></b>
            </td>
      </tr>
      <tr>
             <td width="150" height="10" align="right" class="board_add" style="font-size:18px; background-color: #f3f3f3; border-style:solid; border-color:#f3f3f3; border-width:1px;">評量考區：</td>
             <td align="left" class="board_add" style="font-size:18px; background-color: #f3f3f3; border-style:solid; border-color:#f3f3f3; border-width:1px;" colspan="2"><?php echo $row_allguide['note'];?></td>
      </tr>
       <!--   <tr>
       <td height="10" align="right" class="board_add" style="font-size:18px;">報名科目：</td>
          <td width="300" align="left" class="board_add" style="font-size:18px;"><?php /* $str=split("," , $row_web_examinee['category']);
foreach ($str as $val){
if (!(strcmp($val,"1"))) {echo "國語領域&nbsp;,&nbsp;";}
if (!(strcmp($val,"2"))) {echo "數學領域&nbsp;,&nbsp;";}
if (!(strcmp($val,"3"))) {echo "社會領域&nbsp;,&nbsp;";}
if (!(strcmp($val,"4"))) {echo "自然領域";}} */ ?></td></tr> -->

       <? /*if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {
			$dateline=strtotime($row_web_new['ndate']);
		   echo (date('Y',$dateline)-1911).date('年m月d日 ',$dateline);
		   echo "(".get_chinese_weekday($row_web_new['ndate']).")";}
		  if (!(strcmp($row_web_examinee['exarea'],"Central"))) {
			  $dateline=strtotime($row_web_new['cdate']);
			  echo (date('Y',$dateline)-1911).date('年m月d日 ',$dateline);
		  echo "(".get_chinese_weekday($row_web_new['cdate']).")";}
		  if (!(strcmp($row_web_examinee['exarea'],"Southern"))) {              $dateline=strtotime($row_web_new['sdate']);
	      echo (date('Y',$dateline)-1911).date('年m月d日 ',$dateline);
		  echo "(".get_chinese_weekday($row_web_new['sdate']).")";}
		  if (!(strcmp($row_web_examinee['exarea'],"Eastern"))) {
		  $dateline=strtotime($row_web_new['edate']);
		  echo (date('Y',$dateline)-1911).date('年m月d日 ',$dateline);
		  echo "(".get_chinese_weekday($row_web_new['edate']).")";}*/ ?>

        <!-- <tr>
       		<td width="150" height="10" align="left" class="board_add" style="font-size:16px;" colspan="3">
          	注意：<br />
          	1.參加評量時，請攜帶本准考證及身分證件入場，以便查驗。<br />
          	2.應考人務請依規定之評量時間入場，並請遵守相關之試場規則。<br />
         	 </td>
        </tr> -->
       <!-- <tr>
       		<td width="150" height="10" align="right" class="board_add" style="font-size:18px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;">成績查詢：</td>
          	<td align="left" class="board_add" style="font-size:18px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;" colspan="2"><span class="board_add" style="font-size:18px;"><u>https://tl-assessment.ntcu.edu.tw </u></span>
          	</td>
       </tr> -->
      </table>
      <font size="+1"><span class="font_red" >注意：考試通知不屬應試用品，請勿攜至應試座位，違者該領域不予計分</span></font>

        <br />
      <table  width="600" border="0" cellspacing="0" cellpadding="0" >
      	<tr><td rowspan="2"><img src="images/pctc.png"></td>
      	<td align="left" style="font-size:16px;">教師專業能力測驗中心</td>
      	</tr>
      	<tr>
      		<td align="left" style="font-size:12px;">教育部106年8月31日奉臺教師（二）字第1060125357號函委託國立臺中教育大學辦理</td><!-- (教育部105年○月○○日臺教師（二）字第○○○○○○○○○○號函委託國立臺中教育大學辦理) -->
      	</tr>
      </table>
        <p><b> <font color="#0033FF">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</font> </b></p>
         <br />

      <table width="600" border="0" cellspacing="0" cellpadding="10" >
        <!-- <tr>
        <td  align="center"><b><font size="+2">測驗日期：<? /*if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {
			$dateline=strtotime($row_web_new['ndate']);
		   echo (date('Y',$dateline)-1911).date('年m月d日 ',$dateline);
		   echo "(".get_chinese_weekday($row_web_new['ndate']).")";}
		  if (!(strcmp($row_web_examinee['exarea'],"Central"))) {
			  $dateline=strtotime($row_web_new['cdate']);
			  echo (date('Y',$dateline)-1911).date('年m月d日 ',$dateline);
		  echo "(".get_chinese_weekday($row_web_new['cdate']).")";}
		  if (!(strcmp($row_web_examinee['exarea'],"Southern"))) {              $dateline=strtotime($row_web_new['sdate']);
	      echo (date('Y',$dateline)-1911).date('年m月d日 ',$dateline);
		  echo "(".get_chinese_weekday($row_web_new['sdate']).")";}
		  if (!(strcmp($row_web_examinee['exarea'],"Eastern"))) {
		  $dateline=strtotime($row_web_new['edate']);
		  echo (date('Y',$dateline)-1911).date('年m月d日 ',$dateline);
		  echo "(".get_chinese_weekday($row_web_new['edate']).")";} */?></font> </b> </td>

        </tr>
        </table>

        <table width="600" border="0" cellspacing="0" cellpadding="0" >


      <?php $str=split("," , $row_web_examinee['category']);
		foreach ($str as $val){
		if (!(strcmp($val,"1"))) {$color1="color:#000000;";}
		if (!(strcmp($val,"2"))) {$color2="color:#000000;";}
		if (!(strcmp($val,"3"))) {$color3="color:#000000;";}
		if (!(strcmp($val,"4"))) {$color4="color:#000000;";}} ?>

       <tr>
       <td width="150" height="200" align="center" class="board_add" style="font-size:18px;border-style:solid; border-color:#BBBBBB; border-width:1px; background-color:#FFF;" rowspan="3">考試時間</td>
          <td width="300" height="20" align="center" class="board_add" style="font-size:18px; border-style:solid; border-color:#BBBBBB; border-width:1px; background-color:#FFF;" colspan="3">下午</td>
          <tr>
          <td width="300" align="center" class="illustrate" style="font-size:18px; color:#000000; border-style:solid; border-color:#BBBBBB; border-width:1px;">
                             14:20<br />
                               |  <br />
                             14:30<br />
          </td>
          <td width="300" align="center" class="illustrate" style="font-size:18px; color:#000000; border-style:solid; border-color:#BBBBBB; border-width:1px;">
                             14:30<br />
                               |  <br />
                             14:40<br />
          </td>
           <td width="150" height="10" align="center" class="illustrate" style="font-size:18px; color:#000000; border-style:solid; border-color:#BBBBBB; border-width:1px;">
                            14:40<br />
                              |  <br />
                            15:30<br />


           </td>
          </tr>
          <tr height="10" >
	          <td width="150" align="center" class="illustrate" style="font-size:18px;color:#000000; border-style:solid; border-color:#BBBBBB; border-width:1px; background-color:#FFF;">應考人入場</td>
	          <td width="150" align="center" class="illustrate" style="font-size:18px;color:#000000; border-style:solid; border-color:#BBBBBB; border-width:1px; background-color:#FFF;">試場規則說明暨預備時間</td>
	          <td width="150" align="center" class="illustrate" style="font-size:18px;color:#000000; border-style:solid; border-color:#BBBBBB; border-width:1px; background-color:#FFF;">自然領域學科知能評量</td>
          </tr> -->
       <tr height="50"><td style="font-size:16px; background-color: #e6e6fa;">評量領域</td><td style="font-size:16px; background-color: #e6e6fa;">時間</td><td style="font-size:16px; background-color: #e6e6fa;">執行項目</td></tr>
       <tr class="board_add"><td style="font-size:16px;" rowspan="3">自然領域</td><td style="font-size:16px;">15:30〜15:35</td><td style="font-size:16px;">應考人入場</td></tr>
       <tr class="board_add"><td style="font-size:16px;">15:35〜15:40</td><td style="font-size:16px;">試場規則說明暨預備時間</td></tr>
       <tr class="board_add"><td style="font-size:16px;">15:40〜16:30</td><td style="font-size:16px;">自然領域學科知能評量</td></tr>

          <tr align="left">
          	<td colspan="4">
		          附註：<br/>1.評量日程表，得視天候及考生人數予以調整。 <br/>
		        2.評量開始後逾15分鐘即不得入場應試，且評量未達25分鐘不得離開考場。<br/>
		        3.應考人至少需作答滿15題，本評量方可計分。
		    </td>
          </tr>
    </table>
         <p style="page-break-after:always"></p>
    <table width="600" border="0" cellspacing="0" cellpadding="0" >
    	<tr>
          <td height="40" align="center">
          <p><font size="+2" ><strong>國小教師自然領域學科知能評量試場規則(簡略版)</strong></font></p>
            </td>
        </tr>
        <!-- 試場規則 -->
        <?php foreach($TestingRegulations_t as $value){ ?>
            <tr>
              <td height="70" align="left"><font size="+1" >‧
              <?php echo $value; ?>
            </font></td>
            </tr>
        <?php } ?>

        <tr>
          <td height="40" colspan="3" align="center"><label>

  <?PHP    //      <input type="button" name="Submit" value="列印本頁" onclick="javascript:window.print()">
          //  <input type="button" value="回首頁" onclick="location.href='index.php'" />
?>            <input name="date" type="hidden" id="date" value="<? echo date("Y-m-d H:i:s");?>" />
          </label></td>

        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="memberadd" />
    </form>

  </div>
  <div id="main111" background= "#FFFFFF"></div>
</div>
<!-- <script language="Javascript">window.print();</script> -->
<?PHP }elseif(strtotime($row_web_new['printtime']) <= strtotime(date('Y-m-d H:i:s')) && strtotime(date('Y-m-d')) <= strtotime($exdate) && $times1 == $row_web_new['times'] && $row_web_examinee['allow'] == "N" &&($times2 == date('YY') or $times2 == $exyear)){
		?><table width="555" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td height="80" align="center" class="font_red2">報名資格審查未通過。詳情請見"報名進度查詢"資料審查說明欄。</td>
      </tr>
      <tr>
      <td height="80" align="center"><a href="index.php">[返回首頁]</a></td>
      </tr>
  </table><?PHP }else{?><table width="555" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td height="80" align="center" class="font_red2">目前尚未開放列印或您的資格正在審核中</td>
      </tr>
      <tr>
      <td height="80" align="center"><a href="index.php">[返回首頁]</a></td>
      </tr>
  </table><?PHP }}else{?>
  <table width="555" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td height="80" align="center" class="font_red2">列印准考證請先登入會員</td>
      </tr>
      <tr>
      <td height="80" align="center"><a href="index.php">[返回首頁]</a></td>
      </tr>
  </table>
<?PHP }?>
</body>
</html>
<?php
function get_chinese_weekday($datetime)
{
    $weekday  = date('w', strtotime($datetime));
    $weeklist = array('日', '一', '二', '三', '四', '五', '六');
    return '星期' . $weeklist[$weekday];
}

mysql_free_result($web_new);
mysql_free_result($web_examinee);
mysql_free_result($web_allguide);
?>
