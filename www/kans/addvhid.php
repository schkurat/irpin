<?php
require('top.php');

$pr='
<script type="text/javascript">
$(document).ready(function(){
$("#ex").autocompleteArray([
"виготовити свідоцтво про право власності на майно",
"видати свідоцтво про право власності на майно",
"за ким зареєстровано майно по",
"зняти арешт",
"надати копії технічної документації",
"накласти арешт",
"позивач-",
"про належність земельної ділянки",
"про належність власності",
"чи зареєстрована власність"],
{
	delay:10,
	minChars:1,
	matchSubset:1,
	autoFill:true,
	maxItemsToShow:10
}
);});

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
$(document).ready(function(){
function liFormat (row, i, num) {
	var result = row[0];
	return result;
}
// --- Автозаповнення ---
$("#rob2").autocomplete("../js/robitnuk.php", {
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
$(document).ready(function(){
function liFormat (row, i, num) {
	var result = row[0];
	return result;
}
// --- Автозаповнення ---
$("#rob3").autocomplete("../js/robitnuk.php", {
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
$(document).ready(function(){
function liFormat (row, i, num) {
	var result = row[0];
	return result;
}
// --- Автозаповнення ---
$("#rob4").autocomplete("../js/robitnuk.php", {
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
jQuery(function($){  
    $("#date1").mask("99.99.9999");
	$("#date2").mask("99.99.9999");
	$("#date3").mask("99.99.9999");
	$("#chas").mask("99:99:99");	
    $("#phone").mask("99-99-99");  
    $("#tin").mask("99-9999999");  
    $("#ssn").mask("999-99-9999");  
}); 
</script>';

$pr.='<form action="vhidadd.php" name="myform" method="post">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="5" align="center">Вхiдна документацiя</th></tr>
<tr bgcolor="#FFFAF0">
<td>
Кореспондент
</td>
<td colspan="3">
<input type="text" size="40" maxlength="40" name="kores" value=""/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Номер кореспондента
</td>
<td>
<input type="text" size="20" maxlength="20" name="nkores" value=""/>
</td>
<td>
Дата кор. 
</td>
<td colspan="2">
<input type="text" id="date1" size="10" maxlength="10" name="datakor" value="'.date("d.m.Y").'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
П.I.Б. 
</td>
<td>
<input type="text" size="20" maxlength="20" name="pib" value=""/>
</td>
<td>
Тип: 
</td>
<td>
<select name="tup" size="1" >
					<option value="арешт, зняття">арешт, зняття</option>
            		<option value="замовлення">замовлення</option>
                    <option selected value="запити інші">запити інші</option>
                    <option value="запити ВДВС">запити ВДВС</option>
					<option value="листи">листи</option>
					<option value="позовна заява">позовна заява</option>
					<option value="судові засідання">судові засідання</option>
   </select>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Змiст 
</td>
<td colspan="3">
<textarea rows="3" cols="42" id="ex" name="zmist"></textarea>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Дата вхiдної кор. 
</td>
<td>
<input type="text" id="date2" size="10" maxlength="10" name="data_vhod" value="'.date("d.m.Y").'"/>
</td>
<td colspan="2">
Час: <input type="text"  id="chas" size="8" maxlength="8" name="vrem" value="'.date("H:i:s").'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Дата виконання: 
</td>
<td colspan="3">
<input type="text" id="date3" size="10" maxlength="10" name="data_vuk" value="" required/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Виконавець1: 
</td>
<td>
<input type="text" id="rob1" size="15" maxlength="10" name="vukon1" value=""/>
</td>
<td>
Виконавець3: 
</td>
<td>
<input type="text" id="rob3" size="15" maxlength="10" name="vukon3" value=""/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Виконавець2: 
</td>
<td>
<input type="text" id="rob2" size="15" maxlength="10" name="vukon2" value=""/>
</td>
<td>
Виконавець4: 
</td>
<td>
<input type="text" id="rob4" size="15" maxlength="10" name="vukon4" value=""/>
</td>
</tr>
<tr bgcolor="#FFFAF0"><td align="center" colspan="2">
<input type="submit" name="ok" style="width:70px;" value="Ок">
</form>
</td>
<form action="vhidna.php" name="myform" method="post">
<td align="center" colspan="2">
<input type="submit" name="cans" style="width:70px;" value="Вiдмiна">
</td>
</form>
</tr>';

$pr.='</table>';
echo $pr;   
require('bottom.php');
?>