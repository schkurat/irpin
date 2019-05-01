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
<th>Тип суми</th>
</tr>';

$sql = "SELECT kasa.*,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.BUD,zamovlennya.KVAR,
			zamovlennya.SUM AS SM_A,zamovlennya.SUM_D AS SM_D,
			nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL 
		FROM kasa,zamovlennya,nas_punktu,vulutsi,tup_nsp,tup_vul 
		WHERE 
		zamovlennya.DL='1' AND kasa.DT='$dtkas' AND kasa.DL='1' 
		AND kasa.SZ=zamovlennya.SZ AND kasa.NZ=zamovlennya.NZ 
		AND nas_punktu.ID_NSP=NS AND vulutsi.ID_VUL=VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL";

$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$obj_ner=objekt_ner(0,$aut["BUD"],$aut["KVAR"]);
$adres=$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$obj_ner;
$tsum='';
if($aut["SM"]==$aut["SM_A"]) $tsum='аванс';
if($aut["SM"]==$aut["SM_D"]) $tsum='доплата';
$p.='<tr>    
<td align="center"><a href="naryadu.php?filter=edit_k&kl='.$aut["ID"].'&tsum='.$tsum.'"><img src="../images/b_edit.png" border="0"></a></td>	
	<td align="center">'.$aut["SZ"].'/'.$aut["NZ"].'</td>
      <td align="center">'.german_date($aut["DT"]).'</td>
      <td align="center">'.$aut["PR"].' '.$aut["IM"].' '.$aut["PB"].'</td>
	  <td align="center">'.$adres.'</td>
      <td align="center">'.$aut["SM"].'</td>
	  <td align="center">'.$tsum.'</td>
      </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>