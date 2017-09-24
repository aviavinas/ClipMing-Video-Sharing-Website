<?php
require_once(__DIR__.'/client.php');

/*
 * Author  Avinash Kumar  < toAvinash@clipming.com >
 * Copyright 2016 ClipMing.Com
 *
 *
 * This page handles basic functionality of
 * clipming, so it is mostly required by 
 * most of the module.
 */

// - -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --


/*
* It handles the every Database operation
* and makes error log.
*/

class Database
{
	private $serverhost = "localhost";
	private $username = "root";
	private $password = "";
	public $database ="dbpro";
	private $con;
	private $mysqli;
	public $database_selected;
	public $failed_query_count = 0;
	public $error_msg = array();
	
	public function __construct() {
		 $this->connect();
	}
	
    public function connect() {
        if(!$this->con) {
			$this->mysqli = @new MySQLi($this->serverhost,$this->username,$this->password);
				
            if($this->mysqli && $this->ping()) {
				$this->con = true;
				if(@$this->runQuery("USE dbpro"))
				    $this->database_selected = true;
				else 
				    $this->database_selected = false;
				
				return true; 
			} else {
				$this->con = false;
				return false; 
			}
		} 
		else {
			$this->con = true;
            return true; 
        }
    } // << End connect()   -----------------------------------------------------
	
    public function disconnect() {
		if($this->con) {
			$mysqli = $this->mysqli;
			if(@$mysqli->close()) {
			   $this->con = false; 
				return true; 
			}
			else {
				return false; 
			}
		}
	} // << End disconnect()   -----------------------------------------------------
	
	public function ping() {
		$mysqli = $this->mysqli;
		return @$mysqli->ping();
	} // << End ping()   -----------------------------------------------------
	
	public function error() {
		$mysqli = $this->mysqli;
		return $mysqli->error;
	} // << End eror()   -----------------------------------------------------
	
	private function tableExists($table) {
		$table = $this->esc_str($table);
        $tablesInDb = @$this->runQuery('SHOW TABLES FROM '.$this->database.' LIKE "'.$table.'"');
        if($tablesInDb)
        {
            if($tablesInDb->num_rows==1)
                return true; 
            else {
				$this->failed_query_count++;
				$this->error_msg[] = "Error : '".$table."' table doesn't exist in Database 'dbpro' !";
                return false; 
			}
        }
    } // << End tableExists()   -----------------------------------------------------
	
    public function select($table, $rows = '*', $where = null, $order = null) {
		  if($this->tableExists($table)) {
			  $result = array();
			  $q = 'SELECT '.$rows.' FROM '.$table;
			  if($where != null)
				  $q .= ' WHERE '.$where;
			  if($order != null)
				  $q .= ' ORDER BY '.$order;
			  $query = @$this->runQuery($q); 
			  if($query) {
				  $numResults = $query->num_rows;
				  for($i = 0; $i < $numResults; $i++) {
					  $r = $query->fetch_array(MYSQLI_ASSOC);
					  $key = array_keys($r); 
					  for($x = 0; $x < count($key); $x++) {
						  if($query->num_rows > 1)
							  $result[$i][$key[$x]] = $r[$key[$x]];
						  else if($query->num_rows < 1)
							  $result = null; 
						  else
							  $result[$key[$x]] = $r[$key[$x]]; 
					  }
				  }            
				  return $result; 
			  }
			  else
				  return false; 
		  }
		  else
			  return false; 
    } // << End select()   -----------------------------------------------------
	
    public function insert($table,$values,$rows = null) {
        if($this->tableExists($table)) {
            $insert = 'INSERT INTO '.$table;
            if($rows != null)
                $insert .= ' ('.$rows.')'; 
            
            for($i = 0; $i < count($values); $i++) {
				if(empty($values[$i]))
					$values[$i] = "NULL";
                if(is_string($values[$i]))
                    $values[$i] = '"'.$this->esc_str($values[$i]).'"';
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';
            $ins = @$this->runQuery($insert);
			if($ins)
                return true; 
            else
                return false; 
        }
		else 
			return false;
    } // << End insert()   -----------------------------------------------------
	
    public function delete($table,$where = null) {
        if($this->tableExists($table)) {
			if($where == null)
                $delete = 'DELETE FROM '.$table; 
            else
                $delete = 'DELETE FROM '.$table.' WHERE '.$where; 
 
            $del = @$this->runQuery($delete);
 
            if($del)
                return true; 
            else
               return false; 
        }
        else
            return false; 
    } // << End delete()   -----------------------------------------------------
	
    public function update($table,$rows,$where,$debugging=0) {
        if($this->tableExists($table)) {
		   for($i = 0; $i < count($where); $i++) {
                if($i%2 != 0) {
					if(@$where[$i+1] != NULL) 
						$where[$i] = '"'.$where[$i].'" AND ';
					else
						$where[$i] = '"'.$where[$i].'"';
                }
            }
            $where = implode('=',$where);
            $update = 'UPDATE '.$table.' SET ';
            $keys = array_keys($rows); 
            for($i = 0; $i < count($rows); $i++) {
                if(is_string($rows[$keys[$i]]))
                    $update .= $keys[$i].'="'.$this->esc_str($rows[$keys[$i]]).'"';
                else
                    $update .= $keys[$i].'='.$this->esc_str($rows[$keys[$i]]);
                 
                // Parse to add commas
                if($i != count($rows)-1)
                    $update .= ','; 
            }
          
		    $update .= ' WHERE '.$where;
			if($debugging==1)
			   echo $update;
            $query = @$this->runQuery($update);
            if($query)
                return true; 
            else
                return false; 
        }
        else
            return false; 
    } // << End update()   -----------------------------------------------------
	
	public function esc_str($str) {
		if(!empty($str)) {
			$mysqli = $this->mysqli;
			return $mysqli->real_escape_string($str);
		}
	} // << End esc_str()   -----------------------------------------------------
	
	public function disable_auto_commit() {
		$mysqli = $this->mysqli;
		return $mysqli->autocommit(FALSE);
	}
	
	public function commit_transiction() {
		$mysqli = $this->mysqli;
		return $mysqli->commit();
	}
	
	public function rollback_transiction() {
		$mysqli = $this->mysqli;
		return $mysqli->rollback();
	}
	
	public function runQuery($sql_query) {
		if(empty($sql_query))
			   exit(0);
		$mysqli = $this->mysqli;
		$mysqli->set_charset('utf8');
		$result = $mysqli->query($sql_query);
		if($result == false) {
			$this->failed_query_count++;
			$this->error_msg[] = $mysqli->error;
		}
		return $result;
	} // << End runQuery()   -----------------------------------------------------

} // << End class Database   ------------------------------------------------------------------------------


/*
 * Provides some most Commonly used Method across
 * the Website, without Creating a object.
 */

class common {
	  public static $ffmpeg = '';
	  public static $path = ''; //upload path
	  public static $root_path = '';
	  		 
	  public static function getSession() {
		if(!isset($_SESSION)) 
			   session_start();
	  } // << End getSession()   -----------------------------------------------------
	
	  public static function getDbConfig() {
		    global $_db;
		    if($res = $_db->select("records","val","name ='ffmpeg_path'"))
				 self::$ffmpeg = $res['val'];     
			 else
				 echo "Unable to fetch server ffmpeg path from database.";
			
			if($res = $_db->select("records","val","name ='path'"))
				 self::$path = $res['val'];
			 else
				 echo "Unable to fetch server upload path from database.";
			
			if($res = $_db->select("records","val","name ='Root_path'"))
				 self::$root_path = $res['val'];
			 else
				 echo "Unable to fetch server Root path from database.";
	  } // << End getDbConfig()   -----------------------------------------------------
	  
	  // Function for getting Indian Standard Time
	  public static function ist_time() {
			date_default_timezone_set('Asia/Kolkata'); 
			$time_now=mktime(date('h'),date('i'),date('s'));
			$date = date('Y-m-d H:i:s', $time_now);
			return $date;
	  } // << End ist_time()   -----------------------------------------------------
	  
	  // To generate a unique set of key
	  public static function keygen($key_length){
		$chars = "abcdefghijklmnopqrstuvwxyz";
		$chars .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$chars .= "0123456789";
		while(1){
			$key = '';
			srand((double)microtime()*1000000);
			for($i = 0; $i < $key_length; $i++){
				$key .= substr($chars,(rand()%(strlen($chars))), 1);
			}
			break;
		}
		return $key;
	  }
	  
} // << End class defination


/*
 * Use for Installing the Root Database called 'dbpro', 
 * It will overwrite any previous Installation.
 */

 class Installer extends common {
	  public function makeInstall() {
		   if(isset($_POST['root_path']) || isset($_POST['ffmpeg_path'])) {
				 global $_db;
				 if($_POST['os']=='win')
					 parent::$ffmpeg = $_POST['ffmpeg_path'];
				
				 parent::$path = "server/files/"; 
				 parent::$root_path = $_POST['root_path'];
				 parent::$root_path = $_db->esc_str(parent::$root_path);
				 parent::$ffmpeg = $_db->esc_str(parent::$ffmpeg);
				 parent::$path = $_db->esc_str(parent::$path);
				 
				 $before_count = $_db->failed_query_count;
				 
				 require_once(__DIR__.'/query.php');
				 $_db->disable_auto_commit();
				
				 foreach($sql as $query) {
					 @$_db->runQuery($query);
				 }
				 
				 $this->Insert_data();
				 $fail_count = ($_db->failed_query_count) - $before_count;
				 if($fail_count == 0) {
					$_db->commit_transiction();
					echo '<span style="color: green;"><b>Database created successfully</b></span>';
				 }
				 else if($fail_count>0) {
					$_db->rollback_transiction(); 
					echo "Error during execution of basic installation query: ";
					el();
					v($_db->error_msg);
				 }
				 
		   }
      } // << End makeInstall()   -----------------------------------------------------
	  
      private function Insert_data() {
		    global $_db;
			$_db->insert("cmuser",array("CUaaaaaa", "Avinash", "Kumar", "Av@clipming.com",
									   "pass123", "M", "IN", "7087546495", "1998-05-10", parent::ist_time()),
									   "UserID, Fname, Lname, Email, Pass, Gender, Country, Phone, DateOfBirth, Date_Of_Reg");
		
			$_db->insert("cmuser",array("CUvvvvvv", "Vikas", "Kumar", "vk@clipming.com", 
									   "pass123", "M", "IN", "9855283132", "1995-07-05", parent::ist_time()),
									   "UserID, Fname, Lname, Email, Pass, Gender, Country, Phone, DateOfBirth, Date_Of_Reg");
						  
			$_db->insert("channel",array("CCcacacaca", "CUaaaaaa", "MyTechCraft", "My first channel", 
										"Watch anytime", "tech video tutorial innovation", parent::ist_time(), 
										"Technology"),"channel_id, channel_author, channel_name, discription, 
										channel_label, channel_tags, creation_date, channel_cat");
			
			$_db->insert("channel",array("CCcvcvcvcv", "CUvvvvvv", "Vikas Channel", "Vikas first channel", 
										"Watch anything", "song bollywood music 2016 video", parent::ist_time(), "Music"),
										"channel_id, channel_author, channel_name, discription, channel_label, 
										channel_tags, creation_date, channel_cat");
			
			$_db->insert('accept_formats',array("NULL", "video/webm", "webm"),"f_id, mime_type, extention");
			$_db->insert('accept_formats',array("NULL", "video/quicktime", "mov"),"f_id, mime_type, extention");
			$_db->insert('accept_formats',array("NULL", "video/mp4", "mp4"),"f_id, mime_type, extention");
			$_db->insert('accept_formats',array("NULL", "video/3gpp", "3gp"),"f_id, mime_type, extention");
			$_db->insert('accept_formats',array("NULL", "video/avi", "avi"),"f_id, mime_type, extention");
			$_db->insert('accept_formats',array("NULL", "video/x-matroska", "mkv"),"f_id, mime_type, extention");
			$_db->insert('accept_formats',array("NULL", "video/x-ms-wmv", "wmv"),"f_id, mime_type, extention");
			$_db->insert('accept_formats',array("NULL", "video", "flv"),"f_id, mime_type, extention");
			$_db->insert('accept_formats',array("NULL", "application/octet-stream", "dat"),"f_id, mime_type, extention");
			$_db->insert('accept_formats',array("NULL", "video/mpeg", "mpeg"),"f_id, mime_type, extention");
			$_db->insert('accept_formats',array("NULL", "video/mpeg", "mpg"),"f_id, mime_type, extention");
			$_db->insert('accept_formats',array("NULL", "video/mp4", "m4v"),"f_id, mime_type, extention");
			$_db->insert('accept_formats',array("NULL", "video/ogv", "ogv"),"f_id, mime_type, extention");
			
			$_db->insert('records',array('Root_path', parent::$root_path),"name, val");
			$_db->insert('records',array('ffmpeg_path', parent::$ffmpeg),"name, val");
			$_db->insert('records',array('path', parent::$path),"name, val");
			$_db->insert('records',array('C1', 'Arts & Design'),"name, val");
			$_db->insert('records',array('C2', 'Comedy'),"name, val");
			$_db->insert('records',array('C3', 'Documentary'),"name, val");
			$_db->insert('records',array('C4', 'Education'),"name, val");
			$_db->insert('records',array('C5', 'Entertainment'),"name, val");
			$_db->insert('records',array('C6', 'Experimental'),"name, val");
			$_db->insert('records',array('C7', 'Fashion'),"name, val");
			$_db->insert('records',array('C8', 'Film & Animation'),"name, val");
			$_db->insert('records',array('C9', 'Food'),"name, val");
			$_db->insert('records',array('CA', 'Gaming'),"name, val");
			$_db->insert('records',array('CB', 'Instructionals & Tutorial'),"name, val");
			$_db->insert('records',array('CC', 'Music'),"name, val");
			$_db->insert('records',array('CD', 'News & Politics'),"name, val");
			$_db->insert('records',array('CE', 'Nonprofits & Activism'),"name, val");
			$_db->insert('records',array('CF', 'People & Blogs'),"name, val");
			$_db->insert('records',array('CG', 'Personal'),"name, val");
			$_db->insert('records',array('CH', 'Reporting & Journalism'),"name, val");
			$_db->insert('records',array('CI', 'Science & Technology'),"name, val");
			$_db->insert('records',array('CJ', 'Sports'),"name, val");
			$_db->insert('records',array('CK', 'Travel & Events'),"name, val");

		} // << End Insert_data()   -----------------------------------------------------
 
 } // << End class defination


class clipming {
	private $key = 'AIzaSyD4einllsbfg_A-7GUjI0MgEEe24ge1ytE';
	private function getJSON($url) {
		@$content = file_get_contents($url);
		if(!$content) {
			echo '<br><br><br><h3 style=" color:#f44336" align="center"><i style="font-size:120px;" class="fa fa-globe"></i><br> &nbsp;&nbsp;Facing network Communication Issue, Please Check your Internet Connection !</h2>';
			return false;
		}
		return json_decode($content, true);
	}
	
	public function getVideoYt($video_id) {
		$id = $video_id;
		if(is_array($id))
		    $id = implode(",", $id);
			
		$u = 'https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails,statistics&id='.$id.'&key='.$this->key;
		$response = $this->getJSON($u);
		return $response['items'];
	}
	
	public function getChannelYt($id) {
		$ch_id = $id;
		if(strlen($id)<14) { # Need to grab Yt ChannelId fron vID
			$id = $this->getVideoYt($id);
			$ch_id = $id[0]['snippet']['channelId'];
		}
		   
		$u = 'https://www.googleapis.com/youtube/v3/channels?part=snippet&id='.$ch_id.'&key='.$this->key;
		$response = $this->getJSON($u);
		return $response['items'][0];
	}
	
	public function getVideoInfo($vid, $col='') {
		global $_db;
		$video = $_db->select("video", "*", "video_id = '".$vid."'");
		if(count($video)>0) {
			if(!empty($col)) {
				return $video[$col];
			} else 
			    return $video;
		}
		else 
		    return false;
	}
	
	public function getChannelInfo($ch_id, $attr) {
		global $_db;
		$ch = $_db->select("channel", "*", "channel_id = '".$ch_id."'");
		if(count($ch)>0) {
			if(!empty($attr)) {
				return $ch[$attr];
			} else 
			    return $ch;
		}
		else 
		    return false;
	}
	
	public function getChannelTitle($id=false) {
		if(isset($_GET['cid']) && !empty($_REQUEST['cid']) && strlen($_REQUEST['cid'])>14) { # from ch_id of $_get
			$ch = $this->getChannelYt($_GET['cid']);
			$title = $ch['snippet']['title'];
		}
		else if(strlen($id)>1) {
			$title = $this->getChannelInfo($id,"title");
			if($title === false) {
				$title = $this->getVideoYt($id);
				$title = $title[0]['snippet']['title'];
			}
		}
		else {
			global $_channel;
			$title = $_channel->get("channel_name");
		}
		return $title;
	}
	
	public function getChannelLogo($vid) {
		if(isset($_GET['cid']) && !empty($_REQUEST['cid'])) {
			$ch = $this->getChannelYt($_REQUEST['cid']);
			$logo = '<img src="'.$ch['snippet']['thumbnails']['medium']['url'].'"  id="chLogoImg">';
		}
		else {
			global $_channel;
			$logo = $_channel->getLogo();
		}
		return $logo;
	}
	
	public function getVideoTitle($vid) {
		$title = $this->getVideoInfo($vid,"title");
		if($title === false) {
			$title = $this->getVideoYt($vid);
			$title = $title[0]['snippet']['title'];
		}
		return $title;
	}
	
	public function getLikeCount($vid) {
		$like_count = $this->getVideoInfo($vid,"like_count");
		if($like_count === false) {
			$like_count = $this->getVideoYt($vid);
			$like_count = $like_count[0]["statistics"]["likeCount"];
		}
		return $like_count;
	}
	
	public function getDislikeCount($vid) {
		$dislike_count = $this->getVideoInfo($vid,"dislike_count");
		if($dislike_count === false) {
			$dislike_count = $this->getVideoYt($vid);
			$dislike_count = $dislike_count[0]["statistics"]["dislikeCount"];
		}
		return $dislike_count;
	}
	
	public function getViewCount($vid) {
		$view_count = $this->getVideoInfo($vid,"view_count");
		if($view_count === false) {
			$view_count = $this->getVideoYt($vid);
			$view_count = $view_count[0]["statistics"]["viewCount"];
		}
		return $view_count;
	}
	
	public function covtime($youtube_time) {
		preg_match_all('/(\d+)/',$youtube_time,$parts);
	
		// Put in zeros if we have less than 3 numbers.
		if (count($parts[0]) == 1) {
			array_unshift($parts[0], "0", "0");
		} elseif (count($parts[0]) == 2) {
			array_unshift($parts[0], "0");
		}
	
		$sec_init = $parts[0][2];
		$seconds = $sec_init%60;
		$seconds_overflow = floor($sec_init/60);
	
		$min_init = $parts[0][1] + $seconds_overflow;
		$minutes = ($min_init)%60;
		$minutes_overflow = floor(($min_init)/60);
	
		$hours = $parts[0][0] + $minutes_overflow;
	
		if($hours != 0)
			return $hours.':'.$minutes.':'.$seconds;
		else
			return $minutes.':'.$seconds;
	}
	
	public function convToAboutTime($date_str) {
		$dt = strtotime($date_str);
		$y = date("Y", $dt);
		$m = date("m", $dt);
		$d = date("d", $dt);
		$h = date("H", $dt);
		$i = date("i", $dt);
		$s = date("s", $dt);
		
		$cy = date("Y", time());
		$cm = date("m", time());
		$cd = date("d", time());
		$ch = date("H", time());
		$ci = date("i", time());
		$cs = date("s", time());
		
		if($cy > $y)
		   return abs($cy-$y)." year";
		else if($cm > $m)
		   return abs($cm-$m)." month";
		else if($cd > $d)
		   return abs($cd-$d)." day";
		else if($ch > $h)
		   return abs($ch-$h)." hour";
		else if($ci > $i)
		   return abs($ci-$i)." minute";
		else if($cs > $s)
		   return abs($cs-$s)." second";
	}
	
	public function getVideoFromJson($json_response) {
		$array_id = array();
		foreach($json_response['items'] as $item) {
			if(is_string($item['id'])) {
			    $array_id[] = $item['id'];
			} else {
			    @$array_id[] = $item['id']['videoId'];
			}
		}
		return $this->getVideoYt($array_id);
	}
	
	public function showPlayer() {
		if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
			global $_db;
			$video = $_db->select("channel_video", "file_loc", "video_id = '".$_REQUEST['id']."'");
			echo '
			<div class="main-stage">
			  <div class="play-area">';
			if(count($video)>0) { // Means that there is a video in the database with this id
				$v_loc = "../media/".$video['file_loc'];
				echo '
				 <video width="800" height="480" controls autoplay>
					<source src="'.$v_loc.'" type="video/mp4">
				  Your browser does not support the Html5 video.
				  </video>
				  ';
			}
			else { // Go for Youtube API3
				echo '<iframe width="800" height="480" src="https://www.youtube.com/embed/'.$_REQUEST['id'].'?autoplay=1"></iframe>';
			}
			
			$channel = $this->getChannelYt($_REQUEST['id']);
			
			echo '
			  </div>
			  <div class="channel-area">
				<div class="ch-logo">
				  <a href="channel.php?cid='.$channel['id'].'">
					<img src="'.$channel['snippet']['thumbnails']['default']['url'].'" alt="'.$channel['snippet']['title'].'" /><br>
					<strong>'.$channel['snippet']['title'].'</strong>
				  </a>
				</div>
			  </div>
			</div>';
			echo '
				<h3>'.$this->getVideoTitle($_REQUEST['id']).'</h3>
				<div class="v-stats">
                    <i class="heart" id="like1" rel="like"></i>
					<span class="likeCount lk" id="likeCount1">'.$this->getLikeCount($_REQUEST['id']).'</span>
					<i class="fa fa-heartbeat dislike" rel="dislike"></i>
                    <span class="likeCount dl" id="likeCount2">'.$this->getDislikeCount($_REQUEST['id']).'</span>
					<span class="ViewCount" title="'.$this->getViewCount($_REQUEST['id']).' Views"><i class="fa fa-eye"></i> '.$this->getViewCount($_REQUEST['id']).' Views</span>
                  </div>';
		}
		else
			echo "Noting to Play !";
	}
		
	public function showVideoDesc() {
		if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
			global $_db;
			$video = $_db->select("video", "*", "video_id = '".$_REQUEST['id']."'");
			$publish = '';
			$desc = '';
			if(count($video)>0) {
				$publish = $video['upload_date'];
				$desc = $video['discription'];
			} else {
				$v = $this->getVideoYt($_REQUEST['id']);
				$publish = $v[0]['snippet']['publishedAt'];
				$desc = $v[0]['snippet']['description'];
			}
			echo '
			<div class="left-nav detail">
			<p class="pub-date">Published on '.(date("D j M, Y", strtotime($publish))).'</p>
			<p class="vdesc">'.$desc.'</p>
			</div>';
		}
	} // << End showVideoDesc() 
	
	public function getGridVideo($maxCol = 5, $u=false) {
		$catId = 10;
		if(isset($_GET['category']) && !empty($_GET['category'])) {
			$catId = $_GET['category'];
		}
		
		$url =  'https://www.googleapis.com/youtube/v3/videos?';
		$url.= 'part=snippet';
		$url.= '&maxResults=20';
		$url.= '&chart=mostPopular';
		$url.= '&regionCode=IN';
		$url.= '&videoCategoryId='.$catId;
		$url.= '&key='.$this->key;
		
		if(!$u===false)
		    $url = $u.'&key='.$this->key;

		$col = 1;
		$json_response = $this->getJSON($url);
		if(!$json_response)
		   return false;

		$response = $this->getVideoFromJson($json_response);

		echo '<table class="tb"><tbody><tr>';
		foreach($response as $video) {
			$player = '/ClipMing/includes/player.php?id='.$video['id'];
			$dur = $this->covtime($video['contentDetails']['duration']);
			
			echo '
			<td>
			  <a href="'.$player.'">
				<div>
				  <img src="'.$video['snippet']['thumbnails']['medium']['url'].'" class="thumbs" width="200px" height="120px" alt="'.$video['snippet']['title'].'" />
				  <div class="stats">
					<span title="'.@$video["statistics"]["likeCount"].' Likes"><i class="fa fa-heart-o"></i> '.(readable_num(@$video["statistics"]["likeCount"])).'</span>
					<span title="'.@$video["statistics"]["viewCount"].' Views"><i class="fa fa-eye"></i> '.(readable_num(@$video["statistics"]["viewCount"])).'</span>
					<span class="v-dur"><i class="fa fa-clock-o"></i>'.$dur.'</span>
				  </div>
				</div>
				<div>
				  <h4>'.$video['snippet']['title'].'</h4>
				  <p><a href="/ClipMing/includes/channel.php?cid='.$video['snippet']['channelId'].'">'.$video['snippet']['channelTitle'].'</a></p>
				</div>
			  </a>
			</td>';
			if($col%$maxCol==0)
				echo '</tr><tr>';
			$col++;
		}
		
		echo '</tr></tbody></table>';
		
	} // << End videoList()  --------------------------------------------------------------
	
	public function getLocalSearch($q) {
		if(!isset($q) || empty($q)) {
		    return false;
		}
		
		global $_db;
		$searchRes = $_db->select("video","*","title LIKE'%".$q."%' OR tags LIKE'%".$q."%'");
		
		echo '<ol>';
		foreach($searchRes as $video) {
			$v = $_db->select("channel_video","*","video_id='".$video['video_id']."'");
			//v($video);
			$v_loc = '../media/'.$v['file_loc'];
			$dur = $v['duration_micSec'];
			if($dur == -1)
			   $dur = 120;
			$player = '../includes/player.php?id='.$video['video_id'];
			$dur = $this->covtime($dur);
			$uploadTime = "About ".$this->convToAboutTime($video["upload_date"])." ago";
			$ch = $_db->select("channel_video","channel_id","video_id='".$video['video_id']."'");
			$ch = $_db->select("channel","channel_name","channel_id='".$ch['channel_id']."'");
			echo '
			<li>
			  <div class="v-li">
				<div class="v-lt con">
				  <a href="'.$player.'">
					<video width="200" height="120" class="thumbs">
					  <source src="'.$v_loc.'" type="video/mp4">
					</video>
					<div class="stats">
					  <span title="'.$video["like_count"].' Likes"><i class="fa fa-heart-o"></i> '.(readable_num($video["like_count"])).'</span>
					  <span title="'.$video["view_count"].' Views"><i class="fa fa-eye"></i> '.(readable_num($video["view_count"])).'</span>
					  <span class="v-dur"><i class="fa fa-clock-o"></i> '.$dur.'</span>
					</div>
				  </a>
				</div>
				<div class="v-rt con">
				  <a href="'.$player.'"><h4>'.$video['title'].'</h4></a>
				  <span><a href="/ClipMing/includes/channel.php?cid='.$v['channel_id'].'">'.$ch['channel_name'].'</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
				  <span class="v-uptime">'.$uploadTime.'</span><br>
				  <span class="v-desc">'.$video['discription'].'</span>
				</div>
			  </div>
			</li>';
		}
		
		echo '</ol>';
		
	} // << End videoList()  --------------------------------------------------------------
	
	public function getSearchVideo() {
		if(!isset($_GET['q']) || empty($_GET['q'])) {
			echo '<br><p align="center">Please enter a search Query</p>';
		    return false;
		}
		
		$q = $_GET['q'];	
		$this->getLocalSearch($q);

		$url =  'https://www.googleapis.com/youtube/v3/search?';
		$url.= 'part=snippet';
		$url.= '&q='.urlencode($q);
		$url.= '&maxResults=30';
		$url.= '&videoEmbeddable=true';
		$url.= '&type=video';
		$url.= '&key='.$this->key;
		$json_response = $this->getJSON($url);
		
		if(!$json_response)
		   return false;

		$response = $this->getVideoFromJson($json_response);
		
		echo '<ol>';
		foreach($response as $video) {
			$player = '../includes/player.php?id='.$video['id'];
			$dur = $this->covtime($video['contentDetails']['duration']);
			$uploadTime = "About ".$this->convToAboutTime($video["snippet"]["publishedAt"])." ago";
			
			echo '
			<li>
			  <div class="v-li">
				<div class="v-lt con">
				  <a href="'.$player.'">
					<img src="'.$video['snippet']['thumbnails']['medium']['url'].'" class="thumbs" width="200px" height="120px" alt="'.$video['snippet']['title'].'" />
					<div class="stats">
					  <span title="'.$video["statistics"]["likeCount"].' Likes"><i class="fa fa-heart-o"></i> '.(readable_num($video["statistics"]["likeCount"])).'</span>
					  <span title="'.$video["statistics"]["viewCount"].' Views"><i class="fa fa-eye"></i> '.(readable_num($video["statistics"]["viewCount"])).'</span>
					  <span class="v-dur"><i class="fa fa-clock-o"></i> '.$dur.'</span>
					</div>
				  </a>
				</div>
				<div class="v-rt con">
				  <a href="'.$player.'"><h4>'.$video['snippet']['title'].'</h4></a>
				  <span><a href="/ClipMing/includes/channel.php?cid='.$video['snippet']['channelId'].'">'.$video['snippet']['channelTitle'].'</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
				  <span class="v-uptime">'.$uploadTime.'</span><br>
				  <span class="v-desc">'.$video['snippet']['description'].'</span>
				</div>
			  </div>
			</li>';
		}
		
		echo '</ol>';
		
	} // << End videoList()  --------------------------------------------------------------
	
	public function getRelatedVideo() {
		$video_id = $_REQUEST['id'];
		$url =  'https://www.googleapis.com/youtube/v3/search?';
		$url.= 'part=snippet';
		$url.= '&relatedToVideoId='.$video_id;
		$url.= '&maxResults=30';
		$url.= '&videoEmbeddable=true';
		$url.= '&type=video';
		$url.= '&key='.$this->key;
		$json_response = $this->getJSON($url);
		if(!$json_response)
		   return false;

		$response = $this->getVideoFromJson($json_response);

		foreach($response as $video) {
			$player = 'player.php?id='.$video['id'];
			$dur = $this->covtime($video['contentDetails']['duration']);
			
			echo '
			<li>
			  <div>
				<a href="'.$player.'">
				  <img src="'.$video['snippet']['thumbnails']['medium']['url'].'" class="thumbs" width="288px" height="162px" alt="'.$video['snippet']['title'].'" />
				</a>
				<div class="stats">
				  <span title="'.$video["statistics"]["likeCount"].' Likes"><i class="fa fa-heart-o"></i> '.(readable_num($video["statistics"]["likeCount"])).'</span>
				  <span title="'.$video["statistics"]["viewCount"].' Views"><i class="fa fa-eye"></i> '.(readable_num($video["statistics"]["viewCount"])).'</span>
				  <span class="v-dur"><i class="fa fa-clock-o"></i> '.$dur.'</span>
				</div>
			  </div>
			  <div>
				<a href="'.$player.'"><h4>'.$video['snippet']['title'].'</h4></a>
				<p><a href="/ClipMing/includes/channel.php?cid='.$video['snippet']['channelId'].'">'.$video['snippet']['channelTitle'].'</a></p>
			  </div>
			</li>';
		}
		
	} // << End reccomentVideo()  --------------------------------------------------------------
	
	public function myVideoGrid($user_id) {
		$maxCol = 5;
		$col = 1;
		global $_db;
		
		$channel = $_db->select("channel","*","channel_author = '".$user_id."'");
		$videos_list = $_db->select("channel_video", "video_id, file_loc", "channel_id = '".$channel['channel_id']."'");
		
		if(count($videos_list)==0) {
			echo "<p align='center'><br>You haven't uploaded any Videos , <a href='../includes/upload.php'>Upload Here</a>";
			return false;
		}

		echo '<table class="tb"><tbody><tr>';
		
		foreach($videos_list as $video) {
			$player = 'player.php?id='.$video['video_id'];
			$v_src = "../media/".$video['file_loc'];
			$v_info = $_db->select("video","*","video_id = '".$video['video_id']."'");

			echo '
			<td>
			  <a href="'.$player.'">
				<div>
				  <video width="200" height="120" controls>
					<source src="'.$v_src.'" type="video/mp4">
				  Your browser does not support the Html5 video.
				  </video>
				</div>
				<div>
				  <h4>'.$v_info['title'].'</h4>
				  <p><a href="#">'.$channel['channel_name'].'</a></p>
				</div>
			  </a>
			</td>';
			if($col%$maxCol==0)
				echo '</tr><tr>';
			$col++;
		}
		
		echo '</tr></tbody></table>';
	} // << End myVideoGrid()  --------------------------------------------------------------
} // << End class defination

function el() {
	echo "<br><br>";
}

function v($data) {
	var_dump($data);
}
function readable_num($n) {
	// first strip any formatting;
	$n = (0+str_replace(",","",$n));
	
	// is this a number?
	if(!is_numeric($n)) return false;
	
	// now filter it;
	if($n>1000000000000) return round(($n/1000000000000),1).' T';
	else if($n>1000000000) return round(($n/1000000000),1).' B';
	else if($n>1000000) return round(($n/1000000),1).' M';
	else if($n>1000) return round(($n/1000),1).' K';
	
	return number_format($n);
}

$_db = new Database();
$_cm = new clipming();

?>
