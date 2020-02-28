<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$kl=$_GET['kl'];
//$inv=$_POST['inv_number'];
//$old_inv=$_POST['old_inv_number'];
$dt_vd=date("Y-m-d");
include "../function.php";

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$sql = "UPDATE `arhiv_dop_adr`  SET VD='1',VD_DATE='$dt_vd' WHERE arhiv_dop_adr.id='$kl'";
//echo $sql;
$ath1=mysql_query($sql); 



//Zakrutie bazu      
 /*
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }*/
		  
header("location: arhiv.php?filter=vudacha_view");

?>