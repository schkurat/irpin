<?php
include_once "../function.php"; 

$idzak=$_GET['idzak'];
$smt=$_GET['smt'];
$smk=$_GET['smk'];

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
<form action="save_sum.php" name="myform" method="get">
<table align="center" class="zmview">
<tr>
<th>С. ном.з.</th>
<th>Адреса</th>
<th>ПІБ (назва) замовника</th>
<th>ПІБ виконавця</th>
<th>Сума таксування</th>
<th>Договірна сума</th>
</tr>';

$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,
		zamovlennya.PS,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,nas_punktu.NSP,
		vulutsi.VUL,tup_nsp.TIP_NSP,tup_vul.TIP_VUL,zamovlennya.KEY,zamovlennya.BUD,zamovlennya.KVAR,
		zamovlennya.D_PR,zamovlennya.VUK,zamovlennya.DATA_GOT,zamovlennya.SUM,zamovlennya.SUM_KOR  
				FROM zamovlennya, nas_punktu, vulutsi, tup_nsp, tup_vul 
				WHERE
					zamovlennya.DL='1' AND zamovlennya.KEY='$idzak' 
					AND nas_punktu.ID_NSP=zamovlennya.NS
					AND vulutsi.ID_VUL=zamovlennya.VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY SZ, NZ DESC"; 
			
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
  {	
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";

$zakaz=$aut['SZ'].'/'.$aut['NZ'];
		
$p.='<tr bgcolor="#FFFAF0">
      <td align="center">'.$zakaz.'
	  <input type="hidden" name="idzak" size="9" value="'.$idzak.'"/>
	  </td>
	  <td>'.$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$bud." ".$kvar.'</td>
	  <td>'.$aut["PR"]." ".$aut["IM"]." ".$aut["PB"].'</td>
      <td>'.$aut["VUK"].'</td>
	  <td><input name="smt" type="text" size="8" value="'.$smt.'" readonly/>грн.</td>
	  <td><input name="smk" type="text" size="8" value="'.$smk.'"/>грн.</td>
      </tr>';
}
mysql_free_result($atu);

$p.='<tr><td colspan="8" align="center"><input name="ok" type="submit" value="Зберегти" /></td></tr>
		</table></form>';
echo $p;
?>