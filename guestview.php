<?php
 include("conf/conn_db1.php"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <title>Spending Summary</title>
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
<link rel="stylesheet" type="text/css" href="css/vendor/select2/select2.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="css/vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="css/css/util.css">
<link rel="stylesheet" type="text/css" href="css/css/main.css">
<!--===============================================================================================-->
</head>
<body>
 <div class="limiter">
  <div class="container-table100">
   <div class="wrap-table100">
     <p class="credits"><a href="guestinput.php"><i class="fa fa-dollar" aria-hidden="true"></i> ADD MORE ITEMS </a></p></br></br>
    <div class="table100 ver2 m-b-110">
     <table data-vertable="ver2">
      <thead>
       <tr class="row100 head">
 	<th class="column100 column1" data-column="column1">ID</th>
	<th class="column100 column2" data-column="column2">TYPE</th>
	<th class="column100 column3" data-column="column3">SUB TOTAL</th>
	<th class="column100 column4" data-column="column4">CONSUMED BY</th>
	<th class="column100 column5" data-column="column5">PAY DATE</th>
	<th class="column100 column6" data-column="column6">LOCATION</th>
	<th class="column100 column7" data-column="column7">MEMO</th>
       </tr>
      </thead>
 <tbody>
<?php
$sql = "SELECT id,type,total,who,pay_date,location,memo FROM spending_tbl";
$result = mysqli_query($conn,$sql);
 if(mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
   echo "<tr class='row100'>";
   echo "<td class='column100 column1' data-column='column1'>".$row["id"]."</td>";
   echo "<td class='column100 column2' data-column='column2'>".$row["type"]."</td>";
   echo "<td class='column100 column3' data-column='column3'>".$row["total"]."</td>";
   echo "<td class='column100 column4' data-column='column4'>".$row["who"]."</td>";
   echo "<td class='column100 column5' data-column='column5'>".$row["pay_date"]."</td>";
   echo "<td class='column100 column6' data-column='column6'>".$row["location"]."</td>";
   echo "<td class='column100 column7' data-column='column7'>".$row["memo"]."</td>";
   echo "</tr>";
  }
 } else {
   echo "0 results";
 }
mysqli_close($conn);

?>

     </tbody>
    </table>
   </div>
  </div>
 </div>
</div>

<!--===============================================================================================-->	
<script src="css/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="css/vendor/bootstrap/js/popper.js"></script>
<script src="css/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="css/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="css/js/main.js"></script>

</body>
</html>
