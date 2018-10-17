
<?php require_once('Connections/conn_web.php');
require_once "PEAR183/HTML/QuickForm.php";
require_once "examAdd_function.php";?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>報名審核</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
<script src="Scripts/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="Scripts/jquery-1.8.3.min.js"></script>
<script src="Scripts/jquery.elevateZoom-3.0.8.min.js"></script>
<link rel="stylesheet" href="Scripts/sweetalert2/dist/sweetalert2.min.css">
<script type="text/javascript">
$(function(){
		$("#pic1").elevateZoom({scrollZoom : true,zoomWindowPosition: 3});
		$("#pic2").elevateZoom({scrollZoom : true,zoomWindowPosition: 3});
		$("#pic3").elevateZoom({scrollZoom : true,zoomWindowPosition: 3});
		$("#pic4").elevateZoom({scrollZoom : true,zoomWindowPosition: 3});
		$("#pic5").elevateZoom({scrollZoom : true,zoomWindowPosition: 3});
		$("#pic6").elevateZoom({scrollZoom : true,zoomWindowPosition: 3});
		$("#pic7").elevateZoom({scrollZoom : true,zoomWindowPosition: 3});
		$("#pic8").elevateZoom({scrollZoom : true,zoomWindowPosition: 3});
		$("#pic9").elevateZoom({scrollZoom : true,zoomWindowPosition: 3});
		$("#pic10").elevateZoom({scrollZoom : true,zoomWindowPosition: 3});
		$("#pic11").elevateZoom({scrollZoom : true,zoomWindowPosition: 3});

//     $('#check_click').bind('click',function(){
// 		var btn_ok = document.getElementsByName("radio_pass")[0].checked;
// 		var btn_no = document.getElementsByName("radio_pass")[1].checked;
// 		if(btn_ok == false && btn_no == false){
// 			console.log("NO");
// 		}else{
// 			console.log("OK");
// 		}
//     });
});
	function SaveAlert(){
		var btn_ok = document.getElementsByName("radio_pass")[0].checked;
		var btn_no = document.getElementsByName("radio_pass")[1].checked;
		if(btn_ok == false && btn_no == false){

				swal({
					position: 'top-end',
					type: 'error',
					title: '尚未選擇是否通過',
					showConfirmButton: false,
					timer: 1000,
					width: 400
			  	})
				window.event.returnValue=false;

		}
	};

	function Enter_msg(addmsg){

		document.getElementById('review_msg').value=document.getElementById('review_msg').value+addmsg;

	};

	function review_over(){
		swal({
			  title: '審核完畢',
			  type: 'success',
			  confirmButtonText: '確定!'
			}).then((result) => {
			  if (result.value) {
			    document.location.href="review_list.php";
			  }
			})
	}


</script>
<style>
		#qreport {
			padding: 10px;
			border-radius: 1rem;
			box-shadow: 0 0 1em black;
			background-color: #FFFFFF;

		}
		/* 渐变 color1 - color2 - color1 */

		hr.style-one {
		    border: 0;
		    height: 1px;
		    background: #333;
		    background-image: linear-gradient(to right, #ccc, #333, #ccc);
		}

		/* 透明渐变 - color - transparent */

		hr.style-two {
		    border: 0;
		    height: 1px;
		    background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
		}

		/* 双线 */

		hr.style-three {
		    border: 0;
		    border-bottom: 1px dashed #ccc;
		    background: #999;
		}

		/* 单线阴影 */

		hr.style-four {
		    height: 12px;
		    border: 0;
		    box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);
		}

		/* 云朵状 */

		hr.style-five {
		    border: 0;
		    height: 0; /* Firefox... */
		    box-shadow: 0 0 10px 1px black;
		}
		hr.style-five:after {  /* Not really supposed to work, but does */
		    content: "\00a0";  /* Prevent margin collapse */
		}

		/* 内嵌 */

		hr.style-six {
		    border: 0;
		    height: 0;
		    border-top: 1px solid rgba(0, 0, 0, 0.1);
		    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
		}

		/* 晕状 */

		hr.style-seven {
		    height: 30px;
		    border-style: solid;
		    border-color: black;
		    border-width: 1px 0 0 0;
		    border-radius: 20px;
		}
		hr.style-seven:before {
		    display: block;
		    content: "";
		    height: 30px;
		    margin-top: -31px;
		    border-style: solid;
		    border-color: black;
		    border-width: 0 0 1px 0;
		    border-radius: 20px;
		}

		/* 文字插入式 */

		hr.style-eight {
		    padding: 0;
		    border: none;
		    border-top: medium double #333;
		    color: #333;
		    text-align: center;
    		margin-top: 10px;
			margin-bottom: 10px;

		}
		hr.style-eight:after {
		    content: "gb";
		    display: inline-block;
		    position: relative;
		    top: -0.7em;
		    font-size: 1.5em;
		    padding: 0 0.25em;
		    background: white;
		}

		/* 分隔线统一样式 */
		hr{
		  margin: 40px 0;
		}

</style>

</head>
<body  background="images/background.jpg">
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

// mysql_select_db($database_conn_web, $conn_web);
//$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s ORDER BY SUBSTR( id, 3, 4 ) DESC , SUBSTR( id, 2, 9 ) DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"));
//update by coway 2016.8.11
// $query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s ORDER BY no DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"));
// $web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
// $row_web_examinee = mysql_fetch_assoc($web_examinee);
// $totalRows_web_member = mysql_num_rows($web_examinee);
if($_SESSION['check'][level] == '1'){
	$pname = $picname;
	$button_review_msg=['照片不符,','缺在職證明書,','缺申請應考切結書,'];
	$sql_id='IDt';
}else if($_SESSION['check'][level] == '0'){
	$pname = $picname_t;
	$button_review_msg=['照片不符,','缺學生證,','缺修畢師資職前教育證明書,'];
	$sql_id='ID';
}
if($_SESSION['check']['end_list']==""){
	$_SESSION['check']['end_list'] = array();
}
if (in_array($_POST['check_no'], $_SESSION['check']['end_list'])) {
	header(sprintf("Location: %s", "review_list.php"));
}else{
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
		$upload_file= "";
		foreach($_POST["upload_file"] as $value ){
			$upload_file =$upload_file.$value.',';
		}
			$user_info=getuserinfo($_POST['check_no'],$database_conn_web, $conn_web);
			if($user_info[result1] == "" && $user_info[verify_name1] == "" && $_SESSION['check']['check_type'] == 1){
				//未第一次審核
				mysql_select_db($database_conn_web, $conn_web);
				$query_web_examinee = sprintf("UPDATE `check_review` SET `verify_name1`=%s,`result1`=%s,`explanation1`=%s, `review_message`= %s, `upload_file` = %s where `examinee_sn`=%s",
				 GetSQLValueString($colname_web_member, "text"), GetSQLValueString($_POST[radio_pass], "text"), GetSQLValueString($_POST[review_msg], "text"),
				GetSQLValueString($_POST[review_message], "text"), GetSQLValueString($upload_file, "text"), GetSQLValueString($_POST[check_no], "text"));
				$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
				$row_web_examinee = mysql_fetch_assoc($web_examinee);
				$totalRows_web_examinee = mysql_num_rows($web_examinee);
			}elseif($user_info[result2] == "" && $user_info[verify_name2] == "" && $_SESSION['check']['check_type'] == 1){
				//未第二次審核
				if($user_info[result1] == "OK" && $_POST[radio_pass] == "OK"){
					$first_trial = "OK";
				}else{
					$first_trial = "NO";
				}
				mysql_select_db($database_conn_web, $conn_web);
				$query_web_examinee = sprintf("UPDATE `check_review` SET `verify_name2`=%s,`result2`=%s,`explanation2`=%s, `review_message`= %s, `first_trial` = %s, `upload_file` = %s where `examinee_sn`=%s",
				 GetSQLValueString($colname_web_member, "text"), GetSQLValueString($_POST[radio_pass], "text"), GetSQLValueString($_POST[review_msg], "text"),
				 GetSQLValueString($_POST[review_message], "text"), GetSQLValueString($first_trial, "text"), GetSQLValueString($upload_file, "text"), GetSQLValueString($_POST[check_no], "text"));
				$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
				$row_web_examinee = mysql_fetch_assoc($web_examinee);
				$totalRows_web_examinee = mysql_num_rows($web_examinee);
			}elseif($user_info[result3] == "" && $user_info[verify_name3] == "" && $user_info[first_trial] == "NO" && $_SESSION['check']['check_type'] == 2){
				//未第三次審核
				mysql_select_db($database_conn_web, $conn_web);
				$query_web_examinee = sprintf("UPDATE `check_review` SET `verify_name3`=%s,`result3`=%s,`explanation3`=%s, `review_message`= %s, `first_trial` = %s, `upload_file` = %s where `examinee_sn`=%s",
				 GetSQLValueString($colname_web_member, "text"), GetSQLValueString($_POST[radio_pass], "text"), GetSQLValueString($_POST[review_msg], "text"),
				GetSQLValueString($_POST[review_message], "text"), GetSQLValueString($_POST[radio_pass], "text"), GetSQLValueString($upload_file, "text"), GetSQLValueString($_POST[check_no], "text"));
				$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
				$row_web_examinee = mysql_fetch_assoc($web_examinee);
				$totalRows_web_examinee = mysql_num_rows($web_examinee);
			}elseif($user_info[result4] == "" && $user_info[verify_name4] == "" && $user_info[first_trial] == "NO"  && $_SESSION['check']['check_type'] == 3){
				//未第一次複審
				mysql_select_db($database_conn_web, $conn_web);
				$query_web_examinee = sprintf("UPDATE `check_review` SET `verify_name4`=%s,`result4`=%s,`explanation4`=%s, `review_message`= %s, `upload_file` = %s where `examinee_sn`=%s",
				 GetSQLValueString($colname_web_member, "text"), GetSQLValueString($_POST[radio_pass], "text"), GetSQLValueString($_POST[review_msg], "text"),
				GetSQLValueString($_POST[review_message], "text"), GetSQLValueString($upload_file, "text"), GetSQLValueString($_POST[check_no], "text"));
				$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
				$row_web_examinee = mysql_fetch_assoc($web_examinee);
				$totalRows_web_examinee = mysql_num_rows($web_examinee);
			}elseif($user_info[result5] == "" && $user_info[verify_name5] == "" && $user_info[first_trial] == "NO" && $_SESSION['check']['check_type'] == 4){
				//未第二次複審
				mysql_select_db($database_conn_web, $conn_web);
				$query_web_examinee = sprintf("UPDATE `check_review` SET `verify_name5`=%s,`result5`=%s,`explanation5`=%s, `review_message`= %s, `final_trial` = %s, `upload_file` = %s where `examinee_sn`=%s",
				GetSQLValueString($colname_web_member, "text"), GetSQLValueString($_POST[radio_pass], "text"), GetSQLValueString($_POST[review_msg], "text"),
				GetSQLValueString($_POST[review_message], "text"), GetSQLValueString($_POST[radio_pass], "text"), GetSQLValueString($upload_file, "text"), GetSQLValueString($_POST[check_no], "text"));
				$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
				$row_web_examinee = mysql_fetch_assoc($web_examinee);
				$totalRows_web_examinee = mysql_num_rows($web_examinee);
			}elseif($user_info[result6] == "" && $user_info[verify_name6] == "" && $user_info[first_trial] == "NO" && $_SESSION['check']['check_type'] == 5){
				//最後會議後修改
				mysql_select_db($database_conn_web, $conn_web);
				$query_web_examinee = sprintf("UPDATE `check_review` SET `verify_name6`=%s,`result6`=%s,`explanation6`=%s, `review_message`= %s, `final_trial` = %s, `upload_file` = %s where `examinee_sn`=%s",
				GetSQLValueString($colname_web_member, "text"), GetSQLValueString($_POST[radio_pass], "text"), GetSQLValueString($_POST[review_msg], "text"),
				GetSQLValueString($_POST[review_message], "text"), GetSQLValueString($_POST[radio_pass], "text"), GetSQLValueString($upload_file, "text"), GetSQLValueString($_POST[check_no], "text"));
				$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
				$row_web_examinee = mysql_fetch_assoc($web_examinee);
				$totalRows_web_examinee = mysql_num_rows($web_examinee);
			}elseif($_SESSION['check']['check_type'] == 'edit'){
				mysql_select_db($database_conn_web, $conn_web);
				$query_web_examinee = sprintf("UPDATE `check_review` SET `review_message`= %s, `upload_file` = %s where `examinee_sn`=%s",
				GetSQLValueString($_POST[review_message], "text"), GetSQLValueString($upload_file, "text"), GetSQLValueString($_POST[check_no], "text"));
				$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
				$row_web_examinee = mysql_fetch_assoc($web_examinee);
				$totalRows_web_examinee = mysql_num_rows($web_examinee);
			}
			array_push($_SESSION['check']['end_list'],$_POST['check_no']);
	}
}
//判斷點選名字近來 只修改結果與補件資料
if($_GET["edit_no"] != ""){
	$_SESSION['check']['check_type'] = 'edit';
	$_SESSION['check']['check_list'] = [$_GET["edit_no"],0];
}

//抽出一個sn
$no = array_shift($_SESSION['check']['check_list']);
// if(empty($no)){echo "+++++";}
// echo "0";
if(empty($no)){
	// echo ".";
	echo '<script>review_over();</script>';
}
$todayyear=$row_web_new['times'].substr(($row_web_new['endday']),0,4);//第幾次+西元年
$row_web_examinee=getuserinfo($no,$database_conn_web, $conn_web);
// echo $colname_web_member;

//一、二審時二審已被審過
if($_SESSION['check']['check_type'] == 1 && $row_web_examinee[result2] != ""){
	header('Location:review.php');
}

//取得報考資格_流水號 ,add by coway 2016.8.25
$cert_number= sprintf("%s-%s",$row_web_examinee['cert_no'],sprintf("%04d", $row_web_examinee['cert_id']));

//取得學歷資料 ,add by coway 2016.8.19
$degreeArray = array($row_web_examinee['Edu_level4']=>array($row_web_examinee['Other2'],$row_web_examinee['Other2_dept'],$row_web_examinee['Edu_MK4'],$row_web_examinee['Other2_college']),
		$row_web_examinee['Edu_level']=>array($row_web_examinee['Highest'],$row_web_examinee['Department'],$row_web_examinee['Edu_MK'],$row_web_examinee['High_college']),
		$row_web_examinee['Edu_level2']=>array($row_web_examinee['Sec_highest'],$row_web_examinee['Sec_dept'],$row_web_examinee['Edu_MK2'],$row_web_examinee['Sec_college']),
		$row_web_examinee['Edu_level3']=>array($row_web_examinee['Other1'],$row_web_examinee['Other1_dept'],$row_web_examinee['Edu_MK3'],$row_web_examinee['Other1_college'])

);
// print_r($degreeArray);

//取得報考資格 add by coway 2016.8.18
mysql_select_db($database_conn_web, $conn_web);
$query_web_allguideC = sprintf("SELECT * FROM allguide WHERE up_no=%s and no=%s " , GetSQLValueString($sql_id, "text"), GetSQLValueString($row_web_examinee['cert_no'], "text"));
$web_allguideC = mysql_query($query_web_allguideC, $conn_web) or die(mysql_error());
$row_web_allguideC = mysql_fetch_assoc($web_allguideC);


if($row_web_examinee["status"] == '0'){
	$up_no ='EA2';
}else $up_no ='EA';

$arrcheck_box = explode(",",$row_web_examinee["upload_file"]);
mysql_select_db($database_conn_web, $conn_web);
$query_web_allguide = sprintf("SELECT * FROM allguide Where up_no= %s AND nm= %s AND data2= %s", GetSQLValueString($up_no, "text"),GetSQLValueString($row_web_examinee['exarea'], "text"), GetSQLValueString($row_web_examinee['exarea_note'], "text"));
$web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
$row_allguide = mysql_fetch_assoc($web_allguide);



function getStatus($value){
	IF(isset($value)){
		IF ($value =="1"){
			$status_leve="已畢業";
		}elseif ($value =="0") $status_leve="就學中";
	}
	return $status_leve;
}

function getuserinfo($no,$database_conn_web, $conn_web){
	mysql_select_db($database_conn_web, $conn_web);
	$query_web_examinee = sprintf("SELECT * FROM examinee,examinee_pic,check_review WHERE examinee.no = %s and examinee.no = examinee_pic.examinee_no and examinee.no = check_review.examinee_sn ORDER BY DATE DESC", GetSQLValueString($no, "text"));
	$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
	$row_web_examinee = mysql_fetch_assoc($web_examinee);
	$totalRows_web_examinee = mysql_num_rows($web_examinee);
	return $row_web_examinee;
}



?>
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>

<div id="exam" align="left">
	<div id="qreport" style="width: 380px;height: 620px;position:fixed ;left: 71%;z-index:1;top: 100px;" >
		<div style="height: 290px;">
			<div style="height: 90px;font-size: 18px;">
				<?PHP
					if($row_web_examinee[verify_name1] != "" && $row_web_examinee[result1] !=""){
						if($row_web_examinee[result1]=='OK'){
							$pass_message1 ='<p style="display: inline;color: blue;">通過</p>';
						}elseif($row_web_examinee[result1]=='NO'){
							$pass_message1 ='<p style="display: inline;color: red;">不通過</p>';
						}
						echo "$row_web_examinee[verify_name1]: $pass_message1";
						if($row_web_examinee[explanation1] != ""){
							echo "($row_web_examinee[explanation1])";
						}
						echo "<br>";
						if($row_web_examinee[verify_name2] != "" && $row_web_examinee[result2] !=""){
							if($row_web_examinee[result2]=='OK'){
								$pass_message2 ='<p style="display: inline;color: blue;">通過</p>';
							}elseif($row_web_examinee[result2]=='NO'){
								$pass_message2 ='<p style="display: inline;color: red;">不通過</p>';
							}
							echo "$row_web_examinee[verify_name2]: $pass_message2";
							if($row_web_examinee[explanation2] != ""){
								echo "($row_web_examinee[explanation2])";
							}
							echo "<br>";
							if($row_web_examinee[verify_name3] != "" && $row_web_examinee[result3] !=""){
								if($row_web_examinee[result3]=='OK'){
									$pass_message3 ='<p style="display: inline;color: blue;">通過</p>';
								}elseif($row_web_examinee[result3]=='NO'){
									$pass_message3 ='<p style="display: inline;color: red;">不通過</p>';
								}
								echo "$row_web_examinee[verify_name3]: $pass_message3";
								if($row_web_examinee[explanation3] != ""){
									echo "($row_web_examinee[explanation3])";
								}
								echo "<br>";
								// if($row_web_examinee[verify_name4] != "" && $row_web_examinee[result4] !=""){
								// 	if($row_web_examinee[result4]=='OK'){
								// 		$pass_message4 ='<p style="display: inline;color: blue;">通過</p>';
								// 	}elseif($row_web_examinee[result4]=='NO'){
								// 		$pass_message4 ='<p style="display: inline;color: red;">不通過</p>';
								// 	}
								// 	echo "$row_web_examinee[verify_name4]: $pass_message4";
								// 	if($row_web_examinee[explanation4] != ""){
								// 		echo "($row_web_examinee[explanation4])";
								// 	}
								// 	echo "<br>";
								// }
							}
						}
					}
				?>
			</div>
			<div style="font-size: 18px;">
				<?php
					echo "初審結果：$row_web_examinee[first_trial]";
				?>
			</div>
			<?php if($row_web_examinee[first_trial]=='NO'){ ?>
			<hr class="style-eight">
			<div style="font-size: 18px;">
				<?php
					// echo "複審結果：$row_web_examinee[first_trial]";
					if($row_web_examinee[verify_name4] != "" && $row_web_examinee[result4] !=""){
						if($row_web_examinee[result4]=='OK'){
							$pass_message4 ='<p style="display: inline;color: blue;">通過</p>';
						}elseif($row_web_examinee[result4]=='NO'){
							$pass_message4 ='<p style="display: inline;color: red;">不通過</p>';
						}
						echo "$row_web_examinee[verify_name4]:$pass_message4";
						if($row_web_examinee[explanation4] != ""){
							echo "($row_web_examinee[explanation4])";
						}
						echo "<br>";
						if($row_web_examinee[verify_name6] != "" && $row_web_examinee[result6] !=""){
							if($row_web_examinee[result6]=='OK'){
								$pass_message6 ='<p style="display: inline;color: blue;">通過</p>';
							}elseif($row_web_examinee[result6]=='NO'){
								$pass_message6 ='<p style="display: inline;color: red;">不通過</p>';
							}
							echo "$row_web_examinee[verify_name6]: $pass_message6";
							if($row_web_examinee[explanation6] != ""){
								echo "($row_web_examinee[explanation6])";
							}
							echo "<br>";
						}
					}
				?>
			</div>
		<?php } ?>
			<hr class="style-eight">
			<div style="font-size: 18px;">
				<?php
					echo "審查結果：";
					if($row_web_examinee[final_trial] == ""){
						$final = $row_web_examinee[first_trial];
					}else{
						$final = $row_web_examinee[final_trial];
					}
					if($final == "OK"){
						?><p style="display: inline;color: blue;">通過</p><?php
					}elseif($final == "NO") {
						?><p style="display: inline;color: red;">不通過</p><?php
					}
				?>
			</div>
		</div>
		<form id="form3" name="form3" method="post"  action="review.php" >
			<div style="height: 283px;background-color: #d5d8d9;font-size: 18px;padding-left: 5px;padding-top: 5px;border-right-width: 5px;padding-right: 5px;padding-bottom: 5px;">
				你的審查結果：<br>
				<label><input type="radio" name="radio_pass" value="OK" style="height: 16px;width: 16px;" onkeypress="if (event.keyCode == 13) {return false;}"><p style="display: inline;color: blue;">通過</p></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<label style="padding-left: 15px;"><input type="radio" name="radio_pass" value="NO" style="height: 16px;width: 16px;" onkeypress="if (event.keyCode == 13) {return false;}"><p style="display: inline;color: red;">不通過</p></label><br>
				<input type="text" name="review_msg" id="review_msg" style="width: 370px;" onkeypress="if (event.keyCode == 13) {return false;}" /><br>
				<input type="button" class="btn06" id="btn2canvas" onclick="Enter_msg('<?PHP echo $button_review_msg[0];?>')" value="<?PHP echo $button_review_msg[0];?>" style="box-shadow: 0 0 1px black;flex:1;" />
				<input type="button" class="btn06" id="btn2canvas" onclick="Enter_msg('<?PHP echo $button_review_msg[1];?>')" value="<?PHP echo $button_review_msg[1];?>" style="box-shadow: 0 0 1px black;flex:1;" />
				<input type="button" class="btn06" id="btn2canvas" onclick="Enter_msg('<?PHP echo $button_review_msg[2];?>')" value="<?PHP echo $button_review_msg[2];?>" style="box-shadow: 0 0 1px black;flex:1;" />
				<br>最終審查結果：<br>
				<textarea cols="50" rows="5" name="review_message" onkeypress="if (event.keyCode == 13) {return false;}"><?PHP echo $row_web_examinee[review_message]; ?></textarea>
				<label><input type="checkbox" id="upload_file" name="upload_file[]" value="1" /><?php echo $pname[1]; ?></label>
				<label><input type="checkbox" id="upload_file" name="upload_file[]" value="2" /><?php echo $pname[2]; ?></label><br>
				<label><input type="checkbox" id="upload_file" name="upload_file[]" value="3" /><?php echo $pname[3]; ?></label>
				<label><input type="checkbox" id="upload_file" name="upload_file[]" value="4" /><?php if($pname['4n']==""){echo $pname['4'];}else{echo $pname['4n'];} ?></label><br>
				<label><input type="checkbox" id="upload_file" name="upload_file[]" value="5" /><?php echo $pname[5]; ?></label>
				<label><input type="checkbox" id="upload_file" name="upload_file[]" value="6" /><?php echo $pname[6]; ?></label><br>
				<label><input type="checkbox" id="upload_file" name="upload_file[]" value="hpic" /><?php echo $pname[hpic]; ?></label>
				<label><input type="checkbox" id="upload_file" name="upload_file[]" value="rename" /><?php echo $pname[rename]; ?></label>
			</div>
			<input type="hidden" name="MM_update" value="form3" />
			<input type="hidden" name="check_id" value=<?PHP echo $row_web_examinee[uid] ?> />
			<input type="hidden" name="check_no" value=<?PHP echo $row_web_examinee[no] ?> />
		 	<div>
				<table>
				<tr>
					<td>
						<a href="review.php">下一個</a>
					</td>
					<td style="width: 298px;" align="center">
						<?PHP
						if($_SESSION['check']['check_type']=='1' || $_SESSION['check']['check_type']=='2' || $_SESSION['check']['check_type']=='3' || $_SESSION['check']['check_type']=='4' || $_SESSION['check']['check_type'] == 'edit'){
							?>
						<input type="submit"  id="check_click" value="確認" onclick="SaveAlert();" style="box-shadow: 0 0 1px black;flex:1;" />
						<?PHP }?>
					</td>
					<td>
						<a href="review_list.php">離開</a>
					</td>
				</tr>
	</table>
			</div>
</form>
	  </div>


    <table width="770" border="0" cellspacing="0" cellpadding="0" >
        <tr>
          <td width="25" align="left"><img src="images/board03.gif" /></td>
          <td width="505" align="left" background="images/board04.gif">報名審核</td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="770" border="0" cellspacing="0" cellpadding="2">
        <tr>
        <td width="110" height="30" align="right" class="board_add">姓名：</td>
          <td width="180" align="left" class="board_add"><?php echo $row_web_examinee['uname'];
		   if($row_web_examinee['eng_uname']!=""){
			  list($firstname, $lastname, $lastname2) = explode(" ", $row_web_examinee['eng_uname']);
			  if($firstname !=""){
			   	$eng_name="$firstname, $lastname $lastname2";

			  }
			   echo "<br>".$eng_name;//$row_web_examinee['eng_uname'];
		  }?></td>
          <td width="140" height="130" align="center" class="board_add"  rowspan="4"><img src="images/examinee/<?php echo $row_web_examinee['pic_name']; ?>" alt="" name="pic" width="100" id="pic" /></tr>
          <tr>
          <td height="30" align="right" class="board_add">性別：</td>
          <td align="left" class="board_add"><?php if (!(strcmp($row_web_examinee['sex'],"男"))) {echo "男";}
		  if (!(strcmp($row_web_examinee['sex'],"女"))) {echo "女";}
		   ?> </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">出生年月日：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['birthday']; ?></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">身分證字號：</td>
          <td align="left" class="board_add">
          <p><?php echo $row_web_examinee['per_id']; ?>
          </td>
        </tr>
        <!-- <tr>
           <td height="30" align="right" class="board_add">身份：</td>
          <td align="left" class="board_add">
          <?php if($row_web_examinee['status'] == '0') echo "國民小學師資類科師資生";
          		if($row_web_examinee['status'] == '1') echo "現職專任教師";
          ?></td>
           <td height="30" align="right" class="board_add"></td>
        </tr>-->
        <?php if($row_web_examinee['certificate'] != ""){ ?>
        <tr>
        <td height="30" align="right" class="board_add">教師證號碼：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['certificate']; ?></td>
           <td height="30" align="right" class="board_add"></td>
        </tr>
        <?php }?>
        <tr>
          <td height="30" align="right" class="board_add">E-mail：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['email']; ?></td>
           <td height="30" align="right" class="board_add"></td>
        </tr>
        <tr>
            <td height="30" align="right" class="board_add">聯絡電話：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['phone']; ?></td>
          <td height="30" align="right" class="board_add"></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add">通訊地址：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['cuszip'];  echo $row_web_examinee['cusadr']; ?></td>
          <td height="30" align="right" class="board_add"></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><?php if($row_web_examinee['status'] == '1') echo "任職學校："; else echo "就讀學校："; ?><br></td>
          <td align="left" class="board_add">
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
		  ?>
		  <?php if($row_web_examinee['status'] == '1') echo $row_web_examinee['school']; ?>
          </td>
          <td height="30" align="right" class="board_add"></td>
        </tr>
		<tr>
          <td height="30" align="right" class="board_add">就讀科系：<br></td>
          <td align="left" class="board_add">
          <?php if($row_web_examinee[Department] != ""){echo $row_web_examinee[Department];}
		  ?>
          </td>
          <td height="30" align="right" class="board_add"></td>
        </tr>
        <?php if($degreeArray[4][0] != ""){ //if($row_web_examinee['Other1'] != ""){
        		$status_leve=getStatus($row_web_examinee['Edu_MK']);
        		$status_leve2=getStatus($row_web_examinee['Edu_MK2']);

        	?>
        <tr>
          <td height="30" align="right" class="board_add">博士學歷：</td>
          <td align="left" class="board_add"><?php echo $degreeArray[4][0].'('.getStatus($degreeArray[4][2]).')'; ?><br>
			<?php echo $degreeArray[4][3]." ".$degreeArray[4][1]; ?></td>
        <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>
<!--         <tr>
        <td width="10" align="left" class="board_add"><input type="checkbox" name="chk[]" style="WIDTH: 20px; HEIGHT: 20px"></input></td>
           <td height="30" align="right" class="board_add">學院與科系：</td>
          <td align="left" class="board_add"><?php //echo $row_web_examinee['High_college']." ".$row_web_examinee['Department']; ?></td>
           <td height="30" align="right" class="board_add"></td>
         </tr> -->
        <?php if($degreeArray[3][0] != ""){//if($row_web_examinee['Sec_highest'] != ""){ ?>
        <tr>
          <td height="30" align="right" class="board_add">碩士學歷：</td>
          <td align="left" class="board_add"><?php echo $degreeArray[3][0].'('.getStatus($degreeArray[3][2]).')'; ?><br>
			<?php echo $degreeArray[3][3]." ".$degreeArray[3][1]; ?></td>
        <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>
        <?php //if($row_web_examinee['Sec_dept'] != ""){ ?>
<!--         <tr>
                 <td width="10" align="left" class="board_add"><input type="checkbox" name="chk[]" style="WIDTH: 20px; HEIGHT: 20px"></input></td>
           <td height="30" align="right" class="board_add">學院與科系：</td>
          <td align="left" class="board_add"><?php //echo $row_web_examinee['Sec_college']." ".$row_web_examinee['Sec_dept']; ?></td>
         <td height="30" align="right" class="board_add"></td>
        </tr>-->  <?php// } ?>
        <?php if($degreeArray[2][0] != ""){//if($row_web_examinee['Highest'] != ""){ ?>
        <tr>
            <td height="30" align="right" class="board_add">學士學歷：</td>
          <td align="left" class="board_add"><?php echo $degreeArray[2][0].'('.getStatus($degreeArray[2][2]).')'; ?><br>
			<?php echo $degreeArray[2][3]." ".$degreeArray[2][1]; ?></td>
        <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>
        <?php if($degreeArray[1][0] != ""){//if($row_web_examinee['Other2'] != ""){ ?>
        <tr>
          <td height="30" align="right" class="board_add">大專學歷：</td>
          <td align="left" class="board_add"><?php echo $degreeArray[1][0].'('.getStatus($degreeArray[1][2]).')'; ?><br>
			<?php echo $degreeArray[1][3]." ".$degreeArray[1][1]; ?></td>
        <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>
        <?php if($row_web_examinee['Student_ID'] != ""){ ?>
        <tr>
          <td height="30" align="right" class="board_add">學號：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['Student_ID']; ?></td>
        <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>

        <?php if($row_web_examinee['Grade']!=""){ ?>
        <tr>
          <td height="30" align="right" class="board_add">年級：</td>
          <td align="left" class="board_add"><?php if (!(strcmp($row_web_examinee['Grade'],"1"))) {echo "大一";}
		  if (!(strcmp($row_web_examinee['Grade'],"2"))) {echo "大二";}
		  if (!(strcmp($row_web_examinee['Grade'],"3"))) {echo "大三";}
		  if (!(strcmp($row_web_examinee['Grade'],"4"))) {echo "大四";}
		  if (!(strcmp($row_web_examinee['Grade'],"5"))) {echo "大五以上";}
		  if (!(strcmp($row_web_examinee['Grade'],"6"))) {echo "研究所";}
		  if (!(strcmp($row_web_examinee['Grade'],"7"))) {echo "研究所";}		   ?></td>
          <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>
        <?php if($row_web_examinee['cert_no']!=""){ ?><!-- add by coway 2016.8.9 -->
        <tr>
          <td height="30" align="right" class="board_add">報考資格：</td>
          <td align="left" class="board_add" colspan="2"><?php echo $row_web_allguideC['nm'];
		  ?></td>
          <!-- <td height="30" align="right" class="board_add"></td> -->
        </tr>  <?php } ?>
        <tr>
          <td height="30" align="right" class="board_add">報名領域：</td>
          <td align="left" class="board_add"><?php $str=split("," , $row_web_examinee['category']);
			foreach ($str as $val){
			if (!(strcmp($val,"1"))) {echo "國語領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"2"))) {echo "數學領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"3"))) {echo "社會領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"4"))) {echo "自然領域";}} ?></td>
		<td height="30" align="right" class="board_add"></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><?php
//           		$event="required onchange=\"ShowMsg(this,'$todayyear')\"";
//           		// Create the Element
// 				$sel =& $form->addElement('hierselect', 'exarea', '',$event);
				?>
          	評量考區：</td>
          <td align="left" class="board_add">
          <?php echo $row_allguide['note']." ， ".$row_allguide['data1'];?>
	  </td>
           <td height="30" align="right" class="board_add"></td>
        </tr>
      <?php if($row_web_examinee['contact'] != ""){ ?>
        <tr>
          <td height="30" align="right" class="board_add">緊急聯絡人：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['contact']; ?></td>
          <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>
        <?php if($row_web_examinee['contact_ph']!=""){ ?>
        <tr>
        <td height="30" align="right" class="board_add">緊急聯絡人電話：</td>
          <td align="left" class="board_add"><?php echo $row_web_examinee['contact_ph']; ?></td>
          <td height="30" align="right" class="board_add"></td>
        </tr>  <?php } ?>

				<!-- 顯示上傳照片 BlueS 20180307  -->
				<?php
				if(null !== $row_web_examinee[pic1_name]){?>
					<tr>
	        <td width="20" height="30" align="right" class="board_add"><?PHP echo $pname[1]; ?>：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic1_name']; ?>" alt="" name="pic" width="200" id="pic1" data-zoom-image="images/examinee/id_check/<?php echo $row_web_examinee['pic1_name']; ?>" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_web_examinee[pic2_name]){?>
					<tr>
	          <td width="20" height="30" align="right" class="board_add"><?PHP echo $pname[2]; ?>：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic2_name']; ?>" alt="" name="pic" width="200" id="pic2" data-zoom-image="images/examinee/id_check/<?php echo $row_web_examinee['pic2_name']; ?>" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_web_examinee[pic3_name]){?>
					<tr>
	          <td width="20" height="30" align="right" class="board_add"><?PHP echo $pname[3]; ?>：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic3_name']; ?>" alt="" name="pic" width="200" id="pic3" data-zoom-image="images/examinee/id_check/<?php echo $row_web_examinee['pic3_name']; ?>" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_web_examinee[pic4_name]){?>
					<tr>
	         <td width="20" height="30" align="right" class="board_add"><?PHP echo $pname[4]; ?>：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic4_name']; ?>" alt="" name="pic" width="200" id="pic4" data-zoom-image="images/examinee/id_check/<?php echo $row_web_examinee['pic4_name']; ?>" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_web_examinee[pic5_name]){?>
					<tr>
	         <td width="20" height="30" align="right" class="board_add"><?PHP echo $pname[5]; ?>：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic5_name']; ?>" alt="" name="pic" width="200" id="pic5" data-zoom-image="images/examinee/id_check/<?php echo $row_web_examinee['pic5_name']; ?>"  /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_web_examinee[pic6_name]){?>
					<tr>

			  <td width="20" height="30" align="right" class="board_add"><?PHP echo $pname[6]; ?>：</td>
			  <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic6_name']; ?>" alt="" name="pic" width="200" id="pic6" data-zoom-image="images/examinee/id_check/<?php echo $row_web_examinee['pic6_name']; ?>" /></td>
			<td height="30" align="right" class="board_add"></td>
			</tr>
				<?php }

				if(null !== $row_web_examinee[pic7_name]){?>
					<tr>

			  <td width="20" height="30" align="right" class="board_add"><?PHP echo $pname[7]; ?>：</td>
			  <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_web_examinee['pic7_name']; ?>" alt="" name="pic" width="200" id="pic7" data-zoom-image="images/examinee/id_check/<?php echo $row_web_examinee['pic7_name']; ?>" /></td>
			<td height="30" align="right" class="board_add"></td>
			</tr>
				<?php }
				if(null !== $row_web_examinee[special_pic_name1]){?>
					<tr>
	         <td width="20" height="30" align="right" class="board_add"><?PHP echo $pname['sp1']; ?>：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_web_examinee['special_pic_name1']; ?>" alt="" name="pic" width="200" id="pic8" data-zoom-image="images/examinee/id_check/<?php echo $row_web_examinee['special_pic_name1']; ?>" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_web_examinee[special_pic_name2]){?>
					<tr>
          <td width="20" height="30" align="right" class="board_add"><?PHP echo $pname['sp2']; ?>：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_web_examinee['special_pic_name2']; ?>" alt="" name="pic" width="200" id="pic9" data-zoom-image="images/examinee/id_check/<?php echo $row_web_examinee['special_pic_name2']; ?>" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_web_examinee[special_pic_name3]){?>
					<tr>
	          <td width="20" height="30" align="right" class="board_add"><?PHP echo $pname['sp3']; ?>：</td>
	          <td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_web_examinee['special_pic_name3']; ?>" alt="" name="pic" width="200" id="pic10" data-zoom-image="images/examinee/id_check/<?php echo $row_web_examinee['special_pic_name3']; ?>" /></td>
	        <td height="30" align="right" class="board_add"></td>
	        </tr>
				<?php }
				if(null !== $row_web_examinee[rename_pic_name]){?>
					<tr>
						<td width="20" height="30" align="right" class="board_add"><?PHP echo $pname['rename']; ?>：</td>
						<td align="left" class="board_add"><img src="images/examinee/id_check/<?php echo $row_web_examinee['rename_pic_name']; ?>" alt="" name="pic" width="200" id="pic11" data-zoom-image="images/examinee/id_check/<?php echo $row_web_examinee['rename_pic_name']; ?>" /></td>
					<td height="30" align="right" class="board_add"></td>
					</tr>
				<?php }
?>
				<!--  -->

        <tr>
          <!-- <td height="40" colspan="3" align="center"><label>
            <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
          </label></td> -->

        </tr>
      </table>

  </div>
  <div id="main4"></div>

<?php //include("footer.php");
foreach ($arrcheck_box as $key => $value) {
	if($value == '1'){ echo '<script>$("input[type=checkbox]")[0].checked = true;</script>';}
	if($value == '2'){ echo '<script>$("input[type=checkbox]")[1].checked = true;</script>';}
	if($value == '3'){ echo '<script>$("input[type=checkbox]")[2].checked = true;</script>';}
	if($value == '4'){ echo '<script>$("input[type=checkbox]")[3].checked = true;</script>';}
	if($value == '5'){ echo '<script>$("input[type=checkbox]")[4].checked = true;</script>';}
	if($value == '6'){ echo '<script>$("input[type=checkbox]")[5].checked = true;</script>';}
	if($value == 'hpic'){ echo '<script>$("input[type=checkbox]")[6].checked = true;</script>';}
	if($value == 'rename'){ echo '<script>$("input[type=checkbox]")[7].checked = true;</script>';}
}
?>
</div>

</body>
</html>
