<?php
$picname_t=array(
	"1" 		=> "國民身分證正面",
	"2" 		=> "國民身分證反面",
	"3" 		=> "學生證正面",
	"4" 		=> "修畢師資職前教育<br>證明書",
	"5" 		=> "實習學生證",
	"6" 		=> "國小教師證書",
	"rename"	=> "戶口名簿"   ,
	"hpic"		=> "大頭照",
	"sp1"		=> "特殊考場服務申請表",
	"sp2"		=> "應考服務診斷證明書",
	"sp3"		=> "應考切結書"

);

function upload_pic($pictitle,$_file_){

	print_r($_file_);
	// die();
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
			$src2 = imagecreatefromjpeg($_FILES['upload_hpic']['tmp_name']);
			break;
		case "image/png":
			$src2 = imagecreatefrompng($_FILES['upload_hpic']['tmp_name']);
			break;
		case "image/gif":
			$src2 = imagecreatefromgif($_FILES['upload_hpic']['tmp_name']);
			break;
	}
	$src_w2 = imagesx($src2);
	$src_h2 = imagesy($src2);
	if($src_w2 > 100){
		$thumb_w2 = intval($src_h2 / $src_w2 * 100);
		$thumb_h2 = intval($src_h2 / $src_w2 * 130);
	}else{
		$thumb_h2 = intval($src_w2 / $src_h2 * 130);
		$thumb_w2 = intval($src_w2 / $src_h2 * 100);
	}
echo $thumb_h2."<br>".$thumb_w2;
die();
	if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
		$errStr = "Estensione non valida";
		echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
	}
	if(!is_dir(DESTINATION_PIC_FOLDER) && is_writeable(DESTINATION_PIC_FOLDER)){
		$errStr = "Cartella di destinazione non valida";
		echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
	}
	if(empty($errStr)){
		$newPicname=date("YmdHis")."_$attach.".$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱
		//進行縮圖
		$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
		imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
		switch ($pic_type){
			case "image/jpeg":
				$resultOK= imagejpeg($thumb2, "images/smallPic/".$newPicname);
				break;
			case "image/png":
				$resultOK= imagepng($thumb2, "images/smallPic/".$newPicname);
				break;
			case "image/gif":
				$resultOK= imagegif($thumb2, "images/smallPic/".$newPicname);
				break;
		}


		if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER . "/" . $newPicname)){//修改檔案名稱
			@unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它
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

}



 ?>
