<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "../function.php";
$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";
if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}
$response = '';

$kl = (isset($_POST['kl'])) ? $_POST['kl'] : false;
$status = (isset($_POST['status'])) ? $_POST['status'] : false;

if ($kl && $status) {
    $ath1 = mysql_query("UPDATE zamovlennya SET STATUS='$status' WHERE zamovlennya.KEY='$kl'");
    if (!$ath1) {
        echo "Статус не змінено";
    }
    $response = $status;
}

if (mysql_close($db)) {
} else {
    echo("Не можливо виконати закриття бази");
}

echo $response;