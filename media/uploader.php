<?php
require_once(__DIR__.'/../lib/client.php');  # For getting current active user
require_once(__DIR__.'/../lib/common.php');  # For Updating Database
//require_once(__DIR__.'/media-function.php');


ignore_user_abort(true); # Don't care if user leave this page
set_time_limit(0); # Let me execute for a while

$db = new Database();
$client = new channel();

class UploadHandler {
	private $userInfo;
	private $allowed_format;
	
	public function __construct() {
		 global $client;
		 $this->userInfo = $client->getInfo();
	}
	
	public function Start() {
		$this->storeFiles();
		$this->sendToServer();
	} // << End Start()   -----------------------------------------------------
	
	public function storeFiles() {
		  global $db;
		  global $client;
		  $allowed_ext = array();
		  foreach($db->select("accept_formats","extention") as $ext)
			  $allowed_ext[] = $ext["extention"];
		  $channel_id = $client->channel_id;
		  $succeeded = [];
		  $failed = [];
		  
		  if(!empty($_FILES['file'])) {
			  foreach($_FILES['file']['name'] as $key => $name) {

				  if($_FILES['file']['error'][$key] === 0) {
					  
					  $temp = $_FILES['file']['tmp_name'][$key];
					  
					  $ext = explode('.', $name);
					  $ext = strtolower(end($ext));
					  
					  $file_name = md5_file($temp) . time() . '.' .$ext;
					  $file_loc = $client->getUserPath();
					  if (!file_exists($file_loc)) {
						  mkdir($file_loc, 0777, true);
					  }
					  
					  $file_loc .= "/".$file_name;
					  $file_fmt = $_FILES['file']['type'][$key];
					  $file_size = $_FILES['file']['size'][$key];
					  // make a unique file hash to identify each file 
					  $file_hash = md5($name . $file_fmt . $file_size);
					  // check if the file already exist in database
					  $file_in_database = $db->select("channel_video","channel_id","file_hash='".$file_hash."'");
					  
					  /* A ajax-json response will be generated to 
					   * inform the client side.
					   *   Error Code : ---
					   *     1  --  Invalid File
					   *     2  --  Already Exist
					   *     3  --  Uncaught Error
					   */
					   
					  if(!in_array($ext, $allowed_ext)) {
						  $failed[] = array(
									'file_hash' => $file_hash,
									'eror' => 1
						  );
					  }
					  else if(count($file_in_database)>0) {
						  $failed[] = array(
									'file_hash' => $file_hash,
									'eror' => 2
						  );
					  }
					  else if(move_uploaded_file($temp, $file_loc)) {
						  $new_video_id = 'A'.common::keygen(10);
						  $upload_date = common::ist_time();
						  
						  $q1 = $db->insert('channel_video',
									   array($new_video_id, $channel_id, $file_hash, $file_loc, $file_fmt, $file_size),
									   "video_id, channel_id, file_hash, file_loc, file_fmt, file_size");
									   
						  $q2 = $db->insert('video',
									   array($new_video_id, $name, $upload_date),
									   "video_id, title, upload_date");
						  
						  $q3 = $db->insert('encode_queue',
									   array($new_video_id), "v_id");
						
						  if($q1 && $q2) {
							  $succeeded [] = array(
									   'file_hash' => $file_hash,
									   'vid' => $new_video_id
							  );
						  }
					  }
					  else {
						  $failed[] = array(
									'file_hash' => $file_hash,
									'eror' => 3
						  );
					  }
				  }
			  }
		  }
		  
		  if(!empty($_POST['ajax'])) {
			  echo json_encode(array(
				  'succeeded' => $succeeded,
				  'failed' => $failed
			  ));
		  }
	} // << End storeFiles()   -----------------------------------------------------
	
	public function sendToServer() {
		if(!empty($_POST['FormData'])) {
			$this->sendToDb();
			//$this->addEncodingJobBackground();
		}
	} // << End sendToServer()   -----------------------------------------------------
		
	public function sendToDb() {
		  global $db;
		  $formData = json_decode($_POST['FormData'], true);
		  $succeed_count = 0;
		  $failed_count = 0;
		  foreach($formData as $post_video_info) {
			  $raw_file = $db->select("channel_video","*","file_hash='".$post_video_info['hash']."'");
			  if(count($raw_file)>0) {
				  if(is_file($raw_file['file_loc'])) {
					  if($this->prepare_and_send($post_video_info,$raw_file))
						  $succeed_count++;
					  else 
						  $failed_count++;
				   } else {
					   $failed_count++;
					  echo "File Does not exist !  ";
				   }
			  }
		  }
		  echo "Succeded : ".$succeed_count."<br> Failded : ".$failed_count;
		  if($succeed_count>0)
			 return true;
	} // << End sendToDb()   -----------------------------------------------------
	
	private function prepare_and_send($post_video_info,$raw_file) {
		  global $db;
		  $userInfo = $this->userInfo;
		  $video['title']   = $post_video_info['title'];
		  $video['desc']    = $post_video_info['description'];
		  $video['tag']     = $post_video_info['tag'];
		  $video['cat']     = $post_video_info['category'];
		  $video['avtive']     = '1';                        // Take down the video
		  $video['privacy'] = $post_video_info['privacy'];

		  if(@$post_video_info['publish'] == "Publish")
			  $video['avtive'] = '0';
		    
 //$ft = get_file_info($video['file_loc']);  //$ft_temp = $ft['hour'].':'.$ft['min'].':'.$ft['sec'];  //$video['duration_ms'] = $ft['ms'];
		  
		  $update = $db->update('video',array('title'=>$video['title'], 'discription'=>$video['desc'], 'tags'=>$video['tag'], 'category'=>$video['cat'], 'active'=>$video['avtive'], 'privacy'=>$video['privacy']),array('video_id',$raw_file['video_id']));
		  
		  if($update)
			  return true;
		  else
			  return false; 
		
	} // << End prepare_and_send()   -----------------------------------------------------






	public function addEncodingJobBackground() {
		$gmc= new GearmanClient();
		$gmc->addServer();
		
		$task= $gmc-> addTaskBackground("process_video", "", NULL, time());
		
		if (! $gmc->runTasks())
		{
			echo "ERROR " . $gmc->error() . "<br>";
			exit;
		}
	} // << End addEncodingJobBackground()   -----------------------------------------------------

} // End Class UploadHandler

?>