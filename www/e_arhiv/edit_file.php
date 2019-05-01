<?php
/* include "../function.php";
include "../scriptu.php"; */
$idzp=$_GET['id_zp'];
$id_kat=$_GET['id_kat'];
//echo $idzp;
 $sql = "SELECT * FROM fails WHERE ID='$idzp' AND DL='1'";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$fname=$aut["NAME"];
 }
mysql_free_result($atu);
?>
<form action="update_file.php" name="myform" method="get">
<table align="center" class=bordur>
<tr><th colspan="2"><b>Редагування файлу</b></th></tr>
<tr>
<td>Назва файлу</td>
<td>
<input type="text" size="40" name="fname" value="<?php echo $fname; ?>" required/>
<input type="hidden" name="idz" value="<?php echo $idzp; ?>"/>
<input type="hidden" name="id_kat" value="<?php echo $id_kat; ?>"/>
</td>
</tr>
<tr>
<td align="center"><input type="submit" id="submit" value="Зберегти"></td>
<td align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>
