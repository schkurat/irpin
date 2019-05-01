<?php
require('top.php');
include "../function.php";

$zmkont=$_POST['zmist_kont'];
$datp=date_bd($_POST['data_p']);
$zmkont=trim($zmkont);

$pr='<table align="center" class="zmview">
<tr bgcolor="#B5B5B5">
<th>Дата вх. кор.</th>
<th>Дата вх.</th>
<th>№ вих.</th>
<th>№ вх.</th>
<th>№ вх. кор.</th>
<th>Кореспонд.</th>
<th>Дата вих.</th>
<th>Змiст</th>
<th>Тип</th>
<th>П.I.Б</th>
<th>Дата викон.</th>
<th>Виконавець.</th>
</tr>';

$datp=substr($datp,6,4)."-".substr($datp,3,2)."-".substr($datp,0,2);

$sql = "SELECT DATAKL,DATAV,NI,NV,NKL,NAIM,DATAI,ZMIST,TIP,BOSS,DATAVK FROM kans
		WHERE DATAI>='$datp' AND LOCATE('$zmkont',ZMIST)!=0"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
 
$pr.='<tr bgcolor="#FFFAF0">
      <td align="center">'.german_date($aut["DATAKL"]).'</td>
      <td align="center">'.german_date($aut["DATAV"]).'</td>
      <td align="center">'.$aut["NI"].'</td>
      <td align="center" id="zal"><a href="kor_info_get.php?perekl=vhid&nomer='.$aut["NV"].'">'.$aut["NV"].'</a></td>
      <td align="center">'.$aut["NKL"].'</td>
      <td align="center">'.$aut["NAIM"].'</td>
      <td align="center">'.german_date($aut["DATAI"]).'</td>
      <td align="center">'.$aut["ZMIST"].'</td>
      <td align="center">'.$aut["TIP"].'</td>
      <td align="center">'.$aut["BOSS"].'</td>
      <td align="center">'.german_date($aut["DATAVK"]).'</td>
	  <td align="center">';
	$nvh=$aut["NV"];
	$datv=$aut["DATAV"];
	  
$sql1 = "SELECT VK FROM kans_vuk WHERE NV='$nvh' AND DATAV='$datv' ORDER BY NV"; 
 $atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {
$pr.=$aut1["VK"]; 
$pr.=' ';
 }
 mysql_free_result($atu1); 	  
$pr.='</td></tr>';
 }
 mysql_free_result($atu); 

$pr.='</table>';

echo $pr;
require('bottom.php');
?>