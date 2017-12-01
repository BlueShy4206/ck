  var dcminversion = 6;
  var dcmaxversion = 9;
  var plugin = false;
  if ((navigator.appName == "Netscape") && (navigator.userAgent.indexOf("Mozilla") != -1) && (parseFloat(navigator.appVersion) >= 4) && (navigator.javaEnabled()) && navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"] && navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin) {
  var plugname=navigator.plugins['Shockwave Flash'].description;
  var plugsub=plugname.substring(plugname.indexOf("."),-1);
  var plugsubstr=plugsub.substr(-1);
    if( plugsubstr >= dcminversion) { plugin = true;}
  }
  else if (navigator.userAgent && navigator.userAgent.indexOf("MSIE")>=0 && (navigator.userAgent.indexOf("Opera")<0) && (navigator.userAgent.indexOf("Windows 95")>=0 || navigator.userAgent.indexOf("Windows 98")>=0 || navigator.userAgent.indexOf("Windows NT")>=0) && document.all)
  {
    document.write('<script language=VBScript>' + '\n'
      + 'dcmaxversion = '+dcmaxversion + '\n'
      + 'dcminversion = '+dcminversion + '\n'
      + 'Do' + '\n'
        + 'On Error Resume Next' + '\n'
        + 'plugin = (IsObject(CreateObject(\"ShockwaveFlash.ShockwaveFlash.\" & dcmaxversion & \"\")))' + '\n'
        + 'If plugin = true Then Exit Do' + '\n'
          + 'dcmaxversion = dcmaxversion - 1' + '\n'
      + 'Loop While dcmaxversion >= dcminversion' + '\n'
     + '<\/script>');
  }

  var youth_adserver="http://rd.youthwant.com.tw/";
  var youth_cdn="http://rd.youthwant.com/";
  var us=(new Date()).getSeconds();
  var Adblock="";
  var MWRPinnerHTML="";
  var SMWBinnerHTML="";
  if(us<10)
    us="0"+new String(us)+getCookie("youthcook[DS]")+"0"+new String(us);
  else
    us=new String(us)+getCookie("youthcook[DS]")+new String(us);

  function getParamsValue(pname,ParamsStr)
  {
    var Paramsarray=ParamsStr.split("/");
    var returnstr="";
    for(var i=0;i<Paramsarray.length;i++)
    {
    	if(Paramsarray[i].substr(0,pname.length)==pname)
    	{
    		returnstr=Paramsarray[i].substr(pname.length+1,Paramsarray[i].length);
    		break;
    	}
    }
    return returnstr;
  }

  function adqueue(apnum,qnum,pview,adstyle,aptype,adaddr){
      this.apnum=apnum;this.qnum=qnum;this.pview=pview;this.adstyle=adstyle;this.aptype=aptype;this.adaddr=adaddr;
  }

  function adqueue(apnum,qnum,pview,adstyle,aptype,adaddr,bgcolor){
      this.apnum=apnum;this.qnum=qnum;this.pview=pview;this.adstyle=adstyle;this.aptype=aptype;this.adaddr=adaddr;this.bgcolor=bgcolor;
  }

  function adqueue(apnum,qnum,pview,adstyle,aptype,adaddr,bgcolor,afs){
      this.apnum=apnum;this.qnum=qnum;this.pview=pview;this.adstyle=adstyle;this.aptype=aptype;this.adaddr=adaddr;this.bgcolor=bgcolor;this.afs=afs;
  }

  function adqueue(apnum,qnum,pview,adstyle,aptype,adaddr,bgcolor,afs,adstyle2){
      this.apnum=apnum;this.qnum=qnum;this.pview=pview;this.adstyle=adstyle;this.aptype=aptype;this.adaddr=adaddr;this.bgcolor=bgcolor;this.afs=afs;this.adstyle2=adstyle2;
  }

  function getCookie(theName)
  {
  	theName += "=";
	  theCookie = document.cookie+";";
	  start = theCookie.indexOf(theName);
	  if (start != -1)
	  {
		  end = theCookie.indexOf(";",start);
		  return unescape(theCookie.substring(start+theName.length,end));
	  }
	  return 0;
  }

function showYouthAds(YAdsParams,ywadqueue,adblocktype,adbolckpview){
   if(ywadqueue.length>0 || adblocktype == "D")
   {
      var Adwidth=getParamsValue("w",YAdsParams);
      var Adheight=getParamsValue("h",YAdsParams);
      var Adfonttype=getParamsValue("aft",YAdsParams);
      var Adcrazeads=getParamsValue("acs",YAdsParams);
      //var Adflashstyle=getParamsValue("afs",YAdsParams);
      var adrndv=(new Date()).getTime();
      var randvalue=Math.floor(adbolckpview*Math.random());
      var countpview=0;

      for(idx=0;idx<ywadqueue.length;idx++)
      {
        countpview+=ywadqueue[idx].pview;
        if(countpview>=randvalue)
          break;
      }

      if(idx>=ywadqueue.length)
        idx=ywadqueue.length-1;
      //chk if not at blog and qnum=1000029552,then chg it
      //var myReg=new RegExp("blog","ig");
			//var whereami=location.href;
			//if(whereami.match(myReg) == null)
			//{
				//1000029552
				//if(ywadqueue[idx].qnum=="1000029552")
				//{
					//if(idx>=ywadqueue.length)
        		//idx=idx-1;
        	//else if(idx<=ywadqueue.length)
        		//idx=idx+1;
        	//else idx=idx+1;
				//}
			//}
      if(adblocktype=="D") {
         var Adblock=getParamsValue("bk",YAdsParams);
         document.write("<script src=\""+youth_adserver+"scripts/"+Adblock+".js\"></script>\n");
      }
      else if( "G" == ywadqueue[idx].adstyle )
      {
         document.write("<script src=\""+youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".js\"></script>\n");
      }
      else if(adblocktype=="T")
      {
		if( !ywadqueue[idx].bgcolor && !ywadqueue[idx].adstyle2 ){
			if(Adfonttype!="G"){
				if(ywadqueue[idx].afs=="jpg" || ywadqueue[idx].afs=="gif"||ywadqueue[idx].afs=="png" || ywadqueue[idx].afs=="swf" || ywadqueue[idx].afs=="flv"){
					var isIE7 = navigator.userAgent.search("MSIE 7") > -1;
		   			var isIE6 = navigator.userAgent.search("MSIE 6") > -1;
    				if (isIE7 || isIE6) {
			   			document.write("<a href=\""+youth_adserver+"click/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".php?us="+us+"&r="+adrndv+randvalue+"\" class=\"ad\" target=\"_blank\">"+ywadqueue[idx].adaddr+"</a>");
			   		} else {
				   		if(ywadqueue[idx].afs=="flv"){
				   			document.write("<a href=\""+youth_adserver+"click/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".php?us="+us+"&r="+adrndv+randvalue+"\" target=\"_blank\" onmouseover=\"document.getElementById('"+ywadqueue[idx].qnum+"').style.display='inline';document.getElementById('"+ywadqueue[idx].qnum+"').style.top='18px';document.getElementById('"+ywadqueue[idx].qnum+"').style.left='-85px';document.getElementById('"+ywadqueue[idx].qnum+"').style.zIndex='1000';document.getElementById('"+ywadqueue[idx].qnum+"f').SetVariable('player:jsPlay', '');\" style=\"position:relative;\" onmouseout=\"document.getElementById('"+ywadqueue[idx].qnum+"').style.display='none';document.getElementById('"+ywadqueue[idx].qnum+"f').SetVariable('player:jsStop', '');\">"+ywadqueue[idx].adaddr+"<span id=\""+ywadqueue[idx].qnum+"\" style=\"position:absolute;display:none;background:transparent;cursor:hand;z-index:1000;\"><object id=\""+ywadqueue[idx].qnum+"f\" type=\"application/x-shockwave-flash\" data=\"player_flv_multi.swf\" width=\"350\" height=\"200\" style=\"z-index:1000;\"><param name=\"movie\" value=\"player_flv_multi.swf\" /><param name=\"allowFullScreen\" value=\"true\" /><param name=\"FlashVars\" value=\"flv=http%3A//rd.youthwant.com.tw/pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+"_2."+ywadqueue[idx].afs+"&amp;autoload=1&amp;width=350&amp;height=200&amp;showstop=1&amp;showvolume=1&amp;onclick="+youth_adserver+"click/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".php?us="+us+"&r="+adrndv+randvalue+"&amp;onclicktarget=_self&amp;top1=http://topic.youthwant.com.tw/images/a.png|50|0\" /></object></span></a>");
				   		} else if(ywadqueue[idx].afs=="swf"){
				   			document.write("<a id=\""+ywadqueue[idx].qnum+"-ddheader\" onmouseover=\"setTimeout('ddMenu(\\\'"+ywadqueue[idx].qnum+"\\\',1)',1000)\" onmouseout=\"setTimeout('ddMenu(\\\'"+ywadqueue[idx].qnum+"\\\',-1)',1000)\" style=\"position:relative\" href=\""+youth_adserver+"click/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".php?us="+us+"&r="+adrndv+randvalue+"\" target=\"_blank\">"+ywadqueue[idx].adaddr+"<span id=\""+ywadqueue[idx].qnum+"-ddcontent\" onmouseover=\"cancelHide('"+ywadqueue[idx].qnum+"')\" onmouseout=\"ddMenu('"+ywadqueue[idx].qnum+"',-1)\" style=\"position:absolute; overflow:hidden; display:none; z-index:200; opacity:0\"><object type=\"application/x-shockwave-flash\" width=\"300\" height=\"250\"><param name=\"movie\" value=\"http://rd.youthwant.com.tw/pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+"_2.swf\"> <param name=\"wmode\" value=\"opaque\"></object></span></a>");
				   		} else {
				   			document.write("<a href=\""+youth_adserver+"click/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".php?us="+us+"&r="+adrndv+randvalue+"\" target=\"_blank\" onmouseover=\"document.getElementById('"+ywadqueue[idx].qnum+"').style.display='inline';document.getElementById('"+ywadqueue[idx].qnum+"').style.top='18px';document.getElementById('"+ywadqueue[idx].qnum+"').style.left='-15px';document.getElementById('"+ywadqueue[idx].qnum+"').style.zIndex='1000';\" style=\"position:relative;\" onmouseout=\"document.getElementById('"+ywadqueue[idx].qnum+"').style.display='none';\">"+ywadqueue[idx].adaddr+"<span id=\""+ywadqueue[idx].qnum+"\" style=\"position:absolute;display:none;\"><img src=\"http://rd.youthwant.com.tw/pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+"_2."+ywadqueue[idx].afs+"\"></span></a>");
				   		}
				   	}
				} else {
					document.write("<a href=\""+youth_adserver+"click/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".php?us="+us+"&r="+adrndv+randvalue+"\" class=\"ad\" target=\"_blank\">"+ywadqueue[idx].adaddr+"</a>");
				}
			} else {
				document.write("<a href=\""+youth_adserver+"click/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".php?us="+us+"&r="+adrndv+randvalue+"\" target=\"_blank\">"+ywadqueue[idx].adaddr+"</a>");
			}
		} else {
			var Tst="";
			if( ywadqueue[idx].adstyle2 )
				Tst=Tst + "FONT-SIZE:" + ywadqueue[idx].adstyle2 + ";";
			if( ywadqueue[idx].bgcolor )
				Tst=Tst + "color:" + ywadqueue[idx].bgcolor + ";";
			document.write("<a href=\""+youth_adserver+"click/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".php?us="+us+"&r="+adrndv+randvalue+"\" target=\"_blank\" style='"+Tst+"'>"+ywadqueue[idx].adaddr+"</a>");
		}
      }
      else if(adblocktype=="P")
      {
         document.write("<script>window.open(\""+youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".htm\",\"ypad"+ywadqueue[idx].qnum+"\",\"width="+Adwidth+",height="+Adheight+",resizable=no,scrollbars=no\");</script>");
      }
      else if(adblocktype=="S" || adblocktype=="W" || adblocktype=="X" || adblocktype=="Y" ||adblocktype=="Z" || adblocktype=="B" || adblocktype=="A" || adblocktype=="C" || adblocktype=="O" || adblocktype=="R" || adblocktype=="Q" || adblocktype=="U" || adblocktype=="V")
      {
         if(adblocktype=="W")
         {
           document.write("<script src=\""+youth_adserver+"scripts/watermark_right.js\"></script>");
           document.write("<div id=\"Yw_watermark\" name=\"Yw_watermark\" style=\"position:absolute;visibility:visible;\">");
         }
         else if(adblocktype=="X")
         {
           document.write("<script src=\""+youth_adserver+"scripts/watermark_left.js\"></script>");
           document.write("<div id=\"YwL_watermark\" name=\"YwL_watermark\" style=\"position:absolute;visibility:visible;\">");
         }
         else if(adblocktype=="Y")
         {
           document.write("<script src=\""+youth_adserver+"scripts/move_watermark_right.js\"></script>");
           document.write("<div id=\"MWR_idv\" name=\"MWR_idv\" style=\"position:absolute;visibility:visible;\">");
         }
         else if(adblocktype=="Z")
         {
           document.write("<script src=\""+youth_adserver+"scripts/move_watermark_left.js\"></script>");
           document.write("<div id=\"MWL_idv\" name=\"MWL_idv\" style=\"position:absolute;visibility:visible;\">");
         }
         else if(adblocktype=="S")
         {
           document.write("<script src=\""+youth_adserver+"scripts/sp_watermark_right.js\"></script>");
           document.write("<div id=\"Yw_watermark_sp\"  name=\"Yw_watermark_sp\" style=\"position:absolute;visibility:hidden;\">");
         }
         else if(adblocktype=="V")
         {
           document.write("<script src=\""+youth_adserver+"scripts/mt_watermark_right.js\"></script>");
           document.write("<div id=\"Ymtw_watermark\" name=\"Ymtw_watermark\" style=\"position:absolute;visibility:visible;\">");
         }
         else if(adblocktype=="Q")
         {
           MWRCsrc1=youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr;
           //MWRCsrc2=youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr.substr(0,10)+"_2"+ywadqueue[idx].adaddr.substr(10,4);
           if( ywadqueue[idx].adstyle2=="A" )
             MWRCsrc2=youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr.substr(0,10)+"_2.gif";
           else if( ywadqueue[idx].adstyle2=="H" )
             MWRCsrc2=youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr.substr(0,10)+"_2.jpg";
           document.write("<script>function MWRChange(svar){document.ywadsrc.src=svar;}</script>")
           document.write("<div id=\"MWRC_idv\" name=\"MWRC_idv\" onMouseOver=\"MWRChange(MWRCsrc2)\" onMouseOut=\"MWRChange(MWRCsrc1)\" style=\"position:absolute;visibility:visible;\">");
         }
         else if( adblocktype=="R" || adblocktype=="U" )
         {
           var RUinnerHTML="";
       	   if( ywadqueue[idx].adstyle2=="A" )
       	     RUinnerHTML="<a href=\""+youth_adserver+"click/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".php?us="+us+"&r="+adrndv+randvalue+"\" target=\"_blank\"><img src=\""+youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr.substr(0,10)+"_2.gif\" border=0 alt=\"click here!\"></a>";
       	   else if( ywadqueue[idx].adstyle2=="H" )
       	     RUinnerHTML="<a href=\""+youth_adserver+"click/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".php?us="+us+"&r="+adrndv+randvalue+"\" target=\"_blank\"><img src=\""+youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr.substr(0,10)+"_2.jpg\" border=0 alt=\"click here!\"></a>";
           else if( ywadqueue[idx].adstyle2=="B")
           {
             RUinnerHTML="<OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0'  width='60' height='90'>";
             RUinnerHTML+="<PARAM NAME=movie VALUE='"+youth_adserver+"scripts/f60x902.swf?adserver="+youth_adserver+"&apnum="+ywadqueue[idx].apnum+"&qnum="+ywadqueue[idx].qnum+"'>";
             RUinnerHTML+="<PARAM NAME=quality VALUE=high>";
             RUinnerHTML+="<PARAM NAME='allowScriptAccess' VALUE='always'>";
             //RUinnerHTML+="<PARAM NAME=wmode VALUE=Opaque>";
             //RUinnerHTML+="<PARAM NAME='wmode' value='transparent'>";
             //RUinnerHTML+="<PARAM NAME=bgcolor VALUE=#FFFFFF>";
             //RUinnerHTML+="<EMBED allowScriptAccess='always' src='"+youth_adserver+"scripts/f60x902.swf?adserver="+youth_adserver+"&apnum="+ywadqueue[idx].apnum+"&qnum="+ywadqueue[idx].qnum+"' quality=high  wmode=Opaque WIDTH='"+Adwidth+"' HEIGHT='"+Adheight+"' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></EMBED>";
             RUinnerHTML+="</OBJECT>";
           }
           else if(ywadqueue[idx].adstyle2=="D")
           {
            	RUinnerHTML="<applet codebase=\""+youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/\" code=\""+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr.substr(0,10)+"_2.class\" WIDTH=\""+Adwidth+"\" HEIGHT=\""+Adheight+"\"></applet>";
           }
           else if(ywadqueue[idx].adstyle2=="C")
           {
             RUinnerHTML="<IFRAME SRC=\""+youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr.substr(0,10)+"_2.htm\" WIDTH='90' HEIGHT='60' frameborder='0' scrolling='no'>請使用Internet Explorer瀏覽器，以便達到最佳效果！ </IFRAME>";
           }

	        if( "R" == adblocktype )
	        {
	            MWRPinnerHTML=RUinnerHTML;
              document.write("<script src=\""+youth_adserver+"scripts/img_move_watermark_right.js\"></script>");
              document.write("<div id=\"MWRP_idv\" name=\"MWRP_idv\" style=\"width:"+Adwidth+";height:"+Adheight+";position:absolute;visibility:hidden;\">");
           }
           else if( "U" == adblocktype )
           {
	            SMWBinnerHTML=RUinnerHTML;
              document.write("<script src=\""+youth_adserver+"scripts/sp_move_watermark_buttom.js\"></script>");
              document.write("<div id=\"SMWB_idv\" name=\"SMWB_idv\" style=\"width:"+Adwidth+";height:"+Adheight+";position:absolute;visibility:hidden;\">");
           }
         }

         if(ywadqueue[idx].adstyle=="A"){
            if(adblocktype!="Q")
	      document.write("<a href=\""+youth_adserver+"click/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".php?us="+us+"&r="+adrndv+randvalue+"\" target=\"_blank\"><img src=\""+youth_cdn+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr+"\" border=0 alt=\"click here!\"></a>");
            else
	      document.write("<a href=\""+youth_adserver+"click/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".php?us="+us+"&r="+adrndv+randvalue+"\" target=\"_blank\"><img name=ywadsrc src=\""+youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr+"\" border=0 alt=\"click here!\"></a>");
         }
         else if(ywadqueue[idx].adstyle=="B")
         {
           if( adblocktype == "A" || adblocktype == "B" || adblocktype == "C" )
              document.write("<div style=\"border: medium none ; margin: 0pt; padding: 0pt; display: block; position: relative; visibility: visible;z-index:9;\">");
           
           document.write("<OBJECT style='z-index:10;position:relative;' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0' WIDTH='"+Adwidth+"' HEIGHT='"+Adheight+"'>");
           
           if( !ywadqueue[idx].afs )
             document.write("<PARAM NAME=movie VALUE='"+youth_adserver+"scripts/f"+Adwidth+"x"+Adheight+".swf?adserver="+youth_adserver+"&apnum="+ywadqueue[idx].apnum+"&qnum="+ywadqueue[idx].qnum+"'>");
           else
             document.write("<PARAM NAME=movie VALUE='"+youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr+"'>");
           document.write("<PARAM NAME=quality VALUE=high>");
           document.write("<PARAM NAME='allowScriptAccess' VALUE='always'>");
           //if( adblocktype == "A" || adblocktype == "B" || adblocktype == "C" )
             document.write("<PARAM NAME=wmode VALUE=transparent>");
           //if( adblocktype=="R" || adblocktype=="U")
           //  document.write("<PARAM NAME='wmode' value='transparent'>");

           if( ywadqueue[idx].bgcolor )
             document.write("<PARAM NAME=bgcolor VALUE='" + ywadqueue[idx].bgcolor + "'>");

           if( !ywadqueue[idx].afs ) {
             //if( adblocktype == "A" || adblocktype == "B" || adblocktype == "C" )
             //   document.write("<EMBED allowScriptAccess='always' src='"+youth_adserver+"scripts/f"+Adwidth+"x"+Adheight+".swf?adserver="+youth_adserver+"&apnum="+ywadqueue[idx].apnum+"&qnum="+ywadqueue[idx].qnum+"' quality=high wmode=Opaque WIDTH='"+Adwidth+"' HEIGHT='"+Adheight+"' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></EMBED>");
             //else
                //document.write("<EMBED style='z-index:10;' allowScriptAccess='always' src='"+youth_adserver+"scripts/f"+Adwidth+"x"+Adheight+".swf?adserver="+youth_adserver+"&apnum="+ywadqueue[idx].apnum+"&qnum="+ywadqueue[idx].qnum+"' quality=high WIDTH='"+Adwidth+"' HEIGHT='"+Adheight+"' wmode='Opaque'  TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></EMBED>");
                document.write("<OBJECT TYPE='application/x-shockwave-flash' data='"+youth_adserver+"scripts/f"+Adwidth+"x"+Adheight+".swf?adserver="+youth_adserver+"&apnum="+ywadqueue[idx].apnum+"&qnum="+ywadqueue[idx].qnum+"' quality=high WIDTH='"+Adwidth+"' HEIGHT='"+Adheight+"'></OBJECT>");
           }
           else {
             //if( adblocktype == "A" || adblocktype == "B" || adblocktype == "C" )
             //  document.write("<EMBED allowScriptAccess='always' src='"+youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr+"' quality=high wmode=Opaque WIDTH='"+Adwidth+"' HEIGHT='"+Adheight+"' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></EMBED>");
             //else
               //document.write("<EMBED style='z-index:10;' allowScriptAccess='always' src='"+youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr+"' quality=high WIDTH='"+Adwidth+"' HEIGHT='"+Adheight+"'  wmode='transparent' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></EMBED>");
               document.write("<OBJECT TYPE='application/x-shockwave-flash' data='"+youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr+"' WIDTH='"+Adwidth+"' HEIGHT='"+Adheight+"'></OBJECT>");
           }
           document.write("</OBJECT>");
           if( adblocktype == "A" || adblocktype == "B" || adblocktype == "C" )
              document.write("</div>");
         }
         else if(ywadqueue[idx].adstyle=="D")
         {
         	document.write("<applet codebase=\""+youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/\" code=\""+ywadqueue[idx].adaddr+"\" WIDTH=\""+Adwidth+"\" HEIGHT=\""+Adheight+"\"></applet>");
         }
         else if(ywadqueue[idx].adstyle=="E")
         {
         	document.write("<a href=\""+youth_adserver+"click/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+".php?us="+us+"&r="+adrndv+randvalue+"\" target=\"_blank\">"+ywadqueue[idx].adaddr+"</a>");
         }
         else if(ywadqueue[idx].adstyle=="C")
         {
         	document.write("<IFRAME SRC=\""+youth_adserver+"pic/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].adaddr+"\" WIDTH='"+Adwidth+"' HEIGHT='"+Adheight+"' frameborder='0' scrolling='no'>請使用Internet Explorer瀏覽器，以便達到最佳效果！ </IFRAME>");
         }

         if(adblocktype=="W" || adblocktype=="X" || adblocktype=="Y" || adblocktype=="Z" || adblocktype=="S" || adblocktype=="R" || adblocktype=="Q" || adblocktype=="U" || adblocktype=="V")
         {
           document.write("</div>");
           if( adblocktype=="Q" )
             document.write("<script src=\""+youth_adserver+"scripts/movechange_watermark_right.js\"></script>");
         }
      }
      else {
      	 var Adblock=getParamsValue("bk",YAdsParams);
         document.write("<script src=\""+youth_adserver+"scripts/"+Adblock+".js\"></script>\n");
      }
      if( adblocktype != "D" )
        document.write("<img src=\""+youth_adserver+"?/"+ywadqueue[idx].apnum.substr(0,8)+"/"+ywadqueue[idx].apnum+"/"+ywadqueue[idx].qnum+"/"+adrndv+randvalue+"\" height=\"0\" width=\"0\" border=\"0\" style=\"display: none;\" >");
   }
  }

  function adspac(YAdsParams)
  {
    var Adsite="";
    YAdsParams2=YAdsParams;
    Adsite=getParamsValue("site",YAdsParams);
    Adblock=getParamsValue("bk",YAdsParams);
    document.write("<script src=\""+youth_adserver+"scripts/"+Adsite+"/"+Adblock+".js\"></script>\n");
  }
var myReg=new RegExp("youthwant","ig");
var whereami=location.href;
if(whereami.match(myReg) == null)
{
	//document.domain="youthwant.com.tw";
	document.domain=location.hostname;
}
var DDSPEED = 10;
var DDTIMER = 15;

// main function to handle the mouse events //
function ddMenu(id,d){
  var h = document.getElementById(id + '-ddheader');
  var c = document.getElementById(id + '-ddcontent');
  clearInterval(c.timer);
  if(d == 1){
    clearTimeout(h.timer);
    if(c.maxh && c.maxh <= c.offsetHeight){return}
    else if(!c.maxh){
      c.style.display = 'block';
      c.style.height = 'auto';
      c.maxh = c.offsetHeight;
      c.style.height = '0px';
    }
    c.timer = setInterval(function(){ddSlide(c,1)},DDTIMER);
  }else{
    h.timer = setTimeout(function(){ddCollapse(c)},50);
  }
}

// collapse the menu //
function ddCollapse(c){
  c.timer = setInterval(function(){ddSlide(c,-1)},DDTIMER);
}

// cancel the collapse if a user rolls over the dropdown //
function cancelHide(id){
  var h = document.getElementById(id + '-ddheader');
  var c = document.getElementById(id + '-ddcontent');
  clearTimeout(h.timer);
  clearInterval(c.timer);
  if(c.offsetHeight < c.maxh){
    c.timer = setInterval(function(){ddSlide(c,1)},DDTIMER);
  }
}

// incrementally expand/contract the dropdown and change the opacity //
function ddSlide(c,d){
  var currh = c.offsetHeight;
  var dist;
  if(d == 1){
    dist = (Math.round((c.maxh - currh) / DDSPEED));
  }else{
    dist = (Math.round(currh / DDSPEED));
  }
  if(dist <= 1 && d == 1){
    dist = 1;
  }
  c.style.height = currh + (dist * d) + 'px';
  c.style.opacity = currh / c.maxh;
  c.style.filter = 'alpha(opacity=' + (currh * 100 / c.maxh) + ')';
  if((currh < 2 && d != 1) || (currh > (c.maxh - 2) && d == 1)){
    clearInterval(c.timer);
  }
}
