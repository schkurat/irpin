<?php
$id_pr=$_GET['id_pr'];

$sql = "SELECT * FROM price WHERE ID_PRICE='$id_pr'";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
{	
	$vid=$aut["VUD"];
	$nom=$aut["NOM"];
    $naim=$aut["NAIM"];
    $odv=$aut["ODV"];
	$vum=$aut["VUM"];
	$vuk=$aut["VUK"];
	$kontr=$aut["KONTR"];
	$buro=$aut["BURO"];
}
mysql_free_result($atu);
?>
<form action="update_rob.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Корегування виду робіт</th></tr>
<tr>
<td>№  виду</td>
<td><input type="text" size="15" maxlength="15" name="n_vr" value="<?php echo $nom; ?>"/>
<input name="idpr" type="hidden" value="<?php echo $id_pr; ?>" />
</td>
</tr>
<tr>
<td>Вид</td>
<td>
<?php
$temp="";
for($i=1; $i<=5; $i++){
if($vid==$i)$temp{$i}="selected";
else $temp{$i}="";
}
?>
<select name="vid">
<option value="0">Оберіть вид</option>
<option <?php echo $temp{1}; ?> value="1">Прийом замовлень</option>
<option <?php echo $temp{2}; ?> value="2">Архівні роботи</option>
<option <?php echo $temp{3}; ?> value="3">Роботи техніка</option>
<option <?php echo $temp{4}; ?> value="4">Роботи бюро</option>
<option <?php echo $temp{5}; ?> value="5">Копії</option>
</select>
</td>
</tr>
<tr>
<td>Найменування роботи</td>
<td><input type="text" size="50" name="naim_vr" value="<?php echo $naim; ?>"/></td>
</tr>
<tr>
<td>Одиниці виміру</td>
<td><input type="text" size="20" name="odv" value="<?php echo $odv; ?>"/></td>
</tr>
<tr>
<td>Норма вимірювача</td>
<td><input type="text" size="12" maxlength="12" name="vum" value="<?php echo $vum; ?>"/></td>
</tr>
<tr>
<td>Норма виконавеця</td>
<td><input type="text" size="12" maxlength="12" name="vuk" value="<?php echo $vuk; ?>"/></td>
</tr>
<tr>
<td>Норма контролера</td>
<td><input type="text" size="12" maxlength="12" name="kontr" value="<?php echo $kontr; ?>"/></td>
</tr>
<tr>
<td>Норма бюро</td>
<td><input type="text" size="12" maxlength="12" name="buro" value="<?php echo $buro; ?>"/></td>
</tr>
<tr><td align="center" colspan="2">
<input type="submit" name="ok" value="Корегувати">
</form>
<a href="taks.php">
<input type="button" name="cans" value="Вiдмiна">
</a>
</td>
</tr></table>