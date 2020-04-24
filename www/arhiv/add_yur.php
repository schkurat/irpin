<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include("../function.php");

$name = addslashes($_GET['name']);
$namef = addslashes($_GET['namef']);
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

$ath1 = mysql_query("INSERT INTO yur_kl(N_DOG,DT_DOG,NAME,EDRPOU,SVID,IPN,ADRES,TELEF,NAME_F,RR,BANK,MFO,EMAIL,ED_POD,PRILAD,SERT_S,SERT_N,SO_IPN,SO_PR,SO_IM,SO_PB) 
	VALUES('$n_dog','$dt_dog','$name','$edrpou','$svid','$ipn','$adres','$telef','$namef','$rr','$bank','$mfo','$email','$pdv','$prilad','$ser_sert','$numb_sert','$so_ipn','$so_pr','$so_im','$so_pb');");
if (!$ath1) {
    echo "Клієнт не внесений до БД";
}


//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

header("location: arhiv.php?filter=yur_view");
