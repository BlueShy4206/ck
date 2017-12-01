
if (typeof console === 'undefined' || typeof console.log === 'undefined') {
    console = {};
    console.log = function() {};
}
document.write('<div id="id566124a3a8502"></div>');
var thenewslens = 1036820734;
var appledaily = -599536824;
var mappledaily = 1279734942;
var mamaclub = 752231025;
var cool3c = -1407993245;
var everydayhealth = -1330785334;
String.prototype.hashCode = function() {
    var hash = 0, i, chr, len;
    if (this.length == 0) return hash;
    for (i = 0, len = this.length; i < len; i++) {
        chr   = this.charCodeAt(i);
        hash  = ((hash << 5) - hash) + chr;
        hash |= 0;
    }
    return hash;
};
function trimpath(path, start) {
    if (path.length == 0) {
        return path;
    }
    var e = path.length - 1;
    var end = e;
    for (; path[e] == '/' && e > 0; e--) {
        end = e;
    }
    if (path[end] == '/') {
        return path.substring(start, end);
    } else {
        return path.substring(start, path.length);
    }
}
function hackurl(l) {
    switch (l.host.hashCode()) {
    case thenewslens:
        return 'thenewslens:' + trimpath(l.pathname, 6);
    case appledaily:
    case mappledaily:
        var p = trimpath(l.pathname, 0);
        var parray = p.split('/');
        if (parray.length >= 6) {
            return 'appledaily:' + parray.slice(4, 6).join('.');
        } else {
            return 'appledaily:' + p;
        }
    case cool3c:
        return 'cool3c:' + trimpath(l.pathname, 9);
    case mamaclub:
        return 'mamaclub:' + trimpath(l.pathname, 7);
    case everydayhealth:
        return 'everydayhealth:' + l.pathname.split('/')[2];
    default:
        return '';
    }
}
function createXMLHttpRequest() {
    var xmlHttp = null;
    if (typeof XDomainRequest !== 'undefined' && window.FormData === undefined) {
        return new XDomainRequest();
    }
    if (typeof XMLHttpRequest !== 'undefined') {
        xmlHttp = new XMLHttpRequest();
    } else if(typeof window.ActiveXObject !== 'undefined') {
        try {
            xmlHttp = new ActiveXObject('Msxml2.XMLHTTP.4.0');
        } catch(e) {
            try {
                xmlHttp = new ActiveXObject('MSXML2.XMLHTTP');
            } catch(e) {
                try {
                    xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
                } catch(e) {
                    xmlHttp = null;
                }
            }
        }
    }
    return xmlHttp;
}
function getWidthid566124a3a8502() {
    var ins = [[240, 320],[320, 480], [480, 800], [768, 1024]];
    if (0 == 1) {
        var h = screen.height;
        var w = screen.width;
        var hid = h>=240?h>320?h>=480?h>=768?3:2:1:0:0;
        var wid = w>=320?w>480?w>=800?w>=1024?3:2:1:0:0;
        return hid>wid?ins[wid][1]:ins[hid][1];
    } else {
        return 300;
    }
}
function getHeightid566124a3a8502() {
    var ins = [[240, 320],[320, 480], [480, 800], [768, 1024]];
    if (0 == 1) {
        var h = screen.height;
        var w = screen.width;
        var hid = h>=240?h>320?h>=480?h>=768?3:2:1:0:0;
        var wid = w>=320?w>480?w>=800?w>=1024?3:2:1:0:0;
        return hid>wid?ins[wid][0]:ins[hid][0];
    } else {
        return 250;
    }
}
function errid566124a3a8502() {
    var ps_u = (location.protocol=='https:'?'https://anet.c.appier.net/www/delivery/passback.php':'http://anet.c.appier.net/www/delivery/passback.php');
    var src = ps_u+"?zoneid=94&id=id566124a3a8502";
    var e = createXMLHttpRequest();
    e.open('GET', src);
    e.onload = function() {
        console.log('error load');
        var i = document.createElement('iframe');
        i.frameBorder = 0;
        i.scrolling = 'no';
        //adiv.appendChild(i)
        document.getElementById('id566124a3a8502').appendChild(i);
        var fw = (i.contentWindow || i.contentDocument);
        fw.document.open();
        fw.document.write(this.responseText);
        fw.document.close();
        i.height = getHeightid566124a3a8502();
        i.width = getWidthid566124a3a8502();
    }
    e.send();
}
function fireieid566124a3a8502(data) {
    var x = createXMLHttpRequest();
    var m3_u = (location.protocol=='https:'?'https://anet.c.appier.net/www/delivery/ajs.php':'http://anet.c.appier.net/www/delivery/ajs.php');
    m3_u += '?' + data.toString();
    var i = document.createElement('iframe');
    i.frameBorder = 0;
    i.scrolling = 'no';
    i.height = getHeightid566124a3a8502();
    i.width = getWidthid566124a3a8502();
    i.marginheight = '0';
    i.marginwidth = '0'; 
    i.hspace = '0';
    i.vspace = '0';
    i.src = m3_u;
    document.getElementById('id566124a3a8502').appendChild(i);
    
}
function fireid566124a3a8502(data) {
    if (window.FormData === undefined) {
        fireieid566124a3a8502(data);
        return;
    }
    var x = createXMLHttpRequest();
    var m3_u = (location.protocol=='https:'?'https://anet.c.appier.net/www/delivery/ajs.php':'http://anet.c.appier.net/www/delivery/ajs.php'); 
    x.open('POST', m3_u, true);
    x.timeout = 1000;
    x.ontimeout = function() {
        x.abort();
        errid566124a3a8502();
    };
    x.onerror = function() {
        errid566124a3a8502();
    }
    x.onload = function() {
        console.log('normal load');
        var i = document.createElement('iframe');
        i.frameBorder = 0;
        i.scrolling = 'no';
        //adiv.appendChild(i)
        document.getElementById('id566124a3a8502').appendChild(i);
        var fw = (i.contentWindow || i.contentDocument);
        fw.document.open();
        fw.document.write(this.responseText);
        fw.document.close();
        i.height = getHeightid566124a3a8502();
        i.width = getWidthid566124a3a8502();
    }
    x.send(data);
}
function getCookie(cname) {
    var name = cname + '=';
    var ca = document.cookie.split(name);
    if (ca.length > 1)
        return ca[1].split(';')[0];
    return '';
}
function getMetaKeywords() {
    var k1 = document.getElementsByName('keywords');
    var k2 = document.getElementsByName('news_keywords');
    var k3 = document.getElementsByName('shareaholic:keywords');
    if (k1.length > 0)
        return k1[0].content;
    else if (k2.length > 0)
        return k2[0].content;
    else if (k3.length > 0)
        return k3[0].content;
    return '';
}
var connectionInfo = navigator.connection || {'type': ''};
var CBFormData = function() {
    if (window.FormData === undefined) {
        this.data = [];
        this.append = function(n, v) {
            this.data.push(encodeURIComponent(n) + '=' + encodeURIComponent(v));
        };
        this.toString = function() {
            return this.data.join('&').replace(/%20/g, '+');
        };
    } else {
        return new FormData();
    }
}
var data = new CBFormData();
data.append('zoneid', 94);
data.append('sw', screen.width);
data.append('sh', screen.height);
data.append('acid', 'MXWRkU3GS7SlUA1wDugIAQ');
data.append('conntype', connectionInfo.type);
data.append('loc', escape(window.location));
if (document.referrer)
    data.append('referer', escape(document.referrer));
var kurl = hackurl(location);
if (kurl === '') {
    var a = document.createElement('a');
    a.href = document.referrer;
    kurl = hackurl(a);
}
console.log(kurl);
var keywords = getMetaKeywords();
if (kurl.length > 0) {
    if (keywords.length == 0)
        keywords = getCookie(kurl);
    if (keywords.length > 0) {
        console.log('kw' + keywords);
        data.append('kw', keywords);
        fireid566124a3a8502(data);
    } else {
        var y = createXMLHttpRequest(); 
        y.open('GET', 'https://ctrapx-04.apx.appier.net/' + kurl);
        y.timeout = 600;
        y.onload = function() {
            data.append('kw', encodeURIComponent(this.responseText));
            console.log(this.responseText);
            fireid566124a3a8502(data);
        };
        y.ontimeout = function() {
            y.abort();
            fireid566124a3a8502(data);
        };
        y.onerror = function() {
            fireid566124a3a8502(data);
        };
        y.send();
    }
} else {
    if (keywords.length > 0)
        data.append('kw', keywords);
    fireid566124a3a8502(data);
}
