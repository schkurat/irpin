<?php
require('top.php');
$pr='<form action="druk2pr.php" name="myform" method="post">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="2" align="center">Журн. вхiдн. кореспонденції</th></tr>
<tr bgcolor="#FFFAF0">
<td>
Перiод розрахунку
</td>
<td>з
<input type="text" size="10" maxlength="10" name="dat1" value="'.date("d.m.Y").'"/>
по 
<input type="text" size="10" maxlength="10" name="dat2" value="'.date("d.m.Y").'"/>
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