
//$("body").data("scrollTime", new Date().getTime());

var fiddle_link = "http://jsfiddle.net/soundar24/s5gpugjn/";
var jsbin_link = "http://jsbin.com/sevatip/1/edit?html,js,output";
var codepen_link = "https://codepen.io/soundar24/pen/NqMjKz";

$(window).scroll(function (e) {
    var _body = document.body;
    if ($(document).outerHeight() - $(window).outerHeight() < 200) {
        $(_body).removeClass("fixed-header");
        return;
    }
    //var currentTime = new Date().getTime();
    //var prevTime = $(_body).data("scrollTime") || 0;
    //$(_body).data("scrollTime", currentTime);
    //var diff = currentTime - prevTime;
    //$(".header")[(diff > 50 ? "add" : "remove") + "Class"]("spin");

    var _top = $(window).scrollTop();
    $(_body)[(_top > 40 ? "add" : "remove") + "Class"]("fixed-header");

    //var _total = _body.scrollHeight - _body.offsetHeight, top;
    //top = _top * (360 / _total);
    //$(".logo img").rsRotate(top);
});

$(window).resize(updateMinHeight);

$(document).ready(function () {
    updateFiddleLinks();
    updateFooterEle();
    updateMinHeight();
    updateRotate();
    checkBrowser();
    setTimeout(updateMinHeight, 250);
    setTimeout(function () { $(".header").addClass("anim"); }, 1000);
    setTimeout(bindAnchorClick, 10);
});

function updateFiddleLinks() {
    $("#jsfiddle").attr("href", fiddle_link);
    $("#jsbin").attr("href", jsbin_link);
    $("#codepen").attr("href", codepen_link);
}
function createElement(tag) {
    var t = tag.split('.');
    return $(document.createElement(t[0])).addClass(t[1] || "");
}
function bindAnchorClick() {
    checkNavigation(window.location.hash, true);

    $("a.link").click(function (e) {
        e.preventDefault();
        var href = $(e.currentTarget).attr("href"), _blank = $(e.currentTarget).attr("target") == "_blank";

        if (href[0] == "#") {
            var link = window.location.href.replace(window.location.hash, "") + href;

            if (e.ctrlKey || _blank) window.open(link);
            else if (e.shiftKey) window.open(link, "_blank");
            else {
                checkNavigation(href);
                window.location.hash = href;
            }
        }
    });
}
function checkNavigation(hash, initial) {
    var target = $(hash + "_link");
    if (target && target.length > 0) {
        var pos_top = target.offset().top;
        pos_top -= ($(".header").outerHeight() > 60) ? 104 : 76;
        if (initial) $(window).scrollTop(pos_top);
        else $("html, body").animate({ scrollTop: pos_top }, 600);
    }
    else if (initial) {
        //window.location.hash = "";
    }
}
function updateMinHeight() {
    $(".wrapper").css({
        "min-height": $(window).outerHeight() - ($(".header").outerHeight() + $(".footer").outerHeight())
    });
}
function updateFooterEle() {
    var _text = ["Github", "Download", "Contact me", "Donate", "Licence"];
    var _links = ["https://github.com/soundar24/roundSlider",
                  "./download.html", "./contactme.html",
                  "./donate.html", "./licence.html"];

    var innerBar = createElement("div.ctr").append("<span>Copyright &copy; 2015 - 2018</span>");
    var outerBar = createElement("div.bottom-bar").append(innerBar);

    for (var t in _text) {
        innerBar.append(createElement("a").attr({ "target": "_blank", "href": _links[t] }).html(_text[t]));
    }
    $(".footer").append(outerBar);
}
function updateRotate() {
    if (typeof $.fn.rsRotate == "undefined") {
        $.fn.rsRotate = function (degree) {
            this.css('-webkit-transform', "rotate(" + degree + "deg)");
            this.css('-moz-transform', "rotate(" + degree + "deg)");
            this.css('-ms-transform', "rotate(" + degree + "deg)");
            this.css('-o-transform', "rotate(" + degree + "deg)");
            this.css('transform', "rotate(" + degree + "deg)");
            return this;
        }
    }
}
function checkBrowser() {
    var properties = ["borderRadius", "WebkitBorderRadius", "MozBorderRadius",
        "OBorderRadius", "msBorderRadius", "KhtmlBorderRadius"];
    for (var i = 0; i < properties.length; i++) {
        if (document.body.style[properties[i]] !== undefined) return true;
    }
    // lower browser notification
    var popup = createElement("div").addClass("notify-popup");
    popup.html("You browser doesn't support roundSlider, please try to open this page in any modern browser.");
    var cbtn = createElement("div").addClass("cbtn").html("X");
    cbtn.click(function () { popup.remove(); });
    $("body").addClass("ie8").append(popup.append(cbtn));
}

//For analytics
window.heap = window.heap || [], heap.load = function (t, e) {
    window.heap.appid = t, window.heap.config = e;
    var a = document.createElement("script");
    a.type = "text/javascript", a.async = !0,
    a.src = ("https:" === document.location.protocol ? "https:" : "http:") + "//cdn.heapanalytics.com/js/heap-" + t + ".js";
    var n = document.getElementsByTagName("script")[0]; n.parentNode.insertBefore(a, n); for (var o = function (t) { return function () { heap.push([t].concat(Array.prototype.slice.call(arguments, 0))) } }, p = ["clearEventProperties", "identify", "setEventProperties", "track", "unsetEventProperty"], c = 0; c < p.length; c++) heap[p[c]] = o(p[c])
};
heap.load("606938904");