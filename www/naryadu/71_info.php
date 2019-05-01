<form action="naryadu.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="2" align="center">Оберіть період закриття:</th></tr>
<tr>
<td colspan="2">Оберіть період
<input name="dt_n" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y",mktime(0,0,0,date("m"),date("d"),date("Y")));?>"/>
<input name="dt_k" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y",mktime(0,0,0,date("m"),date("d"),date("Y")));?>"/>
<input name="filter" type="hidden" value="71"/>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Ок" /></td>
</form>
<td align="center">
<a href="naryadu.php?filter=logo" ><input name="Cancel" type="button" value="Відміна" /></a>
</td>
</tr>
</table>
