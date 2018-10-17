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
            $get_exam_uesr_sql = sprintf("SELECT * FROM examinee,examinee_pic,check_review WHERE examinee.examyear_id = %s and examinee.no = examinee_pic.examinee_no and examinee.no = check_review.examinee_sn and apply_mk = '1' and check_review.verify_name3 is not NULL and check_review.verify_name4 is NULL and first_trial = 'NO' ORDER BY check_review.update_time DESC", GetSQLValueString($examyear_id, "text"));
        break;
        case 4://複審二審
            $_SESSION['check']['check_type']=4;
            $str_exam_user="複審二審";
            $get_exam_uesr_sql = sprintf("SELECT * FROM examinee,examinee_pic,check_review WHERE examinee.examyear_id = %s and examinee.no = examinee_pic.examinee_no and examinee.no = check_review.examinee_sn and apply_mk = '1' and check_review.verify_name4 is not NULL and check_review.verify_name5 is NULL and first_trial = 'NO' ORDER BY check_review.update_time DESC", GetSQLValueString($examyear_id, "text"));
        break;
        case 5://會後審查
            $_SESSION['check']['check_type']=5;
            $str_exam_user="會後審查";
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

    if($_GET['sent_mail'] == 'Y'){
        require_once('PHPMailer/class.phpmailer.php');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->Username = "ckassessment@gmail.com";
        $mail->Password = "assessmentck";
        $mail->FromName = "ck系統管理員";
        $webmaster_email = "ckassessment@gmail.com";

        $mail->CharSet = "utf8";
        // $email=$_POST['email'];// 收件者信箱
        // $name=$_POST['username'];// 收件者的名稱or暱稱

        $email='bb42064206@gmail.com';// 收件者信箱
        $name='test1';// 收件者的名稱or暱稱

        $mail->From = $webmaster_email;
        $mail->AddAddress($email,$name);
        $mail->AddReplyTo($webmaster_email,"Squall.f");
        $mail->WordWrap = 50;//每50行斷一次行
        //$mail->AddAttachment("/XXX.rar");
        // 附加檔案可以用這種語法(記得把上一行的//去掉)

        $mail->IsHTML(true); // send as HTML
        $subject="國民小學教師學科知能評量通知";
        $mail->Subject = $subject; // 信件標題

        $body="親愛的考生您好，由於您上傳的大頭照未符合規定，請重新上傳正確的大頭照，以免影響考試權益，謝謝；<br />
           <br />
           如有任何問題歡迎與我們聯絡，謝謝!!<br />
           any problem，you can touch us，thank you!!";
        $mail->Body = $body;//信件內容(html版，就是可以有html標籤的如粗體、斜體之類)
        $mail->AltBody = $body; //信件內容(純文字版)

        if(!$mail->Send()){
        echo "寄信發生錯誤：" . $mail->ErrorInfo;//如果有錯誤會印出原因
         }
        else{
        echo "寄信成功";
            }
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
                <button class="button1 btn1" onclick="javascript:location.href='review_list.php?check_type=5'">會後審查</button>
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
                        <td><?PHP echo $exam_uesr[$key][update_time]; ?></td>
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
