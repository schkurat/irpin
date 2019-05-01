<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];

include("../function.php");

$kl=$_GET['kl'];
$name=addslashes($_GET['name']);
$kod_kl=$_GET['kod_kl'];
$kod_pl=$_GET['kod_pl'];
$dt_rah=date_bd($_GET['dt_rah']);
$sm_rah=$_GET['sm_rah'];
$dt_opl=date_bd($_GET['dt_opl']);
$sm_opl=$_GET['sm_opl'];
$rah=$_GET['rah'];
$pdv=$_GET['pdv'];
$dt_pod=date_bd($_GET['dt_pod']);
$n_pod=$_GET['n_pod'];
$posl=$_GET['posl'];

$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
 
$ath1=mysql_query("UPDATE podatkova SET NAME='$name',K_KL='$kod_kl',K_PLAT='$kod_pl',USL_B='$posl',
	DT_RAH='$dt_rah',SM_RAH='$sm_rah',DT_OPL='$dt_opl',SM_OPL='$sm_opl',N_RAH='$rah',PR_NDS='$pdv',
	N_NAL='$n_pod',DT_NAL='$dt_pod'	WHERE podatkova.ID='$kl'");
	if(!$ath1){
	echo "Запис не скоригований";} 
//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
$rik=date("Y");
$mis=date("m");		  
header("location: naryadu.php?filter=opl_view&rik=".$rik."&mis=".$mis);
?>