<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
include_once "../function.php";
$idzak=$_POST['idzak'];
$proezd=$_POST['proezd'];
$prim=$_POST['prim'];
$vukon=$_POST['vukon'];
$bdate=german_date($_POST['bdate']);
$edate=german_date($_POST['edate']);

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
$ath2=mysql_query("UPDATE zamovlennya SET SM_PROEZD='$proezd',PRIM_PROEZD='$prim' 
	WHERE zamovlennya.KEY='$idzak'");
	if(!$ath2){echo "Інформація не внесена до БД";}  

//Zakrutie bazu       
       if(mysql_close($db))
        {// echo("Закриття бази даних");
		}
         else
         {echo("Не можливо виконати закриття бази"); }
		  
header("location: taks.php?filter=proezd_view&bdate=".$bdate."&edate=".$edate."&vukon=".$vukon);
?>