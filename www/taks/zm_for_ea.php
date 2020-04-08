<?php
include_once "../function.php";

$user = $t_pr . ' ' . p_buk($t_im) . '.' . p_buk($t_pb) . '.';
$flag = ($user == 'Шкурат А.О.' || $user == 'Разно Ю.Ю.' || $user == 'Чернях Ю.С.' || $user == 'Голуб Г.О.') ? "" : "AND zamovlennya.VUK='$user'";


if (!empty($_GET['search'])) {
    $s = trim($_GET['search']);
    $nz = mb_substr($s, 8, 2);
    $sz = mb_substr($s, 2, 6);
    if (strlen($s) == 10) {
        $flag2 = " AND zamovlennya.SZ='$sz' AND zamovlennya.nz='$nz' ";
    } else {
        $flag2 = "";
        echo " Невірный номер замовлення";
    }
} else {
    $flag2 = "";
}


echo '
<div style="display: inline-block; padding: 5px;">
<form metod="GER" action="taks.php">
	<input type="text" name="search">
	<input type="hidden" name="filter" value="zm_for_ea">
	<button type="submit">Пошук</button>
</form>
</div>';
?>
    <div style="background-color: #ffd391; display: inline-block; padding: 5px;">На перевірці</div>
    <div style="background-color: #ff838e; display: inline-block; padding: 5px;">На доопрацюванні</div>
    <div style="background-color: #7afd84; display: inline-block; padding: 5px;">На друк</div>
<?php
$p = '<table align="center" class="zmview">
<tr>
<th colspan="3">Документи</th>
<th>Замовлення</th>
<th>Вид робіт</th>
<th>ПІБ</th>
<th>Адреса зам.</th>
<th>Виконавець</th>
</tr>';

$sql = "SELECT zamovlennya.EA,zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,rayonu.*,
	zamovlennya.STATUS,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.BUD,zamovlennya.VUK,
	zamovlennya.KVAR,zamovlennya.PS,dlya_oformlennya.document,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,
	tup_vul.TIP_VUL,zamovlennya.DATA_GOT,zamovlennya.VD,zamovlennya.SKL    
	FROM zamovlennya,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul,dlya_oformlennya 
	WHERE 
		zamovlennya.VD=0 AND zamovlennya.EA!=0 " . $flag . $flag2 . " AND zamovlennya.DL='1' 
		AND zamovlennya.VUD_ROB=dlya_oformlennya.id_oform
		AND rayonu.ID_RAYONA=zamovlennya.RN 
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		ORDER BY SZ, NZ DESC";

$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $order = get_num_order($aut["ID_RAYONA"], $aut["SZ"], $aut["NZ"]);
    $obj_ner = objekt_ner(0, $aut["BUD"], $aut["KVAR"]);
    $address = $aut["TIP_NSP"] . $aut["NSP"] . " " . $aut["TIP_VUL"] . $aut["VUL"] . " " . $obj_ner;
    $adr_storage = urlencode(serialize($address));
    if ($aut['STATUS'] == 1) {
        $status_css = 'style="background-color: #ffd391;"';
    } elseif ($aut['STATUS'] == 2) {
        $status_css = 'style="background-color: #ff838e;"';
    } elseif ($aut['PS'] == 1) {
        $status_css = 'style="background-color: #7afd84;"';
    } else {
        $status_css = '';
    }

    $p .= '<tr>
    <td ' . $status_css . ' align="center"><a class="text-link" href="taks.php?filter=storage&url=' . $aut["EA"] . '/document&parent_link=&adr=' . $adr_storage . '">Вхідні</a></td>
    <td ' . $status_css . ' align="center"><a class="text-link" href="taks.php?filter=storage&url=' . $aut["EA"] . '/technical&parent_link=&adr=' . $adr_storage . '">Техніка</a></td>
    <td ' . $status_css . ' align="center"><a class="text-link" href="taks.php?filter=storage&url=' . $aut["EA"] . '/inventory&parent_link=&adr=' . $adr_storage . '">Справа</a></td>
    <td ' . $status_css . ' align="center">' . $order . '</td>
    <td ' . $status_css . ' align="center">' . $aut["document"] . '</td>
    <td ' . $status_css . ' align="center">' . $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"] . '</td>
    <td ' . $status_css . ' align="center">' . $address . '</td>
    <td ' . $status_css . ' align="center">' . $aut["VUK"] . '</td>
	</tr>';
}

mysql_free_result($atu);
$p .= '</table>';
echo $p;
