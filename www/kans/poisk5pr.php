<?php
require('top.php');
include "function.php";

$nvuhid=$_POST['n_vuhid']; 

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

$sql = "SELECT DATAKL,DATAV,NI,NV,NKL,NAIM,DATAI,ZMIST,TIP,BOSS,DATAVK FROM kans
		WHERE NI='$nvuhid' AND PR='2' ORDER BY NI"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
 
$pr.='<tr bgcolor="#FFFAF0">
      <td align="center">'.german_date($aut["DATAKL"]).'</td>
      <td align="center">'.german_date($aut["DATAV"]).'</td>
      <td align="center" id="zal"><a href="kor_info_get.php?perekl=vuhid&nomer='.$aut["NI"].'">'.$aut["NI"].'</a></td>
      <td align="center">'.$aut["NV"].'</td>
      <td align="center">'.$aut["NKL"].'</td>
      <td align="center">'.$aut["NAIM"].'</td>
      <td align="center">'.german_date($aut["DATAI"]).'</td>
      <td align="center">'.$aut["ZMIST"].'</td>
      <td align="center">'.$aut["TIP"].'</td>
      <td align="center">'.$aut["BOSS"].'</td>
      <td align="center">'.german_date($aut["DATAVK"]).'</td>
	  <td align="center">';
	$datv=$aut["DATAV"];
	$nvh=$aut["NV"];
	
$sql1 = "SELECT VK FROM kans_vuk WHERE NV='$nvh' AND DATAV='$datv'"; 
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