<?php
require('top.php');
$pr='<form action="druk8pr.php" name="myform" method="post">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="2" align="center">Журнал вихідної інформації за номером</th></tr>
<tr bgcolor="#FFFAF0">
<td>
Вихід. номер
</td>
<td>
<input type="text" size="7" maxlength="7" name="n_vuhid" value=""/>
</td></tr>
<tr bgcolor="#FFFAF0"><td>
Дата: 
</td>
<td>
<input type="text" size="10" maxlength="10" name="dat" value="'.date("d.m.Y").'"/>
</td>
</tr>

<tr bgcolor="#FFFAF0"><td align="center">
<input type="submit" name="ok" style="width:70px;" value="Ок">
</td></form>
<form action="vhidna.php" name="myform" method="post">
<td align="center">
<input type="submit" name="cans" style="width:70px;" value="Вiдмiна">
</td>
</form>
</tr>';

$pr.='</table>';
echo $pr;   
require('bottom.php');
?>