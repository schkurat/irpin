<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$tp=$_GET['tip'];
$kl=$_GET['kl'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

if($tp=='katalog'){
$roz=$_GET['id_roz'];
	$ath=mysql_query("UPDATE fails SET DL='0' WHERE fails.ID_ARH='$kl'");
	if(!$ath){echo "Запис не видалений з БД";}
	$ath=mysql_query("UPDATE earhiv SET DL='0' WHERE earhiv.ID='$kl'");
	if(!$ath){echo "Запис не видалений з БД";}

//Zakrutie bazu       
    if(mysql_close($db))
    {
    // echo("Закриття бази даних");
    }
    else
    {
    echo("Не можливо виконати закриття бази"); 
    }
header("location: earhiv.php?filter=arh_view&rejum=seach&rozdil=".$roz);
}
if($tp=='file'){
$id_kat=$_GET['id_kat'];
	$ath=mysql_query("UPDATE fails SET DL='0' WHERE fails.ID='$kl'");
	if(!$ath){echo "Запис не видалений з БД";}

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
}
?>