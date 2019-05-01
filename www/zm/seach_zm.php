<form action="zamovlennya.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Пошук по номеру замовлення</th></tr>
<tr>
<td>Серія</td>
<td><input name="sz" type="text" size="6" maxlength="6" value="<?php echo date("dmy"); ?>"/>
</td>
</tr>
<tr>
<td>Номер</td>
<td><input name="nz" type="text" size="6" maxlength="6" />
<input name="filter" type="hidden" value="zm_view" />
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" value="Пошук" /></td>
</form><form action="zamovlennya.php" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>