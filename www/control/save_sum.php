<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";

 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit();
   }
$idzak=$_GET['idzak'];
$smk=str_replace(",",".",$_GET['smk']);

$ath1=mysql_query("UPDATE zamovlennya SET SUM_KOR='$smk' WHERE zamovlennya.KEY='$idzak' AND DL='1'");
	if(!$ath1){echo "Відмітка про підпис не внесена до БД";}

//Zakrutie bazu
       if(mysql_close($db))
        {// echo("Закриття бази даних");
		}
         else
         {echo("Не можливо виконати закриття бази"); }

header("location: index.php?filter=pidpus_view&flag=nap");
?>
