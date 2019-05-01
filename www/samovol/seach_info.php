<?php
include "../function.php";
include "../scriptu.php";
?>

<script type="text/javascript">
$(document).ready(function(){
	$("input[name='rj_saech']").change(radio_click)
}); 
function radio_click(){
	if($("input[name='rj_saech']:checked").val()=="npp") 
	{	$("#id_npp").attr("disabled",false);
		$("#id_bd").attr("disabled","disabled");
		$("#id_kv").attr("disabled","disabled");
		$("#id_prim").attr("disabled","disabled");
		$("#id_por").attr("disabled","disabled");
		$("#id_pr").attr("disabled","disabled");
		$("#id_inv").attr("disabled","disabled");
	}
	if($("input[name='rj_saech']:checked").val()=="adr") 
	{	$("#id_npp").attr("disabled","disabled");
		$("#id_bd").attr("disabled",false);
		$("#id_kv").attr("disabled",false);
		$("#id_prim").attr("disabled","disabled");
		$("#id_por").attr("disabled","disabled");
		$("#id_pr").attr("disabled","disabled");
		$("#id_inv").attr("disabled","disabled");
	}
	if($("input[name='rj_saech']:checked").val()=="hpor") 
	{	$("#id_npp").attr("disabled","disabled");
		$("#id_bd").attr("disabled","disabled");
		$("#id_kv").attr("disabled","disabled");
		$("#id_prim").attr("disabled","disabled");
		$("#id_por").attr("disabled",false);
		$("#id_pr").attr("disabled","disabled");
		$("#id_inv").attr("disabled","disabled");
	}
	if($("input[name='rj_saech']:checked").val()=="priz") 
	{	$("#id_npp").attr("disabled","disabled");
		$("#id_bd").attr("disabled","disabled");
		$("#id_kv").attr("disabled","disabled");
		$("#id_prim").attr("disabled","disabled");
		$("#id_por").attr("disabled","disabled");
		$("#id_pr").attr("disabled",false);
		$("#id_inv").attr("disabled","disabled");
	}
	if($("input[name='rj_saech']:checked").val()=="in_n") 
	{	$("#id_npp").attr("disabled","disabled");
		$("#id_bd").attr("disabled","disabled");
		$("#id_kv").attr("disabled","disabled");
		$("#id_prim").attr("disabled","disabled");
		$("#id_por").attr("disabled","disabled");
		$("#id_pr").attr("disabled","disabled");
		$("#id_inv").attr("disabled",false);
	}
	if($("input[name='rj_saech']:checked").val()=="prim") 
	{	$("#id_npp").attr("disabled","disabled");
		$("#id_bd").attr("disabled","disabled");
		$("#id_kv").attr("disabled","disabled");
		$("#id_prim").attr("disabled",false);
		$("#id_por").attr("disabled","disabled");
		$("#id_pr").attr("disabled","disabled");
		$("#id_inv").attr("disabled","disabled");
	}
}
</script>

<body>
<form action="samovol.php" name="myform" method="get">
<input type="hidden" size="10" name="rejum" value="seach" />
<input type="hidden" size="10" name="filter" value="samovol_view" />
<table align="center" class="zmview">
<tr><th colspan="3"><b>Пошук запису в книзі</b></th></tr>
<tr>
<td><input id="r1" type="radio" name="rj_saech" value="npp"/><label for="r1">Порядковий номер</label></td>
<td colspan="2"><input type="text" id="id_npp" size="8" maxlength="8" name="n_pp" value="" disabled/></td>
</tr>
<tr>
<td rowspan="5"><input id="r2" type="radio" name="rj_saech" value="adr" checked/><label for="r2">Адреса</label></td>
</tr>
<tr>
<td colspan="2">
<div class="border">
<select class="sel_ad" id="nas_punkt" name="nsp">
<option value="">Оберіть населений пункт</option>
<?php
$sql = "SELECT nas_punktu.ID_NSP,nas_punktu.NSP,tup_nsp.TIP_NSP 
		FROM nas_punktu,tup_nsp 
		WHERE nas_punktu.ID_TIP_NSP=tup_nsp.ID_TIP_NSP 
		ORDER BY nas_punktu.ID_NSP";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 echo '<option value="'.$aut["ID_NSP"].'">'.$aut["NSP"].' '.$aut["TIP_NSP"].'</option>';
 }
mysql_free_result($atu);
?>
</select>
</div>
</td>
</tr>
<tr>
<td colspan="2">
<div class="border">
<select class="sel_ad" id="vulutsya" name="vyl" disabled="disabled"></select>
</div>
</td>
</tr>
<tr>
<td>Будинок</td>
<td><input type="text" id="id_bd" size="20" maxlength="20" name="bud" value=""/></td>
</tr>
<tr>
<td>Квартира</td>
<td><input type="text" id="id_kv" size="4" maxlength="4" name="kv" value=""/></td>
</tr>
<tr>
<td><input id="r3" type="radio" name="rj_saech" value="hpor"/><label for="r3">Х-р порушення</label></td>
<td colspan="2"><input type="text" id="id_por" size="40" maxlength="40" name="por" value="" disabled/></td>
</tr>
<tr>
<td><input id="r4" type="radio" name="rj_saech" value="priz"/><label for="r4">Прізвище</label></td>
<td colspan="2"><input type="text" id="id_pr" size="40" maxlength="40" name="pr" value="" disabled/></td>
</tr>
<tr>
<td><input id="r5" type="radio" name="rj_saech" value="in_n"/><label for="r5">Інв. №</label></td>
<td colspan="2"><input type="text" id="id_inv" size="40" maxlength="40" name="inv" value="" disabled/></td>
</tr>
<tr>
<td><input id="r6" type="radio" name="rj_saech" value="prim"/><label for="r6">Відмітка</label></td>
<td colspan="2"><input type="text" id="id_prim" size="40" maxlength="40" name="prum" value="" disabled/></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" id="submit" value="Пошук"></td>
<td align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>