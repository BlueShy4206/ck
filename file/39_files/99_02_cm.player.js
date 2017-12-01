;(function($, _player) {
  var domainName = window.location.host.split('.');
  //domainName.shift();
  //domainName = '.' + domainName.join('.');
  domainName = domainName.join('.');

  var PLAYER = {};
  //使用的暫存變數名稱
  PLAYER.VAR_NAME = '_player_status';
  PLAYER.REMOTE_FOLDER = '';
  PLAYER.COOKIE_SETTING = {
    path: '/',
    //domain: domainName,
    expires: 1
  };
  //判斷訪問終端
  PLAYER.BROWSER = {
    VERSION: function(){
      var u = navigator.userAgent, app = navigator.appVersion;
      return {
        trident: u.indexOf('Trident') > -1, //IE內核
        presto: u.indexOf('Presto') > -1, //opera內核
        webKit: u.indexOf('AppleWebKit') > -1, //蘋果、谷歌內核
        gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,//火狐內核
        mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否為移動終端
        ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios終端
        android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android終端或者uc瀏覽器
        iPhone: u.indexOf('iPhone') > -1 , //是否為iPhone或者QQHD瀏覽器
        iPad: u.indexOf('iPad') > -1, //是否iPad
        webApp: u.indexOf('Safari') == -1 //是否web應該程序，沒有頭部與底部
      };
    } (),
    LANG: (navigator.browserLanguage || navigator.language).toLowerCase()
  };
  //陣列格式化
  PLAYER.ARRAY_CHUNK = function(input, size, preserve_keys) {
    var x, p = '', i = 0, c = -1, l = input.length || 0, n = [];

    if (size < 1) {
      return null;
    }

    if (Object.prototype.toString.call(input) === '[object Array]') {
      if (preserve_keys) {
        while (i < l) {
          (x = i % size) ? n[c][i] = input[i] : n[++c] = {}, n[c][i] = input[i];
          i++;
        }
      }
      else {
        while (i < l) {
          (x = i % size) ? n[c][x] = input[i] : n[++c] = [input[i]];
          i++;
        }
      }
    }
    else {
      if (preserve_keys) {
        for (p in input) {
          if (input.hasOwnProperty(p)) {
            (x = i % size) ? n[c][p] = input[p] : n[++c] = {}, n[c][p] = input[p];
            i++;
          }
        }
      }
      else {
        for (p in input) {
          if (input.hasOwnProperty(p)) {
            (x = i % size) ? n[c][x] = input[p] : n[++c] = [input[p]];
            i++;
          }
        }
      }
    }
    return n;
  };
  //初始化暫存變數
  PLAYER.VAR_INIT = function() {
    var path = 'div.ProgramBox_Bouncebox > ul > li:first > a';

    if($(path).length > 0) {
      var defaultCurrent = {
            id: $(path).data('id'),
            url: $(path).data('url'),
            text: $(path).data('text'),
            time: 0,
            total: 0
          },
          playerType = $(path).data('func') == 'play-live' ? "liveRtmp" : "rtmp";
    } else {
      var defaultCurrent = {
            id: "",
            url: "",
            text: "",
            time: 0,
            total: 0
          },
          playerType = 'rtmp';
    }

    $.cookie(PLAYER.VAR_NAME, {
      "play": {
        disabled: true,
        hide: false
      },
      "pause": {
        disabled: true,
        hide: true
      },
      "stop": {
        disabled: true,
        hide: false
      },
      "volume": 100,
      "time": 0,
      "event": [],
      "player": false,
      "playerType": playerType,
      "current": defaultCurrent
    }, PLAYER.COOKIE_SETTING);
    $.cookie('playerSlide', false, PLAYER.COOKIE_SETTING);
    $.cookie('playerSeek', 0, PLAYER.COOKIE_SETTING);
  };
  //設定暫存變數
  PLAYER.VAR_SET = function(callback) {
    var json = $.cookie(PLAYER.VAR_NAME),
        data = {};

    for(var k in json) data[k] = callback(json[k], json, k);

    $.cookie(PLAYER.VAR_NAME, data, PLAYER.COOKIE_SETTING);
  };
  //還未有播放的時候狀態
  PLAYER.CHANGE_BTN_STATUS_INIT = function() {
    PLAYER.VAR_SET(function(element, elements, name) {
      if(name == 'pause') {
        element.hide = true;
        element.disabled = true;
      } else if(name == 'play') {
        element.hide = false;
        element.disabled = true;
      } else if(name == 'stop') {
        element.hide = false;
        element.disabled = true;
      }

      return element;
    });
  };
  //按下播放按鈕後狀態改變
  PLAYER.CHANGE_BTN_STATUS_PLAY = function(addEvent, clearPlay) {
    PLAYER.VAR_SET(function(element, elements, name) {
      if(name == 'pause') {
        element.hide = false;
        element.disabled = false;
      } else if(name == 'play') {
        element.hide = true;
        element.disabled = true;
      } else if(name == 'stop') {
        element.hide = false;
        element.disabled = false;
      } else if(typeof addEvent == 'boolean' && addEvent == true && name == 'event') {
        //是否清除現在播放(暫停中的)
        if(typeof clearPlay == 'boolean' && clearPlay == true) element.push('stop');

        element.push('play');
      }

      return element;
    });
  };
  //按下暫停按鈕以後狀態改變
  PLAYER.CHANGE_BTN_STATUS_PAUSE = function(addEvent) {
    PLAYER.VAR_SET(function(element, elements, name) {
      if(name == 'pause') {
        element.hide = true;
        element.disabled = true;
      } else if(name == 'play') {
        element.hide = false;
        element.disabled = false;
      } else if(typeof addEvent == 'boolean' && addEvent == true && name == 'event') {
        element.push('pause');
      }

      return element;
    });
  };
  //按下停止按鈕以後狀態改變
  PLAYER.CHANGE_BTN_STATUS_STOP = function(addEvent) {
    PLAYER.VAR_SET(function(element, elements, name) {
      if(name == 'pause') {
        element.hide = true;
        element.disabled = true;
      } else if(name == 'play') {
        element.hide = false;
        element.disabled = false;
      } else if(name == 'stop') {
        element.hide = false;
        element.disabled = true;
      } else if(typeof addEvent == 'boolean' && addEvent == true && name == 'event') {
        element.push('stop');
      } else if(name == 'current') {
        element.time = 0;
      }

      return element;
    });
  };
  //加入播放的項目
  PLAYER.ADD_PLAY_ITEM = function(item) {
    PLAYER.VAR_SET(function(element, elements, name) {
      if(name == 'current') {
        element.id = item.id;
        element.url = item.url;
        element.text = item.text;
      } else if(name == 'playerType') {
        element = item.playPlugin;
      } else if(name == 'time') {
        if($.isNumeric(item.sec)) {
          element = item.sec / 1000; 
        } else {
          element = 0;
        }
      }

      return element;
    });
  };
  //檢查播放器是否存在
  PLAYER.CHECK_PLAYER_EXISTS = function() {
    var status = $.cookie(PLAYER.VAR_NAME);
    return status.player;
  };
  //檢查是否有現正播放
  PLAYER.CHECK_CURRENT_ITEM_EXISTS = function() {
    var status = $.cookie(PLAYER.VAR_NAME);
    return status.current.url != '' ? true : false;
  };
  //更新Live播放文字
  PLAYER.REFRESH_LIVE_TEXT = function() {
    if(PLAYER.BROWSER.VERSION.ios == false && PLAYER.BROWSER.VERSION.android == false) {
      var status = $.cookie(PLAYER.VAR_NAME);
    
      if(status.playerType == 'liveRtmp') {
        $.ajax({
          url : location.href,
          type : 'post',
          data : {
            "_request": "live_text",
            "live": status.current.id
          },
          dataType : 'json'
        })
        .then(function(data, textStatus, jqXHR) {
          if(data.success == true) {
            PLAYER.VAR_SET(function(element, elements, name) {
              if(name == 'current') element.text = data.text;

              return element;
            });
          }
        }, function(jqXHR, textStatus, errorThrown) {});
      }
    }    
  };
  //跳出播放連結選擇
  PLAYER.SHOW_SELECT_PLAYER_URL = function(id, url, type, iMda_seq) {
    var playLink = [],
        html = '',
        url = url;

    if(type == 'liveRtmp') {
      playLink.push({uText: '播放連結1(HLS)', uLink: 'http://203.64.188.58/live/_definst_/' + url + '/playlist.m3u8?iMda_seq=' + iMda_seq + '-Mdaf_seq=-iUsr_seq=1-iUgp_seq='});
      playLink.push({uText: '播放連結2(RTSP)', uLink: 'rtsp://203.64.188.58/live/_definst_/' + url + '?iMda_seq=' + iMda_seq + '-Mdaf_seq=-iUsr_seq=1-iUgp_seq='});
      //playLink.push({uText: '播放連結1(HLS)', uLink: 'http://203.64.188.58/live/_definst_/' + url + '/playlist.m3u8'});
      //playLink.push({uText: '播放連結2(RTSP)', uLink: 'rtsp://203.64.188.58/live/_definst_/' + url});
    } else {
      //playLink.push({uText: '播放連結1(HLS-MP4)', uLink: 'http://flv.ccdntech.com/vod/_definst_/' + PLAYER.REMOTE_FOLDER + '/' + url + '/playlist.m3u8'});
      //playLink.push({uText: '播放連結2(RTSP-MP4)', uLink: 'rtsp://flv.ccdntech.com/vod/_definst_/' + PLAYER.REMOTE_FOLDER + '/' + url});

      var newFile = url.split('.');
      newFile.pop();
      newFile = newFile.join('.') + '.3gp';

      playLink.push({uText: '播放連結1(HLS)', uLink: 'http://203.64.188.58/vod/_definst_' + PLAYER.REMOTE_FOLDER + '/' + url + '/playlist.m3u8?iMda_seq=' + iMda_seq + '-Mdaf_seq=-iUsr_seq=1-iUgp_seq='});
      playLink.push({uText: '播放連結2(RTSP)', uLink: 'rtsp://203.64.188.58/vod/_definst_' + PLAYER.REMOTE_FOLDER + '/' + url + '?iMda_seq=' + iMda_seq + '-Mdaf_seq=-iUsr_seq=1-iUgp_seq='});
    }

    html += '<div id="' + id + '" class="modal fade" aria-hidden="false">' + 
    '  <div class="modal-dialog">' + 
    '    <div class="modal-content">' + 
    '      <div class="modal-header">' + 
    '        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>' + 
    '        <h4 class="modal-title">請選擇您平板適合的播放方式</h4>' + 
    '      </div>' + 
    '      <div class="modal-body">';
    
    playLink = PLAYER.ARRAY_CHUNK(playLink, 2);

    for(var i in playLink) {
      html += '<div style="margin-top: 10px;" class="row-fluid">';

      for(var j in playLink[i]) html += '<a class="btn btn-default" href="' + playLink[i][j].uLink + '" >' + playLink[i][j].uText + '</a>';
      
      html += '</div>';
    }

    html += '</div>' + 
    '      <div class="modal-footer">' + 
    '      </div>' + 
    '    </div>' + 
    '  </div>' + 
    '</div>';
    /*
    html += '<div id="' + id + '" class="modal hide fade" aria-hidden="false">' +
    '<div class="jump_box">' +
    '  <div class="modal-footer jump_text">' +
    '    <div class="modal-body">' + 
    '      <h4>請選擇您平板適合的播放方式</h4>';

    playLink = PLAYER.ARRAY_CHUNK(playLink, 2);

    for(var i in playLink) {
      html += '<div style="margin-top: 10px;" class="row-fluid">';

      for(var j in playLink[i]) html += '<a class="btn" href="' + playLink[i][j].uLink + '" >' + playLink[i][j].uText + '</a>';
      
      html += '</div>';
    }
        
    html += '      <h4 style="margin-top: 20px;">建議您下載App</h4>' +
    '      <div style="margin-top: 10px;" class="row-fluid">' + 
    '        <a class="btn" href="javascript:;">Rti&nbsp;News</a>' +
    '        <a class="btn" href="javascript:;">Rti&nbsp;Radio</a>' +
    '      </div>' +
    '    </div>' +
    '  </div>' +
    '  <div class="modal-header jump_bg">' +
    '    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="website/tmpl/images/jump_close.png"></button>' +
    '  </div>' +
    '</div></div>';
    */
    if($('#' + id).length > 0) $('#' + id).remove();

    $(html).prependTo('body').on('hidden', function() { $(this).remove(); }).modal({keyboard: false});
  };
  //打開播放器跳出視窗
  PLAYER.OPEN_PLAYER_WINDOW = function() {
    if(PLAYER.BROWSER.VERSION.ios == true) {
      //iOS系統
      //window.open('/player.php?type=ios', 'PlayerIOS');
      var status = $.cookie(PLAYER.VAR_NAME);
      PLAYER.SHOW_SELECT_PLAYER_URL('playerSelectId', status.current.url, status.playerType, status.current.id);
    } else if(PLAYER.BROWSER.VERSION.android == true) {
      //Android系統
      var status = $.cookie(PLAYER.VAR_NAME);
      PLAYER.SHOW_SELECT_PLAYER_URL('playerSelectId', status.current.url, status.playerType, status.current.id);
    } else {
      //一般PC
      window.open('/player.php', 'Player', 'width=300,height=30,toolbar=no,resizable=no,location=no,status=no,menubar=no,scrollbars=no');
      /*
      var os = navigator.platform.toString();

      if(os.search("Mac") != -1 || /chrom(e|ium)/.test(navigator.userAgent.toLowerCase()) == true) {
        window.open('/player.php', 'Player', 'width=300,height=30,top=10000,left=10000,toolbar=no,resizable=no,location=no,status=no,menubar=no,scrollbars=no');
      } else {
        window.aPopunder = [
          ['/player.php', {window: {height: 30, width: 300}}]
        ];
        $.popunder();      
      }
      */
    }
  };
  //取得副檔名
  PLAYER.GET_FILE_EXT = function(filename) {
    return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename) : undefined;
  };
  //取得播放用連結
  PLAYER.GET_ITEM_URL = function(url, type) {
    if(type == 'rtmp') {
      return PLAYER.GET_FILE_EXT(url) + ':' + PLAYER.REMOTE_FOLDER + '/' + url;
    } else {
      return url;
    }
  };
  //播放按鈕事件綁定
  $('body')
    .on('click', '[data-func="play-music"][data-url],[data-func="play-live"][data-url]', function(e) {
      var plugin = $(this).data('func') == 'play-music' ? 'rtmp' : 'liveRtmp',
          plugin = $(this).data('func') == 'play-sound' ? 'http' : plugin;
      PLAYER.ADD_PLAY_ITEM({
        id: $(this).data('id'),
        url: $(this).data('url'),
        text: $(this).data('text'),
        sec: $(this).data('sec'),
        playPlugin: plugin
      });
      PLAYER.REFRESH_LIVE_TEXT();
      
      if(PLAYER.CHECK_PLAYER_EXISTS() == false) {
        PLAYER.OPEN_PLAYER_WINDOW();
      } else {
        PLAYER.CHANGE_BTN_STATUS_PLAY(true, true);
      }
    });

  $.widget('dgfactor.cmPlayer', {
    options: {
      //是否是播放器
      player: false,
      //播放器物件
      playerObj: null,
      //播放器路徑
      playerPath: '',
      //更新狀態的時間
      refreshTime: 1000
    },
    _get_rand_id: function(prefix) {
      return (typeof prefix == 'string' ? prefix + '_' : '') + (new Date().getTime());
    },
    _get_player_status: function() {
      return $.cookie(PLAYER.VAR_NAME);
    },
    _event_play: function() {
      var that = this,
          status = this._get_player_status(),
          url = PLAYER.GET_ITEM_URL(status.current.url, status.playerType);
      PLAYER.CHANGE_BTN_STATUS_PLAY(false);

      url = url + '?iMda_seq=' + status.current.id + '-Mdaf_seq=-iUsr_seq=1-iUgp_seq=';
      
      if(status.playerType == 'liveRtmp') {
        this.options.playerObj.stop();
        this.options.playerObj.play({
          url: url,
          live: true,
          autoBuffering: true,
          bufferLength: 6,
          provider: status.playerType,
          onPause: function(clip) {
            this.stop();
          },
          onResume: function(clip) {
            this.play();
          }
        });
      } else {
        if(this.options.playerObj.isPaused() == true) {
          this.options.playerObj.resume();
        } else {
          this.options.playerObj.stop();
          this.options.playerObj.play({
            autoPlay: false,
            autoBuffering: true,
            bufferLength: 6,
            url: url,
            provider: status.playerType
          });
        }
      }      
    },
    _event_pause: function() {
      this.options.playerObj.pause();
    },
    _event_stop: function() {
      this.options.playerObj.stop();
    },
    _refresh_status: function() {
      var that = this,
          btn = ["play", "pause", "stop"],
          status = this._get_player_status();
      //先檢查有沒有項目可以播放
      if(PLAYER.CHECK_CURRENT_ITEM_EXISTS() == true) { //有正在播放的項目
        if(PLAYER.CHECK_PLAYER_EXISTS() == true) { //播放器存在
          if(this.options.player == true) { //播放器動作
            if(status.event.length > 0) { //檢查是否有事件佇列，有的話抓出來執行
              var func = '';

              PLAYER.VAR_SET(function(element, elements, name) {
                if(name == 'event') func = '_event_' + element.shift();

                return element;
              });

              if($.isFunction(that[func])) that[func]();
            }
            //將暫存上的音量設定到播放器
            that.options.playerObj.setVolume(status.volume);
            //將設定的時間位置設定到播放器
            if($.isNumeric($.cookie('playerSeek')) && $.cookie('playerSeek') > 0) {
              that.options.playerObj.seek($.cookie('playerSeek'));
              $.cookie('playerSeek', 0, PLAYER.COOKIE_SETTING);
            }
            //將播放器取得的秒數設定到暫存
            PLAYER.VAR_SET(function(element, elements, name) {
              if(name == 'current') element.time = parseInt(that.options.playerObj.getTime(), 10);

              return element;
            });
            //更新暫存
            status = this._get_player_status()
          }
        } else { //沒有播放器的狀況
          PLAYER.CHANGE_BTN_STATUS_STOP(false);
        }
        //物件狀態更新
        for(var k in btn) {
          var btnStatus = status[btn[k]],
              jqBtn = $('[data-func="' + btn[k] + '"]', this.element);
          jqBtn.prop('disabled', btnStatus.disabled);

          if(btnStatus.hide == true) {
            jqBtn.hide();
          } else {
            jqBtn.show();
          }
        }
        //顯示資訊到物件上
        $('[data-func="currentVolume"]', this.element).text(status.volume);
        $('[data-func="currentText"]', this.element).text(status.current.text);

        if(status.current.id == '8') {
          console.log($('[data-func="currentText_s"]', this.element));

          $('[data-func="currentText_s"]', this.element).text(status.current.text);
        } else {
          $('[data-func="currentText_s"]', this.element).text('');
        }

        $('[data-func="currentTime"]', this.element).text(status.current.time);

        var jqPlayTime = $('[data-func="playTime"]', this.element);

        if(jqPlayTime.slider('option', 'max') != status.time) jqPlayTime.slider('option', 'max', status.time);

        if($.cookie('playerSlide') == false) jqPlayTime.slider('value', status.current.time);

        $('[data-func="volume"]', this.element).slider('value', status.volume);
      } else { //沒有正在播放的項目
        $('[data-func="currentVolume"]', this.element).text(status.volume);
        $('[data-func="currentText"]', this.element).text('');
        $('[data-func="currentText_s"]', this.element).text('');
        $('[data-func="currentTime"]', this.element).text('0');
        $('[data-func="playTime"]', this.element).slider('value', 0);
        $('[data-func="volume"]', this.element).slider('value', status.volume);
        //將按鈕回歸初始
        PLAYER.CHANGE_BTN_STATUS_INIT();
      }

      $('[data-url].activePlay:not([data-url="' + status.current.url + '"])').removeClass('activePlay');
      $('[data-url="' + status.current.url + '"]:not(.activePlay)').addClass('activePlay');
    },
    _create: function() {
      var that = this;
      that.options = $.extend({}, that.options, that.element.data('options'));
      //預設值
      if(typeof $.cookie(PLAYER.VAR_NAME) == 'undefined') PLAYER.VAR_INIT();

      //載入播放器
      if(that.options.player == true) {
        var playerId = this._get_rand_id('player_cache');
        $('<div id="' + playerId + '" class="player-cache" style="height:30px; margin:0 auto;"></div>').appendTo(this.element);
        this.options.playerObj = _player(playerId, this.options.playerPath + 'flowplayer-3.2.16.swf', {
          onLoad: function() {
            PLAYER.VAR_SET(function(element, elements, name) {
              if(name == 'player') {
                element = true;
              } else if(name == 'event') {
                element.push('play');
              }

              return element;
            });
          },
          onVolume: function(level) {
            PLAYER.VAR_SET(function(element, elements, name) {
              if(name == 'volume') element = parseInt(level, 10);

              return element;
            });
          },
          onBeforeFinish: function() {
            PLAYER.CHANGE_BTN_STATUS_STOP(false);
          },
          onBeforePause: function() {
            PLAYER.CHANGE_BTN_STATUS_PAUSE(false);
          },
          onBeforeResume: function() {
            PLAYER.CHANGE_BTN_STATUS_PLAY(false);
          },
          plugins: {
            rtmp: {
              url: this.options.playerPath + 'flowplayer.rtmp-3.2.12.swf',
              netConnectionUrl: 'rtmp://203.64.188.58/vod',
              durationFunc: 'getStreamLength'
            },
            liveRtmp: {
              url: this.options.playerPath + 'flowplayer.rtmp-3.2.12.swf',
              netConnectionUrl: 'rtmp://203.64.188.58/live'
            },
            controls: {
              fullscreen: false,
              height: 30,
              autoHide: false,
              progressColor: '#68181A',
              backgroundColor: '#222326',
              backgroundGradient: 'none'
            }
          },
          play: null
        });
        //榜入關閉事件
        $(window).unload(function() {
          PLAYER.VAR_SET(function(element, elements, name) {
            if(name == 'player') element = false;

            return element;
          });
        });
      }

      that.element
        .addClass('cm-player');
      //事件綁定
      $('[data-func="play"]', that.element).on('click.cmPlayer', function(e) {
        if(PLAYER.CHECK_CURRENT_ITEM_EXISTS() == true) {
          if(PLAYER.CHECK_PLAYER_EXISTS() == false) {
            PLAYER.OPEN_PLAYER_WINDOW();
          } else {
            PLAYER.CHANGE_BTN_STATUS_PLAY(true);
          }
        }
      });
      $('[data-func="pause"]', that.element).on('click.cmPlayer', function(e) {
        if(PLAYER.CHECK_CURRENT_ITEM_EXISTS() == true) PLAYER.CHANGE_BTN_STATUS_PAUSE(true);
      });
      $('[data-func="stop"]', that.element).on('click.cmPlayer', function(e) {
        if(PLAYER.CHECK_CURRENT_ITEM_EXISTS() == true) PLAYER.CHANGE_BTN_STATUS_STOP(true);
      });
      $('[data-func="volume"]', that.element).slider({
        //range: "min",
        value: 0,
        min: 0,
        max: 100,
        step: 1,
        slide: function( event, ui ) {
          PLAYER.VAR_SET(function(element, elements, name) {
            if(name == 'volume') element = ui.value;

            return element;
          });
        }
      });
      $('[data-func="playTime"]', that.element).slider({
        //range: "min",
        value: 0,
        min: 0,
        max: 0,
        step: 1,
        start: function(event, ui) {
          $.cookie('playerSlide', true, PLAYER.COOKIE_SETTING);
        },
        stop: function(event, ui) {
          setTimeout(function() {
            $.cookie('playerSlide', false, PLAYER.COOKIE_SETTING);
          }, 2000);

          if(PLAYER.CHECK_CURRENT_ITEM_EXISTS() == true && PLAYER.CHECK_PLAYER_EXISTS() == true) {
            $.cookie('playerSeek', ui.value, PLAYER.COOKIE_SETTING);

            PLAYER.VAR_SET(function(element, elements, name) {
              if(name == 'current') element.time = ui.value;

              return element;
            });
          }
        }
      });

      that._refresh_status();
      //定時更新狀態
      setInterval(function() {
        that._refresh_status();
      }, that.options.refreshTime);

      PLAYER.REFRESH_LIVE_TEXT();
      //定時取得Live文字
      setInterval(function() {
        PLAYER.REFRESH_LIVE_TEXT();
      }, 60000);
    },
    destroy: function() {
      this.element
        .removeClass('cm-player')
        .off('cmPlayer');
      $.Widget.prototype.destroy.call(this);
    }
  });
})(jQuery, flowplayer);