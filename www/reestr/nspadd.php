<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$ns=$_POST['nsp2'];
$tip=$_POST['tup2'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
 $sqll = "SELECT NSP FROM nas_punktu WHERE '$ns'=NSP AND ID_TIP_NSP='$tip'"; 
 $atuu=mysql_query($sqll);
  while($autt=mysql_fetch_array($atuu))
 {
	$nsp1=$autt["NSP"];   
 }
 mysql_free_result($atuu);    

if($nsp1==""){
	$ath1=mysql_query("INSERT INTO nas_punktu (NSP,ID_TIP_NSP) VALUES('$ns','$tip');");
	if(!$ath1){echo "Населений пункт не внесений до БД";} 
	echo '1';
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
?>