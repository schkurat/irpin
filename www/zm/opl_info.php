<?php
include "./scriptu.php";
?>
<form action="zamovlennya.php" name="myform" method="get">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="2" align="center">Замовлення</th></tr>
<tr bgcolor="#FFFAF0">
<td>Серія</td>
<td>
<input name="sz" type="text" size="6" maxlength="6" value="<?php echo date("dmy");?>" />
<input name="filter" type="hidden" value="splata" />
</td>
</tr>
<tr bgcolor="#FFFAF0"><td>
Замовлення №
</td>
<td><input name="nz" type="text" size="6" value="" /></td>
</tr>
<tr bgcolor="#FFFAF0"><td align="center">
<input name="Ok" type="submit" value="Пошук" /></td>
</form>
<form action="zamovlennya.php?filter=logo" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>