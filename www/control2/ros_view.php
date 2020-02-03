<?php
include_once "../function.php";

$i=0;
$p='<form action="add_vuk.php" name="myform" method="post">
<table align="center" class="zmview">
<tr>
<th>Замовлення</th>
<th>Адреса</th>
<th>Вид робіт</th>
<th>ПІБ (назва)</th>
<th>Дзвінок</th>
<th>Виконавець</th>
<th>Дата виходу</th>
<th>Скл.</th>
</tr>';

$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,zamovlennya.VUD_ROB,
		zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.KEY,rayonu.RAYON,nas_punktu.NSP,
		vulutsi.VUL,tup_nsp.TIP_NSP,tup_vul.TIP_VUL,zamovlennya.BUD,zamovlennya.KVAR,
		dlya_oformlennya.document,zamovlennya.D_PR,zamovlennya.DATA_VUH,zamovlennya.DATA_GOT,
		zamovlennya.DATA_VUH,zamovlennya.PR_OS,zamovlennya.VUK,zamovlennya.TEL
		FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
		WHERE
			zamovlennya.DL='1' AND  zamovlennya.VUK='' AND  zamovlennya.VD='0'  
			AND rayonu.ID_RAYONA=zamovlennya.RN
			AND nas_punktu.ID_NSP=zamovlennya.NS
			AND vulutsi.ID_VUL=zamovlennya.VL
			AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
			AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
			AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
			ORDER BY zamovlennya.KEY DESC"; 	
//echo $sql;			
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
  {	
 $i=1;	
 if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
 if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
 $zakaz=$aut["SZ"].'/'.$aut["NZ"];
 if($aut["VUD_ROB"]>19) {$brug=5; $zagl='disabled';}
 else {$brug=1; $zagl='';}
$p.='<tr>
	<td align="center">'.$zakaz.'</td>
	<td>'.$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$bud." ".$kvar.'</td>
    <td align="center">'.$aut["document"].'</td>
	<td align="center">'.$aut["PR"]." ".$aut["IM"]." ".$aut["PB"].'</td>
	<td align="center"><input name="zv'.$aut["KEY"].'" type="checkbox" value="f'.$aut["KEY"].'"></td>
	<td align="center">
	<select name="a'.$aut["KEY"].'">
	<option value=""></option>';
$sql1 = "SELECT ROBS,ID_ROB,BRUGADA FROM robitnuku WHERE BRUGADA='$brug' AND DL='1' ORDER BY ROBS";
$atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {$p.='<option value='.$aut1["ID_ROB"].'>'.$aut1["ROBS"].'</option>';}
mysql_free_result($atu1);
$p.='</select>
	</td>
	<td align="center"><input type="text" class="datepicker" name="b'.$aut["KEY"].'" value="'.german_date($aut["DATA_VUH"]).'" size="10" '.$zagl.'></td>
    <td align="center"><input name="c'.$aut["KEY"].'" type="checkbox" value="g'.$aut["KEY"].'" '.$zagl.'></td>	
	</tr>';
}
mysql_free_result($atu);
$p.='<tr><td colspan="8" align="center"><input type="submit" id="submit" value="Зберегти"></td></tr>';
$p.='</table></form>';
if($i==0) echo "Всі замовлення розподілені";
else
echo $p; 
?>