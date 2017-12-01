$(function(){
	var _showTab = 0;
	var $thisTab = $('ul.iguangNav li.tabs').eq(_showTab);
	$('.iguangPanel').eq($thisTab.index()).siblings().hide();
	
	$('ul.iguangNav li.tabs').click(function(){
		var $this = $(this),
			_index = $this.index();
			
		$this.addClass('current').siblings().removeClass('current');
		$('ul.iguangNav li.tabs:first-child').css("margin-left", 0);
		$('.iguangPanel').eq(_index).stop(true).fadeIn().siblings().hide();
		
		return false;
	}).find('a').focus(function(){
		this.blur();
	});
});