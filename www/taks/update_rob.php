<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
$vud=$_POST['vid'];
$nvr=$_POST['n_vr'];
$naimvr=$_POST['naim_vr'];
$odv=$_POST['odv'];
$vum=$_POST['vum'];
$vuk=$_POST['vuk'];
$kontr=$_POST['kontr'];
$buro=$_POST['buro'];
$id_pr=$_POST['idpr'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }

$ath=mysql_query("UPDATE price SET VUD='$vud',NOM='$nvr',NAIM='$naimvr',ODV='$odv',VUM='$vum',VUK='$vuk',
				KONTR='$kontr',BURO='$buro' WHERE ID_PRICE='$id_pr'");
	if(!$ath){echo "Змінена робота не внесена до БД";}

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
		  
header("location: taks.php?filter=vsi_rob_view");
?>