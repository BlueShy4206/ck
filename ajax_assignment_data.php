<?php require_once('Connections/conn_web.php');
require_once "PEAR183/HTML/QuickForm.php";

// echo '123123';
if ($_POST["type"] == '1') {
	// echo '123123';
	// echo '$_POST["stage"]';

	$k = 0;

    $get_examyear_sql="SELECT * FROM `examyear` WHERE STATUS = :level ORDER BY id desc LIMIT 1";
    $get_examyear = $dbh->prepare($get_examyear_sql);
    $get_examyear->bindValue(':level',$_POST["level"], PDO::PARAM_STR);
	$get_examyear->execute();
	$get_examyear_data = $get_examyear->fetch();
	// $get_examyear_count = $check_group->rowCount();


    $get_examuser_sql="SELECT * FROM examinee,check_review where examinee.examyear_id = :id and examinee.no = check_review.examinee_sn and examinee.username = check_review.user_name";
    $get_examuser = $dbh->prepare($get_examuser_sql);
    $get_examuser->bindValue(':id',$get_examyear_data["id"], PDO::PARAM_INT);
	$get_examuser->execute();
	$get_examuser_data = $get_examuser->fetchAll();
	$get_examuser_count = $get_examuser->rowCount();
    $upload_nm = 0;
    if($_POST["stage"]=='1'){//初審
        foreach ( $get_examuser_data as $key => $value) {
            if($value["first_trial"] != "" && $value["final_trial"] == ""){
                if($value["first_trial"] == "OK"){
                    $symbol='Y';
                }elseif($value["upload_file"] != ""){
                    $symbol = $value["upload_file"];
                }elseif($value["first_trial"] == "NO"){
                    $symbol='X';
                }else{
                    $symbol='0';
                }
                if($value["review_message"]==""){
                    $value["review_message"]=null;
                }
                $upload_examuser_sql="UPDATE `examinee` SET  examinee.allow = :symbol,  examinee.allow_note = :allow_note  where examinee.no = :examinee_sn ";
                $upload_examuser = $dbh->prepare($upload_examuser_sql);
                $upload_examuser->bindValue(':symbol',$symbol, PDO::PARAM_STR);
                $upload_examuser->bindValue(':allow_note',$value["review_message"], PDO::PARAM_STR);
                $upload_examuser->bindValue(':examinee_sn',$value["examinee_sn"], PDO::PARAM_STR);
            	$upload_examuser->execute();
            	$upload_examuser_data = $upload_examuser->fetchAll();
                $upload_examuser_count = $upload_examuser->rowCount();
                if($upload_examuser_count > 0 ){
                    $upload_nm++;
                }
            }
        }
    }


    if($_POST["stage"]=='2'){
        foreach ( $get_examuser_data as $key => $value) {
            if($value["first_trial"] != "" && $value["final_trial"] != ""){
                if($value["final_trial"] == "OK"){
                    $symbol='YY';
                    $value["review_message"]='審核通過';
                }else if($value["final_trial"] == "NO"){
                    $symbol='N';
                }else{
                    $symbol='0';
                }

                $upload_examuser_sql="UPDATE `examinee` SET  examinee.allow = :symbol,  examinee.allow_note = :allow_note  where examinee.no = :examinee_sn ";
                $upload_examuser = $dbh->prepare($upload_examuser_sql);
                $upload_examuser->bindValue(':symbol',$symbol, PDO::PARAM_STR);
                $upload_examuser->bindValue(':allow_note',$value["review_message"], PDO::PARAM_STR);
                $upload_examuser->bindValue(':examinee_sn',$value["examinee_sn"], PDO::PARAM_STR);
            	$upload_examuser->execute();
            	$upload_examuser_data = $upload_examuser->fetchAll();
                $upload_examuser_count = $upload_examuser->rowCount();
                if($upload_examuser_count > 0 ){
                    $upload_nm++;
                }
            }
        }
    }
	echo $upload_nm;
}

//examAdd.php
if ($_POST["type"] == '2') {
	// return 'EA2';
	if($_POST["status"]=='0'){
		$up_no = 'EA2';
		//人數上限
		$Maximum_examuser_sql="SELECT data3 FROM `allguide` WHERE up_no =:up_no and nm=:nm AND data2 =:data2";
		$Maximum_examuser = $dbh->prepare($Maximum_examuser_sql);
		$Maximum_examuser->bindValue(':up_no',$up_no, PDO::PARAM_STR);
		$Maximum_examuser->bindValue(':nm',$_POST["area"], PDO::PARAM_STR);//東西南北
		$Maximum_examuser->bindValue(':data2',$_POST["data2"], PDO::PARAM_STR);//area_note
		$Maximum_examuser->execute();
		$Maximum_examuser_data = $Maximum_examuser->fetch();
		$Maximum_num = $Maximum_examuser_data[data3];


		$Nownum_examuser_sql="SELECT * FROM `examinee` WHERE exarea = :exarea AND exarea_note = :exarea_note AND examyear_id = (SELECT id FROM `examyear` where status =:status ORDER BY `id` DESC LIMIT 1)";
		$Nownum_examuser = $dbh->prepare($Nownum_examuser_sql);
		$Nownum_examuser->bindValue(':exarea',$_POST["area"], PDO::PARAM_STR);
		$Nownum_examuser->bindValue(':exarea_note',$_POST["data2"], PDO::PARAM_STR);
		$Nownum_examuser->bindValue(':status',$_POST["status"], PDO::PARAM_STR);
		$Nownum_examuser->execute();
		$Nownum_examuser_data = $Nownum_examuser->fetchAll();
		$Nownum= $Nownum_examuser->rowCount();
		// echo $Maximum_examuser_data;

		// return $return;
	}
	if($_POST["status"]=='1') {
		$up_no = 'EA';
		$Maximum_examuser_sql="SELECT data3 FROM `allguide` WHERE up_no =:up_no and nm=:nm ";
		$Maximum_examuser = $dbh->prepare($Maximum_examuser_sql);
		$Maximum_examuser->bindValue(':up_no',$up_no, PDO::PARAM_STR);
		$Maximum_examuser->bindValue(':nm',$_POST["area"], PDO::PARAM_STR);
		$Maximum_examuser->execute();
		$Maximum_examuser_data = $Maximum_examuser->fetch();
		$Maximum_num = $Maximum_examuser_data[data3];


		$Nownum_examuser_sql="SELECT * FROM `examinee` WHERE exarea = :exarea  AND examyear_id = (SELECT id FROM `examyear` where status =:status ORDER BY `id` DESC LIMIT 1)";
		$Nownum_examuser = $dbh->prepare($Nownum_examuser_sql);
		$Nownum_examuser->bindValue(':exarea',$_POST["area"], PDO::PARAM_STR);
		$Nownum_examuser->bindValue(':status',$_POST["status"], PDO::PARAM_STR);
		$Nownum_examuser->execute();
		$Nownum_examuser_data = $Nownum_examuser->fetchAll();
		$Nownum= $Nownum_examuser->rowCount();
	}

	$return=[$Maximum_num,$Nownum];
	echo  json_encode($return);
}


if ($_POST["type"] == '3') {
	if($_POST["status"]=='1'){ $up_no = 'EA'; }
	if($_POST["status"]=='0'){ $up_no = 'EA2'; }
	$get_allguide_sql="SELECT * FROM `allguide` where up_no =:up_no ORDER BY `allguide`.`id` ASC";
	$get_allguide = $dbh->prepare($get_allguide_sql);
	$get_allguide->bindValue(':up_no',$up_no, PDO::PARAM_STR);
	$get_allguide->execute();
	$allguide = $get_allguide->fetchAll();

	foreach ($allguide as $key => $value) {
		if($_POST["status"]=='0'){
	// 		//目前報名人數
			$Nownum_examuser_sql="SELECT * FROM `examinee` WHERE exarea = :exarea AND exarea_note = :exarea_note AND examyear_id = (SELECT id FROM `examyear` where status =:status ORDER BY `id` DESC LIMIT 1)";
			$Nownum_examuser = $dbh->prepare($Nownum_examuser_sql);
			$Nownum_examuser->bindValue(':exarea',$value["nm"], PDO::PARAM_STR);
			$Nownum_examuser->bindValue(':exarea_note',$value["data2"], PDO::PARAM_STR);
			$Nownum_examuser->bindValue(':status',$_POST["status"], PDO::PARAM_STR);
			$Nownum_examuser->execute();
			$Nownum_examuser_data = $Nownum_examuser->fetchAll();
			$Nownum= $Nownum_examuser->rowCount();
	// 		$return['']
		}

		if($_POST["status"]=='1') {
			$Nownum_examuser_sql="SELECT * FROM `examinee` WHERE exarea = :exarea  AND examyear_id = (SELECT id FROM `examyear` where status =:status ORDER BY `id` DESC LIMIT 1)";
			$Nownum_examuser = $dbh->prepare($Nownum_examuser_sql);
			$Nownum_examuser->bindValue(':exarea',$value["nm"], PDO::PARAM_STR);
			$Nownum_examuser->bindValue(':status',$_POST["status"], PDO::PARAM_STR);
			$Nownum_examuser->execute();
			$Nownum_examuser_data = $Nownum_examuser->fetchAll();
			$Nownum = $Nownum_examuser->rowCount();
		}
		$return_data[$value["id"]]['note'] = substr($value["note"],7,-1);
		$return_data[$value["id"]]['date'] = $value["data1"];
		$return_data[$value["id"]]['Maximum_num'] = $value["data3"];
		$return_data[$value["id"]]['Nownum'] = $Nownum;
	}
echo json_encode($return_data);
}

 ?>
