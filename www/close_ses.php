<?php
session_start();

unset($_SESSION['LG']);
unset($_SESSION['PAS']);
unset($_SESSION['PR']);
unset($_SESSION['IM']);
unset($_SESSION['PB']);
unset($_SESSION['PD']);

session_destroy();

header("location: index.php");
?>