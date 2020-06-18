<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
include '../classes/database.php';

include("../function.php");

$kl = (isset($_POST['kl'])) ? $_POST['kl'] : '';
$rn = (isset($_POST['rajon'])) ? $_POST['rajon'] : '';
$ns = (isset($_POST['nsp'])) ? $_POST['nsp'] : '';
$vl = (isset($_POST['vyl'])) ? $_POST['vyl'] : '';
$bd = (isset($_POST['bud'])) ? trim($_POST['bud']) : '';
$kva = (isset($_POST['kvar'])) ? trim($_POST['kvar']) : '';

$db = new Database($lg, $pas);

if (!empty($rn) && !empty($ns) && !empty($vl)) {

    $ath1 = $db->db_link->query("UPDATE arhiv SET RN='$rn', NS='$ns', VL='$vl', BD='$bd', KV='$kva' WHERE ID='$kl' AND DL='1'");
    if (!$ath1) {
        echo "Запис не скоригований";
    }

    header("location: earhiv.php?filter=arh_view&rayon=" . $rn);
} else {
    if ($rn == "") echo "Не заповнено поле Район<br>";
    if ($ns == "") echo "Не заповнено поле Населений пункт<br>";
    if ($vl == "") echo "Не заповнено поле Вулиця<br>";
}

$db->__destruct();


