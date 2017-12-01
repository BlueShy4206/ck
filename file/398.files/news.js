function newspicchange(o){
	if(newspicnum>1){
		pgcontent = '';
		$("#newsad").hide();
		$("#newsphoto li").hide();
		//$("#newsphoto a").hide();
		//$("#newspic p").hide();
		$("#newsphoto li:eq("+(o-1)+")").show();
		//$("#newsphoto a:eq("+(o-1)+")").show();
		//$("#newspic p:eq("+(o-1)+")").show();
		for(i=1;i<=newspicnum;i++){
			if(i == o)
				pgcontent += '<strong>'+o+'</strong>';
			else
				pgcontent += '<a href="javascript:newspicchange('+i+');">'+i+'</a>';
		} 
		$("#newspicpg").html(pgcontent);
	}
	else if(newspicnum==1){
		$("#newsad").hide();
		$("#newspicpg").hide();
	}
	else{
		$("#newspicpg").hide();
	}
}
function wordsize(){
  if($("#fnots1 img").attr('src') == '/images/news/wb.gif'){
    $("#fnots1 img").attr('src','/images/news/ws.gif');
    $("#fnots2 img").attr('src','/images/news/ws.gif');
    $("#newstext p").attr('class','wordsize');
    $("#newstext H4").attr('class','wordsize');
  }else{
    $("#fnots1 img").attr('src','/images/news/wb.gif');
    $("#fnots2 img").attr('src','/images/news/wb.gif');
    $("#newstext p").removeAttr('class');
    $("#newstext H4").removeAttr('class');
  }
}
//轉寄
function forward(){
	$("#fcode").attr('src','/images/news/code.php?'+new Date().getTime());
	$(".forwardTo").show();
}
function forwardClose(){
	$(".forwardTo").hide();
	mailreset();
}
function check(btn)
{
	var TEmail=$("input[name='mailto']").val();
	var FEmail=$("input[name='mailfrom']").val();
		if (TEmail == "")
		{
			alert("請填收件人Email");
			$("input[name='mailto']").focus();
			return false;
		}
		else if (FEmail == "")
		{
			alert("請填您的Email");
			$("input[name='mailfrom']").focus();
			return false;
		}
		else
		{
			btn.disabled = true;
			newspnum = $('.text p').length;
			if(newspnum>3)
				newscontent = $('.text > p:eq(0)').html()+" "+$('.text > p:eq(1)').html();
			else
				newscontent = $('.text p:eq(0)').html();
			$.post("http://"+newsServer+"/Forward", {uri:uri,title:$('title').html(),content:newscontent,mailto:$("input[name='mailto']").val(),mailfrom:$("input[name='mailfrom']").val(),message:$("textarea[name='message']").val(),yname:$("input[name='yname']").val(),code:$("input[name='code']").val(),date:$('.text span:eq(0)').html()}, function(data){
			if(data=='ok'){alert('轉寄完成!');forwardClose();}
			else if(data='MailerError') alert('寄件錯誤，請稍後試!');
			else if(data='error') alert('資料錯誤!');
			btn.disabled = false;
			});
		}
}
function mailreset(){
	$("input[name='mailto']").val('');
	$("input[name='mailfrom']").val('');
	$("textarea[name='message']").val('');
	$("input[name='yname']").val('');
	$("input[name='code']").val('');
}

//ready

(function() {
	var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	po.src = 'https://apis.google.com/js/plusone.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
$(function (){
	$('.interFB').each(function(){$(this).prev().append($(this));});
});
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

window.fbAsyncInit = function() {
	FB.init({appId:'140490219413038', status:true, cookie:true, xfbml:true, channelUrl:'http://'+newsServer+'.ltn.com.tw/fbChannel'});
	FB.Event.subscribe('edge.create', function(res) {
		$.get('/fbBack',{no:newsNo,url:res,type:newsType,time:newsTime});
	});
};
function imgErr(obj){
	obj.onerror = function(){};
	obj.style.display="none";
	obj.onload = function(){imgLoad(obj);};
	var imgsrc = obj.src;
	$.post("http://"+newsServer+"/PhotoGet", { nclass:newsClass, src:imgsrc }, function(data){var tnow = new Date();obj.src=data+'?'+tnow.getTime();} );
	//if(data == imgsrc){}
}
function imgLoad(obj){
	obj.style.display="";
}