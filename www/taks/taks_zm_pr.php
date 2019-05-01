<?php
include "./scriptu.php";
?>
<form action="taks.php" name="myform" method="get">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="2" align="center">Таксовані замовлення за період</th></tr>
<tr bgcolor="#FFFAF0">
<td>Період</td>
<td>
<input id="date" name="npr" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>" /> - 
<input id="date1" name="kpr" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
<input name="filter" type="hidden" value="taks_view" />
</td>
</tr>
<tr bgcolor="#FFFAF0"><td>
Тип замовлення
</td>
<td>
<input id="r1" type="radio" name="vud_zam" value="1" /><label for="r1">Фізичне</label>
<input id="r2" type="radio" name="vud_zam" value="2" /><label for="r2">Юридичне</label>
<input id="r3" type="radio" name="vud_zam" value="3" checked/><label for="r3">Всі</label>
</td>
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