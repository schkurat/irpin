<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$pib=$_GET['pib'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
if(!@mysql_select_db(kpbti,$db))
{echo("Не завантажена таблиця");
 exit();}

$ath=mysql_query("UPDATE robitnuku SET DL='0' WHERE ROBITNUK='$pib'");
	if(!$ath){
	echo "Таксировка не видалена з БД";}

//Zakrutie bazu       
if(mysql_close($db))
{
// echo("Закриття бази даних");
}
else
{echo("Не можливо виконати закриття бази");}		  
header("location: admin.php?filter=rob_view");
?>