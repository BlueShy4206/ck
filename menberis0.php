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


mysql_select_db($database_conn_web, $conn_web);
$query_web_banner1 = "SELECT * FROM banner WHERE banner_type = '1' ORDER BY rand() limit 1";
$web_banner1 = mysql_query($query_web_banner1, $conn_web) or die(mysql_error());
$row_web_banner1 = mysql_fetch_assoc($web_banner1);
$totalRows_web_banner1 = mysql_num_rows($web_banner1);

mysql_select_db($database_conn_web, $conn_web);
$query_web_banner2 = "SELECT * FROM banner WHERE banner_type = '2' OR banner_type = '3' order by rand() limit 1  ";
$web_banner2 = mysql_query($query_web_banner2, $conn_web) or die(mysql_error());
$row_web_banner2 = mysql_fetch_assoc($web_banner2);
$totalRows_web_banner2 = mysql_num_rows($web_banner2);

?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>國民小學教師學科知能評量</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="國民小學教師學科知能評量" />
<meta name="keywords" content="國民小學教師學科知能評量" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]><script src="ie6png.js" type="text/javascript"></script><![endif]-->
<script type="text/javascript" src="js/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<style>
/* The container */
.container {
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 15px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #ccc;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
    left: 6px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}
</style>
<script type="text/javascript">


$(document).ready(function() {
    //set initial state.
    var str=document.getElementsByName("checkbox[]");
    var objarray=str.length;//總checkbox數量

    var iCnt=0;
    //判斷checkbox是否已全部勾選
    for (i=0;i<objarray;i++){
         if(str[i].checked == true){iCnt++;}
    }
    if( iCnt != objarray)
    {
        document.getElementById("btnOK").disabled = true;
    }else{
        document.getElementById("btnOK").disabled = false;
    }
    $('[type="checkbox"]').click(function(){
        var str=document.getElementsByName("checkbox[]");
        var objarray=str.length;//總checkbox數量

        var iCnt=0;
		//判斷checkbox是否已全部勾選
		for (i=0;i<objarray;i++){
			 if(str[i].checked == true){iCnt++;}
		}
        if( iCnt != objarray)
		{
            document.getElementById("btnOK").disabled = true;
        }else{
            document.getElementById("btnOK").disabled = false;
        }
		// alert('changed'+iCnt);
	})
});
</script>
</head>

<body onload="MM_preloadImages('images/index_button2.png','images/aboutCK_button2.png','images/download_button2.png','images/Q&A_button2.png')" background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">

  <div id="main2">
      <?php include("leftzone.php")?>
  </div>
  <div id="main1">
      <table width="545" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20">
          <marquee onMouseOver="this.stop()" onMouseOut="this.start()" bgcolor="#efefef" border="0" align="middle" scrollamount="2"  scrolldelay="90" behavior="scroll"  width="100%" height="20" style="color: #000000; font-size: 12">
            <a href="<?php echo $row_web_banner1['banner_url']; ?>"><img src="images/hot.gif" width="28" height="7" border="0" /><?php echo $row_web_banner1['banner_title']; ?></a>
          </marquee>
        </td>
      </tr>
    </table>
    <br/>
  </div>
  <div style="width: 540px;background-color:#FFFFFF">
      <form>
	  <table width="540" border="0" cellspacing="0" cellpadding="0">
	    <tr>
         <p><font size="2">
         歡迎成為教師專業能力測驗中心會員！感謝您使用我們的服務(以下簡稱「服務」)。為配合「個人資料保護法」並保障您的權益，
         請於使用本網站服務前，務必詳細閱讀下列同意書所有內容，當您勾選完畢並點選下方「我同意」時，表示您已閱讀明瞭並已同意遵守本同意書所載之事項。</font></p>
</tr>
</table>
<div style='text-align:center'>
<p><span style="font-size:15px; color:#820000;"><label class="container"><b>網路使用規範</b>
    <input type="checkbox" id="checkbox" name="checkbox[]">
<span class="checkmark"></span>
</label></span></p>
<HR style="width: 80%">
</div>
 <table width="540">



         <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                 1.	您一旦使用教師專業能力測驗中心所提供之任何服務，即表示同意並願意遵守下列規定，以共同維護教師專業能力測驗中心的安全及品質。 <br />
                </td>
         </tr>

         <tr>
             <td style="vertical-align: top;">
                 <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
             </td>
             <td>
                 2.	教師專業能力測驗中心有權隨時修改網站使用規範，並將於首頁公告修改事實，或以E-mail另行個別通知。<br />
             </td>
         </tr>

</table>
         <div style='text-align:center'>
         <p><span style="font-size:15px; color:#820000;"><label class="container"><b>會員權益</b>
             <input type="checkbox" id="checkbox" name="checkbox[]">
         <span class="checkmark"></span>
         </label></span></p>
         <HR style="width: 80%">
         </div>
         <table>
         <tr>
             <td style="vertical-align: top;">
                 <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
             </td>
             <td>
                 1.	教師專業能力測驗中心對於個人資料的保護遵守「個人資料保護法」之規範。除非符合個人資料保護法規定，教師專業能力測驗中心不會蒐集、處理、利用使用者的個人資料，或將之傳遞予第三者。<br />
             </td>
         </tr>
         <tr>
             <td style="vertical-align: top;">
                 <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
             </td>
             <td>
                 2.	您的個人資料接受到嚴密保護，教師專業能力測驗中心網站維護人員不得私自使用、洩漏或協助洩漏您的個人資料。<br />
             </td>
         </tr>
         <tr>
             <td style="vertical-align: top;">
                 <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
             </td>
             <td>
                 3.	教師專業能力測驗中心伺服器使用網站分析軟體紀錄網頁被瀏覽的方式及流量所來自的網域名稱等資訊。從紀錄檔所得來的資訊並不涉及使用者個人身份，將作為內容、服務及系統改進的依據。<br />
             </td>
         </tr>
         <tr>
             <td style="vertical-align: top;">
                 <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
             </td>
             <td>
                 4.	在未獲得您書面同意之前，教師專業能力測驗中心不會公開您的姓名、地址及其他依法受保護的個人資訊。<br />
             </td>
         </tr>
     </table>

          <div style='text-align:center'>
         <p><span style="font-size:15px; color:#820000;"><label class="container"><b>會員義務</b>
             <input type="checkbox" id="checkbox" name="checkbox[]">
         <span class="checkmark"></span>
         </label></span></p>
         <HR style="width: 80%">
         </div>
         <table>
             <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                     1.	首次登記會員時，請務必提供完整詳實的個人資料，經查證後如非屬實，本網站有權於任何時間取消您的會員資格。且如因個人資料不實導致產生糾紛或損失時，會員應自負完全責任。<br />
                 </td>
             </tr>
             <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                     2.	註冊取得帳號及密碼後，您有妥善保管的義務。該帳號及密碼僅限您本人持有或使用，不得出借、轉讓、轉售或以各種形式洩漏或提供給第三人。若因此造成個人資料外洩、遺失、或無法正常使用之情況，概由您自行負責，教師專業能力測驗中心並保留拒絕您使用本站服務或再行於本站註冊之權利。您必須為使用此組帳號及密碼登入系統後，所從事之一切活動及行為負責。 <br />
                 </td>
             </tr>
             <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                     3.	若您發現帳號及密碼遭人冒用、有任何異常、或破壞使用安全的情形時，應立即通知教師專業能力測驗中心。本網站將於獲悉您的帳號及密碼遭冒用時，立即暫停該帳號所發生交易之處理及後續利用。 <br />
                 </td>
             </tr>
             <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                     4.	若教師專業能力測驗中心決定您的行為違反本規範或任何法令，得隨時停止您使用教師專業能力測驗中心之相關服務。 <br />
                 </td>
             </tr>
             <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                     5.	您對公布於教師專業能力測驗中心上傳輸的一切資訊內容負完全責任。 <br />
                 </td>
             </tr>
             <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                     6.	您瞭解必須完整填寫所有報名表所要求之個資等資訊，如遺漏任何一項，即無法完成報名。 <br />
                 </td>
             </tr>
         </table>

         <div style='text-align:center'>
         <p><span style="font-size:15px; color:#820000;"><label class="container"><b>會員應遵守之法律及承諾</b>
             <input type="checkbox" id="checkbox" name="checkbox[]">
         <span class="checkmark"></span>
         </label></span></p>
         <HR style="width: 80%">
         </div>
         <table>
             <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                     1.	本網站所有資料，均受中華民國著作權法及智慧財產權相關法律保護，未得本網站同意，不得使用本網站上任何形式所呈現之資料。請充分尊重著作權及智慧財產權，違者依法辦理。 <br />
                 </td>
             </tr>
             <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                     2.	您承諾遵守中華民國相關法規及一切國際網際網路規定與慣例。您同意並保證不公布或傳送任何毀謗、不實、威脅、不雅、猥褻、不法或侵害他人權利的資訊，並不從事廣告或販賣商品行為。應維護網路公用空間使用者的權益，留言切勿流於人身攻擊及出現不雅文字，本網站保留最終刪除權利，無須告知個別會員。若經勸導而仍犯者，本網站有權停止個別會員之帳號及其相關服務，個別會員不得要求任何補償或賠償。情節嚴重者，本網站將可拒絕個別會員申請其他帳號。 <br />
                 </td>
             </tr>
         </table>
         <div style='text-align:center'>
         <p><span style="font-size:15px; color:#820000;"><label class="container"><b>服務中斷條款</b>
             <input type="checkbox" id="checkbox" name="checkbox[]">
         <span class="checkmark"></span>
         </label></span></p>
         <HR style="width: 80%">
         </div>
         <table>
             <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                     1.	本網站保留隨時更改或停止各項服務內容，或終止任一會員帳戶服務之權利，且無須事先通知，會員不得因此要求任何補償或賠償。 <br />
                 </td>
             </tr>
             <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                     2.	發生下列情形之一時，教師專業能力測驗中心有權停止或中斷提供服務： <br />
                        (1)對教師專業能力測驗中心主機、網路等電子通信設備進行必要之保養及施工時。 <br />
                        (2)發生突發性設備故障時。 <br />
                        (3)教師專業能力測驗中心所申請之電子通信服務不問任何原因被停止，無法提供服務時。 <br />
                        (4)天災、事變等不可抗力之因素致使教師專業能力測驗中心無法提供服務時。 <br />
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                </td>
                <td>
                    3.	瞭解並同意教師專業能力測驗中心可能因中心、其他協力廠商或相關電信業者網路系統軟硬體設備之故障或失靈、或人為操作上之疏失而全部或一部中斷、暫時無法使用、遲延、或造成資料傳輸或儲存上之錯誤、或遭第三人侵入系統篡改或偽造變造資料等，不得因此而要求任何補償或賠償。 <br />
                </td>
            </tr>
        </table>


         <div style='text-align:center'>
         <p><span style="font-size:15px; color:#820000;"><label class="container"><b>擔保責任免除</b>
             <input type="checkbox" id="checkbox" name="checkbox[]">
         <span class="checkmark"></span>
         </label></span></p>
         <HR style="width: 80%">
         </div>
         <table>
             <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                     教師專業能力測驗中心就各項服務，不負任何明示或暗示的擔保責任。教師專業能力測驗中心不保證各項服務的穩定、安全、無誤、及不中斷。您同意承擔使用本服務的風險及可能導致的任何損害。<br >
                 </td>
             </tr>
         </table>

         <div style='text-align:center'>
         <p><span style="font-size:15px; color:#820000;"><label class="container"><b>賠償責任限制</b>
             <input type="checkbox" id="checkbox" name="checkbox[]">
         <span class="checkmark"></span>
         </label></span></p>
         <HR style="width: 80%">
         </div>
         <table>
             <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                     教師專業能力測驗中心對於因不可抗力之因素，無法使用各項服務所導致的任何直接、間接、衍生或特別損害，不負任何賠償責任。若使用之服務係有對價者，教師專業能力測驗中心僅就您所付的對價範圍內，負賠償責任。<br >
                 </td>
             </tr>
         </table>

         <div style='text-align:center'>
         <p><span style="font-size:15px; color:#820000;"><label class="container"><b>準據法與管轄法院</b>
             <input type="checkbox" id="checkbox" name="checkbox[]">
         <span class="checkmark"></span>
         </label></span></p>
         <HR style="width: 80%">
         </div>
         <table>
             <tr>
                 <td style="vertical-align: top;">
                     <!-- <input type="checkbox" name="checkbox[]" value="1" id="checkbox" /> -->
                 </td>
                 <td>
                     本同意書之解釋及適用、以及因使用本服務而與教師專業能力測驗中心間所生之權利義務關係，應依中華民國法令解釋適用之。其因此所生之爭議，以台灣台中地方法院為第一審管轄法院。<br >
                 </td>
             </tr>
         </table>
         </form>
  </div>
  <div id="main4">
	  <table width="540" border="0" cellspacing="0" cellpadding="0">
		  <tr>
	          <td height="40" colspan="3" align="center"><label>
	            <input type="button" name="btnOK" id="btnOK" disabled value="我同意" onclick="location.href='memberAdd.php'" />
	           </label>
	          <label>
	            <input type="button" name="btnDeny" id="btnDeny" value="我不同意" onclick="location.href='index.php'" />

	          </label></td>
	       </tr>
	  </table>

  </div>

<?php include("footer.php"); ?>
</div>
</body>
</html>
<?php

mysql_free_result($web_banner1);

mysql_free_result($web_banner2);

?>
