(function (jQ){

	var $ = jQ;
	var share = $(".share");
	
	if(!share){return console.log('no obj');}
	if(share.length<2){return console.log('obj len');}
	
	var obj = share.eq(1); //jQ('#community');
	var obj2 = share.eq(0); //jQ('.content');
	
	var objW = obj.width();
	var objH = obj.height();
	var objT = obj.offset().top;
	var objMB = obj.css("margin-bottom");
	
	fixPos();
	$(window).scroll(function () {
		fixPos();
	}).resize(function(){
		fixPos();
	});

	function fixPos(){
		var win = $(window);
		var winW = win.width();
		var winH = win.height();
		var winT = win.scrollTop();
		var winL = win.scrollLeft();
		var objL = obj2.offset().left;
		
		var fix = objT-winH+objH;
		
		if(winT>fix){
		
			obj.removeAttr("style");
		
		}else{
			obj.css({
				"background-color": "white",
				"position": "fixed",
				"z-index": "80",
				"bottom": "0px",
				"margin-bottom": "0",
				"padding-bottom": "5px",
				"padding-top": "5px",
				"width": objW+"px",
				"left": (winL==0)? "auto":(objL-winL)+"px"
			});
		}
	}
})(jQuery);