<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
$tp = $_GET['tip'];

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

if ($tp == 'zakaz') {
    $kl = $_GET['kl'];
    $ath = mysql_query("UPDATE arhiv_zakaz SET DL='0' WHERE arhiv_zakaz.KEY='$kl'");
    if (!$ath) {
        echo "Замовлення не видалено з БД";
    }
}

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

header("location: arhiv.php?filter=zm_view");

