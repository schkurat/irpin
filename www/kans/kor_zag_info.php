<?php
require('top.php');
$pr='<form action="kor_info.php" name="myform" method="post">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="2" align="center">Корегування загальної інформації</th></tr>
<tr bgcolor="#FFFAF0">
<td>
<input id="r1" type="radio" name="krit" value="vhid" checked/><label for="r1">Вхідна документація</label>
</td>
<td>
номер
<input type="text" size="7" maxlength="7" name="nom_vh" value=""/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
<input id="r2" type="radio" name="krit" value="vuhid"/><label for="r2">Вихідна документація</label>
</td>
<td>
номер
<input type="text" size="7" maxlength="7" name="nom_vuh" value=""/>
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