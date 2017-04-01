var score_date="";
var score_setting = {"model":"1","zongping":"1","colnums":"1,3,10","tablestyle":"3"};

$(document).ready(function() {
	$.hevent({
		obj: $("#score_setting"),
		eve: "tap",
		fun: setScoreSetting
	});
	$.hevent({
		obj: $("#score_displayColunms"),
		eve: "tap",
		fun: getScoreNewColunms
	});
	initScore();	
	getScoreData();
});

function setScoreSetting() {
	$("#score_dvsetting").css("display", "block");
}

function getScoreNewColunms() {
	$("#score_dvsetting").css("display", "none");
	console.log(score_setting);
	if(score_setting.model==="2"){
		setTongji();
	}
}

function getScoreData() {
    var url = "webAction.php?action=getScore";
    $.myAjax({url: url, fun: dealScoreData});
}

function dealScoreData(json) {
	//alert(JSON.stringify(json));
    $("#score_jidian").val(json.data[0]);
    var cj = json.data[1];
    var str = "";
    for (var i = 0; i < cj.length; i++) {
        var e = cj[i];
        var str2 = "";
        for (j = 0; j < 14; j++) {
            str2 += "<td>" + e[j] + "</td>";
        }
        str += "<tr>" + str2 + "</tr>";
    }
    $("#score_tblbd").html(str);
    $("#loadingToast").css("display", "none");
    $("#toast").css("display", "block");
    setTimeout("$(\"#toast\").css(\"display\",\"none\")", 1000);
}

function initScore() {
	$("#score_model").select({
		title: "选择模式",
		autoClose: true,
		input: "表格数据",
		items: [{
			title: "表格数据",
			value: 1
		}, {
			title: "统计分析",
			value: 2
		}],
		onOpen: mianMeunHide,
		onClose: getSelectValues
	});

	$("#score_zongping").select({
		title: "选择总评线",
		autoClose: true,
		input: "全部",
		items: [{
			title: "全部",
			value: 1
		}, {
			title: "及格",
			value: 2
		}, {
			title: "不及格",
			value: 3
		}],
		onOpen: mianMeunHide,
		onClose: getSelectValues
	});

	$("#score_colnums").select({
		title: "选择显示列",
		input: "学号,学期,绩点",
		multi: true,
		items: [{
				title: "学号",
				value: 1
			}, {
				title: "姓名",
				value: 2
			}, {
				title: "学期",
				value: 3
			}, {
				title: "类别",
				value: 4
			}, {
				title: "学分",
				value: 5
			}, {
				title: "平时",
				value: 6
			}, {
				title: "期中",
				value: 7
			},
			{
				title: "期末",
				value: 8
			}, {
				title: "考试性质",
				value: 9
			}, {
				title: "绩点",
				value: 10
			}, {
				title: "课程代码",
				value: 11
			}, {
				title: "学时",
				value: 12
			},
		],
		onOpen: mianMeunHide,
		onClose: getSelectValues
	});

	$("#score_tablestyle").select({
		title: "选择表格样式",
		autoClose: true,
		input: "绿线行动",
		items: [{
			title: "经典黑白",
			value: 1
		}, {
			title: "暖色护眼",
			value: 2
		}, {
			title: "绿线行动",
			value: 3
		}],
		onOpen: mianMeunHide,
		onClose: getSelectValues
	});
}

function getSelectValues(){
	if($("#score_model").data("values")!==undefined){
		score_setting.model = $("#score_model").data("values");
	};
	if($("#score_zongping").data("values")!==undefined){
		score_setting.zongping = $("#score_zongping").data("values");
	};
	if($("#score_colnums").data("values")!==undefined){
		score_setting.colnums = $("#score_colnums").data("values");
	};
	if($("#score_tablestyle").data("values")!==undefined){
		score_setting.tablestyle = $("#score_tablestyle").data("values");
	};
    console.log(score_setting);
	mianMeunShow();
}
