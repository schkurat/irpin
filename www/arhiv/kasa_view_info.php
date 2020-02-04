<?php
include "../scriptu.php";
?>
<form action="arhiv.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="2" align="center">Перегляд каси</th></tr>
<tr>
<td>Дата надхоження</td>
<td><input name="dt_obr" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
<input name="filter" type="hidden" value="kasa_view"/>
</td>
</tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" style="width:80px" value="Перегляд" /></td>
</form>
</tr>
</table>
