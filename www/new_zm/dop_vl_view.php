<?php
include "../function.php";

$sz=$_GET['sz'];
$nz=$_GET['nz'];
$kl=$_GET['kl'];
 
$p='Серія замовлення '.$sz.' Замовлення № '.$nz.''; 
 
$p.='<table class="zmview">
<tr bgcolor="#B5B5B5">
<th>#</th>
<th>Прізвище</th>
<th>Ім`я</th>
<th>По батькові</th>
<th>Дата народження</th>
<th>Ідентифікаційний код</th>
</tr>';

$sql = "SELECT * FROM zm_dod WHERE IDZM='$kl' AND DL='1'";
					
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	

$p.='<tr bgcolor="#FFFAF0">
<td align="center"><a href="delete_zm.php?tip=dod&kll='.$kl.'&pr='.$aut["PR"].'"><img src="/images/b_drop.png"></a></td>
      <td align="center">'.$aut["PR"].'</td>
      <td align="center">'.$aut["IM"].'</td>
      <td align="center">'.$aut["PB"].'</td>
	  <td align="center">'.german_date($aut["DN"]).'</td>
      <td align="center">'.$aut["IDN"].'</td>
      </tr>';

}
mysql_free_result($atu);
$p.='</table><br>
<a href="index.php?filter=drugi_vlasnuku&sz='.$sz.'&nz='.$nz.'"><input type="button" value="Додати власників" name="add_vl"/></a>';
echo $p; 
?>