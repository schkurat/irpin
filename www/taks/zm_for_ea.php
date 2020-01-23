<?php
include_once "../function.php";

$p = '<table align="center" class="zmview">
<tr>
<th colspan="3">Документи</th>
<th>Замовлення</th>
<th>Вид робіт</th>
<th>ПІБ</th>
<th>Адреса зам.</th>
<th>Виконавець</th>
</tr>';

$sql = "SELECT zamovlennya.EA,zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,
	zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.BUD,zamovlennya.VUK,
	zamovlennya.KVAR,dlya_oformlennya.document,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,
	tup_vul.TIP_VUL,zamovlennya.DATA_GOT,zamovlennya.VD,zamovlennya.SKL    
	FROM zamovlennya,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul,dlya_oformlennya 
	WHERE 
		zamovlennya.PS=0 AND zamovlennya.EA!=0 
		AND zamovlennya.VUD_ROB=dlya_oformlennya.id_oform
		AND rayonu.ID_RAYONA=zamovlennya.RN 
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		ORDER BY SZ, NZ DESC";

$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $order = $aut["SZ"] . '/' .$aut["NZ"];
    $obj_ner = objekt_ner(0, $aut["BUD"], $aut["KVAR"]);
    $address = $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $obj_ner;
    $adr_storage = urlencode(serialize($address));

    $p .= '<tr>
    <td align="center"><a class="text-link" href="taks.php?filter=storage&url=' . $aut["EA"] . '/document&parent_link=&adr=' . $adr_storage . '">Вхідні</a></td>
    <td align="center"><a class="text-link" href="taks.php?filter=storage&url=' . $aut["EA"] . '/technical&parent_link=&adr=' . $adr_storage . '">Техніка</a></td>
    <td align="center"><a class="text-link" href="taks.php?filter=storage&url=' . $aut["EA"] . '/inventory&parent_link=&adr=' . $adr_storage . '">Справа</a></td>
    <td align="center">' . $order . '</td>
    <td align="center">' . $aut["document"] . '</td>
    <td align="center">' . $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"] . '</td>
    <td align="center">' . $address . '</td>
    <td align="center">' . $aut["VUK"] . '</td>
	</tr>';
}

mysql_free_result($atu);
$p .= '</table>';
echo $p;
