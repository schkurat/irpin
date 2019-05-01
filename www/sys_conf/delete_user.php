<?php
session_start();
$log=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$lg=$_GET['login'];

$db=mysql_connect("localhost",$log,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
$ath1=mysql_query("UPDATE security SET DL='0' WHERE LOG='$lg' AND DL='1'");
	if(!$ath1){echo "Користувач не видалений з БД";}  

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }	  		  
header("location: admin.php");
?>