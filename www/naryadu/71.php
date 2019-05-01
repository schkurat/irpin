<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("../function.php");

$dt_n=date_bd($_GET['dt_n']);
$dt_k=date_bd($_GET['dt_k']);
$dt_71=date("Y-m-d");

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
$ath1=mysql_query("UPDATE zamovlennya SET `71`='1',`DT_71`='$dt_71' 
	WHERE D_PR>='$dt_n' AND D_PR<='$dt_k' AND TUP_ZAM=1 AND DL='1'");
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
		  
header("location: naryadu.php?filter=fon");
?>