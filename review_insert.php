
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
                $status=1;
                mysql_select_db($database_conn_web, $conn_web);
                $get_examyear_id_sql = sprintf("SELECT id FROM `examyear` where status = %s ORDER BY `id` DESC limit 1", GetSQLValueString($status, "text"));
                $get_examyear_id = mysql_query($get_examyear_id_sql, $conn_web) or die(mysql_error());
                $arr_examyear_id = mysql_fetch_assoc($get_examyear_id);
                $examyear_id = $arr_examyear_id[id];
                // echo $arr_examyear_id."======";
                $k=0;
                mysql_select_db($database_conn_web, $conn_web);
                $get_exam_uesr_sql = sprintf("SELECT * FROM `examinee` where examyear_id = %s ORDER BY `examinee`.`no` ASC", GetSQLValueString($examyear_id, "text"));
                $get_exam_uesr = mysql_query($get_exam_uesr_sql, $conn_web) or die(mysql_error());
                while($data = mysql_fetch_array($get_exam_uesr)){
                     $exam_uesr[$k] = $data;
                     $k++;

              }

              foreach($exam_uesr as $key => $value){
                  $insert_sql = sprintf("INSERT INTO `check_review`( `examinee_sn`, `user_name`) VALUES (%s,%s)", GetSQLValueString($value['no'], "text"), GetSQLValueString($value['username'], "text"));
                  $get_inesert = mysql_query($insert_sql, $conn_web) or die(mysql_error());
                  $inesert = mysql_fetch_assoc($get_inesert);
              }
