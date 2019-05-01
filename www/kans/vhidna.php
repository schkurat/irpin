<?php
require('top.php');
include "function.php";
$pr='
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
<table align="center" class="zmview">
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
</tr>';

$d1=date("Y-m-d",mktime(0,0,0,/*date("m")*/1,/*date("d")-*/1,date("Y")));
$d2=date("Y-m-d");


$sql = "SELECT DATAKL,DATAV,NI,NV,NKL,NAIM,DATAI,ZMIST,TIP,BOSS,DATAVK FROM kans
		WHERE DATAV>='$d1' AND DATAV<='$d2' AND PR='1' ORDER BY NV DESC"; 
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
      </tr>'; 
 }
 mysql_free_result($atu); 

$pr.='</table>';

echo $pr;
require('bottom.php');
?>