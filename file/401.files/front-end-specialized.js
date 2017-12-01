"use strict";
/************
使用語法：
    frontEndSpecialized ([base$obj][, options][, containerAspectRatio][, callback])
變數說明：
    @param: {jQuery Object} base$obj，例：$("body > .article-box")
    @param: {Array of object(s)} options，例：[{"base": ".article-entry", "target": ".thumb-photo"}]
    @param: {Number} containerAspectRatio，父層參考容器的長寬比例，例：1.66, 3/2
    @param: {Function} callback，例：myFunc或function () {code...}
    變數均為非必要，順序可不固定
************/
function frontEndSpecialized () {
    var base$obj,
        options,
        containerAspectRatio,
        callback,
        arg,
        i = 0,
        l = arguments.length;
    for (; i < l; i += 1) {
        arg = arguments[i];
        if (arg instanceof jQuery) {
            base$obj = arg;
        } else if ($.isArray(arg)) {
            options = arg;
        } else if ($.isNumeric(arg)) {
            containerAspectRatio = arg;
        } else if ($.isFunction(arg)) {
            callback = arg;
        } else {
            console.log("frontEndSpecialized參數型別錯誤");
            return false;
        }
    }
    setEvenOdd(base$obj, options);
    initPhotoContainer(base$obj);
    imgSpecialized(base$obj, containerAspectRatio, callback);
};

function setEvenOdd (base$obj, options) {
    var $self = base$obj instanceof jQuery ? base$obj : $("body"),
        field = [
            {
                "base": "ul",
                "target": "li"
            },
            {
                "base": "ol",
                "target": "li"
            },
            {
                "base": "dl",
                "target": "dd"
            },
            {
                "base": "tbody",
                "target": "tr"
            }
        ];
    if ($.isArray(options)) {
        field = field.concat(options);
    }
    $.each(field, function () {
        var fieldBase = this.base,
            fieldTarget = this.target;
        $self.find(fieldBase).each(function () {
            var $self = $(this),
                $obj,
                process = function ($obj) {
                    $obj.filter(":even").addClass("even");
                    $obj.filter(":odd").addClass("odd");
                    $obj.filter(":first").addClass("first");
                    $obj.filter(":last").addClass("last");
                };
            if (fieldTarget === "dd") {
                $self.find("dt").each(function () {
                    $obj = $(this).nextUntil("dt");
                    process($obj);
                });
            } else {
                $obj = $self.children(fieldTarget);
                process($obj);
            }
        });
    });
};

function initPhotoContainer (base$obj) {
    var $self = base$obj instanceof jQuery ? base$obj : $("body");
    $self.find(".thumb-photo > .cropper").each(function () {
        var $self = $(this),
            $emptySpan = $self.children("span:empty");
        if ($emptySpan.attr("class") !== undefined || $emptySpan.length === 0) {
            $self.prepend("<span></span>");
        }
        $self.not(":has(span.default-photo)").not(":has(img)").append('<span class="default-photo"></span>');
        $self.not(":has(img)").parent(".thumb-photo").addClass("no-photo");
    });
};

(function($){
    $.each(["Width", "Height"], function (i, prop) {
        (function (naturalProp, prop) {
            $.fn[naturalProp] = function () {
                var self = this[0],
                    supported = function () {
                        return self[naturalProp];
                    },
                    unSupported = function () {
                        var img,
                            value;
                        if (self.tagName.toLowerCase() === "img") {
                            img = new Image();
                            img.src = self.src;
                            value = img[prop];
                        }
                        return value;
                    };
                return (naturalProp in new Image()) ? supported() : unSupported();
            };
        })("natural" + prop, prop.toLowerCase());
    });
}(jQuery));

function imgSpecialized () {
    var base$obj,
        containerAspectRatio,
        callback,
        arg,
        i = 0,
        l = arguments.length,
        $imgs,
        imgCount,
        doCallback;
    for (; i < l; i += 1) {
        arg = arguments[i]
        if (arg instanceof jQuery) {
            base$obj = arg;
        } else if ($.isNumeric(arg)) {
            containerAspectRatio = arg
        } else if ($.isFunction(arg)) {
            callback = arg;
        }
    }
    base$obj = base$obj || $("body");
    $imgs = base$obj.find("img");
    imgCount = $imgs.length;
    doCallback = function () {
        if (callback) {
            callback();
        }
    };
    if (imgCount === 0) {
        doCallback();
        return;
    }
    $imgs.one("load", {"count": 0}, function (event) {
        var $img = $(this),
            imgWidth = $img.naturalWidth(),
            imgHeight = $img.naturalHeight(),
            imgAspectRatio = imgWidth / imgHeight,
            count = event.data.count += 1;
        $img.removeClass("h v").addClass(imgAspectRatio >= 1 ? "h" : "v").attr({
            "data-width": imgWidth,
            "data-height": imgHeight,
            "data-aspect-ratio": imgAspectRatio
        });
        if (containerAspectRatio) {
            $img.removeClass("rel-h rel-v").addClass(imgAspectRatio >= containerAspectRatio ? "rel-h" : "rel-v");
        }
        if (count === imgCount) {
            doCallback();
        }
    }).one("error", function () {
        $(this).attr({
            "errorsrc": this.src,
            "src": "http://www.chinatimes.com/2009cti/cthead/images/spacer.gif"
        });
    }).each(function () {
        if (this.complete) {
            $(this).trigger("load");
        }
    });
};

function prefixStyleProperty (styleProperty, toCamelCase) {
    var prop,
        allProps = document.createElement("div").style,
        vendors = ["", "webkit", "Moz", "O", "ms"],
        toCamelCase = (toCamelCase === undefined) ? true : toCamelCase,
        i = 0,
        l = vendors.length;
    for (; i < l; i += 1) {
        prop = styleProperty;
        if (i !== 0) {
            prop = vendors[i] + prop.slice(0, 1).toUpperCase() + prop.slice(1);
        }
        if (prop in allProps) {
            if (toCamelCase || i === 0) {
                return prop;
            } else {
                return "-" + vendors[i].toLowerCase() + "-" + styleProperty
            }
        }
    }
    return false;
};

function prefixTransitionEnd () {
    var map = {
          "transition": "transitionEnd transitionend",
          "webkitTransition": "webkitTransitionEnd webkittransitionend",
          "MozTransition": "MozTransitionEnd moztransitionend",
          "OTransition": "OTransitionEnd otransitionend",
          "msTransition": "msTransitionEnd mstransitionend"
        };
    return map[prefixStyleProperty("transition")];
};

$(document).ready(function () {
    frontEndSpecialized();
});