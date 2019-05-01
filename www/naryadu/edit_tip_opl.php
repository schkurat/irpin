<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("../function.php");

$kl=$_GET['kl'];
$rik=$_GET['rik'];
$mis=$_GET['mis'];
$tip=$_GET['tip'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
$ath1=mysql_query("UPDATE podatkova SET TIP_OPL='$tip' WHERE podatkova.ID='$kl'");
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
		  
header("location: naryadu.php?filter=opl_view&rik=".$rik."&mis=".$mis);
?>