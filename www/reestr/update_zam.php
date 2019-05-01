<?php
session_start();
$lg=$_SESSION['LG'];
$pas=$_SESSION['PAS'];
header('Content-Type: text/html; charset=utf-8'); 
$db=mysql_connect("localhost",$lg,$pas);
if(!$db) echo "Не вiдбулося зєднання з базою даних";
  
 if(!@mysql_select_db(kpbti,$db))
  {
   echo("Не завантажена таблиця");
   exit(); 
   }
   
$vuk="";
$kl=$_POST['kl'];
$vuk=$_POST['vukon'];
$status=$_POST['status'];
if($status=='1') $dt_s=date("Y-m-d");
elseif($status=='0') $dt_s='0000-00-00';
elseif($status=='2') $dt_stop=date("Y-m-d");

if($status=='2')
	$ath1=mysql_query("UPDATE zamovlennya SET VUK='$vuk',PS='0',DATA_PS='0000-00-00',D_STOP='$dt_stop' WHERE zamovlennya.KEY='$kl'");
else
	$ath1=mysql_query("UPDATE zamovlennya SET VUK='$vuk',PS='$status',DATA_PS='$dt_s',D_STOP='0000-00-00' WHERE zamovlennya.KEY='$kl'");	

//Zakrutie bazu       
       if(mysql_close($db))
        {
        // echo("Закриття бази даних");
         }
         else
         {
          echo("Не можливо виконати закриття бази"); 
          }
if($status=='1')
	header("location: reestr.php?filter=reestr_view&fl=compl");
else 
	header("location: reestr.php?filter=reestr_view&fl=injob");
?>   
