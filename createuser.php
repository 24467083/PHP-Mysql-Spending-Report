<?php
include("conf/conn_db1.php");
 
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$firstname = $lastname = $emailadd = "";
$email_err ="";
 
if($_SERVER["REQUEST_METHOD"] == "POST") {
 if(empty(trim($_POST["username"]))){
   $username_err = "Please enter a name.";
 } else {
    $sql = "SELECT user_id FROM user_tbl WHERE user_login = ?";
    if($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $param_username);
      $param_username = trim($_POST["username"]);
      if(mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1) {
          $username_err = "This name is already taken.";
        } else {
          $username = trim($_POST["username"]);
        }
      } else {
        echo "Oops! Something went wrong. Please contact Tank.";
      }
    }
    mysqli_stmt_close($stmt);
 }
    
 if(empty(trim($_POST["password"]))) {
   $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm your password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if($password != $confirm_password) {
            $confirm_password_err = "Password did not match.";
        }
    }

  $emailadd  = trim($_POST["email"]);
  if((!filter_var($emailadd,FILTER_VALIDATE_EMAIL)) && (!empty($emailadd))) {
   $email_err = "Invalid email address";
  }

  $firstname = trim($_POST["firstname"]);
  $lastname  = trim($_POST["lastname"]);

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
      $sql = "INSERT INTO user_tbl(user_login,user_password,user_firstname,user_lastname,user_email) VALUES(?,?,?,?,?)";
      if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt,"sssss",$param_username,$param_password,$param_firstname,$param_lastname,$param_email);
        $param_username  = $username;
        $param_password  = password_hash($password, PASSWORD_DEFAULT);
        $param_firstname = $firstname;
        $param_lastname  = $lastname;
        $param_email     = $emailadd;
        if(mysqli_stmt_execute($stmt)) {
          header("location: signin.php");
        } else {
          echo "Something went wrong. Please contact Tank.";
         }
      }
     mysqli_stmt_close($stmt);
    }
  mysqli_close($conn);
}
?>
 
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Create User</title>
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
 <link rel="stylesheet" type="text/css" href="css/css/util.css">
 <link rel="stylesheet" type="text/css" href="css/css/main.css">
<!--===============================================================================================-->
</head>
<body>
 <div class="limiter">
  <div class="container-login100" style="background-image: url('css/images/bg-01.jpg');">
  <div class="wrap-login100 p-l-55 p-r-55 p-t-30">
   <form class="login100-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <span class="login100-form-title p-b-20">New User</span>
    <div class="wrap-input100">
    <span class="label-input100">Login Name </span><span class="fieldError"><?php echo $username_err; ?></span>
      <input class="input100" type="text" name="username" placeholder="Create a name to login" value="<?php echo $username; ?>">
    </div>

    <div class="wrap-input100">
    <span class="label-input100">Password </span><span class="fieldError"><?php echo $password_err; ?></span>
      <input class="input100" type="password" name="password" placeholder="Enter a password">
    </div>

    <div class="wrap-input100">
    <span class="label-input100">Confirm Password </span><span class="fieldError"><?php echo $confirm_password_err; ?></span>
      <input class="input100" type="password" name="confirm_password" placeholder="Confrm the password">
    </div>

    <div class="wrap-input100">
    <span class="label-input100">First Name </span>
      <input class="input100" type="text" name="firstname" placeholder="Firstname of new user" value="<?php echo $firstname; ?>">
    </div>

    <div class="wrap-input100">
    <span class="label-input100">Last Name </span>
      <input class="input100" type="text" name="lastname" placeholder="Lastname of new user" value="<?php echo $lastname; ?>">
    </div>

    <div class="wrap-input100">
    <span class="label-input100">Email </span><span class="fieldError"><?php echo $email_err; ?></span>
      <input class="input100" type="text" name="email" placeholder="Enter an email address" value="<?php echo $emailadd; ?>">
    </div>

    <div class="form-group" align="center">
     <input type="submit" class="btn btn-primary btn-lg" value="Submit">&nbsp&nbsp
     <input type="reset" class="btn btn-default btn-lg" value="Reset">
    </div>
  </form>
 </div></div>
</div>

<!--===============================================================================================-->
 <script src="css/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
 <script src="css/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
 <script src="css/vendor/bootstrap/js/popper.js"></script>
 <script src="css/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
 <script src="css/js/main.js"></script>

</body>
</html>
