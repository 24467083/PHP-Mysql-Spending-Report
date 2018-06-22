<?php
include("conf/conn_db1.php");
 $del_row_num=$_GET['id']; 
 $sql = "DELETE FROM spending_tbl WHERE id=$del_row_num";
 mysqli_query($conn,$sql);
 mysqli_close($conn);
?>
 
