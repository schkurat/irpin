<?php
include "../function.php";

$kl=$_GET['kl'];

$i=0;

 $sql = "SELECT zamovlennya.SUM,zamovlennya.IDN, zamovlennya.KEY, zamovlennya.DOKVUT,
	zamovlennya.TUP_ZAM,zamovlennya.DODOP,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,
	zamovlennya.D_NAR,zamovlennya.DOR,tup_nsp.TIP_NSP,nas_punktu.NSP,tup_vul.TIP_VUL,vulutsi.VUL,
	zamovlennya.BUD,zamovlennya.KVAR,zamovlennya.DATA_GOT,zamovlennya.VUK,
	zamovlennya.SZ,zamovlennya.NZ,zamovlennya.PS
	FROM zamovlennya,tup_nsp,nas_punktu,tup_vul,vulutsi
				WHERE 
				zamovlennya.KEY='$kl' AND zamovlennya.DL='1' 
				AND nas_punktu.ID_NSP=zamovlennya.NS
				AND vulutsi.ID_VUL=zamovlennya.VL
				AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
				AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL"; 
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$tup_zam=$aut["TUP_ZAM"];

	$ser_z=$aut["SZ"];
	$nom_z=$aut["NZ"];

	$sum=$aut["SUM"];
	$idn=$aut["IDN"];
	$pr=htmlspecialchars($aut["PR"],ENT_QUOTES);
	$im=htmlspecialchars($aut["IM"],ENT_QUOTES);
	$pb=htmlspecialchars($aut["PB"],ENT_QUOTES);
	$d_nar=german_date($aut["D_NAR"]);
	$doruch=$aut["DOR"];
	$tns=$aut["TIP_NSP"];
	$ns=$aut["NSP"];
	$tvl=$aut["TIP_VUL"];
	$vl=$aut["VUL"];
	$bd=$aut["BUD"];
	$kv=$aut["KVAR"];
	$pidpus=$aut["PS"];
	$dat_g=german_date($aut["DATA_GOT"]);
	$vuk=$aut["VUK"];

	$dokvut=$aut["DOKVUT"];
	$dodop=$aut["DODOP"];
	if($dodop=='0000-00-00') {$i=1;}
	} 
mysql_free_result($atu);
if($i==1){ 
if($dokvut=='0000-00-00') $sum=0;
 ?>
<form action="add_doplata_vudacha.php" name="myform" method="post">
<table align="" class="zmview">
<tr><th colspan="4" style="font-size: 35px;"><b>Видача</b></th></tr>
<tr>
<td>Серія замовлення</td>
<td colspan="3"><input type="text" size="4" maxlength="4" name="szam" value="<?php echo $ser_z; ?>" readonly />
Номер замовлення
<input type="text" size="7" maxlength="7" name="nzam" value="<?php echo $nom_z; ?>" readonly /></td>
</tr>
<tr>
<td>ІДН замовника: </td>
<td colspan="3"><input type="text" size="12" maxlength="12" name="kod" value="<?php echo $idn; ?>" readonly /></td>
</tr>
<tr>
<td>Прізвище: </td>
<td colspan="3"><input type="text" size="20" maxlength="20" name="priz" value="<?php echo $pr; ?>" readonly /></td>
</tr>
<tr>
<td>Ім'я: </td>
<td colspan="3"><input type="text" size="20" maxlength="20" name="imya" value="<?php echo $im; ?>" readonly /></td>
</tr>
<tr>
<td>Побатькові: </td>
<td colspan="3"><input type="text" size="20" maxlength="20" name="pobat" value="<?php echo $pb; ?>" readonly /></td>
</tr>
<tr>
<td>Дата народження: </td>
<td colspan="3"><input type="text" size="10" maxlength="10" name="dnar" value="<?php echo $d_nar; ?>" readonly /></td>
</tr>
<tr>
<td>Доручення: </td>
<td colspan="3"><input type="text" size="40" maxlength="40" name="doruch" value="<?php echo $doruch; ?>" readonly /></td>
</tr>
<tr>
<td>Район: </td>
<td colspan="3">
<input type="text" size="30" maxlength="30" name="rajon" value="<?php echo $rn; ?>" readonly />
</td>
</tr>
<tr>
<td>Населений пункт: </td>
<td colspan="3">
<input type="text" size="30" maxlength="30" name="nasp" value="<?php echo $tns.' '.$ns; ?>" readonly />
</td>
</tr>
<tr>
<td>Вулиця: </td>
<td colspan="3">
<input type="text" size="30" maxlength="30" name="vul" value="<?php echo $tvl.' '.$vl; ?>" readonly />
</td>
</tr>
<tr>
<td>Будинок: </td>
<td><input type="text" size="10" maxlength="10" name="bud" value="<?php echo $bd; ?>" readonly /></td>
<td>Квартира: </td>
<td><input type="text" size="3" maxlength="3" name="kvar" value="<?php echo $kv; ?>" readonly /></td>
</tr>
<tr>
<td>Сума аванса</td>
<td><input type="text" size="7" name="avan" value="<?php echo $sum; ?>" readonly /></td>
<?php
$taks=0;
$nds=0;
 $sql = "SELECT taks.SUM,taks.SUM_OKR,taks.NDS FROM taks WHERE taks.IDZM='$kl' AND DL='1'"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
 	$taks=$aut["SUM"]+$aut["SUM_OKR"];
	$nds=$aut["NDS"];
 	} 
mysql_free_result($atu);
if($taks!=0){
$dopl=round(((($nds+100)*$taks)/100)-$sum,2);
$flag='';}
else {$dopl='не такс.';
	$flag='disabled';}
?>
<td>Доплата</td>
<td><input style="background-color: yellow" type="text" size="7" name="dopl" value="<?php echo $dopl; ?>"/></td>
</tr>
<tr>
<td>Дата готовності: </td>
<td><input type="text" size="10" maxlength="10" name="datag" value="<?php echo $dat_g; ?>"/></td>
<td colspan="2">Виконавець: 
<input type="text" size="15" maxlength="15" name="vukon" value="<?php echo $vuk; ?>" />
<input type="hidden" name="kl" value="<?php echo $kl; ?>" />
</td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" id="submit" value="Видати" <?php echo $flag; ?>></td>
</form>
<form action="index.php?filter=vudacha_view" name="reset_form" method="post">
<td colspan="2" align="center"><input name="reset" type="submit" value="Відміна"></td>
</form>
</tr>
</table>

<?php
/* }
else echo "Замовлення ".$ser_z." * ".$nom_z." не підписане"; */

}
else echo "Доплатна сума вже сплачена. </br> Корегування заборонено!";
?>