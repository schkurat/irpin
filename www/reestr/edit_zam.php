<?php
include "../scriptu.php";
$kl=$_GET['id_zp'];

$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,zamovlennya.PS,
						nas_punktu.NSP,vulutsi.VUL,tup_nsp.TIP_NSP,zamovlennya.NREE,zamovlennya.D_STOP,
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
	$nree=$aut["NREE"];
	if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
	if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
	$adres=$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
	$vud_rob=$aut["document"];
	$pib=$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
	$vuk=$aut["VUK"];
	$status=$aut["PS"];
	if($aut["D_STOP"]!='0000-00-00') $status='2';
?>
<form action="reestr.php?filter=update_zam" name="myform" method="post">
<table align="center" cellspacing=0 class="zmview">
<tr><th colspan="4" align="center">Зміна інформації</th></tr>
<tr>
<td>Замовлення
<input name="kl" type="hidden" value="<?php echo $kl;?>" />
</td>
<td><input name="zam" type="text" value="<?php echo $sz.'/'.$nz;?>" readonly/></td>
</tr>
<tr>
<td>Реєстраційний №</td>
<td><input name="nree" type="text" value="<?php echo $nree;?>" readonly/></td>
</tr>
<tr><td>Адреса</td>
<td><input name="adr" type="text" size="60" value="<?php echo $adres;?>" readonly/>
</td></tr>
<tr><td>Вид робіт</td>
<td><input name="v_rob" type="text" size="60" value="<?php echo $vud_rob;?>" readonly/>
</td></tr>
<tr><td>ПІБ (назва)</td>
<td><input name="pib" type="text" size="60" value="<?php echo $pib;?>" readonly/>
</td></tr>
<tr><td>Виконавець</td>
<td><select name="vukon" style="width:120px;">
<option value=""></option>
<?php
$sql1 = "SELECT ROBS FROM robitnuku WHERE DL='1' AND BRUGADA=5 ORDER BY ROBS";
$atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {	if($aut1["ROBS"]!=$vuk) $p.='<option value="'.$aut1["ROBS"].'">'.$aut1["ROBS"].'</option>';
	else
	$p.='<option selected value="'.$aut1["ROBS"].'">'.$aut1["ROBS"].'</option>';
 }
mysql_free_result($atu1);
$p.='</select>';
echo $p;
?>
</td></tr>
<tr><td>Статус</td>
<td><select name="status" style="width:120px;">
<?php
	if($status=='1') 
		$st='<option selected value=1>виконано</option><option value=0>в роботі</option><option value=2>призупинено</option>';
	elseif ($status=='0')
		$st='<option selected value=0>в роботі</option><option value=1>виконано</option><option value=2>призупинено</option>';
	elseif($status=='2')
		$st='<option selected value=2>призупинено</option><option value=0>в роботі</option><option value=1>виконано</option>';
$st.='</select>';
echo $st;
?>
</td></tr>
<tr><td align="center"  colspan="2">
<input name="Ok" type="submit" value="Змінити" />
<a href="kontrol.php?filter=kontrol_view">
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