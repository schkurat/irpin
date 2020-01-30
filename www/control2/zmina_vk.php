<?php
include "../scriptu.php";
$kl=$_GET['kl'];
$vk=$_GET['vk'];
$skl=$_GET['skl'];
$zv=$_GET['zv'];
$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,
						nas_punktu.NSP,vulutsi.VUL,tup_nsp.TIP_NSP,zamovlennya.VUD_ROB AS IDROB, 
						tup_vul.TIP_VUL,zamovlennya.BUD,zamovlennya.KVAR,dlya_oformlennya.document,
						zamovlennya.VUK
				FROM zamovlennya, nas_punktu, vulutsi, tup_nsp, tup_vul, dlya_oformlennya
				WHERE
					zamovlennya.KEY=".$kl." AND zamovlennya.DL='1'  
					AND nas_punktu.ID_NSP=zamovlennya.NS
					AND vulutsi.ID_VUL=zamovlennya.VL
					AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
					AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
					AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB"; 			
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
  {	
	$sz=$aut["SZ"];
	$nz=$aut["NZ"];
	if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
	if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
	$adres=$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
	$vud_rob=$aut["document"];
	$pib=$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
	$vuk=$aut["VUK"];
?>
<form action="index.php?filter=zmina_vk_update" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Зміна виконавця</th></tr>
<tr>
<td>Замовлення
<input name="kl" type="hidden" value="<?php echo $kl;?>" />
</td>
<td><input name="zam" type="text" size="10" value="<?php echo $sz.'/'.$nz;?>" readonly/></td>
</tr>
<tr><td>Адреса</td>
<td><input name="adr" type="text" size="90" value="<?php echo $adres;?>" readonly/>
</td></tr>
<tr><td>Вид робіт</td>
<td><input name="v_rob" type="text" size="60" value="<?php echo $vud_rob;?>" readonly/>
</td></tr>
<tr><td>ПІБ (назва)</td>
<td><input name="pib" type="text" size="60" value="<?php echo $pib;?>" readonly/>
</td></tr>
<tr><td>Виконавець</td>
<td><select name="vukon">
<option value=""></option>
<option value=1>Бюро</option>
<?php
if($aut["IDROB"]>=19) {$brug=5; $zagl='disabled';}
else {$brug=1; $zagl='';}
 
 
$sql1 = "SELECT ROBS,ID_ROB,BRUGADA FROM robitnuku WHERE BRUGADA='$brug' AND DL='1' ORDER BY ROBS";
$atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {	if($aut1["ROBS"]!=$vk) $p.='<option value='.$aut1["ID_ROB"].'>'.$aut1["ROBS"].'</option>';
	else
	$p.='<option selected value='.$aut1["ID_ROB"].'>'.$aut1["ROBS"].'</option>';
 }
mysql_free_result($atu1);
$p.='</select>';
echo $p;
?>
</td></tr>
<tr><td>Дзвінок</td>
<td><?php 
if($zv=='1') echo '<input name="zvon" type="checkbox" value="yes" checked>';
else echo '<input name="zvon" type="checkbox" value="yes">';
?>
</td></tr>
<tr><td>Складність</td>
<td><?php 
if($skl=='1') echo '<input name="skl" type="checkbox" value="yes" '.$zagl.' checked>';
else echo '<input name="skl" type="checkbox" value="yes" '.$zagl.'>';
?>
</td></tr>
<tr><td align="center"  colspan="2">
<input name="Ok" type="submit" value="Змінити" />
<a href="index.php?filter=kontrol_view">
<input name="Cancel" type="button" value="Відміна" />
</a>
</td>
</tr>
</table>
</form>
<?php
}
mysql_free_result($atu);
?>