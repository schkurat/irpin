<form action="add_yur.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Внесення нового юридичного клієнта</th></tr>
<tr>
<td>Скорочена назва:</td>
<td colspan="3"><input name="name" type="text" size="60" value=""/></td>
</tr>
<tr>
<td>Повна назва:</td>
<td colspan="3"><input name="namef" type="text" size="60" value=""/></td>
</tr>
<tr>
<td>Адреса:</td>
<td colspan="3"><input name="adres" type="text" size="60" value=""/></td>
</tr>
<tr>
<td>Телефон:</td>
<td><input name="telef" type="text" size="20" value=""/></td>
<td>E-mail:</td>
<td><input name="email" type="text" size="20" value=""/></td>
</tr>
<tr>
<td>Платник ПДВ:</td>
<td>
<input id="r1" type="radio" name="pdv" value="0" checked/><label for="r1">Так</label>
<input id="r2" type="radio" name="pdv" value="1"/><label for="r2">Ні</label>
</td>
<td>ЄДРПОУ:</td>
<td><input name="edrpou" type="text" size="20" value=""/></td>
</tr>
<tr>
<td>Свідоцтво:</td>
<td><input name="svid" type="text" size="20" value=""/></td>
<td>ІПН:</td>
<td><input name="ipn" type="text" size="20" value=""/></td>
</tr>
<tr>
<td>Банк:</td>
<td colspan="3"><input name="bank" type="text" size="60" value=""/></td>
</tr>
<tr>
<td>МФО:</td>
<td><input name="mfo" type="text" size="20" value=""/></td>
<td>Рахунок:</td>
<td><input name="rr" type="text" size="20" value=""/>
</td>
</tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" style="width:80px" value="Додати" /></td>
</form>
<td align="center" colspan="2">
<a href="naryadu.php?filter=logo" ><input name="Cancel" type="button" value="Відміна" /></a>
</td>
</tr>
</table>
