var xhr = [];
var progUpload = [];
var started_at, totalUploads = 0, succeededUploads = 0;


$('#submit').click(function(e) {
	
	e.preventDefault();
	generateFileList();

	var f = document.getElementById('file_input');

	app.uploader({
		  files: f,
		  processor: '../media/upload.php',
		  
		  finished: function(data) {
			  for(x = 0; x < data.succeeded.length; x++) {
				  var uploadUrl = '../media/uploads/' + data.succeeded[x].file,
				  uploadName = data.succeeded[x].name;
			  }
			  
			  for(x = 0; x < data.failed.length; x++) {
				  var uploadName = data.failed[x].name;
			  }
			  $("#metaForm").submit();
			  
			  succeededUploads++;
			  $(".lt-head").text("Uploaded "+succeededUploads+" of "+totalUploads);
			  
		  },
		  error: function() {
			  console.log('Not Working');
		  }
	});
});

 // Main Uploader Application 
 
 var app = app || {};

(function(o) {
	
	// Private Method
	var ajax, getFormData, setProgress;
	
	ajax = function(data, fileIndex) {
		var xmlhttp = new XMLHttpRequest(), uploaded;
		xhr.push(xmlhttp);

		xmlhttp.addEventListener('readystatechange', function() {
			if(this.readyState === 4) {
				if(this.status === 200) {
					uploaded = JSON.parse(this.response);
					console.log(uploaded);
					
					if(typeof o.options.finished === 'function') {
						o.options.finished(uploaded);
					}
				} else {
					if(typeof o.options.error === 'function') {
						o.options.error();
					}
				}
				
			} 
		});
		
		function canceling() {
			// detach();
			xmlhttp.abort();
		}
		
		xmlhttp.upload.addEventListener('progress', function(event) {
			var percent;
			
			if(event.lengthComputable === true) {
				progUpload["loaded"+fileIndex] = event.loaded;
				progUpload["total"+fileIndex] = event.total;
				
				percent = Math.round((event.loaded / event.total) * 100);
				setProgress(percent, fileIndex);
				setProgressTotal();
			}
		});
		
		xmlhttp.open('post', o.options.processor);
		xmlhttp.send(data);
	};
	
	getFormData = function(source) {
		var data = new FormData();
		
		data.append('file[]', source);
		
		data.append('ajax', true);
		
		return data;
	};
	
	setProgress = function(value, fileIndex) {
		var progressBar = $(".vIn"+fileIndex);
		if(progressBar !== undefined) {
			progressBar.css("width", value ? value + '%' : 0);
		}
		
		if(progressBar !== undefined) {
			progressBar.text(value ? value + '%' : '');
		}
		
		if(value == 100) {
		   progressBar.parent().parent().find(".fa-times").hide();
		   progressBar.addClass("progress-bar-success");
		}
	
	};
	
	setProgressTotal = function() {
		var totalByte = 0, uploadedByte = 0,
			fileCount = $("#file_input").prop('files').length;
		
		for(var i=0; i<fileCount; i++) {
			totalByte = totalByte + progUpload["total"+i];
			uploadedByte = uploadedByte + progUpload["loaded"+i];
			
		}
		var percent = Math.round((uploadedByte/totalByte)*100);
		var seconds_elapsed =   ( new Date().getTime() - started_at.getTime() )/1000;
		var bytes_per_second =  seconds_elapsed ? uploadedByte / seconds_elapsed : 0 ;
		var remaining_bytes =   totalByte - uploadedByte;
		var seconds_remaining = seconds_elapsed ? remaining_bytes / bytes_per_second : 'calculating' ;
		
		var info = '<p><i class="fa fa-tachometer" aria-hidden="true"></i> '+ formatSize(bytes_per_second) +'ps &nbsp;|&nbsp; <i class="fa fa-clock-o" aria-hidden="true"></i> '+formatTime(seconds_remaining)+' &nbsp;|&nbsp; <i class="fa fa-upload" aria-hidden="true"></i> '+ formatSize(uploadedByte) +' / '+ formatSize(totalByte) +'</p>';
		
		if(percent == 100) {
			$("#prog-info").hide(500);
			$("#totalProg").addClass("progress-bar-success");
		}
				
		$("#prog-info").html(info);
		$(".vtotal").css("width", percent+'%');
		$(".vtotal").text(percent+"%");
	};
	
	o.uploader = function(options) {
		o.options = options;
		var files = o.options.files.files, i;
			started_at = new Date();
		 
		 if(options.files !== undefined) {
			totalUploads = files.length;
			$(".lt-head").text("Uploaded 0 of "+totalUploads);
			for(i = 0; i < files.length; i++) {
				ajax(getFormData(files[i]), i);
			}
		 }
	};
	
}(app));
 
$(document).on("click", ".fa-times", function(e) {
    "use strict";
	var nodeIndex = parseInt(e.currentTarget.attributes.vid.nodeValue);
	xhr[nodeIndex].abort();
	$(".vIn"+nodeIndex).addClass("progress-bar-danger");
});
$(document).on("click", ".fa-chevron-down", function(e) {
    "use strict";
        $(e.target).parent().next().show(800);
		$(e.target).hide(500);

});