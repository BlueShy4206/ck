
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
 $times1=substr(($row_web_examinee['id']),1,1);
 $times2=substr(($row_web_examinee['id']),2,4);

     $exyear=date('Y');
 if($row_web_new['times']=="A"){
	 $exyear=date('Y')+1;}

 if(strtotime($row_web_new['printtime']) <= strtotime(date('Y-m-d')) && strtotime(date('Y-m-d')) <= strtotime($exdate) && $times1 == $row_web_new['times'] && $row_web_examinee['allow'] == "Y" &&($times2 == date('Y') or $times2 == $exyear)){ //判斷否符合列印准考證的資格
  ?>



  <div id="exam" align="center">
     <table width="600" border="0" cellspacing="0" cellpadding="0" >
        <tr>
        <td width="10" align="right"><img src="images/board005.gif" width="10" height="28" /></td>
          <td width="580" align="center"  background="images/board04.gif" style="font-size:20px;"><font face="DFKai-sb">准考證</font><span class="font_black"></span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="600" border="0" cellspacing="0" cellpadding="2" >
        <tr>
          <td width="150" height="30" align="right" class="board_add" style="font-size:18px;">准考證號碼：</td>
          <td width="300" align="life" class="board_add" style="font-size:18px;"><?php echo $row_web_examinee['id_number']; ?> </td>
           <td width="150" height="130" align="left" class="board_add" rowspan="4"><img src="images/examinee/<?php echo $row_web_examinee['pic_name']; ?>" alt="" name="pic" width="140" id="pic" /></tr>
       <tr>
       <td width="150" height="10" align="right" class="board_add" style="font-size:18px;">姓名：</td>
          <td width="300" align="life" class="board_add" style="font-size:18px;"><?php echo $row_web_examinee['uname']; ?> </td> </tr>
          <tr>
       <td width="150" height="10" align="right" class="board_add" style="font-size:18px;">應考領域：</td>
          <td width="300" align="left" class="board_add" style="font-size:18px;"><?php $str=split("," , $row_web_examinee['category']);
foreach ($str as $val){
if (!(strcmp($val,"1"))) {echo "國語領域&nbsp;,&nbsp;";}
if (!(strcmp($val,"2"))) {echo "數學領域&nbsp;,&nbsp;";}
if (!(strcmp($val,"3"))) {echo "社會領域&nbsp;,&nbsp;";}
if (!(strcmp($val,"4"))) {echo "自然領域";}} ?></td></tr>
          <tr>
       <td width="150" height="10" align="right" class="board_add" style="font-size:18px;">測驗考場：</td>
       <td width="300" align="left" class="board_add" style="font-size:18px;"><?php if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {echo "北部";}
		  if (!(strcmp($row_web_examinee['exarea'],"Central"))) {echo "中部";}
		  if (!(strcmp($row_web_examinee['exarea'],"Southern"))) {echo "南部";}
		  if (!(strcmp($row_web_examinee['exarea'],"Eastern"))) {echo "東部";}
		   ?> </td> </tr>
       <tr>
       <td width="150" height="10" align="right" class="board_add" style="font-size:18px;">
          測驗日期：</td>
          <td width="300" align="left" class="board_add" style="font-size:18px;">
           <p><? if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {echo $row_web_new['ndate'];
		   echo "(".get_chinese_weekday($row_web_new['ndate']).")";}
		  if (!(strcmp($row_web_examinee['exarea'],"Central"))) {echo $row_web_new['cdate'];
		  echo "(".get_chinese_weekday($row_web_new['cdate']).")";}
		  if (!(strcmp($row_web_examinee['exarea'],"Southern"))) {echo $row_web_new['sdate'];
		  echo "(".get_chinese_weekday($row_web_new['sdate']).")";}
		  if (!(strcmp($row_web_examinee['exarea'],"Eastern"))) {echo $row_web_new['edate'];
		  echo "(".get_chinese_weekday($row_web_new['edate']).")";}?></p>
          </td>
          <td width="150" height="10" align="left" class="board_add"></td></tr>
        </table>

        <table width="600" border="0" cellspacing="0" cellpadding="0" >

         <tr>
          <td width="150" height="10" align="right" class="board_add" style="font-size:18px;"></td>
          <td width="300" align="left" class="board_add" style="font-size:18px;">
          </td>
           <td width="150" height="10" align="left" class="board_add"></td></tr>

      <?php $str=split("," , $row_web_examinee['category']);
foreach ($str as $val){
if (!(strcmp($val,"1"))) {$color1="color:#000000;";}
if (!(strcmp($val,"2"))) {$color2="color:#000000;";}
if (!(strcmp($val,"3"))) {$color3="color:#000000;";}
if (!(strcmp($val,"4"))) {$color4="color:#000000;";}} ?>

       <tr>
       <td width="150" height="10" align="center" class="board_add" style="font-size:18px;">時間</td>
          <td width="300" align="center" class="board_add" style="font-size:18px;">說明</td>
          <td width="150" height="10" align="center" class="board_add" style="font-size:18px;"></tr>
          <tr>
          <td width="150" height="10" align="right" class="illustrate" style="font-size:18px;<?PHP echo $color1;?>">09:30~10:30</td>
          <td width="300" align="center" class="illustrate" style="font-size:18px;<?PHP echo $color1;?>">國語領域學科知能評量
          </td>
           <td width="150" height="10" align="left" class="illustrate" "font-size:18px;<?PHP echo $color1;?>"></tr>
            <td width="150" height="10" align="right" class="illustrate" style="font-size:18px;<?PHP echo $color2;?>">10:30~10:50</td>
          <td width="300" align="center" class="illustrate" style="font-size:18px;<?PHP echo $color2;?>">中場休息
          </td>
           <td width="150" height="10" align="left" class="illustrate" "font-size:18px;<?PHP echo $color2;?>"></tr>
          <td width="150" height="10" align="right" class="illustrate" style="font-size:18px;<?PHP echo $color2;?>">10:50~11:50</td>
          <td width="300" align="center" class="illustrate" style="font-size:18px;<?PHP echo $color2;?>">數學領域學科知能評量
          </td>
           <td width="150" height="10" align="left" class="illustrate" "font-size:18px;<?PHP echo $color2;?>"></tr>
            <td width="150" height="10" align="right" class="board_add" style="font-size:18px;">11:50~13:20</td>
          <td width="300" align="center" class="board_add" style="font-size:18px;">中午用餐時間
          </td>
           <td width="150" height="10" align="left" class="board_add" "font-size:18px;"></tr>
           <td width="150" height="10" align="right" class="illustrate" style="font-size:18px;<?PHP echo $color3;?>">13:20~14:20</td>
          <td width="300" align="center" class="illustrate" style="font-size:18px;<?PHP echo $color3;?>">社會領域學科知能評量
          </td>
           <td width="150" height="10" align="left" class="illustrate" "font-size:18px;<?PHP echo $color3;?>"></tr>
            <td width="150" height="10" align="right" class="illustrate" style="font-size:18px;<?PHP echo $color3;?>">14:20~14:40</td>
          <td width="300" align="center" class="illustrate" style="font-size:18px;<?PHP echo $color3;?>">中場休息
          </td>
           <td width="150" height="10" align="left" class="illustrate" "font-size:18px;<?PHP echo $color3;?>"></tr>
           <td width="150" height="10" align="right" class="illustrate" style="font-size:18px;<?PHP echo $color4;?>">14:40~15:30</td>
          <td width="300" align="center" class="illustrate" style="font-size:18px;<?PHP echo $color4;?>">自然領域學科知能評量
          </td>
           <td width="150" height="10" align="left" class="illustrate" "font-size:18px;<?PHP echo $color4;?>"></tr>
           <tr>
              </table>

        <table width="600" border="0" cellspacing="0" cellpadding="0" >
          <td height="40" colspan="3" align="center">
          <p>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </p>
            </td>

        </tr>

         <tr>

          <td height="40" colspan="3" align="left">

          <p><span class="font_red">*</span> 測驗時考生必須攜帶准考證、學生證(學生證未附照片者，需攜帶國民身分證)、
2B及普通黑色鉛筆、橡皮擦到場應試。外籍人士應攜帶效期內之台灣居留證正本。
</p>
          <p><span class="font_red">*</span> 每節測驗說明開始後即不准再離場。若強行離場、不服糾正者，該科測驗不予計分。</p>
          <p><span class="font_red">*</span> 每節測驗正式開始後十分鐘起，遲到者不得入場。若強行入場，該科測驗不予計分。</p>
          <p><span class="font_red">*</span> 測驗進行間，在監試人員宣布測驗結束前，不得提前交卷離場，違者作答不予計分。</p>
          <p><span class="font_red">*</span> 嚴禁談話、左顧右盼等任何舞弊行為。試場內取得或提供他人答案作弊事實明確者，或相互作弊事實明確者，該科測驗不予計分。</p>
          <p><span class="font_red">*</span> 非應試用品包括報名手冊、書籍、紙張、尺、鉛筆盒、皮包及任何具有通訊、攝影、錄音、記憶、發聲(含振動聲)等功能或有礙試場安寧、妨害測驗公平/智慧財產權之各類器材、物品等。若帶有上述電子設備，須取消鬧鈴設定並關閉電源，測驗進行間若發現上述設備處於開機狀態，扣減該節測驗科目成績5分。</p>
          <p><span class="font_red">*</span> 測驗時應將准考證及身分證件置於監試人員指定處，並配合核對身分及資料。如發現報名所繳身分證件影本與正本不符或身分證件上之相片與本人相貌不同而致辨識困難者，測驗完畢後須再接受查驗；如仍有識別困難者，其作答不予計分，並另行通知其學校或相關機關究辦。</p>
          <p><span class="font_red">*</span> 測驗結束鐘（鈴）響畢，監試人員宣布測驗結束，不論答畢與否應即停止作答，迅速離場。</p>


          </td>

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
      <td height="80" align="center" class="font_red2">目前尚未開放列印!</td>
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

?>
