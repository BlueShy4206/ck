<?php require_once('login_check.php'); ?>
<?
header("Cache-control:private");//解決session 引起的回上一頁表單被清空
?>
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
//自訂變數$password記錄password隱藏欄位傳送過來的已加密舊密碼
$password=$_POST["password"];
//如果新密碼passwordNew與舊密碼passwordOld輸入欄位都不是空的，執行下列動作
if($_POST["passwordNew"]!="" && $_POST["passwordOld"]!=""){
	  //將使用者輸入的舊密碼passwordOld欄位資料md5加密，與原本已加密舊密碼比較
	  if(md5($_POST["passwordOld"])==$password){
	     //如果上述相同，變數$password就變更，改為記錄md5加密的passwordNew
		 $password=md5($_POST["passwordNew"]);
	  }
	}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {

	
  $updateSQL = sprintf("UPDATE member SET password=%s, uname=%s, sex=%s, birthday=%s, email=%s, orderPaper=%s, phone=%s, Area=%s, cityarea=%s, cuszip=%s, cusadr=%s, eng_uname=%s, uid=%s WHERE id=%s",
                       GetSQLValueString( $password , "text"),
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['birthday'], "date"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString(isset($_POST['orderPaper']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['Area'], "text"),
                       GetSQLValueString($_POST['cityarea'], "text"),
                       GetSQLValueString($_POST['cuszip'], "text"),
                       GetSQLValueString($_POST['cusadr'], "text"),
  					   GetSQLValueString($_POST['eng_uname'], "text"),
  					   GetSQLValueString($_POST['uid'], "text"),
  					   GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());


  mysql_select_db($database_conn_web, $conn_web);
  $query_web_allguide = sprintf("SELECT * FROM allguide WHERE up_no='MH'");
  $web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
  $row_web_allguide = mysql_fetch_assoc($web_allguide);
  
  $MailHost = $row_web_allguide['note'];
  
  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $updateGoTo));
  header("Location:$MailHost/EasyMVC/Home/queryList/$_POST[id]");
}

$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_web_member = sprintf("SELECT * FROM member WHERE username = %s", GetSQLValueString($colname_web_member, "text"));
$web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_member);
$totalRows_web_member = mysql_num_rows($web_member);

?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>會員資料更新</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="會員資料更新" />
<meta name="keywords" content="會員資料更新" />
<meta name="author" content="" />
<link href="web.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery.js"></script>
	<script src="js/jquery.validate.js"></script>
<script language=javascript src="address.js"></script><!--引入郵遞區號.js檔案-->
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<script>
	$.validator.setDefaults({
		submitHandler: function() {
			//alert("submitted!");
			//$('#signupForm').submit(function(){
			$(this).ajaxSubmit({
				type:"post",
				url:"memberUpdate.php",
				beforeSubmit:showRequest,
				success:showResponse
			});
			return false; //此處必須返回false，阻止常規的form提交
		//});
		}
	});
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
	
	//驗證
	$().ready(function() {
		// validate the comment form when it is submitted
		$("#commentForm").validate();

		// validate signup form on keyup and submit
		$("#form3").validate({
			rules: {
				//email: "required",
				phone: "required",
				
				Student_ID: {
					required: true,
					minlength: 4
				},
				Department: {
					required: true,
					minlength: 4
				},
				email: {
					required: true,
					email: true,
					uniqueEmail: false
				},	
				cusadr: {
					required: true,
					minlength: 5,
				},	
				birthday: {
					required: true,
					minlength: 10,
				},	
				phone: {
					required: true,
					minlength: 8,
				},	
				certificate: {
					required: true,
					minlength: 5,
				},	
				school: {
					required: true,
					minlength: 4,
				},	
				Highest: {
					required: true,
					minlength: 4,
				},	
				contact: {
					required: true,
					minlength: 2,
				},	
				contact_ph: {
					required: true,
					minlength: 8,
				},	
				news_pic: {
					required: true,
					minlength: 1,
				},																																				
				agree: "required"
			},
			//錯誤訊息
			messages: {
				Student_ID: {
					required: "請檢查學號欄位",
					minlength: "學號輸入請勿少於4個字元"
				},
				Department: {
					required: "請檢查科系欄位",
					minlength: "科系輸入請勿少於4個字元"
				},
				email:{
					required:"請檢查email欄位",
					uniqueEmail: "此Email已經被註冊了"
				},				
				phone: "請檢查電話欄位",
				cusadr: {
					required: "請檢查地址欄位",
					minlength: "請輸入完整地址",
				},
				birthday: {
					required: "請檢查生日欄位",
					minlength: "請檢查格式!",
				},	
				phone: {
					required: "請檢查電話欄位",
					minlength: "請檢查電話欄位",
				},	
				certificate: {
					required: "請檢查教師證號",
					minlength: "請檢查教師證號",
				},	
				school: {
					required: "請檢查學校欄位",
					minlength: "請檢查學校欄位",
				},	
				Highest: {
					required: "請檢查最高學歷",
					minlength: "請檢查最高學歷",
				},	
				contact: {
					required: "請填入緊急聯絡人姓名",
					minlength: "請填入緊急聯絡人姓名",
				},	
				contact_ph: {
					required: "請填入緊急聯絡人電話",
					minlength: "請填入緊急聯絡人電話",
				},	
				news_pic: {
					required: "請選擇照片",
					minlength: "請選擇照片",
				},				
			}
		});

		// propose username by combining first- and lastname
		
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

<body onload="MM_preloadImages('images/btn_shop1_2.gif','images/btn_shop2_2.gif','images/btn_shop3_2.gif','images/btn_shop4_2.gif','images/btn_shop5_2.gif','images/btn_shop6_2.gif')">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <? include("leftzone.php")?>
  </div>
  <div id="main3" align="center">
    <form id="form3" name="form3" method="POST" enctype="multipart/form-data"  action="<?php echo $editFormAction; ?>">   
      <table width="540" border="0" cellspacing="0" cellpadding="0" background="images/back11_2.gif">
        <tr>
          <td width="25" align="left"><img src="images/board03.gif" /></td>
          <td width="505" align="left" background="images/board04.gif">&nbsp; <span class="font_black">親愛的會員[</span><span class="font_red">&nbsp;<?php echo $row_web_member['username']; ?> &nbsp;</span><span class="font_black">]請由下方編輯您的個人資料~~</span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="540" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="82" height="30" align="right" class="board_add">姓名：</td>
          <td width="458" align="left" class="board_add"><label>
            <?php echo $row_web_member['uname']; ?>
            <input name="uname" type="hidden" id="uname" value="<?php echo $row_web_member['uname']; ?>" />            
          </label></td>
        </tr>
        <tr>
          <td width="82" height="30" align="right" class="board_add">英文姓名：</td>
          <td width="458" align="left" class="board_add"><label>
            <?php //echo $row_web_member['eng_uname']; //開放英文姓名可以修改,update by coway 2017.3.17?>
            <input name="eng_uname" type="text" id="eng_uname" value="<?php echo $row_web_member['eng_uname']; ?>" /> ( 例如：李大同，英文姓名：Li Da Tong )  <?php //if($row_web_member['eng_uname'] =="") echo 'text'; else echo 'hidden';?>           
          </label></td>
        </tr>        
        <tr>
          <td width="82" height="30" align="right" class="board_add">身分證號碼：</td>
          <td width="458" align="left" class="board_add"><label>
            <?php echo $row_web_member['uid']; ?>
            <input name="uid" type="<?php if($row_web_member['uid'] =="" && $row_web_member['EForm_MK'] ==0) echo 'text'; else echo 'hidden';?>" id="uid" value="<?php echo $row_web_member['uid']; ?>" />              
          </label></td>
        </tr>        
        <tr>
          <td height="30" align="right" class="board_add">原密碼：</td>
          <td align="left" class="board_add"><label>
            <input name="passwordOld" type="password" id="passwordOld" size="15" />
            <input name="password" type="hidden" id="password" value="<?php echo $row_web_member['password']; ?>" />
          </label><span class="font_red">如需變更密碼，請先輸入原本密碼!</span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">變更密碼：</td>
          <td align="left" class="board_add"><label>
            <input name="passwordNew" type="password" id="passwordNew" size="15" />
          </label><span class="font_red">如需變更密碼才輸入!</span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">E-mail：</td>
          <td align="left" class="board_add"><label>
            <input name="email" type="<?php if($row_web_member['EForm_MK'] ==0) echo 'text'; else echo 'hidden';?>" id="email" value="<?php echo $row_web_member['email']; ?>" size="35" />
          </label><span class="font_red">* </span><br />
<span class="font_black">請勿使用會檔信的yahoo、pchome信箱，以免收不到註冊信及訂閱之會員電子報。</span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">性別：</td>
          <td align="left" class="board_add"><label>
            <input <?php if (!(strcmp($row_web_member['sex'],"男"))) {echo "checked=\"checked\"";} ?> name="sex" type="radio" id="radio" value="男" checked="checked" />
          男
          <input <?php if (!(strcmp($row_web_member['sex'],"女"))) {echo "checked=\"checked\"";} ?> type="radio" name="sex" id="radio2" value="女" />
          女&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</label>
        <!--   <label>
           <input <?php //if (!(strcmp($row_web_member['orderPaper'],"Y"))) {echo "checked=\"checked\"";} ?> name="orderPaper" type="checkbox" id="orderPaper" />
         </label> 訂閱電子報 -->
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">生日：</td>
          <td align="left" class="board_add"><label>
            <?php if($row_web_member['birthday'] !="0000-00-00") echo $row_web_member['birthday']; ?>
            <input name="birthday" type="<?php if($row_web_member['birthday'] =="0000-00-00") echo 'text'; else echo 'hidden';?>" id="birthday" value="<?php echo $row_web_member['birthday']; ?>" />             
         </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">電話：</td>
          <td align="left" class="board_add"><label>
            <input name="phone" type="text" id="phone" value="<?php echo $row_web_member['phone']; ?>" />
          <span class="font_red">* </span></label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">郵遞區號：</td>
          <td align="left" class="board_add">
                          <select onchange="citychange(this.form)" name="Area">
                            <option value="基隆市" <?php if (!(strcmp("基隆市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>基隆市</option>
                            <option value="臺北市" selected="selected" <?php if (!(strcmp("臺北市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>臺北市</option>
                            <option value="新北市" <?php if (!(strcmp("新北市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>新北市</option>
                            <option value="桃園縣" <?php if (!(strcmp("桃園縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>桃園縣</option>
                            <option value="新竹市" <?php if (!(strcmp("新竹市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>新竹市</option>
                            <option value="新竹縣" <?php if (!(strcmp("新竹縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>新竹縣</option>
                            <option value="苗栗縣" <?php if (!(strcmp("苗栗縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>苗栗縣</option>
                            <option value="臺中市" <?php if (!(strcmp("臺中市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>臺中市</option>
                            <option value="彰化縣" <?php if (!(strcmp("彰化縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>彰化縣</option>
                            <option value="南投縣" <?php if (!(strcmp("南投縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>南投縣</option>
                            <option value="雲林縣" <?php if (!(strcmp("雲林縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>雲林縣</option>
                            <option value="嘉義市" <?php if (!(strcmp("嘉義市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>嘉義市</option>
                            <option value="嘉義縣" <?php if (!(strcmp("嘉義縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>嘉義縣</option>
                            <option value="臺南市" <?php if (!(strcmp("臺南市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>臺南市</option>
                            <option value="高雄市" <?php if (!(strcmp("高雄市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>高雄市</option>
                            <option value="屏東縣" <?php if (!(strcmp("屏東縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>屏東縣</option>
                            <option value="臺東縣" <?php if (!(strcmp("臺東縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>臺東縣</option>
                            <option value="花蓮縣" <?php if (!(strcmp("花蓮縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>花蓮縣</option>
                            <option value="宜蘭縣" <?php if (!(strcmp("宜蘭縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>宜蘭縣</option>
                            <option value="澎湖縣" <?php if (!(strcmp("澎湖縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>澎湖縣</option>
                            <option value="金門縣" <?php if (!(strcmp("金門縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>金門縣</option>
                            <option value="連江縣" <?php if (!(strcmp("連江縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>連江縣</option>
                          </select>
                          <select onchange="areachange(this.form)" name="cityarea">
                                <option value="<?php echo $row_web_member['cityarea']; ?>" selected="selected"><?php echo $row_web_member['cityarea']; ?></option>
                          </select>
                          <input type="hidden" value="100" name="Mcode" />
                          <input name="cuszip" value="<?php echo $row_web_member['cuszip']; ?>" size="5" maxlength="5" readonly="readOnly" />
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">詳細地址：</td>
          <td align="left" class="board_add"><span class="bs">
            <input name="cusadr" type="text" id="cusadr" value="<?php echo $row_web_member['cusadr']; ?>" size="55" />
          <span class="font_red">* </span>          </span></td>
        </tr>
        <tr>
          <td height="40" colspan="2" align="center"><label>
            <input type="submit" name="button" id="button" value="更新資料" />
            <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
            <input name="id" type="hidden" id="id" value="<?php echo $row_web_member['id']; ?>" />
          </label></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form3" />
    </form>
  </div>
  <div id="main4"></div>

<?php include("footer.php"); ?>
</body>
</html>
<?php
mysql_free_result($web_member);
?>
