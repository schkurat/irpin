<form action="akt_peredachi.php" name="myform" method="get">
<table align="center" cellspacing=0 class="bordur">
<tr><th colspan="2" align="center">Акт передачі</th></tr>
<tr>
<td>Дата готовності
<input name="flag" type="hidden" value="zm" />
</td>
<td><input name="dgot" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/></td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" value="Друк" /></td>
</form><form action="index.php?filter=pidpus_view" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" value="Відміна" />
</form>
</td>
</tr>
</table>
