<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$idzp=$_GET['id_zp'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

   $ath=mysql_query("UPDATE arhiv SET DL='0' WHERE arhiv.ID='$idzp'");
	if(!$ath){
	echo "Запис не видалений з БД";}

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
header("location: arhiv.php?filter=arh_view&rejum=view");
?>