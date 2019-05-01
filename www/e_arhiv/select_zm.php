<?php
include "../function.php";
$kl=$_GET['kl'];

$p='
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
<table class="zmview" align="center"><tr><th>Оберіть замовлення для перегляду</th></tr>';
if($kl=='vrob'){  
$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,zamovlennya.OBJ, 
				vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.KEY,zamovlennya.BUD,zamovlennya.KVAR 
			 FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					zamovlennya.DL='1' AND zamovlennya.PS='0'   
					AND rayonu.ID_RAYONA=zamovlennya.RN
					AND nas_punktu.ID_NSP=zamovlennya.NS
					AND vulutsi.ID_VUL=zamovlennya.VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY SZ, NZ DESC";

 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
$obj_ner=objekt_ner($aut["OBJ"],$aut["BUD"],$aut["KVAR"]);
$p.='<tr><td id="zal"><a href="earhiv.php?filter=teh_view&kl_zm='.$aut['KEY'].'&fl=id">'.
$aut['SZ'].'/'.$aut['NZ'].' '.$aut['RAYON'].' '.$aut['TIP_NSP'].$aut['NSP'].' '.
$aut['TIP_VUL'].$aut['VUL'].' '.$obj_ner.'</a></td></tr>';
}
mysql_free_result($atu); 
}
if($kl=='vsi'){  
$sql = "SELECT tehnik.SZ,tehnik.NZ,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP, 
				vulutsi.VUL,tup_vul.TIP_VUL,tehnik.ID_ZAK,tehnik.BD,tehnik.KV 
			 FROM tehnik, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					tehnik.DL='1'    
					AND rayonu.ID_RAYONA=tehnik.NR
					AND nas_punktu.ID_NSP=tehnik.NS
					AND vulutsi.ID_VUL=tehnik.VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY SZ, NZ DESC";

 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
$obj_ner=objekt_ner(0,$aut["BD"],$aut["KV"]);
$p.='<tr><td id="zal"><a href="earhiv.php?filter=teh_view&kl_zm='.$aut['ID_ZAK'].'&fl=id">'.
$aut['SZ'].'/'.$aut['NZ'].' '.$aut['RAYON'].' '.$aut['TIP_NSP'].$aut['NSP'].' '.
$aut['TIP_VUL'].$aut['VUL'].' '.$obj_ner.'</a></td></tr>';
}
mysql_free_result($atu); 
}
$p.='</table>';
echo $p;
?>