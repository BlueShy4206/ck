<div id="admin_main3_1"></div>
    <div id="admin_main3_2">
    <span id="admin_link1">
    <ul>
    <?PHP 
	if($_SESSION["MM_UserGroup"]=='admin'){
	
	echo "--公告類--";
	//凱迪 版本 PS 不知 只否功能
	//<li><a href="admin_board.php">留言板管理區</a></li> 
	//凱迪 版本 END 
	?>
		
      <li><a href="admin_news.php">新聞/活動管理區</a></li>
      <li><a href="admin_file.php">檔案管理區</a></li>
      <li><a href="admin_banner.php">公告管理區</a></li>
      <li><a href="admin_exyear.php">報名開放管理區</a></li>
      <li><a href="admin_member.php">會員管理區</a></li>
	  <!--凱迪 版本 PS 不知 只否功能-->
      <?PHP //<li><a href="admin_epaper.php">電子報管理區</a></li> ?>
      
      <?PHP //<li><a href="admin_forum.php">討論區管理區</a></li> ?>
      <?PHP  //<li><a href="admin_shop1.php">商品管理區</a></li>?>
      <?PHP //<li><a href="admin_orders.php">訂單管理區</a></li>?>
	   <!--凱迪 版本 END -->
       <li><a href="admin_exammember.php">考生考試管理區</a></li>
       <?php echo "--寄送郵件--"; //add by coway 2016.10.12?>
	   <li><a href="modifyMailList.php">補正資料通知</a></li>
	   <?php echo "--匯出匯入--"; ?>
	   <li><a href="admin_examine_data.php">匯出審查資料(國小教師)</a></li>
	   <li><a href="admin_examine_data_ts.php">匯出審查資料(師資生)</a></li>
	   <li><a href="admin_examine_data_complete.php">匯入審查結果(國小教師)</a></li>
	   <li><a href="admin_examine_data_complete_ts.php">匯入審查結果(師資生)</a></li>
	   <li><a href="admin_examineeout.php">匯出考場資料</a></li>
	   <!-- 匯出 應考名冊 PS 本來說 需要 匯出 應考名冊 給現場人員 查核 但後面取消 要手動 產生 -->
	   <!--<li><a href="admin_examine_data_Y.php">匯出應考名冊</a></li>-->
	   <!--  匯出 應考名冊 END -->
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