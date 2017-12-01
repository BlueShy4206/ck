function setClipboard(maintext) { 
   if (window.clipboardData) { 
      return (window.clipboardData.setData("Text", maintext)); 
   } 
   else if (window.netscape) { 
        try {
            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
        }
        catch (e)
        {
            alert("瀏覽器不支援！\n請在網址列輸入'about:config'按Enter\n然後將'signed.applets.codebase_principal_support'設定為'true'");
        }
      var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard); 
      if (!clip) return; 
      var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable); 
      if (!trans) return; 
      trans.addDataFlavor('text/unicode'); 
      var str = new Object(); 
      var len = new Object(); 
      var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString); 
      var copytext=maintext; 
      str.data=copytext; 
      trans.setTransferData("text/unicode",str,copytext.length*2); 
      var clipid=Components.interfaces.nsIClipboard; 
      if (!clip) return false; 
      clip.setData(trans,null,clipid.kGlobalClipboard); 
      return true; 
   } 
   return false; 
} 

function getClipboard() { 
   if (window.clipboardData) { 
      return(window.clipboardData.getData('Text')); 
   } 
   else if (window.netscape) { 
      netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect'); 
      var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard); 
      if (!clip) return; 
      var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable); 
      if (!trans) return; 
      trans.addDataFlavor('text/unicode'); 
      clip.getData(trans,clip.kGlobalClipboard); 
      var str = new Object(); 
      var len = new Object(); 
      try { 
         trans.getTransferData('text/unicode',str,len); 
      } 
      catch(error) { 
         return null; 
      } 
      if (str) { 
         if (Components.interfaces.nsISupportsWString) str=str.value.QueryInterface(Components.interfaces.nsISupportsWString); 
         else if (Components.interfaces.nsISupportsString) str=str.value.QueryInterface(Components.interfaces.nsISupportsString); 
         else str = null; 
      } 
      if (str) { 
         return(str.data.substring(0,len.value / 2)); 
      } 
   } 
   return null; 
}


function CheckPicSize(chkw) {
	if (chkw > 400) {
		chkw = 400;
	} else { 
		chkw = chkw;
	}
	return chkw;
}  






/*
 * FlashObject embed
 * by Geoff Stearns (geoff@deconcept.com, http://www.deconcept.com/)
 *
 * v1.1.1 - 05-17-2005
 *
 * writes the embed code for a flash movie, includes plugin detection
 *
 * Usage:
 *
 *	myFlash = new FlashObject("path/to/swf.swf", "swfid", "width", "height", flashversion, "backgroundcolor");
 *	myFlash.write("objId");
 *
 * for best practices, see:
 *  http://blog.deconcept.com/2005/03/31/proper-flash-embedding-flashobject-best-practices/
 *
 */

var FlashObject = function(swf, id, w, h, ver, c) {
	this.swf = swf;
	this.id = id;
	this.width = w;
	this.height = h;
	this.version = ver;
	this.align = "middle";

	this.params = new Object();
	this.variables = new Object();

	this.redirect = "";
	this.sq = document.location.search.split("?")[1] || "";
	this.bypassTxt = "<p>Already have Macromedia Flash Player? <a href='?detectflash=false&"+ this.sq +"'>Click here if you have Flash Player "+ this.version +" installed</a>.</p>";
	
	if (c) this.color = this.addParam('bgcolor', c);
	this.addParam('quality', 'high'); // default to high
	this.doDetect = getQueryParamValue('detectflash');
}

var FOP = FlashObject.prototype;

FOP.addParam = function(name, value) { this.params[name] = value; }

FOP.getParams = function() { return this.params; }

FOP.getParam = function(name) { return this.params[name]; }

FOP.addVariable = function(name, value) { this.variables[name] = value; }

FOP.getVariable = function(name) { return this.variables[name]; }

FOP.getVariables = function() { return this.variables; }

FOP.getParamTags = function() {
    var paramTags = "";
    for (var param in this.getParams()) {
        paramTags += '<param name="' + param + '" value="' + this.getParam(param) + '" />';
    }
    return (paramTags == "") ? false:paramTags;
}

FOP.getHTML = function() {
    var flashHTML = "";
    if (navigator.plugins && navigator.mimeTypes.length) { // netscape plugin architecture
        flashHTML += '<embed type="application/x-shockwave-flash" src="' + this.swf + '" width="' + this.width + '" height="' + this.height + '" id="' + this.id + '" align="' + this.align + '"';
        for (var param in this.getParams()) {
            flashHTML += ' ' + param + '="' + this.getParam(param) + '"';
        }
        if (this.getVariablePairs()) {
            flashHTML += ' flashVars="' + this.getVariablePairs() + '"';
        }

		flashHTML += ' allowScriptAccess="sameDomain" allowFullScreen="true" ';
        flashHTML += '></embed>';
    } else { // PC IE
        flashHTML += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' + this.width + '" height="' + this.height + '" id="' + this.id + '" name="' + this.id + '" align="' + this.align + '">';
        flashHTML += '<param name="movie" value="' + this.swf + '" />';
		flashHTML += '<param name="allowScriptAccess" value="sameDomain" />'
		flashHTML += '<param name="allowFullScreen" value="true" />' 
        if (this.getParamTags()) {
            flashHTML += this.getParamTags();
        }
        if (this.getVariablePairs() != null) {
            flashHTML += '<param name="flashVars" value="' + this.getVariablePairs() + '" />';
        }
        flashHTML += '</object>';
    }
    return flashHTML;	
}

FOP.getVariablePairs = function() {
    var variablePairs = new Array();
    for (var name in this.getVariables()) { 
    	variablePairs.push(name + "=" + escape(this.getVariable(name))); 
    }
    return (variablePairs.length > 0) ? variablePairs.join("&"):false;
}

FOP.write = function(elementId) {
  
	if(detectFlash(this.version) || this.doDetect=='false') {
		if (elementId) {
			//document.getElementById(elementId).innerHTML = this.getHTML();
			document.getElementById(elementId).innerHTML ="";
			document.write(this.getHTML());
		} else {
			document.write(this.getHTML());
		}
	} else {
		if (this.redirect != "") {
			document.location.replace(this.redirect);
		} else if (this.altTxt) {
			if (elementId) {
				document.getElementById(elementId).innerHTML = this.altTxt +""+ this.bypassTxt;
			} else {
				document.write(this.altTxt +""+ this.bypassTxt);
			}
		}
	}		
}

/* ---- detection functions ---- */
function getFlashVersion() {
	var flashversion = 0;
	if (navigator.plugins && navigator.mimeTypes.length) {
		var x = navigator.plugins["Shockwave Flash"];
		if(x && x.description) {
			var y = x.description;
   			flashversion = y.charAt(y.indexOf('.')-1);
		}
	} else {
		result = false;
	    for(var i = 15; i >= 3 && result != true; i--){
   			execScript('on error resume next: result = IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash.'+i+'"))','VBScript');
   			flashversion = i;
   		}
	}
	return flashversion;
}

function detectFlash(ver) {	return (getFlashVersion() >= ver) ? true:false; }

// get value of query string param
function getQueryParamValue(param) {
	var q = document.location.search || document.location.href.split("#")[1];
	if (q) {
		var detectIndex = q.indexOf(param +"=");
		var endIndex = (q.indexOf("&", detectIndex) > -1) ? q.indexOf("&", detectIndex) : q.length;
		if (q.length > 1 && detectIndex > -1) {
			return q.substring(q.indexOf("=", detectIndex)+1, endIndex);
		} else {
			return "";
		}
	}
}

/* add Array.push if needed */
if(Array.prototype.push == null){
	Array.prototype.push = function(item) { this[this.length] = item; return this.length; }
}






function StartSrh(k){
  var v_chn=document.getElementById('chn');
  if (''==k)
    k=v_chn.value;
  else
    v_chn.value=k;

  if ('W'==k.substr(0,1)){
    document.getElementById('search_bar_imgyw').src='images/search_yw_01.gif';
    document.getElementById('search_bar_imgweb').src='images/search_all.gif';
    document.getElementById('ydiv').style.display='none';
    document.getElementById('wdiv').style.display='block';
  } else {
    document.getElementById('search_bar_imgyw').src='images/search_yw.gif';
    document.getElementById('search_bar_imgweb').src='images/search_all_01.gif';
    document.getElementById('ydiv').style.display='block';
    document.getElementById('wdiv').style.display='none';
  }

  var s=document.getElementById('kw');
  if (''==s.value || '-請輸入關鍵字-'==s.value){
    document.getElementById('kw').value='';
    document.getElementById('kw').focus();
    document.getElementById('alert_str').innerHTML='<br><font color=red>　請輸入要搜尋的關鍵字</font>';
    return false;
  } else {
    document.getElementById('alert_str').innerHTML='';
    if ('W'==k.substr(0,1) && 'A'!=k.substr(1,1)){
      document.Srhdata.wwhich[0].checked=true;
      var url='http://www.youthwant.com.tw/search/srho?chn='+v_chn.value+'&kw='+s.value;
      window.open(url,'YS_win','');
      return false;
    } else {
      var url='http://www.youthwant.com.tw/search/srh?chn='+v_chn.value+'&kw='+s.value;
      document.Srhdata.action=url;
      location.href=url;
      return false;
    }
  }
}

function StartSrh1(k){
  var v_chn=document.getElementById('chn1');
  if (''==k)
    k=v_chn.value;
  else
    v_chn.value=k;

  if ('W'==k.substr(0,1)){
    document.getElementById('search_bar_imgyw1').src='images/search_yw_01.gif';
    document.getElementById('search_bar_imgweb1').src='images/search_all.gif';
    document.getElementById('ydiv1').style.display='none';
    document.getElementById('wdiv1').style.display='block';
  } else {
    document.getElementById('search_bar_imgyw1').src='images/search_yw.gif';
    document.getElementById('search_bar_imgweb1').src='images/search_all_01.gif';
    document.getElementById('ydiv1').style.display='block';
    document.getElementById('wdiv1').style.display='none';
  }
    
  var s=document.getElementById('kw1');
  if (''==s.value || '-請輸入關鍵字-'==s.value){
    document.getElementById('kw1').value='';
    document.getElementById('kw1').focus();
    document.getElementById('alert_str1').innerHTML='<br><font color=red>　請輸入要搜尋的關鍵字</font>';
    return false;
  } else {
    document.getElementById('alert_str1').innerHTML='';
    if ('W'==k.substr(0,1) && 'A'!=k.substr(1,1)){
      document.Srhdata1.wwhich1[0].checked=true;
      var url='http://www.youthwant.com.tw/search/srho?chn='+v_chn.value+'&kw='+s.value;
      window.open(url,'YS_win','');
      return false;
    } else {
      var url='http://www.youthwant.com.tw/search/srh?chn='+v_chn.value+'&kw='+s.value;
      document.Srhdata1.action=url;
      location.href=url;
      return false;
    }
  }
}

function StartSrh2(){
  var v_chn=document.getElementById('chn');
  var s=document.getElementById('kw');
  if (''==s.value || '-請輸入關鍵字-'==s.value){
    document.getElementById('kw').value='';
    document.getElementById('kw').focus();
    document.getElementById('alert_str').innerHTML='<div align="right" style="padding-right:150px;"><font color=red size=2>●請輸入要搜尋的關鍵字</font></div>';
    return false;
  } else {
		if ('ST'==v_chn.options[v_chn.selectedIndex].value){
	    var url='http://share.youthwant.com.tw/sh_search.php?FP=1&Swhich=1&S_title='+s.value+'&SR_date=2&SR_ft=1&SR_ct=1';
			document.Srhdata.action=url;
			location.href=url;
			return false;
		} else {
	    document.getElementById('alert_str').innerHTML='';
	    var url='http://www.youthwant.com.tw/search/srh?chn='+v_chn.value+'&kw='+s.value;
	    document.Srhdata.action=url;
	    location.href=url;
	    return false;
  	}
  }
}

/*
for 校園頻道的search
*/
function StartSrh3(){
  var v_chn=document.getElementById('chn');
  var s=document.getElementById('kw');
  if (''==s.value || '-請輸入關鍵字-'==s.value){
    document.getElementById('kw').value='';
    document.getElementById('kw').focus();
    document.getElementById('alert_str').innerHTML='<br><font color=red>●請輸入要搜尋的關鍵字</font>';
    return false;
  } else {
    document.getElementById('alert_str').innerHTML='';
    var url='http://www.youthwant.com.tw/search/srh?chn='+v_chn.value+'&kw='+s.value;
    document.Srhdata.action=url;
    window.open(url,'','');
    return false;
  }
}


/*原先共產檔頁面刊頭的預設js*/
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}











/* 原先 AjaxFunc.js 合併到此 */

/*
 * Returns a new XMLHttpRequest object, or false if this browser
 * doesn't support it
 */
function newXMLHttpRequest() {
  var xmlreq = false;
  if (window.XMLHttpRequest) {

    // Create XMLHttpRequest object in non-Microsoft browsers
    xmlreq = new XMLHttpRequest();

  } else if (window.ActiveXObject) {

    // Create XMLHttpRequest via MS ActiveX
    try {
      // Try to create XMLHttpRequest in later versions
      // of Internet Explorer

      xmlreq = new ActiveXObject("Msxml2.XMLHTTP");

    } catch (e1) {

      // Failed to create required ActiveXObject

      try {
        // Try version supported by older versions
        // of Internet Explorer

        xmlreq = new ActiveXObject("Microsoft.XMLHTTP");

      } catch (e2) {

        // Unable to create an XMLHttpRequest with ActiveX
      }
    }
  }
  return xmlreq;
}
/*
 * Returns a function that waits for the specified XMLHttpRequest
 * to complete, then passes its XML response
 * to the given handler function.
 * req - The XMLHttpRequest whose state is changing
 * responseXmlHandler - Function to pass the XML response to
 */
function getReadyStateHandler(req, responseXmlHandler, oba) {
  // Return an anonymous function that listens to the 
  // XMLHttpRequest instance
  return function () {

    // If the request's status is "complete"
    if (req.readyState == 4) {
      
      // Check that a successful server response was received
      if (req.status == 200) {

        // Pass the XML payload of the response to the 
        // handler function
        responseXmlHandler(req.responseXML, oba);

      } else {

        // An HTTP problem has occurred
        alert("HTTP error: "+req.status);
      }
    }
  }
}
var req = false;


/* 原先 ShareTagproc.js 合併到此 */

function makeRequest_SHARETagAdd() {
	req = newXMLHttpRequest();
	var k=document.getElementById("L_Tagadd_words");
	var s=document.getElementById("WPid");
	var su=document.getElementById("WPuid");
	var t=document.getElementById("L_Tagadd_status");
	
	if (""==k.value || "輸入適當標籤"==k.value){
			alert("請輸入標籤");
			k.select();
			k.focus();
			return false;
	}
	
	
	
//	var tadiv1=document.getElementById("L_TagaddDiv1");
//	var tadiv2=document.getElementById("L_TagaddDiv2");
//	
//	tadiv1.style.display='none';
//	tadiv2.style.display='block';
//	t.innerHTML="<font color=blue size=2>資料處理中...</font>";
	
  
	if (!req) {
		t.innerHTML="<font color=red size=2>系統連線失敗！</font>";
		return false;
	}
	req.onreadystatechange = getReadyStateHandler(req, SHARETagAdd, t);
	req.open('POST', 'sh_AJtagproc.php', true);
	req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	req.send('w=N&id='+s.value+'&uid='+su.value+'&wds='+k.value);
}

function SHARETagAdd(ListXml, t){
	var k=document.getElementById("L_Tagadd_words");
	var s=document.getElementById("WPid");
	var item = ListXml.getElementsByTagName("TagInfo")[0];
	var message = item.getElementsByTagName("infoText")[0].firstChild.nodeValue;
	
//	var tlnk=document.getElementById("L_Tags_linkDiv");
//	var item = ListXml.getElementsByTagName("TagInfo")[0];
//	var stat = item.getElementsByTagName("status")[0].firstChild.nodeValue;
//	var message = item.getElementsByTagName("infoText")[0].firstChild.nodeValue;
//	if (1==stat){
//		tlnk.innerHTML=message+','+tlnk.innerHTML;
//	} else {
//		t.innerHTML="<font color=red size=2>"+message+"</font>";
//		return false;
//	}
//
//	t.innerHTML="<font color=red size=2>貼標籤成功～「"+message+"」 </font>";
//	document.getElementById('L_Tagadd_swflag').value=0;
	
	
	alert("貼標籤成功～" + k.value);
	//location.reload();
	location.href="delbody.php?id="+s.value;
}

function ShowTagDetail(id1,id2,id3,oba){
	req = newXMLHttpRequest();
  req.onreadystatechange = getReadyStateHandler(req, displayInfo, oba);
	req.open("POST", "sh_AJtagproc.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.send("w=Q&uid="+id1+"&id="+id2+"&tag="+id3);
}
function displayInfo(ListXml, oba){
	var item = ListXml.getElementsByTagName("TagInfo")[0];
	var stat = item.getElementsByTagName("status")[0].firstChild.nodeValue;
	var message = item.getElementsByTagName("infoText")[0].firstChild.nodeValue;
	if (stat==1){
		oba.title=message+"所貼";
	}else{
	alert(message);
	}
}
function ShowTagAddZone(k){
	document.getElementById('L_TagaddDiv').style.display=style_display_switch(1);
	document.getElementById('L_TagaddDiv1').style.display=style_display_switch(1);
	document.getElementById('L_TagaddDiv2').style.display=style_display_switch(0);
	if (0==k){
		document.getElementById('L_Tagadd_words').value='';
		document.getElementById('L_Tagadd_words').focus();
	} else {
		document.getElementById('L_Tagadd_words').value='輸入適當標籤';
	}
}
function ShowTagDelZone(k){
	document.getElementById('L_Tags_linkDiv').style.display=style_display_switch(0);
	document.getElementById('L_Tags_mnglinkDiv').style.display=style_display_switch(1);

}

function DeleteTag(){
	var len = document.getElementsByName('L_Tags_Delno').length;
	var chk = 0;
	var tmptag;
	for (i=0; i<len; i++) {
		if (document.getElementsByName('L_Tags_Delno')[i].checked) {
			chk++;
			tmptag = document.getElementsByName('L_Tags_Delno')[i].value;
			break;
		}
	}
	if (!chk) {
		alert('請選擇要刪除的標籤');
		return false;
	}
	
	var s = document.getElementById("WPid");
	var su = document.getElementById("WPuid");
	location.href="sh_AJtagproc.php?w=D&uid="+su.value+"&id="+s.value+"&tag="+tmptag;
}

function New_DeleteTag( deleteTagName, deleteAction ){
	var s = document.getElementById("WPid");
	var su = document.getElementById("WPuid");
	location.href="sh_AJtagproc.php?w=D&uid="+su.value+"&id="+s.value+"&tag="+deleteTagName+"&delAction="+deleteAction;
}

/* 原先 Share_Appraise.js 合併到此 */

var http_request = false;
function makeRequest_SHAREAppr(){
	var p=0;
	if (document.getElementsByName("L_Appr_point")[0].checked) p=5;
	else if (document.getElementsByName("L_Appr_point")[1].checked) p=4;
	else if (document.getElementsByName("L_Appr_point")[2].checked) p=3;
	else if (document.getElementsByName("L_Appr_point")[3].checked) p=2;
	else if (document.getElementsByName("L_Appr_point")[4].checked) p=1;

	if (!p){
		alert('您尚未選擇要評價的星星數喔！');
		return false;
	}
	var s=document.getElementById("WPid").value;
	
  http_request = false;
  document.getElementById("L_ApprDiv1").style.display='none';
  document.getElementById("L_ApprDiv2").style.display='block';
	document.getElementById("L_Appr_msg").innerHTML="<font color=blue size=2><b>評價中...</b></font>";
                if (window.XMLHttpRequest) { // Mozilla, Safari,...
                    http_request = new XMLHttpRequest();
                    if (http_request.overrideMimeType) {
                        http_request.overrideMimeType('text/xml');
                    }
                } else if (window.ActiveXObject) { // IE
                    try {
                        http_request = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e) {
                        try {
                        http_request = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (e) {}
                    }
                }

                if (!http_request) {
									document.getElementById("L_Appr_msg").innerHTML="<font color=red size=2><b>系統錯誤！</b></font>";
                  return false;
                }
                http_request.onreadystatechange = SHAREAppr;
                http_request.open('POST', 'sh_AJappraise.php', true);
                http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                http_request.send('id='+s+'&p='+p);
}

	var tmpStar_arr=new Array();
	tmpStar_arr[0]="";
	tmpStar_arr[1]="<img src='images_200609/star_y.gif' title='不好看＠＠'><img src='images_200609/star_g.gif' title='不好看＠＠'><img src='images_200609/star_g.gif' title='不好看＠＠'><img src='images_200609/star_g.gif' title='不好看＠＠'><img src='images_200609/star_g.gif' title='不好看＠＠'>";
	tmpStar_arr[2]="<img src='images_200609/star_y.gif' title='普普通通'><img src='images_200609/star_y.gif' title='普普通通'><img src='images_200609/star_g.gif' title='普普通通'><img src='images_200609/star_g.gif' title='普普通通'><img src='images_200609/star_g.gif' title='普普通通'>";
	tmpStar_arr[3]="<img src='images_200609/star_y.gif' title='不錯唷'><img src='images_200609/star_y.gif' title='不錯唷'><img src='images_200609/star_y.gif' title='不錯唷'><img src='images_200609/star_g.gif' title='不錯唷'><img src='images_200609/star_g.gif' title='不錯唷'>";
	tmpStar_arr[4]="<img src='images_200609/star_y.gif' title='讚！有意思'><img src='images_200609/star_y.gif' title='讚！有意思'><img src='images_200609/star_y.gif' title='讚！有意思'><img src='images_200609/star_y.gif' title='讚！有意思'><img src='images_200609/star_g.gif' title='讚！有意思'>";
	tmpStar_arr[5]="<img src='images_200609/star_y.gif' title='酷斃了！非看不可'><img src='images_200609/star_y.gif' title='酷斃了！非看不可'><img src='images_200609/star_y.gif' title='酷斃了！非看不可'><img src='images_200609/star_y.gif' title='酷斃了！非看不可'><img src='images_200609/star_y.gif' title='酷斃了！非看不可'>";
function SHAREAppr(){
                if (http_request.readyState == 4) {
                    if (http_request.status == 200) {
                    	var RTNarr_status=http_request.responseText.substring(0,2);
                    	var RTNarr_text=http_request.responseText.substring(3,http_request.responseText.length);
                    	var RTNarr_text1=RTNarr_text.substring(0,1);
                    	var RTNarr_text2=RTNarr_text.substring(2,RTNarr_text.length);
                      if ("ER"==RTNarr_status){
                      	if (5==RTNarr_text1)
                      		document.getElementById("L_Appr_msg").innerHTML="<font color=red size=2><b>你已經對這個檔產評價過囉！</b></font>";
                      	else if (6==RTNarr_text1)
                      		document.getElementById("L_Appr_msg").innerHTML="<font color=red size=2><b>ops! 不能對自己貢獻的檔產做評價喔！</b></font>";
                      	else if (4==RTNarr_text1)
                      		document.getElementById("L_Appr_msg").innerHTML="<font color=red size=2><b>評價系統錯誤！請稍後再試</b></font>";
                      	else if (7==RTNarr_text1)
                      		document.getElementById("L_Appr_msg").innerHTML="<font color=red size=2><b>ops! 罰單未繳不能幫檔產評價喔！</b></font>";
                      	else
													document.getElementById("L_Appr_msg").innerHTML="<font color=red size=2><b>評價錯誤！請依正常程序評價</b></font>";
			                  return false;
                      } else {
			                  
                      }
                    } else {
											document.getElementById("L_Appr_msg").innerHTML="<font color=red size=2><b>評價系統錯誤！請稍後再試</b></font>";
		                  return false;
                    }
                  
                  if(navigator.appName.indexOf("Explorer") > -1){
										document.getElementById("L_Appr_msg").innerHTML="<font color=red size=2><b>評價成功 </b></font>";
										document.getElementById("L_Appr_msg1").innerHTML="評價："+tmpStar_arr[RTNarr_text1];
										document.getElementById("L_Appr_msg2").innerHTML="("+RTNarr_text2+"個評價)";
                  } else{
										document.getElementById("L_Appr_msg").innerHTML="<font color=red size=2><b>評價成功 </b></font>";
										document.getElementById("L_Appr_msg1").innerHTML="評價："+tmpStar_arr[RTNarr_text1];
										document.getElementById("L_Appr_msg2").innerHTML="("+RTNarr_text2+"個評價)";
                  }
                }
}



/* 原先 Share_Modify.js 合併到此 */

var http_request = false;
var modifyTimer = null;

function makeRequest_ModifySt() {
	http_request = false;
	if (""==document.getElementById("Stitle_new").value){
		alert("請填寫檔產標題");
		document.getElementById("Stitle_new").focus();
		return false;
	}
	ModifySt_Switch("Stitle"); //切換回顯示標題
	document.getElementById("DIV_Stitle").innerHTML="<font color=blue>檔產標題儲存中...</font>";

	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {
			http_request.overrideMimeType('text/xml');
		}
	} else if (window.ActiveXObject) { // IE
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}

	if (!http_request) {
		document.getElementById("DIV_Stitle").innerHTML="<font color=red>對不起！目前系統連線失敗！</font>";
		modifyTimer=window.setTimeout("ModifySt_Undo()",2000);
		return false;
	}
	http_request.onreadystatechange = ModifySt;
	http_request.open('POST', 'sh_AJmodify.php', true);
	http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http_request.send('w=T&id='+document.getElementById('Sid').value+'&con='+document.getElementById('Stitle_new').value);
}
function ModifySt() {
                if (http_request.readyState == 4) {
                    if (http_request.status == 200) {
                    	RTNarr_status=http_request.responseText.substring(0,2);
                    	RTNarr_text=http_request.responseText.substring(3,http_request.responseText.length);
                      if ("ER"==RTNarr_status){
                  			document.getElementById("DIV_Stitle").innerHTML="<font color=red>修改失敗！錯誤代碼："+RTNarr_text+"</font>";
                  			modifyTimer=window.setTimeout("ModifySt_Undo()",2000);
			                  return false;
                      } else {
			                  
                      }
                    } else {
                  		document.getElementById("DIV_Stitle").innerHTML="<font color=red>對不起！目前系統連線失敗！</font>";
                  		modifyTimer=window.setTimeout("ModifySt_Undo()",2000);
		                  return false;
                    }
                  
                  document.getElementById("oldStitle").value=RTNarr_text;
                  if(navigator.appName.indexOf("Explorer") > -1){
                    document.getElementById("DIV_Stitle").innerHTML="<b>"+RTNarr_text+"</b>";
                  } else{
										document.getElementById("DIV_Stitle").innerHTML="<b>"+RTNarr_text+"</b>";
                  }
                }
}

function ModifySt_Undo(){
	document.getElementById("DIV_Stitle").innerHTML="<b>"+document.getElementById("oldStitle").value+"</b>";
	window.clearTimeout(modifyTimer);
}

function makeRequest_ModifySi() {
	http_request = false;
	if (""==document.getElementById("Sintro_new").value){
		alert("請填寫檔產內容");
		document.getElementById("Sintro_new").focus();
		return false;
	}

	ModifySt_Switch("Sintro"); //切換回顯示標題
	document.getElementById("DIV_Sintro").innerHTML="<font color=blue>檔產內容儲存中...</font>"; 
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
                    http_request = new XMLHttpRequest();
                    if (http_request.overrideMimeType) {
                        http_request.overrideMimeType('text/xml');
                    }
                } else if (window.ActiveXObject) { // IE
                    try {
                        http_request = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e) {
                        try {
                        http_request = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (e) {}
                    }
                }

                if (!http_request) {
                  document.getElementById("DIV_Sintro").innerHTML="<font color=red>對不起！目前系統連線失敗！</font>";
                  modifyTimer=window.setTimeout("ModifySi_Undo()",2000);
                  return false;
                }
                http_request.onreadystatechange = ModifySi;
                http_request.open('POST', 'sh_AJmodify.php', true);
                http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                http_request.send('w=C&id='+document.getElementById('Sid').value+'&con='+escape(document.getElementById('Sintro_new').value));
}

function ModifySi(){
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {
			RTNarr_status=http_request.responseText.substring(0,2);
			RTNarr_text=http_request.responseText.substring(3,http_request.responseText.length);
			if ("ER"==RTNarr_status){
				document.getElementById("DIV_Sintro").innerHTML="<font color=red>修改失敗！錯誤代碼："+RTNarr_text+"</font>";
				modifyTimer=window.setTimeout("ModifySi_Undo()",2000);
				return false;
			} else {
			                  
			}
		} else {
			document.getElementById("DIV_Sintro").innerHTML="<font color=red>對不起！目前系統連線失敗！</font>";
			modifyTimer=window.setTimeout("ModifySi_Undo()",2000);
			document.getElementById("DIV_Sintro").innerHTML=document.getElementById("oldSintro").value;
			return false;
		}
                  
		document.getElementById("oldSintro").value=RTNarr_text;
		if(navigator.appName.indexOf("Explorer") > -1){
			document.getElementById("DIV_Sintro").innerHTML=RTNarr_text;
		} else{
			document.getElementById("DIV_Sintro").innerHTML=RTNarr_text;
		}
	}
}

function ModifySi_Undo(){
	document.getElementById("DIV_Sintro").innerHTML=document.getElementById("oldSintro").value;
	window.clearTimeout(modifyTimer);
}


function makeRequest_Modifyvc() {
	http_request = false;
	if (""==document.getElementById("vcode_new").value){
		alert("請填寫外貼碼內容");
		document.getElementById("vcode_new").focus();
		return false;
	}

	ModifySt_Switch("vcode"); //切換回顯示標題
	document.getElementById("DIV_vcode").innerHTML="<font color=blue>外貼碼內容儲存中...</font>"; 
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
                    http_request = new XMLHttpRequest();
                    if (http_request.overrideMimeType) {
                        http_request.overrideMimeType('text/xml');
                    }
                } else if (window.ActiveXObject) { // IE
                    try {
                        http_request = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e) {
                        try {
                        http_request = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (e) {}
                    }
                }

                if (!http_request) {
                  document.getElementById("DIV_vcode").innerHTML="<font color=red>對不起！目前系統連線失敗！</font>";
                  modifyTimer=window.setTimeout("Modifyvc_Undo()",2000);
                  return false;
                }
								
                http_request.onreadystatechange = Modifyvc;
                http_request.open('POST', 'sh_AJmodify.php', true);
                http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                http_request.send('w=V&id='+document.getElementById('Sid').value+'&con='+encodeURIComponent(document.getElementById('vcode_new').value));
}

function Modifyvc(){
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {
			RTNarr_status=http_request.responseText.substring(0,2);
			RTNarr_text=http_request.responseText.substring(3,http_request.responseText.length);
			if ("ER"==RTNarr_status){
				document.getElementById("DIV_vcode").innerHTML="<font color=red>修改失敗！錯誤代碼："+RTNarr_text+"</font>";
				modifyTimer=window.setTimeout("Modifyvc_Undo()",2000);
				return false;
			} else {
			                  
			}
		} else {
			document.getElementById("DIV_vcode").innerHTML="<font color=red>對不起！目前系統連線失敗！</font>";
			modifyTimer=window.setTimeout("Modifyvc_Undo()",2000);
			document.getElementById("DIV_vcode").innerHTML=document.getElementById("oldvcode").value;
			return false;
		}
                  
		document.getElementById("oldvcode").value=RTNarr_text;
		if(navigator.appName.indexOf("Explorer") > -1){
			document.getElementById("DIV_vcode").innerHTML=RTNarr_text;
		} else{
			document.getElementById("DIV_vcode").innerHTML=RTNarr_text;
		}
	}
}

function Modifyvc_Undo(){
	document.getElementById("DIV_vcode").innerHTML=document.getElementById("oldvcode").value;
	window.clearTimeout(modifyTimer);
}


function style_display_on(k) {//因應IE & FF差別
	if (window.ActiveXObject) { // IE 
   		if (1==k) return "block";
     	else if (2==k) return "hand";
     	else return "block";
	} else if (window.XMLHttpRequest) { // Mozilla, Safari,... 
   		if (1==k) return "table-row";
     	else if (2==k) return "pointer";
     	else return "table-row";
	} else {
   		if (1==k) return "block";
     	else if (2==k) return "hand";
		else return "block";
	}
}

function ModifySt_Switch(k) {
	var TR_k = 'TR_'+k;
	var TR_k_form = 'TR_'+k+'_form';
	var k_new = k+'_new';
	var oldk = 'old'+k;
	var tmp_value = document.getElementById(oldk).value;
	if (document.getElementById(TR_k).style.display=='none'){
		document.getElementById(TR_k).style.display=style_display_on(1);
		document.getElementById(TR_k_form).style.display='none';
  	} else { 
		document.getElementById(TR_k).style.display='none';
		document.getElementById(TR_k_form).style.display=style_display_on(1);
		while(true){
      		if (tmp_value.indexOf("<br>")!=-1 || tmp_value.indexOf("<BR>")!=-1){
      			tmp_value = tmp_value.replace("<br>", "\n");
      			tmp_value = tmp_value.replace("<BR>", "\n");
      		} else {
      			break;
      		}
		}
		document.getElementById(k_new).value=tmp_value;
		document.getElementById(k_new).select();
		document.getElementById(k_new).focus();
   	} 
}

function style_MouseOver(k) {
	var TR_k='TR_'+k;
	document.getElementById(TR_k).style.cursor=style_display_on(2);
	if (k=='Stitle')
		document.getElementById(TR_k).style.color='#FF0000';
	else
		document.getElementById(TR_k).style.color='#0000FF';
}
function style_MouseOut(k) {
	var TR_k = 'TR_'+k;
	if(document.getElementById('TABLE_ShareDisplay'))
	{
		document.getElementById('TABLE_ShareDisplay').style.cursor='default';
		document.getElementById(TR_k).style.color='#000000';
	}
}

//----------------------------------------------------------------------------------------
// Add by Chaosrx 07.10.12
//---------------------------------------------------------------------------------------- 
 
function hideEditPDesc() {
	var TR_k = '#aEditPDesc_' + document.getElementById('PDescID').value;  
	document.getElementById('DIV_PDESC_form').style.display = 'none';
	location.href = TR_k;
}

function EditPDesc(k) {
	var TR_k = 'EditPDesc_' + k; 
	document.getElementById('DIV_PDESC_form').style.display = '';

	document.getElementById('PDescID').value = k;
	tmp_value = document.getElementById(TR_k).innerHTML;

	while(true){
		if (tmp_value.indexOf("<br>")!=-1 || tmp_value.indexOf("<BR>")!=-1){
			tmp_value = tmp_value.replace("<br>", "\r\n");
			tmp_value = tmp_value.replace("<BR>", "\r\n");
		} else {
			break;
		}
	} 
	document.getElementById('PDesc_new').value = tmp_value;  
}

function ModifyPDesc() {
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {
			RTNarr_status = http_request.responseText.substring(0, 2);
			RTNarr_text = http_request.responseText.substring(3, http_request.responseText.length);
			if ("ER" == RTNarr_status){
				alert('修改失敗！錯誤代碼：'+RTNarr_text);    
				return false;
			} else {

			}
		} else {
			alert('對不起！目前系統連線失敗！！');  
			return false;
		} 

		var TR_k = 'EditPDesc_' + document.getElementById('PDescID').value; 
		/*
		tmp_value = document.getElementById('PDesc_new').value; 
		while(true){
			if (tmp_value.indexOf("\r\n")!=-1){
				tmp_value = tmp_value.replace("\r\n", "<br>"); 
			} else {
				break;
			}
		}  
		if (navigator.appName.indexOf("Explorer") > -1) { 
			document.getElementById(TR_k).innerHTML = tmp_value;//document.getElementById('PDesc_new').value;
		} else{
			document.getElementById(TR_k).innerHTML = tmp_value;//document.getElementById('PDesc_new').value;
		}
		*/
 
		if(navigator.appName.indexOf("Explorer") > -1){
			document.getElementById(TR_k).innerHTML = RTNarr_text;
		} else{
			document.getElementById(TR_k).innerHTML = RTNarr_text;
		}
		document.getElementById('DIV_PDESC_form').style.display = 'none';
		alert('修改成功！');
		location.href = '#'+TR_k;
	}
}
 
function makeRequest_PDesc() {

	http_request = false;
	var PDesc_new = '';
	var PDescID = '';
	
	PDescID = document.getElementById("PDescID").value;
	PDesc_new = document.getElementById("PDesc_new").value;

	if ("" == PDesc_new) {
		alert("請填寫內容");
		document.getElementById("PDesc_new").focus();
		return false;
	}
	//alert(PDesc_new.length);

	http_request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
/*
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {
			http_request.overrideMimeType('text/xml');
		}
	} else if (window.ActiveXObject) { // IE
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
*/
	if (!http_request) {
		alert('asd對不起！目前系統連線失敗！');  
		return false;
	}
	http_request.onreadystatechange = ModifyPDesc;
	http_request.open('POST', 'sh_AJmodify.php', true);
	http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	var tmp = 'w=P&id='+document.getElementById('Sid').value+'&pid='+PDescID+'&con='+escape(PDesc_new);
	//alert(tmp);
	http_request.send(tmp); 
}



