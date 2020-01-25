<?php
include "../scriptu.php";
?>
<form action="index.php" name="myform" method="get">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="2" align="center">Оберіть замовлення</th></tr>
<tr>
<td>Серія замовлення
<input type="hidden" name="filter" value="gr_ros_info2">
</td>
<td style="width:100px"><input name="szam" type="text" size="2" maxlength="2" value="<?php echo date("y");?>"/></td>
</tr>
<tr>
<td>Номер замовлення</td>
<td style="width:100px"><input name="nzam" type="text" size="6" maxlength="6" />
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" value="Пошук" /></td>
</form>
<td align="center">
<a href="index.php?filter=fon">
<input name="Cancel" type="button" value="Відміна" />
</a>
</td>
</tr>
</table>
