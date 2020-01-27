<?php
header('Content-Type: text/html; charset=utf-8'); 
?>
<html>
<head>
<title>
Комунальне пiдприємстро Лубенське мiжмiське бюро технiчної iнвентаризацiї
</title>
<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="js/autozap.js"></script>
<link rel="stylesheet" type="text/css" href="js/autozap.css" />
<link rel="stylesheet" type="text/css" href="my.css" />
</head>
<script type="text/javascript">
$(document).ready(function(){
													$('#nz').bind('blur',net_fokusa);
												}); 
function net_fokusa(eventObj)
					{
						var ser=$("#sz").val(), nom=$("#nz").val();
						$.ajax({
									type: "POST",
									url: "opr_adr.php",
									data: 'sz='+ser+'&nz='+nom,
									dataType: "html",
									success: function(html){
																	var reply=html.split(":",8);
																	$("#adres").val(reply[0] +' '+reply[1]+' '+reply[2]+' '+reply[3]+' '+reply[4]+' '+reply[5]+' '+reply[6]);
															//		$("#key").val(reply[7]);
																	},
									error: function(html){alert(html.error);}
									});								
					} 
</script>
<?php
include "scriptu.php";
?>
<body>
<form action="add_vuk.php" name="myform" method="post">
<h1><b>Розподіл замовлення</b></h1>
<table align="" class=bordur>
<tr>
<td>Серія замовлення</td>
<td><input type="text" id="sz" size="2" maxlength="2" name="szam" value="<?php echo date("y");?>"/></td>
<td>Номер замовлення</td>
<td><input type="text" id="nz" size="7" maxlength="7" name="nzam" value=""/></td>
</tr>
<tr>
<td colspan="4">
<input type="text" id="adres" size="60" maxlength="60" name="adr" value="" style="background-color: silver"/>
</td>
</tr>
<tr>
<td>Оберіть виконавця </td>
<td colspan="3"><input type="text" id="vu" size="15" maxlength="15" name="vukon" value=""/></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" id="submit" value="Створити"></td>
<td colspan="2" align="center"><input name="reset" type="reset" id="reset" value="Очистити"></td>
</tr>
</table>
</form>
</body>
</html>