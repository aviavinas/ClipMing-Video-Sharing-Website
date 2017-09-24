<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>ClipMing | Share Your Videos to World</title>
        <link rel="icon" type="image/x-icon" href="gallery/img/icon.png">
		<link rel="stylesheet" type="text/css" href="gallery/css/header.css" />
		<link rel="stylesheet" type="text/css" href="gallery/css/main.css" />
        <link rel="stylesheet" type="text/css" href="gallery/css/font-awesome-4.5.0/css/font-awesome.min.css" />
    </head>
	<body>
    	<div class="main_container">
			<?php require_once"includes/header.php" ?>
			<div style="clear:both"></div>
            
			<div class="main">
              <div class="lang-tab">
                <ul>
                  <li><a href="?category=10">Music</a></li>
                  <li><a href="?category=17">Sports</a></li>
                  <li><a href="?category=20">Gaming</a></li>
                  <li><a href="?category=30">Movies</a></li>
                  <li><a href="?category=27">Education</a></li>
                  <li><a href="?category=44">Trailer</a></li>
                  <li><a href="?category=25">News</a></li>
                  <li><a href="?category=28">Science & Technology</a></li>
                  <li><a href="?category=23">Comedy</a></li>
                  <li><a href="?category=1">Film & Animation</a></li>
                </ul>
              </div>
              <div class="banner"><h1>Music Can Change<br> the World<br> Because it Can<br> Change People
</h1></div>
              
              <div class="radio-list">
                <div>
                  <img src="gallery/img/radio.png" alt="Radio Icon" width="100px" />
                </div>
                <div class="radio-text" style="margin: 16px auto auto -43px;">
                  <h3>Radio</h3>
                  <p>Pick a mood, song, or artist.<br>We'll play the perfect mix!</p>
                </div>
                
                <div class="radio-btns">
                  <a href="includes/player.php?playlist=SonuNigam">
                    <div class="radio-thumb">
                      <span>
                        <img src="gallery/img/radio-artist-sonu-nigam.jpg" alt="Romantic" />
                      </span>
                      <span>Sonu Nigam</span>
                    </div>
                  </a>
                  <a href="includes/player.php?playlist=ShreyaGhoshal">
                    <div class="radio-thumb">
                      <span>
                        <img src="gallery/img/radio-artist-shreya-ghoshal.jpg" alt="Romantic" />
                      </span>
                      <span>Shreya Ghoshal</span>
                    </div>
                  </a>
                  <a href="includes/player.php?playlist=ArRahman">
                    <div class="radio-thumb">
                      <span>
                        <img src="gallery/img/radio-artist-ar-rahman.jpg" alt="Romantic" />
                      </span>
                      <span>Ar Rahman</span>
                    </div>
                  </a>
                  <a href="includes/player.php?playlist=KishoreKumar">
                    <div class="radio-thumb">
                      <span>
                        <img src="gallery/img/radio-artist-kishore-kumar.jpg" alt="Romantic" />
                      </span>
                      <span>Kishore kumar</span>
                    </div>
                  </a>
                  <a href="includes/player.php?playlist=Romantic">
                    <div class="radio-thumb">
                      <span>
                        <img src="gallery/img/YoYoHoneySingh.jpg" alt="Romantic" />
                      </span>
                      <span>Honey Singh</span>
                    </div>
                  </a>
                  <a href="includes/player.php">
                    <div class="radio-thumb">
                      <span>
                        <img src="gallery/img/Romantic-circular-red-winged-heart.png" alt="Romantic" />
                      </span>
                      <span>Romantic</span>
                    </div>
                  </a>
                </div>
              </div>
              
              <div class="wrapper">
                  <div class="leftWrapper">
					<?php require_once 'includes/category.php'; ?>
                  </div>
                  
                  <div class="rightWrapper">
                    <?php 
					require_once 'lib/common.php';
					$_cm->getGridVideo();
					?>
                  </div>
              </div>
			</div>
            <?php require_once "includes/footer.php" ?>
		
        </div>
		
        <script type="application/javascript" src="gallery/js/main.js"></script>
    </body>
</html>
