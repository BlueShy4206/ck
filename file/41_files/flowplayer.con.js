/**STARTS
 * Protect window.console method calls, e.g. console is not defined on IE
 * unless dev tools are open, and IE doesn't define console.debug
 */
(function() {
  if (!window.console) {
    window.console = {};
  }
  // union of Chrome, FF, IE, and Safari console methods
  var m = [
    "log", "info", "warn", "error", "debug", "trace", "dir", "group",
    "groupCollapsed", "groupEnd", "time", "timeEnd", "profile", "profileEnd",
    "dirxml", "assert", "count", "markTimeline", "timeStamp", "clear"
  ];
  // define undefined methods as noops to prevent errors
  for (var i = 0; i < m.length; i++) {
    if (!window.console[m[i]]) {
      window.console[m[i]] = function() {};
    }    
  } 
})();
/**ENDS
 * Protect window.console method calls, e.g. console is not defined on IE
 * unless dev tools are open, and IE doesn't define console.debug
 */
//	sample player setup
var videoUrl;
var playListArray = new Array();
var html5playlist = new Array();
var bwPlayListArray = new Array();
var playlist_count;
var video_count;

var isAdPlay = false;
var playlist_index;
var playlist_total;
var iPad_url;
var iPad_ipadUrl;
var akamaiLiveStreamClip = new Array();
var normalLiveStreamClip = new Array();
var mp3StreamClip;
var iPadLiveStreamClip;

var initialimage_url;
var buttonColor;
var emailSubject;
var isFacebook;
var isTwitter;
var globalADurl;
var isAndroid;
var isLive = false; 
var isflash = navigator.plugins['Shockwave Flash'];  
//Detect html5 start
	var mobile = (/iphone|ipad|ipod|android|blackberry|xbox|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));
	if (mobile) {
		var userAgent = navigator.userAgent.toLowerCase();
        var ischrome=userAgent.search("chrome");
        var isfirefox=userAgent.search("firefox");
        var isapplewebkit=userAgent.search("applewebkit");
        var isoperamobi=userAgent.search("operamobi");
		var isxbox=userAgent.search("xbox");
		
		if (userAgent.search("android") > -1){
            
			var androidversion = parseFloat(userAgent.slice(userAgent.indexOf("android")+8));
				 if (!isflash||((androidversion >= 4.0)&&((ischrome > -1)||(isfirefox > -1)||(isapplewebkit > -1)||(isoperamobi > -1))))	 
				{
					var html5enable = true;
					 isAndroid = true;
				 }
		}else if ((userAgent.search("iphone") > -1)||(userAgent.search("ipod") > -1)||(userAgent.search("ipad") > -1)){
				  var html5enable = true;
		}else if (userAgent.search("xbox") > -1){
				  var html5enable = true;
				  isAndroid = true;
		}else{
				  var html5enable = false;
		}
	}
//Detect html5 ends
//---- start of viral video functions ----
function viralSetParam(key, value) {
	viral_setting[key]=value;
}
function viralSetShareInfo(key, value) {
	viral_setting['share'][key]=value;
}
function viralSetTitleAndDescription(title, description) {
	viralSetShareInfo('title', title);
	viralSetShareInfo('description', description);
}
// ---- end of viral video functions ----
function setIPadLiveStreamClip(live_url, ipad_url, adTagUrl) {
	var adTagUrl_encoded = adTagUrl;
	var new_clip = {
		'url': live_url,
		'ipadUrl': ipad_url,
		'autoPlay': player_autoPlay,
		'live': true
	};
	iPadLiveStreamClip = new_clip;
}
var Player = {
	create: function (id) {
            var div = document.createElement('div');
            div.id = 'sw-wrapper';
			div.style.cssText = 'height:100%';
			
			var cchn=player_width.indexOf("%");
			var imgunit="px";
			if (cchn!=-1){
			imgunit="%";
			player_height=player_width.replace("%","");
			player_width=player_height.replace("%","");
			
			}			
 if (initialimage_url == null || initialimage_url == "" || isAndroid) {
                div.innerHTML = '<div class="flow_player" id="flow_player" style="position:relative;background-color: #000;color:#ffffff; width: ' + player_width + imgunit+'; height: ' + player_height + imgunit+';"></div>';
            } else {
                div.innerHTML = '<div class="flow_player" id="flow_player" style="position:relative;background-color: #000;color:#ffffff; width: ' + player_width + imgunit+'; height: ' + player_height + imgunit+';">'+
                    '<img class="uvpimg" id="uvpimg" src="' + initialimage_url + '" alt="Initial Image" style=" width: 100%; height: 100%;z-index:3" />'+
                    '<img class="uvpimgarrow" id="uvpimgarrow" src="http://twimg.edgesuite.net/appledaily/images/core/play_large.png" alt="Play Button Image" style="position:absolute; top:45%;left:45%;z-index:4" />'+'</div>';
            }
	
            if(document.getElementById(id)){
                document.getElementById(id).appendChild(div);
            }else{
                document.body.appendChild(div);
            }
		
	},
	
	open: function () {
		
		if (player_streamMethod != 7) {
			var device = navigator.platform;
			if (html5enable) {
				switch (player_streamMethod) {
				case 2:
					mp3StreamingInit();
					break;
				case 4:
				// akamaiLiveStreaming
					iPadLiveStreamInit();
					break;
				default:
					iPadPlaylistInit();
					break;
				}
			} else {
				switch (player_streamMethod) {
					case 1:
						normalStreamingInit();
						break;
					case 2:
						mp3StreamingInit();
						break;
					case 3:
						rtmpStreamingInit();
						break;
					case 4:
					// akamaiLiveStreaming
						akamaiStreamingInit();
						break;
					case 5:
						pseudoStreamingWithBWCheck();
						break;
					case 6:
						rtmpStreamingWithBWCheck();
						break;
					default:
						break;
						
				}
			}
		} else {
			if (html5enable) {
				iPadLiveStreamInit();
			} else {
				normalLiveStreamInit();
			}
		}
		
	},
	
	getPlayerState: function () {
		var state = $f("flow_player").getState();
		var stateString;
		
		switch (state) {
			case -1:
				stateString = "unloaded";
				break;
			case 0:
				stateString = "loaded";
				break;
			case 1:
				stateString = "unstarted";
				break;
			case 2:
				stateString = "buffering";
				break;
			case 3:
				stateString = "playing";
				break;
			case 4:
				stateString = "paused";
				break;
			case 5:
				stateString = "ended";
				break;
			default:
				break;
		}
		
	},
	
	getPlayerVolume: function () {
		var volumeString = $f("flow_player").getVolume();
	},
	
	controlPlay: function () {
		$f("flow_player").resume();
	},
	
	controlPause: function () {
		$f("flow_player").pause();
	},
	controlStop: function () {
		$f("flow_player").stop();
	},
	
	setPlayerVolume: function (volume) {
		$f("flow_player").setVolume(volume);
	},
	
	setVideoTime: function (time) {
		$f("flow_player").seek(time);
	},
	
	seekVideo: function (videoID) {
	console.log(videoID);
		$f("flow_player").play(videoID);
	},
	
	setStreamingMethod: function(type) {
		player_streamMethod = type;
	},
	
	setRTMPServer: function(url) {
		player_RTMPServer = url;
	},
	
	setSmilUrl: function(url) {
		player_smilUrl = url;
	},
	
	setSharing: function(overColor, subject, facebook, twitter) {
		buttonColor = overColor;	//overColor
		emailSubject = subject;		//subject
		isFacebook = facebook;		//facebook
		isTwitter = twitter;		//twitter
	},

	getVideoIndex: function () {
		var indexString = $f("flow_player").getClip().index;
		return indexString;
	},
	setOverLayAD: function (adhtmlimg, adhtmlurl) {	
	    
	    overlayadIMG=adhtmlimg;
	    overlayadURL=adhtmlurl;
	},
	checkIsiPad: function() {
		return isiPad =/(iphone|ipad|pod)/ig.test(navigator.platform);
	},
	
	setInitialImage: function(image_url) {
		initialimage_url = image_url;
	}
	
}
var Playlist = {
	
	addVideo: function (url) {
		var index = -1;
		index++;	
		playListArray[index] = url;
	},
	
	setPlayList: function (list) {
		playListArray = list;
		playlist_index = 0;
		playlist_total = playListArray.length;
	},
	
	setAkamaiLiveStreamPath: function (live_url, iPad_url, adTagUrl,android_url) {
	     isLive=true;
        globalADurl = adTagUrl;
        if(isAndroid && android_url!=null)iPad_url=android_url;
        akamaiLiveStreamClip = [
            {
                'live' : true,
                'autoPlay': player_autoPlay,
                'provider': 'akamai',
                'stopLiveOnPause': false,
                'autoBuffering': player_autoBuffering,
                'scaling': player_scaling,
                'url': live_url,
                'ads': null
            }
        ];
        setIPadLiveStreamClip(live_url, iPad_url, adTagUrl);
    },
        
	setMP3StreamClip: function (mp3_url, coverImage_url,adTagUrl) {
	   video_count=readCookie("viewCount");
	   if (video_count == null || video_count == 0) {
			playlist_count = player_videoCountForAd;
			video_count = 0;
		} else {
			playlist_count = video_count;
		}	
        globalADurl = adTagUrl;
  	    mp3StreamClip ={
			'autoPlay': player_autoPlay,
			'autoBuffering': player_autoBuffering,
			'url': mp3_url,
			'coverImage': { url: coverImage_url,scaling: 'orig' }
            }        
    },	
		
	setNormalLiveStreamPath: function (live_url, ipad_url, adTagUrl) {
		globalADurl = adTagUrl;
		
		normalLiveStreamClip = [
		{
			'autoPlay': player_autoPlay,
			'autoBuffering': player_autoBuffering,
			'scaling': player_scaling,
			'url': live_url,
			'ads': null
		}];
		setIPadLiveStreamClip(live_url, ipad_url, adTagUrl);
	},
	
	setiPadLiveStreamPath: function (live_url, ipad_url, adTagUrl) {
		setIPadLiveStreamClip(live_url, ipad_url, adTagUrl);
	},
	
	adInClip: function (list, adTagUrl) {
		var old_clip;
		var new_clip;
		var new_list = new Array();
		
		video_count=readCookie("viewCount");
		if (video_count == null || video_count == 0) {
			playlist_count = player_videoCountForAd;
			video_count = 0;
		} else {
			playlist_count = video_count;
		}	
        globalADurl = adTagUrl;		
		
			for (x=0;x<list.length;x++) {
				old_clip = list[x].url;
				new_clip = { 'autoPlay': player_autoPlay,
					'autoBuffering': player_autoBuffering,
					'scaling': player_scaling,
					'url': old_clip,
					'ads': null
				};
				new_list[x] = new_clip;	
				html5playlist[x] = old_clip;
			}
		
		return new_list;
	}
}
function createEventLogger(type) {	var evt = document.createEvent('Event');	evt.initEvent(type, true, true);	document.dispatchEvent(evt);
	/*
	if (type == "onAdReady") {
		isAdPlay=true;
	} else if (type == "onAdUnloaded") { 
		isAdPlay=false;
	}
	*/
	return function() {
		//console.error("Got event "+ type, arguments);
		//console.info("Got event "+ type);
	}
	
}
// jl
// 20120824
var isAdPlayAfterSet=false;
var adplayAfter=null;
function AdPlayAfter_set(tInMilliSecond) {
	//alert('time to play AD1');
	AdPlayAfter_reset();	
	if ((!isAdPlayAfterSet)&&(tInMilliSecond>=0)) {
		adplayAfter=setTimeout(function() {
			//alert('time to play AD2');
			getswf('flow_player_api').playAD(globalADurl);
			AdPlayAfter_reset();
		},
		tInMilliSecond);
		isAdPlayAfterSet=true;
	}
}
function AdPlayAfter_set_WithVideoNoSound(tInMilliSecond) {
    AdPlayAfter_reset();    
    if ((!isAdPlayAfterSet)&&(tInMilliSecond>=0)) {
        adplayAfter=setTimeout(function() {
            playADWithVideoNoSound();
            AdPlayAfter_reset();
        },
        tInMilliSecond);
        isAdPlayAfterSet=true;
    }
}
function AdPlayAfter_reset() {/*
	if (adplayAfter!=null) {
		clearTimeout(adplayAfter);
		adplayAfter=null;
	}*/
}
var pushedVolume=-1;
function playADWithVideoNoSound() {
	pushedVolume = $f("flow_player").getVolume();
    $f("flow_player").setVolume(0);
    getswf('flow_player_api').playAD(globalADurl);
}
function restorePushedVolume() {
	if (pushedVolume!=-1) {
		$f("flow_player").setVolume(pushedVolume);
	}
}

function onBeforeBegin_checkAndPlayAD() {
    var tempADcount=player_videoCountForAd;
    if (video_count == tempADcount) {
        video_count = 0;
    }
    var tmpTimePlayADAfter=player_playAdAfterTime;
	
    if ( ((video_count == 0)||(video_count == tempADcount)|| (typeof(video_count) =="undefined")) && (tmpTimePlayADAfter<0) ) {                            
       if (globalADurl!="")
	   getswf('flow_player_api').playAD(globalADurl);                        
        //alert('isAdPlay= '+isAdPlay);                            
    }
}
function onBegin_checkAndPlayAD() {
    var tmpTimePlayADAfter=player_playAdAfterTime;
    switch (player_streamMethod) {
    default:
        AdPlayAfter_set(tmpTimePlayADAfter);
        break;
    }
}
function onStart_checkAndPlayAD() {
    var tmpTimePlayADAfter=player_playAdAfterTime;
    switch (player_streamMethod) {
    case 4:
        AdPlayAfter_set_WithVideoNoSound(tmpTimePlayADAfter);
        break;
    default:
        AdPlayAfter_set(tmpTimePlayADAfter);
        break;
    }
    /*
		StrategyInterface.prototype.getContentType = function() { return StrategyInterface.ContentType.AD;}//Chartbeat
		try{ 		  
	     StrategyInterface.prototype.getAdPosition = function() { return StrategyInterface.AdPosition.PREROLL;}
		}
		catch (ex) {}			
		*/
}
function g_getPlayerViewThroughString(info) {
	var name=info.name;
	var time_sec=info.time_sec;
	var duration_sec=info.duration_sec;
	
	if (name==="1%") {
		name="0%";
		time_sec=0;
	}
	else if (name==="99%") {
		name="100%";
		time_sec=duration_sec;
	}
	var tmpStr="playerviewthrough";
	tmpStr+="-";
	tmpStr+=name;
	
	tmpInfo=info.time_sec;
	tmpStr+=",";
	tmpStr+=time_sec;
	
	tmpInfo=info.duration_sec;
	tmpStr+=",";
	tmpStr+=duration_sec;
	
	return tmpStr;
}
function normalStreamingInit() {
	var cues = [];
	$f("flow_player", flowplayer_plugin_url, {
		
		key: player_key,
        logo: '',
		
		playlist: playListArray,
		
		debug : false,
		
		plugins: {
			controls: controls_setting,
			
			//sharing: sharing_setting,
			//viral: viral_setting,//disable for FB sharing
	  			
			dock: dock_setting,
            dfp: {
                url: dfp_plugin_url,
                linearAdLabel: linearAdLabel_setting,
                skipAdButton : skipButtonSetting,
                adVolumeBar : adVolumeBarSetting,
                isLive : true,
                debug : player_debug,
                onAdLoaded:     function(){createEventLogger("onAdLoaded");},
                onAdReady:      function() {isAdPlay=true; createEventLogger("onAdReady");},
                onAdError:      function(){createEventLogger("onAdError");},
                onAdUnloaded:   function() {restorePushedVolume(); isAdPlay=false; createEventLogger("onAdUnloaded");},
                adStarted:      function(){createEventLogger("adStarted");},
                adFirstQuartile:function(){createEventLogger("adFirstQuartile");},
                adMidpoint:     function(){createEventLogger("adMidpoint");},
                adThirdQuartile:function(){createEventLogger("adThirdQuartile");},
                adCompleted:    function(){createEventLogger("adCompleted");}
            },			
										
			advertisementLabel: advertisementLabel_setting
			
		},
		onMetaData: function() {
			var c=this.getClip();
			var fd = c.duration;
			// Chartbeat
			try{
				StrategyInterface.prototype.isReady = function() {return true;}
				StrategyInterface.prototype.getTotalDuration = function () {return Math.round(fd*1000);}
			}
			catch (ex) {}
			
			var tmpCount=0;
			cues = [
		        {
					idx: tmpCount++,
				    time: fd * .01 * c.cuepointMultiplier,
				    time_sec: Math.round(fd * .01),
				    duration_sec: Math.round(fd),
				    name: "1%",
				    called: false
				},
	            {
					idx: tmpCount++,
	                time: fd * .25 * c.cuepointMultiplier,
	                time_sec: Math.round(fd * .25),
				    duration_sec: Math.round(fd),
	                name: "25%",
	                called: false
	            },
	            {
					idx: tmpCount++,
	                time: fd * .50 * c.cuepointMultiplier,
	                time_sec: Math.round(fd * .50),
				    duration_sec: Math.round(fd),
	                name: "50%",
	                called: false
	            },
	            {
					idx: tmpCount++,
	                time: fd * .75 * c.cuepointMultiplier,
	                time_sec: Math.round(fd * .75),
				    duration_sec: Math.round(fd),
	                name: "75%",
	                called: false
	            },
	            {
					idx: tmpCount++,
	                time: fd * .99 * c.cuepointMultiplier,
	                time_sec: Math.round(fd * .99),
				    duration_sec: Math.round(fd),
	                name: "99%",
	                called: false
	            }
	        ];
	        c.onCuepoint(cues,
	            // each integer represents milliseconds in the timeline cues,
	            // this function is triggered when a cuepoint is reached
	            function(clip, cuepoint) {
	        		var idx=cuepoint.idx;
	        		if (cues[idx].called==false) {
	        			//console.log("progress: " + cuepoint.name+", time_sec: "+cuepoint.time_sec+", duration_sec: "+cuepoint.duration_sec);
	        			cues[idx].called=true;
	        			var tmpStr=g_getPlayerViewThroughString(cuepoint);
	        			playerStateChanged(tmpStr);
	        		}
	            }
	        );
	    },
		onBeforeBegin : function(){				
			     playerStateChanged("onBeforeBegin");
			     //getswf('flow_player_api').playAD(globalADurl);	
						var tempADcount=player_videoCountForAd;
						if (video_count == tempADcount) {
							video_count = 0;
						}
						//alert('video_count= '+video_count+'       tempADcount= '+tempADcount);
						if ((video_count == 0)||(video_count == tempADcount)) {							
							
							getswf('flow_player_api').playAD(globalADurl);	
										
							//alert('isAdPlay= '+isAdPlay);							
						}				
			
			
			var index = Player.getVideoIndex();
			getPlaylistIndex(index);
			playerStateChanged("onBeforeBegin");
      		onBeforeBegin_checkAndPlayAD();
			try{		
					StrategyInterface.prototype.getVideoPath = function() {
					return currentClip.completeUrl;
					}//Chartbeat
				 }
				 catch (ex) {}	      
      
		},
		onBegin : function(){	
			var c=this.getClip();
			var fd = c.duration;
			try{		
                		StrategyInterface.prototype.isReady = function() {return true;}//chartbeat			  
				StrategyInterface.prototype.getTotalDuration = function () {return Math.round(fd*1000);}//chartbeat
			  }		
         	catch (ex) {}	
			onBegin_checkAndPlayAD();			
		    setControlBar();	
		},						
		onLoad: function(){
					
			try{	
				StrategyInterface.prototype.getState = function() { return StrategyInterface.VideoState.UNPLAYED;}//Chartbeat
			
			}	
			catch (ex) {}					
	    var tempADcount=player_videoCountForAd;
			if (video_count == tempADcount) {
			    video_count = 0;
			    
			}
			
		},
		
		onStart: function () {
      try{				
					StrategyInterface.prototype.getContentType = function() {return StrategyInterface.ContentType.CONTENT;}//Chart beat
					StrategyInterface.prototype.getState = function() { return StrategyInterface.VideoState.PLAYED;}//Chartbeat
				  }
				  catch (ex) {}	  			
			//var index = Player.getVideoIndex();
			//getPlaylistIndex(index);
			StrategyInterface.prototype.getAdPosition = function() { return "NA";}
			playerStateChanged("onStart");		
			
			video_count++;
      setViewCountCookie("viewCount", video_count);
      onStart_checkAndPlayAD();                  
			     
      setControlBar();
 
		},
		
		onFinish: function() {
			
			var tempADcount=player_videoCountForAd;
			if (video_count == tempADcount) {
			    //alert('video_count='+video_count+'player_videoCountForAd='+tempADcount);
				video_count = 0;
				setViewCountCookie("viewCount", video_count);	
			}
			
			//var index = Player.getVideoIndex();
			if (playlist_total==1) {
				$f("flow_player").stop();
			}
			playerStateChanged("onFinish");	
			try{	
			 StrategyInterface.prototype.getState = function() {return StrategyInterface.VideoState.COMPLETED;};//Chartbeat
      }
			 catch (ex) {}				
			
			AdPlayAfter_reset();
		},
		
		onResume: function() {
			playerStateChanged("onResume");
		},
		
		onPause: function() {
			//console.log("[onPause]");
			  try{	
			   StrategyInterface.prototype.getState = function() {return StrategyInterface.VideoState.STOPPED;};//Chartbeat
			  }
			  catch (ex) {}				
			playerStateChanged("onPause");
		},
		
		onStop: function () {
			//console.log("[onStop]");
			  try{			
			   StrategyInterface.prototype.getState = function() {return StrategyInterface.VideoState.STOPPED;};//Chartbeat
        }
			  catch (ex) {}				
			playerStateChanged("onStop");
		},
		onError: function () {
			playerStateChanged("onError");
	        html5ErrorDisplay('An error occurred, please try again later.');		
		},		
		onVolume: function () {
			var volume = $f("flow_player").getVolume();
			playerVolumeChanged(volume);
		},
		
		onMute: function () {
			playerVolumeChanged("onMute");
		},
		
		onUnmute: function () {
			playerVolumeChanged("onUnmute");
		},
		
		onFullscreen: function () {
			playerStateChanged("onFullscreen");
		},
		
		onFullscreenExit: function () {
			playerStateChanged("onFullscreenExit");
		}
		
	});
	
	// get a handle to the player just installed and call it's method "getVersion"
	$f("flow_player").getVersion();
	
	// loop through all players on the page
	$f("*").each(function() {
		
	});
	
}
function akamaiStreamingInit() {
    var isOnStart;
    
    $f("flow_player", flowplayer_plugin_url, {
        
        key: player_key,
                logo: '',
        
        playlist: akamaiLiveStreamClip,
        
        plugins:  {              	                        
            controls: {
                url: flowplayer_cccontrol,
                playlist: false,
                stop: false,
                scrubber: true,
                autoHide: player_controlbar_autohide,
                background: '#000000'
            },
            
            
             //viral: viral_setting,//disable for FB sharing
            dock: dock_setting,
            
            dfp: {
                url: dfp_plugin_url,
                linearAdLabel: linearAdLabel_setting,
                skipAdButton : skipButtonSetting,
                adVolumeBar : adVolumeBarSetting,
                isLive : true,
                debug : player_debug,
                onAdLoaded:     function(){createEventLogger("onAdLoaded");},
                onAdReady:      function() {isAdPlay=true; createEventLogger("onAdReady");},
                onAdError:      function(){createEventLogger("onAdError");},
                onAdUnloaded:   function() {restorePushedVolume(); isAdPlay=false; createEventLogger("onAdUnloaded");},
                adStarted:      function(){createEventLogger("adStarted");},
                adFirstQuartile:function(){createEventLogger("adFirstQuartile");},
                adMidpoint:     function(){createEventLogger("adMidpoint");},
                adThirdQuartile:function(){createEventLogger("adThirdQuartile");},
                adCompleted:    function(){createEventLogger("adCompleted");}
            },
            
            akamai: akamaiplugin_setting,
            
            advertisementLabel: advertisementLabel_setting
        },
        
        onLoad: function(){
        	
        },
        onBeforeBegin : function(){
        	$f("flow_player").setVolume(50);
            playerStateChanged("onBeforeBegin");
            onBeforeBegin_checkAndPlayAD();            
        },    
        onStart: function () {
            //$f("flow_player").play(0);
			if(isAndroid&&(androidversion >= 4.0)){
				 $f("flow_player").stopBuffering();
			     window.open($f("flow_player").getClip().completeUrl,'_self');
			}else{
            playerStateChanged("onStart");
			}
            onStart_checkAndPlayAD();
            
            setControlBar();
            
            isOnStart = true;
        },
        
        onFinish: function() {
            playerStateChanged("onFinish");
            AdPlayAfter_reset();
        },
        
        onResume: function() {
            if (!isOnStart) {
                playerStateChanged("onResume");
            } else {
                isOnStart = false;
            }
        },
        
        onPause: function() {
            playerStateChanged("onPause");
        },
        
        onStop: function () {
            playerStateChanged("onStop");
        },
        onError: function () {
            playerStateChanged("onError");
			html5ErrorDisplay('An error occurred, please try again later.');
        },        
        onVolume: function () {
            var volume = $f("flow_player").getVolume();
            playerVolumeChanged(volume);
        },
        
        onMute: function () {
            playerVolumeChanged("onMute");
        },
        
        onUnmute: function () {
            playerVolumeChanged("onUnmute");
        },
        
        onFullscreen: function () {
            playerStateChanged("onFullscreen");
        },
        
        onFullscreenExit: function () {
            playerStateChanged("onFullscreenExit");
        }
        
    });
}
function iPadPlaylistInit() {
	var isOnStart;
	$f("flow_player", flowplayer_plugin_url, {
	
		key: player_key,
				logo: '',
		clip: {
			autoPlay: player_autoPlay,
			autoBuffering: player_autoBuffering
		},
		
		playlist: playListArray,
		/*
		// show playlist buttons in controlbar
		plugins:  {
			controls: controls_setting
		},
		*/
		onLoad: function(){
			if(isAndroid){
				 webkitplayer("video/mp4",$f("flow_player").getClip().completeUrl);
				 $f("flow_player").stop();
			}else{
		    	var indexString = html5playlist.indexOf($f("flow_player").getClip().completeUrl);			   
				getPlaylistIndex(indexString);
				 playerStateChanged("onLoad");	
			
			}
		},
	
		onStart: function () {
			if(isAndroid){
				 webkitplayer("video/mp4",$f("flow_player").getClip().completeUrl);
				 $f("flow_player").stop();
			}else{			
							
		    	//var indexString = html5playlist.indexOf($f("flow_player").getClip().completeUrl);			   
				//getPlaylistIndex(indexString);
				 playerStateChanged("onStart");	
                isOnStart = true;
			}	
		},
		
		onFinish: function() {
			playerStateChanged("onFinish");
		},
		
		onResume: function() {
			if (!isOnStart) {
				playerStateChanged("onResume");
			} else {
				isOnStart = false;
			}
		},
		
		onPause: function() {
			if(isAndroid){
				 $f("flow_player").stopBuffering();			 
			}else{
			playerStateChanged("onPause");
			}
		},
		
		onStop: function () {
			playerStateChanged("onStop");
		},
		onError: function () {
			playerStateChanged("onError");
			html5ErrorDisplay('An error occurred, please try again later.');			
		},			
		onVolume: function () {
			var volume = $f("flow_player").getVolume();
			playerVolumeChanged(volume);
		},
		
		onMute: function () {
			playerVolumeChanged("onMute");
		},
		
		onUnmute: function () {
			playerVolumeChanged("onUnmute");
		},
		
		onFullscreen: function () {
			playerStateChanged("onFullscreen");
		},
		
		onFullscreenExit: function () {
			playerStateChanged("onFullscreenExit");
		}
		
	}).ipad({ simulateiDevice: false, controls: true, posterimg: initialimage_url });
}

function normalLiveStreamInit() {
	var isOnStart;
	
	$f("flow_player", flowplayer_plugin_url, {
	
		key: player_key,
				logo: '',
		
		//clip: normalLiveStreamClip,
		
		playlist: normalLiveStreamClip,
		
		plugins:  {
			//controls: controls_setting,
			controls: {
				url: flowplayer_cccontrol,
				playlist: false,
				stop: false,
				scrubber: true,
				autoHide: player_controlbar_autohide,
				background: '#000000'
			},
			        
			
	
			//sharing: sharing_setting,
			//viral: viral_setting,//disable for FB sharing
			
			dock: dock_setting,
			
			dfp: {
				url: dfp_plugin_url,
				linearAdLabel: linearAdLabel_setting,
				skipAdButton : skipButtonSetting,
				adVolumeBar : adVolumeBarSetting,
				isLive : true,
				debug : player_debug,
				//onStateChanged: createEventLogger("onStateChanged"),
				//onAdScheduled:  createEventLogger("onAdScheduled"),
				onAdLoaded:     function(){createEventLogger("onAdLoaded");},
				onAdReady:      function() {isAdPlay=true; createEventLogger("onAdReady");},
				onAdError:      function(){createEventLogger("onAdError");},
				onAdUnloaded:   function() {isAdPlay=false; createEventLogger("onAdUnloaded");},
                adStarted:      function(){createEventLogger("adStarted");},
                adFirstQuartile:function(){createEventLogger("adFirstQuartile");},
                adMidpoint:     function(){createEventLogger("adMidpoint");},
                adThirdQuartile:function(){createEventLogger("adThirdQuartile");},
                adCompleted:    function(){createEventLogger("adCompleted");}
			},
			
			advertisementLabel: advertisementLabel_setting
		},
		
		
		onLoad: function(){
		    var tempADcount=player_videoCountForAd;
				if (video_count == tempADcount) {
			    video_count = 0;
			    try{		
						StrategyInterface.prototype.getVideoPath = function() {
						return currentClip.completeUrl;
						}//Chartbeat
				 	}
				 	catch (ex) {};	
				}						
		},
    onBeforeBegin : function(){
			playerStateChanged("onBeforeBegin");			
			onBeforeBegin_checkAndPlayAD();						
		},	
		onStart: function () {
				playerStateChanged("onStart");						
				onStart_checkAndPlayAD();			
				setControlBar();			
				isOnStart = true;
		
		},
		
		onFinish: function() {
			playerStateChanged("onFinish");
			AdPlayAfter_reset();
		},
		
		onResume: function() {
			if (!isOnStart) {
				playerStateChanged("onResume");
			} else {
				isOnStart = false;
			}
		},
		
		onPause: function() {
			playerStateChanged("onPause");
			$f("flow_player").stopBuffering();
			
		},
		
		onStop: function () {
			playerStateChanged("onStop");
		},
		onError: function () {
			playerStateChanged("onError");
			html5ErrorDisplay('An error occurred, please try again later.');			
		},		
		onVolume: function () {
			var volume = $f("flow_player").getVolume();
			playerVolumeChanged(volume);
		},
		
		onMute: function () {
			playerVolumeChanged("onMute");
		},
		
		onUnmute: function () {
			playerVolumeChanged("onUnmute");
		},
		
		onFullscreen: function () {
			playerStateChanged("onFullscreen");
		},
		
		onFullscreenExit: function () {
			playerStateChanged("onFullscreenExit");
		}
		
	});
}
function mp3StreamingInit() {
	var isOnStart;
	$f("flow_player", flowplayer_plugin_url, {
	
		key: player_key,
				logo: '',
		
		clip: mp3StreamClip,
		
		plugins:  {
			controls: {
				url: flowplayer_cccontrol,
				playlist: false,
				stop: false,
				scrubber: true,
				autoHide: player_controlbar_autohide,
				background: '#000000'
			},		

			dock: dock_setting,
			
			audio: {
                url: flowplayer_mp3_url
            },
			dfp: {
				url: dfp_plugin_url,
				linearAdLabel: linearAdLabel_setting,
				skipAdButton : skipButtonSetting,
				adVolumeBar : adVolumeBarSetting,
				debug : player_debug,
				onAdLoaded:     function(){createEventLogger("onAdLoaded");},
				onAdReady:      function() {isAdPlay=true;createEventLogger("onAdReady");},
				onAdError:      function(){createEventLogger("onAdError");},
				onAdUnloaded:   function() {isAdPlay=false; createEventLogger("onAdUnloaded");},
                adStarted:      function(){createEventLogger("adStarted");},
                adFirstQuartile:function(){createEventLogger("adFirstQuartile");},
                adMidpoint:     function(){createEventLogger("adMidpoint");},
                adThirdQuartile:function(){createEventLogger("adThirdQuartile");},
                adCompleted:    function(){createEventLogger("adCompleted");}
			},
			
			advertisementLabel: advertisementLabel_setting
		},
		
		onBeforeBegin : function(){
		    var index = Player.getVideoIndex();
		    getPlaylistIndex(index);
			playerStateChanged("onBeforeBegin");
            onBeforeBegin_checkAndPlayAD();
		},
		onBegin : function(){		
			onBegin_checkAndPlayAD();			
		    setControlBar();	
		},						
		onLoad: function(){
		    var tempADcount=player_videoCountForAd;
			if (video_count == tempADcount) {
			    video_count = 0;
			}
		},
		
		onStart: function () {	    	
			//var index = Player.getVideoIndex();
			//getPlaylistIndex(index);
			playerStateChanged("onStart");

			video_count++;
            setViewCountCookie("viewCount", video_count);
		},
		
		onFinish: function() {
			
			var tempADcount=player_videoCountForAd;
			if (video_count == tempADcount) {
				video_count = 0;
				setViewCountCookie("viewCount", video_count);	
			}
			if (playlist_total==1) {
				$f("flow_player").stop();
			}
			playerStateChanged("onFinish");	
			
			AdPlayAfter_reset();
		},
		
		onResume: function() {
			playerStateChanged("onResume");
		},
		
		onPause: function() {
			playerStateChanged("onPause");
		},
		
		onStop: function () {
			playerStateChanged("onStop");
		},
		onError: function () {
			playerStateChanged("onError");
			html5ErrorDisplay('An error occurred, please try again later.');			
		},		
		onVolume: function () {
			var volume = $f("flow_player").getVolume();
			playerVolumeChanged(volume);
		},
		
		onMute: function () {
			playerVolumeChanged("onMute");
		},
		
		onUnmute: function () {
			playerVolumeChanged("onUnmute");
		},
		
		onFullscreen: function () {
			playerStateChanged("onFullscreen");
		},
		
		onFullscreenExit: function () {
			playerStateChanged("onFullscreenExit");
		}
		
	}).ipad({ simulateiDevice: false, controls: true, posterimg: initialimage_url   });
		// get a handle to the player just installed and call it's method "getVersion"
	$f("flow_player").getVersion();
}

function iPadLiveStreamInit() {
	var isOnStart;
	$f("flow_player", flowplayer_plugin_url, {
	
		key: player_key,
				logo: '',
		
		clip: iPadLiveStreamClip,
		
		onLoad: function(){
		   if(isAndroid&&(isLive==true)){
			webkitplayer("application/vnd.apple.mpegurl",iPadLiveStreamClip["ipadUrl"]);	
		   }
		},
	
		onStart: function () {
			/* if(isAndroid&&(isLive==true)){
			     $f("flow_player").stopBuffering();
			    webkitplayer("application/vnd.apple.mpegurl",iPadLiveStreamClip["ipadUrl"]);	
                $f("flow_player").stopBuffering();
			}else{*/
			playerStateChanged("onStart");			
			setControlBar();			
			isOnStart = true;
            //}
		},
		
		onFinish: function() {
			playerStateChanged("onFinish");
		},
		
		onResume: function() {
			if (!isOnStart) {
				playerStateChanged("onResume");
			} else {
				isOnStart = false;
			}
		},
		
		onPause: function() {
			playerStateChanged("onPause");
		},
		
		onStop: function () {
			playerStateChanged("onStop");
		},
		onError: function () {
			playerStateChanged("onError");
			html5ErrorDisplay('An error occurred, please try again later.');
		},		
		onVolume: function () {
			var volume = $f("flow_player").getVolume();
			playerVolumeChanged(volume);
		},
		
		onMute: function () {
			playerVolumeChanged("onMute");
		},
		
		onUnmute: function () {
			playerVolumeChanged("onUnmute");
		},
		
		onFullscreen: function () {
			playerStateChanged("onFullscreen");
		},
		
		onFullscreenExit: function () {
			playerStateChanged("onFullscreenExit");
		}
		
	}).ipad({ simulateiDevice: false, controls: true, posterimg: initialimage_url  });
}
function setControlBar() {
		$f("flow_player").getControls().setEnabled( { all: true} );
}
function setViewCountCookie(cookieName,cookieValue) {
	//var today = new Date();
    //var expire = new Date();
	//expire.setTime();    // No specified time, the cookie will be removed when browser is closed.
    //document.cookie = cookieName+"="+escape(cookieValue)+ ";path=/;expires="+expire.toGMTString();
	document.cookie = cookieName+"="+escape(cookieValue)+ ";path=/";
}
function readCookie(cookieName) {
	var theCookie=" "+document.cookie;
	var ind=theCookie.indexOf(" "+cookieName+"=");
	if (ind==-1) ind=theCookie.indexOf(";"+cookieName+"=");
	if (ind==-1 || cookieName=="") return "";
	var ind1=theCookie.indexOf(";",ind+1);
	if (ind1==-1) ind1=theCookie.length; 
	return unescape(theCookie.substring(ind+cookieName.length+2,ind1));
}

function loadjscssfile(filename, filetype){
 if (filetype=="js"){ //if filename is a external JavaScript file
  var fileref=document.createElement('script')
  fileref.setAttribute("type","text/javascript")
  fileref.setAttribute("src", filename)
 }
 else if (filetype=="css"){ //if filename is an external CSS file
  var fileref=document.createElement("link")
  fileref.setAttribute("rel", "stylesheet")
  fileref.setAttribute("type", "text/css")
  fileref.setAttribute("href", filename)
 }
 if (typeof fileref!="undefined")
      document.getElementById("flow_player").appendChild(fileref);
}
  function html5ErrorDisplay(errormessage) {
  document.getElementById('flow_player').innerHTML = '<img src = "http://twimg.edgesuite.net/appledaily/images/core/playerscreen_error.gif"  alt = "Error Detection"  width="100%" height="100%" id="kswebkit"/><div class="message" style="margin-top:-35%;margin-left:10%;display:block;">'+errormessage+'</div>';
  
  }

function webkitplayer(videocctype,ccipadurl) {
//if (((ischrome > -1)&&(isLive==false))||((isapplewebkit >-1)&&(ischrome == -1)&&(isLive==true))){		 
if ((isapplewebkit >-1)||(isxbox>-1)){		
//loadjscssfile('http://hk.adx.nextmedia.com/uvp/js/kswebkitscript.js', "js");
  if (videocctype!="video/mp4"){
      var playurl=ccipadurl;
	  }else{
      var playurl=$f("flow_player").getClip().completeUrl;	  
	  }	  
	  
	document.getElementById('flow_player').innerHTML = '<video width="100%" height="100%" id="kswebkit" controls src="'+playurl+'" type="'+videocctype+'" codecs="avc1.42E01E, mp4a.40.2" poster="'+initialimage_url+'" preload></video>';
	//document.getElementById('flow_player').innerHTML = '<video width="100%" height="100%" id="kswebkit" src="'+$f("flow_player").getClip().completeUrl+'" type="'+videocctype+'" controls></video><!-- Video Controls --><div id="video-controls"><button type="button" id="play-hq">HQ</button></div>';
	//loadjscssfile('http://hk.adx.nextmedia.com/uvp/css/kswebkitstyle.css', "css");
 
}else{
  html5ErrorDisplay('Sorry, this video is not available on this browser. Please Try to install Google Chrome for better performance.');
}
var videoElement = document.getElementById("kswebkit");
var vcurrentstatus ='';
    videoElement.play(); 
    videoElement.addEventListener('canplay',function (){vcurrentstatus="";html5PlayCCStatus("onLoad");playerStateChanged("onLoad");},false); 		
    videoElement.addEventListener('play',function (){html5PlayCCStatus("play");},false);
    videoElement.addEventListener('ended',function (){vcurrentstatus="";playerStateChanged("onFinish");html5PlayCCStatus("ended");},false);	
    videoElement.addEventListener('pause',function (){vcurrentstatus="onPause";html5PlayCCStatus("onPause");},false);	
    videoElement.addEventListener('error',function (){vcurrentstatus="";playerStateChanged("onError");html5PlayCCStatus("onError");},false);
	
  function html5PlayCCStatus(currentAct) {
	var ccindex = html5playlist.indexOf(videoElement.src);
    if ((currentAct=='ended')&&(ccindex<playlist_total-1)){
		   videoElement.setAttribute('src', html5playlist[ccindex+1]);
	       videoElement.play();
         }else if ((currentAct=='play')&&(ischrome > -1)&&(isLive==true)){
		   videoElement.pause();
		   window.open(playurl,'_self');		 
		 }
		 
	  if((currentAct=='onLoad')||(currentAct=='play')){
		   ccindex = html5playlist.indexOf(videoElement.src);
		   getPlaylistIndex(ccindex);	
		   if ((vcurrentstatus=="onPause")&&(currentAct=='play')){
		        playerStateChanged("onResume");
		        vcurrentstatus ='';
		   }else if ((vcurrentstatus=="")&&(currentAct=='play')){
		        playerStateChanged("onStart");		   
		   }
	   
	  }
	 if (currentAct=='onError'){
	   html5ErrorDisplay('An error occurred, please try again later.');
	  } 
	 if (currentAct=='onPause'){
	    if (videoElement.currentTime !=videoElement.duration)
	          playerStateChanged("onPause");
	  } 
	
  }
  
 } 
/* ------------------------ Call back functions ------------------------ */
<!-- call back function for end users to further implement -->
function playerStateChanged(state) {
	liveStateChanged(state);
}

function playerVolumeChanged(volume) {
	//alert("volume changed: " + volume);
	liveStateChanged("volume " + volume);
}
function getswf(swfname){
   if(document.all){
	return window[swfname];
	}else{
	return document[swfname];
   }
}

function getObjectString(object) {
	if (typeof(object)=="string") {
		return object;
	}
	var output = '';
	for (property in object) {
		output += property + ': ' + object[property]+'; ';
	}
	return output;
}

/********************Chartbeat*************************************/
if (!html5enable === true){
	function StrategyInterface(player) {
		this._player = player;
		//console.log(this.player_);
		//console.log('StrategyInterface under 3.0.4');
	}
	
	/**
	 * Enum for the content type.
	 * @enum {string}
	 */
	StrategyInterface.ContentType = {
		AD: 'ad',
		CONTENT: 'ct'
	};
	
	/**
	 * Enum for the ad position.
	 * @enum {string}
	 */
	StrategyInterface.AdPosition = {
		PREROLL: 'a1',
		MIDROLL: 'a2',
		POSTROLL: 'a3',
		OVERLAY: 'a4',
		SPECIAL: 'a5'
	};
	
	/**
	 * Enum for the video state.
	 * @enum {string}
	 */
	StrategyInterface.VideoState = {
		UNPLAYED: 's1',
		PLAYED: 's2',
		STOPPED: 's3',
		COMPLETED: 's4'
	};
	
	// used for getViewPlayTime
	StrategyInterface.m_viewPlayTimeStart=-1;
	StrategyInterface.m_viewPlayTimeCurrent=-1;
	StrategyInterface.resetViewPlayTime =  function() {
		StrategyInterface.m_viewPlayTimeStart=-1;
		StrategyInterface.m_viewPlayTimeCurrent=-1;
	}
	StrategyInterface.fetchViewPlayTimeStart =  function() {
		StrategyInterface.m_viewPlayTimeStart=new Date().getTime();
	}
	StrategyInterface.fetchViewPlayTimeCurrent =  function() {
		StrategyInterface.m_viewPlayTimeCurrent=new Date().getTime();
	}
	StrategyInterface.calViewPlayTime =  function() {
		viewPlayTime=0;
		if (StrategyInterface.m_viewPlayTimeStart>0) {
			StrategyInterface.fetchViewPlayTimeCurrent();
			tDiff=StrategyInterface.m_viewPlayTimeCurrent-StrategyInterface.m_viewPlayTimeStart;
			if (tDiff>0) {
				viewPlayTime=tDiff;
			}
		}
		return viewPlayTime;
	}
	
	StrategyInterface.prototype.getViewStartTime = function() {
		starttime=0;
		if (StrategyInterface.m_viewPlayTimeStart>0) {
			starttime=StrategyInterface.m_viewPlayTimeStart;
		}
		return starttime;
	}
	
	StrategyInterface.prototype.getViewPlayTime = function() {
		playertime=StrategyInterface.calViewPlayTime();
		return playertime;
	}
	
	StrategyInterface.prototype.getCurrentPlayTime = function() {
		playertime = $f().getTime();
		if (isNaN(playertime)) {
			// no clip running
			playertime = 0;
		}
		return playertime* 1000;
	}
	
	StrategyInterface.verify = function(player) {
		return true;
	}
	
	StrategyInterface.prototype.isReady = function() {
		return true;
	}
	
	StrategyInterface.prototype.getViewAdPlayTime = function() {return 0;}
	StrategyInterface.prototype.getAdPosition = function() {return '';}
	StrategyInterface.prototype.getState = function() { return "NA";}
	StrategyInterface.prototype.getThumbnailPath = function() {return '';}
	StrategyInterface.prototype.getTitle = function() {return "NA";}
	StrategyInterface.prototype.getBitrate = function() {return 550;}
	StrategyInterface.prototype.getContentType = function() {return "NA";}
	StrategyInterface.prototype.getTotalDuration = function () {return "NA";}
	StrategyInterface.prototype.getVideoPath = function() {return "NA";}
}