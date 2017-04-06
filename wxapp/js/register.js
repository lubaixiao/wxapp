$(document).ready(function () {
   
    /*
     var page2 = $("#register_view");//
     var hammerPage2 = new Hammer(page2[0]);
     hammerPage2.get('swipe').set({ direction: Hammer.DIRECTION_ALL });//添加支持上下滑动事件。
     hammerPage2.on('swipeup swipedown',chuli);*/
});

function chuli() {
    return  $.alert("滑动了");
    $("#register_view").pullToRefresh();
    $("#register_view").on("pull-to-refresh", function () {
        alert("下拉更新了！");
        setTimeout("$(\"#register_view\").pullToRefreshDone();", 3000);
    });
}

function readRegisterAgreement() {
    $("#register_form_inputs, #register_form_buttons").hide();
    $("#register_agreement").show();
}
function closeRegisterAgreement() {
    $("#register_agreement").hide();
    $("#register_form_inputs, #register_form_buttons").show();
    
}

function registerGoLogin(){
    loginOrRegister();
}