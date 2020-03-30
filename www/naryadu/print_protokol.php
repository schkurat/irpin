<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
$lg = $_SESSION['LG'];
$pas = $_SESSION['PAS'];

include "../function.php";
//$dt_pr=$_GET["dt_obr"];
//$dt_prb=date_bd($dt_pr);
$dt_start = date_bd($_GET["date_start"]);
$dt_end = date_bd($_GET["date_end"]);
$db = mysql_connect("localhost", $lg, $pas);
if (!$db) echo "Не вiдбулося зєднання з базою даних";

if (!@mysql_select_db(kpbti, $db)) {
    echo("Не завантажена таблиця");
    exit();
}
$p = '<table cellpadding="0" cellspacing="0" border="1">
<tr><th colspan="5">Протокол обробки інформації з ' . german_date($dt_start) . ' по ' . german_date($dt_end) . '</th></tr>
<tr>
<th>Замовлення</th>
<th>ПІБ (Назва)</th>
<th>Адреса</th>
<th>Дата</th>
<th>Сума</th>
</tr>';


$sum = 0;
/* $sql="SELECT s_obr.* FROM s_obr 
WHERE s_obr.DL='1' AND d_obr='$dt_prb'";
	$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu)){
		$n_file=$aut["N_FILE"];
		$t_obr=$aut["T_OBR"];
		$sm=$aut["SM"];
	$p.='<!--<tr><th colspan="2" align="left">'.$n_file.'</th></tr>-->
	<tr><td> </td><td>'.$sm.'</td></tr>';
	$sum=$sum+$sm;	
	}
	mysql_free_result($atu);	 */
$sql = "SELECT kasa.*,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB, 
		zamovlennya.BUD,zamovlennya.KVAR,zamovlennya.RN FROM kasa,zamovlennya,rayonu,nas_punktu,tup_nsp,vulutsi,tup_vul 
WHERE kasa.DL='1' AND zamovlennya.DL='1' 
		AND kasa.SZ=zamovlennya.SZ AND kasa.NZ=zamovlennya.NZ AND kasa.DT>='$dt_start' AND kasa.DT<='$dt_end' 
		AND rayonu.ID_RAYONA=zamovlennya.RN
		AND nas_punktu.ID_NSP=zamovlennya.NS 
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $zakaz = get_num_order($aut["RN"],$aut["SZ"],$aut["NZ"]);
    $obj_ner = objekt_ner(0, $aut["BUD"], $aut["KVAR"]);
    $adres = $aut["RAYON"] . ' ' . $aut["TIP_NSP"] . ' ' . $aut["NSP"] . ' ' . $aut["TIP_VUL"] . ' ' . $aut["VUL"] . ' ' . $obj_ner;
    $pib = $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"];
    $dt_k = german_date($aut["DT"]);
    $summa = $aut["SM"] + $aut["SM_KM"];
    $p .= '<tr><td>' . $zakaz . '</td><td>' . $pib . '</td><td>' . $adres . '</td><td>' . $dt_k . '</td><td align="right">' . number_format($summa,2) . '</td></tr>';
    $sum = $sum + ($aut["SM"] + $aut["SM_KM"]);
}
mysql_free_result($atu);

$p .= '<tr>
		<th align="left">Всього</th><th align="right" colspan="5">' . number_format($sum, 2) . '</th>
		</tr>';
$p .= '</table>';
//Zakrutie bazu       
if (mysql_close($db)) {
// echo("Закриття бази даних");
} else {
    echo("Не можливо виконати закриття бази");
}

echo $p;

?>