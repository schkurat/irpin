<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$sz=$_GET['sz'];
$nz=$_GET['nz'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
	$ath=mysql_query("UPDATE zamovlennya SET DL='0' WHERE SZ='$sz' AND NZ='$nz' AND VUD_ROB=19");
	if(!$ath){echo "Доплата не видалена з БД";}
	$ath1=mysql_query("UPDATE zamovlennya SET VD='0' WHERE SZ='$sz' AND NZ='$nz' AND VUD_ROB!=19");
	if(!$ath1){echo "Не знята відмітка про видачу";}
	
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
header("location: index.php?filter=vudacha_view");
?>