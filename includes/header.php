<?php
require_once "config.php";
require_once(__DIR__.'/../lib/client.php');
$sq ='';
if(isset($_GET['q']))
   $sq = $_GET['q'];
?>
<header>
  <div class="header">
      <div class="logo-container left">
        <a href="<?php echo $root ?>">
          <img src="<?php echo $root ?>gallery/img/logo-icon.png" />
          <h1>ClipMing</h1>
          <p class="slogan">Share Your Videos to World</p>
        </a>
      </div>
      
      <div class="search-container left">
        <form method="get" action="<?php echo $root ?>includes\search.php" title="search-bar">
          <input type="text" name="q" id="search-box" style="padding-bottom: 7px; font-family: cursive;" placeholder="Search for Jabra Fan, Yo Yo Honey Singh, Rocky Handsome... " value="<?=$sq?>">
          <input type="submit" value="Search" id="search-btn">
          <i class="fa fa-search search-icon"></i>
        </form>
      </div>
      
      <div class="nav-container left">
        <nav class="navigation">
          <span>
            <a href="#">Browse <i class="fa fa-angle-down"></i></a>
            <div class="dropdown" id="a">
              <ol>
                <li><a>BollyWood</a></li>
                <li><a>New Release</a></li>
                <li><a>All Album</a></li>
                <li><a>Remix</a></li>
                <li><a>Pop</a></li>
              </ol>
            </div>
          </span>
          
          <span>
            <a href="#">Playlist <i class="fa fa-angle-down"></i></a>
            <div class="dropdown" id="b">
                <ol>
                 <li><a>Favourite</a></li>
                  <li><a>Recents</a></li>
                  <li><a>Most Played</a></li>
                  <li><a>Listen Later</a></li>
                  <li><a>Playlist 1</a></li>
               </ol>
            </div>
          </span>
          <i class="fa fa-cloud-upload"></i><a href="<?php echo('/ClipMing/includes/upload.php') ?>">Upload</a>
          <?php echo $_client->accountLink(); ?>
          <?php echo $_client->logoutLink(); ?>
        </nav>
      </div>
  </div>
</header>