<?php
include_once "../function.php";
$fl=$_GET['fl'];

if($fl=='injob') $flag='zamovlennya.PS=0 ';
if($fl=='compl') $flag='zamovlennya.PS=1 ';
if($fl=='zm') {
	if(isset($_GET['szam'])) $szak=$_GET['szam'];
	if(isset($_GET['nzam'])) $nzak=$_GET['nzam'];
	if($szak!="" and $nzak!=""){ $flag="zamovlennya.SZ=".$szak." AND zamovlennya.NZ=".$nzak;}
}
if($fl=='ree') {
	if(isset($_GET['nree'])) $nree=$_GET['nree'];
	if($nree!=""){ $flag="zamovlennya.NREE=".$nree;}
}
if($fl=='adres'){
	if(isset($_GET['nsp'])) $ns=$_GET['nsp'];
	if(isset($_GET['vyl']))	$vl=$_GET['vyl'];
	if(isset($_GET['bud']))	$bd=$_GET['bud'];
	if(isset($_GET['kvar'])) $kv=$_GET['kvar'];

	$flag="zamovlennya.NS=".$ns." AND zamovlennya.VL=".$vl;
	if($bd!=""){
		$flag.=" AND zamovlennya.BUD=".$bd;
	}
	if($kv!=""){
		$flag.=" AND zamovlennya.KVAR=".$kv;
	}
}
if($fl=='kon') {
	if(isset($_GET['kn'])) $kn=$_GET['kn'];
	if($kn!=""){$flag="LOCATE('$kn',zamovlennya.PR)!=0";}
}

$kly=0;
$p='<table class="zmview">
<tr>
<th colspan="2">#</th>
<th>Замовлення</th>
<th>Замовник</th>
<th>Вид робіт</th>
<th>Адреса</th>
<th>Телефон</th>
<th>Виконавець</th>
<th>Оплата</th>
<th>Статус</th>
</tr>';

$sql = "SELECT zamovlennya.*,dlya_oformlennya.document,nas_punktu.NSP,tup_nsp.TIP_NSP,
				vulutsi.VUL,tup_vul.TIP_VUL,zamovlennya.KEY
			 FROM zamovlennya, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
				WHERE 
					".$flag."
					AND zamovlennya.DL='1' AND zamovlennya.VUD_ROB>19 
					AND dlya_oformlennya.id_oform=VUD_ROB
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
$dt_opl=german_date($aut["DOKVUT"]);
//$zakaz=$aut["SZ"].'/'.$aut["NZ"];
$obj_ner=objekt_ner(0,$aut["BUD"],$aut["KVAR"]);
$adres=$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$obj_ner;
if($aut["PS"]=='1') {$status='виконане'; $dt_stat=german_date($aut["DATA_PS"]);
$vstavka='<td align="center"><a href="print_akt.php?kl='.$aut["KEY"].'"><img src="../images/akt.png" border="0"></a></td>';}
elseif($aut["PS"]=='0' and $aut["D_STOP"]=='0000-00-00') {$status='в роботі'; $dt_stat='';
$vstavka='<td align="center"><a href="print_kvut.php?kl='.$aut["KEY"].'"><img src="../images/kvut.png" border="0"></a></td>';}
elseif($aut["D_STOP"]!='0000-00-00') {$status='призупинено'; $dt_stat=german_date($aut["D_STOP"]);
$vstavka='<td align="center"><a href="print_kvut.php?kl='.$aut["KEY"].'"><img src="../images/kvut.png" border="0"></a></td>';}
		
$p.='<tr>
<td align="center"><a href="reestr.php?filter=edit_zam&id_zp='.$aut["KEY"].'"><img src="../images/b_edit.png" border="0"></a></td>	
'.$vstavka.'
	<td align="center">№ '.$aut["NREE"].'</br>від '.german_date($aut["D_PR"]).'</td>
      <td align="center">'.$aut["PR"]." ".$aut["IM"]." ".$aut["PB"].'</td>
	  <td align="center">'.$aut["document"].'</td>
	  <td align="center">'.$adres.'</td>
      <td align="center">'.$aut["TEL"].'</td>
      <td align="center">'.$aut["VUK"].'</td>
	  <td align="center">'.$aut["SUM"].' грн.</br>'.$dt_opl.'</td>
	  <td align="center">'.$status.'</br>'.$dt_stat.'</td>
      </tr>';
}
mysql_free_result($atu);
$p.='</table>';
if($kly>0) echo $p;
else echo '<table class="zmview" align="center"><tr><th style="font-size: 35px;"><b>Замовлень не знайдено</b></th></tr></table>';
?>