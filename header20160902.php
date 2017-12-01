<?php
//http轉為https
if ($_SERVER["HTTPS"]<>"on")
{
$xredir='https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
header("Location:".$xredir);
}
?>

<body ><div id="header">
  <table width="770" border="0" cellspacing="0" cellpadding="0">
    
      <td width="770" rowspan="2"><a href="index.php"><img src="images/header_1.png" width="770" height="124" border="0" usemap="#Map" /></a></td>
         
    <tr>
     </table>
     <table width="770" border="0" cellspacing="0" cellpadding="0" align="center"  >
      <td height="41" align="center" background="images/blue.png" ><a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','images/index_button2.png',1)"><img src="images/index_button1.png" name="Image5" width="77" height="41" border="0" id="Image5" /></a><a href="abortck.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','images/aboutCK_button2.png',1)"><img src="images/aboutCK_button1.png" name="Image6" width="84" height="41" border="0" id="Image6" /></a><a href="download.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image7','','images/download_button2.png',1)"><img src="images/download_button1.png" name="Image7" width="84" height="41" border="0" id="Image7" /></a><a href="Q_A.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image9','','images/Q&A_button2.png',1)"><img src="images/Q&A_button1.png" name="Image9" width="84" height="41" border="0" id="Image9" /></a><a href="mailto.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','images/mailTo2.png',1)"><img src="images/mailTo1.png" name="Image5" width="77" height="41" border="0" id="Image5" /></a>

      </td>
    </tr>
  </table>
</div>
<?php
//<map name="Map" id="Map">
//  <area shape="rect" coords="700,1,768,26" //href="mailto:ckassessment@gmail.com" />
//</map>
?>