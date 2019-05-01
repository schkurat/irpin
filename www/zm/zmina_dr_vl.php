<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
<title>
Комунальне пiдприємстро Кременчуцьке мiжмiське бюро технiчної iнвентаризацiї
</title>
<script type="text/javascript" src="/js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="/js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="/js/autozap.js"></script>
<script type="text/javascript" src="/js/jquery.maskedinput-1.2.2.js"></script>
<link rel="stylesheet" type="text/css" href="/js/autozap.css" />
<link rel="stylesheet" type="text/css" href="/my.css" />
<script type="text/javascript">
$(document).ready(function(){
													$('#idn').bind('blur',net_fokusa);
												}); 
		function net_fokusa(eventObj)
					{
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

<body>

<?php
include "scriptu.php";

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$sz=$_GET['sz'];
$nz=$_GET['nz'];
$kl=$_GET['kl'];
?>

<form action="addvln2.php" name="myform" method="get">
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
<td colspan="3"><input type="text" id="pr" size="20" maxlength="20" name="priz" value=""/></td>
</tr>
<tr>
<td>Ім'я: </td>
<td colspan="3"><input type="text" id="im" size="20" maxlength="20" name="imya" value=""/></td>
</tr>
<tr>
<td>Побатькові: </td>
<td colspan="3"><input type="text" id="pb" size="20" maxlength="20" name="pobat" value=""/></td>
</tr>
<tr>
<td>Дата народження: </td>
<td colspan="3"><input type="text" id="dn" size="10" maxlength="10" name="dnar" value=""/></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" id="submit" value="Додати"></td>
</form>
<!--<form action="pr_docum.php" name="myform1" method="get">-->
<td colspan="2" align="center">
<a href="zamovlennya.php?filter=zm_view">
<input name="cancel" type="button" value="Відміна"></a></td>
</tr>
</table>
<!--</form>-->
</body>
</html>
<?php
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
?>