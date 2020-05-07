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

$id_el_arh = 0;
$sql = "SELECT ID FROM arhiv WHERE RN='$rn' AND NS='$ns' AND VL='$vl' AND BD='$bd' AND KV='$kva' AND DL='1'";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $id_el_arh = $aut["ID"];
}
mysql_free_result($atu);

if ($id_el_arh == 0) {
    $ath3 = mysql_query("INSERT INTO arhiv (RN,NS,VL,BD,KV) VALUES('$rn','$ns','$vl','$bd','$kva');");
    $id_el_arh = mysql_insert_id();
}

if (!empty($rn) and !empty($ns) and !empty($vl) and !empty($bd) and !empty($kl)) {
    $ath1 = mysql_query("INSERT INTO arhiv_dop_adr (id_zm,id_arh,rn,ns,vl,bud,kvar) VALUES('$kl','$id_el_arh','$rn','$ns','$vl','$bd','$kva');");
    if (!$ath1) {
        echo "Адреса не внесена до БД";
    }
    header("location: arhiv.php?filter=zm_view");
} else {
    if ($rn == "") echo "Не заповнено поле Район<br>";
    if ($ns == "") echo "Не заповнено поле Населений пункт<br>";
    if ($vl == "") echo "Не заповнено поле Вулиця<br>";
    if ($bd == "") echo "Не заповнено поле Будинок<br>";
    if ($kl == "") echo "Не вказане замовлення<br>";
}

//Zakrutie bazu       
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
