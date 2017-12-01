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

<?php
header("Cache-control:private");//解決session 引起的回上一頁表單被清空
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

mysql_select_db($database_conn_web, $conn_web);
$query_web_new = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);
$totalRows_web_new = mysql_num_rows($web_new);


$a = $_GET["examarea"];
if(!isset($_GET["status"])){$status = $row_web_new['status'];}else{$status = $_GET["status"];}
if(!isset($_GET["times"])){$times = $row_web_new['times'];}else{$times = $_GET["times"];}
// echo "post:".$_POST["examarea"]."<br>";
// echo "status=".$status."<br>";
// echo "times=".$times."<br>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理後台</title>
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="國民小學教師學科知能評量" />
<meta name="keywords" content="國民小學教師學科知能評量" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<meta charset="UTF-8">
<link href="../web.css" rel="stylesheet" type="text/css" />
<title>發送郵寄通知</title>
<script type="text/javascript" >

window.onload = initPage;
	function initPage(){
		var subBtn = document.getElementById("mailSentBtn");
		
		subBtn.onclick = function(){
			var inputEmail = document.getElementById("examList").value;
			if(inputEmail !=''){
				QueryMail();
			}else alert('請挑選收件人，謝謝');
		}
	}
	
	function setShemp(setting) {
		var mailtype = document.form1.sendType.value;
		if( mailtype =='examarea'){
			document.form1.subject.value="<?php echo date("Y")-1911;?>"+"年國民小學教師自然領域學科職能評量--考生試場位置通知";
			document.form1.mailBody.value="<?php echo date("Y")-1911;?>"+"年國民小學教師自然領域學科職能評量--考生試場位置通知<br/>詳如附件。<br/>如有任何問題歡迎與我們聯絡，謝謝!!<br/>any problem，you can touch us，thank you!!";
		}else if(mailtype =='score'){
			document.form1.subject.value="<?php echo date("Y")-1911;?>"+"年國民小學教師自然領域學科職能評量--成績通知";
			document.form1.mailBody.value="";
		}else if(mailtype =='password'){
			document.form1.subject.value="<?php echo date("Y")-1911;?>"+"年國民小學教師自然領域學科職能評量--忘記密碼通知";
			document.form1.mailBody.value="";
		}else if(mailtype =='student'){
			var Today=new Date();
// 			var RPNm = document.getElementById("RP").value;
			var PRStr=GetCheckedValue("RPc");
			 var arrChk=PRStr.split(",");    //遍历得到每个checkbox的value值
			 var PRString="";
			 for (var i=0;i<arrChk.length;i++){ PRString+="<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+(i+1)+".<span style='color:#f00;'><u>"+arrChk[i]+"</u></span></p>"; }   
			document.form1.subject.value=<?php echo date("Y")-1911;?>+"年第一梯次師資生學科知能評量_應考人補正資料通知_"+Today.getFullYear()+ " 年 " + (Today.getMonth()+1) + " 月 " + Today.getDate() + " 日";
			document.form1.mailBody.value="您好：<br>\n"+
				"<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;謝謝您報名參與<span style='color:#00f;'><u>"+<?php echo date("Y")-1911;?>+"</u></span>年第<span style='color:#00f;'>一</span>梯次<span style='color:#00f;'>師資生</span>學科知能評量，您所郵寄的報名相關表件我們已收到。</p><br>\n"+
			"<p>一、依本報名簡章所載：本中心自<span style='color:#00f;'><u>106/4/10</u></span>起開始公告應考人需補正資料，並於<span style='color:#00f;'><u>4/14</u></span>報名補件截止，以郵局郵戮為憑，逾期不予受理。</p>\n"+
			"<p>二、基於'考生權益保障'之考量，試務行政組為了提醒您準備補件資料，自即日起以E-mail或簡訊通知您(請留意您的垃圾信件匣)。</p>\n"+
			"<p>三、<u>最後貼心提醒，有關您個人報名進度，仍請隨時留意報名網站之報名進度查詢。</u></p><br>\n\n"+
			"<p>您的報考資格為<span style='color:#f00;'><u>"+$('#id').val()+"</u></span>， 所需補正之表件如下：</p>\n\n"+
			"<table align='left' border='1' cellpadding='1' cellspacing='1' style='width: 700px;'><tr><td>"+PRString+
			"<p>&nbsp;&nbsp;※請於<span style='color:#00f;'><u>106/4/14</u></span>報名補件截止日前(郵局郵戮為憑)將需補正之表件，郵寄至本中心。</p><p>&nbsp; ※請於信封外註明&quot;補件及報考場次&quot;。</p></td></tr></table>";
		}else if(mailtype =='teacher'){
			var Today=new Date();
// 			var RPNm = document.getElementById("RP").value;
			var PRStr=GetCheckedValue("RPc");
			 var arrChk=PRStr.split(",");    //遍历得到每个checkbox的value值
			 var PRString="";
			 for (var i=0;i<arrChk.length;i++){ PRString+="<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+(i+1)+".<span style='color:#f00;'><u>"+arrChk[i]+"</u></span></p>"; }   
			document.form1.subject.value=<?php echo date("Y")-1911;?>+"年第一梯次國民小學教師「自然領域」學科知能評量_應考人補正資料通知_"+Today.getFullYear()+ " 年 " + (Today.getMonth()+1) + " 月 " + Today.getDate() + " 日";
			document.form1.mailBody.value="您好：<br>\n"+
				"<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;謝謝您報名參與<span style='color:#00f;'><u>"+<?php echo date("Y")-1911;?>+"</u></span>年第<span style='color:#00f;'>二</span>梯次<span style='color:#00f;'>國民小學教師「自然領域」</span>學科知能評量，您所郵寄的報名相關表件我們已收到。</p><br>\n"+
			"<p>一、依本報名簡章所載：本中心自<span style='color:#00f;'><u>105/11/2</u></span>起開始公告應考人需補正資料，並於<span style='color:#00f;'><u>11/8</u></span>報名補件截止，以郵局郵戮為憑，逾期不予受理。</p>\n"+
			"<p>二、基於'考生權益保障'之考量，試務行政組為了提醒您準備補件資料，自即日起以E-mail或簡訊通知您(請留意您的垃圾信件匣)。</p>\n"+
			"<p>三、<u>最後貼心提醒，有關您個人報名進度，仍請隨時留意報名網站之報名進度查詢。</u></p><br>\n\n"+
			"<p>您的報考資格為<span style='color:#f00;'><u>"+$('#id').val()+"</u></span>， 所需補正之表件如下：</p>\n\n"+
			"<table align='left' border='1' cellpadding='1' cellspacing='1' style='width: 700px;'><tr><td>"+PRString+
			"<p>&nbsp;&nbsp;※請於<span style='color:#00f;'><u>105/11/8</u></span>報名補件截止日前(郵局郵戮為憑)將需補正之表件，郵寄至本中心。</p><p>&nbsp; ※請於信封外註明&quot;補件及報考場次&quot;。</p></td></tr></table>";
		}
	    
	}
	//取得多個CHECK BOX value並用逗號隔開
	function GetCheckedValue(checkBoxName)
	 {
	  return $('input:checkbox[name=' + checkBoxName + '][checked=true]').map(function ()
	  {
	   return $(this).val();
	  })
	  	.get().join(',');
	 }
	//jquery全選
	function CheckedAll(){
		$('#chkAll').change(function() {

			//get all checkbox which want to change
			var checkboxes = $(this).closest('form')
					   .find('input[name="examList[]"]:checkbox');

			if($(this).is(':checked')) {
				checkboxes.prop('checked', 'checked');
			} else {
				checkboxes.removeAttr('checked');
			}

		});
		
// 		$("#chkAll").click(function() {
// 			   if($("#chkAll").prop("checked")) {
// 				   $("input[name='examList[]']").prop("checked", true);
// // 			     $("input[name='examList[]']").each(function() {
// // 			         $(this).prop("checked", true);
// // 			     });
// 			   } else {
// 				   $("input[name='examList[]']").prop("checked", false);
// // 			     $("input[name='examList[]']").each(function() {
// // 			         $(this).prop("checked", false);
// // 			     });           
// 			   }
// 			});
		
// 	    var checkall = $('#chkAll')[0].checked;
// 	    $('input:checkbox.chk').each(function(){                
// 	        this.checked = checkall;
// 	    });
	}
	function queryData(){
		var examarea = $('#examarea').val();
		var username = $('#username').val();
		var status = $('#status').val();
		var times = $('#times').val();
		window.location.assign("modifyMailList.php?examarea="+examarea+"&username="+username+"&status="+status+"&times="+times);
	}

	function QueryMail(){
		var URLs="addNoticeData.php";
		 
		$.ajax({
			url: URLs,
			data: {sendmail: $('#sendmail').val(), subject: $('#subject').val(), mailBody: $('#mailBody').val(), attachment: $('#attachment').val(), examList: $('#examList').val()},
			type:"POST",
			dataType:'text',
			
			success: function(msg){
				alert('郵件寄送中，請稍候！');
// 				window.location.assign("http://120.108.208.34/EasyMVC/Home/mailList")
				window.location.assign("modifyMailList.php")
			},

			error:function(xhr, ajaxOptions, thrownError){
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}
	
</script>
<script type="text/javascript" src="../js/jquery-1.6.2.min.js"></script>
</head>
<?php include("header.php"); ?>
<div id="main">
	<table width="555" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="25" align="left"><img src="../images/board07.gif" /></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">發送郵寄通知區&nbsp; &nbsp;</span></td>
        <td width="416" align="left" background="../images/board04.gif"><a href="modifyMailList.php"><img src="../images/icon_add.gif" width="47" height="19" border="0" /></a></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
    <?php 
    //取得報考資格 add by coway 2016.10.7
    mysql_select_db($database_conn_web, $conn_web);
    $query_web_allguide = "SELECT * FROM allguide WHERE up_no='ID' or up_no='IDt' ORDER BY up_no,no ";
    $web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
    // $row_web_allguide = mysql_fetch_assoc($web_allguide);
    // $totalRows_web_allguide = mysql_num_rows($web_allguide);
    $allguide_lot = array();
    $alli=0;
    while ($row_web_allguide = mysql_fetch_assoc($web_allguide)){
    	$allguide_lot[$alli] = $row_web_allguide;
    	$alli++;
    }
    //取得補件項目 add by coway 2016.10.7
    mysql_select_db($database_conn_web, $conn_web);
    $query_web_allguide_RP = "SELECT * FROM allguide where up_no='RP' ORDER BY id ";
    $web_allguide_RP = mysql_query($query_web_allguide_RP, $conn_web) or die(mysql_error());
    // $row_web_allguide = mysql_fetch_assoc($web_allguide);
    // $totalRows_web_allguide = mysql_num_rows($web_allguide);
    $allguide_RP_lot = array();
    $RPi=0;
    while ($row_web_allguide_RP = mysql_fetch_assoc($web_allguide_RP)){
    	$allguide_RP_lot[$RPi] = $row_web_allguide_RP;
    	$RPi++;
    }
    ?>
  	<form id="form1" name="form1" method="post" action="addNoticeData.php">
	<table width="620" border="0" cellspacing="0" cellpadding="0">
		<tr><td colspan=2 align=center> &nbsp;&nbsp; </td></tr>
		<tr><td>寄件信箱</td><td><input name="sendmail" type="text" style="width:300px;" value="ckassessment@gmail.com"/></td></tr>
		<tr><td colspan=2><p>報考資格：<select id="id" onClick='setShemp(true)'>
		<?php 
		$i=0;
// 		echo "i=".$i."<br>";
// 		echo "alli=".$alli."<br>";
		while($alli > $i){
		echo "<option value='".$allguide_lot[$i]['nm']."'>".$allguide_lot[$i]['nm']."</option>";
		$i++;}        
        ?>
		</select></p></td>
		</tr>
		<div>
		<tr><td colspan=2 align="left">須補件項目請勾選：</td>
		<?php 
// 		echo "name=".$allguide_RP_lot[0]['nm']."<br>";
// 		echo "name1=".$allguide_RP_lot[1]['nm']."<br>";
// 		echo "<tr><td colspan=2><input name='RP' type='checkbox' value='".$allguide_RP_lot[0]['nm']."' />".$allguide_RP_lot[0]['nm']."</td></tr>";
// 		echo "<tr><td colspan=2><input name='RP' type='checkbox' value='".$allguide_RP_lot[1]['nm']."' />".$allguide_RP_lot[1]['nm']."</td></tr>";
		$j=0;
// 		echo "i=".$i."<br>";
// 		echo "RPi=".$RPi."<br>";
		$RPstr="";
		while($RPi > $j){
			if((($j % 5)==0) && ($j != 0) ){
				$RPstr.="<input name='RPc' type='checkbox' style='width:18px;height:18px;' onClick='setShemp(true)' value='".$allguide_RP_lot[$j]['nm']."' />".$allguide_RP_lot[$j]['nm']."<br>";
			}else{
		$RPstr.= "<input name='RPc' type='checkbox' style='width:18px;height:18px;' onClick='setShemp(true)' value='".$allguide_RP_lot[$j]['nm']."' />".$allguide_RP_lot[$j]['nm']."";
			}
		$j++;} 
		echo "<tr><td colspan=2>".$RPstr."</td></tr>";
        ?>
		</tr></div>
		<tr><td colspan=2>---------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>
		<tr>
		<td colspan=2><p>通知類型：	
		<input  type="radio" name="sendType" id="sendType" style="width:18px;height:18px;" value="student" onclick="setShemp(true)">師資生補件通知
		<input  type="radio" name="sendType" id="sendType" style="width:18px;height:18px;" value="teacher" onclick="setShemp(true)">國小教師補件通知
		<!-- input  type="radio" name="sendType" id="sendType" style="width:18px;height:18px;" value="examarea" onclick="setShemp(true)">考場坐位通知
		<input  type="radio" name="sendType" id="sendType" style="width:18px;height:18px;" value="password" onclick="setShemp(false)">忘記密碼
		<input  type="radio" name="sendType" id="sendType" style="width:18px;height:18px;" value="score" onclick="setShemp(false)">成績通知 -->	
		</p></td></tr>
		<tr><td>信件主旨</td><td><input name="subject" id="subject" type="text" style="width:500px;" value="<?php echo $_POST[subject];?>"/></td></tr>
		<tr><td>郵寄內容</td><td><textarea name="mailBody" id="mailBody" type="text" style="width:500px;height:200px;" ><?php echo $_POST[mailBody];?></textarea></td></tr>
<!-- 		<tr><td>附加檔案</td><td><input name="attachment" id="attachment" type="text"></td></tr> -->
		
		<tr><td>寄送郵件</td><td>確認後點選  <input type="submit" id="mailSentBtn" name="mailSentBtn" value="寄出"> 按鈕郵件</td></tr>
	</table>
	<br/>
		
	<table border="2" style="border-style:solid;">
	<tr><td colspan="2" rowspan="2" align="center">查詢條件</td><td>報考類別:</td><td width=100><select id="status"><option value="0" <?php if($status=='0'){ echo "selected";}?>>師資生</option><option value="1"<?php if($status=='1'){ echo "selected";}?>>國小教師</option></select></td><td>考區:</td><td><select id="examarea" name="examarea"><option value="">全部</option><option value="N" <?php if($a=='N'){ echo "selected";}?>>台北</option><option value="S" <?php if($a=='S') echo "selected";?>>高雄</option><option value="C" <?php if($a=='C') echo "selected";?>>台中</option><option value="E" <?php if($a=='E') echo "selected";?>>花蓮</option></select></td><td></td><td>姓名:</td><td><input id="username" name="username" type="text" value=<?php if(isset($_GET['username'])){echo $_GET['username'] ;} ?>></td></tr>
	<tr><td colspan="2"><?php echo date("Y")-1911;?>年度第 <select id="times"><option value="A"  <?php if($times=="A") {echo "selected=\"selected\"";} ?>>1</option><option value="B" <?php if($times=="B") {echo "selected=\"selected\"";} ?> >2</option><option value="C" <?php if($times=="C") {echo "selected=\"selected\"";} ?> >3</option><option value="D" <?php if($times=="D") {echo "selected=\"selected\"";} ?> >4</option></select> 次</td></tr>
	<tr><td>收件人員</td><td colspan=8>列表如下, 勾選後點選  <input type="button" name="sendbtn" id="sendbtn" value="查詢" onclick="queryData()"> 按鈕</td></tr>
	<tr><td><input type="checkbox" id="chkAll" name="chkAll" style="width:18px;height:18px;" onclick="CheckedAll()"/><label>全選</label></td><td>人次</td><td>姓名</td><td>聯絡電話</td><td>身份證</td><td>報名時間</td><td>審核註記</td><td colspan=4>e-mail</td></tr>
	<?php 
		mysql_select_db($database_conn_web, $conn_web);
		$todayyear=$times.date("Y");//第幾次+西元年
// 		$query_web_member = sprintf("SELECT * from member where eform_mk=0 and level='member'");
		$query_web_member = sprintf("SELECT * FROM examinee WHERE apply_mk=1 and  email is not null and no=1523");
		if(isset($_GET['username']) || isset($_GET['examarea']) ){
			$query_web_member = sprintf("SELECT * FROM examinee WHERE apply_mk=1 and  email is not null and exarea like %s and uname like %s and status=%s AND id LIKE %s ", GetSQLValueString($_GET['examarea']. "%", "text"), GetSQLValueString("%".$_GET['username']. "%", "text"), GetSQLValueString($_GET['status'], "text"),GetSQLValueString("_" . $todayyear . "%", "text"));
		}
		/*if(isset($_GET['username']) || isset($_GET['examarea'])){
			$query_web_member = sprintf("SELECT * FROM examinee WHERE allow='Y' and email is not null and exarea like %s and username like %s", GetSQLValueString($_GET['examarea']. "%", "text"), GetSQLValueString($_GET['username']. "%", "text"));
		}else 
			$query_web_member = sprintf("SELECT * FROM examinee WHERE allow='Y' and email is not null");
		*///echo $query_web_member;
		$web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
		$i=0;
		while ($row_web_member = mysql_fetch_assoc($web_member))
		{
			$i++;
			$index=$row_web_member['no'];
			$chkdata[$index]['email']=$row_web_member['email'];
			$chkdata[$index]['username']=$row_web_member['username'];
			
			//Print_r($chkdata[$index]) ;
			//$chkdata = array($row_web_member['no']=>array($row_web_member['username'],$row_web_member['email']));
			echo "<tr><td><label><input type='checkbox' name='examList[]' value=$index style='width:18px;height:18px;' ></label></td>
			<td>$i</td><td>$row_web_member[uname]</td><td>$row_web_member[phone]</td><td>$row_web_member[per_id]</td><td>$row_web_member[date]</td><td>$row_web_member[allow]</td><td colspan=4>$row_web_member[email]</td>
			</tr>";
		}

	?>
	<tr></tr>
	</table>

	
	<?php //require_once "QryMailList.php";?>
	</form> 
</div>
<?php include("footer.php"); ?>
</body>
</html>