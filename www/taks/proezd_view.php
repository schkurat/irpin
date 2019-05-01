<script type="text/javascript">
$(document).ready(
  function()
  {
  	$(".zmview tr").mouseover(function() {
  		$(this).addClass("over");
  	});
  
  	$(".zmview tr").mouseout(function() {
  		$(this).removeClass("over");
  	});
	$(".zmview tr:even").addClass("alt");
  }
);
</script>
<?php
include_once "../function.php";

$vukon=$_GET['vukon'];
if(isset($_GET['bdate'])) $bdate=date_bd($_GET['bdate']); else $bdate='';
if(isset($_GET['edate'])) $edate=date_bd($_GET['edate']); else $edate='';

$p='<table align="center" class="zmview">
<tr><th colspan="7">'.$vukon.'</th></tr>
<tr>
<th><a href="proezd_print.php?bdate='.$bdate.'&edate='.$edate.'&vukon='.$vukon.'"><img src="../images/print.png"></a></th>
<th>Дата<br>прийому</th>
<th>Дата<br>виїзду</th>
<th>№<br>замовлення</th>
<th>Адреса</th>
<th>Витрачені<br>кошти</th>
<th>Примітка (посилання на<br>додатки - проїзні квитки)</th>
</tr>';
$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.KEY,
zamovlennya.TUP_ZAM,zamovlennya.BUD,zamovlennya.KVAR,nas_punktu.NSP,tup_nsp.TIP_NSP,
vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.D_PR,zamovlennya.DATA_VUH,zamovlennya.SM_PROEZD,PRIM_PROEZD 
FROM zamovlennya,nas_punktu,vulutsi,tup_nsp,tup_vul 
	WHERE 
		zamovlennya.DATA_VUH>='$bdate' AND zamovlennya.DATA_VUH<='$edate'
		AND zamovlennya.VUK='$vukon' AND zamovlennya.VUD_ROB!=9 
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
	ORDER BY SZ, NZ";

 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$zakaz=$aut["NZ"];

$p.='<tr>
<td align="center"><a href="taks.php?filter=edit_proezd_info&idzak='.$aut["KEY"].'&bdate='.$bdate.'&edate='.$edate.'&vukon='.$vukon.'"><img src="../images/b_edit.png"></a></td>
	<td align="center">'.german_date($aut["D_PR"]).'</td>
	<td align="center">'.german_date($aut["DATA_VUH"]).'</td>
	<td align="center">'.$aut["SZ"].'/'.$zakaz.'</td>
	<td>'.$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$bud." ".$kvar.'</td>
    <td align="center">'.$aut["SM_PROEZD"].'</td>
    <td align="center">'.$aut["PRIM_PROEZD"].'</td>
</tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>