/* out-freq, hit 2 */
/* silent, no pid */
  if (ONEAD_get_response !== undefined && typeof ONEAD_get_response == 'function'){
      ONEAD_get_response(null);
  }
  if (window.ONEAD_img !== undefined && typeof window.ONEAD_img == 'function'){
    window.ONEAD_img({
      "guid": "7d015a2f-3960-30a9-ad64-a35063e06e78",
      "pid": "",
      "play_mode": ""
    });
  }
/* time: 5.86 ms */
