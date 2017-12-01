var SETTING = {
	CHANGE_INTERVAL: 10000, //シャッフルの間隔
	SLIDE_INTERVAL: 6000//3000    //スライドショーの間隔
};

var GLOBAL = {
	MIN_COLUMN: 3, 
	MAX_COLUMN: 12, 
	
	blockWidth: 216, 
	blockHeight: 216, 
	blockMarginRight: 10, 
	blockMarginBottom: 10, 
	
	isIE: $.browser.msie, 
	isIE6: $.browser.msie && $.browser.version < 7, 
	isIE6to7: $.browser.msie && $.browser.version < 8, 
	isIE6to8: $.browser.msie && $.browser.version < 9
};

GLOBAL.DEBUG = true;

/**
* console.logのラッパー関数
*/
function trace() {
	if(GLOBAL.DEBUG) {
		if(window.console && console.log) {
			console.log.apply(console, arguments);
		}
	}
}


(function($) {


/**
* ブロックを制御するクラスです。
*/
function BlockView() {
}
BlockView.prototype = {
	column: [], 
	width: 0, 
	maxRows: 0, 
	minRows: 0, 
	last: 0, 
	initialize: function(minRows, maxRows) {
		this.minRows = minRows || 0;
		this.maxRows = maxRows || 9999;
	}, 
	reset: function(width) {
		if(width < this.minRows) width = this.minRows;
		else if(this.maxRows < width) width = this.maxRows;
		this.width = Math.floor(width);
		this.column = [];
		this.last = 0;
		var i = this.width;
		while(i--) {
			this.column.push(0);
		}
		return true;
	}, 
	addLine: function() {
		var i = this.width;
		while(i--) this.cells.push(0);
	} , 
	getShortColumnIndexByRank: function(rank) {
		var tmp = this.column.slice();
		tmp.sort(function(a,b) {return a-b;});
		var min = tmp[rank - 1];
		for(var i = 0, l = this.column.length; i < l; i++) {
			if(this.column[i] == min) {
				return i;
			}
		}
		return false;
	}, 
	
	
	getShortColumnIndex: function(width) {
		var _this = this;
		var tmp = this.column;
		var index = (function(rank) {
			var offset = _this.getShortColumnIndexByRank(rank);
			var min = tmp[offset];
			for(var i = 1, l = width; i < l; i++) {
				if(tmp[offset + i] == null || min < tmp[offset + i]) {
					if(rank + 1 <= tmp.length) {
						return arguments.callee.call(this, rank + 1);
					} else {
						return false;
					}
				}
			}
			return offset;
		})(1);
		return index;
	}, 
	
	/**
	 * 指定したサイズが入る最小の位置を取得
	 */
	getPosition: function(width, boxHeight) {
		var shortIndex = this.getShortColumnIndex(width);
		if(shortIndex === false) {
			//return false;
			var longest = 0;
			for(var i = 0, l = width; i < l; i++) {
				longest = Math.max(this.column[i], longest);
			}
			for(var i = 0, l = width; i < l; i++) {
				this.column[i] = longest;
			}
			shortIndex = 0;
		}
		
		var y = this.column[shortIndex];
		var bottom = y + boxHeight + GLOBAL.blockMarginBottom;
		for(var i = 0; i < width; i++) {
			this.column[shortIndex + i] = bottom;
		}
		
		return {
			x: shortIndex, 
			y: y, 
			width: width, 
			height: boxHeight
		}
	}, 
	
	/**
	 * 指定したカラムに入る最小の位置を取得
	 */
	getPositionByColumn: function(x, width, boxHeight) {
		if(x + width > this.column.length) return false;
		var y = 0;
		for(var i = 0; i < width; i++) {
			y = Math.max(y, this.column[x + i]);
		}
		var bottom = y + boxHeight + GLOBAL.blockMarginBottom;
		for(var i = 0; i < width; i++) {
			this.column[x + i] = bottom;
		}
		return {
			x: x, 
			y: y, 
			width: width, 
			height: boxHeight
		}
	}, 
	fill: function(data) {
		var offset = (data.y * this.width) + data.x;
		for(var y = 0, h = data.height; y < h; y++) {
			for(var x = 0, w = data.width; x < w; x++) {
				this.cells[offset + x + (y * this.width)] = 1;
			}
		}
	}, 
	dispose: function() {
		this.column = null;
	}
}


$.initBlock = function(options){
	if(!options) options = {};
	var blockWidth = GLOBAL.blockWidth, 
		blockHeight = GLOBAL.blockHeight, 
		blockMarginX = GLOBAL.blockMarginRight, 
		blockMarginY = GLOBAL.blockMarginBottom, 
		blockMaxRows = 0, 
		items = [], 
		columnWidth = 0, 
		wrapperWidth = 0, 
		containerWidth = 0, 
		containerHeight = 0, 
		headerLeft = 0, 
		containerMarginBottom = 32, 
		windowWidth = 0, 
		
		blockChangeInterval = SETTING.CHANGE_INTERVAL;
	
	$('#main .blockList .block').each(function(i){
		var t = $(this);
		var item = {
			priority: Number(t.attr('data-priority')), 
			width: (function(){
				if(t.hasClass('w1')) return 1;
				if(t.hasClass('w2')) return 2;
				if(t.hasClass('w3')) return 3;
				if(t.hasClass('w4')) return 4;
			})(), 
			height: (function(){
				if(t.hasClass('h1')) return 1;
				if(t.hasClass('h2')) return 2;
				if(t.hasClass('h3')) return 3;
				if(t.hasClass('h4')) return 4;
			})(), 
			x: (function(){
				if(t.hasClass('x0')) return 0;
				if(t.hasClass('x1')) return 1;
				if(t.hasClass('x2')) return 2;
				if(t.hasClass('x3')) return 3;
				return null;
			})(), 
			fixed: t.hasClass('fixed'), 
			html: t
		};
		blockMaxRows = Math.max(item.width, blockMaxRows);
		items[items.length] = item;
		
		/**
		 * SlideShow
		 */
		var $slide = t.find('.slide');
		if($slide.length) {
			$slide.css({
				width: $slide.find('img').width(), 
				height: $slide.find('img').height()
			});
			var slideIndex = 0;
			var $slideTarget = $slide.children('*').css({
					position: 'absolute', 
					top: 0, 
					left: 0
				}).each(function(i) {
				if( i == 0 ) {
					$(this).css({opacity: 1});
				} else {
					$(this).css({opacity: 0});
				}
			});
			setTimeout(function() {
				var intervalId = setInterval(function(){
					var nextIndex = slideIndex + 1;
					if(nextIndex >= $slideTarget.length) nextIndex = 0;
					slideIndex = nextIndex;
					var option = {
						duration: 1000, 
						easing: 'easeOutQuad'
					};
					$slideTarget.each(function(i) {
						if( i == slideIndex ) {
							$(this).animate({opacity: 1}, option);
						} else {
							$(this).animate({opacity: 0}, option);
						}
					});
				}, SETTING.SLIDE_INTERVAL);
			}, Math.random() * SETTING.SLIDE_INTERVAL);
		}
		
		t.css({
			position: 'absolute'
		});
	});
	
	//$('#side').height()
	
	$('.blockList').css({
		height: 0
	});
	$(window).scroll();

	var view = new BlockView();
	view.initialize( blockMaxRows, GLOBAL.MAX_COLUMN );
	
	function shuffle() {
		var shuffled = [];
		for(var i = 0, l = items.length; i < l; i++) {
			var item = items[i];
			if(!item.fixed) shuffled[shuffled.length] = i;
		}
		shuffled = (function(){
			var tmp = shuffled.concat();
			var i = tmp.length;
			while(i){
				var j = Math.floor(Math.random()*i);
				var t = tmp[--i];
				tmp[i] = tmp[j];
				tmp[j] = t;
			}
			return tmp;
		})();
		var tmp = [];
		for(var i = 0, l = items.length; i < l; i++) {
			var item = items[i];
			if(item.fixed) tmp[tmp.length] = item;
			else tmp[tmp.length] = items[shuffled.shift()];
		}
		items = tmp;
	}
	
	function getWindowWidth() {
		return (parseInt(GLOBAL.isIE6 ? $(window).width() : $('body').width()) - 0);
	}
	
	function setPosition() {
		containerHeight = 0;
		if(options.liquid) {
			windowWidth = getWindowWidth();
			columnWidth = Math.max(Math.min( Math.floor((windowWidth + blockMarginX) / (blockWidth + blockMarginX)), GLOBAL.MAX_COLUMN), GLOBAL.MIN_COLUMN);
			wrapperWidth = (columnWidth * (blockWidth + blockMarginX)) - blockMarginX;
		} else {
			wrapperWidth = $('#wrapper').width();
		}
		wrapperWidth = $('.a3').width();
		var stageWidth = wrapperWidth ; // - (blockWidth + blockMarginX);//parseInt($('#main').width());
		//alert();
		view.reset( (stageWidth + blockMarginX) / (blockWidth + blockMarginX), 1 );
		containerWidth = view.width * (GLOBAL.blockWidth + GLOBAL.blockMarginRight) - GLOBAL.blockMarginRight;
		headerLeft = containerWidth + GLOBAL.blockMarginRight;
		var x = 0;
		for(var i = 0, l = items.length; i < l; i++) {
			var item = items[i];
			var itemHeight = item.html.height() + parseFloat(item.html.css('paddingTop')) + parseFloat(item.html.css('paddingBottom'));
			var pos;
			if(options.fill == 'float') {
				if(x + item.width > view.width) {
					x = 0;
				}
				pos = view.getPositionByColumn(x, item.width, itemHeight);
				x += item.width;
				if(x >= view.width) {
					x = 0;
				}
			} else {
				pos = item.x === null ? view.getPosition(item.width, itemHeight) : view.getPositionByColumn(item.x, item.width, itemHeight);
			}
			if(pos === false) {
				item.removed = true;
				item.html.remove();
				continue;
			}
			
			containerHeight = Math.max(pos.y + itemHeight, containerHeight);
			item.position = {
				x: pos.x * (blockWidth + blockMarginX), 
				y: pos.y
			}
		}
		//$('#side').height()
		containerHeight = Math.max(containerHeight, parseInt(0));
	}
	
	function introBlock() {
		var duration = 750, 
			easing = 'easeInOutQuint';
		//$('.container').css({ height: containerHeight });
		$('#wrapper').animate({
			width: wrapperWidth
		}, {
			duration: duration, 
			easing: easing
		});
		//$('#header').css({ marginLeft: headerLeft });
		
		for(var i = 0, l = items.length; i < l; i++) {
			var item = items[i];
			if(item.removed) {
				trace(item);
				continue;
			}
			var option = {
				duration: duration * 2, 
				easing: 'easeOutQuint'
			};
			if(i == 0) {
				setTimeout(function() {
					window.movieStartFlag = true;
				}, duration * 2);
			}
			item.html.stop(false, true).delay(i * 50).css({
				top: item.position.y + containerHeight, 
				left: item.position.x, 
				display: 'block'
			}).animate({
				top: item.position.y
			}, option);
		}
		
		$('.blockList').animate({
			height: containerHeight
		}, {
			duration: duration, 
			easing: easing, 
			step: function() {
				$(window).scroll();
			}
		});
	}
	
	function moveBlock() {
		var duration = 750, 
			easing = 'easeInOutQuint';
			
		if(options.liquid) {
			$('#wrapper').stop().animate({ width: wrapperWidth }, duration, easing);
			//$('#header').stop().animate({marginLeft: headerLeft}, duration, easing);
		}
		for(var i = 0, l = items.length; i < l; i++) {
			var item = items[i];
			
			item.html.stop(false, true).animate({
				top: item.position.y, 
				left: item.position.x
			}, duration, easing);
		}
		var option = {
			duration: duration, 
			easing: easing
		}
		if(options.liquid) {
			option.step = updateSize;
			option.complete = updateSize;
		}
		$('.blockList').animate({
			height: containerHeight + containerMarginBottom
		}, option);
	}
	
	function hideBlock() {
		var duration = 750, 
			easing = 'easeInOutQuint';
		var ri = 0, 
			rl = 0;
		for(var i = 0, l = items.length; i < l; i++) {
			var item = items[i];
			if(item.fixed) continue;
			var $mask = item.html, 
				$inner = $mask.children('*');
			if($mask.get(0).width == null) $mask.get(0).width = $mask.width();
			var delay = Math.random() * 200;
			$mask.stop().delay(delay).animate({
				width: 0
			}, {
				duration: duration, 
				easing: easing, 
				complete: function() {
					if(++rl >= ri) _hideBlockHandler();
				}
			});
			$inner.stop().delay(delay).animate({
				marginLeft: -blockWidth / 3
			}, {
				duration: duration, 
				easing: easing
			});
			ri++;
		}
	}
	
	function _hideBlockHandler() {
		shuffle();
		setPosition();
		showBlock();
	}
	
	function showBlock() {
		var duration = 1000, 
			easing = 'easeInOutQuint';
		if(options.liquid) {
			$('#wrapper').css({ width: wrapperWidth });
		}
		for(var i = 0, l = items.length; i < l; i++) {
			var item = items[i];
			if(item.fixed) continue;
			var $mask = item.html, 
				$inner = $mask.children('*'), 
				delay = Math.random() * 200;
			$mask.stop().delay(delay).animate({
				width: $mask.get(0).width
			}, {
				duration: duration, 
				easing: easing, 
				complete: _showBlockHandler
			});
			$inner.stop().delay(delay).animate({
				marginLeft: 0
			}, {
				duration: duration, 
				easing: easing
			});
			item.html.css({
				top: item.position.y, 
				left: item.position.x
			});
		}
		
		$('.blockList').animate({
			height: containerHeight
		}, {
			duration: duration, 
			easing: easing, 
			step: updateSize, 
			complete: updateSize
		});
	}
	
	function _showBlockHandler() {
		startTimer();
	}
	
	function getItemWidth(item) {
		return (item.width * blockWidth) + ((item.width - 1) * blockMarginX);
	}
	
	function updateSize() {
		var minX = 0;
		var maxX = 0;
		for(var i = 0, l = items.length; i < l; i++) {
			var item = items[i];
			var itemX = parseFloat(item.html.css('left'));
			var itemWidth = getItemWidth(item) + parseFloat(item.html.css('paddingLeft')) + parseFloat(item.html.css('paddingRight'));
			minX = Math.min(itemX, minX);
			maxX = Math.max(itemX + itemWidth, maxX);
		}
		$('.container').css({
			width: maxX - minX
		});
		$(document).scroll();
		$(window).scroll();
	}
	
	if(options.liquid) {
		var resizeId;
		$(window).resize(function() {
			clearTimeout(resizeId);
			var _windowWidth = getWindowWidth();
			if(_windowWidth == windowWidth) return;
			resizeId = setTimeout(function(){
				setPosition();
				moveBlock();
			}, 100);
		});
	}
	
	$(window).load(function(){
		$('html').removeClass('no-js');
		setPosition();
		introBlock();
	});
	
	
	/**
	 * Rotation Timer
	 */
	if(options.shuffle) {
		var changeTimeoutId;
		function startTimer() {
			stopTimer();
			changeTimeoutId = setTimeout(function(){
				hideBlock();
			}, blockChangeInterval);
		}
		function stopTimer() {
			clearTimeout( changeTimeoutId );
		}
		function setupTimer() {
			$('body').mousemove(function(){
				stopTimer();
				startTimer();
			});
			startTimer();
		}
		setupTimer();
	}
	
	
	var $navi = $('#header');
	var naviOffset = parseInt($navi.css('top'));
	$(document).scroll(function(){
		var scrollTop = $(document).scrollTop();
		var scrollLeft = $(document).scrollLeft();
		if(scrollTop > 100) $('#toTop').fadeIn();
		if(scrollTop < 100) $('#toTop').fadeOut();
		
		var windowRest = $(document).height() - $('#footer').height() - 32 - scrollTop;
		var naviBottom = naviOffset + $navi.height();
		if( naviBottom > windowRest ) {
			$navi.css({
				top: naviOffset - (naviBottom - windowRest)
			});
		} else {
			$navi.css({
				top: naviOffset
			});
		}
	}).scroll();
	
	//if(GLOBAL.isIE6) {
		$('a.block').click(function() {
			var t = $(this);
			if(t.attr('target') == "_blank") {
				window.open(t.attr('href'), '_blank');
			} else {
				location.href = t.attr('href');
			}
			return false;
		});
	//}
};


})(jQuery);