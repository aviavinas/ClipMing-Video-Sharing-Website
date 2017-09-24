
$(function() {
"use strict";
	$("#logoEdit").click(function(e) {
		e.preventDefault();

        $("#ImageBrowse").trigger("click");
		$("#formRole").val("logoImg");
    });
	
	$("#artEdit, #addChannelArt").click(function(e) {
		e.preventDefault();

        $("#ImageBrowse").trigger("click");
		$("#formRole").val("artImg");
    });
	
	$('#imageUploadForm').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
		
		if($("#formRole").val() === "logoImg") {
			$("#logo-h1").css("display","none");
			$("#chLogoImg").css("display","inline-block");
			$("#chLogoImg").attr("src","ring.gif");
			$("#chLogoImg").css("background-color", "rgba(255, 255, 255, 0.91)");
		}
		else if($("#formRole").val() === "artImg") {
			$("#artBanner").attr("src","");
			$("#artBanner").css("background-image", "url(ring.gif)");
			$("#artBanner").css("background-size", "100px");
			$("#artBanner").css("background-repeat", "no-repeat");
			$("#artBanner").css("background-position-x", "575px");
			$("#artBanner").css("background-color", "rgba(0, 0, 0, 0.1)");
		}
		
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                console.log("success");
                console.log(data);
				if($("#formRole").val() === "logoImg") {
					  $("#chLogoImg").attr("src",data);
				}
				else if($("#formRole").val() === "artImg") {
					  $("#artBanner").attr("src",data);
				}
				$("#chLogoImg").css("background-color", "transparent");
				$("#artBanner").css("background-size", "initial");
				$("#artBanner").css("background-position-x", "initial");
				$("#artBanner").css("background-color", "#fff");
			},
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
    }));

    $("#ImageBrowse").on("change", function() {
        $("#imageUploadForm").submit();
    });

});

