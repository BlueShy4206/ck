var src = 'http://'+mobileServer+'/css/setDevice.htm';
var boxes = [];

var cookies_admin = new cookies_admin_mode(window.location.host);
var cookies_m = new cookies_admin_mode('m.ltn.com.tw');

function cookies_admin_mode(mobile_key){

	this.write = function (value){
		document.cookie=mobile_key+'='+value+';domain=.ltn.com.tw;path=/';
	}

	this.read = function(){

		var cookies = document.cookie ? document.cookie.split('; ') : [];
		var res = '';
		for (var i = 0, l = cookies.length; i < l; i++) {
			var parts = cookies[i].split('=');
			var name = parts.shift();
			var cookie = parts.join('=');
			if (mobile_key && mobile_key === name) {
				res = cookie;
				break;
			}
		}
		
		return res;
	}
	
	this.isPC = function(){
		var res = this.read();
		if (res == ''){
			if(jQuery.browser.mobile)
				return false;
			else
				return true;
		}else{
			if(res=='PC')
				return true;
			else
				return false;
		}
	}
};

(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);

if(jQuery.browser.mobile){

	if(cookies_m.read()=='PC'){
		
	}else{
		document.write('<style>body{display: none;}</style>');
		gotoMobile();
	}

}

function gotoMobile(){
  window.location.replace("http://" + mobileServer + uri);
}

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-31404335-1', 'ltn.com.tw');
  ga('require', 'displayfeatures');
  ga('require', 'linkid', 'linkid.js');
  if (typeof(category)!='undefined')
	ga('set', 'dimension2', category);
  ga('send', 'pageview');

var hotnewspgnum = 3;
function hotInit(){
	var huh = $('#hotnewsul1').height() + 10;
	var hli = $('li','#hotnewsul1');
	var ht = 0, hid = 0;
	$.each(hli,function(i){
		if(hid<4){
			if ($(this).offset().top + $(this).outerHeight(true)>ht){
				ht = $(this).offset().top + huh;
				hid++;
			}
			$(this).addClass('hn'+hid);
		}else
			$(this).addClass('hnHd');
	});
	$('.hn4').addClass('hnHd');
	
	if ($('.hotul').size() > 0)
	{
		$('.hotul').hide();
		$('.hotnews_1').show();
		
		// 熱門新聞 隱藏超出文章
		$(".hotul").each(function() {
			hotnews_line_check( $(this) );
		});
		
	};
}
function hotnews_line_check(DOM)
{
	var hotnewstotalheight = 0;
	DOM.children().each(
		function() {
			hotnewstotalheight += $( this ).height();
			hotnewstotalheight += 15;
			if (hotnewstotalheight > 290)
			{
				$( this ).hide();
			};
		}
	);
	return;
}
function hotnewschange(o){
	if ($('#hotnewsul1').size() > 0)
	{
		$('#hotnewsul1').removeClass().addClass('pg'+o);
	}
	if ($('.hotul').size() > 0)
	{
		$('.hotul').hide();
		$('.hotnews_'+o).show();
	}
}

function hotnewspg(o){
  pgcontent = '';
  if(o != 1)
    pgcontent += '<a href="javascript:hotnewschange('+(o-1)+');hotnewspg('+(o-1)+');">上一頁</a>';
  for(i=1;i<=hotnewspgnum;i++){
      if(i==o)
        pgcontent += '<strong>'+i+'</strong>';
      else
        pgcontent += '<a href="javascript:hotnewschange('+i+');hotnewspg('+i+');">'+i+'</a>';
  }
  if(o != hotnewspgnum)
    pgcontent += '<a href="javascript:hotnewschange('+(o+1)+');hotnewspg('+(o+1)+')">下一頁</a>';
  else
    pgcontent += '<a href="/list/MostPopular">下一頁</a>';
  $("#hotnewspg").html(pgcontent);
}

var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') + 
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();

function adshow(pagetype,slot){
  if(addate[pagetype][slot] instanceof Array){
    document.write("<div id='"+addate[pagetype][slot][2]+"' ></div>");
    googletag.cmd.push(function() {
		var slot1 = googletag.defineSlot(addate[pagetype][slot][0], addate[pagetype][slot][1], addate[pagetype][slot][2]).addService(googletag.pubads());
		
		googletag.pubads().addEventListener('slotRenderEnded', function(event) {
			if (event.slot.i.indexOf('K1')>0) {
				if (event.isEmpty) {
					$('.ad970').hide();
				}
			}
			
			if (event.slot.i.indexOf('00-ltn-home-BC1')>0 || event.slot.i.indexOf('00-ltn-home-BC2')>0 ) {
				if (event.isEmpty) {
					$('#'+event.slot.b.getDomId()).hide();
				}
			}
			
		});
	
		/*RTA Script TOP*/
		if(location.hostname==='news.ltn.com.tw'){
			var crtg_split = (crtg_content || '').split(';');
			var pubads = googletag.pubads();
			for (var i=1;i<crtg_split.length;i++){
				pubads.setTargeting("" + (crtg_split[i-1].split('='))[0] + "", "" + (crtg_split[i-1].split('='))[1] + "");
			}
		}
		/*RTA Script END*/

		googletag.enableServices();
		googletag.display(addate[pagetype][slot][2]);

    });
  }
}

$(function (){ 

	$("#tom, #tomf").click(function() {
		cookies_m.write('MOBILE');
		setTimeout('gotoMobile()', 800);
	});
  
	setTimeout(function(){
	
		if(jQuery.browser.mobile){return;}
		move_sidebar_space();
		
	}, 300);

	//var _path = document.location.pathname;
	//if(/^\/news/.test(_path)){
		//news_page();/*GA事件追蹤:新聞內容頁*/
	//}else{
		//index_page();/*GA事件追蹤:首頁點擊*/
	//}
	ga_news_event();
	show_history();
});

function show_history(){
	
	var _path = document.location.pathname;
	var chv = new cookies_admin_mode('history.view');
	var decode = decodeURIComponent;
	var encode = encodeURIComponent;
	
	/*顯示清單*/
	var his = chv.read();
	var new_his = '';
	var hisItem = {};
	if (his==''){
		/*空值*/
	}else{
		/* 分欄：|, 分列：# */
		var line = his.split('#')
		var his_ul = '';
		$.each(line, function(idx, rs){
			var row = rs.split('|');
			var a_title = decode(row[0]);
			var a_link = decode(row[1]);
			if(idx>=5){return false;} /*只取五則*/
			
			new_his +=(new_his=='') ? '' : '#';
			new_his += rs;
			his_ul += '<li><a href="'+a_link+'">'+a_title+'</a></li>';
			debug(idx+':'+a_title+'='+a_link);
			
			if(idx<=4) hisItem[a_link] = true;
			
		});
		
		if(his_ul!=''){
			debug('his_ul='+his_ul);
			$('#pointnews1 ul').empty().append(his_ul);
		}
	}
	
	debug(hisItem);
	
	/*加入清單內*/
	if(/^\/news/.test(_path)){
		var _title = $('.content h1').text();
		var a_title = encode(_title);
		var a_link = encode(_path);
		var _new_his = a_title +'|'+ a_link;
		_new_his += (new_his=='') ? '' : '#';
		/*已存在的就不加入*/
		if(!hisItem[_path]){
			debug('_new_his='+_new_his);
			chv.write(_new_his+new_his);
		} 
	}
	
	function debug(v){
		//console.log(v);
	}
	
}

/* 輪播 */
function boxSlide(){
	var no = arguments[0],
		sec = arguments[1],
		start = arguments[2] || 0, // 第幾張開始
		lbox = this;
		
	if (typeof sec == 'undefined')
		sec = 4500;

	lbox.no = no;
	lbox.len = $('.slideAuto.sa'+no+' .slideElm').size();
	lbox.itv;
	lbox.stop = 0;
	lbox.bts = $('.slideAuto.sa'+no+' .bts');
	if (start=='ran'){
		lbox.n = Math.floor(Math.random() * lbox.len);
	}else
		lbox.n = start*1;

	if (sec !== 0){
		$('.slideAuto.sa'+no+' .btl').click(function(){lbox.SI(-1);});
		$(lbox.bts).click(function(){lbox.goStop();});
		$('.slideAuto.sa'+no+' .btr').click(function(){lbox.SI(1);});
	}

	lbox.fn = function(d){
		if (lbox.stop==1){
			lbox.goStop();
		}
		if (typeof(d)=='undefined') d=1;
		$('.slideAuto.sa'+lbox.no+' .slideElm:nth-child('+lbox.n+')').removeClass('slideElmOn');
		lbox.n += d*1;
		if (lbox.n>lbox.len) lbox.n = 1;
		else if (lbox.n==0) lbox.n = lbox.len;
		var obj = $('.slideAuto.sa'+lbox.no+' .slideElm:nth-child('+lbox.n+')').addClass('slideElmOn');/*GA事件追蹤:首頁大圖*/
		/*2014.10.07 停用
		if(no==1){
			var link = $('.explain a', obj);
			var href = link.attr('href');
			var text = link.text();
			ga_send_event("首頁:大圖顯示", text, href);
		}*/
		
	}

	lbox.goStop = function(){
		if (lbox.stop==1){ //暫停中
			lbox.stop = 0;
			$('img',lbox.bts).attr({'src':'/images/news/bt-stop.png','title':'暫停','alt':'暫停'});
			lbox.SI(1);
		}else{ //播放中
			lbox.stop = 1;
			$('img',lbox.bts).attr({'src':'/images/news/bt-play.png','title':'播放','alt':'播放'});
			clearInterval(lbox.itv);
		}
	}
	
	lbox.SI = function(d){
		lbox.fn(d);
		if (sec !== 0){
			clearInterval(lbox.itv);
			lbox.itv = setInterval(function(){lbox.fn(1)},sec);
		}
	}
	
	lbox.SI();
};

/* 內廣 */
$(function(){
	$('.ltn_ad').each(function(){
		$('head').append('<script src="http://iservice.ltn.com.tw/IService2/ad2.php?ano='+$(this).attr('data-no')+'" async></'+'script>');
		$(this).attr('href',$(this).attr('href')+'&source='+document.URL);
	});
});

/* 重要專題 */
function evtInit(){
	var tab = $('.evtTab'), evt = $('.evt');
	if (tab.length>0){
		$('.evtTab').click(evtChange).hover(evtChange);
		$(tab).first().click();
		if (tab.length>1)
			$(tab).show();
	}else{ //沒tab只show第一組
		$(evt).first().show();
	}
}

function evtChange(){
	$('.evt').hide();
	$('.evtTab').removeClass('evtTab_now');
	var n = $(this).attr('data-col');
	$('.e'+n).show();
	$('.t'+n).addClass('evtTab_now');
}

/*
右側下方留白太多, 需移動右側區塊去填滿
*/
function move_sidebar_space() {

	var obj1129 = $('.contentAll');

	var s2a = {
		'height': function(){			
			var h = $('.content').height();
			if(obj1129.length==1){
				h += obj1129.height();
			}
			return h;
		},
		'offset': function(){
			if(obj1129.length==1){
				return obj1129.offset();
			}else{
				return $('.content').offset();
			}
		}
	}
	var s1 = new scorllobj(".content", ".adright_bar");
var s2 = new scorllobj(s2a, "#door");
	//var s2 = new scorllobj(".content", "#door");

	$(window).on('scroll.sidebar', function () {
		var winScroll = $(window).scrollTop(),
			windowsH = $(window).height();
		s1.run(winScroll, windowsH);
		s2.run(winScroll, windowsH);
	});

	function scorllobj(obj_left, obj_right) {

		var obj = {
			left: (typeof(obj_left)=='string') ? $(obj_left) : obj_left,
			right: $(obj_right)
		};

		var actType = '';

		this.run = function (winScroll, windowsH) {

			  var containerH = obj.left.height(),
				primaryH = obj.left.height(),
				sidebarH = obj.right.height(),
				beginPos = obj.left.offset().top;

			if (sidebarH > primaryH) { return; }
			var runType = 'C';
			var pH = sidebarH + beginPos;
			if (pH > windowsH) {
				runType = 'A';
			} else if (pH < windowsH) {
				runType = 'B';
			}

			if (runType == 'A') {
				if (winScroll + windowsH > sidebarH + beginPos && winScroll + windowsH < primaryH + beginPos) {
					if (actType == 'A1') { return; }
					var fix = winScroll + windowsH - (beginPos + sidebarH);
					obj.right.attr("style", "position:fixed; bottom:0px;");
					actType = 'A1';
				}
				if (winScroll + windowsH > sidebarH + beginPos && winScroll + windowsH >= primaryH + beginPos) {
					if (actType == 'A2') { return; }
					var fix = primaryH - sidebarH;
					obj.right.attr("style", "position:relative; top:" + fix + "px;")
					actType = 'A2';
				}
				if (winScroll + windowsH < sidebarH + beginPos) {
					if (actType == 'A3') { return; }
					obj.right.attr("style", "position:relative; bottom:auto;")
					actType = 'A3';
				}
			}

			if (runType == 'B') {
				if (winScroll > beginPos && winScroll + sidebarH < beginPos + primaryH) {
					if (actType == 'B1') { return; }
					var fix = winScroll - beginPos;
					obj.right.attr("style", "position:fixed; top:0px;")
					actType = 'B1';
				}
				if (winScroll > beginPos && winScroll + sidebarH >= beginPos + primaryH) {
					if (actType == 'B2') { return; }
					var fix = primaryH - sidebarH;
					obj.right.attr("style", "position:relative; top:" + fix + "px;")
					actType = 'B2';
				}
				if (winScroll <= beginPos) {
					if (actType == 'B3') { return; }
					obj.right.attr("style", "position:relative; bottom:auto;")
					actType = 'B3';
				}
			}
		}
	}
};

function move_sidebar_space2() {

	var obj = {
		left: $(".content"),
		right: $(".adright_bar")
	};

	var windowsH = $(window).height(),
		containerH = obj.left.height(),
		primaryH = obj.left.height(),
		sidebarH = obj.right.height(),
		beginPos = obj.left.offset().top;
	
	if (sidebarH > primaryH) {return;}
	
	if (sidebarH < primaryH && sidebarH + beginPos < windowsH) {
		$(window).on('scroll.sidebar', function () {
			
			var windowsH = $(window).height(),
				containerH = obj.left.height(),
				primaryH = obj.left.height(),
				sidebarH = obj.right.height(),
				beginPos = obj.left.offset().top,
				winScroll = $(window).scrollTop();
				
			if (sidebarH > primaryH) {return;}	
				
			if (winScroll > beginPos && winScroll + sidebarH < beginPos + primaryH) {
				var fix = winScroll - beginPos;
				obj.right.attr("style", "position:relative; top:" + fix + "px;")
			}
			if (winScroll > beginPos && winScroll + sidebarH >= beginPos + primaryH) {
				var fix = primaryH - sidebarH;
				obj.right.attr("style", "position:relative; top:" + fix + "px;")
			}
			if (winScroll <= beginPos) {
				obj.right.attr("style", "position:relative; bottom:auto;")
			}
		})
	}
	if (sidebarH < primaryH && sidebarH + beginPos > windowsH) {
		$(window).on('scroll.sidebar', function () {
			var windowsH = $(window).height(),
				containerH = obj.left.height(),
				primaryH = obj.left.height(),
				sidebarH = obj.right.height(),
				beginPos = obj.left.offset().top,
				winScroll = $(window).scrollTop();
				
			if (sidebarH > primaryH) {return;}
				
			if (winScroll + windowsH > sidebarH + beginPos && winScroll + windowsH < primaryH + beginPos) {
				var fix = winScroll + windowsH - (beginPos + sidebarH);
				//obj.right.attr("style", "position:relative; top:" + fix + "px;")
				obj.right.attr("style", "position:fixed; bottom:0px;");
			}
			if (winScroll + windowsH > sidebarH + beginPos && winScroll + windowsH >= primaryH + beginPos) {
				var fix = primaryH - sidebarH;
				obj.right.attr("style", "position:relative; top:" + fix + "px;")
			}
			if (winScroll + windowsH < sidebarH + beginPos) {
				obj.right.attr("style", "position:relative; bottom:auto;")
			}
		})
	}
};

/*GA事件追蹤:頁面不轉換*/
function ga_send_event(category, title, url){
	ga_send_event_callback(category, title, url, function(){});
}

/*GA事件追蹤:頁面轉換*/
function ga_send_event_callback(category, title, url, fn_callback){
	//return fn_callback();
	ga('send', 'event', category, title, url, {'hitCallback':
		function() {
			fn_callback();
		}
	});
}

/*GA事件追蹤:連結點擊*/
function send2ga2page(category, title, url) {
		var redirectTriggered = false;
		
		ga_send_event_callback(category, title, url, function(){
			redirectTriggered = true;
			document.location = url;
		});
		
		setTimeout(function() {
			if (!redirectTriggered) {
				document.location = url;
			}
		}, 1500);
	}

/*GA事件追蹤:首頁氣象*/
function ga_home_weathertab(o){
	var _areaTitle = ['北部地區', '中部地區', '南部地區', '東部地區', '外島地區'];
	var areaTitle = (_areaTitle[o]) ? _areaTitle[o] : '';
	ga_send_event('首頁:氣象', areaTitle, '切換');
}

/*GA事件追蹤:點擊事件*/
function index_page(){

	var idxName = {
		/*首頁區塊*/
		"idx1": "大圖", "idx2": "選單", "idx3": "首八", "idx4": "選舉", "idx5": "焦點", "idx6b_11": "政治", "idx6b_12": "言論", "idx6b_13": "財經", "idx6b_14": "社會", "idx6b_15": "地方", "idx6b_16": "國際", "idx6b_21": "影視", "idx6b_22": "體育", "idx6b_23": "生活", "idx6b_24": "消費", "idx6b_25": "副刊", "idx7": "娛樂", "idx8": "fun送台", "idx9": "3C科技", "idx10": "影音", "idx11": "汽車", "idx12": "中英對照", "idx13": "週末生活", "idx14": "A好康", "idx16": "新聞查詢", "idx17": "球賽直播", "idx18": "網友關注", "idx19": "瀏覽紀錄", "idx21": "統一發票", "idx22": "編輯精選", "idx23": "天氣", "idx26": "首頁頂部", "idx27": "首頁頂部", "idx28": "首頁頂部", "idx30": "首頁底部"
	}

	function check_url(_url){
		if((/^http:/).test(_url)){
			return _url;
		}else{
			return 'http://news.ltn.com.tw'+_url;
		}
	}
	
	var getinfo = function(obj, SendOnly){
		
		var undefined;
		var par = obj.parents('.boxTitle');
		var _desc = par.attr('data-desc');
		var desc = (idxName[_desc]) ? idxName[_desc] : _desc;
		
		var target = obj.attr('target');
		
		var _href = obj.attr('href');
		var text = obj.text();
		if(text==''){
			var img = obj.find('img');
			if(img) text = img.attr('title');
		}
		var head = '';
		if(uri==''){
			head = '首頁';
		}else if(uri=='/' || (/^\/section/).test(uri)){
			head = '次首頁';
		}else if(/^\/news/.test(uri)){
			head = '新聞頁';
		}
		var href = '';
		if(_href){
			if((/^javascript/).test(_href)){
				/*pass*/
			}else{
				href = check_url(_href);
			}
		}
		
		var send_type = 'send';
		if(href==''){
			//ga_send_event(head+':'+desc,text,href);
			//return false;
		}
		
		if(!target && href!=''){
			send_type = 'redirect';
			//return true;
		}else{
			//ga_send_event(head+':'+desc,text,href);
			//return false;
		}
		
		if(SendOnly) send_type = 'send';
		
		if(send_type=='send'){
			ga_send_event(head+':'+desc,text,href);
			return false;
		}else{
			send2ga2page(head+':'+desc,text,href);
			return true;
		}
	}
	
	$('.boxTitle').on('click.count', 'a', function(e){
		if(e.button!=0){return;}
		if(getinfo($(this), false)) e.preventDefault();
	}).on('mouseup.count', 'a', function(e){
		if(e.button!=1){return;}
		getinfo($(this), true);
		e.preventDefault();
	});
	
};


function news_page(){

	function check_url(_url){
		if((/^http:/).test(_url)){
			return _url;
		}else{
			return 'http://news.ltn.com.tw'+_url;
		}
	}
	
	var getinfo = function(desc, obj, SendOnly){
		
		var _href = obj.attr('href');
		var text = obj.text();
		var head = '新聞頁';
		var href = check_url(_href);
		
		var send_type = 'redirect';
		if(typeof _href === 'undefined') send_type = 'send';
		if(SendOnly) send_type = 'send';
		
		if(send_type=='send'){
			ga_send_event(head+':'+desc,text,href);
			return false;
		}else{
			send2ga2page(head+':'+desc,text,href);
			return true;
		}
	}
	
	var setEvent = function(select, title){
		$(select).on('click.count', function(e){
			if(e.button!=0){return;}
			if(getinfo(title, $(this), false)) e.preventDefault();
		}).on('mouseup.count', function(e){
			if(e.button!=1){return;}
			getinfo(title, $(this), true);
			e.preventDefault();
		});
	}
	
	/*相關新聞*/
	setEvent('.relatednews a', '相關新聞');
	/*編輯推薦*/
	setEvent('.realtimenews:eq(0) a', '編輯推薦');
	/*即時新聞*/
	setEvent('.realtimenews:eq(1) a', '即時新聞');
	/*最多瀏覽*/
	setEvent('.browsenews a', '最多瀏覽');
	/*熱門新聞*/
	setEvent('.hotnews a[href^="/news/"]', '熱門新聞');
	/*新聞圖輯*/
	setEvent('.picbox a', '新聞圖輯');
	/*專題*/
	setEvent('.manPrt a', '專題');
	/*放送台*/
	setEvent('[data-box=P-fun] a', '放送台');
	/*3c*/
	setEvent('[data-box=P-3c] a', '3C');
	/*auto*/
	setEvent('[data-box=P-auto] a', '汽車');
	/*ent*/
	setEvent('[data-box=P-ent] a', '娛樂');
	/*網友關注*/
	setEvent('#pointnews0 a', '網友關注');
	
	/*黑心油, 選舉*/
	var getinfoA = function(obj, SendOnly){
		var par = obj.parents('.boxTitle');
		var _desc = par.attr('data-desc');
		return getinfo(_desc, obj, SendOnly);
	};

	$('.boxTitle').on('click.count', 'a', function(e){
		if(e.button!=0){return;}
		if(getinfoA($(this), false)) e.preventDefault();
	}).on('mouseup.count', 'a', function(e){
		if(e.button!=1){return;}
		getinfoA($(this), true);
		e.preventDefault();
	});
	
	
}


// GA 點擊事件統計
function ga_news_event()
{
    var base_root_org = 'http://'+newsServer; // http://istyle.ltn.com.tw

    var deviceDesc = $("meta[name='ltn:device']").attr('content') || 'U';
    /*取頁面說明*/
    var _pageDesc = $('.page-name').attr('data-desc');
	
    var pageDesc =deviceDesc+':'+_pageDesc;

    $(document.body).on('click.ga', '.boxInput', function(){
        var obj = $(this);
        var objDesc = obj.attr('data-desc');
		
        var par = obj.parents('.boxTitle');
        var boxDesc = par.attr('data-desc');
        
        var category = pageDesc;
        var action = boxDesc;
        var label = objDesc || ''; /*使用自定義說明*/
        
        ga_send_event(category,action,label);

    });

    $('.boxTitle').on('click.count', 'a', function(e){
        if(e.button!=0){return;}
        if(getinfo($(this), false)) e.preventDefault();
    }).on('mouseup.count', 'a', function(e){
        if(e.button!=1){return;}
        getinfo($(this), true);
        e.preventDefault();
    });

    function getinfo(obj, SendOnly){
		
        var objText = obj.text();
        var objDesc = obj.attr('data-desc');
		
        var par = obj.parents('.boxTitle');
        /*取區塊說明*/
        var boxDesc = par.attr('data-desc');
        /*是否用連結文字*/
        var useText = par.hasClass('boxText');
		
        var category = pageDesc;
        var action = boxDesc;
        var label = objDesc || ''; /*使用自定義說明*/
        if(useText && label==''){
            label = objText || ''; /*使用連結文字*/
        }

        if(label==''){
            /*記錄該區塊第幾則*/
            var idx = $('a', par).index(obj);
            label = '第'+idx+'則';
        }
		
        var target = obj.attr('target');
        var href = '';
        var _href = obj.attr('href');
		
        if(_href){
            href = check_url(_href);
        }
		
        var send_type = 'send';
		
        if(!target && href!=''){
            send_type = 'redirect';
        }
		
        if(SendOnly) send_type = 'send';
		
        if(send_type=='send'){
            ga_send_event(category,action,label);
            return false;
        }else{
            send2ga2page(category,action,label,href);
            return true;
        }
    }
	
    function check_url(_url){
        if((/^http:/).test(_url)){
            return _url;
        }else if((/^https:/).test(_url)){
            return _url;
        }else if((/^javascript/).test(_url)){
            return '';
        }else if((/^#/).test(_url)){
            return '';
        }else{
            var base_root = $('base').attr('href') || base_root_org;
            return base_root+_url;
        }
    }

    /*GA事件追蹤:頁面不轉換*/
    function ga_send_event(category, title, label){
        ga_send_event_callback(category, title, label, function(){});
    }

    /*GA事件追蹤:頁面轉換*/
    function ga_send_event_callback(category, title, label, fn_callback){
        //return fn_callback();
        ga('send', 'event', category, title, label, {'hitCallback':
	        function() {
		        fn_callback();
	        }
        });
		//console.log(category+'-'+title+'-'+label);
		//return false;
    }

    /*GA事件追蹤:連結點擊*/
    function send2ga2page(category, title, label, url) {
        var redirectTriggered = false;

        ga_send_event_callback(category, title, label, function(){
	        redirectTriggered = true;
	        document.location = url;
        });

        setTimeout(function() {
	        if (!redirectTriggered) {
		        document.location = url;
	        }
        }, 1500);
    }
};