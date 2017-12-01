
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
	$eng_name="$firstname, $lastname $lastname2";
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
//update by coway 2016.8.18
// $query_web_new = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$query_web_new = "SELECT * FROM examyear WHERE status='0' ORDER BY id DESC LIMIT 0,1";
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);
$totalRows_web_new = mysql_num_rows($web_new);

$todayyear = $row_web_new['times'];
$todayyear .= date("Y");
mysql_select_db($database_conn_web, $conn_web);
//update by coway 2016.8.15
//$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND id LIKE %s ORDER BY SUBSTR( id, 3, 4 ) DESC , SUBSTR( id, 2, 9 ) DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"),GetSQLValueString("%" . $todayyear . "%", "text"));
//add by coway 2016.9.24 (增加已確認報名表方可列印報名表，apply_mk='1')
$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND id LIKE %s AND apply_mk='1' ORDER BY no DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"),GetSQLValueString("%" . $todayyear . "%", "text"));
$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
$row_web_examinee = mysql_fetch_assoc($web_examinee);
$totalRows_web_member = mysql_num_rows($web_examinee);

//取得報考資格_流水號 ,add by coway 2016.8.30
$cert_number= sprintf("%s-%s",$row_web_examinee['cert_no'],sprintf("%04d", $row_web_examinee['cert_id']));

mysql_select_db($database_conn_web, $conn_web);
$query_web_allguide = sprintf("SELECT * FROM allguide Where up_no='EA2' AND nm= %s AND data2= %s",GetSQLValueString($row_web_examinee['exarea'], "text"), GetSQLValueString($row_web_examinee['exarea_note'], "text"));
$web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
$row_allguide = mysql_fetch_assoc($web_allguide);
//取得報考資格 add by coway 2016.8.9
mysql_select_db($database_conn_web, $conn_web);
$query_web_allguideC = sprintf("SELECT * FROM allguide WHERE up_no='ID' and no=%s " , GetSQLValueString($row_web_examinee['cert_no'], "text"));
$web_allguideC = mysql_query($query_web_allguideC, $conn_web) or die(mysql_error());
$row_web_allguideC = mysql_fetch_assoc($web_allguideC);
?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>報名表列印</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="報名表列印" />
<meta name="keywords" content="報名表列印" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />

</head>

<body >

<div id="main111" background= "#FFFFFF">
  <div id="main111" background= "#FFFFFF"></div>
 <?
 if($colname_web_member != "-1"){
 
          
  
  ?>
 
 
 
  <div id="exam" align="center" style="line-height:10px;">
  
  <table width="600" border="0" cellspacing="0" cellpadding="0" >
    <td align="center">
    <div style="font-family:標楷體;">
  <p><font size="5px"><?php echo (date('Y')-1911); ?>年第二梯次國民小學師資類科
  	<br/>師資生學科知能評量報名表</div></font></p></td><!-- add by coway 2016.8.9 -->
  	<td><div align="right" style="font-family:標楷體;"><font size="3px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;准考證號碼：</font><br/><br/>________________________</div></td>
  </table>
     <table width="750" border="0" cellspacing="0" cellpadding="9" >
        <tr>
	        <td width="50" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">姓名</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['uname']."<br>".EngNameStr($row_web_examinee['eng_uname']);  ?></td>
	        <td width="50" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">性別</td> <td width="30" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['sex']; ?></td>
	        <td width="80" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; " colspan="2">身分證字號</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "  colspan="2"><?php echo $row_web_examinee['per_id']; ?></td>
	        <td width="120" height="130" align="left" class="board_add" rowspan="3" style="background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px;">
	        <?php if($row_web_examinee['pic_name'] != ""){ ?>
	        <img src="images/examinee/<?php echo $row_web_examinee['pic_name']; ?>" alt="" name="pic" width="115" id="pic" />
	        <?php }else{ ?>
	        
	        (請上傳近3個月內1吋正面脫帽半身照片)
	
	        <?php  } ?>        
	        <!-- </td> -->
        </tr>
        <tr>
        	<td height="40" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">連絡電話</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo cutSubString($row_web_examinee['phone'],10); ?></td>
        	<td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">Email</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2"><?php echo cutSubString($row_web_examinee['email'],22); ?></td>
        	<td width="110" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">生日</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2"><?php echo $row_web_examinee['birthday']; ?></td>
        </tr>
        <tr>
        	<td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">郵遞區號</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['cuszip']; ?></td>
        	<td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">詳細<br>地址</td> <td  align="left" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="5"><?php echo $row_web_examinee['cusadr']; ?></td>
        </tr>
        <tr>
	        <td width="70" height="40" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">就讀學校</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; ">
	        <?php if (!(strcmp($row_web_examinee['school'],"01_國立臺灣藝術大學"))) {echo "國立臺灣藝術大學";}
		  if (!(strcmp($row_web_examinee['school'],"02_文藻外語大學"))) {echo "文藻外語大學";}
		  if (!(strcmp($row_web_examinee['school'],"03_國立臺東大學"))) {echo "國立臺東大學";}
		  if (!(strcmp($row_web_examinee['school'],"04_國立東華大學"))) {echo "國立東華大學";}
		  if (!(strcmp($row_web_examinee['school'],"05_國立臺北教育大學"))) {echo "國立臺北教育大學";}
		  if (!(strcmp($row_web_examinee['school'],"06_輔仁大學"))) {echo "輔仁大學";}
		  if (!(strcmp($row_web_examinee['school'],"07_南臺科技大學"))) {echo "南臺科技大學";}		 
		  if (!(strcmp($row_web_examinee['school'],"08_國立屏東大學"))) {echo "國立屏東大學";}
		  if (!(strcmp($row_web_examinee['school'],"09_靜宜大學"))) {echo "靜宜大學";}
		  if (!(strcmp($row_web_examinee['school'],"10_國立清華大學"))) {echo "國立清華大學";}  
		  if (!(strcmp($row_web_examinee['school'],"11_國立臺南大學"))) {echo "國立臺南大學";}
		  if (!(strcmp($row_web_examinee['school'],"12_國立高雄師範大學"))) {echo "國立高雄師範大學";}
		  if (!(strcmp($row_web_examinee['school'],"13_國立臺中教育大學"))) {echo "國立臺中教育大學";}
		  if (!(strcmp($row_web_examinee['school'],"14_臺北市立大學"))) {echo "臺北市立大學";}
		  if (!(strcmp($row_web_examinee['school'],"15_國立嘉義大學"))) {echo "國立嘉義大學";}
		  if (!(strcmp($row_web_examinee['school'],"17_國立臺灣海洋大學"))) {echo "國立臺灣海洋大學";}
		  ?></td>
	        <td width="40" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">年級</td> <td width="60" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; ">
	        <?php 
	        	if((int)$row_web_examinee['Grade'] < 6){
	        		echo '大學'.$row_web_examinee['Grade'].'年級';
	        	} 
	        	if((int)$row_web_examinee['Grade'] == 6){echo '研究所';};
	        	if((int)$row_web_examinee['Grade'] == 7){echo '已畢業';};
	         ?></td>
	        <td width="70" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">就讀科系</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2" ><?php echo $row_web_examinee['Department']; ?></td>
	        <td width="80" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">學號</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " ><?php echo $row_web_examinee['Student_ID']; ?></td>
	        <!-- </td> -->
        </tr>
        <tr>
	        <td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">報考資格</td> <td  align="left" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="3">
	        <?php if($row_web_allguideC['no'] == '1'){ echo "(一)";}
	        		elseif($row_web_allguideC['no'] == '2'){ echo "(二)";}
	        		elseif($row_web_allguideC['no'] == '3'){ echo "(三)";}
	        		elseif($row_web_allguideC['no'] == '4'){ echo "(四)";}
	        		elseif($row_web_allguideC['no'] == '5'){ echo "(五)";}
	        echo $row_web_allguideC['nm'];?></td>
            <td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">緊急<br>連絡人<br>姓名</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2">
            <?php echo $row_web_examinee['contact'];?>            
            </td>
            <td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">緊急<br>連絡人<br>電話</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="1"><?php echo $row_web_examinee['contact_ph'];?></td>
        </tr>
        
        <tr>
	        <td height="40" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">評量考區</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2">
	        <?php echo $row_allguide['note'];?>
	        <?php /*if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {echo "北區(國立臺北教育大學)";} 
	         if (!(strcmp($row_web_examinee['exarea'],"Central"))) {echo "中區(國立臺中教育大學)";}  
	         if (!(strcmp($row_web_examinee['exarea'],"Southern"))) {echo "南區(國立臺南大學)";} 
	         if (!(strcmp($row_web_examinee['exarea'],"Eastern"))) {echo "東區(國立臺東大學)";} */ ?> </td>
            <td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">評量日期</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2">
            <?php echo $row_allguide['data1'];?>
            <? /*if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {
				$dateline=strtotime($row_web_new['ndate']);
			   echo (date('Y',$dateline)-1911).date('年m月d日 ',$dateline);
			   echo "(".get_chinese_weekday($row_web_new['ndate']).")";}
			  if (!(strcmp($row_web_examinee['exarea'],"Central"))) {
				  $dateline=strtotime($row_web_new['cdate']);
				  echo (date('Y',$dateline)-1911).date('年m月d日 ',$dateline);
			  echo "(".get_chinese_weekday($row_web_new['cdate']).")";}
			  if (!(strcmp($row_web_examinee['exarea'],"Southern"))) { 
			  	$dateline=strtotime($row_web_new['sdate']);
		      echo (date('Y',$dateline)-1911).date('年m月d日 ',$dateline);
			  echo "(".get_chinese_weekday($row_web_new['sdate']).")";}
			  if (!(strcmp($row_web_examinee['exarea'],"Eastern"))) {
			  $dateline=strtotime($row_web_new['edate']);	  
			  echo (date('Y',$dateline)-1911).date('年m月d日 ',$dateline);
			  echo "(".get_chinese_weekday($row_web_new['edate']).")";} */ ?>
            </td>
            <td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; " colspan="2">報名科目</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php $str=split("," , $row_web_examinee['category']);
			foreach ($str as $val){
			if (!(strcmp($val,"1"))) {echo "國語領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"2"))) {echo "數學領域&nbsp;,<br>";}
			if (!(strcmp($val,"3"))) {echo "社會領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"4"))) {echo "自然領域";}} ?></td>
        </tr>

        <!-- tr>
        <td width="50" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; " colspan="2">緊急連絡人姓名</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2"><?php echo $row_web_examinee['contact']; ?></td>
        <td width="50" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; " colspan="2">緊急連絡人電話</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2"><?php echo $row_web_examinee['contact_ph']; ?></td>
        </td>
        </tr-->
       </table>
            
     <table width="750" height="520" border="0" cellspacing="0" cellpadding="7">
     <tr>
	     <td width="300" align="center" class="board_add" style="font-size:16px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; border: 2px dashed;">國民身分證影本<br />
	                                                 正面<br />
	                                                 (請影印清晰並黏貼)
	     </td>
	     <td width="300" align="center" class="board_add" style="font-size:16px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; border: 2px dashed;">國民身分證影本<br />
	                                                 反面<br />
	                                                 (請影印清晰並黏貼)
	     </td>
     </tr>
     <tr>
	     <td width="300" align="center" class="board_add" style="font-size:16px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; border: 2px dashed;">學生證影本<br />
	                                                 正面<br />
	                                                 (請影印清晰並黏貼)<br />(已畢業者毋需檢附)
	     </td>
	     <td width="300" align="center" class="board_add" style="font-size:16px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; border: 2px dashed;">學生證影本<br />
	                                                 反面<br />
	                                                 (請影印清晰並黏貼)<br />(已畢業者毋需檢附)
	     </td>
     </tr>
     </table>
     <table width="750" border="0" cellspacing="0" cellpadding="8">
     <tr>
        <td width="50" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; "rowspan="2">備註</td> <td width="530"  height="80" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="6" rowspan="2"><p>本表請於<u>106年10月3日（星期二）前</u>填妥並貼妥國民身分證及學生證（務必加蓋當學期的註冊章，或提供在學證明書）的正、反面影本1份或相關表件，以掛號寄達本試務行政組收（40306臺中市西區民生路140號教育樓5樓教師專業能力測驗中心），逾期視同未完成報名（以郵局郵戳為憑）。【所有資料依個資法辦理】備註：<u>應考人所填寫相關資料，將與就讀學校師培單位進行確認<b>(報考資格(三)(四)之應考人)</b>，經查核呈報資料如有虛報不實者，將取消應考資格</u>。</p></td>
          <td width="60" align="center"  style="font-size:12px; background-color: #E8E8E8;  border-color:#000000; border-width:5px; border-style:double; " colspan="2" >申請人簽章
     </td>
     <!--td width="320" align="center" class="board_add" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="3">准考證號碼：________________ (由試務人員填寫)
     </td-->
     <tr>	 
     <td width="120" align="center"  style=" background-color: #FFFFFF; border-color:#000000; border-width:5px;  border-bottom-style:double; border-right-style:double; border-left-style:double;"colspan="2"  ><font  color="#F8F8FF"> (無法親自簽名者由其監護、代理人代簽並註明原因)</font>
     </td></tr>
     </tr>
     </table>
     
                 
         
        <table width="750" border="0" cellspacing="0" cellpadding="0" >  
     
          <tr>
              
          <td height="40" colspan="3" align="center"><label>
          
  <?PHP    //      <input type="button" name="Submit" value="列印本頁" onclick="javascript:window.print()">
          //  <input type="button" value="回首頁" onclick="location.href='index.php'" />
?>            <input name="date" type="hidden" id="date" value="<? echo date("Y-m-d H:i:s");?>" />
          </label></td>
          
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="memberadd" />
      
      <table border="0" width="770">  
      <tr><td ><div style="font-family:標楷體;"><p><font size="4px" color="red"  ></div></font></p></td>
      <td width="100" align="right" colspan="3"><div style="font-family:標楷體;"><p><font size="5px" color="red" >流水號：<?php echo $cert_number;?></div></font></p></td>
      </tr>
      <tr>  
      <td align="center" colspan="4" ><div style="font-family:標楷體;">
	  <p><font size="5px" ><?php echo (date('Y')-1911); ?>年第二梯次國民小學師資類科師資生學科知能評量<br></div></font></p> <!---->
	  </td> 
	  </tr>  
	  <tr>
	  <td align="center" colspan="2"><div style="font-family:標楷體;"><p><font size="5px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;「報名信封封面」</div></font></p></td>
	  <td align="center" width="100" style="font-size:12px; background-color: #E8E8E8;  border-color:#000000;  border-width:1px;border-style:solid; ">掛號</td>
	  </tr>
	  <tr>
	  <td height="100"  colspan="2"></td>  
	  <td width="80"  align="center" style="font-size:12px; background-color: #E8E8E8;  border-color:#000000; border-width:2px; border-style:dotted; ">請貼足<br>掛號<br>郵資</td> 
	  </tr>
      </table>
      <table border="1" width="770" style="border:3px #000000 solid;"  >
      <tr><td width="770" rowspan="3" align="left" style="font-size:22px; border-width:5px; border-style:solid;border-color:#000000;">
      <div style="font-family:標楷體;"><br>&nbsp;&nbsp;<BIG><TT>收件地址：<span style="font-weight:bolder;"><u>40306臺中市西區民生路140號教育樓5樓</u></TT></span></BIG><br><br>&nbsp;&nbsp;<TT><BIG>收件單位：<span style="font-weight:bolder;">教師專業能力測驗中心 (04-2218-3651)</span></BIG></TT><br>
      <br><div align="center"><font size="4px" ><BIG><span style="font-weight:bolder;"><?php echo (date('Y')-1911); ?>年第二梯次國民小學師資類科師資生學科知能評量 試務行政組&nbsp;&nbsp;收</span></BIG></div></font><br></div></td>
      </tr> 
      </table><br>
      <table border="0" width="770"   >
      <tr>
      	<td colspan="2"><div align="left" style="font-family:標楷體;"><font size="4px" ><b>郵寄報名表件截止時間：106年10月3日(星期二)止，以郵局郵戳為憑</b>
      	</font></div></td>
      </tr> 
      <tr><td><div align="left" style="font-family:標楷體;"><font size="3px" >寄件人姓名：</font></div></td>      
      </tr>
      <tr><td colspan="2"><div align="left" style="font-family:標楷體;"><font size="3px">寄件人行動電話：</font></div></td></tr>
      <tr><td colspan="2"><div align="left" style="font-family:標楷體;"><font size="3px" >寄件人地址：</font></div></td></tr>
      <tr><td colspan="2"><div align="left" style="font-family:標楷體;"><font size="3px" >應考資格： ☐已取得國民小學師資類科修畢師資職前教育證明書，但現行非屬編制內正式及代理代課教師者</font></div></td>
      <tr><td colspan="2"><div align="left" style="font-family:標楷體;"><font size="3px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐國民小學師資類科教育實習學生</font></td></tr>
      <tr><td colspan="2"><div align="left" style="font-family:標楷體;"><font size="3px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐刻正修習國民小學教師師資職前教育課程之在學師資生</font></td></tr>
      <tr><td colspan="2"><div align="left" style="font-family:標楷體;"><font size="3px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐甫通過國民小學師資類科師資生資格甄選學生</font></td></tr>
      <tr><td colspan="2"><div align="left" style="font-family:標楷體;"><font size="3px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐一般在學生</font></td></tr>
      </tr>
      </table><br>
      <table width="750" height="230" border="0" cellspacing="0" cellpadding="6">          
      
     <tr>
     <td width="300" align="left" class="board_add" style="font-size:16px; background-color: #FFFFFF;border-width:2px; border-style:dashed;border-color:#000000;"><div align="left" style="font-family:標楷體;"><font size="4px" >＊請將下列文件依序整理備齊(請打勾)，平整裝入信封內：</br>
<p>☐ 一、線上列印報表1份(貼妥國民身份証正、反面影印本)。(須簽名)</p>
<p>☐ 二、其他(請視需要檢附)：</p>
	 <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐ 修畢師資職前教育證明書影本。</p>
	 <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐ 實習學生證影本。</p>
     <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐ 特殊考場服務申請表正本1份(貼妥身心障礙手冊或證明正、反面<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;影印本)。<b>(須簽名)</b></p>
     <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐ 身心障礙應考人申請應考服務診斷證明書正本1份。</p>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐ 身心障礙應考人申請應考切結書正本1份。<b>(須簽名)</b></p>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐ 戶口名簿影本或戶籍謄本正本1份。</p>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(例：改名致與檢附之學生證上所記載之姓名不同者)</p>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐ 其他：<u>______________________________________________________________</u></p>
      </font></div></td>
     
     </tr>
     </table>
     
    </form>
    
  </div>
  <div id="main111" background= "#FFFFFF"></div>
</div>
<script language="Javascript">window.print();</script>
<?PHP }else{?>
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
function cutString($string, $max = 25) {
	$strlen = mb_strlen($string, 'UTF-8');
	$cutLen = 0;
	$retval = "";
	for ($i = 0; $i < $strlen; $i++) {
		$s = mb_substr($string, $i, 1, 'UTF-8');
		if (strlen($s) == 1) {
			$cutLen++;
		} else {
			$cutLen += 2;
		}
		$retval .= $s;
		if ($cutLen >= $max) {
			return $retval;
		}
	}

	return $retval;
}
function cutSubString($string,$len){//取得字串長度後依$len長度做斷行 ,add by coway 2016.8.11
 return mb_substr($string, 0, $len, 'UTF-8')."<br>".mb_substr($string, $len, mb_strlen($string, 'UTF-8'), 'UTF-8');
}
?>
