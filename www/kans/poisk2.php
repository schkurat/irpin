<?php
require('top.php');
$pr='<form action="poisk2pr.php" name="myform" method="post">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="2" align="center">Пошук документацiї</th></tr>
<tr bgcolor="#FFFAF0">
<td>
№ вхiдної кореспондента
</td>
<td>
<input type="text" size="14" maxlength="14" name="n_vhid_kor" value=""/>
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