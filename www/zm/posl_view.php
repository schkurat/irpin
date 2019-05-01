<?php
//include "../scriptu.php";

$p='<table class="view2" align="center">
<tr>
<th>Послуги</th>
</tr>';

$sql = "SELECT document FROM dlya_oformlennya WHERE id_oform!=19 ORDER BY document";
			
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$p.='<tr>
	<td>'.$aut["document"].'</td>
      </tr>';
}
mysql_free_result($atu);
$p.='</table>';
echo $p; 
?>