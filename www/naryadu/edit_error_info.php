<?php
include "../function.php";
include "../scriptu.php";
$prz=0;
$p='	<table class="zmview" align="center"><tr>
		<th colspan="3">#</th>
		<th>С.з.</th>
		<th>№ зм.</th>
		<th>Дата</th>
		<th>Сума</th>
		<th>Сума ком.</th>
		<th>Примітка</th>
		<th>Район</th>
		</tr>';
$sql="SELECT * FROM kasa_error 
	WHERE DL='1' ORDER BY kasa_error.ID LIMIT 1";
$atu=mysql_query($sql);
	while($aut=mysql_fetch_array($atu))
	{
		$k_kl=$aut["KODP"];
		if($k_kl==1063) $rjn="не виявлений платіж";
		else{
			$rjn="";
			$sql1="SELECT NAS FROM spr_nr WHERE KODP='$k_kl'";
			$atu1=mysql_query($sql1);
			while($aut1=mysql_fetch_array($atu1))
			{
				$rjn=$aut1["NAS"];
			}
			mysql_free_result($atu1);
			if($rjn==""){
			$rjn=$k_kl;
			}
		}
	if($aut["SZU"]!='') $zakaz=$aut["SZU"].'/'.$aut["NZU"];
	else $zakaz=$aut["NZ"];
	$p.='<tr>
		<td><a href="naryadu.php?filter=edit_error_str&id='.$aut["ID"].'&script=edit_error_info"><img src="../images/b_edit.png" border="0"></a></td>
		<td><a href="naryadu.php?filter=delete_error&id='.$aut["ID"].'&script=edit_error_info"><img src="../images/save.gif" border="0"></a></td>
		<td><a href="naryadu.php?filter=delete_str_error&id='.$aut["ID"].'&script=edit_error_info"><img src="../images/b_drop.png" border="0"></a></td>
		<td>'.$aut["SD"].'</td>
		<td>'.$zakaz.'</td>
		<td>'.german_date($aut["DT"]).'</td>
		<td>'.$aut["SM"].'</td>
		<td>'.$aut["SM_KM"].'</td>
		<td>'.$aut["PRIM"].'</td>
		<td>'.$rjn.'</td>
		</tr>';
		$prz=1;
	}
mysql_free_result($atu);
$p.='</table>';
if($prz==1) echo $p;
else echo "Помилок не знайдено!";
?>

<script type="text/javascript">
$(document).ready(function(){
	$("input[name='rj_saech']").change(radio_click)
	}); 
	function radio_click(){
		if($("input[name='rj_saech']:checked").val()=="n_zm") 
		{	$("#id_zam").removeAttr("disabled");
			$("#rayon").attr("disabled","disabled");
			$("#id_bd").attr("disabled","disabled");
			$("#id_kv").attr("disabled","disabled");
			$("#id_kvut").attr("disabled","disabled");
			$("#id_vlas").attr("disabled","disabled");
			$("#id_sm").attr("disabled","disabled");
		}
		if($("input[name='rj_saech']:checked").val()=="adr") 
		{	$("#id_zam").attr("disabled","disabled");
			$("#rayon").removeAttr("disabled");
			$("#id_bd").removeAttr("disabled");
			$("#id_kv").removeAttr("disabled");
			$("#id_kvut").attr("disabled","disabled");
			$("#id_vlas").attr("disabled","disabled");
			$("#id_sm").attr("disabled","disabled");
		}
		if($("input[name='rj_saech']:checked").val()=="kv") 
		{	$("#id_zam").attr("disabled","disabled");
			$("#rayon").attr("disabled","disabled");
			$("#id_bd").attr("disabled","disabled");
			$("#id_kv").attr("disabled","disabled");
			$("#id_kvut").removeAttr("disabled");
			$("#id_vlas").attr("disabled","disabled");
			$("#id_sm").attr("disabled","disabled");
		}
		if($("input[name='rj_saech']:checked").val()=="vls") 
		{	$("#id_zam").attr("disabled","disabled");
			$("#rayon").attr("disabled","disabled");
			$("#id_bd").attr("disabled","disabled");
			$("#id_kv").attr("disabled","disabled");
			$("#id_kvut").attr("disabled","disabled");
			$("#id_sm").attr("disabled","disabled");
			$("#id_vlas").removeAttr("disabled");
		}
		if($("input[name='rj_saech']:checked").val()=="sum") 
		{	$("#id_zam").attr("disabled","disabled");
			$("#rayon").attr("disabled","disabled");
			$("#id_bd").attr("disabled","disabled");
			$("#id_kv").attr("disabled","disabled");
			$("#id_kvut").attr("disabled","disabled");
			$("#id_vlas").attr("disabled","disabled");
			$("#id_sm").removeAttr("disabled");
			}
	}
</script>

<body>
<br>
<table align="center" class="zmview">
<tr><th align="center"><b>Пошук</b></th></tr>
<tr><td align="center">
<form action="naryadu.php" name="myform" method="get">
<table align="center" class=bordur>
<tr>
<td><input id="r1" type="radio" name="rj_saech" value="n_zm"/><label for="r1">Номер замовлення</label></td>
<td colspan="2"><input type="text" id="id_zam" size="8" maxlength="8" name="n_zam" value="" disabled/></td>
</tr>
<tr>
<td><input id="r3" type="radio" name="rj_saech" value="kv"/><label for="r3">Квитанція</label></td>
<td colspan="2"><input type="text" id="id_kvut" size="40" maxlength="40" name="kvut" value="" disabled/></td>
</tr>
<tr>
<td rowspan="5"><input id="r2" type="radio" name="rj_saech" value="adr" checked/><label for="r2">Адреса</label></td>
<td colspan="2">
<div class="border">
<select class="sel_ad" id="rayon" name="rajon">
<option value="0">Оберіть район</option>
<?php
$id_rn=''; $rajn='';
$sql = "SELECT rayonu.ID_RAYONA,rayonu.RAYON FROM rayonu ORDER BY rayonu.ID_RAYONA";
 $atu=mysql_query($sql);
 while($aut=mysql_fetch_array($atu))
 {
 $dl_s=strlen($aut["RAYON"])-10;
 $n_rjn=substr($aut["RAYON"],0,$dl_s);
 echo '<option '.$sl[$aut["ID_RAYONA"]].' value="'.$aut["ID_RAYONA"].'">'.$n_rjn.'</option>';
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
<select class="sel_ad" id="nas_punkt" name="nsp" disabled="disabled"></select>
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
<td><input id="r5" type="radio" name="rj_saech" value="sum"/><label for="r5">Cума</label></td>
<td colspan="2"><input type="text" id="id_sm" size="6" maxlength="6" name="sm" value="" disabled/></td>
</tr>
<tr>
<td><input id="r4" type="radio" name="rj_saech" value="vls"/><label for="r4">Власник</label></td>
<td colspan="2"><input type="text" id="id_vlas" size="40" maxlength="40" name="vlasn" value="" disabled/>
<input type="hidden" name="filter" value="zm_view"/>
</td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" id="submit" value="Пошук"></td>
<td align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>
</td>
</tr></table>