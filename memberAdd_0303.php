<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>國民小學教師學科知能評量</title>
	<meta http-equiv="Content-Language" content="zh-tw" />
	<meta name="description" content="國民小學教師學科知能評量" />
	<meta name="keywords" content="國民小學教師學科知能評量" />
	<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
	<link rel="stylesheet" href="css/screen.css">
	<script src="js/jquery.js"></script>
	<script src="js/jquery.validate.js"></script>
	<link href="web.css" rel="stylesheet" type="text/css" />
	<script src="address.js"></script><!--引入郵遞區號.js檔案-->
	<link rel="stylesheet" href="./css/dhtmlgoodies_calendar.css" />
	<script src="./js/dhtmlgoodies_calendar.js"></script>
	<script>
	$.validator.setDefaults({
		submitHandler: function() {
			//alert("submitted!");
			//$('#signupForm').submit(function(){
			$(this).ajaxSubmit({
				type:"post",
				url:"insertMember.php",
				beforeSubmit:showRequest,
				success:showResponse
			});
			return false; //此處必須返回false，阻止常規的form提交
		//});
		}
	});
	
	//初步判斷身分證字號是否符合運算規則
	$.validator.addMethod("isIdCardNo", function(value, element) {
		var a = new Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'W', 'Z', 'I', 'O');
		var b = new Array(1, 9, 8, 7, 6, 5, 4, 3, 2, 1);
		var c = new Array(2);
		var d;
		var e;
		var f;
		var g = 0;
		var h = /^[a-z](1|2)\d{8}$/i;
		var l = /^[a-z][a-d]\d{8}$/i;
		
		
		if(value.search(l) == 0 ) {
			return true;
			}else{
		if (value.search(h) == -1 && value.search(l) == -1 ) {
		
			return false;
		} else {
			
			d = value.charAt(0).toUpperCase();
			f = value.charAt(9);
		}
		for (var i = 0; i < 26; i++) {
			if (d == a[i])//a==a 
			{
				e = i + 10; //10
				c[0] = Math.floor(e / 10); //1
				c[1] = e - (c[0] * 10); //10-(1*10)
				break;
			}
		}
		for (var i = 0; i < b.length; i++) {
			if (i < 2) {
				g += c[i] * b[i];
			} else {
				g += parseInt(value.charAt(i - 1)) * b[i];
			}
		}
		if ((g % 10) == f) {
			return true;
		}
		if ((10 - (g % 10)) != f) {
			return false;
		}}
		return true;
	});
	
	//判斷帳號是否重複
	jQuery . validator . addMethod ( "uniqueUsername" , function ( value , element ) {
		var response ;
 
		var username = $ ( '#username' ) . val ( ) ;
		$ . ajax ( {
			type : "POST" ,
			url : "process.php" ,
			data : { username : username } ,
			async : false ,
			success : function ( data ) {
				response = data ;
			}
		} ) ;
		if ( response == 'true' ) {
			return true ;
		} else {
			return false ;
		}
	} ) ;
	
	//判斷身分證字號是否重複
	jQuery . validator . addMethod ( "uniqueID" , function ( value , element ) {
		var response ;
 
		var id = $ ( '#id' ) . val ( ) ;
		$ . ajax ( {
			type : "POST" ,
			url : "process.php" ,
			data : { id : id } ,
			async : false ,
			success : function ( data ) {
				response = data ;
			}
		} ) ;
		if ( response == 'true' ) {
			return true ;
		} else {
			return false ;
		}
	} ) ;
	
	//判斷email是否重複
	jQuery . validator . addMethod ( "uniqueEmail" , function ( value , element ) {
		var response ;
 
		var email = $ ( '#email' ) . val ( ) ;
		$ . ajax ( {
			type : "POST" ,
			url : "process.php" ,
			data : { email : email } ,
			async : false ,
			success : function ( data ) {
				response = data ;
			}
		} ) ;
		if ( response == 'true' ) {
			return true ;
		} else {
			return false ;
		}
	} ) ;
	
	//判斷生日
	/*
	$.validator.addMethod("Birthday", function(value, element) {
		var year = $ ( '#year' ) . val ( ) ;
		var month = $ ( '#month' ) . val ( ) ;
		var day = $ ( '#day' ) . val ( ) ;

		if( year == '年'){
			return false ;
			} else {
			if( month == '月'){
				return false ;
				} else {
					if( day == '日'){
						return false ;
						} else {
							return true ;
							}
					
					}
			
			}
		
	});*/

	//驗證
	$().ready(function() {
		// validate the comment form when it is submitted
		$("#commentForm").validate();

		// validate signup form on keyup and submit
		$("#signupForm").validate({
			rules: {
				uname: "required",
				Firstname: "required",
				Lastname: "required",
				//eng_uname: "required",
				username: {
					required: true,
					minlength: 4,
					uniqueUsername: true
				},
				password: {
					required: true,
					minlength: 4
				},
				repassword: {
					required: true,
					minlength: 4,
					equalTo: "#password"
				},
				id: {
					required: true,
					minlength: 10,
					isIdCardNo: true,
					uniqueID: true
				},
				email: {
					required: true,
					email: true,
					uniqueEmail: true
				},
				phone: "required",
				cusadr: {
					required: true,
					minlength: 5,
				},				
				captcha:{
					required: true,
					remote:"process.php"
				},
				birthday:"required",
				/*day: {
					Birthday: true
				},*/
				topic: {
					required: "#newsletter:checked",
					minlength: 2
				},
				agree: "required"
			},
			//錯誤訊息
			messages: {
				uname: "請檢查姓名欄位",
				Firstname: "請檢查英文姓欄位",	
				Lastname: "請檢查英文名欄位",	
				//eng_uname: "請檢查英文姓名欄位",				
				username: {
					required: "請檢查帳號欄位",
					minlength: "帳號輸入請勿少於4個字元",
					uniqueUsername: "此帳號已經被註冊了"
				},
				password: {
					required: "請檢查密碼欄位",
					minlength: "密碼輸入請勿少於4個字元"
				},
				repassword: {
					required: "請檢查確認密碼欄位",
					minlength: "密碼輸入請勿少於4個字元",
					equalTo: "輸入值與密碼欄位不同"
				},
				id: {
					required: "請檢查身分證字號欄位",
					minlength: "身分證字號輸入請勿少於10個字元",
					isIdCardNo: "請檢查身分證字號欄位",
					uniqueID: "此身分證字號已經被註冊了"
				},
				email:{
					required:"請檢查email欄位",
					uniqueEmail: "此Email已經被註冊了"
				},
				day: {
					Birthday:"請檢查生日欄位"
				},
				phone: "請檢查電話欄位",
				cusadr: {
					required: "請檢查地址欄位",
					minlength: "請輸入完整地址",
				},				
				captcha:{
					required: "請檢查驗證碼欄位",
					remote:"驗證碼錯誤！"
				}
			}
		});

		// propose username by combining first- and lastname
	/*	$("#username").focus(function() {
			var uname = $("#uname").val();
			if (uname && !this.value) {
				this.value = uname + ".";
			}
		});  */
		/*
		//code to hide topic selection, disable for demo
		var newsletter = $("#newsletter");
		// newsletter topics are optional, hide at first
		var inital = newsletter.is(":checked");
		var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
		var topicInputs = topics.find("input").attr("disabled", !inital);
		// show when newsletter is checked
		newsletter.click(function() {
			topics[this.checked ? "removeClass" : "addClass"]("gray");
			topicInputs.attr("disabled", !this.checked);
		});
		*/
		//驗證碼
		$("#getcode").click(function(){
			$imgstr="getcode.php?randcode="+Math.random();
			$(this).attr("src",$imgstr);
		});
	});
	</script>
	<style>
	#commentForm {
		width: 500px;
	}
	#commentForm label {
		width: 250px;
	}
	#commentForm label.error, #commentForm input.submit {
		margin-left: 253px;
	}
	#signupForm {
		width: 500px;
	}
	#signupForm label.error {
		margin-left: 10px;
		width: auto;
		display: inline;
	}
	#newsletter_topics label.error {
		display: none;
		margin-left: 103px;
	}
	</style>
	<style type="text/css">
        /************jQuery.Validate樣式********************/
    label.error
        {
            background: url(../../ck910/ck/images/icon-cross.gif) no-repeat 0px 0px;
            color: Red;
            padding-left: 20px;
        }
        input.error
        {
            border: dashed 1px red;
        }
        /************jQuery.Validate樣式********************/
    </style>
</head>
<body background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main_1">
  <div id="main1" style="background:#efefef; margin: auto; width: 770px"></div>
  <div id="main_2">
     
  </div>
  <div id="main_3" align="center" style="background:#efefef; margin: auto; width: 770px">
	<? if(empty($_SESSION["MM_Username"])){//如果未驗證到會員登入的Session變數MM_Username，顯示本區塊?>
	<form method="POST" action="insertMember.php" id="signupForm" onsubmit='return confirm("<?php $_POST['Firstname']?> 確定送出?");' >
      <? if($_GET["requsername"]!=""){?>
      <table width="540" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" bgcolor="#FF0000" class="font_white">帳號或電子郵件已經註冊過了!!</td>
        </tr>
      </table>
      <? }?>
      <table width="540" border="0" cellspacing="0" cellpadding="0" >
        <tr>
          <td width="25" align="left"><img src="images/board03.gif" /></td>
          <td width="505" align="left" background="images/board04.gif">&nbsp; <span class="font_black">請您填妥資料，加入成為網站會員</span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="540" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="82" height="30" align="right" class="board_add">中文姓名：</td>
          <td width="458" align="left" class="board_add">
          <label for="uname"><input id="uname" name="uname" type="text"></label>
            <span class="font_red">* </span></td>
        </tr>
        <tr>
          <td width="82" height="30" align="right" class="board_add">英文姓名：</td>
          <td width="458" align="left" class="board_add">
          <!-- <label for="eng_uname"><input id="eng_uname" name="eng_uname" type="text"></label> -->
          	姓 <label for="Firstname"><input id="Firstname" name="Firstname" type="text"></label>
          , 名 <label for="Lastname"><input id="Lastname" name="Lastname" type="text"></label>
            <span class="font_red">* <a href="https://www.boca.gov.tw/sp.asp?xdURL=E2C/c2102-5.asp&CtNode=677&mp=1" target="new">英文姓名查詢</a></span></td>
        </tr>        
        <tr>
          <td height="30" align="right" class="board_add">帳號：</td>
          <td align="left" class="board_add"><label for="username"><input id="username" name="username" type="text">
          </label><span class="font_red">* </span><span id="idErrMsg"> </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">密碼：</td>
          <td align="left" class="board_add"><label for="password"><input id="password" name="password" type="password">
          </label><span class="font_red">* </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">確認密碼：</td>
          <td align="left" class="board_add"><label for="repassword"><input id="repassword" name="repassword" type="password">
          </label><span class="font_red">* </span></td>
        </tr>
		<tr>
          <td height="30" align="right" class="board_add">身分證字號：</td>
          <td align="left" class="board_add"><label for="id"><input id="id" name="id" type="text">
          </label><span class="font_red">* </span><span id="ROCidErrMsg"> </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">E-mail：</td>
          <td align="left" class="board_add"><label for="email"><input id="email" name="email" type="text" style="width:200px;">
          </label><span class="font_red">*</span><span id="emailErrMsg"> </span><br />
          <span class="font_black">請勿使用會檔信的yahoo、pchome信箱，以免收不到信。</span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">性別：</td>
          <td align="left" class="board_add"><label for="sex"><input name="sex" type="radio" id="radio" value="男" checked="checked" /> 男
				<input type="radio" name="sex" id="radio2" value="女" /> 女
                     
		  </label>
          <span class="font_red">* </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">生日：</td>
          <td align="left" class="board_add">
          <input type="text" name="birthday" id="birthday">
		  <input type="button" value="Cal" onclick="displayCalendar(birthday,'yyyy-mm-dd',this)">
          <!--  <select name="year" id="year">
             <option>年</option>
               <script language="javascript" type="text/javascript">
                   var watch=new Date();
                   var thisYear=watch.getFullYear();
				   for(y=thisYear;y>=1900;y--){
                       document.write("<option value='"+y+"'>"+y+"</option>")
	                  }
	           </script>
          </select>
          
          <select name="month" id="month">
            <option>月</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(m=01;m<=12;m++){
                       document.write("<option value='"+m+"'>"+m+"</option>")
	                  }
	           </script>
           </select>
 
           <select name="day" id="day">
            <option>日</option>
               <script language="JavaScript" type="text/JavaScript">
                   for(d=01;d<=31;d++){
                       document.write("<option value='"+d+"'>"+d+"</option>")
	                  }
	           </script>
          </select>-->
          <span class="font_red">* </span>          </td>
        </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">電話：</td>
          <td align="left" class="board_add"><label for="phone"><input id="phone" name="phone" type="text">
          </label><span class="font_red">* </span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">郵遞區號：</td>
          <td align="left" class="board_add">
                          <select onChange="citychange(this.form)" name="Area">
                              <option value="基隆市">基隆市</option>
                              <option value="臺北市" selected="selected">臺北市</option>
                              <option value="新北市">新北市</option>
                              <option value="桃園縣">桃園縣</option>
                              <option value="新竹市">新竹市</option>
                              <option value="新竹縣">新竹縣</option>
                              <option value="苗栗縣">苗栗縣</option>
                              <option value="臺中市">臺中市</option>
                              <option value="彰化縣">彰化縣</option>
                              <option value="南投縣">南投縣</option>
                              <option value="雲林縣">雲林縣</option>
                              <option value="嘉義市">嘉義市</option>
                              <option value="嘉義縣">嘉義縣</option>
                              <option value="臺南市">臺南市</option>
                              <option value="高雄市">高雄市</option>
                              <option value="屏東縣">屏東縣</option>
                              <option value="臺東縣">臺東縣</option>
                              <option value="花蓮縣">花蓮縣</option>
                              <option value="宜蘭縣">宜蘭縣</option>
                              <option value="澎湖縣">澎湖縣</option>
                              <option value="金門縣">金門縣</option>
                              <option value="連江縣">連江縣</option>
                            </select>
                              <select onChange="areachange(this.form)" name="cityarea">
                                <option value="中正區" selected="selected">中正區</option>
                                <option value="大同區">大同區</option>
                                <option value="中山區">中山區</option>
                                <option value="松山區">松山區</option>
                                <option value="大安區">大安區</option>
                                <option value="萬華區">萬華區</option>
                                <option value="信義區">信義區</option>
                                <option value="士林區">士林區</option>
                                <option value="北投區">北投區</option>
                                <option value="內湖區">內湖區</option>
                                <option value="南港區">南港區</option>
                                <option value="文山區">文山區</option>
                              </select>
                           <input type="hidden" value="100" name="Mcode" />
                           <input name="cuszip" value="100" size="5" maxlength="5" readonly="readOnly" />
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">詳細地址：</td>
          <td align="left" class="board_add"><span class="bs">
            <input name="cusadr" type="text" id="cusadr" value="" size="60" />
          <span class="font_red">* </span></span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">驗證碼：</td>
          <td align="left" class="board_add">
          <label for="captcha">
				<input type="text" name="captcha" class="input required" style="width:80px;">
				<img src="getcode.php" id="getcode" alt="看不清楚，點擊換一張" align="absmiddle" style="cursor:pointer"  height="35">
          </label>
          &nbsp;
          <input name="recaptcha" type="hidden" id="recaptcha" value="<? echo $_SESSION['captcha_code']?>" />
          (點擊可換一張圖)</td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="center"><label>
            <!--<input type="submit" name="button" id="button" value="送出資料" />
            <input type="reset" name="button2" id="button2" value="重設" />-->
            <input name="date" type="hidden" id="date" value="<? echo date("Y-m-d H:i:s");?>" />
            <input name="orderPaper" type="hidden" id="orderPaper" value="N" />
			<input class="submit" type="submit" value="送出資料">
          </label></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="memberadd" />
    </form>
    <? }else{//否則顯示另依個區塊內容?>
    <div align="center"><img src="images/memberAdderr.gif"></div>
    <? }?>

  <div id="main4"></div>
<?php include("footer.php"); ?>
	<!--<form class="cmxform" id="signupForm" method="get" action="">
		<fieldset>
			<legend>Validating a complete form</legend>
			<p>
				<label for="uname">姓名：</label>
				<input id="uname" name="uname" type="text">
			</p>
			<p>
				<label for="username">帳號：</label>
				<input id="username" name="username" type="text">
			</p>
			<p>
				<label for="password">密碼：</label>
				<input id="password" name="password" type="password">
			</p>
			<p>
				<label for="repassword">確認密碼：</label>
				<input id="repassword" name="repassword" type="password">
			</p>
			<p>
				<label for="id">身分證字號：</label>
				<input id="id" name="id" type="text">
			</p>
			<p>
				<label for="email">Email</label>
				<input id="email" name="email" type="text">
			</p>
			<p>
				<label for="sex">性別：</label>
				<input name="sex" type="radio" id="radio" value="男" checked="checked" /> 男
				<input type="radio" name="sex" id="radio2" value="女" /> 女
				<input name="orderPaper" type="checkbox" id="orderPaper" value="Y" checked="checked" /> 訂閱電子報
			</p>
			<p>
				<label for="phone">電話：</label>
				<input id="phone" name="phone" type="text">
			</p>
			<p>
				<label for="phone">驗證碼：</label>
				<input type="text" name="captcha" class="input required" style="width:80px;">
				<img src="getcode.php" id="getcode" alt="看不清，点击换一张" align="absmiddle" style="cursor:pointer">
			</p>
			<p>
				<label for="agree">Please agree to our policy</label>
				<input type="checkbox" class="checkbox" id="agree" name="agree">
			</p>
			<p>
				<label for="newsletter">I'd like to receive the newsletter</label>
				<input type="checkbox" class="checkbox" id="newsletter" name="newsletter">
			</p>
			<fieldset id="newsletter_topics">
				<legend>Topics (select at least two) - note: would be hidden when newsletter isn't selected, but is visible here for the demo</legend>
				<label for="topic_marketflash">
					<input type="checkbox" id="topic_marketflash" value="marketflash" name="topic">Marketflash
				</label>
				<label for="topic_fuzz">
					<input type="checkbox" id="topic_fuzz" value="fuzz" name="topic">Latest fuzz
				</label>
				<label for="topic_digester">
					<input type="checkbox" id="topic_digester" value="digester" name="topic">Mailing list digester
				</label>
				<label for="topic" class="error">Please select at least two topics you'd like to receive.</label>
			</fieldset>
			<p>
				<input class="submit" type="submit" value="Submit">
			</p>
		</fieldset>
	</form>-->
</div>
</body>
</html>
