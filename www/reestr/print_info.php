<?php
include "../scriptu.php";
$krit=$_GET['krit'];

if($krit=="reestr"){
?>
<form action="print.php" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Звіт по реєстратору:</th></tr>
<tr>
<td>Період з</td>
<td>
<input name="flag" type="hidden" value="reestr" />
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr><td>
Виконавець</td><td> 
<select name="isp" style="width: 200px;">
<option value=""></option>
<?php
$sql1 = "SELECT ROBS FROM robitnuku WHERE DL='1' AND BRUGADA=5 ORDER BY ROBS";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{echo '<option value="'.$aut1["ROBS"].'">'.$aut1["ROBS"].'</option>';}
mysql_free_result($atu1);
?>
</select>
</td></tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</td>
</tr>
</table>
</form>
<?php
}
if($krit=="vid_rob"){
?>
<form action="print.php" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Звіт по виду робіт:</th></tr>
<tr>
<td>Період з</td>
<td>
<input name="flag" type="hidden" value="vid_rob" />
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr><td>
Вид робіт</td><td>
<select name="vidr">
<option value=""></option>
<?php
$sql1 = "SELECT id_oform,document FROM dlya_oformlennya WHERE id_oform>20 ORDER BY document";
$atu1=mysql_query($sql1);
while($aut1=mysql_fetch_array($atu1))
{echo '<option value="'.$aut1["id_oform"].'">'.$aut1["document"].'</option>';}
mysql_free_result($atu1);
?>
</select>
</td></tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="vukon"){
?>
<form action="print.php" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Звіт виконаних замовленнь за:</th></tr>
<tr>
<td>Період з</td>
<td>
<input name="flag" type="hidden" value="vukon" />
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</form>
</td>
</tr>
</table>
<?php
}
if($krit=="nespl"){
?>
<form action="print.php" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Звіт несплачених замовлень:</th></tr>
<tr>
<td>Період з</td>
<td><input name="flag" type="hidden" value="nespl" />
<input name="date1" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y"); ?>" />
по <input name="date2" type="text" size="10" maxlength="10" value="<?php echo date("d.m.Y"); ?>" />
</td>
</tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" style="width:80px" value="Формувати" /></td>
</form>
</td>
</tr>
</table>
<?php
}
?>