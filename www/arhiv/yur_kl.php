<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "../function.php";
$ipn = "";
$svid = "";
$nazva = "";
$telef = "";
$email = "";
$sert_s = "";
$sert_n = "";
$so_ipn = "";
$so_pr = "";
$so_im = "";
$so_pb = "";

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";
if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

if (isset($_POST['edrpou'])) {
    $edrpou = $_POST['edrpou'];
    if ($edrpou != "") {
        $ath = mysql_query("SELECT * FROM yur_kl WHERE EDRPOU=$edrpou;");
        if ($ath) {
            while ($aut = mysql_fetch_array($ath)) {
                $nazva = $aut['NAME'];
                $ipn = $aut['IPN'];
                $svid = $aut['SVID'];
                $adres = $aut['ADRES'];
                $telef = $aut['TELEF'];
                $email = $aut['EMAIL'];
                $prilad = $aut['PRILAD'];
                $sert_s = $aut['SERT_S'];
                $sert_n = $aut['SERT_N'];
                $so_ipn = $aut['SO_IPN'];
                $so_pr = $aut['SO_PR'];
                $so_im = $aut['SO_IM'];
                $so_pb = $aut['SO_PB'];
            }
            mysql_free_result($ath);
        }
    }
}
echo $nazva . ':' . $ipn . ':' . $svid . ':' . $telef . ':' . $email . ':' . $adres . ':' . $prilad . ':' . $sert_s . ':' . $sert_n . ':' . $so_ipn . ':' . $so_pr . ':' . $so_im . ':' . $so_pb;

//echo 'Текст:вася:петя';
if (mysql_close($db)) {
} else {
    echo("Не можливо виконати закриття бази");
}
