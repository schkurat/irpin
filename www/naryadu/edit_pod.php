<?php
$kl=$_GET['kl'];
include_once "../function.php";

$sql = "SELECT * FROM podatkova WHERE podatkova.ID='$kl'";
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$dt_rah=german_date($aut["DT_RAH"]);
	$dt_opl=german_date($aut["DT_OPL"]);
	$dt_nal=german_date($aut["DT_NAL"]);
?>
<form action="update_pod.php" name="myform" method="get">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Редагування податкової</th></tr>
<tr>
<td>Код клієнта:</td>
<td><input name="kod_kl" type="text" size="6" value="<? echo $aut["K_KL"]; ?>"/></td>
<td>Код платника:</td>
<td><input name="kod_pl" type="text" size="6" value="<? echo $aut["K_PLAT"]; ?>"/></td>
</tr>
<tr>
<td>Назва:</td>
<td colspan="3"><input name="name" type="text" size="50" value="<? echo htmlspecialchars($aut["NAME"],ENT_QUOTES); ?>"/></td>
</tr>
<tr>
<td>Дата рахунку:</td>
<td><input name="dt_rah" type="text" size="10" value="<? echo $dt_rah;?>"/></td>
<td>Сума рахунку:</td>
<td><input name="sm_rah" type="text" size="15" value="<? echo $aut["SM_RAH"]; ?>"/></td>
</tr>
<tr>
<td>Дата оплати:</td>
<td><input name="dt_opl" type="text" size="10" value="<? echo $dt_opl;?>"/></td>
<td>Сума оплати:</td>
<td><input name="sm_opl" type="text" size="15" value="<? echo $aut["SM_OPL"]; ?>"/></td>
</tr>
<tr>
<td>№ рахунку:</td>
<td><input name="rah" type="text" size="10" value="<? echo $aut["N_RAH"];?>"/></td>
<td>% ПДВ:</td>
<td><input name="pdv" type="text" size="2" value="<? echo $aut["PR_NDS"]; ?>"/></td>
</tr>
<tr>
<td>Дата податкової:</td>
<td><input name="dt_pod" type="text" size="10" value="<? echo $dt_nal;?>"/></td>
<td>№ податкової:</td>
<td><input style="background-color: yellow;" name="n_pod" type="text" size="5" value="<? echo $aut["N_NAL"]; ?>"/></td>
</tr>
<tr>
<td>Послуги:</td>
<td colspan="3"><input name="posl" type="text" size="10" value="<? echo $aut["USL_B"]; ?>"/></td>
<input name="kl" type="hidden" value="<? echo $kl; ?>"/>
</tr>
<tr><td align="center" colspan="2">
<input name="Ok" type="submit" style="width:80px" value="Змінити" /></td>
</form>
<td align="center" colspan="2">
<a href="naryadu.php?filter=fon" ><input name="Cancel" type="button" value="Відміна" /></a>
</td>
</tr>
</table>
<?php
 }
 mysql_free_result($atu);
?>