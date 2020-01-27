<?php
include_once "../function.php";

$sz=$_GET['sz'];
$nz=$_GET['nz'];

$sql = "SELECT SM,SM_KM FROM kasa WHERE DL='1' AND SZ='$sz' AND NZ='$nz'";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$sm=$aut["SM"];
$sm_km=$aut["SM_KM"];
}
mysql_free_result($atu);
$sm_zak=number_format($sm+$sm_km,2);

$p='<table class="zmview" align="center">
<tr>
<th>Замовлення '.$sz.'/'.$nz.'<br>сплачена сума '.$sm_zak.'грн.</th>
</tr>
</table>';
echo $p;
?>