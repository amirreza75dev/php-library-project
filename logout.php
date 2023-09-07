<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header('Location: login.php');
exit(); // Make sure to exit the script after the redirection
?>