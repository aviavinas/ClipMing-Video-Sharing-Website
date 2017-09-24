<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>ClipMing | Share Your Videos to World</title>
        <link rel="icon" type="image/x-icon" href="../gallery/img/icon.png">
		<link rel="stylesheet" type="text/css" href="../gallery/css/header.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/main.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/shape.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/font-awesome-4.5.0/css/font-awesome.min.css" />
    </head>
	<body>
    	<div class="main_container">
			
			<?php require_once"header.php" ?>
			<div style="clear:both"></div>
            
            <div class="main">
              <div class="shapes">
                <div id="shape-a"></div>
                <div id="shape-b"></div>
                <div id="shape-c"></div>
                <div id="shape-d"></div>
                <div id="shape-e"></div>
                <div id="shape-f"></div>
                <div id="shape-g"></div>
                <div id="shape-h"></div>
                <div id="shape-i"></div>
                <div id="shape-j"></div>
              </div>
              <div class="about">
              <h1 class="title-head">Music is who we are.</h1>
              <p><b>ClipMing&trade;</b> is a revolutionary video streaming website, reinventing how people watch to and share video, in India and around the world. With a catalog in the millions (and growing by the day), our motto is simple –  <q>Share Your Videos to World.</q><br><br>
Best of all, ClipMing is unlimited and free on mobile, tablet, and the web. No strings attached. Listen to the latest Bollywood hits, classics, regional music, and even a huge English catalog.
               <br><br><br><span> - Founder & CEO - Avinash and Vikash</span>
</p>
              </div>
			</div>
            
            <?php require_once "footer.php" ?>
            
            <script src="../gallery/js/shape.js"></script>
            <script>
			  document.body.onload = function()
			   {
				   var myInt = setInterval(animateShape, 2000);
			  };
			</script>
			
        </div>
		
    </body>
</html>
