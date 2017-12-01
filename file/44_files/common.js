// JavaScript Document
$(document).ready(function() {
	//下拉選單					   
	$(".seltbxtp").styleSelect({styleClass: "seltBox",optionsWidth: 1,speed: 'fast'});
						   
	//動態頁籤
	
	$(".tabs").tabs(".major", {event:'click',tabs:'li'});
	
	//td與li間隔顏色
	$('.fmtb tr:nth-child(2n)').addClass('odd');
	$('.serplist li:nth-child(2n)').addClass('odd');

	//水平輪動
	$("#scroll").scrollable({item:"ul",circular: true,autopaly:true}).autoscroll({interval:5000});
	
	//垂直輪動
	$("#scroll3").scrollable({item:"ul",vertical:true,circular:true});
	
	//IE6 Hover效果
	$("#navigate .navs li,.newsinfo .listing li,.videolist li,.arowOpen").hover(
    function() { $(this).addClass("iehover");},function() { $(this).removeClass("iehover");});	
						   
						   
});