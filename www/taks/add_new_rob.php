<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');

include "../function.php";
$id = "";
$nom = "";
$naim = "";
$od_vum = "";
$vum = "";
$vuk = "";
$kontr = "";
$vud = "";
$select_item = '';
$sl_construct = '';
$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";
if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

if (isset($_POST['nrob'])) {
    $nrob = $_POST['nrob'];
    if ($nrob != "") {
        $ath = mysql_query("SELECT * FROM price WHERE NOM='$nrob';");
        if ($ath) {
            while ($aut = mysql_fetch_array($ath)) {
                $id = $aut['ID_PRICE'];
                $nom = $aut['NOM'];
                $naim = $aut['NAIM'];
                $od_vum = $aut['ODV'];
                $vum = $aut['VUM'];
                $vuk = $aut['VUK'];
                $kontr = $aut['KONTR'];
                $vud = $aut['VUD'];
            }
            mysql_free_result($ath);
        }

        $sql = "SELECT ID_ROB,ROBS FROM robitnuku WHERE BRUGADA!=9 AND DL='1' ORDER BY ROBS";
        $atu = mysql_query($sql);
        while ($aut = mysql_fetch_array($atu)) {
            $sl_construct .= '<option value="' . $aut["ID_ROB"] . '">' . $aut["ROBS"] . '</option>';
        }
        mysql_free_result($atu);

    }
}
$n_sel = substr($_POST['nom'], 1) + 1;
$select_item = '<select name="s' . $n_sel . '"><option value=""></option>' . $sl_construct . '</select>';
echo $id . ':' . $nom . ':' . $naim . ':' . $od_vum . ':' . $vum . ':' . $vuk . ':' . $kontr . ':' . $vud . ':' . $n_sel . ':' . $select_item;

//echo 'Текст:вася:петя';
if (mysql_close($db)) {
} else {
    echo("Не можливо виконати закриття бази");
}
?>