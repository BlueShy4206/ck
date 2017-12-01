
var ONEAD = {};
	ONEAD.channel =  21; // 自由時報電子報：文章版位
	ONEAD.volume =  0.02; // range is 0 to 1 (float)
	ONEAD.slot_limit = {width: 960, height: 420};
	// optional(s)
	ONEAD.slot_limit_multiple = {
		inread: {
			width: 634,
			height: 390
		}
	};
	ONEAD.response_freq = {start:1, step: 3};
	ONEAD.category = get_now_category();
	ONEAD.response_freq_multiple = {
		instream: "1,2,4,7,10,13,16,19",
		inread: "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"
	};
ONEAD.cmd = ONEAD.cmd || [];

// For OneAD, DON'T MODIFY the following
if (typeof(ONEAD) !== "undefined"){
	ONEAD.uid = "1000054";
	ONEAD.external_url = "http://onead.onevision.com.tw/"; // base_url, post-slash is necessary
	ONEAD.wrapper = 'ONEAD_player_wrapper';
	ONEAD.wrapper_multiple = {
		instream: "ONEAD_player_wrapper", // equals to inpage
		inread: "ONEAD_inread_wrapper",
		incover: "ONEAD_incover_wrapper"
	};
}

if (typeof window.isip_js == "undefined") {
	(function() {
		var src = 'http://ad-specs.guoshipartners.com/static/js/isip.v2.js';
		var js = document.createElement('script');
		js.async = true;
		js.type = 'text/javascript';
		var useSSL = 'https:' == document.location.protocol;
		js.src = src;
		var node = document.getElementsByTagName('script')[0];
		node.parentNode.insertBefore(js, node.nextSibling); // insert after
	})();
}

ONEAD_on_get_response = function(param){
// if there is no pid, param is {}, it's not null
	if (param === null || param.pid === undefined){
		// 沒廣告
	}else{
		var t = setInterval(function(){
			if (ONEAD_is_above(100)){}
		}, 1000);
	 }
}
	// 這個函式名稱是固定的，廣告播放完畢會呼叫之
/*
function changeADState(obj){
	if (obj.newstate == 'COMPLETED' || obj.newstate == 'DELETED' ){
		if (ONEAD.play_mode == 'incover'){
			ONEAD_cleanup(ONEAD.play_mode);
		}else{
			ONEAD_cleanup();
		}
	}
}
*/
function changeADState(obj){
    // if not out-of-screen
    if (!ONEAD_is_above(200)){ // 可知廣告是否超過 browser 顯示範圍， 以控制廣告播放完畢時，不會slideup
        // following is necessary for Firefox (its bug), DON'T remove it
        ONEAD_setfocus();

        if (obj.newstate == 'COMPLETED' || obj.newstate == 'DELETED' ){
            if (ONEAD.play_mode == 'incover'){
                // remove the dimming block
                ONEAD_cleanup(ONEAD.play_mode);
            }else{
                ONEAD_cleanup();
            }
        }
    }
    else {
        if (obj.newstate == 'DELETED' ){
            if (ONEAD.play_mode == 'incover'){
                // remove the dimming block
                ONEAD_cleanup(ONEAD.play_mode);
            }else{
                ONEAD_cleanup();
            }
        }
    }
}

function get_now_category() {
    var _category = '-1';
    try {
        var secA = uri.split('/')[1];
        var secB = uri.split('/')[2];
        if (secA.toLowerCase()=='news') _category = secB;
    } catch (e) {

    }
    return _category;
}
