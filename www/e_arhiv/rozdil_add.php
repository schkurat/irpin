<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$rozdil=$_POST['rozdil'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$ath1=mysql_query("INSERT INTO rozdilu (NAME) VALUES('$rozdil');");
	if(!$ath1){
	echo "Запис не внесений до БД";}
else{
if(mysql_close($db))
    {// echo("Закриття бази даних");
	}
    else
    {echo("Не можливо виконати закриття бази");}
header("location: earhiv.php?filter=rozdil_view");
}	     
?>