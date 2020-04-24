<?php
require('top.php');
include "function.php";
$n_vhid=$_POST['nom_vh'];
$d1=date("Y-m-d",mktime(0,0,0,1,1,date("Y")));

$sql = "SELECT ID,EA,DATAV,NKL,DATAKL,NAIM,BOSS,ZMIST,TIP FROM kans
		WHERE DATAV>='$d1' AND NV='$n_vhid'"; 
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
	$ea_id = $aut["EA"];
	$kl = $aut["ID"];
 }
 mysql_free_result($atu); 

 $sql1 = "SELECT NI FROM kans WHERE DATAI>='$d1' ORDER BY NI DESC LIMIT 1"; 
 $atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {
	$n_vuh=$aut1["NI"]+1; 
 }
 mysql_free_result($atu1); 
if ($n_vuh==''){
$n_vuh=1;
}

$pr='<form action="vidadd.php" name="myform" method="post" enctype="multipart/form-data">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th colspan="5" align="center">Вихiдна документацiя</th></tr>
<tr bgcolor="#FFFAF0">
<td>
Кореспондент
</td>
<td>
<input type="text" size="20" maxlength="20" name="kores" value="'.$naim.'"/>
</td>
</td>
<td colspan="2">
<input type="checkbox" name="konvert" value="1">Конверт
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Номер кореспондента
</td>
<td>
<input type="text" size="20" maxlength="20" name="nkores" value="'.$nom_kl.'"/>
</td>
<td>
Дата: 
</td>
<td colspan="2">
<input type="text" size="10" maxlength="10" name="datkl" value="'.$data_kl.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
П.I.Б. 
</td>
<td>
<input type="text" size="20" maxlength="20" name="pib" value="'.$boss.'"/>
</td>
<td>
Тип: 
</td>
<td>
<input type="text" size="10" maxlength="10" name="tup" value="'.$tip.'"/>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Змiст 
</td>
<td colspan="3">
<textarea rows="3" cols="42" name="zauv">'.$zmist.'</textarea>
</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
Номер вхiдної кор. 
</td>
<td>
<input type="text" readonly size="10" maxlength="10" name="nvhid" value="'.$n_vhid.'"/>
</td>
<td>
Дата: 
</td>
<td>
<input type="text" size="10" maxlength="10" name="data_v" value="'.$data_vh.'"/>
</td>
<tr bgcolor="#FFFAF0">
<td>
Номер вихiдної кор. 
</td>
<td>
<input type="text" readonly size="10" maxlength="10" name="nvuh" value="'.$n_vuh.'"/>
</td>
<td>
Дата: 
</td>
<td>
<input type="text" size="10" maxlength="10" name="data_vuh" value="'.date("d.m.Y").'"/>
</td>
</tr>
<tr>
                <td colspan="2">Файли для електронного архіву</td>
                <td colspan="2">
                    <input type="hidden" name="ea_id" value="'. $ea_id .'">
                    <input type="hidden" name="kl" value="' . $kl . '">
                    <input type="file" name="file[]" size="40" multiple>
                </td>
            </tr>
<tr bgcolor="#FFFAF0">
<td align="center" colspan="4">
<input type="submit" name="ok" style="width:70px;" value="Ок">
</td>
</tr>
</form>';

$pr.='</table>';
echo $pr;   
require('bottom.php');
