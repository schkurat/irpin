<form action="taks.php" name="myform" method="get">
<table align="center" class="zmview">
<tr><th colspan="4" align="center">Звіт про фактичні виїзди</th></tr>
<tr>
<td>Оберіть період</td>
<td>
з
<input name="bdate" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
по
<input name="edate" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
<input name="filter" type="hidden" value="proezd_view"/>
</td>
</tr>
<tr>
<td>Оберіть виконавця</td>
<td>
<select name="vukon" required>
<option value=""></option>
<?php
$sql = "SELECT ROBS FROM robitnuku WHERE BRUGADA=1 ORDER BY ROBS";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 echo '<option value="'.$aut["ROBS"].'">'.$aut["ROBS"].'</option>';
 }
mysql_free_result($atu);
?>
</select>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" value="Формувати" /></td>
</form><form action="" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>
