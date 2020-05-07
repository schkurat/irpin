<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
include("../function.php");

$id_vr = $_POST['vud_rob']; //вид робіт
$pr = addslashes(trim($_POST['priz']));
$im = addslashes(trim($_POST['imya']));
$pb = addslashes(trim($_POST['pobat']));
$prim = addslashes($_POST['prim']);
$sert = trim($_POST['sert']);
$subj = addslashes(trim($_POST['subj']));
$adrs_subj = addslashes(trim($_POST['adrs_subj']));
$edrpou = $_POST['edrpou'];
$ipn = $_POST['ipn'];
$svid = $_POST['svid'];
$prilad = addslashes($_POST['prilad']);
$dover = addslashes($_POST['doruch']);
$tl = trim($_POST['tel']);
if (isset($_POST['email'])) $email = $_POST['email']; else $email = "";
$sm = $_POST['sum'];
//$d_pr = date_bd($_POST['d_pr']);
$kl = $_POST['kll'];

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$ath1 = mysql_query("UPDATE arhiv_zakaz SET VUD_ROB='$id_vr',EDRPOU='$edrpou',IPN='$ipn',SVID='$svid',
                       SUBJ='$subj',ADR_SUBJ='$adrs_subj',PRILAD='$prilad',PR='$pr',IM='$im',PB='$pb',PRIM='$prim',
                       SERT='$sert',TEL='$tl',EMAIL='$email',DOR='$dover',SUM='$sm' WHERE arhiv_zakaz.KEY='$kl'");
if (!$ath1) {
    echo "Замовлення не внесене до БД";
}

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

header("location: arhiv.php?filter=zm_view");
