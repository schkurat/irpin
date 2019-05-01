<?php
include "function.php";

$zm=$_GET['zam'];
$rj=$_GET['rajon'];
$ns=$_GET['nsp'];
$vl=$_GET['vyl'];
$bd=$_GET['bud'];
$kv=$_GET['kvar'];
$idn=$_GET['idn'];
$kvut=$_GET['kvit'];
$pr=$_GET['priz'];
$zzz="zamovlennya.IDN=".$idn;

if($zm!=""){
				$sql = "SELECT *,rayonu.RAYON,nas_punktu.NSP, tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL
				FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					zamovlennya.NZ='$zm'
					AND rayonu.ID_RAYONA=RN
					AND nas_punktu.ID_NSP=NS
					AND vulutsi.ID_VUL=VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY D_PR DESC";
				}
if($rj!="" and $ns!="" and $vl!="" and $bd!="" and $kv!=""){
				$sql = "SELECT *,rayonu.RAYON,nas_punktu.NSP, tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL
				FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					zamovlennya.RN='$rj' AND zamovlennya.NS='$ns' AND zamovlennya.VL='$vl' 
					AND zamovlennya.BUD='$bd' AND zamovlennya.KVAR='$kv'
					AND rayonu.ID_RAYONA=RN
					AND nas_punktu.ID_NSP=NS
					AND vulutsi.ID_VUL=VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY D_PR DESC";
				}
if($idn!=""){
				$sql = "SELECT *,rayonu.RAYON,nas_punktu.NSP, tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL
				FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					".$zzz."
					AND rayonu.ID_RAYONA=RN
					AND nas_punktu.ID_NSP=NS
					AND vulutsi.ID_VUL=VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY D_PR DESC";
				}
if($pr!=""){
				$sql = "SELECT *,rayonu.RAYON,nas_punktu.NSP, tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL
				FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				WHERE 
					zamovlennya.PR='$pr'
					AND rayonu.ID_RAYONA=RN
					AND nas_punktu.ID_NSP=NS
					AND vulutsi.ID_VUL=VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY D_PR DESC";
				}


				
				
$p='<table class="zmview">
<tr bgcolor="#B5B5B5">
<th colspan="3">#</th>
<th>С.з.</th>
<th>№.</th>
<th>№ кв.</th>
<th>Тип</th>
<th>Вид робіт</th>
<th>ІДН</th>
<th>ПІБ</th>
<th>Дата нар.</th>
<th>Телефон</th>
<th>Адреса зам.</th>
<th>Сума</th>
<th>Дата вих.</th>
<th>Дата гот.</th>
<th>Пр. докум.</th>
</tr>';

//$d1=date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y")));
//$d2=date("Y-m-d");

// $sql = "SELECT *,rayonu.RAYON,nas_punktu.NSP, tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL
			 // FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul
				// WHERE 
					// zamovlennya.D_PR>='$d1' AND zamovlennya.D_PR<='$d2'
					// AND rayonu.ID_RAYONA=RN
					// AND nas_punktu.ID_NSP=NS
					// AND vulutsi.ID_VUL=VL
					// AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					// AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					// ORDER BY D_PR DESC";
					
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	

if($aut["TUP_ZAM"]==1) $tz="з"; else $tz="т";
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
$nn=substr_count($aut["PRDOC"],":");
$ndoc=explode(":",$aut["PRDOC"]);
$tt="";
//echo $nn;
for($i=0; $i<=$nn; $i++){

$sql1 = "SELECT PRDOC FROM pravo_doc WHERE ID_PRDOC='$ndoc[$i]'";
$atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {	$tt.=$aut1["PRDOC"]."<br>";}
mysql_free_result($atu1);
} 

$p.='<tr bgcolor="#FFFAF0">
<td align="center"><img src="images/b_edit.png"></td>
<td align="center"><img src="images/b_drop.png"></td>
<td align="center"></td>     
	  <td align="center">'.$aut["SZ"].'</td>
      <td align="center">'.$aut["NZ"].'</td>
      <td align="center">'.$aut["KVUT"].'</td>
      <td align="center">'.$tz.'</td>
      <td align="center">'.$aut["VUD_ROB"].'</td>
      <td align="center">'.$aut["IDN"].'</td>
      <td align="center">'.$aut["PR"]." ".$aut["IM"]." ".$aut["PB"].'</td>
      <td align="center">'.german_date($aut["D_NAR"]).'</td>
	  <td align="center">'.$aut["TEL"].'</td>
      <td align="center">'.$aut["RAYON"]." ".$aut["TIP_NSP"].$aut["NSP"]." ".
										$aut["TIP_VUL"].$aut["VUL"]." ".$bud." ".$kvar.'</td>
	  <td align="center">'.$aut["SUM"].'</td>
	  <td align="center">'.german_date($aut["DATA_VUH"]).'</td>
	  <td align="center">'.german_date($aut["DATA_GOT"]).'</td>
	  <td align="center">'.$tt.'</td>
      </tr>';

}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>