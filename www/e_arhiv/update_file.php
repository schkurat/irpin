<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$idz=$_GET['idz'];
$id_kat=$_GET['id_kat'];
$fname=$_GET['fname'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

 $ath1=mysql_query("UPDATE fails SET NAME='$fname' WHERE fails.ID='$idz'");
	if(!$ath1){
	echo "Запис не скоригований";} 

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
header("location: earhiv.php?filter=file_view&id_kat=".$id_kat);
?>