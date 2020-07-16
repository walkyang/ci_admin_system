$(function () {

    var box = $(".topnavbar > .nav-box");
    box.data("Reset", function () {
        $(".lowermenu").hide();
        $(".children" + box.find(".active").find("a").attr("tid")).show();
    });

    box.find("li").mouseover(function () {
        $(".lowermenu").hide();
        $(".children" + $(this).find("a").attr("tid")).show();
        return false;
    });
    box.find("li").mouseout(box.data("Reset")); 
    $(".lowermenu").mousemove(function () {
        $(".lowermenu").hide();
        $(this).show();
    });
    $(".lowermenu").mouseout(box.data("Reset"));
});

$(function () {
    $("body").on("click", ".pateSumArea", function () {
        var form = $("<form method=\"POST\"></form>");
        var o = $(".PageSearch").find("form").serializeArray();
        for (var i = 0; i < o.length; i++) {
            if (o[i].name != "County" && o[i].name != "Plate") {
                var input = $("<input type=\"hidden\" name=\"" + o[i].name + "\" />")
                input.val(o[i].value);
                form.append(input);
            }
        }
        var input = $("<input type=\"hidden\" name=\"County\" value=\"" + $(this).attr("fid") + "\" />")
        form.append(input);
        form.attr("action", "/@(Html.GetCity())/Transaction/ProjectDeal");
        form.submit();
    });
    $("body").on("click", ".setSearch", function () {
        $('#' + $(this).attr("searchid")).val($(this).attr("searchvalue"));
        $(".btn-search").click();
    });
    $("body").on("click", ".outExcel", function () { 
        var form = $("<form id=\"outexcel\"   method=\"post\"></form>");
        form.attr("action", $(this).attr("url"));
        var data1=$(this).parents("form").serializeArray();
        for (var i in data1) {
            var input1 = $("<input type=\"hidden\" name=\"" + data1[i].name + "\">");
            input1.attr("value", data1[i].value);
            form.append(input1);
        }
        $('body').append(form);
        form.submit();
        form.empty();
    });
})

$(function () {
    $("body").on("click", ".goCounty", function () {
        var form = $("<form method=\"POST\"></form>");
        var o = $(".PageSearch").find("form").serializeArray();
        for (var i = 0; i < o.length; i++) {
            if (o[i].name != "County" && o[i].name != "Plate") {
                var input = $("<input type=\"hidden\" name=\"" + o[i].name + "\" />")
                input.val(o[i].value);
                form.append(input);
            }
        }
        var input = $("<input type=\"hidden\" name=\"County\" value=\"" + $(this).attr("fid") + "\" />")
        form.append(input);
        form.attr("action", $(this).attr("url"));
        form.submit();
    });
    $("body").on("click", ".goPropertyType", function () {
        var form = $("<form method=\"POST\"></form>");
        var o = $(".PageSearch").find("form").serializeArray();
        for (var i = 0; i < o.length; i++) {
            var input = $("<input type=\"hidden\" name=\"" + o[i].name + "\" />")
            input.val(o[i].value);
            form.append(input);
        }
        var item = $(this).attr("fid").split(",");
        for (var i = 0; i < item.length;i++ ) {
            var input = $("<input type=\"hidden\" name=\"PropertyType\" value=\"" + item[i] + "\" />")
            form.append(input);
        }
       
        form.attr("action", $(this).attr("url"));
        form.submit();
    });
    $("body").on("click", ".PDetails", function () {
        var p = $(this).parents(".data-grid").find(".PageSearch").find("form").serialize();
        $(this).attr("param", p);
    });
    $("body").on("click", ".btn-search", function () {
        if ($(".chartHidden").size() > 0 && $(".chartHidden").data("chart") != undefined)
        {
             $.each($(".chartHidden").data("chart"), function (i, n) { n.clear();});
        }
        $(".chartHidden").data("chart", []);
        
    });
    $(".PageSearch").find("button[type='reset']").click(function () {
        $(".PageSearch").find("input[name='County']").val("");
        $(".PageSearch").find("input[name='Plate']").val("");
        $(".county").find("input[type='checkbox']").prop("checked", false);
    });
});

$(function () { 
    var haveNoCopy = function () {
        var show = false;
        if ($(".nocopy").size() > 0) { 
            $.each($(".nocopy"), function (i, n) {
                if(!show&&!$(n).is(':hidden'))
                {
                    show = true;
                }
            }); 
        }
        return show;
    }

    document.oncontextmenu = function (evt)
    {
        if (haveNoCopy())
        {
            evt.preventDefault();
        }
    }

    document.onselectstart = function (evt) {
        if (haveNoCopy()) {
            evt.preventDefault();
        }
    };

});
