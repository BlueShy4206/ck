var res_width = screen.width;
if( res_width < 1025 ){
	document.write('<img src="https://tw.buy.yahoo.com/bestbuy/?anchor=7&amp;act=todaybest7_main_01&co_servername=gp5cf167f2ebee7bd4c0547de27c5982" border="0" width="0" height="0"></img>');
}else{
	newtop=screen.height - 700;
	newleft=screen.width - 680;
	strFeatures ="top=" + newtop + ",left="+newleft+",width=680,height=590,toolbar=1,menubar=1,location=1,directories=1,status=1,scrollbars=yes,resizable=yes,alwaysLowered=1";
 
        window.open("http://buy.youthwant.com.tw/t/tk_gotobuy?url=http%3A%2F%2Figuang.tw%2Factivity.php" , "MyNew", strFeatures);
 
}

