
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
//update by coway 2016.8.18
// $query_web_new = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$query_web_new = "SELECT * FROM examyear WHERE status='1' ORDER BY id DESC LIMIT 0,1";
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

//取得報考資格_流水號 ,add by coway 2016.8.30
$cert_number= sprintf("%s-%s",$row_web_examinee['cert_no'],sprintf("%04d", $row_web_examinee['cert_id']));

//取得報考資格 add by coway 2016.8.18
mysql_select_db($database_conn_web, $conn_web);
$query_web_allguideC = sprintf("SELECT * FROM allguide WHERE up_no='IDt' and no=%s " , GetSQLValueString($row_web_examinee['cert_no'], "text"));
$web_allguideC = mysql_query($query_web_allguideC, $conn_web) or die(mysql_error());
$row_web_allguideC = mysql_fetch_assoc($web_allguideC);
//取得評量考區與日期 add by coway 2016.8.19
mysql_select_db($database_conn_web, $conn_web);
$query_web_allguide = sprintf("SELECT * FROM allguide Where up_no='EA' AND nm= %s",GetSQLValueString($row_web_examinee['exarea'], "text"));
$web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
$row_allguide = mysql_fetch_assoc($web_allguide);

function getLevel($value){
	IF(isset($value)){
		switch ($value) {
			case "1":
				$level = "專科學位";
				break;
			case "2":
				$level = "學士學位";
				break;
			case "3":
				$level = "碩士學位";
				break;
			case "4":
				$level = "博士學位";
				break;
		}
	}
	return $level;
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
<meta name="description" content="報名表列印" />
<meta name="keywords" content="報名表列印" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div id="main111" background= "#FFFFFF">

 <?
 if($colname_web_member != "-1" && $row_web_new['status'] == '1'){
   
  ?>

  <div id="exam" align="center" >
  <table width="650" border="0" cellspacing="0" cellpadding="0" >
    <td align="center"><div style="font-family:標楷體;">
  <p><font size="5px" ><?php echo (date('Y')-1911); ?>年第二梯次國民小學教師「自然領域」 學科知能評量<br>報名表</div></font></p> <br /><!---->
  </td>
  <td><div align="right" style="font-family:標楷體;"><font size="3px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;准考證號碼：</font><br/><br/>________________________</div></td>
  </table>
     <table width="650" border="0" cellspacing="0" cellpadding="9" >
        <tr>
        <td width="130" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">姓名</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['uname']."<br>".EngNameStr($row_web_examinee['eng_uname']); ?></td>
        <td width="80" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">性別</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['sex']; ?></td>
        <td width="80" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">身分證字號</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['per_id']; ?></td>
        <td width="120" height="130" align="left" class="board_add" rowspan="3" colspan="2" style="background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px;">
        <?php if($row_web_examinee['pic_name'] != ""){ ?>
        <img src="images/examinee/<?php echo $row_web_examinee['pic_name']; ?>" alt="" name="pic" width="115" id="pic" />
        <?php }else{ ?>
        
        (請上傳近3個月內1吋正面脫帽半身照片)

        <?php  } ?>        
        </td>
        </tr>
        <tr>
        <td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">聯絡<br>電話</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['phone']; ?></td>
        <td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">Email</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo cutSubString($row_web_examinee['email'],18); ?></td>
        <td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">生日</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['birthday']; ?></td>
        </tr>
        <tr>
        <td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">郵遞區號</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['cuszip']; ?></td>
        <td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">詳細地址</td> <td  align="left" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="3"><?php echo $row_web_examinee['cusadr']; ?></td>
        </tr>
        <tr>
        <td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">報名科目</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; ">自然領域</td>
        <td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">評量考區</td> <td  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2">
        	<?php echo $row_allguide['note']."-".$row_allguide['data1'];?>
           <?php //if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {echo "臺北(國立臺灣大學考場)"."-".$row_allguide['data1'];} ?> 
           <?php //if (!(strcmp($row_web_examinee['exarea'],"Central"))) {echo "臺中(國立臺中教育大學考場)"."-".$row_allguide['data1'];} ?> 
           <?php //if (!(strcmp($row_web_examinee['exarea'],"Southern"))) {echo "高雄(高雄市私立三信家事商業職業學校考場)"."-".$row_allguide['data1'];} ?> 
           <?php //if (!(strcmp($row_web_examinee['exarea'],"Eastern"))) {echo "花蓮(國立花蓮高級商業職業學校考場)"."-".$row_allguide['data1'];} ?> </td>
         <td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">任職學校</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2"><?php echo $row_web_examinee['school']; ?></td>
         <!-- <td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">身份</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo "現職專任教師"; ?></td>  -->   
        </tr>
        <tr>
        	<td  align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">報考資格</td> <td  align="left" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="6">
	        <?php if($row_web_allguideC['no'] == '1'){ echo "(一)";}
	        		elseif($row_web_allguideC['no'] == '2'){ echo "(二)";}
	        		elseif($row_web_allguideC['no'] == '3'){ echo "(三)";}
	        echo $row_web_allguideC['nm'];?></td>
        </tr>
        <tr>
        	<td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; " rowspan="2">教師證<br>號碼</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " rowspan="2"><?php echo $row_web_examinee['certificate']; ?></td>
        	<td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; "></td>
        	<td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">畢業學校名稱</td> 
        	<td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; " colspan="2">學院與系所名稱</td> 
        	<td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; "></td>
        	
        </tr>
        <tr>
        	<td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; "><?php 
			$level1=getLevel($row_web_examinee['Edu_level']);
			echo "$level1";?></td>
        	<td height="40" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['Highest']; ?></td>
			<td align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2"><?php echo $row_web_examinee['High_college']."-".$row_web_examinee['Department']; ?></td>
			<td align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; ">
			<?php 
			//$level1=getLevel($row_web_examinee['Edu_level']);
			$status_leve1=getStatus($row_web_examinee['Edu_MK']);
			echo "$status_leve1";?>
			</td>
        </tr>
        <tr>
        	<td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; ">緊急聯絡<br>人姓名</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['contact']; ?></td>
        	<td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; "><?php 
			$level2=getLevel($row_web_examinee['Edu_level2']);
			echo "$level2";?></td>
        	<td height="40"  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['Sec_highest']; ?></td>
        	<td align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2"><?php echo $row_web_examinee['Sec_college']."-".$row_web_examinee['Sec_dept']; ?></td>
			<td align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; ">
			<?php 
			//$level2=getLevel($row_web_examinee['Edu_level2']);
			$status_leve2=getStatus($row_web_examinee['Edu_MK2']);
			if (isset($row_web_examinee['Sec_highest'])) echo "$status_leve2";?>
			</td>
        </tr>
        <tr>
        	<td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; " rowspan="2">緊急聯絡<br>人電話</td> <td width="100" align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " rowspan="2"><?php echo $row_web_examinee['contact_ph']; ?></td>
        	<td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; "><?php 
			$level2=getLevel($row_web_examinee['Edu_level3']);
			echo "$level2";?></td>
        	<td height="40"  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['Other1']; ?></td>
        	<td align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2"><?php echo $row_web_examinee['Other1_college']."-".$row_web_examinee['Other1_dept']; ?></td>
			<td align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; ">
			<?php 
			//$level2=getLevel($row_web_examinee['Edu_level3']);
			$status_leve2=getStatus($row_web_examinee['Edu_MK3']);
			if(isset($row_web_examinee['Other1'])) echo "$status_leve2";?>
			</td>
        </tr>
        <tr>
        	<td align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; "><?php 
			$level2=getLevel($row_web_examinee['Edu_level4']);
			echo "$level2";?></td>
	        <td height="40"  align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; "><?php echo $row_web_examinee['Other2']; ?></td>
	        <td align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="2"><?php echo $row_web_examinee['Other2_college']."-".$row_web_examinee['Other2_dept']; ?></td>
	        <td align="center" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; ">
	        <?php 
			//$level2=getLevel($row_web_examinee['Edu_level4']);
			$status_leve2=getStatus($row_web_examinee['Edu_MK4']);
			if(isset($row_web_examinee['Other2'])) echo "$status_leve2";?>
	        </td>
	    </tr>
       </table>
            
     <table width="650" height="230" border="0" cellspacing="0" cellpadding="6">
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
     </table>
     <table width="650" border="0" cellspacing="0" cellpadding="7">
     <tr>
        <td width="50" align="center" style="font-size:12px; background-color: #E8E8E8; border-style:solid; border-color:#000000; border-width:1px; " rowspan="2">備註</td> <td width="550" align="life" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="5" rowspan="2">本表請於<u>105年10月25日</u>前填妥並貼妥國民身分證正、反面影本，並檢附大專以上學歷學位證書影本各1份、國民小學教師證書影本1份、在職證明書正本1份（自開立日起二個月內有效）（附表3）或相關表件，以掛號寄達本試務行政組收（40306臺中市西區民生路140號教育樓5樓教師專業能力測驗中心），逾期視同未完成報名（以郵局郵戳為憑）。【所有資料依個資法辦理】</td>
        
         <td width="60" align="center"  style="font-size:12px; background-color: #E8E8E8;  border-color:#000000; border-width:5px; border-style:double; " colspan="2" >申請人簽章
     </td>
     <!--td width="320" align="center" class="board_add" style="font-size:12px; background-color: #FFFFFF; border-style:solid; border-color:#000000; border-width:1px; " colspan="3">准考證號碼：________________ (由試務人員填寫)
     </td-->
     <tr>	 
     <td width="140" align="center"  style=" background-color: #FFFFFF; border-color:#000000; border-width:5px;  border-bottom-style:double; border-right-style:double; border-left-style:double;"colspan="2"  ><font  color="#F8F8FF"> (無法親自簽名者由其監護、代理人代簽並註明原因) </font> 
     </td></tr>
     </tr>
     </table><br><br>

        <table width="650" border="0" cellspacing="0" cellpadding="0" >  
     
          <tr>
              
          <td height="40" colspan="3" align="center"><label>
          
  <?PHP    //      <input type="button" name="Submit" value="列印本頁" onclick="javascript:window.print()">
          //  <input type="button" value="回首頁" onclick="location.href='index.php'" />
?>            <input name="date" type="hidden" id="date" value="<? echo date("Y-m-d H:i:s");?>" />
          </label></td>
          
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="memberadd" />
      <table border="0"  width="750">  
      <tr><td ><div style="font-family:標楷體;"><p><font size="4px" color="red"  ></div></font></p></td>
      <td width="100" align="right" colspan="3"><div style="font-family:標楷體;"><p><font size="5px" color="red" >流水號：<?php echo $cert_number;?></div></font></p></td>
      </tr>
      <tr>  
      <td align="center" colspan="4" ><div style="font-family:標楷體;">
	  <p><font size="5px" ><?php echo (date('Y')-1911); ?>年第二梯次國民小學教師「自然領域」 學科知能評量<br></div></font></p> <!---->
	  </td> 
	  </tr>  
	  <tr>
	  <td align="center" colspan="2"><div style="font-family:標楷體;"><p><font size="5px" >「報名信封封面」</div></font></p></td>
	  <td align="center" width="100" style="font-size:12px; background-color: #E8E8E8;  border-color:#000000;  border-width:1px;border-style:solid; ">掛號</td>
	  </tr>
	  <tr>
	  <td height="100"  colspan="2"></td>  
	  <td width="80"  align="center" style="font-size:12px; background-color: #E8E8E8;  border-color:#000000; border-width:2px; border-style:dotted; ">請貼足<br>掛號<br>郵資</td> 
	  </tr>
      </table>
      <table border="1" width="750" style="border:3px #000000 solid;"  >
      <tr><td width="650" rowspan="3" align="left" style="font-size:22px; border-width:5px; border-style:solid;border-color:#000000;">
      <div style="font-family:標楷體;"><br>&nbsp;&nbsp;<BIG><TT>收件地址：<strong><u>40306臺中市西區民生路140號教育樓5樓</u></strong></TT></BIG><br><br>&nbsp;&nbsp;<BIG><TT>收件單位：<span style="font-weight:bolder;">教師專業能力測驗中心 (04-2218-3651)</span></TT></BIG><br>
      <br><div align="center"><font size="5px" ><BIG><span style="font-weight:bolder;"><?php echo (date('Y')-1911); ?>年第二梯次國民小學教師「自然領域」學科知能 <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;評量試務行政組&nbsp;&nbsp;收</span></BIG></div></font><br></div></td>
      </tr> 
      </table><br>
      <table border="0" width="750"   >
      <tr>
      	<td colspan="2"><div align="left" style="font-family:標楷體;"><font size="4px" ><b>郵寄報名表件截止時間：105年10月25日(星期二)止，以郵局郵戳為憑</b>
      	</font></div><br></td>
      </tr> 
      <tr><td><div align="left" style="font-family:標楷體;"><font size="3px" >寄件人姓名：</font></div></td>
      <td><div align="right" style="font-family:標楷體;"><font size="4px" >報考資格：☐現職教師;☐現職代理代課教師;☐儲備教師</font></div></td>
      </tr>
      <tr><td colspan="2"><div align="left" style="font-family:標楷體;"><font size="3px"><br>寄件人行動電話：</font></div></td></tr>
      <tr><td colspan="2"><div align="left" style="font-family:標楷體;"><font size="3px" ><br>寄件人地址：</font></div></td></tr>
      </table><br>
      <table width="750" height="230" border="0" cellspacing="0" cellpadding="6">          
      
     <tr>
     <td width="300" align="left" class="board_add" style="font-size:16px; background-color: #FFFFFF;border-width:5px; border-style:double;border-color:#000000;"><div align="left" style="font-family:標楷體;"><font size="4px" >＊請將下列文件依序整理備齊(請打勾)，平整裝入信封內：</br>
<p>☐ 一、線上列印報表1份(貼妥國民身份証正、反面影印本)。(須簽名)</p>
<p>☐ 二、大專以上學歷學位證書影印本各1份(縮印成A4紙張影印)。</p>
<p>☐ 三、國民小學教師證書影印本1份。</p>
<p>☐ 四、在職證明書正本1份(自開立日起二個月內有效)(一律使用本中心提供之<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;表格，請線上自行下載)。</p>
<p>☐ 五、其他(請視需要檢附)：</p>
     <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐ 特殊考場服務申請表正本1份(貼妥身心障礙手冊或證明正、反面<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;影印本)。<b>(須簽名)</b></p>
     <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐ 身心障礙應考人申請應考服務診斷證明書正本1份。</p>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐ 身心障礙應考人申請應考切結書正本1份。<b>(須簽名)</b></p>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;☐ 戶口名簿影本或戶籍謄本正本1份。</p></font></div></td>
     
     </tr>
     </table>
     
	  </div>
    </form>
    
  </div>
  <div id="main111" background= "#FFFFFF"></div>
</div>
<script language="Javascript">window.print();</script>
<?PHP }else{?>
  <table width="555" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td height="80" align="center" class="font_red2">列印報名表請先登入會員</td>
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
function cutSubString($string,$len){//取得字串長度後依$len長度做斷行 ,add by coway 2016.8.11
	return mb_substr($string, 0, $len, 'UTF-8')."<br>".mb_substr($string, $len, mb_strlen($string, 'UTF-8'), 'UTF-8');
}
mysql_free_result($web_new);
mysql_free_result($web_examinee);
?>
