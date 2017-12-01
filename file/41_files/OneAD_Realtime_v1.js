var ONEAD = {};
	ONEAD.channel = 21; // AppleDaily
	ONEAD.volume =  0.02; // range is 0 to 1 (float)	
	ONEAD.slot_limit = {width: 970, height: 444};
	// optional(s)
	//ONEAD.response_freq = [1, 4, 7, 10, 13, 16, 19, 22];
	//ONEAD.response_freq = {start:1, step: 3};
	
	ONEAD.response_freq_multiple = {
    		"incover": "1,5",
    		"instream": "1,4,7,10,13,16,19,22,25,28,31,34,37,40,43,46,49"
	};
	ONEAD.wrapper = 'ONEAD_player_wrapper';
    	ONEAD.wrapper_multiple = {
          instream: "ONEAD_player_wrapper", // equals to inpage
          inread: "ONEAD_inread_wrapper",
          incover: "ONEAD_incover_wrapper"
    	};
	ONEAD.slot_limit_multiple = {
          incover: {
            width: 970,
            height: 444
          },
	  inread: {
            width: 450,
            height: 390
          }
        };
	
	ONEAD.cmd = ONEAD.cmd || [];
	
 function changeADState(obj){
      if (obj.newstate == 'COMPLETED' || obj.newstate == 'DELETED' ){
          if (ONEAD.play_mode == 'incover'){
              // remove the dimming block
              ONEAD_cleanup(ONEAD.play_mode);
          }else{
              ONEAD_cleanup();
          }
      }
  }

