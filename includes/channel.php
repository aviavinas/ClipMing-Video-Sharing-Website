<?php 
require_once(__DIR__.'/../lib/client.php');

$_user->lockPage();

if(!$_user->hasChannel()) {
  $newChannel = $_channel->addChannel();
}

if(!empty($_POST) && !empty($_FILES['image'])) {
  echo $_channel->setImage();
  return;
}
 
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>ClipMing | Share Your Videos to World</title>
        <link rel="icon" type="image/x-icon" href="../gallery/img/icon.png">
		<link rel="stylesheet" type="text/css" href="../gallery/css/header.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/main.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/channel.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/font-awesome-4.5.0/css/font-awesome.min.css" />
    </head>
	<body>
    	<div class="main_container">
			
			<?php require_once"header.php" ?>
			<div style="clear:both"></div>
            
            <div class="main">
			<?php if(!$_user->hasChannel()){ ?>
                <p align="center" id="inst"><i class="fa fa-info-circle" aria-hidden="true"></i>&nbsp;You haven't created any channel yet, Create One to publish your video. </p>
                
                <div class="new_ch c-cont">
                  <form method="post" action="">
                    <label><span>Channel Name : </span><input type="text" name="ch_name" maxlength="24"></label></br>
                    <label><span>Channel Label : </span><input type="text" name="ch_label" maxlength="100"></label></br>
                    <label><span>Channel Description : </span><textarea name="ch_desc"></textarea></label></br>
                    <label><span>Channel Tag : </span><input type="text" name="ch_tag" maxlength="200"></label></br>
                    <label><span>Channel Category : </span><select name="ch_cat">
                      <option label="Arts & Design" value="C1">Arts & Design</option>
                      <option label="Comedy" value="C2">Comedy</option>
                      <option label="Documentary" value="C3">Documentary</option>
                      <option label="Education" value="C4">Education</option>
                      <option label="Entertainment" value="C5">Entertainment</option>
                      <option label="Experimental" value="C6">Experimental</option>
                      <option label="Fashion" value="C7">Fashion</option>
                      <option label="Film & Animation" value="C8">Film & Animation</option>
                      <option label="Food" value="C9">Food</option>
                      <option label="Gaming" value="CA">Gaming</option>
                      <option label="Instructionals & Tutorial" value="CB">Instructionals & Tutorial</option>
                      <option label="Music" value="CC">Music</option>
                      <option label="News & Politics" value="CD">News & Politics</option>
                      <option label="Nonprofits & Activism" value="CE">Nonprofits & Activism</option>
                      <option label="People & Blogs" value="CF">People & Blogs</option>
                      <option label="Personal" value="CG">Personal</option>
                      <option label="Reporting & Journalism" value="CH">Reporting & Journalism</option>
                      <option label="Science & Technology" value="CI">Science & Technology</option>
                      <option label="Sports" value="CJ">Sports</option>
                      <option label="Travel & Events" value="CK">Travel & Events</option>
                    </select></label></br>
                    <input type="submit" name="submit" value="Create Channel">
                  </form>
                </div>
			<?php } 
            else {?>
                <div class="channel_main c-cont">
                  <div id="ch_branding">
                    <div id="ch-art">
                      <?php echo $_channel->getArt(); ?>
                      <a id="artEdit" class="fa fa-pencil-square-o art-edit"></a> 
                    </div>
                    <?php echo $_cm->getChannelLogo(@$_REQUEST['cid']); 
                    if(!(isset($_GET['cid']) && !empty($_REQUEST['cid']))) {?>
					<a id="logoEdit" class="fa fa-pencil-square-o logo-edit"></a>
                    <button type="button" id="addChannelArt">Add Channel Art</button>
                    <form id="imageUploadForm" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                      <input type="file" name="image" id="ImageBrowse">
                      <input type="hidden" name="role" value="none" id="formRole">
                    </form>
					<?php
                    }
					?>
                  </div>
                  <div id="ch_option">
                    <h1><?php echo $_cm->getChannelTitle(@$_REQUEST['cid']); ?></h1>
                  </div>
                </div>
                <div class="v-list c-cont">
                 <?php 
				   if(isset($_GET['cid']) && !empty($_REQUEST['cid'])) {
					   $u = 'https://www.googleapis.com/youtube/v3/search?part=snippet,id&order=date&maxResults=20&channelId='.$_REQUEST['cid'];
					   echo '<h2 class="title-lable">Videos</h2>';
					   $_cm->getGridVideo(5, $u);
				   }
				   else {
					   $_cm->myVideoGrid($_user->getUid());
					   echo '<h2 class="title-lable">My Videos</h2>';
				   }
				 ?>
               </div>
            <?php }?>
			</div>
            
            <?php require_once "footer.php" ?>
        </div>
        <script src="../gallery/js/channel.js"></script>
    </body>
</html>
