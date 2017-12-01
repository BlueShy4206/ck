;(function($, cm) {
  App.init();
  
  var shareBox = $('[data-cmfunc=sendMail]');
  //sendMail
  shareBox.on('click', function() {
    $.ajax({
      url : location.href,
      type : 'post',
      data : {"_request": "sendMail", "recordId": $(this).data('id')},
      dataType : 'json'
    })
    .then(function(data, textStatus, jqXHR) {
      if(data.success == true) {
        if($('#' + data.id).length > 0) $('#' + data.id).remove();

        $(data.html)
          .prependTo('body')
          .on('show.bs.modal', function(e) {
            $('body').css({"padding-right": "17px"});
            $('.cm-form', this).cmForm();
          })
          .on('shown.bs.modal', function(e) {
            
          })
          .on('hidden.bs.modal', function() {
            $('#pop_sendMailbox').remove();
            $('body').css({"padding-right": "0"});
          })
          .modal({
            keyboard: false,
            show : true
          });

      } else {
        //$.pnotify({text: data.message, type: 'error'});
      }
    }, function(jqXHR, textStatus, errorThrown) {
      //$.pnotify({text: errorThrown, type: 'error'});
    });
  });
  
  window.onload = function() {
    //$('.dataInfoBox').fadeIn('fast');
    //$('#loadingBox').fadeOut('fast', function() { $(this).remove(); });
    $('.flexslider').flexslider({
    animation: "slide",
      directionNav: $('[data-hasdirectionnav]').data('hasdirectionnav') == '1' ? true : false,
      controlNav: false,
      namespace: '',
      selector: ".slides > div.item",
      pauseInvisible: false,
      pauseOnAction: false,
      slideshowSpeed: 5000,
      //manualControls: ".carousel-indicators li"
    });
  }
})(jQuery, window._cm)