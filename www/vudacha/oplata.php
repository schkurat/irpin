<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$sz=$_GET['sz'];
$nz=$_GET['nz'];
$kvut=$_GET['kv'];

//include("function.php");

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

if($kvut!="0") {
 $d_opl=date("Y-m-d");

$ath=mysql_query("UPDATE zamovlennya SET DOKVUT='$d_opl', VD='1' 
								WHERE SZ='$sz' AND NZ='$nz' AND DL='1' AND VUD_ROB=19");
	if(!$ath){
	echo "Замовлення не поновлене до БД";} 

$ath1=mysql_query("UPDATE zamovlennya SET VD='1' 
								WHERE SZ='$sz' AND NZ='$nz' AND DL='1' AND VUD_ROB!=19");
	if(!$ath1){
	echo "Замовлення не поновлене до БД1";} 
	
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }	
	
header("location: vudacha.php?filter=vudacha_view");
}
else
echo "Квитанція ще не роздрукована";
?>