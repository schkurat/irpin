<?php
include_once "../function.php";

$dtkas=date_bd($_GET['dt_obr']);
$p='<table class="zmview" align="center">
<tr>
<th>#</th>
<th>№</th>
<th>Дата</th>
<th>ПІБ</th>
<th>Адреса</th>
<th>Сума</th>
</tr>';

$sql = "SELECT arhiv_kasa.*,arhiv_zakaz.SUBJ,arhiv_zakaz.BUD,arhiv_zakaz.KVAR,
			arhiv_zakaz.SUM AS SM_A,
			nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL 
		FROM arhiv_kasa,arhiv_zakaz,nas_punktu,vulutsi,tup_nsp,tup_vul 
		WHERE 
		arhiv_zakaz.DL='1' AND arhiv_kasa.DT='$dtkas' AND arhiv_kasa.DL='1' 
		AND arhiv_kasa.SZ=arhiv_zakaz.SZ AND arhiv_kasa.NZ=arhiv_zakaz.NZ 
		AND nas_punktu.ID_NSP=arhiv_zakaz.NS AND vulutsi.ID_VUL=arhiv_zakaz.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";

$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$obj_ner=objekt_ner(0,$aut["BUD"],$aut["KVAR"]);
$adres=$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$obj_ner;
$tsum='';
//if($aut["SM"]==$aut["SM_A"]) $tsum='аванс';
//if($aut["SM"]==$aut["SM_D"]) $tsum='доплата';
$p.='<tr>    
<td align="center"><a href="arhiv.php?filter=edit_k&kl='.$aut["ID"].'"><img src="../images/b_edit.png" border="0"></a></td>	
	<td align="center">'.$aut["SZ"].'/'.$aut["NZ"].'</td>
      <td align="center">'.german_date($aut["DT"]).'</td>
      <td align="center">'.htmlspecialchars($aut["SUBJ"],ENT_QUOTES).'</td>
	  <td align="center">'.$adres.'</td>
      <td align="center">'.$aut["SM"].'</td>
      </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>