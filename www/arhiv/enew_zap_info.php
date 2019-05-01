<?php
//include "../function.php";
include "../scriptu.php";
?>
<form action="arhiv.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="2"><b>Створення/редагування справи</b></th></tr>
<tr>
<td>Введіть номер інвентарної страви</td>
<td>
<input type="text" size="20" name="inv_spr" value="" required/>
<input type="hidden" size="20" name="filter" value="spr_view" required/>
</td>
</tr>
<tr>
<td align="center"><input type="submit" id="submit" value="Ок" style="width:79px"></td>
<td align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>