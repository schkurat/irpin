<?php
include_once "../function.php";

$kly = 0;
$p = '<table class="zmview">
<tr>
<!--<th>#</th>-->
<th>Замовлення</th>
<th>Замовник</th>
<th>Тип справи</th>
<th>Сертифікована особа</th>
<th>Прим.</th>
<th>Телефон<br>Email</th>
<th>Адреса зам.</th>
<th>Сума</th>
<th>Дата пр.</th>
</tr>';

/*$sql = "SELECT arhiv_zakaz.*,arhiv_jobs.name,rayonu.RAYON,rayonu.ID_RAYONA,nas_punktu.NSP, tup_nsp.TIP_NSP,
		    arhiv_jobs.id,vulutsi.VUL,tup_vul.TIP_VUL,arhiv_dop_adr.bud,arhiv_dop_adr.kvar 
		FROM arhiv_zakaz 
            LEFT JOIN arhiv_jobs ON arhiv_zakaz.VUD_ROB=arhiv_jobs.id 
            LEFT JOIN arhiv_dop_adr ON arhiv_zakaz.KEY=arhiv_dop_adr.id_zm 
            LEFT JOIN rayonu ON rayonu.ID_RAYONA=arhiv_dop_adr.rn 
            LEFT JOIN nas_punktu ON nas_punktu.ID_NSP=arhiv_dop_adr.ns 
            LEFT JOIN vulutsi ON vulutsi.ID_VUL=arhiv_dop_adr.vl
            LEFT JOIN tup_nsp ON tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
            LEFT JOIN tup_vul ON tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		WHERE 
		    TO_DAYS(NOW()) - TO_DAYS(D_PR) > 4 AND arhiv_zakaz.DL='1' AND arhiv_zakaz.VD='0'";*/
$sql  = "SELECT  arhiv_zakaz.*, arhiv_jobs.name, arhiv_jobs.id
		FROM arhiv_zakaz, arhiv_jobs
		WHERE 
			arhiv_zakaz.VUD_ROB=arhiv_jobs.id 	
			AND arhiv_zakaz.DL = 1
			AND  TO_DAYS(NOW()) - TO_DAYS(D_PR) > 4 			";

//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $kly++;
    $d_pr = german_date($aut["D_PR"]);

//    $seriya = $aut["SZ"];
//    $zam = $aut["NZ"];

    //$obj_ner = objekt_ner(0, $aut["bud"], $aut["kvar"]);
    $rayon = 0;
	$sql_adr = 'SELECT arhiv_dop_adr.*, rayonu.RAYON,rayonu.ID_RAYONA,nas_punktu.NSP, tup_nsp.TIP_NSP,
		    vulutsi.VUL,tup_vul.TIP_VUL
		FROM   rayonu, nas_punktu,  tup_nsp, vulutsi, tup_vul, arhiv_dop_adr
		WHERE 	
			arhiv_dop_adr.DL = 1
			AND arhiv_dop_adr.id_zm = '.$aut["KEY"].'
			AND rayonu.ID_RAYONA=arhiv_dop_adr.rn
			AND nas_punktu.ID_NSP=arhiv_dop_adr.ns 
			AND vulutsi.ID_VUL=arhiv_dop_adr.vl
			AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
			AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
	';
	//echo $sql_adr;
	$atu2 = mysql_query($sql_adr);
	$adr = '';
	while ($aut2 = mysql_fetch_array($atu2)) {
        $rayon = $aut2["rn"];
		if ($aut2["VD"]==0)
		{
		$adr .= '<form action="vudacha.php" metod="GET" style="margin:3px 0;">
			<input id="kl" name="kl" type="hidden" value="'.$aut2["id"].'">
			<button type="submit" value="Отправить" style="border:none;  background-color: #fff;"><img src="../images/vid.png" width="10px"></button>
		'. $aut2["RAYON"] . ' ' . $aut2["TIP_NSP"] .' '. $aut2["NSP"] .' '. $aut2["TIP_VUL"] . $aut2["VUL"].' '.(!empty($aut2["bud"]) ? 'буд. '.$aut2["bud"] : '').' '.(!empty($aut2["kvar"]) ? 'кв. '.$aut2["kvar"] : '').'
		</form>';
		}else{
			$adr .= $aut2["RAYON"] . ' ' . $aut2["TIP_NSP"] .' '. $aut2["NSP"] .' '. $aut2["TIP_VUL"] . $aut2["VUL"].' '.(!empty($aut2["bud"]) ? 'буд. '.$aut2["bud"] : '').' '.(!empty($aut2["kvar"]) ? 'кв. '.$aut2["kvar"] : '');
		}
	}
    $order = get_num_order($rayon, $aut["SZ"], $aut["NZ"]);

    $p .= '<tr bgcolor="#FFFAF0">
        <!--<td align="center" id="zal"><a href="arhiv.php?filter=vudacha_info&kl=' . $aut["KEY"] . '">Видати</a></td>	-->
        <td align="center">' . $order . '</td>
        <td align="center">' . $aut["SUBJ"] . '</td>    
        <td align="center">' . $aut["name"] . '</td>
        <td align="center">' . $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"] . '</a></td>
        <td align="center">' . $aut["PRIM"] . '</td>
        <td align="center">' . $aut["TEL"] . '<br>' . $aut["EMAIL"] . '</td>
        <td align="center">	'.$adr.' </td>
        <td align="center">' . $aut["SUM"] . '</td>
        <td align="center">' . $d_pr . '</td>
    </tr>';
}
mysql_free_result($atu);
$p .= '</table>';
if ($kly > 0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>Замовленя на видачу</b></th></tr></table>';
