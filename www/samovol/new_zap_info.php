<?php
//include "../function.php";
include "../scriptu.php";
?>
<body>
<form action="add_zap.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4"><b>Новий запис в книзі обліку самочинного будівництва</b></th></tr>
<tr>
<td>Населений пункт</td>
<td>
<div class="border">
<select class="sel_ad" id="nas_punkt" name="nsp" required>
<option value="">Оберіть населений пункт</option>
<?php
$sql = "SELECT nas_punktu.ID_NSP,nas_punktu.NSP,tup_nsp.TIP_NSP 
		FROM nas_punktu,tup_nsp 
		WHERE nas_punktu.ID_TIP_NSP=tup_nsp.ID_TIP_NSP 
		ORDER BY nas_punktu.ID_NSP";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 echo '<option value="'.$aut["ID_NSP"].'">'.$aut["NSP"].' '.$aut["TIP_NSP"].'</option>';
 }
mysql_free_result($atu);
?>
</select>
</div>
</td>
<td>Вулиця</td>
<td>
<div class="border">
<select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled"></select>
</div>
</td>
</tr>
<tr>
<td>Будинок</td>
<td>
<input type="text" size="20" maxlength="20" name="bud" value="" required/>
</td>
<td>Квартира</td>
<td><input type="text" size="4" maxlength="4" name="kv" value=""/></td>
</tr>
<tr>
<td>Дата:</td>
<td colspan="3"><input type="text" size="10" maxlength="10" name="dt" value="<?php echo date("d.m.Y"); ?>"/></td>
</tr>
<tr>
<td>Характер <br>порушення</td>
<td colspan="3"><textarea rows="2" cols="60" name="por" required></textarea></td>
</tr>
<tr>
<td>Прізвище</td>
<td colspan="3"><input type="text" size="30" maxlength="30" name="priz" value="" required/></td>
</tr>
<tr>
<td>Ім'я</td>
<td colspan="3"><input type="text" size="30" maxlength="30" name="imya" value="" required/></td>
</tr>
<tr>
<td>Побатькові</td>
<td colspan="3"><input type="text" size="30" maxlength="30" name="pbat" value="" required/></td>
</tr>
<tr>
<td>Інвентарний №</td>
<td colspan="3"><input type="text" size="10" maxlength="10" name="inv" value="" required/></td>
</tr>
<tr>
<td>Відмітка</td>
<td colspan="3"><input type="text" size="80" maxlength="300" name="prum" value="" required/></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" id="submit" value="Створити"></td>
<td colspan="2" align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>