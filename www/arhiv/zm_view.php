<?php
include_once "../function.php";

$d2=date("Y-m-d");
$zam_den="arhiv_zakaz.D_PR='".$d2."'";
$flag=$zam_den;
$szak=$_GET['sz'];
$nzak=$_GET['nz'];

$ns=$_GET['nsp'];
$vl=$_GET['vyl'];
$bd=$_GET['bud'];
$kv=$_GET['kvar'];
//$idn=$_GET['idn'];
//$rah=$_GET['rah'];
//$pr=$_GET['priz'];
if(isset($_GET['npr'])){ 
$npr=date_bd($_GET['npr']);
if(isset($_GET['kpr'])){
$kpr=date_bd($_GET['kpr']);
//$kr_zak=$_GET['vud_zam'];
$posluga=$_GET['posluga'];
//if($kr_zak==3) $fl_vst='';
//else $fl_vst=" AND arhiv_zakaz.TUP_ZAM='".$kr_zak."'";
if($posluga=="") $fl2_vst='';
else $fl2_vst=" AND arhiv_zakaz.VUD_ROB='".$posluga."'";
}
}
if($npr!="" and $kpr!=""){
$flag="arhiv_zakaz.D_PR>='".$npr."' AND arhiv_zakaz.D_PR<='".$kpr."'".$fl_vst.$fl2_vst;
}
if($szak!="" and $nzak!=""){ $flag="arhiv_zakaz.SZ=".$szak." AND arhiv_zakaz.NZ=".$nzak;}

if($ns!="" and $vl!=""){
$flag="arhiv_zakaz.NS=".$ns." AND arhiv_zakaz.VL=".$vl;
if($bd!=""){
$flag.=" AND arhiv_zakaz.BUD=".$bd;
}
if($kv!=""){
$flag.=" AND arhiv_zakaz.KVAR=".$kv;
}
					}
//if($idn!=""){$flag="zamovlennya.IDN=".$idn;}
if(isset($_GET['search'])) $search = $_GET['search']; else $search = '';
if($search != ''){
    $flag="(LOCATE('$search',arhiv_zakaz.SUBJ)!=0 OR LOCATE('$search',arhiv_zakaz.EDRPOU)!=0 OR "
            . "LOCATE('$search',rayonu.RAYON)!=0 OR LOCATE('$search',nas_punktu.NSP)!=0 OR "
            . "LOCATE('$search',vulutsi.VUL)!=0 OR LOCATE('$search',arhiv_zakaz.PR)!=0)";
    
}

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
<th>Замовник</th>
<th>Тип справи</th>
<th>Сертифікована особа</th>
<th>Прим.</th>
<th>Телефон<br>Email</th>
<th>Адреса зам.</th>
<th>Сума</th>
<th>Дата пр.</th>
</tr>';

$sql = "SELECT arhiv_zakaz.*,arhiv_jobs.name,rayonu.RAYON,nas_punktu.NSP,tup_nsp.TIP_NSP,
				vulutsi.VUL,tup_vul.TIP_VUL
			 FROM arhiv_zakaz, rayonu, nas_punktu, vulutsi, tup_nsp, tup_vul, arhiv_jobs
				WHERE 
					".$flag."
					AND arhiv_zakaz.DL='1'  
					AND arhiv_jobs.id=VUD_ROB
					AND rayonu.ID_RAYONA=RN
					AND nas_punktu.ID_NSP=NS
					AND vulutsi.ID_VUL=VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					ORDER BY arhiv_zakaz.KEY DESC";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$kly++;
$d_pr=german_date($aut["D_PR"]);
//if($aut["TUP_ZAM"]==1){
//$tz="ф"; 
//}
//else{
//$tz="ю";
//}
$seriya=$aut["SZ"];
$zam=$aut["NZ"];

//if($aut["TERM"]==1) $term="з"; else $term="т";

$obj_ner=objekt_ner(0,$aut["BUD"],$aut["KVAR"]);

if($ddl=='1'){
if($aut["PS"]=='0'){
$vst_bl='<td align="center"><a href="arhiv.php?filter=delete_info&tip=zakaz&kl='.$aut["KEY"].'"><img src="../images/b_drop.png" border="0"></a></td>';
}
else{
 $vst_bl='<td align="center">-</td>';}
} 
else {
$vst_bl='';
}
//if($tz=="ю"){
//if($aut["PS"]!='0'){
//$vst_bl2='<td align="center"><a href="print_akt.php?kl='.$aut["KEY"].'"><img src="../images/akt.png" border="0"></a></td>';
//}
//else{
//$vst_bl2='<td align="center">-</td>';
//}
$vst_print='<a href="print_dog.php?kl='.$aut["KEY"].'"><img src="../images/print.png" border="0"></a>';
//}
//else{
//if($aut["PS"]!='0'){
//$vst_bl2='<td align="center"><a href="print_akt.php?kl='.$aut["KEY"].'"><img src="../images/akt.png" border="0"></a></td>';
//}
//else{
$vst_bl2='<td align="center"><a href="arhiv.php?filter=dop_vl_view&kl='.$aut["KEY"].'&sz='.$aut["SZ"].'&nz='.$aut["NZ"].'"><img src="../images/active.gif" border="0"></a></td>';
//}
//$vst_print='<a href="print_dog.php?kl='.$aut["KEY"].'"><img src="../images/print.png" border="0"></a>';
//}

$kvut='<a href="print_kvut.php?kl='.$aut["KEY"].'&tz='.$aut["TUP_ZAM"].'"><img src="../images/kvut.png" border="0"></a>';

		
$p.='<tr bgcolor="#FFFAF0">
'.$vst_bl.$vst_bl2.'
<td align="center">'.$vst_print.'</td>	
<td align="center">'.$kvut.'</td>	
	<td align="center">'.$seriya.'</td>
      <td align="center">'.$zam.'</td>
      <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=subj&kl='.$aut["KEY"].'">'.$aut["SUBJ"].'</a></td>    
      <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=tup_spr&kl='.$aut["KEY"].'">'.$aut["name"].'</a></td>
      <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=prizv&kl='.$aut["KEY"].'">'.$aut["PR"]." ".$aut["IM"]." ".$aut["PB"].'</a></td>
	<td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=prim&kl='.$aut["KEY"].'">'.$aut["PRIM"].'</a></td>
        <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=telefon&kl='.$aut["KEY"].'">'.$aut["TEL"].'<br>'.$aut["EMAIL"].'</a></td>
	  <!--<td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=email&kl='.$aut["KEY"].'">'.$mulo.'</a></td>-->
      <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=adres&kl='.$aut["KEY"].'">
				'.$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$obj_ner.'</a></td>
	  <td align="center" id="zal"><a href="arhiv.php?filter=zmina_info&fl=vartist&kl='.$aut["KEY"].'">'.$aut["SUM"].'</a></td>
	  <td align="center">'.$d_pr.'</td>
      </tr>';

}
mysql_free_result($atu);
$p.='</table>';
if($kly>0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>Замовлень не знайдено</b></th></tr></table>';
?>