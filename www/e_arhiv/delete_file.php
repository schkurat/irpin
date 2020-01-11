<?php
$url = $_GET['url'];
$inv = $_GET['inv'];

$rez = unlink($url);
if (!$rez) echo 'Ошибка удаления файла!';
else
    header("location: earhiv.php?filter=spr_view&inv_spr=" . $inv);
