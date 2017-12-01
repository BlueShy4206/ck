;(function($, cm) {
  $(function() {
   $('input, textarea').placeholder();
  });

  $("a").focus(function() {
    $(this).blur();
  });

  if($('div.global_pop_alert').length > 0) {
    $('div.global_pop_alert')
      .on('show.bs.modal', function(e) {

      })
      .on('shown.bs.modal', function(e) {
        
      })
      .on('hidden.bs.modal', function() {
        $('div.global_pop_alert').remove();
      })
      .modal({
        keyboard: false,
        show : true
      });
  }
  
  //menu
  $(window).on('scroll', function() {  
    var _scrollVal = $(this).scrollTop(),
        _menuBox = $('div.navbar-responsive-collapse.fixedMenu', 'div.header');
    
    if(_scrollVal > 100 && $(window).width() > 1024) {
      //_menuBox.css({"position": "fixed", "top": "0", "width": "100%", "margin": "0", "display": "block !important"});
      _menuBox.css({"display": "block"});
    } else {
      //_menuBox.css({"position": "relative", "margin": "5px 0 0", "display": "none !important"});
      _menuBox.css({"display": "none"});
    }
  });
  
  //banner輪播
  window.onload = function() {
    $('[data-cmfunc=flexslider]').each(function() {
      $(this).fadeIn();
      $(this).flexslider({
        animation: "slide",
        directionNav: $(this).data('hasdirectionnav') == '1' ? true : false,
        controlNav: $(this).data('controlnav') == '1' ? true : false,
        namespace: '',
        selector: ".slides > div.item",
        pauseInvisible: false,
        pauseOnAction: false,
        slideshowSpeed: 5000,
        //manualControls: ".carousel-indicators li"
      });
    });
  }
  
  $('div.cm-player')
    .cmPlayer($(this).data('options'))
    .on('click', '.ProgramBox_Btn, .ProgramBox_txt', function() {
      var that = this,
          jqParent = $(that).parents('div.ProgramBox'),
          jqBtn = $('.ProgramBox_Btn', jqParent),
          jqBox = $('div.ProgramBox_Bouncebox', jqParent);

      if(jqBtn.hasClass('ProgramBox_Btn_down')) {
        //打開狀態
        jqBox.animate({height: '0px'}, 'fast', function() {
          jqBtn.removeClass('ProgramBox_Btn_down');
        });
      } else {
        //關閉狀態
        jqBox.animate({height: ($('li', jqBox).length * 40) + 'px'}, 'fast', function() {
          jqBtn.addClass('ProgramBox_Btn_down');
        });
      }
    });
  
  //player embed
  $('[data-cmfunc=musicPlay]', 'body').each(function() {
    var dataid = $(this).data('id'),
        playerId = $(this).attr('id'),
        videoUrl = $(this).attr('href'),
        rtmp = $(this).data('rtmp'),
        hls = $(this).data('hls'),
        webversion = $(this).data('webversion');

    if($(this).data('provider') == '1') {
      var clip = {
        provider: $(this).data('provider') == '1' ? 'rtmp' : 'http',
        url: 'mp4:' + videoUrl,
        autoPlay: true,
        autoBuffering: true,
        scaling: 'fix'
      };
    } else {
      var clip = {
        url: videoUrl,
        autoPlay: true,
        autoBuffering: true,
        scaling: 'fix'
      };
    }
    
    if(webversion == 'mobile') {
      $(this).on('click', function() {
        window.open(hls);
      });
    } else {
      $f(playerId, {
          src: "http://releases.flowplayer.org/swf/flowplayer.commercial-3.2.18.swf",
          wmode: 'transparent'
        }, {
          //key: '#$6646c0118cc4b9157ea',
          clip: clip,
          plugins: {
            controls: {
              volume: true,
              stop: true
            },
            rtmp: {
              url: "flowplayer.rtmp-3.2.13.swf",
              netConnectionUrl: rtmp
            },
            controls: {
              autoHide: false,
              fullscreen:false,
              stop:true
            }
          },
          onLoad: function() {
            //console.log(this.getTime());
          },
          onStart: function(clip, info) {
            
          },
          canvas: {
            // remove default canvas gradient
            backgroundGradient: 'none',
          }
        });
    }
  });
  
  //播放bar
  var jqBroadcastBox = $('li.Broadcast'),
      jqPlayBar = $('div.cm-player', jqBroadcastBox);
  
  if($.cookie('_playBar') == undefined) $.cookie('_playBar', false, {path: '/'});

  if($.cookie('_playBar') == true) {
    jqPlayBar.fadeIn();
    $('a', jqBroadcastBox).addClass('open');
  }
  jqBroadcastBox
    .on('click', 'a', function() {
      if($('a', jqBroadcastBox).attr('class') == 'open') {
        jqPlayBar.fadeOut();
        $('a', jqBroadcastBox).removeClass('open');
        $.cookie('_playBar', false, {path: '/'});
      } else {
        jqPlayBar.fadeIn();
        $('a', jqBroadcastBox).addClass('open');
        $.cookie('_playBar', true, {path: '/'});
      }
    });
  //QRcode
  var jqQRcodeBox = $('li.QRcode'),
      jqQRcodeImgBax = $('div.qrcode-box', jqQRcodeBox);

  jqQRcodeBox
    .on('click', 'a', function() {
      if($('a', jqQRcodeBox).attr('class') == 'open') {
        jqQRcodeImgBax.fadeOut();
        $('a', jqQRcodeBox).removeClass('open');
      } else {
        jqQRcodeImgBax.fadeIn();
        $('a', jqQRcodeBox).addClass('open');
      }
    });
  
  //click統計
  $('body')
    .on('click', '[data-cmfunc=click_statistics][data-id][data-dao]', function() {
      $.ajax({
        url : location.href,
        type : 'post',
        data : {
          "_request": "click_statistics",
          "dao": $(this).data('dao'),
          "data_id": $(this).data('id')
        },
        dataType : 'json'
      })
      .then(function(data, textStatus, jqXHR) {
        
      }, function(jqXHR, textStatus, errorThrown) {

      });
    });
  
  //更換字體大小
  if($.cookie('_fontSize') == undefined) $.cookie('_fontSize', 'medium', {path: '/'});

  if($.cookie('_fontSize') != undefined) {
    $('#fontsize').attr('href', 'website/tmpl/css/fontsize_' + $.cookie('_fontSize') + '.css');
  }
  $('div.topbar .Text-Size')
    .on('click', '[data-cmfunc="textSize"]', function() {
      $('#fontsize').attr('href', 'website/tmpl/css/fontsize_' + $(this).data('cmdata') + '.css');
      $.cookie('_fontSize', $(this).data('cmdata'), {path: '/'});
    });
})(jQuery, window._cm)