<?php
include_once "../function.php";
?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tax').on('click', '.add_storage', addToStorage);
        });
    </script>
<?php
$flag = "";
$zm = $_GET['zam'];
if (isset($_GET['szu'])) $szu = $_GET['szu']; else $szu = '';
if (isset($_GET['zmu'])) $nzu = $_GET['zmu']; else $nzu = '';

$ns = $_GET['nsp'];
$vl = $_GET['vyl'];
$bd = $_GET['bud'];
$kv = $_GET['kvar'];
$idn = $_GET['idn'];
$pr = $_GET['priz'];
$vud_zam = $_GET['vud_zam'];
$npr = date_bd($_GET['npr']);
$kpr = date_bd($_GET['kpr']);

$d1 = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$d2 = date("Y-m-d");

if ($zm != "") {
    $flag = "zamovlennya.NZ=" . $zm;
}
//if($szu!=""){ $flag="zamovlennya.SZU=".$szu." AND zamovlennya.NZU=".$nzu;}
if ($ns != "" and $vl != "" and $bd != "" and $kv != "") {
    $flag = "zamovlennya.NS=" . $ns . " AND zamovlennya.VL=" . $vl . " 
					AND zamovlennya.BUD=" . $bd . " AND zamovlennya.KVAR=" . $kv;
}
if ($vud_zam != "") {
    if ($vud_zam != 3) $flag = "zamovlennya.TUP_ZAM='$vud_zam' AND taks.DATE_T>='$npr' AND taks.DATE_T<='$kpr' ";
    else
        $flag = "taks.DATE_T>='$npr' AND taks.DATE_T<='$kpr' ";
}
if ($flag == "") {
    $flag = "taks.DATE_T>='" . $d1 . "'";
}

$user = $t_pr . ' ' . p_buk($t_im) . '.' . p_buk($t_pb) . '.';
$flag2 = ($user == 'Шкурат А.О.' || $user == 'Разно Ю.Ю.' || $user == 'Чернях Ю.С.' || $user == 'Голуб Г.О.')? "": "AND zamovlennya.VUK='$user'";

$p = '<table id="tax" align="center" class="zmview">
<tr>
<th colspan="4">#</th>
<th>Замовлення</th>
<th>Вид робіт</th>
<th>ПІБ</th>
<th>Адреса зам.</th>
<th>Сума такс.</th>
<th>Дата такс.</th>
<th>Дата гот.</th>
<th>Виконавець</th>
<th>#</th>
</tr>';
$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,rayonu.*,
	zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.BUD,taks.ID_TAKS,zamovlennya.VUK,
	zamovlennya.KVAR,dlya_oformlennya.document,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,
	tup_vul.TIP_VUL,taks.DATE_T,taks.SUM,taks.SUM_OKR,taks.NDS,zamovlennya.DATA_GOT,zamovlennya.VD,zamovlennya.SKL    
	FROM zamovlennya,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul,dlya_oformlennya,taks 
	WHERE 
		" . $flag . $flag2 . "
		AND taks.DL='1' AND zamovlennya.KEY=taks.IDZM  
		AND zamovlennya.VUD_ROB=dlya_oformlennya.id_oform
		AND rayonu.ID_RAYONA=zamovlennya.RN AND taks.KODP=zamovlennya.KODP
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		ORDER BY SZ, NZ DESC";

$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    if ($aut["BUD"] != "") $bud = "буд." . $aut["BUD"]; else $bud = "";
    if ($aut["KVAR"] != "") $kvar = "кв." . $aut["KVAR"]; else $kvar = "";
    $zakaz = get_num_order($aut["ID_RAYONA"], $aut["SZ"], $aut["NZ"]);

    if ($aut["VD"] == 1) {
        $vst1 = '-';
        $vst2 = '-';
        $vst3 = '-';
    } else {
        $vst1 = '<img class="add_storage" src="../images/database.png" data-tax-id="' . $aut["ID_TAKS"] . '">';
        $vst2 = '<a href="delete_taks.php?idtaks=' . $aut["ID_TAKS"] . '"><img src="../images/b_drop.png"></a>';
        $vst3 = '<a href="taks.php?filter=edit_taks_info&idtaks=' . $aut["ID_TAKS"] . '&skl=' . $aut["SKL"] . '"><img src="../images/b_edit.png"></a>';
    }
    $p .= '<tr>
<td align="center">' . $vst1 . '</td>
<td align="center">' . $vst3 . '</td>
<td align="center"><a href="taks_print.php?idtaks=' . $aut["ID_TAKS"] . '&storage=0"><img src="../images/print.png"></a></td>
<td align="center">' . $vst2 . '</td>
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