<?php
//header('Content-type: application/octet-stream');
header("Content-type: application/x-download");
header("Content-Disposition: attachment; filename=".$_GET['url']);
$x = fread(fopen($_GET['url'], "rb"), filesize($_GET['url'])); 
echo $x;
?>