<?php
session_start();
$lg=$_SESSION["LG"];
$pas=$_SESSION["PAS"];
$nvuh=$_POST["nvuh"];
$datavuh=$_POST["data_vuh"];
$naim=$_POST["kores"];
$zmist=$_POST["zauv"];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

//$chas=date("H:i:s");

 $datavuh=substr($datavuh,6,4)."-".substr($datavuh,3,2)."-".substr($datavuh,0,2);
  
 $ath=mysql_query("UPDATE kans SET NAIM=\"$naim\",ZMIST=\"$zmist\"
				WHERE DATAI=DATE_FORMAT(\"$datavuh\",\"%Y-%m-%d\") AND NI=\"$nvuh\" AND PR=\"2\"");
if(!$ath){
echo "Загальна інформація вхідної документації не змінена";
}
	header("location: vhidna.php");

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
?>