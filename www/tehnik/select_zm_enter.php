<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$kl_zm=$_GET['kl'];
$vuk=$_GET['vuk'];

$vul=$_GET['vul'];
$nsp=$_GET['nsp'];
$bud=$_GET['bud'];

$_SESSION['KL_ZM']=$kl_zm;
$_SESSION['VUK']=$vuk;

$_SESSION['VUL']=$vul;
$_SESSION['NSP']=$nsp;
$_SESSION['BUD']=$bud;

header("location: tehnik.php?filter=fon");
?>