<?php
$tp=$_GET['tip'];
$kl=$_GET['kl'];

if($tp=='katalog'){
$sql = "SELECT KATALOG,ID_ROZD FROM earhiv WHERE earhiv.ID='$kl'";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
	{$katalog=$aut["KATALOG"];
	$rozd=$aut["ID_ROZD"];}
mysql_free_result($atu);
$p='<table class="zmview">
<tr bgcolor="#B5B5B5">
<th>Видалення каталогу до корзини</th>
</tr>
<tr bgcolor="#FFFAF0">
<td>Ви дійсно бажаєте видалити каталог: '.$katalog.'
<br>разом із файлами?</td>
</tr>
<tr bgcolor="#FFFAF0"><td align="center">
<a href="delete.php?tip='.$tp.'&kl='.$kl.'&id_roz='.$rozd.'"><input name="cancel" type="button" value="Ок"></a>
<a href="earhiv.php?filter=arh_view&rejum=seach&katalog='.$katalog.'"><input name="cancel" type="button" value="Відміна"></a>
</td>
</tr>';
}
if($tp=='file'){
$sql = "SELECT NAME,ID_ARH FROM fails WHERE fails.ID='$kl'";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
	{$fname=$aut["NAME"];
	$id_kat=$aut["ID_ARH"];}
mysql_free_result($atu);
$p='<table class="zmview">
<tr bgcolor="#B5B5B5">
<th>Видалення файлу до корзини</th>
</tr>
<tr bgcolor="#FFFAF0">
<td>Ви дійсно бажаєте видалити файл: '.$fname.'?</td>
</tr>
<tr bgcolor="#FFFAF0"><td align="center">
<a href="delete.php?tip='.$tp.'&kl='.$kl.'&id_kat='.$id_kat.'"><input name="cancel" type="button" value="Ок"></a>
<a href="earhiv.php?filter=file_view&id_kat='.$id_kat.'"><input name="cancel" type="button" value="Відміна"></a>
</td>
</tr>';
}
$p.='</table>';
echo $p;
?>