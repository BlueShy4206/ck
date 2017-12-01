/*PARAMETERS*/
/* GENERATION: 13:26:1-31, August 2015-141676 */
ad_141676 = {};
ad_141676.id     = "141676";
ad_141676.adSlot = "innity_adslot_141676";
ad_141676.src    = "<script type=\"text/javascript\">google_ad_client=\"ca-pub-6206733407413638\";google_ad_slot=\"9063148575\";google_ad_width=300;google_ad_height=250;</script><!--共產檔檔產內頁右側跟隨300x250--><script type=\"text/javascript\"\
src=\"//pagead2.googlesyndication.com/pagead/show_ads.js\"></script>​";
ad_141676.width  = 300;
ad_141676.height = 250;
ad_141676.frame  = document.createElement("iframe");
ad_141676.frame.id           = "INNITYFrame_141676";
ad_141676.frame.style.width  = ad_141676.width + "px";
ad_141676.frame.style.height = ad_141676.height + "px";
ad_141676.frame.scrolling    = "no";
ad_141676.frame.style.border = "0px";
ad_141676.frame.frameBorder  = 0;
ad_141676.frame.src          = "javascript:'<html><body style=\"background:transparent\"></body></html>'";

function browser_141676() {
	this.ua      = " " + navigator.userAgent.toLowerCase();
	this.av      = parseInt(navigator.appVersion);
	this.isIE    = (this.ua.indexOf("msie") >= 0);
	this.isOpera = (this.ua.indexOf("opera") > 0);
	if (this.isOpera) {
		this.isIE = false;
	}
	this.IEVersion = (this.ua.indexOf("msie") + 1 ? parseFloat(this.ua.split("msie")[1]) : 999);
	this.isIE9up   = (!this.isIE) ? true : ((this.IEVersion > 9) ? true : false);
}
var mybrowser_141676 = new browser_141676();
try {
	c141676_getObj(ad_141676.adSlot).style.width  = 300 + "px";
	c141676_getObj(ad_141676.adSlot).style.height = 250 + "px";
	c141676_getObj(ad_141676.adSlot).appendChild(ad_141676.frame);
	if (mybrowser_141676.isIE && !mybrowser_141676.isIE9up) {
		ad_141676.frame.contentWindow.contents = "<body style=\"padding:0px;margin:0px;\">" + ad_141676.src + "</body>";
		ad_141676.frame.src = "javascript:window[\"contents\"]";
	} else {
		ad_141676.frame.contentWindow.document.open("text/html", "replace");
		ad_141676.frame.contentWindow.document.write("<body style=\"padding:0px;margin:0px;\">" + ad_141676.src + "</body>");
		ad_141676.frame.contentWindow.document.close();
	}
} catch(e) {
	document.write(ad_141676.src);
}
function c141676_getObj(obj) {
	return document.getElementById(obj);
}
// Ad start