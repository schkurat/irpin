<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$tp=$_GET['tip'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
if($tp=='zakaz'){	
	$kl=$_GET['kl'];
	$ath=mysql_query(/* "DELETE FROM zamovlennya WHERE SZ='$sz' AND NZ='$nz'" */
"UPDATE zamovlennya SET DL='0' WHERE zamovlennya.KEY='$kl'"	
	);
	if(!$ath){
	echo "Замовлення не видалений з БД";}
	$ath1=mysql_query(/* "DELETE FROM zm_dod WHERE SZ='$sz' AND NZ='$nz'" */
"UPDATE zm_dod SET DL='0' WHERE zm_dod.IDZM='$kl'"	
	);
	if(!$ath1){
	echo "Додаткові власники не видалені з БД";}
	}
if($tp=='dod'){	
	$kl=$_GET['kll'];
	$pr=$_GET['pr'];
	$ath=mysql_query(/* "DELETE FROM zm_dod WHERE SZ='$sz' AND NZ='$nz'" */
"UPDATE zm_dod SET DL='0' WHERE zm_dod.IDZM='$kl' AND PR='$pr'"	
	);
	if(!$ath){
	echo "Додаткові власники не видалені з БД";}
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
		  
header("location: zamovlennya.php?filter=zm_view");

?>