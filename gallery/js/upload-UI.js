"use strict";

$(function() {
	
	$("#upload-trig").click(function() {
	  $("#file_input").trigger( "click" );
	});
	
	$("#metaForm").submit(function(e) {
		var formSerializeArray = $(e.target).serializeArray(),
		    CurrentFile = $("#file_input").prop('files'),
		    totalFiles = CurrentFile.length,
			dataLength = parseInt((formSerializeArray.length)/totalFiles),
			formData = {};
		for(var i=0; i<totalFiles; i++) {
			var data = {};
			for(var j=(i*dataLength); j<((i+1)*dataLength); j++) {
				var key = formSerializeArray[j].name;
				var val = formSerializeArray[j].value;
				data[key] = val;
				if(j==(((i+1)*dataLength)-1)) { // This is last iteration of this loop
					var fileHash = md5((CurrentFile[i].name)+(CurrentFile[i].type)+(CurrentFile[i].size));
					data.hash = fileHash;
				}
			}
			formData[i] = data;
		}
		var jsonFormData = JSON.stringify(formData);
		
		$.ajax({
			type: "POST",
			url: "../media/upload.php",
			data: {FormData: jsonFormData},
			dataType: "json",
			success: function(data){console.log("succeed");console.log(data.responseText);},
			error: function(data){console.log("eror");console.log(data.responseText);},
			failure: function(errMsg) {console.log("fail");
				console.log(data);
			}
		});
		
		e.preventDefault();
		return false;
    });
	
	$('#file_input').change(function() {
		$("#upload-fs").hide(100);
		$("#upload-cont").show(1000);
		$("#submit").trigger( "click" );
		$(".fa-chevron-down:first").trigger( "click" );
	});
});

var formatTime = function (s) {
			var time = "Calculating ...";
			if (s == 0) {time = "";}
			else if (s < 60) {time = "About "+Math.round(s)+" seconds remaining.";}
			else if (s < 3600) {time = "About "+Math.round(s/60)+" minutes remaining.";}
			else if (s < 86400) {time = "About "+Math.round(s/3600)+" hours and "+Math.round((s%3600)/60)+" minutes remaining.";}
			else { time = "More than a day is remaining.";}
			
			return time;
};

var formatSize = function(bytes) {
							if (typeof bytes !== 'number') {
								return '';
							}
							if (bytes >= 1000000000) {
								return (bytes / 1000000000).toFixed(2) + ' Gb';
							}
							if (bytes >= 1000000) {
								return (bytes / 1000000).toFixed(2) + ' Mb';
							}
							return (bytes / 1000).toFixed(2) + ' Kb';
						};
						
var generateFileList = function() {
	var fileList = $("#file_input"),
		files = fileList.prop('files'), // Files Array
		totalFiles = files.length;

		if(totalFiles>0) {
			printHead();
			for(var i=0; i<totalFiles; i++) {
				printList(files[i], i);
			}	
		}
    },
	
	printHead = function() {
		var head = '<div class="vid-cont layout-head"><div class="lt-head"><p>Uploaded 2 of 5</p></div><div class="md-head"><div class="progress"><div class="progress-bar progress-bar-striped active vtotal" id="totalProg" style="width: 0%;">0%</div></div><div id="prog-info"></div></div><div class="rt-head"><button type="submit" id="publish">Publish All</button><select><option>Public</option><option>Private</option><option>Unlisted</option></select></div><div class="clear-both"></div></div>';
		$('#upload-sc').append(head);
	},
	
	printList = function(file, fileIndex) {
		window.URL = window.URL || window.webkitURL;
		var fileName = file.name,
			fileSize = formatSize(file.size),
		    fileUrl = window.URL.createObjectURL(file),
			
			video = '<div class="vid-cont"><div class="head-lt"><h4>'+fileName+'</h4></div><div class="head-rt"><p class="upload-file-size">'+fileSize+'</p><div class="progress"><div class="progress-bar progress-bar-striped active vIn'+fileIndex+'" style="width: 0%;">0%</div></div><i class="fa fa-times" vid="'+fileIndex+'" aria-hidden="true" style="font-size:20px"></i></div><div class="layout-exp clear-both"><i class="fa fa-chevron-down" aria-hidden="true"></i></div><div class="meta-cont"><div class="meta-input lt-meta"><video width="300" height="220" controls><source src="'+fileUrl+'" type="video/mp4"></video></div><div class="meta-input"><input type="text" name="title" class="input-meta v_title fe" placeholder="Title" value="'+fileName+'"><textarea name="description" placeholder="Description" class="input-meta v_desc fe"></textarea><input type="text" name="tag" class="input-meta v_tag fe" placeholder="Tags (e.g., albert einstein, flying pig, mashup)"></div><div class="meta-input rt-meta"><label>Publish : <input type="checkbox" value="Publish" class="fe" name="publish" checked=""></label><label>Privacy : <select class="fe" name="privacy" data-initial-value="public"><option value="Public" selected="true">Public</option><option value="Unlisted">Unlisted</option><option value="Private">Private</option></select></label><label>Category : <select name="category" class="fe"><option label="Arts & Design" value="C1">Arts & Design</option><option label="Comedy" value="C2">Comedy</option><option label="Documentary" value="C3">Documentary</option><option label="Education" value="C4">Education</option><option label="Entertainment" value="C5">Entertainment</option><option label="Experimental" value="C6">Experimental</option><option label="Fashion" value="C7">Fashion</option><option label="Film & Animation" value="C8">Film & Animation</option><option label="Food" value="C9">Food</option><option label="Gaming" value="CA">Gaming</option><option label="Instructionals & Tutorial" value="CB">Instructionals & Tutorial</option><option label="Music" value="CC">Music</option><option label="News & Politics" value="CD">News & Politics</option><option label="Nonprofits & Activism" value="CE">Nonprofits & Activism</option><option label="People & Blogs" value="CF">People & Blogs</option><option label="Personal" value="CG">Personal</option><option label="Reporting & Journalism" value="CH">Reporting & Journalism</option><option label="Science & Technology" value="CI">Science & Technology</option><option label="Sports" value="CJ">Sports</option><option label="Travel & Events" value="CK">Travel & Events</option></select></label><button type="button"><i class="fi-list-thumbnails"></i> Add to playlist</button></div></div><div class="clear-both"></div></div>';
			$('#upload-sc').append(video);
	};



	$(".fe").change(function(){
        alert("The text has been changed.");
    });
	
	
