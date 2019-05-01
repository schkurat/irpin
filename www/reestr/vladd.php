<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$ns=$_POST['nsp3'];
$vl=$_POST['vul3'];
$tip=$_POST['tup3'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$sqll = "SELECT VUL FROM vulutsi WHERE '$vl'=VUL AND ID_TIP_VUL='$tip' AND ID_NSP='$ns'"; 
 $atuu=mysql_query($sqll);
  while($autt=mysql_fetch_array($atuu))
 {
	$v1=$autt["VUL"];   
 }
 mysql_free_result($atuu);    
 if($v1=="" and $tip!=0 and $ns!=""){
 
 $ath1=mysql_query("INSERT INTO vulutsi (ID_NSP,VUL,ID_TIP_VUL) VALUES('$ns','$vl','$tip');");
	if(!$ath1){
	echo "Вулиця не внесена до БД";} 
	
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