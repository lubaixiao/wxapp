var menuJson={"name":"", "type":"click", "url":"", "key":"welcome"};
$(document).ready(function(){
	sms.initMenus();
	$("input[name='content']").change(function(){
		alert($(this).val());
	});
	
	$("#keyurl").change(function(){
		alert(1231);
//		$("#keyword").val("");
//		$("#keyword").css("display","none");
	});
	
});

function addSonMenu(num){
	sms.addSonMenu(num);
}
function setMenus(){
	this.onfocusDivId = "";
	this.father_menu=new Array({"name":"主菜单一", "type":"click", "url":"", "key":"welcome"},{"name":"主菜单二", "type":"click", "url":"", "key":"welcome"},{"name":"主菜单三", "type":"click", "url":"", "key":"welcome"});
	this.son_menu1=new Array();
	this.son_menu2=new Array();
	this.son_menu3=new Array();
	this.addsonmenu1 = "<div class=\"addzicaidan\" onclick=\"addSonMenu(1)\"><p class='text-center'><span class='glyphicon glyphicon-plus'></span></p></div>";
	this.addsonmenu2 = "<div class=\"addzicaidan\" onclick=\"addSonMenu(2)\"><p class='text-center'><span class='glyphicon glyphicon-plus'></span></p></div>";
	this.addsonmenu3 = "<div class=\"addzicaidan\" onclick=\"addSonMenu(3)\"><p class='text-center'><span class='glyphicon glyphicon-plus'></span></p></div>";
	
	this.initMenus = function(){
		for(var i=0; i<3;i++){
			$(".caidan").eq(i).html(this.father_menu[i].name);	
		}
		
		$("#father_menu1").click(function(){
			sms.setMenu(1);	
		if(sms.onfocusDivId!=="")
			sms.onfocusDivId.removeClass("caidanAction");
			sms.onfocusDivId = $("#father_menu1");
			sms.onfocusDivId.addClass("caidanAction");
			
		});
		
		$("#father_menu2").click(function(){
			sms.setMenu(2);
			if(sms.onfocusDivId!=="")
			sms.onfocusDivId.removeClass("caidanAction");
			sms.onfocusDivId = $("#father_menu2");
			sms.onfocusDivId.addClass("caidanAction");
		});
		
		$("#father_menu3").click(function(){
			sms.setMenu(3);
			if(sms.onfocusDivId!=="")
			sms.onfocusDivId.removeClass("caidanAction");
			sms.onfocusDivId = $("#father_menu3");
			sms.onfocusDivId.addClass("caidanAction");
		});
		return this;
	};
	
	//设置主菜单
	this.setMenu = function(num){		
		if(num===1){
			var son_menu = this.son_menu1;
			var add_son = this.addsonmenu1;
		}else if(num===2){
			var son_menu = this.son_menu2;
			var add_son = this.addsonmenu2;
		}else if(num===3){
			var son_menu = this.son_menu3;
			var add_son = this.addsonmenu3;
		}else{
			return alert("参数无效!");
		}
		
		var divId = $("#son_menu"+num);
		var len = son_menu.length;
		var str = ""; 
		
		if(len===0){
			divId.html(add_son);
		}
		for(x in son_menu){
			str += "<div class=\"zicaidan\" data-num="+ num +" data-col="+(len-1-x)+" >"+son_menu[len-1-x].name+"</div>";
		}
		
		if(len===5){
			divId.html(str);
		}else{
			divId.html(add_son+str);
		}
		$(".son_menu").hide();
		divId.show();
		$("#son_menu"+num+"> .zicaidan").click(function(){
			sms.onfocusDivId.removeClass("caidanAction");
			sms.onfocusDivId = $(this);
			sms.inputMenu();
			sms.onfocusDivId.addClass("caidanAction");
		});
		if(sms.onfocusDivId!==""){
			sms.onfocusDivId.removeClass("caidanAction");
		}
		
		sms.onfocusDivId = divId;
		sms.inputMenu();
		sms.onfocusDivId.addClass("caidanAction");
		
		return this;
	};
	
	//添加子菜单
	this.addSonMenu = function(num){
		if(num===1){
			var son_menu = this.son_menu1;
			var add_son = this.addsonmenu1;
		}else if(num===2){
			var son_menu = this.son_menu2;
			var add_son = this.addsonmenu2;
		}else if(num===3){
			var son_menu = this.son_menu3;
			var add_son = this.addsonmenu3;
		}else{
			return alert("参数无效!");
		}
		
		var divId = $("#son_menu"+num);
		var len = son_menu.length;
	    var str = "";
	
		if(len===5){
			for(x in son_menu){
				str += "<div class=\"zicaidan\"  >"+son_menu[len-x].name+"</div>";
			}
			divId.html(str);
		}else{
			var son_json = menuJson;
			son_json.name= "子菜单"
			son_menu[len] = son_json;
			for(x in son_menu){
				str += "<div class=\"zicaidan\" data-num="+ num +" data-col="+(len-x)+" >"+son_menu[len-x].name+"</div>";
			}
			if(len===4){
				divId.html(str);
			}else{
				divId.html(add_son+str);
			}
		}
		
		$("#son_menu"+num+"> .zicaidan").click(function(){
			sms.onfocusDivId.removeClass("caidanAction");
			sms.onfocusDivId = $(this);
			sms.onfocusDivId.addClass("caidanAction");
			sms.inputMenu();
		});
		return this;
	};
	
	this.inputMenu= function(){
		var row = sms.onfocusDivId.attr("data-num");
		var col = sms.onfocusDivId.attr("data-col"); 
		var data ;
		alert("row:"+row);
		alert("col"+col);
		if(col==="-1"){
			$("#menu_main_type").html("主菜单");
			data = sms.father_menu[row-1];
			console.log(data);
			$("#menu_name").val(data.name);
			$("#keyword").val(data.key);
			
			
		}else{
			$("#menu_main_type").html("子菜单");
			if(row==="1"){
				data = sms.son_menu1[col];
				console.log(data);
				$("#menu_name").val(data.name);
				$("#keyword").val(data.key);
			}else if(row==="2"){
				data = sms.son_menu2[col];
				console.log(data);
				$("#menu_name").val(data.name);
				$("#keyword").val(data.key);
			}else if(row==="3"){
				data = sms.son_menu3[col];
				console.log(data);
				$("#menu_name").val(data.name);
				$("#keyword").val(data.key);
			}else{
				alert("error!")
			}
			
		}
		return this;
	};
	
}
var sms = new setMenus();
