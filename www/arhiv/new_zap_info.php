<?php
//include "../function.php";
include "../scriptu.php";
?>
<body>
<form action="add_zap.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="2"><b>Реєстрація нової справи</b></th></tr>
<tr>
<td>Інвентареий номер</td>
<td><input type="text" size="20" maxlength="6" name="inv_number" value="000000"/></td>
</tr>
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
</tr>
<tr>
<td>Вулиця</td>
<td>
<div class="border">
<select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled"></select>
</div>
</td>
</tr>
<tr>
<td>Будинок</td>
<td><input type="text" size="20" maxlength="20" name="bud" value=""/></td>
</tr>
<tr>
<td>Квартира</td>
<td><input type="text" size="4" maxlength="4" name="kv" value=""/></td>
</tr>
<tr>
<td>Примітка</td>
<td><input type="text" size="50" maxlength="100" name="prum" value=""/></td>
</tr>
<tr><th colspan="2"><b>Об'єкт</b></th></tr>
<tr>
<td>Назва</td>
<td><input type="text" size="50" name="nameobj" value=""/></td>
</tr>
<tr>
<td>Власники</td>
<td><input type="text" size="50" name="vlasn" value=""/></td>
</tr>
<tr>
<td>Складові частини</td>
<td><input type="text" size="50" name="skl_chast" value=""/></td>
</tr>
<tr>
<td>Кадастровий номер</br>земельної ділянки</td>
<td><input type="text" size="50" name="kad_nom" value=""/></td>
</tr>
<tr><th colspan="2"><b>Площа</b></th></tr>
<tr>
<td>Земельної ділянки</td>
<td><input type="text" name="plzem" value=""/></td>
</tr>
<tr>
<td>Загальна</td>
<td><input type="text" name="plzag" value=""/></td>
</tr>
<tr>
<td>Житлова</td>
<td><input type="text" name="pljit" value=""/></td>
</tr>
<tr>
<td>Допоміжна</td>
<td><input type="text" name="pldop" value=""/></td>
</tr>
<tr><th colspan="2"><b>Первинна інвентаризація</b></th></tr>
<tr>
<td>Дата</td>
<td><input type="text" size="10" maxlength="10" name="dt_perv" value=""/></td>
</tr>
<tr>
<td>Виконавець</td>
<td><input type="text" size="50" name="vk_perv" value=""/></td>
</tr>
<tr><th colspan="2"><b>Прийняття на облік</b></th></tr>
<tr>
<td>Номер</td>
<td><input type="text" name="numb_obl" value=""/></td>
</tr>
<tr>
<td>Дата</td>
<td><input type="text" size="10" maxlength="10" name="dt_obl" value=""/></td>
</tr>
<tr>
<td colspan="2" align="center">
<input type="submit" id="submit" value="Створити" style="margin-right:50px;">
<input name="reset" type="reset" id="reset" value="Очистити">
</td>
</tr>
</table>
</form>