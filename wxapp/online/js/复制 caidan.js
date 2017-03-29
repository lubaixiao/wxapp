var father_menu=new Array("主菜单一","主菜单二","主菜单三");
var son_menu1=new Array();
var son_menu2=new Array();
var son_menu3=new Array();
var son_menu1_msg=new Array();
var son_menu2_msg=new Array();
var son_menu3_msg=new Array();
var addsonmenu1 = "<div class=\"addzicaidan\" onclick=\"addSonMenu1()\"><p class='text-center'><span class='glyphicon glyphicon-plus'></span></p></div>";
var addsonmenu2 = "<div class=\"addzicaidan\" onclick=\"addSonMenu2()\"><p class='text-center'><span class='glyphicon glyphicon-plus'></span></p></div>";
var addsonmenu3 = "<div class=\"addzicaidan\" onclick=\"addSonMenu3()\"><p class='text-center'><span class='glyphicon glyphicon-plus'></span></p></div>";
$(document).ready(function(){
	
	for(var i=0; i<3;i++){
		$(".caidan").eq(i).html(father_menu[i]);	
	}
	
	$("#father_menu1").click(function(){
		setMenu1();	
		$("#father_menu1").addClass("caidanAction");
		
	});
	
	$("#father_menu2").click(function(){
		setMenu2();	
	});
	
	$("#father_menu3").click(function(){
		setMenu3();
	});
	
});
function setMenu1(){
	var len = son_menu1.length;
	var str= "";
	if(son_menu1.length===0){
		$("#son_menu1").html(addsonmenu1);
	}
	for(x in son_menu1){
		str += "<div class=\"zicaidan\">"+son_menu1[x]+"</div>";
	}
	if(len===5){
		$("#son_menu1").html(str);
	}else{
		$("#son_menu1").html(addsonmenu1+str);
	}
	
	$("#son_menu2,#son_menu3").hide();
	$("#son_menu1").show();
}
function addSonMenu1(){
	var len = son_menu1.length;
	var str = "";
	
	if(len===5){
		for(x in son_menu1){
			str += "<div class=\"zicaidan\">"+son_menu1[x]+"</div>";
		}
		$("#son_menu1").html(str);
	}else{
		son_menu1[len] = "子菜单";
		for(x in son_menu1){
			str += "<div class=\"zicaidan\">"+son_menu1[x]+"</div>";
		}
		console.log(son_menu1);
		if(len===4){
			$("#son_menu1").html(str);
		}else{
			$("#son_menu1").html(addsonmenu1+str);
		}
	}
	
	
}

function setMenu2(){
	var len = son_menu2.length;
	var str= "";
	if(son_menu2.length===0){
		$("#son_menu2").html(addsonmenu2);
	}
	for(x in son_menu2){
		str += "<div class=\"zicaidan\">"+son_menu2[x]+"</div>";
	}
	if(len===5){
		$("#son_menu2").html(str);
	}else{
		$("#son_menu2").html(addsonmenu2+str);
	}
	
	$("#son_menu1,#son_menu3").hide();
	$("#son_menu2").show();
}
function addSonMenu2(){
	var len = son_menu2.length;
	var str = "";
	
	if(len===5){
		for(x in son_menu2){
			str += "<div class=\"zicaidan\">"+son_menu2[x]+"</div>";
		}
		$("#son_menu2").html(str);
	}else{
		son_menu2[len] = "子菜单";
		for(x in son_menu2){
			str += "<div class=\"zicaidan\">"+son_menu2[x]+"</div>";
		}
		console.log(son_menu2);
		if(len===4){
			$("#son_menu2").html(str);
		}else{
			$("#son_menu2").html(addsonmenu2+str);
		}
	}
	
	
}


function setMenu3(){
	var len = son_menu3.length;
	var str= "";
	if(son_menu3.length===0){
		$("#son_menu3").html(addsonmenu3);
	}
	for(x in son_menu3){
		str += "<div class=\"zicaidan\">"+son_menu3[x]+"</div>";
	}
	if(len===5){
		$("#son_menu3").html(str);
	}else{
		$("#son_menu3").html(addsonmenu3+str);
	}
	
	$("#son_menu1,#son_menu2").hide();
	$("#son_menu3").show();
}
function addSonMenu3(){
	var len = son_menu3.length;
	var str = "";
	
	if(len===5){
		for(x in son_menu3){
			str += "<div class=\"zicaidan\">"+son_menu3[x]+"</div>";
		}
		$("#son_menu3").html(str);
	}else{
		son_menu3[len] = "子菜单";
		for(x in son_menu3){
			str += "<div class=\"zicaidan\">"+son_menu3[x]+"</div>";
		}
		console.log(son_menu3);
		if(len===4){
			$("#son_menu3").html(str);
		}else{
			$("#son_menu3").html(addsonmenu3+str);
		}
	}
	
	
}

