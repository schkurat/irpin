<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "../function.php";
$priz = "";
$imya = "";
$pobat = "";
$dnar = "";

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";
if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

if (isset($_POST['kod'])) {
    $idn_kod = $_POST['kod'];
    if ($idn_kod != "") {
        $ath = mysql_query("SELECT * FROM idn WHERE IDN=$idn_kod;");
        if ($ath) {
            while ($aut = mysql_fetch_array($ath)) {
                $priz = $aut['PR'];
                $imya = $aut['IM'];
                $pobat = $aut['PB'];
                $dnar = german_date($aut['DATA_NAR']);
            }
            mysql_free_result($ath);
        }
    }
    if ($dnar == "") {
        $dd = substr($idn_kod, 0, 5);
        $dnar = date("d.m.Y", mktime(0, 0, 0, 12, 31 + $dd, 1899));
    }
}
echo $priz . ':' . $imya . ':' . $pobat . ':' . $dnar;

//echo 'Текст:вася:петя';
if (mysql_close($db)) {
} else {
    echo("Не можливо виконати закриття бази");
}