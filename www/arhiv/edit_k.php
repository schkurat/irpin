<?php
include("../function.php");
$kl=$_GET['kl'];
//$tsum=$_GET['tsum'];

$sql = "SELECT arhiv_kasa.* FROM arhiv_kasa WHERE arhiv_kasa.ID='$kl' AND arhiv_kasa.DL='1'";
$atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {	
$sz=$aut["SZ"];
$nz=$aut["NZ"];
$dt=german_date($aut["DT"]);
$sm=$aut["SM"];
$sm_km=$aut["SM_KM"];
}
mysql_free_result($atu);
?>
<script type="text/javascript">
$(document).ready(
  function()
  {
 /*$('#nzam').bind('blur',net_fokusa);*/
 $('#nzam').keyup(net_fokusa);
 function net_fokusa(eventObj){
	$.ajax({
		type: "POST",
		url: "seach_zm.php",
		data: 'nzam='+ $("#nzam").val()+'&szam='+$("#szam").val(),
		dataType: "html",
		success: function(html){
			var reply=html;
		$("#vstavka").empty();
		$("#vstavka").append(reply); 
		},
		error: function(html){alert(html.error);}
	});								
	}
  } 
);
</script>
<form action="arhiv.php" name="myform" method="get">
<table align="center" id="vstavka" class="zmview"></table>
<br>
<table align="center" class="zmview">
<tr bgcolor="#B5B5B5"><th  align="center" colspan="2">Зміна оплати</th></tr>
<tr>
<td>Серія замовлення
</td>
<td style="width:100px"><input name="szam" id="szam" type="text" size="6" maxlength="6" value="<?php echo $sz;?>"/></td>
</tr>
<tr>
<td>Номер замовлення</td>
<td style="width:100px"><input name="nzam" id="nzam" type="text" size="6" maxlength="6" value="<?php echo $nz;?>" required />
</td></tr>
<tr>
<td>Дата оплати</td>
<td style="width:100px"><input name="dopl" type="text" value="<?php echo $dt;?>" required />
</td></tr>
<tr><td>Сума</td>
<td><input name="sum" type="text" value="<?php echo $sm;?>"></td></tr>
<tr><td>Комісія банка</td>
<td><input name="kom" type="text" value="<?php echo $sm_km;?>"></td></tr>

<tr bgcolor="#FFFAF0"><td align="center" colspan="2">
<input name="filter" type="hidden" value="oplata_update">
<input name="kl" type="hidden" value="<?php echo $kl;?>">
<input name="Ok" type="submit" value="Змінити" />
</form>
</td>
</tr>
</table>