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
$flag="";
$rj_saech=$_GET['rj_saech'];
switch($rj_saech)
{
   case 'n_zm': 
		if(isset($_GET['n_zam'])) $zm=$_GET['n_zam'];
		$rezult=explode("/",$zm);
		if($rezult[1]!=''){
		$flag="zamovlennya.SZU=".$rezult[0]." AND zamovlennya.NZU=".$rezult[1];
		}
		else{
		$flag="zamovlennya.NZ=".$zm;}
   break;
   case 'kv':
		if(isset($_GET['kvut'])) $kvut=$_GET['kvut'];
		$flag="zamovlennya.KVUT=".$kvut;
   break;
   case 'adr':
		if(isset($_GET['rajon'])) $rj=$_GET['rajon'];
		if(isset($_GET['nsp'])) $ns=$_GET['nsp'];
		if(isset($_GET['vyl'])) $vl=$_GET['vyl'];
		if(isset($_GET['bud'])) $bd=$_GET['bud'];
		if(isset($_GET['kv'])) $kv=$_GET['kv'];
		$flag="zamovlennya.RN='".$rj."' AND zamovlennya.NS='".$ns."' AND zamovlennya.VL='".$vl."' 
					AND zamovlennya.BUD='".$bd."' AND zamovlennya.KVAR='".$kv."'";
   break;
   case 'sum': 
		if(isset($_GET['sm'])) $sm_p=$_GET['sm'];
		$flag="zamovlennya.SUM=".$sm_p;
   break;
   case 'vls':
		if(isset($_GET['vlasn'])) $pr=$_GET['vlasn'];
		$flag="LOCATE('$pr',zamovlennya.PR)!=0";
   break;
   default:		 
    break;
}
$pr='	<table border="1" class="zmview" align="center"><tr>
		<th colspan="2">#</th>
		<th>С.з.</th>
		<th>№ зм.</th>
		<th>Дата</th>
		<th>Сума</th>
		<th>Сума ком.</th>
		<th>Примітка</th>
		<th>Район</th>
		</tr>';
		
$sql="SELECT * FROM kasa_error 
	WHERE DL='1' ORDER BY kasa_error.ID LIMIT 1";
$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu))
	{
		$k_kl=$aut["KODP"];
		if($k_kl==1063) $rjn="не виявлений платіж";
		else{
			$sql1="SELECT NAS FROM spr_nr WHERE KODP='$k_kl'";
			$atu1=mysql_query($sql1);
			while($aut1=mysql_fetch_array($atu1))
			{
				$rjn=$aut1["NAS"];
			}
			mysql_free_result($atu1);
		}
		if($aut["SZU"]!=''){
		$zam=$aut["SZU"].'/'.$aut["NZU"];
		}
		else{
		$zam=$aut["NZ"];
		}
		
		$pr.='<tr>
		<td><a href="naryadu.php?filter=edit_error_str&id='.$aut["ID"].'&script=edit_error_info"><img src="/images/b_edit.png" border="0"></a></td>
		<td><a href="naryadu.php?filter=delete_error&id='.$aut["ID"].'&script=edit_error_info"><img src="/images/save.gif" border="0"></a></td>
		<td>'.$aut["SD"].'</td>
		<td>'.$zam.'</td>
		<td>'.german_date($aut["DT"]).'</td>
		<td>'.$aut["SM"].'</td>
		<td>'.$aut["SM_KM"].'</td>
		<td>'.$aut["PRIM"].'</td>
		<td>'.$rjn.'</td>
		</tr>';
	}
mysql_free_result($atu);
$pr.='</table><br>';
echo $pr;

$p='<table class="zmview">
<tr bgcolor="#B5B5B5">
<th>Район</th>
<th>С.з.</th>
<th>№.</th>
<th>Вид робіт</th>
<th>ПІБ</th>
<th>Адреса зам.</th>
<th>Сума<br>зам.</th>
<th>Сума<br>каси</th>
<th>Сума<br>ком.</th>
<th>Дата гот.</th>
</tr>';

$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.SZU,zamovlennya.NZU,zamovlennya.DOKVUT,
	zamovlennya.PR,zamovlennya.KODP,zamovlennya.IM,zamovlennya.PB,zamovlennya.BUD,zamovlennya.SUM,
	zamovlennya.RN,zamovlennya.NS,zamovlennya.DATA_GOT,zamovlennya.KVAR,zamovlennya.VL,
	dlya_oformlennya.document,rayonu.RAYON,nas_punktu.NSP,vulutsi.VUL,spr_nr.NAS,spr_nr.KOD_ZM 
FROM zamovlennya,rayonu,nas_punktu,vulutsi,dlya_oformlennya,tup_nsp,tup_vul,spr_nr 
			WHERE ".$flag."
			AND zamovlennya.DL='1' 
			AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
			AND rayonu.ID_RAYONA=zamovlennya.RN
			AND nas_punktu.ID_NSP=zamovlennya.NS 
			AND vulutsi.ID_VUL=zamovlennya.VL
			AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
			AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
			AND spr_nr.KODP=zamovlennya.KODP 
			ORDER BY DATA_GOT DESC";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
	$kodp=$aut["KODP"];
	$sd=$aut["SZ"];
	$nz=$aut["NZ"];
	$szu=$aut["SZU"];
	$nzu=$aut["NZU"];
	$nr=$aut["RN"];
	$ns=$aut["NS"];
	$vl=$aut["VL"];
	$bd=$aut["BUD"];
	$kv=$aut["KVAR"];
	$sm_k="";
	if($aut["KOD_ZM"]!=="") $kod_zk="-".$aut["KOD_ZM"];
	else $kod_zk="";
	if($szu!=''){
	$zakaz=$szu.'/'.$nzu;
	}
	else{
	$zakaz=$nz.$kod_zk;
	}

$sql2 = "SELECT SUM(kasa.SM) AS SM_K, SUM(kasa.SM_KM) AS SM_KOM FROM kasa WHERE kasa.DL='1'  
		AND kasa.SD='$sd' AND kasa.NZ='$nz' AND kasa.KODP='$kodp'";
 $atu2=mysql_query($sql2);
  while($aut2=mysql_fetch_array($atu2))
 {	
	$sm_k=$aut2["SM_K"];
	$sm_kom=$aut2["SM_KOM"];
	}
mysql_free_result($atu2);
	
$p.='<tr>
	<td align="center">'.$aut["NAS"].'</td>
	<td align="center">'.$aut["SZ"].'</td>
      <td align="center">'.$zakaz.'</td>
      <td align="center">'.$aut["document"].'</td>
      <td align="center">'.$aut["PR"]." ".$aut["IM"]." ".$aut["PB"].'</td>
      <td align="center">'.$aut["RAYON"]." ".$aut["TIP_NSP"].$aut["NSP"]." ".
	  $aut["TIP_VUL"].$aut["VUL"]." ".$bud." ".$kvar.'</td>
	  <td align="center">'.$aut["SUM"].'</td>
	  <td align="center">'.$sm_k.'</td>
	  <td align="center">'.$sm_kom.'</td>
	  <td align="center">'.german_date($aut["DATA_GOT"]).'</td>
      </tr>';

}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>