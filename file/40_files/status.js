var get_18_block_html = function (){
	return '<div class="sexmask"></div><div class="sex"><div class="sexicon">限制級</div><div class="sexword"><h6>您即將進入之新聞內容<span> 需滿18歲 </span>方可瀏覽。</h6></div><div class="sexbox"><a href="javascript: void(0)" id="18noBtn"><div class="sexno">未滿18歲<br>或不同意本條款<span><img src="images/news/sexno.png" width="30">離開</span></div></a><a href="javascript: void(0)" id="18yesBtn"><div class="sexyes">我同意<br>我已年滿18歲<span><img src="images/news/sexyes.png" width="30">進入</span></div></a></div><div class="sexword">根據「電腦網路內容分級處理辦法」修正條文第六條第三款規定，已於網站首頁或各該限制級網頁，依台灣網站分級推廣基金會規>    定作標示。 台灣網站分級推廣基金會（TICRF）網站：http://www.ticrf.org.tw</div></div>'
}

var re_size_window = function(){
    sex_height = $('.sex').height();
    $('body, #main').css('height', sex_height);
}

var ben_18_show = function(){
    re_size_window();
    $(window).resize(re_size_window);
    $('.sexmask').show();
    $('body, #main').css('background', 'rgba(0,0,0,0.9)');
    $('.sex').show();
	
	var allHeight = $(window).height();
    $('.sexmask').css('height',allHeight+80);
}

var ben_18_hide = function(){
    if ($('.sex').length == 0){
        return;
    }
    
    $(window).resize(function(){
        $('body, #main').css('height', 'auto');
    });

    $('.sexmask').hide();
    $('.sex').hide();
    $('body, #main').css('height', 'auto');
    $('body, #main').css('background', '');
}
var art_18_ben_event = function (){
if (typeof(article_status) != 'undefined' && article_status == 1) {
    if ($('.sex').length == 0) {
	  var html = get_18_block_html();
	  $('#main').append(html);
    }

    ben_18_show();
}
$('#18yesBtn').click(function(){
    ben_18_hide();
});

$('#18noBtn').click(function(){
    location.href='/';
});

}();
