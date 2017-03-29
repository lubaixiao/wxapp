var view = {
    "about_developer": "",
    "register": "",
    "video": "",
    "score": "",
    "bbs": "",
    "live": ""
};

$(function () {
    FastClick.attach(document.body);
});
$(document).ready(function () {
    setTabbar();
    // getChengjiData();
    $(".aside").blur(function () {
        $(".weui_tabbar>a").unbind("click");
        $(this).animate({
            left: '-60%'
        });
        setTimeout("setTabbar()", 500);
    });
    $.hevent({
        obj: $("#score"),
        eve: "tap",
        fun: goScore
    });
    $.hevent({
        obj: $("#about_developer"),
        eve: "tap",
        fun: goAbout_developer
    });
    $.hevent({
        obj: $("#video"),
        eve: "tap",
        fun: goVideo
    });
    $.hevent({
        obj: $("#live"),
        eve: "tap",
        fun: goLive
    });

    //	$("#main_view").pullToRefresh();
    //	$("#main_view").on("pull-to-refresh", function() {
    //		//do something
    //		alert("刷新了！");
    //		$(document.body).pullToRefreshDone();
    //	});

});

function setTabbar() {
    $(".weui_tabbar>a").click(function () {
        if ($(this).index() === 0) {
            $(".aside").animate({
                left: '0%'
            });
            $(".aside").focus();
        } else {
            $(".weui_tabbar>a").removeClass("weui_bar_item_on");
            $(this).addClass("weui_bar_item_on");
            switch ($(this).index()) {
                case 1:
                    goVideo();
                    break;
                case 2:
                    goScore();
                    break;
                case 3:
                    loginOrRegister();
                    goBbs();
                    break;
                default:
                    break;
            }

        }
    });

}

function loginOrRegister() {
    $("#home_menu").hide();
    $.modal({
        title: "提示",
        text: "请登录或注册后再操作！",
        buttons: [{
                text: "登录",
                onClick: function () {
                    $.login({
                        title: '会员登录',
                        text: '请输入用户名和密码',
                        onOK: function (username, password) {
                            //点击确认
                            alert(username + "  " + password);
                            $("#home_menu").show();
                        },
                        onCancel: function () {
                            //点击取消
                            $("#home_menu").show();
                        }
                    });
                }
            }, {
                text: "注册",
                onClick: function () {
                    goRegister();
                }
            }, {
                text: "取消",
                className: "default",
                onClick: function () {
                    console.log(3)
                }
            }, ]
    });
}

//关于
function goAbout_developer() {
    view.about_developer = goView("about_developer", view.about_developer);
}

//注册
function goRegister() {
    view.register = goView("register", view.register);
}

//视频
function goVideo() {
    view.video = goView("video", view.video);
}

//我的成绩
function goScore() {
    view.score = goView("score", view.score);
}

//论坛
function goBbs() {
    view.bbs = goView("bbs", view.bbs);
}

//直播
function goLive() {
    view.live = goView("live", view.live);
}

//go通用
function goView(key_word, view_val) {
    $(".aside").animate({
        left: '-60%'
    });
    if (view_val === "") {
        var url = "htmlCreater.php";
        var json = {
            "need": key_word
        };
        $.myAjax({
            url: url,
            data: json,
            fun: function (json) {
                $("#main>div").hide();
                $("#main").append(json.data);
                switch (key_word) {
                    case "about_developer":
                        break;
                    case "register":

                        break;
                    case "video":

                        break;
                    case "score":
                        loadStyles("css/score.css");
                        loadScript("js/Chart.min.js");
                        loadScript("js/score.js");
                        break;

                    case "bbs":
                        break;
                    case "live":
                        loadScript("js/live.js");
                        break;
                    default:

                        break;
                }
            }
        });
    } else {
        $("#main>div").hide();
        $("#" + key_word + "_view").show();
    }
    return key_word;
}

// 动态加载js脚本文件
function loadScript(url) {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = url;
    document.body.appendChild(script);
}

// 动态加载css文件
function loadStyles(url) {
    var link = document.createElement("link");
    link.type = "text/css";
    link.rel = "stylesheet";
    link.href = url;
    document.getElementsByTagName("head")[0].appendChild(link);
}

//隐藏底部菜单
function mianMeunHide() {
    $("#home_menu").hide();
}

//显示底部菜单
function mianMeunShow() {
    $("#home_menu").show();
}

function test() {
    var json = {"user":"king","pwd":"123456","arr":Array(1,2,3,4)};
    var url = "webAction.php?action=getHtml";
    $.myAjax({
        url: url,
        data: json,
        fun: function (json) {
            console.log(json);
        }});
}