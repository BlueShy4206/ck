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

//echo "post:".$_POST["examarea"]."<br>";
$a = $_GET["examarea"];

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
			document.form1.subject.value="104年國民小學教師自然領域學科職能評量--考生試場位置通知";
			document.form1.mailBody.value="104年國民小學教師自然領域學科職能評量--考生試場位置通知<br/>詳如附件。<br/>如有任何問題歡迎與我們聯絡，謝謝!!<br/>any problem，you can touch us，thank you!!";
		}else if(mailtype =='score'){
			document.form1.subject.value="104年國民小學教師自然領域學科職能評量--成績通知";
			document.form1.mailBody.value="";
		}else if(mailtype =='password'){
			document.form1.subject.value="104年國民小學教師自然領域學科職能評量--忘記密碼通知";
			document.form1.mailBody.value="";
		}
	    
	}
	//jquery全選
	function CheckedAll(){
	    var checkall = $('#chkAll')[0].checked;
	    $('input:checkbox.chk').each(function(){                
	        this.checked = checkall;
	    });
	}
	function queryData(){
		var examarea = $('#examarea').val();
		var username = $('#username').val();
		window.location.assign("modifyMailList.php?examarea="+examarea+"&username="+username);
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
				window.location.assign("http://localhost/lab2/EasyMVC/Home/mailList")
			},

			error:function(xhr, ajaxOptions, thrownError){
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}
	
</script>
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
</head>
<?php include("header.php"); ?>
<div id="main">
	<table width="555" border="0" cellspacing="0" cellpadding="0" background="../images/back11_2.gif">
      <tr>
        <td width="25" align="left"><img src="images/board07.gif" /></td>
        <td width="104" align="left" valign="middle" background="images/board04.gif">&nbsp; <span class="font_black">發送郵寄通知區&nbsp; &nbsp;</span></td>
        <td width="416" align="left" background="images/board04.gif"><a href="modifyMailList.php"><img src="images/icon_add.gif" width="47" height="19" border="0" /></a></td>
        <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
      </tr>
    </table>
  	<form id="form1" name="form1" method="post" action="addNoticeData.php">
	<table width="555" border="0" cellspacing="0" cellpadding="0">
		<tr><td colspan=2 align=center> &nbsp;&nbsp; </td></tr>
		<tr><td>寄件信箱</td><td><input name="sendmail" type="text" style="width:300px;" value="ckassessment@gmail.com"/></td></tr>
		<tr><td colspan=2>
		<input  type="radio" name="sendType" id="sendType" value="examarea" onclick="setShemp(true)">考場坐位通知
		<input  type="radio" name="sendType" id="sendType" value="password" onclick="setShemp(false)">忘記密碼
		<input  type="radio" name="sendType" id="sendType" value="score" onclick="setShemp(false)">成績通知

		</td></tr>
		<tr><td>信件主旨</td><td><input name="subject" id="subject" type="text" style="width:400px;" value="<?php echo $_POST[subject];?>"/></td></tr>
		<tr><td>郵寄內容</td><td><textarea name="mailBody" id="mailBody" type="text" style="width:400px;height:100px;" ><?php echo $_POST[mailBody];?></textarea></td></tr>
		<tr><td>附加檔案</td><td><input name="attachment" id="attachment" type="text"></td></tr>
		
		<tr><td>寄送郵件</td><td>確認後點選  <input type="submit" id="mailSentBtn" name="mailSentBtn" value="寄出"> 按鈕郵件</td></tr>
	</table>
	<br/>
	
	<table border="1">
	<tr><td colspan="2">查詢條件</td><td>考區:</td><td><select id="examarea" name="examarea"><option value="">全部</option><option value="N" <?php if($a=='N'){ echo "selected";}?>>台北</option><option value="S" <?php if($a=='S') echo "selected";?>>高雄</option></select></td><td></td><td>帳號:</td><td><input id="username" name="username" type="text" /></td></tr>
	<tr><td>收件人員</td><td colspan=6>列表如下, 勾選後點選  <input type="button" name="sendbtn" id="sendbtn" value="送出" onclick="queryData()"> 按鈕</td></tr>
	<tr><td><input type="checkbox" id="chkAll" onclick="CheckedAll()"/><label>全選</label></td><td>人次</td><td>姓名</td><td>身份證</td><td>報名時間</td><td>審核註記</td><td>e-mail</td></tr>
	<?php 
		mysql_select_db($database_conn_web, $conn_web);
		
		$query_web_member = sprintf("SELECT * from member WHERE id > 10199");
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
			echo "<tr><td><label><input type='checkbox' id='examList' name='examList[]' value=$index class='chk'></label></td>
			<td>$i</td><td>$row_web_member[uname]</td><td>$row_web_member[per_id]</td><td>$row_web_member[date]</td><td>$row_web_member[allow]</td><td>$row_web_member[email]</td>
			</tr>";
		}

	?>
	<tr></tr>
	</table>


	</form> 
</div>
<?php include("footer.php"); ?>
</body>
</html>