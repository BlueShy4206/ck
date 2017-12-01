
<?php require_once('Connections/conn_web.php'); ?>
<?php
mysql_select_db($database_conn_web, $conn_web);
$query_web = "select pic_name from examinee where examyear_id=33 and allow='Y' and exarea in ('Northern','Southern') ";//and id in ('CD20160092','CD20160091')";
// 		'CD20160012',
// 'CD20160013',
// 'CD20160019',
// 'CD20160021',
// 'CD20160045',
// 'ED20160014',
// 'ND20160021',
// 'ND20160032',
// 'ND20160040',
// 'ND20160054',
// 'ND20160067',
// 'ND20160074',
// 'ND20160079',
// 'ND20160087',
// 'ND20160094',
// 'ND20160100',
// 'ND20160111',
// 'ND20160115',
// 'ND20160118',
// 'ND20160121',
// 'ND20160125',
// 'ND20160150',
// 'ND20160155',
// 'SD20160011',
// 'SD20160030',
// 'SD20160041'
// )";
// $query_web = "select pic_name from examinee where id like '%D2016%'";

// $query_web = "select pic_name from examinee where examyear_id=33 and id in('SD20160007',
// 		'ND20160039',
// 		'SD20160011',
// 		'ND20160066',
// 		'ND20160071',
// 		'ND20160076',
// 		'ND20160078',
// 		'CD20160046',
// 		'SD20160034',
// 		'ND20160090',
// 		'CD20160054',
// 		'CD20160059',
// 		'CD20160062',
// 		'ND20160125',
// 		'CD20160075',
// 		'ND20160144',
// 		'SD20160093',
// 		'CD20160094')";

// $query_web = "select pic_name from examinee where examyear_id=31 and id in('CC20160477'
// )";
		
$web_img = mysql_query($query_web, $conn_web) or die(mysql_error());


while ($row = mysql_fetch_assoc($web_img)){
	
	$path="images/examinee/$row[pic_name]";
	if (file_exists($path)) {
		echo "exists: $path <br>";
		$type = exif_imagetype($path);
		//echo $type;
		// 取得上傳圖片
		switch ($type) {
			case 1 :
				$src2 = imageCreateFromGif($path);
				break;
			case 2 :
				$src2 = imageCreateFromJpeg($path);
				break;
			case 3 :
				$src2 = imageCreateFromPng($path);
				break;
			case 6 :
				$src2 = imageCreateFromBmp($path);
				break;
		}
		//$src2 = imagecreatefromjpeg($path);
		
		// 取得來源圖片長寬
		$src_w2 = imagesx($src2);
		$src_h2 = imagesy($src2);
		
		// 假設要長寬不超過90
		if($src_w2 > 100){
			$thumb_w2 = intval($src_h2 / $src_w2 * 100);
			$thumb_h2 = intval($src_h2 / $src_w2 * 130);
		}else{
			$thumb_h2 = intval($src_w2 / $src_h2 * 130);
			$thumb_w2 = intval($src_w2 / $src_h2 * 100);
		}
		
		// 建立縮圖
		$thumb2 = imagecreatetruecolor($thumb_w2, $thumb_h2);
		
		// 開始縮圖
		imagecopyresampled($thumb2, $src2, 0, 0, 0, 0, $thumb_w2, $thumb_h2, $src_w2, $src_h2);
		
		// 儲存縮圖到指定 images/examinee/ 目錄
		
		//$resultOK= imagejpeg($thumb2, "images/smallPic/".$_FILES['news_pic']['name']);
		switch ($type){
			case 2:
				$resultOK= imagejpeg($thumb2, "images/smallPic/".$row[pic_name]);
				echo "src...:$src_w2,$src_h2, $resultOK <br>";
				break;
			case 3:
				$resultOK= imagepng($thumb2, "images/smallPic/".$row[pic_name]);
				break;
			case 1:
				$resultOK= imagegif($thumb2, "images/smallPic/".$row[pic_name]);
				break;
		}
		
		if($resultOK){
			echo "image to jpeg success.<br>";
		}
	}else echo "no such file: $path <br>";
	
	
}

