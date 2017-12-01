(function(){
    
    /*
    A1, B1~B4, BC1, BD1, BD2, C1~C4, K1
    */
    
    var adslotcfg={};
    adslotcfg['index'] = ['BD1', 'BD2', 'K1'];
    adslotcfg['news'] = ['BD1','BD2','C1','C2','B3','B4','K1'];
    adslotcfg['section'] = ['BD1','BD2','C1','C2','K1'];
    adslotcfg['other'] = ['BD1','BD2','C1','C2','K1'];
    
    var adslot = get_now_slot();
    
    function get_now_slot(){
        return (!adslotcfg[pagetype]) ? [] : adslotcfg[pagetype];
    }
    
	var overcount = (function(){
		
		var list = {};
		
		return function(obj){
			var id = obj.slot.b.getDomId();
			if(!list[id]){
				list[id] = 1
			}else{
				list[id] += 1;
			}
			
			return list[id]>3 ? true : false;
		}
		
	})();
	
	
    googletag.cmd.push(function() {
        
        var slots = {};
        $.each(adslot, function(idx, slot){
            if(!addate[pagetype][slot] instanceof Array) return;
            var item = addate[pagetype][slot];
            slots[slot] = googletag.defineSlot(item[0], item[1], 'ad-'+slot).addService(googletag.pubads());
            
        });
        
        googletag.pubads().addEventListener('slotRenderEnded', function(event) {
            
            if (slots['K1'] == event.slot) {
                if (event.isEmpty) {
                    $('#'+event.slot.b.getDomId()).hide();
                }
            }
            
            if (event.isEmpty && pagetype === 'news') {
                
                if(
                    slots['C1'] == event.slot
                    || slots['C2'] == event.slot
                    || slots['B3'] == event.slot
                    || slots['B4'] == event.slot
                    || slots['BD1'] == event.slot
					|| slots['BD2'] == event.slot
                ){
                    if(!overcount(event.slot)) googletag.pubads().refresh([event.slot]);
                }
                
            }
        });
    
        /*RTA Script TOP*/
        if(location.hostname==='news.ltn.com.tw'){
            var crtg_split = (crtg_content || '').split(';');
            var pubads = googletag.pubads();
            for (var i=1;i<crtg_split.length;i++){
                pubads.setTargeting("" + (crtg_split[i-1].split('='))[0] + "", "" + (crtg_split[i-1].split('='))[1] + "");
            }
        }
        /*RTA Script END*/

        googletag.enableServices();
        
        
    });

    $(function(){
        googletag.cmd.push(function() {
            $.each(adslot, function(idx, slot){	
                googletag.display('ad-'+slot);
            });	
        });
    });
    
})();