<?php
require_once(__DIR__.'/../lib/client.php');

if(isset($_POST['user_email']) && isset($_POST['user_pass'])) {
	$_client->login();
}
else if(isset($_POST['signup'])) {
	$_client->signUp();
}
$_client->unlockPage();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>ClipMing | Share Your Videos to World</title>
		<link rel="stylesheet" type="text/css" href="../gallery/css/login.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/header.css" />
        <link rel="icon" type="image/x-icon" href="../gallery/img/icon.png">
		<link rel="stylesheet" type="text/css" href="../gallery/css/main.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/shape.css" />
		<link rel="stylesheet" type="text/css" href="../gallery/css/font-awesome-4.5.0/css/font-awesome.min.css" />
        
    </head>
	<body>
     <?php require_once "country_code.php"; ?>
                              
    	<div class="main_container">
			
			<?php require_once"header.php" ?>
			<div style="clear:both"></div>
            
            <div class="main">
              <div id="login-frm" class="form-div">
                 <div class="upside">
                   <div class="frm-title">
                     <i class="fa fa-bookmark bkm lt"></i>
                     <h1>Have a ClipMing Account ?</h1>
                     <i class="fa fa-bookmark bkm rt"></i>
                   </div>
                   <div id="frm">
                     <form method="post" action="">
                       <span>Email Id : </span>
                       <input type="email" class="input-field" id="o-ml" name="user_email" value="Av@clipming.com" maxlength="50" required>
                       <i class='fa fa-exclamation-circle excl'></i><i class='fa fa-check-circle chk'></i><br/>
                       <span>Password : </span>
                       <input type="password" class="input-field" name="user_pass" maxlength="20" value="pass123" required><br/>
                       <input type="checkbox" name="remember" checked>
                       <span class="sm">Remember me</span><br/>
                       <input type="submit" value="Login" name="submit" id="login-sbmt"></br>
                     </form>
                   </div>
                 </div>
                 <div class="downside">
                   <a href="reset_pass.php" class="sm">Forgot Password ?</a>
                 </div>
              </div>
              <div id="reg-frm" class="form-div">
                 <div class="upside">
                   <div class="frm-title">
                     <i class="fa fa-bookmark bkm lt"></i>
                     <h1>Don't have a ClipMing Account?</h1>
                     <i class="fa fa-bookmark bkm rt"></i>
                   </div>
                   <div id="rg-frm">
                     <form>
                     <h2>What's Your Email ?</h2>
                     <input type="email" name="new_email" class="nw_mail focus-hint" id="n-ml" required maxlength="50" placeholder="Email" value="x@x.xx"><i class='fa fa-exclamation-circle excl'></i><i class='fa fa-check-circle chk'></i><br/>
                     <button type="button" id="goNext">Next</button>
                     </form>
                   </div>
                 </div>
                 <div class="downside">
                   <h2 class="benefits">Register now and receive these benefits</h2>
                     <table>
                       <tr>
                         <td>
                           <i class="fa fa-upload"></i>
                           <img src="../gallery/img/highlight-icon.png" alt="Benefit of Signup" />
                           <p>Upload and Share <br>Your Video <br>to the World.</p>
                         </td>
                         <td>
                           <i class="fa fa-desktop"></i>
                           <img src="../gallery/img/highlight-icon.png" alt="Benefit of Signup" />
                           <p>Monitor Stats <br>and Manage <br>Your Video</p>
                         </td>
                         <td>
                           <i class="fa fa-film"></i>
                           <img src="../gallery/img/highlight-icon.png" alt="Benefit of Signup" />
                           <p>Online Edit <br>and Apply Effect <br>to Your Video.</p>
                         </td>
                       </tr>
                       <tr>
                         <td style="margin-left: 74px;">
                           <i class="fa fa-rupee"></i>
                           <img src="../gallery/img/highlight-icon.png" alt="Benefit of Signup" />
                           <p>Upload and Share <br>Your Video <br>to the World.</p>
                         </td>
                         <td>
                           <i class="fa fa-upload"></i>
                           <img src="../gallery/img/highlight-icon.png" alt="Benefit of Signup" />
                           <p>Upload and Share <br>Your Video <br>to the World.</p>
                         </td>
                       </tr>
                     </table>
                 </div>
              </div>
              <div class="form-div cont signUp-exp">
                <div class="tab">
                  <div class="tb login-tab">
                  <h1><a href="" id="goLogin" style="color:#666">Have a ClipMing Account?</a></h1>
                  </div>
                  <div class="tb signup-tab">
                  <h1><a>Don't have a ClipMing Account?</a></h1>
                  </div>
                </div>
                <div class="signup-main">
                  <form method="post" action="">
                    <div class="sec sec1" id="sec1">
                      <h2>Sign up for a ClipMing Account</h2>
                      <span>Email : </span>
                      <input type="email" id="r_email" name="new_email" maxlength="50" required>
                      <i class='fa fa-exclamation-circle excl'></i><i class='fa fa-check-circle chk'></i>
                      <span>Password : </span>
                      <input type="password" id="r_pass" class="ip" name="new_pass" maxlength="20" required>
                      <span id="err_msg"></span>
                      <span>Confirm Password : </span>
                      <input type="password" id="r_rpass" name="re_pass" maxlength="20" required><br/>
                    </div>
                    <div class="sec sec2" id="sec2">
                      <h2>Please let us know more about you</h2>
                      <table>
                        <tr>
                          <td>
                              <span>First Name : </span>
                              <input type="text" id="r_fn" name="fname" maxlength="25" required>
                              <i class='fa fa-exclamation-circle excl' id="ex-fn"></i>
                          </td>
                          <td>
                              <span>Last Name : </span>
                              <input type="text" id="r_ln" name="lname" maxlength="25" required>
                              <i class='fa fa-exclamation-circle excl' id="ex-ln"></i><br>
                          </td>
                        </tr>
                        <tr>
                          <td>
                              <span>Gender : </span>
                              
                              <b>Male </b><input type="radio" id="r_gM" name="gen" value="M">
                              <b>Female </b><input type="radio" id="r_gF" name="gen" value="F">  
                              <i class='fa fa-exclamation-circle excl' id="ex-gn"></i>                        
                          </td>
                          <td>
                              <span>Date Of Birth : </span>
                              <?php echo $date; ?>
                              <i class='fa fa-exclamation-circle excl' id="ex-db"></i><br>
                          </td>
                        </tr>
                        <tr>
                          <td>
                              <span>Phone No. : </span>
                              <input type="tel" id="r_ph" name="phoneNo" maxlength="15" required>
                              <i class='fa fa-exclamation-circle excl' id="ex-ph"></i>
                          </td>
                          <td>
                              <span>Country : </span>
                             <?php echo $countryList; ?>
                          </td>
                        </tr>
                      </table>
                    </div>
                    <div class="sec sec3" id="sec3">
                      <h2>Let Finish Now</h2>
                      <span>By providing your information and registering you are agreeing to the Zend Terms of Use.</span><br>
                      <input type="checkbox" id="r_chk" name="agree" required>
                      <i class='fa fa-exclamation-circle excl'></i>
                      <span>I agree to the Privacy Policy</span><br>
                      <button type="submit" id="signup-sbmt" name="signup" value="signup"><i class="fa fa-user-plus"></i>Registor Now</button>
                    </div>
                    <div class="sec sec4" id="sec4">
                      <h2>Register with your Social accounts</h2>
                      <a href="#" class="hvr-bounce-to-top fb"><i class="fa fa-facebook"></i>FACEBOOK</a>
                      <a href="#" class="hvr-bounce-to-top tw"><i class="fa fa-twitter"></i>TWITTER</a>
                      <a href="#" class="hvr-bounce-to-top gl"><i class="fa fa-google"></i>Google</a>
                    </div>
                     
                  </form>
                </div>
              </div>
              
              </div>  
			</div>
            
            <?php require_once "footer.php" ?>
            
            <script src="../gallery/js/strength.js"></script>
			<script src="../gallery/js/login.js"></script>
            
        </div>
		
    </body>
</html>
