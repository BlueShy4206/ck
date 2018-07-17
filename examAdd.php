<?php require_once('login_check.php');
require_once "PEAR183/HTML/QuickForm.php";
require_once "examAdd_function.php";
?>
<?php
header("Cache-control:private");//解決session 引起的回上一頁表單被清空
?>

<?php
//	---------------------------------------------
//  師資生報名頁面
//	-------------------------------------------

if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}
define("MAX_PIC_SIZE",3000000);
define("DESTINATION_PIC_FOLDER", "images/examinee");
define("DESTINATION_PIC_FOLDER_ID", "images/examinee/id_check");
define("no_error", "examOut.php");
define("yes_error", "examAdd2.php");

$_accepted_PIC_extensions_ = "jpg,gif,png";
if(strlen($_accepted_PIC_extensions_) > 0){
	$_accepted_PIC_extensions_ = @explode(",",$_accepted_PIC_extensions_);
} else{
	$_accepted_PIC_extensions_ = array();
}
/*	modify */
@$news_pic_title=$_POST["oldPictitle"];
@$newPicname=$_POST["oldPic"]; //變數$news_pic_title先儲存之前舊圖片檔名，如果沒有更新圖片，news_pic圖片欄位就繼續存入舊圖檔名
if(!empty($HTTP_POST_FILES['upload_hpic'])){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['upload_hpic']['tmp_name']) && $HTTP_POST_FILES['upload_hpic']['error'] == 0){
		$_file_ = $HTTP_POST_FILES['upload_hpic'];
		upload_pic('upload_hpic',$_file_);
		print_r($_file_);
		die();
		// $errStr = "";
		// $_name_ = $_file_['name'];
		// $_type_ = $_file_['type'];
		// $_tmp_name_ = $_file_['tmp_name'];
		// $_size_ = $_file_['size'];
		// header ('Content-type: text/html; charset=utf-8');//指定編碼
		// if($_size_ > MAX_PIC_SIZE && MAX_PIC_SIZE > 0){
		// 	$errStr = "File troppo pesante";
		// 	echo "<script>javascript:alert(\"超過限制檔案大小\");</script>";//跳出錯誤訊息
		// }
		// $_ext_ = explode(".", $_name_);
		// $attach = $_POST['username'];
		// $_ext_ = strtolower($_ext_[count($_ext_)-1]);
		// $news_pic_title=$_file_['name'];
		// $pic_type = $_file_['type'];
		// //echo "$pic_type";
		//
		// //取原圖的大小進行比例處理
		// switch ($pic_type){
		// 	case "image/jpeg":
		// 		$src2 = imagecreatefromjpeg($_FILES['upload_hpic']['tmp_name']);
		// 		break;
		// 	case "image/png":
		// 		$src2 = imagecreatefrompng($_FILES['upload_hpic']['tmp_name']);
		// 		break;
		// 	case "image/gif":
		// 		$src2 = imagecreatefromgif($_FILES['upload_hpic']['tmp_name']);
		// 		break;
		// }
		// $src_w2 = imagesx($src2);
		// $src_h2 = imagesy($src2);
		// if($src_w2 > 100){
		// 	$thumb_w2 = intval($src_h2 / $src_w2 * 100);
		// 	$thumb_h2 = intval($src_h2 / $src_w2 * 130);
		// }else{
		// 	$thumb_h2 = intval($src_w2 / $src_h2 * 130);
		// 	$thumb_w2 = intval($src_w2 / $src_h2 * 100);
		// }
		//
		// if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
		// 	$errStr = "Estensione non valida";
		// 	echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		// }
		// if(!is_dir(DESTINATION_PIC_FOLDER) && is_writeable(DESTINATION_PIC_FOLDER)){
		// 	$errStr = "Cartella di destinazione non valida";
		// 	echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		// }
		// if(empty($errStr)){
		// 	$newPicname=date("YmdHis")."_$attach.".$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱
		// 	//進行縮圖
		// 	$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
		// 	imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
		// 	switch ($pic_type){
		// 		case "image/jpeg":
		// 			$resultOK= imagejpeg($thumb2, "images/smallPic/".$newPicname);
		// 			break;
		// 		case "image/png":
		// 			$resultOK= imagepng($thumb2, "images/smallPic/".$newPicname);
		// 			break;
		// 		case "image/gif":
		// 			$resultOK= imagegif($thumb2, "images/smallPic/".$newPicname);
		// 			break;
		// 	}
		//
		//
		// 	if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER . "/" . $newPicname)){//修改檔案名稱
		// 		@unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它
		// 		//header("Location: " . no_error);
		// 	} else {
		// 		echo "<script>javascript:alert(\"發生錯誤1!\");</script>";//跳出錯誤訊息
		// 		echo "<script>history.back()</script>";//回上一頁
		// 		exit;                                  //停止後續程式碼的繼續執行
		// 		//header("Location: " . yes_error);
		// 	}
		// } else {
		// 	echo "<script>javascript:alert(\"發生錯誤2!\");</script>";//跳出錯誤訊息
		// 	echo "<script>history.back()</script>";//回上一頁
		//     exit;	                               //停止後續程式碼的繼續執行
		// 	//header("Location: " . yes_error);
		// }
	}
}
//1********************  BlueS 20180302 將身分證等資料傳至網頁
if(!empty($HTTP_POST_FILES['news_pic1']) && !empty($HTTP_POST_FILES['news_pic2'])){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['news_pic1']['tmp_name']) && $HTTP_POST_FILES['news_pic1']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['news_pic1'];
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
		$news_pic_title1=$_file_['name'];
		$pic_type = $_file_['type'];
		//echo "$pic_type";

		//取原圖的大小進行比例處理
		switch ($pic_type){
			case "image/jpeg":
				$src2 = imagecreatefromjpeg($_FILES['news_pic1']['tmp_name']);
				break;
			case "image/png":
				$src2 = imagecreatefrompng($_FILES['news_pic1']['tmp_name']);
				break;
			case "image/gif":
				$src2 = imagecreatefromgif($_FILES['news_pic1']['tmp_name']);
				break;
		}
		$src_w2 = imagesx($src2);
		$src_h2 = imagesy($src2);
		// if($src_w2 > 100){
			$thumb_w2 = intval(300/ $src_w2 * $src_w2);
			$thumb_h2 = intval(300 / $src_w2 * $src_h2);
		// }else{
		// 	$thumb_h2 = intval($src_w2 / $src_h2 * 130);
		// 	$thumb_w2 = intval($src_w2 / $src_h2 * 100);
		// }

		if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_PIC_FOLDER_ID) && is_writeable(DESTINATION_PIC_FOLDER_ID)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			$newPicname1=date("YmdHis")."_".$attach."_1.".$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱

			//進行縮圖
			$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
			imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
			switch ($pic_type){
				case "image/jpeg":
					$resultOK= imagejpeg($thumb2, "images/smallPic/id_check/".$newPicname1);
					break;
				case "image/png":
					$resultOK= imagepng($thumb2, "images/smallPic/id_check/".$newPicname1);
					break;
				case "image/gif":
					$resultOK= imagegif($thumb2, "images/smallPic/id_check/".$newPicname1);
					break;
			}


			if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER_ID . "/" . $newPicname1)){//修改檔案名稱
				@unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
				//header("Location: " . no_error);
			} else {
				echo "<script>javascript:alert(\"發生錯誤1!\");</script>";//跳出錯誤訊息
				echo "<script>history.back()</script>";//回上一頁
				exit;                                  //停止後續程式碼的繼續執行
				//header("Location: " . yes_error);
			}
		} else {
			echo "<script>javascript:alert(\"發生錯誤!身分證正面有誤！\");</script>";//跳出錯誤訊息
			echo "<script>history.back()</script>";//回上一頁
				exit;	                               //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}
	}

//2********************
	if(is_uploaded_file($HTTP_POST_FILES['news_pic2']['tmp_name']) && $HTTP_POST_FILES['news_pic2']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['news_pic2'];
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
		$news_pic_title2=$_file_['name'];
		$pic_type = $_file_['type'];
		//echo "$pic_type";

		//取原圖的大小進行比例處理
		switch ($pic_type){
			case "image/jpeg":
				$src2 = imagecreatefromjpeg($_FILES['news_pic2']['tmp_name']);
				break;
			case "image/png":
				$src2 = imagecreatefrompng($_FILES['news_pic2']['tmp_name']);
				break;
			case "image/gif":
				$src2 = imagecreatefromgif($_FILES['news_pic2']['tmp_name']);
				break;
		}
		$src_w2 = imagesx($src2);
		$src_h2 = imagesy($src2);
		$thumb_w2 = intval(300/ $src_w2 * $src_w2);
		$thumb_h2 = intval(300 / $src_w2 * $src_h2);

		if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_PIC_FOLDER_ID) && is_writeable(DESTINATION_PIC_FOLDER_ID)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			$newPicname2=date("YmdHis")."_".$attach."_2.".$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱

			//進行縮圖
			$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
			imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
			switch ($pic_type){
				case "image/jpeg":
					$resultOK= imagejpeg($thumb2, "images/smallPic/id_check/".$newPicname2);
					break;
				case "image/png":
					$resultOK= imagepng($thumb2, "images/smallPic/id_check/".$newPicname2);
					break;
				case "image/gif":
					$resultOK= imagegif($thumb2, "images/smallPic/id_check/".$newPicname2);
					break;
			}


			if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER_ID . "/" . $newPicname2)){//修改檔案名稱
				@unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
				//header("Location: " . no_error);
			} else {
				echo "<script>javascript:alert(\"發生錯誤1!\");</script>";//跳出錯誤訊息
				echo "<script>history.back()</script>";//回上一頁
				exit;                                  //停止後續程式碼的繼續執行
				//header("Location: " . yes_error);
			}
		} else {
			echo "<script>javascript:alert(\"發生錯誤!身分證反面有誤！\");</script>";//跳出錯誤訊息
			echo "<script>history.back()</script>";//回上一頁
				exit;	                               //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}
	}
}
//3********************
if(!empty($HTTP_POST_FILES['news_pic3']) && $_POST['id'] == 1 ){
	if(is_uploaded_file($HTTP_POST_FILES['news_pic3']['tmp_name']) && $HTTP_POST_FILES['news_pic3']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['news_pic3'];
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
		$news_pic_title3=$_file_['name'];
		$pic_type = $_file_['type'];
		//echo "$pic_type";

		//取原圖的大小進行比例處理
		switch ($pic_type){
			case "image/jpeg":
				$src2 = imagecreatefromjpeg($_FILES['news_pic3']['tmp_name']);
				break;
			case "image/png":
				$src2 = imagecreatefrompng($_FILES['news_pic3']['tmp_name']);
				break;
			case "image/gif":
				$src2 = imagecreatefromgif($_FILES['news_pic3']['tmp_name']);
				break;
		}
		$src_w2 = imagesx($src2);
		$src_h2 = imagesy($src2);
		$thumb_w2 = intval(500/ $src_h2 * $src_w2);
		$thumb_h2 = intval(500 / $src_h2 * $src_h2);

		if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_PIC_FOLDER_ID) && is_writeable(DESTINATION_PIC_FOLDER_ID)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			$newPicname3=date("YmdHis")."_".$attach."_3.".$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱

			//進行縮圖
			$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
			imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
			switch ($pic_type){
				case "image/jpeg":
					$resultOK= imagejpeg($thumb2, "images/smallPic/id_check/".$newPicname3);
					break;
				case "image/png":
					$resultOK= imagepng($thumb2, "images/smallPic/id_check/".$newPicname3);
					break;
				case "image/gif":
					$resultOK= imagegif($thumb2, "images/smallPic/id_check/".$newPicname3);
					break;
			}


			if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER_ID . "/" . $newPicname3)){//修改檔案名稱
				@unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
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
}
//4********************
if(!empty($HTTP_POST_FILES['news_pic4']) && $_POST['id'] == 2 ){
	if(is_uploaded_file($HTTP_POST_FILES['news_pic4']['tmp_name']) && $HTTP_POST_FILES['news_pic4']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['news_pic4'];
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
		$news_pic_title4=$_file_['name'];
		$pic_type = $_file_['type'];
		//echo "$pic_type";

		//取原圖的大小進行比例處理
		switch ($pic_type){
			case "image/jpeg":
				$src2 = imagecreatefromjpeg($_FILES['news_pic4']['tmp_name']);
				break;
			case "image/png":
				$src2 = imagecreatefrompng($_FILES['news_pic4']['tmp_name']);
				break;
			case "image/gif":
				$src2 = imagecreatefromgif($_FILES['news_pic4']['tmp_name']);
				break;
		}
		$src_w2 = imagesx($src2);
		$src_h2 = imagesy($src2);
		$thumb_w2 = intval(300/ $src_w2 * $src_w2);
		$thumb_h2 = intval(300 / $src_w2 * $src_h2);

		if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_PIC_FOLDER_ID) && is_writeable(DESTINATION_PIC_FOLDER_ID)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			$newPicname4=date("YmdHis")."_".$attach."_4.".$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱

			//進行縮圖
			$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
			imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
			switch ($pic_type){
				case "image/jpeg":
					$resultOK= imagejpeg($thumb2, "images/smallPic/id_check/".$newPicname4);
					break;
				case "image/png":
					$resultOK= imagepng($thumb2, "images/smallPic/id_check/".$newPicname4);
					break;
				case "image/gif":
					$resultOK= imagegif($thumb2, "images/smallPic/id_check/".$newPicname4);
					break;
			}


			if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER_ID . "/" . $newPicname4)){//修改檔案名稱
				@unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
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
	}
//5********************
if(!empty($HTTP_POST_FILES['news_pic5']) && $_POST['id'] == 3 ){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['news_pic5']['tmp_name']) && $HTTP_POST_FILES['news_pic5']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['news_pic5'];
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
		$news_pic_title5=$_file_['name'];
		$pic_type = $_file_['type'];
		//echo "$pic_type";

		//取原圖的大小進行比例處理
		switch ($pic_type){
			case "image/jpeg":
				$src2 = imagecreatefromjpeg($_FILES['news_pic5']['tmp_name']);
				break;
			case "image/png":
				$src2 = imagecreatefrompng($_FILES['news_pic5']['tmp_name']);
				break;
			case "image/gif":
				$src2 = imagecreatefromgif($_FILES['news_pic5']['tmp_name']);
				break;
		}
		$src_w2 = imagesx($src2);
		$src_h2 = imagesy($src2);
		$thumb_w2 = intval(300/ $src_w2 * $src_w2);
		$thumb_h2 = intval(300 / $src_w2 * $src_h2);

		if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_PIC_FOLDER_ID) && is_writeable(DESTINATION_PIC_FOLDER_ID)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			$newPicname5=date("YmdHis")."_".$attach."_5.".$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱

			//進行縮圖
			$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
			imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
			switch ($pic_type){
				case "image/jpeg":
					$resultOK= imagejpeg($thumb2, "images/smallPic/id_check/".$newPicname5);
					break;
				case "image/png":
					$resultOK= imagepng($thumb2, "images/smallPic/id_check/".$newPicname5);
					break;
				case "image/gif":
					$resultOK= imagegif($thumb2, "images/smallPic/id_check/".$newPicname5);
					break;
			}


			if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER_ID . "/" . $newPicname5)){//修改檔案名稱
				@unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
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

	// echo "title1=$newPicname5<br>"; $news_pic_title5
}
//特殊考生1********************
if(!empty($HTTP_POST_FILES['special_pic1']) && $_POST['special_check'] == 1 ){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['special_pic1']['tmp_name']) && $HTTP_POST_FILES['special_pic1']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['special_pic1'];
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
		$special_pic_title1=$_file_['name'];
		$pic_type = $_file_['type'];
		//echo "$pic_type";

		//取原圖的大小進行比例處理
		switch ($pic_type){
			case "image/jpeg":
				$src2 = imagecreatefromjpeg($_FILES['special_pic1']['tmp_name']);
				break;
			case "image/png":
				$src2 = imagecreatefrompng($_FILES['special_pic1']['tmp_name']);
				break;
			case "image/gif":
				$src2 = imagecreatefromgif($_FILES['special_pic1']['tmp_name']);
				break;
		}
		$src_w2 = imagesx($src2);
		$src_h2 = imagesy($src2);
		$thumb_w2 = intval(300/ $src_w2 * $src_w2);
		$thumb_h2 = intval(300 / $src_w2 * $src_h2);

		if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_PIC_FOLDER_ID) && is_writeable(DESTINATION_PIC_FOLDER_ID)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			$special_pic_name1=date("YmdHis")."_".$attach."_sp1.".$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱

			//進行縮圖
			$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
			imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
			switch ($pic_type){
				case "image/jpeg":
					$resultOK= imagejpeg($thumb2, "images/smallPic/id_check/".$special_pic_name1);
					break;
				case "image/png":
					$resultOK= imagepng($thumb2, "images/smallPic/id_check/".$special_pic_name1);
					break;
				case "image/gif":
					$resultOK= imagegif($thumb2, "images/smallPic/id_check/".$special_pic_name1);
					break;
			}


			if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER_ID . "/" . $special_pic_name1)){//修改檔案名稱
				@unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
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

	// echo "title1=$newPicname5<br>"; $news_pic_title5
}
//特殊考生2********************
if(!empty($HTTP_POST_FILES['special_pic2']) && $_POST['special_check'] == 1 ){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['special_pic2']['tmp_name']) && $HTTP_POST_FILES['special_pic2']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['special_pic2'];
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
		$special_pic_title2=$_file_['name'];
		$pic_type = $_file_['type'];
		//echo "$pic_type";

		//取原圖的大小進行比例處理
		switch ($pic_type){
			case "image/jpeg":
				$src2 = imagecreatefromjpeg($_FILES['special_pic2']['tmp_name']);
				break;
			case "image/png":
				$src2 = imagecreatefrompng($_FILES['special_pic2']['tmp_name']);
				break;
			case "image/gif":
				$src2 = imagecreatefromgif($_FILES['special_pic2']['tmp_name']);
				break;
		}
		$src_w2 = imagesx($src2);
		$src_h2 = imagesy($src2);
		$thumb_w2 = intval(300/ $src_w2 * $src_w2);
		$thumb_h2 = intval(300 / $src_w2 * $src_h2);

		if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_PIC_FOLDER_ID) && is_writeable(DESTINATION_PIC_FOLDER_ID)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			$special_pic_name2=date("YmdHis")."_".$attach."_sp2.".$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱

			//進行縮圖
			$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
			imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
			switch ($pic_type){
				case "image/jpeg":
					$resultOK= imagejpeg($thumb2, "images/smallPic/id_check/".$special_pic_name2);
					break;
				case "image/png":
					$resultOK= imagepng($thumb2, "images/smallPic/id_check/".$special_pic_name2);
					break;
				case "image/gif":
					$resultOK= imagegif($thumb2, "images/smallPic/id_check/".$special_pic_name2);
					break;
			}


			if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER_ID . "/" . $special_pic_name2)){//修改檔案名稱
				@unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
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

	// echo "title1=$newPicname5<br>"; $news_pic_title5
}
//特殊考生3********************
if(!empty($HTTP_POST_FILES['special_pic3']) && $_POST['special_check'] == 1 ){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['special_pic3']['tmp_name']) && $HTTP_POST_FILES['special_pic3']['error'] == 0){

		$_file_ = $HTTP_POST_FILES['special_pic3'];
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
		$special_pic_title3=$_file_['name'];
		$pic_type = $_file_['type'];
		//echo "$pic_type";

		//取原圖的大小進行比例處理
		switch ($pic_type){
			case "image/jpeg":
				$src2 = imagecreatefromjpeg($_FILES['special_pic3']['tmp_name']);
				break;
			case "image/png":
				$src2 = imagecreatefrompng($_FILES['special_pic3']['tmp_name']);
				break;
			case "image/gif":
				$src2 = imagecreatefromgif($_FILES['special_pic3']['tmp_name']);
				break;
		}
		$src_w2 = imagesx($src2);
		$src_h2 = imagesy($src2);
		$thumb_w2 = intval(300/ $src_w2 * $src_w2);
		$thumb_h2 = intval(300 / $src_w2 * $src_h2);

		if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
		}
		if(!is_dir(DESTINATION_PIC_FOLDER_ID) && is_writeable(DESTINATION_PIC_FOLDER_ID)){
			$errStr = "Cartella di destinazione non valida";
			echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
		}
		if(empty($errStr)){
			$special_pic_name3=date("YmdHis")."_".$attach."_sp3.".$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱

			//進行縮圖
			$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
			imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
			switch ($pic_type){
				case "image/jpeg":
					$resultOK= imagejpeg($thumb2, "images/smallPic/id_check/".$special_pic_name3);
					break;
				case "image/png":
					$resultOK= imagepng($thumb2, "images/smallPic/id_check/".$special_pic_name3);
					break;
				case "image/gif":
					$resultOK= imagegif($thumb2, "images/smallPic/id_check/".$special_pic_name3);
					break;
			}


			if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER_ID . "/" . $special_pic_name3)){//修改檔案名稱
				@unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
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

	//改名********************
	if(!empty($HTTP_POST_FILES['rename_pic'])){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
		if(is_uploaded_file($HTTP_POST_FILES['rename_pic']['tmp_name']) && $HTTP_POST_FILES['rename_pic']['error'] == 0){

			$_file_ = $HTTP_POST_FILES['rename_pic'];
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
			$rename_pic_title=$_file_['name'];
			$pic_type = $_file_['type'];
			//echo "$pic_type";

			//取原圖的大小進行比例處理
			switch ($pic_type){
				case "image/jpeg":
					$src2 = imagecreatefromjpeg($_FILES['rename_pic']['tmp_name']);
					break;
				case "image/png":
					$src2 = imagecreatefrompng($_FILES['rename_pic']['tmp_name']);
					break;
				case "image/gif":
					$src2 = imagecreatefromgif($_FILES['rename_pic']['tmp_name']);
					break;
			}
			$src_w2 = imagesx($src2);
			$src_h2 = imagesy($src2);
			$thumb_w2 = intval(300/ $src_w2 * $src_w2);
			$thumb_h2 = intval(300 / $src_w2 * $src_h2);

			if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
				$errStr = "Estensione non valida";
				echo "<script>javascript:alert(\"請檢查檔案格式\");</script>";//跳出錯誤訊息
			}
			if(!is_dir(DESTINATION_PIC_FOLDER_ID) && is_writeable(DESTINATION_PIC_FOLDER_ID)){
				$errStr = "Cartella di destinazione non valida";
				echo "<script>javascript:alert(\"必須指定資料夾目錄\");</script>";//跳出錯誤訊息
			}
			if(empty($errStr)){
				$rename_pic_name=date("YmdHis")."_".$attach."_name.".$_ext_;//如果更新圖片，變數$newname就重新取得新檔案名稱

				//進行縮圖
				$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
				imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
				switch ($pic_type){
					case "image/jpeg":
						$resultOK= imagejpeg($thumb2, "images/smallPic/id_check/".$rename_pic_name);
						break;
					case "image/png":
						$resultOK= imagepng($thumb2, "images/smallPic/id_check/".$rename_pic_name);
						break;
					case "image/gif":
						$resultOK= imagegif($thumb2, "images/smallPic/id_check/".$rename_pic_name);
						break;
				}


				if(@copy($_tmp_name_,DESTINATION_PIC_FOLDER_ID . "/" . $rename_pic_name)){//修改檔案名稱
					@unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
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

		// echo "title1=$newPicname5<br>"; $news_pic_title5
	}

}
?>


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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
// echo "college=".$_POST['exarea1'][0]."<br>";
// echo "dept.=".$_POST['exarea1'][1]."<br>";
// die();
echo("<script>console.log('111111111');</script>");
	$allSubjects=$_POST['Subjects'];
	$allSubjects= implode(',' , $allSubjects);

	$Ticket=substr(($_POST['exarea'][0]),0,1).$_POST['times'].substr(($_POST['endday']),0,4);
	mysql_select_db($database_conn_web, $conn_web);

	//$Ticket抓取(正取)師資生的報名資料 status=0 //update by coway 2016.8.11
	$query_web_search = sprintf("SELECT id FROM examinee WHERE id LIKE %s
			AND Qualify=1 AND status=0  ORDER BY id DESC", GetSQLValueString("%" . $Ticket . "%", "text"));//AND exarea_note = %s , GetSQLValueString($_POST['exarea'][2], "text")
	//2016/03/04 teresa mark
	//$query_web_search = sprintf("SELECT id FROM examinee WHERE id LIKE %s ORDER BY id DESC LIMIT 0,1", GetSQLValueString("%" . $Ticket . "%", "text"));
	$web_search = mysql_query($query_web_search, $conn_web) or die(mysql_error());

	$row_web_search = mysql_fetch_assoc($web_search);
	$totalRows_web_search = mysql_num_rows($web_search);
	//$Ticket抓取(備取)師資生的報名資料 status=0 //update by coway 2016.8.11
	$query_web_search_last = sprintf("SELECT id FROM examinee WHERE id LIKE %s
			AND Qualify=0 AND status=0  ORDER BY id DESC", GetSQLValueString("%" . $Ticket . "%", "text"));//AND exarea_note = %s , GetSQLValueString($_POST['exarea'][2], "text")
	$web_search_last = mysql_query($query_web_search_last, $conn_web) or die(mysql_error());

	$row_web_search_last = mysql_fetch_assoc($web_search_last);
	$totalRows_web_search_last = mysql_num_rows($web_search_last);

	//抓取(正取)師資生的報名資料 status=0 //add身份別1(cert_no='1')判斷 ,add by coway 2016.9.22
	$query_web_search2 = sprintf("SELECT id FROM examinee WHERE id LIKE %s
			AND Qualify=1 AND status=0 AND exarea_note = %s AND apply_mk=1 AND cert_no='1' ORDER BY id DESC", GetSQLValueString("%" . $Ticket . "%", "text"), GetSQLValueString($_POST['exarea'][2], "text"));
// 	echo "sql=".$query_web_search2."<br>";
// 	die();
	$web_search2 = mysql_query($query_web_search2, $conn_web) or die(mysql_error());

	$row_web_search2 = mysql_fetch_assoc($web_search2);
	$totalRows_web_search2 = mysql_num_rows($web_search2);

	//抓取(備取)師資生的報名資料 status=0
	$query_web_search_last2 = sprintf("SELECT id FROM examinee WHERE id LIKE %s
			AND Qualify=0 AND status=0 AND exarea_note = %s AND apply_mk=1 ORDER BY id DESC", GetSQLValueString("%" . $Ticket . "%", "text"), GetSQLValueString($_POST['exarea'][2], "text"));
	$web_search_last2 = mysql_query($query_web_search_last2, $conn_web) or die(mysql_error());
	$row_web_search_last2 = mysql_fetch_assoc($web_search_last2);
	$totalRows_web_search_last2 = mysql_num_rows($web_search_last2);

	$query_web_allguide2 = sprintf("SELECT * FROM allguide Where up_no='EA2' AND nm= %s AND data2= %s",GetSQLValueString($_POST['exarea'][0], "text"), GetSQLValueString($_POST['exarea'][2], "text"));
	$web_allguide2 = mysql_query($query_web_allguide2, $conn_web) or die(mysql_error());
	$row_web_allguide2 = mysql_fetch_assoc($web_allguide2);

	$exam_date = $row_web_allguide2['data1'];

	if($totalRows_web_search == 0){
		$number=1;
		$Ticket=$Ticket.sprintf("%04d", $number);
	}else{
		if($totalRows_web_search_last == 0){
			$number=substr(($row_web_search['id']),6,4); //ex:CA20160001 取後4位
		}else{
			$number=substr(($row_web_search_last['id']),6,4);
		}
		$number=$number+1;
		$Ticket=$Ticket.sprintf("%04d", $number);
		/*// 2016/3/4 teresa mark...
		$number=substr(($row_web_search['id']),6,4);
		$number=$number+1;
		$Ticket=$Ticket.sprintf("%04d", $number);*/

	}
	if(substr(($_POST['exarea'][0]),0,1) == $row_web_allguide2['no']){
		if($totalRows_web_search2 >= (int)$row_web_allguide2['data3']){
// 			if($totalRows_web_search_last2 >= (int)$row_web_allguide2['data4']){
				//echo "last:$totalRows_web_search_last, data4: $row_web_allguide2[data4]";
// 			echo "<script>javascript:alert(\"超過限制檔案大小\");exit;</script>";
			echo "<script>javascript:alert(\"本考場第一錄取順序應考人之網路登錄報名人數已超過簡張開放名額，請考慮是否選擇其他考場參與評量。\");</script>";
// 			echo "<script>if(confirm('本考場第一錄取順序應考人之網路登錄報名人數已超過簡單開放名額，請考慮是否選擇其他考場參與評量。')){history.go(-1);} </script>";

		?>
		 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			    <script type="text/javascript">
// 		if(confirm("本考場第一錄取順序應考人之網路登錄報名人數已超過簡單開放名額，請考慮是否選擇其他考場參與評量。")){history.go(-1) ;
		<?php //die();?>
// 		}else{exit;}
// 			    break;
// 			    window.open('popIdMsg.php','msg','resizable=no,top=220,left=900,height=200,width=400,scrollbars=no,menubar=no,location=no,status=no,titlebar=no,toolbar=no');
// 				alert("本考場第一錄取順序應考人之網路登錄報名人數已超過簡單開放名額，請考慮是否選擇其他考場參與評量。");
// // 				exit();
// 				window.history.back();
				</script>;
<?php
// 			$qualify=1;
// echo "<script>alert('報名人數已滿，是否選擇其他場次。');exit; </script>";
// die();

// 				die("<script>if(confirm('本考場第一錄取順序應考人之網路登錄報名人數已超過簡單開放名額，請考慮是否選擇其他考場參與評量。')){history.go(-1) ;}</script>");
// 				exit();
// 			}else{
// 				$qualify=0;
// 			}
		}//else $qualify=1;

	}else{
		?>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <script type="text/javascript">
		alert("報名場次有誤，請重新報名。");
		window.history.back();
		</script>;
<?php
	}
	//判斷其他欄位有無填入，其他欄位優先
	$_POST['Department'] = (trim($_POST['Department_other']) != "") ? $_POST['Department_other'] : $_POST['Department'];
$_POST['High_college'] = (trim($_POST['High_college_other']) != "") ? $_POST['High_college_other'] : $_POST['High_college'];

if($_POST['Department']=="" || $_POST['High_college']==""){
	?>
        <script language="JavaScript">
                alert("學院/科系填寫不完整！");
                history.go(-1); //回上一頁
        </script> <?
}
	//取得報考資格流水號
	$query_web_cert = sprintf("SELECT IFNULL(max(cert_id),0)+1 AS cert_id FROM `examinee` WHERE examyear_id=%s AND cert_no=%s ",GetSQLValueString($_POST['examyear_id'], "text"), GetSQLValueString($_POST['id'], "text"));
	$web_cert = mysql_query($query_web_cert, $conn_web) or die(mysql_error());
	$row_web_cert = mysql_fetch_assoc($web_cert);
// 	echo "cert_no=".$_POST['id']."<br>";
// 	echo "examyear_id=".$_POST['examyear_id']."<br>";
// 	echo "cert_id=".$row_web_cert['cert_id']."<br>";
// echo $special_pic_title1."*****";
	// die();

 $insertSQL = sprintf("INSERT INTO examinee (birthday, username, uname, eng_uname, sex, email,
 		phone, Area, cityarea, cuszip, cusadr, per_id, category, exarea, exarea_date, exarea_note, school, Grade, Student_ID,
 		Department, pic_title, pic_name, `date`, id, contact, contact_ph, Qualify, status, cert_no, cert_id,examyear_id,High_college)
 		VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
 		%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",//, certificate
                       GetSQLValueString($_POST['birthday'], "text"),
											 GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['uname'], "text"),
											 GetSQLValueString($_POST['eng_uname'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['Area'], "text"),
                       GetSQLValueString($_POST['cityarea'], "text"),
                       GetSQLValueString($_POST['cuszip'], "text"),
                       GetSQLValueString($_POST['cusadr'], "text"),
					   //GetSQLValueString($_POST['certificate'], "text"),
					   GetSQLValueString($_POST['per_id'], "text"),
					   GetSQLValueString($allSubjects, "text"),
					   //GetSQLValueString($_POST['exarea'], "text"),
 					   GetSQLValueString($_POST['exarea'][0], "text"),
 					   GetSQLValueString($exam_date, "text"),
 					   GetSQLValueString($_POST['exarea'][2], "text"),
					   GetSQLValueString($_POST['school'], "text"),
					   GetSQLValueString($_POST['Grade'], "text"),
					   GetSQLValueString($_POST['Student_ID'], "text"),
					   GetSQLValueString($_POST['Department'], "text"),
					   GetSQLValueString($news_pic_title, "text"),
                       GetSQLValueString($newPicname, "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($Ticket, "text"),
 					   GetSQLValueString($_POST['contact'], "text"),
					   GetSQLValueString($_POST['contact_ph'], "text"),
// 				 	   GetSQLValueString($qualify, "text"),
				 	   GetSQLValueString('1', "text"),
				 	   GetSQLValueString('0', "text"),
					   GetSQLValueString($_POST['id'], "text"),//cert_no, add by coway 2016.8.9
					   GetSQLValueString($row_web_cert['cert_id'], "text"),//cert_id, add by coway 2016.8.25
					   GetSQLValueString($_POST['examyear_id'], "text"),//examyear_id, add by coway 2016.8.25
					   GetSQLValueString($_POST['High_college'], "text")//High_college, add by coway 2017.4.6

 		);

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());

  $insertGoTo = "examOut.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
	if (isset($_SESSION['MM_Username'])) {
	  $colname_web_member = $_SESSION['MM_Username'];
	}

$web_examinne_check = sprintf("SELECT no,username,examyear_id FROM examinee WHERE username = %s ORDER BY DATE DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"));
$web_examinne_c = mysql_query($web_examinne_check, $conn_web) or die(mysql_error());
$row_web_examinne = mysql_fetch_assoc($web_examinne_c);
// print_r($row_web_examinne);
// echo "$special_pic_title1<br>$special_pic_title2<br>$special_pic_title3****";
// die();
//****************BlueS 20180302 將身分證等資料存入資料庫
mysql_select_db($database_conn_web, $conn_web);
$insertSQL_check = sprintf("INSERT INTO `examinee_pic` (`examinee_no`, `username`, `examyear_id`, `pic1_title`,
	`pic1_name`, `pic2_title`, `pic2_name`, `pic3_title`, `pic3_name`, `pic4_title`, `pic4_name`, `pic5_title`,
	`pic5_name`, `special_pic_title1`, `special_pic_name1`, `special_pic_title2`, `special_pic_name2`, `special_pic_title3`,
	`special_pic_name3`, `rename_pic_title`, `rename_pic_name`)
	 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
											GetSQLValueString($row_web_examinne["no"], "text"),
											GetSQLValueString($row_web_examinne["username"], "text"),
											GetSQLValueString($row_web_examinne["examyear_id"], "text"),
											GetSQLValueString($news_pic_title1, "text"),
											GetSQLValueString($newPicname1, "text"),
											GetSQLValueString($news_pic_title2, "text"),
											GetSQLValueString($newPicname2, "text"),
											GetSQLValueString($news_pic_title3, "text"),
											GetSQLValueString($newPicname3, "text"),
											GetSQLValueString($news_pic_title4, "text"),
											GetSQLValueString($newPicname4, "text"),
											GetSQLValueString($news_pic_title5, "text"),
											GetSQLValueString($newPicname5, "text"),
											GetSQLValueString($special_pic_title1, "text"),
											GetSQLValueString($special_pic_name1, "text"),
											GetSQLValueString($special_pic_title2, "text"),
											GetSQLValueString($special_pic_name2, "text"),
											GetSQLValueString($special_pic_title3, "text"),
											GetSQLValueString($special_pic_name3, "text"),
											GetSQLValueString($rename_pic_title, "text"),
											GetSQLValueString($rename_pic_name, "text")
	 );

// echo $insertSQL_check;
// die();
 $Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error());
	$nums=mysql_affected_rows();
	if($nums > 0){
	  header(sprintf("Location: %s", $insertGoTo));
	  exit();
	}
}

$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}

mysql_select_db($database_conn_web, $conn_web);
//update by coway 2016.8.17
// $query_web_new = "SELECT * FROM examyear ORDER BY id DESC LIMIT 0,1";
$query_web_new = "SELECT * FROM examyear WHERE status='0' ORDER BY id DESC LIMIT 0,1";
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);
$totalRows_web_new = mysql_num_rows($web_new);

mysql_select_db($database_conn_web, $conn_web);
$query_web_member = sprintf("SELECT * FROM member WHERE username = %s", GetSQLValueString($colname_web_member, "text"));
$web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_member);
$totalRows_web_member = mysql_num_rows($web_member);

$todayyear=$row_web_new['times'].substr(($row_web_new['endday']),0,4);//第幾次+西元年
mysql_select_db($database_conn_web, $conn_web);
$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND id LIKE %s ORDER BY DATE DESC", GetSQLValueString($colname_web_member, "text"),
GetSQLValueString("%" . $todayyear . "%", "text"));
$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
$row_web_examinee = mysql_fetch_assoc($web_examinee);
$totalRows_web_examinee = mysql_num_rows($web_examinee);

//判斷是否報名師資生 examyear_id-1 BlueS 20180313
mysql_select_db($database_conn_web, $conn_web);
$query_web_examyear_id = sprintf("SELECT examinee.* FROM examinee,(SELECT id FROM `examyear` where status = '1' ORDER BY `examyear`.`startday` DESC LIMIT 0, 1) as examyear WHERE examyear.id = examinee.examyear_id AND examinee.username = %s ORDER BY DATE DESC", GetSQLValueString($colname_web_member, "text"));
$web_examyear_id = mysql_query($query_web_examyear_id, $conn_web) or die(mysql_error());
$row_web_examyear_id = mysql_fetch_assoc($web_examyear_id);
$totalRows_web_xamyear_id = mysql_num_rows($web_examyear_id);

mysql_select_db($database_conn_web, $conn_web);
$query_web_examinee2 = sprintf("SELECT * FROM examinee WHERE username = %s ORDER BY DATE DESC", GetSQLValueString($colname_web_member, "text"));
$web_examinee2 = mysql_query($query_web_examinee2, $conn_web) or die(mysql_error());
$row_web_examinee2 = mysql_fetch_assoc($web_examinee2);
$totalRows_web_examinee2 = mysql_num_rows($web_examinee2);

//取得報考資格 add by coway 2016.8.8
mysql_select_db($database_conn_web, $conn_web);
$query_web_allguide = "SELECT * FROM allguide WHERE up_no='ID' ORDER BY no  ";
$web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
// $row_web_allguide = mysql_fetch_assoc($web_allguide);
// $totalRows_web_allguide = mysql_num_rows($web_allguide);
$allguide_lot = array();
$alli=0;
while ($row_web_allguide = mysql_fetch_assoc($web_allguide)){
	$allguide_lot[$alli] = $row_web_allguide;
	$alli++;
}

// echo "totalRows_web_allguide=".$allguide_lot[0]['no']."<br>";
// echo "totalRows_web_allguide=".$allguide_lot[0]['nm']."<br>";
// echo "totalRows_web_allguide=".$allguide_lot[1]['no']."<br>";
// echo "totalRows_web_allguide=".$allguide_lot[1]['nm']."<br>";
// echo "totalRows_web_allguide=".$allguide_lot[2]['no']."<br>";
// echo "totalRows_web_allguide=".$allguide_lot[2]['nm']."<br>";

//查詢正/備取資料 2016/3/4 teresa add
$lot = array();
mysql_select_db($database_conn_web, $conn_web);
$query_web_lot = sprintf("SELECT IFNULL(num,0) num, nm as exarea, data2 as exarea_note,
		data3, data4, (data3-IFNULL(num,0)) lot1 FROM allguide a2 left join
		( SELECT count(*) num, exarea, exarea_note FROM examinee WHERE id LIKE %s
		AND apply_mk=1 AND Qualify=1 group by exarea, exarea_note) as a1 on
		(a1.exarea = a2.nm and a1.exarea_note = a2.data2)
		WHERE a2.up_no = %s", GetSQLValueString("%" .$todayyear . "%", "text"), GetSQLValueString('EA2', "text"));
// echo"query_web_lot=".$query_web_lot."<br>";
// die();
$web_examinee_lot = mysql_query($query_web_lot, $conn_web) or die(mysql_error());

mysql_select_db($database_conn_web, $conn_web);
$query_web_lot2 = sprintf("SELECT IFNULL(num2,0) num2, nm as exarea, data2 as exarea_note,
		data3, data4, (data4-IFNULL(num2,0)) lot2 FROM allguide a2 left join
		(SELECT count(*) num2, exarea as exarea2, exarea_note as exarea_note2 FROM examinee WHERE id LIKE %s
		AND apply_mk=1 AND Qualify=0 group by exarea, exarea_note) as a3 on
		(a3.exarea2 = a2.nm and a3.exarea_note2 = a2.data2) WHERE a2.up_no = %s", GetSQLValueString("%" .$todayyear . "%", "text"), GetSQLValueString('EA2', "text"));
$web_examinee_lot2 = mysql_query($query_web_lot2, $conn_web) or die(mysql_error());

//$row_web_examinee_log = mysql_fetch_assoc($web_examinee_lot);
$k=0;
while ($row_web_examinee_log = mysql_fetch_assoc($web_examinee_lot)){
	$lot[$k] = $row_web_examinee_log;
	$k++;
}
//print_r($lot);

$form = new HTML_QuickForm('examAdd','post','');
$init='';
$select1[$init]='請選擇-地區';
$select2[$init][$init]='請選擇-考場';
$select3[$init][$init][$init]='請選擇-日期場次';
$select3[$init]['考場'][$init]='日期場次';

//查詢各考場正/備取人數
mysql_select_db($database_conn_web, $conn_web);
//$query_web_allguide = sprintf("SELECT * FROM allguide Where up_no='EA2' AND nm= %s AND data2= %s",GetSQLValueString($row_web_examinee['exarea'], "text"), GetSQLValueString($row_web_examinee['exarea_note'], "text"));
$query_web_allguide = sprintf("SELECT * FROM allguide Where up_no='EA2' ORDER BY CAST(CONVERT(data1 USING big5) AS BINARY),data2 ASC",GetSQLValueString('%', "text"));
$web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
$i=0;
while ($row_allguide = mysql_fetch_assoc($web_allguide)){
	$select1[$row_allguide['nm']]=substr($row_allguide['note'], 0, 6);
	$select2[$row_allguide['nm']][$init]='請選擇-考場';
	$select3[$row_allguide['nm']][$init][$init]='請選擇-日期場次';
	$select2[$row_allguide['nm']][$row_allguide['note']]=$row_allguide['note'];
	$select3[$row_allguide['nm']][$row_allguide['note']][$init]='請選擇-日期場次';
	$select3[$row_allguide['nm']][$row_allguide['note']][$row_allguide['data2']]=$row_allguide['data1'];
}
//print_r($exam_area);


//取得學院系所資料
$form1 = new HTML_QuickForm('examAdd1','post','');
$init1='';
$sele1[$init1]='請 選 擇-學 院';
$sele2[$init1][$init1]='請 選 擇-系 所';

// $query_web_allguide = sprintf("SELECT * FROM `allguide` where up_no='Edu' order by no,CAST(CONVERT(data1 USING big5) AS BINARY)",GetSQLValueString('%', "text"));
$query_web_college = sprintf("SELECT * FROM allguide where up_no='Edu' and data1 not in ('其他學系') UNION SELECT * FROM allguide where up_no='Edu' and data1 ='其他學系'",GetSQLValueString('%', "text"));
$web_college = mysql_query($query_web_college, $conn_web) or die(mysql_error());
$i=0;
while ($row_college = mysql_fetch_assoc($web_college)){
	$sele1[$row_college['nm']]=$row_college['nm'];
	$sele2[$row_college['nm']][$init1]='請選擇-系所';
	$sele2[$row_college['nm']][$row_college['data1']]=$row_college['data1'];
// 	$select3[$row_allguide['nm']][$init][$init]='請選擇-日期場次';
// 	$select3[$row_allguide['nm']][$row_allguide['note']][$init]='請選擇-日期場次';
// 	$select3[$row_allguide['nm']][$row_allguide['note']][$row_allguide['data2']]=$row_allguide['data1'];
}



?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>報名考試</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="報名考試" />
<meta name="keywords" content="報名考試" />
<meta name="author" content="國立臺中教育大學 測驗統計與適性學習中心" />
<link href="web.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery.js"></script>
	<script src="js/jquery.validate.js"></script>
<script type="text/javascript" src="address.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<!--引入郵遞區號.js檔案-->
<link rel="stylesheet" href="./css/dhtmlgoodies_calendar.css" />
<script src="./js/dhtmlgoodies_calendar.js"></script>
<script>
	var data = [];
	$.validator.setDefaults({
		submitHandler: function() {
			//alert("submitted!");
			//$('#signupForm').submit(function(){
			$(this).ajaxSubmit({
				type:"post",
				url:"examAdd.php",
				beforeSubmit:showRequest,
				success:showResponse
			});
			return false; //此處必須返回false，阻止常規的form提交
		//});
		}
	});




	//驗證
	$().ready(function() {

		var radio3_upload = '#radio3';
		var radio3= '#radio3_upload';

		// (function(radio3_upload,radio3){
		// 	$(radio3_upload).click(function(){
		// 			$(radio3).slideToggle();
		// 	});
		// })(radio3_upload,radio3);

		$('#optionDiv1').show();//修畢師資職前教育證明書
		$('#optionDiv1-1').show();
		$('#optionDiv2').hide();
		$('#optionDiv2-1').hide();
		$('#optionDiv3').hide();
		$('#optionDiv3-1').hide();
		$('#optionDiv4').hide();
		$('#optionDiv4-1').hide();
		$('#special_upload').hide();
		$('.radio-inline').change(function(){

			console.log ('---------');
			var selected_radio_value = $("input[name=id]:checked").val();
			if(selected_radio_value == '1')
			{
					$('#optionDiv1').show();
					$('#optionDiv1-1').show();
					$('#optionDiv2').hide();
					$('#optionDiv2-1').hide();
					$('#optionDiv3').hide();
					$('#optionDiv3-1').hide();
					$('#optionDiv4').hide();
					$('#optionDiv4-1').hide();
			}else if(selected_radio_value == '2') {
					$('#optionDiv1').hide();
					$('#optionDiv1-1').hide();
					$('#optionDiv2').show();
					$('#optionDiv2-1').show();
					$('#optionDiv3').hide();
					$('#optionDiv3-1').hide();
					$('#optionDiv4').hide();
					$('#optionDiv4-1').hide();
			}else if(selected_radio_value == '3') {
					$('#optionDiv1').hide();
					$('#optionDiv1-1').hide();
					$('#optionDiv2').hide();
					$('#optionDiv2-1').hide();
					$('#optionDiv3').show();
					$('#optionDiv3-1').show();
					$('#optionDiv4').hide();
					$('#optionDiv4-1').hide();
			}else if(selected_radio_value == '4') {
					$('#optionDiv1').hide();
					$('#optionDiv1-1').hide();
					$('#optionDiv2').hide();
					$('#optionDiv2-1').hide();
					$('#optionDiv3').hide();
					$('#optionDiv3-1').hide();
					$('#optionDiv4').show();
					$('#optionDiv4-1').show();
			}
		});
		$('.radio-special').change(function(){

			console.log ('---------');
			var selected_radio_value = $("input[name=special_check]:checked").val();
			if(selected_radio_value == '1')
			{
					$('#special_upload').show();
			}else if(selected_radio_value == '2') {
					$('#special_upload').hide();
			}
		});
		// validate the comment form when it is submitted
		$("#commentForm").validate();

		// validate signup form on keyup and submit
		$("#form3").validate({
			rules: {
				email: "required",
				phone: "required",
				Student_ID: {
					required: true,
					minlength: 4
				},
				Department: {
					required: true,
					minlength: 4
				},
				agree: "required"
			},
			//錯誤訊息
			messages: {
				Student_ID: {
					required: "請檢查學號欄位",
					minlength: "學號輸入請勿少於4個字元"
				},
				Department: {
					required: "請檢查科系欄位",
					minlength: "科系輸入請勿少於4個字元"
				},
				email:"請檢查email欄位",
				phone: "請檢查電話欄位",
				//exam_school: "請選擇考場"
			}
		});
	});

	function SaveAlert(){
// 判斷是否上傳照片 BlueS 20180308


var input_id = $("input[name=id]:checked").val();
if(input_id==3 && news_pic5.value== ""){
	alert("檔案上傳不完整。");
	window.event.returnValue=false;
}else if(input_id==2 && news_pic4.value== ""){
	alert("檔案上傳不完整。");
	window.event.returnValue=false;
}else if(input_id==1 && news_pic3.value== ""){
	alert("檔案上傳不完整。");
	window.event.returnValue=false;
}
var input_sp = $("input[name=special_check]:checked").val();
if(input_sp==undefined){
	alert("是否為特殊考生未填。");
	window.event.returnValue=false;
}
if(input_sp==1){
		if(special_pic1.value == "" || special_pic2.value == "" || special_pic3.value == ""){
			alert("特殊考生資料上傳不完整。");
			window.event.returnValue=false;
		}
}


		alert("提醒您，報名尚未完成。");
	}

	function showData(str,index) {
		if (str == "") {
		   document.getElementById("msg").innerHTML = "";
		   return;
		}
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		   xmlhttp = new XMLHttpRequest();
		} else {// code for IE6, IE5
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			   if (xmlhttp.readyState == 4 && xmlhttp.status == 200) { //傳回值是固定寫法
			   document.getElementById("msg").innerHTML = xmlhttp.responseText; //[最後]把select出來的資料 傳回前面指定的html位置
			//alert(xmlhttp.responseText);
			}
		}
		//console.log("prodb_queryol.php?area="+str[0]+"&note="+str[2]+"&todayyear="+index);
		xmlhttp.open("GET", "prodb_queryol.php?area="+str[0]+"&note="+str[2]+"&todayyear="+index, true);
		xmlhttp.send();
	}

	function popIdMsg(){
		var winvar;
		swal({
  			title: "同類別中以完成網路報名時間先後為錄取順序之排定報名完成時間較早者為優先",
  			text: "※請確實點選報考資格，經查核資料不實者，即取消本次應考資格※",
  			icon: "warning",
  			button: "確定!",
		});
			// window.open('popIdMsg.php','msg','resizable=no,top=220,left=900,height=200,width=400,scrollbars=no,menubar=no,location=no,status=no,titlebar=no,toolbar=no');
// 		winvar = window.open('localhost', '', config='toolbar=no,top=220,left=900,height=200,width=400,scrollbars=no,resizable=0,menubar=no,location=no,status=no');
// 		var text1 ="※請確實點選應考資格， 經查核資料不實者，即取消本次應考資格※";
// 		winvar.document.writeln("&nbsp;&nbsp;&nbsp;&nbsp;教師專業能力測驗中心將依報考資格開放錄取順序，於郵寄報名表件審查時列為正取或備取。<br>各考場正取應考人經審核後若有報名資格不符等情事，由本中心依序通知備取應考人遞補。<br><br>"+text1.bold().fontcolor('red'));
	}
	//刪除報名表 ,add by coway 2016.8.17
	function DeleteAlert(){
// 		var str=document.getElementsByName("MM_delete");
// 		alert(str.length);
		if(confirm('確定刪除報名表資料?')){
		location.href='examAdd.php?action=delete';}
	}

	function areachange1(form) {
		var form1 = document.getElementById("form3");
// 		 var test_value= document.form.elements["edu2[1]"].value;
// 		var form = document.getElementById("form3");
// 		i = form.edu2.selectedIndex;
// 		edu = form.edu2[0].value;
// 		test_value = document.form.i.value();
// 		form.Other2_dept.value="123";
// 		alert(test_value);

// 		var form1 = document.getElementById("form3")
		var High_college_str=$(".input-normal[name^='edu1[0]'").val();
		var Department_str=$(".input-normal[name^='edu1[1]'").val();
		form1.High_college.value=High_college_str;
		form1.Department.value=Department_str;
// 		for (var i=0; i<form1.edu2.length ; i++)
// 		{
// 			if (form1.edu2[i].checked)
// 				{
// 				id2Val = form1.edu2[i].value;
// 				}
// 			}
// 		alert(High_college_str+Department_str);



// 		i = form.cityarea.selectedIndex;
// 		form.Mcode.value = cityareacode[cityarea_account[form.Area.selectedIndex]+i+1];
// 		form.cuszip.value = cityareacode[cityarea_account[form.Area.selectedIndex]+i+1];
// 		form.cusadr.value = form.Area.options[form.Area.selectedIndex].value+form.cityarea.options[form.cityarea.selectedIndex].value;
	}


	//update by coway 2016.8.9
// 	function ShowMsg(sel, index){
// 		var length = data.length;
// 		var value = sel.value;
// 		var name = sel.name.substr(7,1);
// 		if(name == '0') data.length = 0;
// 		if(name == '1') data.length = 1;
// 		data[name] = value;
// 		//console.log(index);
// 		if(data.length == 3){
// 			//console.log(data);
// 			showData(data,index);
// // 			alert('test2');
// 		}else document.getElementById("msg").innerHTML='正取尚餘__人  ；備取尚餘 __人';
// 	}

// 	function ShowFullMsg(){
// 		if(substr(($_POST['exarea'][0]),0,1) == $row_web_allguide2['no']){

// 			alert('test2');
// 			if($totalRows_web_search2 >= (int)$row_web_allguide2['data3']){

// 				alert('test');
// 			}
// 			}
// 	}
	</script>


</head>

<body background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>

  <div id="exam" align="center">
  <?php
//   echo "開始時間=".strtotime($row_web_new['startday'])."<br>";
//   echo "開始時間H:i=".strtotime('2016-09-23 08:30:00')."<br>";
//   echo "now=".date('Y-m-d')."<br>";
//   echo "now時間=".strtotime(date('Y-m-d'))."<br>";
//    echo "開始時間=".$row_web_new['startday']."<br>";
//    echo "儲存時間2=".substr(($row_web_examinee['date']),0,19)."<br>";
  $row_web_new['startday']=$row_web_new['startday']." 08:30:00";
  $row_web_new['endday']=$row_web_new['endday']." 15:30:00";
  ?>
  <? if(strtotime($row_web_new['startday']) <= strtotime(date('Y-m-d H:i:s')) && strtotime(date('Y-m-d H:i:s')) <= strtotime($row_web_new['endday'])&& $row_web_new['status'] == '0'){?>
		<!-- 如果有報名師資生跳出訊息 -->
		<?php if($totalRows_web_xamyear_id > '0'){?>
			<table width="555" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="80" align="center" class="font_red2">已報名 國民小學教師自然領域學科知能評量!<br><br>請點選 <a href="progress.php?status=1"><img src="images/progress_check_t.png"  /></a> 查看審核情況。</td>
						</tr>
			</table>
		<?php }elseif(($row_web_examinee['username'] != $row_web_member['username']) or  strtotime(substr(($row_web_examinee['date']),0,19)) < (strtotime($row_web_new['startday']))){?>

    <form id="form3" name="form3" method="post" enctype="multipart/form-data" action="<?php echo $editFormAction; ?>" >
      <table width="640" border="0" cellspacing="0" cellpadding="0" >
        <tr>
          <td width="25" align="left"><img src="images/board03.gif" /></td>
          <td width="505" align="left" background="images/board04.gif">&nbsp; <span class="font_black">親愛的考生[</span><span class="font_red">&nbsp;<?php echo $row_web_member['username']; ?> &nbsp;</span><span class="font_black">]請在下方填寫您的報名資料~~</span></td>
          <td width="10" align="right"><img src="images/board05.gif" width="10" height="28" /></td>
        </tr>
      </table>
      <table width="640" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="82" height="30" align="right" class="board_add"><span class="font_red">* </span>姓名：</td>
          <td width="458" align="left" class="board_add"><label>
			  <?php echo $row_web_member['uname'];?>
            <input name="uname" type="hidden" id="uname" value="<?php echo $row_web_member['uname']; ?>" />
          </label></td>
        </tr>
				<tr>
				<td class="board_add" align="right">戶口名簿上傳區</td>
					<td class="board_add" colspan="3"><span id="input_rename">
					<input type="file" name="rename_pic" id="rename_pic" /><br>
					<span class="font_red">**如有改名且姓名與相關證件不符，才需上傳。</span>
				</span></td>
			</tr>
        <tr>
          <td width="82" height="30" align="right" class="board_add">英文姓名：</td>
          <td width="458" align="left" class="board_add" colspan="2"><label>
          <?php
	          list($firstname, $lastname, $lastname2) = explode(" ", $row_web_member['eng_uname']);
	          if($firstname !=""){
	          	$eng_name="$firstname, $lastname $lastname2";
	          }
	          echo $eng_name; //$row_web_member['eng_uname'];
          ?><?php //echo $row_web_member['eng_uname']; //update by coway 2016.8.8?>
            <input name="eng_uname" type="hidden" id="eng_uname" value="<?php echo $row_web_member['eng_uname']; ?>" />
          </label><!-- (例如：李大同，英文名:Li Da Tong) -->
          </td>
        </tr>
				<tr>
        <td height="30" align="right" class="board_add"><span class="font_red">* </span>大頭照圖片：</td>
        <td align="left" class="board_add"><span class="table_lineheight">
          <?php /*START_PHP_SIRFCIT*/ //if ($row_web_examinee2['pic_name']!=""){ //marker by coway 2016.9.23?>
          <img src="images/examinee/<?php //echo $row_web_examinee2['pic_name']; ?>" alt="" name="pic" width="70" id="pic" />
          <?php //} /*END_PHP_SIRFCIT*/ ?>
          <input name="oldPic" type="hidden" id="oldPic" value="<?php echo $row_web_examinee2['pic_name']; ?>" />
          <input name="oldPictitle" type="hidden" id="oldPic" value="<?php echo $row_web_examinee2['pic_title']; ?>" />
          <?php //echo $row_web_examinee2['pic_title']; ?><br />
          <label>
          <span id="sprytextfield10">
            <input type="file" name="upload_hpic" id="upload_hpic" />
            <span class="textfieldRequiredMsg">請選擇照片</span><span class="textfieldMinCharsMsg">請選擇照片</span>
          </span>
          </label>
          <br/>
          <span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
	       </td>
			 </tr>
        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>E-mail：</td>
          <td align="left" class="board_add"><label>
            <input name="email" type="text" id="email" value="<?php echo $row_web_member['email']; ?>" size="35" />
          </label><br />
			<span class="font_black">請勿使用會檔信的yahoo、pchome信箱，以免收不到信。</span></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>性別：</td>
          <td align="left" class="board_add"><label>
            <input <?php if (!(strcmp($row_web_member['sex'],"男"))) {echo "checked=\"checked\"";} ?> name="sex" type="radio" id="radio" value="男" checked="checked" />
          男
          <input <?php if (!(strcmp($row_web_member['sex'],"女"))) {echo "checked=\"checked\"";} ?> type="radio" name="sex" id="radio2" value="女" />
          女</label>

          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>生日：</td>
          <td align="left" class="board_add"><label>
          <span id="sprytextfield4">
            <input name="birthday" type="text" id="birthday" value="<?php echo $row_web_member['birthday']; ?>" />
            <input type="button" value="Cal" onclick="displayCalendar(birthday,'yyyy-mm-dd',this)">
          	格式為：YYYY-MM-DD
          	<span class="textfieldRequiredMsg">請輸入生日</span><span class="textfieldMinCharsMsg">請輸入生日</span></span>
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>電話：</td>
          <td align="left" class="board_add"><label>
          <span id="sprytextfield5">
            <input name="phone" type="text" id="phone" value="<?php echo $row_web_member['phone']; ?>" />
            <span class="textfieldRequiredMsg">請輸入電話</span><span class="textfieldMinCharsMsg">請輸入電話</span></span>
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>身分證字號：</td>
          <td align="left" class="board_add"><label>
            <?php echo $row_web_member['uid']; ?><input name="per_id" type="hidden" id="per_id" value="<?php echo $row_web_member['uid']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>郵遞區號：</td>
          <td align="left" class="board_add">
                          <select onchange="citychange(this.form)" name="Area">
                            <option value="基隆市" <?php if (!(strcmp("基隆市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>基隆市</option>
                            <option value="臺北市" selected="selected" <?php if (!(strcmp("臺北市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>臺北市</option>
                            <option value="新北市" <?php if (!(strcmp("新北市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>新北市</option>
                            <option value="桃園縣" <?php if (!(strcmp("桃園縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>桃園縣</option>
                            <option value="新竹市" <?php if (!(strcmp("新竹市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>新竹市</option>
                            <option value="新竹縣" <?php if (!(strcmp("新竹縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>新竹縣</option>
                            <option value="苗栗縣" <?php if (!(strcmp("苗栗縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>苗栗縣</option>
                            <option value="臺中市" <?php if (!(strcmp("臺中市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>臺中市</option>
                            <option value="彰化縣" <?php if (!(strcmp("彰化縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>彰化縣</option>
                            <option value="南投縣" <?php if (!(strcmp("南投縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>南投縣</option>
                            <option value="雲林縣" <?php if (!(strcmp("雲林縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>雲林縣</option>
                            <option value="嘉義市" <?php if (!(strcmp("嘉義市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>嘉義市</option>
                            <option value="嘉義縣" <?php if (!(strcmp("嘉義縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>嘉義縣</option>
                            <option value="臺南市" <?php if (!(strcmp("臺南市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>臺南市</option>
                            <option value="高雄市" <?php if (!(strcmp("高雄市", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>高雄市</option>
                            <option value="屏東縣" <?php if (!(strcmp("屏東縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>屏東縣</option>
                            <option value="臺東縣" <?php if (!(strcmp("臺東縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>臺東縣</option>
                            <option value="花蓮縣" <?php if (!(strcmp("花蓮縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>花蓮縣</option>
                            <option value="宜蘭縣" <?php if (!(strcmp("宜蘭縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>宜蘭縣</option>
                            <option value="澎湖縣" <?php if (!(strcmp("澎湖縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>澎湖縣</option>
                            <option value="金門縣" <?php if (!(strcmp("金門縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>金門縣</option>
                            <option value="連江縣" <?php if (!(strcmp("連江縣", $row_web_member['Area']))) {echo "selected=\"selected\"";} ?>>連江縣</option>
                          </select>
                          <!-- <span id="spryselect5"> -->
                          <select onchange="areachange(this.form)" name="cityarea">
                                <option value="<?php echo $row_web_member['cityarea']; ?>" selected="selected"><?php echo $row_web_member['cityarea']; ?></option>

                          </select><!-- <span class="textfieldRequiredMsg">請選擇地址區域</span></span> -->
                          <input type="hidden" value="100" name="Mcode" />
                          <input name="cuszip" value="<?php echo $row_web_member['cuszip']; ?>" size="5" maxlength="5" readonly="readOnly" />
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>詳細地址：<br><br></td>
          <td align="left" class="board_add"><span class="bs">
            <span id="sprytextfield3">
            <label for="cusadr"></label>
            <input type="text" name="cusadr" id="cusadr" value="<?php echo $row_web_member['cusadr']; ?>" size="60" />
            <span class="textfieldRequiredMsg">請輸入地址</span><span class="textfieldMinCharsMsg">請輸入地址</span></span></span>
		<br><span class="font_red"><?php echo "**(請填寫有效地址，寄發精熟級證書用)";?></span> </td>

		</tr>
        <tr>
          <td height="30" align="right" colspan="2" class="board_add">=========================================================================================</td>
        </tr>
        <tr>
        </tr>
        <!--	<td height="30" align="right" class="board_add"><span class="font_red">* </span>身份：</td>
        	<td align="left" class="board_add">
          <label>
            <input name="idtype" type="radio" id="radio" value="0" checked="checked" />
          		國民小學師資類科師資生
            <input name="idtype" type="radio" id="radio2" value="1" />
          		實習教師
          </label>
         <tr>
          <td height="30" align="right" class="board_add">教師證號碼：</td>
          <td align="left" class="board_add">
           <label>
            <input name="certificate" type="text" id="certificate" value="<?php echo $row_web_examinee2['certificate']; ?>" />
          </label>
            </td>
        </tr> -->
         <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>報考資格：<br>錄取順序一.<br>錄取順序二.<br>錄取順序三.<br>錄取順序四.</td>
           <td align="left" class="board_add">
          <label>本評量報考資格分為四類，其錄取順序如下：<br>
							<label class="radio-inline">
	          					<input type="radio" name="id" id="radio1" value="1"  onclick="popIdMsg();"  Checked/>
			          			<?php echo $allguide_lot[0]['nm']."<br>"?>
							</label>
							<label class="radio-inline">
			          			<input type="radio" name="id" id="radio2" value="2" onclick="popIdMsg();" />
			          			<?php echo $allguide_lot[1]['nm']."<br>"?>
							</label>
							<label class="radio-inline">
			          			<input type="radio" name="id" id="radio3" value="3"  onclick="popIdMsg();" />
			          			<?php echo $allguide_lot[2]['nm']."<br>"?>
							</label>
							<label class="radio-inline">
			          			<input type="radio" name="id" id="radio4" value="4"  onclick="popIdMsg();" />
			          			<?php echo $allguide_lot[3]['nm']."<br>"?>
							</label>
          </label>
          </td>
         </tr>
				 <!-- 上傳相片 BlueS 20180307 -->
				 <tr>
					 <td height="30" align="right" class="board_add" valign="top" style="line-height: 24px;"><span class="font_red">* </span>國民身分證正面：<br><span class="font_red">* </span>國民身分證反面：<br>
						 <div id="optionDiv1" style="display:inline-block;"><span class="font_red">* </span><span style="text-align:left;">學生證正面</span><br>(需有個人資訊)：<br></div>
						 <div id="optionDiv2" style="display:inline-block;"><span class="font_red">* </span>修畢師資職前教育<br>證明書：<br></div>
						 <div id="optionDiv3" style="display:inline-block;"><span class="font_red">* </span>實習學生證：</div>
						 <div id="optionDiv4" style="display:inline-block;"><span class="font_red">* </span>國小教師證書：</div></td>
					 <td class="board_add">
						 <span id="sprytextfield11">
							 <input type="file" name="news_pic1" id="news_pic1" />
							 <span class="textfieldRequiredMsg">請選擇照片</span><span class="textfieldMinCharsMsg">請選擇照片</span>
						 </span><br/>
						 <span id="sprytextfield12">
							 <input type="file" name="news_pic2" id="news_pic2" />
							 <span class="textfieldRequiredMsg">請選擇照片</span><span class="textfieldMinCharsMsg">請選擇照片</span>
						 </span><br/>
						<div id="optionDiv1-1" style="display:inline-block;"><br>
						 <span id="sprytextfield13">
							 <input type="file" name="news_pic3" id="news_pic3" />
							 <span class="textfieldRequiredMsg">請選擇照片</span><span class="textfieldMinCharsMsg">請選擇照片</span>
						 </span><br/>
					 	</div>
						<div id="optionDiv2-1" style="display:inline-block;"><br>
						 <span id="sprytextfield14">
							 <input type="file" name="news_pic4" id="news_pic4" />
							 <span class="textfieldRequiredMsg">請選擇照片</span><span class="textfieldMinCharsMsg">請選擇照片</span>
						 </span><br/>
					 	</div>
						<div id="optionDiv3-1" style="display:inline-block;">
							 <span id="sprytextfield15">
								 <input type="file" name="news_pic5" id="news_pic5" />
								 <span class="textfieldRequiredMsg">請選擇照片</span><span class="textfieldMinCharsMsg">請選擇照片</span>
							 </span><br/>
					 	</div>
						<div id="optionDiv4-1" style="display:inline-block;">
							<span id="sprytextfield16">
								<input type="file" name="news_pic6" id="news_pic6" />
								<span class="textfieldRequiredMsg">請選擇照片</span><span class="textfieldMinCharsMsg">請選擇照片</span>
							</span><br/>
					   </div><br/>
						<span class="font_red">**接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span>
					 </td>
				 </tr>
				 <!-- 結尾 -->
        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>報名科目：</td>
          <td align="left" class="board_add">

          <label><input name="Subjects[]" type="checkbox" id="Subjects[]" value="1" checked="checked" />
           國語 </label>
          <label><input type="checkbox" name="Subjects[]" id="Subjects[]" value="2" />
          數學 </label>
          <label><input type="checkbox" name="Subjects[]" id="Subjects[]" value="3" />
          社會 </label>
          <label><input type="checkbox" name="Subjects[]" id="Subjects[]" value="4" />
          自然
          </label>
          (可複選)</td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>
          <?php
//           		$event="required onchange=\"ShowMsg(this,'$todayyear')\"";
          		$event="required";
          		// Create the Element
				$sel =& $form->addElement('hierselect', 'exarea', '',$event);?>
          	評量考區：</td>
          <td align="left" class="board_add">
          <label>
          	<span id="spryselect3">
          	<?php
				// And add the selection options
				$sel->setOptions(array($select1, $select2, $select3));
				$form->display();
				?>
			<!--div id="msg">正取尚餘__人  ；備取尚餘 __人;</div> update by coway 2016.8.9-->
            <!-- <input type="radio" name="exarea" id="radio" value="Northern" checked="checked" />
          		北部
          	<input type="radio" name="exarea" id="radio2" value="Central" />
          		中部
          	<input type="radio" name="exarea" id="radio3" value="Southern" />
         		 南部
          	<input type="radio" name="exarea" id="radio4" value="Eastern" />
          		東部 -->
          	<span class="selectRequiredMsg">請選擇考場名稱</span></span>
          </label>
          <label>
          <!--<span id="spryselect1">
	           <select name="exam_school">
	          		<option>請選擇</option>
	          		<option value="01_國立臺北教育大學">國立臺北教育大學考場</option>
	          		<option value="02_臺北市立大學" >臺北市立大學考場</option>
	          		<option value="03_國立新竹教育大學" >國立新竹教育大學考場</option>
	          		<option value="04_國立臺中教育大學">國立臺中教育大學考場</option>
	          		<option value="05_國立嘉義大學" >國立嘉義大學考場</option>
	          		<option value="06_國立臺南大學" >國立臺南大學考場</option>
	          		<option value="07_國立屏東大學" >國立屏東大學考場</option>
	          		<option value="08_國立臺東大學" >國立臺東大學考場</option>
	          		<option value="09_國立東華大學" >國立東華大學考場</option>
	          </select>
          <span class="selectRequiredMsg">請選擇考場名稱</span></span> -->
          </label>
          <?php
			$datelineN=strtotime($row_web_new['ndate']);
			$datelineC=strtotime($row_web_new['cdate']);
			$datelineS=strtotime($row_web_new['sdate']);
			$datelineE=strtotime($row_web_new['edate']);
          ?>
          <!--<span id="spryselect2">
           <select name="exam_date">
          		<option>請選擇</option>
          		<option value="01"><?php echo (date('Y',$datelineN)-1911).date('年m月d日 ',$datelineN). "(".get_chinese_weekday($row_web_new['ndate']).")";?></option>
          		<option value="02"><?php echo (date('Y',$datelineC)-1911).date('年m月d日 ',$datelineC). "(".get_chinese_weekday($row_web_new['cdate']).")";?></option>
          		<option value="03"><?php echo (date('Y',$datelineS)-1911).date('年m月d日 ',$datelineS). "(".get_chinese_weekday($row_web_new['sdate']).")";?></option>
          		<option value="04"><?php echo (date('Y',$datelineE)-1911).date('年m月d日 ',$datelineE). "(".get_chinese_weekday($row_web_new['edate']).")";?></option>
          </select>
          <span class="selectRequiredMsg">請選擇考場場次</span>
          </span>-->
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>就讀學校：</td>
          <td align="left" class="board_add">
          <span id="spryselect4">
          <select name="school">
          		<option>請選擇</option>
				<option value="01_國立臺灣藝術大學"  <?php if (!(strcmp($row_web_examinee2['school'],"01_國立臺灣藝術大學"))) {echo "selected=\"selected\"";} ?>>國立臺灣藝術大學</option>
                <option value="02_文藻外語大學"  <?php if (!(strcmp($row_web_examinee2['school'],"02_文藻外語大學"))) {echo "selected=\"selected\"";} ?>>文藻外語大學</option>
                <option value="03_國立臺東大學"  <?php if (!(strcmp($row_web_examinee2['school'],"03_國立臺東大學"))) {echo "selected=\"selected\"";} ?> >國立臺東大學</option>
                <option value="04_國立東華大學" <?php if (!(strcmp($row_web_examinee2['school'],"04_國立東華大學"))) {echo "selected=\"selected\"";} ?> >國立東華大學</option>
                <option value="05_國立臺北教育大學" <?php if (!(strcmp($row_web_examinee2['school'],"05_國立臺北教育大學"))) {echo "selected=\"selected\"";} ?> >國立臺北教育大學</option>
                <option value="06_輔仁大學" <?php if (!(strcmp($row_web_examinee2['school'],"06_輔仁大學"))) {echo "selected=\"selected\"";} ?> >輔仁大學</option>
                <option value="07_南臺科技大學" <?php if (!(strcmp($row_web_examinee2['school'],"07_南臺科技大學"))) {echo "selected=\"selected\"";} ?> >南臺科技大學</option>
                <option value="08_國立屏東大學" <?php if (!(strcmp($row_web_examinee2['school'],"08_國立屏東大學"))) {echo "selected=\"selected\"";} ?> >國立屏東大學</option>
                <option value="09_靜宜大學" <?php if (!(strcmp($row_web_examinee2['school'],"09_靜宜大學"))) {echo "selected=\"selected\"";} ?> >靜宜大學</option>
                <option value="10_國立清華大學" <?php if (!(strcmp($row_web_examinee2['school'],"10_國立清華大學"))) {echo "selected=\"selected\"";} ?> >國立清華大學</option>
                <option value="11_國立臺南大學" <?php if (!(strcmp($row_web_examinee2['school'],"11_國立臺南大學"))) {echo "selected=\"selected\"";} ?> >國立臺南大學</option>
                <option value="12_國立高雄師範大學" <?php if (!(strcmp($row_web_examinee2['school'],"12_國立高雄師範大學"))) {echo "selected=\"selected\"";} ?> >國立高雄師範大學</option>
                <option value="13_國立臺中教育大學" <?php if (!(strcmp($row_web_examinee2['school'],"13_國立臺中教育大學"))) {echo "selected=\"selected\"";} ?> >國立臺中教育大學</option>
                <option value="14_臺北市立大學" <?php if (!(strcmp($row_web_examinee2['school'],"14_臺北市立大學"))) {echo "selected=\"selected\"";} ?> >臺北市立大學</option>
                <option value="15_國立嘉義大學" <?php if (!(strcmp($row_web_examinee2['school'],"15_國立嘉義大學"))) {echo "selected=\"selected\"";} ?> >國立嘉義大學</option>
                <option value="17_國立臺灣海洋大學" <?php if (!(strcmp($row_web_examinee2['school'],"17_國立臺灣海洋大學"))) {echo "selected=\"selected\"";} ?> >國立臺灣海洋大學</option>

            </select>
            <span class="selectRequiredMsg">請輸入學校</span></span>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>年級：</td>
          <td align="left" class="board_add">
          <label>
           <input <?php if (!(strcmp($row_web_examinee2['Grade'],"1"))) {echo "checked=\"checked\"";} ?> name="Grade" type="radio" id="radio1" value="1" checked="checked" />
          大一
          <input <?php if (!(strcmp($row_web_examinee2['Grade'],"2"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio2" value="2" />
          大二
          <input <?php if (!(strcmp($row_web_examinee2['Grade'],"3"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio3" value="3" />
          大三
          <input <?php if (!(strcmp($row_web_examinee2['Grade'],"4"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio4" value="4" />
          大四
          <input <?php if (!(strcmp($row_web_examinee2['Grade'],"5"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio5" value="5" />
          大五(含)以上
          <input <?php if (!(strcmp($row_web_examinee2['Grade'],"6"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio6" value="6" />
          研究所
          <input <?php if (!(strcmp($row_web_examinee2['Grade'],"7"))) {echo "checked=\"checked\"";} ?> type="radio" name="Grade" id="radio7" value="7" />
         已畢業
          </label>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>學號：</td>
          <td align="left" class="board_add"><label>

          <span id="sprytextfield1">
            <input type="text" name="Student_ID" id="Student_ID"  value="<?php echo $row_web_examinee2['Student_ID']; ?>" />(已畢業者請填畢業時之學號)
          <span class="textfieldRequiredMsg">請輸入學號</span><span class="textfieldMinCharsMsg">請輸入學號</span></span></label></td>
        </tr>
        <?php
          		$events=' class="input-normal" height="30" width="200" required onchange="areachange1(this.form)"';?>
        <tr>
        <?php
				$sel1 =& $form1->addElement('hierselect', 'edu1', '',$events);?>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>就讀科系：</td>
          <td align="left" class="board_add">
          <span id="spryselect5">
          <!-- <span id="sprytextfield2"> -->
          <?php
        		$sel1->setOptions(array($sele1, $sele2));
        		$form1->display();
        ?>
          <span class="selectRequiredMsg">請選擇科系</span></span>
		  <input name="High_college" type="hidden" ></input>
		  <input name="Department"  type="hidden" ></input>
          其他：<input type="text" name="High_college_other" id="High_college_other" style="width: 100px;" />學院 / <input type="text" name="Department_other" id="Department_other"  style="width: 100px;"/>系所 (已畢業者請填最高學歷之就讀科系)<!-- value="<?php //echo $row_web_examinee2['Department']; ?>" -->
          <!-- <span class="textfieldRequiredMsg">請輸入科系</span><span class="textfieldMinCharsMsg">請輸入科系</span></span> --></td>
        </tr>

        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>緊急聯絡人：</td>
          <td align="left" class="board_add" colspan="2">
          <label>
           <span id="sprytextfield8">
            <input name="contact" type="text" id="contact" value="<?php echo $row_web_examinee2['contact']; ?>" />
			<span class="textfieldRequiredMsg">請輸入聯絡人</span><span class="textfieldMinCharsMsg">請輸聯絡人</span></span>
          </label>
          </td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add"><span class="font_red">* </span>緊急聯絡人電話：</td>
          <td align="left" class="board_add" colspan="2">
          <label>
           <span id="sprytextfield9">
            <input name="contact_ph" type="text" id="contact_ph" value="<?php echo $row_web_examinee2['contact_ph']; ?>" />
			<span class="textfieldRequiredMsg">請輸入聯絡電話</span><span class="textfieldMinCharsMsg">請輸聯絡電話</span></span>
          </label>
          </td>
        </tr>
        <tr>
        <td height="30" align="right" class="board_add" style="width:  100px;"><span class="font_red">* </span>是否為特殊考生：</td>
	        <td align="left" class="board_add"><span class="table_lineheight">
						<label class="radio-special">
								<input type="radio" name="special_check" id="sqecial_radio" value="2"  />
								否
						</label>
						<label class="radio-special">
								<input type="radio" name="special_check" id="sqecial_radio" value="1" />
								是
						</label>
						<br>
						<div id="special_upload" style="display:inline-block;">
						 <span id="special_pic_upload1">特殊考場服務申請表：
							 <input type="file" name="special_pic1" id="special_pic1" />
						 </span><br/>
						 <span id="special_pic_upload2">應考服務診斷證明書：
							 <input type="file" name="special_pic2" id="special_pic2" />
						 </span><br/>
						 <span id="special_pic_upload3">應考切結書：
							 <input type="file" name="special_pic3" id="special_pic3" />
						 </span><br/>
	          <span class="font_red">**以上表格皆須使用本中心表格並掃描<br>接受檔案格式為：JPG、GIF、PNG，檔案大小不能超過3MB</span></span>
						</div>
	       </td>
			 </tr>

        <tr>
          <td height="40" colspan="2" align="center"><label>
            <input title="為協助各校師培單位研擬&#10;教學精進等相關措施&#10;您的應考資料本中心將開放予&#10;就讀學校師培處查詢" type="submit" name="button" id="button" value="報名資料儲存" onclick="SaveAlert()" />
            <input type="button" name="submit" value="回上一頁" onClick=window.history.back();>
            <input name="username" type="hidden" id="username" value="<?php echo $row_web_member['username']; ?>" />
            <input name="date" type="hidden" id="date" value="<? echo date("Y-m-d H:i:s");?>" />
            <input name="times" type="hidden" id="times" value="<?php echo $row_web_new['times']; ?>" />
            <input name="endday" type="hidden" id="endday" value="<?php echo $row_web_new['endday']; ?>" />
            <input name="examyear_id" type="hidden" id="examyear_id" value="<?php echo $row_web_new['id']; ?>" />

          </label></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form3" />
    </form>
     <?php
     	}elseif($row_web_examinee['username'] == $row_web_member['username'] && $row_web_examinee['apply_mk']=='1' && ($_GET["action"]!="delete")){

	?>
	<!-- 2016/03/07 teresa add -->
	<table width="555" border="0" cellspacing="0" cellpadding="0">
	    <tr>
	      <td height="80" align="center" class="font_red2">您已經完成報名了，請點選 <a href="progress.php?status=0"><img src="images/progress_check_t.png"  /></a> 查看審核情況。</td>

	      </tr>
	      <tr> <td align="center" style="color: blue; font-weight: bold; font-size: 16px;">若您需取消本梯次報名，請點選 <input type="button" name="btnSentDel" value="刪除報名>>" onclick="DeleteAlert();"/> 取消報名資格。 </td></tr>
	</table>
	<?php
	}elseif( ($_GET["action"]!="delete")){//否則顯示另依個區塊內容 (isset($_GET["action"])) ||
	?>
	<table width="555" border="0" cellspacing="0" cellpadding="0">
  	<tr>
  	<td height="80" align="center" class="font_red2">您已經填寫報名資料，請點選<a href="examOut.php"><img src="images/sign.png"  /></a>送出報名資料。</td>
  	</tr>
  	</table>
<?php
    //header('Location: examOut.php');
	}?>

<?PHP }else{?><table width="555" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2">目前尚未開放報名!</td>
      </tr>
  </table><?PHP }?>
<?php
  //刪除報名表 ,add by coway 2016.8.17

if ((isset($_GET["action"])) && ($_GET["action"]=="delete")){
	$ResultDel="";
	$deleteSQL = sprintf("DELETE FROM examinee WHERE no=%s",
			GetSQLValueString($row_web_examinee['no'], "text"));
	$deleteSQL_pic = sprintf("DELETE FROM examinee_pic WHERE examinee_no=%s",
			GetSQLValueString($row_web_examinee['no'], "text"));

	//echo "no=".$row_web_examinee["no"]."<br>";
	mysql_select_db($database_conn_web, $conn_web);
		$ResultDel = mysql_query($deleteSQL, $conn_web) or die(mysql_error());
	mysql_select_db($database_conn_web, $conn_web);
		$ResultDel_pic = mysql_query($deleteSQL_pic, $conn_web) or die(mysql_error());

		if($ResultDel && $ResultDel_pic)
		{
// 			echo "result=".$ResultDel;
		$deleteGoTo = "examAdd.php";
		header(sprintf("Location: %s", $deleteGoTo));
	?>
			<table width="570" border="0" cellspacing="0" cellpadding="0">
  			<tr>
  				<td height="80" align="center" class="font_red2">您已取消本梯次報名資格，欲重新報名者，請點選<a href="examAdd.php"><img src="images/sign.png"  /></a> 重新報名。</td>
  			</tr>
  			</table>
	<?php
	include("footer.php");
	exit();
		}
}
?>

  </div>
  <div id="main4"></div>

<?php include("footer.php"); ?>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:4, validateOn:["blur", "change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:2, validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {minChars:6, validateOn:["blur", "change"]});
//20160307 teresa add
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {minChars:8, validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {minChars:9, validateOn:["blur", "change"]});
//var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {minChars:5, validateOn:["blur", "change"]});
//var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var spryselect5 = new Spry.Widget.ValidationSelect("spryselect5");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "none", {minChars:2, validateOn:["blur", "change"]});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "none", {minChars:9, validateOn:["blur", "change"]});
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "none", {minChars:3, validateOn:["blur", "change"]});
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "none", {minChars:3, validateOn:["blur", "change"]});//11~14 錄取順序一
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "none", {minChars:3, validateOn:["blur", "change"]});
// var sprytextfield13 = new Spry.Widget.ValidationTextField("sprytextfield13", "none", {minChars:3, validateOn:["blur", "change"]});
// var sprytextfield14 = new Spry.Widget.ValidationTextField("sprytextfield14", "none", {minChars:3, validateOn:["blur", "change"]});
// var sprytextfield15 = new Spry.Widget.ValidationTextField("sprytextfield15", "none", {minChars:3, validateOn:["blur", "change"]});
</script>
</body>
</html>
<?php
function get_chinese_weekday($datetime)
{
    $weekday  = date('w', strtotime($datetime));
    $weeklist = array('日', '一', '二', '三', '四', '五', '六');
    return '星期' . $weeklist[$weekday];
}

?>
<?php
mysql_free_result($web_member);
//mysql_free_result($web_search);
mysql_free_result($web_examinee);
mysql_free_result($web_new);
?>
