<? session_start();?>
<?php header("Access-Control-Allow-Origin: *");?>
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
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">

window.onload = initPage;
function initPage(){
	var subBtn = document.getElementById("sub_btn");
	
	subBtn.onclick = function(){
		var inputEmail = document.getElementById("email").value;
		if(inputEmail !=''){
			QueryMail();
			//MakeAjaxMail();
		}else alert('請輸入mail');
	}
}

function QueryMail(){
	var URLs="memberLostPass2.php";
	 
	$.ajax({
		url: URLs,
		data: {email: $('#email').val()},
		type:"POST",
		dataType:'text',
		
		success: function(msg){
			alert('郵件寄送中，請稍候！');
			window.location.assign("http://120.108.208.34/EasyMVC/Home/mailList")
		},

		error:function(xhr, ajaxOptions, thrownError){
			alert(xhr.status);
			alert(thrownError);
		}
	});
}
function jsonCallback( json ) {
    $.each(json, function(index, value){
       // alert(index + " " + value );
    });
}

function MakeAjaxMail(){
	var URLs="http://120.108.208.34/EasyMVC/Home/mailList";
	 
	$.ajax({
		url: URLs,
		type:"get",
		contentType: "application/json; charset=utf-8;",
		dataType:'jsonp',
		jsonpCallback: 'jsonCallback',
		success: function(json){
			alert('新密碼已寄發您的信箱，請使用新密碼登入網站，謝謝');
		},

		error:function(xhr, ajaxOptions, thrownError){
			alert(xhr.status);
			alert(thrownError);
		}
	});

}
</script>
</head>

<body background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <? include("leftzone.php")?>
  </div>
  <div id="main3">
	<br />
    <br />
    <br />
    <table width="364" border="0" align="center" cellpadding="0" cellspacing="0" background="images/memberSendPass.gif">
      <tr>
        <td width="22" height="55">&nbsp;</td>
        <td width="306">&nbsp;</td>
      </tr>
      <tr>
        <td height="129">&nbsp;</td>
        <td align="left" valign="top">
        <form name="LostPass" id="LostPass" >
          <p class="font_black"><br/>請輸入您申請會員帳號的Email信箱!!
            <br />
            <br />
            <label>
            	<input type="text" name="email" id="email" /> 
            </label>
            <label>
              <input type="button" name="sub_btn" id="sub_btn" value="送出" />
            </label>
            <br />
        </p>
        </form></td>
      </tr>
    </table>
  </div>
  <div id="main4"></div>

<?php include("footer.php"); ?>
</div>
</div>
</body>
</html>