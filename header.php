<?php
//http轉為https
if ($_SERVER["HTTPS"]<>"on")
{
// $xredir='https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
// header("Location:".$xredir);
}
?>
<body ><div id="header">
<?php //echo "group=".$_SESSION["MM_UserGroup"]."<br>"?>
  <table width="770" border="0" cellspacing="0" cellpadding="0">
    
      <td width="770" rowspan="2"><a href="index.php"><img src="images/header_1.png" width="770" height="124" border="0" usemap="#Map" /></a></td>
         
    <tr>
     </table>
     <table width="770" border="0" cellspacing="0" cellpadding="0" align="center"  >
      <td height="41" align="center" background="images/blue.png" ><a href="index.php" onMouseOut="" onMouseOver=""><img src="images/index_button1.png" name="Image5" width="77" height="41" border="0" id="Image5" /></a><a href="abortck.php" onMouseOut="" onMouseOver=""><img src="images/aboutCK_button1.png" name="Image6" width="77" height="41" border="0" id="Image6" /></a><a href="download.php" onMouseOut="" onMouseOver=""><img src="images/download_button1.png" name="Image7" width="77" height="41" border="0" id="Image7" /></a><a href="Q_A.php" onMouseOut="" onMouseOver=""><img src="images/Q&A_button1.png" name="Image9" width="77" height="41" border="0" id="Image9" /></a><a href="mailto.php" onMouseOut="" onMouseOver=""><img src="images/mailTo1.png" name="Image11" width="77" height="41" border="0" id="Image11" /></a><a href="schoolQry.php" onMouseOut="" onMouseOver=""><img src="images/schoolQry.png" name="Image12" width="100" height="39" border="0" id="Image12" /></a>

      </td>
    </tr>
  </table>
</div>
<?php
//<map name="Map" id="Map">
//  <area shape="rect" coords="700,1,768,26" //href="mailto:ckassessment@gmail.com" />
//</map>
?>