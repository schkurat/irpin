<?php
include "../function.php";
include "scriptu.php";
$id=$_GET["id"];
$script=$_GET["script"];
$sql="SELECT * FROM kasa_error WHERE kasa_error.ID='$id'";
	$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu)){
		$dt=german_date($aut["DT"]);
		$sum=$aut["SM"];
		$sum_km=$aut["SM_KM"];
		$sd=$aut["SD"];
		$nz=$aut["NZ"];
		$szu=$aut["SZU"];
		$nzu=$aut["NZU"];
		$kodp=$aut["KODP"];
	}
	mysql_free_result($atu);
	$fiz_zak='';
	$yur_zak='';
	if($szu!=''){
	$fiz_zak='readonly';
	}
	else{
	$yur_zak='readonly';
	}
$sl1="";$sl2="";$sl3="";$sl4="";$sl5="";$sl6="";$sl7="";$sl8="";$sl9="";$sl10="";$sl11="";$sl12="";
switch($kodp) 
{
   case "1063": 
	$sl1="selected";
   break;
   case "1020": 
	$sl2="selected";
   break;
   case "1018": 
	$sl3="selected";
   break;
   case "1019": 
	$sl4="selected";
   break;
   case "1013": 
	$sl5="selected";
	break;
	case "1017": 
	$sl6="selected";
	break;
	case "1011": 
	$sl7="selected";
	break;
	case "1014": 
	$sl8="selected";
	break;
	case "1015": 
	$sl9="selected";
	break;
	case "1021": 
	$sl10="selected";
	break;
	case "1022": 
	$sl11="selected";
	break;
	case "1010": 
	$sl12="selected";
   break;
}
?>
<form action="naryadu.php" name="myform" method="get">
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th  align="center" colspan="2">Редагування запису</th></tr>
<tr><td>Серія</td>
<td><input name="szm" type="text" value="<?php echo $sd; ?>"></td></tr>
<tr><td>№ замовлення фіз.</td>
<td><input name="zamov" type="text" value="<?php echo $nz; ?>" <?php echo $fiz_zak; ?>></td></tr>
<tr><td>Серія юр.</td>
<td><input name="szu" type="text" value="<?php echo $szu; ?>" <?php echo $yur_zak; ?>></td></tr>
<tr><td>№ замовлення юр.</td>
<td><input name="nzu" type="text" value="<?php echo $nzu; ?>" <?php echo $yur_zak; ?>></td></tr>
<tr><td>Сума</td>
<td><input name="sum" type="text" value="<?php echo $sum; ?>"></td></tr>
<tr><td>Сума комісії</td>
<td><input name="sum_km" type="text" value="<?php echo $sum_km; ?>"></td></tr>
<tr><td>Дата</td>
<td><input name="dat" type="text" size="10" maxlength="10" value="<?php echo $dt; ?>"></td></tr>
<tr><td>Район</td>
<td>
<select name="rayon">
<option <?php echo $sl1; ?> value="1063">Не виявлений платіж</option>
<option <?php echo $sl2; ?> value="1020">Ч. Знамянка</option>
<option <?php echo $sl3; ?> value="1018">К. Потоки</option>
<option <?php echo $sl4; ?> value="1019">Потоки</option>
<option <?php echo $sl5; ?> value="1013">Козельщина</option>
<option <?php echo $sl6; ?> value="1017">Н.Галещина</option>
<option <?php echo $sl7; ?> value="1011">Глобине</option>
<option <?php echo $sl8; ?> value="1014">Градизьк</option>
<option <?php echo $sl9; ?> value="1015">Комсомольск</option>
<option <?php echo $sl10; ?> value="1021">Піщане</option>
<option <?php echo $sl11; ?> value="1022">Ялинці</option>
<option <?php echo $sl12; ?> value="1010">Кременчук</option>
</select>
</td></tr>
<tr bgcolor="#FFFAF0"><td align="center" colspan="2">
<input name="filter" type="hidden" value="edit_error_str_save">
<input name="script" type="hidden" value="<?php echo $script; ?>">
<input name="id" type="hidden" value="<?php echo $id; ?>">
<input name="Ok" type="submit" value="Зберегти" />
</form>
<!--<form action="zamovlennya.php?filter=logo" name="myform" method="post">-->
<a href="kasa.php?filter=logo" ><input name="Cancel" type="button" value="Відміна" /></a>
<!--</form>-->
</td>
</tr>
</table>