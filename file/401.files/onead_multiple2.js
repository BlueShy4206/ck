var $window = $(window);
var winWidth = $window.width();

if (isM) {
    // OneAD Mobile 版(開始)
    if (idx_MobilOneADSet == 1) {
        var ONEAD = {};
        ONEAD.query_only = true;
        ONEAD.channel = 21; // ChinaTimes
        ONEAD.category = "-1";
	ONEAD.bypass_comscore = true;
        ONEAD.response_freq_multiple = {
		'mobile-incover': "1,2,4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34,36,38,40,42,44,46,48,50",
		'mobile-inread': "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50"
        };
        ONEAD.cmd = ONEAD.cmd || [];

        // For OneAD, DON'T MODIFY the following
        if (typeof (ONEAD) !== "undefined") {
            ONEAD.uid = "1000033";
            ONEAD.external_url = "http://onead.onevision.com.tw/";
        }
        if (typeof window.isip_js == "undefined") {
            (function () {
                var src = 'http://ad-specs.guoshipartners.com/static/js/isip.js';
                var js = document.createElement('script');
                js.async = true;
                js.type = 'text/javascript';
                var useSSL = 'https:' == document.location.protocol;
                js.src = src;
                var node = document.getElementsByTagName('script')[0];
                node.parentNode.insertBefore(js, node.nextSibling); // insert after
            })();
        }

    ONEAD_on_get_response = function (param) {
	// if there is no pid, param is {}, it's not null
	if (param === null || param.pid === undefined) {
	    // 沒廣告
	} else {
		// Mobile In-Read 廣告可與蓋版廣告共存
		if (param.play_mode == 'mobile-inread'){
			ONEAD.cmd = ONEAD.cmd || [];
			ONEAD.cmd.push(function () {
			    ONEAD_expand_slot();
			});
		}
	    var t = setInterval(function () {
		if (ONEAD_is_above(100)) { }
	    }, 1000);
	}
    }

        var AdDomain = document.domain;
        switch (AdDomain) {
            case "news.chinatimes.com":
                ONEAD.category = "news"; // 新聞
                break;
            case "money.chinatimes.com":
                ONEAD.category = "money"; // 財經
                break;
            case "showbiz.chinatimes.com":
                ONEAD.category = "showbiz"; // 電影、娛樂
                break;
            case "ent.chinatimes.com":
                ONEAD.category = "showbiz"; // 電影、娛樂
                break;
            case "life.chinatimes.com":
                ONEAD.category = "life"; // 樂活
                break;
            case "mag.chinatimes.com":
                ONEAD.category = "mag"; // 雜誌
                break;
            case "want-car.chinatimes.com":
                ONEAD.category = "car"; // 旺車網
                break;
            case "house.chinatimes.com":
                ONEAD.category = "house"; // 房地產
                break;
            default:
                ONEAD.category = "news"; // 新聞
        }
    }
    // OneAD Mobile 版(結束)
}
else if (winWidth > 768) {
    // OneAD Desktop 版(開始)
    var ONEAD = {};
    ONEAD.channel = 21; // 中時電子報：文章版位
    ONEAD.volume = 0.05; // range is 0 to 1 (float)
    ONEAD.slot_limit = { width: 980, height: 402 };
    // optional(s)
    ONEAD.slot_limit_multiple = {
        inread: {
            width: 568,
            height: 366
        }
    };
    ONEAD.response_freq = { start: 1, step: 3 };
    ONEAD.category = "-1";
    ONEAD.bypass_comscore = true;
    ONEAD.response_freq_multiple = {
        incover: "1",
        instream: "1,4,7,10,13,16,19,22,25,28,31,34,37,40,43,46,49,52,55,58,61,64,67,70,73,76,79,82,85,88,91,94,97",
        inread: "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99"
    };
    ONEAD.cmd = ONEAD.cmd || [];

    // For OneAD, DON'T MODIFY the following
    if (typeof (ONEAD) !== "undefined") {
        ONEAD.uid = "1000033";
        ONEAD.external_url = "http://onead.onevision.com.tw/"; // base_url, post-slash is necessary
        ONEAD.wrapper = 'ONEAD_player_wrapper';
        ONEAD.wrapper_multiple = {
            instream: "ONEAD_player_wrapper", // equals to inpage
            inread: "ONEAD_inread_wrapper",
            incover: "ONEAD_incover_wrapper"
        };
    }
    if (typeof window.isip_js == "undefined") {
        (function () {
            var src = 'http://ad-specs.guoshipartners.com/static/js/isip.js';
            var js = document.createElement('script');
            js.async = true;
            js.type = 'text/javascript';
            var useSSL = 'https:' == document.location.protocol;
            js.src = src;
            var node = document.getElementsByTagName('script')[0];
            node.parentNode.insertBefore(js, node.nextSibling); // insert after
        })();
    }

    ONEAD_on_get_response = function (param) {
        // if there is no pid, param is {}, it's not null
        if (param === null || param.pid === undefined) {
            // 沒廣告
        } else {
            var t = setInterval(function () {
                if (ONEAD_is_above(100)) { }
            }, 1000);
        }
    }
    // 這個函式名稱是固定的，廣告播放完畢會呼叫之
    function changeADState(obj) {
        if (obj.newstate == 'COMPLETED' || obj.newstate == 'DELETED') {
            if (ONEAD.play_mode == 'incover') {
                // remove the dimming block
                ONEAD_cleanup(ONEAD.play_mode);
            } else {
                ONEAD_cleanup();
            }
        }
    }

    var AdDomain = document.domain;
    switch (AdDomain) {
        case "news.chinatimes.com":
            ONEAD.category = "news"; // 新聞
            break;
        case "money.chinatimes.com":
            ONEAD.category = "money"; // 財經
            break;
        case "showbiz.chinatimes.com":
            ONEAD.category = "showbiz"; // 電影、娛樂
            break;
        case "ent.chinatimes.com":
            ONEAD.category = "showbiz"; // 電影、娛樂
            break;
        case "life.chinatimes.com":
            ONEAD.category = "life"; // 樂活
            break;
        case "mag.chinatimes.com":
            ONEAD.category = "mag"; // 雜誌
            break;
        case "want-car.chinatimes.com":
            ONEAD.category = "car"; // 旺車網
            break;
        case "house.chinatimes.com":
            ONEAD.category = "house"; // 房地產
            break;
        default:
            ONEAD.category = "news"; // 新聞
    }
    // OneAD Desktop 版(結束)
}