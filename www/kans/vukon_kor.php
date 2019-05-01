<?php
require('top.php');
include "function.php";

$pr='
<script type="text/javascript">

$(document).ready(function(){
function liFormat (row, i, num) {
	var result = row[0];
	return result;
}
// --- Автозаповнення ---
$("#rob1").autocomplete("/js/robitnuk.php", {
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
$("#rob2").autocomplete("/js/robitnuk.php", {
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
$("#rob3").autocomplete("/js/robitnuk.php", {
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
$("#rob4").autocomplete("/js/robitnuk.php", {
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

$d1=date("Y-m-d",mktime(0,0,0,1,1,date("Y")));

$vhid=$_POST['nom_vh'];

$sql = "SELECT DATAV,NKL,DATAKL,NAIM,BOSS,NI,ZMIST,TIP,DATAVK,TIME FROM kans
		WHERE DATAV>='$d1' AND NV='$vhid' AND PR='1'"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$datv=german_date($aut["DATAV"]); 
	$n_kl=$aut["NKL"];
	$dat_kl=german_date($aut["DATAKL"]);
	$naim=$aut["NAIM"];
	$boss=$aut["BOSS"];
	$n_vuh=$aut["NI"];
	$zmist=$aut["ZMIST"];
	$tip=$aut["TIP"];
	$dat_vuk=german_date($aut["DATAVK"]);
	$time=$aut["TIME"];
 }
 mysql_free_result($atu); 

$k=1;
$sql1 = "SELECT VK FROM kans_vuk
		WHERE DATAV>='$d1' AND NV='$vhid'"; 
 $atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {
	$vuk[$k]=$aut1["VK"]; 
	$k=$k+1;
 }
 mysql_free_result($atu1); 
 
 switch ($k)
{
case 2:
        $vuk1=$vuk[1];
		$vuk2='';
		$vuk3='';
		$vuk4='';
        break; 
case 3:
        $vuk1=$vuk[1];
		$vuk2=$vuk[2];
		$vuk3='';
		$vuk4='';
        break; 
case 4:
        $vuk1=$vuk[1];
		$vuk2=$vuk[2];
		$vuk3=$vuk[3];
		$vuk4='';
        break; 
case 5:
        $vuk1=$vuk[1];
		$vuk2=$vuk[2];
		$vuk3=$vuk[3];
		$vuk4=$vuk[4];
        break; 
default:
        $vuk1='';
		$vuk2='';
		$vuk3='';
		$vuk4='';
        break;
 }  

$pr.='<form action="vukon_upd.php" name="myform" method="post">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="5" align="center">Корегування виконавців</th></tr>
<tr bgcolor="#FFFAF0">
<td>
Кореспондент
</td>
<td colspan="3">
<input type="text" readonly size="40" maxlength="40" name="kores" value="'.$naim.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Номер кореспондента
</td>
<td>
<input type="text" readonly size="20" maxlength="20" name="nkores" value="'.$n_kl.'"/>
</td>
<td>
Дата кор. 
</td>
<td colspan="2">
<input type="text" readonly size="10" maxlength="10" name="datakor" value="'.$dat_kl.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
П.I.Б. 
</td>
<td>
<input type="text" readonly size="20" maxlength="20" name="pib" value="'.$boss.'"/>
</td>
<td>
Тип: 
</td>
<td>
<input type="text" readonly size="10" maxlength="10" name="tup" value="'.$tip.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Змiст 
</td>
<td colspan="3">
<textarea rows="3" cols="42" readonly name="zmist">'.$zmist.'</textarea>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Номер вхiдної кор. 
</td>
<td>
<input type="text" readonly size="10" maxlength="10" name="nvhid" value="'.$vhid.'"/>
</td>
<td>
Дата: <input type="text" readonly size="10" maxlength="10" name="data_vhod" value="'.$datv.'"/>
</td>
</td>
<td>
Час: <input type="text"  readonly size="8" maxlength="8" name="vrem" value="'.$time.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Дата виконання: 
</td>
<td colspan="3">
<input type="text" readonly size="10" maxlength="10" name="data_vuk" value="'.$dat_vuk.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Виконавець1: 
</td>
<td>
<input type="text" id="rob1" size="15" maxlength="10" name="vukon1" value="'.$vuk1.'"/>
</td>
<td>
Виконавець3: 
</td>
<td>
<input type="text" id="rob3" size="15" maxlength="10" name="vukon3" value="'.$vuk3.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Виконавець2: 
</td>
<td>
<input type="text" id="rob2" size="15" maxlength="10" name="vukon2" value="'.$vuk2.'"/>
</td>
<td>
Виконавець4: 
</td>
<td>
<input type="text" id="rob4" size="15" maxlength="10" name="vukon4" value="'.$vuk4.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0"><td align="center" colspan="2">
<input type="submit" name="ok" style="width:70px;" value="Ок">
</form>
</td>
<td align="center" colspan="2">
<form action="vhidna.php" name="myform" method="post">
<input type="submit" name="cans" style="width:70px;" value="Вiдмiна">
</form>
</td></tr>';

$pr.='</table>';
echo $pr;   
require('bottom.php');
?>