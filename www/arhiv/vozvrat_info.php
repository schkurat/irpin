<?php
include "../function.php";
include "../scriptu.php";
$idzak=$_GET['kl'];
$inv=explode('.', $_GET['inv']);
$serial = $inv[0];
$numb = $inv[1];
$idArh = 0;
$ns=$_GET['ns'];
$vl=$_GET['vl'];

 $sql = "SELECT * FROM arhiv WHERE SERIAL='$serial' AND NUM='$numb' AND DL='1'";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$idArh=$aut["ID"];
        $nsp=str_pad($aut["N_SPR"], 6, "0", STR_PAD_LEFT);
	$ns=$aut["NS"];
	$vl=$aut["VL"];
	$bd=$aut["BD"];
	$kva=$aut["KV"];
	$pr=$aut["PRIM"];
	$dt_perv=german_date($aut["FIRST_DT_INV"]);
	$vuk_perv=htmlspecialchars($aut["FIRST_VUK"],ENT_QUOTES);
/* 	$dt_pot=german_date($aut["SECOND_DT_INV"]);
	$vuk_pot=$aut["SECOND_VUK"]; */
	$numb_obl=$aut["NUMB_OBL"];
	$dt_obl=german_date($aut["DT_OBL"]);
	$name=$aut["NAME"];
	$vlasn=$aut["VLASN"];
	$skl_chast=$aut["SKL_CHAST"];
	$kad_nom=$aut["KAD_NOM"];
	$pl_zem=$aut["PL_ZEM"];
	$pl_zag=$aut["PL_ZAG"];
	$pl_jit=$aut["PL_JIT"];
	$pl_dop=$aut["PL_DOP"];
 }

mysql_free_result($atu);

 $sql = "SELECT * FROM second_inv WHERE SPR='$nsp' ORDER BY DT_INV DESC LIMIT 1";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$dt_pot=german_date($aut["DT_INV"]);
	$vuk_pot=htmlspecialchars($aut["ISP"],ENT_QUOTES);
 }
mysql_free_result($atu);
?>
<body>
    <form action="vozvrat_EXPIRED.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="4"><b>Редагування запису в архіві</b></th></tr>
<tr>
<input type="hidden" name="id_arh" value="<?php echo $idArh; ?>"/>
<input type="hidden" name="id_zak" value="<?php echo $idzak; ?>"/>
<input type="hidden" name="serial" value="<?php echo $serial; ?>"/>
<input type="hidden" name="numb" value="<?php echo $numb; ?>"/>
<td>Старий номер справи</td>
<td colspan="3"><input type="text" size="8" maxlength="8" name="n_spr" value="<?php echo $nsp; ?>"/></td>
</tr>
<tr>
<td>Населений пункт</td>
<td>
<input type="hidden" id="idns" size="10" name="nss" value="<?php echo $ns; ?>"/>
<div class="border">
<!--<select class="sel_ad" id="nas_p_pd" name="nsp" disabled="disabled"></select>-->
<select class="sel_ad" id="nas_p_pd" name="nsp">
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
</tr>
<tr>
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
<td><input type="text" size="20" maxlength="20" name="bud" value="<?php echo $bd; ?>"/></td>
</tr>
<tr>
<td>Квартира</td>
<td><input type="text" size="4" maxlength="4" name="kv" value="<?php echo $kva; ?>"/></td>
</tr>
<tr>
<td>Примітка</td>
<td><input type="text" size="50" maxlength="60" name="prum" value="<?php echo $pr; ?>"/></td>
</tr>
<tr><th colspan="2"><b>Об'єкт</b></th></tr>
<tr>
<td>Назва</td>
<td><input type="text" size="50" name="nameobj" value="<?php echo $name; ?>"/></td>
</tr>
<tr>
<td>Власники</td>
<td><input type="text" size="50" name="vlasn" value="<?php echo $vlasn; ?>"/></td>
</tr>
<tr>
<td>Складові частини</td>
<td><input type="text" size="50" name="skl_chast" value="<?php echo $skl_chast; ?>"/></td>
</tr>
<tr>
<td>Кадастровий номер</br>земельної ділянки</td>
<td><input type="text" size="50" name="kad_nom" value="<?php echo $kad_nom; ?>"/></td>
</tr>
<tr><th colspan="2"><b>Площа</b></th></tr>
<tr>
<td>Земельної ділянки</td>
<td><input type="text" name="plzem" value="<?php echo $pl_zem; ?>"/></td>
</tr>
<tr>
<td>Загальна</td>
<td><input type="text" name="plzag" value="<?php echo $pl_zag; ?>"/></td>
</tr>
<tr>
<td>Житлова</td>
<td><input type="text" name="pljit" value="<?php echo $pl_jit; ?>"/></td>
</tr>
<tr>
<td>Допоміжна</td>
<td><input type="text" name="pldop" value="<?php echo $pl_dop; ?>"/></td>
</tr>
<tr><th colspan="2"><b>Первинна інвентаризація</b></th></tr>
<tr>
<td>Дата</td>
<td><input type="text" size="10" maxlength="10" name="dt_perv" value="<?php echo $dt_perv; ?>" readonly/></td>
</tr>
<tr>
<td>Виконавець</td>
<td><input type="text" size="50" name="vk_perv" value="<?php echo $vuk_perv; ?>"readonly/></td>
</tr>
<tr><th colspan="2"><b>Прийняття на облік</b></th></tr>
<tr>
<td>Номер</td>
<td><input type="text" name="numb_obl" value="<?php echo $numb_obl; ?>"/></td>
</tr>
<tr>
<td>Дата</td>
<td><input type="text" size="10" maxlength="10" name="dt_obl" value="<?php echo $dt_obl; ?>"/></td>
</tr>
<tr><th colspan="2"><b>Остання інвентаризація</b></th></tr>
<tr>
<td>Дата</td>
<td><input type="text" size="10" maxlength="10" name="dt_pot" value="<?php echo $dt_pot; ?>"/></td>
</tr>
<tr>
<td>Виконавець</td>
<td><input type="text" size="50" name="vk_pot" value="<?php echo $vuk_pot; ?>"/></td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" id="submit" value="Зберегти" style="margin-right:50px;">
<input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>
