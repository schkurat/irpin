<?php
include_once "../function.php";

//$flag = "";
//$zm = $_GET['zam'];
//if (isset($_GET['szu'])) $szu = $_GET['szu']; else $szu = '';
//if (isset($_GET['zmu'])) $nzu = $_GET['zmu']; else $nzu = '';
//
//$ns = $_GET['nsp'];
//$vl = $_GET['vyl'];
//$bd = $_GET['bud'];
//$kv = $_GET['kvar'];
//$idn = $_GET['idn'];
////$kvut=$_GET['kvit'];
//$pr = $_GET['priz'];
//$vud_zam = $_GET['vud_zam'];
//$npr = date_bd($_GET['npr']);
//$kpr = date_bd($_GET['kpr']);
//
//$d1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
//$d2 = date("Y-m-d");
//
//if ($zm != "") {
//    $flag = "zamovlennya.NZ=" . $zm;
//}
//if ($ns != "" and $vl != "" and $bd != "" and $kv != "") {
//    $flag = "zamovlennya.NS=" . $ns . " AND zamovlennya.VL=" . $vl . "
//					AND zamovlennya.BUD=" . $bd . " AND zamovlennya.KVAR=" . $kv;
//}
//if ($vud_zam != "") {
//    if ($vud_zam != 3) $flag = "zamovlennya.TUP_ZAM='$vud_zam' AND taks.DATE_T>='$npr' AND taks.DATE_T<='$kpr' ";
//    else
//        $flag = "taks.DATE_T>='$npr' AND taks.DATE_T<='$kpr' ";
//}
//if ($flag == "") {
//    $flag = "taks.DATE_T>='" . $d1 . "'";
//}

$p = '<table align="center" class="zmview">
<tr>
<th colspan="3">#</th>
<th>С.з.</th>
<th>№.</th>
<th>Вид робіт</th>
<th>ПІБ</th>
<th>Адреса зам.</th>
<th>Сума такс.</th>
<th>Дата такс.</th>
<th>Виконавець</th>
</tr>';
$sql = "SELECT zamovlennya.EA,zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,
	zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.BUD,taks.ID_TAKS,zamovlennya.VUK,
	zamovlennya.KVAR,dlya_oformlennya.document,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,
	tup_vul.TIP_VUL,zamovlennya.DATA_GOT,zamovlennya.VD,zamovlennya.SKL    
	FROM zamovlennya,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul,dlya_oformlennya 
	WHERE 
		zamovlennya.PS=0 
		AND zamovlennya.VUD_ROB=dlya_oformlennya.id_oform
		AND rayonu.ID_RAYONA=zamovlennya.RN 
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		ORDER BY SZ, NZ DESC";

$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $zakaz = $aut["NZ"];

    $obj_ner = objekt_ner(0, $aut["BUD"], $aut["KVAR"]);

    if ($aut["VD"] == 1) {
//$vst1='-';
        $vst2 = '-';
        $vst3 = '-';
    } else {
        $vst2 = '<a href="delete_taks.php?idtaks=' . $aut["ID_TAKS"] . '"><img src="../images/b_drop.png"></a>';
        $vst3 = '<a href="taks.php?filter=edit_taks_info&idtaks=' . $aut["ID_TAKS"] . '&skl=' . $aut["SKL"] . '"><img src="../images/b_edit.png"></a>';
    }
    $p .= '<tr>
<!--<td align="center">' . $vst1 . '</td>-->
<td align="center">' . $vst3 . '</td>
<td align="center"><a href="taks_print.php?idtaks=' . $aut["ID_TAKS"] . '"><img src="../images/print.png"></a></td>
<td align="center">' . $vst2 . '</td>
	<td align="center">' . $aut["SZ"] . '</td>
      <td align="center">' . $zakaz . '</td>
      <td align="center">' . $aut["document"] . '</td>
      <td align="center">' . $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"] . '</td>
      <td align="center">' . $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $bud . " " . $kvar . '</td>
	  <td align="center">' . round((($aut["SUM"] + $aut["SUM_OKR"]) * (($aut["NDS"] / 100) + 1)), 2) . '</td>
	  <td align="center">' . german_date($aut["DATE_T"]) . '</td>
	  <td align="center">' . german_date($aut["DATA_GOT"]) . '</td>
      <td align="center">' . $aut["VUK"] . '</td>
	  <td align="center"><a href="taks_print_html.php?idtaks=' . $aut["ID_TAKS"] . '"><img src="../images/print.png"></a></td>
	</tr>';
}
mysql_free_result($atu);
$p .= '</table>';
echo $p;
?>