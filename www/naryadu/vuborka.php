<?php
include "../scriptu.php";
$krit=$_GET['krit'];
$isp='<select name="vukon">
	<option value=""></option>';
$sql1 = "SELECT ROBS,ID_ROB FROM robitnuku WHERE BRUGADA=1 AND DL='1' ORDER BY ROBS";
$atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {	$isp.='<option value='.$aut1["ID_ROB"].'>'.$aut1["ROBS"].'</option>';}
mysql_free_result($atu1);
$isp.='</select>';

if($krit=="form"){
?>
<form action="formuvannya.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Формування нарядів</th></tr>
<tr>
<td>Оберіть період</td>
<td>
з
<input name="bdate" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
по
<input name="edate" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" value="Формувати" /></td>
</form><form action="" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="one_v"){
?>
<form action="nr_vuk_print.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Місячний звіт по одному виконавцю</th></tr>
<tr>
<td>Оберіть період</td>
<td>
з
<input name="bdate" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
по
<input name="edate" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr>
<td>Оберіть виконавця</td>
<td><!--<input id="vu" name="vukon" type="text" size="25" maxlength="40" />-->
<?php echo $isp; ?>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" value="Формувати" /></td>
</form><form action="" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="naryad"){
?>
<form action="naryad_vuk_print.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Наряд по одному виконавцю</th></tr>
<tr>
<td>Оберіть період</td>
<td>
з
<input name="bdate" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
по
<input name="edate" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr>
<td>Оберіть виконавця</td>
<td><!--<input id="vu" name="vukon" type="text" size="25" maxlength="40" />-->
<?php echo $isp; ?>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" value="Формувати" /></td>
</form><form action="" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="naryad_br"){
?>
<form action="naryad_brigadira.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Наряд по бригадира</th></tr>
<tr>
<td>Оберіть період</td>
<td>
з
<input name="bdate" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
по
<input name="edate" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr>
<td>Бригадир</td>
<td><input id="vu" name="vukon" type="text" size="25" maxlength="40" value=""/>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" value="Формувати" /></td>
</form><form action="" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="all_t"){
?>
<form action="nr_allteh_print.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Місячний звіт по всім технікам</th></tr>
<tr>
<td>Оберіть період</td>
<td>
з
<input name="bdate" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
по
<input name="edate" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" value="Формувати" /></td>
</form><form action="" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="buro"){
?>
<form action="nr_buro_print.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Місячний звіт по бюро</th></tr>
<tr>
<td>Оберіть період</td>
<td>
з
<input name="bdate" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
по
<input name="edate" class="datepicker" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<td colspan="2">
Район 
			<select style="float:right;" name="rayon">
			<option value="0">Всі</option>
			<?php
			$sql = "SELECT * FROM `rayonu`";
			echo $sql;
			$atu=mysql_query($sql); 
			while ($aut = mysql_fetch_array($atu)) {
				echo '<option value="'.$aut['ID_RAYONA'].'">'.$aut['RAYON'].'</option>';
			}
			?>
			</select>
</td>
<tr><td align="center">
<input name="Ok" type="submit" value="Формувати" /></td>
</form><form action="" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
?>