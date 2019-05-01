<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$kl=$_POST['kl'];
$inv=$_POST['inv_number'];
$old_inv=$_POST['old_inv_number'];
$dt_vd=date("Y-m-d");
include "../function.php";

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
$ath1=mysql_query("UPDATE arhiv_zakaz SET VD='1',DATA_VD='$dt_vd',ARH_NUMB='$inv',OLD_ARH_NUMB='$old_inv' WHERE arhiv_zakaz.KEY='$kl'"); 



//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
header("location: arhiv.php?filter=vudacha_view");

?>