<?php
include("conf/conn_db1.php");
$username = $password = "";
$username_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $input_uname = trim($_POST["username"]);
  $input_passw = trim($_POST["password"]);
 if(empty($input_uname)){
   $username_err = "Please enter login name.";
    } else{
        $username = $input_uname;
    }
    
 if(empty($input_passw)){
   $password_err = 'Please enter your password.';
    } else{
        $password = $input_passw;
    }
  
 if(empty($username_err) && empty($password_err)){
   $sql = "SELECT user_login,user_password,user_firstname,user_lastname FROM user_tbl WHERE user_login = ?";
     if($stmt = mysqli_prepare($conn, $sql)){
       mysqli_stmt_bind_param($stmt, "s", $param_username);
       $param_username = $username;
         if(mysqli_stmt_execute($stmt)){
           mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){                    
              mysqli_stmt_bind_result($stmt,$username,$hashed_password,$userfirstname,$userlastname);
                if(mysqli_stmt_fetch($stmt)){
                  if(password_verify($password, $hashed_password)){
                     session_start();
                     $_SESSION["username"]  = $username;
                     $_SESSION["firstname"] = $userfirstname;
                     $_SESSION["lastname"]  = $userlastname;
                     header("location: spendsum.php");
                  }
                  else{ $password_err = 'The password was not valid.'; }
                }
            }
            else{ $username_err = 'Account not found.'; }
         }
         else{ echo "Oops! Something went wrong. Please contact Tank."; }
     }
     mysqli_stmt_close($stmt);
 }
 mysqli_close($conn);
}
?>

<html lang="en">
<head>
 <title>Sign In</title>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
 <link rel="icon" type="image/png" href="css/images/icons/money.ico"/>
<!--===============================================================================================-->
 <link rel="stylesheet" type="text/css" href="css/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
 <link rel="stylesheet" type="text/css" href="css/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
 <link rel="stylesheet" type="text/css" href="css/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
 <link rel="stylesheet" type="text/css" href="css/vendor/animate/animate.css">
<!--===============================================================================================-->	
 <link rel="stylesheet" type="text/css" href="css/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
 <link rel="stylesheet" type="text/css" href="css/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
 <link rel="stylesheet" type="text/css" href="css/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
 <link rel="stylesheet" type="text/css" href="css/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
 <link rel="stylesheet" type="text/css" href="css/css/util.css">
 <link rel="stylesheet" type="text/css" href="css/css/main.css">
<!--===============================================================================================-->
</head>
<body>
 <div class="limiter">
  <div class="container-login100" style="background-image: url('css/images/bg-01.jpg');">
   <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
    <form class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
     <span class="login100-form-title p-b-49">Sign In</span>
      <div class="wrap-input100 validate-input m-b-23>">
       <span class="label-input100">Username </span><span class="fieldError"><?php echo $username_err; ?></span>
	   <input class="input100" type="text" name="username" placeholder="Type your username" value="<?php echo $username; ?>">
       <span class="focus-input100" data-symbol="&#xf206;"></span>
      </div>

      <div class="wrap-input100 validate-input">
       <span class="label-input100">Password </span><span class="fieldError"><?php echo $password_err; ?></span>
       <input class="input100" type="password" name="password" placeholder="Type your password">
       <span class="focus-input100" data-symbol="&#xf190;"></span>
      </div>
					
      <div class="text-right p-t-8 p-b-31">
       <a href="#">Forgot password?</a>
      </div>
					
      <div class="container-login100-form-btn">
       <div class="wrap-login100-form-btn">
        <div class="login100-form-bgbtn"></div>
         <button class="login100-form-btn" type="submit" name="signin">Sign In</button>
	</div>	
       </div></br>

       <div class="text-center p-t-8 p-b-31">
        <a href="guestview.php" class="txt2">Guest Sign In</a>
       </div>
      </form>
     </div>
    </div>
   </div>
	
<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
 <script src="css/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
 <script src="css/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
 <script src="css/vendor/bootstrap/js/popper.js"></script>
 <script src="css/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
 <script src="css/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
 <script src="css/vendor/daterangepicker/moment.min.js"></script>
 <script src="css/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
 <script src="css/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
 <script src="css/js/main.js"></script>

</body>
</html>
