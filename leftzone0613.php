<style>
A:hover{color:#ff0000; position:relative;top:3px;left:3px}
</style>
<?php require_once('Connections/conn_web.php'); ?>
<? $originUrl=$_SERVER["HTTP_REFERER"];?>
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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="epaperOrder.php";
  $loginUsername = $_POST['orderemail'];
  $LoginRS__query = sprintf("SELECT email FROM member WHERE email=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_conn_web, $conn_web);
  $LoginRS=mysql_query($LoginRS__query, $conn_web) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    //修改如下，解決電子報訂閱區被include()載入引用的錯誤
    echo("<script language='javascript'>location.href='".$MM_dupKeyRedirect."'</script>");
	//header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "epaperOder")) {
  $insertSQL = sprintf("INSERT INTO member (email) VALUES (%s)",
                       GetSQLValueString($_POST['orderemail'], "text"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());

  $insertGoTo = "epaperOrder.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
   //修改如下，解決電子報訂閱區被include()載入引用的錯誤
   echo("<script language='javascript'>location.href='".$insertGoTo."'</script>");
  //header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['uCheck'])) {
  $loginUsername=$_POST['uCheck'];
  $password=md5($_POST['pCheck']);
  $MM_fldUserAuthorization = "level";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "index.php?loginerror=1";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_conn_web, $conn_web);
//通用密碼
  // if($_POST['pCheck']=='9998'){
  //   $LoginRS__query=sprintf("SELECT id, username, password, level, EForm_MK FROM member WHERE username=%s ",
  //   GetSQLValueString($loginUsername, "text"));
  //   $LoginRS = mysql_query($LoginRS__query, $conn_web) or die(mysql_error());
  //   $loginFoundUser = mysql_num_rows($LoginRS);
  // }else{
  $LoginRS__query=sprintf("SELECT id, username, password, level, EForm_MK FROM member WHERE username=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));
  $LoginRS = mysql_query($LoginRS__query, $conn_web) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  // }

  if ($loginFoundUser) {

    $loginStrGroup  = mysql_result($LoginRS,0,'level');//登入者的層級:admin,member
    $loginStrType = mysql_result($LoginRS,0,'EForm_MK');//登入者的類型:老師,師資生
    $loginStrId = mysql_result($LoginRS,0,'id');//登入者的ID //add by coway 2016.8.31

    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
    $_SESSION['MM_UserType'] = $loginStrType;
    $_SESSION['MM_UserId'] = $loginStrId;  //add by coway 2016.8.31

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
    }

    //修改如下，解決會員登入區被include()載入引用的錯誤
    echo("<script language='javascript'>location.href='".$originUrl."'</script>");
	//header("Location: " . $MM_redirectLoginSuccess );

  }
  else {
    //修改如下，解決會員登入區被include()載入引用的錯誤
    echo("<script language='javascript'>location.href='".$MM_redirectLoginFailed."'</script>");
	//header("Location: ". $MM_redirectLoginFailed );
  }
}

//定義變數
$publishDate='15-07-15'; //簡章公告日期

?>
 <script type="text/javascript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function YY_checkform() { //v4.66
//copyright (c)1998,2002 Yaromat.com
  var args = YY_checkform.arguments; var myDot=true; var myV=''; var myErr='';var addErr=false;var myReq;
  for (var i=1; i<args.length;i=i+4){
    if (args[i+1].charAt(0)=='#'){myReq=true; args[i+1]=args[i+1].substring(1);}else{myReq=false}
    var myObj = MM_findObj(args[i].replace(/\[\d+\]/ig,""));
    myV=myObj.value;
    if (myObj.type=='text'||myObj.type=='password'||myObj.type=='hidden'){
      if (myReq&&myObj.value.length==0){addErr=true}
      if ((myV.length>0)&&(args[i+2]==1)){ //fromto
        var myMa=args[i+1].split('_');if(isNaN(myV)||myV<myMa[0]/1||myV > myMa[1]/1){addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==2)){
          var rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-z]{2,4}$");if(!rx.test(myV))addErr=true;
      } else if ((myV.length>0)&&(args[i+2]==3)){ // date
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);
        if(myAt){
          var myD=(myAt[myMa[1]])?myAt[myMa[1]]:1; var myM=myAt[myMa[2]]-1; var myY=myAt[myMa[3]];
          var myDate=new Date(myY,myM,myD);
          if(myDate.getFullYear()!=myY||myDate.getDate()!=myD||myDate.getMonth()!=myM){addErr=true};
        }else{addErr=true}
      } else if ((myV.length>0)&&(args[i+2]==4)){ // time
        var myMa=args[i+1].split("#"); var myAt=myV.match(myMa[0]);if(!myAt){addErr=true}
      } else if (myV.length>0&&args[i+2]==5){ // check this 2
            var myObj1 = MM_findObj(args[i+1].replace(/\[\d+\]/ig,""));
            if(myObj1.length)myObj1=myObj1[args[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!myObj1.checked){addErr=true}
      } else if (myV.length>0&&args[i+2]==6){ // the same
            var myObj1 = MM_findObj(args[i+1]);
            if(myV!=myObj1.value){addErr=true}
      }
    } else
    if (!myObj.type&&myObj.length>0&&myObj[0].type=='radio'){
          var myTest = args[i].match(/(.*)\[(\d+)\].*/i);
          var myObj1=(myObj.length>1)?myObj[myTest[2]]:myObj;
      if (args[i+2]==1&&myObj1&&myObj1.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
      if (args[i+2]==2){
        var myDot=false;
        for(var j=0;j<myObj.length;j++){myDot=myDot||myObj[j].checked}
        if(!myDot){myErr+='* ' +args[i+3]+'\n'}
      }
    } else if (myObj.type=='checkbox'){
      if(args[i+2]==1&&myObj.checked==false){addErr=true}
      if(args[i+2]==2&&myObj.checked&&MM_findObj(args[i+1]).value.length/1==0){addErr=true}
    } else if (myObj.type=='select-one'||myObj.type=='select-multiple'){
      if(args[i+2]==1&&myObj.selectedIndex/1==0){addErr=true}
    }else if (myObj.type=='textarea'){
      if(myV.length<args[i+1]){addErr=true}
    }
    if (addErr){myErr+='* '+args[i+3]+'\n'; addErr=false}
  }
  if (myErr!=''){alert('The required information is incomplete or contains errors:\t\t\t\t\t\n\n'+myErr)}
  document.MM_returnValue = (myErr=='');
}
//-->

	function ShowLink() {
			alert("確認後直接 下載 「知能評量證明書申請書」，並於會員資料補入 中文姓名、英文姓名、出生年月日、身份證字號、E-Mail等資料，謝謝。");
			window.location.href = './file/20150707105802.doc';
	}
	function ShowLink2(){
		alert("確認後直接 下載 「知能評量證明書申請書」，謝謝。");
		window.location.href = './file/20180111064949.doc';//20160325030145,20160830155137
	}
	function ShowLink3(){
		alert("證明書之核發僅限達精熟級之應考人，第一次由中心主動寄發。");//update by coway 2017.1.6
		window.location.href = './file/20180122085512.doc';//20160725033236
	}
	function ShowLink5(){//師資生
		alert("確認後直接 下載 「複查成績申請單」，謝謝。");
		window.location.href = './file/20170111095729.docx';//add by coway 2017.1.12
	}
	function ShowLink6(){//現職教師
		alert("確認後直接 下載 「複查成績申請單」，謝謝。");
		window.location.href = './file/20170119101643.doc';//add by coway 2017.1.19
	}

    </script>

<link href="web.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="js/themes/easyui.css" />
<link rel="stylesheet" type="text/css" href="js/themes/icon.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.easyui.min.js"></script>
<script type="text/javascript" src="js/easyui-lang-zh_TW.js"></script>

	<? if(empty($_SESSION["MM_Username"])){
		if($_GET["link"] == '2' ){ $member_img = 'images/member_region2.png';}
		else $member_img = 'images/member_region.png';
		?>
<table width="184" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td align="center"><img src="<?php echo $member_img;?>" width="184" height="36" /></td>
      </tr>
      <tr> <td height="16" align="center" valign="middle" bgcolor="#FFFFFF"></tr>
      <tr>
        <td align="center" bgcolor="#FFFFFF">
        <form id="memberLogin" name="memberLogin" method="POST" action="<?php echo $loginFormAction; ?>">
        <table width="175" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
          <? if($_GET["loginerror"]!=""){?>
          <tr>
            <td height="20" colspan="3" align="center" valign="middle" bgcolor="#FF0000" class="font_white">帳號或密碼錯誤，請重新登入!!</td>
          </tr>
          <? }?>
          <tr>
            <td width="36" height="20" valign="middle">帳號：</td>
            <td width="78"><label>
              <input name="uCheck" type="text" class="inputstyle1" id="uCheck" value="<?php if(isset($_COOKIE['rmUsername']))echo $_COOKIE['rmUsername'];?>" />
            </label></td>
            <td width="61" rowspan="2" valign="middle"><label>
              <input type="image" name="imageField" id="imageField" src="images/memberzonebtn3.gif" />
            </label></td>
          </tr>
          <tr>
            <td height="20" valign="middle">密碼：</td>
            <td><label>
              <input name="pCheck" type="password" class="inputstyle1" id="pCheck" value="<?php if(isset($_COOKIE['rmPassword']))echo $_COOKIE['rmPassword'];?>" />
            </label></td>
            </tr>
          <tr>
            <td height="20" colspan="3" align="center" valign="middle" bgcolor="#FFFFFF"><label>
              <input name="remember" type="checkbox" id="remember" value="1" />
            </label>記住我的帳號密碼</td>
          </tr>
        </table>
        </form>
        </td>
      </tr>
      <tr>
        <td align="center" height="10" bgcolor="#FFFFFF"><img src="images/memberzone4.gif" width="166" height="2" /></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#FFFFFF"><a href="menberis.php"><img src="images/memberzonebtn1.gif" width="79" height="19" border="0" /></a><a href="memberLostPass.php"><img src="images/memberzonebtn2.gif" width="86" height="19" border="0" /></a></td>
      </tr>
      <tr>
         <td height="10" align="center" valign="middle" bgcolor="#FFFFFF">
      </tr>
    </table>
    <br /><? }else{
    		if($_SESSION['MM_UserType'] =='1'){ $member_img = 'images/member_region2.png';}
    		else $member_img = 'images/member_region.png';?>
    <table width="184" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
      <tr>
        <td align="center" bgcolor="#FFFFFF"><img src="<?php echo $member_img;?>" width="184" height="36" /></td>
      </tr>
      <tr>

        <td height="20" align="center" valign="top" bgcolor="#FFFFFF">親愛的會員<span class="font_red">&nbsp;<?php echo $_SESSION['MM_Username']; ?> &nbsp;&nbsp; &nbsp;</span>您好</td>
      </tr>
      <tr>
        <td align="center" height="10" bgcolor="#FFFFFF"><img src="images/memberzone4.gif" width="166" height="2" /></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#FFFFFF">
        <? if($_SESSION["MM_UserGroup"]=='admin'){?>
        <a href="admin/admin.php"><img src="images/memberzonebtn7.gif" border="0" /></a><br />
        <? }?>
       <?php //<a href="shopcart_myorder.php"><img src="images/memberzonebtn6.gif" border="0" /></a> ?>
        <br /><a href="memberUpdate.php"><img src="images/memberzonebtn4.gif" width="79" height="19" border="0" /></a><a href="logout.php"><img src="images/memberzonebtn5.gif" width="86" height="19" border="0" /></a></td>
      </tr>
      <tr>
        <td><td height="8" align="center" valign="middle" bgcolor="#FFFFFF"></td>
      </tr>
    </table>
    <br /><? }?>
   <? if(isset($_SESSION["cart"])){?>
   <div align="center"> <?PHP //<a href="shopcart_show.php"><img src="images/btn_car1.gif" width="84" height="18" border="0" /></a>?> </div>
    <br />
    <? }?>
<!-- 國小教師連結 -->
    <table width="184" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="184" height="40" align="center" bgcolor="#FFFFFF"><img src="images/exam_information.png" width="184" height="40" onmousemove="tbodyevent2()" /></td>
      </tr>
      <script>
      	function tbodyevent2(){
			//console.log('tbodyevent2');
			tbody_t.style.display='';
			tbody_ts.style.display='none';
		}
      	</script>
      <tr>
        <td height="10" align="center" valign="middle" bgcolor="#FFFFFF">
        </td>
      </tr>
      <tbody id="tbody_t" style="display:none;">
      <tr>
        <td height="67" align="center" valign="middle" bgcolor="#FFFFFF"><?php //if($_SESSION["MM_UserGroup"]=='member'){
		if($_SESSION['MM_Username'] != NULL){
			if($_SESSION['MM_UserType'] =='0'){
					?>
		        <a href="examAdd1.php?id=3"><img src="images/sign_t.png" width="115"  height="67" /></a><br />
		<? }}else{?> <a href="index.php" onclick="alert('請先登入會員，再報名測驗。')">
 <!--<a href="menberis1.php">--><img src="images/sign_t.png" width="115"  height="67" /></a><? }?>
        </td>
      </tr>
      <tr>
        <td height="36" align="center" valign="middle" bgcolor="#FFFFFF" >
        <?php if(date('y-m-d')>= $publishDate){//國小日程表 ./file/20160927221237.pdf?>
          <a href="./file/20180309103058.pdf"><img src="images/106schedule_t.png" /></a>

  		<?php }else { ?> <img src="images/106schedule_t.png" /><? }?>
  		</td>
      <tr>
         <td height="36" align="center" valign="middle" bgcolor="#FFFFFF" >
         <?php if(date('y-m-d')>= $publishDate){//國小報名流程 ./file/20160927221256.pdf?>

           <a href="./file/20180309103047.pdf"><img src="images/flow_t.png"  /></a>


         <?php }else { ?><img src="images/flow_t.png"  /><? }?>
         </td>
       </tr>
  	<? if($_SESSION["MM_UserGroup"]=='member' && $_SESSION['MM_UserType'] =='0'){?>
   		<td height="36" align="center" valign="middle" bgcolor="#FFFFFF" >
            <a href="progress.php?status=1"><img src="images/progress_check_t.png"  /></a> <?php } ?>
		</td>
      </tr>
      <tr>
<?php if($_SESSION["MM_UserGroup"]=='member' && $_SESSION['MM_UserType'] !=""){?>
		<?php if($_SESSION['MM_UserType'] =='0') {?>
		<td height="32" align="center" valign="middle" bgcolor="#FFFFFF">
        <a href="examOutprint.php"><img src="images/print_t.png" /></a>
        </td><?php }?>
      </tr>
      <tr>
        <td height="32" align="center" valign="middle" bgcolor="#FFFFFF">
        <? if($_SESSION['MM_UserType'] =='0'){
      				$showresult='Results2.php?status=1 ';
              // $showresult='Results.php';//改
      				$download='ShowLink2()';
        		}else {$showresult='Results.php';
		        		$download='ShowLink()';}?>

        <a href="<?php echo $showresult;?>"><img src="images/check_t.png" /></a><br /></td></tr>
        <tr>
        <td height="32" align="center" valign="middle" bgcolor="#FFFFFF">
        <a href="duble_check.php?status=1"><img src="images/duble_check_t.png" /></a>
        <!-- <a href="./file/20151120151612.doc"><img src="images/duble_check.png" /></a> -->
      <tr>
        <td height="32" align="center" valign="middle" bgcolor="#FFFFFF">
        <!-- <img src="images/certificate_ok.png" onclick="<?php echo $download?>" />  -->
        <?php }?>
        </td>
      </tr>
      </tbody>
      <tr>
        <td height="10" align="center" valign="middle" bgcolor="#FFFFFF">
        </td>
      </tr>
    </table>
    <br>
<!-- 師資生連結 -->
    <table width="184" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="184" height="40" align="center" bgcolor="#FFFFFF"><img src="images/exam_information3.png" width="184" height="40" onmousemove="tbodyevent()"/></td>
      </tr>
		<script>
      	function tbodyevent(){
			//console.log('tbodyevent');
			tbody_ts.style.display='';
			tbody_t.style.display='none';
		}
      	</script>
      <tr>
        <td height="10" align="center" valign="middle" bgcolor="#FFFFFF">
        </td>
      </tr>
      <tbody id="tbody_ts" style="display:none;">
      <tr>
        <td height="67" align="center" valign="middle" bgcolor="#FFFFFF"><?php //if($_SESSION["MM_UserGroup"]=='member'){
		if($_SESSION['MM_Username'] != NULL){
			if($_SESSION['MM_UserType'] =='0'){
					?>
		        <a href="examAdd.php" ><img src="images/sign.png" width="115"  height="67" /></a><br /><!-- onclick="alert('提醒您：本梯次僅提供在學師資生報名，感謝您。')" -->
		<? }}else{?> <a href="index.php" onclick="alert('請先登入會員，再報名測驗。')">
 <!--<a href="menberis1.php">--><img src="images/sign.png" width="115"  height="67" /></a><? }?>
        </td>
      </tr>
      <tr>
        <td height="36" align="center" valign="middle" bgcolor="#FFFFFF" >
        <?php if(date('y-m-d')>= $publishDate){//師資生日程表?>

          <a href="./file/20180309102843.pdf"><img src="images/106schedule.png" /></a>

  		<?php }else { ?> <img src="images/106schedule.png" /><? }?>
  		</td>
      <tr>
         <td height="36" align="center" valign="middle" bgcolor="#FFFFFF" >
         <?php if(date('y-m-d')>= $publishDate){//師資生報名流程?>

           <a href="./file/20180309102829.pdf"><img src="images/flow.png"  /></a>


         <?php }else { ?><img src="images/flow.png"  /><? }?>
         </td>
      </tr>
  	<? if($_SESSION["MM_UserGroup"]=='member' && $_SESSION['MM_UserType'] =='0'){?>
   		<td height="36" align="center" valign="middle" bgcolor="#FFFFFF" >
            <a href="progress.php?status=0"><img src="images/progress_check.png"  /></a> <?php } ?>
		</td>
      </tr>
      <tr>
<?php if($_SESSION["MM_UserGroup"]=='member' && $_SESSION['MM_UserType'] !=""){?>
		<?php if($_SESSION['MM_UserType'] =='0') {?>
		<td height="32" align="center" valign="middle" bgcolor="#FFFFFF">
        <a href="examOutprint_ts.php"><img src="images/print.png" /></a>
        </td><?php }?>
      </tr>
      <tr>
        <td height="32" align="center" valign="middle" bgcolor="#FFFFFF">
        <? if($_SESSION['MM_UserType'] =='0'){
      				$showresult='Results2.php?status=0 ';
              // $showresult='Results.php';//改
      				$download='ShowLink2()';
        		}else {$showresult='Results.php';
		        		$download='ShowLink()';}?>

        <a href="<?php echo $showresult;?>"><img src="images/check.png" /></a><br /></td></tr>
        <tr>
        <td height="32" align="center" valign="middle" bgcolor="#FFFFFF">
        <a href="duble_check.php?status=0"><img src="images/duble_check.png" /></a>
        <!-- <a href="./file/20151120151612.doc"><img src="images/duble_check.png" /></a> -->
      <tr>
        <td height="32" align="center" valign="middle" bgcolor="#FFFFFF">
        <!-- <img src="images/certificate_ok3.png" onclick="<?php echo $download?>" />  -->
        <?php }?>
        </td>
      </tr>
      <tr>
        <td height="10" align="center" valign="middle" bgcolor="#FFFFFF">
        </td>
      </tr>
      </tbody>
    </table>
<br/>

<!--<a href="./file/20160420145740.pdf"><img src="images/download.gif"></a> --><!-- 國小簡章下載 -->
<img src="images/download.gif" onclick="$('#dlg').dialog('open')">
<div id="dlg" class="easyui-dialog" closed="true" title="簡章下載" style="width:200px;height:150px;padding:10px"
						data-options="
							buttons: [{
								text:'Cancel',
								handler:function(){
									$('#dlg').dialog('close');
								}
							}]
						">

    <a href="./file/20180309100438.pdf" class="easyui-linkbutton" >師資生簡章</a><a href="./file/20180309100452.pdf" class="easyui-linkbutton" >國小教師簡章</a>
</div>
  <?PHP   /*  <form id="shopSearch" name="shopSearch" method="get" action="search.php">
 <table width="180" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="61" rowspan="2" align="right"><img src="images/shopsearch01.gif" width="45" height="43" /></td>
        <td width="98"><img src="images/shopsearch02.gif" width="54" height="21" /></td>
        <td width="21">&nbsp;</td>
      </tr>
      <tr>
        <td><label>
          <input name="keyword" type="text" class="inputstyle2" id="keyword" />
        </label><br /><a href="search_advanced.php">進階搜尋</a></td>
        <td valign="top"><label>
          <input type="image" name="imageField2" id="imageField2" src="images/shopsearchbtn.gif" />
        </label></td>
      </tr>
    </table>
    </form>
   <table width="193" border="0" cellspacing="0" cellpadding="0" background="images/btn_onlineservice.gif">
  <tr>
    <td width="125" height="50">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="26" align="right" valign="top">
<a target="_blank" href="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee=c8bccc1881e1d6da@apps.messenger.live.com&mkt=zh-tw"><img style="border-style: none;" src="http://messenger.services.live.com/users/c8bccc1881e1d6da@apps.messenger.live.com/presenceimage?mkt=zh-tw" width="16" height="16" /></a><img src="images/im_icon_03.gif" width="76" height="16"><a href="http://wowimme.spaces.live.com/" target="_blank"><img src="images/im_icon_04.gif" width="18" height="16" border="0"></a>
    &nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
    <a href="forum.php"><img src="images/btn_forum.gif" width="193" height="76" border="0" /></a><br />
    <form action="<?php echo $editFormAction; ?>" method="POST" name="epaperOder" id="epaperOder" onsubmit="YY_checkform('epaperOder','orderemail','#S','2','訂閱電子報請輸入email');return document.MM_returnValue">
    <table width="193" border="0" cellspacing="0" cellpadding="0" background="images/btn_epaper.gif">
      <tr>
        <td width="129" height="40">&nbsp;</td>
        <td width="64">&nbsp;</td>
      </tr>
      <tr>
        <td height="36" align="right" valign="middle"><label>
          <input name="orderemail" type="text" id="orderemail" size="13" />
        </label></td>
        <td align="left" valign="middle"> &nbsp;
          <input type="submit" name="button" id="button" value="訂閱" />&nbsp;</td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="epaperOder" />
</form>

*/?>
