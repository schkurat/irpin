<script type="text/javascript">
$(document).ready(function(){
	$('#idn').bind('blur',net_fokusa);
}); 
function net_fokusa(eventObj){
	$.ajax({
	type: "POST",
	url: "test_idn.php",
	data: 'kod='+ $("#idn").val(),
	dataType: "html",
	success: function(html){
		var reply=html.split(":",4);
		$("#pr").val(reply[0]);
		$("#im").val(reply[1]);
		$("#pb").val(reply[2]);
		$("#dn").val(reply[3]);
	},
	error: function(html){alert(html.error);}
	});
}
</script>
<?php
$sz=$_GET['sz'];
$nz=$_GET['nz'];
//$kodp=$_GET['kodp'];

$sql = "SELECT zamovlennya.KEY AS KL FROM zamovlennya WHERE SZ='$sz' AND NZ='$nz' AND DL='1'";
$atu=mysql_query($sql);
while($aut=mysql_fetch_array($atu))
{
$kl=$aut["KL"];
}
mysql_free_result($atu);
              
?>

<form action="addvln.php" name="myform" method="get">
<h1><b>Інші власники</b></h1>
<table align="" class=bordur>
<tr>
<td>Серія замовлення</td>
<td><input type="text" size="2" maxlength="2" name="szam" value="<?php echo $sz; ?>"/></td>
<td>Номер замовлення</td>
<td><input type="text" size="7" maxlength="7" name="nzam" value="<?php echo $nz; ?>"/>
<input type="hidden" name="kll" value="<?php echo $kl; ?>"/>
</td>
</tr>
<tr>
<td>ІДН замовника: </td>
<td colspan="3"><input type="text" id="idn" size="12" maxlength="12" name="kod" value=""/></td>
</tr>

<tr>
<td>Прізвище: </td>
<td colspan="3"><input type="text" id="pr" size="20" name="priz" value=""/></td>
</tr>
<tr>
<td>Ім'я: </td>
<td colspan="3"><input type="text" id="im" size="20" name="imya" value=""/></td>
</tr>
<tr>
<td>Побатькові: </td>
<td colspan="3"><input type="text" id="pb" size="20" name="pobat" value=""/></td>
</tr>
<tr>
<td>Дата народження: </td>
<td colspan="3"><input type="text" id="dn" size="10" maxlength="10" name="dnar" value=""/></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" id="submit" value="Додати"></td>
</form>
<td colspan="2" align="center">
<a href="index.php?filter=zm_view">
<input name="cancel" type="button" value="Відміна"></a></td>
</tr>
</table>
