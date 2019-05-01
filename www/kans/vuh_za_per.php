<?php
require('top.php');
$pr='<form action="vuhid_view.php" name="myform" method="post">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="2" align="center">Вихідна за період</th></tr>
<tr bgcolor="#FFFAF0">
<td>
Вкажіть період
</td>
<td colspan="">з 
<input type="text" size="10" maxlength="10" name="dt_n" value="'.date("d.m.Y").'"/> по 
<input type="text" size="10" maxlength="10" name="dt_k" value="'.date("d.m.Y").'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0"><td align="center" colspan="2">
<input type="submit" name="ok" value="Ок">
</td></tr>
</form>';

$pr.='</table>';
echo $pr;   
require('bottom.php');
?>