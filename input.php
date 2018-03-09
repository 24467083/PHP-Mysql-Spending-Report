<?php
 include("conf/conn_db1.php");
 session_start();
 if(!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
  header("Location: signin.php");
  exit;
 }

$totalErr = $paydateErr = "";
$total_spend = $sql_paydate = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
  if(empty($_POST["total"])) {
    $totalErr = "Total spent is required!";
  } else {
    $total_spend = $_POST["total"];
     if (!preg_match("/^\d+$/",$total_spend)) {
      $totalErr = "Only integer data in Total field!";
    }
  }

  if(empty($_POST["pay_date"])) {
    $paydateErr = "Date spent is required!";
  } else {
     $sql_paydate = date('Y-m-d',strtotime($_POST['pay_date']));

     $sql = "INSERT INTO spending_tbl (type,total,who,pay_date,location,memo)
            values ('$_POST[type]','$total_spend','$_POST[who]','$sql_paydate','$_POST[location]','$_POST[memo]')";

     if(mysqli_query($conn,$sql))
      { echo "New spending record is added.";
        header("location:spendsum.php");
      } else {
        echo "Failed to add." . mysqli_error($conn);
      }
  } 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
 <title>Add Consumption</title>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
 <link rel="icon" type="image/png" href="css/images/icons/money.ico"/>
<!--===============================================================================================-->
 <link rel="stylesheet" type="text/css" href="css/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
 <link rel="stylesheet" type="text/css" href="css/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
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
 <link rel="stylesheet" type="text/css" href="css/vendor/jquery-ui/jquery-ui.css">
<!--===============================================================================================-->
 <link rel="stylesheet" type="text/css" href="css/css/util.css">
 <link rel="stylesheet" type="text/css" href="css/css/main.css">
<!--===============================================================================================-->
</head>
<body>
 <div class="container-contact100">
  <div class="wrap-contact100">
    <form class="contact100-form validate-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
     <span class="contact100-form-title">New Consumption</span>
      
      <div class="wrap-input100 input100-select">
       <span class="label-input100">Cost Type</span>
        <div>
         <select class="selection-2" name="type">
	  <option>House/Renter</option>
	  <option>Food</option>
	  <option>Restaurant</option>
	  <option>Cell Mobile</option>
	  <option>Electricity</option>
	  <option>Gocery</option>
	 </select>
	</div>
       <span class="focus-input100"></span>
      </div>

      <div class="wrap-input100">
       <span class="label-input100">Total Spent </span><span class="fieldError">* <?php echo $totalErr; ?></span>
        <input class="input100" type="text" name="total" placeholder="How much did you spend" value="<?php if(isset($_POST['total'])){ echo $_POST['total'];} ?>">
         <span class="focus-input100"></span>
      </div>

      <div class="wrap-input100 input100-select">
       <span class="label-input100">Who did it</span>
        <div>
         <select class="selection-2" name="who">
          <option>Tank</option>
	  <option>Jen</option>
         </select>
	</div>
       <span class="focus-input100"></span>
      </div>

      <div class="wrap-input100 validate-input">
       <span class="label-input100">Spent on day </span><span class="fieldError">* <?php echo $paydateErr; ?></span>
        <input class="input100" type="text" name="pay_date" id="datepicker" placeholder="Pickup a date">
         <span class="focus-input100"></span>
      </div>

      <div class="wrap-input100 input100-select">
       <span class="label-input100">Where did you spend</span>
        <div>
         <select class="selection-2" name="location">
          <option>Austin</option>
          <option>Houston</option>
         </select>
        </div>
       <span class="focus-input100"></span>
      </div>

      <div class="wrap-input100 validate-input">
       <span class="label-input100">Memo/Notes</span>
        <textarea class="input100" name="memo" placeholder="Put notes here..."></textarea>
         <span class="focus-input100"></span>
      </div>

      <div class="container-contact100-form-btn">
       <div class="wrap-contact100-form-btn">
        <div class="contact100-form-bgbtn"></div>
         <button class="contact100-form-btn" type="submit" name="save">
	  <span>Submit
	   <i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
	  </span>
	 </button>
        </div>
       </div>
    </form>
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
 <script>
  $(".selection-2").select2({
  minimumResultsForSearch: 20,
  dropdownParent: $('#dropDownSelect1')
 });
 </script>
<!--===============================================================================================-->
 <script src="css/vendor/daterangepicker/moment.min.js"></script>
 <script src="css/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
 <script src="css/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
 <script src="css/js/main.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
 <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
 <script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
 </script>
<!--===============================================================================================-->
 <script src="css/vendor/jquery/jquery-3.2.1.min.js"></script>
 <script src="css/vendor/jquery-ui/jquery-ui.js"></script>
 <script>
 $( function() {
   $( "#datepicker" ).datepicker();
 } );
 </script>


</body>
</html>
