<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>ClipMing | Share Your Videos to World</title>
        <link rel="icon" type="image/x-icon" href="../gallery/img/icon.png">
		<link rel="stylesheet" type="text/css" href="../gallery/css/header.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/main.css" />
        <link rel="stylesheet" type="text/css" href="../gallery/css/font-awesome-4.5.0/css/font-awesome.min.css" />
        <style>
		.wrapper {
			margin: 12px auto !important;
		}
		.rightWrapper li {
			background-color: #fff;
			overflow: auto;
			list-style-type: none;
			padding: 8px;
			margin: 4px;
		}
		h4 {
			margin:2px;
		}
		.stats {
			margin: -5px 2px;
		}
		.v-li {
			max-height: 150px;
			display: -webkit-box;
		}
		.v-lt {
			float:left;
			width:20%;
		}
		.v-lt img {
			transition:all .3s;
		}
		.v-desc {
			text-indent: 20px;
			color: #37474F;
			overflow: hidden;
			text-overflow: ellipsis;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			-webkit-line-clamp: 3;
			max-height: 6em;
			font-size: 13px;
			margin-top: 10px;
		}
		.v-uptime {
			font-family: cursive;
			color: rgba(0, 0, 0, 0.29);
			font-size: 14px;
		}
		.v-lt img:hover {
			height: 125px;
			width: 205px;
			box-shadow: 0 0 32px 7px rgba(0, 0, 0, 0.16);
		}
		.v-rt {
			padding-left: 12px;
			float:left;
			width:78%;
		}
		.v-rt span a {
			font-size:14px;
			color: #607D8B;
			font-weight: bold;
		}
		.con {
			position:relative;
		}
		</style>
    </head>
	<body>
    	<div class="main_container">
			<?php require_once"header.php" ?>
			<div style="clear:both"></div>
            
			<div class="main">
              <div class="wrapper">
                  <div class="leftWrapper">
                    <?php require_once 'category.php'; ?>
                  </div>
                  
                  <div class="rightWrapper">
                    <?php require_once "../lib/common.php";
					      $_cm->getSearchVideo();
						  ?>
                  </div>
              </div>
			</div>
            <?php require_once "footer.php" ?>
		
        </div>
		
        <script type="application/javascript" src="../gallery/js/main.js"></script>
    </body>
</html>
