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