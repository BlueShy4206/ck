/*!
 * jQuery Tools v1.2.7 - The missing UI library for the Web
 *
 * dateinput/dateinput.js
 * rangeinput/rangeinput.js
 * validator/validator.js
 *
 * NO COPYRIGHTS OR LICENSES. DO WHAT YOU LIKE.
 *
 * http://flowplayer.org/tools/
 *
 */
(function(d, D) {
    function M(b, a) {
        b = "" + b;
        for (a = a || 2; b.length < a;) b = "0" + b;
        return b
    }

    function N(b, a, d, g) {
        var f = a.getDate(),
            l = a.getDay(),
            k = a.getMonth(),
            c = a.getFullYear(),
            f = {
                d: f,
                dd: M(f),
                ddd: r[g].shortDays[l],
                dddd: r[g].days[l],
                m: k + 1,
                mm: M(k + 1),
                mmm: r[g].shortMonths[k],
                mmmm: r[g].months[k],
                yy: ("" + c).slice(2),
                yyyy: c
            },
            b = O[b](d, a, f, g);
        return S.html(b).html()
    }

    function l(b) {
        return parseInt(b, 10)
    }

    function P(b, a) {
        return b.getFullYear() === a.getFullYear() && b.getMonth() == a.getMonth() && b.getDate() == a.getDate()
    }

    function w(b) {
        if (b !==
            D) {
            if (b.constructor == Date) return b;
            if ("string" == typeof b) {
                var a = b.split("-");
                if (3 == a.length) return new Date(l(a[0]), l(a[1]) - 1, l(a[2]));
                if (!/^-?\d+$/.test(b)) return;
                b = l(b)
            }
            a = new Date;
            a.setDate(a.getDate() + b);
            return a
        }
    }

    function T(b, a) {
        function j(a, t, c) {
            o = a;
            z = a.getFullYear();
            B = a.getMonth();
            A = a.getDate();
            c || (c = d.Event("api"));
            "click" == c.type && !d.browser.msie && b.focus();
            c.type = "beforeChange";
            C.trigger(c, [a]);
            c.isDefaultPrevented() || (b.val(N(t.formatter, a, t.format, t.lang)), c.type = "change", C.trigger(c),
                b.data("date", a), f.hide(c))
        }

        function g(a) {
            a.type = "onShow";
            C.trigger(a);
            d(document).on("keydown.d", function(a) {
                if (a.ctrlKey) return !0;
                var e = a.keyCode;
                if (8 == e || 46 == e) return b.val(""), f.hide(a);
                if (27 == e || 9 == e) return f.hide(a);
                if (0 <= d(Q).index(e)) {
                    if (!u) return f.show(a), a.preventDefault();
                    var h = d("#" + c.weeks + " a"),
                        j = d("." + c.focus),
                        g = h.index(j);
                    j.removeClass(c.focus);
                    if (74 == e || 40 == e) g += 7;
                    else if (75 == e || 38 == e) g -= 7;
                    else if (76 == e || 39 == e) g += 1;
                    else if (72 == e || 37 == e) g -= 1;
                    41 < g ? (f.addMonth(), j = d("#" + c.weeks + " a:eq(" +
                        (g - 42) + ")")) : 0 > g ? (f.addMonth(-1), j = d("#" + c.weeks + " a:eq(" + (g + 42) + ")")) : j = h.eq(g);
                    j.addClass(c.focus);
                    return a.preventDefault()
                }
                if (34 == e) return f.addMonth();
                if (33 == e) return f.addMonth(-1);
                if (36 == e) return f.today();
                13 == e && (d(a.target).is("select") || d("." + c.focus).click());
                return 0 <= d([16, 17, 18, 9]).index(e)
            });
            d(document).on("click.d", function(a) {
                var e = a.target;
                !d(e).parents("#" + c.root).length && e != b[0] && (!E || e != E[0]) && f.hide(a)
            })
        }
        var f = this,
            q = new Date,
            k = q.getFullYear(),
            c = a.css,
            F = r[a.lang],
            i = d("#" + c.root),
            K = i.find("#" + c.title),
            E, G, H, z, B, A, o = b.attr("data-value") || a.value || b.val(),
            n = b.attr("min") || a.min,
            p = b.attr("max") || a.max,
            u, I;
        0 === n && (n = "0");
        o = w(o) || q;
        n = w(n || new Date(k + a.yearRange[0], 1, 1));
        p = w(p || new Date(k + a.yearRange[1] + 1, 1, -1));
        if (!F) throw "Dateinput: invalid language: " + a.lang;
        "date" == b.attr("type") && (I = b.clone(), k = I.wrap("<div/>").parent().html(), k = d(k.replace(/type/i, "type=text data-orig-type")), a.value && k.val(a.value), b.replaceWith(k), b = k);
        b.addClass(c.input);
        var C = b.add(f);
        if (!i.length) {
            i =
                d("<div><div><a/><div/><a/></div><div><div/><div/></div></div>").hide().css({
                    position: "absolute"
                }).attr("id", c.root);
            i.children().eq(0).attr("id", c.head).end().eq(1).attr("id", c.body).children().eq(0).attr("id", c.days).end().eq(1).attr("id", c.weeks).end().end().end().find("a").eq(0).attr("id", c.prev).end().eq(1).attr("id", c.next);
            K = i.find("#" + c.head).find("div").attr("id", c.title);
            if (a.selectors) {
                var x = d("<select/>").attr("id", c.month),
                    y = d("<select/>").attr("id", c.year);
                K.html(x.add(y))
            }
            for (var k =
                i.find("#" + c.days), L = 0; 7 > L; L++) k.append(d("<span/>").text(F.shortDays[(L + a.firstDay) % 7]));
            d("body").append(i)
        }
        a.trigger && (E = d("<a/>").attr("href", "#").addClass(c.trigger).click(function(e) {
            a.toggle ? f.toggle() : f.show();
            return e.preventDefault()
        }).insertAfter(b));
        var J = i.find("#" + c.weeks),
            y = i.find("#" + c.year),
            x = i.find("#" + c.month);
        d.extend(f, {
            show: function(e) {
                if (!b.attr("readonly") && !b.attr("disabled") && !u) {
                    e = e || d.Event();
                    e.type = "onBeforeShow";
                    C.trigger(e);
                    if (!e.isDefaultPrevented()) {
                        d.each(R, function() {
                            this.hide()
                        });
                        u = true;
                        x.off("change").change(function() {
                            f.setValue(l(y.val()), l(d(this).val()))
                        });
                        y.off("change").change(function() {
                            f.setValue(l(d(this).val()), l(x.val()))
                        });
                        G = i.find("#" + c.prev).off("click").click(function() {
                            G.hasClass(c.disabled) || f.addMonth(-1);
                            return false
                        });
                        H = i.find("#" + c.next).off("click").click(function() {
                            H.hasClass(c.disabled) || f.addMonth();
                            return false
                        });
                        f.setValue(o);
                        var t = b.offset();
                        i.css({
                            top: t.top + b.outerHeight({
                                    margins: true
                                }) +
                                a.offset[0],
                            left: t.left + a.offset[1]
                        });
                        if (a.speed) i.show(a.speed, function() {
                            g(e)
                        });
                        else {
                            i.show();
                            g(e)
                        }
                        return f
                    }
                }
            },
            setValue: function(e, b, g) {
                var h = l(b) >= -1 ? new Date(l(e), l(b), l(g == D || isNaN(g) ? 1 : g)) : e || o;
                h < n ? h = n : h > p && (h = p);
                typeof e == "string" && (h = w(e));
                e = h.getFullYear();
                b = h.getMonth();
                g = h.getDate();
                if (b == -1) {
                    b = 11;
                    e--
                } else if (b == 12) {
                    b = 0;
                    e++
                }
                if (!u) {
                    j(h, a);
                    return f
                }
                B = b;
                z = e;
                A = g;
                var g = (new Date(e, b, 1 - a.firstDay)).getDay(),
                    i = (new Date(e, b + 1, 0)).getDate(),
                    k = (new Date(e, b - 1 + 1, 0)).getDate(),
                    r;
                if (a.selectors) {
                    x.empty();
                    d.each(F.months, function(a, b) {
                        n < new Date(e, a + 1, 1) && p > new Date(e, a, 0) && x.append(d("<option/>").html(b).attr("value", a))
                    });
                    y.empty();
                    for (var h = q.getFullYear(), m = h + a.yearRange[0]; m < h + a.yearRange[1]; m++) n < new Date(m + 1, 0, 1) && p > new Date(m, 0, 0) && y.append(d("<option/>").text(m));
                    x.val(b);
                    y.val(e)
                } else K.html(F.months[b] + " " + e);
                J.empty();
                G.add(H).removeClass(c.disabled);
                for (var m = !g ? -7 : 0, s, v; m < (!g ? 35 : 42); m++) {
                    s = d("<a/>");
                    if (m % 7 === 0) {
                        r = d("<div/>").addClass(c.week);
                        J.append(r)
                    }
                    if (m < g) {
                        s.addClass(c.off);
                        v = k -
                            g + m + 1;
                        h = new Date(e, b - 1, v)
                    } else if (m >= g + i) {
                        s.addClass(c.off);
                        v = m - i - g + 1;
                        h = new Date(e, b + 1, v)
                    } else {
                        v = m - g + 1;
                        h = new Date(e, b, v);
                        P(o, h) ? s.attr("id", c.current).addClass(c.focus) : P(q, h) && s.attr("id", c.today)
                    }
                    n && h < n && s.add(G).addClass(c.disabled);
                    p && h > p && s.add(H).addClass(c.disabled);
                    s.attr("href", "#" + v).text(v).data("date", h);
                    r.append(s)
                }
                J.find("a").click(function(b) {
                    var e = d(this);
                    if (!e.hasClass(c.disabled)) {
                        d("#" + c.current).removeAttr("id");
                        e.attr("id", c.current);
                        j(e.data("date"), a, b)
                    }
                    return false
                });
                c.sunday &&
                    J.find("." + c.week).each(function() {
                        var b = a.firstDay ? 7 - a.firstDay : 0;
                        d(this).children().slice(b, b + 1).addClass(c.sunday)
                    });
                return f
            },
            setMin: function(a, b) {
                n = w(a);
                b && o < n && f.setValue(n);
                return f
            },
            setMax: function(a, b) {
                p = w(a);
                b && o > p && f.setValue(p);
                return f
            },
            today: function() {
                return f.setValue(q)
            },
            addDay: function(a) {
                return this.setValue(z, B, A + (a || 1))
            },
            addMonth: function(a) {
                var a = B + (a || 1),
                    b = (new Date(z, a + 1, 0)).getDate();
                return this.setValue(z, a, A <= b ? A : b)
            },
            addYear: function(a) {
                return this.setValue(z + (a || 1), B, A)
            },
            destroy: function() {
                b.add(document).off("click.d keydown.d");
                i.add(E).remove();
                b.removeData("dateinput").removeClass(c.input);
                I && b.replaceWith(I)
            },
            hide: function(a) {
                if (u) {
                    a = d.Event();
                    a.type = "onHide";
                    C.trigger(a);
                    if (a.isDefaultPrevented()) return;
                    d(document).off("click.d keydown.d");
                    i.hide();
                    u = false
                }
                return f
            },
            toggle: function() {
                return f.isOpen() ? f.hide() : f.show()
            },
            getConf: function() {
                return a
            },
            getInput: function() {
                return b
            },
            getCalendar: function() {
                return i
            },
            getValue: function(b) {
                return b ? N(a.formatter, o, b,
                    a.lang) : o
            },
            isOpen: function() {
                return u
            }
        });
        d.each(["onBeforeShow", "onShow", "change", "onHide"], function(b, c) {
            if (d.isFunction(a[c])) d(f).on(c, a[c]);
            f[c] = function(a) {
                if (a) d(f).on(c, a);
                return f
            }
        });
        a.editable || b.on("focus.d click.d", f.show).keydown(function(a) {
            var c = a.keyCode;
            if (!u && d(Q).index(c) >= 0) {
                f.show(a);
                return a.preventDefault()
            }(c == 8 || c == 46) && b.val("");
            return a.shiftKey || a.ctrlKey || a.altKey || c == 9 ? true : a.preventDefault()
        });
        w(b.val()) && j(o, a)
    }
    d.tools = d.tools || {
        version: "@VERSION"
    };
    var R = [],
        O = {},
        q, Q = [75, 76, 38, 39, 74, 72, 40, 37],
        r = {};
    q = d.tools.dateinput = {
        conf: {
            format: "mm/dd/yy",
            formatter: "default",
            selectors: !1,
            yearRange: [-10, 10],
            lang: "en",
            offset: [0, 0],
            speed: 0,
            firstDay: 0,
            min: D,
            max: D,
            trigger: 0,
            toggle: 0,
            editable: 0,
            css: {
                prefix: "cal",
                input: "date",
                root: 0,
                head: 0,
                title: 0,
                prev: 0,
                next: 0,
                month: 0,
                year: 0,
                days: 0,
                body: 0,
                weeks: 0,
                today: 0,
                current: 0,
                week: 0,
                off: 0,
                sunday: 0,
                focus: 0,
                disabled: 0,
                trigger: 0
            }
        },
        addFormatter: function(b, a) {
            O[b] = a
        },
        localize: function(b, a) {
            d.each(a, function(b, d) {
                a[b] = d.split(",")
            });
            r[b] = a
        }
    };
    q.localize("en", {
        months: "January,February,March,April,May,June,July,August,September,October,November,December",
        shortMonths: "Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec",
        days: "Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday",
        shortDays: "Sun,Mon,Tue,Wed,Thu,Fri,Sat"
    });
    var S = d("<a/>");
    q.addFormatter("default", function(b, a, d) {
        return b.replace(/d{1,4}|m{1,4}|yy(?:yy)?|"[^"]*"|'[^']*'/g, function(a) {
            return a in d ? d[a] : a
        })
    });
    q.addFormatter("prefixed", function(b, a, d) {
        return b.replace(/%(d{1,4}|m{1,4}|yy(?:yy)?|"[^"]*"|'[^']*')/g,
            function(a, b) {
                return b in d ? d[b] : a
            })
    });
    d.expr[":"].date = function(b) {
        var a = b.getAttribute("type");
        return a && "date" == a || !!d(b).data("dateinput")
    };
    d.fn.dateinput = function(b) {
        if (this.data("dateinput")) return this;
        b = d.extend(!0, {}, q.conf, b);
        d.each(b.css, function(a, d) {
            !d && "prefix" != a && (b.css[a] = (b.css.prefix || "") + (d || a))
        });
        var a;
        this.each(function() {
            var j = new T(d(this), b);
            R.push(j);
            j = j.getInput().data("dateinput", j);
            a = a ? a.add(j) : j
        });
        return a ? a : this
    }
})(jQuery);
(function(a) {
    function z(c, b) {
        var a = Math.pow(10, b);
        return Math.round(c * a) / a
    }

    function m(c, b) {
        var a = parseInt(c.css(b), 10);
        return a ? a : (a = c[0].currentStyle) && a.width && parseInt(a.width, 10)
    }

    function y(a) {
        return (a = a.data("events")) && a.onSlide
    }

    function A(c, b) {
        function e(a, d, f, e) {
            void 0 === f ? f = d / i * v : e && (f -= b.min);
            s && (f = Math.round(f / s) * s);
            if (void 0 === d || s) d = f * i / v;
            if (isNaN(f)) return g;
            d = Math.max(0, Math.min(d, i));
            f = d / i * v;
            if (e || !n) f += b.min;
            n && (e ? d = i - d : f = b.max - f);
            var f = z(f, r),
                h = "click" == a.type;
            if (u && void 0 !== k &&
                !h && (a.type = "onSlide", w.trigger(a, [f, d]), a.isDefaultPrevented())) return g;
            e = h ? b.speed : 0;
            h = h ? function() {
                a.type = "change";
                w.trigger(a, [f])
            } : null;
            n ? (j.animate({
                top: d
            }, e, h), b.progress && x.animate({
                height: i - d + j.height() / 2
            }, e)) : (j.animate({
                left: d
            }, e, h), b.progress && x.animate({
                width: d + j.width() / 2
            }, e));
            k = f;
            c.val(f);
            return g
        }

        function o() {
            (n = b.vertical || m(h, "height") > m(h, "width")) ? (i = m(h, "height") - m(j, "height"), l = h.offset().top + i) : (i = m(h, "width") - m(j, "width"), l = h.offset().left)
        }

        function q() {
            o();
            g.setValue(void 0 !==
                b.value ? b.value : b.min)
        }
        var g = this,
            p = b.css,
            h = a("<div><div/><a href='#'/></div>").data("rangeinput", g),
            n, k, l, i;
        c.before(h);
        var j = h.addClass(p.slider).find("a").addClass(p.handle),
            x = h.find("div").addClass(p.progress);
        a.each(["min", "max", "step", "value"], function(a, d) {
            var f = c.attr(d);
            parseFloat(f) && (b[d] = parseFloat(f, 10))
        });
        var v = b.max - b.min,
            s = "any" == b.step ? 0 : b.step,
            r = b.precision;
        void 0 === r && (r = s.toString().split("."), r = 2 === r.length ? r[1].length : 0);
        if ("range" == c.attr("type")) {
            var t = c.clone().wrap("<div/>").parent().html(),
                t = a(t.replace(/type/i, "type=text data-orig-type"));
            t.val(b.value);
            c.replaceWith(t);
            c = t
        }
        c.addClass(p.input);
        var w = a(g).add(c),
            u = !0;
        a.extend(g, {
            getValue: function() {
                return k
            },
            setValue: function(b, d) {
                o();
                return e(d || a.Event("api"), void 0, b, true)
            },
            getConf: function() {
                return b
            },
            getProgress: function() {
                return x
            },
            getHandle: function() {
                return j
            },
            getInput: function() {
                return c
            },
            step: function(c, d) {
                d = d || a.Event();
                g.setValue(k + (b.step == "any" ? 1 : b.step) * (c || 1), d)
            },
            stepUp: function(a) {
                return g.step(a || 1)
            },
            stepDown: function(a) {
                return g.step(-a ||
                    -1)
            }
        });
        a.each(["onSlide", "change"], function(c, d) {
            if (a.isFunction(b[d])) a(g).on(d, b[d]);
            g[d] = function(b) {
                if (b) a(g).on(d, b);
                return g
            }
        });
        j.drag({
            drag: !1
        }).on("dragStart", function() {
            o();
            u = y(a(g)) || y(c)
        }).on("drag", function(a, b, f) {
            if (c.is(":disabled")) return false;
            e(a, n ? b : f)
        }).on("dragEnd", function(a) {
            if (!a.isDefaultPrevented()) {
                a.type = "change";
                w.trigger(a, [k])
            }
        }).click(function(a) {
            return a.preventDefault()
        });
        h.click(function(a) {
            if (c.is(":disabled") || a.target == j[0]) return a.preventDefault();
            o();
            var b =
                n ? j.height() / 2 : j.width() / 2;
            e(a, n ? i - l - b + a.pageY : a.pageX - l - b)
        });
        b.keyboard && c.keydown(function(b) {
            if (!c.attr("readonly")) {
                var d = b.keyCode,
                    f = a([75, 76, 38, 33, 39]).index(d) != -1,
                    e = a([74, 72, 40, 34, 37]).index(d) != -1;
                if ((f || e) && !b.shiftKey && !b.altKey && !b.ctrlKey) {
                    f ? g.step(d == 33 ? 10 : 1, b) : e && g.step(d == 34 ? -10 : -1, b);
                    return b.preventDefault()
                }
            }
        });
        c.blur(function(b) {
            var c = a(this).val();
            c !== k && g.setValue(c, b)
        });
        a.extend(c[0], {
            stepUp: g.stepUp,
            stepDown: g.stepDown
        });
        q();
        i || a(window).load(q)
    }
    a.tools = a.tools || {
        version: "@VERSION"
    };
    var u;
    u = a.tools.rangeinput = {
        conf: {
            min: 0,
            max: 100,
            step: "any",
            steps: 0,
            value: 0,
            precision: void 0,
            vertical: 0,
            keyboard: !0,
            progress: !1,
            speed: 100,
            css: {
                input: "range",
                slider: "slider",
                progress: "progress",
                handle: "handle"
            }
        }
    };
    var q, l;
    a.fn.drag = function(c) {
        document.ondragstart = function() {
            return !1
        };
        c = a.extend({
            x: !0,
            y: !0,
            drag: !0
        }, c);
        q = q || a(document).on("mousedown mouseup", function(b) {
            var e = a(b.target);
            if ("mousedown" == b.type && e.data("drag")) {
                var o = e.position(),
                    m = b.pageX - o.left,
                    g = b.pageY - o.top,
                    p = !0;
                q.on("mousemove.drag",
                    function(a) {
                        var b = a.pageX - m,
                            a = a.pageY - g,
                            k = {};
                        c.x && (k.left = b);
                        c.y && (k.top = a);
                        p && (e.trigger("dragStart"), p = !1);
                        c.drag && e.css(k);
                        e.trigger("drag", [a, b]);
                        l = e
                    });
                b.preventDefault()
            } else try {
                l && l.trigger("dragEnd")
            } finally {
                q.off("mousemove.drag"), l = null
            }
        });
        return this.data("drag", !0)
    };
    a.expr[":"].range = function(c) {
        var b = c.getAttribute("type");
        return b && "range" == b || !!a(c).filter("input").data("rangeinput")
    };
    a.fn.rangeinput = function(c) {
        if (this.data("rangeinput")) return this;
        var c = a.extend(!0, {}, u.conf, c),
            b;
        this.each(function() {
            var e = new A(a(this), a.extend(!0, {}, c)),
                e = e.getInput().data("rangeinput", e);
            b = b ? b.add(e) : e
        });
        return b ? b : this
    }
})(jQuery);
(function(c) {
    function i(b, a, f) {
        var a = c(a).first() || a,
            d = b.offset().top,
            e = b.offset().left,
            g = f.position.split(/,?\s+/),
            j = g[0],
            g = g[1],
            d = d - (a.outerHeight() - f.offset[0]),
            e = e + (b.outerWidth() + f.offset[1]);
        /iPad/i.test(navigator.userAgent) && (d -= c(window).scrollTop());
        f = a.outerHeight() + b.outerHeight();
        "center" == j && (d += f / 2);
        "bottom" == j && (d += f);
        b = b.outerWidth();
        "center" == g && (e -= (b + a.outerWidth()) / 2);
        "left" == g && (e -= b);
        return {
            top: d,
            left: e
        }
    }

    function q(b) {
        function a() {
            return this.getAttribute("type") == b
        }
        a.key = '[type="' +
            b + '"]';
        return a
    }

    function n(b, a, f) {
        function p(a, b, e) {
            if (f.grouped || !a.length) {
                var g;
                !1 === e || c.isArray(e) ? (g = d.messages[b.key || b] || d.messages["*"], g = g[f.lang] || d.messages["*"].en, (b = g.match(/\$\d/g)) && c.isArray(e) && c.each(b, function(a) {
                    g = g.replace(this, e[a])
                })) : g = e[f.lang] || e;
                a.push(g)
            }
        }
        var e = this,
            g = a.add(e),
            b = b.not(":button, :image, :reset, :submit");
        a.attr("novalidate", "novalidate");
        c.extend(e, {
            getConf: function() {
                return f
            },
            getForm: function() {
                return a
            },
            getInputs: function() {
                return b
            },
            reflow: function() {
                b.each(function() {
                    var a =
                        c(this),
                        b = a.data("msg.el");
                    b && (a = i(a, b, f), b.css({
                        top: a.top,
                        left: a.left
                    }))
                });
                return e
            },
            invalidate: function(a, h) {
                if (!h) {
                    var d = [];
                    c.each(a, function(a, f) {
                        var c = b.filter("[name='" + a + "']");
                        c.length && (c.trigger("OI", [f]), d.push({
                            input: c,
                            messages: [f]
                        }))
                    });
                    a = d;
                    h = c.Event()
                }
                h.type = "onFail";
                g.trigger(h, [a]);
                h.isDefaultPrevented() || l[f.effect][0].call(e, a, h);
                return e
            },
            reset: function(a) {
                a = a || b;
                a.removeClass(f.errorClass).each(function() {
                    var a = c(this).data("msg.el");
                    a && (a.remove(), c(this).data("msg.el", null))
                }).off(f.errorInputEvent +
                    ".v" || "");
                return e
            },
            destroy: function() {
                a.off(f.formEvent + ".V reset.V");
                b.off(f.inputEvent + ".V change.V");
                return e.reset()
            },
            checkValidity: function(a, h) {
                var a = a || b,
                    a = a.not(":disabled"),
                    d = {},
                    a = a.filter(function() {
                        var a = c(this).attr("name");
                        if (!d[a]) return d[a] = !0, c(this)
                    });
                if (!a.length) return !0;
                h = h || c.Event();
                h.type = "onBeforeValidate";
                g.trigger(h, [a]);
                if (h.isDefaultPrevented()) return h.result;
                var k = [];
                a.each(function() {
                    var a = [],
                        b = c(this).data("messages", a),
                        d = m && b.is(":date") ? "onHide.v" : f.errorInputEvent +
                        ".v";
                    b.off(d);
                    c.each(o, function() {
                        var c = this[0];
                        if (b.filter(c).length) {
                            var d = this[1].call(e, b, b.val());
                            if (!0 !== d) {
                                h.type = "onBeforeFail";
                                g.trigger(h, [b, c]);
                                if (h.isDefaultPrevented()) return !1;
                                var j = b.attr(f.messageAttr);
                                if (j) return a = [j], !1;
                                p(a, c, d)
                            }
                        }
                    });
                    if (a.length && (k.push({
                        input: b,
                        messages: a
                    }), b.trigger("OI", [a]), f.errorInputEvent)) b.on(d, function(a) {
                        e.checkValidity(b, a)
                    });
                    if (f.singleError && k.length) return !1
                });
                var i = l[f.effect];
                if (!i) throw 'Validator: cannot find effect "' + f.effect + '"';
                if (k.length) return e.invalidate(k,
                    h), !1;
                i[1].call(e, a, h);
                h.type = "onSuccess";
                g.trigger(h, [a]);
                a.off(f.errorInputEvent + ".v");
                return !0
            }
        });
        c.each(["onBeforeValidate", "onBeforeFail", "onFail", "onSuccess"], function(a, b) {
            if (c.isFunction(f[b])) c(e).on(b, f[b]);
            e[b] = function(a) {
                if (a) c(e).on(b, a);
                return e
            }
        });
        if (f.formEvent) a.on(f.formEvent + ".V", function(b) {
            if (!e.checkValidity(null, b)) return b.preventDefault();
            b.target = a;
            b.type = f.formEvent
        });
        a.on("reset.V", function() {
            e.reset()
        });
        b[0] && b[0].validity && b.each(function() {
            this.oninvalid = function() {
                return !1
            }
        });
        a[0] && (a[0].checkValidity = e.checkValidity);
        if (f.inputEvent) b.on(f.inputEvent + ".V", function(a) {
            e.checkValidity(c(this), a)
        });
        b.filter(":checkbox, select").filter("[required]").on("change.V", function(a) {
            var b = c(this);
            (this.checked || b.is("select") && c(this).val()) && l[f.effect][1].call(e, b, a)
        });
        b.filter(":radio[required]").on("change.V", function(a) {
            var b = c("[name='" + c(a.srcElement).attr("name") + "']");
            b != null && b.length != 0 && e.checkValidity(b, a)
        });
        c(window).resize(function() {
            e.reflow()
        })
    }
    c.tools = c.tools || {
        version: "@VERSION"
    };
    var r = /\[type=([a-z]+)\]/,
        s = /^-?[0-9]*(\.[0-9]+)?$/,
        m = c.tools.dateinput,
        t = /^([a-z0-9_\.\-\+]+)@([\da-z\.\-]+)\.([a-z\.]{2,6})$/i,
        u = /^(https?:\/\/)?[\da-z\.\-]+\.[a-z\.]{2,6}[#&+_\?\/\w \.\-=]*$/i,
        d;
    d = c.tools.validator = {
        conf: {
            grouped: !1,
            effect: "default",
            errorClass: "invalid",
            inputEvent: null,
            errorInputEvent: "keyup",
            formEvent: "submit",
            lang: "en",
            message: "<div/>",
            messageAttr: "data-message",
            messageClass: "error",
            offset: [0, 0],
            position: "center right",
            singleError: !1,
            speed: "normal"
        },
        messages: {
            "*": {
                en: "Please correct this value"
            }
        },
        localize: function(b, a) {
            c.each(a, function(a, c) {
                d.messages[a] = d.messages[a] || {};
                d.messages[a][b] = c
            })
        },
        localizeFn: function(b, a) {
            d.messages[b] = d.messages[b] || {};
            c.extend(d.messages[b], a)
        },
        fn: function(b, a, f) {
            c.isFunction(a) ? f = a : ("string" == typeof a && (a = {
                en: a
            }), this.messages[b.key || b] = a);
            (a = r.exec(b)) && (b = q(a[1]));
            o.push([b, f])
        },
        addEffect: function(b, a, f) {
            l[b] = [a, f]
        }
    };
    var o = [],
        l = {
            "default": [
                function(b) {
                    var a = this.getConf();
                    c.each(b, function(b, d) {
                        var e = d.input;
                        e.addClass(a.errorClass);
                        var g = e.data("msg.el");
                        g || (g = c(a.message).addClass(a.messageClass).appendTo(document.body), e.data("msg.el", g));
                        g.css({
                            visibility: "hidden"
                        }).find("p").remove();
                        c.each(d.messages, function(a, b) {
                            c("<p/>").html(b).appendTo(g)
                        });
                        g.outerWidth() == g.parent().width() && g.add(g.find("p")).css({
                            display: "inline"
                        });
                        e = i(e, g, a);
                        g.css({
                            visibility: "visible",
                            position: "absolute",
                            top: e.top,
                            left: e.left
                        }).fadeIn(a.speed)
                    })
                },
                function(b) {
                    var a = this.getConf();
                    b.removeClass(a.errorClass).each(function() {
                        var a = c(this).data("msg.el");
                        a && a.css({
                            visibility: "hidden"
                        })
                    })
                }
            ]
        };
    c.each(["email", "url", "number"], function(b, a) {
        c.expr[":"][a] = function(b) {
            return b.getAttribute("type") === a
        }
    });
    c.fn.oninvalid = function(b) {
        return this[b ? "on" : "trigger"]("OI", b)
    };
    d.fn(":email", "Please enter a valid email address", function(b, a) {
        return !a || t.test(a)
    });
    d.fn(":url", "Please enter a valid URL", function(b, a) {
        return !a || u.test(a)
    });
    d.fn(":number", "Please enter a numeric value.", function(b, a) {
        return s.test(a)
    });
    d.fn("[max]", "Please enter a value no larger than $1", function(b, a) {
        if ("" === a || m && b.is(":date")) return !0;
        var c = b.attr("max");
        return parseFloat(a) <= parseFloat(c) ? !0 : [c]
    });
    d.fn("[min]", "Please enter a value of at least $1", function(b, a) {
        if ("" === a || m && b.is(":date")) return !0;
        var c = b.attr("min");
        return parseFloat(a) >= parseFloat(c) ? !0 : [c]
    });
    d.fn("[required]", "Please complete this mandatory field.", function(b, a) {
        return b.is(":checkbox") ? b.is(":checked") : !!a
    });
    d.fn("[pattern]", function(b, a) {
        return "" === a || RegExp("^" + b.attr("pattern") + "$").test(a)
    });
    d.fn(":radio", "Please select an option.", function(b) {
        var a = !1;
        c("[name='" + b.attr("name") + "']").each(function(b, d) {
            c(d).is(":checked") && (a = !0)
        });
        return a ? !0 : !1
    });
    c.fn.validator = function(b) {
        var a = this.data("validator");
        a && (a.destroy(), this.removeData("validator"));
        b = c.extend(!0, {}, d.conf, b);
        if (this.is("form")) return this.each(function() {
            var d = c(this);
            a = new n(d.find(":input"), d, b);
            d.data("validator", a)
        });
        a = new n(this, this.eq(0).closest("form"), b);
        return this.data("validator", a)
    }
})(jQuery);