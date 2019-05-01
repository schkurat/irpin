<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$nvh=$_POST['nvhid']; 
$datav=$_POST['data_vhod'];
$vk1=$_POST['vukon1'];
$vk2=$_POST['vukon2'];
$vk3=$_POST['vukon3'];
$vk4=$_POST['vukon4'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

 $datav=substr($datav,6,4)."-".substr($datav,3,2)."-".substr($datav,0,2);
  
 $ats=mysql_query("DELETE FROM kans_vuk
				WHERE DATAV=DATE_FORMAT('$datav','%Y-%m-%d') AND NV='$nvh'");
if($ats){
if($vk1!=''){
	$ath1=mysql_query("INSERT INTO kans_vuk (DATAV,NV,VK)
				VALUES(DATE_FORMAT('$datav','%Y-%m-%d'),'$nvh','$vk1');");
	if(!$ath1){
	echo "Виконавець1 не внесений до БД";}}

	if($vk2!=''){
	$ath2=mysql_query("INSERT INTO kans_vuk (DATAV,NV,VK)
				VALUES(DATE_FORMAT('$datav','%Y-%m-%d'),'$nvh','$vk2');");
	if(!$ath2){
	echo "Виконавець2 не внесений до БД";}}
	
	if($vk3!=''){
	$ath3=mysql_query("INSERT INTO kans_vuk (DATAV,NV,VK)
				VALUES(DATE_FORMAT('$datav','%Y-%m-%d'),'$nvh','$vk3');");
	if(!$ath3){
	echo "Виконавець3 не внесений до БД";}}
	
	if($vk4!=''){
	$ath4=mysql_query("INSERT INTO kans_vuk (DATAV,NV,VK)
				VALUES(DATE_FORMAT('$datav','%Y-%m-%d'),'$nvh','$vk4');");
	if(!$ath4){
	echo "Виконавець4 не внесений до БД";}}
}
else
{echo "Старі виконавці не вилучені";}				
  
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