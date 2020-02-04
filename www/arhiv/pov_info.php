<?php
include("../function.php");
?>
<form action="arhiv.php" name="myform" method="get">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th  align="center" colspan="2">Повернення коштів</th></tr>
<tr>
<td>Серія замовлення
</td>
<td style="width:100px"><input name="szam" type="text" size="6" maxlength="6" value="<?php echo date("dmy");?>"/></td>
</tr>
<tr>
<td>Номер замовлення</td>
<td style="width:100px"><input name="nzam" type="text" size="6" maxlength="6" />
</td></tr>
<tr>
<td>Дата повернення</td>
<td style="width:100px"><input class="datepicker" name="dpov" type="text" required />
</td></tr>
<tr><td>Сума</td>
<td><input name="sum" type="text" value=""></td></tr>
<tr><td align="center" colspan="2">
<input name="filter" type="hidden" value="vozvrat_add">
<input name="Ok" type="submit" value="Повернути" />
</form>
<a href="arhiv.php?filter=logo" ><input name="Cancel" type="button" value="Відміна" /></a>
</td>
</tr>
</table>