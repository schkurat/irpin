<?php
require('top.php');
include "function.php";
//$perekl=$_POST['krit'];
$perekl=$_GET['perekl'];
$nomer=$_GET['nomer'];

if($perekl=='vhid'){
//$n_vh=$_POST['nom_vh'];
$n_vh=$nomer;

$d1=date("Y-m-d",mktime(0,0,0,1,1,date("Y")));

$sql = "SELECT DATAV,NKL,DATAKL,NAIM,BOSS,ZMIST,TIP,NI,DATAI FROM kans
		WHERE DATAV>='$d1' AND NV='$n_vh' AND PR='1'"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$data_vh=german_date($aut["DATAV"]);
	$nom_kl=$aut["NKL"];
	$data_kl=german_date($aut["DATAKL"]);
	$naim=$aut["NAIM"];
	$boss=$aut["BOSS"];
	$zmist=$aut["ZMIST"];
	$tip=$aut["TIP"];
	$n_vuh=$aut["NI"];
	$datvuh=german_date($aut["DATAI"]);
 }
 mysql_free_result($atu); 

$pr='<form action="kor_vh.php" name="myform" method="post" enctype="multipart/form-data">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="5" align="center">Вихiдна документацiя</th></tr>
<tr bgcolor="#FFFAF0">
<td>Кореспондент</td>
<td colspan="3">
<input type="text" size="20" maxlength="20" name="kores" value="'.$naim.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>Номер кореспондента</td>
<td>
<input type="text" size="20" maxlength="20" name="nkores" value="'.$nom_kl.'"/>
</td>
<td>Дата: </td>
<td colspan="2">
<input type="text" size="10" maxlength="10" name="datkl" value="'.$data_kl.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>П.I.Б. </td>
<td>
<input type="text" size="20" maxlength="20" name="pib" value="'.$boss.'"/>
</td>
<td>Тип: </td>
<td>
<input type="text" size="10" maxlength="10" name="tup" value="'.$tip.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>Змiст </td>
<td colspan="3">
<textarea rows="3" cols="42" name="zauv">'.$zmist.'</textarea>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>Номер вхiдної кор. </td>
<td>
<input type="text" readonly size="10" maxlength="10" name="nvhid" value="'.$n_vh.'"/>
</td>
<td>Дата: </td>
<td>
<input type="text" readonly size="10" maxlength="10" name="data_v" value="'.$data_vh.'"/>
</td>
<tr bgcolor="#FFFAF0">
<td>Номер вихiдної кор. </td>
<td>
<input type="text" readonly size="10" maxlength="10" name="nvuh" value="'.$n_vuh.'"/>
</td>
<td>Дата: </td>
<td>
<input type="text" readonly size="10" maxlength="10" name="data_vuh" value="'.$datvuh.'"/>
</td>
</tr>
<tr>
                <td colspan="2">Файли для електронного архіву</td>
                <td colspan="2">
                    <input type="file" name="file[]" size="40" multiple>
                </td>
            </tr>
<tr bgcolor="#FFFAF0">
<td align="center" colspan="4">
<input type="submit" name="ok" style="width:70px;" value="Ок">
</td>
</tr>
</form>';

}
if($perekl=='vuhid'){
////$n_vuh=$_POST['nom_vuh'];
$n_vuh=$nomer;

$d1=date("Y-m-d",mktime(0,0,0,1,1,date("Y")));

$sql = "SELECT DATAV,NKL,DATAKL,NAIM,BOSS,ZMIST,TIP,NV,DATAI FROM kans
		WHERE DATAI>='$d1' AND NI='$n_vuh' AND PR='2'"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$data_vh=german_date($aut["DATAV"]);
	$nom_kl=$aut["NKL"];
	$data_kl=german_date($aut["DATAKL"]);
	$naim=$aut["NAIM"];
	$boss=$aut["BOSS"];
	$zmist=$aut["ZMIST"];
	$tip=$aut["TIP"];
	$n_vh=$aut["NV"];
	$datvuh=german_date($aut["DATAI"]);
 }
 mysql_free_result($atu); 

$pr='<form action="kor_vuh.php" name="myform" method="post">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="5" align="center">Вихiдна документацiя</th></tr>
<tr bgcolor="#FFFAF0">
<td>Кореспондент</td>
<td colspan="3">
<input type="text" size="20" maxlength="20" name="kores" value="'.$naim.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>Номер кореспондента</td>
<td>
<input type="text" readonly size="20" maxlength="20" name="nkores" value="'.$nom_kl.'"/>
</td>
<td>Дата: </td>
<td colspan="2">
<input type="text" readonly size="10" maxlength="10" name="datkl" value="'.$data_kl.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>П.I.Б. </td>
<td>
<input type="text" readonly size="20" maxlength="20" name="pib" value="'.$boss.'"/>
</td>
<td>Тип: </td>
<td>
<input type="text" readonly size="10" maxlength="10" name="tup" value="'.$tip.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>Змiст </td>
<td colspan="3">
<textarea rows="3" cols="42" name="zauv">'.$zmist.'</textarea>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>Номер вхiдної кор. </td>
<td>
<input type="text" readonly size="10" maxlength="10" name="nvhid" value="'.$n_vh.'"/>
</td>
<td>Дата: </td>
<td>
<input type="text" readonly size="10" maxlength="10" name="data_v" value="'.$data_vh.'"/>
</td>
<tr bgcolor="#FFFAF0">
<td>Номер вихiдної кор. </td>
<td>
<input type="text" readonly size="10" maxlength="10" name="nvuh" value="'.$n_vuh.'"/>
</td>
<td>Дата: </td>
<td>
<input type="text" size="10" maxlength="10" name="data_vuh" value="'.$datvuh.'"/>
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
}

$pr.='</table>';
echo $pr;   
require('bottom.php');
?>