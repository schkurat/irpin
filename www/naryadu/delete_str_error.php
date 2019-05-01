<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
include "../function.php";
$id=$_GET["id"];
$script=$_GET["script"];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
//удаляем из кассы_ерор строку 
$ath=mysql_query("UPDATE kasa_error SET DL='0' WHERE kasa_error.ID='$id'");
if(!$ath){echo "Запис не змінився";} 



header("location: naryadu.php?filter=".$script."");

if(mysql_close($db))
    {
    // echo("Закриття бази даних");
    }
    else
    {
    echo("Не можливо виконати закриття бази"); 
    }
?>