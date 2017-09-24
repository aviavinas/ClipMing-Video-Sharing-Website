<?php
 header('Content-Type: application/json');
 require_once(__DIR__.'/uploader.php');
 
 $uploadHandler = new UploadHandler();
 $uploadHandler->Start();
//echo('{"0":{"title":"yaara.Pankaj.Udhas-By.Bluffmaster.mp4","description":"","tag":"","publish":"Publish","privacy":"Public","category":"H","hash":"55d04d50008bd886ac24e5b4e4bf5482"}}');
//var_dump($_POST['FormData']);
?>
