<?php
$url=$_GET['url'];
$kat=$_GET['kat'];
$name=$_GET['name'];
$adr=$_GET['adr'];

$rez=unlink( $url);
if(!$rez) echo 'Ошибка удаления файла!';
else
header("location: earhiv.php?filter=file_view&kat=".$kat."&name=".$name."&adr=".$adr);
?>