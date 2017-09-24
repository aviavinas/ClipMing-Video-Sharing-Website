<?php
require_once(__DIR__.'/../lib/client.php');

$_user->lockPage();

	if(!$_user->hasChannel()) {
		header("Location: channel.php?create_a_new");
		exit();
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
		<link rel="stylesheet" type="text/css" href="../gallery/css/shape.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/upload.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/font-awesome-4.5.0/css/font-awesome.min.css" />
        <style>
		.main {
		    position: relative;
			top: 20px;
		}
		dl li {
			list-style-type:none;
		}
		.meta-info {
			float:none;
		}
		dt {
			background-color: rgba(33, 150, 243, 0.08);
		}
		</style>
    </head>
	<body>
    	<div class="main_container">
			
			<?php require_once"header.php" ?>
			<div style="clear:both"></div>
            
            <div class="main">
                <div class="wz-cont">
                  <table id="upload-fs">
                    <tr>
                      <td>
                          <i class="fa fa-upload" id="upload-trig" aria-hidden="true"></i>
                          <form method="post" action="../media/upload.php" id="upload" class="upload" enctype="multipart/form-data">
                              <input type="file" name="file[]" id="file_input" multiple required/>
                              <input type="submit" name="submit" id="submit" value="upload" style="display:none">
                          </form>
                          <div id="upload_lable">
                            <h4>Select Video files</h4>
                            <span>or</span>
                            <h4>Drag and drop your video files here</h4>
                          </div>
                      </td>
                      <td>
                          <div>
                            <h3><i class="fa fa-cogs"></i>&nbsp;&nbsp;Video Specs</h3>
                          </div>
                          <ul>
                            <li><i class="fa fa-square"></i>&nbsp;&nbsp;Duration: 60 minute maximum per video</li>
                            <li><i class="fa fa-square"></i>&nbsp;&nbsp;File size: 2 GB maximum per file</li>
                            <li><i class="fa fa-square"></i>&nbsp;&nbsp;Resolution: Up to 4K Ultra HD (3840 x 2160)</li>
                            <li><i class="fa fa-square"></i>&nbsp;&nbsp;Formats: We support all common video formats</li>
                            <li><i class="fa fa-square"></i>&nbsp;&nbsp;Frame rate: 24, 25, or 30 FPS non-interlaced</li>
                            <li><i class="fa fa-square"></i>&nbsp;&nbsp;Save time by uploading multiple videos simultaneously</li>
                          </ul>
                      </td>
                    </tr>
                  </table>

                  <div id="upload-cont" class="upload-cont">
                      <form id="metaForm">
                         <div id="upload-sc"></div>
                      </form>
                  </div>

                </div>
            </div>
		</div>
          
            <?php require_once "footer.php" ?>
            <script src="../gallery/js/upload.js"></script>
            <script src="../gallery/js/upload-UI.js"></script>
            <script src="../gallery/js/md5.min.js"></script>
    </body>
</html>
  