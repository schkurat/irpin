<?php
include_once "../function.php";

$kly=0;
$p='<table class="zmview">
<tr>
<th>#</th>
<th>С.з.</th>
<th>№.</th>
<th>Замовник</th>
<th>Тип справи</th>
<th>Сертифікована особа</th>
<th>Прим.</th>
<th>Телефон<br>Email</th>
<th>Адреса зам.</th>
<th>Сума</th>
<th>Дата пр.</th>
</tr>';

$sql = "SELECT arhiv_zakaz.*,arhiv_jobs.name,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,
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
            ORDER BY arhiv_zakaz.KEY DESC";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$kly++;
$d_pr=german_date($aut["D_PR"]);

$seriya=$aut["SZ"];
$zam=$aut["NZ"];

$obj_ner=objekt_ner(0,$aut["BUD"],$aut["KVAR"]);
		
$p.='<tr bgcolor="#FFFAF0">
        <td align="center" id="zal"><a href="arhiv.php?filter=vozvrat_info&kl='.$aut["KEY"].'&inv='.$aut["ARH_NUMB"].'&ns='.$aut["NS"].'&vl='.$aut["VL"].'">Повернути</a></td>	
        <td align="center">'.$seriya.'</td>
        <td align="center">'.$zam.'</td>
        <td align="center">'.$aut["SUBJ"].'</td>    
        <td align="center">'.$aut["name"].'</td>
        <td align="center">'.$aut["PR"]." ".$aut["IM"]." ".$aut["PB"].'</a></td>
        <td align="center">'.$aut["PRIM"].'</td>
        <td align="center">'.$aut["TEL"].'<br>'.$aut["EMAIL"].'</td>
        <td align="center">'.$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$obj_ner.'</td>
        <td align="center">'.$aut["SUM"].'</td>
        <td align="center">'.$d_pr.'</td>
    </tr>';
}
mysql_free_result($atu);
$p.='</table>';
if($kly>0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>Замовленя на видачу</b></th></tr></table>';
?>