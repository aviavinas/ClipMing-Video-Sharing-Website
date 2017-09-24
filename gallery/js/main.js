	function rand(m) {
		return Math.floor((Math.random() * m) + 1);
	}

    function tgl(s,node) {
            if(s==1) { //On
                document.getElementById(node).style.display = 'block';
                }
            else if(s==0) { // Off
                document.getElementById(node).style.display = 'none';
                }
		}
		
		
	document.body.onload = function() {
		document.getElementsByClassName("radio-list")[0].style.paddingLeft = "24px";
		document.querySelectorAll(".banner > h1")[0].style.marginLeft = "55px";
		document.querySelectorAll(".banner > h1")[0].style.wordSpacing = "10px";
		var current;
		var m = document.querySelectorAll(".tb > tbody > tr > td");
		for(var i=0; i<=m.length; i++) {
			current = m[i];
		}
			
		setTimeout(function(){
			  var x = document.querySelectorAll(".radio-btns > a");
			  var i;
			  for (i = 0; i < x.length; i++) {
				  x[i].style.marginTop = 0;
			  }
		},1000);
	  
	};
	