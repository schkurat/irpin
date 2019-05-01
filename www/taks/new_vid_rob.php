<form action="add_vid_rob.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Внесення нового виду робіт</th></tr>

<tr>
<td>№  виду</td>
<td><input type="text" size="15" maxlength="15" name="n_vr" value=""/></td>
</tr>
<tr>
<td>Вид</td>
<td>
<select name="vid">
<option value="1">Прийом замовлень</option>
<option value="2">Архівні роботи</option>
<option value="3">Роботи техніка</option>
<option value="4">Роботи бюро</option>
<option value="5">Копії</option>
</select>
</td>
</tr>
<tr>
<td>Найменування роботи</td>
<td><input type="text" size="50" name="naim_vr" value=""/></td>
</tr>
<tr>
<td>Одиниці виміру</td>
<td><input type="text" size="20" name="odv" value=""/></td>
</tr>
<tr>
<td>Норма вимірювача</td>
<td><input type="text" size="12" maxlength="12" name="vum" value=""/></td>
</tr>
<tr>
<td>Норма виконавеця</td>
<td><input type="text" size="12" maxlength="12" name="vuk" value=""/></td>
</tr>
<tr>
<td>Норма контролера</td>
<td><input type="text" size="12" maxlength="12" name="kontr" value=""/></td>
</tr>
<tr>
<td>Норма бюро</td>
<td><input type="text" size="12" maxlength="12" name="buro" value=""/></td>
</tr>
<tr><td align="center" colspan="2">
<input type="submit" name="ok" value="Додати">
</form>
<a href="taks.php">
<input type="submit" name="cans" value="Вiдмiна">
</a>
</td>
</tr></table>