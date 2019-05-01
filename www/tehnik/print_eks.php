<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$vuk=$_SESSION['VUK'];
$vul=$_SESSION['VUL'];
$nsp=$_SESSION['NSP'];
$bud=$_SESSION['BUD'];
include_once "../function.php";

$file_fiz='eskiz.xml';
$file_fiz_new='eskiz_new.xml';

$file = fopen($file_fiz, 'r');
$text_kvut = fread($file, filesize($file_fiz));
fclose($file);

$patterns[0] = "[bud]";
$patterns[1] = "[vulutsya]";
$patterns[2] = "[naspunkt]";
$patterns[3] = "[vukonav]";

$replacements[0] = $bud;
$replacements[1] = $vul;
$replacements[2] = $nsp;
$replacements[3] = $vuk;

$text_kvut_new=preg_replace($patterns, $replacements,$text_kvut);

$filez = fopen($file_fiz_new, 'w+');
fwrite($filez,$text_kvut_new);
fclose($filez);

$download_size = filesize($file_fiz_new);
//header("Content-type: application/msword");
header("Content-type: application/msexcel");
header("Content-Disposition: attachment; filename=".$file_fiz_new.";");
header("Accept-Ranges: bytes");
header("Content-Length: " . $download_size );
readfile($file_fiz_new);

?>