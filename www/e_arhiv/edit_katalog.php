<?php
/* include "../function.php";
include "../scriptu.php"; */
$idzp=$_GET['id_zp'];
//echo $idzp;
 $sql = "SELECT * FROM earhiv WHERE ID='$idzp' AND DL='1'";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$rozdil=$aut["ID_ROZD"];
	$katalog=$aut["KATALOG"];
 }
mysql_free_result($atu);
?>
<form action="update_katalog.php" name="myform" method="get">
<table align="center" class=bordur>
<tr><th colspan="2"><b>Редагування каталогу</b></th></tr>
<tr>
<td>Оберіть розділ архіву</td>
<td>
<select name="rozdil" required>
<option value=""></option>
<?
$p='';
$sql = "SELECT ID,NAME FROM rozdilu WHERE DL='1' ORDER BY NAME";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
 if($aut["ID"]==$rozdil) $p.='<option selected value="'.$aut["ID"].'">'.$aut["NAME"].'</option>';
 else $p.='<option value="'.$aut["ID"].'">'.$aut["NAME"].'</option>';
 }
mysql_free_result($atu);
$p.='</select>';
echo $p;
?>
</td>
</tr>
<tr>
<td>Назва каталогу для файлів</td>
<td>
<input type="text" size="30" name="katalog" value="<?php echo $katalog; ?>" required/>
<input type="hidden" name="idz" value="<?php echo $idzp; ?>"/>
</td>
</tr>
<tr>
<td align="center"><input type="submit" id="submit" value="Зберегти"></td>
<td align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>
