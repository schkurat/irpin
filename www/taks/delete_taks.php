<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
//$tp=$_GET['tip'];
//$sz=$_GET['sz'];
//$nz=$_GET['nz'];
$idtaks=$_GET['idtaks'];
//$vk=$_GET['vuk'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
//if($tp=='taks'){	
	$ath=mysql_query(/* "DELETE FROM taks WHERE SZ='$sz' AND NZ='$nz'" */
"UPDATE taks SET DL='0' WHERE ID_TAKS='$idtaks'"
	);
	if(!$ath){
	echo "Таксировка не видалена з БД";}
 	$ath1=mysql_query(/* "DELETE FROM taks_detal WHERE SZ='$sz' AND NZ='$nz'" */
"UPDATE taks_detal SET DL='0' WHERE ID_TAKS='$idtaks'"	
	);
	if(!$ath1){
	echo "Розширена таксировка не видалена з БД";} 
//	}
/* if($tp=='dod'){	
	$ath=mysql_query("DELETE FROM zm_dod WHERE SZ='$sz' AND NZ='$nz'");
	if(!$ath){
	echo "Додаткові власники не видалені з БД";}
	} */

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
header("location: taks.php");
?>