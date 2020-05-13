<style type="text/css">
    td, th {
        border: 1px solid lightgrey;
        padding: 0px 5px;
    }
</style>
<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];


if (!empty($_POST['rayon'])) {
    $rayon = intval($_POST['rayon']);
    if ($rayon > 0) {
        $ray = " AND zamovlennya.RN = " . $rayon;
    } else {
        $ray = '';
    }
} else {
    $ray = '';
}

include "../function.php";

$bdat = date_bd($_POST['bdate']);
$edat = date_bd($_POST['edate']);

$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$p = '<table border="1" style="border-collapse: collapse;font-size:13px; border:1px solid lightgrey;">
<tr><th colspan="11" align="left">Загальний вал по бюро</th></tr>
<tr><th colspan="11" align="left">Період: з ' . german_date($bdat) . ' по ' . german_date($edat) . '</th></tr>
<tr>
<th align="center">Ном. зам.</th>
<th align="center">Т.з.</th>
<th align="center">Адреса</th>
<th align="center">ПІБ (назва) замовника</th>
<th align="center">Виконавець</th>
<th align="center">Дата підпису</th>
<th align="center">Дата оплати<br>аванса</th>
<th align="center">Сума<br>аванса</th>
<th align="center">Дата оплати<br>доплати</th>
<th align="center">Сума<br>доплати</th>
<th align="center">Сума<br>загальна</th>
</tr>';

$ssum = 0;

$sh = "";
$kk = 0;
$zag_sum = 0;
$sql1 = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,zamovlennya.PRIM,rayonu.*,
		zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.BUD,zamovlennya.KVAR,
		nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.SUM,
		zamovlennya.DATA_PS,zamovlennya.DOKVUT,zamovlennya.VUK,zamovlennya.VIDSOTOK,zamovlennya.KEY,
		zamovlennya.DODOP,zamovlennya.SUM_D FROM zamovlennya,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul
				WHERE 
					zamovlennya.D_PR>='$bdat' AND zamovlennya.D_PR<='$edat'
					" . $ray . "
					AND zamovlennya.DL='1' AND zamovlennya.VUD_ROB!=0 
					AND rayonu.ID_RAYONA=zamovlennya.RN 
					AND nas_punktu.ID_NSP=zamovlennya.NS
					AND vulutsi.ID_VUL=zamovlennya.VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY SZ,NZ";

$atu1 = mysql_query($sql1);
while ($aut1 = mysql_fetch_array($atu1)) {
    $kl_id = $aut1["KEY"];
    $sz = $aut1["SZ"];
    $nz = $aut1["NZ"];
    $pr = $aut1["PR"];
    $im = $aut1["IM"];
    $pb = $aut1["PB"];
//    $prim = $aut1["PRIM"];
    $vukon = $aut1["VUK"];
    $ns = $aut1["NSP"];
    $tns = $aut1["TIP_NSP"];
    $vl = $aut1["VUL"];
    $tvl = $aut1["TIP_VUL"];
    $bud = $aut1["BUD"];
    $kvar = $aut1["KVAR"];
    $sum = $aut1["SUM"];
    $sum_dopl = $aut1["SUM_D"];
    $data_ps = german_date($aut1["DATA_PS"]);
    $d_opl = german_date($aut1["DOKVUT"]);
    $d_dopl = german_date($aut1["DODOP"]);
    $vids = $aut1["VIDSOTOK"];
    $sumv = $sum * $vids / 100;

    if ($bud != "") $budd = "буд. " . $aut1["BUD"]; else $budd = "";
    if ($kvar != "") $kvarr = "кв. " . $aut1["KVAR"]; else $kvarr = "";
    $adres = $tns . ' ' . $ns . ' ' . $tvl . ' ' . $vl . ' ' . $budd . ' ' . $kvarr;

    $fio = $pr . ' ' . $im . ' ' . $pb;

    if ($aut1["TUP_ZAM"] == 1) {
        $tip_zak = 'ф';
    } else {
        $tip_zak = 'ю';
    }

    $zakaz = get_num_order($aut1["ID_RAYONA"], $sz, $nz);

    $zag_sum = $sumv + $sum_dopl;

    $p .= '<tr>
<td align="center">' . $zakaz . '</td>
<td align="center">' . $tip_zak . '</td>
<td>' . $adres . '</td>
<td>' . $fio . '</td>
<td>' . $vukon . '</td>
<td align="center">' . $data_ps . '</td>
<td align="center">' . $d_opl . '</td>
<td align="center">' . number_format($sumv,2) . '</td>
<td align="center">' . $d_dopl . '</td>
<td align="center">' . $sum_dopl . '</td>
<td align="center">' . number_format($zag_sum,2) . '</td>
</tr>';
    $ssum = $ssum + $zag_sum;

//-------------
    if ($vids != 100) {
        $sql = "SELECT VUKD,VIDS FROM dod_vuk WHERE dod_vuk.ID_ZAK=" . $kl_id;
//echo $sql;			
        $atu = mysql_query($sql);
        while ($aut = mysql_fetch_array($atu)) {
            $vukon = $aut["VUKD"];
            $vids = $aut["VIDS"];
            $sumv = $sum * $vids / 100;
            $p .= '<tr>
<td align="center">' . $zakaz . '</td>
<td align="center">' . $tip_zak . '</td>
<td>' . $adres . '</td>
<td>' . $fio . '</td>
<td>' . $vukon . '</td>
<td align="center">' . $data_ps . '</td>
<td align="center">' . $d_opl . '</td>
<td align="center">' . number_format($sumv,2) . '</td>
<td align="center">' . $d_dopl . '</td>
<td align="center">' . number_format($sum_dopl,2) . '</td>
</tr>';
            $ssum = $ssum + $sumv;
        }
        mysql_free_result($atu);
    }
//-------------
    $sh = $sh + 1;
    $data_ps = "-";
    $d_opl = "-";
}
mysql_free_result($atu1);
/* $rsum=$rsum+$rs_bti;
$ssum=$ssum+$ss_bti; */
$p .= '<tr>
<th colspan="10" align="right">Загальний вал бюро:</th>
<th>' . $ssum . '</th></tr>
<tr><th colspan="10" align="right">Загальна кількість:</th>
<th>' . $sh . '</th>
</tr>';

$p .= '</table>';
echo $p;
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
?>