<?php
include_once "../function.php";
$idzak=$_GET['idzak']; 
$vukon=$_GET['vukon'];
$bdate=$_GET['bdate'];
$edate=$_GET['edate'];

$sql = "SELECT zamovlennya.SZ,zamovlennya.NZ,zamovlennya.TUP_ZAM,
	zamovlennya.BUD,zamovlennya.KVAR,nas_punktu.NSP,tup_nsp.TIP_NSP,vulutsi.VUL,
	tup_vul.TIP_VUL,zamovlennya.D_PR,zamovlennya.DATA_VUH,zamovlennya.SM_PROEZD,PRIM_PROEZD 
	FROM zamovlennya,nas_punktu,vulutsi,tup_nsp,tup_vul 
	WHERE 
	zamovlennya.KEY='$idzak' 
	AND nas_punktu.ID_NSP=zamovlennya.NS
	AND vulutsi.ID_VUL=zamovlennya.VL
	AND tup_nsp.ID_TIP_NSP=nas_punktu.ID_TIP_NSP
	AND tup_vul.ID_TIP_VUL=vulutsi.ID_TIP_VUL"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
{	
	if($aut["BUD"]!="") $bud="буд.".$aut["BUD"]; else $bud="";
	if($aut["KVAR"]!="") $kvar="кв.".$aut["KVAR"]; else $kvar="";
	$zakaz=$aut["NZ"];
	$sz=$aut["SZ"];
	$d_pr=german_date($aut["D_PR"]);
	$data_vuh=german_date($aut["DATA_VUH"]);
	$adres=$aut["TIP_NSP"].$aut["NSP"]." ".$aut["TIP_VUL"].$aut["VUL"]." ".$bud." ".$kvar;
	$sm_pr=$aut["SM_PROEZD"];
	$prim_pr=$aut["PRIM_PROEZD"];
}	
mysql_free_result($atu);  
?>
<form action="add_edit_proezd.php" name="myform" method="post">
<table align="center" class="zmview">
<tr><th colspan="6" style="font-size: 35px;"><b>Корегування виїзду</b></th></tr>
<tr><td>Дата прийому</td><td><?php echo $d_pr; ?></td>
<td>Дата виходу</td><td><?php echo $data_vuh; ?></td>
<td>Номер замовлення</td><td><?php echo $sz.'/'.$zakaz; ?></td>
</tr>
<tr><td>Адреса</td><td colspan="5"><?php echo $adres; ?></td></tr>
<tr>
<td>Витрачені кошти</td>
<td colspan="5"><input type="text" name="proezd" size="10" value="<?php  echo $sm_pr;?>"/></td>
</tr>
<tr><td>Примітка</td>
<td colspan="5"><input type="text" name="prim" size="60" value="<?php echo $prim_pr; ?>"/>
<input type="hidden" name="idzak" value="<?php echo $idzak; ?>"/>
<input type="hidden" name="bdate" value="<?php echo $bdate; ?>"/>
<input type="hidden" name="edate" value="<?php echo $edate; ?>"/>
<input type="hidden" name="vukon" value="<?php echo $vukon; ?>"/>
</td>
</tr>
<tr>
<td colspan="3" align="center"><input type="submit" id="calc" value="Корегувати"></td>
<td colspan="3" align="center">
<a href="taks.php?filter=taks_view">
<input name="cancel" type="button" value="Відміна"></a>
</td>
</tr>
</table>
</form>