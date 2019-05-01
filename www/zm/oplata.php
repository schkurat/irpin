<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$kl=$_GET['kl'];

include("function.php");

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
 $d_opl=date("Y-m-d");

$ath=mysql_query("UPDATE zamovlennya SET DOKVUT='$d_opl' WHERE KEY='$kl'1 AND DL='1'");
	if(!$ath){
	echo "Замовлення не поновлене до БД";} 

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }	
	
header("location: zamovlennya.php?filter=zm_view");
?>