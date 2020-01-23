<?php
include "../scriptu.php";
$krit=$_GET['krit'];
if($krit=="got"){
?>
<form action="print.php" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Пошук замовленнь готовністю на:</th></tr>
<tr>
<td>Період з
<input name="flag" type="hidden" value="got" />
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/></td>
<td>по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</form><form action="kontrol.php?filter=kontrol_view" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" style="width:80px" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="nevk"){
?>
<form action="print.php" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Пошук невиконаних замовленнь:</th></tr>
<tr>
<td>Період з
<input name="flag" type="hidden" value="nevuk" />
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/></td>
<td>по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</form><form action="kontrol.php?filter=kontrol_view" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" style="width:80px" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="nevk_vuk"){
?>
<form action="print.php" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Пошук невиконаних замовлень по виконавцю:</th></tr>
<tr>
<td>Період з
<input name="flag" type="hidden" value="nevuk_vuk" />
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/></td>
<td>по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr><td colspan="2">
Виконавець
<select name="isp">
<option value=""></option>
<?php
$sql1 = "SELECT ROBS,ID_ROB FROM robitnuku WHERE DL='1' ORDER BY ROBS";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{echo '<option value="'.$aut1["ROBS"].'">'.$aut1["ROBS"].'</option>';}
mysql_free_result($atu1);
?>
</select>
</td></tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</form><form action="kontrol.php?filter=kontrol_view" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" style="width:80px" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="pr_per"){
?>
<form action="print.php" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Пошук замовленнь прийнятих за:</th></tr>
<tr>
<td>Період з
<input name="flag" type="hidden" value="pr_period" />
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/></td>
<td>по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</form><form action="kontrol.php?filter=kontrol_view" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" style="width:80px" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="vk_d_got"){
?>
<form action="print.php" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Пошук по виконавцю та даті готовності:</th></tr>
<tr>
<td>Період з
<input name="flag" type="hidden" value="vk_date_g" />
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/></td>
<td>по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr><td colspan="2">
Виконавець
<select name="isp">
<option value=""></option>
<?php
$sql1 = "SELECT ROBS,ID_ROB FROM robitnuku WHERE DL='1' ORDER BY ROBS";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{echo '<option value="'.$aut1["ROBS"].'">'.$aut1["ROBS"].'</option>';}
mysql_free_result($atu1);
?>
</select>
</td></tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</form><form action="kontrol.php?filter=kontrol_view" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" style="width:80px" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="vk_d_vuh"){
?>
<form action="print.php" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Пошук по виконавцю та даті виходу:</th></tr>
<tr>
<td>Період з
<input name="flag" type="hidden" value="vk_date_vh" />
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/></td>
<td>по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr><td colspan="2">
Виконавець <input id="vu" name="ispol" type="text" size="20" maxlength="20" value=""/>
</td></tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</form><form action="kontrol.php?filter=kontrol_view" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" style="width:80px" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="d_vuh"){
?>
<form action="print.php" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Пошук по даті виходу:</th></tr>
<tr>
<td>Період з
<input name="flag" type="hidden" value="date_vh" />
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/></td>
<td>по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</form><form action="kontrol.php?filter=kontrol_view" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" style="width:80px" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="nespl"){
?>
<form action="print_nespl.php" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Відомість несплачених замовлень:</th></tr>
<tr>
<td>Період з
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y"); ?>" /></td>
<td>по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y"); ?>" />
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</form><form action="naryadu.php" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" style="width:80px" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="vuhodu"){
?>
<form action="print_proezd.php" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Відомість проїздів техніками:</th></tr>
<tr>
<td>Період з
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y"); ?>" /></td>
<td>по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y"); ?>" />
</td>
</tr>
<tr><td align="center">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</form><form action="naryadu.php" name="myform" method="post">
<td align="center">
<input name="Cancel" type="submit" style="width:80px" value="Відміна" />
</form>
</td>
</tr>
</table>
<?php
}
?>
