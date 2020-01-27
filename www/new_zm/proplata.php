<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$kl=$_GET['kl'];
$st=$_GET['st'];

//include("function.php");

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
 $d_opl=date("Y-m-d");
if($st=="n"){
$ath=mysql_query("UPDATE zamovlennya SET DOKVUT='$d_opl', VD='1' WHERE zamovlennya.KEY='$kl' AND zamovlennya.DL='1'");
if(!$ath){
	echo "Замовлення не поновлене до БД";} 
}
else
{
$ath=mysql_query("UPDATE zamovlennya SET DOKVUT='0000-00-00' WHERE zamovlennya.KEY='$kl' AND zamovlennya.DL='1'");
	if(!$ath){
	echo "Замовлення не поновлене до БД";} 
}
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }	
	
header("location: index.php?filter=vudacha_view");
?>