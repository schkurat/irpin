<?php
require('top.php');
$pr='<form action=".php" name="myform" method="post">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="2" align="center">Журн. вхiдн. коресп. пiсля 15 години</th></tr>
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
<td align="center">
<form action="vhidna.php" name="myform" method="post">
<input type="submit" name="cans" style="width:70px;" value="Вiдмiна">
</form>
</td>
</tr>';

$pr.='</table>';
echo $pr;   
require('bottom.php');
?>