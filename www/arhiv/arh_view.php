<?php
include_once "../function.php";
$flag = "";

if (isset($_GET['srt'])) $sort = $_GET['srt'];
else $sort = "NUMB_OBL";

$rej = $_GET['rejum'];
if ($rej == "seach") {
    $rjs = $_GET['rj_saech'];
    switch ($rjs) {
        case "n_spr":
            $flag = "N_SPR=" . $_GET['n_spravu'];
            break;
        case "adr":
            if ($_GET['bud'] != "" AND $_GET['kv'] != "")
                $flag = "NS='" . $_GET['nsp'] . "' AND VL='" . $_GET['vyl'] . "' AND BD='" . $_GET['bud'] . "' AND KV='" . $_GET['kv'] . "'";
            else {
                if ($_GET['bud'] == "" AND $_GET['kv'] != "")
                    $flag = "NS='" . $_GET['nsp'] . "' AND VL='" . $_GET['vyl'] . "' AND KV='" . $_GET['kv'] . "'";
                else {
                    if ($_GET['bud'] == "" AND $_GET['kv'] == "")
                        $flag = "NS='" . $_GET['nsp'] . "' AND VL='" . $_GET['vyl'] . "'";
                    else
                        $flag = "NS='" . $_GET['nsp'] . "' AND VL='" . $_GET['vyl'] . "' AND BD='" . $_GET['bud'] . "'";
                }
            }
            break;
        case "prim":
            $flag = "LOCATE('" . $_GET['prum'] . "',PRIM)!=0";
            break;
        case "vlasn":
            $flag = "LOCATE('" . $_GET['vlasnuk'] . "',VLASN)!=0";
            break;
        case "kadn":
            $flag = "LOCATE('" . $_GET['kad_n'] . "',KAD_NOM)!=0";
            break;
        case "obln":
            $flag = "LOCATE('" . $_GET['obl_n'] . "',NUMB_OBL)!=0";
            break;
    }
}

$p = '<table align="center" 	class="zmview">
<tr bgcolor="#B5B5B5">
<th colspan="2">#</th>
<th id="zal"><a href="arhiv.php?filter=arh_view&rejum=view&srt=N_SPR">№ Справи</a></th>
<th>Прийняття на обл.</th>
<th>Адреса</th>
<th id="zal"><a href="arhiv.php?filter=arh_view&rejum=view&srt=PRIM">Примітка</a></th>
<th>Об`єкт</th>
<th>Площа</th>
<th>Інвентаризація</th>
</tr>';
if ($flag == "") {
    $sql = "SELECT arhiv.*,nas_punktu.NSP,
	tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL 
	FROM arhiv,nas_punktu,vulutsi,tup_nsp,tup_vul 
	WHERE 
	nas_punktu.ID_NSP=arhiv.NS
	AND vulutsi.ID_VUL=arhiv.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
	AND DL='1' ORDER BY " . $sort . " DESC LIMIT 30";
} else {
    $sql = "SELECT arhiv.*,nas_punktu.NSP,
	tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL 
	FROM arhiv,nas_punktu,vulutsi,tup_nsp,tup_vul 
	WHERE 
	nas_punktu.ID_NSP=arhiv.NS 
	AND vulutsi.ID_VUL=arhiv.VL 
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
	AND DL='1' AND " . $flag;
}

$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $obj_ner = objekt_ner(0, $aut["BD"], $aut["KV"]);
    $archive_number = (!empty($aut["N_SPR"]))? str_pad($aut["RN"],2,'0',STR_PAD_LEFT).$aut["N_SPR"]: '';
    $arhid = $aut["ID"];
    $potochka = '';
    $sql1 = "SELECT * FROM second_inv WHERE SPR='$arhid' ORDER BY DT_INV";
    $atu1 = mysql_query($sql1);
    while ($aut1 = mysql_fetch_array($atu1)) {
        $dt_pot = german_date($aut1["DT_INV"]);
        $vuk_pot = htmlspecialchars($aut1["ISP"], ENT_QUOTES);
        $potochka .= $dt_pot . '-' . $vuk_pot . '</br>';
    }
    mysql_free_result($atu1);

    $p .= '<tr bgcolor="#FFFAF0">
<td align="center"><a href="arhiv.php?filter=edit_zap_info&zap_id=' . $aut["ID"] . '"><img src="../images/b_edit.png" border="0"></a></td>
<td align="center"><a href="arhiv.php?filter=delete_zap&id_zp=' . $aut["ID"] . '"><img src="../images/b_drop.png" border="0"></a></td>
	<td align="center" id="zal"><a href="arhiv.php?filter=spr_view&inv_spr=' . $aut["N_SPR"] . '">' . $archive_number . '</a></td>
	<td>№' . $aut["NUMB_OBL"] . '</br>' . german_date($aut["DT_OBL"]) . '</td>
	<td>' . $aut["TIP_NSP"] . $aut["NSP"] . ' ' . $aut["TIP_VUL"] . $aut["VUL"] . ' ' . $obj_ner . '</td>
	<td align="center">' . $aut["PRIM"] . '</td>
	<td><b>Тип:</b>' . $aut["NAME"] . '
	</br><b>Власник:</b>' . $aut["VLASN"] . '
	</br><b>Складові частини:</b>' . $aut["SKL_CHAST"] . '
	</br><b>Кадастр. ном. з.д.:</b>' . $aut["KAD_NOM"] . '</td>
	<td>Землі:<span style="float: right;">' . $aut["PL_ZEM"] . '</span></br>Загальна:<span style="float: right;">' . $aut["PL_ZAG"] .
        '</span></br>Житлова:<span style="float: right;">' . $aut["PL_JIT"] . '</span></br>Допоміжна:' . $aut["PL_DOP"] . '</td>
	<td>' . german_date($aut["FIRST_DT_INV"]) . '-' . $aut["FIRST_VUK"] . '</br>' . $potochka . '</td>
    </tr>';
}
mysql_free_result($atu);
$p .= '</table>';
echo $p;
?>