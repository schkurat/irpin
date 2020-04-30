<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
$kl = $_GET['kl'];

$dt_pv = date("Y-m-d");
include "../function.php";

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$sql = "UPDATE `arhiv_dop_adr`  SET status=1,PV='1',PV_DATE='$dt_pv' WHERE arhiv_dop_adr.id='$kl'";
$ath1 = mysql_query($sql);


//Zakrutie bazu

if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

if ($ath1) {
    echo '1';
} else {
    echo '0';
}