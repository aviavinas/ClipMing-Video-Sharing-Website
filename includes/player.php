<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>ClipMing | Share Your Videos to World</title>
		<link rel="shortcut icon" href="../gallery/img/ic.png"> 
        <link rel="icon" type="image/x-icon" href="../gallery/img/icon.png">
		<link rel="stylesheet" type="text/css" href="../gallery/css/header.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/main.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/player.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/font-awesome-4.5.0/css/font-awesome.min.css" />
    </head>
	<body>
    	<div class="main_container">
			
			<?php require_once"header.php"; require_once"../lib/common.php"; ?>
			<div style="clear:both"></div>
            
            <div class="main">
                <div class="right-nav">
                  <dl>
                      <dt><h2 id="rt-head">Now Playing</h2></dt>
                      <dd>
                          <?php $_cm->getRelatedVideo(); ?>
                      </dd>
                  </dl>
                </div>
                <div class="left-nav">
				  <?php $_cm->showPlayer(); ?>
                </div>
                <?php $_cm->showVideoDesc(); ?>
            </div>
		</div>
        <?php require_once "footer.php" ?>
        <script src="../gallery/js/player.js"></script>    
    </body>
</html>
