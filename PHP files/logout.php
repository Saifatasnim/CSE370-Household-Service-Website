<?php
session_start();
$_SESSION = array();

session_destroy();
header("location: http://localhost/household_service_website/sign_in.php");
exit;
?>
