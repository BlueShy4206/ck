$(document).ready(function() {
    PopupStandby.init()
});
var PopupStandby = {
    timeoutID: 0,
    isOpen: false,
    isFirst: true,
    noEvent: false,
    addEventListener: function(e, listener, useCapture) {
        if (window.addEventListener) {
            window.addEventListener(e, listener, useCapture);
        } else if (window.attachEvent) {
            window.attachEvent("on"+e, listener);
        } else {
            PopupStandby.noEvent = true;
        }
    },
    init: function() {
        PopupStandby.addEventListener("mousemove", this.resetTimer, false);
        PopupStandby.addEventListener("mousedown", this.resetTimer, false);
        PopupStandby.addEventListener("keypress", this.resetTimer, false);
        PopupStandby.addEventListener("DOMMouseScroll", this.resetTimer, false);
        PopupStandby.addEventListener("mousewheel", this.resetTimer, false);
        PopupStandby.addEventListener("touchmove", this.resetTimer, false);
        PopupStandby.addEventListener("MSPointerMove", this.resetTimer, false);
        if (!PopupStandby.noEvent) {
            this.startTimer()
        }
    },
    startTimer: function() {
        PopupStandby.timeoutID = window.setTimeout(PopupStandby.goInactive, 60 * 10 * 1e3)
    },
    resetTimer: function(e) {
        window.clearTimeout(PopupStandby.timeoutID);
        PopupStandby.goActive()
    },
    goInactive: function() {
        if (PopupStandby.isFirst) {
            $('.pageidle').fancybox({
                padding: 0,
                minWidth: 900,
                maxHeight: 506,
                width: 900,
                height: 506,
                closeBtn: true,
                afterClose: function() {
                    PopupStandby.isOpen = false
                }
            });
            PopupStandby.isFirst = false
        };
        $('.pageidle').click();
        PopupStandby.isOpen = true;
        window.clearTimeout(PopupStandby.timeoutID)
    },
    goActive: function() {
        if (!PopupStandby.isOpen) PopupStandby.startTimer()
    },
    closePopup: function() {
        $.fancybox.close();
        PopupStandby.isOpen = false
    }
};