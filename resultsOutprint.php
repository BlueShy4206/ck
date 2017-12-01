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

$maxRows_web_news = 12;
$pageNum_web_news = 0;
if (isset($_GET['pageNum_web_news'])) {
	$pageNum_web_news = $_GET['pageNum_web_news'];
}
$startRow_web_news = $pageNum_web_news * $maxRows_web_news;

$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
	$colname_web_member = $_SESSION['MM_Username'];
}

mysql_select_db($database_conn_web, $conn_web);
$query_examyear = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$web_examyear = mysql_query($query_examyear, $conn_web) or die(mysql_error());
$row_examyear = mysql_fetch_assoc($web_examyear);

$todayyear = $row_examyear['times'];
$todayyear .= date("Y");
mysql_select_db($database_conn_web, $conn_web); //`id` `name` `school` `Student_ID` `Department` `Grade`
$query_web_news = sprintf("SELECT ff.id, name, school, Student_ID, Department, Grade, chinese_level, a1.no level_eng1, chinese, math_level, a2.no level_eng2, math, social_level, a3.no level_eng3, social, physical_level, a4.no level_eng4, physical, ff.note, note2, note3, note4 
		FROM forfirst as ff left join allguide as a1 ON ff.chinese_level = a1.nm 
		left join allguide as a2 ON ff.math_level = a2.nm 
		left join allguide as a3 ON ff.social_level = a3.nm 
		left join allguide as a4 ON ff.physical_level = a4.nm WHERE ff.id = %s ORDER BY id ASC", GetSQLValueString($colname_web_member, "text"));
$query_limit_web_news = sprintf("%s LIMIT %d, %d", $query_web_news, $startRow_web_news, $maxRows_web_news);
$web_news = mysql_query($query_limit_web_news, $conn_web) or die(mysql_error());
$row_web_news = mysql_fetch_assoc($web_news);

IF($_GET['type']=='p'){
	$subjectTest="自然領域<br><span class='context'>Natural Sciences</span>";
	$scoreSub=$row_web_news['physical'];
	$levelSub=$row_web_news['physical_level']."<br><span class='score'>".$row_web_news['level_eng4']."</span>";
	$noteScore=$row_web_news['note4'];
}elseif ($_GET['type']=='c'){
	$subjectTest="國語領域<br><span class='context'>Chinese</span>";
	$scoreSub=$row_web_news['chinese'];
	$levelSub=$row_web_news['chinese_level']."<br><span class='score'>".$row_web_news['level_eng1']."</span>";
	$noteScore=$row_web_news['note'];
}elseif ($_GET['type']=='m'){
	$subjectTest="數學領域<br><span class='context'>Mathematics</span>";
	$scoreSub=$row_web_news['math'];
	$levelSub=$row_web_news['math_level']."<br><span class='score'>".$row_web_news['level_eng2']."</span>";
	$noteScore=$row_web_news['note2'];
}elseif ($_GET['type']=='s'){
	$subjectTest="社會領域<br><span class='context'>Social Sciences</span>";
	$scoreSub=$row_web_news['social'];
	$levelSub=$row_web_news['social_level']."<br><span class='score'>".$row_web_news['level_eng3']."</span>";
	$noteScore=$row_web_news['note3'];
}
if($levelSub=="") $levelSub='--';
if($scoreSub==0) $scoreSub='--';
?>

<?php session_start();?>
<?php 
// Include the main TCPDF library (search for installation path).
include_once ('Pdf/tcpdf.php');
include_once ('Pdf/config/tcpdf_config.php');
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
		$img_file = K_PATH_IMAGES.'backgroup_c.jpg';
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

//$font = new TCPDF_FONTS();
//$fontKaiu=$font->addTTFfont('Pdf/fonts/kaiu.ttf', 'TrueTypeUnicode');
//$pdf->setLanguageArray($l);
//$pdf->setFontSubsetting(true);
//$pdf->setRTL(false);
//$pdf->SetFont($fontKaiu ,'', 18,'',true);
$pdf->SetFont('cid0jp', '', 18);

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
	$img_file = K_PATH_IMAGES.'backgroup_p.jpg';
}elseif ($_GET['type']=='c'){
	$img_file = K_PATH_IMAGES.'backgroup_c.jpg';
}elseif ($_GET['type']=='m'){
	$img_file = K_PATH_IMAGES.'backgroup_m.jpg';
}elseif ($_GET['type']=='s'){
	$img_file = K_PATH_IMAGES.'backgroup_s.jpg';
}
$pdf->Image($img_file, 0, 0, 148, 130, 'JPEG', '', '', false, 300, 'L', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

$html = <<<EOF
<style type="text/css">			
 .title {
		font-family: "Times New Roman", Georgia, Serif;
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
	font-size: 8pt;
}
 .nameC {
	font-family:新細明體;
	font-size: 16pt;
}
</style>
			<table width='500' border='0' cellspacing='0' cellpadding='0' valign='top'>
		<tr>
			<td align='center' colspan='4'><br><p><font size='+3' >104年師資生學科知能評量</font></p></td>
		</tr>
		<tr>
			<td align='center' colspan='4'>成績單<span class="title"> Test Score Report </span></td>
		</tr>
	</table>
	<table width='500' border='1' cellspacing='0' cellpadding='0' >
        <tr>
        	<td width='120' height='10' align='center' style='font-size:18px;'>姓名<br><span class="score">Name</span></td>
        	<td width='120' align='center' valign="middle"><span style="font-size: 8px;">&nbsp;<br/></span>$row_web_news[name]</td>
        	<td width='120' height='10' align='center' style='font-size:18px;'>准考證號碼<br><span class="score">Reg. No.</span></td>
        	<td width='120' align='center' style='font-size:20px;'><span style="font-size: 8px;">&nbsp;<br/></span>$row_web_news[id]</td>
        </tr>
        <tr>
        	<td width='120' height='10' align='center' style='font-size:18px;'>評量科目<br><span class="score">Test Subject</span></td>
        	<td width='120' align='center' valign='middle' style='font-size:20px;'>$subjectTest</td>
        	<td width='120' height='10' align='center' style='font-size:18px;'>測驗成績<br><span class="score">Test Score</span></td>
        	<td align='center' valign='middle' style='font-size:20px;'><span style="font-size: 8px;">&nbsp;<br/></span>$scoreSub</td>
        </tr>
        <tr>
        	<td height='10' height='10' align='center' style='font-size:18px;'>表現層級<br><span class="score"> Level</span></td>
        	<td colspan='3' align='center' valign='middle' style='font-size:20px;'>$levelSub</td>
        </tr>
        <tr>
        	<td height='10'  height='10' align='center' style='font-size:18px;'>備註 <br><span class="score">Remark</span></td>
        	<td colspan='3' align='center' valign='middle' style='font-size:14px;'><span style="font-size: 8px;">&nbsp;<br/></span>$noteScore</td>
        </tr>
	</table>
	<table>
        <tr><td colspan='3' height='50'><span style='font-size: 12px;'>成績效期：成績公布(104年8月1日)起算三年内有效</span></td></tr>
        <tr><td width='120'></td>
        	<td width='120' align='right'></td>
        	<td width='240' colspan='2'><span style='font-size: 18px;'>教師專業能力測驗中心</span><br>
			<span style='font-size: 10px;'>(教育部104年7月14日臺教師(二)字第1040091018號委託國立臺中教育大學辦理)
        		<br>地址：臺中市西區民生路140號
				<br>電話：(04)2218-3651
				<br>網站：</span><span class="footer">https://tl-assessment.ntcu.edu.tw</span>
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
$pdfName="Score_$row_web_news[id].pdf";
$pdf->Output($pdfName, 'I');
ob_end_flush();
?>

