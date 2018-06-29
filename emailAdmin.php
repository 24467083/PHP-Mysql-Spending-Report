<?php
$email_sender = parse_ini_file("conf/admin_email.ini");
include("conf/conn_db1.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "phpMailer/PHPMailer-6.0.5/src/Exception.php";
require "phpMailer/PHPMailer-6.0.5/src/PHPMailer.php";
require "phpMailer/PHPMailer-6.0.5/src/SMTP.php";

$emailSender = $email_sender["email_addr"];
$emailFrname = $email_sender["email_from"];

$target_uid = $_GET["userid"];

$sql = "SELECT user_firstname,user_lastname,user_login,user_email FROM user_tbl WHERE user_id=$target_uid";
$target_ures = mysqli_query($conn,$sql);
$target_urow = mysqli_fetch_assoc($target_ures);
$customer_fname = $target_urow['user_firstname'];
$customer_lname = $target_urow['user_lastname'];
$customer_login = $target_urow['user_login'];
$customer_email = $target_urow['user_email'];

$mail = new PHPMailer();
//$mail->SMTPDebug = 2;
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = $email_sender["email_smtp"];
$mail->Host = $email_sender["email_host"];
$mail->Port = $email_sender["email_port"];
$mail->CharSet = "utf-8";
$mail->Username = $emailSender;
$mail->Password = $email_sender["email_pswd"];
$mail->setFrom($emailSender,$emailFrname);
$mail->AddAddress($emailSender);
$mail->Subject = $customer_fname." Need Help";
$mail->Body = $customer_fname." ".$customer_lname." need assistance.<br>"
              ."User Login: ".$customer_login."<br>"
              ."User Email: ".$customer_email."<br>";
$mail->IsHTML(true);
$mail->Send();
//if (!$mail->Send()) { echo $mail->ErrorInfo; }
//else {echo "Sent"; }
?>

