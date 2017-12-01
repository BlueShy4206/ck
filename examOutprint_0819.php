
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}

mysql_select_db($database_conn_web, $conn_web);
$query_web_new = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);
$totalRows_web_new = mysql_num_rows($web_new);

$todayyear = $row_web_new['times'];
$todayyear .= date("Y");
mysql_select_db($database_conn_web, $conn_web);
$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND id LIKE %s ORDER BY SUBSTR( id, 3, 4 ) DESC , SUBSTR( id, 2, 9 ) DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"),GetSQLValueString("%" . $todayyear . "%", "text"));
$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
$row_web_examinee = mysql_fetch_assoc($web_examinee);
$totalRows_web_member = mysql_num_rows($web_examinee);

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
<title>准考證</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="准考證" />
<meta name="keywords" content="准考證" />
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
 
 if(strtotime($row_web_new['printtime']) <= strtotime(date('Y-m-d')) && strtotime(date('Y-m-d')) <= strtotime($exdate) && $times1 == $row_web_new['times'] && $row_web_examinee['allow'] == "Y" &&($times2 == date('Y') or $times2 == $exyear)){ //判斷否符合列印准考證的資格
  $dateline=strtotime($row_web_new['ndate']);
  
  ?>
 
 
 
  <div id="exam" align="center">
  <br />
  <table width="600" border="0" cellspacing="0" cellpadding="0" >
    <td align="center">
    <br />
  <p><font size="+3" ><?php echo (date('Y',$dateline)-1911); ?>年度國民小學教師自然領域</font></p> <br />
  <p><font size="+3" >學科知能評量准考證</font> </p><br />
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
          <td height="30" width="120" align="right" class="board_add" style="font-size:18px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;">准考證號碼：</td>
          <td width="350" align="center" class="board_add" style="font-size:20px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;"><b><?php echo $row_web_examinee['id_number']; ?> </b></td>
           </tr>
       <tr>
       <td height="10" align="right" class="board_add" style="font-size:18px; border-style:solid; border-color:#f3f3f3; border-width:1px;">姓名：</td>
          <td width="300" align="center" class="board_add" style="font-size:20px; border-style:solid; border-color:#f3f3f3; border-width:1px; "><b><?php echo $row_web_examinee['uname']."<br>".$row_web_examinee['eng_uname']; ?> </b></td> </tr>
       <!--   <tr>
       <td height="10" align="right" class="board_add" style="font-size:18px;">報名科目：</td>
          <td width="300" align="left" class="board_add" style="font-size:18px;"><?php /* $str=split("," , $row_web_examinee['category']);
foreach ($str as $val){
if (!(strcmp($val,"1"))) {echo "國語領域&nbsp;,&nbsp;";}
if (!(strcmp($val,"2"))) {echo "數學領域&nbsp;,&nbsp;";}
if (!(strcmp($val,"3"))) {echo "社會領域&nbsp;,&nbsp;";}
if (!(strcmp($val,"4"))) {echo "自然領域";}} */ ?></td></tr> -->
          <tr>
       <td height="10" align="right" class="board_add" style="font-size:18px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;">測驗日期：</td>
       <td width="300" align="center" class="board_add" style="font-size:20px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;"><b> <? if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {
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
		  echo "(".get_chinese_weekday($row_web_new['edate']).")";}?>
          </b> </td> </tr> 
           <tr>
       <td width="150" height="10" align="left" class="board_add" style="font-size:16px;" colspan="3">
          注意：<br />
          1.參加考試時，請攜帶本准考證及身分證件入場，以便查驗。<br />
          2.考生務請依規定之考試時間入場，並請遵守相關之試場規則。<br />
          
          </td>
          </tr>
       <tr>
       <td width="150" height="10" align="right" class="board_add" style="font-size:18px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;">試場地點：</td>
          <td align="left" class="board_add" style="font-size:18px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;" colspan="2"><?php echo $row_allguide['note'];?></td>
          </tr>
       <td width="150" height="10" align="right" class="board_add" style="font-size:18px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;">查榜網站：</td>
          <td align="left" class="board_add" style="font-size:18px; background-color: #FFFFFF; border-style:solid; border-color:#f3f3f3; border-width:1px;" colspan="2"><span class="board_add" style="font-size:18px;"><u>https://tl-assessment.ntcu.edu.tw </u></span>     
          
          </td>
          </tr>
        </table>
        <br />
      <table  width="600" border="0" cellspacing="0" cellpadding="0" > 
      	<tr><td rowspan="2"><img src="images/pctc.png"></td>
      	<td align="left" style="font-size:16px;">教師專業能力測驗中心</td>
      	</tr>
      	<tr>
      		<td align="left" style="font-size:12px;">(教育部104年1月16日臺教師(二)字第1030183883號委託國立臺中教育大學辦理)<td>
      	</tr>
      </table>
        <p><b> <font color="#0033FF">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</font> </b></p>
         <br />
         
         <table width="600" border="0" cellspacing="0" cellpadding="0" >
        <tr>
        <td  align="center"><b><font size="+2">測驗日期：<? if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {
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
		  echo "(".get_chinese_weekday($row_web_new['edate']).")";}?></font> </b> </td>
        
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
          </tr>
          <tr align="left">
          	<td colspan="4">
		          附註：<br/>1.考試日程表，得視天候及考生人數予以調整。 <br/>
		        2.評量開始後逾15分鐘即不得入場應試，且評量未達25分鐘不得離開考場。<br/>
		        3.應考人至少需作答滿15題，本評量方可計分。
		    </td>
          </tr>
    </table>
         <p style="page-break-after:always"></p> 
    <table width="600" border="0" cellspacing="0" cellpadding="0" > 
    	<tr>
          <td height="40" align="center">
          <p><font size="+2" ><strong>國民小學教師自然領域學科知能評量試場規則</strong></font></p>
            </td>
        </tr>
        <tr>  
          <td height="70" align="left"><font size="+1" ><u>
          	‧應考人應攜帶自行列印之「<strong>准考證</strong>」及「<strong>國民身分證</strong>」正本（或以駕照、具照片之健保卡或護照代替國民身分證）到場應試。未能提供身分證明文件者，即取消應試資格，不得參加本次評量。
          </u></font></td>
          
        </tr>
        <tr>
          <td height="70" align="left"><font size="+1" ><u>‧本次評量將由承辦單位提供計算紙及原子筆供試題計算用，應考人試後計算紙不得攜出考場，違者</u>該科不予計分<u>。</u>
        </font></td></tr>
        <tr>
          <td height="70" align="left"><font size="+1" >‧非應試用品包括：水、簡章、書籍、紙張、尺、鉛筆盒、皮包及任何具有通訊、攝影、錄音、記憶、發聲等功能或有礙試場安寧、妨害評量公平/智慧財產權之各類器材、物品（如行動電話、收錄音機、MP3、鬧鐘/錶、翻譯機、智慧型手錶……）等。有關個人之醫療器材如助聽器等，須先報備並經檢查方可使用，違者扣減其該科成績20分。前述各類事件並得視其使用情節加重扣分或該科不予計分。
          </font></td>
        </tr>
        <tr>
          <td height="70" align="left"><font size="+1" ><strong><u>‧評量開始後逾15分鐘即不得入場應試，且評量未達25分鐘不得離開考場。
          </u></strong></font></td>
        </tr>
        <tr>
          <td height="70" align="left"><font size="+1" >‧評量時應將准考證及身分證件置於監試人員指定處，並配合核對身分及資料。如發現報名所繳身分證件影本與正本不符或身分證件上之相片與本人相貌不同而致辨識困難者，評量完畢後須再接受查驗，如仍有識別困難者，其作答不予計分。
          </font></td>
        </tr>
        <tr>
          <td height="70" align="left"><font size="+1" >‧評量進行間行動電話、計時器及其他電子設備不得攜至座位或發出任何聲響（含振動聲），違者將扣減該節評量科目成績50分，並得視違規情節加重扣分或不予計分。
          </font></td>
        </tr>
        <tr>
          <td height="70" align="left"><font size="+1" >‧評量進行間除在規定處作答擬稿外，不得在准考證、身分證件、文具、桌面、肢體上或其他物品上書寫與評量有關之任何文字、符號等，違者作答不予計分。
          </font></td>
        </tr>
        <tr>
          <td height="70" align="left"><font size="+1" >‧評量結束時，應依監試人員指示立即停止作答並在原位靜候。監試人員宣布離場前，不得提前離場。違者作答不予計分。
          </font></td>
        </tr>
        <tr>
          <td height="70" align="left"><font size="+1" >‧其他未盡事宜，除依本中心訂頒之試場規則辦理外，由各該考區負責人處理之。
          </font></td>
        </tr>
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
<script language="Javascript">window.print();</script>
<?PHP }else{?><table width="555" border="0" cellspacing="0" cellpadding="0" align="center">
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
