<form action="import_opl.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="2" align="center">Період імпорту:</th></tr>
<tr>
<td colspan="2">Дата імпорту:
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/></td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Ок" /></td>
</form>
<td align="center">
<a href="naryadu.php?filter=logo" ><input style="width:80px" name="Cancel" type="button" value="Відміна" /></a>
</td>
</tr>
</table>
