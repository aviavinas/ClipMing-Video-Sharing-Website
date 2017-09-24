<!DOCTYPE html>
<html lang="en">
<head>
<style>
body {
	background-color: #fafee6;
}

fieldset {
	max-width: 400px;
	margin: auto;
	padding: 10px;
	background-color:#FFF;
}

input {
	padding: 4px 1px;
    margin: 8px;
    font-size: 16px;
}

</style>
</head>
<body>
<a href="#">Refresh</a>
<fieldset>
<legend><h3>Install Wizard </h3></legend>
<form method="post" action="#">
<label>Root Directory path : <input type="text" name="root_path" value="/ClipMing/" /></label><br/>
OS : &nbsp;&nbsp;
<label>Window <input type="radio" value="win" name="os" checked/></label>
<label>Ubuntu <input type="radio" value="ubn" name="os"/></label><br/> 
<label>FFmpeg path : <input type="text" name="ffmpeg_path" value="C:\\ffmpeg\\bin\\" /></label>
<input type="hidden" value="install" name="conf">
<input type="submit" value="submit" name="submit" />
</form>
</fieldset>
</body>
</html>

<?php 
require_once(__DIR__.'/../lib/common.php');
  $installer = new Installer();
  $installer->makeInstall();
?>