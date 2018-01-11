<?php require_once('Connections/conn_web.php'); ?>
 <?php 
// echo $_REQUEST["i2d"];
// echo $_REQUEST["i2d2"];
// echo $_REQUEST["id"];

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

function EngNameStr($eng_name){
	list($firstname, $lastname, $lastname2) = explode(" ", trim($eng_name));//去掉英文欄位前後空白 
	$firstname = strtoupper (substr($firstname,0,1)).strtolower(substr($firstname,1));

	if(isset($lastname2)){
		$lastname=strtoupper (substr($lastname,0,1)).strtolower(substr($lastname,1));
		$lastname2=strtoupper (substr($lastname2,0,1)).strtolower(substr($lastname2,1));
	}else {

		list($lastname, $lastname2)=explode("-", $lastname);
		if(isset($lastname2)){
			$lastname=strtoupper (substr($lastname,0,1)).strtolower(substr($lastname,1));
			$lastname2=strtoupper (substr($lastname2,0,1)).strtolower(substr($lastname2,1));
		}else {
			$lastname=strtoupper (substr($lastname,0,1)).substr($lastname,1);
		}
	}
	$eng_name="$firstname $lastname $lastname2";
	return $eng_name;
}

function PubTime($public_time){
	list($year, $month, $day) = explode("-", $public_time);
	$year=$year-1911;
	$month=$month;//+1
	$day = substr($day,0,2);
	$pub_time = "$year.$month.$day";
	return $pub_time;
}

$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
	$colname_web_member = $_SESSION['MM_Username'];
}
$type=$_GET['status'];
$examyear_id=$_GET['examyear_id'];
mysql_select_db($database_conn_web, $conn_web);
//add status ,examyear_id search, by coway 2017.1.5
// $query_web_new = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";// WHERE status = '$type'
$query_web_new = sprintf("SELECT * FROM examyear WHERE status=%s and id=%s ORDER BY id DESC LIMIT 0,1",GetSQLValueString($type, "text"),GetSQLValueString($examyear_id, "text"));
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);

$todayyear = $row_web_new['times'];
$todayyear .= date("Y");
mysql_select_db($database_conn_web, $conn_web);
$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND id_number = %s LIMIT 0,1", GetSQLValueString($colname_web_member, "text"),GetSQLValueString($_GET["id"], "text"));
$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
$row_web_examinee = mysql_fetch_assoc($web_examinee);

$id_number=$row_web_examinee['id_number'];
mysql_select_db($database_conn_web, $conn_web);
$query_web_news = sprintf("SELECT ff.*, a1.no level_eng1, a2.no level_eng2, a3.no level_eng3, a4.no level_eng4 
		FROM score as ff left join allguide as a1 ON ff.c_level = a1.nm 
		left join allguide as a2 ON ff.m_level = a2.nm 
		left join allguide as a3 ON ff.s_level = a3.nm 
		left join allguide as a4 ON ff.p_level = a4.nm WHERE score_id = %s ORDER BY id ASC", GetSQLValueString($id_number, "text"));
$web_score = mysql_query($query_web_news, $conn_web) or die(mysql_error());
$row_web_score = mysql_fetch_assoc($web_score);

mysql_select_db($database_conn_web, $conn_web);
$query_allguide = "SELECT no,nm,data1,data2 FROM allguide WHERE up_no='Level' ORDER BY id";
$web_allguide = mysql_query($query_allguide, $conn_web) or die(mysql_error());
$row_web_allguide = mysql_fetch_array($web_allguide);


IF($_GET['type']=='p'){
	$subjectTest='自然領域';
	$scoreSub= $row_web_score['score_ppoint'];
	$levelSub=$row_web_score['p_level']."<span class='score'>".$row_web_score['level_eng4']."</span>";
	$note = ($row_web_score['note4'] != "") ? "備註：".$row_web_score['note4']."<br>" : "";
}elseif ($_GET['type']=='c'){
	$subjectTest='國語領域';
	$scoreSub=$row_web_score['score_cpoint'];
	$levelSub=$row_web_score['c_level']."<span class='score'>".$row_web_score['level_eng1']."</span>";
	$note = ($row_web_score['note1'] != "") ? "備註：".$row_web_score['note1']."<br>" : "";
}elseif ($_GET['type']=='m'){
	$subjectTest='數學領域';
	$scoreSub=$row_web_score['score_mpoint'];
	$levelSub=$row_web_score['m_level']."<span class='score'>".$row_web_score['level_eng2']."</span>";
	$note = ($row_web_score['note2'] != "") ? "備註：".$row_web_score['note2']."<br>" : "";
}elseif ($_GET['type']=='s'){
	$subjectTest='社會領域';
	$scoreSub=$row_web_score['score_spoint'];
	$levelSub=$row_web_score['s_level']."<span class='score'>".$row_web_score['level_eng3']."</span>";
	$note = ($row_web_score['note3'] != "") ? "備註：".$row_web_score['note3']."<br>" : "";
}
$eng_uname = EngNameStr($row_web_examinee['eng_uname']);

// if($row_web_examinee['status']==0){
	$pub_time = PubTime($row_web_new['scoreTime']);
// }else $pub_time = PubTime($row_web_new['scoreTimeCK']);

$pdf_name = $row_web_examinee['id'];
$pdf_uname = $row_web_examinee['uname'];

mysql_select_db($database_conn_web, $conn_web);
$query_examyear_cnt = sprintf("SELECT count(*)  FROM `examyear` where status=%s and id <=%s and printtime like %s ",GetSQLValueString($type, "text"),GetSQLValueString($examyear_id, "text"),GetSQLValueString(substr($row_web_new['printtime'],0,4)."%", "text"));
$web_examyear_cnt = mysql_query($query_examyear_cnt, $conn_web) or die(mysql_error());
$row_web_examyear_cnt = mysql_fetch_array($web_examyear_cnt);


$year_str=substr($row_web_new['printtime'],0,4)-1911;
$times = (($row_web_examyear_cnt[0] ==1) ? "一":(($row_web_examyear_cnt[0] ==2) ? "二":"三"));
if($row_web_examinee['status']==0){
	$pdf_title = $year_str.'年第'.$times.'梯次國民小學師資類科師資生';//'105年第二梯次師資生'
}else $pdf_title = $year_str.'年第'.$times.'梯次國民小學教師';//'105年第二梯次國民小學教師'

if($scoreSub=='0') $scoreSub='--';

?>
<? session_start();?>

<?php 
// Include the main TCPDF library (search for installation path).
include_once ('Pdf/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'score_Backgroud2.jpg';
		$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
}

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NTCU Assessment');
$pdf->SetTitle('Subject knowledge and ability assessment');
$pdf->SetSubject('Test Score Report');
$pdf->SetKeywords('NTCU, PDF, assessment, score');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// set font

$font = new TCPDF_FONTS();
$fontKaiu=$font->addTTFfont('Pdf/fonts/kaiuwu.ttf', 'TrueTypeUnicode');
$pdf->setLanguageArray($l);
$pdf->setFontSubsetting(true);
$pdf->setRTL(false);
//$pdf->SetFont($fontKaiu ,'', 18,'',true);
//$pdf->SetFont('cid0jp', '', 20);

$tmparray = explode("啓",$row_web_examinee[uname]);//難字使用droidsansfallback字型, add by coway 2017.1.9
if(count($tmparray)>1){
$pdf->SetFont('droidsansfallback', '', 20, '', true);//使用者端電腦的預設字型 ,msungstdlight
}else{
$pdf->SetFont('msungstdlight', '', 20, '', true);//使用者端電腦的預設字型 ,msungstdlight	
}

// remove default header
$pdf->setPrintHeader(false);

// add a page
$resolution= array(180, 180);
$pdf->AddPage('L','A5');

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image

IF($_GET['type']=='p'){
	$img_file = K_PATH_IMAGES.'score_Backgroud2.jpg';
}elseif ($_GET['type']=='c'){
	$img_file = K_PATH_IMAGES.'backgroup_c2.jpg';
}elseif ($_GET['type']=='m'){
	$img_file = K_PATH_IMAGES.'backgroup_m2.jpg';
}elseif ($_GET['type']=='s'){
	$img_file = K_PATH_IMAGES.'backgroup_s2.jpg';
}
$pdf->Image($img_file, 0, 0, 150, 143, 'JPEG', '', '', false, 300, 'L', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();


$html = <<<EOF
<style type='text/css'>			
 .title {
	font-family: 'Times New Roman', Georgia, Serif;
	font-size: 16pt;
	}
 .score {
	font-family: times;
	font-size: 14pt;
}
 .context {
	font-family: times;
	font-size: 12pt;
}
 .footer {
	font-family: times;
	font-size: 10pt;
}
</style>
		<table width='510' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td align='center' colspan='4'><span style='font-size: 30px;'></span><font size='+3' >$pdf_title<br>$subjectTest 學科知能評量</font></td>
		</tr>
		<tr>
			<td align='center' colspan='4'>成績單 <span class='title'> Test Score Report</span></td>
		</tr>
	</table>
	<table width='500' border='1' cellspacing='0' cellpadding='0'>
        <tr>
        	<td width='120' height='10' align='center' style='font-size:18px;'>姓名<br><span class='score'>Name</span></td>
        	<td width='120' align='center' style='font-size:20px;'>$row_web_examinee[uname]<br><span class='footer'>$eng_uname</span></td>
        	<td width='120' height='10' align='center' style='font-size:18px;'>測驗日期<br><span class='score'>Test Date</span></td>
        	<td width='120' align='center'><span style='font-size: 8px;'>&nbsp;<br/></span><span class='score'>$row_web_score[score_time]</span></td>
        </tr>
        <tr>
        	<td width='120' height='10' align='center' style='font-size:18px;'>出生年月日<br><span class='score'>Date of Birth</span></td>
        	<td width='120' align='center'><span style='font-size: 8px;'>&nbsp;<br/></span><span class='score'>$row_web_examinee[birthday]</span></td>
        	<td width='120' height='10' align='center' style='font-size:18px;'>准考證號碼<br><span class='score'>Reg. No.</span></td>
        	<td width='120' align='center'><span style='font-size: 6px;'>&nbsp;<br/></span><span class='score'>$row_web_examinee[id_number]</span></td>
        </tr>
        <tr>
        	<td width='120' height='10' align='center' style='font-size:18px;'>身份證字號<br><span class='score'>ID. No</span></td>
        	<td width='120' align='center'><span style='font-size: 6px;'>&nbsp;<br/></span><span class='score'>$row_web_examinee[per_id]</span></td>
        	<td width='120' height='10' align='center' style='font-size:18px;'>測驗成績<br><span class='score'>Test Score</span></td>
        	<td width='120' align='center'><span style='font-size: 8px;'>&nbsp;<br/></span><span class='score'>$scoreSub</span></td>
        </tr>
        <tr><td height='10' align='center' style='font-size:18px;'colspan='4'>表現層級 <span class='score'>Level</span></td></tr>
        <tr><td align='center' style='font-size:20px;'colspan='4'>$levelSub</td></tr>
    </table>
	<table>
		<tr><td colspan='3'><span style='font-size: 8px;'>$note</span><span style='font-size: 12px;'>成績效期：成績公布日$pub_time 起算三年内有效</span></td></tr>
		<tr><td width='120'></td>
        	<td width='120' align='right'></td>
        	<td width='240' colspan='2'><span style='font-size: 14px;'><br><br>教師專業能力測驗中心</span><br>
			<span style='font-size: 10px;'>(教育部104年7月14日臺教師(二)字第1040091018號函委託國立臺中教育大學辦理)
        		<br>地址：臺中市西區民生路140號
				<br>電話：(04) 2218-3651
				<br>網站：</span><span class='footer'>https://tl-assessment.ntcu.edu.tw</span>
        	</td>
        </tr>
		
    </table>
EOF;
$html=str_replace("'",'"',$html);

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
ob_start();
$pdfName="Score_$row_web_score[score_id].pdf";
$pdf->Output($pdfName, 'I');
ob_end_flush();
?>