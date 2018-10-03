<?php
$picname_t=array(
	"1" 		=> "國民身分證正面",
	"2" 		=> "國民身分證反面",
	"3" 		=> "學生證正面",					//exam_id 1
	"4" 		=> "修畢師資職前教育<br>證明書",  //exam_id 2
	"4n" 		=> "修畢師資職前教育證明書",
	"5" 		=> "實習學生證",					//exam_id 3
	"6" 		=> "國小教師證書",			   //exam_id 4
	"rename"	=> "戶口名簿"   ,
	"hpic"		=> "大頭照",
	"sp1"		=> "特殊考場服務申請表",
	"sp2"		=> "應考服務診斷證明書",
	"sp3"		=> "身心障礙應考人切結書"
);

$picname=array(
	"1" 		=> "國民身分證正面",			//exam_id 1,exam_id 2,exam_id 3
	"2" 		=> "國民身分證反面",			//exam_id 1,exam_id 2,exam_id 3
	"3" 		=> "最高學歷學位證書",			//exam_id 1,exam_id 2,exam_id 3
	"4" 		=> "國民小學教師證書",  		//exam_id 1,exam_id 2,exam_id 3
	"5" 		=> "在職證明書",					//exam_id 1,exam_id 2
	"6" 		=> "申請應考切結書",					//exam_id 1,exam_id 2
	"rename"	=> "戶口名簿"   ,
	"hpic"		=> "大頭照",
	"sp1"		=> "特殊考場服務申請表",
	"sp2"		=> "應考服務診斷證明書",
	"sp3"		=> "身心障礙應考人切結書"

);

function upload_pic($pictitle,$_file_){

	//大頭照路徑
	if($pictitle=='hpic'){
		$pic_num="";
		$s_path='images/smallPic/';
		$path='images/examinee/';
	}elseif(is_numeric($pictitle)){
		$pic_num="_".$pictitle;
		$s_path='images/smallPic/id_check/';
		$path='images/examinee/id_check/';
	}elseif(strpos($pictitle,'sp') !== false){
		$pic_num="_sp".substr($pictitle, -1);
		$s_path='images/smallPic/id_check/';
		$path='images/examinee/id_check/';
	}elseif(strpos($pictitle,'rename') !== false){
		$pic_num="_rename";
		$s_path='images/smallPic/id_check/';
		$path='images/examinee/id_check/';
	}
	$errStr = "";
	$_name_ = $_file_['name'];
	$_type_ = $_file_['type'];
	$_tmp_name_ = $_file_['tmp_name'];
	$_size_ = $_file_['size'];
	header ('Content-type: text/html; charset=utf-8');//指定編碼
	if($_size_ > MAX_PIC_SIZE && MAX_PIC_SIZE > 0){
		$errStr = "File troppo pesante";
		echo "<script>javascript:alert(\"超過限制檔案大小\");</script>";//跳出錯誤訊息
	}
	$_ext_ = explode(".", $_name_);
	$attach = $_POST['username'];
	$_ext_ = strtolower($_ext_[count($_ext_)-1]);
	$news_pic_title=$_file_['name'];
	$pic_type = $_file_['type'];
	//echo "$pic_type";

	//取原圖的大小進行比例處理
	switch ($pic_type){
		case "image/jpeg":
			$src2 = imagecreatefromjpeg($_FILES[$pictitle]['tmp_name']);
			break;
		case "image/png":
			$src2 = imagecreatefrompng($_FILES[$pictitle]['tmp_name']);
			break;
		case "image/gif":
			$src2 = imagecreatefromgif($_FILES[$pictitle]['tmp_name']);
			break;
	}
	$src_w2 = imagesx($src2);
	$src_h2 = imagesy($src2);
	if($pictitle=='upload_hpic'){
		if($src_w2 > 100){
			$thumb_w2 = intval($src_h2 / $src_w2 * 100);
			$thumb_h2 = intval($src_h2 / $src_w2 * 130);
		}else{
			$thumb_h2 = intval($src_w2 / $src_h2 * 130);
			$thumb_w2 = intval($src_w2 / $src_h2 * 100);
		}
	}elseif($pictitle=='news_pic3'){
		$thumb_w2 = intval(500/ $src_h2 * $src_w2);
		$thumb_h2 = intval(500 / $src_h2 * $src_h2);
	}else{
		$thumb_w2 = intval(300/ $src_w2 * $src_w2);
		$thumb_h2 = intval(300 / $src_w2 * $src_h2);
	}
	if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
		$errStr = "Estensione non valida";
		echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
	}
	if(!is_dir($path) && is_writeable($path)){
		$errStr = "Cartella di destinazione non valida";
		echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
	}
	if(empty($errStr)){
		$newPicname=date("YmdHis")."_".$attach.$pic_num.".$_ext_";//如果更新圖片，變數$newname就重新取得新檔案名稱
		//進行縮圖
		$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
		imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
		switch ($pic_type){
			case "image/jpeg":
				$resultOK= imagejpeg($thumb2, $s_path.$newPicname);
				break;
			case "image/png":
				$resultOK= imagepng($thumb2, $s_path.$newPicname);
				break;
			case "image/gif":
				$resultOK= imagegif($thumb2, $s_path.$newPicname);
				break;
		}

		if(@copy($_tmp_name_, $path.$newPicname)){//修改檔案名稱
			@unlink($path.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它
			//header("Location: " . no_error);
		} else {
			echo "<script>javascript:alert(\"發生錯誤1!\");</script>";//跳出錯誤訊息
			echo "<script>history.back()</script>";//回上一頁
			exit;                                  //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}
	} else {
		echo "<script>javascript:alert(\"發生錯誤2!\");</script>";//跳出錯誤訊息
		echo "<script>history.back()</script>";//回上一頁
	    exit;	                               //停止後續程式碼的繼續執行
		//header("Location: " . yes_error);
	}
	$pic_name=array($news_pic_title,$newPicname);
	return $pic_name;
}

//驗證台灣手機號碼
function isPhone($str) {
    if (preg_match("/^09[0-9]{2}-[0-9]{3}-[0-9]{3}$/", $str)) {
		$phone_info=array(true,'1');
        return $phone_info;    // 09xx-xxx-xxx
    } else if(preg_match("/^09[0-9]{2}-[0-9]{6}$/", $str)) {
		$phone_info=array(true,'2');
        return $phone_info;    // 09xx-xxxxxx
    } else if(preg_match("/^09[0-9]{8}$/", $str)) {
		$phone_info=array(true,'3');
        return $phone_info;    // 09xxxxxxxx
    } else {
        return false;
    }
}

//驗證台灣身份證字號
function isTWID($id){
    $id=strtoupper($id);
    $d0=strlen($id);
    if ($d0 <= 0) {return false;}
    if ($d0 > 10) {return false;}
    if ($d0 < 10 && $d0 > 0) {return false;}
    $d1=substr($id,0,1);
    $ds=ord($d1);
    if ($ds > 90 || $ds < 65) {return false;}
    $d2=substr($id,1,1);
    if($d2!="1" && $d2!="2") {return false;}
    for ($i=1;$i<10;$i++) {
        $d3=substr($id,$i,1);
        $ds=ord($d3);
        if ($ds > 57 || $ds < 48) {
            $n=$i+1;
            return false;
            break;
        }
    }
    $num=array("A" => "10","B" => "11","C" => "12","D" => "13","E" => "14",
        "F" => "15","G" => "16","H" => "17","J" => "18","K" => "19","L" => "20",
        "M" => "21","N" => "22","P" => "23","Q" => "24","R" => "25","S" => "26",
        "T" => "27","U" => "28","V" => "29","X" => "30","Y" => "31","W" => "32",
        "Z" => "33","I" => "34","O" => "35");
    $n1=substr($num[$d1],0,1)+(substr($num[$d1],1,1)*9);
    $n2=0;
    for ($j=1;$j<9;$j++) {
        $d4=substr($id,$j,1);
        $n2=$n2+$d4*(9-$j);
    }
    $n3=$n1+$n2+substr($id,9,1);
    if(($n3 % 10)!=0) {return false;}
    return true;
}

$TestingRegulations_s=['<u>應考人應攜帶身分證明文件正本（<strong>國民身分證</strong>或有效駕照、護照）到場應試。</u>未能提供身分證明文件正本者，經監試委員拍照存證後，得先准予應試，惟身分證明文件正本至應考人最後一節評量結束鈴（鐘）響畢前仍未送達者，所有領域不予計分。',
						'應考人除身分證明文件正本外，其他非應試用品均 須置於教室前面地板上，不得攜帶入座。',
						'本次評量將由試務單位依領域性質提供計算紙及原子筆供試題計算用，應考人試後計算紙不得攜出考場，違者該領域不予計分。',
						'評量開始後逾15分鐘即不得入場應試；評量未達25分鐘不得離開考場，強行出場者，該領域不予計分。',
						'評量進行間行動電話、計時器及其他電子設備不得發出任何聲響（含振動聲），違者將扣減該領域成績50分，並得視違規情節加重扣分或不予計分。',
						'應考人不得破壞考場的配置（例如撕開或未經監試委員同意即自行帶走座位貼條、自行調整電腦螢幕亮度、自行離開測驗系統全螢幕、未經監試委員同意先行輸入測驗系統帳號與密碼…等），違者將扣減該領域成績50分，並得視違規情節加重扣分或不予計分。',
						'除在規定處作答擬稿外，不得在身分證明文件、文具、桌面、肢體上或其他物品上書寫任何文字、符號等，違者以監試委員發現時之評量領域不予計分。',
						'應考人作答結束時，應舉手並於原位靜候監試委員前往回收計算紙，並依監試委員指示始能離場，違者該領域作答不予計分。',
						'應考人因個人因素致延遲進入試場，須於評量結束鈴響時立即停止作答並在原位靜候，違者該領域作答不予計分。',
						'其他未盡事宜，除依本中心訂頒之試場規則辦理外，由各該考區負責人處理之。'];

$TestingRegulations_t=['<u>應考人應攜帶身分證明文件正本（<strong>國民身分證</strong>或有效駕照、護照）到場應試。</u>未能提供身分證明文件者正本，經監試委員拍照存證後，得先准予應試，惟身分證明文件正本至當日評量結束鈴(鐘)響畢前仍未送達者，則作答結果不予計分。',
						'應考人除身分證明文件正本外，其他非應試用品均須置於教室前面地板上，不得攜帶入座。',
						'本次評量將由試務單位依領域性質提供計算紙及原子筆供試題計算用，應考人試後計算紙不得攜出考場，違者該領域不予計分。',
						'評量開始後逾15分鐘即不得入場應試；評量未達25分鐘不得離開考場，強行出場者，該領域不予計分。',
						'評量進行間行動電話、計時器及其他電子設備不得發出任何聲響（含振動聲），違者將扣減該領域成績50分，並得視違規情節加重扣分或不予計分。',
						'應考人不得破壞考場的配置（例如撕開或未經監試委員同意即自行帶走座位貼條、自行調整電腦螢幕亮度、自行離開測驗系統全螢幕、未經監試委員同意先行輸入測驗系統帳號與密碼…等），違者將扣減該領域成績50分，並得視違規情節加重扣分或不予計分。',
						'除在規定處作答擬稿外，不得在身分證明文件、文具、桌面、肢體上或其他物品上書寫任何文字、符號等，違者以監試委員發現時之評量領域不予計分。',
						'應考人作答結束時，應舉手並於原位靜候監試委員前往回收計算紙，並依監試委員指示始能離場，違者該領域作答不予計分。',
						'應考人因個人因素致延遲進入試場，須於評量結束鈴響時立即停止作答並在原位靜候，違者該領域作答不予計分。',
						'其他未盡事宜，除依本中心訂頒之試場規則辦理外，由各該考區負責人處理之。'];
 ?>
