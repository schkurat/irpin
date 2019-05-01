<form action="naryadu.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="2" align="center">Перенесення кінцевих залишків:</th></tr>
<tr>
<td colspan="2">Оберіть місяць
<input name="dt" type="text" size="7" maxlength="7" value="<?php echo date("m.Y",mktime(0,0,0,date("m")+1,1,date("Y")));?>"/>
<input name="filter" type="hidden" value="perenos"/>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Перенос" /></td>
</form>
<td align="center">
<a href="naryadu.php?filter=logo" ><input name="Cancel" type="button" value="Відміна" /></a>
</td>
</tr>
</table>
