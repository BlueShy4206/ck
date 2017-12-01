$(function () {
    var $menubg = $('.menubg'),
        $menuarea = $menubg.find('.menuarea'),
        $menu_h = $menuarea.height(),
        $menu_t = $menuarea.offset().top,
        _class_name = 'is-fixed';

    $(window).on('scroll resize', function () { //±²°Ê¨Æ¥ó
        var $this = $(this),
            $this_Top = $this.scrollTop();

        if ($this_Top > $menu_t) {
            $menubg.height($menu_h);
            $menubg.addClass(_class_name);
        } else {
            $menubg.removeClass(_class_name);
        }

    }).scroll();
});
