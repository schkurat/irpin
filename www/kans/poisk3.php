<?php
require('top.php');

$pr='<script type="text/javascript">
jQuery(function($){  
    $("#date").mask("99.99.9999");
	$("#chas").mask("99:99:99");	
    $("#phone").mask("99-99-99");  
    $("#tin").mask("99-9999999");  
    $("#ssn").mask("999-99-9999");  
}); 
</script>';

$pr.='<form action="poisk3pr.php" name="myform" method="post">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="2" align="center">Пошук документацiї</th></tr>
<tr bgcolor="#FFFAF0">
<td>
Кореспондент (контекст)
</td>
<td>
<input type="text" size="25" maxlength="25" name="naim_kont" value=""/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Дата начала пошуку:
</td>
<td>
<input type="text" id="date" size="10" maxlength="10" name="data_p" value=""/>
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