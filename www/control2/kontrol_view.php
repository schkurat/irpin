<?php
include_once "../function.php";

$frn = get_filter_for_rn($drn,'zamovlennya','RN');

$kr_fl = '';
if (isset($_POST['flag'])) {
    $flg = $_POST['flag'];
    if ($flg == "zm") {
        $sz = $_POST['szam'];
        $nz = $_POST['nzam'];
        $kr_fl = "AND zamovlennya.SZ='$sz' AND zamovlennya.NZ='$nz'";
    }
    if ($flg == "kon") {
        $kontekst = $_POST['kn'];
        $kr_fl = "AND LOCATE('$kontekst',zamovlennya.PR)>0";
    }
    if ($flg == "adres") {
        $ns = $_POST['nsp'];
        $vl = $_POST['vyl'];
        if (isset($_POST['bud'])) $bd = $_POST['bud'];
        else $bd = "";
        if (isset($_POST['kvar'])) $kv = $_POST['kvar'];
        else $kv = "";
        $kr_fl = "AND zamovlennya.NS='$ns' AND zamovlennya.VL='$vl'";
        if ($bd != "") {
            $kr_fl .= " AND zamovlennya.BUD=" . $bd;
        }
        if ($kv != "") {
            $kr_fl .= " AND zamovlennya.KVAR=" . $kv;
        }
    }
}

$p = '<table align="center" class="zmview">
<tr>
<th>Замовлення</th>
<th>Адреса</th>
<th>Вид робіт</th>
<th>ПІБ (назва)</th>
<th>Дата прийому</th>
<th>Дата готовності</th>
<th>Виконавець</th>
<th>Приймальник</th>
<th>Телефон</th>
<th>Таксування</th>
<th>Підпис</th>
<th>Видача</th>
</tr>';

$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,zamovlennya.ZVON,rayonu.*,
		zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.KEY,nas_punktu.NSP,
		vulutsi.VUL,tup_nsp.TIP_NSP,tup_vul.TIP_VUL,zamovlennya.BUD,zamovlennya.KVAR,
		dlya_oformlennya.document,zamovlennya.D_PR,zamovlennya.DATA_VUH,zamovlennya.DATA_GOT,
		zamovlennya.PR_OS,zamovlennya.VUK,zamovlennya.TEL,zamovlennya.SKL,zamovlennya.PS,zamovlennya.VD   
		FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
		WHERE
		zamovlennya.DL='1' " . $kr_fl . " AND (" . $frn . ") 
		AND rayonu.ID_RAYONA=zamovlennya.RN 
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
		ORDER BY zamovlennya.KEY DESC";
//echo $sql;					
$i = 1;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    if ($aut["BUD"] != "") $bud = "буд." . $aut["BUD"]; else $bud = "";
    if ($aut["KVAR"] != "") $kvar = "кв." . $aut["KVAR"]; else $kvar = "";

    $key_zm = $aut['KEY'];
    $d_taks = "";
    $sql2 = "SELECT * FROM taks WHERE IDZM='$key_zm' AND DL='1'";
    $atu2 = mysql_query($sql2);
    while ($aut2 = mysql_fetch_array($atu2)) {
        $d_taks = german_date($aut2["DATE_T"]);
        $sm_taks = round((($aut2["SUM"] + $aut2["SUM_OKR"]) * (($aut2["NDS"] / 100) + 1)), 2);
    }
    mysql_free_result($atu2);

    if ($aut["ZVON"] == '1') $zv = 'телефонували';
    else $zv = '';

    $vst1 = 'id="zal"';
    $vst2 = '<a href="index.php?filter=zmina_vk&kl=' . $aut["KEY"] . '&vk=' . $aut["VUK"] . '&skl=' . $aut["SKL"] . '&zv=' . $aut["ZVON"] . '">';
    $vst3 = $zv . '</a>';

    if ($aut["VUK"] == "") $vukon_zm = "-";
    else $vukon_zm = $aut["VUK"];
    $zakaz = get_num_order($aut["ID_RAYONA"], $aut["SZ"], $aut["NZ"]);
    $autograph = ($aut["PS"] == '1')? 'так' : 'ні';
    $vudacha = ($aut["VD"] == '1')? 'так' : 'ні';

    $p .= '<tr>
	<td align="center">' . $zakaz . '</td>
	<td align="center">' . $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $bud . " " . $kvar . '</td>
    <td align="center">' . $aut["document"] . '</td>
	<td align="center">' . $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"] . '</td>
	<td align="center">' . german_date($aut["D_PR"]) . '</td>
	<td align="center">' . german_date($aut["DATA_GOT"]) . '</td>
	<td align="center" ' . $vst1 . '>' . $vst2 . ' ' . $vukon_zm . ' ' . $vst3 . '</td>
    <td align="center">' . $aut["PR_OS"] . '</td>
	<td align="center">' . $aut["TEL"] . '</td>
	<td align="center">' . $sm_taks . '</td>
	<td align="center">' . $autograph . '</td>
	<td align="center">' . $vudacha . '</td>
    </tr>';
}
mysql_free_result($atu);
$p .= '</table>';
echo $p;
?>