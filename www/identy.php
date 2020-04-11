<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once "function.php";
$lg = $_POST['login'];
$ps = $_POST['parol'];

//$pas=md5($ps);
$pas = $ps;

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}
//AND PAS=PASSWORD('$pas')
$sql = "SELECT * FROM security WHERE LOG='$lg' AND DL='1'";

$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $pr = $aut["PR"];
    $im = $aut["IM"];
    $pb = $aut["PB"];
    $pd = $aut["PRD"];
    $brigada = $aut["BR"];
    $ddl = $aut['DTL'];
}
mysql_free_result($atu);

if($brigada == 0){
    $robs = $pr . ' ' . p_buk($im) . '.' . p_buk($pb) . '.';
    $sql = "SELECT BRUGADA FROM robitnuku WHERE ROBS='$robs' AND DL='1'";
    $atu = mysql_query($sql);
    while ($aut = mysql_fetch_array($atu)) {
        $brigada = $aut["BRUGADA"];
    }
    mysql_free_result($atu);
}

if ($pr != "") {
    $_SESSION['LG'] = $lg;
    $_SESSION['PAS'] = $pas;
    $_SESSION['PR'] = $pr;
    $_SESSION['IM'] = $im;
    $_SESSION['PB'] = $pb;
    $_SESSION['PD'] = $pd;
    $_SESSION['BRIGADA'] = $brigada;
    if ($ddl == '1') $_SESSION['DDL'] = '1';
    else $_SESSION['DDL'] = '0';
}
//Zakrutie bazu--
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
header("location: menu.php");

