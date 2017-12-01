(function() {
    if (typeof DISPLAY2S == 'undefined' || !DISPLAY2S) {
        var DISPLAY2S = {};
    }
    DISPLAY2S.DEFAULT_SETTINGS = {
        linkspothost : 'https://tw.linkspot.search.yahoo.com/sales/ysmlist.php',
        apihost : 'https://ssl.sitemaji.com/yc.json',
        imghost : 'https://s.yimg.com/bf/linkspot/'
    }
    DISPLAY2S.PREFIX = 'ysm-d2s-module-';
    DISPLAY2S.PROTO = {
        createJS : function(sUrl) {
            var head = document.getElementsByTagName('head')[0],
                script = document.createElement('script');
            script.src = sUrl;
            head.appendChild(script);
            script = null;
        },
        genHTML : function(aKeywords, sCat, sCat2, pc_len) {
            var sHTML = '';
            var sCat_name = sCat;
            var sImgname = '';
            var x = 1;
            for (var i = 0, j = iCount; i < j; i++) {
                sImgname = (x < 10) ? '0' + x : x;
                if (sCat == 'entertainment' && i < 9) {// entertainment10, 11 img not found
                    sCat = 'tech';
                }
                if (sPartner === 'icars') {// entertainment10, 11 img not found
                    sCat = 'auto';
                }
                if(iCount == 21 ) {
                    if(sImgname > pc_len) {
                    sCat_name = sCat2;
                    x = 1;
                    sImgname = (x < 10) ? '0' + x : x;
                    }
                }
                    x ++ ;
                if (sCat_name == 'entertainment' && x < 9) {
                    sCat_name = 'tech';
                }
                sHTML = sHTML + '<li class="' + DISPLAY2S.PREFIX + 'u"><a href="' + DISPLAY2S.DEFAULT_SETTINGS.linkspothost + '?p=' + encodeURIComponent(aKeywords[i]) + '&Partner=tw_syndication_sitetag_' + sPartner + '_park&type=popup' + '" target="_blank"><img src="' + DISPLAY2S.DEFAULT_SETTINGS.imghost + sCat_name + sImgname + '.jpg">' + '<span>' + aKeywords[i] + '</span></a></li>';
                }
            var dUl = document.getElementsByTagName('ul')[0];
            dUl.innerHTML = sHTML;
        },
        shuffle : function(o){
            for(var j, x, i = o.length; i; j = Math.floor(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
            return o;
        },
        getYahooHotWords : function(data) {
            var aCat = [],
                aKeywords = [],
                aKeywords_concat = [];
            if (!data) {
                return;
            }
            for (var i in data) {
                var a = i.toString();
                aCat.push(a);
            }
            //讓使用concat連接 不會讓相同的字串重複列出
            Array.prototype.unique = function() {
                var a = this.concat();
                for(var i=0; i<a.length; ++i) {
                    for(var j=i+1; j<a.length; ++j) {
                        if(a[i] === a[j])
                            a.splice(j, 1);
                    }
                }
                return a;
            };
            var random_count = aCat.length,
                iIndex = Math.floor(Math.random()*random_count),
                iIndex2 = ((iIndex + 1) >= (random_count)) ? iIndex - 1 : iIndex + 1,
                sCat = aCat[iIndex],
                sCat2 = aCat[iIndex2],
                aKeywords = data[sCat],
                aKeywords_concat = data[sCat].concat(data[sCat2]).unique(),
                aKeywordpc1 = data[sCat],
                aKeywordpc2 = data[sCat2];

            if (sPartner === 'icars') {
                aKeywords = data['auto'];
            }
            if(iCount == 21) {
                aKeywords_concat.shift();
                DISPLAY2S.PROTO.genHTML(aKeywords_concat, sCat, sCat2, (aKeywordpc1.length - 1));
                return;
            }
            aKeywords.shift();
            DISPLAY2S.PROTO.genHTML(DISPLAY2S.PROTO.shuffle(aKeywords), sCat, sCat2, aKeywordpc1.length);
        },
        init : function() {
            DISPLAY2S.PROTO.createJS(DISPLAY2S.DEFAULT_SETTINGS.apihost);
        }
    }
    window.DISPLAY2S = DISPLAY2S;
    DISPLAY2S.PROTO.init();
}());
