<form action="eksport_medoc.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Період експорту:</th></tr>
<tr>
<td>Період з
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/></td>
<td>по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</form>
<td align="center">
<a href="naryadu.php?filter=logo" ><input name="Cancel" type="button" value="Відміна" /></a>
</td>
</tr>
</table>
