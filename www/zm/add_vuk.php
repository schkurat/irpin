<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8'); 
?>
<html>
<head>
<title>
Комунальне пiдприємстро Лубенське мiжмiське бюро технiчної iнвентаризацiї
</title>
<link rel="stylesheet" type="text/css" href="my.css" />
</head>
<?php
$s_zam=$_POST['szam'];
$n_zam=$_POST['nzam'];
$vk=$_POST['vukon'];
$key=$_POST['ky'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$ath1=mysql_query("UPDATE zamovlennya SET VUK='$vk' WHERE SZ='$s_zam' AND NZ='$n_zam'");	
	
	if(!$ath1){
	echo "Замовлення не внесене до БД";} 

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
<body>
<h1><b>Виконавеця присвоєно</b></h1>
<table class=bordur>
<tr>
<td align="center"><a href="set_zm.php"><input type="button" value="Наступне замовлення"></a></td>
<td align="center"><a href="menu.php"><input type="button" value="Вихід"></a></td>
</tr>
</table>

</body>
</html>		  
