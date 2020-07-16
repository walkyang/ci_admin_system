var zindex = 1050;
$.extend({
    confirm: function (txt, Success) {
        $.modal({
            but: $(document),
            title: "系统消息",
            width: 400,
            height: 400,
            modal: true,
            confirm: true,
            Success: Success,
            content: "<div style=\" width:350px;min-height:80px;overflow:auto;text-align:left;font-size:18px; font-weight:800;\"><div style=\"padding:15px;\">" + txt.replaceAll("\r\n", "<br/>") + "</div></div>"
        });
    },
    alert: function (txt, Success) {
        $.modal({
            but: $(document),
            title: "系统消息",
            width: 400,
            height: 400,
            modal: true,
            Success: Success || function () { },
            alert: true,
            content: "<div style=\" width:350px;min-height:80px;overflow:auto;text-align:left;font-size:18px; font-weight:800;\"><div style=\"padding:15px;\">" + txt.replaceAll("\r\n", "<br/>") + "</div></div>"
        });
    },
    //=======dialog
    modal: function (options) {
        if (options.but) {
            if (options.but.data("window") && options.but.data("window").data("hide")) {
                options.but.data("window").show();
                return;
            }
            if (options.but.data("openOptions")) {
                options.but.data("openOptions").onClose();
            }
            options.but.data("openOptions", options);
        }
        options["backdrop"] = false;
        var submit = options.submit || false;
        var isSubmit = false;
        options["onLoad2"] = function (options) {
            if (options.but.is(".iframe")) {
                var d = options.d;
                var body = d.find(".iframe").contents().find("body");
                var bodyheight = body.height();
                var bodywidth = body.width();
                if (body.find(".c4").size() > 0) {
                    bodyheight = body.find(".c4").height() > bodyheight ? body.find(".c4").height() : bodyheight;
                    bodywidth = body.find(".c4").width() > bodywidth ? body.find(".c4").width() : bodywidth;
                }
                body.data("dialog", options);
                d.find(".modal-body").css({ height: bodyheight + 10, width: bodywidth + 10 });

                d.width(bodywidth + 30);
                d.data("wpt", options);
                var top = (($("body").height() - bodyheight) / 2);
                if (top > 70 || top < 20) { top = 70; }
                top += $(document).scrollTop();
                d.css({ left: (($("body").width() - bodywidth) / 2), top: top });

            } else {
                $.validator.unobtrusive.parse(options.d);
                var d = options.d;
                if (options.onLoad) {
                    options.onLoad(options.d);
                }
                var body = d.find(".modal-body").find(".c4");
                if (body.size() == 0) {
                    body = d.find(".modal-body").children();
                }
                d.width(body.width() + 20);
                d.data("wpt", options);
                if (options.but && options.but.is(".tag")) {
                    d.width(body.width() + 40);
                    var but = options.but;
                    if (options.but.attr("forName")) {
                        but = $(options.but.attr("forName"))
                    }
                    var offset = but.offset();
                    var top = (but.scrollTop());
                    d.css({ left: (offset.left + (but.width() > 100 ? 100 : but.width()) + d.find(".arrow").outerWidth()), top: (offset.top - d.find(".popover-title").outerHeight() - d.find(".arrow").outerHeight() / 2 + but.outerHeight() / 2) });
                } else {
                    var top = (($("body").height() - d.height()) / 2);
                    if (top > 70 || top < 20) { top = 70; }
                    top += $(document).scrollTop();
                    d.css({ left: (($("body").width() - d.width()) / 2), top: top });
                }
            }
        }
        if (options.submit || options.but.is(".submit")) {
            options["success2"] = options["success2"] || options["success"];
            options["failure2"] = options["failure2"] || options["failure"];
            options["success"] = function (data, options1) {
                if (data.State) {
                    if (options["success2"]) {
                        if (options["success2"].call(this, data, options) != false) {
                            options.onClose();
                        }
                    } else {
                        options.onClose();
                        $.alert(data.Message);
                    }
                    if (options.parent && options.parent.refresh) {
                        options.parent.refresh();
                    } else {
                        if (options.parent && options.parent.load) {
                            options.parent.load();
                        }
                    }
                } else {
                    d.find(".call").show();
                    $.alert(data.Message);
                }
            }
            options["failure"] = function (data, options1) {
                d.find(".call").show();
                $.alert(data.Message);
            }
        }
        zindex++;
        var id = Math.round(Math.random() * 100000000000);
        var d = null;
        if (options.but && options.but.is(".tag")) {
            d = $('<div class="popover fade right in" style="display: block;max-width:1000px;" id="' + id + '" style="position:absolute"><div class="arrow" style="top:46px;"></div>'
                 + '<h3 class="popover-title">'
                 + options.title + '<button type="button" class="close closed" data-dismiss="modal" aria-hidden="true">×</button></h3>'
                 + '<div class="popover-content modal-body"><div>Loading...</div></div>'
                 + (submit ? '<div class="modal-footer"><a href="javascript:void(0)"  class="btn closed">关闭</a> <a href="javascript:void(0)" class="btn btn-primary call">保存</a></div>' : '')
                 + (options.alert ? '<div class="modal-footer"><a href="javascript:void(0)" class="btn btn-primary confirm">朕知道了</a></div>' : '')
                 + (options.confirm ? '<div class="modal-footer"><a href="javascript:void(0)"  class="btn closed">取消</a><a href="javascript:void(0)" class="btn btn-danger confirm">确定</a></div>' : '')
                 + '</div></div> ');

        } else {
            d = $(' <div class="modal-dialog modal" id="' + id + '" style="position:absolute;z-index:' + zindex + ';background: #fff;margin-left:0;"><div class="modal-content"  >'
                 + '<div class="modal-header"  style="padding:5px; padding-left:3px;margin:0;"><button type="button" class="close closed" data-dismiss="modal" aria-hidden="true">×</button><h3 class="title" style=" padding:0; padding-left:0px;margin:0;font-size: 16px;line-height: 20px;">'
                 + options.title + '</h3></div>'
                 + '<div class="modal-body" style="padding: 0px;max-height:auto !important;"><div>Loading...</div></div>'
                 + (submit ? '<div class="modal-footer"><a href="javascript:void(0)"  class="btn closed">关闭</a> <a href="javascript:void(0)" class="btn btn-primary call">保存</a></div>' : '')
                 + (options.confirm ? '<div class="modal-footer"><a href="javascript:void(0)"  class="btn closed">取消</a><a href="javascript:void(0)" class="btn btn-danger confirm">确定</a></div>' : '')
                 + (options.alert ? '<div class="modal-footer"><a href="javascript:void(0)" class="btn btn-primary confirm">朕知道了</a></div>' : '')
                 + '</div></div> ');
        }
        options["d"] = d;
        if (options.but) {
            options.but.data("window", d);
        }
        d.data("options", options);
        options.onClose = function () {
            if (options.parent && options.parent.close) {
                options.parent.close();
            }
            if (options.but && options.but.is(".cache")) {
                d.hide();
                d.data("hide", true);
            } else {
                d.remove();
            }
        }
        options.onCall = function () {
            var f = d.find("form");
            if (f.data("valid")) {
                if (f.data("valid")(options) == false) {
                    return false;
                }
            }
            if (!options["param"]) {
                options["param"] = "";
            }
            if (options["param"].indexOf("submit=call") == -1) {
                options["param"] += "&submit=call"
            }
            if (!options["param"]) {
                options["param"] = "";
            }
            if ($(this).attr("param")) {
                options["param"] = $(this).attr("param");
            }
            d.find(".call").hide();
            options.callbut = d.find(".call");
            f.AjaxSubmit(options);
        }

        options.Format = function () {
            d.find(".call").unbind("click");
            d.find(".closed").unbind("click");
            d.find(".confirm").unbind("click");
            d.find(".confirm").click(function () { options.Success(); options.onClose() });
            d.find(".call").click(options.onCall);
            d.find(".closed").click(options.onClose);
            d.find(".load").click(function () {
                options["href"] = $(this).attr("href");
                options["param"] = $(this).attr("param");
                options["load"](options["param"]);
            });
        }

        if (options.but && options.but.is(".at")) {
            options.but.after(d);
        } else {
            $("body").append(d);
        }
        options.Format();
        options["setTitle"] = function (t) { d.find(".modal-header").find(".title").html(t); }
        options.onLoad2(options);

        options["load"] = function (o) {
            if (o && o.href) {
                options["href"] = o.href;
            }
            if (options["href"]) {
                if (options["onBeforeLoad"]) {
                    options.onBeforeLoad(options);
                }
                if (o && o.httptype) {
                    options["httptype"] = o.httptype;
                }
                var type = options["httptype"] || "GET";
                if (options["href"].indexOf("?") > 0) {
                    options["href"] += "&ajax=true&random=" + Math.random() * 100;
                } else {
                    options["href"] += "?ajax=true&random=" + Math.random() * 100;
                }

                if (o && o.param && type != "POST") {
                    options["param"] = o.param;
                }
                if (o && o.title) {
                    options.setTitle(o.title);
                }
                if (options.but.is(".iframe")) {
                    d.find(".modal-body").html('<iframe scrolling="auto" class="iframe" frameborder="0"  src="' + options["href"] + '" style="width:100%;height:100%;"></iframe>');
                    d.find(".modal-body").find("iframe").load(function () {
                        options.onLoad2(options);
                    });
                } else {
                    $.ajax({
                        url: options["href"],
                        type: options["httptype"] || "GET",
                        data: options["param"],
                        success: function (result) {
                            if (typeof (result) == "string") {
                                var splitstr = "<samp>$====================================$</samp>";
                                if (result.indexOf(splitstr) > -1) {
                                    result = result.split(splitstr)[0];
                                }
                                d.find(".modal-body").html(result);

                                d.find(".modal-body").data("dialog", d);
                                d.Format();
                                options.Format();
                                options.onLoad2(options);
                            } else {
                                if (!result.State && !result.NoLogin) {
                                    options["load"]({ href: "/Login?window=true", httptype: "GET", login: true });
                                    return;
                                }
                                d.find(".modal-body").html('<div class="c4" style=" padding-top: 50px; height: 150px; text-align: center;">' + result.Message + '</div>');
                                d.Format();
                                options.Format();
                                options.onLoad2(options);
                            }

                        },
                        error: function (e) {
                            $.alert('提交失败' + e.responseText);
                        }
                    });
                }
            } else if (options["content"]) {
                d.find(".modal-body").html(options["content"]);
                d.Format();
                options.onLoad2(options);
            }
        }
        d.find(".modal-dialog,.popover").data("options", options);
        options.load();
    }
    //=======end dialog
});


jQuery.fn.extend({
    //===list
    List: function (fn) {
        this.each(function () {
            var datagrid = $(this);
            var listbox = datagrid.find(".list-box");
            var options = datagrid.data("options")
            if (!options) {
                options = {};
                try {
                    options = eval("({" + datagrid.attr("data") + "})");
                } catch (e) { }
                if (datagrid.attr("url")) {
                    options["url"] = datagrid.attr("url");
                }
                options["list"] = listbox;
                if (!options["pagesize"]) {
                    options.pagesize = 10;
                }
                //=================load
                options.load = function (op) {
                    var index = 0;
                    if (op != undefined && op["index"]) {
                        index = op.index;
                    } else {
                        index = listbox.find(".page").find(".no").attr("page");
                    }
                    options["list"].html("<div style=\" width:" + options.list.width() + "px; height:" + options.list.height() + "px;\">Loading...</div>");
                    var parameter = "&pageindex=" + index + "&pagesize=" + options.pagesize;
                    if (op && op.parameter) {
                        parameter += "&" + op.parameter;
                    }
                    var url = options.url;
                    if (url.indexOf("?") > -1) {
                        url += "&part=true";
                    } else { url += "?part=true" }
                    $.ajax({
                        "dataType": 'html',
                        "type": "POST",
                        "url": url,
                        "data": parameter,
                        "success": function (htm) {
                            var splitstr = "<samp>$====================================$</samp>";
                            if (htm.indexOf(splitstr) > -1) {
                                listbox.html(htm.split(splitstr)[0]);
                            } else {
                                listbox.html(htm);
                            }
                            listbox.Format();
                            listbox.find(".dialog,.file").data("parent", options);
                            listbox.find(".dialog[closeLoad='true'],.file[closeLoad='true']").data("parent", { load: options.load, close: options.load });
                        }
                    });
                }
                datagrid.find(".dialog,.file").data("parent", options);
                listbox.find(".dialog[closeLoad='true'],.file[closeLoad='true']").data("parent", { load: options.load, close: options.load });
                //==============end loads
                options.parameter = function () {
                    // console.log("parameter", datagrid.find(".PageSearch"))
                    return datagrid.find(".PageSearch").find("form").serialize();
                }
                options.search = function (op) {
                    options.load({ index: op.index, parameter: options.parameter() + (op != undefined && op.param != undefined ? "&" + op.param : ""), dow: (op != undefined && op.dow != undefined ? "&" + op.dow : false) });
                }
                datagrid.find(".PageSearch").on("click", ".btn-success,.btn-search", function () {
                    options.search({ param: $(this).attr("param") });
                });
                datagrid.find(".PageSearch").on("click", ".btn-dow", function () {
                    options.search({ param: $(this).attr("param"), dow: true });
                });

                options.Order = function () {
                    var orderBut = $(this);
                    if (datagrid.find(".PageSearch").find("#order").size() == 0) {
                        var ds1 = document.createElement("samp");
                        $(ds1).html("<input id='order' name='order' type='hidden' value='ID' />");
                        datagrid.find(".PageSearch").find("form").append(ds1);
                    }
                    if (datagrid.find(".PageSearch").find("#orderAsc").size() == 0) {
                        var ds1 = document.createElement("samp");
                        $(ds1).html("<input id='orderAsc' name='orderAsc' type='hidden' value='false' />");
                        datagrid.find(".PageSearch").find("form").append(ds1);
                    }
                    datagrid.find(".PageSearch").find("#order").val(orderBut.attr("order"));
                    datagrid.find(".PageSearch").find("#orderAsc").val(orderBut.attr("orderAsc") == "False" ? "false" : "true");
                    options.search({ index: 1 });
                }
                listbox.on("click", ".jon-order,i", function () {
                    var event = arguments[0] || window.event;
                    if (event.preventDefault) {
                        event.preventDefault();
                    } else {
                        event.returnValue = false;
                    }
                    if ($(this).is("i")) {
                        options.Order.call($(this).parents(".jon-order")[0]);
                    } else {
                        options.Order.call(this, event);
                    }
                });
                //===============page
                options.page = function (index) {
                    options.search({ index: index });
                }
                options.refresh = function () {
                    options.search({ index: listbox.find(".page").find(".no").attr("page") });
                }
                listbox.on("click", ".page .p", function (e) {
                    if (e.preventDefault) {
                        e.preventDefault();
                    } else {
                        e.returnValue = false;
                    }
                    options.page($(this).attr("page"));
                });
                options.Delete = function (url) {
                    $.ajax({
                        "dataType": 'json',
                        "type": "POST",
                        "url": url,
                        "success": function (json) {
                            $.alert(json.Message, function () {
                                if (json.State) {
                                    options.refresh();
                                }
                            });
                        }
                    });
                };

                listbox.on("click", ".delete", function (e) {
                    if (e.preventDefault) {
                        e.preventDefault();
                    } else {
                        e.returnValue = false;
                    }
                    var that = $(this);
                    var ms = "确定删除该记录吗！";
                    if (that.attr("message")) {
                        ms = that.attr("message");
                    }
                    $.confirm(ms, function () {
                        that.hide();
                        options.Delete(that.attr("href"));
                    });

                });
                //====================delete end
                datagrid.data("options", options);

            }
            if (fn == "load") {
                options.load();
            } else if (fn == "refresh") {
                options.refresh();
            }
        });
    },
    select3: function (cmd, v, opt) {
        if (cmd == "val") {
            if ($(this).size() > 0) {
                $(this).data("select3val").call($(this).parents(".select3"), v);
            }
        } else if (cmd == "url") {
            var select3 = $(this).parents(".select3");
            var input = $(this);
            select3.find(".dropdown-menu > li").empty();
            $.getJSON(v, { _r: Math.random() }, function (data) {
                var list = "";
                if (data.Data) {
                    $.each(data.Data, function (i, n) {
                        list += "<li><a href=\"javascript:void(0)\" value=\"" + n.Value + "\">" + n.Name + "</a></li>";
                    });
                    select3.find(".dropdown-menu").html(list);
                    if (data.Data.length > 0) {
                        select3.find(".dropdown-name").html(data.Data[0].Name);
                        select3.attr("value", data.Data[0].Value);
                        input.val(data.Data[0].Value);
                    }
                    if (opt && opt.success) {
                        opt.success.call(select3);
                    }
                }
            });
        }
        else {
            this.each(function () {
                var select3 = $(this);
                if ($(this).find(".select > a").size() > 0) {
                    var obj1 = { text: $(this).find(".select > a").text(), value: $(this).find(".select > a").attr("value") };
                    select3.find(".dropdown-name").html(obj1.text);
                    select3.attr("value", obj1.value);
                }
                $(this).find("input").data("select3val", function (v) {
                    if ($(this).find("li > a[value='" + v + "']").size() == 0) { return; }
                    var obj1 = { text: $(this).find("li > a[value='" + v + "']").text(), value: $(this).find("li > a[value='" + v + "']").attr("value") };
                    $(this).find(".dropdown-name").html(obj1.text);
                    select3.attr("value", obj1.value);
                    select3.find("input").val(obj1.value);
                    if (select3.attr("forName")) {
                        var forInput = $("input[name='" + select3.attr("forName") + "']");
                        forInput.val(obj.value);
                    }
                });
                $(this).on("click", ".dropdown-menu > li", function () {
                    select3.find("li").removeClass("select");
                    var obj = { text: $(this).find("a").text(), value: $(this).find("a").attr("value") };
                    $(this).addClass("select");
                    select3.find("input").val(obj.value);
                    select3.find(".dropdown-name").html(obj.text);
                    select3.find("input").change.call(select3.find("input"));
                    if (select3.attr("forName")) {
                        var forInput = $("input[name='" + select3.attr("forName") + "']");
                        forInput.val(obj.value);
                        forInput.change.call(forInput);
                    }
                });
            });
        }
    },
    //=========end list
    err: function () { this.css("border", "1px solid red"); },
    ok: function () { this.css("border", ""); }
    //=================AjaxSubmit
   , AjaxSubmit: function (op) {
       this.each(function () {
           var jqForm = $(this);
           if (jqForm.is("form") && !jqForm.valid()) {
               $.alert('请填写完整', function () {
                   if (op && op["fail"]) { op["fail"]({ State: false, Message: "提交失败" }); }
                   if (op.callbut) {
                       op.callbut.show();
                   }
               });
               return;
           }
           jqForm.SetData();
           if (jqForm.data("valid")) { jqForm.data("valid")(jqForm); }
           var param = "";
           if (jqForm.is("form")) {
               param = jqForm.serialize();
           }
           if (op.param) {

               param += (param == "" ? "" : "&") + op.param;
           }
           $.ajax({
               url: op["action"] || jqForm.attr("action"),
               type: "post",
               data: param,
               success: function (result) {
                   if (typeof (result) == "object") {
                       if (result.State == false) {
                           if (op && op["failure"]) {
                               op["failure"](result, op);
                               if (op.callbut) {
                                   op.callbut.show();
                               }
                           } else {
                               $.alert(result.Message, function () {
                                   if (op.callbut) {
                                       op.callbut.show();
                                   }
                               });
                           }
                           return;
                       } else {
                           if (op && op["success"]) {
                               if (op.but) {
                                   op["success"].call(op.but, result, op);
                               } else {
                                   op["success"](result, op);
                               }
                           } else {
                               $.alert(result.Message, function () {
                                   window.location.href = result.Data.href;
                               });
                           }
                       }
                   } else {
                       if (op && op["success"]) {
                           op["success"](result, op);
                       } else {
                           jqForm.html(result);
                           jqForm.Format();
                       }
                   }
               },
               error: function () {
                   if (op && op["fail"]) { op["fail"]({ State: false, Message: "提交失败" }); } else {
                       $.alert('提交失败', function () {
                           if (op.callbut) {
                               op.callbut.show();
                           }
                       });
                       return;
                   }
                   if (op.callbut) {
                       op.callbut.show();
                   }
               }
           });

       });
   },
    Dialogfor: function () {
        this.each(function () {
            $(this).click(function (event) {
                if (event.preventDefault) {
                    event.preventDefault();
                } else {
                    event.returnValue = false;
                }
                var href = $(this).attr("dialog-href");
                $(this).attr("href", href);
                $(this).Dialog(event);
            })

        });
    }
    //===========================AjaxSubmit end
    , linkage: function () {
        this.each(function () {
            var This = $(this);
            var higher = $("#" + This.attr("linkage"));
            if (higher.size() > 0) {
                higher.on("change", function () {
                    $.getJSON(This.attr("linkage-url") + "/" + higher.val(), function (data1) {
                        var v = This.val();
                        This.select2({
                            data: data1, initSelection: function (element, callback) {
                                var text1 = ""; var id = element.val()
                                $.each(data1, function (i, n) {
                                    if (n.id == id) { text1 = n.text; }
                                });
                                var data2 = { id: element.val(), text: text1 };
                                callback(data2);
                            }
                        });
                    });
                });
                if (higher.val() != "") {
                    higher.change();
                }
            }
        });
    }
    //======================================
    , Dialog: function (event) {
        if (event.preventDefault) {
            event.preventDefault();
        } else {
            event.returnValue = false;
        }
        var that = $(this);
        var options = that.data("options");
        if (!options) { options = {}; }
        if (that.data("parent")) {
            options.parent = that.data("parent");
        }
        if (that.attr("success")) {
            try {
                options["success"] = eval("(function(data,options){  if(data.Message){ $.alert(data.Message,function(){" + that.attr("success") + "});return;} " + that.attr("success") + ";})");
            } catch (e1) { }
        }
        $.modal({
            but: that,
            onBeforeLoad: options["onBeforeLoad"],
            title: that.attr("title") || that.text() || "系统",
            width: that.attr("width") || 800,
            height: that.attr("height") || 600,
            autoHeight: that.attr("autoHeight") != undefined,
            modal: true,
            httptype: that.attr("method") || "get",
            submit: that.attr("submit") != undefined,
            submitAction: that.attr("submithref") || that.attr("href") + (that.attr("href").indexOf("?") > 0 ? "&" : "?") + that.attr("param"),
            submitText: that.attr("butName") || "保存",
            href: that.attr("href"),
            onLoad: options["onLoad"],
            param: that.attr("param"),
            success: options["success"],
            parent: options.parent
        });
    }, Format: function () {
        if ($(this).ExtensionFormat) {
            $(this).ExtensionFormat();
        }
        $(this).find(".select3").select3();
        $(this).find("select").select2();
        $(this).find(".file").File();
        $(this).find(".data-grid").List();
        //$(this).find('.keditor').Ckeditor(); 
        //$(this).find(".numeral").numeral();
        $(this).find(".linkage").linkage();
        $(this).find(".checkboxall").CheckboxSelectAll();
        $(this).find(".dialogfor").Dialogfor();
        // $(this).find('input[type=checkbox],input[type=radio]').uniform();
    }
    ,  
    //黑色盖板
    MB: function (message, mode) {
        this.each(function (eva) {
            if ($("body").data("Mask")) {
                $("body").data("Mask").remove();
                $("body").removeData("Mask");
            }
            var top = (($("body").height() - 50) / 2);
            top += $(document).scrollTop();
            var left = (($("body").width() - 200) / 2);
            var html = '<div class="maskloading modal-dialog" style="background: #fff;width: 300px;text-align: center;position:absolute;z-index:1000;top:' + top + 'px;;left:' + left + 'px;">' + message + '</div>';
            if (mode == true || mode == undefined) {
                html += '<div class="mask modal-backdrop fade in" style="z-index:800;"></div>';
            }

            var w = $(html);
            $("body").data("Mask", w);
            $("body").append(w);
        });
    },
    MBClear: function () {
        this.each(function (eva) {
            if ($("body").data("Mask")) {
                $("body").data("Mask").remove();
                $("body").removeData("Mask");
            }
        });
    },
    SetData: function () {
        //        for (instance in CKEDITOR.instances) {
        //            CKEDITOR.instances[instance].updateElement();
        //        }
    }, Ckeditor: function () {
        //        this.each(function () {
        //            var that = $(this);
        //            CKEDITOR.replace(that.attr("name"), { filebrowserImageBrowseUrl: '/Content/PlugIn/CKfinder/ckfinder.html?Type=FloImgs', toolbar: 'Basic' });
        //        });
    }
    //==================
    , File: function (event) {
        this.each(function () {
            var that = $(this)
            var multiple = that.attr("multiple");
            var type = that.attr("type");
            var value = that.attr("value");
            var butText = that.text() || "上传";
            var id = that.attr("id");
            if (id == undefined) {
                id = parseInt(Math.random() * 1000000 + 1);
                that.attr("id", id);
            }
            var parent = undefined;
            if (that.data("parent")) {
                parent = that.data("parent");
            }
            var url = "/admin/Upload/Default";
            if (that.attr("href")) {
                url = that.attr("href");
                that.attr("href", "javascript:void(0)");
            }
            if (!that.attr("file")) {
                var html = "<span class='result'>";
                if (value) {
                    var values = value.split(",")
                    for (var i = 0; i < values.length; i++) {
                        if (values[i] != "" && values[i] != undefined) {
                            html += "<span>";
                            if (values[i].fileType() == "img") {
                                html += "<img src='" + values[i] + "' class=\"uploadImg\" />";
                            } else {
                                html += "<a  href='" + values[i] + "' target='_blank'><img src='/Content/PlugIn/Separate/imgs/file.gif' title=\"" + values[i].substr(values[i].lastIndexOf("/") + 1) + "\" /></a>";

                            }
                            html += "<input value='" + values[i] + "'  type='hidden'  name='" + id + "'  /><a href='javascript:void(0)' class='deleteimg'>删除</a></span>";
                        }
                    }
                }
                html += "</span><form class=\"nobut\" id=\"form" + id + "\" action=\"\" method=\"POST\" enctype=\"multipart/form-data\">"
                + "<a href=\"#\" class=\"u-upload\"><button type=\"button\">" + butText + "</button><input class=\"filebut\"  type=\"file\" name=\"filedata\" id=\"file" + id + "\" value=\"\"  /></a>";
                html += "</form>";
                that.html(html);
                that.attr("file", true);
                that.find(".deleteimg").click(function () {
                    $(this).parent().remove();
                });
            }
            var up = function () {
                $.ajaxFileUpload({
                    url: url,
                    secureuri: false,
                    fileElementId: "file" + id,
                    dataType: 'json',
                    data: {},
                    success: function (data, status) {
                        if (data.State) {
                            if (!data.Data || !data.Data.url) {
                                if (that.data("parent")) { that.data("parent").search(); };
                                $.alert(data.Message || data.err);
                                return;
                            }
                            if (!that.data("success")) {
                                var html = "";
                                if (data.Data.url.fileType() == "img") {
                                    html += "<img src='" + data.Data.url + "' class=\"uploadImg\" />";
                                } else {
                                    html += "<a  href='" + data.Data.url + "' target='_blank'><img src='/Content/PlugIn/Separate/imgs/file.gif' title=\"" + data.Data.url.substr(data.Data.url.lastIndexOf("/") + 1) + "\" /></a>";
                                }
                                html += "<input value='" + data.Data.url + "'  type='hidden'  name='" + id + "'  />";
                                if (multiple) {
                                    that.find(".result").append("<span>" + html + "<a href='javascript:void(0)' class='deleteimg'>删除</a></span>");
                                    that.find(".deleteimg").click(function () {
                                        $(this).parent().remove();
                                    });
                                } else {
                                    that.find(".result").html(html);
                                }
                            } else {
                                that.data("success")(data.Data);
                            }

                        } else {
                            if (!data.notFile) {
                                $.alert(data.Message || data.err);
                            }
                        }
                        that.find(".filebut").unbind("change");
                        that.find(".filebut").change(function () { up(); });
                    },
                    error: function (data, status, e) {
                        $.alert(e);
                        that.find(".filebut").unbind("change");
                        that.find(".filebut").change(function () { up(); });
                    }
                });
            }
            that.find(".filebut").unbind("change");
            that.find(".filebut").change(function () { up(); that.find(".filebut").change(function () { up(); }); });
        });
    }
    //===========File
   , ShowMessage: function (message) {
       this.each(function () {
           $(this).html(message);
           $(this).fadeIn("fast", function () {
               $(this).fadeOut(3000);
           });
       })
   }, CheckboxSelectAll: function (message) {
       this.each(function () {
           var that = $(this);
           var thatList = $(this).parents(".checkAllBox").find(".checkItem");
           that.change(function () {
               thatList.prop("checked", $(this).prop("checked"));
           });
       })
   }
});
//============ 扩展基本方法
String.prototype.replaceTemp = function (old, New) {
    return this.replace(/(\s*<!--\s*)|(\s*-->\s*$)/g, "").replaceAll(old, New);
}
String.prototype.fileType = function () {
    if (/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test(this)) {
        return "img";
    }
    return "file";
}
String.prototype.replaceAll = function (old, New) {
    var re = new RegExp(old, "g");
    return this.replace(re, New);
};
String.prototype.asInt = function () {
    return parseInt(this);
};
 
//
$(document).on("click", ".ajaxsubmit", function (e) {
    if (event.preventDefault) {
        event.preventDefault();
    } else {
        event.returnValue = false;
    }
    var options = $(this).data("options");

    if (options == undefined) { options = {}; }
    if (options["valid"] == undefined && $(this).attr("valid")) { options["valid"] = eval("(function(that){  " + $(this).attr("valid") + ";})"); }
    if (options["success"] == undefined && $(this).attr("success")) {
        try {
            options["success"] = eval("(function(data,options){if(data.Message){ $.alert(data.Message,function(){" + $(this).attr("success") + "});return;}" + $(this).attr("success") + "; })");
        } catch (e1) { }
    }
    if (options["failure"] == undefined && $(this).attr("failure")) {
        try {
            options["failure"] = eval("(function(data,options){if(data.Message){ $.alert(data.Message,function(){" + $(this).attr("success") + "});return;}" + $(this).attr("failure") + "; })");
        } catch (e1) { }
    }
    if ($(this).attr("action")) {
        options["action"] = $(this).attr("action");
    } else if ($(this).attr("href")) {
        options["action"] = $(this).attr("href");
    }
    if ($(this).attr("param")) {
        options["param"] = $(this).attr("param");
    }
    if (options && options["valid"]) {
        var valid = options.valid($(this));
        if (valid == false) { return false; }
    }
    options.callbut = $(this);
    $(this).hide();
    var f = $(this).parents("form:eq(0)");
    if (f.size() > 0) {
        f.AjaxSubmit(options);
    } else {
        $(this).AjaxSubmit(options);
    }
    return false;
});

$(document).on("click", ".dialog", function (e) {
    $(this).Dialog(e);
});
$(document).on("click", ".uploadImg", function (e) {
    if (event.preventDefault) {
        event.preventDefault();
    } else {
        event.returnValue = false;
    }
    var that = $(this);
    $.modal({
        but: that,
        title: that.attr("title") || "系统",
        width: that.attr("width") || 800,
        height: that.attr("height") || 600,
        modal: true,
        content: "<div style=\" width:800px;max-height:500px;overflow:auto\"><img src='" + that.attr("src") + "' /><div>"
    });
});

function Dialog(that, e) {
    $(that).Dialog(e);
}
$(function () {
    $("body").Format();
});



