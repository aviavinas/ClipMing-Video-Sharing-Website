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
            <h2 class="title-head">Say Hello To ClipMing</h2>
              <div id="frm-container">
                <form action="#" method="get">
                  <label>Name <input type="text" name="Cname" required /></label><br/>
                  <label>Email <input type="email" name="email" required /></label><br/>
                  <label>Gender <input type="radio" class="radioBtn" name="gender" value="M" checked /></label>
                  <label><input type="radio" class="radioBtn" name="gender" value="F" /></label><br/>
                  <label>Attachment <br/><br/><input type="file" name="attachment" /></label><br/>
                  <label>Message <textarea id="msg" name="message" maxlength="500" required></textarea></label><br/>
                  <input type="submit" style="margin-left: 184px;" id="sbmt" value="Send" />
                </form>
              </div>
			</div>
            
            <?php require_once "footer.php" ?>
         
        </div>
		
    </body>
</html>
