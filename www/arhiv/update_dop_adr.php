<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include("../function.php");

$kl = (isset($_POST['kl'])) ? $_POST['kl'] : '';
$rn = (isset($_POST['rajon'])) ? $_POST['rajon'] : '';
$ns = (isset($_POST['nsp'])) ? $_POST['nsp'] : '';
$vl = (isset($_POST['vyl'])) ? $_POST['vyl'] : '';
$bd = (isset($_POST['bud'])) ? trim($_POST['bud']) : '';
$kva = (isset($_POST['kvar'])) ? trim($_POST['kvar']) : '';

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

if (!empty($rn) && !empty($ns) && !empty($vl)) {

    $ath1 = mysql_query("UPDATE arhiv_dop_adr SET rn='$rn', ns='$ns', vl='$vl', bud='$bd', kvar='$kva' 
	WHERE id='$kl' AND DL='1'");
    if (!$ath1) {
        echo "Запис не скоригований";
    }

    header("location: arhiv.php?filter=zm_view");
} else {
    if ($rn == "") echo "Не заповнено поле Район<br>";
    if ($ns == "") echo "Не заповнено поле Населений пункт<br>";
    if ($vl == "") echo "Не заповнено поле Вулиця<br>";
}

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
