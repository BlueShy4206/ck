/* in-freq, hit 2 */
/* silent, no pid */
  if (ONEAD_get_response !== undefined && typeof ONEAD_get_response == 'function'){
      ONEAD_get_response(null);
  }
  if (window.ONEAD_img !== undefined && typeof window.ONEAD_img == 'function'){
    window.ONEAD_img({
      "guid": "51c1c995-4785-3b57-8bf9-3611dff8f7bb",
      "pid": "",
      "play_mode": ""
    });
  }