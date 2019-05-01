<?php
include_once "../function.php";

$d2=date("Y-m-d");
$zam_den="zamovlennya.D_PR='".$d2."'";
$flag=$zam_den;
$szak=$_GET['sz'];
$nzak=$_GET['nz'];

$ns=$_GET['nsp'];
$vl=$_GET['vyl'];
$bd=$_GET['bud'];
$kv=$_GET['kvar'];
$idn=$_GET['idn'];
$rah=$_GET['rah'];
$pr=$_GET['priz'];
if(isset($_GET['npr'])){ 
$npr=date_bd($_GET['npr']);
if(isset($_GET['kpr'])){
$kpr=date_bd($_GET['kpr']);
$kr_zak=$_GET['vud_zam'];
$posluga=$_GET['posluga'];
if($kr_zak==3) $fl_vst='';
else $fl_vst=" AND zamovlennya.TUP_ZAM='".$kr_zak."'";
if($posluga=="") $fl2_vst='';
else $fl2_vst=" AND zamovlennya.VUD_ROB='".$posluga."'";
}
}
if($npr!="" and $kpr!=""){
$flag="zamovlennya.D_PR>='".$npr."' AND zamovlennya.D_PR<='".$kpr."'".$fl_vst.$fl2_vst;
}
if($szak!="" and $nzak!=""){ $flag="zamovlennya.SZ=".$szak." AND zamovlennya.NZ=".$nzak;}

if($ns!="" and $vl!=""){
$flag="zamovlennya.NS=".$ns." AND zamovlennya.VL=".$vl;
if($bd!=""){
$flag.=" AND zamovlennya.BUD=".$bd;
}
if($kv!=""){
$flag.=" AND zamovlennya.KVAR=".$kv;
}
					}
if($idn!=""){$flag="zamovlennya.IDN=".$idn;}
if($pr!=""){$flag="LOCATE('$pr',zamovlennya.PR)!=0";}

if($ddl=='1'){
$cssp='4';
}
else {
$cssp='3';
}
$kly=0;
$p='<table class="zmview">
<tr>
<th colspan="'.$cssp.'">#</th>
<th>С.з.</th>
<th>№.</th>
<th>Тип</th>
<th>Тер.</th>
<th>Вид робіт</th>
<th>ПІБ</br>замовника</th>
<th>ПІБ</br>власника</th>
<th>Прим.</th>
<th>Телефон</th>
<th>Адреса зам.</th>
<th>Сума</th>
<th>Дата пр.</th>
<th>Дата вих.</th>
<th>Дата гот.</th>
</tr>';

$sql = "SELECT zamovlennya.*,dlya_oformlennya.document,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,
				vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.KEY
			 FROM zamovlennya, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
				WHERE 
					".$flag."
					AND zamovlennya.DL='1'  
					AND dlya_oformlennya.id_oform=VUD_ROB
					AND rayonu.ID_RAYONA=RN
					AND nas_punktu.ID_NSP=NS
					AND vulutsi.ID_VUL=VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY zamovlennya.KEY DESC";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$kly++;
$d_pr=german_date($aut["D_PR"]);
if($aut["TUP_ZAM"]==1){
$tz="ф"; 
}
else{
$tz="ю";
}
$seriya=$aut["SZ"];
$zam=$aut["NZ"];

if($aut["TERM"]==1) $term="з"; else $term="т";

$obj_ner=objekt_ner(0,$aut["BUD"],$aut["KVAR"]);

if($ddl=='1'){
if($aut["PS"]=='0'){
$vst_bl='<td align="center"><a href="zamovlennya.php?filter=delete_info&tip=zakaz&kl='.$aut["KEY"].'"><img src="../images/b_drop.png" border="0"></a></td>';
}
else{
 $vst_bl='<td align="center">-</td>';}
} 
else {
$vst_bl='';
}
if($tz=="ю"){
if($aut["PS"]!='0'){
$vst_bl2='<td align="center"><a href="print_akt.php?kl='.$aut["KEY"].'"><img src="../images/akt.png" border="0"></a></td>';
}
else{
$vst_bl2='<td align="center">-</td>';
}
$vst_print='<a href="print_dog.php?kl='.$aut["KEY"].'"><img src="../images/print.png" border="0"></a>';
/* $vst_print='
<style>
#print a{
	display:block;
	text-decoration: none;
	color: black;
	background: #FFF0F5;
}
div#print a:hover{
	display:block;
	text-decoration: none;
	color: black;
	background: #FFE4B5;
}
  </style>
<div id="print"><a href="print_dog.php?kl='.$aut["KEY"].'&tip=10">10</a>
<a href="print_dog.php?kl='.$aut["KEY"].'&tip=30">30</a>
<a href="print_dog.php?kl='.$aut["KEY"].'&tip=b">Б</a>
<a href="print_dog.php?kl='.$aut["KEY"].'&tip=3h">3-х</a>
<a href="print_dog.php?kl='.$aut["KEY"].'&tip=r">Р</a></div>'; */
}
else{
if($aut["PS"]!='0'){
$vst_bl2='<td align="center"><a href="print_akt.php?kl='.$aut["KEY"].'"><img src="../images/akt.png" border="0"></a></td>';
}
else{
$vst_bl2='<td align="center"><a href="zamovlennya.php?filter=dop_vl_view&kl='.$aut["KEY"].'&sz='.$aut["SZ"].'&nz='.$aut["NZ"].'"><img src="../images/active.gif" border="0"></a></td>';
}
$vst_print='<a href="print_dog.php?kl='.$aut["KEY"].'"><img src="../images/print.png" border="0"></a>';
}
//if($aut["RAH"]!='0' || $aut["TUP_ZAM"]!=2){
$kvut='<a href="print_kvut.php?kl='.$aut["KEY"].'&tz='.$aut["TUP_ZAM"].'"><img src="../images/kvut.png" border="0"></a>';
/* }
else{
$kvut='-';
} */
		
$p.='<tr bgcolor="#FFFAF0">
'.$vst_bl.$vst_bl2.'
<td align="center">'.$vst_print.'</td>	
<td align="center">'.$kvut.'</td>	
	<td align="center">'.$seriya.'</td>
      <td align="center">'.$zam.'</td>
	  <td align="center">'.$tz.'</td>
	  <td align="center">'.$term.'</td>
      <td align="center" id="zal"><a href="zamovlennya.php?filter=zmina_info&fl=vud_zm&kl='.$aut["KEY"].'">'.$aut["document"].'</a></td>
      <td align="center" id="zal"><a href="zamovlennya.php?filter=zmina_info&fl=prizv&kl='.$aut["KEY"].'">'.$aut["PR"]." ".$aut["IM"]." ".$aut["PB"].'</a></td>
	  <td align="center">'.$aut["PRVL"]." ".$aut["IMVL"]." ".$aut["PBVL"].'</td>
	  <td align="center" id="zal"><a href="zamovlennya.php?filter=zmina_info&fl=prim&kl='.$aut["KEY"].'">'.$aut["PRIM"].'</a></td>
	  <td align="center">'.$aut["TEL"].'</td>
	  <!--<td align="center" id="zal"><a href="zamovlennya.php?filter=zmina_info&fl=email&kl='.$aut["KEY"].'">'.$mulo.'</a></td>-->
      <td align="center" id="zal"><a href="zamovlennya.php?filter=zmina_info&fl=adres&kl='.$aut["KEY"].'">
				'.$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$obj_ner.'</a></td>
	  <td align="center" id="zal"><a href="zamovlennya.php?filter=zmina_info&fl=vartist&kl='.$aut["KEY"].'">'.$aut["SUM"].'</a></td>
	  <td align="center">'.$d_pr.'</td>
	  <td align="center">'.german_date($aut["DATA_VUH"]).'</td>
	  <td align="center">'.german_date($aut["DATA_GOT"]).'</td>
      </tr>';

}
mysql_free_result($atu);
$p.='</table>';
if($kly>0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>Замовлень не знайдено</b></th></tr></table>';
?>