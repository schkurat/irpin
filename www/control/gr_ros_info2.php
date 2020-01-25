<?php
include "../scriptu.php";
$sz=$_GET['szam'];
$nz=$_GET['nzam'];
$pib="";

$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.PR,zamovlennya.IM,zamovlennya.PB,
			rayonu.RAYON,nas_punktu.NSP,vulutsi.VUL,tup_nsp.TIP_NSP,tup_vul.TIP_VUL,zamovlennya.BUD,
			zamovlennya.KVAR,dlya_oformlennya.document,zamovlennya.KEY
		FROM zamovlennya,rayonu,nas_punktu,vulutsi,tup_nsp,tup_vul,dlya_oformlennya
		WHERE
			zamovlennya.SZ=".$sz." AND zamovlennya.NZ=".$nz." AND zamovlennya.VUK='' AND
			zamovlennya.KODP=".$kodp." AND zamovlennya.DL='1'
			AND rayonu.ID_RAYONA=zamovlennya.RN
			AND nas_punktu.ID_NSP=zamovlennya.NS
			AND vulutsi.ID_VUL=zamovlennya.VL
			AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
			AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL
			AND dlya_oformlennya.id_oform=zamovlennya.VUD_ROB";
//echo $sql;
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
  {
/* 	$sz=$aut["SZ"];
	$nz=$aut["NZ"]; */
	if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
	if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
	$adres=$aut["RAYON"].' '.$aut["TIP_NSP"].' '.$aut["NSP"].' '.$aut["TIP_VUL"].' '.$aut["VUL"].' '.$bud.' '.$kvar;
	$vud_rob=$aut["document"];
	$pib=$aut["PR"].' '.$aut["IM"].' '.$aut["PB"];
	$kl=$aut["KEY"];
}
mysql_free_result($atu);
if($pib!=''){
?>
<form action="index.php" name="myform" method="get">
<table align="center" cellspacing=0 class="zmview">
<tr>
<th>Замовлення</th>
<th align="center">Адреса</th>
<th align="center">Вид робіт</th>
<th align="center">ПІБ(назва)</th>
</tr>
<tr>
<td><?php echo $sz.'*'.$nz; ?></td>
<td><?php echo $adres; ?></td>
<td><?php echo $vud_rob; ?></td>
<td><?php echo $pib; ?></td>
</tr>
<tr>
<th colspan="4" align="center">Оберіть виконавців та долі участі</th>
</tr>
<tr>
<td colspan="4" align="center">Виконавець1
<select name="vukon1">
<option value=""></option>
<?
$p='';
$sql1 = "SELECT ROBS FROM robitnuku where dl='1' AND BRUGADA='$br' order by ROBS";
$atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {	$p.='<option value="'.$aut1["ROBS"].'">'.$aut1["ROBS"].'</option>';}
mysql_free_result($atu1);
$p.='</select>';
echo $p;
?>
Відсоток <input name="pr1" type="text" size="2" maxlength="2"/>
</td>
</tr><tr>
<td colspan="4" align="center">Виконавець2
<select name="vukon2">
<option value=""></option>
<?
$p='';
$sql1 = "SELECT ROBS FROM robitnuku where dl='1' AND BRUGADA='$br' order by ROBS";
$atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {	$p.='<option value="'.$aut1["ROBS"].'">'.$aut1["ROBS"].'</option>';}
mysql_free_result($atu1);
$p.='</select>';
echo $p;
?>
Відсоток <input name="pr2" type="text" size="2" maxlength="2"/>
</td>
</tr>
<tr>
<td colspan="4" align="center">Виконавець3
<select name="vukon3">
<option value=""></option>
<?
$p='';
$sql1 = "SELECT ROBS FROM robitnuku where dl='1' AND BRUGADA='$br' order by ROBS";
$atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {	$p.='<option value="'.$aut1["ROBS"].'">'.$aut1["ROBS"].'</option>';}
mysql_free_result($atu1);
$p.='</select>';
echo $p;
?>
Відсоток <input name="pr3" type="text" size="2" maxlength="2"/>
</td>
</tr>
<tr>
<td colspan="4" align="center">Виконавець4
<select name="vukon4">
<option value=""></option>
<?
$p='';
$sql1 = "SELECT ROBS FROM robitnuku where dl='1' AND BRUGADA='$br' order by ROBS";
$atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {	$p.='<option value="'.$aut1["ROBS"].'">'.$aut1["ROBS"].'</option>';}
mysql_free_result($atu1);
$p.='</select>';
echo $p;
?>
Відсоток <input name="pr4" type="text" size="2" maxlength="2"/>
</td>
</tr>
<tr>
<td colspan="4" align="center">Виконавець5
<select name="vukon5">
<option value=""></option>
<?
$p='';
$sql1 = "SELECT ROBS FROM robitnuku where dl='1' AND BRUGADA='$br' order by ROBS";
$atu1=mysql_query($sql1);
  while($aut1=mysql_fetch_array($atu1))
 {	$p.='<option value="'.$aut1["ROBS"].'">'.$aut1["ROBS"].'</option>';}
mysql_free_result($atu1);
$p.='</select>';
echo $p;
?>
Відсоток <input name="pr5" type="text" size="2" maxlength="2"/>
<input name="filter" type="hidden" value="gr_ros_add"/>
<input name="kl" type="hidden" value="<?php echo $kl; ?>"/>
</td>
</tr>
<tr><td align="center"  colspan="4">
<input name="Ok" type="submit" value="Зберегти" />
<a href="index.php?filter=fon">
<input name="Cancel" type="button" value="Відміна" />
</a>
</td>
</tr>
</table>
<?php
}
else{
echo "Замовлення не знайдено або розподілене!";
}
?>
</form>
