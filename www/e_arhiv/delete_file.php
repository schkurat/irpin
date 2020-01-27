<?php
$url = $_GET['url'];
$sz = $_GET['sz'];
$nz = $_GET['nz'];
$id_storage = $_GET['id_storage'];

$rez = unlink($url);
if (!$rez) echo 'Ошибка удаления файла!';
else
    header("location: earhiv.php?filter=spr_view&sz=" . $sz . "&nz=" . $nz . "&id_storage=" . $id_storage);
