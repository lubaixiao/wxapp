var liveData;
$(document).ready(function() {
			var url = "webAction.php?action=getLiveOnline";
			$.myAjax({
					url: url,
					data: "",
					fun: function(json) {
						if(json.url==100){
							return alert("人数已达上限");
						}
						liveData = json;
						if(50>json.online&&json.online>0){
							$("#dvLiveOnline").css("background-color","green");
						}else if(90>json.online&&json.online>=50){
							$("#dvLiveOnline").css("background-color","#AC2925");
						}else{
							$("#dvLiveOnline").css("background-color","red");
						}
						$("#dvLiveOnline").css("width",json.online+"%");
						$("#dvLiveOnline2").css("width",json.online+"%");
						$("#liveOnline").html(json.online+"/100");
						$("#liveOnline2").html(json.online);
						$("#liveCount").html(json.count);
						console.log(json);
						$("#ifram").attr("src","html/live_iframe.html");
					}
					});
			setInterval(function() {
				$.myAjax({
					url: url,
					data: "",
					fun: function(json) {
						liveData = json;
						if(50>json.online&&json.online>0){
							$("#dvLiveOnline").css("background-color","green");
							
						}else if(90>json.online&&json.online>=50){
							$("#dvLiveOnline").css("background-color","#AC2925");
						}else{
							$("#dvLiveOnline").css("background-color","red");
						}
						$("#dvLiveOnline").css("width",json.online+"%");
						$("#dvLiveOnline2").css("width",json.online+"%");
						$("#liveOnline").html(json.online+"/100");
						$("#liveOnline2").html(json.online);
						$("#liveCount").html(json.count);
						//console.log(json);
					}
					});
					
				}, 5000);
});
