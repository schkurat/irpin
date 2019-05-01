<?php
include("../function.php");
$id=$_GET["id"];
$path=$_GET["path"];
$sql="SELECT * FROM temp_kasa WHERE temp_kasa.ID='$id'";
	$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu)){
		$dt=german_date($aut["DATE"]);
		$nz=$aut["NZ"];
		$tip=$aut["TIP"];
		$sum=$aut["SUM"];
		$sum_km=$aut["SUM_KM"];
		$prim=$aut["PRIM"];
	}
	mysql_free_result($atu);
?>
<form action="naryadu.php" name="myform" method="get">
<table align="center" class="bordur">
<tr bgcolor="#B5B5B5"><th  align="center" colspan="2">Редагування запису</th></tr>
<tr><td>Дата</td>
<td><input name="dat" type="text" size="10" maxlength="10" value="<?php echo $dt; ?>"></td></tr>
<tr><td>Замовлення</td>
<td><input name="zamov" type="text" value="<?php echo $nz; ?>"></td></tr>
<tr><td>Тип</td>
<td><input name="tip" type="text" value="<?php echo $tip; ?>"></td></tr>
<tr><td>Сума</td>
<td><input name="sum" type="text" value="<?php echo $sum; ?>"></td></tr>
<tr><td>Сума комісії</td>
<td><input name="sum_km" type="text" value="<?php echo $sum_km; ?>"></td></tr>
<tr><td>Примітка</td>
<td><input name="prim" type="text" size="70" maxlength="70" value="<?php echo $prim; ?>" readonly></td></tr>


<tr bgcolor="#FFFAF0"><td align="center" colspan="2">
<input name="filter" type="hidden" value="edit_kasa_sv">
<input name="id" type="hidden" value="<?php echo $id; ?>">
<input name="path" type="hidden" value="<?php echo $path; ?>">
<input name="Ok" type="submit" value="Зберегти" />
</form>
<!--<form action="zamovlennya.php?filter=logo" name="myform" method="post">-->
<a href="naryadu.php?filter=logo" ><input name="Cancel" type="button" value="Відміна" /></a>
<!--</form>-->
</td>
</tr>
</table>