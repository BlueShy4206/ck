<?php require_once('Connections/conn_web.php');
require_once "PEAR183/HTML/QuickForm.php";?>
<script type="text/javascript" src="Scripts/jquery-2.1.0.min.js"></script>
<script src="Scripts/sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="Scripts/sweetalert2/dist/sweetalert2.min.css">
<style type"text/css">

div.fullScreenTable {
    display:block;
    position:relative;
    width:100%;
    height:100%;
    overflow:hidden;
    float:left;

}
#main3.table tbody, #main3.table thead
{
    display: inline-block;
    table-layout:fixed;
}
#main3.table tbody
{
   overflow: auto;
   height: 250px;
   weight:50%;
}

/* 按鈕 */
.btn1:hover {
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);

}

.button1 {
    background: linear-gradient(to bottom, rgba(180,227,145,1) 0%,rgba(97,196,25,1) 50%,rgba(180,227,145,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    border: none;
    border-radius: 12px;
    color: white;
    padding: 15px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
}

.button2 {
    background: linear-gradient(to bottom, rgba(229,112,231,1) 0%,rgba(200,94,199,1) 47%,rgba(168,73,163,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    border: none;
    border-radius: 12px;
    color: white;
    padding: 15px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
}

.button3 {
    background: linear-gradient(to bottom, rgba(73,192,240,1) 0%,rgba(44,175,227,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    border: none;
    border-radius: 12px;
    color: white;
    padding: 15px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
}

.datatable { width:100%; border-spacing:0px; background:#ededed; margin-bottom:30px;}
.datatable th { text-align:center; font-size:20px; padding:12px 3px; font-weight:normal; border-width:0 0 1px 1px; border-style:solid; border-color:#ededed;
/* background: linear-gradient(90deg, #cff2cb 0%, #9ee0d1 100%);
background: -moz-linear-gradient(90deg, #cff2cb 0%, #9ee0d1 100%);
background: -webkit-linear-gradient(90deg, #cff2cb 0%, #9ee0d1 100%);
background: -o-linear-gradient(90deg, #cff2cb 0%, #9ee0d1 100%);} */
background: rgb(125,185,232); /* Old browsers */
background: -moz-linear-gradient(top, rgba(125,185,232,1) 1%, rgba(125,185,232,1) 1%, rgba(41,137,216,1) 70%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, rgba(125,185,232,1) 1%,rgba(125,185,232,1) 1%,rgba(41,137,216,1) 70%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, rgba(125,185,232,1) 1%,rgba(125,185,232,1) 1%,rgba(41,137,216,1) 70%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */}
.datatable tr { background:#fff;
-webkit-transition: all 0.2s ease-out 0s;
-moz-transition: all 0.2s ease-out 0s;
transition: all 0.2s ease-out 0s; }
.datatable tr:hover {
-webkit-box-shadow:inset 0px 0px 20px 0px rgba(0,0,0,0.1);
-moz-box-shadow:inset 0px 0px 20px 0px rgba(0,0,0,0.1);
box-shadow:inset 0px 0px 20px 0px rgba(0,0,0,0.1);}
.datatable tr:first-child:hover {
-webkit-box-shadow:inset 0px 0px 20px 0px rgba(0,0,0,0);
-moz-box-shadow:inset 0px 0px 20px 0px rgba(0,0,0,0);
box-shadow:inset 0px 0px 20px 0px rgba(0,0,0,0);}
.datatable tr.gray { background:#ededed;}
.datatable td { text-align:center; font-size:19px; padding:12px 3px; border-width:0 0 1px 1px; border-style:solid; border-color:#ededed;}
.datatable th:first-child { border-radius:10px 0 0 0;}
.datatable th:last-child { border-radius:0 10px 0 0;}
.datatable td:last-child, .datatable th:last-child { border-width:0 1px 1px 1px;}
.datatable td i { font-size:24px;}
.datatable td a { text-decoration:underline;}
.datatable td a:hover, .datatable td a:hover i { color:#F10004;}
.datatable td span { display:inline-block; padding-right:6px;}

.datatable-l { min-width:500px; width:100%;}
.datatable-l td img, .datatable td img { max-width:inherit;}
.datatable-l td { text-align:left; padding-left:3px; padding-right:3px;}
.datatable-l td:nth-of-type(1), .datatable-l td:last-child { text-align:center;}
.datatable-l2 td:last-child { text-align:left;}
</style>
<?php

session_start();
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

if($_POST[level] != ""){
    $_SESSION['check'][level] = $_POST[level];

}
$status = $_SESSION['check'][level];
if($status == '1'){ $str_user_level = "現職教師";}
if($status == '0'){ $str_user_level = "師資生";}
// if (isset($_GET['status'])) {
//   $status =$_GET['status'];
// }

$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}

mysql_select_db($database_conn_web, $conn_web);
$get_examyear_id_sql = sprintf("SELECT id FROM `examyear` where status = %s ORDER BY `id` DESC limit 1", GetSQLValueString($status, "text"));
$get_examyear_id = mysql_query($get_examyear_id_sql, $conn_web) or die(mysql_error());
$arr_examyear_id = mysql_fetch_assoc($get_examyear_id);
$examyear_id = $arr_examyear_id[id];
$check_list = array();
$_SESSION['check']['$check_list']="";


// 判斷SQL 要撈那些名單
$check_type = $_GET[check_type];
if($check_type != ""){
    mysql_select_db($database_conn_web, $conn_web);
    switch ($check_type) {
        case 1://1,2審 且不能相同帳號
            $_SESSION['check']['check_type']=1;
            $str_exam_user="一、二審";
            $get_exam_uesr_sql = sprintf("SELECT * FROM examinee,examinee_pic,check_review WHERE examinee.examyear_id = %s and examinee.no = examinee_pic.examinee_no and examinee.no = check_review.examinee_sn and apply_mk = '1' and (check_review.verify_name1 != %s or check_review.verify_name1 is NULL) and check_review.verify_name2 is NULL ORDER BY DATE",
             GetSQLValueString($examyear_id, "text"), GetSQLValueString($colname_web_member, "text"));
            break;
        case 2://3審
            $_SESSION['check']['check_type']=2;
            $str_exam_user="三審";
            $get_exam_uesr_sql = sprintf("SELECT * FROM examinee,examinee_pic,check_review WHERE examinee.examyear_id = %s and examinee.no = examinee_pic.examinee_no and examinee.no = check_review.examinee_sn and apply_mk = '1' and check_review.verify_name3 is NULL and first_trial = 'NO' ORDER BY DATE", GetSQLValueString($examyear_id, "text"));
            break;
        case 3://複審一審
            $_SESSION['check']['check_type']=3;
            $str_exam_user="複審一審";
            $get_exam_uesr_sql = sprintf("SELECT * FROM examinee,examinee_pic,check_review WHERE examinee.examyear_id = %s and examinee.no = examinee_pic.examinee_no and examinee.no = check_review.examinee_sn and apply_mk = '1' and check_review.verify_name3 is not NULL and check_review.verify_name5 is NULL and first_trial = 'NO' ORDER BY check_review.update_time DESC", GetSQLValueString($examyear_id, "text"));
            break;
        case 4://複審二審
            $_SESSION['check']['check_type']=4;
            $str_exam_user="複審二審";
            $get_exam_uesr_sql = sprintf("SELECT * FROM examinee,examinee_pic,check_review WHERE examinee.examyear_id = %s and examinee.no = examinee_pic.examinee_no and examinee.no = check_review.examinee_sn and apply_mk = '1' and check_review.verify_name5 is not NULL and check_review.verify_name6 is NULL and first_trial = 'NO' ORDER BY check_review.update_time DESC", GetSQLValueString($examyear_id, "text"));
            break;
        case 11://初審不通過
            $_SESSION['check']['check_type']=11;
            $str_exam_user="初審不通過";
            $get_exam_uesr_sql = sprintf("SELECT * FROM examinee,examinee_pic,check_review WHERE examinee.examyear_id = %s and examinee.no = examinee_pic.examinee_no and examinee.no = check_review.examinee_sn and apply_mk = '1' and first_trial = 'NO' ORDER BY DATE", GetSQLValueString($examyear_id, "text"));
            break;
        case 12://一二審不通過,最終通過
            $_SESSION['check']['check_type']=12;
            $str_exam_user="一二審不通過";
            $get_exam_uesr_sql = sprintf("SELECT * FROM examinee,examinee_pic,check_review WHERE examinee.examyear_id = %s and examinee.no = examinee_pic.examinee_no and examinee.no = check_review.examinee_sn and apply_mk = '1' and (result1 ='NO' or result2 = 'NO') and first_trial = 'OK' ORDER BY DATE", GetSQLValueString($examyear_id, "text"));
            break;
        case 13://補件二審有更動名單
            $_SESSION['check']['check_type']=13;
            $str_exam_user="補件二審有更動名單";
            $get_exam_uesr_sql = sprintf("SELECT * FROM examinee,examinee_pic,check_review WHERE examinee.examyear_id = %s and examinee.no = examinee_pic.examinee_no and examinee.no = check_review.examinee_sn and apply_mk = '1' and ((result5='OK' and result6='NO') OR (result5='NO' and result6='OK')) ORDER BY DATE", GetSQLValueString($examyear_id, "text"));
            break;
        case 14://複審不通過
            $_SESSION['check']['check_type']=13;
            $str_exam_user="複審不通過";
            $get_exam_uesr_sql = sprintf("SELECT * FROM examinee,examinee_pic,check_review WHERE examinee.examyear_id = %s and examinee.no = examinee_pic.examinee_no and examinee.no = check_review.examinee_sn and apply_mk = '1' and final_trial='NO' ORDER BY DATE", GetSQLValueString($examyear_id, "text"));
            break;
        case all://
            $_SESSION['check']['check_type']='all';
            $str_exam_user="全部名單";
            $get_exam_uesr_sql = sprintf("SELECT * FROM examinee,examinee_pic,check_review WHERE examinee.examyear_id = %s and examinee.no = examinee_pic.examinee_no and examinee.no = check_review.examinee_sn and apply_mk = '1' ORDER BY DATE", GetSQLValueString($examyear_id, "text"));
            break;
    }
    $k=0;

    // echo $get_exam_uesr_sql;
    $get_exam_uesr = mysql_query($get_exam_uesr_sql, $conn_web) or die(mysql_error());
    $count_exam_user = mysql_num_rows($get_exam_uesr);
    while($data = mysql_fetch_array($get_exam_uesr)){
                         $exam_uesr[$k] = $data;
                             array_push($check_list,$data['no']);
                         $k++;

                  }
    $_SESSION['check']['check_list']=$check_list;
}


$maxRows_web_shop = 8;
$pageNum_web_shop = 0;
if (isset($_GET['pageNum_web_shop'])) {
  $pageNum_web_shop = $_GET['pageNum_web_shop'];
}
$startRow_web_shop = $pageNum_web_shop * $maxRows_web_shop;

$_SESSION['check']['end_list']="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>教師專業能力測驗中心</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="國民小學教師學科知能評量" />
<meta name="keywords" content="國民小學教師學科知能評量" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css">
<script type='text/javascript' src='https://code.jquery.com/jquery-3.3.1.js'></script>
<script type="text/javascript">
    function check_upload(stage) {
        if(<?PHP echo $_SESSION['check'][level];?> == 0 ){var level_nm ='師資生';}
        else if (<?PHP echo $_SESSION['check'][level];?> == 1 ){var level_nm ='現職教師';}
        if(stage==1){ var stage_nm = '初審';}
        else if(stage==2){ var stage_nm = '複審';}
        swal({
          title: '您確定要匯入'+level_nm+stage_nm+'嗎?',
          // text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '確定!',
          cancelButtonText: '取消'
        }).then((result) => {
          if (result.value) {
              upload_trial(stage,'<?PHP echo $_SESSION['check'][level];?>');

          }
        })
    }
    function upload_trial(stage,level) {
        // console.log(stage);
    	var i = 0;
        $.ajax({
    				type : "POST" ,
    				url : "ajax_assignment_data.php" ,
    				data :{'type': 1, 'stage' : stage, 'level' : level},
    				dataType:'text',
                    async: false,
    				success: function(returndata){
                        if(returndata>0){
                            swal(
                              '匯入成功',
                              '已成功匯入'+returndata+'筆資料',
                              'question'
                            )
                        }else if(returndata == 0){
                            swal(
                              '匯入失敗',
                              '沒有需要更新的資料',
                              'warning'
                            )
                        }

                        console.log(returndata);
    				},
    				error: function(xhr, ajaxOptions, thrownError){
    					// alert('error...');
    					alert(xhr.status);//0: 请求未初始化
    					alert(thrownError);
    				}
    			});

    }
</script>


<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('table#example').DataTable();
    } );
</script> -->
</head>

<body  background="images/background.jpg">

<div id="wrapper">
<?php
if($_SESSION['MM_UserGroup'] != 'reviewer'){
    ?>
    <script>
    swal({
      title: '操作錯誤！',
      // text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      confirmButtonText: '確定!',
    }).then((result) => {
      if (result.value) {
         document.location.href="https://tl-assessment.ntcu.edu.tw/";
      }
    })
    </script>
<?PHP
}
    include("header.php");
// echo phpinfo();?>
</div>
<div id="main">
    <div id="main1"></div>
        <form id="form3" name="form3" method="post"  action="review_list.php" style="display: inline;">
            <button class="button1 btn1" >師資生</button>
            <input type="hidden" name="level" value="0"/>
        </form>
        <form id="form3" name="form3" method="post"  action="review_list.php" style="display: inline;">
            <button class="button1 btn1">現職老師</button>
            <input type="hidden" name="level" value="1"/>
        </form>
        <table border="1">
        <tr>
            <td>
                初步審查：
            </td>
            <td>
                <button class="button1 btn1" onclick="javascript:location.href='review_list.php?check_type=1'">一、二審</button>
                <button class="button1 btn1" onclick="javascript:location.href='review_list.php?check_type=2'">三審</button>
            </td>
        </tr>
        <tr>
            <td>
                補件名單：
            </td>
            <td>
                <button class="button2 btn1" onclick="javascript:location.href='review_list.php?check_type=11'">初步審核不通過</button>
            </td>
        </tr>
        <tr>
            <td>
                補件審查：
            </td>
            <td>
                <button class="button1 btn1" onclick="javascript:location.href='review_list.php?check_type=3'">複審一審</button>
                <button class="button1 btn1" onclick="javascript:location.href='review_list.php?check_type=4'">複審二審</button>
            </td>
        </tr>
        <tr>
            <td>
                檢核清單：
            </td>
            <td>
                <button class="button2 btn1" onclick="javascript:location.href='review_list.php?check_type=all'">全部</button>
                <button class="button2 btn1" onclick="javascript:location.href='review_list.php?check_type=12'">初步一審或二審不通過，但三審通過名單</button>
                <button class="button2 btn1" onclick="javascript:location.href='review_list.php?check_type=13'">補件二審有更動名單</button>
                <button class="button2 btn1" onclick="javascript:location.href='review_list.php?check_type=14'">複審不通過</button>
            </td>
        </tr>
        <!-- <tr>
            <td>
                會議後審核狀態異動：
            </td>
            <td>
                <button class="button1 btn1" onclick="javascript:location.href='review_list.php?check_type=all'">全部名單</button>
            </td>
        </tr> -->








        </table>
<input type="button" class="button3 btn1" value="開始審查" onclick="location.href='review.php'">
<input type="button" class="button3 btn1" value="匯入初審結果" onclick="check_upload('1')">
<input type="button" class="button3 btn1" value="匯入複審結果" onclick="check_upload('2')">
<div id="main1"></div>
<?PHP if($_POST[level] !="" ){
        if($_POST[level] == '0'){
            $level_nm='師資生';
        }
        if($_POST[level] == '1'){
            $level_nm='現職教師';
        }
        ?>
<p style="font-size: 17px;" id="object_type"><?PHP echo "已選擇：$level_nm"; ?></p>
<?PHP }?>
<?PHP if($check_type != ""){ ?>
  <div style="width: 100%;">
      <p style="font-size: 17px;">選擇狀態：<?PHP echo $str_user_level."\t".$str_exam_user; ?></p>
      <p style="font-size: 17px;">總計:<?PHP echo $count_exam_user; ?>人</p>
      <table  id="example" class="DataTable" style="width:100%">
          <thead>
              <tr>
                  <th>帳號<?PHP echo "<br>"?>姓名</th>
                  <th>身分證</th>
                  <th>審查結果</th>
                  <th>信箱</th>
              </tr>
          </thead>
          <tbody>
              <?PHP
              foreach($exam_uesr as $key => $value){
                  if($value[final_trial] != ""){
                      if($value[final_trial]=="OK"){
                          $trial ='複審：<p style="display: inline;color: blue;">通過</p>';
                      }
                      if($value[final_trial]=="NO"){
                          $trial ='複審：<p style="display: inline;color: red;">不通過</p>';
                      }
                  }else if($value[first_trial] != ""){
                      if($value[first_trial]=="OK"){
                          $trial ='初審：<p style="display: inline;color: blue;">通過</p>';
                      }
                      if($value[first_trial]=="NO"){
                          $trial ='初審：<p style="display: inline;color: red;">不通過</p>';
                      }
                  }else{
                      $trial = '未審核';
                  }
                  ?>
                    <tr>
                        <td><label><a href="review.php?edit_no=<?PHP echo $exam_uesr[$key][no];?> "><?PHP echo $exam_uesr[$key][username]."<br>".$exam_uesr[$key][uname]; ?></a></label></td>
                        <!-- <td><?PHP echo $exam_uesr[$key][uname] ?></td> -->
                        <td><?PHP echo $exam_uesr[$key][per_id]; ?></td>
                        <td><?PHP echo $trial ?></td>
                        <td><img style="width: 43px;" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPgo8cGF0aCBzdHlsZT0iZmlsbDojRkZDRDcxOyIgZD0iTTQ3MC45ODMsMTM1LjMyaC01Ny4xNDFWODAuMjc4bDY5LjQxMSwxNi41NDhsOS4xNiwyLjE4M2M4LjEyNywxLjkzNiwxMi45MiwxMC41ODgsOS44OSwxOC4zNzQgIEM0OTguOTAxLDEyNi4xMjksNDkwLjYzNiwxMzUuMzIsNDcwLjk4MywxMzUuMzJ6Ii8+CjxwYXRoIHN0eWxlPSJmaWxsOiNGRkUxQUE7IiBkPSJNNDgzLjI1Myw5Ni44MjZjLTQuNTgxLDYuNjA5LTEyLjk3NiwxMi4yMDktMjguMzEzLDEyLjIwOWgtNDEuMDk4VjgwLjI3OEw0ODMuMjUzLDk2LjgyNnoiLz4KPHBhdGggc3R5bGU9ImZpbGw6I0YyOTUwMDsiIGQ9Ik00OTMuMTMxLDQzOS41MTJjMCwwLjYwNS0wLjAxLDEuMjExLTAuMDQsMS44MTZjLTAuNDY0LDEyLjA5OC01LjU1LDIzLjAwNi0xMy41NjEsMzEuMDE3ICBjLTguNDA1LDguMzk1LTIwLjAwOSwxMy41OTItMzIuODM0LDEzLjU5Mkg1My45OTNjLTI1LjYzOSwwLTQ2LjQyNS0yMC43NzYtNDYuNDI1LTQ2LjQyNWMwLTEyLjgyNSw1LjE5Ni0yNC40MjksMTMuNjAyLTMyLjgyNCAgYzguMzk1LTguNDA1LDIwLjAwOS0xMy42MDIsMzIuODI0LTEzLjYwMmgzOTIuNzAzQzQ3Mi4zNDUsMzkzLjA4Niw0OTMuMTMxLDQxMy44NzIsNDkzLjEzMSw0MzkuNTEyeiIvPgo8Zz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNGRkE5MEI7IiBkPSJNNDkzLjEzMSw0MzkuNTEyYzAsMC42MDUtMC4wMSwxLjIxMS0wLjA0LDEuODE2SDEwMy4yMTNjLTI1LjYzOSwwLTQ2LjQyNS0yMC43ODYtNDYuNDI1LTQ2LjQyNSAgIGMwLTAuNjA1LDAuMDEtMS4yMTEsMC4wNC0xLjgxNmgzODkuODY3QzQ3Mi4zNDUsMzkzLjA4Niw0OTMuMTMxLDQxMy44NzIsNDkzLjEzMSw0MzkuNTEyeiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6I0ZGQTkwQjsiIGQ9Ik0zODMuNzY4LDExOS4zOEwzODMuNzY4LDExOS4zOGgtNTkuNDQ5bC04LjM5MywxOC44MDNsNjAuMjQzLDY5LjAwNiAgIGMxMy4yNjcsMTUuOTEsMjAuNTMzLDM1Ljk3MSwyMC41MzMsNTYuNjg3djc0LjI1NGg1OS40NDl2LTc0LjI1NGMwLTIwLjcxNi03LjI2Ni00MC43NzctMjAuNTMzLTU2LjY4N2wtMzUuNDM3LTQyLjQ5OSAgIEMzODkuNTc2LDE1MS45NzIsMzgzLjc2OCwxMzUuOTM4LDM4My43NjgsMTE5LjM4eiIvPgo8L2c+CjxwYXRoIHN0eWxlPSJmaWxsOiNGRkI1MkQ7IiBkPSJNNDM2Ljk4OSw5NC43NjhjMCwxMS45OTctMy4wNzgsMjMuMjc4LTguNDc2LDMzLjA4NmMtMTEuNjk1LDIxLjI0LTM0LjI4NywzNS42MjktNjAuMjM5LDM1LjYyOSAgYy0zNy45NDksMC02OC43MDUtMzAuNzY1LTY4LjcwNS02OC43MTVjMC0yNi45MjEsMTUuNDc4LTUwLjIxOSwzOC4wMS02MS40OGM5LjIzMy00LjYyMSwxOS42NTYtNy4yMjUsMzAuNjk1LTcuMjI1ICBDNDA2LjIyNCwyNi4wNjMsNDM2Ljk4OSw1Ni44MTgsNDM2Ljk4OSw5NC43Njh6Ii8+CjxnPgoJPHBhdGggc3R5bGU9ImZpbGw6I0ZGQzE0RjsiIGQ9Ik00MzYuOTg5LDk0Ljc2OGMwLDExLjk5Ny0zLjA3OCwyMy4yNzgtOC40NzYsMzMuMDg2Yy05LjI0Myw0LjYzMS0xOS42NzYsNy4yMzUtMzAuNzE1LDcuMjM1ICAgYy0zNy45NDksMC02OC43MDUtMzAuNzU1LTY4LjcwNS02OC43MDVjMC0xMS45OTcsMy4wNzgtMjMuMjc4LDguNDg2LTMzLjA5NmM5LjIzMy00LjYyMSwxOS42NTYtNy4yMjUsMzAuNjk1LTcuMjI1ICAgQzQwNi4yMjQsMjYuMDYzLDQzNi45ODksNTYuODE4LDQzNi45ODksOTQuNzY4eiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6I0ZGQzE0RjsiIGQ9Ik00OTMuMTMxLDM0Ni42NjFjMCwyNS42MzktMjAuNzg2LDQ2LjQyNS00Ni40MjUsNDYuNDI1SDUzLjk5MyAgIGMtMTIuODE1LDAtMjQuNDI5LTUuMTk2LTMyLjgyNC0xMy42MDJjLTguNDA1LTguMzk1LTEzLjYwMi0xOS45OTktMTMuNjAyLTMyLjgyNHYtODUuMjMyYzAtOS45MTksOC4wNDItMTcuOTYxLDE3Ljk2MS0xNy45NjEgICBjNC4wMzYsMCw3Ljg2LDEuMzUyLDEwLjkzOCwzLjcxM2MyLjI3LDEuNzQ2LDQuMTM3LDQuMDM2LDUuMzc4LDYuNzRsMjEuMjksNDYuMzE0aDM4My41NzFjMTIuODE1LDAsMjQuNDI5LDUuMTk2LDMyLjgyNCwxMy42MDIgICBjNy44Niw3Ljg1LDEyLjkxNSwxOC41MDYsMTMuNTMxLDMwLjM0MUM0OTMuMTExLDM0NS4wMDYsNDkzLjEzMSwzNDUuODM0LDQ5My4xMzEsMzQ2LjY2MXoiLz4KPC9nPgo8cGF0aCBzdHlsZT0iZmlsbDojRkZDRDcxOyIgZD0iTTQ5My4wNjEsMzQ0LjE3OWMtNS4zODgsMi4xOS0xMS4yODEsMy40LTE3LjQ2NiwzLjRIODIuODkxYy0xMi44MTUsMC0yNC40MjktNS4xOTYtMzIuODI0LTEzLjYwMiAgYy04LjQwNS04LjM5NS0xMy42MDItMTkuOTk5LTEzLjYwMi0zMi44MjR2LTUzLjk3M2MyLjI3LDEuNzQ2LDQuMTM3LDQuMDM2LDUuMzc4LDYuNzRsMjEuMjksNDYuMzE0aDM4My41NzEgIGMxMi44MTUsMCwyNC40MjksNS4xOTYsMzIuODI0LDEzLjYwMkM0ODcuMzksMzIxLjY4OCw0OTIuNDQ1LDMzMi4zNDMsNDkzLjA2MSwzNDQuMTc5eiIvPgo8cGF0aCBzdHlsZT0iZmlsbDojRkZEOTkzOyIgZD0iTTM2OC4wNzMsMzQ2Ljk3NGMtMC42NTYsNy44Ni0zLjAzNywxNS43NDEtNy4zNTYsMjMuMTY3Yy03LjQ4NywxMi44ODUtMTYuODYxLDIyLjIwOS0yNi42MzgsMjguOTU5ICBjLTI0LjA1NSwxNi41OTktNTQuODIsMjAuMDI5LTgyLjMwNiwxMC4wN2MtNDEuODQ0LTE1LjE2Ni05NC44MjgtNDguMDA5LTEyNi43MjQtMTEzLjU1NmwtMTQuMzE4LTI5LjQyMyAgYy01Ljc4Mi0xMS44ODYsNC43MTItMjUuMTk1LDE3LjYxOC0yMi4zM2w3LjczOSwxLjcxNWwxODcuODEsNDEuNTgyQzM1Mi41ODQsMjkzLjUxNiwzNzAuMzUzLDMyMC4wNzMsMzY4LjA3MywzNDYuOTc0eiIvPgo8cGF0aCBzdHlsZT0iZmlsbDojRkZFMUFBOyIgZD0iTTM2OC4wNzMsMzQ2Ljk3NGMtNS4yMDcsNi4wMzQtMTAuODc3LDEwLjk0OC0xNi42NzksMTQuOTU0ICBjLTI0LjA1NSwxNi42MDktNTQuODMsMjAuMDI5LTgyLjMxNiwxMC4wN2MtNDEuODM0LTE1LjE1Ni05NC44MjgtNDcuOTk5LTEyNi43MjQtMTEzLjU0NmwtNi4yNjYtMTIuODc1bDE4Ny44MSw0MS41ODIgIEMzNTIuNTg0LDI5My41MTYsMzcwLjM1MywzMjAuMDczLDM2OC4wNzMsMzQ2Ljk3NHoiLz4KPHBhdGggZD0iTTUwMC42OTksMzQ2LjY2MWMwLTIzLjgyMy0xNS41MTktNDQuMTA1LTM2Ljk4MS01MS4yMzhjLTEuMjAyLTIyLjk5LDQuMDAxLTQ0LjEyNS04Ljk2LTcyLjAzNCAgYy0yLjIzLTQuODAzLTguNTA2LTUuOTg0LTEyLjI1LTIuMjRjLTIuMjQsMi4yNC0yLjg1Niw1LjY0LTEuNTI0LDguNTA2YzExLjA4OSwyMy43OCw2LjUyOCw0MS43NjYsNy41OTgsNjMuMDU0ICBjLTEuNDUtMC4wNzEsMC41NDMtMC4wMy00NC4zMTYtMC4wNGMtMi4wMTItMTkuNjUyLDguMTU5LTUyLjI2LTIyLjQtOTAuNDU5bC0yOC40ODUtMzIuNjIyYzEyLjk1MiwyLjU3NCwyNi40NiwxLjc1NSwzOS4wNTktMi40NjIgIGMxLjYzOSwyLjE0MSwxLjExNywxLjQwOCwzMC42NDQsMzYuODZjMi44NTYsMy40MTEsOC4wMjIsMy42NDMsMTEuMTYsMC41MDVsMC4wMS0wLjAxYzIuNzY1LTIuNzY1LDIuOTY3LTcuMTg0LDAuNDU0LTEwLjE5MSAgbC0yOC4wMzEtMzMuNjMxYzcuOTQxLTQuNjQyLDE0Ljk2NC0xMC42NzYsMjAuNzQ2LTE3Ljc2OWg0My41NmMyMi42MTIsMCw0MS4wMTctMTguMzk1LDQxLjAxNy00MS4wMTcgIGMwLTMuNTAxLTIuNDEyLTYuNTQ5LTUuODEyLTcuMzU2bC02My4xNzUtMTUuMDY1Yy03LjExNC0zNC43NDEtMzcuOTE5LTYwLjk1NS03NC43MzktNjAuOTU1Yy00Mi4wNTYsMC03Ni4yNzIsMzQuMjE2LTc2LjI3Miw3Ni4yNzIgIGMwLDIyLjg2NSwxMC4xMSw0My40MDgsMjYuMDgzLDU3LjM5M2w1Mi4zMjgsNTkuOTM2YzEyLjA2OCwxNC41MSwxOC43MTcsMzIuODk0LDE4LjcxNyw1MS43ODN2MjguNzg4aC0zNi44NCAgYy03LjYyOC02LjIzNi0xNi43Mi0xMC42NzUtMjYuNzU5LTEyLjg5NWwtMTA4LjQyLTI0LjAxNWMtNy4wMzQtMS41Ni0xMS45Niw2LjY1Ni03LjU0OCwxMi4xMjkgIGMzLjE1NSwzLjk0NCwxLjY1MiwxLjQ0OSwxMDQuMTgyLDI0Ljc4Mmw4LjUxNiwxLjg4N2MzMi40NDMsNy4xODYsNDguMjg5LDQzLjYzNywzMS45MTUsNzEuNzgyICBjLTIwLjgwMywzNS43ODQtNjIuNzA4LDQ5LjE3NC05OS44MzMsMzUuNzJjLTEwMi41ODMtMzYuNjkyLTEyNy40MjctMTIzLjg5NS0xMzYuODE0LTEzOS4xNzUgIGMtMi43NzItNS43MDIsMS41OTctMTEuODQ2LDcuMzI2LTExLjg0NmMxLjY2NCwwLTEuMDIxLTAuMzU4LDU2LjIxMywxMi4yNWM0LjczMiwxLjA0OSw5LjIxMi0yLjU1Myw5LjIxMi03LjM5NiAgYzAtMy41NzItMi40ODYtNi42Mi01LjkzMy03LjM4NmwtNTQuMzU2LTEyLjAzOGMtMTkuMTA2LTQuMjE1LTM0LjYxNywxNS40NzgtMjYuMDczLDMzLjA0NmwxMS4yNzEsMjMuMTU3SDY3Ljk3OGwtMTkuMjUyLTQxLjkwNSAgYy00LjE1Ny05LjAzMS0xMy4yNTktMTQuODYzLTIzLjE5OC0xNC44NjNDMTEuNDUyLDIzNS45LDAsMjQ3LjM1MywwLDI2MS40Mjl2ODUuMjMyYzAsMTkuODE3LDEwLjcyNiwzNy4xNzMsMjYuNjc5LDQ2LjU1NiAgYy0xNS42OCw5LjI3My0yNi4zNzYsMjYuMDYzLTI2LjY2OSw0NS40NjdjLTAuNDU0LDMwLjE1LDIzLjk0NCw1NC44Miw1My45ODMsNTQuODJoMjg2LjAxOWM0LjE3NywwLDcuNTY4LTMuMzksNy41NjgtNy41NjggIGMwLTQuMTM5LTMuMzY1LTcuNTY4LTcuNTY4LTcuNTY4SDUzLjk5M2MtMjEuNzI0LDAtMzkuMzUyLTE3LjkzLTM4Ljg0OC0zOS43NzZjMC40OTQtMjEuMjIsMTguMzU0LTM3LjkzOSwzOS41NzQtMzcuOTM5aDE1OS45OTEgIGMxMC45NzgsNi4wNzQsMjIuNDkxLDExLjI5MSwzNC40NzgsMTUuNjNjMzIuMjA3LDExLjY1MSw2OC40MTMsNi4zNDMsOTUuNDAzLTE1LjYzaDEwMS4zODdjMjEuMjIsMCwzOS4wOCwxNi43MiwzOS41NzQsMzcuOTM5ICBjMC41MDUsMjEuODQ1LTE3LjEyMywzOS43NzYtMzguODQ4LDM5Ljc3NmgtNzMuOTQxYy00LjE3NywwLTcuNTY4LDMuMzktNy41NjgsNy41NjhjMCw0LjEzOSwzLjM2NSw3LjU2OCw3LjU2OCw3LjU2OGg3My45NDEgIGMzMC4wMzksMCw1NC40MzctMjQuNjcxLDUzLjk4My01NC44MmMtMC4yOTMtMTkuNDA0LTEwLjk4OC0zNi4xOTQtMjYuNjY5LTQ1LjQ2N0M0ODkuOTczLDM4My44MzMsNTAwLjY5OSwzNjYuNDc4LDUwMC42OTksMzQ2LjY2MXogICBNNDQ0LjU1Nyw5NS4zNzNsNTEuNjQyLDEyLjMyYy0yLjY0NCwxMS40ODMtMTIuOTQ2LDIwLjA1OS0yNS4yMTYsMjAuMDU5SDQzNy4wNUM0NDEuNzgyLDExNy45MzUsNDQ0LjQ2NiwxMDYuOTU3LDQ0NC41NTcsOTUuMzczeiAgIE0zNjguMjc0LDMzLjYzMWMyNi45ODEsMCw0OS45MjcsMTcuNTQ3LDU4LjAxOSw0MS44MzRjMTMuMTM5LDM5LjI2LTE2LjI0Nyw4MC40NS01OC4wMTksODAuNDUgIGMtMTUuMDY1LDAtMjguODU4LTUuNDc5LTM5LjUyNC0xNC41NEMyODUuMTU3LDEwNC40MTMsMzExLjk2MiwzMy42MzEsMzY4LjI3NCwzMy42MzF6IE01My45OTMsMzg1LjUxOSAgYy0yMS40MjIsMC0zOC44NTgtMTcuNDI2LTM4Ljg1OC0zOC44NTh2LTg1LjIzMmMwLTExLjA2NSwxNS4xNzgtMTQuNDYyLDE5LjgzNy00LjMzOWwyMS4yOCw0Ni4zMDQgIGMxLjIzMSwyLjY5NCwzLjkyNSw0LjQwOSw2Ljg4Miw0LjQwOWg1OS42NTRjMTYuMzMyLDMwLjMzOCwzOC44MzMsNTYuNjIsNjguMDE4LDc3LjcxNSAgQzE3MC41NzQsMzg1LjUxOSw3My45NTksMzg1LjUxOSw1My45OTMsMzg1LjUxOXogTTQ0Ni43MDYsMzg1LjUxOWMtOS43ODYsMC03Ny4zNzMsMC04Ny4yODEsMCAgYzIwLjg0NS0yNi41MTYsMjAuNzQyLTU1LjAxMiw2LjI4Ni03Ny43MTVjMTMuNjc0LDAsMjQuOTI1LDAsMzguNTU1LDBjMzYuODU3LDEuMTI2LDQ1Ljg2Mi0yLjcwNiw1OS40NTIsMy45MjUgIGMxMi45MjYsNi4zMjcsMjEuODQ1LDE5LjYwNSwyMS44NDUsMzQuOTMyQzQ4NS41NjQsMzY4LjA5Myw0NjguMTI4LDM4NS41MTksNDQ2LjcwNiwzODUuNTE5eiIvPgo8cGF0aCBkPSJNMzkwLjIzNCw4MS41MTZjNC4xOCwwLDcuNTY4LTMuMzg4LDcuNTY4LTcuNTY4cy0zLjM4Ny03LjU2OC03LjU2OC03LjU2OGgtMjEuOTU3Yy00LjE4LDAtNy41NjgsMy4zODgtNy41NjgsNy41NjggIHMzLjM4Nyw3LjU2OCw3LjU2OCw3LjU2OEgzOTAuMjM0eiIvPgo8cGF0aCBkPSJNMjY4LjI5OSwzMTEuODI1bC04NC44ODUtMjguNTczYy0zLjk2LTEuMzM2LTguMjUzLDAuNzk2LTkuNTg3LDQuNzU4Yy0xLjMzMywzLjk2MSwwLjc5Nyw4LjI1Myw0Ljc1OSw5LjU4NiAgYzkwLjA3NywzMC4xNjgsODQuOTY2LDI4Ljk3LDg3LjMwMSwyOC45N0MyNzQuMzk0LDMyNi41NjYsMjc2LjQxOSwzMTQuNTU4LDI2OC4yOTksMzExLjgyNXoiLz4KPHBhdGggZD0iTTIwNy4yMjUsMzM1Ljc2Yy00LjExNS0wLjcyLTguMDM5LDIuMDI5LTguNzYxLDYuMTQ2Yy0wLjcyMiw0LjExNywyLjAyOSw4LjAzOSw2LjE0Niw4Ljc2MWw1OS45NjgsMTAuNTIyICBjNC4xMzMsMC43MjIsOC4wNDEtMi4wNDMsOC43NjEtNi4xNDZjMC43MjItNC4xMTctMi4wMjktOC4wMzktNi4xNDYtOC43NjFMMjA3LjIyNSwzMzUuNzZ6Ii8+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" />
                        </td>
                    </tr>
                    <?php
                    }
                    ?>

    </tbody>
</table>
</div>
<?PHP }?>

</div>
</body>

</html>
<?php
mysql_free_result($web_news);

mysql_free_result($web_banner1);

mysql_free_result($web_banner2);

?>
