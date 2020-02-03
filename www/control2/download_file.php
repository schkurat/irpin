<?php
//header('Content-type: application/octet-stream');
$dir = substr(strrchr($_GET['url'], "/"), 1);
header("Content-type: application/x-download");
header("Content-Disposition: attachment; filename=" . $dir);
$x = fread(fopen($_GET['url'], "rb"), filesize($_GET['url']));
echo $x;