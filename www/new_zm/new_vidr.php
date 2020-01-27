<form action="add_vidr.php" name="myform" method="post">
<table align="center" cellspacing=0 border="1">
<tr bgcolor="#B5B5B5"><th colspan="4" align="center">Внесення нового виду робіт</th></tr>

<tr bgcolor="#FFFAF0">
<td>Тип</td><td>Документ</td><td>Вартість</td>
</tr>
<tr bgcolor="#FFFAF0">
<td>
<select name="tip">
<option value="1">Фіксавана</option>
<option value="2">Від площи</option>
</select>
</td>
<td><input type="text" size="50" maxlength="50" name="v_rob" value=""/></td>
<td><input type="text" size="6" maxlength="6" name="vart" value=""/></td>
</tr>

<tr bgcolor="#FFFAF0"><td align="center">
<input type="submit" name="ok" value="Додати">
</td></form><td>&nbsp</td>
<form action="index.php" name="myform" method="post">
<td align="center">
<input type="submit" name="cans" value="Вiдмiна">
</td>
</form>
</tr></table>