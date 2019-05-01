<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$nvh=$_POST['nvhid']; 
$nvuh=$_POST['nvuh'];
$datav=$_POST['data_v'];
$nkl=$_POST['nkores'];
$dkl=$_POST['datkl'];
$naim=$_POST['kores'];
$boss=$_POST['pib'];
$zmist=$_POST['zauv'];
$tip=$_POST['tup'];


$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

//$chas=date("H:i:s");
   
 $dkl=substr($dkl,6,4)."-".substr($dkl,3,2)."-".substr($dkl,0,2);
 $datav=substr($datav,6,4)."-".substr($datav,3,2)."-".substr($datav,0,2);
  
 $ath=mysql_query("UPDATE kans SET NAIM='$naim',NKL='$nkl',DATAKL=DATE_FORMAT('$dkl','%Y-%m-%d'),
					BOSS='$boss',TIP='$tip',ZMIST='$zmist'
				WHERE DATAV=DATE_FORMAT('$datav','%Y-%m-%d') AND NV='$nvh' AND PR='1'");
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