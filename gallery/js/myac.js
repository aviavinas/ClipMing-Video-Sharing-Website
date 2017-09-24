   "use strict";

$(".bottom-rt-sec li").hover(
	function() {
	   $(this).find(".editF").css("opacity","1");
	},
	function() {
	   $(this).find(".editF").css("opacity","0");
	}
);
$(".bottom-rt-sec li i").click(function() {
	if($(this).hasClass("saveF")) {
		var _inp = $(this).parent().find(".inp"),
		_dat = _inp.attr("name") + ":" + _inp.val();
		if(_inp.attr("name") == "nm") {
			_dat = "nm:" + _inp[0].value +":" + _inp[1].value;
		}
		else if(_inp.attr("name") == "dob_day") {
			_dat = "dob:" + _inp[2].value +"-" + _inp[1].value +"-" + _inp[0].value;
		}
		console.log(_dat);
		updt(_dat);
	}
});

$(".editF").click(function(e) {
	e.preventDefault();
	
	$(this).parent().find(".vl").find("span").css("display", "none");
	$(this).parent().find(".inp").css("display", "inline-block");
	$(this).html("<span>Save</span>");
	$(this).removeClass("fa-pencil-square-o");
	$(this).addClass("fa-check saveF");
});
$(".bottom-lt-sec li").click(function() {
	$(".bottom-lt-sec li").removeClass("tab-active");
	$(this).addClass("tab-active");
	
	var el = $(this).attr("id");
	$(".bottom-rt-sec div").hide(500);
	$(".bottom-rt-sec").find("."+el).show(500);
});

function updt(dt) {
	$.ajax({
		type: 'POST',
		url: '?update=true',
		data: { FormDat: dt},
		cache: false,
		success:function(data){
			console.log("success");
			console.log(data);
		},
		error: function(data){
			console.log("error");
			console.log(data);
		}
	});
}