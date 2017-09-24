<?php 
if(isset($_GET['update']) && $_GET['update'] == 'true') {
	require_once "../lib/client.php"; 
	$_user->updateProfile();
	echo "\n Received";
	exit(0);
}
require_once "country_code.php"; 
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>ClipMing | Share Your Videos to World</title>
        <link rel="icon" type="image/x-icon" href="../gallery/img/icon.png">
		<link rel="stylesheet" type="text/css" href="../gallery/css/header.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/main.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/myac.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/font-awesome-4.5.0/css/font-awesome.min.css" />
    </head>
	<body>
    	<div class="main_container">
			
			<?php require_once"header.php" ?>
			<div style="clear:both"></div>
            
            <div class="main">
                <div class="top-sec">
                  <div class="blur-banner">
                    <img src="../gallery/img/radio-artist-sonu-nigam.jpg">
                  </div>
                  <div class="prof-pic">
                    <img src="../gallery/img/radio-artist-sonu-nigam.jpg">
                  </div>
                </div>
                <div class="bottom-sec">
                  <div class="bottom-lt-sec">
                    <ul>
                      <li id="ch"><a href="channel.php">My Channel</a></li>
                      <li id="ps" class="tab-active">Personal Info</li>
                      <li id="nt">Notification</li>
                      <li id="pr">Privacy</li>
                      <li id="sc">Security</li>
                      <li id="ad">Advertisement</li>
                      <li id="dl">Delete Account</li>
                    </ul>
                  </div>
                  <div class="bottom-rt-sec">
                    <div class="ps">
                      <ul>
                        <li>
                          <span class="nm">Name</span>
                          <span class="vl"><span>Avinask Kumar</span>
                            <input type="text" name="nm" placeholder="First Name" class="inp">
                            <input type="text" name="nm" placeholder="Last Name" class="inp">
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                        <li>
                          <span class="nm">Email</span>
                          <span class="vl"><span>Kumar@ClipMing.Com</span>
                            <input type="text" name="em" value="Kumar@ClipMing.Com" class="inp">
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                        <li>
                          <span class="nm">Phone</span>
                          <span class="vl"><span>07087546495</span>
                            <input type="text" name="ph" value="07087546495" class="inp">
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                        <li>
                          <span class="nm">BirthDay</span>
                          <span class="vl"><span>May 10 1998</span>
                            <?php echo $date; ?>
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                        <li>
                          <span class="nm">Gender</span>
                          <span class="vl"><span>Male</span>
                            <select name="gn" class="inp">
                              <option value="M">Male</option>
                              <option value="F">Female</option>
                            </select>
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                        <li>
                          <span class="nm">About Me</span>
                          <span class="vl"><span>Edit what others see about you</span>
                            <textarea name="ab" class="inp"></textarea>
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                        <li>
                          <span class="nm">Location</span>
                          <span class="vl"><span>Will not be shared</span>
                            <?php echo $countryList; ?>
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                      </ul>
                    </div>
                    
                    <div class="nt">
                      <ul>
                        <li>
                          <span class="nm">Name</span>
                          <span class="vl"><span>Avinask Kumar</span>
                            <input type="text" name="nm" value="Avinask Kumar" class="inp">
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                        <li>
                          <span class="nm">Email</span>
                          <span class="vl"><span>Kumar@ClipMing.Com</span>
                            <input type="text" name="em" value="Kumar@ClipMing.Com" class="inp">
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                      </ul>
                    </div>
                    
                    <div class="pr">
                      <ul>
                        <li>
                          <span class="nm">Name</span>
                          <span class="vl"><span>Avinask Kumar</span>
                            <input type="text" name="nm" value="Avinask Kumar" class="inp">
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                        <li>
                          <span class="nm">Email</span>
                          <span class="vl"><span>Kumar@ClipMing.Com</span>
                            <input type="text" name="em" value="Kumar@ClipMing.Com" class="inp">
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                      </ul>
                    </div>
                    
                    <div class="sc">
                      <ul>
                        <li>
                          <span class="nm">Name</span>
                          <span class="vl"><span>Avinask Kumar</span>
                            <input type="text" name="nm" value="Avinask Kumar" class="inp">
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                        <li>
                          <span class="nm">Email</span>
                          <span class="vl"><span>Kumar@ClipMing.Com</span>
                            <input type="text" name="em" value="Kumar@ClipMing.Com" class="inp">
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                      </ul>
                    </div>
                    
                    <div class="ad">
                      <ul>
                        <li>
                          <span class="nm">Name</span>
                          <span class="vl"><span>Avinask Kumar</span>
                            <input type="text" name="nm" value="Avinask Kumar" class="inp">
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                        <li>
                          <span class="nm">Email</span>
                          <span class="vl"><span>Kumar@ClipMing.Com</span>
                            <input type="text" name="em" value="Kumar@ClipMing.Com" class="inp">
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                      </ul>
                    </div>
                    
                    <div class="dl">
                      <ul>
                        <li>
                          <span class="nm">Name</span>
                          <span class="vl"><span>Avinask Kumar</span>
                            <input type="text" name="nm" value="Avinask Kumar" class="inp">
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                        <li>
                          <span class="nm">Email</span>
                          <span class="vl"><span>Kumar@ClipMing.Com</span>
                            <input type="text" name="em" value="Kumar@ClipMing.Com" class="inp">
                          </span>
                          <i class="fa fa-pencil-square-o editF"><span>Edit</span></i>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
            </div>
			<?php require_once "footer.php" ?>
            <script src="../gallery/js/myac.js"></script>
        </div>
		
    </body>
</html>
