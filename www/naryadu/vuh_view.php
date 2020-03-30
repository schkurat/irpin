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

if(isset($_GET['bdate'])) $bdate=date_bd($_GET['bdate']); else $bdate='';
if(isset($_GET['edate'])) $edate=date_bd($_GET['edate']); else $edate='';
if(!empty($_POST['rayon'])){
	$rayon = intval($_POST['rayon']);
	//var_dump($_POST);
	if ($rayon > 0){
		 $ray = " AND zamovlennya.RN = ".$rayon;
	}else{
		$ray = '';
	}
}else{
	$ray = '';
}

$p='<table align="center" class="zmview">
<tr>
<th>Дата<br>прийому</th>
<th>Дата<br>виїзду</th>
<th>№<br>замовлення</th>
<th>Адреса</th>
<th>Виконавець</th>
</tr>';
$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.KEY,
zamovlennya.TUP_ZAM,zamovlennya.BUD,zamovlennya.KVAR,nas_punktu.NSP,tup_nsp.TIP_NSP,
vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.D_PR,zamovlennya.DATA_VUH,zamovlennya.SM_PROEZD,PRIM_PROEZD,
zamovlennya.VUK FROM zamovlennya,nas_punktu,vulutsi,tup_nsp,tup_vul 
	WHERE 
		zamovlennya.DATA_VUH>='$bdate' AND zamovlennya.DATA_VUH<='$edate'
		" . $ray . "
		AND zamovlennya.VUD_ROB!=9 
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
	ORDER BY VUK";

 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$zakaz=$aut["NZ"];

$p.='<tr>
	<td align="center">'.german_date($aut["D_PR"]).'</td>
	<td align="center">'.german_date($aut["DATA_VUH"]).'</td>
	<td>'.$aut["SZ"].'/'.$zakaz.'</td>
	<td>'.$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$bud." ".$kvar.'</td>
    <td>'.$aut["VUK"].'</td>
</tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>