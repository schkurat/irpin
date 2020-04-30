<?php
$tp=$_GET['tip'];
$kl=$_GET['kl'];
$taks=0;

$sql = "SELECT SZ,NZ FROM zamovlennya WHERE zamovlennya.KEY='$kl'";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu)){
		$sz=$aut["SZ"];
		$nz=$aut["NZ"];
	}
mysql_free_result($atu);

$sql = "SELECT * FROM taks WHERE taks.IDZM='$kl' AND taks.DL='1'";
$atu=mysql_query($sql);
$taks=mysql_num_rows($atu);
mysql_free_result($atu);

$sql = "SELECT SUM(SM) AS SM FROM kasa WHERE kasa.SZ='$sz' AND kasa.NZ='$nz' AND kasa.DL='1'";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
    $sm=$aut["SM"];
}
mysql_free_result($atu);
 
$p='<table class="zmview">
<tr bgcolor="#B5B5B5">
<th>Видалення замовлення</th>
</tr>';
if(!empty($taks) or $sm > 0){
$p.='<tr bgcolor="#FFFAF0">
<td>Замовлення '.$sz.'/'.$nz.' неможливо видалити!</td>
</tr>
<tr bgcolor="#FFFAF0"><td align="center">
<a href="index.php?filter=zm_view"><input name="cancel" type="button" value="OK"></a></td>
</tr>';
}
else{
$p.='<tr bgcolor="#FFFAF0">
<td>Ви дійсно бажаєте видалити замовлення '.$sz.'/'.$nz.'?</td>
</tr>
<tr bgcolor="#FFFAF0"><td align="center">
<a href="delete_zm.php?tip='.$tp.'&kl='.$kl.'"><input name="cancel" type="button" value="Ок"></a>
<a href="index.php?filter=zm_view"><input name="cancel" type="button" value="Відміна"></a>
</td>
</tr>';
}
$p.='</table>';
echo $p;
?>