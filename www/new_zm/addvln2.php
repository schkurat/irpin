<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
include("../function.php");
$ser=$_GET['szam'];
$nzam=$_GET['nzam'];
//$idn=$_GET['kod'];
if(isset($_GET['kod'])) $idn=$_GET['kod']; else $idn="";
$pr=$_GET['priz'];
$im=$_GET['imya'];
$pb=$_GET['pobat'];
$dn=$_GET['dnar'];
$kl=$_GET['kll'];

if($pr!="" and $im!="" and $pb!="" and $dn!=""){
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$dn=date_bd($dn);
 $ath=mysql_query("INSERT INTO zm_dod (IDZM,IDN,PR,IM,PB,DN) VALUES('$kl','$idn','$pr','$im','$pb','$dn');");
	if(!$ath){
	echo "Інший власник не внесений до БД";} 
	
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
header("location: zmina_dr_vl.php?sz=".$ser."&nz=".$nzam."&kl=".$kl."");  
}
else{
if($pr=="") echo "Не заповнено поле Прізвище<br>";
if($im=="") echo "Не заповнено поле Ім`я<br>";
if($pb=="") echo "Не заповнено поле По батькові<br>";
if($dn=="") echo "Не заповнено поле Дата народження<br>";
}
?>