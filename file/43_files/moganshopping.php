
//跳窗廣告輔助程式
  document.write('<img src="http://www.tkec.com.tw/TKRedirectURL.aspx?fromSite=A00060103&redirect=http%3a%2f%2fwww.tkec.com.tw" border="0" width="0" height="0"></img>');

	  
//設定Cookie值   
//expire:指定過期時間,傳入Date物件   
function setCookie(name, value, expire){   
    // 產生 cookie 內容  name=escape(value);expires=exdate   
    document.cookie = name + "=" + escape(value) + ((expire==null) ? "" : ";expires=" + expire)   
}   
  
//取得Cookie值   
function getCookie(name){   
    if (document.cookie.length > 0){   
        var c_list = document.cookie.split("\;");   
        for(i in c_list){           
            var cook = c_list[i].split("=");   
            if(trim(cook[0]) == trim(name))   
                return unescape(trim(cook[1]));   
        }    
    }   
    return '';
}   
    
//去除字串前後空白   
function trim(str) {   
    if(str == null)   
        return '';   
    else  
        return str.replace(/^\s+|\s+$/g, "");   
}  

//=========
if(location.hostname == "iguang.tw" || 
   location.hostname == "top.tkec.com.tw" ||
   location.hostname == "iguang.aptg.com.tw" ||
   location.hostname == "buy.kidshelp.org.tw"){
  document.write('<iframe src="http://www.momoshop.com.tw/main/Main.jsp?&osm=youthwant&ctype=B&cid=youthwant&oid=001&sdiv=youthwant_001&utm_source=youthwant&utm_medium=shop&utm_content=homepage" style="visibility: hidden;" width="10" height="10"></iframe>');
  document.write('<img src="http://www.payeasy.com.tw/ECShop/Forward.jsp?sid=SID_YOUTHWANT&path=http://www.payeasy.com.tw/index.shtml" style="visibility: hidden;" width="10" height="10"></img>');
  document.write('<img src="http://shopping.udn.com/mall/cus/adv/Cc1d01.do?kdid=A06&advKdid=A06-A1&sid=158" style="visibility: hidden;" width="10" height="10"></img>');
  document.write('<img src="http://www.17life.com/ppon/default.aspx?&rsrc=Youth_web" style="visibility: hidden;" width="10" height="10"></img>');
}
if(location.hostname == "buy.sina.com.tw"){
  document.write('<iframe src="http://www.momoshop.com.tw/main/Main.jsp?&osm=sina&ctype=B&cid=sina&oid=001&sdiv=sina_001&utm_source=sina&utm_medium=shop&utm_content=homepage" style="visibility: hidden;" width="10" height="10"></iframe>');
  document.write('<img src="http://www.payeasy.com.tw/ECShop/Forward.jsp?sid=SID_SINA&path=http://www.payeasy.com.tw/index.shtml" style="visibility: hidden;" width="10" height="10"></img>');
  document.write('<img src="http://shopping.udn.com/mall/cus/adv/Cc1d01.do?kdid=A06&advKdid=A06-A1&sid=582" style="visibility: hidden;" width="10" height="10"></img>');
  document.write('<img src="http://www.17life.com/ppon/default.aspx?&rsrc=Youth_web" style="visibility: hidden;" width="10" height="10"></img>');
}
