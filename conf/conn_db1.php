<?php
$dbconfig = parse_ini_file("conf/db1_conf.ini");

$conn = mysqli_connect($dbconfig["srv_name"],$dbconfig["db_user"],$dbconfig["user_psw"],$dbconfig["db_name"]);

if (!$conn) {
 die("Connection failed: " . mysqli_connect_error());
}

