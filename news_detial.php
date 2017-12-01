<?php require_once('Connections/conn_web.php'); ?>
<?php
$colname_web_news = "-1";
if (isset($_GET['news_id'])) {
  $colname_web_news = $_GET['news_id'];
}

$search_web_news = $dbh->prepare("SELECT * FROM news WHERE news_id = :news_id");
$search_web_news->bindValue(':news_id', $colname_web_news, PDO::PARAM_STR);
$search_web_news->execute();
$row_web_news = $search_web_news->fetch();

/*mysql_select_db($database_conn_web, $conn_web);
$query_web_news = sprintf("SELECT * FROM news WHERE news_id = %s", GetSQLValueString($colname_web_news, "int"));
$web_news = mysql_query($query_web_news, $conn_web) or die(mysql_error());
$row_web_news = mysql_fetch_assoc($web_news);
$totalRows_web_news = mysql_num_rows($web_news);*/

$colname_web_newspic = "-1";
if (isset($_GET['news_id'])) {
  $colname_web_newspic = $_GET['news_id'];
}

$search_web_newspic = $dbh->prepare("SELECT * FROM newspic WHERE news_id = :news_id ORDER BY newspic_id ASC");
$search_web_newspic->bindValue(':news_id', $colname_web_newspic, PDO::PARAM_STR);
$search_web_newspic->execute();
$row_web_newspic = $search_web_newspic->fetchAll();
$totalRows_web_newspic = $search_web_newspic->rowCount();

/*
mysql_select_db($database_conn_web, $conn_web);
$query_web_newspic = sprintf("SELECT * FROM newspic WHERE news_id = %s ORDER BY newspic_id ASC", GetSQLValueString($colname_web_newspic, "int"));
$web_newspic = mysql_query($query_web_newspic, $conn_web) or die(mysql_error());
$row_web_newspic = mysql_fetch_assoc($web_newspic);
$totalRows_web_newspic = mysql_num_rows($web_newspic);*/

/* 依據URL參數傳送的news_id更新news_count新聞瀏覽次數欄位計數*/
$news_id=$_GET["news_id"];  //變數$news_id儲存URL參數傳遞過來的news_id編號
$updateSQL = $dbh->prepare("UPDATE news SET news_count=news_count+1 WHERE news_id= :news_id");
$updateSQL->bindValue(':news_id', $colname_web_newspic, PDO::PARAM_STR);
$updateSQL->execute();
/*$updateSQL = sprintf("UPDATE news SET news_count=news_count+1 WHERE news_id='$news_id'");//更新資料的SQL字串
$Result = mysql_query($updateSQL, $conn_web) or die(mysql_error());//執行上述資料更新*/
?>
<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NEWS</title>
<meta http-equiv="Content-Language" content="zh-tw" />
<meta name="description" content="NEWS" />
<meta name="keywords" content="NEWS" />
<meta name="author" content="Web Design" />
<link href="web.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript" src="js/slimbox2.js"></script>
<link rel="stylesheet" href="css/slimbox2.css" type="text/css" media="screen" />
</head>

<body background="images/background.jpg">
<div id="wrapper">
<?php include("header.php"); ?>
<div id="main">
  <div id="main1"></div>
  <div id="main2">
      <?
      	if ($row_web_news['news_type']!="news"){
      		include("leftzone.php");
      	}?>
  </div>
  <div id="news1"><img src="images/adv2.gif" width="505" height="31" /><img src="images/adv4.gif" width="40" height="31" border="0" /><br />
    <div id="news_detial1">
      <table width="545" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed">
         <tr>
           <td width="35" height="28" align="left" valign="middle" class="font_newstitle1">
             <?php /*START_PHP_SIRFCIT*/ if ($row_web_news['news_type']=="news"){ ?>
               <img src="images/icon_news.gif" />
               <?php } /*END_PHP_SIRFCIT*/ ?>
             <?php /*START_PHP_SIRFCIT*/ if ($row_web_news['news_type']=="action"){ ?>
               <img src="images/icon_action.gif" />
               <?php } /*END_PHP_SIRFCIT*/ ?></td>
           <td width="410" align="left" valign="middle" class="font_newstitle1" style="word-break:break-all;overflow:hidden;"><?php echo $row_web_news['news_title']; ?></td>
           <td width="90" align="right" class="font_newstitle1"><?php echo $row_web_news['news_date']; ?></td>
         </tr>
         <tr>
           <td height="25" colspan="3" align="right" valign="top"><table width="545" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td width="395" height="25" align="right" valign="middle">瀏覽次數：<?php echo $row_web_news['news_count']; ?></td>
               <td width="150" align="right" valign="middle">
               <!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style">
<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4bffd1e52481cf03" class="addthis_button_compact">Share</a>
<span class="addthis_separator">|</span>
<a class="addthis_button_facebook"></a>
<a class="addthis_button_myspace"></a>
<a class="addthis_button_google"></a>
<a class="addthis_button_twitter"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4bffd1e52481cf03"></script>
<!-- AddThis Button END -->

               </td>
             </tr>
           </table></td>
        </tr>
         <tr>
           <td colspan="3" align="left" valign="top"><p>
             <?php /*START_PHP_SIRFCIT*/ if ($row_web_news['news_pic']!=""){ ?>
               <a href="timthumb.php?src=images/news/<?php echo $row_web_news['news_pic']; ?>&w=500&zc=0" target="_blank" rel="lightbox"><img src="timthumb.php?src=images/news/<?php echo $row_web_news['news_pic']; ?>&w=150&zc=0" alt="" name="pic" width="150" hspace="10" vspace="10" border="0" align="right" id="pic" /></a>
               <?php } /*END_PHP_SIRFCIT*/ ?>
             <?php echo $row_web_news['news_content']; ?></p>
           <p>&nbsp;</p>
           <?php /*START_PHP_SIRFCIT*/ if ($row_web_news['news_download']!=""){ ?>
             <table width="300" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td><img src="images/adminarrow.gif" alt="" width="10" height="10" /> 下載檔案：<a href="images/news/<?php echo $row_web_news['news_download']; ?>"><?php echo $row_web_news['news_download_title']; ?></a></td>
               </tr>
             </table>
             <?php } /*END_PHP_SIRFCIT*/ ?>
<p><?php echo $row_web_news['news_movie']; ?></p>
           <p>
             <?php if ($totalRows_web_newspic > 0) { // Show if recordset not empty ?>
<table width="545" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3"><img src="images/news01.gif" width="545" height="37" /></td>
    </tr>
  <tr>
    <td width="9" background="images/news02.gif">&nbsp;</td>
    <td width="527" align="center"><table >
      <tr>
        <?php
$web_newspic_endRow = 0;
$web_newspic_columns = 5; // number of columns
$web_newspic_hloopRow1 = 0; // first row flag
do {
    if($web_newspic_endRow == 0  && $web_newspic_hloopRow1++ != 0) echo "<tr>";
   ?>
        <td><table width="96" border="0" cellspacing="1" cellpadding="8" bgcolor="#cdcdcd">
          <tr>
            <td align="center" valign="middle" bgcolor="#FFFFFF"><a href="timthumb.php?src=images/news/<?php echo $row_web_newspic['newspic_pic']; ?>&w=500&zc=0" target="_blank" rel="lightbox-cats" title="<?php echo $row_web_newspic['newspic_title']; ?>"><img src="timthumb.php?src=images/news/<?php echo $row_web_newspic['newspic_pic']; ?>&w=80&zc=0" alt="" name="pic2" width="80" border="0" id="pic2" /></a></td>
            </tr>
          </table></td>
        <?php  $web_newspic_endRow++;
if($web_newspic_endRow >= $web_newspic_columns) {
  ?>
        </tr>
      <?php
 $web_newspic_endRow = 0;
  }
//} while ($row_web_newspic = mysql_fetch_assoc($web_newspic));
} while ($row_web_newspic = $search_web_newspic->fetch());

if($web_newspic_endRow != 0) {
while ($web_newspic_endRow < $web_newspic_columns) {
    echo("<td>&nbsp;</td>");
    $web_newspic_endRow++;
}
echo("</tr>");
}?>
      </table></td>
    <td width="9" background="images/news03.gif">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3"><img src="images/news04.gif" width="545" height="15" /></td>
    </tr>
</table>
<?php } ?>
</p>
           <div align="center">
<input type="button" name="submit" value="回上一頁" onClick="window.history.back()";>
<input type="button" name="Submit" value="回首頁" onclick="window.location='index.php'">
</div>
           </td>
         </tr>
      </table>
    </div>
  </div>
  <div id="main4"></div>
  <?php include("footer.php"); ?>
</div>
</div>
</body>
</html>
<?php
//mysql_free_result($web_news);

//mysql_free_result($web_newspic);
?>
