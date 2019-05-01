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
<!--<script type="text/javascript">
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
</script> -->

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
$kl=$_GET['kll'];
?>

<form action="add_prdoc.php" name="myform" method="post">
<h1><b>Документи, що додаються до замовлення</b></h1>
<table align="" class=bordur>
<tr>
<td>Серія замовлення</td>
<td><input type="text" size="2" maxlength="2" name="szam" value="<?php echo $sz; ?>"/></td>
<td>Номер замовлення</td>
<td><input type="text" size="7" maxlength="7" name="nzam" value="<?php echo $nz; ?>"/>
<input type="hidden" name="kl" value="<?php echo $kl; ?>"/>
</td>
</tr>
<tr>
<td colspan="4">
<?php 
$sql = "SELECT * FROM pravo_doc"; 
 $atu=mysql_query($sql);
  while($aut=mysql_fetch_array($atu))
 {
	$id_doc=$aut["ID_PRDOC"];
	$doc=$aut["PRDOC"];?>   
<input name="<?php echo $id_doc; ?>" type="checkbox" value="<?php echo $doc;?>"><?php echo $doc;?><br> 
<?php }
 mysql_free_result($atu); 

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
<!--<input name="1" type="checkbox" value="Технічний паспорт">Технічний паспорт<br>
<input name="2" type="checkbox" value="Договір куплі-продажу">Договір куплі-продажу<br>
<input name="3" type="checkbox" value="Договір міни">Договір міни<br>
<input name="4" type="checkbox" value="Свідоцтво про право на спадщину">Свідоцтво про право на спадщину<br>
<input name="5" type="checkbox" value="Свідоцтво про право власності">Свідоцтво про право власності<br>
<input name="6" type="checkbox" value="Договір дарування">Договір дарування<br>-->
</td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" id="submit" value="Додати"></td>
<td colspan="2" align="center">

<a href="zamovlennya.php?filter=zm_view">
<input name="cancel" type="button" value="Відміна"></a>

</td>
</tr>
</table>
</form>
</body>
</html>