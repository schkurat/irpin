<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
include "../function.php";
$kl = (int)$_POST["kl"];

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

//удаляем из кассы_ерор строку 
$ath = mysql_query("UPDATE kasa SET DL='0' WHERE kasa.ID='$kl'");
if (!$ath) {
    echo "Error";
}else{
    echo "Success";
}



if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
