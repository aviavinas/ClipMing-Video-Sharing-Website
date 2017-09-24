<?php
require_once(__DIR__.'/common.php');

class client {
	private $loginErrEmail = "";
	private $loginErrPass = "";
	private $loginErrCount = 0;
	private $attempt = 0;
	private $email = "";
	private $pass = "";
	private $signupError;
	
	public function __construct() {
		common::getSession();
	}
	public function login() {

		   if(isset($_POST['submit'])) {
			   $this->validate();
		   }
	} // << End login()   -----------------------------------------------------
	
		private function validate() {
				// Validating Input Data
				if(empty($_POST['user_email'])) { 
					$this->loginErrEmail = "* Please Enter Your Email";
					$this->loginErrCount+=1;
				 }
				else if(!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {  
					$this->loginErrEmail = "* Invalid Email !";
					$this->loginErrCount+=1;
				 }
			  
				if(empty($_POST['user_pass'])) {  
					$this->loginErrPass = "* Password can't be empty";
					$this->loginErrCount+=1;
				 }
				else if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,16}$/',$_POST['user_pass'])) {
					$this->loginErrPass = "* Special character not allowed";
					$this->loginErrCount+=1;
				 }
				 // Making Request if ,there is no error	  
				 if($this->loginErrCount==0) {
					 $this->submit();
				 }
		} // << End validate()   -----------------------------------------------------
		
		private function submit() {
				global $_db;
				$this->email = $_POST['user_email'];
				$this->pass = $_POST['user_pass'];
				$result = $_db->select("CmUser","Email,Pass","Email='".$_db->esc_str($this->email)."' and Pass='".$_db->esc_str($this->pass)."'");

				if(@$result["Email"]==$this->email && $result["Pass"]==$this->pass)
				{
						$_SESSION['login_user']=$this->email;
						header("Location: /ClipMing/index.php?user=logged");
						exit();
				}
				else {
						if(isset($_COOKIE['lgn_attempt']))
							$this->attempt = $_COOKIE['lgn_attempt'];
						
						setcookie("lgn_attempt", $this->attempt+1, time() + (600), "/");
						$this->loginErrEmail = "Your Login Name or Password is invalid";
				}
		} // << End submit()   -----------------------------------------------------
		
		
	public function getInfo() {
		global $_db;
		
     	$User = array("UserID"=>"", "Fname"=>"", "Lname"=>"", "Email"=>"", "Pass"=>"", "Gender"=>"", "Country"=>"", "DOB"=>"", "Date_Of_Reg"=>"", "email_verif"=>"", "phone_verif"=>"");
		
		if(isset($_SESSION['login_user'])) { 
				$email = $_db->esc_str($_SESSION['login_user']);
				$res = $_db->select("CmUser","*","Email='".$email."'");

				if(!empty($res["UserID"]))
				  $User['UserID'] = $res["UserID"]; 
				  
				if(!empty($res["Fname"]))
				  $User['Fname'] = $res["Fname"]; 
				
				if(!empty($res["Lname"]))
				  $User['Lname'] = $res["Lname"]; 
				
				if(!empty($res["Email"]))
				  $User['Email'] = $res["Email"]; 
				
				if(!empty($res["Pass"]))
				  $User['Pass'] = $res["Pass"]; 
				
				if(!empty($res["Gender"]))
				  $User['Gender'] = $res["Gender"]; 
				
				if(!empty($res["Country"]))
				  $User['Country'] = $res["Country"]; 
				
				if(!empty($res["email_verif"]))
				  $User['email_verif'] = $res["email_verif"]; 
				
				if(!empty($res["phone_verif"]))
				  $User['phone_verif'] = $res["phone_verif"]; 
				
				if(!empty($res["DateOfBirth"]))
				  $User['DateOfBirth'] = $res["DateOfBirth"]; 
				
				if(!empty($res["Date_Of_Reg"]))
				  $User['Date_Of_Reg'] = $res["Date_Of_Reg"]; 
				 
				 return $User;
		  }
		  else 
		           return false;
	} // << End getInfo()   -----------------------------------------------------
	
	protected function isLogged() {
		
		if(isset($_SESSION['login_user']))
		    return true;
		else
		    return false;
	} // << End isLogged()   -----------------------------------------------------
	 
	public function signUp() {
		  global $_db;
		   // Start Validation ----
		  if(isset($_POST['signup'])) {
			  $error_count = $this->validateSignup();
		  }
		  else {
			  exit(0);
		  }
		  if($error_count==0) {
				 $new_user_id = "CU".common::keygen(6);
				 @$fname = $_db->esc_str($_POST['fname']); 
				 @$lname = $_db->esc_str($_POST['lname']); 
				 @$email = $_db->esc_str($_POST['new_email']); 
				 @$pass = $_db->esc_str($_POST['new_pass']); 
				 @$gender = $_db->esc_str($_POST['gen']); 
				 @$country = $_db->esc_str($_POST['CountryCode']); 
				 @$dob = $_db->esc_str($_POST['dob_year']."-".$_POST['dob_month']."-".$_POST['dob_day']); 
				 @$phone = $_db->esc_str($_POST['phoneNo']);
				 @$date_of_reg = common::ist_time();
				 
				  $res = $_db->select("CmUser","*","Email='".$email."'");
				  if(count($res)<1) {
							$insertOperation = $_db->insert('cmuser',array($new_user_id, $fname, $lname, $email, $pass, $gender, $country, $phone, $dob, $date_of_reg),"UserID, Fname, Lname, Email, Pass, Gender, Country, Phone, DateOfBirth, Date_Of_Reg"); 
							if($insertOperation) 
								  echo "Registered Successfully.";
							else
								  echo "Error in Regisrtation ".$_db->error();
						} 
				  else
							echo "SORRY...YOU ARE ALREADY REGISTERED USER...";
		  }
	} // << End signup()   -----------------------------------------------------
	    
		protected function valFName($fname, &$ec=0) {
			if(empty($fname)) {
				$ec++;
				return "* First Name is Required";
			}
			else if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/',$fname)) {
				$ec++;
				return "* Special character not allowed";
			}
		}
		
		protected function valLName($lname, &$ec=0) {
			if(empty($lname)) {
				$ec++;
				return "* Last Name is Required";
			}
			else if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/',$lname)) {
				$ec++;
				return "* Special character not allowed";
			}
		}
		
		protected function valEmail($email, &$ec=0) {
			if(empty($email)) {
				$ec++;
				return "* Email is Required";
			}
			else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$ec++;
				return "* Invalid Email !";
			}
		}
		
		protected function valPass($pass, &$ec=0) {
			if(empty($pass)) {
				$ec++;
				return "* Password can't be empty";
			}
			else if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,16}$/',$pass)) {
				$ec++;
				return "* These special character not allowed";
			}
		}
		
		protected function valGen($gen, &$ec=0) {
			if(empty($gen)) {
				$ec++;
				return "* Please select a Gender";
			}
			else if($gen!='F' && $gen!='M') {
				$ec++;
				return "* Gender not Accepted !";
			}
		}
		
		protected function valCon($country, &$ec=0) {
			if(empty($country)) {
				$ec++;
				return "* Please Select a Country";
			}
			else if(!preg_match("/^[a-zA-Z ]*$/",$country) || strlen($country)!=2) {
				$ec++;
				return "* Invalid Country Selection !";
			}
		}
		
		protected function valPh($ph, &$ec=0) {
			if(empty($ph)) {
				$ec++;
				return "* Phone Number can't be empty";
			}
			else if(!is_numeric($ph) || !(strlen($ph)>9 && strlen($ph)<16)) {
				$ec++;
				return "* Invalid Phone Number !";
			}
		}
		
		protected function valDb($dd, $dm, $dy, &$ec=0) {
			if(empty($dd) || empty($dm) || empty($dy)) {
				$ec++;
				return "* Incomplete Date of Birth !";
			}
			else if(!checkdate($dm, $dd, $dy)) {
				$ec++; 
				return "* Invalid Date of Birth !";
			}
		}
		
		private function validateSignup() {
					$ec=0; // No. of Error found
					$error_msg = array('fn'=>'','ln'=>'','em'=>'','gn'=>'','ps'=>'','cn'=>'','db'=>'','ph'=>'');
					
					$error_msg['fn'] = $this->valFName($_POST['fname'],$ec);
					$error_msg['ln'] = $this->valLName($_POST['lname'],$ec);
					$error_msg['em'] = $this->valEmail($_POST['new_email'],$ec);
					$error_msg['gn'] = $this->valGen($_POST['gen'],$ec);
					$error_msg['ps'] = $this->valPass($_POST['new_pass'],$ec);
					$error_msg['cn'] = $this->valCon($_POST['CountryCode'],$ec);
					$error_msg['db'] = $this->valDb($_POST['dob_day'],$_POST['dob_month'],$_POST['dob_year'],$ec);
					$error_msg['ph'] = $this->valPh($_POST['phoneNo'],$ec);
					
					$this->signupError = $error_msg;
					return $ec;
					 
		} // << End validateSignup()   -----------------------------------------------------
	
	public function lockPage() {  // Lock a page to prevent unauthorized access
	  if(!$this->isLogged()) {
		header("Location: login.php?msg=Notlogged");
		exit();
		$refferer='http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		setcookie("client_refferer", $refferer, time()+300, '/', 'localhost' );
	  }
	} // << End lockPage()   -----------------------------------------------------
	  
	public function unlockPage() {  // Prevent logged user to access this page
	  if($this->isLogged())
		header("Location: ../../index.php");
	} // << End unlockPage()   -----------------------------------------------------
	
	public function accountLink() {
		if($this->isLogged()) {
			$userInfo = $this->getInfo();
			$name = $userInfo["Fname"];
			return '<i class="fa fa-user"></i><a href="/ClipMing/includes/myAccount.php">'.$name.'</a>';
		}
		else {
			return '<i class="fa fa-sign-in"></i><a href="/ClipMing/includes/login.php">My Account</a>';
		}
	} // << End accountLink()   -----------------------------------------------------
	
	public function logoutLink() {
		if($this->isLogged()) {
			return '<i class="fa fa-sign-out"></i><a href="/ClipMing/includes/logout.php">Logout</a>';
		}
		else {
			return '';
		}
	} // << End accountLink()   -----------------------------------------------------
	
	public function logout() {
		
		session_unset(); // remove all session variables
		session_destroy(); // destroy the session  
		header("Location: ../index.php");
		exit();
	} // << End logout()   -----------------------------------------------------
	
}


 
/*
 * It handles the user operation like - Managing
 * channel and video, Subscription, Playlist.
 */

class user extends client
{
	protected $user;
	
	public function __construct() {
		parent::__construct();

		if(parent::isLogged()) {
			$this->user = parent::getInfo();
		}
	}
	
	public function getUid() {
		$user = $this->user;
		return $user['UserID'];
	}
	
	public function hasChannel() {
		global $_db;
		$user = $this->user;
		$channel = $_db->select("channel","channel_id","channel_author='".$user['UserID']."'");
		
		if(count($channel)>0)
		  return true;
		else
		  return false;
	}
	
	public function updateProfile() {
		global $_db;
		$errMsg = '';
		$attr = '';
		$ec = 0;
		$fData = explode(":", $_POST['FormDat']);
		$key = $fData[0];
		$i=1;
		$val = '';
		while(isset($fData[$i])) {
			$val.= $fData[$i];
			if(isset($fData[$i+1]))
			   $val.= ':';
			$i++;
		}
		
		if($key == "nm") {
			$val = explode(':',$val);
			$fn = $val[0];
			@$ln = $val[1];
			$errMsg.= parent::valFName($fn, $ec);
			$errMsg.= parent::valLName($ln, $ec);
			if($ec==0) {
				$update = $_db->update('cmuser',array('Fname'=>$fn), array('UserID', $this->user['UserID']));
				$update = $_db->update('cmuser',array('Lname'=>$ln), array('UserID', $this->user['UserID']));
				$ec=2; // Encountering Mannual error to prevent ReUpdation
				echo 200;
			}
		}
		else if($key == "em") {
			$errMsg = parent::valEmail($val, $ec);
			$attr = 'Email';
		}
		else if($key == "ph") {
			$errMsg = parent::valPh($val, $ec);
			$attr = 'Phone';
		}
		else if($key == "dob") {
			$v = explode('-',$val);
			$dy = $v[0];
			@$dm = $v[1];
			@$dd = $v[2];var_dump($v);
			$errMsg = parent::valDb($dd, $dm, $dy, $ec);
			$attr = 'DateOfBirth';
		}
		else if($key == "gn") {
			$errMsg = parent::valGen($val, $ec);
			$attr = 'Gender';
		}
		else if($key == "ab") {
			if(empty($val)) {
				$errMsg = "* Cannot update to Empty text";
				$ec++;
			}
			$attr = 'about';
		}
		else if($key == "CountryCode") {
			$errMsg = parent::valCon($val, $ec);
			$attr = 'Country';
		}
		if($ec==0) {
			$update = $_db->update('cmuser',array($attr=>$val), array('UserID', $this->user['UserID']));
			
			if($update) {
			   echo 200;
			   if($attr == 'Email')
			      $_SESSION['login_user']=$val;
			}
			else
			   echo 401;
		}
		else
		    echo $errMsg;
	}
	
	public function getUserPath() {
		global $_db;
		$user = $this->user;
		$author_id = $user['UserID'];
		$channel = $_db->select("channel","channel_id","channel_author='".$author_id."'");
		$channel_id = $channel['channel_id'];
		$file_loc = "uploads/".$author_id."/".$channel_id;
		return $file_loc;
	}
	  
} // << End class defination

/*
 * It handles the user operation like - Managing
 * channel and video, Subscription, Playlist.
 */

class channel extends user
{
	public function __construct() {
		parent::__construct();
		$this->getChannelInfo();
	}
	
	public $channel_id;
	public $channel_name;
	public $channel_label;
	public $channel_desc;
	public $channel_tag;
	public $channel_cat;
	public $channel_author;
	public $creation_date;
	
	public function getChannelInfo() {
		if(!parent::hasChannel())
		  return false;
		global $_db;
		$user = parent::getInfo();
		$channel = $_db->select("channel","*","channel_author='".$user['UserID']."'");

		$this->channel_id = $channel['channel_id'];
		$this->channel_name = $channel['channel_name'];
		$this->channel_label = $channel['channel_label'];
		$this->channel_desc = $channel['discription'];
		$this->channel_tag = $channel['channel_tags'];
		$this->channel_cat = $channel['channel_cat'];
		$this->channel_author = $channel['channel_author'];
		$this->creation_date = $channel['creation_date'];
	}
	 
	public function get($row) {
		global $_db;
		if(!parent::hasChannel())
		  return false;
		
		$user = parent::getInfo();
		$channel = $_db->select("channel",$row,"channel_author='".$user['UserID']."'");
		if($channel) {
			if(count($channel)>0)
			  return $channel[$row];
			else
			  return false;
		}
		else 
		    return false;
	}
	
	public function getLogo() {
		if(!parent::hasChannel())
		  return false;
		
		$channel_logo = $this->get("channel_logo");
		
		if($channel_logo == NULL || empty($channel_logo)) {
			$channel_name = $this->get("channel_name");
			return "<h1 id='logo-h1'>".strtoupper($channel_name[0])."</h1>".'<img alt="'.$this->channel_name.' logo" style="display:none" id="chLogoImg"/>';
		}
		else {
			return '<img src="'.$channel_logo.'" alt="'.$this->channel_name.' logo" id="chLogoImg"/>';
		}
	}
	
	public function getArt() {
		$artImg = $this->get("channel_art");
		if($artImg === NULL || empty($artImg)) {
			return '<img src="../gallery/img/dark_leather.jpg" id="artBanner"/>';
		}
		else {
			return '<img src="'.$artImg.'" id="artBanner"/>';
		}
	}
	
	public function setImage() {
		global $_db;
		if(!parent::hasChannel())
		  return false;
		
		if($_POST['role'] == "logoImg")
		    $role = "channel_logo";
		else if($_POST['role'] == "artImg")
		    $role = "channel_art";
		else
		    return false;
		
		$allowed_mime = array("image/jpeg", "image/png", "image/gif", "image/x-ms-bmp");
		$temp = $_FILES['image']['tmp_name'];
		$ext = explode('.', $_FILES['image']['name']);
		$ext = strtolower(end($ext));
		$file_mime = $_FILES['image']['type'];
		
		$file_name = md5_file($temp) . time() . '.' .$ext;
		$file_loc = "../media/".parent::getUserPath()."/images";

		if(!file_exists($file_loc)) {
			mkdir($file_loc, 0777, true);
		}
		$file_loc .= "/".$file_name;
		
		if($_FILES['image']['error'] === 0) {
			if(in_array($file_mime, $allowed_mime) && move_uploaded_file($temp, $file_loc)) {
				$_db->insert('', array(), $role);
				$update = $_db->update('channel',array($role=>$file_loc), array('channel_id', $this->channel_id));
				if($update)
				   return $file_loc;
			}
		}
	}
	
	public function addChannel() {
		global $_db;
		if(isset($_POST['submit'])) {
			if(empty($_POST['ch_name']))
				return "* Channel Name is required";
				
			else if(!preg_match("/([A-Za-z0-9]+)/", $_POST['ch_name']))
				return  "* Special character not allowed";
			
			else {
				$this->channel_id = "CC".common::keygen(8);
				$channel_author = parent::getInfo();
				$this->channel_author = $channel_author['UserID'];
				$this->channel_name = $_POST['ch_name'];
				$this->channel_label = $_POST['ch_label'];
				$this->channel_desc = $_POST['ch_desc'];
				$this->channel_tag = $_POST['ch_tag'];
				$this->channel_cat = $_POST['ch_cat'];
				$this->creation_date = common::ist_time();
				
				$ins = $_db->insert('channel',array($this->channel_id, $this->channel_author,
												   $this->channel_name, $this->channel_label, 
												   $this->channel_desc, $this->channel_tag, 
												   $this->channel_cat, $this->creation_date),
												   "channel_id, channel_author, channel_name, 
												   discription, channel_label, channel_tags, creation_date, channel_cat"
									);
				if($ins)
				    return true;
				else
				    return false; 
			}
			
		}
	}
} // << End class defination


$_client = new client();
$_user = new user();
$_channel = new channel();
?>