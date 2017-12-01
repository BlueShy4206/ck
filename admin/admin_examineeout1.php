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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	 downloadxls();
     //die();
}
function downloadxls(){
//凱迪 版本
/* $query_web_Recordset2 = sprintf("SELECT * FROM examinee WHERE id LIKE %s  ORDER BY id ASC", GetSQLValueString("%" . $_POST['times']. $_POST['startyear'] . "%", "text"));
$web_Recordset2 = mysql_query($query_web_Recordset2);

$totalRows_web_Recordset2 = mysql_num_rows($web_Recordset2);
	
	
$filename="examineeoutput.xls";
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: filename=$filename");
//header("Content-type: application/octetstream");
header("Pragma: no-cache");
header("Expires: 0");


echo "<table border=1px><tr><td>本欄留空</td><td>中文姓名(必填)</td><td>密碼((若不填，由系統決定密碼))</td><td>電子郵件信箱(可留白)</td><td>性別(必填)</td><td>出生年月日(可留白)</td><td>身份證字號(可留白)</td><td>住所電話(可留白)</td><td>手機號碼</td><td>家裡住址(可留白)</td><td>考區</td><td>年級(預設為6)</td><td>班級(預設為1)</td><td>自訂帳號</td></tr>";

for ($i = 0; $i < $totalRows_web_Recordset2; $i++)
{
$row_web_Recordset2 = mysql_fetch_array($web_Recordset2);

echo "<tr><td></td><td>".$row_web_Recordset2['uname']."</td><td>".substr($row_web_Recordset2['per_id'], -4)."</td><td>".$row_web_Recordset2['email']."</td><td>".$row_web_Recordset2['sex']."</td><td>".$row_web_Recordset2['birthday']."</td><td>".$row_web_Recordset2['per_id']."</td><td>".$row_web_Recordset2['phone']."</td><td>".$row_web_Recordset2['phone']."</td><td>".$row_web_Recordset2['cusadr']."</td><td>".$row_web_Recordset2['exarea']."</td><td>".$row_web_Recordset2['Grade']."</td><td></td><td>".$row_web_Recordset2['id']."</td></tr>";
$j=$i+1;
}
echo "</table>"; */

//PHPExcel 套件
		include "./PHPExcel/Classes/PHPExcel.php"; 
		require_once('./PHPExcel/Classes/PHPExcel.php');
		require_once('./PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');
		
		//建立 文件
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$i = 1;
		
		
				
		
			//加入 第一行 
			$objPHPExcel->getActiveSheet()->setCellValue('A1' ,"本欄留空"); 
			$objPHPExcel->getActiveSheet()->setCellValue('B1' ,"中文姓名(必填)"); 
			$objPHPExcel->getActiveSheet()->setCellValue('C1' ,"密碼((若不填，由系統決定密碼))"); 
			$objPHPExcel->getActiveSheet()->setCellValue('D1' ,"電子郵件信箱(可留白)");  
			$objPHPExcel->getActiveSheet()->setCellValue('E1' ,"性別(必填)"); 
			$objPHPExcel->getActiveSheet()->setCellValue('F1' ,"出生年月日(可留白)"); 
			$objPHPExcel->getActiveSheet()->setCellValue('G1' ,"身份證字號(可留白)"); 
			$objPHPExcel->getActiveSheet()->setCellValue('H1' ,"住所電話(可留白)"); 
			$objPHPExcel->getActiveSheet()->setCellValue('I1' ,"手機號碼"); 
			$objPHPExcel->getActiveSheet()->setCellValue('J1' ,"家裡住址(可留白)"); 
			$objPHPExcel->getActiveSheet()->setCellValue('K1' ,"年級(CK為考區)"); 
			$objPHPExcel->getActiveSheet()->setCellValue('L1' ,"班級(預設為1)"); 
			$objPHPExcel->getActiveSheet()->setCellValue('M1' ,"自訂帳號"); 
			$objPHPExcel->getActiveSheet()->setCellValue('N1' ,"考區"); 
						
			$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
		
		
		//撈取資料庫 
		//考場版本
		//$query_web_Recordset2 = "SELECT * FROM examinee WHERE id LIKE '%". $_POST['times'] . $_POST['startyear'] ."%' AND exarea = '". $_POST['exarea'] ."' ORDER BY id";
		
		$query_web_Recordset2 = "SELECT * FROM examinee WHERE id LIKE '%". $_POST['times']. $_POST['startyear'] ."%' AND allow ='Y' AND id_number is not null ORDER BY id";
		
		$result = mysql_query($query_web_Recordset2);

		//寫入資料 excel
		while($row = mysql_fetch_array($result))
		{
			
			$i++;
			
			//007 排版 
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i ,""); //空白
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$i ,$row['uname']); //姓名
			
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i ,substr($row['per_id'], -4)); //密碼
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i ,$row['email']);  //mail
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i ,$row['sex']); //性別
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i ,$row['birthday']); //生日
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$i ,$row['per_id']); //身分證字號
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i ,$row['phone']); //住所電話
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i ,$row['phone']); //手機號碼
			$Ar_city_cu = $row['Area'].$row['cityarea'].$row['cusadr'];
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$i ,$Ar_city_cu); //家裡住址(可留白)
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i ,"6"); //年級(預測為六)
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i ,"1"); //班級(預測為一)
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i ,$row['id_number']); //准考證號碼
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$i ,$row['exarea']); //考區

			
			//007 新版 排版  END 
							
				//行高 設定
				$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(20);
			
			
		}
		
		
		//寬度設定 右邊 為 自動列寬 setAutoSize(true) 不建議使用  
		 $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
		 $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); 
		 $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(32); 
		 $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(35);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
		 
		 require_once('./PHPExcel/Classes/PHPExcel/Writer/Excel5.php');
                $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
				//考場版本
				//$objWriter->save(str_replace('.php', '.xls',  date('Y-n-j').'_stuteach_'.$_POST['exarea'].'.xls'));
				
                $objWriter->save(str_replace('.php', '.xls',  date('Y-n-j').'_stuteach.xls'));
				
				//考場版本
				//header("Location: "."/git/ck/admin/".date('Y-n-j').'_stuteach_'.$_POST['exarea'].'.xls');
				
				header("Location: "."/git/ck/admin/".date('Y-n-j').'_stuteach.xls');




}


mysql_select_db($database_conn_web, $conn_web);
$query_web_new = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);
$totalRows_web_new = mysql_num_rows($web_new);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理後台</title>



<link href="../web.css" rel="stylesheet" type="text/css" />
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
</head>

<body>
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="admin_main2">
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1">
    <table width="540" border="0" cellspacing="0" cellpadding="0" >
     <tr>
        <td width="25" align="left"><img src="../images/board17.gif"/></td>
        <td width="104" align="left" valign="middle" background="../images/board04.gif">&nbsp; <span class="font_black">匯出考生資料</span></td>
        <td width="416" align="left" background="../images/board04.gif"></td>
        <td width="10" align="right"><img src="../images/board05.gif" width="10" height="28" /></td>
      </tr>
    
      <tr>
        <td width="25" align="left"></td>
        <td width="140" align="right">
<div><span class="font_red">管理員</span>您好
 </div>      
        </td>
        <td width="444" align="left">&nbsp;</td>
        
       
      </tr>
    </table>
    <table width="540" border="0" align="center" cellpadding="5" cellspacing="0">
    
      <tr>
        <td width="140" height="20" align="right" class="board_add">最後一次為：</td>
        <td width="405" align="left" class="board_add"><label>
        <?PHP echo substr(($row_web_new['endday']),0,4);?> 年度第 <?php 
		  if (!(strcmp($row_web_new['times'],"A"))) {echo "1";}
		  if (!(strcmp($row_web_new['times'],"B"))) {echo "2";}
		  if (!(strcmp($row_web_new['times'],"C"))) {echo "3";}
		  if (!(strcmp($row_web_new['times'],"D"))) {echo "4";}
		  if (!(strcmp($row_web_new['times'],"E"))) {echo "5";}
		  if (!(strcmp($row_web_new['times'],"F"))) {echo "6";}
		  if (!(strcmp($row_web_new['times'],"G"))) {echo "7";}
		  if (!(strcmp($row_web_new['times'],"H"))) {echo "8";}
		  if (!(strcmp($row_web_new['times'],"I"))) {echo "9";}
		  if (!(strcmp($row_web_new['times'],"J"))) {echo "10";}
		  if (!(strcmp($row_web_new['times'],"K"))) {echo "11";}
		  if (!(strcmp($row_web_new['times'],"L"))) {echo "12";}
		  if (!(strcmp($row_web_new['times'],"M"))) {echo "13";}
		  if (!(strcmp($row_web_new['times'],"N"))) {echo "14";}
		  if (!(strcmp($row_web_new['times'],"O"))) {echo "15";}
		  if (!(strcmp($row_web_new['times'],"P"))) {echo "16";}   ?> 次考試</label></td>
      </tr>
       <tr>
        <td height="20" align="right" class="board_add">匯出年份：</td>
        <td align="left" class="board_add"><p class="table_lineheight">
           <select name="startyear" id="startyear">
             <option>年</option>
               <script language="javascript" type="text/javascript">
                   var watch=new Date();
                   var thisYear=watch.getFullYear();
				   for(y=2014;y<=thisYear;y++){
                       document.write("<option value='"+y+"'>"+y+"</option>")
	                  }
	           </script>
          </select>
          
         </td>
      </tr>     
      
      <tr>
        <td width="140" height="20" align="right" class="board_add">匯出場次：</td>
        
        <td width="405" align="left" class="board_add">第  
          <select name="times">
                              <option value="A" selected="selected">1</option>
                              <option value="B" >2</option>
                              <option value="C">3</option>
                              <option value="D">4</option>
                              <option value="E">5</option>
                              <option value="F">6</option>
                              <option value="G">7</option>
                              <option value="H">8</option>
                              <option value="I">9</option>
                              <option value="J">10</option>
                              <option value="K">11</option>
                              <option value="L">12</option>
                              <option value="M">13</option>
                              <option value="N">14</option>
                              <option value="O">15</option>
                              <option value="P">16</option>
                              
                            </select> 
           次</td>
      </tr>
	  
	  <!--  //考場版本
	  <tr>
        <td width="140" height="20" align="right" class="board_add">匯出考區：</td>
        
        <td width="405" align="left" class="board_add">場區  
          <select name="exarea">
                              <option value="Northern" selected="selected">台北</option>
                              <option value="Central" >台中</option>
                              <option value="Southern">高雄</option>
                              <option value="Eastern">花蓮</option>
                                                           
                            </select> 
           </td>
      </tr>  
	  -->
    </table>
    <label>
      <br />
      <input type="submit" name="button" id="button" value="匯出" />&nbsp;&nbsp;
    </label>
  

    <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
               <input type="button" class="style1" onclick="location='logout.php'" value="登出" />
    <br />
    <input type="hidden" name="MM_insert" value="form1" />
    </form>
    </div>
 <div id="admin_main3">
       <?php include("right_zone.php");?>
  </div>
  <div id="main4"></div>
</div>
<?php include("footer.php"); ?>
</body>
</html>

<?php
mysql_free_result($web_new);
?>
