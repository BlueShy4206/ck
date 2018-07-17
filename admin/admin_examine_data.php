<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";
ini_set('memory_limit', '2048M');
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

if (isset($_POST["butOutput"])) {
	 downloadxls();
}
function downloadxls(){

		//PHPExcel 套件
		include "./PHPExcel/Classes/PHPExcel.php";
		require_once('./PHPExcel/Classes/PHPExcel.php');
		require_once('./PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

		//建立 文件
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$i = 1;


		//撈取資料庫 (考場人數)
		$sql_n = "SELECT no , data1 , data2 FROM allguide WHERE up_no = 'AN'";
		$result_n = mysql_query($sql_n);
		while($row2 = mysql_fetch_array($result_n))
		{
			 ${"Z_".$row2['no']} = $row2['data1'];
			 ${"LA_".$row2['no']} = $row2['data2'];
			 ${"ZI_".$row2['no']} = 0;
			 ${"LAI_".$row2['no']} = 0;
		}




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
			$objPHPExcel->getActiveSheet()->setCellValue('O1' ,"任職學校"); //(就讀/任職)學校
			$objPHPExcel->getActiveSheet()->setCellValue('P1' ,"教師證號碼"); //教師證
			$objPHPExcel->getActiveSheet()->setCellValue('Q1' ,"緊急聯絡人 姓名"); //緊急聯絡人
			$objPHPExcel->getActiveSheet()->setCellValue('R1' ,"緊急聯絡人 電話"); //緊急聯絡人 電話

			$objPHPExcel->getActiveSheet()->setCellValue('S1' ,"最高學歷"); //最高學歷
			$objPHPExcel->getActiveSheet()->setCellValue('T1' ,"系別"); //系別
			$objPHPExcel->getActiveSheet()->setCellValue('U1' ,"最高學位"); //最高學位

			$objPHPExcel->getActiveSheet()->setCellValue('V1' ,"次要學歷"); //次要學歷
			$objPHPExcel->getActiveSheet()->setCellValue('W1' ,"系別"); //系別
			$objPHPExcel->getActiveSheet()->setCellValue('X1' ,"次要學位"); //次要學位

			$objPHPExcel->getActiveSheet()->setCellValue('Y1' ,"其他學歷"); //其他學歷
			$objPHPExcel->getActiveSheet()->setCellValue('Z1' ,"系別"); //系別
			$objPHPExcel->getActiveSheet()->setCellValue('AA1' ,"其他學位"); //其他學位


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
			$objPHPExcel->getActiveSheet()->setCellValue('AM1' ,"審核備註"); //審核備註 ,錄取順序update by coway 2016.10.25
			$objPHPExcel->getActiveSheet()->setCellValue('AN1' ,"身份別"); //身份別,add by coway 2016.10.25
			$objPHPExcel->getActiveSheet()->setCellValue('AO1' ,"流水號"); //流水號,add by coway 2016.10.25
			$objPHPExcel->getActiveSheet()->setCellValue('AP1' ,"帳號"); //帳號,add by coway 2016.10.25
      $objPHPExcel->getActiveSheet()->setCellValue('AQ1' ,"身分證正面");
      $objPHPExcel->getActiveSheet()->setCellValue('AR1' ,"身分證反面");
      $objPHPExcel->getActiveSheet()->setCellValue('AS1' ,"最高學歷學位證書");
      $objPHPExcel->getActiveSheet()->setCellValue('AT1' ,"國民小學教師證書");
      $objPHPExcel->getActiveSheet()->setCellValue('AU1' ,"在職證明書");
      $objPHPExcel->getActiveSheet()->setCellValue('AV1' ,"特殊考場服務申請表");
      $objPHPExcel->getActiveSheet()->setCellValue('AW1' ,"應考服務診斷證明書");
      $objPHPExcel->getActiveSheet()->setCellValue('AX1' ,"應考切結書");
      $objPHPExcel->getActiveSheet()->setCellValue('AY1' ,"戶口名簿");



			$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);


		//撈取資料庫
// 		$sql_s = "SELECT * FROM examinee WHERE id LIKE '%". $_POST['times'] . $_POST['startyear'] ."%' AND exarea LIKE '%".$_POST['exarea']."%' AND allow LIKE '%".$_POST['apply_mk']."%'
// 					ORDER BY no ASC";
			$sql_s="SELECT examinee.*, allguide.note as exam_school, examinee_pic.* FROM examinee, allguide, examinee_pic WHERE allguide.up_no='EA2'
					AND examinee.exarea = allguide.nm and examinee.exarea_note = allguide.data2
					AND examinee.id LIKE '_". $_POST['times'] . $_POST['startyear'] ."%' AND examinee.apply_mk = '1'  AND examinee.no = examinee_pic.examinee_no ";
// 					"AND examinee.exarea LIKE '%".$_POST['exarea']."%' ";
		if($_POST['allow'] != ""){
        if	($_POST['allow'] == "N"){
            $sql_s = $sql_s ."AND examinee.allow != 'Y' ";//add by BlueS 2018.4.18
        }else{
          $sql_s = $sql_s ."AND examinee.allow = '".$_POST['allow']."' ";//add by coway 2017.5.9
        }
		}
		if($_POST['exarea'] != ""){	$sql_s = $sql_s ."AND examinee.exarea = '".$_POST['exarea']."' " ;
		}

			$sql_s = $sql_s ."ORDER BY examinee.date ASC";//AND examinee.date>'2016/11/1' AND examinee.allow='Y'
		// echo $sql_s;
		// die();
		$result = mysql_query($sql_s);

		//寫入資料 excel
		while($row = mysql_fetch_array($result))
		{

			$i++;

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
			$Ar_city_cu = $row['cusadr'];//$row['Area'].$row['cityarea'].$row['cusadr'];//update by coway 2016.10.25
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i ,$Ar_city_cu); //地址
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i ,$row['category']); //考科
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$i ,$row['exarea']); //考區
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$i ,$row['school']); //學校
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$i ,$row['certificate']); //教師證
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i ,$row['contact']); //緊急聯絡人
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$i ,$row['contact_ph']); //緊急聯絡人 電話

			$objPHPExcel->getActiveSheet()->setCellValue('S'.$i ,$row['Highest']); //最高學歷
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$i ,$row['High_college'].' '.$row['Department']); //系別 ,update by coway 2016.10.28

			$H_MK="";
			if($row['Edu_level'] == 1)
			{
				$H_MK ='專科';
			}elseif($row['Edu_level'] == 2){
				$H_MK ='學士';
			}elseif($row['Edu_level'] == 3){
				$H_MK ='碩士';
			}elseif($row['Edu_level'] == 4){
				$H_MK ='博士';
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
			$objPHPExcel->getActiveSheet()->setCellValue('W'.$i ,$row['Sec_college'].' '.$row['Sec_dept']); //系別 ,update by coway 2016.10.28


			$S_MK="";
			if(!empty($row['Sec_highest'])){
			if($row['Edu_level2'] == 1)
			{
				$S_MK ='專科';
			}elseif($row['Edu_level2'] == 2){
				$S_MK ='學士';
			}elseif($row['Edu_level2'] == 3){
				$S_MK ='碩士';
			}elseif($row['Edu_level2'] == 4){
				$S_MK ='博士';
			}else{
				;
			}

			if($row['Edu_MK2'] == 0)
			{
				$S_MK =$S_MK."\n就學中";
			}else{
				$S_MK =$S_MK."\n已畢業";
			}
			}

			$objPHPExcel->getActiveSheet()->setCellValue('X'.$i ,$S_MK); //次要學位

			$objPHPExcel->getActiveSheet()->setCellValue('Y'.$i ,$row['Other1']); //其他學歷
			$objPHPExcel->getActiveSheet()->setCellValue('Z'.$i ,$row['Other1_college'].' '.$row['Other1_dept']); //系別 ,update by coway 2016.10.28


			$O_MK = "";
			if(!empty($row['Other1'])){
			if($row['Edu_level3'] == 1)
			{
				$O_MK ='專科';
			}elseif($row['Edu_level3'] == 2){
				$O_MK ='學士';
			}elseif($row['Edu_level3'] == 3){
				$O_MK ='碩士';
			}elseif($row['Edu_level3'] == 4){
				$O_MK ='博士';
			}else{
				;
			}

			if($row['Edu_MK3'] == 0)
			{
				$O_MK =$O_MK."\n就學中";
			}else{
				$O_MK =$O_MK."\n已畢業";
			}
			}

			$objPHPExcel->getActiveSheet()->setCellValue('AA'.$i ,$O_MK); //其他學位


			$objPHPExcel->getActiveSheet()->setCellValue('AB'.$i ,""); //身分證影本
			$objPHPExcel->getActiveSheet()->setCellValue('AC'.$i ,$row['date']); //申請日期
			$objPHPExcel->getActiveSheet()->setCellValue('AD'.$i ,$row['allow']); //審核

			$objPHPExcel->getActiveSheet()->setCellValue('AE'.$i ,$row['id_number']);//id_number ,add by coway 2016.12.1

			$objPHPExcel->getActiveSheet()->setCellValue('AF'.$i ,$row['con_mk']); //身心障礙者
			$objPHPExcel->getActiveSheet()->setCellValue('AG'.$i ,$row['con2_mk']); //診斷證明書
			$objPHPExcel->getActiveSheet()->setCellValue('AH'.$i ,$row['con3_mk']); //切結書

			$objPHPExcel->getActiveSheet()->setCellValue('AI'.$i ,$row['copy_mk']); //大專以上學歷證書影本
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$i ,$row['copy2_mk']); //國民小學教師證書影本
			$objPHPExcel->getActiveSheet()->setCellValue('AK'.$i ,$row['copy3_mk']); //在職證明書正本
			$objPHPExcel->getActiveSheet()->setCellValue('AL'.$i ,$row['remark']); //考場安排


			//Z_C_N 台中 正取人數 LA_C_N 台中 備取人數 ZI_C_N 台中目前正取人數  LAI_C_N 台中目前備取人數
			if($row['Qualify'] == 1){
				$Order = substr($row['id'] , 0 , 1);
				if($Order == 'C'){
					$ZI_C_N++;
					if($ZI_C_N > $Z_C_N){
						$ZLA ="臺中正取 超出報名人數";
					}else{
						$ZLA =$row['id']."臺中正取".$ZI_C_N;
					}

				}elseif($Order == 'N'){
					$ZI_N_N++;
					if($ZI_N_N > $Z_N_N){
						$ZLA ="臺北正取 超出報名人數";
					}else{
						$ZLA =$row['id']."臺北正取".$ZI_N_N;
					}

				}elseif($Order == 'S'){
					$ZI_S_N++;
					if($ZI_S_N > $Z_S_N){
						$ZLA ="高雄正取 超出報名人數";
					}else{
						$ZLA =$row['id']."高雄正取".$ZI_S_N;
					}

				}elseif($Order == 'E'){
					$ZI_E_N++;
					if($ZI_E_N > $Z_E_N){
						$ZLA ="高雄正取 超出報名人數";
					}else{
						$ZLA =$row['id']."花蓮正取".$ZI_E_N;
					}

				}
			}elseif($row['Qualify'] == 0){
				$Order = substr($row['id'] , 0 , 1);
				if($Order == 'C'){
					$LAI_C_N++;
					if($LAI_C_N > $LA_C_N){
						$ZLA ="臺中備取 超出報名人數";
					}else{
						$ZLA =$row['id']."臺中備取".$LAI_C_N;
					}

				}elseif($Order == 'N'){
					$LAI_N_N++;
					if($LAI_N_N > $LA_N_N){
						$ZLA ="臺北備取 超出報名人數";
					}else{
						$ZLA =$row['id']."臺北備取".$LAI_N_N;
					}

				}elseif($Order == 'S'){
					$LAI_S_N++;
					if($LAI_S_N > $LA_S_N){
						$ZLA ="高雄備取 超出報名人數";
					}else{
						$ZLA =$row['id']."高雄備取".$LAI_S_N;
					}

				}elseif($Order == 'E'){
					$LAI_E_N++;
					if($LAI_E_N > $LA_E_N){
						$ZLA ="花蓮備取 超出報名人數";
					}else{
						$ZLA =$row['id']."花蓮備取".$LAI_E_N;
					}

				}

			}

// 			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$i ,$ZLA); //備取順序
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$i ,$row['allow_note']); //審核備註
			$objPHPExcel->getActiveSheet()->setCellValue('AN'.$i ,$row['cert_no']); //身份別,add by coway 2016.10.25
			$objPHPExcel->getActiveSheet()->setCellValue('AO'.$i ,$row['cert_id']); //流水號,add by coway 2016.10.25
			$objPHPExcel->getActiveSheet()->setCellValue('AP'.$i ,$row['username']); //帳號,add by coway 2016.10.25

			//007 新版 排版  END
			/*
				//匯入 大頭照
			if(is_file('../images/examinee/'.$row['pic_name'])){
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName($row['pic_name']);
                $objDrawing->setDescription($row['pic_name']);
                $objDrawing->setPath('../images/smallPic/'.$row['pic_name']);
                //$objDrawing->setHeight(100);
				//$objDrawing->setWidth(80);
				$objDrawing->setWidthAndHeight(80,100);
				$objDrawing->setResizeProportional(true);
                $objDrawing->setCoordinates('G'.$i);
               	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			}else $objPHPExcel->getActiveSheet()->setCellValue('G'.$i ,"");
				//匯入 大頭照 END
				*/

			//匯入 大頭照
			if(is_file('../images/smallPic/'.$row['pic_name'])){
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName($row['pic_name']);
				$objDrawing->setDescription($row['pic_name']);
				$objDrawing->setPath('../images/smallPic/'.$row['pic_name']);
				$objDrawing->setHeight(100);
				$objDrawing->setWidth(80);
				//$objDrawing->setWidthAndHeight(80,100);
				$objDrawing->setResizeProportional(true);
				$objDrawing->setCoordinates('G'.$i);
				$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

			}else $objPHPExcel->getActiveSheet()->setCellValue('G'.$i ,"");
			//匯入 大頭照 END

      //匯入 照片1~5,特殊考生,戶口名簿 START    BlueS 20180321
      //1
    if(is_file('../images/smallPic/id_check/'.$row['pic1_name'])){

      $objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setName($row['pic1_name']);
                              $objDrawing->setDescription($row['pic1_name']);
                              $objDrawing->setPath('../images/smallPic/id_check/'.$row['pic1_name']);
                              $objDrawing->setHeight(400);
      $objDrawing->setWidth(320);
      //$objDrawing->setWidthAndHeight(80,100);
      $objDrawing->setResizeProportional(true);
                              $objDrawing->setCoordinates('AQ'.$i);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    }else $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$i ,"");

    //2
    if(is_file('../images/smallPic/id_check/'.$row['pic2_name'])){
      $objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setName($row['pic2_name']);
                              $objDrawing->setDescription($row['pic2_name']);
                              $objDrawing->setPath('../images/smallPic/id_check/'.$row['pic2_name']);
                              $objDrawing->setHeight(400);
      $objDrawing->setWidth(320);
      //$objDrawing->setWidthAndHeight(80,100);
      $objDrawing->setResizeProportional(true);
                              $objDrawing->setCoordinates('AR'.$i);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    }else $objPHPExcel->getActiveSheet()->setCellValue('AR'.$i ,"");

    //3
    if(is_file('../images/smallPic/id_check/'.$row['pic3_name'])){
      $objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setName($row['pic3_name']);
                              $objDrawing->setDescription($row['pic3_name']);
                              $objDrawing->setPath('../images/smallPic/id_check/'.$row['pic3_name']);
                              $objDrawing->setHeight(400);
      $objDrawing->setWidth(320);
      //$objDrawing->setWidthAndHeight(80,100);
      $objDrawing->setResizeProportional(true);
                              $objDrawing->setCoordinates('AS'.$i);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    }else $objPHPExcel->getActiveSheet()->setCellValue('AS'.$i ,"");

    //4
    if(is_file('../images/smallPic/id_check/'.$row['pic4_name'])){
      $objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setName($row['pic4_name']);
                              $objDrawing->setDescription($row['pic4_name']);
                              $objDrawing->setPath('../images/smallPic/id_check/'.$row['pic4_name']);
                              $objDrawing->setHeight(400);
      $objDrawing->setWidth(320);
      //$objDrawing->setWidthAndHeight(80,100);
      $objDrawing->setResizeProportional(true);
                              $objDrawing->setCoordinates('AT'.$i);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    }else $objPHPExcel->getActiveSheet()->setCellValue('AT'.$i ,"");

    //5
    if(is_file('../images/examinee/id_check/'.$row['pic5_name'])){
      $objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setName($row['pic5_name']);
                              $objDrawing->setDescription($row['pic5_name']);
                              $objDrawing->setPath('../images/examinee/id_check/'.$row['pic5_name']);
                              $objDrawing->setHeight(400);
      $objDrawing->setWidth(320);
      //$objDrawing->setWidthAndHeight(80,100);
      $objDrawing->setResizeProportional(true);
                              $objDrawing->setCoordinates('AU'.$i);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    }else $objPHPExcel->getActiveSheet()->setCellValue('AU'.$i ,"");

    //特殊-1
    if(is_file('../images/smallPic/id_check/'.$row['special_pic_name1'])){
      $objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setName($row['special_pic_name1']);
                              $objDrawing->setDescription($row['special_pic_name1']);
                              $objDrawing->setPath('../images/smallPic/id_check/'.$row['special_pic_name1']);
                              $objDrawing->setHeight(100);
      $objDrawing->setWidth(80);
      //$objDrawing->setWidthAndHeight(80,100);
      $objDrawing->setResizeProportional(true);
                              $objDrawing->setCoordinates('AV'.$i);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    }else $objPHPExcel->getActiveSheet()->setCellValue('AV'.$i ,"");

    //特殊-2
    if(is_file('../images/smallPic/id_check/'.$row['special_pic_name2'])){
      $objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setName($row['special_pic_name2']);
                              $objDrawing->setDescription($row['special_pic_name2']);
                              $objDrawing->setPath('../images/smallPic/id_check/'.$row['special_pic_name2']);
                              $objDrawing->setHeight(100);
      $objDrawing->setWidth(80);
      //$objDrawing->setWidthAndHeight(80,100);
      $objDrawing->setResizeProportional(true);
                              $objDrawing->setCoordinates('AW'.$i);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    }else $objPHPExcel->getActiveSheet()->setCellValue('AW'.$i ,"");

    //特殊-3
    if(is_file('../images/smallPic/id_check/'.$row['special_pic_name3'])){
      $objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setName($row['special_pic_name3']);
                              $objDrawing->setDescription($row['special_pic_name3']);
                              $objDrawing->setPath('../images/smallPic/id_check/'.$row['special_pic_name3']);
                              $objDrawing->setHeight(100);
      $objDrawing->setWidth(80);
      //$objDrawing->setWidthAndHeight(80,100);
      $objDrawing->setResizeProportional(true);
                              $objDrawing->setCoordinates('AX'.$i);
                        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    }else $objPHPExcel->getActiveSheet()->setCellValue('AX'.$i ,"");

      //匯入 照片1~5,特殊考生,戶口名簿 END


   //戶口名簿
   if(is_file('../images/examinee/id_check/'.$row['rename_pic_name'])){
     $objDrawing = new PHPExcel_Worksheet_Drawing();
     $objDrawing->setName($row['rename_pic_name']);
                             $objDrawing->setDescription($row['rename_pic_name']);
                             $objDrawing->setPath('../images/examinee/id_check/'.$row['rename_pic_name']);
                             $objDrawing->setHeight(100);
     $objDrawing->setWidth(80);
     //$objDrawing->setWidthAndHeight(80,100);
     $objDrawing->setResizeProportional(true);
                             $objDrawing->setCoordinates('AY'.$i);
                       $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

   }else $objPHPExcel->getActiveSheet()->setCellValue('AY'.$i ,"");

				//行高 設定
				$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(160);


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
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(30);

		 $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(16);//身份別,add by coway 2016.10.25
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(16);//流水號,add by coway 2016.10.25
		 $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(16);//帳號,add by coway 2016.10.25
     $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(48);//1~5 CHECK BlueS 20180321
     $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(48);
     $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(48);
     $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(48);
     $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(48);
     $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(16);
     $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(16);
     $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(16);
     $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setWidth(16);




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

//撈取資料庫 (考場)
$sql_exarea = "SELECT no , nm, note FROM allguide WHERE up_no = 'EA'";
$result_exarea = mysql_query($sql_exarea);


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
    <form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1">
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

        <td width="305" align="left" class="board_add">第
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
      <tr>
      	<td width="140" height="20" align="right" class="board_add">匯出考場場區：</td>

        <td width="305" align="left" class="board_add">
       		<select name="exarea"><option value="" selected="selected">不分區</option>
       		<?php while($row_exarea = mysql_fetch_array($result_exarea)){
       				echo "<option value=".$row_exarea['nm'].">$row_exarea[note]</option>";
       			}
       		?>
       		</select> </td>
      </tr>
      <tr>
      	<td width="140" height="20" align="right" class="board_add">審核狀態：</td>

        <td width="305" align="left" class="board_add">
       		<select name="allow"><option value="" selected="selected">全部</option>
       			<option value="0" >未審核</option>
       			<option value="YY" >已通過</option>
       			<option value="N" >未通過</option>
       		</select> </td>
      </tr>
    </table>
    <label>
      <br />
      <input type="submit" name="butOutput" id="butOutput" value="匯出" onClick= />&nbsp;&nbsp;
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
