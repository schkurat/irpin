<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("../function.php");

$name=addslashes($_GET['name']);
$namef=addslashes($_GET['namef']);
$adres=addslashes($_GET['adres']);
$telef=$_GET['telef'];
$email=$_GET['email'];
$pdv=$_GET['pdv'];
$edrpou=$_GET['edrpou'];
$svid=$_GET['svid'];
$ipn=$_GET['ipn'];
$bank=addslashes($_GET['bank']);
$mfo=$_GET['mfo'];
$rr=$_GET['rr'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
	
$ath1=mysql_query("INSERT INTO yur_kl(NAME,EDRPOU,SVID,IPN,ADRES,TELEF,NAME_F,RR,BANK,MFO,EMAIL,ED_POD,BTI_OR_ZBER) 
	VALUES('$name','$edrpou','$svid','$ipn','$adres','$telef','$namef','$rr','$bank','$mfo','$email',
	'$pdv','0');");
if(!$ath1){echo "Клієнт не внесений до БД";} 

	
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
header("location: naryadu.php?filter=yur_view");
?>