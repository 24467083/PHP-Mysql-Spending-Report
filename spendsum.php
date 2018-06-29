<?php
 include("conf/conn_db1.php"); 
 session_start();
 if(!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
  header("Location: signin.php");
  exit;
 }
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

    <table class="function-table">
     <tr>
      <td><div class="user-dropdown">
        <button id="current_user" class="user-dropbtn"><?php echo "Hi, ".htmlspecialchars($_SESSION["firstname"]." ".$_SESSION["lastname"]); ?> <i class="fa fa-caret-right"></i></button>
        <div class="user-dropdown-content"> 
        <a href="signout.php">Switch User</a>
        <!--<a href="../spendsum.php" onclick="Email_Admin((<?php echo $_SESSION['userid']; ?>),(<?php echo $_SESSION['firstname']; ?>))">Email Admin</a> -->
        <a href="../spendsum.php" onclick="Email_Admin(<?php echo $_SESSION['userid']; ?>)">Email Admin</a>
      </div></div></td>
      <td><select class="searchSelect" id="ft_srch_sl">
          <option value="1">Type</option>
          <option value="2">Sub Total</option>
          <option value="3">Consumed by</option>
          <option value="4">Pay Date</option>
          <option value="5">Location</option>
          <option value="6">Memo</option></select></td>
      <td><input type="text" id="ft_srch" class="searchText" onkeyup="search_by_col()" placeholder="Search within Type"></td>
      <td><p class="searchIcon"><i class="fa fa-search"></i></p></td>
      <td><p class="credits"><a href="input.php"><i class="fa fa-dollar" aria-hidden="true"></i> ADD MORE ITEMS </a></p></td>
     </tr>
     <tr><td colspan="2"><td></tr>
    </table>

    <div class="table100 ver2 m-b-110">
     <table data-vertable="ver2" id="spend_tbl">
      <thead>
       <tr class="row100 head">
 	<th class="column100 column1" data-column="column1" onclick="header_sort(0)">ID</th>
	<th class="column100 column2" data-column="column2" onclick="header_sort(1)">TYPE</th>
	<th class="column100 column3" data-column="column3" onclick="header_sort(2)">SUB TOTAL</th>
	<th class="column100 column4" data-column="column4" onclick="header_sort(3)">CONSUMED BY</th>
	<th class="column100 column5" data-column="column5" onclick="header_sort(4)">PAY DATE</th>
	<th class="column100 column6" data-column="column6" onclick="header_sort(5)">LOCATION</th>
	<th class="column100 column7" data-column="column7" onclick="header_sort(6)">MEMO</th>
	<th class="column100 column8" data-column="column8">Action</th> 
       </tr>
      </thead>
 <tbody>
<?php
$sql = "SELECT id,type,total,who,pay_date,location,memo FROM spending_tbl";
$result = mysqli_query($conn,$sql);
 if(mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
   $row_id = $row["id"];
   echo "<tr class='row100'>";
   echo "<td class='column100 column1' data-column='column1'>".$row_id."</td>";
   echo "<td class='column100 column2' data-column='column2'>".$row["type"]."</td>";
   echo "<td class='column100 column3' data-column='column3'>".$row["total"]."</td>";
   echo "<td class='column100 column4' data-column='column4'>".$row["who"]."</td>";
   echo "<td class='column100 column5' data-column='column5'>".$row["pay_date"]."</td>";
   echo "<td class='column100 column6' data-column='column6'>".$row["location"]."</td>";
   echo "<td class='column100 column7' data-column='column7'>".$row["memo"]."</td>";
   echo "<td class='column100 column8' data-column='column8'>
         <input type='button' class='btn btn-primary btn-sm' id='mod_record' value='Modify' onclick='change_record(".$row_id.");'>&nbsp&nbsp
         <div class='del_button' onclick='del_popup($row_id)'>
          <input type='button' class='btn btn-danger btn-sm' id='del_".$row_id."' value='Delete'>
          <a href='../spendsum.php' onclick='del_record(".$row_id.");'><span class='popup_alarm' id='alarm_".$row_id."'>Are you sure?</span></a>
         </div>
         </td>"; 
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

<script>
var last_id;
function del_popup(line_id) {
 var popup = document.getElementById("alarm_"+line_id);
   popup.classList.toggle("show_alarm");
 var del_txt = document.getElementById("del_"+line_id);
   if (del_txt.value == "Delete") {del_txt.value="NO";}
   else { del_txt.value="Delete";}
 setTimeout(function() {
   popup.classList.remove("show_alarm");
   del_txt.value="Delete";
  },5000);

 var last_popup = document.getElementById("alarm_"+last_id);
 if ((last_popup) && (last_id != line_id)) {
   last_popup.classList.remove("show_alarm");
   var last_del_txt = document.getElementById("del_"+last_id);
   last_del_txt.value="Delete";
 }
 last_id = line_id;
}

function del_record(del_record_id) {
 $.get("del_row.php?id="+del_record_id);
 return false;
}

function change_record(change_record_id) {
 var nw_width = 650;
 var nw_height = 870;
 var w_url = "change_row.php?id="+change_record_id;
 var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;  
 var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;  
              
 w_width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;  
 w_height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;  
              
 var w_left = ((w_width / 2) - (nw_width / 2)) + dualScreenLeft;  
 var w_top = ((w_height / 2) - (nw_height / 2)) + dualScreenTop;  

 var change_window = window.open(w_url, '', 'width='+nw_width+', height='+nw_height+', top='+w_top+', left='+w_left);

 if (window.focus) {
  change_window.focus();
 }
}

document.getElementById("ft_srch_sl").addEventListener("change", update_search_ph);

function update_search_ph() {
 var xx = document.getElementById("ft_srch_sl");
 var yy = xx.options[xx.selectedIndex].text;
 var aa = document.getElementById("ft_srch");
 aa.placeholder = "Search within "+yy;
}

function Email_Admin(user_id) {
 $.get("emailAdmin.php?userid="+user_id);
 var currentU = document.getElementById("current_user");
 alert(currentU.textContent+", you have triggered an email to admin with your contact information. He will contact you soon. Hope you enjoy this site.");
}

</script>
<!--=======External JS===========================================-->	
<script src="css/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="css/vendor/bootstrap/js/popper.js"></script>
<script src="css/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="css/vendor/select2/select2.min.js"></script>
<script src="css/js/main.js"></script>
<script type="text/javascript" src="css/js/sort_search.js"></script>

</body>
</html>
