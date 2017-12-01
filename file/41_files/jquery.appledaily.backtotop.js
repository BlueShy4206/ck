;(function($) {

    var ready = false;
    var btts;
    var bttm;

    var checkBackToTopSide = function() {
    	if (!ready) return;

        var winsTop = $(window).scrollTop();
        var bttsH = btts.height();
        var checkH = parseInt(btts.css('top'), 10) + bttsH;
        var winH = $(window).height();

        var checkA;
        var checkB;

        if (bttm.length == 0) {
            var nowPos = btts.position().top + bttsH;
            var endPos = $(document).height() - $('#corpfoot').height() - $('#extras').height() - bttsH;

            checkA = nowPos;
            checkB = endPos;
        } else {
            var bttbTop = bttm.position().top;
            var scrollH = winsTop + winH;

            checkA = scrollH;
            checkB = bttbTop;
        }

        if (winH < checkH) {
            btts.css('visibility', 'hidden');
        } else if (checkA > checkB) {
            btts.css('visibility', 'hidden');
        } else if (winsTop > 130) {
            btts.css('visibility', 'visible');
        } else {
            btts.css('visibility', 'hidden');
        }
    }

    $(document).ready(function() {
    	btts = $('.back-to-top-side');
    	bttm = $('.abkct');

        var mobile = (/iphone|ipad|ipod|android|blackberry|xbox|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));
        if (mobile) return;
        
    	ready = true;

    	if (btts.length == 0) return;

        $(window).scroll(function() {
            checkBackToTopSide();
        });
        checkBackToTopSide();
    });

})(jQuery);