<?php
session_start();
$log=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
include_once "../function.php";

$ng=str_replace(',','.',$_POST['ng']);
$dt_start=date_bd($_POST['dt_start']);

if($ng!="" and $dt_start!=""){

$db=mysql_connect("localhost",$log,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }


$ath1=mysql_query("INSERT INTO ng(ng,dtstart) VALUES ('$ng','$dt_start');");
	if(!$ath1){echo "Користувач не внесений до БД";}  

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
}
else{
echo "Ви не внесли дані!";
}
		  		  
header("location: admin.php?filter=ng_view");
