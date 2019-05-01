<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include_once "../function.php";

$hr=$_GET['hr'];

$im_file=$hr;

$poz=strpos($im_file,'tehnik')+7;
$rez_obr=substr($im_file,$poz);

$download_size = filesize($im_file);
//header("Content-type: application/msword");
header("Content-type: application/msexcel");
header("Content-Disposition: attachment; filename=".$rez_obr.";");
header("Accept-Ranges: bytes");
header("Content-Length: " . $download_size );
readfile($im_file);
?>