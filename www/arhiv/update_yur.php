<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include("../function.php");

$kl = $_GET['kl'];
$name = addslashes($_GET['name']);
$namef = addslashes($_GET['namef']);
$boss = addslashes($_GET['boss']);
$boss_f = addslashes($_GET['boss_f']);
$pidstava = addslashes($_GET['pidstava']);
$adres = addslashes($_GET['adres']);
$telef = $_GET['telef'];
$email = $_GET['email'];
$pdv = $_GET['pdv'];
$edrpou = $_GET['edrpou'];
$svid = $_GET['svid'];
$ipn = $_GET['ipn'];
$bank = addslashes($_GET['bank']);
$mfo = $_GET['mfo'];
$rr = $_GET['rr'];

$prilad = (isset($_GET["prilad"])) ? addslashes(trim($_GET["prilad"])) : '';
$ser_sert = (isset($_GET["ser_sert"])) ? addslashes(trim($_GET["ser_sert"])) : '';
$numb_sert = (isset($_GET["numb_sert"])) ? addslashes(trim($_GET["numb_sert"])) : '';
$so_ipn = (isset($_GET["so_ipn"])) ? addslashes(trim($_GET["so_ipn"])) : '';
$so_pr = (isset($_GET["so_pr"])) ? addslashes(trim($_GET["so_pr"])) : '';
$so_im = (isset($_GET["so_im"])) ? addslashes(trim($_GET["so_im"])) : '';
$so_pb = (isset($_GET["so_pb"])) ? addslashes(trim($_GET["so_pb"])) : '';

$n_dog = (isset($_GET["ndog"])) ? addslashes(trim($_GET["ndog"])) : '';
$dt_dog = (isset($_GET["dtdog"])) ? date_bd($_GET["dtdog"]) : '';

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$ath1 = mysql_query("UPDATE yur_kl SET N_DOG='$n_dog',DT_DOG='$dt_dog',NAME='$name',EDRPOU='$edrpou',SVID='$svid',IPN='$ipn',ADRES='$adres',
	TELEF='$telef',NAME_F='$namef',BOSS='$boss',BOSS_F='$boss_f',PIDSTAVA='$pidstava',RR='$rr',BANK='$bank',MFO='$mfo',EMAIL='$email',ED_POD='$pdv',PRILAD='$prilad',
	SERT_S='$ser_sert',SERT_N='$numb_sert',SO_IPN='$so_ipn',SO_PR='$so_pr',SO_IM='$so_im',SO_PB='$so_pb' 
	WHERE yur_kl.ID='$kl' AND yur_kl.DL='1'");
if (!$ath1) {
    echo "Запис не скоригований";
}

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

header("location: arhiv.php?filter=yur_view");
