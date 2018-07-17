<?php require_once('login_check.php'); ?>
<?php require_once('Connections/conn_web.php'); ?>
<?php
ini_set('memory_limit', '256M');
//**************************
//補件截止時間
$end_date="2019-04-23";

//****************************
if (phpversion() > "4.0.6") {
	$HTTP_POST_FILES = &$_FILES;
}

define("DESTINATION_PIC_FOLDER_ID", "images/examinee/id_check");
define("MAX_PIC_SIZE",5000000);
define("DESTINATION_PIC_FOLDER", "images/examinee");
define("no_error", "examAdd2.php");
define("yes_error", "examAdd2.php");
$_accepted_PIC_extensions_ = "jpg,gif,png";
if(strlen($_accepted_PIC_extensions_) > 0){
	$_accepted_PIC_extensions_ = @explode(",",$_accepted_PIC_extensions_);
} else {
	$_accepted_PIC_extensions_ = array();
}
/*	modify */
@$news_pic_title=$_POST["oldPictitle"];
@$newPicname=$_POST["oldPic"];

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







$colname_web_member = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_web_member = $_SESSION['MM_Username'];
}

if(isset($_GET['status'])){
	$exam_type = $_GET['status'];
}

mysql_select_db($database_conn_web, $conn_web);
$query_web_banner1 = "SELECT * FROM banner WHERE banner_type = '1' ORDER BY banner_id desc limit 1";//rand()
$web_banner1 = mysql_query($query_web_banner1, $conn_web) or die(mysql_error());
$row_web_banner1 = mysql_fetch_assoc($web_banner1);
$totalRows_web_banner1 = mysql_num_rows($web_banner1);

mysql_select_db($database_conn_web, $conn_web);
$query_web_banner2 = "SELECT * FROM banner WHERE banner_type = '2' OR banner_type = '3' order by rand() limit 1  ";
$web_banner2 = mysql_query($query_web_banner2, $conn_web) or die(mysql_error());
$row_web_banner2 = mysql_fetch_assoc($web_banner2);
$totalRows_web_banner2 = mysql_num_rows($web_banner2);
//add by coway 2016.9.20
mysql_select_db($database_conn_web, $conn_web);
$query_web_new = "SELECT * FROM examyear WHERE status='{$exam_type}' ORDER BY id DESC LIMIT 0,1";
$web_new = mysql_query($query_web_new, $conn_web) or die(mysql_error());
$row_web_new = mysql_fetch_assoc($web_new);
$totalRows_web_new = mysql_num_rows($web_new);

mysql_select_db($database_conn_web, $conn_web);
//update by coway 2016.8.19
// $query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND status = %s ORDER BY SUBSTR( id, 3, 4 ) DESC , SUBSTR( id, 2, 9 ) DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"), GetSQLValueString($exam_type, "text"));
//update by coway 2016.9.24  (增加已確認報名表方可列印報名表，apply_mk='1')
//add by coway 2016.10.14  (增加本梯次報名方可列印報名表，examyear_id)
$query_web_examinee = sprintf("SELECT * FROM examinee WHERE username = %s AND status = %s AND apply_mk='1' AND examyear_id=%s ORDER BY no DESC LIMIT 0,1", GetSQLValueString($colname_web_member, "text"), GetSQLValueString($exam_type, "text"), GetSQLValueString($row_web_new['id'], "text"));
$web_examinee = mysql_query($query_web_examinee, $conn_web) or die(mysql_error());
$row_web_examinee = mysql_fetch_assoc($web_examinee);
$totalRows_web_member = mysql_num_rows($web_examinee);


mysql_select_db($database_conn_web, $conn_web);
$query_web_allguide = sprintf("SELECT * FROM allguide WHERE up_no='MH'");
$web_allguide = mysql_query($query_web_allguide, $conn_web) or die(mysql_error());
$row_web_allguide = mysql_fetch_assoc($web_allguide);

$MailHost = $row_web_allguide['note'];

if($row_web_examinee["status"] == '0'){
	$up_no ='EA2';
}else $up_no ='EA';

mysql_select_db($database_conn_web, $conn_web);
//$query_allguide_EA = sprintf("SELECT * FROM allguide Where up_no='EA2' AND nm= %s AND data2= %s",GetSQLValueString($row_web_examinee['exarea'], "text"), GetSQLValueString($row_web_examinee['exarea_note'], "text"));
$query_allguide_EA = sprintf("SELECT * FROM allguide Where up_no= %s AND nm= %s AND data2= %s", GetSQLValueString($up_no, "text"),GetSQLValueString($row_web_examinee['exarea'], "text"), GetSQLValueString($row_web_examinee['exarea_note'], "text"));
$web_allguide_EA = mysql_query($query_allguide_EA, $conn_web) or die(mysql_error());
$row_allguide_EA = mysql_fetch_assoc($web_allguide_EA);

mysql_select_db($database_conn_web, $conn_web);
$query_web_member = sprintf("SELECT * FROM member  WHERE username = %s", GetSQLValueString($colname_web_member, "text"));
$web_member = mysql_query($query_web_member, $conn_web) or die(mysql_error());
$row_web_member = mysql_fetch_assoc($web_member);

mysql_select_db($database_conn_web, $conn_web);
$apply_user = sprintf("SELECT apply_mk FROM `examinee`  WHERE id=%s", GetSQLValueString($row_web_examinee['id'], "text"));
$web_apply = mysql_query($apply_user, $conn_web) or die(mysql_error());
$rowee = mysql_fetch_assoc($web_apply);
$rowee = $rowee['apply_mk'];

//各種check START
$up_load_count = 0;
$up_load_all = 0;


//1********************  BlueS 20180302 將身分證等資料傳至網頁
if(!empty($HTTP_POST_FILES['news_pic1'])){
if(is_uploaded_file($HTTP_POST_FILES['news_pic1']['tmp_name']) && $HTTP_POST_FILES['news_pic1']['error'] == 0){
  $up_load_all = $up_load_all+1 ;

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
	$attach = $row_web_examinee['username'];
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
		echo "<script>javascript:alert(\"請檢查國民身分證正面格式\");</script>";//跳出錯誤訊息
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
				@unlink('images/examinee/id_check/'.$_POST["oldPic1"]);
			//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
			//header("Location: " . no_error);
		} else {
			echo "<script>javascript:alert(\"發生錯誤!身分證正面有誤!\");</script>";//跳出錯誤訊息
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
	//updata
	$insertSQL_check = sprintf("UPDATE examinee_pic SET pic1_title = %s, `pic1_name` = %s
											WHERE examinee_no = %s",
  									 GetSQLValueString($news_pic_title1, "text"),
 										 GetSQLValueString($newPicname1, "text"),
 				 					   GetSQLValueString($row_web_examinee['no'], "text")
 	);
 	// echo "$insertSQL_check<br>";
 	// die();
 	mysql_select_db($database_conn_web, $conn_web);
 		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
  	$nums=mysql_affected_rows();
		if($nums==0){
		echo "<script>javascript:alert(\"上傳檔案失敗\");</script>";
	}else{
    $up_load_count = $up_load_count +1;
  }
}
}

//2*******************
if(!empty($HTTP_POST_FILES['news_pic2'])){
	if(is_uploaded_file($HTTP_POST_FILES['news_pic2']['tmp_name']) && $HTTP_POST_FILES['news_pic2']['error'] == 0){

    $up_load_all = $up_load_all+1 ;

		$_file_ = $HTTP_POST_FILES['news_pic2'];
		$errStr = "";
		$_name_ = $_file_['name'];
		$_type_ = $_file_['type'];
		$_tmp_name_ = $_file_['tmp_name'];
		$_size_ = $_file_['size'];
		header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_PIC_SIZE && MAX_PIC_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"國民身分證反面，超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$attach = $row_web_examinee['username'];
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
			echo "<script>javascript:alert(\"請檢查國民身分證反面格式\");</script>";//跳出錯誤訊息
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
					@unlink('images/examinee/id_check/'.$_POST["oldPic2"]);
				// @unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
				//header("Location: " . no_error);
			} else {
				echo "<script>javascript:alert(\"發生錯誤!身分證反面有誤！\");</script>";//跳出錯誤訊息
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
		//updata
		$insertSQL_check = sprintf("UPDATE examinee_pic SET pic2_title = %s, `pic2_name` = %s
												WHERE examinee_no = %s",
	  									 GetSQLValueString($news_pic_title2, "text"),
	 										 GetSQLValueString($newPicname2, "text"),
	 				 					   GetSQLValueString($row_web_examinee['no'], "text")
	 	);
	 	// echo "$insertSQL_check<br>";
	 	// die();
	 	mysql_select_db($database_conn_web, $conn_web);
	 		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
	  	$nums=mysql_affected_rows();
			if($nums==0){
			echo "<script>javascript:alert(\"身分證反面上傳檔案失敗\");</script>";
		}else{
      $up_load_count = $up_load_count +1;
    }
	}
}
//3********************
if(!empty($HTTP_POST_FILES['news_pic3'])){
	if(is_uploaded_file($HTTP_POST_FILES['news_pic3']['tmp_name']) && $HTTP_POST_FILES['news_pic3']['error'] == 0){

    $up_load_all = $up_load_all+1 ;

		$_file_ = $HTTP_POST_FILES['news_pic3'];
		$errStr = "";
		$_name_ = $_file_['name'];
		$_type_ = $_file_['type'];
		$_tmp_name_ = $_file_['tmp_name'];
		$_size_ = $_file_['size'];
		header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_PIC_SIZE && MAX_PIC_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"修畢師資職前教育證明書超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$attach = $row_web_examinee['username'];
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
			echo "<script>javascript:alert(\"請檢查修畢師資職前教育證明書格式\");</script>";//跳出錯誤訊息
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
				@unlink('images/examinee/id_check/'.$_POST["oldPic3"]);
				// @unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
				//header("Location: " . no_error);
			} else {
				echo "<script>javascript:alert(\"修畢師資職前教育證明書發生錯誤!\");</script>";//跳出錯誤訊息
				echo "<script>history.back()</script>";//回上一頁
				exit;                                  //停止後續程式碼的繼續執行
				//header("Location: " . yes_error);
			}
		} else {
			echo "<script>javascript:alert(\"修畢師資職前教育證明書發生錯誤!\");</script>";//跳出錯誤訊息
			echo "<script>history.back()</script>";//回上一頁
				exit;	                               //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}
		//updata
		$insertSQL_check = sprintf("UPDATE examinee_pic SET pic3_title = %s, `pic3_name` = %s
												WHERE examinee_no = %s",
	  									 GetSQLValueString($news_pic_title3, "text"),
	 										 GetSQLValueString($newPicname3, "text"),
	 				 					   GetSQLValueString($row_web_examinee['no'], "text")
	 	);
	 	// echo "$insertSQL_check<br>";
	 	// die();
	 	mysql_select_db($database_conn_web, $conn_web);
	 		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
	  	$nums=mysql_affected_rows();
			if($nums==0){
			echo "<script>javascript:alert(\"修畢師資職前教育證明書，上傳檔案失敗\");</script>";
		}else{
      $up_load_count = $up_load_count +1;
    }
	}
}
//4********************
if(!empty($HTTP_POST_FILES['news_pic4'])){
	if(is_uploaded_file($HTTP_POST_FILES['news_pic4']['tmp_name']) && $HTTP_POST_FILES['news_pic4']['error'] == 0){

    $up_load_all = $up_load_all+1 ;

		$_file_ = $HTTP_POST_FILES['news_pic4'];
		$errStr = "";
		$_name_ = $_file_['name'];
		$_type_ = $_file_['type'];
		$_tmp_name_ = $_file_['tmp_name'];
		$_size_ = $_file_['size'];
		header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_PIC_SIZE && MAX_PIC_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"實習學生證超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$attach = $row_web_examinee['username'];
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
			echo "<script>javascript:alert(\"請檢查實習學生證格式\");</script>";//跳出錯誤訊息
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
				@unlink('images/examinee/id_check/'.$_POST["oldPic4"]);
				// @unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
				//header("Location: " . no_error);
			} else {
				echo "<script>javascript:alert(\"發生錯誤!實習學生證上傳失敗\");</script>";//跳出錯誤訊息
				echo "<script>history.back()</script>";//回上一頁
				exit;                                  //停止後續程式碼的繼續執行
				//header("Location: " . yes_error);
			}
		} else {
			echo "<script>javascript:alert(\"發生錯誤!實習學生證上傳失敗\");</script>";//跳出錯誤訊息
			echo "<script>history.back()</script>";//回上一頁
				exit;	                               //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}
		//updata
		$insertSQL_check = sprintf("UPDATE examinee_pic SET pic4_title = %s, `pic4_name` = %s
												WHERE examinee_no = %s",
	  									 GetSQLValueString($news_pic_title4, "text"),
	 										 GetSQLValueString($newPicname4, "text"),
	 				 					   GetSQLValueString($row_web_examinee['no'], "text")
	 	);
	 	// echo "$insertSQL_check<br>";
	 	// die();
	 	mysql_select_db($database_conn_web, $conn_web);
	 		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
	  	$nums=mysql_affected_rows();
			if($nums==0){
			echo "<script>javascript:alert(\"實習學生證上傳檔案失敗\");</script>";
		}else{
      $up_load_count = $up_load_count +1;
    }
	}
}
//5********************
if(!empty($HTTP_POST_FILES['news_pic5'])){
	if(is_uploaded_file($HTTP_POST_FILES['news_pic5']['tmp_name']) && $HTTP_POST_FILES['news_pic5']['error'] == 0){

    $up_load_all = $up_load_all+1 ;

		$_file_ = $HTTP_POST_FILES['news_pic5'];
		$errStr = "";
		$_name_ = $_file_['name'];
		$_type_ = $_file_['type'];
		$_tmp_name_ = $_file_['tmp_name'];
		$_size_ = $_file_['size'];
		header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_PIC_SIZE && MAX_PIC_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"學生證正面超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$attach = $row_web_examinee['username'];
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
			echo "<script>javascript:alert(\"請檢查學生證正面格式\");</script>";//跳出錯誤訊息
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
				@unlink('images/examinee/id_check/'.$_POST["oldPic5"]);
				// @unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
				//header("Location: " . no_error);
			} else {
				echo "<script>javascript:alert(\"發生錯誤!學生證正面上傳失敗！\");</script>";//跳出錯誤訊息
				echo "<script>history.back()</script>";//回上一頁
				exit;                                  //停止後續程式碼的繼續執行
				//header("Location: " . yes_error);
			}
		} else {
			echo "<script>javascript:alert(\"發生錯誤!學生證正面上傳失敗！\");</script>";//跳出錯誤訊息
			echo "<script>history.back()</script>";//回上一頁
				exit;	                               //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}

	// echo "title1=$newPicname5<br>"; $news_pic_title5
	//updata
	$insertSQL_check = sprintf("UPDATE examinee_pic SET pic5_title = %s, `pic5_name` = %s
											WHERE examinee_no = %s",
  									 GetSQLValueString($news_pic_title5, "text"),
 										 GetSQLValueString($newPicname5, "text"),
 				 					   GetSQLValueString($row_web_examinee['no'], "text")
 	);
 	// echo "$insertSQL_check<br>";
 	// die();
 	mysql_select_db($database_conn_web, $conn_web);
 		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
  	$nums=mysql_affected_rows();
		if($nums==0){
			echo "<script>javascript:alert(\"學生證正面上傳檔案失敗\");</script>";
		}else{
      $up_load_count = $up_load_count +1;
    }
	}
}
//特殊考生1********************
if(!empty($HTTP_POST_FILES['special_pic1'])){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['special_pic1']['tmp_name']) && $HTTP_POST_FILES['special_pic1']['error'] == 0){

    $up_load_all = $up_load_all+1 ;

		$_file_ = $HTTP_POST_FILES['special_pic1'];
		$errStr = "";
		$_name_ = $_file_['name'];
		$_type_ = $_file_['type'];
		$_tmp_name_ = $_file_['tmp_name'];
		$_size_ = $_file_['size'];
		header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_PIC_SIZE && MAX_PIC_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"特殊考場服務申請表超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$attach = $row_web_examinee['username'];
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
			echo "<script>javascript:alert(\"請檢查特殊考場服務申請表格式\");</script>";//跳出錯誤訊息
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
				// @unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
				//header("Location: " . no_error);
			} else {
				echo "<script>javascript:alert(\"發生錯誤!特殊考場服務申請表上傳失敗！\");</script>";//跳出錯誤訊息
				echo "<script>history.back()</script>";//回上一頁
				exit;                                  //停止後續程式碼的繼續執行
				//header("Location: " . yes_error);
			}
		} else {
			echo "<script>javascript:alert(\"發生錯誤!特殊考場服務申請表上傳失敗！\");</script>";//跳出錯誤訊息
			echo "<script>history.back()</script>";//回上一頁
				exit;	                               //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}

	//updata
	$insertSQL_check = sprintf("UPDATE examinee_pic SET special_pic_title1 = %s, `special_pic_name1` = %s
											WHERE examinee_no = %s",
										 GetSQLValueString($special_pic_title1, "text"),
										 GetSQLValueString($special_pic_name1, "text"),
										 GetSQLValueString($row_web_examinee['no'], "text")
	);
	// echo "$insertSQL_check<br>";
	// die();
	mysql_select_db($database_conn_web, $conn_web);
		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error(""));
		$nums=mysql_affected_rows();
		if($nums==0){
		echo "<script>javascript:alert(\"特殊考場服務申請表，上傳檔案失敗\");</script>";
	}else{
    $up_load_count = $up_load_count +1;
  }
	// echo "title1=$newPicname5<br>"; $news_pic_title5
	}
}
//特殊考生2********************
if(!empty($HTTP_POST_FILES['special_pic2'])){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['special_pic2']['tmp_name']) && $HTTP_POST_FILES['special_pic2']['error'] == 0){

    $up_load_all = $up_load_all + 1 ;

  	$_file_ = $HTTP_POST_FILES['special_pic2'];
		$errStr = "";
		$_name_ = $_file_['name'];
		$_type_ = $_file_['type'];
		$_tmp_name_ = $_file_['tmp_name'];
		$_size_ = $_file_['size'];
		header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_PIC_SIZE && MAX_PIC_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"應考服務診斷證明書，超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$attach = $row_web_examinee['username'];
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
			echo "<script>javascript:alert(\"請檢查應考服務診斷證明書格式\");</script>";//跳出錯誤訊息
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
				// @unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
				//header("Location: " . no_error);
			} else {
				echo "<script>javascript:alert(\"發生錯誤!應考服務診斷證明書上傳失敗！\");</script>";//跳出錯誤訊息
				echo "<script>history.back()</script>";//回上一頁
				exit;                                  //停止後續程式碼的繼續執行
				//header("Location: " . yes_error);
			}
		} else {
			echo "<script>javascript:alert(\"發生錯誤!應考服務診斷證明書上傳失敗！\");</script>";//跳出錯誤訊息
			echo "<script>history.back()</script>";//回上一頁
				exit;	                               //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}

	//updata
	$insertSQL_check = sprintf("UPDATE examinee_pic SET special_pic_title2 = %s, `special_pic_name2` = %s
											WHERE examinee_no = %s",
										 GetSQLValueString($special_pic_title2, "text"),
										 GetSQLValueString($special_pic_name2, "text"),
										 GetSQLValueString($row_web_examinee['no'], "text")
	);
	// echo "$insertSQL_check<br>";
	// die();
	mysql_select_db($database_conn_web, $conn_web);
		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error(""));
		$nums=mysql_affected_rows();
		if($nums==0){
		echo "<script>javascript:alert(\"應考服務診斷證明書，上傳檔案失敗\");</script>";
	}else{
    $up_load_count = $up_load_count +1;
  }
	// echo "title1=$newPicname5<br>"; $news_pic_title5
	}
}
//特殊考生3********************

if(!empty($HTTP_POST_FILES['special_pic3'])){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['special_pic3']['tmp_name']) && $HTTP_POST_FILES['special_pic3']['error'] == 0){

    $up_load_all = $up_load_all+1 ;

		$_file_ = $HTTP_POST_FILES['special_pic3'];
		$errStr = "";
		$_name_ = $_file_['name'];
		$_type_ = $_file_['type'];
		$_tmp_name_ = $_file_['tmp_name'];
		$_size_ = $_file_['size'];
		header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_PIC_SIZE && MAX_PIC_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"應考切結書，超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$attach = $row_web_examinee['username'];
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
			echo "<script>javascript:alert(\"請檢查應考切結書格式\");</script>";//跳出錯誤訊息
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
				// @unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
				//header("Location: " . no_error);
			} else {
				echo "<script>javascript:alert(\"發生錯誤!應考切結書上傳失敗！\");</script>";//跳出錯誤訊息
				echo "<script>history.back()</script>";//回上一頁
				exit;                                  //停止後續程式碼的繼續執行
				//header("Location: " . yes_error);
			}
		} else {
			echo "<script>javascript:alert(\"發生錯誤!應考切結書上傳失敗！\");</script>";//跳出錯誤訊息
			echo "<script>history.back()</script>";//回上一頁
				exit;	                               //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}

	//updata
	$insertSQL_check = sprintf("UPDATE examinee_pic SET special_pic_title3 = %s, `special_pic_name3` = %s
											WHERE examinee_no = %s",
										 GetSQLValueString($special_pic_title3, "text"),
										 GetSQLValueString($special_pic_name3, "text"),
										 GetSQLValueString($row_web_examinee['no'], "text")
	);
	// echo "$insertSQL_check<br>";
	// die();
	mysql_select_db($database_conn_web, $conn_web);
		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error(""));
		$nums=mysql_affected_rows();
		if($nums==0){
		echo "<script>javascript:alert(\"應考切結書，上傳檔案失敗\");</script>";
	}else{
    $up_load_count = $up_load_count +1;
  }
	// echo "title1=$newPicname5<br>"; $news_pic_title5
	}
}
//改名********************

if(!empty($HTTP_POST_FILES['rename_pic'])){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['rename_pic']['tmp_name']) && $HTTP_POST_FILES['rename_pic']['error'] == 0){

    $up_load_all = $up_load_all+1 ;


		$_file_ = $HTTP_POST_FILES['rename_pic'];
		$errStr = "";
		$_name_ = $_file_['name'];
		$_type_ = $_file_['type'];
		$_tmp_name_ = $_file_['tmp_name'];
		$_size_ = $_file_['size'];
		header ('Content-type: text/html; charset=utf-8');//指定編碼
		if($_size_ > MAX_PIC_SIZE && MAX_PIC_SIZE > 0){
			$errStr = "File troppo pesante";
			echo "<script>javascript:alert(\"戶口名簿，超過限制檔案大小\");</script>";//跳出錯誤訊息
		}
		$_ext_ = explode(".", $_name_);
		$attach = $row_web_examinee['username'];
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
			echo "<script>javascript:alert(\"請檢查戶口名簿檔案格式\");</script>";//跳出錯誤訊息
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
				// @unlink('images/examinee/'.$_POST["oldPic"]);//依據傳過來的舊圖檔名，指定路徑刪除它  抓sql的oldpic
				//header("Location: " . no_error);
			} else {
				echo "<script>javascript:alert(\"上傳戶口名簿發生錯誤!\");</script>";//跳出錯誤訊息
				echo "<script>history.back()</script>";//回上一頁
				exit;                                  //停止後續程式碼的繼續執行
				//header("Location: " . yes_error);
			}
		} else {
			echo "<script>javascript:alert(\"上傳戶口名簿發生錯誤!\");</script>";//跳出錯誤訊息
			echo "<script>history.back()</script>";//回上一頁
				exit;	                               //停止後續程式碼的繼續執行
			//header("Location: " . yes_error);
		}
	$insertSQL_check = sprintf("UPDATE examinee_pic SET rename_pic_title = %s, `rename_pic_name` = %s
											WHERE examinee_no = %s",
										 GetSQLValueString($rename_pic_title, "text"),
										 GetSQLValueString($rename_pic_name, "text"),
										 GetSQLValueString($row_web_examinee['no'], "text")
	);
	// echo "$insertSQL_check<br>";
	// die();
	mysql_select_db($database_conn_web, $conn_web);
		$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
		$nums=mysql_affected_rows();
		if($nums==0){
		echo "<script>javascript:alert(\"戶口名簿上傳失敗\");</script>";
	}else{
    $up_load_count = $up_load_count +1;
  }
}

	// echo "title1=$newPicname5<br>"; $news_pic_title5
}
//6***********************大頭照
if(!empty($HTTP_POST_FILES['news_pic'])){ //如果你的上傳檔案欄位不是取名為news_pic，請將你的欄位名稱取代所有news_pic名稱
	if(is_uploaded_file($HTTP_POST_FILES['news_pic']['tmp_name']) && $HTTP_POST_FILES['news_pic']['error'] == 0){
		$up_load_all = $up_load_all+1 ;

		$_file_ = $HTTP_POST_FILES['news_pic'];
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
				$src2 = imagecreatefromjpeg($_FILES['news_pic']['tmp_name']);
				break;
			case "image/png":
				$src2 = imagecreatefrompng($_FILES['news_pic']['tmp_name']);
				break;
			case "image/gif":
				$src2 = imagecreatefromgif($_FILES['news_pic']['tmp_name']);
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

		if(!in_array($_ext_, $_accepted_PIC_extensions_) && count($_accepted_PIC_extensions_) > 0){
			$errStr = "Estensione non valida";
			echo "<script>javascript:alert(\"請檢查大頭照檔案格式\");</script>";//跳出錯誤訊息
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
		$insertSQL_check = sprintf("UPDATE examinee SET pic_title = %s, pic_name = %s
												WHERE no = %s",
											 GetSQLValueString($news_pic_title, "text"),
											 GetSQLValueString($newPicname, "text"),
											 GetSQLValueString($row_web_examinee['no'], "text")
		);
		// echo "$insertSQL_check<br>";
		// die();
		mysql_select_db($database_conn_web, $conn_web);
			$Result1 = mysql_query($insertSQL_check, $conn_web) or die(mysql_error("GG"));
			$nums=mysql_affected_rows();
			if($nums==0){
			echo "<script>javascript:alert(\"大頭照上傳失敗\");</script>";
		}else{
			$up_load_count = $up_load_count +1;
		}
	}
}

// die();
//各種check END
if($up_load_all != '0'){
	if($_GET['status'] == '0'){
		echo "<script>alert('上傳完成，請確認照片是否變更'); location.href = 'examOuttoprint_ts.php';</script>";
	}
	if($_GET['status'] == '1'){
		echo "<script>alert('上傳完成，請確認照片是否變更'); location.href = 'examOuttoprint.php';</script>";
	}

}



if($_GET['check']=='ok'){
	if($rowee==1){
		echo '<script type="text/javascript">alert("您已完成線上報名登錄，您的網路登錄報名流水號為：'.$_GET['cert_number'].'。");location.href = "progress.php?status=1";</script>';
	}else{
		echo '<script type="text/javascript">alert("報名尚未完成！\n請再次勾選確認報名表資料!!");location.href = "examOut1.php";</script>';


// 		header(sprintf("Location: %s", $returncheck));$returncheck="examOut1.php";
	}
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
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
 <script type="text/javascript">
	function CheckMailVal(){
		//console.log(MailHost+'/EasyMVC/Home/queryList/'+id);
		alert("因E-mail未認證通知，請至信箱收信並進行E-mail認證");
		//window.location = '';
		window.location = 'progress.php';// echo "$MailHost/EasyMVC/Home/queryList/$row_web_member[id]";
	}
 </script>
</head>
<body  background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <?php include("leftzone.php")?>
  </div>
  <div id="main3" style="height:600px;">
    <table width="545" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20">
          <marquee onMouseOver="this.stop()" onMouseOut="this.start()" bgcolor="#efefef" border="0" align="middle" scrollamount="2"  scrolldelay="90" behavior="scroll"  width="100%" height="20" style="color: #000000; font-size: 12">
            <a href="<?php echo $row_web_banner1['banner_url']; ?>"><img src="images/hot.gif" width="28" height="7" border="0" /><?php echo $row_web_banner1['banner_title']; ?></a>
          </marquee>
        </td>
      </tr>
    </table>
<table width="545" border="0" cellspacing="0" cellpadding="0">

</table>
    <img src="images/progress.png" width="540" height="48" /><br />


<?php if($totalRows_web_member == 0){ //判斷本次是否有報名 ?>
  <table width="540" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="80" align="center" class="font_red2" bgcolor="#FFFFFF">您尚未報名本次測驗</td>
      </tr>
  </table>
<?php }else{ ?>
        <table width="540" border="0" cellspacing="0" cellpadding="2" bgcolor="#FFFFFF">
        <tr>
          <td width="100" height="30" align="right" class="board_add4">線上報名登錄：</td>
          <td align="left" class="board_add4" > 已完成</td>
          <td width="140" height="130" align="center"  rowspan="4" style="border-style:solid; border-color:#999999; border-width:1px;"><img src="images/examinee/<?php echo $row_web_examinee['pic_name']; ?>" alt="" name="pic" width="100" id="pic"


            ></tr>
         <!-- <tr>
          <td height="30" align="right" class="board_add4"></td>

          <td align="left" class="board_add4"><font color="#FF0000">請確認右方大頭照是否已正確上傳。</font> </td>

           </tr>-->
           <tr>
          <td height="30" align="right" class="board_add4">報名科目：</td>
          <td align="left" class="board_add4"><?php $str=split("," , $row_web_examinee['category']);
			foreach ($str as $val){
			if (!(strcmp($val,"1"))) {echo "國語領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"2"))) {echo "數學領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"3"))) {echo "社會領域&nbsp;,&nbsp;";}
			if (!(strcmp($val,"4"))) {echo "自然領域";}} ?></td>
          </tr>
          <tr>
          <td height="30" align="right" class="board_add4">評量考區：</td>
          <td align="left" class="board_add4">
          <?php echo $row_allguide_EA['note']." ， ".$row_allguide_EA['data1'];?>
          <?php /*if (!(strcmp($row_web_examinee['exarea'],"Northern"))) {echo "臺北(國立臺灣大學)";}
		  if (!(strcmp($row_web_examinee['exarea'],"Central"))) {echo "臺中(國立臺中教育大學)";}
		  if (!(strcmp($row_web_examinee['exarea'],"Southern"))) {echo "高雄(高雄市私立三信家事商業職業學校)";}
		  if (!(strcmp($row_web_examinee['exarea'],"Eastern"))) {echo "花蓮(國立花蓮高級商業職業學校)";} */
		   ?>
          </td>
          </tr>
        <tr>
          <td height="30" align="right" class="board_add4">檢視報名表：</td>
          <td align="left" class="board_add4">
          <?php
          	if($row_web_examinee['status'] == 1){
          		$report_url='examOuttoprint.php';
          	}else $report_url='examOuttoprint_ts.php';

          	if($row_web_member['status']== 0){
          		$report_url = "$MailHost/EasyMVC/Home/queryList/$row_web_member[id]";
          	}
          ?>
          <a href="<?php echo $report_url;?>">
          	<img src="images/progress_look.png"  onclick="<?php if($row_web_member['status'] == 0) echo "CheckMailVal()";?>" /></a></td>
           <td height="30" align="right" class="board_add4"></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add4">資料審查：</td>
          <td align="left" class="board_add4">

           <?php

           // if(strtotime($row_web_new['endday']) < strtotime(date('Y-m-d'))){//add by coway 2016.9.20?>
          <?php //20180417 BlueS 顯示審核狀態
          if($row_web_examinee['allow']=="YY"){
					echo "<font color='#FF0000'>審核通過</font>";
        }elseif($row_web_examinee['allow']=="Y"){
					echo "<font color='#FF0000'>初步審核通過</font>";
				}elseif($row_web_examinee['allow'] == "N"){
					echo "<font color='#FF0000'>審核不通過</font>";
				}elseif($row_web_examinee['allow'] == "0"){
					echo "<font color='#FF0000'>審核中</font>";
				}else{
					echo "<font color='#FF0000'>初步審核不通過</font>";
				} ?>
           </td>
           <td height="30" align="right" class="board_add4"></td>
        </tr>
        <tr>
          <td height="30" align="right" class="board_add4">資料審查說明：</td>
          <td align="left" class="board_add4"><?php echo $row_web_examinee['allow_note']?></td>
           <td height="30" align="right" class="board_add4"></td>
        </tr>
        <!-- 20180305 BlueS 補件上傳處 -->
        <?php
// 				1身分證正面
// 2身分證反面
// 3修畢師資職前教育證明書，最高學歷學位證書
// 4實習學生證， 國民小學教師證書
// 5學生證正面， 在職證明書
// 6大頭照
// 7改名
// a特殊考生
// b
// c
// echo strtotime(date('Y-m-d'));
				if(strtotime(date('Y-m-d')) <= strtotime($end_date) ){
					//師資生補件區
	        if($row_web_examinee['allow'] != 0 && $exam_type == '0'){ ?>
	          <form id="form3" name="form3" method="post" enctype="multipart/form-data" action="<?php echo $editFormAction; ?>" >
	        <tr>
	          <td height="30" ></td>
	          <td height="30" align="center" style="font-size: 21px; color: #F00;">補件資料上傳</td>
	          <td height="30" ><?php //echo $row_web_examinee['allow'];?></td>
	        </tr>

	        <?php
					$tmp6=strpos($row_web_examinee['allow'], '6');
	        if(false !== $tmp6){
						$tmp6 ='1';
	        ?>
	        <tr>
	          <td height="30" align="right" class="board_add4">大頭照：</td>
	          <td align="left" class="board_add4">
	            <div id="optionDiv2-1" style="display:inline-block;">
	             <span id="sprytextfield14">
	               <input type="file" name="news_pic" id="news_pic" />
	             </span><br/>
	            </div>
	          </td>
	           <td height="30" align="right" class="board_add4"></td>
	        </tr>
	      <?php }
	        // echo $row_web_examinee['allow'];
	        $tmp1=strpos($row_web_examinee['allow'], '1');
	          if( false !== $tmp1 ){
							$tmp1 ='1';
	            ?>
	        <tr>
	          <td height="30" align="right" class="board_add4">國民身分證正面：</td>
	          <td align="left" class="board_add4">
	            <div id="optionDiv2-1" style="display:inline-block;">
	             <span id="sprytextfield14">
	               <input type="file" name="news_pic1" id="news_pic1" />
	             </span><br/>
	            </div>
	          </td>
	           <td height="30" align="right" class="board_add4"></td>
	        </tr>
	      <?php }
	      $tmp2=strpos($row_web_examinee['allow'], '2');
	        if(false !== $tmp2){
						$tmp2 ='1';
	        ?>
	        <tr>
	          <td height="30" align="right" class="board_add4">國民身分證反面：</td>
	          <td align="left" class="board_add4">
	            <div id="optionDiv2-1" style="display:inline-block;">
	             <span id="sprytextfield14">
	               <input type="file" name="news_pic2" id="news_pic2" />
	             </span><br/>
	            </div>
	          </td>
	           <td height="30" align="right" class="board_add4"></td>
	        </tr>
	      <?php }
	        $tmp3=strpos($row_web_examinee['allow'], '3');
	        if(false !== $tmp3){
						$tmp3 ='1';
	        ?>
	        <tr>
	          <td height="30" align="right" class="board_add4">修畢師資職前<br>教育證明書：</td>
	          <td align="left" class="board_add4">
	            <div id="optionDiv2-1" style="display:inline-block;">
	             <span id="sprytextfield14">
	               <input type="file" name="news_pic3" id="news_pic3" />
	             </span><br/>
	            </div>
	          </td>
	           <td height="30" align="right" class="board_add4"></td>
	        </tr>
	      <?php }
	        $tmp4=strpos($row_web_examinee['allow'], '4');
	        if(false !== $tmp4){
						$tmp4 ='1';
	        ?>
	        <tr>
	          <td height="30" align="right" class="board_add4">實習學生證：</td>
	          <td align="left" class="board_add4">
	            <div id="optionDiv2-1" style="display:inline-block;">
	             <span id="sprytextfield14">
	               <input type="file" name="news_pic4" id="news_pic4" />
	             </span><br/>
	            </div>
	          </td>
	           <td height="30" align="right" class="board_add4"></td>
	        </tr>
	      <?php }
	        $tmp5=strpos($row_web_examinee['allow'], '5');
	        if(false !== $tmp5){
						$tmp5 ='1';
	        ?>
	        <tr>
	          <td height="30" align="right" class="board_add4">學生證正面：</td>
	          <td align="left" class="board_add4">
	            <div id="optionDiv2-1" style="display:inline-block;">
	             <span id="sprytextfield14">
	               <input type="file" name="news_pic5" id="news_pic5" />
	             </span><br/>
	            </div></td>
	           <td height="30" align="right" class="board_add4"></td>
	        </tr>
	      <?php }
		  $tmp5=strpos($row_web_examinee['allow'], '7');
		  if(false !== $tmp5){
					  $tmp5 ='1';
		  ?>
		  <tr>
			<td height="30" align="right" class="board_add4">國小教師證書：</td>
			<td align="left" class="board_add4">
			  <div id="optionDiv2-1" style="display:inline-block;">
			   <span id="sprytextfield14">
				 <input type="file" name="news_pic5" id="news_pic5" />
			   </span><br/>
			  </div></td>
			 <td height="30" align="right" class="board_add4"></td>
		  </tr>
		<?php }
				$tmp7=strpos($row_web_examinee['allow'], 'a');
				if( false !== $tmp7){
					$tmp7 ='1';
				?>
				<tr>
					<td height="30" align="right" class="board_add4">戶籍謄本：</td>
					<td align="left" class="board_add4">
						<div id="optionDiv2-1" style="display:inline-block;">
						 <span id="sprytextfield14">
							 <input type="file" name="rename_pic" id="rename_pic" />
						 </span><br/>
						</div></td>
					 <td height="30" align="right" class="board_add4"></td>
				</tr>
			<?php }
	    }elseif ($row_web_examinee['allow'] != 0 && $exam_type == '1'){?>
				<form id="form3" name="form3" method="post" enctype="multipart/form-data" action="<?php echo $editFormAction; ?>" >
	    <tr>
	      <td height="30" ></td>
	      <td height="30" align="center" style="font-size: 21px; color: #F00;">補件資料上傳</td>
	      <td height="30" ><?php //echo $row_web_examinee['allow'];?></td>
	    </tr>
	    <?php
			$tmp6=strpos($row_web_examinee['allow'], '6');
			if(false !== $tmp6){
				$tmp6 ='1';
			?>
			<tr>
				<td height="30" align="right" class="board_add4">大頭照：</td>
				<td align="left" class="board_add4">
					<div id="optionDiv2-1" style="display:inline-block;">
					 <span id="sprytextfield14">
						 <input type="file" name="news_pic" id="news_pic" />
					 </span><br/>
					</div>
				</td>
				 <td height="30" align="right" class="board_add4"></td>
			</tr>
		<?php }

	    $tmp1=strpos($row_web_examinee['allow'], '1');
	      if( false !== $tmp1){
					$tmp1 ='1';
	        ?>
	    <tr>
	      <td height="30" align="right" class="board_add4" style="width: 110px;">國民身分證正面：</td>
	      <td align="left" class="board_add4">
	        <div id="optionDiv2-1" style="display:inline-block;">
	         <span id="sprytextfield14">
	           <input type="file" name="news_pic1" id="news_pic1" />
	         </span><br/>
	        </div>
	      </td>
	       <td height="30" align="right" class="board_add4"></td>
	    </tr>
	  <?php }
		$tmp2=strpos($row_web_examinee['allow'], '2');
	     if( false !== $tmp2){
				 $tmp2 ='1';
	    ?>
	    <tr>
	      <td height="30" align="right" class="board_add4">國民身分證反面：</td>
	      <td align="left" class="board_add4">
	        <div id="optionDiv2-1" style="display:inline-block;">
	         <span id="sprytextfield14">
	           <input type="file" name="news_pic2" id="news_pic2" />
	         </span><br/>
	        </div>
	      </td>
	       <td height="30" align="right" class="board_add4"></td>
	    </tr>
	  <?php }
	    $tmp3=strpos($row_web_examinee['allow'], '3');
	    if( false !== $tmp3){
				$tmp3 ='1';
	    ?>
	    <tr>
	      <td height="30" align="right" class="board_add4">最高學歷學位證書：</td>
	      <td align="left" class="board_add4">
	        <div id="optionDiv2-1" style="display:inline-block;">
	         <span id="sprytextfield14">
	           <input type="file" name="news_pic3" id="news_pic3" />
	         </span><br/>
	        </div>
	      </td>
	       <td height="30" align="right" class="board_add4"></td>
	    </tr>
	  <?php }
	    $tmp4=strpos($row_web_examinee['allow'], '4');
	    if( false !== $tmp4){
				$tmp4 ='1';
	    ?>
	    <tr>
	      <td height="30" align="right" class="board_add4">國民小學教師證書：</td>
	      <td align="left" class="board_add4">
	        <div id="optionDiv2-1" style="display:inline-block;">
	         <span id="sprytextfield14">
	           <input type="file" name="news_pic4" id="news_pic4" />
	         </span><br/>
	        </div>
	      </td>
	       <td height="30" align="right" class="board_add4"></td>
	    </tr>
	  <?php }
	    $tmp5=strpos($row_web_examinee['allow'], '5');
	    if( false !== $tmp5){
				$tmp5 ='1';
	    ?>
	    <tr>
	      <td height="30" align="right" class="board_add4">在職證明書：</td>
	      <td align="left" class="board_add4">
	        <div id="optionDiv2-1" style="display:inline-block;">
	         <span id="sprytextfield14">
	           <input type="file" name="news_pic5" id="news_pic5" />
	         </span><br/>
	        </div></td>
	       <td height="30" align="right" class="board_add4"></td>
	    </tr>
	  <?php }
		$tmp7=strpos($row_web_examinee['allow'], '7');
		if( false !== $tmp7){
			$tmp7 ='1';
		?>
		<tr>
			<td height="30" align="right" class="board_add4">戶籍謄本：</td>
			<td align="left" class="board_add4">
				<div id="optionDiv2-1" style="display:inline-block;">
				 <span id="sprytextfield14">
					 <input type="file" name="rename_pic" id="rename_pic" />
				 </span><br/>
				</div></td>
			 <td height="30" align="right" class="board_add4"></td>
		</tr>
	<?php }
		}
	  }
	  ?>
	</table>
	      <?php

	        if((($tmp7==1) || ( $tmp6==1) || ( $tmp5==1 ) || ( $tmp4==1 ) || ( $tmp3==1 ) || ( $tmp2 ==1 ) || ( $tmp1 ==1))
					&& (strtotime(date('Y-m-d')) <= strtotime($end_date))){ ?>
	      <div align="center">
	      <input  type="submit" name="button" id="button" value="確認上傳檔案" />
	    </div>
	  <?php }

}?>
  </div>
  <div id="main4"></div>
<?php include("footer.php"); ?>
</div>
</body>
</html>
<?php
mysql_free_result($web_banner1);
mysql_free_result($web_banner2);

?>
