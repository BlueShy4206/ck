// player configuration

var plugin_url = "http://twimg.edgesuite.net/appledaily/adx1/";

//var dfp_plugin_url = plugin_url + "flowplayer.dfp-nextmedia.com-2.9-dev.swf";
var dfp_plugin_url = plugin_url + "flowplayer.dfp-nextmedia.com-3.6-dev.swf";


//var player_key = '#@150e0cbab4588892a54';	// key for running Flowplayer
var player_key = '#$def2be488e89efe0560';	// key for running Flowplayer


var player_width = '640';				// Set the width of player size

var player_height = '360';				// Set the height of player size

var player_buffering = false;			// Specifies whether the rotating buffering animation must be shown or not. 
										// Set this to false and the animation will not be shown.
										
var player_debug = true;				// Configures logging of the Flowplayer JavaScript component.
										// This will output all events triggered by the Flash component to 
										// the Firebug or Safari Dev tools console.

//var player_accelerated = false;		Flag indicating whether Flash 9 (and above) hardware-accelerated 
										// full screen mode should be used.

var player_autoPlay = true;				// Flag indicating whether the player should start playback immediately upon loading.

var player_autoBuffering = true;		// Flag indicating whether loading of clip into player's memory 
										// should begin straight away. When this is true and autoPlay is false 
										// then the clip will automatically stop at the first frame of the video.

//var player_bufferLength = 3;			// The amount of video data (in seconds) which should be loaded into 
										// Flowplayer's memory in advance of playback commencing.
										
var player_scaling = 'scale';				// To defines how video is scaled on the player screen
										// Possible values: fit, half, orig, scale

//var player_start = 0;					// The time (in seconds) at which playback should commence. 
										// This is only supported when you have a streaming server.
										
var player_videoCountForAd = 2;			// Set the time for showing Ad. Eg. 5 = display 1 Ad after showing 5 videos

var player_playAdAfterTime = -1;			// Set the time for showing Ad. after a video started (in ms). Eg. -1=disable, 3000=play Ad. after a video started 3 seconds 

var player_controlbar_autohide = true;	// Auto hide the Control bar

var player_streamMethod;				// Input Value: 1 = Progressive Download, 2 = HTTP Pseudo-Streaming, 
										// 3 = RTMP Streaming, 4 = Akamai HTTP Streaming,
										// 5 = Pseudo-Streaming with Bandwidth Checking,
										// 6 = RTMP Streaming with Bandwidth Checking,
										// 7 = Normal Live Streaming (For both web browser and iPad)
										
var player_RTMPServer;					// URL of RTMP server

var player_smilUrl;						// URL of Smil XML film

//var player_iPadStreamMethod;

	//var isAndroid = /android 4/i.test(navigator.userAgent.toLowerCase()); 	
	//var isiPad =/(iphone|ipad|pod)/ig.test(navigator.platform);



/* ------------------------ Flowplayer Size Setting ------------------------ */

function setPlayerSize(width, height) {
	if (width != null || width != '') {
		player_width = width;
	}
	if (height != null || height != '') {
		player_height = height;
	}
}


/* ------------------------ Flowplayer Plugin Setting ------------------------ */


var flowplayer_plugin_url = plugin_url + "flowplayer.commercial-3.2.14.swf";
var flowplayer_cccontent = plugin_url + "flowplayer.content-3.2.8.swf";
var flowplayer_cccontrol = plugin_url + "flowplayer.controls-3.2.14.swf";
var flowplayer_viralcontrol = plugin_url + "flowplayer.viralvideos-3.2.13.swf";
var flowplayer_akamaiplugin_url = plugin_url + "AkamaiFlowPlugin-2.10.swf";
var flowplayer_mp3_url = plugin_url + "flowplayer.audio-3.2.10.swf";


var controls_setting = {
	'url': flowplayer_cccontrol,
	'playlist': false,
	'stop': false,
	'autoHide': player_controlbar_autohide,
    'sliderBorderWidth': 2.5,
	'background': '#000000'
};

var akamaiplugin_setting = {
        url: flowplayer_akamaiplugin_url
};

var dock_setting = {
	'right': 15,
	'horizontal': false,
	'width': '10%',
	'autoHide': player_controlbar_autohide
};

var viral_setting = {// location of the plugin

        url: flowplayer_viralcontrol,
        
        email: false,
        
        embed: true,

        // configure sharing
        share: {
            // description used when sharing to the social sites
			title: '',
            description: '',
			twitter: false,
			myspace: false,
			livespaces: false,
			digg: false,
			orkut: false,
			stumbleupon: false,
			bebo: false
        }
    
};

/*AD Setting Starts*/
var linearAdLabel_setting = {
	'advertisementLabel': "advertisementLabel",
	'type': "top", // "overlay", "top", "bottom"
	//'content': "廣告播放中, 動新聞影片會在{time-left}秒後自動播放 ",
	'content': "廣告播放中, 您可以在{time-left}秒後略過廣告 ",	
	'alpha' : 50,
	mouseover : false
};

var advertisementLabel_setting = {
	'url': flowplayer_cccontent,
	'top': 0,
	'width': 400,
	'height': 24,
	'border': 'none',
	'style': {
		'body': {
			'fontSize': 12,
			'fontFamily': "Arial",
			'textAlign': "center",
			'color': "#ffffff"
		}
	},
	'backgroundColor': "rgba(20, 20, 20, 0.5)",
	'display': "none"
};

var skipButtonSetting = {
	show : true,
	type : 'right',//left || right
	delayDisplay : 5000,
	text : '略過廣告',
	alpha : 80,
	position : 'top' //top,bottom
}
var adVolumeBarSetting = {
	alpha : 50,
	show : true,
	mouseover : true

}

/*AD Setting Ends*/
