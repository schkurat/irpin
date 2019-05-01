<?php
include "../function.php";
include "../scriptu.php";
$idzp=$_GET['id_zp'];
//echo $idzp;
 $sql = "SELECT * FROM samovol WHERE ID='$idzp'";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$npp=$aut["NPP"];
	$dt=german_date($aut["DT"]);
	$ns=$aut["NS"];
	$vl=$aut["VL"];
	$bd=$aut["BD"];
	$kva=$aut["KV"];
	$por=htmlspecialchars($aut["POR"],ENT_QUOTES);
	$pri=htmlspecialchars($aut["PR"],ENT_QUOTES);
	$im=htmlspecialchars($aut["IM"],ENT_QUOTES);
	$pb=htmlspecialchars($aut["PB"],ENT_QUOTES);
	$pr=htmlspecialchars($aut["PRIM"],ENT_QUOTES);
	
	$inv=$aut["IN_N"];
 }

mysql_free_result($atu);
for($i=1;$i<=16;$i++){
$sl[$i]='';
}
$sl[$nr]='selected';
?>
<body>
<form action="update_zap.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="4"><b>Редагування запису в книзі</b></th></tr>
<tr>
<input type="hidden" name="id_zps" value="<?php echo $idzp; ?>"/>
<td>Порядковий номер</td>
<td colspan="3"><input type="text" size="8" maxlength="8" name="npp" value="<?php echo $npp; ?>" readonly/></td>
</tr>
<tr>
<td>Населений пункт</td>
<td>
<input type="hidden" id="idns" size="10" name="nss" value="<?php echo $ns; ?>"/>
<div class="border">
<select class="sel_ad" id="nas_p_pd" name="nsp" required>
<option value="">Оберіть населений пункт</option>
<?php
$sql = "SELECT nas_punktu.ID_NSP,nas_punktu.NSP,tup_nsp.TIP_NSP 
		FROM nas_punktu,tup_nsp 
		WHERE nas_punktu.ID_TIP_NSP=tup_nsp.ID_TIP_NSP 
		ORDER BY nas_punktu.ID_NSP";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 if($ns==$aut["ID_NSP"]) echo '<option selected value="'.$aut["ID_NSP"].'">'.$aut["NSP"].' '.$aut["TIP_NSP"].'</option>';
	else echo '<option value="'.$aut["ID_NSP"].'">'.$aut["NSP"].' '.$aut["TIP_NSP"].'</option>';
 }
mysql_free_result($atu);
?>
</select>
</div>
</td>
<td>Вулиця</td>
<td>
<input type="hidden" id="idvl" size="10" name="vll" value="<?php echo $vl; ?>"/>
<div class="border">
<select class="sel_ad" id="vul_pd" name="vyl" disabled="disabled"></select>
</div>
</td>
</tr>
<tr>
<td>Будинок</td>
<td><input type="text" size="20" maxlength="20" name="bud" value="<?php echo $bd; ?>" required/></td>
<td>Квартира</td>
<td><input type="text" size="4" maxlength="4" name="kv" value="<?php echo $kva; ?>"/></td>
</tr>
<tr>
<td>Дата:</td>
<td colspan="3"><input type="text" size="10" maxlength="10" name="dt" value="<?php echo $dt; ?>"/></td>
</tr>
<tr>
<td>Характер <br>порушення</td>
<td colspan="3"><textarea rows="2" cols="60" name="por" required><?php echo $por; ?></textarea></td>
</tr>
<tr>
<td>Прізвище</td>
<td colspan="3"><input type="text" size="30" maxlength="30" name="priz" value="<?php echo $pri; ?>" required/></td>
</tr>
<tr>
<td>Ім'я</td>
<td colspan="3"><input type="text" size="30" maxlength="30" name="imya" value="<?php echo $im; ?>" required/></td>
</tr>
<tr>
<td>Побатькові</td>
<td colspan="3"><input type="text" size="30" maxlength="30" name="pbat" value="<?php echo $pb; ?>" required/></td>
</tr>
<tr>
<td>Інвентарний №</td>
<td colspan="3"><input type="text" size="10" maxlength="10" name="inv" value="<?php echo $inv; ?>" required/></td>
</tr>
<tr>
<td>Відмітка</td>
<td colspan="3"><input type="text" size="60" maxlength="60" name="prum" value="<?php echo $pr; ?>"/></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" id="submit" value="Зберегти"></td>
<td colspan="2" align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>
