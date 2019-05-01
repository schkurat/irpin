<form action="import_zal.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Імпорт початкових залишків</th></tr>
<tr>
<td>Місяць</td><td><input name="mis" type="text" size="2" value="<?php echo date('m'); ?>"/></td>
<td>Рік</td><td><input name="rik" type="text" size="4" value="<?php echo date('Y'); ?>"/></td>
</tr>
<tr><td colspan="2" align="center">
<input name="Ok" type="submit" value="Імпорт" /></td>
<td colspan="2" align="center">
<input name="reset" type="reset" value="Очистити" />
</td>
</tr>
</table>
</form>