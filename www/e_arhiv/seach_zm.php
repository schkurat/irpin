<?php
include "../scriptu.php";
?>
<form action="earhiv.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Пошук по номеру замовлення</th></tr>
<tr>
<td>Серія замовлення
<input name="flag" type="hidden" value="zm" />
</td>
<td style="width:100px"><input name="szam" type="text" size="2" maxlength="2" value="<?php echo date("y");?>"/></td>
</tr>
<tr>
<td>Номер замовлення</td>
<td style="width:100px"><input name="nzam" type="text" size="6" maxlength="6" />
<input name="filter" type="hidden" value="teh_view" />
<input name="fl" type="hidden" value="zm" />
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" value="Пошук" /></td>
</form><form action="earhiv.php" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>