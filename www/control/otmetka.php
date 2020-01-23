<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
$kl=$_GET['i'];

for($i=1; $i<$kl; $i++){
$key_zm=$_GET['z'.$i];

if (isset($_GET[$i])){

$spr=$_GET['spr'.$i];

$dt_ps=date("Y-m-d");

/* if($spr==88){
$ath1=mysql_query("UPDATE zamovlennya SET PS='1',DATA_PS='$dt_ps',VD='1',DATA_VD='$dt_ps' WHERE zamovlennya.KEY='$key_zm' AND DL='1'");
	if(!$ath1){echo "Відмітка про підпис не внесена до БД";}
}
else{ */
$ath1=mysql_query("UPDATE zamovlennya SET PS='1', DATA_PS='$dt_ps' WHERE zamovlennya.KEY='$key_zm' AND DL='1'");
	if(!$ath1){echo "Відмітка про підпис не внесена до БД";}
//}
}
else{
/* $ath2=mysql_query("UPDATE zamovlennya SET PS='0', DATA_PS=0000-00-00 WHERE zamovlennya.KEY='$key_zm' AND DL='1'");
	if(!$ath2){echo "Відмітка про підпис не внесена до БД";} */
}
}

//Zakrutie bazu       
       if(mysql_close($db))
        {// echo("Закриття бази даних");
		}
         else
         {echo("Не можливо виконати закриття бази"); }
		  
header("location: pidpus.php");
?>