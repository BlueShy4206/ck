<?php  
if ($_SERVER[ 'REQUEST_METHOD' ] ==  'POST' )  
{  
 $targ_w =  160 ;
 $targ_h =  200;
 $jpeg_quality =  90 ;  
 $src =  '../images/examinee/'.$_POST['filename'] ;
 
 $ext = pathinfo($_POST['filename'], PATHINFO_EXTENSION);
 if($ext=="jpg"){  
     $img_r = imagecreatefromjpeg($src);}
 elseif($ext=="png"){
	 $img_r = imagecreatefrompng($src); 
$bgcolor = ImageColorAllocate($img_r,0,0,0); 
$bgcolor = ImageColorTransparent($img_r,$bgcolor) ; 
	 
	 //$img_r = imagecreatefrompng($src);
	 }
 elseif($ext=="gif"){
	 $img_r = imagecreatefromgif($src);}
   
 $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );  
 imagecopyresampled($dst_r,$img_r, 0 , 0 ,$_POST[ 'x' ],$_POST[ 'y' ],  
 $targ_w,$targ_h,$_POST[ 'w' ],$_POST[ 'h' ]);  
 header( 'Content-type: image/jpeg' );  
 imagejpeg($dst_r,null,$jpeg_quality);
 imagejpeg($dst_r, "../images/examinee/".$_POST['filename']);   header('Location: admin_exammember.php');
 exit;  
}  
?>  