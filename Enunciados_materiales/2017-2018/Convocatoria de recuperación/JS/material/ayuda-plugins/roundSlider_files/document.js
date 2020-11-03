
$(document).ready(function () {

    $.each(window.defaults, function (category, props) {
        $(".properties_toc").append($("<h3>" + category + "</h3>"));

        $.each(props, function (i, name) {
            $(".properties_toc").append($("<span><a class='link " + name + "' href='#" + name + "'>" + name + "</a></span>"));

            $(".details").append(propertyBlock(name));
        });
    });

    updateOffsetArray();
    setTimeout(function () {
        updateOffsetArray();
        updateFocusedClass();
    }, 250);

    $(window).bind("mousewheel DOMMouseScroll", function (e) {
        if ($(".properties_toc:hover").length != 0) {
            var delta = (e.type === 'DOMMouseScroll' ? e.originalEvent.detail * -40 : e.originalEvent.wheelDelta);
            var direction = delta > 0 ? "up" : "down";

            var scrollEnd = $(".properties_toc")[0].scrollHeight - $(".properties_toc").outerHeight();
            if (scrollEnd == 0) return;
            if (($(".properties_toc").scrollTop() == 0 && direction === "up") ||
                $(".properties_toc").scrollTop() == scrollEnd && direction === "down") {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        }
    });

    var timeout_scroll, timeout_resize;
    $(window).resize(function (e) {
        if (timeout_resize) clearTimeout(timeout_resize);
        timeout_resize = setTimeout(function () { updateOffsetArray(); }, 50);
    });

    $(window).bind("scroll resize", function (e) {
        if ($("#options_link").hasClass("closed")) return;
        var _top = $(window).scrollTop();
        var top_start = $(".all_prop").offset().top - 57;
        var top_end = (top_start + $(".all_prop").outerHeight() + 70) - $(window).outerHeight() - _top;

        var isFixed = (_top < top_start || top_end < 0);
        $(".contents")[(isFixed ? "remove" : "add") + "Class"]("fixed");
        $(".contents")[(isFixed ? "add" : "remove") + "Class"]("derived");

        $(".properties_toc")[(top_end < 0 ? "add" : "remove") + "Class"]("bottom");

        if (timeout_scroll) clearTimeout(timeout_scroll);
        timeout_scroll = setTimeout(function () {
            updateFocusedClass(top_end);
        }, 10);
    });

    $(".ref button").click(function (e) {
        $(e.target).parent().slideToggle();
        $(e.target).parent().siblings(".ref").slideToggle();
        $(".ref-note").slideToggle();
    });

    $(".container h2").append($(document.createElement("span")).addClass("arrow"));
    $(".container h2").append(createElement("a.permalink link").append(createElement("div")));

    $(".container h2").parent().bind("click", arrowClick);

    $(".container h2").each(function () {
        var link = $.trim($(this).text().replace("?", "")).toLowerCase().split(" ").join("-");
        $(this).attr("id", link + "_link").children("a").attr("href", "#" + link);
    });

    updateDependecies();
});

function updateDependecies(e) {
    var version = $.fn.roundSlider.prototype.version;
    var jq = "https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js";
    var css = "https://cdnjs.cloudflare.com/ajax/libs/roundSlider/"+ version +"/roundslider.min.css";
    var js = "https://cdnjs.cloudflare.com/ajax/libs/roundSlider/"+ version +"/roundslider.min.js";

    $("#rjq").html(jq).attr("href", jq);
    $("#rcss").html(css).attr("href", css);
    $("#rjs").html(js).attr("href", js);
}

function arrowClick(e) {
    if ($(e.target).hasClass("permalink") || $(e.target).parent().hasClass("permalink")) return;
    var htag = $(this).children();
    htag.toggleClass("closed");
    htag.parent().next().slideToggle();
}

function propertyBlock(name) {
    var currentDetail = details[name];
    var description = currentDetail["desc"][0], type = currentDetail["type"];
    var div = $(document.createElement("div")).attr("id", name + "_link");
    var h3 = $(document.createElement("h3")).html(name);
    var span = $(document.createElement("span")).html(description);
    div.append(h3, description);

    if (currentDetail && currentDetail["list"]) {
        var items = currentDetail["list"];
        var ul = $(document.createElement("ul"));

        $.each(items, function (i, item) {
            var li = $(document.createElement("li")).html(item);
            ul.append(li);
        });
        div.append(ul);

        if (currentDetail["desc1"]) div.append(currentDetail["desc1"]);
    }

    if ($.inArray(name, window.defaults["Properties"]) != -1) {
        var d = $(document.createElement("div")).addClass("cont");
        var v = $.fn.roundSlider.prototype.defaults[name];
        var _default = $(document.createElement("div")).addClass("def").html("<span>default </span> " + (typeof v == "string" ? '"' + v + '"' : v));

        var _type = $(document.createElement("div")).addClass("type").html("<span>type </span> " + type);

        d.append(_default, _type);
        div.append(d);
    }

    return div;
}

function updateOffsetArray() {
    $(".contents").css("left", Math.ceil($(".details").offset().left) - $(".contents").outerWidth() - 20);

    window.offsetJson = [];
    $(".properties_toc a").each(function (i, val) {
        var s = {}, block = $(val.hash + "_link");
        s["href"] = val.hash;
        s["currentLi"] = $(this).parent();
        s["hTag"] = block;
        s["offset"] = block.offset().top;
        offsetJson.push(s);
    });
}
function updateFocusedClass(top_end) {
    if (!$(".contents").hasClass("fixed") && top_end > 0) {
        $(".properties_toc span").removeClass("focused").first().addClass("focused");
        $(".details div").removeClass("focused").first().addClass("focused");
    }
    else {
        var current;
        for (var i = 0; i < offsetJson.length; i++) {
            current = offsetJson[i];
            if ($(window).scrollTop() + 70 < current.offset) {
                $(".properties_toc span").removeClass("focused");
                current.currentLi.addClass("focused");
                moveSelectedCenter();
                setTimeout(function () {
                    $(".details div").removeClass("focused");
                    current.hTag.addClass("focused");
                }, 100);
                return;
            }
        }
    }
}
function moveSelectedCenter() {
    var container = $(".properties_toc"), items = container.children("span");
    var headingHeight = container.children("h3").eq(0).outerHeight(true);
    var itemHeight = items.eq(0).outerHeight();

    var index = container.find(".focused").index();
    var selectedHeight = (itemHeight * (index - 1)) + headingHeight;
    if (index >= 18) selectedHeight += headingHeight;
    else if (index >= 21) selectedHeight += headingHeight * 2;

    var top = selectedHeight - ((container.outerHeight() - itemHeight) / 2);
    container.scrollTop(top);
    return top;
}