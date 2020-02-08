<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];
$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

include "../function.php";

$idtaks = $_GET['idtaks'];

$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.PR,zamovlennya.IM,rayonu.*,
	zamovlennya.PB,zamovlennya.BUD,zamovlennya.KVAR,nas_punktu.NSP,tup_nsp.TIP_NSP,
	vulutsi.VUL,tup_vul.TIP_VUL,taks.DATE_T,taks.SUM_OKR,taks.NDS,zamovlennya.PRIM   
	FROM zamovlennya,taks,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul
	WHERE 
	taks.ID_TAKS='$idtaks' AND taks.DL='1' AND zamovlennya.KEY=taks.IDZM
	AND rayonu.ID_RAYONA=zamovlennya.RN 
	AND nas_punktu.ID_NSP=zamovlennya.NS
	AND vulutsi.ID_VUL=zamovlennya.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";


$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    if ($aut["BUD"] != "") $bud = "буд." . $aut["BUD"]; else $bud = "";
    if ($aut["KVAR"] != "") $kvar = "кв." . $aut["KVAR"]; else $kvar = "";
    $sz = $aut["SZ"];
    $rahunok = get_num_order($aut["ID_RAYONA"], $sz, $aut["NZ"]);
    $pib = $aut["PR"] . ' ' . $aut["IM"] . ' ' . $aut["PB"];
    $adr = $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $bud . " " . $kvar;
    $dtak = german_date($aut["DATE_T"]);
    $sum_okr = $aut["SUM_OKR"];
    $nds = $aut["NDS"];
    $prim = $aut["PRIM"];
}
mysql_free_result($atu);

$p = '<table border="1" style="border-collapse: collapse;font-size:13px; border:1px solid lightgrey;">
<tr><td colspan="5" align="center">Рахунок по замовленню № ' . $rahunok . '</td></tr>
<tr><td colspan="5">Адреса: ' . $adr . '</td></tr>
<tr><td colspan="5">Замовник: ' . $pib . ' ' . $prim . '</td></tr>
<tr>
<td align="center">№</td>
<td align="center">Найменування робіт</td>
<td align="center">Кільк.</td>
<td align="center">Норма</br>часу в г.</td>
<td align="center">Сума</td>
</tr>';

$sql1 = "SELECT price.NOM,price.NAIM,price.VUD,taks_detal.NORM,taks_detal.KL,taks_detal.KF,taks_detal.KF_SKL,taks_detal.SUM,
	robitnuku.ROBS
	FROM price, taks_detal, robitnuku
	WHERE 
		taks_detal.ID_TAKS='$idtaks' AND taks_detal.DL='1' AND taks_detal.ID_PRICE=price.ID_PRICE
		AND taks_detal.ID_ROB=robitnuku.ID_ROB AND robitnuku.DL='1' ORDER BY robitnuku.ROBS,price.NOM";

$it = 0;
//$sum_temp="";
$ssum = "";
$sum_vuk = "";
$rob_temp = "";
$text_skl = '';
$text_skl2 = '';
$atu1 = mysql_query($sql1);
while ($aut1 = mysql_fetch_array($atu1)) {
    $nomer = $aut1["NOM"];
    $naim = $aut1["NAIM"];
    $vud = $aut1["VUD"];
    $norma = $aut1["NORM"];
    $kilk = $aut1["KL"];
    $skl = $aut1["KF_SKL"];
    $koef = $aut1["KF"];
    $sum1 = $aut1["SUM"];
    $robitnuk = $aut1["ROBS"];
    if ($skl == 1.25) {
        $naim .= '*';
        $text_skl = '*Під час викреслювання та копіювання поверхових планів з особливо складними зовнішніми окресленнями і архітектурним';
        $text_skl2 = 'оформленням до норм часу 2.20; 2.21; 2.24; 2.27, що належать до третьої категорії складності, застосовується коефіцієнт 1.25';
    }
    if ($skl == 1.75) {
        $naim .= '**';
        $text_skl = '**Під час складання поверхових планів з особливо складними зовнішніми окресленнями і архітектурним оформленням';
        $text_skl2 = 'до норм часу 2.18; 2.19; 2.22; 2.23, що належать до третьої категорії складності, застосовується коефіцієнт 1.75';
    }
    if ($skl == 0.9) {
        $naim .= '***';
        $text_skl = '***Під час складання поверхових планів адміністративних або інших будівель із середньою площею приміщень (кімнат)';
        $text_skl2 = 'більше 50 кв. м до норм часу 2.18-2.24 застосовується коефіцієнт 0.9';
    }

    if ($koef == 2) {
        $sum1 = round(($sum1 * 2), 2);
    }

    if (($rob_temp != $robitnuk) and ($rob_temp != "")) {
        $ssum = $ssum + $sum_vuk;
        $temp = number_format($sum_vuk, 2);

        $p .= '<tr><td colspan="4">Сума по виконавцю</td>
<td align="right">' . $temp . '</td>
</tr>';

        $sum_vuk = "";

    }
    if ($rob_temp != $robitnuk) {
        $p .= '<tr><td colspan="5"><b>' . $robitnuk . '</b></td></tr>';

        $rob_temp = $robitnuk;

    }
    $tet = number_format($sum1, 2);
    $p .= '<tr>
<td align="center">' . $nomer . '</td>
<td>' . $naim . '</td>
<td align="center">' . $kilk . '</td>
<td align="center">' . $norma . '</td>
<td align="center">' . $tet . '</td>
</tr>';

    $sum_vuk = $sum_vuk + $sum1;
}
mysql_free_result($atu1);

$temp2 = number_format($sum_vuk, 2);

$p .= '<tr><td colspan="4">Сума по виконавцю</td>
<td align="right">' . $temp2 . '</td>
</tr>';

$ssum = $ssum + $sum_vuk;

//----pdv i sum s pdv---------
$ssum = $ssum + $sum_okr;
$pdv = round(($ssum * ($nds / 100)), 2);
$sm_spdv = round(($ssum * (($nds / 100) + 1)), 2);
//---------------------------

if ($text_skl != '') {
    $p .= '<tr><td colspan="5">' . $text_skl . '</td></tr>
<tr><td colspan="5">' . $text_skl2 . '</td></tr>';

}
$okug = number_format($sum_okr, 3);
$razom = number_format($ssum, 2);
$nalog = number_format($pdv, 2);
$itogo = number_format($sm_spdv, 2);
$p .= '<tr>
<td colspan="2">Вартість 1 нормо-години: 132.00</br>
Округлення до гривні</br>
Разом по рахунку:</br>
ПДВ-20%</br>
<b>Всього</b></td>
<td colspan="3" align="right"></br>' . $okug . '</br>' . $razom . '</br>' . $nalog . '</br>' . $itogo . '</td>
</tr>
<tr><td colspan="2">Таксувальник</td><td colspan="3">' . $dtak . 'р.</td></tr>';

echo $p;
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
?>