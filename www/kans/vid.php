<?php
require('top.php');
$pr='<form action="vidpov.php" name="myform" method="post">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="2" align="center">Вихiдна документацiя</th></tr>
<tr bgcolor="#FFFAF0">
<td>
Вхiдний номер
</td>
<td colspan="">
<input type="text" size="7" maxlength="7" name="nom_vh" value=""/>
</td>
</tr>
<tr bgcolor="#FFFAF0"><td align="center" colspan="2">
<input type="submit" name="ok" style="width:70px;" value="Ок">
</td></tr>
</form>';

$pr.='</table>';
echo $pr;   
require('bottom.php');
?>