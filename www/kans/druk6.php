<?php
require('top.php');

$pr='
<script type="text/javascript">
$(document).ready(function(){
function liFormat (row, i, num) {
	var result = row[0];
	return result;
}
// --- Автозаповнення ---
$("#rob1").autocomplete("../js/robitnuk.php", {
	delay:10,
	minChars:2,
	matchSubset:1,
	autoFill:true,
	matchContains:1,
	cacheLength:10,
	selectFirst:true,
	formatItem:liFormat,
	maxItemsToShow:30,
});
});
</script>';

$pr.='<form action="druk6pr.php" name="myform" method="post">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="2" align="center">Журнал невиконаних запитiв по виконавцям</th></tr>
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
<tr bgcolor="#FFFAF0">
<td>
Виконавець 
</td>
<td>
<input type="text" id="rob1" size="25" maxlength="25" name="vukon" value=""/>
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