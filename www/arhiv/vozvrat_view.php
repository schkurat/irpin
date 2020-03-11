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

/*$sql = "SELECT arhiv_zakaz.*,arhiv_jobs.name,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,
                    vulutsi.VUL,tup_vul.TIP_VUL
            FROM arhiv_zakaz, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, arhiv_jobs
            WHERE 
            arhiv_zakaz.DATA_POVER='0000-00-00'
            AND arhiv_zakaz.DL='1' AND arhiv_zakaz.VD='1' 
            AND arhiv_jobs.id=VUD_ROB
            AND rayonu.ID_RAYONA=RN
            AND nas_punktu.ID_NSP=NS
            AND vulutsi.ID_VUL=VL
            AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
            AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
            ORDER BY arhiv_zakaz.KEY DESC";*/

$sql = "SELECT  arhiv_zakaz.*, arhiv_jobs.name, arhiv_jobs.id
		FROM arhiv_zakaz, arhiv_jobs
		WHERE 
			arhiv_zakaz.VUD_ROB=arhiv_jobs.id 	
			AND arhiv_zakaz.DL = 1";
//echo $sql;
$atu = mysql_query($sql);
while ($aut = mysql_fetch_array($atu)) {
    $kly++;
    $pt = False;
    $rayon = 0;
    $sql_adr = 'SELECT arhiv_dop_adr.*, rayonu.RAYON,rayonu.ID_RAYONA,nas_punktu.NSP, tup_nsp.TIP_NSP,
		    vulutsi.VUL,tup_vul.TIP_VUL
		FROM   rayonu, nas_punktu,  tup_nsp, vulutsi, tup_vul, arhiv_dop_adr
		WHERE 	
			arhiv_dop_adr.DL = 1
			AND arhiv_dop_adr.id_zm = ' . $aut["KEY"] . '
			AND rayonu.ID_RAYONA=arhiv_dop_adr.rn
			AND nas_punktu.ID_NSP=arhiv_dop_adr.ns 
			AND vulutsi.ID_VUL=arhiv_dop_adr.vl
			AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
			AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL';

    $atu2 = mysql_query($sql_adr);
    $adr = '';
    while ($aut2 = mysql_fetch_array($atu2)) {
        $rayon = $aut2["rn"];
        if ($aut2["VD"] == 1 && $aut2["PV"] == 0) {
            $pt = True;
            echo "!";
            $adr .= '<form action="vozvrat.php" metod="GET" style="margin:3px 0;">
			<input id="kl" name="kl" type="hidden" value="' . $aut2["id"] . '">
			<button type="submit" value="Отправить" style="border:none;  background-color: #fff;"><img src="../images/prij.png" width="10px"></button>
		' . $aut2["RAYON"] . ' ' . $aut2["TIP_NSP"] . ' ' . $aut2["NSP"] . ' ' . $aut2["TIP_VUL"] . $aut2["VUL"] . ' ' . (!empty($aut2["bud"]) ? 'буд. ' . $aut2["bud"] : '') . ' ' . (!empty($aut2["kvar"]) ? 'кв. ' . $aut2["kvar"] : '') . '
		</form>';
        }
    }
    $order = get_num_order($rayon, $aut["SZ"], $aut["NZ"]);


    $d_pr = german_date($aut["D_PR"]);

    $seriya = $aut["SZ"];
    $zam = $aut["NZ"];

    $obj_ner = objekt_ner(0, $aut["BUD"], $aut["KVAR"]);

    $temp .= '<tr bgcolor="#FFFAF0">
        <!--<td align="center" id="zal"><a href="arhiv.php?filter=vozvrat_info&kl=' . $aut["KEY"] . '&inv=' . $aut["ARH_NUMB"] . '&ns=' . $aut["NS"] . '&vl=' . $aut["VL"] . '">Повернути</a></td>	-->
        <td align="center">' . $order . '</td>
        <td align="center">' . $aut["SUBJ"] . '</td>    
        <td align="center">' . $aut["name"] . '</td>
        <td align="center">' . $aut["PR"] . " " . $aut["IM"] . " " . $aut["PB"] . '</a></td>
        <td align="center">' . $aut["PRIM"] . '</td>
        <td align="center">' . $aut["TEL"] . '<br>' . $aut["EMAIL"] . '</td>
        <td align="center">' . $adr . '</td>
        <td align="center">' . $aut["SUM"] . '</td>
        <td align="center">' . $d_pr . '</td>
    </tr>';
    if ($pt) $p .= $temp;
}
mysql_free_result($atu);
$p .= '</table>';
if ($kly > 0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>Замовленя на видачу</b></th></tr></table>';
