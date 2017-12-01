
(function(){

	var OneMinute = 1000 * 60;
	var OneHour = 60 * OneMinute;
	var OneDay = 24 * OneHour;

	var OnTime = function(y, m ,d){
		var now=new Date();
		var dt1=new Date(y, (m-0)*1-1, d, 12);
		var dt2=new Date();
		dt2.setTime(dt1.getTime() + OneDay);

		return (now>=dt1 && now<dt2) ? true : false;

	}

	googletag.cmd.push(function () {
		var IsFireFox = false;
		if (navigator.userAgent.indexOf('Firefox')>=0){IsFireFox=true;}
		if(IsFireFox){$('.door-left-head, .door-right-head').height(130);}
		
		$('.door-top-close').on('click.close', function(e){
			$('#door-top-over').hide();
		});
		
		$('.door-home-close').on('click.close', function(e){
			$('#door-home-over').hide();
		});
		
		/*門簾*/
		var D1;
		var D2;
		var SM2;
		if(location.hostname=='news.ltn.com.tw'){
		
			D1 = googletag.defineSlot('/21202031/00-ltn-home-doorcurtain-left', [150, 600], 'door-left').addService(googletag.pubads());
			D2 = googletag.defineSlot('/21202031/00-ltn-home-doorcurtain-right', [150, 600], 'door-right').addService(googletag.pubads());
			
		}else if(location.hostname=='www.ltn.com.tw'){
			
			D1 = googletag.defineSlot('/21202031/01-ltn-news-doorcurtain-left', [150, 600], 'door-left').addService(googletag.pubads());
			D2 = googletag.defineSlot('/21202031/01-ltn-news-doorcurtain-right', [150, 600], 'door-right').addService(googletag.pubads());
			SM2 = googletag.defineSlot('/21202031/sizmek-richmedia-sub', [1, 1], 'sizmek-sub').addService(googletag.pubads());
			
		}
		
		googletag.pubads().addEventListener('slotRenderEnded', function(event) {
			if (event.isEmpty) { return; }
			
		});
		
		/*RTA Script TOP*/
		var crtg_split = (crtg_content || '').split(';');
		var pubads = googletag.pubads();
		for (var i=1;i<crtg_split.length;i++){
			pubads.setTargeting("" + (crtg_split[i-1].split('='))[0] + "", "" + (crtg_split[i-1].split('='))[1] + "");
		}
		/*RTA Script END*/
		
        googletag.enableServices();
    });

    $(document).ready(function () {
        googletag.cmd.push(function () {
			if(OnTime(2015, 11, 25) || OnTime(2015, 11, 26) || OnTime(2015, 11, 27)){
				googletag.display('door-left');
				googletag.display('door-right');
			}
			
			if(OnTime(2015, 6, 1)){
				googletag.display('sizmek-sub');
			}
			
        });
    });
	
})();
