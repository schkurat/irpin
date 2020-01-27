<?php
include_once "../function.php";

$dt_vd=date("Y-m-d");
if(isset($_GET["npr"])) $npr=date_bd($_GET["npr"]); else $npr='';
if(isset($_GET["kpr"])) $kpr=date_bd($_GET["kpr"]); else $kpr='';
$vud_zam=$_GET["vud_zam"];
if($npr!='' and $kpr!=''){
if($vud_zam=='3'){
$filter="zamovlennya.DATA_VD>='$npr' AND zamovlennya.DATA_VD<='$kpr'";}
else{
$filter="zamovlennya.DATA_VD>='$npr' AND zamovlennya.DATA_VD<='$kpr' AND zamovlennya.TUP_ZAM='$vud_zam'";}
}
else{ 
$filter="zamovlennya.DATA_VD='$dt_vd'";}

$p='<table align="center" class="zmview">
<tr bgcolor="#B5B5B5">
<th colspan="2">#</th>
<th>№ зам.</th>
<th>Вид робіт</th>
<th>ІДН</th>
<th>ПІБ</th>
<th>Прим.</th>
<th>Дата нар.</th>
<th>Адреса зам.</th>
<th>Сума допл.</th>
<th>Дата гот.</th>
</tr>';
$lich=0;
$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,zamovlennya.PRIM,
	zamovlennya.DOKVUT,zamovlennya.IDN,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.D_NAR,
	zamovlennya.BUD,zamovlennya.KVAR,zamovlennya.SUM_D,zamovlennya.DATA_GOT,dlya_oformlennya.document,
	nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.KEY
	FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
	WHERE
		zamovlennya.DL='1' AND ".$filter." AND zamovlennya.VD='1'
		AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB
		AND rayonu.ID_RAYONA=zamovlennya.RN
		AND nas_punktu.ID_NSP=zamovlennya.NS
		AND vulutsi.ID_VUL=zamovlennya.VL
		AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
		AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
		ORDER BY zamovlennya.KEY DESC"; 
				
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
  {	
if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";

if($aut["DOKVUT"]=="0000-00-00")
{ $prop="dollar_s.png";
$stat="n";
}
else{
$prop="dollar_z.png";
$stat="a";
}
$zakaz=$aut["SZ"].'/'.$aut["NZ"];

$p.='<tr bgcolor="#FFFAF0">
<td align="center"><a href="print_kvut_vudacha.php?kl='.$aut["KEY"].'&tz='.$aut["TUP_ZAM"].'"><img src="/images/print.png"></a></td>
<td align="center"><a href="print_akt_vudacha.php?kl='.$aut["KEY"].'"><img src="/images/akt.png"></a></td>
	<td align="center">'.$zakaz.'</td>
      <td align="center">'.$aut["document"].'</td>
	  <td align="center">'.$aut["IDN"].'</td>
      <td align="center">'.$aut["PR"]." ".$aut["IM"]." ".$aut["PB"].'</td>
	  <td align="center">'.$aut["PRIM"].'</td>
	  <td align="center">'.german_date($aut["D_NAR"]).'</td>
      <td align="center">'.$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$bud." ".$kvar.'</td>
	  <td align="center" id="zal"><a href="index.php?filter=zmina_dop_info&kl='.$aut["KEY"].'">'.$aut["SUM_D"].'</a></td>
	  <td align="center">'.german_date($aut["DATA_GOT"]).'</td>
      </tr>';
$lich++;
}
mysql_free_result($atu);
$p.='</table>';
 
if($lich>0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>За даний період видача не здійснювалась.</b></th></tr></table>';
?>