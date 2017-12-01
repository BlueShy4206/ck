<div id="admin_main3_1"></div>
    <div id="admin_main3_2">
    <span id="admin_link1">
    <ul>
    <?PHP 
	if($_SESSION["MM_UserGroup"]=='admin'){
	//<li><a href="admin_board.php">留言板管理區</a></li> ?>
      <li><a href="admin_news.php">新聞/活動管理區</a></li>
      <li><a href="admin_file.php">檔案管理區</a></li>
      <li><a href="admin_banner.php">公告管理區</a></li>
      <li><a href="admin_exyear.php">報名開放管理區</a></li>
      <li><a href="admin_member.php">會員管理區</a></li>
     <?PHP //<li><a href="admin_epaper.php">電子報管理區</a></li> ?>
      
     <?PHP //<li><a href="admin_forum.php">討論區管理區</a></li> ?>
    <?PHP  //<li><a href="admin_shop1.php">商品管理區</a></li>?>
      <?PHP //<li><a href="admin_orders.php">訂單管理區</a></li>?>
       <li><a href="admin_exammember.php">考生考試管理區</a></li>
      <li><a href="admin_examineeout.php">匯出考生資料</a></li>
      <li><a href="admin_score.php">匯入考試成績</a></li>
      <li><a href="admin_allin.php">批次匯入資料</a></li>
      <li><a href="admin_viewCount.php">瀏覽人次資料</a></li>
      <li><a href="admin_allinforone.php">第一次批次匯入</a></li>
      <li><a href="admin_allinforoneexammember.php">第一次考生資料</a></li>
      <li><a href="../logout.php">離開管理區</a></li>
      <?PHP } ?>
    </ul>
    </span>
    </div>
<div id="admin_main3_3"></div>