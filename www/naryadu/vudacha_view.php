<?php
include_once "../function.php";

/* $sz=$_POST['szam'];
$nz=$_POST['nzam']; */

/* $rj=$_GET['rajon'];
$ns=$_GET['nsp'];
$vl=$_GET['vyl'];
$bd=$_GET['bud'];
$kv=$_GET['kvar'];
$idn=$_GET['idn'];
$kvut=$_GET['kvit'];
$pr=$_GET['priz']; */

/* if($zm!=""){ $flag="zamovlennya.NZ=".$zm;}
if($rj!="" and $ns!="" and $vl!="" and $bd!="" and $kv!=""){
					$flag="zamovlennya.RN=".$rj." AND zamovlennya.NS=".$ns." AND zamovlennya.VL=".$vl." 
					AND zamovlennya.BUD=".$bd." AND zamovlennya.KVAR=".$kv;}
if($flag==""){$flag="zamovlennya.D_PR>=".$d1;} */

$p='<table align="center" class="zmview">
<tr bgcolor="#B5B5B5">
<th colspan="3">#</th>
<th>С.з.</th>
<th>№.</th>
<th>№ кв.</th>
<th>Дата сп. кв.</th>
<th>Вид робіт</th>
<th>ІДН</th>
<th>ПІБ</th>
<th>Дата нар.</th>
<th>Адреса зам.</th>
<th>Доплата</th>
<th>Дата гот.</th>
</tr>';

$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.KVUT,zamovlennya.DOKVUT,zamovlennya.IDN,zamovlennya.PR,
							 zamovlennya.IM,zamovlennya.PB,zamovlennya.D_NAR,zamovlennya.BUD,zamovlennya.KVAR,zamovlennya.SUM,
							zamovlennya.DATA_GOT,dlya_oformlennya.document,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,
							 tup_vul.TIP_VUL
				FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
				WHERE
					zamovlennya.VUD_ROB=19 AND zamovlennya.DL='1' 
					AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
					AND rayonu.ID_RAYONA=zamovlennya.RN
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

if($aut["DOKVUT"]=="0000-00-00"){ $prop="dollar_s.png";}
		else{$prop="dollar_z.png";}

$p.='<tr bgcolor="#FFFAF0">
<td align="center"><a href="oplata.php?sz='.$aut["SZ"].'&nz='.$aut["NZ"].'&kv='.$aut["KVUT"].'"><img src="/images/'.$prop.'"></a></td>
<td align="center"><a href="kvut.php?sz='.$aut["SZ"].'&nz='.$aut["NZ"].'"><img src="/images/print.png"></a></td>
<td align="center"><a href="delete_doplata.php?sz='.$aut["SZ"].'&nz='.$aut["NZ"].'"><img src="/images/b_drop.png"></a></td>
	<td align="center">'.$aut["SZ"].'</td>
      <td align="center">'.$aut["NZ"].'</td>
	  <td align="center">'.$aut["KVUT"].'</td>
	  <td align="center">'.german_date($aut["DOKVUT"]).'</td>
      <td align="center">'.$aut["document"].'</td>
	  <td align="center">'.$aut["IDN"].'</td>
      <td align="center">'.$aut["PR"]." ".$aut["IM"]." ".$aut["PB"].'</td>
	  <td align="center">'.german_date($aut["D_NAR"]).'</td>
      <td align="center">'.$aut["RAYON"]." ".$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$bud." ".$kvar.'</td>
	  <td align="center">'.$aut["SUM"].'</td>
	  <td align="center">'.german_date($aut["DATA_GOT"]).'</td>
      </tr>';

}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>