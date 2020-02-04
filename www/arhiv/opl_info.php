<form action="arhiv.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="2" align="center">Перегляд оплати</th></tr>
<tr>
<td>Рік:</td><td>
<input name="rik" type="text" size="4" maxlength="4" value="<?php echo date("Y");?>"/></td>
</tr>
<tr>
<td>Місяць:</td><td>
<input name="mis" type="text" size="2" maxlength="2" value="<?php echo date("m");?>"/>
<input name="filter" type="hidden" value="opl_view"/>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Ок" /></td>
</form>
<td align="center">
<a href="arhiv.php?filter=logo" ><input style="width:80px" name="Cancel" type="button" value="Відміна" /></a>
</td>
</tr>
</table>
