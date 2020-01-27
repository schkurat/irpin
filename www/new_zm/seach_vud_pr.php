<?php
include "./scriptu.php";
?>
<form action="index.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Видача за період</th></tr>
<tr>
<td>Період</td>
<td>
<input id="date" name="npr" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>" /> - 
<input id="date1" name="kpr" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
<input name="filter" type="hidden" value="vudacha_view" />
</td>
</tr>
<tr><td>
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
<form action="index.php?filter=vudacha_view" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>