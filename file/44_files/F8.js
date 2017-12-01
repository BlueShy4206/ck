	<!--
    //可連上FB時，才載入 FB js
    function FBshow(){ 
			(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.3";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
    }
    //FB connect fail
    function FBhide(){    
        $("img#fbchk").onerror=null; 
    }
    $(function(){
        chkFBpic = '<img id="fbchk" src="https://graph.facebook.com/cnYES/picture" width="0" height="0" style="display:none" onerror="javascript:FBhide()" onload="javascript:FBshow()"/>';
        $("body").append(chkFBpic);
    });

//-->