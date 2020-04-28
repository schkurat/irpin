<?php
session_start();
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include "../function.php";
?>
<style>
    .report{
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 0.75em;
    }
    .report th,.report td{
        border: 1px solid black;
        padding: 2px 3px;
    }
</style>
<?php

$bdat = date_bd($_POST['date1']);
$edat = date_bd($_POST['date2']);
$flg = $_POST['flag'];
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


$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}

$p = '<b>Період: з  ' . german_date($bdat) . ' по ' . german_date($edat) . '</b>
	<table class="report"><tr>
	<th align="center" rowspan="2">Замов лення</th>
	<th align="center" rowspan="2">Адреса</th>
	<th align="center" rowspan="2">Вид робіт</th>
	<th align="center" rowspan="2">ПІБ (назва)</th>
	<th align="center" rowspan="2">Дата прийому</th>
	<th align="center" rowspan="2">Таксування<br>без ПДВ</th>
	<th align="center" rowspan="2">Таксування<br>з ПДВ</th>
	<th align="center" colspan="2">Сплачено</th>
	<th align="center" rowspan="2">Виконавець</th>
	</tr>
	<tr><th>Сума</th><th>Дата</th></tr>
	';

if ($flg == "got") {
    $kr_fl = "AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat'";
}
if ($flg == "nevuk") {
    $kr_fl = "AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat' AND zamovlennya.PS='0' AND zamovlennya.VD='0'";
}
if ($flg == "nevuk_vuk") {
    $vukonavets = $_POST['isp'];
    $kr_fl = "AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat' AND zamovlennya.PS='0' AND zamovlennya.VD='0'
 AND zamovlennya.VUK='$vukonavets'";
}
if ($flg == "got_vuk") {
    $vukonavets = $_POST['isp'];
    $kr_fl = "AND zamovlennya.DATA_PS>='$bdat' AND zamovlennya.DATA_PS<='$edat' AND zamovlennya.PS='1' AND zamovlennya.VUK='$vukonavets'";
}
if ($flg == "pr_period") {
    $kr_fl = "AND zamovlennya.D_PR>='$bdat' AND zamovlennya.D_PR<='$edat'";
}
if ($flg == "vk_date_g") {
    $vukonavets = $_POST['isp'];
    $kr_fl = "AND zamovlennya.DATA_GOT>='$bdat' AND zamovlennya.DATA_GOT<='$edat' AND zamovlennya.VUK='$vukonavets'";
}

$s_sm_opl = 0;
$s_sm_taks = 0;
$s_taks_not_pdv = 0;
$sql1 = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.PR,zamovlennya.IM,zamovlennya.ZVON,zamovlennya.DOKVUT,zamovlennya.DODOP,
			zamovlennya.PB,zamovlennya.PS,nas_punktu.NSP,vulutsi.VUL,tup_nsp.TIP_NSP,rayonu.*,
			tup_vul.TIP_VUL,zamovlennya.KEY,zamovlennya.BUD,zamovlennya.KVAR,dlya_oformlennya.document,
			zamovlennya.D_PR,zamovlennya.EDRPOU,zamovlennya.IPN,zamovlennya.SVID,
			zamovlennya.DATA_GOT,zamovlennya.PR_OS,zamovlennya.VUK,zamovlennya.TEL,zamovlennya.TUP_ZAM 
		FROM zamovlennya,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul,dlya_oformlennya 
		WHERE
			zamovlennya.DL='1' 
			" . $kr_fl . "
			" . $ray . "			
			AND rayonu.ID_RAYONA=zamovlennya.RN 
			AND nas_punktu.ID_NSP=zamovlennya.NS
			AND vulutsi.ID_VUL=zamovlennya.VL
			AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
			AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
			AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
			ORDER BY SZ, NZ";

$atu1 = mysql_query($sql1);
$num_rows = mysql_num_rows($atu1);
while ($aut1 = mysql_fetch_array($atu1)) {
    if ($aut1["BUD"] != "") $bud = "буд. " . $aut1["BUD"]; else $bud = "";
    if ($aut1["KVAR"] != "") $kvar = "кв. " . $aut1["KVAR"]; else $kvar = "";

    $ser = $aut1['SZ'];
    $nom = $aut1['NZ'];
    $tup_zam = $aut1['TUP_ZAM'];
    $zakaz = get_num_order($aut1['ID_RAYONA'], $ser, $nom);

    $pr = $aut1["PR"];
    $im = $aut1["IM"];
    $pb = $aut1["PB"];
//	$edrpou=$aut1["EDRPOU"];
//	$ipn=$aut1["IPN"];
//	$svid=$aut1["SVID"];
    $ns = $aut1["NSP"];
    $tns = $aut1["TIP_NSP"];
    $vl = $aut1["VUL"];
    $tvl = $aut1["TIP_VUL"];
    $vud_rob = $aut1["document"];
    if ($aut1["ZVON"] == '1') $zv = 'так';
    else $zv = 'ні';

    $adres = $rn . ' ' . $tns . ' ' . $ns . ' ' . $tvl . ' ' . $vl . ' ' . $bud . ' ' . $kvar;
    $fio = $pr . ' ' . $im . ' ' . $pb;
    $tel = $aut1["TEL"];
    $vukon = $aut1["VUK"];
    if ($vukon == "") $vukon = "-";
    if ($tel == "") $tel = "-";
    if ($aut1["PS"] == '1') $pidpus = 'так';
    else $pidpus = 'ні';

    $sm_taks = 0;
    $taks_not_pdv = 0;
    $id_zm = $aut1["KEY"];
    $sql2 = "SELECT taks.* FROM taks WHERE IDZM='$id_zm' AND DL='1'";
    $atu2 = mysql_query($sql2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $sm_taks = (float)round((($aut2["SUM"] + $aut2["SUM_OKR"]) * (($aut2["NDS"] / 100) + 1)), 2);
        $taks_not_pdv = (float)round(($aut2["SUM"] + $aut2["SUM_OKR"]), 2);
        $s_sm_taks += $sm_taks;
        $s_taks_not_pdv += $taks_not_pdv;
    }
    mysql_free_result($atu2);

    $sm_opl = 0;
    $pay_insert_one = '';
    $pay_insert_more = '';
    $sql2 = "SELECT SM,DT FROM kasa WHERE SZ='$ser' AND NZ='$nom' AND DL='1'";
    $atu2 = mysql_query($sql2);
    $cunt_pay = mysql_num_rows($atu2);
    $i=0;
    while ($aut2 = mysql_fetch_array($atu2)) {
        $i++;
        $sm_opl = (float)round($aut2["SM"], 2);
        $s_sm_opl += $sm_opl;
        if($cunt_pay == 1){
            $pay_insert_one = '<td align="right">' . number_format($sm_opl,2) . '</td><td align="center">' . german_date($aut2["DT"]) . '</td>';
        }else{
            if($i == 1){
                $pay_insert_one = '<td align="right">' . number_format($sm_opl,2) . '</td><td align="center">' . german_date($aut2["DT"]) . '</td>';
            }else{
                $pay_insert_more .= '<tr><td align="right">' . number_format($sm_opl,2) . '</td><td align="center">' . german_date($aut2["DT"]) . '</td></tr>';
            }
        }
    }
    mysql_free_result($atu2);
    if($cunt_pay == 0){
        $pay_insert_one = '<td align="right">-</td><td align="center">-</td>';
        $cunt_pay = 1;
    }

    $p .= '<tr>
	<td align="center" rowspan="' . $cunt_pay . '">' . $zakaz . '</td>
	<td rowspan="' . $cunt_pay . '">' . $adres . '</td>
	<td align="center" rowspan="' . $cunt_pay . '">' . $vud_rob . '</td>
	<td align="center" rowspan="' . $cunt_pay . '">' . $fio . '</td>
	<td align="center" rowspan="' . $cunt_pay . '">' . german_date($aut1["D_PR"]) . '</td>
	<td align="right" rowspan="' . $cunt_pay . '">' . number_format($taks_not_pdv,2) . '</td>
	<td align="right" rowspan="' . $cunt_pay . '">' . number_format($sm_taks,2) . '</td>
	'. $pay_insert_one .'
	<td align="center" rowspan="' . $cunt_pay . '">' . $vukon . '</td>
	</tr>'.$pay_insert_more;
}
mysql_free_result($atu1);
$p .= '<tr>
    <th colspan="5" align="left">Всього:</th>
    <th>' . number_format($s_taks_not_pdv,2) . '</th>
    <th>' . number_format($s_sm_taks,2) . '</th>
    <th>' . number_format($s_sm_opl,2) . '</th>
    <th colspan="2"></th>
    </tr></table>';

echo $p;
echo '<br>Всього замовлень: ' . $num_rows;
if (mysql_close($db)) {
    // echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}
