<?php
	include "../scriptu.php";
	$krit=$_GET['krit'];

	if($krit=="zm"){
		?>
	<form action="index.php" name="myform" method="get">
	<table align="center" class="zmview">
	<tr><th colspan="4" align="center">Пошук по номеру замовлення</th></tr>
	<tr>
	<td>Серія замовлення
	<input name="flag" type="hidden" value="zm" />
	</td>
	<td style="width:100px"><input name="szam" type="text" size="6" maxlength="6" value="<?php echo date("dmy");?>"/></td>
	</tr>
	<tr>
		<td>Номер замовлення</td>
		<td style="width:100px"><input name="nzam" type="text" size="6" maxlength="6" /></td>
	</tr>
	<tr><td align="center">
<input name="Ok" type="submit" value="Пошук" /></td>
</form><form action="index.php?filter=pidpus_view" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="vuk"){
?>
<form action="index.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Пошук по виконавцю</th></tr>
<tr>
<td>Виконавець
<input name="flag" type="hidden" value="vuk" />
</td>
<td style="width:100px"><input id="vu" name="vk" type="text" size="20" />
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" value="Пошук" /></td>
</form><form action="index.php?filter=pidpus_view" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="adr"){
?>
<form action="index.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="4" align="center" bgcolor="#999999" >Пошук по за адресою</th></tr>
<tr>
<td>Населений пункт: </td>
<td colspan="3">
<div class="border">
<select class="sel_ad" id="nas_punkt" name="nsp" required>
<option value="">Оберіть населений пункт</option>
<?php
$sql = "SELECT nas_punktu.ID_NSP,nas_punktu.NSP,tup_nsp.TIP_NSP
		FROM nas_punktu,tup_nsp
		WHERE nas_punktu.ID_TIP_NSP=tup_nsp.ID_TIP_NSP
		ORDER BY nas_punktu.ID_NSP";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 echo '<option value="'.$aut["ID_NSP"].'">'.$aut["NSP"].' '.$aut["TIP_NSP"].'</option>';
 }
mysql_free_result($atu);
?>
</select>
</div>
</td>
</tr>
<tr>
<td>Вулиця: </td>
<td colspan="3">
<div class="border">
<select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled"></select>
</div>
</td>
</tr>
<tr>
<td>Будинок:
<input name="flag" type="hidden" value="adres" />
</td>
<td><input type="text" size="10" maxlength="10" name="bud" value=""/></td>
<td>Квартира: </td>
<td><input type="text" size="3" maxlength="3" name="kvar" value=""/>
</td>
</tr>

<tr bgcolor="#FFFAF0"><td colspan="2" align="center">
<input name="Ok" type="submit" value="Пошук" /></td>
</form><form action="index.php?filter=pidpus_view" name="myform" method="post">
<td colspan="2" align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
?>
