<?php
include("../function.php");

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
<tr bgcolor="#B5B5B5"><th  align="center" colspan="2">Ручна розноска банка</th></tr>
<tr>
<td>Серія замовлення
</td>
<td style="width:100px"><input name="szam" id="szam" type="text" size="6" maxlength="6" value="<?php echo date("dmy");?>"/></td>
</tr>
<tr>
<td>Номер замовлення</td>
<td style="width:100px"><input name="nzam" id="nzam" type="text" size="6" maxlength="6" required />
</td></tr>
<tr>
<td>Дата оплати</td>
<td style="width:100px"><input class="datepicker" name="dopl" type="text" required />
</td></tr>
<tr><td>Сума</td>
<td><input name="sum" type="text" value=""></td></tr>
<tr><td>Комісія банка</td>
<td><input name="kom" type="text" value="0"></td></tr>

<tr bgcolor="#FFFAF0"><td align="center" colspan="2">
<input name="filter" type="hidden" value="oplata_add">
<input name="Ok" type="submit" value="Внести" />
</form>
<a href="arhiv.php?filter=logo" ><input name="Cancel" type="button" value="Відміна" /></a>
</td>
</tr>
</table>