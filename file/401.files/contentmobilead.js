if (idx_MobilADSet == 1) {
    if (isM == true || winWidth < 1024) {
        if (!(/ipad/gi).test(navigator.platform)) {
            if ($.cookie('CtConMAD') == null) {
                var MAD_init = function () {
                    $('#m_ad').html('<span id="m_ad_close" title="關閉廣告"><span></span></span><div id="m_ad_box"></div>');
                    $("#m_ad_close").click(MAD_close).css('margin-left', ($('#m_ad').width() - 300) / 2);
                    googletag.cmd.push(function () {
                        googletag.pubads().display(MAD_ad, [[300, 250], [300, 430]], "m_ad_box");
                        googletag.pubads().addEventListener('slotRenderEnded', function (event) {
                            if (!event.isEmpty) {
                                for (var p in event.slot) {
                                    if (event.slot[p] === MAD_ad) {
                                        $('#m_ad').find('iframe:first').load(function () {
                                            $('#m_ad').show();
                                        });
                                    }
                                }
                            }
                        });
                    });

                    setTimeout(function () {
                        if ($('#m_ad:visible').length > 0) {
                            MAD_cookie();
                        }
                    }, 3000);
                };
                var MAD_cookie = function () {
                    var t = new Date();
                    t.setTime(t.getTime() + (1000 * 60 * 60 * 1));
                    $.cookie('CtConMAD', 'y', { path: '/', expires: t });
                };
                var MAD_close = function () {
                    MAD_cookie();
                    $("#m_ad").remove();
                    $("body").scrollTop($("body").scrollTop() + 1);     // 為了修正MI手機的殘影現象
                };
                MAD_init();
            }
        }
    }
}

$(function () {
    $('.art_click .num').on('click', function () {
        var t = new Date();
        t.setTime(t.getTime() + (1000 * 60 * 60 * 1));
        $.cookie('CtConMAD', null, { path: '/', expires: t });
        //location.reload();
    });
});