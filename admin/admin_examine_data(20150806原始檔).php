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
//凱迪 excel 匯出 版本  PS 此方法 不使用套件 產生資料到 網頁上 並透過 網業產生 excel 此方法不能產生圖片的匯入 也不需要用套件
//$query_web_Recordset2 = sprintf("SELECT * FROM examinee WHERE id LIKE %s  ORDER BY id ASC", GetSQLValueString("'%" . $_POST['times']. $_POST['startyear'] . "%'", "text"));
/* $web_Recordset2 = mysql_query($query_web_Recordset2);

$totalRows_web_Recordset2 = mysql_num_rows($web_Recordset2); */
	
	
/* $filename="examineeoutput.xls";
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: filename=$filename");
//header("Content-type: application/octetstream");
header("Pragma: no-cache");
header("Expires: 0");


echo "<table border=1px><tr><td>本欄留空</td><td>中文姓名(必填)</td><td>密碼((若不填，由系統決定密碼))</td><td>電子郵件信箱(可留白)</td><td>性別(必填)</td><td>出生年月日(可留白)</td><td>身份證字號(可留白)</td><td>住所電話(可留白)</td><td>手機號碼</td><td>家裡住址(可留白)</td><td>考區</td><td>年級(預設為6)</td><td>班級(預設為1)</td><td>自訂帳號</td></tr>";

for ($i = 0; $i < $totalRows_web_Recordset2; $i++)
{
$row_web_Recordset2 = mysql_fetch_array($web_Recordset2);

echo "<tr><td></td><td>".$row_web_Recordset2['uname']."</td><td>".$row_web_Recordset2['per_id']."</td><td>".$row_web_Recordset2['email']."</td><td>".$row_web_Recordset2['sex']."</td><td>".$row_web_Recordset2['birthday']."</td><td>".$row_web_Recordset2['per_id']."</td><td>".$row_web_Recordset2['phone']."</td><td>".$row_web_Recordset2['phone']."</td><td>".$row_web_Recordset2['cusadr']."</td><td>".$row_web_Recordset2['exarea']."</td><td>".$row_web_Recordset2['Grade']."</td><td></td><td>".$row_web_Recordset2['id']."</td></tr>";
$j=$i+1;
}
echo "</table>"; */

		//header("Content-Type:application/vnd.ms-excel");
		//header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        //header("Content-Disposition:attachment;filename=product.xls");
        //header("Pragma:no-cache");
        //header("Expires:0");
		
//凱迪 excel 匯出 版本  END

		//PHPExcel 套件
		include "./PHPExcel/Classes/PHPExcel.php"; 
		require_once('./PHPExcel/Classes/PHPExcel.php');
		require_once('./PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');
		
		//建立 文件
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$i = 1;
		
		
				
		
			//加入 第一行 
			$objPHPExcel->getActiveSheet()->setCellValue('A1' ,"空白"); //空白
			$objPHPExcel->getActiveSheet()->setCellValue('B1' ,"程式識別用"); //id
			
			$objPHPExcel->getActiveSheet()->setCellValue('C1' ,"姓名"); //姓名
			$objPHPExcel->getActiveSheet()->setCellValue('D1' ,"英文名");  //英文名
			$objPHPExcel->getActiveSheet()->setCellValue('E1' ,"性別"); //性別
			$objPHPExcel->getActiveSheet()->setCellValue('F1' ,"身分證字號"); //身分證字號
			$objPHPExcel->getActiveSheet()->setCellValue('G1' ,"大頭照"); //大頭照
			$objPHPExcel->getActiveSheet()->setCellValue('H1' ,"連絡電話"); //phone
			$objPHPExcel->getActiveSheet()->setCellValue('I1' ,"email"); //email
			$objPHPExcel->getActiveSheet()->setCellValue('J1' ,"生日"); //生日
			$objPHPExcel->getActiveSheet()->setCellValue('K1' ,"郵遞區號"); //郵遞區號
			$objPHPExcel->getActiveSheet()->setCellValue('L1' ,"地址"); //地址
			$objPHPExcel->getActiveSheet()->setCellValue('M1' ,"考科 \n 1國 2數 \n 3社 4自"); //考科
			$objPHPExcel->getActiveSheet()->setCellValue('N1' ,"測驗考場"); //考區
			$objPHPExcel->getActiveSheet()->setCellValue('O1' ,"任職學校"); //學校
			$objPHPExcel->getActiveSheet()->setCellValue('P1' ,"教師證號碼"); //教師證
			$objPHPExcel->getActiveSheet()->setCellValue('Q1' ,"緊急聯絡人 姓名"); //緊急聯絡人
			$objPHPExcel->getActiveSheet()->setCellValue('R1' ,"緊急聯絡人 電話"); //緊急聯絡人 電話
			
			$objPHPExcel->getActiveSheet()->setCellValue('S1' ,"最高學歷"); //最高學歷
			$objPHPExcel->getActiveSheet()->setCellValue('T1' ,"系別"); //系別
			$objPHPExcel->getActiveSheet()->setCellValue('U1' ,"最高學位"); //最高學位
			
			$objPHPExcel->getActiveSheet()->setCellValue('V1' ,"次要學歷"); //次要學歷
			$objPHPExcel->getActiveSheet()->setCellValue('W1' ,"系別"); //系別
			$objPHPExcel->getActiveSheet()->setCellValue('X1' ,"次要學位"); //次要學位
			
			$objPHPExcel->getActiveSheet()->setCellValue('Y1' ,"次要學歷"); //其他學歷
			$objPHPExcel->getActiveSheet()->setCellValue('Z1' ,"系別"); //系別
			$objPHPExcel->getActiveSheet()->setCellValue('AA1' ,"次要學位"); //其他學位
			
			
			$objPHPExcel->getActiveSheet()->setCellValue('AB1' ,"有無身分證影本"); //身分證影本
			$objPHPExcel->getActiveSheet()->setCellValue('AC1' ,"申請日期"); //申請日期
			$objPHPExcel->getActiveSheet()->setCellValue('AD1' ,"是否通過"); //審核
			
			$objPHPExcel->getActiveSheet()->setCellValue('AE1' ,"准考證號碼");//id_number
			
			$objPHPExcel->getActiveSheet()->setCellValue('AF1' ,"是否為身心障礙者"); //身心障礙者
			$objPHPExcel->getActiveSheet()->setCellValue('AG1' ,"是否有診斷證明書"); //診斷證明書
			$objPHPExcel->getActiveSheet()->setCellValue('AH1' ,"是否有切結書"); //切結書
			
			$objPHPExcel->getActiveSheet()->setCellValue('AI1' ,"大專以上學歷證書影本"); //大專以上學歷證書影本
			$objPHPExcel->getActiveSheet()->setCellValue('AJ1' ,"國民小學教師證書影本"); //國民小學教師證書影本
			$objPHPExcel->getActiveSheet()->setCellValue('AK1' ,"在職證明書正本"); //在職證明書正本
			$objPHPExcel->getActiveSheet()->setCellValue('AL1' ,"考場安排"); //考場安排
			
			
			
			$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
		
		
		//撈取資料庫 
		$sql_s = "SELECT * FROM examinee WHERE id LIKE '%". $_POST['times'] . $_POST['startyear'] ."%' ORDER BY id ASC";
		$result = mysql_query($sql_s);
		
		//凱迪 excel 匯出 版本 資料撈取
		//SELECT * FROM examinee WHERE id LIKE %s  ORDER BY id ASC
		//$result = mysql_query($query_web_Recordset2);
		//echo "SELECT * FROM examinee WHERE id LIKE '%".$_POST['times']. $_POST['startyear']."%' ORDER BY id ASC";
		//凱迪 excel 匯出 版本 資料撈取 END
		
		//寫入資料 excel
		while($row = mysql_fetch_array($result))
		{
			
			$i++;
								
			//$objPHPExcel->getActiveSheet()->setCellValue('A'.$i ,""); //空白
			
			//007 舊版 排版
			/* $objPHPExcel->getActiveSheet()->setCellValue('B'.$i ,$row['id']); //id
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i ,$row['uname']); //姓名
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i ,$row['eng_uname']);  //英文名
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i ,$row['sex']); //性別
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i ,$row['birthday']); //生日
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$i ,$row['per_id']); //身分證字號
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i ,$row['email']); //email
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i ,$row['phone']); //phone
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$i ,$row['Area']); //縣市
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i ,$row['cityarea']); //區域
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i ,$row['cuszip']); //郵遞區號
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i ,$row['cusadr']); //地址
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$i ,$row['certificate']); //教師證
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$i ,$row['exarea']); //考區
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$i ,$row['school']); //學校
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i ,$row['category']); //考科
			//$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i ,$row['Grade']); //學級
			//$objPHPExcel->getActiveSheet()->setCellValue('R'.$i ,$row['Student_ID']); //學號
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$i ,$row['Highest']); //最高學歷
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$i ,$row['Department']); //系別
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$i ,$row['contact']); //緊急聯絡人
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$i ,$row['contact_ph']); //緊急聯絡人 電話
			
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName($row['pic_name']);
                $objDrawing->setDescription($row['pic_name']);
                $objDrawing->setPath('../images/examinee/'.$row['pic_name']);
                $objDrawing->setHeight(120);
				$objDrawing->setWidth(80);
                $objDrawing->setCoordinates('W'.$i);
                //$objDrawing->setOffsetX(110);
				$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());	
				
				
				
			//$objPHPExcel->getActiveSheet()->setCellValue('W'.$i ,$row['pic_title']); //大頭照(再改)
			//$objPHPExcel->getActiveSheet()->setCellValue('X'.$i ,$row['pic_name']); //大頭照 檔名(再改)
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$i ,$row['status']); //考試類型
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$i ,$row['date']); //生日
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$i ,$row['allow']); //審核
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$i ,"");//id_number */
			//007 舊版 排版 END
			
			//007 新版 排版 
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i ,""); //空白
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$i ,$row['id']); //id
			
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i ,$row['uname']); //姓名
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i ,$row['eng_uname']);  //英文名
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i ,$row['sex']); //性別
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i ,$row['per_id']); //身分證字號
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i ,$row['phone']); //phone
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i ,$row['email']); //email
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$i ,$row['birthday']); //生日
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i ,$row['cuszip']); //郵遞區號
			$Ar_city_cu = $row['Area'].$row['cityarea'].$row['cusadr'];
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i ,$Ar_city_cu); //地址
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i ,$row['category']); //考科
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$i ,$row['exarea']); //考區
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$i ,$row['school']); //學校
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$i ,$row['certificate']); //教師證
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i ,$row['contact']); //緊急聯絡人
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$i ,$row['contact_ph']); //緊急聯絡人 電話
			
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$i ,$row['Highest']); //最高學歷
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$i ,$row['Department']); //系別
			
			if($row['Edu_level'] == 1)
			{
				$H_MK ='專科';
			}elseif($row['Edu_level'] == 2){
				$H_MK ='學士';
			}elseif($row['Edu_level'] == 3){
				$H_MK ='碩士';
			}else{
				;
			}
			
			if($row['Edu_MK'] == 0)
			{
				$H_MK =$H_MK."\n就學中";
			}else{
				$H_MK =$H_MK."\n已畢業";
			}
			
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$i ,$H_MK); //最高學位
			
			$objPHPExcel->getActiveSheet()->setCellValue('V'.$i ,$row['Sec_highest']); //次要學歷
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$i ,$row['Sec_dept']); //系別
			
			if($row['Edu_level'] == 1)
			{
				$S_MK ='專科';
			}elseif($row['Edu_level'] == 2){
				$S_MK ='學士';
			}elseif($row['Edu_level'] == 3){
				$S_MK ='碩士';
			}else{
				;
			}
			
			if($row['Edu_MK'] == 0)
			{
				$S_MK =$S_MK."\n就學中";
			}else{
				$S_MK =$S_MK."\n已畢業";
			}
			
			$objPHPExcel->getActiveSheet()->setCellValue('X'.$i ,$S_MK); //次要學位
			
			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$i ,$row['Other1']); //其他學歷
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$i ,$row['Other1_dept']); //系別
			
			if($row['Edu_level'] == 1)
			{
				$O_MK ='專科';
			}elseif($row['Edu_level'] == 2){
				$O_MK ='學士';
			}elseif($row['Edu_level'] == 3){
				$O_MK ='碩士';
			}else{
				;
			}
			
			if($row['Edu_MK'] == 0)
			{
				$O_MK =$O_MK."\n就學中";
			}else{
				$O_MK =$O_MK."\n已畢業";
			}
			
			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$i ,$O_MK); //其他學位
			
			
			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$i ,""); //身分證影本
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$i ,$row['date']); //申請日期
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$i ,$row['allow']); //審核
			
			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$i ,"");//id_number
			
			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$i ,""); //身心障礙者
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$i ,""); //診斷證明書
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$i ,""); //切結書
						
			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$i ,""); //大專以上學歷證書影本
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$i ,""); //國民小學教師證書影本
			$objPHPExcel->getActiveSheet()->setCellValue('AK'.$i ,""); //在職證明書正本
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$i ,""); //考場安排
			//007 新版 排版  END 
			
				//匯入 大頭照 
			if(is_file('../images/examinee/'.$row['pic_name'])){
				//$objDrawing = new PHPExcel_Worksheet_Drawing();
				//$objDrawing->setName($row['pic_name']);
                //$objDrawing->setDescription($row['pic_name']);
                //$objDrawing->setPath('../images/examinee/'.$row['pic_name']);
                //$objDrawing->setHeight(100);
				//$objDrawing->setWidth(80);
                //$objDrawing->setCoordinates('G'.$i);
               	//$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			}	
				//匯入 大頭照 END
				
				
				//行高 設定
				$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(100);
			
			
		}
		
		
		
		//寬度設定 右邊 為 自動列寬 setAutoSize(true) 不建議使用  
		 $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
		 $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); 
		 $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10); 
		 $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(35);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
		 
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(10);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(16);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
		 
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(10);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(15);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(18);
		 
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(18);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(14);
		 
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(22);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(22);
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(16);
		 
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(10);
		 
		 
		

		/* //Save Excel 2007 file 保存
                $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                $objWriter->save(str_replace('.php', '.xlsx', __FILE__)); */
				require_once('./PHPExcel/Classes/PHPExcel/Writer/Excel5.php');
                $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
                $objWriter->save(str_replace('.php', '.xls',  './downloadFile/'.date('Y-n-j').'test.xls'));
                $downloadFile = './downloadFile/'.date('Y-n-j').'test.xls';
				header(sprintf("Location: %s", $downloadFile));				
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
                              <option value="B">2</option>
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
    </table>
    <label>
      <br />
      <input type="submit" name="button" id="button" value="匯出" onClick= />&nbsp;&nbsp;   
    </label>
  
    <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
               <input type="button" class="style1" onclick="location='logout.php'" value="登出" />
    <br />
    <input type="hidden" name="MM_insert" value="form1" />
	
	<br />
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
