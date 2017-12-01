cont = '' +

      '<section class="ad_carousel_box clear-fix">' +
      '  <div class="headpic clear-fix">' +
      '        <div id="ad-carousel">' +
      '      <div class="ad-carousel-player">' +
      '            <ul class="ad-carousel-list">' +
      '          <li class="set">' +
      '                <ul class="page">' +
      '              <li>' +
      '                    <div class="kind">女人心事</div>' +
      '                    <div class="subtitle"><a href="http://photo.chinatimes.com/20151221003141-260803" rel="nofollow" target="_blank">她假扮性工作者站櫥窗8小時</a></div>' +
      '                    <div class="title"><a href="http://photo.chinatimes.com/20151221003141-260803" rel="nofollow" target="_blank">真相竟是...</a></div>' +
      '                  </li>' +
      '              <li>' +
      '                    <div class="kind">恐怖！</div>' +
      '                    <div class="subtitle"><a href="http://tube.chinatimes.com/20151221003020-261412 " rel="nofollow" target="_blank">俄羅斯大樓遭縱火恐多死</a></div>' +
      '                    <div class="title"><a href="http://tube.chinatimes.com/20151221003020-261412 " rel="nofollow" target="_blank">在逃嫌犯的身分讓人毛骨悚然</a></div>' +
  
      '                  </li>' +
      '            </ul>' +
      '              </li>' +
      '          <li class="set">' +
      '                <ul class="page">' +
      '              <li>' +
     '                    <div class="kind">純真童心</div>' +
      '                    <div class="subtitle"><a href="http://tube.chinatimes.com/20151221003134-261411" rel="nofollow" target="_blank">電視台要送禮物給低收入戶孩子</a></div>' +
      '                    <div class="title"><a href="http://tube.chinatimes.com/20151221003134-261411" rel="nofollow" target="_blank">卻讓所有孩子面有難色</a></div>' +
      '                  </li>' +
      '              <li>' +
      '                    <div class="kind">報時國中</div>' +
      '                    <div class="subtitle"><a href="http://quiz.chinatimes.com/20151218003895-320201" rel="nofollow" target="_blank">哪一家手機製造商</a></div>' + 
      '                    <div class="title"><a href="http://quiz.chinatimes.com/20151218003895-320201" rel="nofollow" target="_blank">今年遭德國法院發佈禁售令？</a></div>' +
      '                  </li>' +
      '            </ul>' +
      '              </li>' +
      '          <li class="set">' +
      '                <ul class="page">' +
      '              <li>' +
   '                    <div class="kind">娛樂線上</div>' +
      '                    <div class="subtitle"><a href="http://photo.chinatimes.com/20151221003032-260806" rel="nofollow" target="_blank">她為他懷孕生子</a></div>' +
      '                    <div class="title"><a href="http://photo.chinatimes.com/20151221003032-260806" rel="nofollow" target="_blank">他卻給不了她想要的結局</a></div>' +
      '                  </li>' +
      '              <li>' +
  '                    <div class="kind">好康！</div>' +
      '                    <div class="subtitle"><a href="https://business.facebook.com/events/1019771641397464/" rel="nofollow" target="_blank">快來留言按讚</a></div>' +
      '                    <div class="title"><a href="https://business.facebook.com/events/1019771641397464/" rel="nofollow" target="_blank">超豐富好書大放送</a></div>' +
      '                  </li>' +
      '            </ul>' +
      '              </li>' +
      '        </ul>' +
      '          </div>' +
      '      <div class="ad-carousel-control">' +
      '            <ul class="arrows">' +
      '          <li class="prev">&lt;</li>' +
      '          <li class="next">&gt;</li>' +
      '        </ul>' +
      '          </div>' +
      '    </div>' +
      '      </div>' +
      '</section>';

$(".nav-below").after(cont);
//document.write(cont); 

$(function () {
    var $block = $('#ad-carousel'),
        $slides = $block.find('ul.ad-carousel-list'),
        _width = $block.width(),
        $li = $slides.find('li.set'),
        $control = $block.find('.ad-carousel-control'),
        _animateSpeed = 600;
    if (winWidth > 767) {
        $slides.css('width', ($li.length + 1) * _width);
    } else {
        $slides.css('width', '100%');
    }
    var _str = '';
    var _selectMum = Math.floor(Math.random() * $li.length) ;  

    for (var i = 0, j = $li.length; i < j; i++) {
        _str += '<li class="carousel-player-control_' + (i + 1) + '">' + (i + 1) + '</li>';
    }
    var $number = $('<ul class="numbers"></ul>').html(_str).appendTo($control),
        $numberLi = $number.find('li');
    $numberLi.click(function () {
        var $this = $(this);
        $this.addClass('current').siblings('.current').removeClass('current');
        $slides.stop().animate({
            left: _width * $this.index() * -1
        }, _animateSpeed);
        return false;
    }).eq(_selectMum).click();
    $control.find('ul.arrows li').click(function () {
        var _index = $numberLi.filter('.current').index();
        $numberLi.eq((this.className.indexOf('next') > -1 ? _index + 1 : _index - 1 + $numberLi.length) % $numberLi.length).click();
        return false;
    });
    $control.find('li').hover(function () {
        $(this).addClass('hover');
    }, function () {
        $(this).removeClass('hover');
    });
})

var arrWatermark = [
'<div class="ad_watermark"><a href="http://goo.gl/mllXOS" target="_blank"><img src="http://www.chinatimes.com/Images/2015122101.jpg"/></a></div>'];
var _adMum = Math.floor(Math.random() * arrWatermark.length);
$("div.wrapper").append(arrWatermark[_adMum]);