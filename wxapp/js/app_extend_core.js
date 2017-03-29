$.extend({//便捷扩展手机触屏事件
    hevent: function (option) {
        if (!option.obj || !option.eve || !option.fun) {
            alert("参数不全");
        } else {
            //创建一个新的hammer对象并且在初始化时指定要处理的dom元素 
            var hammertime = new Hammer(option.obj[0]);
            //添加事件
            hammertime.on(option.eve, option.fun);
        }
    }
});

$.extend({//统一数据交互
    myAjax: function (option) {
        if (!option.url) {
            alert("请求地址不能为空！");
        }
        var data = {"jsonData": ""};
        if (option.data || option.data !== undefined) {
            data.jsonData = option.data;
        }
        $.ajax({
            url: option.url,
            type: "POST",
            data: data,
            dataType: "JSON",
            cache: false,
            error: function () {
                alert("数据获取失败！");
            },
            success: function (json) {
                (json.msg !== undefined) ? alert(json.msg) : option.fun(json);
            }
        });
    }
});